<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityPostAttachmentStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_city_attachment';
        $this->_pk = 'aca_id';
        $this->_shopId = 'aca_s_id';

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
            $sql .= ' (`aca_id`, `aca_path`,`aca_acp_id`, `aca_s_id`,`aca_m_id`, `aca_deleted`,`aca_create_time`) ';
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

    public function fetchAllAttachment($pid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aca_acp_id', 'oper' => '=', 'value' => $pid);
        return $this->getList($where,0,0,array('aca_create_time'=>'DESC'));
    }

    /**
     * @param $id
     * @param $url
     * @return bool
     * 根据id更新图片路径
     */
    public function updateAttachment($id,$path){
        $where   = array();
        $where[] = array('name'=>$this->_pk,'oper'=>'=','value'=>$id);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $set = array(
            'aca_path'     => $path
        );
        return $this->updateValue($set,$where);
    }

    /**
     * @param $gid
     * @param $id
     * @return bool
     * 根据商品ID逻辑删除
     */
    public function deleteAttachment($acpId,$id){
        $where   = array();
        if(is_array($id) && !empty($id)){
            $where[] = array('name'=>$this->_pk,'oper'=>'in','value'=>$id);
        }else{
            $where[] = array('name'=>$this->_pk,'oper'=>'=','value'=>$id);
        }
        $where[] = array('name'=>'aca_acp_id','oper'=>'=','value'=>$acpId);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        return $this->deleteValue($where);
    }
}