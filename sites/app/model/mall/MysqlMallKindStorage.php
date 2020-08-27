<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/20
 * Time: 下午2:39
 */
class App_Model_Mall_MysqlMallKindStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $goods_table;
    private $group_match;
    private $entershop_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_mall_kind';
        $this->_pk = 'amk_id';
        $this->_shopId = 'amk_s_id';
        $this->goods_table  = DB::table("goods");
        $this->entershop_table = DB::table("enter_shop");
        $this->group_match = DB::table("group_match");
        $this->sid = $sid;
    }

    /*
       * 获取店铺可展示的快捷菜单列表
       */
    public function fetchKindShowList($tpl_id = 15) {
        $where[]    = array('name' => 'amk_tpl_id', 'oper' => '=', 'value' => $tpl_id); //所属模版，暂定通用
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        return $this->getList($where, 0, 50, array('amk_weight' => 'ASC'));
    }

    /*
       * 获取店铺可展示的快捷菜单列表
       */
    public function fetchKindShowListGroup($tpl_id = 15) {
        $where[]    = array('name' => 'amk_tpl_id', 'oper' => '=', 'value' => $tpl_id); //所属模版，暂定通用
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sort = array('amk_weight' => 'ASC');
        $sql  = ' SELECT * ';
        $sql .= " from `".DB::table($this->_table)."` amk ";
        $sql .= " left join `pre_goods_group` gg on gg.gg_id = amk.amk_link ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql(0,50);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
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
            $sql .= ' (`amk_id`, `amk_s_id`,`amk_tpl_id`,`amk_name`, `amk_img`,`amk_link`,`amk_sign`,`amk_weight`,`amk_create_time`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$val_arr);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }

    }
    /**
     * @param array $val_arr
     * @return bool
     * 批量插入首页分类（万能商城用）
     */
    public function newInsertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`amk_id`, `amk_s_id`,`amk_tpl_id`,`amk_name`, `amk_img`,`amk_link`,`amk_sign`,`amk_goods_list`,`amk_weight`,`amk_create_time`) ';
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