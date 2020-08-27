<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/6/27
 * Time: 下午10:01
 */
class App_Model_Answer_MysqlSubjectAwardStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $shop_table = '';
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_subject_award';
        $this->_pk      = 'asa_id';
        $this->_shopId  = 'asa_s_id';
        $this->_df      = 'asa_deleted';
        $this->sid      = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
     * 获得对应店铺奖品列表
     */
    public function fetchAwardsBySid($sid){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        return $this->getList($where,0,0);
    }

    /*
     * 更新奖品使用使用状态
     * 用于仅设置单一奖品的条件下
     */
    public function refreshAwardsUse($newId,$oldId){

        $new = $this->updateById(array('asa_status'=>1),$newId);
        $old = $this->updateById(array('asa_status'=>0),$oldId);
        return true;
    }

    /**
   * 增加或减少获奖人数 $operation=add添加 $operation=reduce减少
   */
  public function changeWinnerNum($id,$operation){
    $sql  = 'UPDATE '.DB::table($this->_table);
    if($operation=='add'){
      $sql .= ' SET  asa_winner = asa_winner + 1 ';
    }
    elseif($operation=='reduce'){
      $sql .= ' SET  asa_winner = asa_winner - 1 ';
    }
    $sql .= '  WHERE '.$this->_pk .' = '.$id;
    $ret = DB::query($sql);
    if ($ret === false) {
      trigger_error("query mysql failed.", E_USER_ERROR);
      return false;
    }
    return $ret;
  }




}