<?php

class App_Model_Agent_MysqlCommonGoodsStorage extends Libs_Mvc_Model_BaseModel{

    const GOODS_IN_SALE     = 1;
    const GOODS_OUT_SALE    = 2;

    private $sid;
    private $format_table;
    private $match_table;
    private $curr_table;

	public function __construct($sid = null){
		$this->_table 	= 'common_goods';
		$this->_pk 		= 'g_id';
		$this->_shopId 	= 'g_s_id';
        $this->_df      = 'g_deleted';
		parent::__construct();

        $this->sid      = $sid;
        $this->format_table = DB::table('goods_format');
        $this->match_table  = DB::table('group_match');
        $this->curr_table   = DB::table($this->_table);
	}

    /*
     * 获取店铺商品列表,仅列出已上架商品
     */
	public function fetchShopGoodsList($sid, $index = 0, $count = 20, $keyword = '', $top = 0, $sort = array(),$field=array(),$kind1=0,$kind2=0,$type=1,$where,$kind3=0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        if ($keyword) {
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

    public function findGoodsBySidGid($sid, $gid) {
        $where[]    = array('name' => 'g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);

        return $this->getRow($where);
    }


    /**
     * 获取入驻店铺商品
     */
    public function getShopGoodsCount($where){
        $sql = "select count(*)";
        $sql .= " from `".DB::table($this->_table)."` g ";
        $sql .= " left join `pre_enter_shop` es on g.g_es_id = es.es_id ";

        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取入驻店铺商品
     */
    public function getShopGoodsList($where,$index,$count,$sort){
        $sql = "select g.*,es.* ";
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
     * 获取公共产品库商品数量
     */
    public function getGoodsCount($where){
        $sql = "select count(*)";
        $sql .= " from `".DB::table($this->_table)."` g ";
        $sql .= " left join `pre_agent_open` ao on g.g_s_id = ao.ao_a_id ";

        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取公共产品库商品
     */
    public function getGoodsList($where,$index,$count,$sort){
        $sql = "select g.*,ao.* ";
        $sql .= " from `".DB::table($this->_table)."` g ";
        $sql .= " left join `pre_agent_open` ao on g.g_s_id = ao.ao_a_id ";

        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        Libs_Log_Logger::outputLog($sql);
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
    public function fetchGoodsBySidGids($sid, $gids) {
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

        return $this->getList($where, 0, 0);
    }
    /*
     * 获取当前店铺的全部商品数量,仅计算在售商品数量
     */
    public function fetchCountBySid($sid, $keyword = '',$kind1 = 0,$kind2 = 0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        if ($keyword) {
            $where[] = array('name' => 'g_name', 'oper' => 'like', 'value' => "%{$keyword}%");
        }
        if($kind1){
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$kind1);
        }
        if($kind2){
            $where[] = array('name'=>'g_kind2','oper'=>'=','value'=>$kind2);
        }
        return $this->getCount($where);
    }

    /*
     * 设置商品库存
     * @param int $gfid 商品规格ID
     */
    public function adjustStock($gid, $num, $gfid = 0) {
        //修改商品表中总库存量
        $field  = array('g_stock');
        $inc    = array($num);

        $where[]    = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => 'g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        DB::query($sql);
        //修改商品规格表中库存量
        if ($gfid) {
            $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
            $format_model->incrementGoodsStock($gfid, $gid, $num);
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
     * @return array|bool
     * 获取分组商品和未分组商品
     * type look查看 add追加分组
     */
    public function getGroupGoods($type,$gpid,$index,$count,$keyword='',$isShop=0){
        $where = '';
        if($type == 'look'){
            $where = ' and gm_gg_id = '.intval($gpid);
            $sort  = array('gm_weight' => 'DESC','gm_create_time' => 'DESC');
        }else{
            $where = ' and gm_gg_id is null ';//' and (gm_gg_id is null or gm_gg_id != '.intval($gpid).')';
            $sort  = array('g_create_time' => 'DESC');
        }
        if($isShop){
            $where .= ' and g_es_id != 0 ';
            $where .= ' and es_status = 0 ';
        }else{
            $where .= ' and g_es_id = 0 ';
        }
        $where .= ' and g_type in (1,2) ';
        $sql = 'SELECT g_id, g_name,g_cover , g_price , g_ori_price, g_brief, g_stock, g_stock_show,g_sold,g_unified_fee,gm_id,gm_weight ';
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
            $where = ' and gm_gg_id is null ';
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
    */
    public function fetchShopGoodsListByKind($index = 0, $count = 20, $kind1=0,$kind2=0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        if($kind1 > 0){
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$kind1);
        }
        if($kind2 > 0){
            $where[] = array('name'=>'g_kind2','oper'=>'=','value'=>$kind2);
        }
        $sort   =  array('g_weight'=>'DESC','g_update_time' => 'DESC');
        return $this->getList($where, $index, $count, $sort);
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
        return $this->getList($where, $index, $count, $sort,array('g_id','g_name','g_ori_price','g_vip_price','g_price','g_cover'));
    }
    /**
     * 获取店铺商品列表,仅列出已上架商品(预约版使用)
     */
    public function fetchShopGoodsListReservation($sid, $index = 0, $count = 20, $keyword = '', $top = 0, $sort = array(),$field=array(),$kind1=0,$kind2=0,$type=1,$where,$kind3=0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => self::GOODS_IN_SALE);
        $where[]    = array('name' => 'g_kind2','oper' => '=','value' =>0);
        if ($keyword) {
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

}