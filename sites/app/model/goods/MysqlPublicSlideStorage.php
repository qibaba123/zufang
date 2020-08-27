<?php

class App_Model_Goods_MysqlPublicSlideStorage extends Libs_Mvc_Model_BaseModel{

    public function __construct() {
        $this->_table   = 'public_goods_slide';
        $this->_pk      = 'pgs_id';
        parent::__construct();
    }

    public function getListByGidSid($gid){
        $where = array();
        $where[] = array('name'=>'pgs_pg_id','oper'=>'=','value'=>$gid);
        $sort = array('pgs_create_time'=>'DESC');
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
            'pgs_path'     => $path
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
            'pgs_s_id' => $this->sid,
            'pgs_pg_id' => $gid,
            'pgs_path' => $path,
            'pgs_deleted'     => 0,
            'pgs_create_time' => time(),
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
        $where[] = array('name'=>'pgs_pg_id','oper'=>'=','value'=>$gid);

        return $this->deleteValue($where);
    }

    /**
     * @param $gid
     * @return array|bool
     * 后台展示，根据时间正序
     */
    public function getSlideByGid($gid){
        $where = array();
        $where[] = array('name'=>'pgs_pg_id','oper'=>'=','value'=>$gid);
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
            $sql .= ' (`pgs_id`, `pgs_pg_id`, `pgs_path`,`pgs_create_time`) ';
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