<?php

class App_Model_Goods_MysqlPublicFormatStorage extends Libs_Mvc_Model_BaseModel{



    public function __construct() {
        $this->_table   = 'public_goods_format';
        $this->_pk      = 'pgf_id';
        parent::__construct();
    }

    /**
     * @param $gid
     * @return array|bool
     * 获取单个商品的规格
     */
    public function getListByGid($gid){
        $where = array();
        $where[] = array('name'=>'pgf_pg_id','oper'=>'=','value'=>$gid);
        $sort = array('pgf_sort'=>'ASC','pgf_create_time'=>'DESC');
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
            $sql .= ' (`pgf_id`, `pgf_pg_id`, `pgf_name`, `pgf_price`,`pgf_sort`,`pgf_create_time`) ';
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
        $where[] = array('name'=>'pgf_pg_id','oper'=>'=','value'=>$gid);
        return $this->deleteValue($where);
    }

    /*
     * 根据规格ID,商品ID,获取商品规格
     */
    public function findFormatByGfid($gfid, $gid) {
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $gfid);
        $where[]    = array('name' => 'pgf_pg_id', 'oper' => '=', 'value' => $gid);

        return $this->getRow($where);
    }
    /*
     * 获取商品的规格总数
     */
    public function getFromatCountByGid($gid) {
        $where[]    = array('name' => 'pgf_pg_id', 'oper' => '=', 'value' => $gid);

        return $this->getCount($where);
    }
    /*
     * 增减商品销量
     */
    public function incrementGoodsSold($gfid, $gid, $sold) {
        $field  = array('pgf_sold');
        $inc    = array($sold);

        $where[]    = array('name' => 'pgf_id', 'oper' => '=', 'value' => $gfid);
        $where[]    = array('name' => 'pgf_pg_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'pgf_s_id', 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 增减商品销量
     */
    public function incrementGoodsStock($gfid, $gid, $stock) {
        $field  = array('pgf_stock');
        $inc    = array($stock);

        $where[]    = array('name' => 'pgf_id', 'oper' => '=', 'value' => $gfid);
        $where[]    = array('name' => 'pgf_pg_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'pgf_s_id', 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
}