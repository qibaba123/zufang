<?php

class App_Model_Entershop_MysqlEnterShopSlideStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid) {
        $this->_table   = 'enter_shop_slide';
        $this->_pk      = 'ess_id';
        $this->_shopId  = 'ess_s_id';
        parent::__construct();

        $this->sid = $sid;
    }

    public function getListBySid($sid){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$sid);
        $where[] = array('name'=>'ess_deleted','oper'=>'=','value'=>0);

        $sort = array('ess_create_time'=>'DESC');
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
            'ess_path' => $path
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
            'ess_s_id' => $this->sid,
            'ess_g_id' => $gid,
            'ess_path' => $path,
            'ess_deleted'     => 0,
            'ess_create_time' => time(),
        );
       return $this->insertValue($data);
    }

    /**
     * @param $gid
     * @param $id
     * @return bool
     * 根据商品ID逻辑删除
     */
    public function deleteSlide($id){
        $where   = array();
        if(is_array($id) && !empty($id)){
            $where[] = array('name'=>$this->_pk,'oper'=>'in','value'=>$id);
        }else{
            $where[] = array('name'=>$this->_pk,'oper'=>'=','value'=>$id);
        }
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $set = array(
            'ess_deleted' => 1
        );
        return $this->updateValue($set,$where);
    }

    /**
     * @param $gid
     * @return array|bool
     * 后台展示，根据时间正序
     */
    public function getSlideList(){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'ess_deleted','oper'=>'=','value'=>0);
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
            $sql .= ' (`ess_id`, `ess_s_id`, `ess_path`,`ess_weight`, `ess_deleted`, `ess_create_time`) ';
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

    /*
     * 前端获取店铺可展示的幻灯列表
     */
    public function fetchSlideShowList() {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ess_deleted', 'oper' => '=', 'value' => 0);//未删除

        return $this->getList($where, 0, 50, array('ess_weight' => 'ASC'));
    }

}