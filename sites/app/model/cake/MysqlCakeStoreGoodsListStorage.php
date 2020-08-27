<?php

class App_Model_Cake_MysqlCakeStoreGoodsListStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'applet_store_goods_limit';
        $this->_pk 		= 'asgl_id';
        $this->_shopId 	= 'asgl_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    /*
     * 商品列表
     */
    public function getGoodsListAction($where,$index,$count,$sort){
        $where[]   = array('name'=>'g_deleted','oper'=>'=','value'=>0);
        $sql = "select asgl.*,g.g_name,g.g_cover,g.g_price,g.g_id";
        $sql .= " from `".DB::table($this->_table)."` asgl ";
        $sql .= " left join `pre_goods` g on g.g_id = asgl.asgl_g_id ";
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
     * 获得商品id列表
     */
    public function getStoreGoods($where,$index,$count,$sort){
        $sql = "select asgl_g_id ";
        $sql .= " from `".DB::table($this->_table)."` asgl ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " group by asgl_g_id ";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        Libs_Log_Logger::outputLog($sql,'test.log');
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`asgl_id`, `asgl_s_id`,`asgl_store_id`, `asgl_g_id`, `asgl_create_time`) ';
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


    /**
     * 根据门店ID删除门店商品
     */
    public function deleteListByStoreid($id){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asgl_store_id', 'oper' => '=', 'value' => $id);
        return $this->deleteValue($where);
    }

    /**
     * 根据门店ID获得门店商品
     */
    public function getListByStoreid($id){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asgl_store_id', 'oper' => '=', 'value' => $id);
        return $this->getList($where,0,0);
    }

    public function getStoreIdsByGids($gids){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asgl_g_id', 'oper' => 'in', 'value' => $gids);
        $list = $this->getList($where,0,0,[],['asgl_store_id']);
        $data = [];
        if($list){
            foreach ($list as $val){
                if(!in_array($val['asgl_store_id'],$data)){
                    $data[] = $val['asgl_store_id'];
                }
            }
        }

        return $data;
    }

}