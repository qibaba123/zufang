<?php
/**
 * @var 商城商品试衣间参数功能
 */
class App_Model_Goods_MysqlClothesProductStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;
    public function __construct($sid) {
        $this->_table   = 'goods_clothes_product';
        $this->_pk      = 'gcp_id';
        $this->_shopId  = 'gcp_s_id';
        parent::__construct();
        $this->sid = $sid;
    }
    /**
     * 根据商品id,店铺id来取出参数
     */
    public function getProductDataByGid($gid){
        $where   =  array();
        $where[] =  array('name'=>'gcp_g_id','oper'=>'=','value'=>$gid);
        $where[] =  array('name'=>'gcp_s_id','oper'=>'=','value'=>$this->sid);
        return $this->getRow($where);
    }









}