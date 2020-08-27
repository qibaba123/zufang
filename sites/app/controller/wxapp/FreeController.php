<?php

class App_Controller_Wxapp_FreeController extends App_Controller_Wxapp_OrderCommonController{

    const PROMOTION_TOOL_KEY = 'mfyy';
    
    public function __construct(){
        parent::__construct();

        
    }


    
    public function freeTradeListAction(){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $sort       = array('acft_create_time' => 'DESC');
        $where = [];
        $list = [];
        $output['title']   = $this->request->getStrParam('title');
        if($output['title']){
            $where[]    = array('name' => 'acfp_name', 'oper' => 'like', 'value' => "%{$output['title']}%");
        }
        $output['buyer']   = $this->request->getStrParam('buyer');
        if($output['buyer']){
            $where[]    = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$output['buyer']}%");
        }
        $output['phone']   = $this->request->getStrParam('phone');
        if($output['phone']){
            $where[]    = array('name' => 'acft_mobile', 'oper' => 'like', 'value' => "%{$output['phone']}%");
        }
        $output['status'] = $this->request->getStrParam('status','all');
        $output['timeStatus'] = $this->request->getStrParam('timeStatus');
        switch ($output['timeStatus']){
            case 'on':
                $where[] = array('name' => 'acft_time','oper' => '>=' , 'value' => time());
                break;
            case 'expire'://只要预约时间小于当前都是已失效
                $where[] = array('name' => 'acft_time','oper' => '<' , 'value' => time());
                break;
        }

        switch ($output['status']){
            case 'yes':
                $where[] = array('name' => 'acft_status','oper' => '=' , 'value' => 2);
                break;
            case 'no':
                $where[] = array('name' => 'acft_status','oper' => '=' , 'value' => 1);
                break;
            case 'cancel':
                $where[] = array('name' => 'acft_status','oper' => '=' , 'value' => 3);
                break;
        }

        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 'acft_create_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 'acft_create_time', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }

        $output['appostart']   = $this->request->getStrParam('appostart');
        if($output['appostart']){
            $where[]    = array('name' => 'acft_time', 'oper' => '>=', 'value' => strtotime($output['appostart']));
        }
        $output['appoend']     = $this->request->getStrParam('appoend');
        if($output['appoend']){
            $where[]    = array('name' => 'acft_time', 'oper' => '<=', 'value' => (strtotime($output['appoend']) + 86400));
        }
        $where[]    = array('name' => 'acft_s_id', 'oper' => '=', 'value' => $this->curr_sid);

        $output['esId'] = $this->request->getIntParam('esId');
        if($output['esId']){
            $where[]    = array('name' => 'acft_es_id', 'oper' => '=', 'value' => $output['esId']);
        }
        $trade_model = new App_Model_Community_MysqlCommunityFreeTradeStorage($this->curr_sid);
        $total       = $trade_model->getTradeCount($where);
        $page_lib    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['page_html'] = $page_lib->render();
        if($total > $index){
            $list = $trade_model->getTradeList($where,$index,$this->count,$sort);
        }
        $output['list'] = $list;
        $output['link'] = $this->_get_trade_link();
        $this->_shop_list_for_select(true);
        $statusNote = array(
            1 => '待处理',
            2 => '已处理',
            3 => '已取消'
        );
        $output['statusNote'] = $statusNote;

        $this->buildBreadcrumbs(array(
            array('title' => '预约订单', 'link' => '#'),
        ));

        $this->showOutput($output);
        $this->displaySmarty('wxapp/free/free-trade-list.tpl');
    }

    
    private function _shop_list_for_select($all = false){
        $where[] = array('name'=>'es_s_id','oper'=>'=','value'=>$this->curr_sid);
        if(!$all){
            $where[] = array('name'=>'es_status','oper'=>'=','value'=>0);
        }


        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $sort    = array('es_createtime' => 'DESC');
        $list    = $shop_model->getList($where,0,0,$sort);

        $data = array();
        $selectShop = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['es_id'],
                    'name' => $val['es_name']
                );
                $selectShop[$val['es_id']] = $val['es_name'];
            }
        }
        $this->output['shoplist'] = json_encode($data);
        $this->output['selectShop'] = $selectShop;
    }

    
    private function _get_trade_link(){
        $link = array(
            'all'   => array(
                'id'    => 0,
                'label' => '全部'
            ),
            'no'   => array(
                'id'    => 1 ,
                'label' => '待处理'
            ),
            'yes'   => array(
                'id'    => 2,
                'label' => '已处理'
            ),
            'cancel'   => array(
                'id'    => 3,
                'label' => '已取消'
            )

        );
        return $link;
    }

    
    public function handleFreeTradeAction(){
        $id = $this->request->getIntParam('id');
        $remark = $this->request->getStrParam('remark');
        $trade_model = new App_Model_Community_MysqlCommunityFreeTradeStorage($this->curr_sid);
        $row = $trade_model->getRowById($id);
        if($row){
            $data = array(
                'acft_status' => 2,
                'acft_handle_remark' => $remark,
                'acft_handle_time'   => time()
            );
            $res = $trade_model->updateById($data,$id);
            if($res){
                $result = array(
                    'ec' => 200,
                    'em' => '处理成功'
                );
                App_Helper_OperateLog::saveOperateLog("免费预约订单处理成功");
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '处理失败'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '未找到订单信息'
            );
        }
        $this->displayJson($result);
    }



}

