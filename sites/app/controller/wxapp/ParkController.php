<?php



class App_Controller_Wxapp_ParkController extends App_Controller_Wxapp_InitController{


    public function __construct() {
        parent::__construct();
    }



    //园区列表
    public function parkListAction(){
        $page         = $this->request->getIntParam('page');
        $name         = $this->request->getIntParam('name');
        $pro          = $this->request->getIntParam('pro');
        $city         = $this->request->getIntParam('city');
        $area         = $this->request->getIntParam('area');
        $index        = $page * $this->count;
        $park_model    = new App_Model_Park_MysqlAddressParkStorage();
        $address_model = new App_Model_Address_MysqlAddressCoreStorage();
        $this->output['pro'] = $address_model->get_province();
        $where         = array();
        if($name){
            $where[] = array('name'=>'ap_name','oper'=>'like','value'=>'%'.$name.'%');
            $this->output['name'] = $name;
        }
        if($pro){
            $where[] = array('name'=>'ap_pro','oper'=>'=','value'=>$pro);
            $this->output['pro_id'] = $pro;
            $citylist = $address_model->get_city_by_parent($pro);
            $this->output['city'] = $citylist;

        }
        if($city){
            $where[] = array('name'=>'ap_city','oper'=>'=','value'=>$city);
            $this->output['city_id'] = $city;
            $arealist = $address_model->get_area_by_parent($city);
            $this->output['area'] = $arealist;
        }
        if($area){
            $where[] = array('name'=>'ap_area_id','oper'=>'=','value'=>$area);
            $this->output['area_id'] = $area;
        }
        $list       = $park_model->getList($where,$index,$this->count,array('ap_weight'=>'DESC'));
        $total      = $park_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pageHtml']   = $pageCfg->render();
        $this->output['list']       = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '园区列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/park/park-list.tpl');
    }



}