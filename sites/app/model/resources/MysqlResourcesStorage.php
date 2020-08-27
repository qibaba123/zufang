<?php

class App_Model_Resources_MysqlResourcesStorage extends Libs_Mvc_Model_BaseModel{

    const GOODS_IN_SALE     = 1;
    const GOODS_OUT_SALE    = 2;

    private $sid;
    private $format_table;
    private $match_table;
    private $curr_table;

	public function __construct($sid = null){
		$this->_table 	= 'applet_house_resource';
		$this->_pk 		= 'ahr_id';
		$this->_shopId 	= 'ahr_s_id';
        $this->_df      = 'ahr_deleted';
		parent::__construct();

        $this->sid      = $sid;
        $this->format_table = DB::table('goods_format');
        $this->match_table  = DB::table('group_match');
        $this->curr_table   = DB::table($this->_table);
	}

    // 根据距离排序获取帖子信息
    public function getListDistanceAsc($where,$index,$count,$sort,$lng,$lat){
        $where[] = array('name' => $this->_df,'oper' => '=','value' =>0);
        $sql  = ' SELECT ahr.*,ahe.ahe_id,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-ahr_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(ahr_lng * PI()/180)*POW(SIN(PI()*("'.$lat.'"-ahr_lat)/360),2)))) distance ';
        $sql .= " from `".DB::table($this->_table)."` ahr ";
        $sql .= ' LEFT JOIN pre_applet_house_experts ahe on ahr.ahr_m_id = ahe.ahe_m_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' group by ahr_id ';
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
     * 获得当天发布房源数量
     */
    public function getTodayNum($mid){
	    $today_0 = strtotime(date('Y-m-d',time()));
	    $today_24 = $today_0 + 86400;

	    $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ahr_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'ahr_create_time', 'oper' => '>=', 'value' => $today_0);
        $where[] = array('name' => 'ahr_create_time', 'oper' => '<=', 'value' => $today_24);

        return $this->getCount($where);
    }

    //获取房源信息和城市名称
    public function getResourceAndAhzname($id){
        $where   = array();
        $where[] = array('name' => $this->_pk,'oper' => '=','value' =>$id);
        $where[] = array('name' => $this->_df,'oper' => '=','value' =>0);
        $sql  = "select ahr.*,ahz.ahz_name";
        $sql .= " from `".DB::table($this->_table)."` ahr ";
        $sql .= ' LEFT JOIN pre_applet_house_zone ahz on ahr.ahr_city = ahz.ahz_zone_id ';
        // $sql .= ' LEFT JOIN pre_applet_house_zone ahz on ahr.ahr_city = ahz.ahz_zone_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    //获取房源信息和城市名称 关联用户表
    public function getListMember($where,$index,$count,$sort){
        $where[] = array('name' => $this->_df,'oper' => '=','value' =>0);
        $sql  = "select ahr.*,m.m_nickname,m.m_show_id";
        $sql .= " from `".DB::table($this->_table)."` ahr ";
        $sql .= ' LEFT JOIN pre_member m on ahr.ahr_m_id = m.m_id ';
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
    public function getCountMember($where){
        $where[] = array('name' => $this->_df,'oper' => '=','value' =>0);
        $sql  = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` ahr ";
        $sql .= ' LEFT JOIN pre_member m on ahr.ahr_m_id = m.m_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}