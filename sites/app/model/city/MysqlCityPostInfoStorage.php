<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityPostInfoStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_city_info';
        $this->_pk = 'aci_id';
        $this->_shopId = 'aci_s_id';
        $this->_df = 'aci_deleted';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /**
     * 根据店铺id获取店铺的所有资讯分类
     */
    public function getListBySid(){
        $where = array();
        $where[] = array('name'=>'acc_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        return $this->getList($where,0,0,array('acc_sort'=>'ASC','acc_create_time'=>'DESC'));
    }

    /*
     * 获取店铺可展示的信息
     */
    public function fetchShortcutShowList() {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aci_deleted', 'oper' => '=', 'value' => 0);//未删除
        return $this->getList($where, 0, 60, array('aci_sort' => 'ASC'));
    }

    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`aci_id`, `aci_s_id`,`aci_img`,`aci_link`,`aci_type`,`aci_sort`, `aci_create_time`) ';
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

    /*
     * 获取店铺可展示的快捷菜单列表
     */
    public function fetchCategoryListForSelect($type=null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acc_deleted', 'oper' => '=', 'value' => 0);//未删除
        if($type){
            $where[]    = array('name' => 'acc_type', 'oper' => '=', 'value' => $type);
        }
        $data = array();
        $list = $this->getList($where, 0, 0, array('acc_sort' => 'ASC'));
        if($list){
            foreach ($list as $val){
                $data[$val['acc_id']] = $val['acc_title'];
            }
        }
        return $data;
    }
}