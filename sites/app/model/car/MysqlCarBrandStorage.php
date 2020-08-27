<?php

class App_Model_Car_MysqlCarBrandStorage extends Libs_Mvc_Model_BaseModel{

    public function __construct() {
        $this->_table   = 'car_brand';
        $this->_pk      = 'cb_id';
        $this->_df      = 'cb_deleted';
        parent::__construct();

    }

    /**
     * 批量插入
     */
    public function batchSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`cb_id`, `cb_name`, `cb_letter`, `cb_cate_id`, `cb_img`, `cb_deleted`) ';
            $sql .= ' VALUES '.implode(',',$value);

            $ret  = DB::query($sql);
            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
            return $ret;
        }
        return false;
    }

    /**
     * 增加或减少阅读数、评论数、点赞数 $operation=add添加 $operation=reduce减少
     */
    public function addReduceNum($id,$type,$operation='add',$num=1){
        if($type=='search') {
            $field = 'cb_search_num';
        }
        $sql  = 'UPDATE '.DB::table($this->_table);
        if($operation=='add'){
            $sql .= ' SET  '.$field.' = '.$field.' + '.$num;
        }else{
            $sql .= ' SET  '.$field.' = '.$field.' - '.$num;
        }
        $sql .= '  WHERE '.$this->_pk .' = '.intval($id);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }




}