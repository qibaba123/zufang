<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Community_MysqlKindStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_community_kind';
        $this->_pk      = 'ack_id';
        $this->_shopId  = 'ack_s_id';
        $this->_df      = 'ack_deleted';
        $this->sid      = $sid;
    }

    /**
     * @return array|bool
     * 获取店铺所有分类
     */
    public function getListBySid(){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $sort       = array('ack_fid' => 'ASC','ack_weight' => 'ASC');
        $field      = array('ack_id','ack_name','ack_weight','ack_fid','ack_level','ack_create_time');
        return $this->getList($where,0,0,$sort,$field,true);
    }
    /**
     * 获取以主键为键值的 主分类列表
     * 最多取20个
     */
    public function getFirstCategory($index=0,$count=20){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'ack_level','oper' => '=','value' =>1);
        $sort       = array('ack_weight' => 'ASC');
        $field      = array('ack_id','ack_name','ack_weight');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }
    /**
     * 获取以主键为键值的 主分类列表
     * 最多取200个
     */
    public function getSonCategory(array $fids,$index=0,$count=200){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'ack_level','oper' => '=','value' =>2);
        $where[]    = array('name' => 'ack_fid','oper' => 'in','value' =>$fids);
        $sort       = array('ack_weight' => 'DESC');
        $field      = array('ack_id','ack_name','ack_weight','ack_fid');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }
    /*
     * 获取某个父级下的子类
     */
    public function getSonsByFid($fid, $index = 0, $count = 100) {
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'ack_level','oper' => '=','value' =>2);
        $where[]    = array('name' => 'ack_fid','oper' => '=','value' =>$fid);
        $sort       = array('ack_weight' => 'ASC');
        $field      = array('ack_id','ack_name','ack_weight','ack_fid','ack_create_time');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }

    /**
     * @param $ids
     * @param string $oper
     * 根据id删除分类
     */
    public function deleteByIds($ids,$oper='in'){
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => $this->_df,'oper' => '=','value' =>0);
        if(!empty($ids) && is_array($ids)){
            $where[]= array('name' => $this->_pk,'oper' => $oper,'value' =>$ids);
            $set    = array($this->_df => 1);
            $this->updateValue($set,$where);
        }
    }

    /**
     * @param $value
     * @return bool
     * 批量新增
     */
    public function insertBatchValue($value){
        $sql  = 'INSERT INTO '.DB::table($this->_table);
        $sql .= ' (`ack_id`, `ack_s_id`, `ack_name`, `ack_weight`, `ack_level`, `ack_fid`, `ack_deleted`, `ack_create_time`) ';
        $sql .= ' VALUES ';
        $sql .= implode(',',$value);

        $ret  = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取一个店铺的所有二级分类
     */
    public function getAllSonCategory($index=0,$count=200){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'ack_level','oper' => '=','value' =>2);
        $sort       = array('ack_weight' => 'DESC');
        $field      = array('ack_id','ack_name','ack_weight','ack_fid');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }

    /**
     * 获取一个店铺的所有二级分类
     */
    public function getAllSonCategorySelect($index=0,$count=200){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'ack_level','oper' => '=','value' =>2);
        $sort       = array('ack_weight' => 'DESC');
        $field      = array('ack_id','ack_name','ack_weight','ack_fid');
        $list = $this->getList($where,$index,$count,$sort,$field,true);
        $data = array();
        foreach($list as $val){
            $data[$val['ack_id']] = $val['ack_name'];
        }
        return $data;
    }

    /**
     * 获取一个店铺的所有分类
     */
    public function getAllCategorySelect($index=0,$count=200){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $sort       = array('ack_weight' => 'DESC');
        $field      = array('ack_id','ack_name','ack_weight','ack_fid');
        $list = $this->getList($where,$index,$count,$sort,$field,true);
        $data = array();
        foreach($list as $val){
            $data[$val['ack_id']] = $val['ack_name'];
        }
        return $data;
    }
}