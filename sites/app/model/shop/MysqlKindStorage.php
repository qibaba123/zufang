<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Shop_MysqlKindStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'shop_kind';
        $this->_pk      = 'sk_id';
        $this->_shopId  = 'sk_s_id';
        $this->_df      = 'sk_deleted';
        $this->sid      = $sid;
    }

    /**
     * @return array|bool
     * 获取店铺所有分类
     */
    public function getListBySid($independent = 0){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'sk_independent_mall','oper' => '=','value' =>$independent);
        $sort       = array('sk_fid' => 'ASC','sk_weight' => 'ASC');
        $field      = array('sk_id','sk_name','sk_logo','sk_logo_show','sk_weight','sk_fid','sk_level','sk_create_time','sk_show','sk_independent_mall');
        return $this->getList($where,0,0,$sort,$field,true);
    }
    /**
     * 获取以主键为键值的 主分类列表
     * 最多取20个
     */
    public function getFirstCategory($index=0,$count=20,$checkShow = false,$independent = 0){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'sk_level','oper' => '=','value' =>1);
        $where[]    = array('name' => 'sk_independent_mall','oper' => '=','value' =>$independent);
        if($checkShow){
            $where[]    = array('name' => 'sk_show','oper' => '=','value' =>1);
        }
        $sort       = array('sk_weight' => 'ASC');
        $field      = array('sk_id','sk_name','sk_logo','sk_logo_show','sk_weight','sk_show','sk_independent_mall');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }

    /**
     * 根据分类id获取以主键为键值的 主分类列表
     * 最多取20个
     */
    public function getFirstCategoryByIds($ids,$independent = 0){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'sk_level','oper' => '=','value' =>1);
        $where[]    = array('name' => 'sk_id','oper' => 'in','value' =>$ids);
        $where[]    = array('name' => 'sk_independent_mall','oper' => '=','value' =>$independent);
        $sort       = array('sk_weight' => 'ASC');
        $field      = array('sk_id','sk_name','sk_logo','sk_logo_show','sk_weight','sk_show','sk_independent_mall');
        return $this->getList($where,0,0,$sort,$field,true);
    }
    /**
     * 获取以主键为键值的 主分类列表
     * 最多取200个
     */
    public function getSonCategory(array $fids,$index=0,$count=200,$independent = 0){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'sk_level','oper' => '=','value' =>2);
        $where[]    = array('name' => 'sk_fid','oper' => 'in','value' =>$fids);
        $where[]    = array('name' => 'sk_independent_mall','oper' => '=','value' =>$independent);
        $sort       = array('sk_weight' => 'DESC');
        $field      = array('sk_id','sk_name','sk_logo','sk_weight','sk_fid','sk_show','sk_independent_mall');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }
    /*
     * 获取某个父级下的子类
     */
    public function getSonsByFid($fid, $index = 0, $count = 100,$checkShow = false,$independent = 0) {
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'sk_level','oper' => '=','value' =>2);
        $where[]    = array('name' => 'sk_fid','oper' => '=','value' =>$fid);
        $where[]    = array('name' => 'sk_independent_mall','oper' => '=','value' =>$independent);
        if($checkShow){
            $where[]    = array('name' => 'sk_show','oper' => '=','value' =>1);
        }
        $sort       = array('sk_weight' => 'ASC');
        $field      = array('sk_id','sk_name','sk_logo','sk_weight','sk_fid','sk_create_time','sk_show','sk_independent_mall');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }

    /**
     * @param $ids
     * @param string $oper
     * 根据id删除分类
     */
    public function deleteByIds($ids,$oper='in',$independent = 0){
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'sk_independent_mall','oper' => '=','value' =>$independent);
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
        $sql .= ' (`sk_id`, `sk_s_id`, `sk_name`, `sk_logo`, `sk_logo_show`, `sk_weight`, `sk_level`, `sk_fid`, `sk_show`, `sk_deleted`, `sk_create_time`, `sk_independent_mall`) ';
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
     * 获取一个店铺的所有二级分类（权重正序排列）
     */
    public function getAllSonCategorySortAsc($index=0,$count=200,$checkShow = false,$independent = 0){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'sk_level','oper' => '=','value' =>2);
        $where[]    = array('name' => 'sk_independent_mall','oper' => '=','value' =>$independent);
        if($checkShow){
            $where[]    = array('name' => 'sk_show','oper' => '=','value' =>1);
        }
        $sort       = array('sk_weight' => 'ASC');
        $field      = array('sk_id','sk_name','sk_logo','sk_weight','sk_fid','sk_create_time','sk_show','sk_independent_mall');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }

    /**
     * 获取一个店铺的所有二级分类（权重倒序排列）
     */
    public function getAllSonCategory($index=0,$count=200,$checkShow = false,$independent = 0){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'sk_level','oper' => '=','value' =>2);
        if(is_array($independent))
            $where[]    = array('name' => 'sk_independent_mall','oper' => 'in','value' =>$independent);
        else
            $where[]    = array('name' => 'sk_independent_mall','oper' => '=','value' =>$independent);
        if($checkShow){
            $where[]    = array('name' => 'sk_show','oper' => '=','value' =>1);
        }
        $sort       = array('sk_weight' => 'DESC');
        $field      = array('sk_id','sk_name','sk_logo','sk_weight','sk_fid','sk_create_time','sk_show','sk_independent_mall');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }
    /**
     * 获取一个店铺的所有一级分类
     */
    public function getAllFirstCategory($index=0,$count=200,$checkShow = false,$independent = 0){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'sk_level','oper' => '=','value' =>1);
        if(is_array($independent))
            $where[]    = array('name' => 'sk_independent_mall','oper' => 'in','value' =>$independent);
        else
            $where[]    = array('name' => 'sk_independent_mall','oper' => '=','value' =>$independent);
        if($checkShow){
            $where[]    = array('name' => 'sk_show','oper' => '=','value' =>1);
        }
        $sort       = array('sk_weight' => 'ASC');
        $field      = array('sk_id','sk_name','sk_logo','sk_logo_show','sk_weight','sk_fid','sk_create_time','sk_show','sk_independent_mall');
        return $this->getList($where,$index,$count,$sort,$field,true);
    }
    /**
     * @param $ids
     * @param string $oper
     * 根据id删除分类(预约版用)
     */
    public function deleteByIdsFirst($ids,$oper='in',$independent = 0){
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => $this->_df,'oper' => '=','value' =>0);
        $where[]    = array('name' => 'sk_level','oper' => '=','value' =>1);
        $where[]    = array('name' => 'sk_independent_mall','oper' => '=','value' =>$independent);
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
    public function getListBySidFirst($independent = 0){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'sk_level','oper' => '=','value' =>1);
        $where[]    = array('name' => 'sk_independent_mall','oper' => '=','value' =>$independent);
        $sort       = array('sk_fid' => 'ASC','sk_weight' => 'ASC');
        $field      = array('sk_id','sk_name','sk_logo','sk_weight','sk_fid','sk_level','sk_create_time','sk_show','sk_independent_mall');
        return $this->getList($where,0,0,$sort,$field,true);
    }
}