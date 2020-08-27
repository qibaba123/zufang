<?php
/*
 * 爆品分销 团长表
 */
class App_Model_Sequence_MysqlSequenceLeaderStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $member_table;
    private $manager_table;
    private $leader_manager_table;
    private $community_table;
    private $area_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_leader';
        $this->_pk = 'asl_id';
        $this->_shopId = 'asl_s_id';
        $this->_df = 'asl_deleted';
        $this->sid = $sid;
        $this->member_table = DB::table('member');
        $this->manager_table = DB::table('enter_shop_manager');
        $this->leader_manager_table = DB::table('applet_sequence_leader_manager');
        $this->community_table = DB::table('applet_sequence_community');
        $this->area_table = DB::table('applet_sequence_area');
    }

    /*
     * 获得列表 关联用户表
     */
    public function getLeaderList($where,$index,$count,$sort,$with_search=false,$join=false){
        $where[] = array('name' => 'asl.'.$this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        if($join)
            $sql = "SELECT asl.*,m.m_nickname,m.m_avatar,m.m_show_id,m.m_deduct_ktx,m.m_deduct_ytx,m.m_deduct_dsh,esm.esm_nickname,esm.esm_id,esm.esm_mobile,(m.m_deduct_ktx+m.m_deduct_ytx+m.m_deduct_dsh) as total_deduct,als2.asl_name AS recmd_man,als2.asl_id AS recmd_man_id ";
        else
             $sql = "SELECT asl.*,m.m_nickname,m.m_avatar,m.m_show_id,m.m_deduct_ktx,m.m_deduct_ytx,m.m_deduct_dsh,esm.esm_nickname,esm.esm_id,esm.esm_mobile,(m.m_deduct_ktx+m.m_deduct_ytx+m.m_deduct_dsh) as total_deduct ";
        $sql .= " FROM ".DB::table($this->_table)." asl ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asl.asl_m_id ";
        $sql .= " LEFT JOIN ".$this->leader_manager_table." aslm on aslm.aslm_leader=asl.asl_id ";
        $sql .= " LEFT JOIN ".$this->manager_table." esm on esm.esm_id=aslm.aslm_manager ";

        // 查看推荐人
        if($join)
            $sql .= " LEFT JOIN ".DB::table($this->_table)." als2 on als2.asl_id=asl.asl_parent_id ";

        if($with_search){
            $sql.=' LEFT JOIN `pre_applet_sequence_community` on asl.asl_id= asc_leader ';
            $sql.=' LEFT JOIN `pre_applet_sequence_area` on asc_area= asa_id ';
            // $sql.=' LEFT JOIN `pre_manager` as pm ON m_area_id=asa_zone ';
            $sql.='  LEFT JOIN `pre_manager` as pm ON pm.`m_id` = asl.asl_region_manager_id ';

        }

        $sql .= $this->formatWhereSql($where);

        if($with_search){
            $sql.=' GROUP BY `asl_m_id` ';
        }

        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        if($this->sid == 11055){
            Libs_Log_Logger::outputLog($sql,'zhangzc.log');
        }


        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getLeaderListCommunity($where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql = "SELECT asl.*,m.m_nickname,m.m_avatar,m.m_show_id,m.m_deduct_ktx,m.m_deduct_ytx,m.m_deduct_dsh,asct.asc_name,asct.asc_shop_name,asct.asc_address_detail,asct.asc_address ";
        $sql .= " FROM ".DB::table($this->_table)." asl ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asl.asl_m_id ";
        $sql .= " LEFT JOIN ".$this->community_table." asct on asct.asc_id=asl.asl_apply_community_id ";
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
     * 获得列表数量 关联用户表
     * @params $region 社区团购区域管理合伙人
     */
    public function getLeaderCount($where,$with_search=false){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        if($with_search)
            $sql = "SELECT COUNT(DISTINCT(asl_m_id)) as total ";
        else
            $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." asl ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asl.asl_m_id ";
        $sql .= " LEFT JOIN ".$this->leader_manager_table." aslm on aslm.aslm_leader=asl.asl_id ";
        $sql .= " LEFT JOIN ".$this->manager_table." esm on esm.esm_id=aslm.aslm_manager ";

        if($with_search){
            $sql.=' LEFT JOIN `pre_applet_sequence_community` on asl_id= asc_leader ';
            $sql.=' LEFT JOIN `pre_applet_sequence_area` on asc_area= asa_id ';
            $sql.=' LEFT JOIN `pre_manager` as pm ON m_area_id=asa_zone ';
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
     * 获得单条数据 关联用户表
     */
    public function getLeaderRow($id,$showDel = false){
        $where[] = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        if(!$showDel){
            $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        }
        $sql = "SELECT asl.*,m.m_nickname,m.m_avatar,m.m_show_id ";
        $sql .= " FROM ".DB::table($this->_table)." asl ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asl.asl_m_id ";
        //$sql .= " LEFT JOIN ".$this->member_table." pm on pm.m_id=asl.asl_parent_mid ";
        //$sql .= " LEFT JOIN ".DB::table($this->_table)." pasl on pasl.asl_id=asl.asl_parent_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得单条数据 关联用户表
     */
    public function getLeaderRowMid($mid,$showDel = false){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'asl_m_id', 'oper' => '=', 'value' => $mid);
        if(!$showDel){
            $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        }
        $sql = "SELECT asl.*,m.m_nickname,m.m_avatar,m.m_show_id ";
        $sql .= " FROM ".DB::table($this->_table)." asl ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asl.asl_m_id ";
        //$sql .= " LEFT JOIN ".$this->member_table." pm on pm.m_id=asl.asl_parent_mid ";
        //$sql .= " LEFT JOIN ".DB::table($this->_table)." pasl on pasl.asl_id=asl.asl_parent_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getRowByMid($mid){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录.
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'asl_m_id', 'oper' => '=', 'value' => $mid);
        return $this->getRow($where);
    }
    /**
     * 根据城市id获取该城市下的所有团长的id
     * @param  [type] $city_id [城市id]
     * @return [type]          [description]
     */
    public function getLeaderByCityId($city_id){
        $sql=sprintf('SELECT `asc_leader` FROM `%s` 
            LEFT JOIN `%s` ON `asc_area`=`asa_id`',
                'pre_applet_sequence_community',
                'pre_applet_sequence_area'
            );
        $where=[
            ['name'=>'asc_s_id','oper'=>'=','value'=>$this->sid],
            ['name'=>'asa_city','oper'=>'=','value'=>$city_id],
            ['name'=>'asc_deleted','oper'=>'=','value'=>0]
        ];
        $sql.=$this->formatWhereSql($where);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 社区团购-团长推荐人的总佣金累加
     * zhanzgc
     * 2019-04-25
     * @param  [type] $leader_id [description]
     * @param  [type] $money     [description]
     * @return [type]            [description]
     */
    public function incrementLeaderRecmdReward($leader_id,$money){
        $field=['asl_recmd_brokerage'];
        $inc=[$money];
        $where=[
            ['name'=>'asl_id','oper'=>'=','value'=>$leader_id],
            ['name'=>'asl_s_id','oper'=>'=','value'=>$this->sid],
        ];
        $sql=$this->formatIncrementSql($field,$inc,$where);
        return DB::query($sql);
    }

    /**
     * [getLeaderRecommendList 获取团长推荐]
     * @param  [type] $leader_id [父团长id]
     * @param  [type] $index [页码]
     * @param  [type] $count [分页数量]
     * @return [type]          [description]
     */
    public function getLeaderRecommendList($leader_id,$index=0,$count){
        $sql=sprintf('SELECT `asl_name`,`asl_mobile`,`asl_id`,`m_avatar` FROM %s 
            LEFT JOIN `pre_member` ON `m_id`=`asl_m_id` ',
            DB::table($this->_table));
        $where[]=['name'=>'asl_parent_id','oper'=>'=','value'=>$leader_id];
        $where[]=['name'=>'asl_deleted','oper'=>'=','value'=>0];
        $where[]=['name'=>'asl_status','oper'=>'=','value'=>2];
        $sql.=$this->formatWhereSql($where);
        $sql.=$this->formatLimitSql($index,$count);
        $res=DB::fetch_all($sql);
        if($res===false){
            trigger_error("query mysql failed.",E_USER_ERROR);
        }
        return $res;
    }
}