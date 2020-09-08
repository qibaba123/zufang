<?php



class App_Controller_Wxapp_ParkController extends App_Controller_Wxapp_InitController{


    public function __construct() {
        parent::__construct();
    }

    //工位列表
    public function stationListAction(){
        $page   = $this->request->getIntParam('page');
        $this->houseList($page,1);
        $this->buildBreadcrumbs(array(
            array('title' => '工位列表', 'link' => '#'),
        ));
        $this->output['type'] = 'stationList';
        $this->displaySmarty('wxapp/park/house-list.tpl');
    }


    //办公室列表
    public function officeListAction(){
        $page   = $this->request->getIntParam('page');
        $this->houseList($page,2);
        $this->buildBreadcrumbs(array(
            array('title' => '办公室列表', 'link' => '#'),
        ));
        $this->output['type'] = 'officeList';
        $this->displaySmarty('wxapp/park/house-list.tpl');
    }


    //园区资源列表
    public function houseList($page,$type){
        $index  = $page * $this->count;
        $resource_model = new App_Model_Resources_MysqlResourcesStorage();
        $where[] = array('name'=>"ahr_type",'oper'=>'=','value'=>$type);
        $list    = $resource_model->getList($where,$index,$this->count,array('ahr_weight'=>'DESC'));
        $total   = $resource_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pageHtml']  = $pageCfg->render();
        $this->output['list']      = $list;
    }

    //新增或编辑工位
    public function addHouseAction(){

        $this->buildBreadcrumbs(array(
            array('title' => '编辑工位', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/park/house-list.tpl');
    }


    //保存工位
    public function saveHouseAction(){
        $result = array(
            'ec' => 400,
            'em' => '请填写完整房源信息'
        );
        $id       = $this->request->getIntParam('id');
        $data     = array();
        $data['ahr_title']      = $this->request->getStrParam('title');
        $data['ahr_community']  = $this->request->getStrParam('community');
        $data['ahr_area']       = $this->request->getFloatParam('area');
        $data['ahr_home_num']   = $this->request->getIntParam('home_num');
        $data['ahr_hall_num']   = $this->request->getIntParam('hall_num');
        $data['ahr_toilet_num']   = $this->request->getIntParam('toilet_num');
        $data['ahr_orientation']= $this->request->getStrParam('orientation');//朝向
        $data['ahr_floor']      = $this->request->getStrParam('floor');
        $data['ahr_all_floor']  = $this->request->getStrParam('all_floor');
        $data['ahr_type']       = $this->request->getStrParam('type');
        $data['ahr_fitment']    = $this->request->getStrParam('fitmentType');
        $data['ahr_orientation']     = $this->request->getStrParam('orientation');
        $data['ahr_build_time'] = $this->request->getStrParam('build_time');
        $data['ahr_address']    = $this->request->getStrParam('address');//地址
        $data['ahr_lng']        = $this->request->getStrParam('lng');//经纬度
        $data['ahr_lat']        = $this->request->getStrParam('lat');
        $data['ahr_contact']    = $this->request->getStrParam('contact');
        $data['ahr_mobile']     = $this->request->getStrParam('mobile');
        $data['ahr_weixin']     = $this->request->getStrParam('weixin');
        $data['ahr_content']    = $this->request->getStrParam('detail');
        $data['ahr_cover']      = $this->request->getStrParam('slide_0');
        $data['ahr_sale_type']  = $this->request->getIntParam('saleType');
        $data['ahr_province']   = $this->request->getIntParam('province');;
        $data['ahr_city']       = $this->request->getIntParam('city');
        $data['ahr_zone']       = $this->request->getIntParam('zone');
        $data['ahr_video_url']  = $this->request->getStrParam('video');
        $data['ahr_vr_url']     = $this->request->getStrParam('vr');
        if($this->request->getStrParam('label')){
            $data['ahr_label']       = json_encode(explode('/',$this->request->getStrParam('label')));
        }else{
            $data['ahr_label'] = '';
        }

        $data['ahr_resource_source']  = $this->request->getIntParam('resourceSource');

        $data['ahr_s_id']       = $this->curr_sid;
        if($data['ahr_sale_type'] == 1){
            $data['ahr_price']      = $this->request->getFloatParam('salePrice');
        }else{
            $data['ahr_price']      = $this->request->getFloatParam('rentPrice');
        }

        $resources_model = new App_Model_Resources_MysqlResourcesStorage();
        $is_add = 0;
        if($id){
            $data['ahr_update_time']= $_SERVER['REQUEST_TIME'];
            $ret = $resources_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
        }else{
            $data['ahr_create_time']= $_SERVER['REQUEST_TIME'];
            $ret = $resources_model->insertValue($data);
            $id  = $ret;
            $is_add = 1;
        }
        if($ret){
            $this->batchSlide($id,$is_add);
            $result = array(
                'ec' => 200,
                'em' => '保存成功',
            );
            App_Helper_OperateLog::saveOperateLog("房源【{$data['ahr_title']}】保存成功");
        }else{
            $result['em'] = '保存失败';
        }
        $this->displayJson($result);
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
        $this->buildBreadcrumbs(array(
            array('title' => '新增园区', 'link' => '#'),
        ));
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