<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/7/29
 * Time: 下午2:59
 */
class App_Model_Shop_MysqlAttachmentStorage extends Libs_Mvc_Model_BaseModel{

    public function __construct(){
        $this->_table 	= 'shop_attachment';
        $this->_pk 		= 'sa_id';
        $this->_shopId 	= 'sa_s_id';
        parent::__construct();
    }

    /*
     * 获取本店铺图片
     */
    public function getImgListBySid($sid,$index=0,$count=20) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'sa_type', 'oper' => '=', 'value' => 1);
        return $this->getList($where, $index, $count, array('sa_create_time' => 'DESC'));
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
            $sql .= '  (`sa_id`, `sa_s_id`, `sa_link`, `sa_path`, `sa_weight`, `sa_show`, `sa_deleted`, `sa_create_time`) ';
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

    //根据分组获取图片数量
    public function getCountByGid($sid, $gid, $height=0, $width=0){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'sa_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'sa_type', 'oper' => '=', 'value' => 1);
        if($width){
            $where[] = array('name'=>'sa_width','oper'=>'=','value'=>$width);
        }
        if($height){
            $where[] = array('name'=>'sa_height','oper'=>'=','value'=>$height);
        }
        return $this->getCount($where);
    }

}