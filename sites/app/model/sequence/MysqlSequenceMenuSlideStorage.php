<?php
/*
 * 社区团购菜单幻灯图
 */
class App_Model_Sequence_MysqlSequenceMenuSlideStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_sequence_menu_slide';
        $this->_pk 		= 'asms_id';
        $this->_shopId 	= 'asms_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    public function fetchSlideList(){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getList($where,0,0,['asms_weight'=>'ASC','asms_id'=>'ASC']);
    }



    /**
     * @param array $val_arr
     * @return bool
     * 批量插入数据
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`asms_id`, `asms_s_id`, `asms_path`, `asms_weight`, `asms_link_type`, `asms_link`,  `asms_create_time`) ';
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