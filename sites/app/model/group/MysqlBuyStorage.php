<?php

class App_Model_Group_MysqlBuyStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $goods_table;
    private $curr_table;
    private $course_table;
	public function __construct($sid = null){
		$this->_table 	= 'group_buy';
		$this->_pk 		= 'gb_id';
		$this->_shopId 	= 'gb_s_id';
        $this->_df      = 'gb_deleted';
		parent::__construct();

        $this->sid         = $sid;
        $this->curr_table  = DB::table($this->_table);
        $this->goods_table = DB::table('goods');
        $this->course_table = DB::table('applet_train_course');
	}

    public function getGoodsList($where,$index,$count,$sort=array('gb_update_time' => 'DESC'),$keyfield=''){
        $where[] = array('name' => $this->_df , 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT gb.*,go.* ';
        $sql .= ' FROM `'.$this->curr_table.'` gb ';
        $sql .= ' LEFT JOIN '.$this->goods_table.' go on g_id=gb_g_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql,array(),$keyfield);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getGoodsListWithSection($where,$index,$count,$sort=array('gb_update_time' => 'DESC'),$keyfield=''){
        $where[] = array('name' => $this->_df , 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT gb.*,go.* ';
        $sql .= ' FROM `'.$this->curr_table.'` gb ';
        $sql .= ' LEFT JOIN '.$this->goods_table.' go on g_id=gb_g_id ';
        $sql .= ' LEFT JOIN pre_group_buy_section gbs on gbs.gbs_id=gb_gbs_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY IFNULL(gbs.gbs_id,UUID()) ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql,array(),$keyfield);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCourseListWithSection($where,$index,$count,$sort=array('gb_update_time' => 'DESC'),$keyfield=''){
        $where[] = array('name' => $this->_df , 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT gb.*,atc.* ';
        $sql .= ' FROM `'.$this->curr_table.'` gb ';
        $sql .= ' LEFT JOIN '.$this->course_table.' atc on atc_id=gb_g_id ';
        $sql .= ' LEFT JOIN pre_group_buy_section gbs on gbs.gbs_id=gb_gbs_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY IFNULL(gbs.gbs_id,UUID()) ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql,array(),$keyfield);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getGoodsCount($where){
        $where[] = array('name' => $this->_df , 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT count(*) ';
        $sql .= ' FROM `'.$this->curr_table.'` gb ';
        $sql .= ' LEFT JOIN '.$this->goods_table.' go on g_id=gb_g_id ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getGoodsCountWithSection($where){
        $where[] = array('name' => $this->_df , 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT count(*) ';
        $sql .= ' FROM `'.$this->curr_table.'` gb ';
        $sql .= ' LEFT JOIN '.$this->goods_table.' go on g_id=gb_g_id ';
        $sql .= ' LEFT JOIN pre_group_buy_section gbs on gbs.gbs_id=gb_gbs_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY IFNULL(gbs.gbs_id,UUID()) ';

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCourseCountWithSection($where){
        $where[] = array('name' => $this->_df , 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT count(*) ';
        $sql .= ' FROM `'.$this->curr_table.'` gb ';
        $sql .= ' LEFT JOIN '.$this->course_table.' atc on atc_id=gb_g_id ';
        $sql .= ' LEFT JOIN pre_group_buy_section gbs on gbs.gbs_id=gb_gbs_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY IFNULL(gbs.gbs_id,UUID()) ';

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param array $ids
     * @param string $oper
     * @return array|bool
     * 根据ID数组获取活动列表
     */
    public function getListByIds(array $ids,$oper='in'){
        $where[]    = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gb_id', 'oper' => $oper, 'value' => $ids);
        $sort       = array($this->_pk => 'DESC');
        return $this->getGoodsListWithSection($where,0,0,$sort,$this->_pk);
    }

    /**
     * @param $index
     * @param $count
     * @return array|bool
     * 获取本店当前未结束的活动列表
     */
    public function getCurrentList($index,$count,$where=array(),$version=0){
        if($version){
            $where[]    = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);
            $sort  = array('gb_end_time' => 'DESC');
        }else{
            $where = $this->current_where($where);
            $sort  = array('gb_start_time' => 'ASC');
        }
        return $this->getGoodsListWithSection($where,$index,$count,$sort);
    }

    public function getCourseCurrentList($index,$count,$where=array(),$version=0){
        if($version){
            $where[]    = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);
            $sort  = array('gb_end_time' => 'DESC');
        }else{
            $where = $this->current_where($where);
            $sort  = array('gb_start_time' => 'ASC');
        }
        return $this->getCourseListWithSection($where,$index,$count,$sort);
    }

    /**
     * @param $index
     * @param $count
     * @return array|bool
     * 获取本店当前未结束的活动列表
     * $version  1 新版本显示本店所有的活动列表
     */
    public function getCurrentListByType($type,$index,$count,$version=0,$goodsType = '', $esId){
        if($version){
            $where[]    = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);
            $sort  = array('gb_sort'=>'DESC','gb_end_time' => 'DESC');
        }else{
            $where = $this->current_where();
            $sort  = array('gb_sort'=>'DESC','gb_start_time' => 'ASC');
        }

        if($esId){
            $where[]    = array('name' => 'gb_es_id', 'oper' => '=', 'value' => $esId);
        }else{
            $where[] = " ( gb_es_id = 0 OR gb_index_show = 1 ) ";
        }

        if($type){
            $where[] = array('name' => 'gb_type', 'oper' => '=', 'value' => $type);
        }
       //
        if($goodsType == 'course'){
            return $this->getCourseListWithSection($where,$index,$count,$sort);
        }else{
            return $this->getGoodsListWithSection($where,$index,$count,$sort);
        }

    }


    /**
     * @return bool
     * 统计本店当前未结束的活动
     */
    public function getCurrentCount($where=array(),$version=0){
        if($version){
            $where[]    = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);
        }else{
            $where = $this->current_where($where);
        }
        return $this->getGoodsCountWithSection($where);
    }

    /**
     * @return bool
     * 培训版 统计本店当前未结束的活动
     */
    public function getCourseCurrentCount($where=array(),$version=0){
        if($version){
            $where[]    = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);
        }else{
            $where = $this->current_where($where);
        }
        return $this->getCourseCountWithSection($where);
    }

    /**
     * @param array $where
     * @param string $type  1、noStart 未开始；2、ing 进行中；3、end 已结束；4、 canSelect，未结束的（包含未开始，进行中）
     * @return array
     */
    private function current_where($where=array(),$type='canSelect'){
        $where[]    = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);
        switch($type){
            case 'noStart':
                $where[]    = array('name' => 'gb_start_time', 'oper' => '>', 'value' => $_SERVER['REQUEST_TIME']);
                break;
            case 'ing':
                $where[]    = array('name' => 'gb_start_time', 'oper' => '<=', 'value' => $_SERVER['REQUEST_TIME']);
                $where[]    = array('name' => 'gb_end_time', 'oper' => '>', 'value' => $_SERVER['REQUEST_TIME']);
                break;
            case 'end':
                $where[]    = array('name' => 'gb_end_time', 'oper' => '<', 'value' => $_SERVER['REQUEST_TIME']);
                break;
            case 'canSelect':
                $where[]    = array('name' => 'gb_end_time', 'oper' => '>', 'value' => $_SERVER['REQUEST_TIME']);
                break;
        }
        return $where;
    }

    /*
     * 通过活动ID获取活动及商品信息
     */
    public function fetchGroupGoods($gid) {
        $where[]    = array('name' => 'gb.gb_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gb.gb_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_df , 'oper' => '=', 'value' => 0);

        $sql    = "SELECT gb.*,g.* FROM `{$this->curr_table}` AS gb LEFT JOIN `{$this->goods_table}` AS g ON gb.gb_g_id=g.g_id ";
        $sql    .= $this->formatWhereSql($where);
        $ret    = DB::fetch_first($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 培训版
     * 通过活动ID获取活动及课程信息
     */
    public function fetchCourseGroupGoods($gid) {
        $where[]    = array('name' => 'gb.gb_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gb.gb_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_df , 'oper' => '=', 'value' => 0);

        $sql    = "SELECT gb.*,atc.* FROM `{$this->curr_table}` AS gb LEFT JOIN `pre_applet_train_course` AS atc ON gb.gb_g_id=atc.atc_id ";
        $sql    .= $this->formatWhereSql($where);
        $ret    = DB::fetch_first($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 增加活动参与人数
     */
    public function incrementJoin($actid, $num = 1) {
        $field  = array('gb_joined');
        $inc    = array($num);

        $where[]    = array('name' => 'gb_id', 'oper' => '=', 'value' => $actid);
        $where[] = array('name' => $this->_df , 'oper' => '=', 'value' => 0);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
    /*
     * 通过活动id数组获取活动列表
     */
    public function fetchAddGroup(array $ids) {
        $where[]    = array('name' => 'gb.gb_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gb.gb_id', 'oper' => 'in', 'value' => $ids);
        $where[]    = array('name' => $this->_df , 'oper' => '=', 'value' => 0);

        $sql     = "SELECT gb.*,g.* FROM `{$this->curr_table}` AS gb LEFT JOIN `{$this->goods_table}` AS g ON gb.gb_g_id=g.g_id ";
        $sql    .= $this->formatWhereSql($where);

        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $type
     * @param $gpId
     * @param $index
     * @param $count
     * @return array|bool
     * 获取分组商品和未分组商品
     * type look查看 add追加分组
     * $version   新版本显示所有的活动包括结束的活动，旧版本不显示
     */
    public function getGroupGoodsWithSection($type,$gpid,$index,$count,$keyword='',$version=0){
        if($version){
            $awhere[]    = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);
        }else{
            $awhere = $this->current_where();
        }

        if($type == 'look'){
            $where = ' and agm_gg_id = '.intval($gpid);
            $sort  = array('agm_weight' => 'DESC','agm_create_time' => 'DESC');
        }else{
            $where = ' and agm_gg_id is null ';//' and (gm_gg_id is null or gm_gg_id != '.intval($gpid).')';
            if($version){
                $sort  = array('gb_sort'=>'DESC','gb_end_time' => 'DESC');
            }else{
                $sort  = array('gb_sort'=>'DESC','gb_create_time' => 'DESC');
            }
        }
        $sql = 'SELECT g.*,g.g_name as name,gb.*,agm_id,agm_weight ';
        $sql .= ' FROM `'.DB::table($this->_table).'` gb ';
        $sql .= ' LEFT JOIN pre_applet_group_match agm on agm_g_id = gb.gb_id ';
        $sql .= ' LEFT JOIN pre_goods g on g_id = gb.gb_g_id ';
        $sql .= ' LEFT JOIN pre_group_buy_section gbs on gbs.gbs_id=gb_gbs_id ';
        $sql .= $this->formatWhereSql($awhere);
        $sql .= ' and gb_deleted = 0 and  gb_s_id =  '.$this->sid . $where;
        if($keyword){
            $sql .= ' and  g_name like '.DB::quote("%{$keyword}%");
        }

        $sql .= ' GROUP BY IFNULL(gbs.gbs_id,UUID()) ';

        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * @param $type
     * @param $gpId
     * @return bool
     * 获得商品总数，用于分页
     */
    public function getCountGoods($type,$gpid,$keyword=''){
        $awhere = $this->current_where();
        if($type == 'look'){
            $where = ' and agm_gg_id = '.intval($gpid);
        }else{
            $where = ' and agm_gg_id is null ';
        }

        $sql  = ' SELECT count(*) FROM';
        $sql .= ' ( SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` gb ';
        $sql .= ' LEFT JOIN pre_applet_group_match agm ON agm_g_id = gb.gb_id ';
        $sql .= ' LEFT JOIN pre_goods g on g_id = gb.gb_g_id ';
        $sql .= $this->formatWhereSql($awhere);
        $sql .= ' and gb_deleted = 0 and gb_s_id =  '.$this->sid . $where;
        if($keyword){
            $sql .= ' and  g_name like '.DB::quote("%{$keyword}%");
        }
        $sql .= ' GROUP BY gb_id ';
        $sql .= ') temp';

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $type
     * @param $gpId
     * @return bool
     * 获得商品总数，用于分页
     */
    public function getCountGoodsWithSection($type,$gpid,$keyword=''){
        $awhere = $this->current_where();
        if($type == 'look'){
            $where = ' and agm_gg_id = '.intval($gpid);
        }else{
            $where = ' and agm_gg_id is null ';
        }

        $sql  = ' SELECT count(*) FROM';
        $sql .= ' ( SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` gb ';
        $sql .= ' LEFT JOIN pre_applet_group_match agm ON agm_g_id = gb.gb_id ';
        $sql .= ' LEFT JOIN pre_goods g on g_id = gb.gb_g_id ';
        $sql .= ' LEFT JOIN pre_group_buy_section gbs on gbs.gbs_id=gb_gbs_id ';
        $sql .= $this->formatWhereSql($awhere);
        $sql .= ' and gb_deleted = 0 and gb_s_id =  '.$this->sid . $where;
        if($keyword){
            $sql .= ' and  g_name like '.DB::quote("%{$keyword}%");
        }
        $sql .= ' GROUP BY IFNULL(gbs.gbs_id,UUID()) ';
        $sql .= ') temp';

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCourseList($where,$index,$count,$sort=array('gb_update_time' => 'DESC'),$keyfield=''){
        $where[] = array('name' => $this->_df , 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT gb.*,atc.* ';
        $sql .= ' FROM `'.$this->curr_table.'` gb ';
        $sql .= ' LEFT JOIN '.$this->course_table.' atc on  atc.atc_id=gb_g_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql,array(),$keyfield);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCourseCount($where){
        $where[] = array('name' => $this->_df , 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT count(*) ';
        $sql .= ' FROM `'.$this->curr_table.'` gb ';
        $sql .= ' LEFT JOIN '.$this->course_table.' atc on  atc.atc_id=gb_g_id ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $type
     * @param $gpId
     * @param $index
     * @param $count
     * @return array|bool
     * 获取分组商品和未分组商品
     * type look查看 add追加分组
     * $version   新版本显示所有的活动包括结束的活动，旧版本不显示
     */
    public function getGroupCourse($type,$gpid,$index,$count,$keyword='',$version=0){
        if($version){
            $awhere[]    = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);
        }else{
            $awhere = $this->current_where();
        }

        if($type == 'look'){
            $where = ' and agm_gg_id = '.intval($gpid);
            $sort  = array('agm_weight' => 'DESC','agm_create_time' => 'DESC');
        }else{
            $where = ' and agm_gg_id is null ';//' and (gm_gg_id is null or gm_gg_id != '.intval($gpid).')';
            if($version){
                $sort  = array('gb_sort'=>'DESC','gb_end_time' => 'DESC');
            }else{
                $sort  = array('gb_sort'=>'DESC','gb_create_time' => 'DESC');
            }
        }
        $sql = 'SELECT atc.*,atc.atc_title as name,gb.*,agm_id,agm_weight ';
        $sql .= ' FROM `'.DB::table($this->_table).'` gb ';
        $sql .= ' LEFT JOIN pre_applet_group_match agm on agm_g_id = gb.gb_id ';
        $sql .= ' LEFT JOIN pre_applet_train_course atc on atc_id = gb.gb_g_id ';
        $sql .= $this->formatWhereSql($awhere);
        $sql .= ' and gb_deleted = 0 and  gb_s_id =  '.$this->sid . $where;
        if($keyword){
            $sql .= ' and  atc_title like '.DB::quote("%{$keyword}%");
        }

        $sql .= ' GROUP BY gb_id ';

        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $type
     * @param $gpId
     * @param $index
     * @param $count
     * @return array|bool
     * 获取分组商品和未分组商品
     * type look查看 add追加分组
     * $version   新版本显示所有的活动包括结束的活动，旧版本不显示
     */
    public function getGroupCourseWithSection($type,$gpid,$index,$count,$keyword='',$version=0){
        if($version){
            $awhere[]    = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);
        }else{
            $awhere = $this->current_where();
        }

        if($type == 'look'){
            $where = ' and agm_gg_id = '.intval($gpid);
            $sort  = array('agm_weight' => 'DESC','agm_create_time' => 'DESC');
        }else{
            $where = ' and agm_gg_id is null ';//' and (gm_gg_id is null or gm_gg_id != '.intval($gpid).')';
            if($version){
                $sort  = array('gb_sort'=>'DESC','gb_end_time' => 'DESC');
            }else{
                $sort  = array('gb_sort'=>'DESC','gb_create_time' => 'DESC');
            }
        }
        $sql = 'SELECT atc.*,atc.atc_title as name,gb.*,agm_id,agm_weight ';
        $sql .= ' FROM `'.DB::table($this->_table).'` gb ';
        $sql .= ' LEFT JOIN pre_applet_group_match agm on agm_g_id = gb.gb_id ';
        $sql .= ' LEFT JOIN pre_applet_train_course atc on atc_id = gb.gb_g_id ';
        $sql .= ' LEFT JOIN pre_group_buy_section gbs on gbs.gbs_id=gb_gbs_id ';
        $sql .= $this->formatWhereSql($awhere);
        $sql .= ' and gb_deleted = 0 and  gb_s_id =  '.$this->sid . $where;
        if($keyword){
            $sql .= ' and  atc_title like '.DB::quote("%{$keyword}%");
        }

        $sql .= ' GROUP BY IFNULL(gbs.gbs_id,UUID()) ';

        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $type
     * @param $gpId
     * @param $index
     * @param $count
     * @return array|bool
     * 获取分组商品和未分组商品
     * type look查看 add追加分组
     * $version   新版本显示所有的活动包括结束的活动，旧版本不显示
     */
    public function getGroupGoods($type,$gpid,$index,$count,$keyword='',$version=0){
        if($version){
            $awhere[]    = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);
        }else{
            $awhere = $this->current_where();
        }

        if($type == 'look'){
            $where = ' and agm_gg_id = '.intval($gpid);
            $sort  = array('agm_weight' => 'DESC','agm_create_time' => 'DESC');
        }else{
            $where = ' and agm_gg_id is null ';//' and (gm_gg_id is null or gm_gg_id != '.intval($gpid).')';
            if($version){
                $sort  = array('gb_sort'=>'DESC','gb_end_time' => 'DESC');
            }else{
                $sort  = array('gb_sort'=>'DESC','gb_create_time' => 'DESC');
            }
        }
        $sql = 'SELECT g.*,g.g_name as name,gb.*,agm_id,agm_weight ';
        $sql .= ' FROM `'.DB::table($this->_table).'` gb ';
        $sql .= ' LEFT JOIN pre_applet_group_match agm on agm_g_id = gb.gb_id ';
        $sql .= ' LEFT JOIN pre_goods g on g_id = gb.gb_g_id ';
        $sql .= $this->formatWhereSql($awhere);
        $sql .= ' and gb_deleted = 0 and  gb_s_id =  '.$this->sid . $where;
        if($keyword){
            $sql .= ' and  g_name like '.DB::quote("%{$keyword}%");
        }

        $sql .= ' GROUP BY gb_id ';

        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCountCourse($type,$gpid,$keyword=''){
        $awhere = $this->current_where();
        if($type == 'look'){
            $where = ' and agm_gg_id = '.intval($gpid);
        }else{
            $where = ' and agm_gg_id is null ';
        }

        $sql  = ' SELECT count(*) FROM';
        $sql .= ' ( SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` gb ';
        $sql .= ' LEFT JOIN pre_applet_group_match agm ON agm_g_id = gb.gb_id ';
        $sql .= ' LEFT JOIN pre_applet_train_course atc on atc_id = gb.gb_g_id ';
        $sql .= $this->formatWhereSql($awhere);
        $sql .= ' and gb_deleted = 0 and gb_s_id =  '.$this->sid . $where;
        if($keyword){
            $sql .= ' and  atc_title like '.DB::quote("%{$keyword}%");
        }
        $sql .= ' GROUP BY gb_id ';
        $sql .= ') temp';

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /**
     * @param $type
     * @param $gpId
     * @return bool
     * 获得商品总数，用于分页
     */
    public function getCountCourseWithSection($type,$gpid,$keyword=''){
        $awhere = $this->current_where();
        if($type == 'look'){
            $where = ' and agm_gg_id = '.intval($gpid);
        }else{
            $where = ' and agm_gg_id is null ';
        }

        $sql  = ' SELECT count(*) FROM';
        $sql .= ' ( SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` gb ';
        $sql .= ' LEFT JOIN pre_applet_group_match agm ON agm_g_id = gb.gb_id ';
        $sql .= ' LEFT JOIN pre_applet_train_course atc on atc_id = gb.gb_g_id ';
        $sql .= ' LEFT JOIN pre_group_buy_section gbs on gbs.gbs_id=gb_gbs_id ';
        $sql .= $this->formatWhereSql($awhere);
        $sql .= ' and gb_deleted = 0 and gb_s_id =  '.$this->sid . $where;
        if($keyword){
            $sql .= ' and  atc_title like '.DB::quote("%{$keyword}%");
        }
        $sql .= ' GROUP BY IFNULL(gbs.gbs_id,UUID()) ';
        $sql .= ') temp';

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 通过活动ID获取活动及商品信息
     */
    public function fetchGroupCourse($gid) {
        $where[]    = array('name' => 'gb.gb_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gb.gb_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_df , 'oper' => '=', 'value' => 0);

        $sql    = "SELECT gb.*,atc.* FROM `{$this->curr_table}` AS gb LEFT JOIN `{$this->course_table}` AS atc ON gb.gb_g_id=atc.atc_id ";
        $sql    .= $this->formatWhereSql($where);
        Libs_Log_Logger::outputLog($sql);
        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 增减活动浏览量
     */
    public function incrementViewNum($gbid, $num=1) {
        $field  = array('gb_view_num');
        $inc    = array($num);

        $where[]    = array('name' => 'gb_id', 'oper' => '=', 'value' => $gbid);
        $where[]    = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 获取所有进行中的活动
     */
    public function getRunningActCount($esId=0) {
        $curr	= time();
        if($esId){
            $where[]	= array('name' => 'gb_es_id', 'oper' => '=', 'value' => $esId);
        }
        $where[]	= array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]	= array('name' => 'gb_start_time', 'oper' => '<', 'value' => $curr);
        $where[]	= array('name' => 'gb_end_time', 'oper' => '>', 'value' => $curr);
        return $this->getCount($where);
    }
}