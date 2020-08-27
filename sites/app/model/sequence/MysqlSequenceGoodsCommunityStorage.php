<?php
/*
 * 社区团购 商品限制小区表
 */
class App_Model_Sequence_MysqlSequenceGoodsCommunityStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $community_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_goods_community';
        $this->_pk = 'asgc_id';
        $this->_shopId = 'asgc_s_id';
        $this->sid = $sid;
        $this->community_table = DB::table('applet_sequence_community');

    }


    /**
     * @param array $val_arr
     * @return bool
     * 批量插入数据
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`asgc_id`, `asgc_s_id`,  `asgc_g_id`, `asgc_c_id`, `asgc_sort`, `asgc_create_time`) ';
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
    * 根据商品id和小区id，查找关联信息
    */
    public function fetchRow($gid,$cid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asgc_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'asgc_c_id', 'oper' => '=', 'value' => $cid);

        return $this->getRow($where);
    }

    /*
     * 根据商品id获得关联信息
     */
    public function getListByGidAction($gid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asgc_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    =array('name' => 'asc_deleted', 'oper' => '=', 'value' => 0);
        $sort = ['asgc_id'=>'DESC'];
        $sql = "select asgc.*,asct.asc_id ";
        $sql .= " from `".DB::table($this->_table)."` asgc ";
        $sql .= " left join ".$this->community_table." asct on asgc.asgc_c_id = asct.asc_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql(0,0);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * 从商城和社区id中获取该社区可以限购条件下购买的商品
     * @param  [type] $community_id [description]
     * @return [type]               [description]
     */
    public function getGoodsBySidCid($community_id){
        $sql='SELECT `asgc_g_id` FROM `pre_applet_sequence_goods_community`';
        $sql.=$this->formatWhereSql([
            ['name'=>'asgc_s_id','oper'=>'=','value'=>$this->sid],
            ['name'=>'asgc_c_id','oper'=>'=','value'=>$community_id]
        ]);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }




}