<?php

class App_Model_Giftcard_MysqlGiftCardCoverStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_gift_card_cover';
        $this->_pk 		= 'agcc_id';
        $this->_shopId 	= 'agcc_s_id';
        parent::__construct();

        $this->sid = $sid;
    }

    /**
     * 根据店铺id获取店铺的所有资讯分类
     */
    public function getListBySid(){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        return $this->getList($where,0,0,array('agcc_sort'=>'ASC','agcc_create_time'=>'DESC'));
    }
    /**
     * 获取分类选择使用
     */
    public function getCategoryListForSelect(){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $list = $this->getList($where,0,0,array('agcc_create_time'=>'DESC'));
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[$val['agcc_id']] = $val['agcc_name'];
            }
        }
        return $data;
    }

    /**
     * 批量插入分类使用
     * @param array $val_arr
     * @return bool
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`agcc_id`, `agcc_s_id`,`agcc_name`, `agcc_img`, `agcc_sort`, `agcc_create_time`) ';
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