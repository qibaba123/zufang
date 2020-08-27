<?php

class App_Model_Auction_MysqlAuctionSlideStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid) {
        $this->_table   = 'applet_auction_slide';
        $this->_pk      = 'aas_id';
        $this->_shopId  = 'aas_s_id';
        parent::__construct();

        $this->sid = $sid;
    }

    public function getListByGidSid($gid,$sid){
        $where = array();
        $where[] = array('name'=>'aas_aal_id','oper'=>'=','value'=>$gid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$sid);
        $where[] = array('name'=>'aas_deleted','oper'=>'=','value'=>0);
        $sort = array('aas_create_time'=>'ASC');
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
            'aas_path'     => $path
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
            'aas_s_id' => $this->sid,
            'aas_aal_id' => $gid,
            'aas_path' => $path,
            'aas_deleted'     => 0,
            'aas_create_time' => time(),
        );
       return $this->insertValue($data);
    }

    /**
     * @param $gid
     * @param $id
     * @return bool
     * 根据商品ID逻辑删除
     */
    public function deleteSlide($gid,$id=0){
        $where   = array();
        if($id>0){
            if(is_array($id) && !empty($id)){
                $where[] = array('name'=>$this->_pk,'oper'=>'in','value'=>$id);
            }else{
                $where[] = array('name'=>$this->_pk,'oper'=>'=','value'=>$id);
            }
        }
        $where[] = array('name'=>'aas_aal_id','oper'=>'=','value'=>$gid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $set = array(
            'aas_deleted' => 1
        );
        return $this->updateValue($set,$where);
    }

    /**
     * @param $gid
     * @return array|bool
     * 后台展示，根据时间正序
     */
    public function getSlideByGid($gid){
        $where = array();
        $where[] = array('name'=>'aas_aal_id','oper'=>'=','value'=>$gid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'aas_deleted','oper'=>'=','value'=>0);
        $sort = array('aas_create_time'=>'ASC');
        return $this->getList($where,0,0,$sort);
    }

    /**
     * @param array $value
     * @return bool
     * 新增商品时，批量插入商品幻灯
     */
    public function batchSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`aas_id`, `aas_s_id`, `aas_aal_id`, `aas_path`, `aas_deleted`, `aas_create_time`) ';
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