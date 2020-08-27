<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/7/29
 * Time: 下午2:59
 */
class App_Model_Applet_MysqlAppletInformationStorage extends Libs_Mvc_Model_BaseModel{

    public function __construct(){
        $this->_table 	= 'applet_information';
        $this->_pk 		= 'ai_id';
        $this->_shopId 	= 'ai_s_id';
        $this->_df 	    = 'ai_deleted';
        parent::__construct();
    }

    /**
     * 批量插入测试
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`ai_id`, `ai_s_id`,`ai_category`, `ai_title`, `ai_cover`, `ai_brief`, `ai_content`,`ai_sort`,`ai_create_time`) ';
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


    /**
     * 增加或减少阅读数、评论数、点赞数 分享数 $operation=add添加 $operation=reduce减少
     */
    public function addReduceInformationNum($aid,$type,$operation='add',$num=1){
        if($type=='like'){
            $field = 'ai_like_num';
        }elseif ($type=='comment'){
            $field = 'ai_comment_num';
        }elseif($type=='share'){
            $field = 'ai_share_num';
        }elseif($type=='collection'){
            $field = 'ai_collection_num';
        }else{
            $field = 'ai_show_num';
        }
        $sql  = 'UPDATE '.DB::table($this->_table);
        if($operation=='add'){
            $sql .= ' SET  '.$field.' = '.$field.' + '.$num;
        }else{
            $sql .= ' SET  '.$field.' = '.$field.' - '.$num;
        }
        $sql .= '  WHERE '.$this->_pk .' = '.intval($aid);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 资讯统计信息
     *
     */
    public function getSumInfo($where){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT count(ai_id) as infoTotal,sum(ai_comment_num) as commentSum,sum(ai_show_num) as showSum,sum(ai_like_num) as likeSum ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}