<?php

/**
 * Class App_Model_Goods_MysqlGoodsVerifyStorage
 * 商品审核记录表
 */
class App_Model_Goods_MysqlGoodsVerifyStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;
	public function __construct($sid=null){
		$this->_table   = 'goods_verify';
		$this->_pk      = 'gv_id';
        $this->_df      = 'gv_deleted';
        $this->_shopId  = 'gv_s_id';
        $this->sid      = $sid;
		parent::__construct();

	}

	/**
     * 根据商品id 查询或者修改数据
     */
	public function getDataByGid($gid,$data=array()){
	    $where   = array();
        $where[] = array('name'=>'gv_g_id','oper'=>'=' ,'value'=>$gid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        if($data){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }
    }






}