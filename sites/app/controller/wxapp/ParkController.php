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



    //新增园区
    public function addParkAction(){
        $id            = $this->request->getIntParam('id');
        $address_model = new App_Model_Address_MysqlAddressCoreStorage();
        $province      = $address_model->get_province();
        $this->output['province'] = $province;
        if($id){
            $park_model  = new App_Model_Park_MysqlAddressParkStorage();
            $row         = $park_model->getRowById($id);
            $this->output['row'] = $row;
            $city = $address_model->get_city_by_parent($row['ap_pro']);
            $this->output['city'] = $city;
            $area = $address_model->get_area_by_parent($row['ap_city']);
            $this->output['area'] = $area;
        }
        $this->displaySmarty('wxapp/park/add-park.tpl');
    }


    //保存园区
    public function saveParkAction(){
        $id                     = $this->request->getIntParam('id');
        $data['ap_pro']         = $this->request->getIntParam('pro');
        $data['ap_city']        = $this->request->getIntParam('city');
        $data['ap_area']        = $this->request->getIntParam('area');
        $data['ap_pro_name']    = $this->request->getStrParam('pro_name');
        $data['ap_city_name']   = $this->request->getStrParam('city_name');
        $data['ap_area_name']   = $this->request->getStrParam('area_name');
        $data['ap_name']        = $this->request->getStrParam('ap_name');
        $data['ap_weight']      = $this->request->getIntParam('ap_weight');
        $data['ap_create_time'] = time();
        $park_model  = new App_Model_Park_MysqlAddressParkStorage();
        if(!$data['ap_pro'] || !$data['ap_city'] || !$data['ap_area'] || !$data['ap_name'] || !$data['ap_weight']){
            $this->displayJsonError('请完善资料');
        }
        if($id){
            $ret = $park_model->updateById($data,$id);
        }else{
            $data['ap_s_id'] = $this->curr_sid;
            $ret = $park_model->insertValue($data);
        }
        if($ret){
            $this->displayJsonSuccess(array(),true,'保存成功');
        }else{
            $this->displayJsonError('保存失败');
        }
    }


    // 根据省获得市
    public function getcityAction(){
        $pro = $this->request->getParam('pro');
        //var_dump($pro);exit;
        $area_model = new App_Model_Address_MysqlAddressCoreStorage();
        $city = $area_model->get_city_by_parent($pro);
        echo json_encode($city);
    }
    // 根据市获得县区
    public function getareaAction(){
        $city = $this->request->getParam('city');
        $area_model = new App_Model_Address_MysqlAddressCoreStorage();
        $area = $area_model->get_area_by_parent($city);
        echo json_encode($area);
    }


}