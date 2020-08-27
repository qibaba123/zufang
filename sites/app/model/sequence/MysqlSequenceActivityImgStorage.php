<?php
/*
 * 社区团购 活动图片表
 */
class App_Model_Sequence_MysqlSequenceActivityImgStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_activity_img';
        $this->_pk = 'asai_id';
        $this->_shopId = 'asai_s_id';
        $this->_df = 'asai_deleted';
        $this->sid = $sid;
    }

    /*
     * 前端获取店铺可展示的幻灯列表
     */
    public function fetchImgList($aid,$count = 0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asai_a_id', 'oper' => '=', 'value' => $aid);
        $where[]    = array('name' => 'asai_deleted', 'oper' => '=', 'value' => 0);//未删除

        return $this->getList($where, 0, $count, array('asai_sort' => 'ASC'));
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
            $sql .= '  (`asai_id`, `asai_s_id`,  `asai_a_id`, `asai_path`, `asai_sort`,  `asai_deleted`, `asai_create_time`) ';
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