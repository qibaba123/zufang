<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Train_MysqlTrainNoticeStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_train_notice';
        $this->_pk = 'atn_id';
        $this->_shopId = 'atn_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
    * 获取店铺可展示的快捷菜单列表
    */
    public function fetchNoticeShowList($tpl_id = 0,$index = 0, $count = 50) {
        if($tpl_id>0){
            $where[]    = array('name' => 'atn_tpl_id', 'oper' => '=', 'value' => $tpl_id); //所属模版，暂定通用
        }
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getList($where, $index, $count, array('atn_weight' => 'DESC'));
    }

    //批量插入微培训首页通知公告信息
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`atn_id`, `atn_s_id`,`atn_title`,`atn_img`,`atn_article_id`,`atn_article_title`,`atn_weight`,`atn_create_time`) ';
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

    //批量插入微培训首页通知公告信息(新的加入类型的)
    public function newInsertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`atn_id`, `atn_s_id`,`atn_title`,`atn_img`,`atn_article_id`,`atn_article_title`,`atn_weight`,`atn_type`,`atn_create_time`) ';
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
    //批量插入微汽车首页通知公告信息
    public function carInsertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`atn_id`, `atn_s_id`,`atn_tpl_id`,`atn_title`,`atn_img`,`atn_article_id`,`atn_article_title`,`atn_weight`,`atn_create_time`) ';
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
}