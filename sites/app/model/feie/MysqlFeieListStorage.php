<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Feie_MysqlFeieListStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_feie_list';
        $this->_pk      = 'afl_id';
        $this->_shopId  = 'afl_s_id';

        $this->sid      = $sid;
    }
    /*
    * 通过店铺id获取该店铺所有打印机列表
    * @params  $region 区域合伙人id
    * @params $rg_choice 自动打印的订单标记下是否判断社区团购区域合伙人
    */
    public function findListBySid($esId = 0,$region=false,$onlyShop = 0,$rg_choice=0) {
        $where   = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($esId){
           // $where[] = array('name' => 'afl_es_id', 'oper' => '=', 'value' => $esId);//只获得门店自身打印机
//            if($onlyShop){
//                $where[] = array('name' => 'afl_es_id', 'oper' => '=', 'value' => $esId);//只获得入驻店铺自身打印机
//            }else{
//                $where[] = " ( afl_es_id = ".$esId." or (afl_es_trade = 1 and afl_es_id = 0) ) "; //门店自身的打印机或开启了打印入驻店铺订单的平台打印机
//            }


            //主平台打印机不再打印入驻店铺订单，同时入驻店铺也不再能查看到开启了打印入驻店铺订单的平台打印机 2019.6.15 ding
            $where[] = array('name' => 'afl_es_id', 'oper' => '=', 'value' => $esId);//只获得入驻店铺自身打印机

        }else{
            $where[] = array('name' => 'afl_es_id', 'oper' => '=', 'value' => 0);//只获得平台自身打印机
        }
        $sort = array('afl_create_time'=>'DESC');


        // 订单自动打印时
        // zhangzc
        // 2019-06-15
        if($rg_choice){
            // 区域合伙人的 找到平台与合伙人的打印机
            if($region){
                $where[]=['name'=>'afl_create_by','oper'=>'in','value'=>[$region,0]];
            }else{ // 非区域合伙人的订单查询打印机的时候去掉区域合伙人添加的打印机
                $where[]=['name'=>'afl_create_by','oper'=>'=','value'=>0];
            }
        }else{ //获取指定合伙人的打印机列表 
            // 区域合伙人则只提取改合伙人添加的打印机
            if($region)
                $where[]=['name'=>'afl_create_by','oper'=>'=','value'=>$region];
        }

        
        // $list = $this->getList($where,0,0,$sort);
        $sql=sprintf('SELECT `pre_applet_feie_list`.*,`m_nickname` FROM %s LEFT JOIN `pre_manager` ON `afl_create_by`=`m_id` ',
            DB::table($this->_table));
        $sql.=$this->formatWhereSql($where);
        $sql.=$this->getSqlSort($sort);

    
        $list = DB::fetch_all($sql);
        if ($list === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }

        return $list;
    }

    /*
    * 通过店铺id和打印机编号查找
    */
    public function findRowBySidSn($sn,$data=array(),$need=true,$esId = 0,$checkEsId = true) {
        $where   = array();
        $where[] = array('name' => 'afl_sn', 'oper' => '=', 'value' => $sn);
        if($need){
            $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        }
        if($checkEsId){
            $where[] = array('name' => 'afl_es_id', 'oper' => '=', 'value' => $esId);
        }

        if(!empty($data)){
            $ret = $this->updateValue($data,$where);
        }else{
            $ret = $this->getRow($where);
        }
        return $ret;
    }




}