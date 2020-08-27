<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Smart_MysqlStoreDynamicSlideStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_store_dynamic_slide';
        $this->_pk = 'ads_id';
        $this->_shopId = 'ads_s_id';
        $this->_df     = 'ads_deleted';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }
    public function getListByDidSid($asdid){
        $where = array();
        $where[] = array('name'=>'ads_asd_id','oper'=>'=','value'=>$asdid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'ads_deleted','oper'=>'=','value'=>0);
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
            $sql .= ' (`ads_id`, `ads_s_id`, `ads_asd_id`,`ads_cover`, `ads_deleted`, `ads_create_time`) ';
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
            'ads_cover'     => $path
        );
        return $this->updateValue($set,$where);
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
        $where[] = array('name'=>'ads_asd_id','oper'=>'=','value'=>$gid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $set = array(
            'ads_deleted' => 1
        );
        return $this->updateValue($set,$where);
    }
}