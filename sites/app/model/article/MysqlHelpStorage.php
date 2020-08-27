<?php
/**
 * Created by PhpStorm.
 * User: zhaowei
 * Date: 16/6/21
 * Time: 下午5:40
 */
class App_Model_Article_MysqlHelpStorage extends Libs_Mvc_Model_BaseModel {

    private $helper_kind;

    public function __construct() {
        parent::__construct();
        $this->_table   = 'help_article';
        $this->_pk      = 'ha_id';
        $this->_df      = 'ha_deleted';
        $this->helper_kind = DB::table('help_kind');
    }
    /*
     * 根据小程序类型获取教程文章
     */
    public function getRowByType($kind,$appletType){
        $where    = array();
        $where[]  = array('name'=>'ha_hk_id','oper'=>'=','value'=>$kind);
        $where[]  = array('name'=>'ha_wxapp_id','oper'=>'=','value'=>$appletType);
        return $this->getRow($where);
    }

    public function getKindList($where, $index, $count, $sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = "select ha.*,hk_name ";
        $sql .= " from `".DB::table($this->_table)."` ha ";
        $sql .= " left join {$this->helper_kind} hk on hk_id = ha_hk_id ";

        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql, array());
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取所有的展示文章
     */
    public function fetchAllShopArticle($category=0,$keyword='') {
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        if($category){
            $where[] = array('name' => 'ha_hk_id', 'oper' => '=', 'value' => $category);
        }
        if($keyword){
            $where[] = array('name' => 'ha_title', 'oper' => 'like', 'value' => "%{$keyword}%");
        }
        $sort   = array('ha_weight' => 'DESC');
        return $this->getList($where, 0, 0, $sort);
    }

    public function getKindCount($where){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` ha ";
        $sql .= " left join {$this->helper_kind} hk on hk_id = ha_hk_id ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql, array());
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 通过管理链接搜索文章
     */
    public function fetchHelpListByManage($search) {
        $where[]    = array('name' => 'ha_manage', 'oper' => '=', 'value' => $search);
        $where[]    = array('name' => 'ha_deleted', 'oper' => '=', 'value' => 0);//未删除
        $sort = array('ha_weight'=>'DESC','ha_update_time'=>'DESC');
        return $this->getList($where, 0, 10,$sort);
    }

    /*
     * 教程和案例搜索文章
     */
    public function getArticleList($where, $index, $count, $sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = "select ha.*,hk_name ";
        $sql .= " from `".DB::table($this->_table)."` ha ";
        $sql .= " left join {$this->helper_kind} hk on hk_id = ha_hk_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql, array());
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}