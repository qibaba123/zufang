<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/27
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletServiceMsgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $shop_table;
    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'applet_service_msg';
        $this->_pk      = 'asm_id';
        $this->_shopId  = 'asm_s_id';
        $this->_df      = 'asm_deleted';

        $this->sid      = $sid;
        $this->shop_table = DB::table('shop');
    }

    public function getRowByKeyword($keyword, $type){
        $where = array();
        $where[] = array('name' => 'asm_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'asm_deleted', 'oper' => '=', 'value' => 0);
        switch ($type){
            case 1: //精准匹配
                $where[] = array('name' => 'asm_keyword', 'oper' => '=', 'value' => $keyword);
                break;
            case 2: //模糊匹配
                $where[] = array('name' => 'asm_keyword', 'oper' => 'like', 'value' => "%{$keyword}%");
                break;
            case 3: //默认回复
                $where[] = array('name' => 'asm_keyword', 'oper' => '=', 'value' => '');
                break;
        }
        return $this->getRow($where);
    }
}