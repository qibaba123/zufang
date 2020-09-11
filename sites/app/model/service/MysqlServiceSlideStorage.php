<?php

class App_Model_Service_MysqlServiceSlideStorage extends Libs_Mvc_Model_BaseModel{

    public function __construct() {
        $this->_table   = 'service_slide';
        $this->_pk      = 'ss_id';
        $this->_shopId  = 'ss_s_id';
        $this->_df      = 'ss_deleted';
        parent::__construct();
    }

    public function getListByGidSid($gid,$sid,$type){
        $where = array();
        $where[] = array('name'=>'ss_ser_id','oper'=>'=','value'=>$gid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$sid);
        $where[] = array('name'=>'ss_deleted','oper'=>'=','value'=>0);
        $sort = array('ss_create_time'=>'DESC');
        return $this->getList($where,0,0,$sort);
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
        $set = array(
            'ss_path'     => $path
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
            'ss_s_id' => $this->sid,
            'ss_ser_id' => $gid,
            'ss_path' => $path,
            'ss_deleted'     => 0,
            'ss_create_time' => time(),
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
        $where[] = array('name'=>'ss_ser_id','oper'=>'=','value'=>$gid);
        $set = array(
            'ss_deleted' => 1
        );
        return $this->updateValue($set,$where);
    }

    /**
     * @param $gid
     * @return array|bool
     * 后台展示，根据时间正序
     */
    public function getSlideByGid($gid, $type){
        $where = array();
        $where[] = array('name'=>'ss_ser_id','oper'=>'=','value'=>$gid);
        $where[] = array('name'=>'ss_deleted','oper'=>'=','value'=>0);
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
            $sql .= ' (`ss_id`, `ss_s_id`, `ss_ser_id`,`ss_path`, `ss_deleted`, `ss_create_time`) ';
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




}