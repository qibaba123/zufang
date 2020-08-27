<?php
/**
 * @var 商城商品试衣间功能
 */
class App_Model_Goods_MysqlClothesRoomStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;

    public function __construct($sid) {
        $this->_table   = 'goods_clothes_room_img';
        $this->_pk      = 'gcri_id';
        $this->_shopId  = 'gcri_s_id';
        parent::__construct();
        $this->sid = $sid;
    }

    /**
     * @param $gid
     * @param $sid
     * @return array|bool 获取商品试衣间面料图片列表
     */
    public function getListByGidSid($gid,$index=0,$count=0){
        $where   = array();
        if($gid){
            $where[] = array('name'=>'gcri_g_id','oper'=>'=','value'=>$gid);
        }
        $where[] = array('name'=>'gcri_type','oper'=>'=','value'=>'2');
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sort    = array('gcri_create_time'=>'DESC');
        return $this->getList($where,$index,$count,$sort);
    }
    /**
     * 获取对应店铺的模特图片
     * copy_status  1.代表图库图片 2.代表商铺图片
     */
    public function getModelListSid(){
        $where   = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'gcri_type','oper'=>'=','value'=>'1');
        $where[] = array('name'=>'gcri_copy_status','oper'=>'=','value'=>'2');
        $sort    = array('gcri_create_time'=>'DESC');
        return $this->getList($where,0,0,$sort);
    }
    /**
     * 批量插入 复用图片
     * @param array $val_arr
     * @return bool
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`gcri_id`, `gcri_s_id`,`gcri_g_id`, `gcri_path`, `gcri_create_time`, `gcri_update_time` ,`gcri_type`,`gcri_copy_status`) ';
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
     * 批量插入--每个店铺选择图片
     */
    public function insertShopBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`gcri_id`, `gcri_s_id`, `gcri_path`, `gcri_create_time`, `gcri_update_time` ,`gcri_type`,`gcri_copy_status`) ';
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