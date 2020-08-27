<?php

class App_Model_Goods_MysqlPublicGoodsStorage extends Libs_Mvc_Model_BaseModel{

    const GOODS_IN_SALE     = 1;
    const GOODS_OUT_SALE    = 2;

    private $sid;
    private $format_table;
    private $match_table;

	public function __construct($sid = null){
		$this->_table 	= 'public_goods';
		$this->_pk 		= 'pg_id';
		parent::__construct();

        $this->sid      = $sid;
        $this->format_table = DB::table('goods_format');
        $this->match_table  = DB::table('group_match');
	}

    public function findGoodsBySidGid($sid, $gid) {
        $where[]    = array('name' => 'g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);

        return $this->getRow($where);
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
    public function getGroupGoods($type,$gpid,$index,$count,$keyword=''){
        if($type == 'look'){
            $where = ' and gm_gg_id = '.intval($gpid);
            $sort  = array('gm_weight' => 'DESC','gm_create_time' => 'DESC');
        }else{
            $where = ' and gm_gg_id is null ';//' and (gm_gg_id is null or gm_gg_id != '.intval($gpid).')';
            $sort  = array('g_create_time' => 'DESC');
        }
        $sql = 'SELECT g_id, g_name,g_cover ,gm_id,gm_weight ';
        $sql .= ' FROM `'.DB::table($this->_table).'` go ';
        $sql .= ' LEFT JOIN '.$this->match_table.' gm on gm_g_id = go.g_id ';
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
    public function getCountGoods($type,$gpid,$keyword=''){
        if($type == 'look'){
            $where = ' and gm_gg_id = '.intval($gpid);
        }else{
            $where = ' and gm_gg_id is null ';
        }

        $sql  = ' SELECT count(*) FROM';
        $sql .= ' ( SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` go ';
        $sql .= ' LEFT JOIN '.$this->match_table.' gm ON gm_g_id = go.g_id ';
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

}