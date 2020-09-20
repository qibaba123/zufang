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

    }




   //预约表单订单
    public function formTradeListAction(){
        $page    = $this->request->getIntParam('page');
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
        $list    = $form_model->getSerList($where,$index,$this->count,array('ft_create_time'=>"DESC"));
        $total   = $form_model->getCount($where);
        $page_libs = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pageHtml']  = $page_libs->render();
        $this->output['list']      = $list;
        $type = array(
            1 => '企业服务',
            2 => '学习园地',
            3 => '关于我们'
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