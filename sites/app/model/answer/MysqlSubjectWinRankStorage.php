<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/6/27
 * Time: 下午10:01
 */
class App_Model_Answer_MysqlSubjectWinRankStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $shop_table = '';
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_subject_win_rank';
        $this->_pk      = 'aswr_id';
        $this->_shopId  = 'aswr_s_id';
        $this->sid      = $sid;
        $this->shop_table = DB::table('shop');
    }



    /**
   * 增加或减少胜场 $operation=add添加 $operation=reduce减少
   */
  public function changeWinNum($id,$operation){
    $sql  = 'UPDATE '.DB::table($this->_table);
    if($operation=='add'){
      $sql .= ' SET  aswr_win = aswr_win + 1 ';
    }
    elseif($operation=='reduce'){
      $sql .= ' SET  aswr_win = aswr_win - 1 ';
    }
    $sql .= '  WHERE '.$this->_pk .' = '.$id;
    $ret = DB::query($sql);
    if ($ret === false) {
      trigger_error("query mysql failed.", E_USER_ERROR);
      return false;
    }
    return $ret;
  }

  /*
   * 获得指定用户排名
   */
  public function getMemberRank($mid){
      $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
      $where_mid[] = array('name' => 'aswr_m_id', 'oper' => '=', 'value' => $mid);

      $sql  = 'SELECT aswr_win as win,FIND_IN_SET( aswr_win, ( ';
      $sql .= ' SELECT GROUP_CONCAT( aswr_win ORDER BY aswr_win DESC ) FROM pre_applet_subject_win_rank ';
      $sql .= $this->formatWhereSql($where);
      $sql .= ') ) AS rank ';
      $sql .= ' FROM pre_applet_subject_win_rank ';
      $sql .= $this->formatWhereSql($where_mid);
      $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;

  }

  /*
   * 获得排行榜列表
   */
    public function getRankList($where,$index,$count){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sort = array('aswr_win' => 'DESC');
        $sql  = 'SELECT aswr.* , m.m_id, m.m_nickname, m.m_avatar  ';
        $sql .= ' FROM '.DB::table($this->_table) . ' aswr ';
        $sql .= ' LEFT JOIN pre_member m ON aswr.aswr_m_id = m.m_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
   * 获得排行榜列表数量
   */
    public function getRankListCount($where,$group_m_id=false){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql  = 'SELECT count(*) ';
        $sql .= ' FROM '.DB::table($this->_table) . ' aswr ';
        $sql .= ' LEFT JOIN pre_member m ON aswr.aswr_m_id = m.m_id ';
        $sql .= $this->formatWhereSql($where);
        if($group_m_id){
            $sql .= ' group by aswr_m_id ';
        }
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}