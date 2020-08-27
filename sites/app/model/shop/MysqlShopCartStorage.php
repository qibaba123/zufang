<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/5/10
 * Time: 下午5:00
 */
class App_Model_Shop_MysqlShopCartStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;
    private $curr_table;
    private $goods_table;
    private $format_table;

    public function __construct($sid)
    {
        $this->_table = 'shop_cart';
        $this->_pk = 'sc_id';
        $this->_shopId = 'sc_s_id';
        parent::__construct();
        $this->sid = $sid;
        $this->curr_table = DB::table($this->_table);
        $this->goods_table   = DB::table('goods');
        $this->format_table  = DB::table('goods_format');
    }

    /**
     * 根据用户的ID和商品ID获取购物车信息
     * $mid : 用户ID
     * $gid : 商品ID
     * $gfid : 商品规格ID
     */
    public function getGoodsInfo($mid,$gid,$gfid=null,$data=null,$esId = 0){
        $where    = array();
        $where[]  = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]  = array('name' => 'sc_m_id', 'oper' => '=', 'value' => $mid);
        $where[]  = array('name' => 'sc_g_id', 'oper' => '=', 'value' => $gid);
        $where[]  = array('name' => 'sc_es_id', 'oper' => '=', 'value' => $esId);
        if($gfid){
            $where[]  = array('name' => 'sc_gf_id', 'oper' => '=', 'value' => $gfid);
        }
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /**
     * 获取商品详情及规格
     * @param $where
     * @param $index
     * @param $count
     * @param $sort
     */
    public function getGoodsFormat($where,$index,$count,$sort,$all = false,$field = ''){
        $where[]  = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]  = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        if(!$all){
            $where[]  = array('name' => 'g_is_sale', 'oper' => 'in', 'value' => array(1,3));
        }

        if($field){
            $sql = 'select '.$field.' ';
        }else{
            $sql = 'select * ';
        }

        $sql .= ' from '.$this->curr_table.' sc ';
        $sql .= ' left join '.$this->goods_table.' g on g.g_id = sc.sc_g_id ';
        $sql .= ' left join '.$this->format_table.' gf on gf.gf_id = sc.sc_gf_id ';
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

    public function getMealGoodsFormat($esId,$where,$index,$count,$sort){
        $where[]  = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]  = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $where[]  = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
        $where[]  = " amgs.amgs_id is null ";
        $sql = 'select * ';
        $sql .= ' from '.$this->curr_table.' sc ';
        $sql .= ' left join '.$this->goods_table.' g on g.g_id = sc.sc_g_id ';
        $sql .= ' left join '.$this->format_table.' gf on gf.gf_id = sc.sc_gf_id ';
        $sql .= " left join pre_applet_meal_goods_shelf amgs on amgs.amgs_g_id = sc.sc_g_id AND amgs.amgs_es_id = {$esId} ";
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
     * 根据用户的ID和商品ID获取购物车商品数量
     * $mid : 用户ID
     * $gid : 商品ID
     * $gfid : 商品规格ID
     */
    public function getGoodsCount($mid){
        $where[]  = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]  = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $where[]  = array('name' => 'sc_m_id', 'oper' => '=', 'value' => $mid);

        $sql = 'select sum(sc_num) as total ';
        $sql .= ' from '.$this->curr_table.' sc ';
        $sql .= ' left join '.$this->goods_table.' g on g.g_id = sc.sc_g_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /**
     * 根据用户ID和店铺ID获取购物车信息
     */
    public function getCartGoods($mid){
        $where    = array();
        $where[]  = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]  = array('name' => 'sc_m_id', 'oper' => '=', 'value' => $mid);
        $list = $this->getList($where,0,0,array('sc_add_time'=>'DESC'));
        $data = array();
        if($list){
            foreach ($list as $item) {
                if($item['sc_gf_id']>0){
                    $data['format'][$item['sc_g_id']][$item['sc_gf_id']] = $item['sc_num'];
                }else{
                    $data['goods'][$item['sc_g_id']] = $item['sc_num'];
                }
                $data['num'][$item['sc_g_id']][] = $item['sc_num'];
            }
        }
        return $data;
    }

    public function getMealCartGoods($mid,$esId,$gid = 0){
        $where    = array();
        $where[]  = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]  = array('name' => 'sc_m_id', 'oper' => '=', 'value' => $mid);
        $where[]  = array('name' => 'sc_es_id', 'oper' => '=', 'value' => $esId);
        $where[]  = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
        if($gid){
            $where[]  = array('name' => 'sc_g_id', 'oper' => '=', 'value' => $gid);
        }
        $where[]  = " amgs.amgs_id is null ";
        $sort = array('sc_add_time'=>'DESC');
        $sql = 'select * ';
        $sql .= ' from '.$this->curr_table.' sc ';
        $sql .= ' left join '.$this->goods_table.' g on g.g_id = sc.sc_g_id ';
        $sql .= " left join pre_applet_meal_goods_shelf amgs on amgs.amgs_g_id = sc.sc_g_id AND amgs.amgs_es_id = {$esId} ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql(0,0);
        $list = DB::fetch_all($sql);
        $data = array();
        if($list){
            foreach ($list as $item) {
                if($item['sc_gf_id']>0){
                    $data['format'][$item['sc_g_id']][$item['sc_gf_id']] = $item['sc_num'];
                }else{
                    $data['goods'][$item['sc_g_id']] = $item['sc_num'];
                }
                $data['num'][$item['sc_g_id']][] = $item['sc_num'];
            }
        }
//        if($this->sid == 4286){
//            Libs_Log_Logger::outputLog($data,'test.log');
//            Libs_Log_Logger::outputLog($sql,'test.log');
//        }
        return $data;
    }
    /*
     * 获得每个商品的数量 不区分规格
     */
    public function getGoodsCountSum($where,$index = 0,$count = 0){
        $where[]  = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]  = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);

        $sql = 'select sc.*,g.g_id,sum(sc_num) as total ';
        $sql .= ' from '.$this->curr_table.' sc ';
        $sql .= ' left join '.$this->goods_table.' g on g.g_id = sc.sc_g_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY sc.sc_g_id ';
        $sql .= $this->formatLimitSql($index,$count);
        //Libs_Log_Logger::outputLog($sql);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得购物车商品总数量
     * $esid ： 多店或平台入驻店铺id
     */
    public function getCartSum($mid,$independent = 0,$esid=-1){
        $where[]  = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]  = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $where[]  = array('name' => 'g_is_sale', 'oper' => 'in', 'value' => array(1,3));
        $where[]  = array('name' => 'sc_m_id', 'oper' => '=', 'value' => $mid);
        $where[]  = array('name' => 'sc_independent_mall', 'oper' => '=', 'value' => $independent);
        if($esid>=0){
            //原为g_es_id，改为sc_es_id  dn 2019-08-16
            $where[]  = array('name' => 'sc_es_id', 'oper' => '=', 'value' => $esid);
        }
        $sql = 'select sum(sc_num) as total ';
        $sql .= ' from '.$this->curr_table.' sc ';
        $sql .= ' left join '.$this->goods_table.' g on g.g_id = sc.sc_g_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}