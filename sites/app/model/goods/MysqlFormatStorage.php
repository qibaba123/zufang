<?php

class App_Model_Goods_MysqlFormatStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid) {
        $this->_table   = 'goods_format';
        $this->_pk      = 'gf_id';
        $this->_shopId  = 'gf_s_id';
        parent::__construct();

        $this->sid = $sid;
    }

    /**
     * @param $gid
     * @return array|bool
     * 获取单个商品的规格
     * $esId  入驻店铺的id 多店平台
     */
    public function getListByGid($gid,$esId=0){
        $where = array();
        $where[] = array('name'=>'gf_g_id','oper'=>'=','value'=>$gid);
        if($this->sid){
            $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        }
        if($esId){
            $where[] = array('name'=>'gf_es_id','oper'=>'=','value'=>$esId);
        }
        $sort = array( 'gf_sort'=>'ASC', 'gf_price' => 'ASC','gf_create_time'=>'DESC');
        return $this->getList($where,0,0,$sort);
    }


    /**
     * @param $id
     * @param $set
     * @return bool
     * 根据id更新单个规格信息
     */
    public function updateFormat($id,$set){
        $where   = array();
        $where[] = array('name'=>$this->_pk,'oper'=>'=','value'=>$id);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        return $this->updateValue($set,$where);
    }

    /**
     * @param array $value
     * @return bool
     * 新增商品时，批量插入商品规格
     */
    public function batchSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`, `gf_g_id`, `gf_name`, `gf_price`,`gf_stock`,`gf_sort`,`gf_sold`, `gf_create_time`) ';
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

    /**
     * @param array $value
     * @return bool
     * 新增商品时，批量插入商品规格, 添加单日库存
     */
    public function batchNewSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`, `gf_g_id`, `gf_name`, `gf_price`,`gf_stock`,`gf_day_stock`,`gf_sort`,`gf_sold`, `gf_create_time`) ';
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

    /**
     * @param array $value
     * @return bool
     * 新增商品时，批量插入商品规格
     */
    public function batchMealShopSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`, `gf_es_id`, `gf_g_id`, `gf_name`, `gf_price`,`gf_stock`,`gf_sort`,`gf_sold`, `gf_create_time`) ';
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

    /**
     * @param array $value
     * @return bool
     * 新增商品时，批量插入商品规格
     */
    public function batchMealShopNewSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`, `gf_es_id`, `gf_g_id`, `gf_name`, `gf_price`,`gf_stock`,`gf_day_stock`,`gf_sort`,`gf_sold`, `gf_create_time`) ';
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


    /**
     * @param array $value
     * @return bool
     * 新增商品时，批量插入商品规格,商品多规格
     */
    public function newBatchSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`, `gf_g_id`, `gf_name`,`gf_name2`,`gf_name3`,`gf_img`, `gf_ori_price`, `gf_price`,`gf_stock`, `gf_format_weight`, `gf_format_weight_type`, `gf_sort`,`gf_sold`, `gf_create_time`,`gf_cost`,`gf_newmember_price`) ';
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

    /**
     * @param array $value
     * @return bool
     * 微蛋糕添加规格，增加赠品字段
     */
    public function batchCakeSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`, `gf_g_id`, `gf_name`, `gf_price`,`gf_stock`,`gf_sort`,`gf_sold`, `gf_create_time`, `gf_cake_gift`) ';
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

    /**
     * @param array $value
     * @return bool
     * 微蛋糕添加规格，增加赠品字段
     */
    public function batchNewCakeSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`, `gf_g_id`, `gf_name`, `gf_price`,`gf_stock`,`gf_day_stock`,`gf_sort`,`gf_sold`, `gf_create_time`, `gf_cake_gift`) ';

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

    /**
     * @param array $value
     * @return bool
     * 微蛋糕添加规格，增加赠品字段,增加重量
     */
    public function batchCakeSaveNew(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`, `gf_g_id`, `gf_name`, `gf_price`,`gf_format_weight`,`gf_format_weight_type`,`gf_stock`,`gf_sort`,`gf_sold`, `gf_create_time`, `gf_cake_gift`) ';
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


    /**
     * @param array $value
     * @return bool
     * 微蛋糕添加规格，增加赠品字段
     */
    public function batchHotelSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`, `gf_g_id`, `gf_name`, `gf_price`, `gf_date_price`,`gf_stock`,`gf_sort`,`gf_sold`, `gf_create_time`, `gf_cake_gift`, `gf_hotel_stock`) ';
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

    /**
     * @param array $value
     * @return bool
     * 新增商品时，批量插入商品规格,商品多规格
     */
    public function copyBatchSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`, `gf_g_id`, `gf_name`,`gf_name2`,`gf_name3`,`gf_img`, `gf_price`, `gf_format_weight`,`gf_points`,`gf_stock`,`gf_sort`,`gf_sold`, `gf_create_time`, `gf_cake_gift`) ';
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

    /**
     * @param array $value
     * @return bool
     * 积分商品添加规格，增加积分字段
     */
    public function batchPointsSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`, `gf_g_id`, `gf_name`, `gf_price`,`gf_points`,`gf_stock`,`gf_sort`,`gf_sold`, `gf_create_time`, `gf_cake_gift`) ';
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



    public function batchFormatSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_es_id`,gf_s_id`, `gf_g_id`, `gf_name`, `gf_price`,`gf_points`,`gf_stock`,`gf_sort`,`gf_sold`, `gf_create_time`, `gf_cake_gift`) ';
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

    /**
     * @param array $value
     * @return bool
     * 微蛋糕添加规格，增加赠品字段
     */
    public function batchShopSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`, `gf_g_id`, `gf_name`, `gf_price`,`gf_vip_price`,`gf_stock`,`gf_sort`,`gf_sold`, `gf_create_time`, `gf_cake_gift`) ';
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

    /**
     * @param $gid
     * @param $id
     * @return bool
     * 根据商品ID物理删除
     */
    public function deleteFormat($gid,$id){
        $where   = array();
        if(is_array($id) && !empty($id)){
            $where[] = array('name'=>$this->_pk,'oper'=>'in','value'=>$id);
        }else{
            $where[] = array('name'=>$this->_pk,'oper'=>'=','value'=>$id);
        }
        $where[] = array('name'=>'gf_g_id','oper'=>'=','value'=>$gid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);

        return $this->deleteValue($where);
    }

    /*
     * 根据规格ID,商品ID,获取商品规格
     */
    public function findFormatByGfid($gfid, $gid) {
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $gfid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gf_g_id', 'oper' => '=', 'value' => $gid);

        return $this->getRow($where);
    }
    /*
     * 获取商品的规格总数
     */
    public function getFromatCountByGid($gid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gf_g_id', 'oper' => '=', 'value' => $gid);

        return $this->getCount($where);
    }
    /*
     * 增减商品销量
     */
    public function incrementGoodsSold($gfid, $gid, $sold) {
        $field  = array('gf_sold');
        $inc    = array($sold);

        $where[]    = array('name' => 'gf_id', 'oper' => '=', 'value' => $gfid);
        $where[]    = array('name' => 'gf_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'gf_s_id', 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 增减商品库存
     */
    public function incrementGoodsStock($gfid, $gid, $stock) {
        $field  = array('gf_stock');
        $inc    = array($stock);

        $where[]    = array('name' => 'gf_id', 'oper' => '=', 'value' => $gfid);
        $where[]    = array('name' => 'gf_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'gf_s_id', 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /**
     * 获取店铺的所有商品规格（订餐使用）
     */
    public function getAllList(){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sort = array('gf_price' => 'ASC','gf_sort'=>'ASC','gf_create_time'=>'DESC');
        $list = $this->getList($where,0,0,$sort);
        return $list;
    }


    /**
     * @param array $value
     * @return bool
     * 入驻店铺商品添加规格
     */
    public function batchShopFormatSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`,`gf_es_id`, `gf_g_id`, `gf_name`,`gf_name2`,`gf_name3`,`gf_img`, `gf_price`,`gf_stock`, `gf_format_weight`, `gf_sort`,`gf_sold`, `gf_create_time`) ';
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

    /**
     * @param array $value
     * @return bool
     * 入驻店铺商品添加规格
     */
    public function batchNewShopFormatSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`,`gf_es_id`, `gf_g_id`, `gf_name`,`gf_name2`,`gf_name3`,`gf_img`, `gf_price`, `gf_vip_price`,`gf_stock`, `gf_format_weight`, `gf_format_weight_type`, `gf_sort`,`gf_sold`, `gf_create_time`) ';
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

    /**
     * @param array $value
     * @return bool
     * 入驻店铺商品添加规格
     */
    public function batchShopFormatSaveCopy(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`,`gf_es_id`, `gf_g_id`, `gf_name`,`gf_name2`,`gf_name3`,`gf_img`, `gf_price`, `gf_vip_price`,`gf_vip_price_list`,`gf_stock`, `gf_format_weight`, `gf_sort`,`gf_sold`, `gf_create_time`) ';
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

    public function getFormatListAndLimitAction($where, $index=0, $count=0, $sort=array()){
        $sql = "select *";
        $sql .= " from `".DB::table($this->_table)."` gf ";
        $sql .= " left join pre_limit_goods_format lgf on gf.gf_id = lgf.lgf_gf_id ";

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

    public function getFormatListAndGroupAction($where, $index=0, $count=0, $sort=array()){
        $sql = "select *";
        $sql .= " from `".DB::table($this->_table)."` gf ";
        $sql .= " left join pre_group_buy_format gbf on gf.gf_id = gbf.gbf_gf_id ";

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
}