<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/20
 * Time: 下午2:39
 */
class App_Model_Mall_MysqlMallRecommendStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_mall_recommend';
        $this->_pk = 'amr_id';
        $this->_shopId = 'amr_s_id';

        $this->sid = $sid;
    }

    /*
       * 获取店铺可展示的快捷菜单列表
       */
    public function fetchRecommendShowList($tpl_id = 15) {
        $where[]    = array('name' => 'amr_tpl_id', 'oper' => '=', 'value' => $tpl_id); //所属模版，暂定通用
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        return $this->getList($where, 0, 50, array('amr_weight' => 'ASC'));
    }

    public function fetchRecommendShowListGoods($tpl_id = 15){
        $where[]    = array('name' => 'amr_tpl_id', 'oper' => '=', 'value' => $tpl_id); //所属模版，暂定通用
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = "SELECT amr.*,g.g_name,g.g_list_label,g.g_price,g.g_es_id ";
        $sql .= " FROM ".DB::table($this->_table)." amr ";
        $sql .= " LEFT JOIN `pre_goods` g on g.g_id=amr.amr_link ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort(array('amr_weight' => 'ASC'));
        $sql .= $this->formatLimitSql(0,50);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;

    }

    /**
     * @param array $val_arr
     * @return bool
     * 批量插入首页分类
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`amr_id`, `amr_s_id`,`amr_tpl_id`,`amr_name`,`amr_price`,`amr_img`, `amr_link`,`amr_weight`,`amr_brief`,`amr_create_time`) ';
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




}