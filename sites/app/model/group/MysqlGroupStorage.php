<?php

class App_Model_Group_MysqlGroupStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
	public function __construct($sid){
        parent::__construct();

        $this->_table   = 'applet_group_group';
		$this->_pk      = 'agg_id';
        $this->_df      = 'agg_deleted';
        $this->_shopId  = 'agg_s_id';
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
            $sql .= ' SET `agg_total` = agg_total + 1 ';
        }else{
            $sql .= ' SET `agg_total` = agg_total - 1 ';
            $where = ' and agg_total >= 1 ';
        }
        $sql .= ' WHERE `agg_id` = '.intval($id).$where;
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
        $where[]    = array('name' => 'agm_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'agm_gg_id', 'oper' => '=', 'value' => $id);
        $match_model = new App_Model_Group_MysqlGroupMatchStorage($this->sid);
        $match_model->deleteValue($where);
    }
}