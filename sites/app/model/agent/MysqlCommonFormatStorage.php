<?php

class App_Model_Agent_MysqlCommonFormatStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid) {
        $this->_table   = 'common_goods_format';
        $this->_pk      = 'gf_id';
        $this->_shopId  = 'gf_s_id';
        parent::__construct();

        $this->sid = $sid;
    }

    /**
     * @param $gid
     * @return array|bool
     * 获取单个商品的规格
     */
    public function getListByGid($gid){
        $where = array();
        $where[] = array('name'=>'gf_g_id','oper'=>'=','value'=>$gid);
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
     * 新增商品时，批量插入商品规格,商品多规格
     */
    public function newBatchSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`gf_id`, `gf_s_id`, `gf_g_id`, `gf_name`,`gf_name2`,`gf_name3`,`gf_img`, `gf_ori_price`, `gf_price`,`gf_stock`, `gf_format_weight`,`gf_format_weight_type`,`gf_sort`,`gf_sold`, `gf_create_time`) ';
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
     * 增减商品销量
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
}