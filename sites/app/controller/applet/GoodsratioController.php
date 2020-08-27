<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/6/24
 * Time: 上午：11：30
 * 微培训相关接口
 */

class App_Controller_Applet_GoodsratioController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 单品分销商品列表
     */
    public function goodsListAction(){
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $deduct_model = new App_Model_Goods_MysqlGoodsRatioDeductStorage($this->sid);
        $where[] = array('name' => 'grd_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'grd_is_used', 'oper' => '=', 'value' => 1);//启用中
        $sort = array('grd_create_time' => 'desc');
        $list = $deduct_model->getGoodsList($where, $index, $this->count, $sort);
        if($list){
            $info['data'] = array();

            foreach ($list as $val){
                $info['data'][] = array(
                    'gid'   => $val['g_id'],
                    'cover' => $this->dealImagePath($val['g_cover']),
                    'name'  => $val['g_name'],
                    'shareNum' => $val['grd_share_num'],
                    'profit' => $val['g_price'] * $val['grd_1f_ratio']/100,
                    'type'   => $val['g_knowledge_pay_type'],
                );
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }
    }

    /**
     * 我的分享收益
     */
    public function shareProfitListAction(){
        $page  = $this->request->getIntParam('page');
        $month = $this->request->getStrParam('month'); //月份  2018-08
        $index = $page * $this->count;
        $sort  = array('od_create_time' => 'DESC');//订单生成时间倒序排列

        $where = array();
        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'od_share_goods', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'od_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 't_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET);


        if($month){
            $time = strtotime($month);
            $where[] = array('name' => 't_finish_time', 'oper' => '>', 'value' => $time);
            $where[] = array('name' => 't_finish_time', 'oper' => '<', 'value' => strtotime("+1 month", $time));
        }else{
            $time = strtotime(date('Y-m'));
            $where[] = array('name' => 't_finish_time', 'oper' => '>', 'value' => $time);
            $where[] = array('name' => 't_finish_time', 'oper' => '<', 'value' => time());
        }

        $deduct_storage  = new App_Model_Shop_MysqlOrderDeductStorage($this->sid);
        $list = $deduct_storage->getGoodsDeductByMidSid($where,$index,$this->count,$sort, 1, $this->member['m_id']);

//        $info['data']['totalProfit'] = $deduct_storage->profitStatistic('total', $this->member['m_id']);
//        $info['data']['todayProfit'] = $deduct_storage->profitStatistic('today', $this->member['m_id']);

        $deduct_0_total = $deduct_storage->profitStatistic('total',$this->member['m_id'],0);
        $deduct_1_total = $deduct_storage->profitStatistic('total',$this->member['m_id'],1);
        $info['data']['totalProfit'] = $deduct_0_total + $deduct_1_total;

        $deduct_0_today = $deduct_storage->profitStatistic('today',$this->member['m_id'],0);
        $deduct_1_today = $deduct_storage->profitStatistic('today',$this->member['m_id'],1);
        $info['data']['todayProfit'] = $deduct_0_today + $deduct_1_today;

        $info['data']['list'] = array();

        foreach ($list as $value){
            $info['data']['list'][] = array(
                'title' => $value['t_title'],
                'profit' => $value['od_1f_id']==$this->member['m_id']?$value['od_1f_deduct']:$value['od_0f_deduct'],
                'time'  => date("Y.m.d H:i:s", $value['t_finish_time']),
                'status'  => '已返现'
            );
        }
        $this->outputSuccess($info);

    }
}
