<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/20
 * Time: 上午7:39
 */

class App_Model_Member_MysqlMemberExtraStorage extends Libs_Mvc_Model_BaseModel {
    //会员表
    private $member_table;
    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_member_extra';
        $this->_pk      = 'ame_id';
        $this->_shopId  = 'ame_s_id';
        $this->sid      = $sid;

        $this->member_table     = DB::table($this->_table);
    }


    /**
     * 根据会员id获取会员信息
     */
    public function findUpdateExtraByMid($mid, $updata=array()){
        $where = array();
        $where[] = array('name' => 'ame_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ame_m_id', 'oper' => '=', 'value' => $mid);
        if (!$updata) {
            return $this->getRow($where);
        } else {
            return $this->updateValue($updata, $where);
        }
    }

    /*
     * 社区团购
     * 根据会员id获得小区信息
     */
    public function getRowSequence($mid){
        $where = array();
        $where[] = array('name' => 'ame_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ame_m_id', 'oper' => '=', 'value' => $mid);
        $sql  = ' SELECT ame.ame_se_cid,asct.*,asl.asl_name,asl.asl_m_id,asl.asl_mobile,asl.asl_id,asl.asl_introduce,m.m_avatar,m.m_nickname ';
        $sql .= " from `".DB::table($this->_table)."` ame ";
        $sql .= " left join `pre_applet_sequence_community` asct on ame.ame_se_cid = asct.asc_id ";
//        $sql .= " left join `pre_applet_sequence_leader_community` aslc on aslc.aslc_community = ame.ame_se_cid ";
        $sql .= " left join `pre_applet_sequence_leader` asl on asct.asc_leader = asl.asl_id ";
        $sql .= " left join `pre_member` m on asl.asl_m_id = m.m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 增加或减少阅读数、评论数、点赞数 $operation=add添加 $operation=reduce减少
     */
    public function addReduceNum($mid,$type,$operation='add',$num=1){
        if($type=='car') {
            $field = 'ame_car_num';
        }
        $sql  = 'UPDATE '.DB::table($this->_table);
        if($operation=='add'){
            $sql .= ' SET  '.$field.' = '.$field.' + '.$num;
        }else{
            $sql .= ' SET  '.$field.' = '.$field.' - '.$num;
        }
        $sql .= '  WHERE ame_m_id = '.intval($mid);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param array $insArr
     * @return bool
     * 批量插入数据
     */
    public function batchInsert(array $insArr){
        $sql  = 'INSERT '.' INTO '.DB::table($this->_table);
        $sql .= ' (`ame_id`, `ame_s_id`, `ame_m_id`, `ame_cate`, `ame_update_time` , `ame_create_time`) ';
        $sql .= ' VALUES ';
        $sql .= implode(',',$insArr);

        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
  
   public function getAreaRow($where){
        $sql  = ' SELECT p.region_name as p_name,c.region_name as c_name,a.region_name as a_name';
        $sql .= " from `".DB::table($this->_table)."` ame ";
        $sql .= " left join `pre_china_address` p on p.region_id = ame.ame_pro ";
        $sql .= " left join `pre_china_address` c on c.region_id = ame.ame_city ";
        $sql .= " left join `pre_china_address` a on a.region_id = ame.ame_area ";
        $sql .= $this->formatWhereSql($where);
     Libs_Log_Logger::outputLog($sql,'wxpay.log');
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}