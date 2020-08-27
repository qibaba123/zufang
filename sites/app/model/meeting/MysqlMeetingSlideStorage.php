<?php
/**
 * Created by PhpStorm.
 * User: zhanghongwei
 * Date: 17/12/28
 * Time: 下午7:45
 */
class App_Model_Meeting_MysqlMeetingSlideStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_meeting_slide';
        $this->_pk 		= 'ams_id';
        $this->_shopId 	= 'ams_s_id';
        $this->_df 	    = 'ams_deleted';
        parent::__construct();
        $this->sid = $sid;
    }
    public function getListByGidSid($amid){
        $where = array();
        $where[] = array('name'=>'ams_am_id','oper'=>'=','value'=>$amid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'ams_deleted','oper'=>'=','value'=>0);
        return $this->getList($where,0,0);
    }
    /**
     * @param array $value
     * @return bool
     * 新增商品时，批量插入商品幻灯
     */
    public function batchSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`ams_id`, `ams_s_id`, `ams_am_id`,`ams_cover`, `ams_deleted`, `ams_create_time`) ';
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
     * @param $id
     * @param $url
     * @return bool
     * 根据id更新图片路径
     */
    public function updateSlide($id,$path){
        $where   = array();
        $where[] = array('name'=>$this->_pk,'oper'=>'=','value'=>$id);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $set = array(
            'ams_cover'     => $path
        );
        return $this->updateValue($set,$where);
    }

    /**
     * @param $gid
     * @param $path
     * @return bool
     * 新增商品ID
     */
    public function insertSlide($gid,$path){
        $data = array(
            'ams_s_id'        => $this->sid,
            'ams_am_id'       => $gid,
            'ams_cover'       => $path,
            'ams_deleted'     => 0,
            'ams_create_time' => time(),
        );
        return $this->insertValue($data);
    }

    /**
     * @param $gid
     * @param $id
     * @return bool
     * 根据商品ID逻辑删除
     */
    public function deleteSlide($gid,$id){
        $where   = array();
        if(is_array($id) && !empty($id)){
            $where[] = array('name'=>$this->_pk,'oper'=>'in','value'=>$id);
        }else{
            $where[] = array('name'=>$this->_pk,'oper'=>'=','value'=>$id);
        }
        $where[] = array('name'=>'ams_am_id','oper'=>'=','value'=>$gid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $set = array(
            'ams_deleted' => 1
        );
        return $this->updateValue($set,$where);
    }
}