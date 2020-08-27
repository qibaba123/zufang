<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Goods_MysqlCommentAttachmentStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'goods_comment_attachment';
        $this->_pk = 'gca_id';
        $this->_shopId = 'gca_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /**
     * 批量插入帖子图片
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`gca_id`, `gca_path`,`gca_gc_id`, `gca_s_id`,`gca_m_id`, `gca_deleted`,`gca_create_time`) ';
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

    public function fetchAllAttachment($gcid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gca_gc_id', 'oper' => '=', 'value' => $gcid);
        return $this->getList($where,0,0,array('gca_create_time'=>'DESC'));
    }
}