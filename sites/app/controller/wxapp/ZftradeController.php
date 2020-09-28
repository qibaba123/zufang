<?php



class App_Controller_Wxapp_ZftradeController extends App_Controller_Wxapp_InitController{


    public function __construct() {
        parent::__construct();
    }

    //预约支付订单列表
    public function tradeListAction(){
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $trade_model = new App_Model_Trade_MysqlReserveTradeStorage();
        $ceshi_model = new App_Model_Trade_MysqlTradeStorage();
        $where   = array();
        $output['type'] = $this->request->getIntParam('type');
        if($output['type']){
            $where[]= array('name'=>'rt_type','oper'=>'=','value'=>$output['type']);
        }else{
            $where[] = array('name'=>"rt_type",'oper'=>"!=",'value'=>3);
        }
        $output['status'] = $this->request->getIntParam('status');
        if($output['status']){
            $where[]= array('name'=>'rt_status','oper'=>'=','value'=>$output['status']);
        }
        $output['title'] = $this->request->getStrParam('title');
        if($output['title']){
            $where[]= array('name'=>'rt_g_name','oper'=>'like','value'=>"%{$output['title']}%");
        }
        $output['tid'] = $this->request->getStrParam('tid');
        if($output['tid']){
            $where[]= array('name'=>'rt_tid','oper'=>'=','value'=>$output['tid']);
        }
        $output['buyer']  = $this->request->getStrParam('buyer');
        if($output['buyer']){
            $where[]= array('name'=>'rt_m_nickname','oper'=>'like','value'=>"%{$output['buyer']}%");
        }
        $output['harvest']  = $this->request->getStrParam('harvest');
        if($output['harvest']){
            $where[]= array('name'=>'rt_m_name','oper'=>'like','value'=>"%{$output['harvest']}%");
        }
        $output['phone']  = $this->request->getStrParam('phone');
        if($output['phone']){
            $where[]= array('name'=>'rt_m_mobile','oper'=>'=','value'=>$output['phone']);
        }
        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 'rt_start_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 'rt_end_time', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }
        $this->showOutput($output);
        $list    = $trade_model->getMemberList($where,$index,$this->count,array('rt_create_time'=>'DESC'));
        $total   = $trade_model->getCount($where);
        $page_libs = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pageHtml']  = $page_libs->render();
        $this->output['list']      = $list;
        $time_type = array(
            1 => '天',
            2 => '月',
            3 => '年'
        );
        $this->output['statusNote'] = array(
            1 => '待付款',
            2 => '已付款',
            3 => '已到期',
        );
        $this->output['goods_type'] = array(
            1 => '园区服务',
            2 => '企业服务',
            3 => 'VIP服务'
        );
        $this->output['time_type'] = $time_type;
        $this->buildBreadcrumbs(array(
            array('title' => '订单列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/trade/trade-list.tpl');
    }




   //预约表单订单
    public function formTradeListAction(){
        $page    = $this->request->getIntParam('page');
        $order_type    = $this->request->getIntParam('order_type');
        $pro     = $this->request->getIntParam('pro');
        $city    = $this->request->getIntParam('city');
        $area    = $this->request->getIntParam('area');
        $name    = $this->request->getStrParam('name');
        $c_name  = $this->request->getStrParam('c_name');
        $mobile  = $this->request->getStrParam('mobile');
        $index = $page * $this->count;
        $form_model = new App_Model_Trade_MysqlFormTradeStorage();
        $address_model = new App_Model_Address_MysqlAddressCoreStorage();
        $this->output['pro'] = $address_model->get_province();
        $where = array();
        if($order_type){
            $where[] = array('name'=>"ft_type",'oper'=>"=",'value'=>$order_type);
            $this->output['order_type'] = $order_type;
        }
        if($c_name){
            $where[] = array('name'=>"ft_c_name",'oper'=>"like",'value'=>'%'.$c_name.'%');
            $this->output['c_name'] = $c_name;
        }
        if($name){
            $where[] = array('name'=>"ft_name",'oper'=>"like",'value'=>'%'.$name.'%');
            $this->output['name'] = $name;
        }
        if($mobile){
            $where[] = array('name'=>"ft_mobile",'oper'=>"like",'value'=>'%'.$mobile.'%');
            $this->output['mobile'] = $mobile;
        }
        if($pro){
            $where[] = array('name'=>'ft_pro','oper'=>'=','value'=>$pro);
            $this->output['pro_id'] = $pro;
            $citylist = $address_model->get_city_by_parent($pro);
            $this->output['city'] = $citylist;

        }
        if($city){
            $where[] = array('name'=>'ft_city','oper'=>'=','value'=>$city);
            $this->output['city_id'] = $city;
            $arealist = $address_model->get_area_by_parent($city);
            $this->output['area'] = $arealist;
        }
        if($area){
            $where[] = array('name'=>'ft_area','oper'=>'=','value'=>$area);
            $this->output['area_id'] = $area;
        }
        $list    = $form_model->getList($where,$index,$this->count,array('ft_create_time'=>"DESC"));
        $total   = $form_model->getCount($where);
        $page_libs = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pageHtml']  = $page_libs->render();
        $service_model       = new App_Model_Service_MysqlEnterpriseServiceStorage();
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        foreach ($list as $key=>&$val){
            $name = '';
            if($val['ft_type'] == 1){
                $row = $service_model->getRowById($val['ft_ser_id']);
                $name = $row['es_name'];
            }elseif($val['ft_type'] == 4){
                $row = $information_storage->getRowById($val['ft_ser_id']);
                $name = $row['ai_title'];
            }
            $list[$key]['name'] = $name;
        }
        $this->output['list']      = $list;
        $type = array(
            1 => '企业服务',
            2 => '学习园地',
            3 => '关于我们',
            4 => '资讯文章'
        );
        $this->output['type'] = $type;
        $this->buildBreadcrumbs(array(
            array('title' => '预约订单列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/trade/form-trade-list.tpl');
    }

    //删除预约订单
    public function delTradeAction(){
        $id = $this->request->getIntParam('id');
        $form_model = new App_Model_Trade_MysqlFormTradeStorage();
        $update['ft_deleted'] = 1;
        $ret = $form_model->updateById($update,$id);
        if($ret){
            $this->displayJsonSuccess(array(),true,'删除成功');
        }else{
            $this->displayJsonError('删除失败');
        }
    }


}