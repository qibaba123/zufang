<?php

class App_Model_Resources_MysqlResourcesSlideStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid) {
        $this->_table   = 'applet_house_resource_slide';
        $this->_pk      = 'ahrs_id';
        $this->_shopId  = 'ahrs_s_id';
        $this->_df      = 'ahrs_deleted';
        parent::__construct();

        $this->sid = $sid;
    }

    public function getListByGidSid($gid,$sid,$type){
        $where = array();
        $where[] = array('name'=>'ahrs_ahr_id','oper'=>'=','value'=>$gid);
        $where[] = array('name'=>'ahrs_type','oper'=>'=','value'=>$type);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$sid);
        $where[] = array('name'=>'ahrs_deleted','oper'=>'=','value'=>0);
        $sort = array('ahrs_create_time'=>'DESC');
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
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $set = array(
            'ahrs_path'     => $path
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
            'ahrs_s_id' => $this->sid,
            'ahrs_ahr_id' => $gid,
            'ahrs_path' => $path,
            'ahrs_deleted'     => 0,
            'ahrs_create_time' => time(),
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
        $where[] = array('name'=>'ahrs_ahr_id','oper'=>'=','value'=>$gid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $set = array(
            'ahrs_deleted' => 1
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
        $where[] = array('name'=>'ahrs_ahr_id','oper'=>'=','value'=>$gid);
        $where[] = array('name'=>'ahrs_type','oper'=>'=','value'=>$type);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'ahrs_deleted','oper'=>'=','value'=>0);
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
            $sql .= ' (`ahrs_id`, `ahrs_s_id`, `ahrs_ahr_id`, `ahrs_type`,`ahrs_path`, `ahrs_deleted`, `ahrs_create_time`) ';
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