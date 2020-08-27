<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Train_MysqlTrainRecommendStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_train_recommend';
        $this->_pk = 'atr_id';
        $this->_shopId = 'atr_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
    * 获取店铺可展示的快捷菜单列表
    */
    public function fetchRecommendShowList($tpl_id = 11) {
        $where[]    = array('name' => 'atr_tpl_id', 'oper' => '=', 'value' => $tpl_id); //所属模版，暂定通用
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'atr_deleted', 'oper' => '=', 'value' => 0);//未删除

        return $this->getList($where, 0, 50, array('atr_weight' => 'ASC'));
    }

    //批量插入微培训首页课程信息
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`atr_id`, `atr_s_id`,`atr_tpl_id`, `atr_title`,`atr_icon`,`atr_link`,`atr_price`,`atr_brief`,`atr_course_title`,`atr_weight`,`atr_deleted`, `atr_create_time`) ';
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