<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2018/3/12
 * Time: 17:31
 */

class App_Model_Mobile_MysqlMobileShopCategoryStorage extends Libs_Mvc_Model_BaseModel{

  public function __construct($sid = null){
    $this->_table 	= 'applet_mobile_shop_category';
    $this->_pk 		= 'amc_id';
    $this->_df    = 'amc_deleted';
    $this->_shopId 	= 'amc_s_id';
    parent::__construct();
    $this->sid  = $sid;

  }

  /*
     * 获取店铺可展示的分类列表
     */
  public function fetchCategoryListForSelect() {
    $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
    $where[]    = array('name' => 'amc_deleted', 'oper' => '=', 'value' => 0);//未删除
    $data = array();
    $list = $this->getList($where, 0, 0, array('amc_sort' => 'DESC'));
    if($list){
      foreach ($list as $val){
        $data[$val['amc_id']] = $val['amc_title'];
      }
    }
    return $data;
  }

  /*
     * 获取店铺可展示的快捷菜单列表
     */
    public function fetchShortcutShowList() {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'amc_deleted', 'oper' => '=', 'value' => 0);//未删除

        return $this->getList($where, 0, 0, array('amc_sort' => 'ASC'));
    }

}