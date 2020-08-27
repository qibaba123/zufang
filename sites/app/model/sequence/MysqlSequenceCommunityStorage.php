<?php
/*
 * 爆品分销 小区表
 */
class App_Model_Sequence_MysqlSequenceCommunityStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $member_table;
    private $leader_table;
    private $activity_community;
    private $area_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_community';
        $this->_pk = 'asc_id';
        $this->_shopId = 'asc_s_id';
        $this->_df = 'asc_deleted';
        $this->sid = $sid;
        $this->member_table = DB::table('member');
        $this->leader_table = DB::table('applet_sequence_leader');
        $this->activity_community = DB::table('applet_sequence_activity_community');
        $this->area_table = DB::table('applet_sequence_area');
    }

    // 根据距离排序店铺信息
    public function getCommunityListDistance($where,$index,$count,$sort,$lng,$lat){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql  = ' SELECT asct.*,asl.asl_name,asl.asl_m_id,asl.asl_mobile,m.m_avatar,m.m_nickname,asa.asa_city,asa.asa_id,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-asc_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(asc_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-asc_lat)/360),2)))) distance ';
        $sql .= " from `".DB::table($this->_table)."` asct ";
       // $sql .= " left join `pre_applet_sequence_leader_community` aslc on aslc.aslc_community = asct.asc_id ";
        $sql .= " left join `pre_applet_sequence_leader` asl on asct.asc_leader = asl.asl_id ";
        $sql .= " left join `pre_applet_sequence_area` asa on asct.asc_area = asa.asa_id ";
//        $sql.=  ' LEFT JOIN `dpl_china_address` AS addr1 on addr1.region_id=asa.asa_city ';
        $sql .= " left join `pre_member` m on asl.asl_m_id = m.m_id ";
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

    public function getCommunityListDistanceRange($range,$where,$index,$count,$sort,$lng,$lat){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql  = 'SELECT * FROM (';
        $sql  .= ' SELECT asct.*,asl.asl_name,asl.asl_m_id,asl.asl_mobile,m.m_avatar,m.m_nickname,asa.asa_city,asa.asa_id,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-asc_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(asc_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-asc_lat)/360),2)))) distance ';
        $sql .= " from `".DB::table($this->_table)."` asct ";
        // $sql .= " left join `pre_applet_sequence_leader_community` aslc on aslc.aslc_community = asct.asc_id ";
        $sql .= " left join `pre_applet_sequence_leader` asl on asct.asc_leader = asl.asl_id ";
        $sql .= " left join `pre_applet_sequence_area` asa on asct.asc_area = asa.asa_id ";
//        $sql.=  ' LEFT JOIN `dpl_china_address` AS addr1 on addr1.region_id=asa.asa_city ';
        $sql .= " left join `pre_member` m on asl.asl_m_id = m.m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= ' ) as a ';
        $sql .= " where distance <= {$range} ";
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    // 根据距离排序店铺信息
    /*
    public function getCommunityListDistanceNew($where,$index,$count,$sort,$lng,$lat){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql  = ' SELECT asct.*,asl.asl_name,asl.asl_m_id,asl.asl_mobile,m.m_avatar,m.m_nickname,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-asc_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(asc_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-asc_lat)/360),2)))) distance ';
        $sql .= " from `".DB::table($this->_table)."` asct ";
//        $sql .= " left join `pre_applet_sequence_leader_community` aslc on aslc.aslc_community = asct.asc_id ";
        $sql .= " left join `pre_applet_sequence_leader` asl on asct.asc_leader = asl.asl_id ";
        $sql .= " left join `pre_member` m on asl.asl_m_id = m.m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }*/

    /*
     * 获得小区列表 关联团长表
     */
    public function getCommunityLeaderList($where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql = "SELECT asct.*,asl.*,asa.*,m.m_nickname,m.m_avatar,m.m_show_id ";
        $sql .= " FROM ".DB::table($this->_table)." asct ";
        $sql .= " LEFT JOIN ".$this->leader_table." asl on asl.asl_id=asct.asc_leader ";
        $sql .= " LEFT JOIN ".$this->area_table." asa on asa.asa_id=asct.asc_area ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asl.asl_m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCommunityLeaderRow($id){
        $where = [];
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $where[] = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
//        $where[] = array('name' => 'asc_status', 'oper' => '=', 'value' => 2);
        $sql = "SELECT asct.*,asl.*,asa.*,m.m_nickname,m.m_avatar,m.m_show_id ";
        $sql .= " FROM ".DB::table($this->_table)." asct ";
        $sql .= " LEFT JOIN ".$this->leader_table." asl on asl.asl_id=asct.asc_leader ";
        $sql .= " LEFT JOIN ".$this->area_table." asa on asa.asa_id=asct.asc_area ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asl.asl_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCommunityLeaderCount($where){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." asct ";
        $sql .= " LEFT JOIN ".$this->leader_table." asl on asl.asl_id=asct.asc_leader ";
        $sql .= " LEFT JOIN ".$this->area_table." asa on asa.asa_id=asct.asc_area ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asl.asl_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得小区列表 关联社区团购活动小区表
     */
    public function getListSequence($aid,$where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql = "SELECT * ";
        $sql .= " FROM ".DB::table($this->_table)." asct ";
        $sql .= " LEFT JOIN ".$this->activity_community." asac on asct.asc_id=asac.asac_c_id and asac.asac_a_id = {$aid} ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }




    public function getCountSequence($aid,$where){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." asct ";
        $sql .= " LEFT JOIN ".$this->activity_community." asac on asct.asc_id=asac.asac_c_id and asac.asac_a_id = {$aid}";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得小区列表 关联社区团购活动小区表
     * @param $is_area  如果是社区团购的区域管理员的话-限制可查看的小区
     */
    public function getListGoods($gid,$where,$index,$count,$sort,$is_area=false){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql = "SELECT * ";
        $sql .= " FROM ".DB::table($this->_table)." asct ";
        $sql .= " LEFT JOIN `pre_applet_sequence_goods_community` asgc on asct.asc_id=asgc.asgc_c_id and asgc.asgc_g_id = {$gid} ";
        if($is_area){
            $sql.='LEFT JOIN `pre_applet_sequence_area` ON `asa_id`=`asc_area`';
        }
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得小区列表 关联社区团购活动小区表
     * @param $is_area  如果是社区团购的区域管理员的话-限制可查看的小区
     */
    public function getCountGoods($gid,$where,$join='LEFT',$is_area=false){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." asct ";
        $sql .= $join." JOIN `pre_applet_sequence_goods_community` asgc on asct.asc_id=asgc.asgc_c_id and asgc.asgc_g_id = {$gid} ";
        if($is_area){
            $sql.='LEFT JOIN `pre_applet_sequence_area` ON `asa_id`=`asc_area`';
        }
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 设置指定字段自增或自减
     */
    public function incrementRiderField($id,$num,$field) {
        $fields  = array($field);
        $inc    = array($num);

        $where[]    = array('name' => 'asc_id', 'oper' => '=', 'value' => $id);

        $sql = $this->formatIncrementSql($fields, $inc, $where);
        return DB::query($sql);
    }

    /**
     * 获取指定城市下的所有的社区-数量
     * @return [type] [description]
     */
    public function getCommunityCountByArea($city_id,$area_type='C'){
        $sql=sprintf('SELECT COUNT(*) as total FROM %s 
            LEFT JOIN %s on asc_area=asa_id',
            DB::table($this->_table),
            'pre_applet_sequence_area');
        $where=[
           
            ['name' => $this->_df, 'oper' => '=', 'value' => 0],
            ['name'=> $this->_shopId,'oper'=>'=','value'=>$this->sid]
        ];
        if($area_type=='C')
             $where[]=['name'=>'asa_city','oper'=>'=','value'=>$city_id];
        else if($area_type=='D')
            $where[]=['name'=>'asa_zone','oper'=>'=','value'=>$city_id];
        $sql.=$this->formatWhereSql($where);
        $res= DB::result_first($sql);
        if($res === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $res;
    }
    /**
     * 根据城市id 获取该城市下的所有的小区
     * @param  [type] $city_id [description]
     * @return [type]          [description]
     */
    public function getCommunitysListByArea($city_id,$area_type='C'){
         $sql=sprintf('SELECT `asc_id`,`asc_name`  FROM %s 
            LEFT JOIN %s on asc_area=asa_id',
            DB::table($this->_table),
            'pre_applet_sequence_area');
        $where=[
            ['name' => $this->_df, 'oper' => '=', 'value' => 0],
            ['name'=> $this->_shopId,'oper'=>'=','value'=>$this->sid],
            ['name'=> 'asc_status','oper'=>'=','value'=> 2]
        ];
        if($area_type=='C')
            $where[]=['name'=>'asa_city','oper'=>'=','value'=>$city_id];
        else if($area_type=='D')
             $where[]=['name'=>'asa_zone','oper'=>'=','value'=>$city_id];
        $sql.=$this->formatWhereSql($where);
        $res= DB::fetch_all($sql);
        if($res === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $res;
    }


    /**
     * 获取指定城市下的团长的数量
     * @return [type] [description]
     */
    public function getLeaderCountByArea($city_id,$area_type='C'){
         $sql=sprintf('SELECT COUNT(*) as total FROM %s 
            LEFT JOIN %s on asc_area=asa_id',
            DB::table($this->_table),
            'pre_applet_sequence_area');
        $where=[
            ['name' => $this->_df, 'oper' => '=', 'value' => 0],
            ['name'=> $this->_shopId,'oper'=>'=','value'=>$this->sid],
            ['name'=>'asc_leader','oper'=>'>','value'=>0]
        ];
        if($area_type=='C')
            $where[]=['name'=>'asa_city','oper'=>'=','value'=>$city_id];
        else if($area_type=='D')
             $where[]=['name'=>'asa_zone','oper'=>'=','value'=>$city_id];
        $sql.=$this->formatWhereSql($where);
        $res= DB::result_first($sql);
        if($res === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $res;
    }

  /**
   * 区域管理合伙人查看当前小区是否属于
   * @param  [type] $city_id      [城市id]
   * @param  [type] $community_id [社区id]
   * @return [type]               [description]
   */
    public function checkCommunityIsMine($city_id,$community_id,$area_type='C'){
        $sql=sprintf('SELECT COUNT(*) as total FROM %s 
            LEFT JOIN %s ON asc_area=asa_id',
            DB::table($this->_table),
            'pre_applet_sequence_area');
        
        if($area_type=='C'){
            $where=[
                ['name'=>'asa_city','oper'=>'=','value'=>$city_id],
                ['name'=>'asc_id','oper'=>'=','value'=>$community_id]
            ];
        }else if($area_type=='D'){
            $where=[
                ['name'=>'asa_zone','oper'=>'=','value'=>$city_id],
                ['name'=>'asc_id','oper'=>'=','value'=>$community_id]
            ];
        }
        $sql.=$this->formatWhereSql($where);

        $res= DB::result_first($sql);
        if($res === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $res;
    }

    /**
     * 查询社区是否有区域管理合伙人
     * @param  [type] $community_id [社区id]
     * @param  [type] $company_id [公司id]
     * @return [type]               [description]
     */
    public function checkCommunityHasRegionManager($community_id,$company_id=0,$area_type='asa_city'){
        $sql=sprintf('SELECT `m_area_id`,`m_id`,`m_area_brokerage`,`m_area_region_goods_brokerage` FROM `%s` 
            LEFT JOIN `%s` ON `asa_id`=`asc_area` 
            LEFT JOIN `%s` ON `m_area_id`=`%s` ',
            DB::table($this->_table),
            'pre_applet_sequence_area',
            'pre_manager',
            $area_type);
        $where=[
            ['name'=>'asc_id','oper'=>'=','value'=>$community_id],
            ['name'=>'m_c_id','oper'=>'=','value'=>$company_id],
            ['name'=>'m_status','oper'=>'=','value'=>0],   //增加只查询正常状态的区域合伙人
            ['name'=>'m_area_region_child','oper'=>'=','value'=>0], //区域管理员子账号标记
        ];

        $sql.=$this->formatWhereSql($where);
        $res=DB::fetch_first($sql);
        if($res === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $res;
    }

    /**
     * 获取小区名称+团长信息+配送路径
     * @param  [type]  $where [description]
     * @param  integer $index [description]
     * @param  integer $count [description]
     * @param  array   $sort  [description]
     * @return [type]         [description]
     */
    public function getCommnunityNotInRoute($where=[],$index=0,$count=20,$sort=[]){
        $sql=sprintf('SELECT `asc_id`,`asc_name`,`asc_leader`,`asl_name`,`asl_mobile` FROM `%s` 
            LEFT JOIN `pre_applet_sequence_leader` ON `asl_id`=`asc_leader` ',
            DB::table($this->_table));

        $where[]=['name'=>'asc_s_id','oper'=>'=','value'=>$this->sid];
        $where[]=['name'=>'asc_deleted','oper'=>'=','value'=>0];
        $where[]=['name'=>'asc_leader','oper'=>'>','value'=>0];
        $where[]=" `asc_id` NOT IN(SELECT `asdrt_community_id` FROM `pre_applet_sequence_delivery_route_detail` WHERE `asdrt_s_id`={$this->sid}) ";

        $sql.=$this->formatWhereSql($where);
        $sql.=$this->getSqlSort($sort);
        $sql.=$this->formatLimitSql($index,$count);
       
        $res=DB::fetch_all($sql);
        if($res===false){
            trigger_error('mysql query failed.',E_USER_ERROR);
        }
        return $res;
    }
    /**
     * 获取可以添加的小区的数量
     * @param  array  $where [description]
     * @return [type]        [description]
     */
    public function getCommnunityNotInRouteCount($where=[]){
        $sql=sprintf('SELECT COUNT(*) AS total FROM `%s` ',
            DB::table($this->_table));

        $where[]=['name'=>'asc_s_id','oper'=>'=','value'=>$this->sid];
        $where[]=['name'=>'asc_deleted','oper'=>'=','value'=>0];
        $where[]=['name'=>'asc_leader','oper'=>'>','value'=>0];
        $where[]=" `asc_id` NOT IN(SELECT `asdrt_community_id` FROM `pre_applet_sequence_delivery_route_detail` WHERE `asdrt_s_id`={$this->sid} ) ";

        $sql.=$this->formatWhereSql($where);

        $res=DB::result_first($sql);
        if($res===false){
            trigger_error('mysql query failed.',E_USER_ERROR);
        }
        return $res;
    }

    public function getCommunityAreaRow($id){
        $where = [];
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $where[] = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
//        $where[] = array('name' => 'asc_status', 'oper' => '=', 'value' => 2);
        $sql = "SELECT asct.*,asa.* ";
        $sql .= " FROM ".DB::table($this->_table)." asct ";
        $sql .= " LEFT JOIN ".$this->area_table." asa on asa.asa_id=asct.asc_area ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据小区id 查询出团长对应的区域合伙人的信息
     * @param  [type] $comId [description]
     * @return [type]        [description]
     */
    public function getSeqInfoByCommid($comId){
        $sql=sprintf('SELECT `m_area_id`,`m_id`,`m_area_brokerage`,`m_area_region_goods_brokerage` FROM `%s` 
            LEFT JOIN `%s` AS asl ON `asc_leader`=`asl_id` 
            LEFT JOIN `%s` AS pm ON `m_id`=`asl_region_manager_id` ',
            DB::table($this->_table),
            'pre_applet_sequence_leader',
            'pre_manager');
        $sql.=$this->formatWhereSql([
            ['name'=>'asc_id','oper'=>'=','value'=>$comId],
            ['name'=>'asc_s_id','oper'=>'=','value'=>$this->sid],
            ['name'=>'m_status','oper'=>'=','value'=>0], //增加只查询正常状态的区域合伙人
        ]);
        $res=DB::fetch_first($sql);
        if($res===false){
            trigger_error('mysql query failed.',E_USER_ERROR);
        }
        return $res;
    }

}