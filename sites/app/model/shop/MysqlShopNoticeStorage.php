<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/14
 * Time: 下午5:03
 */
class App_Model_Shop_MysqlShopNoticeStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'shop_notice';
        $this->_pk 		= 'sn_id';
        $this->_shopId 	= 'sn_s_id';
        $this->_df      = 'sn_deleted';
        parent::__construct();

        $this->sid  = $sid;
    }

    /*
     * 获取店铺通知公告列表
     */
    public function fetchNoticeShowList() {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'sn_deleted', 'oper' => '=', 'value' => 0);//未删除
        $sort = array('sn_weight' => 'ASC');
        return $this->getList($where, 0, 50,$sort);
    }

    /**
     * 批量插入店铺公告
     * @param array $val_arr
     * @return bool
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`sn_id`, `sn_s_id`, `sn_title`, `sn_link`, `sn_weight`, `sn_deleted`, `sn_create_time`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$val_arr);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }

    /*
     * 获取店铺通知公告最新一条（微商城小程序使用）
     */
    public function fetchNoticeShowNew() {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'sn_deleted', 'oper' => '=', 'value' => 0);//未删除
        $sort = array('sn_create_time'=>'DESC','sn_weight' => 'DESC');
        $list = $this->getList($where, 0, 1,$sort);
        if($list){
            return $list[0];
        }
        return false;
    }
}