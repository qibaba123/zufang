<?php
/*
 * 社区团购 菜单商品表
 */
class App_Model_Sequence_MysqlSequenceMenuGoodsStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $goods_table;
    private $menu_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_menu_goods';
        $this->_pk = 'asmg_id';
        $this->_shopId = 'asmg_s_id';
        $this->goods_table = DB::table('goods');
        $this->menu_table = DB::table('applet_sequence_menu');
        $this->sid = $sid;
    }

    public function getListByMenu($id)
    {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'asmg_menu_id', 'oper' => '=', 'value' => $id);
        return $this->getList($where,0,0);
    }

    public function deleteByMenu($id){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'asmg_menu_id', 'oper' => '=', 'value' => $id);
        return $this->deleteValue($where);
    }


    /*
     * 获得商品关联的菜单列表
     */
    public function fetchMenuList($where,$index,$count,$sort) {

        $sql = "SELECT asmg.*,asm.asm_like_num,asm.asm_title,asm.asm_sort,asm.asm_create_time ";
        $sql .= " FROM ".DB::table($this->_table)." asmg ";
        $sql .= " LEFT JOIN ".$this->menu_table." asm on asm.asm_id=asmg.asmg_menu_id ";
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
     * 获得菜单关联的商品列表
     */
    public function fetchGoodsList($where,$index,$count,$sort) {

        $sql = "SELECT asmg.*,g.g_name,g.g_cover ";
        $sql .= " FROM ".DB::table($this->_table)." asmg ";
        $sql .= " LEFT JOIN ".$this->goods_table." g on g.g_id=asmg.asmg_goods_id ";
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

    public function fetchGoodsCount($where) {

        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." asmg ";
        $sql .= " LEFT JOIN ".$this->goods_table." g on g.g_id=asmg.asmg_goods_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据菜单id和商品id，查找关联信息 关联商品列表,菜单表
     */
    public function fetchGoodsRow($aid,$gid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asmg_a_id', 'oper' => '=', 'value' => $aid);
        $where[]    = array('name' => 'asmg_g_id', 'oper' => '=', 'value' => $gid);
        $sql = "SELECT asmg.*,g.g_name,g.g_cover,asm.* ";
        $sql .= " FROM ".DB::table($this->_table)." asmg ";
        $sql .= " LEFT JOIN ".$this->goods_table." g on g.g_id=asmg.asmg_goods_id ";
        $sql .= " LEFT JOIN ".$this->menu_table." asm on asm.asm_id=asmg.asmg_menu_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /*
     * 根据菜单id和商品id，查找关联信息
     */
    public function fetchRow($menuId,$gid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asmg_menu_id', 'oper' => '=', 'value' => $menuId);
        $where[]    = array('name' => 'asmg_goods_id', 'oper' => '=', 'value' => $gid);

        return $this->getRow($where);
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
            $sql .= '  (`asmg_id`, `asmg_s_id`,  `asmg_goods_id`, `asmg_menu_id`, `asmg_create_time`) ';
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