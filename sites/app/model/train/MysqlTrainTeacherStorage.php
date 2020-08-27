<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Train_MysqlTrainTeacherStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_train_teacher';
        $this->_pk = 'att_id';
        $this->_shopId = 'att_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
    * 获取店铺荣誉证书
    */
    public function fetchSchoolShowList() {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getList($where, 0, 0, array('att_weight' => 'ASC'));
    }

    //批量插入微培训荣誉证书信息
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`att_id`, `att_s_id`,`att_name`,`att_avatar`,`att_course`,`att_grade`,`att_brief`,`att_content`,`att_weight`,`att_tags`,`att_create_time`) ';
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