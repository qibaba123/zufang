<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/10/10
 * Time: 下午：3：32
 */
class App_Model_Meal_MysqlMealOrderQueueStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_meal_order_queue';
        $this->_pk = 'amoq_id';
        $this->_shopId = 'amoq_s_id';
        $this->_df = 'amoq_delete';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    public function getQueueMaxIndex($tableId){
        $time = strtotime(date('Y-m-d')); //当天0点的时间戳
        $sql = "SELECT MAX(`amoq_index`) FROM pre_applet_meal_order_queue WHERE `amoq_s_id` = {$this->sid} AND `amoq_table_id` = {$tableId} AND `amoq_create_time` >= {$time}";
        $max_index = DB::result_first($sql);
        return $max_index+1;
    }

    /**
     * 获取正在排号的数量
     */
    public function getQueueCount($tableId){
        $where   = array();
        $where[] = array('name' => 'amoq_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amoq_table_id', 'oper' => '=', 'value' => $tableId);
        $where[] = array('name' => 'amoq_delete', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'amoq_status', 'oper' => '=', 'value' => 1); //正在排号

        $count = $this->getCount($where);
        return $count?$count:0;
    }

    /**
     * 获取当前用户一条正在排号的记录
     */
    public function getQueueIngRow($mid, $esId=0){
        $where = array();
        $where[] = array('name' => 'amoq_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amoq_m_id', 'oper' => '=', 'value' => $mid);
        if($esId){
            $where[] = array('name' => 'amoq_es_id', 'oper' => '=', 'value' => $esId);
        }
        $where[] = array('name' => 'amoq_delete', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'amoq_status', 'oper' => '=', 'value' => 1);
        //获取一条正在排号的记录
        return $this->getRow($where);
    }

    /**
     * 获取当前用户当天是否有已过号的记录
     */
    public function getQueueOverRow($mid, $esId=0){
        $where = array();
        $where[] = array('name' => 'amoq_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amoq_m_id', 'oper' => '=', 'value' => $mid);
        if($esId){
            $where[] = array('name' => 'amoq_es_id', 'oper' => '=', 'value' => $esId);
        }
        $where[] = array('name' => 'amoq_status', 'oper' => '=', 'value' => 2);
        $where[] = array('name' => 'amoq_create_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d')));
        //获取一条正在排号的记录
        $list = $this->getList($where, 0, 0, array('amoq_create_time' => 'desc'));
        if($list){
            return $list[0];
        }else{
            return false;
        }
    }

    /**
     * 获取当前用户前面排了多少人
     */
    public function getWaitTotal($tableId, $time){
        $where = array();
        $where[] = array('name' => 'amoq_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amoq_table_id', 'oper' => '=', 'value' => $tableId);
        $where[] = array('name' => 'amoq_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'amoq_create_time', 'oper' => '<', 'value' => $time);
        //获取一条正在排号的记录
        return $this->getCount($where);
    }

    /**
     * 获取一条排队信息
     */
    public function getQueueRowWithTable($id){
        $where = array();
        $where[] = array('name'=>'amoq_id','oper'=>'=','value'=>$id);

        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` amoq ";
        $sql .= " left join pre_applet_meal_order_table amot on amoq.amoq_table_id = amot.amot_id ";

        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}