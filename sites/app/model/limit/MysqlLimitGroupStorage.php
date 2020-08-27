<?php

class App_Model_Limit_MysqlLimitGroupStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
	public function __construct($sid){
        parent::__construct();

        $this->_table   = 'applet_limit_group';
		$this->_pk      = 'alg_id';
        $this->_df      = 'alg_deleted';
        $this->_shopId  = 'alg_s_id';
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
            $sql .= ' SET `alg_total` = alg_total + 1 ';
        }else{
            $sql .= ' SET `alg_total` = alg_total - 1 ';
            $where = ' and alg_total >= 1 ';
        }
        $sql .= ' WHERE `alg_id` = '.intval($id).$where;
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
        $where[]    = array('name' => 'algm_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'algm_gg_id', 'oper' => '=', 'value' => $id);
        $match_model = new App_Model_Limit_MysqlLimitGroupMatchStorage($this->sid);
        $match_model->deleteValue($where);
    }
}