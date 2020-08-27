<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Applet_MysqlAppointmentKindStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'appointment_goods_kind';
        $this->_pk      = 'agk_id';
        $this->_shopId  = 'agk_s_id';
        $this->_df      = 'agk_deleted';
        $this->sid      = $sid;
    }

    /**
     * @return array|bool
     * 获取店铺所有分类
     */
    public function getListBySid(){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $sort       = array('agk_fid' => 'ASC','agk_weight' => 'DESC');
        $field      = array('agk_id','agk_name','agk_logo','agk_weight','agk_fid','agk_level','agk_create_time');
        return $this->getList($where,0,0,$sort,$field,true);
    }
    /**
     * 获取以主键为键值的 主分类列表
     * 默认取20个
     */
    public function getFirstCategory($index=0,$count=20){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'agk_level','oper' => '=','value' =>1);
        $sort       = array('agk_weight' => 'DESC');
        $field      = array('agk_id','agk_name','agk_logo','agk_weight');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }

    /**
     * 根据分类id获取以主键为键值的 主分类列表
     * 最多取20个
     */
    public function getFirstCategoryByIds($ids){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'agk_level','oper' => '=','value' =>1);
        $where[]    = array('name' => 'agk_id','oper' => 'in','value' =>$ids);
        $sort       = array('agk_weight' => 'DESC');
        $field      = array('agk_id','agk_name','agk_logo','agk_weight');
        return $this->getList($where,0,0,$sort,$field,true);
    }
    /**
     * 获取以主键为键值的 主分类列表
     * 默认取200个
     */
    public function getSonCategory(array $fids,$index=0,$count=200){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'agk_level','oper' => '=','value' =>2);
        $where[]    = array('name' => 'agk_fid','oper' => 'in','value' =>$fids);
        $sort       = array('agk_weight' => 'DESC');
        $field      = array('agk_id','agk_name','agk_logo','agk_weight','agk_fid');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }
    /*
     * 获取某个父级下的子类
     */
    public function getSonsByFid($fid, $index = 0, $count = 100) {
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'agk_level','oper' => '=','value' =>2);
        $where[]    = array('name' => 'agk_fid','oper' => '=','value' =>$fid);
        $sort       = array('agk_weight' => 'DESC');
        $field      = array('agk_id','agk_name','agk_logo','agk_weight','agk_fid','agk_create_time');
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
        $sql .= ' (`agk_id`, `agk_s_id`, `agk_name`, `agk_logo`, `agk_weight`, `agk_level`, `agk_fid`, `agk_deleted`, `agk_create_time`) ';
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
        $where[]    = array('name' => 'agk_level','oper' => '=','value' =>2);
        $sort       = array('agk_weight' => 'DESC');
        $field      = array('agk_id','agk_name','agk_logo','agk_weight','agk_fid','agk_create_time');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }
    /**
     * 获取一个店铺的所有一级分类
     */
    public function getAllFirstCategory($index=0,$count=200){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'agk_level','oper' => '=','value' =>1);
        $sort       = array('agk_weight' => 'DESC');
        $field      = array('agk_id','agk_name','agk_logo','agk_weight','agk_fid','agk_create_time');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }
    /**
     * @param $ids
     * @param string $oper
     */
    public function deleteByIdsFirst($ids,$oper='in'){
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => $this->_df,'oper' => '=','value' =>0);
        $where[]    = array('name' => 'agk_level','oper' => '=','value' =>1);
        if(!empty($ids) && is_array($ids)){
            $where[]= array('name' => $this->_pk,'oper' => $oper,'value' =>$ids);
            $set    = array($this->_df => 1);
            $this->updateValue($set,$where);
        }
    }
    /**
     * @return array|bool
     */
    public function getListBySidFirst(){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'agk_level','oper' => '=','value' =>1);
        $sort       = array('agk_fid' => 'ASC','agk_weight' => 'DESC');
        $field      = array('agk_id','agk_name','agk_logo','agk_weight','agk_fid','agk_level','agk_create_time');
        return $this->getList($where,0,0,$sort,$field,true);
    }
}