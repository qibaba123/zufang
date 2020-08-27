<?php
/**
 * 多店预约预约配置
 */
class App_Model_Community_MysqlCommunityFreeCfgStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $entershop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_community_free_cfg';
        $this->_pk = 'acfc_id';
        $this->_shopId = 'acfc_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->entershop_table = DB::table('enter_shop');
    }

    /*
     * 根据门店id
     * 获取或更新预约配置信息
     */
    public function findupdateByEsId($esId,$data = array()){
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=> 'acfc_es_id','oper'=>'=','value'=>$esId);
        if($data){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }
    }

}