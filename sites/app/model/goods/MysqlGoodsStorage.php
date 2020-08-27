<?php

class App_Model_Goods_MysqlGoodsStorage extends Libs_Mvc_Model_BaseModel{

    const GOODS_IN_SALE     = 1;
    const GOODS_OUT_SALE    = 2;
    const GOODS_PRE_SALE    = 3;
    private $sid;
    private $format_table;
    private $match_table;
    private $curr_table;

	public function __construct($sid = null){
		$this->_table 	= 'goods';
		$this->_pk 		= 'g_id';
		$this->_shopId 	= 'g_s_id';
        $this->_df      = 'g_deleted';
		parent::__construct();

        $this->sid      = $sid;
        $this->format_table = DB::table('goods_format');
        $this->match_table  = DB::table('group_match');
        $this->curr_table   = DB::table($this->_table);
	}

    /**
     * 获取店铺商品列表,仅列出已上架商品
     * @param  [type]  $sid            [店铺id]
     * @param  integer $index          [description]
     * @param  integer $count          [description]
     * @param  string  $keyword        [查询关键词]
     * @param  integer $top            [推荐商品]
     * @param  array   $sort           [排序]
     * @param  array   $field          [要查询的字段]
     * @param  integer $kind1          [分类1]
     * @param  integer $kind2          [分类2]
     * @param  integer $type           [商品类型]
     * @param  array   $where          [查询条件]
     * @param  integer $kind3          [分类3]
     * @param  boolean $presell        [预售]
     * @param  boolean $checkCommunity [description]
     * @param  integer $community      [社区id]
     * @param  boolean $customer_query [自定义查询字段]
     * @param  boolean $region_manager [社区团合伙人id]
     * @param  array   $region_where   [社区合伙人额外查询字段]
     * @param  boolean $log            [日志]
     * @param  boolean $tplIndex       [description]
     * @return [type]                  [description]
     */
	public function fetchShopGoodsList(
        $sid, 
        $index = 0, 
        $count = 20, 
        $keyword = '', 
        $top = 0, 
        $sort = array(),
        $field=array(),
        $kind1=0,
        $kind2=0,
        $type=1,
        $where=array(),
        $kind3=0,
        $presell = false,
        $checkCommunity =false,
        $community = 0,
        $customer_query=false,
        $region_manager=false,
        $region_where=[],
        $log = false,
        $tplIndex=false
    ) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        if($presell){
            $where[]    = array('name' => 'g_is_sale', 'oper' => 'in', 'value' => [self::GOODS_IN_SALE,self::GOODS_PRE_SALE]);
        }else{
            $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        }

        if ($keyword) {
            $keyword = $this->utf8_str_to_unicode($keyword);
            $where[]    = array('name' => 'g_name', 'oper' => 'like', 'value' => "%{$keyword}%");
        }
        if ($top) {
            $where[]    = array('name' => 'g_is_top', 'oper' => '=', 'value' => 1);//筛选店长推荐商品
        }
        if($kind1 > 0){
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$kind1);
        }
        if($kind2 > 0){
            $where[] = array('name'=>'g_kind2','oper'=>'=','value'=>$kind2);
        }
        if($kind3 > 0){
            $where[] = array('name'=>'g_kind3','oper'=>'=','value'=>$kind3);
        }
        if($kind3 == -1){
            $where[] = array('name'=>'g_kind3','oper'=>'=','value'=>0);
        }
        if($type){
            if($type == 1){
                $where[] = array('name'=>'g_type','oper'=>'in','value'=>array(1,2));
            }else{
                if(is_array($type)){
                    $where[] = array('name'=>'g_type','oper'=>'in','value'=>$type);
                }else{
                    $where[] = array('name'=>'g_type','oper'=>'=','value'=>$type);
                }
            }

        }

        // 社区团购 区域管理员如果存在的话
        if($region_manager&&!empty($region_where)){
            foreach ($region_where as $value) {
                if($value && isset($value)){
                    $where[]=$value;
                }
            }
        }else{
            if($checkCommunity){
                $where[] =  "((g_add_bed = 1 AND (select count(*) as num from `pre_applet_sequence_goods_community` where asgc_g_id = g_id And asgc_c_id = {$community} ) > 0) or (g_add_bed = 0))";
            }
            // 不存在社区管理员的时候
            // 只有社区团购的传递来的是0 其他的是false
            if($region_manager === 0)
                $where[]=['name'=>'g_region_add_by','oper'=>'=','value'=>0];      
        }
        


        $sort   = empty($sort) ? array('g_update_time' => 'DESC') : $sort;
        // 社区团购商品列表 售罄的排序下沉
        if($customer_query){
            $query_field=[];
            foreach ($field as $key => $value) {
                if(is_numeric($key))
                     $query_field[]="`".$value."`";
                 else
                   $query_field[]=$key." as ".$value."";
            }
            $sql_field = implode(',', $query_field);
            $sql=sprintf('SELECT %s FROM %s',
                $sql_field,
                DB::table($this->_table)
            );
            $where[]=['name'=>$this->_df,'oper'=>'=','value'=>0];
            $sql.=$this->formatWhereSql($where);
            $sql.=$this->getSqlSort($sort);
            $sql.=$this->formatLimitSql($index,$count);
       
            $res=DB::fetch_all($sql);
            if($res===false){
                trigger_error("query mysql failed.", E_USER_ERROR);
                return;
            }
            return $res;
        }else{
            if($tplIndex){
                $query_field=[];
                if(is_array($field) && $field){
                    foreach ($field as $key => $value) {
                        if(is_numeric($key))
                            $query_field[]="`".$value."`";
                        else
                            $query_field[]=$key." as ".$value."";
                    }
                    $sql_field = implode(',', $query_field);
                }else{
                    $sql_field = '*';
                }
                $sql=sprintf('SELECT %s FROM %s',
                    $sql_field,
                    DB::table($this->_table)
                );
                $where[]=['name'=>$this->_df,'oper'=>'=','value'=>0];
                $sql.=' LEFT JOIN pre_enter_shop es ON g_es_id = es.es_id and es.es_deleted != 1 ';
                $sql.=$this->formatWhereSql($where);
                $sql.=$this->getSqlSort($sort);
                $sql.=$this->formatLimitSql($index,$count);
                $res=DB::fetch_all($sql);

                if($res===false){
                    trigger_error("query mysql failed.", E_USER_ERROR);
                    return;
                }
                return $res;
            }
            return $this->getList($where, $index, $count, $sort,$field);

        }
    }

    public function fetchShopGoodsListByDistance($sid, $index = 0, $count = 20, $keyword = '', $top = 0, $sort = array(),$field=array(),$kind1=0,$kind2=0,$type=1,$where=array(),$kind3=0, $lng, $lat) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        $where[]    = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => 'es_deleted','oper'=>'=','value'=>0);
        if ($keyword) {
            $keyword = $this->utf8_str_to_unicode($keyword);
            $where[]    = array('name' => 'g_name', 'oper' => 'like', 'value' => "%{$keyword}%");
        }
        if ($top) {
            $where[]    = array('name' => 'g_is_top', 'oper' => '=', 'value' => 1);//筛选店长推荐商品
        }
        if($kind1 > 0){
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$kind1);
        }
        if($kind2 > 0){
            $where[] = array('name'=>'g_kind2','oper'=>'=','value'=>$kind2);
        }
        if($kind3 > 0){
            $where[] = array('name'=>'g_kind3','oper'=>'=','value'=>$kind3);
        }
        if($kind3 == -1){
            $where[] = array('name'=>'g_kind3','oper'=>'=','value'=>0);
        }
        if($type){
            if($type == 1){
                $where[] = array('name'=>'g_type','oper'=>'in','value'=>array(1,2));
            }else{
                if(is_array($type)){
                    $where[] = array('name'=>'g_type','oper'=>'in','value'=>$type);
                }else{
                    $where[] = array('name'=>'g_type','oper'=>'=','value'=>$type);
                }
            }

        }
        $sort   = empty($sort) ? array('distance' => 'ASC') : $sort;
        $sql = 'SELECT g.*, (2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-es_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(es_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-es_lat)/360),2)))) distance';
        $sql .= " FROM ".DB::table($this->_table)." g ";
        $sql .= ' LEFT JOIN pre_enter_shop es ON g_es_id = es.es_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function fetchMealShopGoodsList($esId,$sid, $index = 0, $count = 20, $keyword = '', $top = 0, $sort = array(),$field=array(),$kind1=0,$kind2=0,$type=1,$where,$kind3=0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        $where[]    = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        if ($keyword) {
            $keyword = $this->utf8_str_to_unicode($keyword);
            $where[]    = array('name' => 'g_name', 'oper' => 'like', 'value' => "%{$keyword}%");
        }
        if ($top) {
            $where[]    = array('name' => 'g_is_top', 'oper' => '=', 'value' => 1);//筛选店长推荐商品
        }
        if($kind1 > 0){
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$kind1);
        }
        if($kind2 > 0){
            $where[] = array('name'=>'g_kind2','oper'=>'=','value'=>$kind2);
        }
        if($kind3 > 0){
            $where[] = array('name'=>'g_kind3','oper'=>'=','value'=>$kind3);
        }
        if($kind3 == -1){
            $where[] = array('name'=>'g_kind3','oper'=>'=','value'=>0);
        }
        if($type){
            if($type == 1){
                $where[] = array('name'=>'g_type','oper'=>'in','value'=>array(1,2));
            }else{
                if(is_array($type)){
                    $where[] = array('name'=>'g_type','oper'=>'in','value'=>$type);
                }else{
                    $where[] = array('name'=>'g_type','oper'=>'=','value'=>$type);
                }
            }

        }
        $sort   = empty($sort) ? array('g_update_time' => 'DESC') : $sort;
        $sql = "SELECT * ";
        $sql .= " FROM ".DB::table($this->_table)." g ";
        $sql .= " LEFT JOIN  pre_applet_meal_goods_shelf amgs on g.g_id = amgs_g_id and amgs_es_id= {$esId} ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取商品数量
     */
    public function fetchShopGoodsCount($sid, $keyword = '', $top = 0, $sort = array(),$field=array(),$kind1=0,$kind2=0,$type=1,$where,$kind3=0){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        if ($keyword) {
            $keyword = $this->utf8_str_to_unicode($keyword);
            $where[]    = array('name' => 'g_name', 'oper' => 'like', 'value' => "%{$keyword}%");
        }
        if ($top) {
            $where[]    = array('name' => 'g_is_top', 'oper' => '=', 'value' => 1);//筛选店长推荐商品
        }
        if($kind1 > 0){
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$kind1);
        }
        if($kind2 > 0){
            $where[] = array('name'=>'g_kind2','oper'=>'=','value'=>$kind2);
        }
        if($kind3 > 0){
            $where[] = array('name'=>'g_kind3','oper'=>'=','value'=>$kind3);
        }
        if($kind3 == -1){
            $where[] = array('name'=>'g_kind3','oper'=>'=','value'=>0);
        }
        if($type){
            if($type == 1){
                $where[] = array('name'=>'g_type','oper'=>'in','value'=>array(1,2));
            }else{
                if(is_array($type)){
                    $where[] = array('name'=>'g_type','oper'=>'in','value'=>$type);
                }else{
                    $where[] = array('name'=>'g_type','oper'=>'=','value'=>$type);
                }
            }

        }
        //$sort   = empty($sort) ? array('g_update_time' => 'DESC') : $sort;
        return $this->getCount($where);
    }

    public function findGoodsBySidGid($sid, $gid) {
        $where[]    = array('name' => 'g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);

        return $this->getRow($where);
    }

    public function findGoodsBySidGidNew($sid, $gid) {
        $where[]    = array('name' => 'g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
//        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);

        return $this->getRow($where);
    }


    /**
     * 获取入驻店铺商品
     */
    public function getShopGoodsCount($where,$type = ''){
        $sql = "select count(*)";
        $sql .= " from `".DB::table($this->_table)."` g ";
        $sql .= " left join `pre_enter_shop` es on g.g_es_id = es.es_id ";
//        if($type == 'city'){
//            $sql .= " left join `pre_applet_city_shop` acs on acs.acs_es_id = es.es_id";
//        }
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 获取多店入驻商品列表
     */
    public function getCommunityShopGoods($where,$index,$count,$sort){
        $where[]   = array('name'=>'g_deleted','oper'=>'=','value'=>0);
        $sql = "select g.*,es.es_name";
        $sql .= " from `".DB::table($this->_table)."` g ";
        $sql .= " left join `pre_enter_shop` es on g.g_es_id = es.es_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取入驻店铺商品
     */
    public function getShopGoodsList($where,$index,$count,$sort,$type = ''){
        $where[] = array('name'=> $this->_df, 'oper' => '=', 'value' => 0);
        if($type == 'city'){
            $sql = "select g.*,es.* ";
        }else{
            $sql = "select * ";
        }

        $sql .= " from `".DB::table($this->_table)."` g ";
        $sql .= " left join `pre_enter_shop` es on g.g_es_id = es.es_id ";
//        if($type == 'city'){
//            $sql .= " left join `pre_applet_city_shop` acs on acs.acs_es_id = es.es_id";
//        }
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        Libs_Log_Logger::outputLog($sql);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



    /*
     * 获取商品列表,数组id形式
     * @todo 限购,上下架等
     */
    public function fetchGoodsBySidGids($sid, $gids, $sort=array()) {
        $arr    = array();
        foreach ($gids as $gid) {
            $gid    = intval($gid);
            if ($gid) {
                array_push($arr, $gid);
            }
        }
        if (empty($arr)) {
            return false;
        }
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => $this->_pk, 'oper' => 'in', 'value' => $arr);
        return $this->getList($where, 0, 0, $sort);
    }

    /*
     * 获取商品列表,数组id形式
     * @todo 限购,上下架等
     */
    public function newFetchGoodsBySidGids($sid, $gids) {
        $arr    = array();
        foreach ($gids as $gid) {
            $gid    = intval($gid);
            if ($gid) {
                array_push($arr, $gid);
            }
        }
        if (empty($arr)) {
            return false;
        }
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => $this->_pk, 'oper' => 'in', 'value' => $arr);

        $list = $this->getList($where, 0, 0);
        $data = array();
        if($list){
            foreach ($list as $value){
                $data[$value['g_id']] = $value;
            }
        }
        return $data;
    }
    /*
     * 获取当前店铺的全部商品数量,仅计算在售商品数量
     */
    public function fetchCountBySid($sid, $keyword = '',$kind1 = 0,$kind2 = 0,$points=0,$screen = '',$where = array()) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        //代表未积分商品
        if($points){
            $where[] = array('name'=>'type','oper'=>'in','value'=>array(4,5));
        }
        if ($keyword) {
            $keyword = $this->utf8_str_to_unicode($keyword);
            $where[] = array('name' => 'g_name', 'oper' => 'like', 'value' => "%{$keyword}%");
        }
        if($kind1){
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$kind1);
        }
        if($kind2){
            $where[] = array('name'=>'g_kind2','oper'=>'=','value'=>$kind2);
        }
        if($screen == 'shop'){
            $where[] = array('name'=>'g_es_id','oper'=>'=','value'=>0);
        }elseif ($screen == 'entershop'){
            $where[] = array('name'=>'g_es_id','oper'=>'>','value'=>0);
        }
        return $this->getCount($where);
    }

    /*
     * 设置商品库存
     * @param int $gfid 商品规格ID
     */
    public function adjustStock($gid, $num, $gfid = 0,$curr_shop = []) {
        //修改商品表中总库存量
        $field  = array('g_stock');
        $inc    = array($num);

        $where[]    = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => 'g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'g_stock_type', 'oper' => '=', 'value' => 1); //设置库存类型是总库存的
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        $goods_stock_exec=DB::query($sql);
        $alert = false;
        $alert_format = false;
        //再次取出
        if($curr_shop['s_goods_alert_open'] == 1){
            $goods = $this->getRowById($gid);
            if($goods['g_stock'] <= $curr_shop['s_goods_alert_value']){
                $alert = true;
            }
        }

        //修改商品规格表中库存量
        if ($gfid) {
            $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
            $goods_format_stock_exec=$format_model->incrementGoodsStock($gfid, $gid, $num);
            //再次取出
            if($curr_shop['s_goods_alert_open'] == 1){
                $format = $format_model->findFormatByGfid($gfid,$gid);
                if($format['gf_stock'] <= $curr_shop['s_goods_alert_value']){
                    $alert_format = true;
                }
            }
        }
        if($alert_format){
            //执行规格库存不足推送
            plum_open_backend('index', 'goodsStockAlert', array('sid' => $this->sid, 'gid' => $gid, 'gfid' => $gfid));
        }elseif($alert && !$alert_format){
            //执行商品库存不足推送
            plum_open_backend('index', 'goodsStockAlert', array('sid' => $this->sid, 'gid' => $gid, 'gfid' => 0));
        }

        // 加入库存减去的记录
        // zhangzc
        // 2019-09-03
        if($gfid){
            if($goods_stock_exec && $goods_format_stock_exec)
                return true;
        }else{
            if($goods_stock_exec)
                return true;
        }
        return false;
    }

    /*
     * 设置商品单日库存
     * @param int $gfid 商品规格ID
     */
    public function adjustDayStock($goods, $num, $gfid = 0) {
        //修改商品表中总库存量

        $where[]    = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => 'g_id', 'oper' => '=', 'value' => $goods['g_id']);
        $where[]    = array('name' => 'g_stock_type', 'oper' => '=', 'value' => 2); //设置库存类型是总库存的
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if($goods['g_day_stock_update_time'] >= strtotime(date('Y-m-d'))){
            $set = array(
                'g_day_stock' => $goods['g_day_stock'] + $num,
                'g_day_stock_update_time' => time()
            );
        }else{
            $set = array(
                'g_day_stock' => $goods['g_stock'] + $num,
                'g_day_stock_update_time' => time()
            );
        }
        $this->updateValue($set, $where);
        //修改商品规格表中库存量
        if ($gfid) {
            $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
            $format = $format_model->getRowById($gfid);
            if($format['gf_day_stock_update_time'] >= strtotime(date('Y-m-d'))){
                $set = array(
                    'gf_day_stock' => $format['gf_day_stock'] + $num,
                    'gf_day_stock_update_time' => time()
                );
            }else{
                $set = array(
                    'gf_day_stock' => $format['gf_stock'] + $num,
                    'gf_day_stock_update_time' => time()
                );
            }
            $format_model->updateById($set, $gfid);
        }
    }

    public function changeDeduct($gid,$is_deduct){
        $where      = array();
        $where[]    = array('name' => 'g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $set = array(
            'g_is_deduct' => $is_deduct ? 1 : 0
        );
        return $this->updateValue($set,$where);
    }

    /*
     * 通过微店商品ID查找数据
     */
    public function findGoodsByWdid($wdid) {
        $where[]    = array('name' => 'g_wd_itemid', 'oper' => '=', 'value' => $wdid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        return $this->getRow($where);
    }
    /*
     * 通过有赞商品ID查找数据
     */
    public function findGoodsByYzid($yzid) {
        $where[]    = array('name' => 'g_yz_itemid', 'oper' => '=', 'value' => $yzid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        return $this->getRow($where);
    }
    /**
     * @param $gid
     * @return bool
     * 根据商品ID更新商品规格,和库存（废弃）
     */
    public function updateGoodsFormatNum($gid,$stock){
        if($gid > 0){
            $sql = 'UPDATE '.DB::table($this->_table);
            $sql .= ' SET g_stock = '.intval($stock).', `g_has_format` = ( ';
            $sql .= ' SELECT COUNT(*) FROM `'.$this->format_table.'` WHERE gf_s_id='.$this->sid.'  and gf_g_id= '.intval($gid);
            $sql .= ' ) WHERE g_s_id = '.$this->sid.' and `g_id` = '.intval($gid);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
            return $ret;
        }
        return false;

    }

    /**
     * @param $type
     * @param $gpId
     * @param $index
     * @param $count
     * @hide 是否隐藏后台设置前台不显示的商品
     * @return array|bool
     * 获取分组商品和未分组商品
     * type look查看 add追加分组
     */
    public function getGroupGoods($type,$gpid,$index,$count,$keyword='',$isShop=0,$hide=0,$independent = 0,$region_manager = [],$diff_goods = [],$checkCommunity = 0,$community = 0,$presell = 0,$isSequenceList = 0){

        if($type == 'look'){
            $where = ' and gm_gg_id = '.intval($gpid);
            if($isSequenceList){
                $sort  = array('stockby'=>'DESC','gm_weight' => 'DESC','gm_create_time' => 'DESC');
            }else{
                $sort  = array('gm_weight' => 'DESC','gm_create_time' => 'DESC');
            }

        }else{
            //$where = ' and gm_gg_id is null ';//' and (gm_gg_id is null or gm_gg_id != '.intval($gpid).')';
            $where = ' and (gm_gg_id is null or gm_gg_id != '.intval($gpid).')';
            $sort  = array('g_create_time' => 'DESC');
        }
        if($isShop){
            $where .= ' and g_es_id != 0 ';
            $where .= ' and es_status = 0 ';
            $where .= ' and es_deleted = 0 ';
        }else{
            $where .= ' and g_es_id = 0 ';
        }
        if($hide){
            $where .= ' and g_applay_goods_show = 1 ';
        }

        // 社区团购 区域管理员如果存在的话
        if($region_manager&&!empty($diff_goods)){
            $diff_goods_str = implode(',',$diff_goods);
            $where .= " and (g_region_add_by = {$region_manager['m_id']} or g_region_add_by = 0) ";
            $where .= ' and g_id not in ('.$diff_goods_str.') ';
        }else{
            if($checkCommunity){
                $where .=  " and ((g_add_bed = 1 AND (select count(*) as num from `pre_applet_sequence_goods_community` where asgc_g_id = g_id And asgc_c_id = {$community} ) > 0) or (g_add_bed = 0)) ";
            }
            // 不存在社区管理员的时候
            $where .= ' and g_region_add_by = 0 ';
        }

        $where .= " and g_independent_mall = {$independent} ";
        $where .= ' and g_type in (1,2) ';
        $where .= $hide ? ' and g_applay_goods_show = 1  ' : '';
        if($isSequenceList){
            $sql = 'SELECT g_id, g_es_id, g_name,g_cover , g_price , g_ori_price, g_brief, g_stock, g_stock_show,g_sold,g_unified_fee,gm_id,gm_weight,g_list_label,g_is_discuss,g_show_num,g_limit,g_show_vip,g_fake_buynum,g_had_vip_price,g_join_discount,g_ori_price,g_kind1,g_kind2,g_format_type,g_hotel_stock,g_has_window,g_date_price,(case g_stock WHEN 0 THEN 0 else 1 end) as stockby ';
        }else{
            $sql = 'SELECT g_id, g_es_id, g_name,g_cover , g_price , g_ori_price, g_brief, g_stock, g_stock_show,g_sold,g_unified_fee,gm_id,gm_weight,g_is_discuss,g_list_label ';
        }

        $sql .= ' FROM `'.DB::table($this->_table).'` go ';
        $sql .= ' LEFT JOIN '.$this->match_table.' gm on gm_g_id = go.g_id ';
        $sql .= ' LEFT JOIN pre_enter_shop es ON g_es_id = es.es_id ';

        if($presell){
            $sql .= ' where g_deleted = 0 and g_is_sale in (1,3) and  g_s_id =  '.$this->sid . $where;
        }else{
            $sql .= ' where g_deleted = 0 and g_is_sale = '.self::GOODS_IN_SALE.' and  g_s_id =  '.$this->sid . $where;
        }

        if($keyword){
            $sql .= ' and  g_name like '.DB::quote("%{$keyword}%");
        }
        $sql .= ' GROUP BY g_id ';

        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getGroupGoodsByDistance($type,$gpid,$index,$count,$keyword='',$isShop=0,$hide=0,$independent = 0, $lng, $lat){
        $where = '';
        if($type == 'look'){
            $where = ' and gm_gg_id = '.intval($gpid);
            $sort  = array('distance' => 'ASC', 'gm_weight' => 'DESC','gm_create_time' => 'DESC');
        }else{
            //$where = ' and gm_gg_id is null ';//' and (gm_gg_id is null or gm_gg_id != '.intval($gpid).')';
            $where = ' and (gm_gg_id is null or gm_gg_id != '.intval($gpid).')';
            $sort  = array('g_create_time' => 'DESC');
        }
        if($isShop){
            $where .= ' and g_es_id != 0 ';
            $where .= ' and es_status = 0 ';
            $where .= ' and es_deleted = 0 ';
        }else{
            $where .= ' and g_es_id = 0 ';
        }

        $where .= " and g_independent_mall = {$independent} ";
        $where .= ' and g_type in (1,2) ';
        $where .= $hide ? ' and g_applay_goods_show = 1  ' : '';
        $sql = 'SELECT g_id, g_es_id, g_name,g_cover , g_price , g_ori_price, g_brief, g_stock, g_stock_show,g_sold,g_unified_fee,g_is_discuss,gm_id,gm_weight,g_list_label,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-es_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(es_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-es_lat)/360),2)))) distance ';
        $sql .= ' FROM `'.DB::table($this->_table).'` go ';
        $sql .= ' LEFT JOIN '.$this->match_table.' gm on gm_g_id = go.g_id ';
        $sql .= ' LEFT JOIN pre_enter_shop es ON g_es_id = es.es_id ';
        $sql .= ' where g_deleted = 0 and g_is_sale = '.self::GOODS_IN_SALE.' and  g_s_id =  '.$this->sid . $where;
        if($keyword){
            $sql .= ' and  g_name like '.DB::quote("%{$keyword}%");
        }
        $sql .= ' GROUP BY g_id ';

        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $type
     * @param $gpId
     * @return bool
     * 获得商品总数，用于分页
     */
    public function getCountGoods($type,$gpid,$keyword='',$isShop=0){
        $where = '';
        if($type == 'look'){
            $where = ' and gm_gg_id = '.intval($gpid);
        }else{
            //$where = ' and gm_gg_id is null ';
            $where = ' and (gm_gg_id is null or gm_gg_id != '.intval($gpid).')';
        }

        if($isShop){
            $where .= ' and g_es_id != 0 ';
            $where .= ' and es_status = 0 ';
        }else{
            $where .= ' and g_es_id = 0 ';
        }

        $where .= ' and g_type in (1,2) ';

        $sql  = ' SELECT count(*) FROM';
        $sql .= ' ( SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` go ';
        $sql .= ' LEFT JOIN '.$this->match_table.' gm ON gm_g_id = go.g_id ';
        $sql .= ' LEFT JOIN pre_enter_shop es ON g_es_id = es.es_id ';
        $sql .= ' WHERE g_deleted = 0 and g_is_sale = '.self::GOODS_IN_SALE.' and  g_s_id =  '.$this->sid . $where;
        if($keyword){
            $sql .= ' and  g_name like '.DB::quote("%{$keyword}%");
        }
        $sql .= ' GROUP BY g_id ';
        $sql .= ') temp';

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 增减商品销量
     */
    public function incrementGoodsSold($gid, $sold) {
        $field  = array('g_sold');
        $inc    = array($sold);

        $where[]    = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => 'g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 增减商品库存
     */
    public function incrementGoodsStock($gid, $stock) {
        $field  = array('g_stock');
        $inc    = array($stock);

        $where[]    = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => 'g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);

        return DB::query($sql);
    }

    /*
     * 增减商品浏览量
     */
    public function incrementGoodsShow($gid, $sold, $realSold = 1) {

        $field  = array('g_show_num','g_show_real_num');
        $inc    = array($sold,$realSold);

        $where[]    = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => 'g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /**
     * @param $gids
     * @param $type
     * @param $index
     * @param $count
     * @param array $field
     * @return array|bool
     * @type 的值是“in”  "not in" "="
     */
    public function getListByGid($gids,$type,$index,$count,$field=array('g_id','g_name','g_cover','g_price')){
        $where      = array();
        $where[]    = array('name' => 'g_id', 'oper' => $type, 'value' => $gids);
        $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        $sort       = array('g_update_time' => 'DESC');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }

    /**
     * @param $id
     *  删除某个商品产生的影响
     */
    public function deleteEffectById($id){

    }
    /**
     * 批量插入商品(复制公共商品)
     */
    public function doInsertGoods($value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`g_id`, `g_s_id`, `g_name`, `g_price`, `g_has_format`,`g_ori_price`,`g_type`,`g_cover`, `g_brief`, `g_detail`, `g_is_back`, `g_is_quality`, `g_is_truth`, `g_create_time`) ';
            $sql .= ' VALUES '.implode(',',$value);

            $ret  = DB::query($sql);
            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
            return $ret;
        }
        return false;
    }
    /*
     * @param int $fxid 分销店铺ID
     * @param int $curr 当前所选商品ID
     * 获取选品上架商品
     */
    public function getDeductGoodsList($index = 0, $count = 20, $gids = array(), $curr = 0) {
        $curr   = intval($curr);
        $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);//未删除商品
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);//在售商品
        $where[]    = array('name' => 'g_is_deduct', 'oper' => '=', 'value' => 1);//开启分销的商品

        if (in_array($curr, $gids)) {
            $curr   = 0;
        }
        if ($curr) {
            array_push($gids, $curr);
            $first  = $this->getRowById($curr);
        }
        if (!empty($gids)) {
            $where[]    = array('name' => 'g_id', 'oper' => 'not in', 'value' => $gids);
        }

        $sort   = array('g_update_time' => 'DESC');

        $list   = $this->getList($where, $index, $count, $sort);

        if (isset($first)) {
            array_unshift($list, $first);
        }
        return $list;
    }
    /*
     * 获取选品上架商品总量
     */
    public function getDeductGoodsCount($gids = array()) {
        $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);//未删除商品
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);//在售商品
        $where[]    = array('name' => 'g_is_deduct', 'oper' => '=', 'value' => 1);//开启分销的商品

        if (!empty($gids)) {
            $where[]    = array('name' => 'g_id', 'oper' => 'not in', 'value' => $gids);
        }

        return $this->getCount($where);
    }

    /*
     * 增减商品分销数量
     */
    public function incrementGoodsBranch($gid, $num) {
        $field  = array('g_has_branch');
        $inc    = array($num);

        $where[]    = array('name' => 'g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
    * 获取店铺所有商品的类型（订餐小程序使用）
    */
    public function fetchShopGoodsCategory() {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sort   = empty($sort) ? array('g_update_time' => 'DESC') : $sort;
        $list = $this->getList($where, 0, 0, $sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[$val['g_id']] = $val['g_kind1'];
            }
        }
        return $data;
    }

    /*
    * 根据商品分类获取店铺商品列表,仅列出已上架商品
    * @params  customer_query  售罄商品排序下沉
    * @params  region_manager  社区团购区域管理合伙人存在绕过总的商品限购开关
    * @params  region_where    社区团购区域合伙人限购商品查询方式        
    */
    public function fetchShopGoodsListByKind($index = 0, $count = 20, $kind1=0,$kind2=0, $hide=0,$presell = false,$checkCommunity =false,$community = 0,$field = [],$customer_query=false,$region_manager=false,$region_where=[],$log = false) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($presell){
            $where[]    = array('name' => 'g_is_sale', 'oper' => 'in', 'value' => [self::GOODS_IN_SALE,self::GOODS_PRE_SALE]);
        }else{
            $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        }

        $where[]    = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        if($kind1 > 0){
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$kind1);
        }
        if($kind2 > 0){
            $where[] = array('name'=>'g_kind2','oper'=>'=','value'=>$kind2);
        }
        if($hide){
            $where[] = array('name'=>'g_applay_goods_show','oper'=>'=','value'=>1);
        }
        if(!$region_manager){
            if($checkCommunity){
               $where[] =  "((g_add_bed = 1 AND (select count(*) as num from `pre_applet_sequence_goods_community` where asgc_g_id = g_id And asgc_c_id = {$community} ) > 0) or (g_add_bed = 0))";
            }
            // 不存在社区管理员的时候
            $where[]=['name'=>'g_region_add_by','oper'=>'=','value'=>0];

        }else{
            if($region_where){
                 foreach ($region_where as  $value) {
                    $where[]=$value;
               }
            }  
        }
        
        $sort   =  array('g_is_top' => 'DESC', 'g_weight'=>'DESC','g_update_time' => 'DESC');

        if($customer_query){
            $query_field=[];
            if($field){
                foreach ($field as $key => $value) {
                    if(is_numeric($key))
                         $query_field[]="`".$value."`";
                     else
                       $query_field[]=$key." as ".$value."";
                }
            }
          
            $sql_field = implode(',', $query_field);
            $sql=sprintf('SELECT %s FROM %s',
                $sql_field,
                DB::table($this->_table)
            );
            $where[]=['name'=>$this->_df,'oper'=>'=','value'=>0];
            $sql.=$this->formatWhereSql($where);
            $sql.=$this->getSqlSort($customer_query);
            $sql.=$this->formatLimitSql($index,$count);

            if($log){
                Libs_Log_Logger::outputLog($sql,'test.log');
            }

            $res=DB::fetch_all($sql);
            if($res===false){
                trigger_error("query mysql failed.", E_USER_ERROR);
                return;
            }
            return $res;
        }             

        return $this->getList($where, $index, $count, $sort,$field);
    }

    /**
     * 获取酒店最低价格
     */
    public function getHotelMinPrice($id){
        $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'g_kind1', 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        $where[]    = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);//未删

        $sql    = "SELECT min(g_price) as minprice FROM `pre_goods` ";

        $sql    .= $this->formatWhereSql($where);
        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取入驻店铺商品
     */
    /*
 * 获取店铺商品列表,仅列出已上架商品
 */
    public function fetchEnterShopGoodsList($sid, $index = 0, $count = 20, $top = 0, $sort = array(),$kind1=0,$where) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'g_es_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        if ($top) {
            $where[]    = array('name' => 'g_is_top', 'oper' => '=', 'value' => 1);//筛选店长推荐商品
        }
        if($kind1 > 0){
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$kind1);
        }
        $sort   = empty($sort) ? array('g_update_time' => 'DESC') : $sort;
        return $this->getList($where, $index, $count, $sort);
    }
    /**
     * 获取商品列表--仅列出已经首页推荐展示的商品
     */
    public function fetchTopShopGoodsList($index = 0, $count = 20, $sort = array(),$top = 0,$kind1=0,$kind2=0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        $where[]    = array('name'=>'g_type','oper'=>'in','value'=>array(1,2));
        if ($top) {
            $where[]    = array('name' => 'g_is_top', 'oper' => '=', 'value' => 1);//筛选店长推荐商品
        }
        if($kind1 > 0){
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$kind1);
        }
        if($kind2 > 0){
            $where[] = array('name'=>'g_kind2','oper'=>'=','value'=>$kind2);
        }
        $sort   = empty($sort) ? array('g_update_time' => 'DESC') : $sort;
        return $this->getList($where, $index, $count, $sort,array('g_id','g_name','g_ori_price','g_vip_price','g_price','g_cover','g_list_label'));
    }
    /**
     * 获取店铺商品列表,仅列出已上架商品(预约版使用)
     */
    public function fetchShopGoodsListReservation($sid, $index = 0, $count = 20, $keyword = '', $top = 0, $sort = array(),$field=array(),$kind1=0,$kind2=0,$type=1,$where=array(),$kind3=0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        $where[]    = array('name' => 'g_kind2','oper' => '=','value' =>0);
        if ($keyword) {
            $keyword = $this->utf8_str_to_unicode($keyword);
            $where[]    = array('name' => 'g_name', 'oper' => 'like', 'value' => "%{$keyword}%");
        }
        if ($top) {
            $where[]    = array('name' => 'g_is_top', 'oper' => '=', 'value' => 1);//筛选店长推荐商品
        }
        if($kind1 > 0){
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$kind1);
        }
        if($kind2 > 0){
            $where[] = array('name'=>'g_kind2','oper'=>'=','value'=>$kind2);
        }
        if($kind3 > 0){
            $where[] = array('name'=>'g_kind3','oper'=>'=','value'=>$kind3);
        }
        if($kind3 == -1){
            $where[] = array('name'=>'g_kind3','oper'=>'=','value'=>0);
        }
        if($type){
            if($type == 1){
                $where[] = array('name'=>'g_type','oper'=>'in','value'=>array(1,2));
            }else{
                if(is_array($type)){
                    $where[] = array('name'=>'g_type','oper'=>'in','value'=>$type);
                }else{
                    $where[] = array('name'=>'g_type','oper'=>'=','value'=>$type);
                }
            }

        }
        $sort   = empty($sort) ? array('g_update_time' => 'DESC') : $sort;
        return $this->getList($where, $index, $count, $sort,$field);
    }

    /*
     * 根据店铺id  门店id 获得未删除商品总量
     * 包含未上架商品
     */
    public function getGoodsCountBySidEsIdAction($sid,$esId = 0){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[] = array('name' => 'g_es_id', 'oper' => '=', 'value' => $esId);
        $where[] = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);//未删除商品
        return $this->getCount($where);
    }

    /*
     * 获得商品列表 关联社区团购活动商品表
     */
    public function getListSequence($aid,$where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql = "SELECT * ";
        $sql .= " FROM ".DB::table($this->_table)." g ";
        $sql .= " LEFT JOIN pre_applet_sequence_activity_goods asag on g.g_id=asag.asag_g_id AND asag.asag_a_id = {$aid} ";
        $sql .= $this->formatWhereSql($where);
        //$sql .= " group by g.g_id ";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    public function getCountSequence($aid,$where){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." g ";
        $sql .= " LEFT JOIN pre_applet_sequence_activity_goods asag on g.g_id=asag.asag_g_id  AND asag.asag_a_id = {$aid} ";
        $sql .= $this->formatWhereSql($where);
        //$sql .= " group by g.g_id ";
        $ret = DB::result_first($sql);
        Libs_Log_Logger::outputLog($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

//    public function goodsExpert(){
//        $sql = "SELECT g.* FROM `pre_goods` g ";
//        $sql .= " LEFT JOIN `pre_applet_cfg` ac on g.`g_s_id` = ac.`ac_s_id` ";
//        $sql .= " WHERE ac.`ac_type` = 18 and g.`g_deleted` = 0 and g.`g_kind3` >0 ";
//        $ret = DB::fetch_all($sql);
//        if($ret === false){
//            trigger_error("query mysql failed.", E_USER_ERROR);
//            return false;
//        }
//        return $ret;
//    }

    /*
     * 获得餐饮商品
     * 关联门店
     */
    public function getMealGoodsList($esId,$where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql = "SELECT * ";
        $sql .= " FROM ".DB::table($this->_table)." g ";
        $sql .= " LEFT JOIN pre_applet_meal_goods_shelf amgs on g.g_id=amgs.amgs_g_id and amgs_es_id = {$esId} ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得餐饮商品
     * 关联门店
     */
    public function getMealGoodsCount($esId,$where){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." g ";
        $sql .= " LEFT JOIN pre_applet_meal_goods_shelf amgs on g.g_id=amgs.amgs_g_id and amgs_es_id = {$esId} ";
        $sql .= $this->formatWhereSql($where);
        //echo $sql;die;
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得统计信息
     */
    public function getStatInfo($where){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql = "SELECT count(*) as total,sum(g_sold) as soldNum ";
        $sql .= " FROM ".DB::table($this->_table)." ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * 获取主管理社区团购中设置的不可购买的商品
     * @return [type] [description]
     */
    public function getGoodsLimited(){
        $sql='SELECT `g_id` FROM `pre_goods` ' ;
        $sql.=$this->formatWhereSql([
            ['name'=>'g_s_id','oper'=>'=','value'=>$this->sid],
            ['name'=>'g_add_bed','oper'=>'=','value'=>1],
            ['name'=>'g_deleted','oper'=>'=','value'=>0]
        ]);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * 社区团购区域管理合伙人的商品提取的时候加上自定义添加的商品的关联区域
     * @param  [type] $where [description]
     * @param  [type] $index [description]
     * @param  [type] $count [description]
     * @param  [type] $sort  [description]
     * @return [type]        [description]
     */
    public function getGoodsListWithRegion($where,$index,$count,$sort){

        $sql=sprintf('SELECT `pre_goods`.*, `region_name`,`m_id`,`assi_name` FROM `%s` 
                LEFT JOIN `%s` ON `g_region_add_by`=`m_id` 
                LEFT JOIN `%s` ON `m_area_id`=`region_id` 
                LEFT JOIN `%s` ON `g_supplier_id`=`assi_id` ',
                DB::table($this->_table),
                'pre_manager',
                'dpl_china_address',
                'pre_applet_sequence_supplier_info');
        $where[]=['name'=>'g_deleted','oper'=>'=','value'=>0];
        $sql.=$this->formatWhereSql($where);
        $sql.=$this->getSqlSort($sort);
        $sql.=$this->formatLimitSql($index,$count);
        
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * utf8字符转换成Unicode字符
     */
    private function utf8_str_to_unicode($utf8_str) {
        $unicode_str = '';
        for($i=0;$i<mb_strlen($utf8_str);$i++){
            $val = mb_substr($utf8_str,$i,1,'utf-8');
            if(strlen($val) >= 4){
                $unicode = (ord($val[0]) & 0xF) << 18;
                $unicode |= (ord($val[1]) & 0x3F) << 12;
                $unicode |= (ord($val[2]) & 0x3F) << 6;
                $unicode |= (ord($val[3]) & 0x3F);
                $unicode_str.= '';
            }else{
                $unicode_str.=$val;
            }
        }
        $unicode_str = $this->_filter_character($unicode_str);
        return $unicode_str;
    }
    /*
     * 过滤掉昵称中特殊字符
     */
    private function _filter_character($nickname) {
        $nickname = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $nickname);
        $nickname = preg_replace('/[=]/u', '', $nickname);
        $nickname = str_replace(array('"','\''), '', $nickname);
        $nickname  = addslashes(trim($nickname));
        return $nickname;
    }




    /**
     * 收银台商品列表
     */
    public function cashierGoodsList($where,$index,$count,$sort,$keyword=''){
        $where[] = array('name'=>'g_deleted', 'oper'=>'=', 'value'=>0);

        $sql  = '';
        $sql .= " Select g_id,g_name,g_cover,g_abb_name,g_bar_code,g_kind2,g_stock,g_sold,g_cost,g_price,g_vip_price, g_os_id,g_create_time,g_join_discount,g_show_vip ";
        $sql .= " From ".DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        if($keyword){
            $sql .= " And (g_name like ".DB::quote("%{$keyword}%").' or g_abb_name like '.DB::quote("%{$keyword}%").' or g_bar_code like '.DB::quote("%{$keyword}%").') ';
        }
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    public function cashierGoodsCount($where,$keyword=''){
        $where[] = array('name'=>'g_deleted', 'oper'=>'=', 'value'=>0);

        $sql  = '';
        $sql .= " Select count(*) From ".DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        if($keyword){
            $sql .= " And (g_name like ".DB::quote("%{$keyword}%").' or g_abb_name like '.DB::quote("%{$keyword}%").' or g_bar_code like '.DB::quote("%{$keyword}%").') ';
        }
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getGoodsSold($where) {
        $where[] = array('name'=>'g_deleted', 'oper'=>'=', 'value'=>0);

        $sql  = '';
        $sql .= " select count(*) as count, sum(g_sold) as sold ";
        $sql .= " From ".DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    //新品
    public function getNewCountByDays($where) {
        $where[] = array('name'=>'g_deleted', 'oper'=>'=', 'value'=>0);

        $sql = '';
        $sql .= " Select count(*) as count, g_create_day as day ";
        $sql .= " From ".DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        $sql .= " and g_create_day is not null ";
        $sql .= " Group BY g_create_day ";
        $sql .= " Order BY g_create_day desc ";

        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}