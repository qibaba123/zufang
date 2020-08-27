<?php

class App_Model_Limit_MysqlLimitActStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $course_table;
    public function __construct($sid = null){
        $this->_table 	= 'limit_act';
        $this->_pk 		= 'la_id';
        $this->_shopId 	= 'la_s_id';
        $this->_df		= 'la_deleted';
        parent::__construct();

        $this->sid      = $sid;
        $this->course_table = 'applet_train_course';
    }

    /*
     * 获取所有进行中的活动
     */
    public function getAllRunningAct($esId=0) {
        $curr	= time();
        if($esId){
            $where[]	= array('name' => 'la_es_id', 'oper' => '=', 'value' => $esId);
        }

        $where[]	= array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]	= array('name' => 'la_start_time', 'oper' => '<', 'value' => $curr);
        $where[]	= array('name' => 'la_end_time', 'oper' => '>', 'value' => $curr);
        $sort	= array('la_create_time' => 'DESC');
        return $this->getList($where, 0, 50, $sort);
    }

    /*
     * 获取所有进行中的活动和活动id
     */
    public function getAllRunningGoodsAct() {
        $curr	= time();
        $where[]	= array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $where[]	= array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]	= array('name' => 'la_start_time', 'oper' => '<', 'value' => $curr);
        $where[]	= array('name' => 'la_end_time', 'oper' => '>', 'value' => $curr);
        $sql = "select lg_g_id,la.la_id";
        $sql .= " from `".DB::table($this->_table)."` as la";
        $sql .= " join `pre_limit_goods` as lg on la.la_id = lg.lg_actid ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据活动id获取活动
     */
    public function getRowUpdateById($id,$data=array()) {
        $where[]	= array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]	= array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        if(!empty($data)){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }
    }

    /**
     * 获取店铺进行中和未开始的活动
     * $version
     */
    public function getAllRunningNotBeginAct($where = array(),$version=0) {
        $curr	= time();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        if(!$version){
            $where[] = array('name' => 'la_end_time', 'oper' => '>', 'value' => $curr);
            $sort	 = array('la_start_time' => 'ASC','la_create_time' => 'DESC');
        }else{
            $sort	 = array('la_end_time' => 'DESC');
        }

        return $this->getList($where, 0, 50, $sort);
    }

    /**
     * 获取店铺进行中和未开始的活动商品
     * update 添加一个可以自定义排序的规则
     * zhangzc
     * 2019-09-26
     */
    public function getAllRunningNotBeginActGoods($where=array(), $index, $count, $keyword='',$sort=[]){
        $curr	= time();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'la_end_time', 'oper' => '>', 'value' => $curr);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
       // if(!isset($sort))
         //   $sort	 = array('la_start_time' => 'ASC','la_create_time' => 'DESC');
        if(!$sort){
            $sort	 = array('la_start_time' => 'ASC','la_create_time' => 'DESC');
        }

        $sql = 'SELECT g.*,la.*,lg.lg_g_id ';
        $sql .= ' FROM `'.DB::table($this->_table).'` la ';
        $sql .= ' LEFT JOIN pre_limit_goods lg on lg_actid = la.la_id ';
        $sql .= ' LEFT JOIN pre_goods g on g_id = lg.lg_g_id ';
        $sql .= $this->formatWhereSql($where);
        if($keyword){
            $sql .= ' and  g_name like '.DB::quote("%{$keyword}%");
        }

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
     * 获取店铺已结束的活动商品
     */
    public function getAllEndActGoods($where=array(), $index, $count){
        $curr	= time();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'la_end_time', 'oper' => '<', 'value' => $curr);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sort	 = array('la_start_time' => 'ASC','la_create_time' => 'DESC');

        $sql = 'SELECT g.*,la.*,lg.lg_g_id ';
        $sql .= ' FROM `'.DB::table($this->_table).'` la ';
        $sql .= ' LEFT JOIN pre_limit_goods lg on lg_actid = la.la_id ';
        $sql .= ' LEFT JOIN pre_goods g on g_id = lg.lg_g_id ';
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

    /**
     * 获取店铺进行中和未开始的活动商品
     */
    public function getAllRunningNotBeginActGoodsCount($where=array(), $keyword=''){
        $curr	= time();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'la_end_time', 'oper' => '>', 'value' => $curr);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);

        $sql = 'SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` la ';
        $sql .= ' LEFT JOIN pre_limit_goods lg on lg_actid = la.la_id ';
        $sql .= ' LEFT JOIN pre_goods g on g_id = lg.lg_g_id ';
        $sql .= $this->formatWhereSql($where);
        if($keyword){
            $sql .= ' and  g_name like '.DB::quote("%{$keyword}%");
        }

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取店铺进行中和未开始的活动商品
     */
    public function getAllRunningNotBeginActCourseCount($where=array(), $keyword=''){
        $curr	= time();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'la_end_time', 'oper' => '>', 'value' => $curr);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);

        $sql = 'SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` la ';
        $sql .= ' LEFT JOIN pre_limit_goods lg on lg_actid = la.la_id ';
        $sql .= ' LEFT JOIN '.DB::table($this->course_table).' atc on atc_id = lg.lg_g_id ';
        $sql .= $this->formatWhereSql($where);
        if($keyword){
            $sql .= ' and  atc_title like '.DB::quote("%{$keyword}%");
        }

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 培训用
     * 获取店铺进行中和未开始的活动课程
     */
    public function getAllRunningNotBeginActCourse($where=array(), $index, $count, $keyword=''){
        $curr	= time();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'la_end_time', 'oper' => '>', 'value' => $curr);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sort	 = array('la_start_time' => 'ASC','la_create_time' => 'DESC');

        $sql = 'SELECT atc.*,la.* ';
        $sql .= ' FROM `'.DB::table($this->_table).'` la ';
        $sql .= ' LEFT JOIN pre_limit_goods lg on lg_actid = la.la_id ';
        $sql .= ' LEFT JOIN '.DB::table($this->course_table).' atc on atc_id = lg.lg_g_id ';
        $sql .= $this->formatWhereSql($where);
        if($keyword){
            $sql .= ' and  atc_title like '.DB::quote("%{$keyword}%");
        }

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
     * 培训用
     * 获取店铺已结束的活动课程
     */
    public function getAllEndActCourse($where=array(), $index, $count){
        $curr	= time();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'la_end_time', 'oper' => '<', 'value' => $curr);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sort	 = array('la_start_time' => 'ASC','la_create_time' => 'DESC');

        $sql = 'SELECT atc.*,la.* ';
        $sql .= ' FROM `'.DB::table($this->_table).'` la ';
        $sql .= ' LEFT JOIN pre_limit_goods lg on lg_actid = la.la_id ';
        $sql .= ' LEFT JOIN '.DB::table($this->course_table).' atc on atc_id = lg.lg_g_id ';
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

    /**
     * 获取所有正在进行中的商品id
     */
    public function  getActGoodsList($start, $end){
        $curr	= time();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'la_end_time', 'oper' => '>', 'value' => $curr);
        $where[] = array('name' => 'la_deleted', 'oper' => '=', 'value' => 0);
        $sql = "select lg_g_id";
        $sql .= " from `".DB::table($this->_table)."` as la";
        $sql .= " join `pre_limit_goods` as lg on la.la_id = lg.lg_actid ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " and ((la.la_start_time>".$start." and la.la_start_time<".$end.")";
        $sql .= " or (la.la_start_time<".$start." and la.la_end_time>".$end.")";
        $sql .= " or (la.la_end_time>".$start." and la.la_end_time<".$end."))";
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取已开抢的正在进行中的商品
     */
    public function getHadActGoodsList($time, $index, $count){
        $curr	 = time();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'la_start_time', 'oper' => '<', 'value' => $time);
        $where[] = array('name' => 'la_end_time', 'oper' => '>', 'value' => $curr);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sort	 = array('la_start_time' => 'ASC','la_create_time' => 'DESC');

        $sql = 'SELECT g.*,la.* ';
        $sql .= ' FROM `'.DB::table($this->_table).'` la ';
        $sql .= ' LEFT JOIN pre_limit_goods lg on lg_actid = la.la_id ';
        $sql .= ' LEFT JOIN pre_goods g on g_id = lg.lg_g_id ';
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

    /**
     * 获取已开抢的正在进行中的商品
     */
    public function getActingGoodsList($time, $index, $count){
        $curr	 = time();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'la_start_time', 'oper' => '>', 'value' => $time);
        $where[] = array('name' => 'la_start_time', 'oper' => '<', 'value' => $curr);
        $where[] = array('name' => 'la_end_time', 'oper' => '>', 'value' => $curr);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sort	 = array('la_start_time' => 'ASC','la_create_time' => 'DESC');

        $sql = 'SELECT g.*,la.* ';
        $sql .= ' FROM `'.DB::table($this->_table).'` la ';
        $sql .= ' LEFT JOIN pre_limit_goods lg on lg_actid = la.la_id ';
        $sql .= ' LEFT JOIN pre_goods g on g_id = lg.lg_g_id ';
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

    /**
     * 获取即将抢购的商品
     */
    public function getPreActGoodsList($time, $index, $count){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'la_start_time', 'oper' => '=', 'value' => $time);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sort	 = array('la_start_time' => 'ASC','la_create_time' => 'DESC');

        $sql = 'SELECT g.*,la.* ';
        $sql .= ' FROM `'.DB::table($this->_table).'` la ';
        $sql .= ' LEFT JOIN pre_limit_goods lg on lg_actid = la.la_id ';
        $sql .= ' LEFT JOIN pre_goods g on g_id = lg.lg_g_id ';
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

    /**
     * @param array $where
     * @param string $type  1、noStart 未开始；2、ing 进行中；3、end 已结束；4、 canSelect，未结束的（包含未开始，进行中）
     * @return array
     */
    private function current_where($where=array(),$type='canSelect'){
        $where[]    = array('name' => 'la_s_id', 'oper' => '=', 'value' => $this->sid);
        switch($type){
            case 'noStart':
                $where[]    = array('name' => 'la_start_time', 'oper' => '>', 'value' => $_SERVER['REQUEST_TIME']);
                break;
            case 'ing':
                $where[]    = array('name' => 'la_start_time', 'oper' => '<=', 'value' => $_SERVER['REQUEST_TIME']);
                $where[]    = array('name' => 'la_end_time', 'oper' => '>', 'value' => $_SERVER['REQUEST_TIME']);
                break;
            case 'end':
                $where[]    = array('name' => 'la_end_time', 'oper' => '<', 'value' => $_SERVER['REQUEST_TIME']);
                break;
            case 'canSelect':
                $where[]    = array('name' => 'la_end_time', 'oper' => '>', 'value' => $_SERVER['REQUEST_TIME']);
                break;
        }
        return $where;
    }


    /**
     * @param $type
     * @param $gpId
     * @param $index
     * @param $count
     * @return array|bool
     * 获取分组商品和未分组商品
     * type look查看 add追加分组
     */
    public function getGroupGoods($type,$gpid,$index,$count,$keyword=''){
        $awhere = $this->current_where();
        if($type == 'look'){
            $where = ' and algm_gg_id = '.intval($gpid);
            $sort  = array('algm_weight' => 'DESC','algm_create_time' => 'DESC');
        }else{
            $where = ' and algm_gg_id is null ';//' and (gm_gg_id is null or gm_gg_id != '.intval($gpid).')';
            $sort  = array('la_create_time' => 'DESC');
        }
        $sql = 'SELECT g.*,la.*,algm.* ';
        $sql .= ' FROM `'.DB::table($this->_table).'` la ';
        $sql .= ' LEFT JOIN pre_limit_goods lg on lg_actid = la.la_id ';
        $sql .= ' LEFT JOIN pre_goods g on g_id = lg.lg_g_id ';
        $sql .= ' LEFT JOIN pre_applet_limit_group_match algm on algm_g_id = lg_g_id';
        $sql .= $this->formatWhereSql($awhere);
        $sql .= ' and g_id > 0 and la_deleted = 0' . $where;
        if($keyword){
            $sql .= ' and  g_name like '.DB::quote("%{$keyword}%");
        }

        $sql .= ' GROUP BY g_id ';

        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        Libs_Log_Logger::outputLog($sql);
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
            $where = ' and algm_gg_id = '.intval($gpid);
        }else{
            $where = ' and algm_gg_id is null ';
        }

        $sql  = ' SELECT count(*) FROM';
        $sql .= ' ( SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` la ';
        $sql .= ' LEFT JOIN pre_limit_goods lg on lg_actid = la.la_id ';
        $sql .= ' LEFT JOIN pre_goods g on g_id = lg.lg_g_id ';
        $sql .= ' LEFT JOIN pre_applet_limit_group_match algm on algm_g_id = lg_g_id';
        $sql .= $this->formatWhereSql($awhere);
        $sql .= ' and g_id > 0 and la_deleted = 0'. $where;
        if($keyword){
            $sql .= ' and  g_name like '.DB::quote("%{$keyword}%");
        }

        $sql .= ' GROUP BY g_id ';
        $sql .= ') temp';

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 培训用
     * @param $type
     * @param $gpId
     * @param $index
     * @param $count
     * @return array|bool
     * 获取分组课程和未分组课程
     * type look查看 add追加分组
     */
    public function getGroupCourse($type,$gpid,$index,$count,$keyword=''){
        $awhere = $this->current_where();
        if($type == 'look'){
            $where = ' and algm_gg_id = '.intval($gpid);
            $sort  = array('algm_weight' => 'DESC','algm_create_time' => 'DESC');
        }else{
            $where = ' and algm_gg_id is null ';//' and (gm_gg_id is null or gm_gg_id != '.intval($gpid).')';
            $sort  = array('la_create_time' => 'DESC');
        }
        $sql = 'SELECT atc.*,atc.atc_title as g_name,atc.atc_id as g_id,atc.atc_cover as g_cover,la.*,algm.* ';
        $sql .= ' FROM `'.DB::table($this->_table).'` la ';
        $sql .= ' LEFT JOIN pre_limit_goods lg on lg_actid = la.la_id ';
        $sql .= ' LEFT JOIN '.DB::table($this->course_table).' atc on atc_id = lg.lg_g_id ';
        $sql .= ' LEFT JOIN pre_applet_limit_group_match algm on algm_g_id = lg_g_id';
        $sql .= $this->formatWhereSql($awhere);
        $sql .= ' and atc_id > 0 and la_deleted = 0' . $where;
        if($keyword){
            $sql .= ' and  atc_title like '.DB::quote("%{$keyword}%");
        }

        $sql .= ' GROUP BY atc_id ';

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
     * 培训用
     * @param $type
     * @param $gpId
     * @return bool
     * 获得课程总数，用于分页
     */
    public function getCountCourse($type,$gpid,$keyword=''){
        $awhere = $this->current_where();
        if($type == 'look'){
            $where = ' and algm_gg_id = '.intval($gpid);
        }else{
            $where = ' and algm_gg_id is null ';
        }

        $sql  = ' SELECT count(*) FROM';
        $sql .= ' ( SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` la ';
        $sql .= ' LEFT JOIN pre_limit_goods lg on lg_actid = la.la_id ';
        $sql .= ' LEFT JOIN '.DB::table($this->course_table).' atc on atc_id = lg.lg_g_id ';
        $sql .= ' LEFT JOIN pre_applet_limit_group_match algm on algm_g_id = lg_g_id';
        $sql .= $this->formatWhereSql($awhere);
        $sql .= ' and atc_id > 0 and la_deleted = 0'. $where;
        if($keyword){
            $sql .= ' and  atc_title like '.DB::quote("%{$keyword}%");
        }

        $sql .= ' GROUP BY atc_id ';
        $sql .= ') temp';

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /*
     * 获取所有进行中的活动
     */
    public function getRunningActCount($esId=0) {
        $curr	= time();
        if($esId){
            $where[]	= array('name' => 'la_es_id', 'oper' => '=', 'value' => $esId);
        }
        $where[]	= array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]	= array('name' => 'la_start_time', 'oper' => '<', 'value' => $curr);
        $where[]	= array('name' => 'la_end_time', 'oper' => '>', 'value' => $curr);
        return $this->getCount($where);
    }

}