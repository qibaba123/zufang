<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Job_MysqlJobCategoryStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_job_category';
        $this->_pk      = 'ajc_id';
        $this->_shopId  = 'ajc_s_id';
        $this->_df      = 'ajc_deleted';
        $this->sid      = $sid;
    }

    /**
     * @return array|bool
     * 获取店铺所有分类
     */
    public function getListBySid($type,$pType = 2){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'ajc_type','oper' => '=','value' =>$type);
        $where[]    = array('name' => 'ajc_p_type','oper' => '=','value' =>$pType);
        $sort       = array('ajc_fid' => 'ASC','ajc_weight' => 'ASC');
        $field      = array('ajc_id','ajc_name','ajc_logo','ajc_logo_show','ajc_weight','ajc_fid','ajc_level','ajc_create_time');
        return $this->getList($where,0,0,$sort,$field,true);
    }
    /**
     * 获取以主键为键值的 主分类列表
     * 最多取20个
     */
    public function getFirstCategory($type=1,$index=0,$count=20,$pType = 2){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'ajc_level','oper' => '=','value' =>1);
        $where[]    = array('name' => 'ajc_type','oper' => '=','value' =>$type);
        $where[]    = array('name' => 'ajc_p_type','oper' => '=','value' =>$pType);
        $sort       = array('ajc_weight' => 'ASC');
        $field      = array('ajc_id','ajc_name','ajc_logo','ajc_logo_show','ajc_weight');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }

    /**
     * 根据分类id获取以主键为键值的 主分类列表
     * 最多取20个
     */
    public function getFirstCategoryByIds($ids,$pType = 2){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'ajc_level','oper' => '=','value' =>1);
        $where[]    = array('name' => 'ajc_id','oper' => 'in','value' =>$ids);
        $where[]    = array('name' => 'ajc_p_type','oper' => '=','value' =>$pType);
        $sort       = array('ajc_weight' => 'ASC');
        $field      = array('ajc_id','ajc_name','ajc_logo','ajc_logo_show','ajc_weight');
        return $this->getList($where,0,0,$sort,$field,true);
    }
    /**
     * 获取以主键为键值的 主分类列表
     * 最多取200个
     */
    public function getSonCategory(array $fids,$index=0,$count=200,$pType = 2){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'ajc_level','oper' => '=','value' =>2);
        $where[]    = array('name' => 'ajc_fid','oper' => 'in','value' =>$fids);
        $where[]    = array('name' => 'ajc_p_type','oper' => '=','value' =>$pType);
        $sort       = array('ajc_weight' => 'DESC');
        $field      = array('ajc_id','ajc_name','ajc_logo','ajc_weight','ajc_fid');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }
    /*
     * 获取某个父级下的子类
     */
    public function getSonsByFid($fid, $index = 0, $count = 100,$pType = 2) {
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'ajc_level','oper' => '=','value' =>2);
        $where[]    = array('name' => 'ajc_fid','oper' => '=','value' =>$fid);
        $where[]    = array('name' => 'ajc_p_type','oper' => '=','value' =>$pType);
        $sort       = array('ajc_weight' => 'ASC');
        $field      = array('ajc_id','ajc_name','ajc_logo','ajc_weight','ajc_fid','ajc_create_time');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }

    /**
     * @param $ids
     * @param string $oper
     * 根据id删除分类
     */
    public function deleteByIds($ids,$oper='in', $type , $pType = 2){
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => $this->_df,'oper' => '=','value' =>0);
        $where[]    = array('name' => 'ajc_type','oper' => '=','value' =>$type);
        $where[]    = array('name' => 'ajc_p_type','oper' => '=','value' =>$pType);
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
        $sql .= ' (`ajc_id`, `ajc_s_id`, `ajc_type`,`ajc_name`, `ajc_logo`, `ajc_logo_show`, `ajc_weight`, `ajc_level`, `ajc_fid`, `ajc_deleted`, `ajc_create_time`,`ajc_p_type`) ';
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
    public function getAllSonCategory($type=1,$index=0,$count=200,$pType = 2){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'ajc_level','oper' => '=','value' =>2);
        $where[]    = array('name' => 'ajc_type','oper' => '=','value' =>$type);
        $where[]    = array('name' => 'ajc_p_type','oper' => '=','value' =>$pType);
        $sort       = array('ajc_weight' => 'DESC');
        $field      = array('ajc_id','ajc_name','ajc_logo','ajc_weight','ajc_fid','ajc_create_time');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }
    /**
     * 获取一个店铺的所有一级分类
     */
    public function getAllFirstCategory($type=2, $index=0,$count=200,$pType = 2){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'ajc_level','oper' => '=','value' =>1);
        $where[]    = array('name' => 'ajc_type','oper' => '=','value' =>$type);
        $where[]    = array('name' => 'ajc_p_type','oper' => '=','value' =>$pType);
        $sort       = array('ajc_weight' => 'DESC');
        $field      = array('ajc_id','ajc_name','ajc_logo','ajc_weight','ajc_fid','ajc_create_time');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }
    /**
     * @param $ids
     * @param string $oper
     * 根据id删除分类(预约版用)
     */
    public function deleteByIdsFirst($ids,$oper='in',$pType = 2){
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => $this->_df,'oper' => '=','value' =>0);
        $where[]    = array('name' => 'ajc_level','oper' => '=','value' =>1);
        $where[]    = array('name' => 'ajc_p_type','oper' => '=','value' =>$pType);
        if(!empty($ids) && is_array($ids)){
            $where[]= array('name' => $this->_pk,'oper' => $oper,'value' =>$ids);
            $set    = array($this->_df => 1);
            $this->updateValue($set,$where);
        }
    }
    /**
     * @return array|bool
     * 获取店铺所有分类(预约版用)
     */
    public function getListBySidFirst($pType = 2){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'ajc_level','oper' => '=','value' =>1);
        $where[]    = array('name' => 'ajc_p_type','oper' => '=','value' =>$pType);
        $sort       = array('ajc_fid' => 'ASC','ajc_weight' => 'ASC');
        $field      = array('ajc_id','ajc_name','ajc_logo','ajc_weight','ajc_fid','ajc_level','ajc_create_time');
        return $this->getList($where,0,0,$sort,$field,true);
    }

    /*
     * 获取分类列表选择使用
     */
    public function fetchCategoryListForSelect($type=1,$pType = 2) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ajc_deleted', 'oper' => '=', 'value' => 0);//未删除
        if($type){
            $where[]    = array('name' => 'ajc_type', 'oper' => '=', 'value' => $type);
        }
        $where[]    = array('name' => 'ajc_p_type','oper' => '=','value' =>$pType);
        $data = array();
        $list = $this->getList($where, 0, 0, array('ajc_weight' => 'ASC'));
        if($list){
            foreach ($list as $val){
                $data[$val['ajc_id']] = $val['ajc_name'];
            }
        }
        return $data;
    }
}