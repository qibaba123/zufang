<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityPostCategoryStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_city_category';
        $this->_pk = 'acc_id';
        $this->_shopId = 'acc_s_id';

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
     * 获取店铺可展示的快捷菜单列表
     */
    public function fetchShortcutShowList($type='',$level=1,$fid=0,$serviceType = 0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acc_deleted', 'oper' => '=', 'value' => 0);//未删除
        if($type){
            $where[]    = array('name' => 'acc_type', 'oper' => '=', 'value' => $type);
        }else{
            $where[]    = array('name' => 'acc_type', 'oper' => '!=', 'value' => 1);
        }
        if($level){
            $where[]    = array('name' => 'acc_level', 'oper' => '=', 'value' => $level);
        }
        if($fid){
            $where[]    = array('name' => 'acc_fid', 'oper' => '=', 'value' => $fid);
        }
        if($serviceType){
            $where[]    = array('name' => 'acc_service_type', 'oper' => '=', 'value' => $serviceType);
        }
        return $this->getList($where, 0, 60, array('acc_sort' => 'ASC'));
    }

    /*
     * 批量添加帖子分类
     */
    public function insertBatchPostCategory(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`acc_id`, `acc_s_id`, `acc_title`, `acc_type`,`acc_img`,`acc_sort`,`acc_service_type`,`acc_price`,`acc_mobile_show`,`acc_address_show`,`acc_allow_comment`,`acc_verify_comment`,`acc_link_url`,`acc_deleted`, `acc_create_time`) ';
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
     * 批量添加店铺分类
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`acc_id`, `acc_s_id`, `acc_title`, `acc_type`,`acc_img`,`acc_sort`,`acc_service_type`,`acc_price`,`acc_deleted`, `acc_create_time`) ';
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
     * 批量添加店铺分类
     */
    public function secondInsertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`acc_id`, `acc_s_id`, `acc_title`, `acc_type`,`acc_sort`,`acc_price`,`acc_level`,`acc_fid`, `acc_deleted`,`acc_update_time`,`acc_create_time`) ';
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
     * 获取店铺帖子分类列表选择使用
     */
    public function fetchCategoryListForSelect($type=null,$level=false,$details=false,$service_type=1) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acc_deleted', 'oper' => '=', 'value' => 0);//未删除
        if($service_type){
            $where[]    = array('name' => 'acc_service_type', 'oper' => '=', 'value' => $service_type);//默认获取帖子分类
        }
        if($type){
            $where[]    = array('name' => 'acc_type', 'oper' => '=', 'value' => $type);
        }
        if($level){
            $where[]    = array('name' => 'acc_level', 'oper' => '=', 'value' => $level);
        }
        $data = array();
        $list = $this->getList($where, 0, 0, array('acc_sort' => 'ASC'));
        if($list){
            if($details){
                foreach ($list as $val){
                    $data[$val['acc_id']] = $val;
                }
            }else{
                foreach ($list as $val){
                    $data[$val['acc_id']] = $val['acc_title'];
                }
            }
        }
        return $data;
    }

    /*
     * 获取店铺帖子所有的二级分类
     */
    public function fetchCategorySecondList() {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acc_deleted', 'oper' => '=', 'value' => 0);//未删除
        $where[]    = array('name' => 'acc_service_type', 'oper' => '=', 'value' => 1);//获取帖子分类
        $where[]    = array('name' => 'acc_type', 'oper' => '=', 'value' => 1);   // 帖子
        $where[]    = array('name' => 'acc_level', 'oper' => '=', 'value' => 2);   // 二级分类
        $data = array();
        $list = $this->getList($where, 0, 0, array('acc_sort' => 'ASC'));
        if($list){
            foreach ($list as $val){
                $data[$val['acc_fid']][] = array(
                    'id'    => $val['acc_id'],
                    'name'  => $val['acc_title'],
                    'icon'  => $val['acc_img'] ? plum_deal_image_url($val['acc_img']) : plum_deal_image_url('/public/manage/img/zhanwei/fenleinav.png'),
                    'price' => $val['acc_price'],
                    'level' => $val['acc_level'],
                    'fid'   => $val['acc_fid']
                );
            }
        }
        return $data;
    }

    /*
     * 获取店铺帖子一级分类所有的二级分类
     */
    public function fetchCategorySecondListByOne($oneCategory) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acc_deleted', 'oper' => '=', 'value' => 0);//未删除
        $where[]    = array('name' => 'acc_service_type', 'oper' => '=', 'value' => 1);//获取帖子分类
        $where[]    = array('name' => 'acc_type', 'oper' => '=', 'value' => 1);   // 帖子
        $where[]    = array('name' => 'acc_level', 'oper' => '=', 'value' => 2);   // 二级分类
        $where[]    = array('name' => 'acc_fid', 'oper' => '=', 'value' => $oneCategory);   // 一级分类id
        return $this->getList($where, 0, 0, array('acc_sort' => 'ASC'));
    }
}