<?php
/*
 * 爆品分销 区域表
 */
class App_Model_Sequence_MysqlSequenceAreaStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_area';
        $this->_pk = 'asa_id';
        $this->_shopId = 'asa_s_id';
        $this->_df = 'asa_deleted';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }
    // 获取附带省市区的列表数据
    public function getListWithArea($where = array(), $index = 0, $count = 20, $sort = array(), $field = array(), $primary = false,$test=0){
        $where[]=['name'=>'asa_deleted','oper'=>'=','value'=>'0'];

        $sql='SELECT `asa_id`,`asa_name`,`asa_create_time`,`asa_province`,`asa_city`,`asa_zone`,concat(addr.`region_name`,"-" ,addr1.`region_name`,"-" , addr2.`region_name`) AS `area`,addr1.region_name as cityName,addr1.region_id as cityId ';
        $sql.='FROM '.DB::table('applet_sequence_area').' AS asa ';
        $sql.='LEFT JOIN `dpl_china_address` AS addr on addr.`region_id`=asa.`asa_province` ';
        $sql.='LEFT JOIN `dpl_china_address` AS addr1 on addr1.`region_id`=asa.`asa_city` ';
        $sql.='LEFT JOIN `dpl_china_address` AS addr2 on addr2.`region_id`=asa.`asa_zone` ';
        $sql.=$this->formatWhereSql($where);
        $sql.=$this->getSqlSort($sort);
        $sql.=$this->formatLimitSql($index,$count);
        $res=DB::fetch_all($sql);
        return $res;
    }

    // 获取已开通的省份的列表
    public function getSeqProvinces(){
        return $this->getAddress([
            ['name'=>'region_type','oper'=>'=','value'=>1]
        ],'asa_province');
    }
    // 获取已开通的城市的列表
    public function getSeqCitys(){
        return $this->getAddress([
            ['name'=>'region_type','oper'=>'=','value'=>2],
        ],'asa_city');
    }
    // 获取已开通的区域的列表
    public function getSeqDistrict(){
        return $this->getAddress([
            ['name'=>'region_type','oper'=>'=','value'=>3],
        ],'asa_zone');
    }
    // 获取地址信息
    private function getAddress($where=[],$groupby){
        $where[]=['name'=>'asa_s_id','oper'=>'=','value'=>$this->sid];
        $sql=sprintf('SELECT `region_id`,`region_name` FROM %s AS asa LEFT JOIN dpl_china_address AS addr on `region_id`=asa.`%s` %s GROUP BY %s',DB::table('applet_sequence_area'),$groupby,$this->formatWhereSql($where),$groupby);
        $res=DB::fetch_all($sql);
        if($res===false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $res;
    }

    /**
     * 根据区/县获取所有的街道列表
     * @param  array  $where [description]
     * @return [type]        [description]
     */
    public function getAreaByDistrict($where=[]){
        $sql=sprintf('SELECT `asa_id`,`asa_name` FROM `%s` ',
            DB::table($this->_table));
        $where[]=['name'=>'asa_s_id','oper'=>'=','value'=>$this->sid];
        $where[]=['name'=>'asa_deleted','oper'=>'=','value'=>0];

        $sql.=$this->formatWhereSql($where);
        $res=DB::fetch_all($sql);
        if($res===false){
            trigger_error('mysql query failed',E_USER_ERROR);
        }
        return $res;
    }

}