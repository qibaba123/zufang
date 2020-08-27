<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/14
 * Time: 下午4:59
 */
class App_Model_Shop_MysqlShopSlideStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $game_table;
    public function __construct($sid){
        $this->_table 	= 'shop_slide';
        $this->_pk 		= 'ss_id';
        $this->_shopId 	= 'ss_s_id';
        parent::__construct();
        $this->sid  = $sid;
        $this->game_table = 'applet_gamebox_game';
    }

    /*
     * 前端获取店铺可展示的幻灯列表
     */
    public function fetchSlideShowList($tpl_id = 1, $type=1) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ss_show', 'oper' => '=', 'value' => 1);//设置为显示
        if($type == 1){
            $where[]    = array('name' => 'ss_tpl_id', 'oper' => '=', 'value' => $tpl_id);//某个模版的
        }

        $where[]    = array('name' => 'ss_deleted', 'oper' => '=', 'value' => 0);//未删除
        $where[]    = array('name' => 'ss_type', 'oper' => '=', 'value' => $type);//1首页幻灯2预约幻灯
        return $this->getList($where, 0, 50, array('ss_weight' => 'ASC'));
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
            $sql .= '  (`ss_id`, `ss_s_id`,`ss_tpl_id`, `ss_type`, `ss_link`, `ss_article_title`, `ss_path`, `ss_weight`, `ss_show`, `ss_deleted`, `ss_create_time`) ';
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
     * @param array $val_arr
     * @return bool
     * 批量插入数据(新的，增加链接类型)
     */
    public function newInsertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`ss_id`, `ss_s_id`,`ss_tpl_id`, `ss_type`, `ss_link`,`ss_link_type`, `ss_article_title`, `ss_path`, `ss_weight`, `ss_show`, `ss_deleted`, `ss_create_time`) ';
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
     * 游戏盒子用 关联游戏表
     */
    public function fetchSlideShowListGame($tpl_id = 1, $type=1){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ss_show', 'oper' => '=', 'value' => 1);//设置为显示
        if($type == 1){
            $where[]    = array('name' => 'ss_tpl_id', 'oper' => '=', 'value' => $tpl_id);//某个模版的
        }
        $where[]    = array('name' => 'ss_deleted', 'oper' => '=', 'value' => 0);//未删除
        $where[]    = array('name' => 'ss_type', 'oper' => '=', 'value' => $type);//1首页幻灯2预约幻灯
        $sort = array('ss_weight' => 'ASC');
        $sql = "SELECT ss.*,agg.* ";
        $sql .= " FROM ".DB::table($this->_table)." ss ";
        $sql .= " LEFT JOIN ".DB::table($this->game_table)." agg on ss.ss_link = agg.agg_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql(0,50);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}