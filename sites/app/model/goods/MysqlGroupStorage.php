<?php

class App_Model_Goods_MysqlGroupStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
	public function __construct($sid){
        parent::__construct();

        $this->_table   = 'goods_group';
		$this->_pk      = 'gg_id';
        $this->_df      = 'gg_deleted';
        $this->_shopId  = 'gg_s_id';
        $this->sid      = $sid;

	}

    /**
     * @param $id
     * @return bool
     * 修改商品关联总数
     */
    public function changeTotalById($id,$oper = 1){
        $sql   = 'UPDATE '.DB::table($this->_table);
        $where = '';
        if($oper == 1){
            $sql .= ' SET `gg_total` = gg_total + 1 ';
        }else{
            $sql .= ' SET `gg_total` = gg_total - 1 ';
            $where = ' and gg_total >= 1 ';
        }
        $sql .= ' WHERE `gg_id` = '.intval($id).$where;
        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function findGroupById($gpid) {
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $gpid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
        
        return $this->getRow($where);
    }

    /**
     * @param $id
     * 修改删除后产品的影响
     * 关联商品表中商品需要删除
     */
    public function deleteEffectById($id){
        $where[]    = array('name' => 'gm_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm_gg_id', 'oper' => '=', 'value' => $id);
        $match_model = new App_Model_Goods_MysqlGroupMatchStorage($this->sid);
        $match_model->deleteValue($where);
    }
}