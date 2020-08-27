<?php

class App_Model_Sequence_MysqlSequenceMenuStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_sequence_menu';
        $this->_pk     = 'asm_id';
        $this->_shopId = 'asm_s_id';
        $this->sid     = $sid;
        $this->_df     = 'asm_deleted';
    }


    /**
     * 增加或减少点赞数、分享数 $operation=add添加 $operation=reduce减少
     */
    public function addReducePostNum($id,$type,$operation='add',$num=1){
        if(is_array($id)){
            $where[]    = array('name' => $this->_pk, 'oper' => 'in', 'value' => $id);
        }else{
            $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        }
        if($type=='like'){
            $field = 'asm_like_num';
        }elseif($type=='share'){
            $field = 'asm_share_num';
        }
        $sql  = 'UPDATE '.DB::table($this->_table);
        if($operation=='add'){
            $sql .= ' SET  '.$field.' = '.$field.' + '.$num;
        }else{
            $sql .= ' SET  '.$field.' = '.$field.' - '.$num;
        }
        //$sql .= '  WHERE '.$this->_pk .' = '.intval($pid);
        $sql .= $this->formatWhereSql($where);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }





}