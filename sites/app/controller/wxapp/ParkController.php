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
        $this->output['type'] = 1;
        $this->output['type_name'] = 'stationList';
        $this->displaySmarty('wxapp/park/house-list.tpl');
    }


    //办公室列表
    public function officeListAction(){
        $page   = $this->request->getIntParam('page');
        $this->houseList($page,2);
        $this->buildBreadcrumbs(array(
            array('title' => '办公室列表', 'link' => '#'),
        ));
        $this->output['type'] = 2;
        $this->output['type_name'] = 'officeList';
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
        $id  = $this->request->getIntParam('id');
        $type  = $this->request->getIntParam('type');
        $address_model = new App_Model_Address_MysqlAddressCoreStorage();
        $this->output['province'] = $address_model->get_province();
        if($id){
            $resource_model = new App_Model_Resources_MysqlResourcesStorage();
            $row            = $resource_model->getRowById($id);
            $this->output['row'] = $row;
            $city           = $address_model->get_city_by_parent($row['ahr_province']);
            $this->output['city'] = $city;
            $area = $address_model->get_area_by_parent($row['ahr_city']);
            $this->output['area'] = $area;
            $park_model = new App_Model_Park_MysqlAddressParkStorage();
            $this->output['park'] = $park_model->get_park_by_parent($row['ahr_park']);
        }
        $this->output['type'] = $type;
        $this->buildBreadcrumbs(array(
            array('title' => '编辑工位', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/park/add-house.tpl');
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
        $data['ahr_stock']      = $this->request->getIntParam('stock');
        //$data['ahr_area']       = $this->request->getFloatParam('area');
        $data['ahr_type']       = $this->request->getStrParam('type');
        $data['ahr_address']    = $this->request->getStrParam('address');//地址
        $data['ahr_lng']        = $this->request->getStrParam('lng');//经纬度
        $data['ahr_lat']        = $this->request->getStrParam('lat');;
        $data['ahr_content']    = $this->request->getStrParam('detail');
        $data['ahr_cover']      = $this->request->getStrParam('slide_0');
        $data['ahr_province']   = $this->request->getIntParam('province');;
        $data['ahr_city']       = $this->request->getIntParam('city');
        $data['ahr_zone']       = $this->request->getIntParam('zone');
        $data['ahr_park']       = $this->request->getIntParam('park');
        $data['ahr_province_name']   = $this->request->getStrParam('pro_name');;
        $data['ahr_city_name']       = $this->request->getStrParam('city_name');
        $data['ahr_zone_name']       = $this->request->getStrParam('zone_name');
        $data['ahr_park_name']       = $this->request->getStrParam('park_name');


        $data['ahr_s_id']       = $this->curr_sid;
        $data['ahr_price']      = $this->request->getFloatParam('rentPrice');

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
            App_Helper_OperateLog::saveOperateLog("【{$data['ahr_title']}】保存成功");
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
    // 根据区获得园区
    public function getparkAction(){
        $zone = $this->request->getParam('zone');
        $park_model = new App_Model_Park_MysqlAddressParkStorage();
        $park = $park_model->get_park_by_parent($zone);

        echo json_encode($park);
    }

    public function batchSlide($resId,$is_add=0){
        $slide_model    = new App_Model_Resources_MysqlResourcesSlideStorage($this->curr_sid);
        $maxNum         = $this->request->getStrParam('slide-img-num');
        $slide          = array();
        if($is_add){
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                if($temp){
                    $slide[] = "(NULL, '{$this->curr_sid}', '{$resId}', 1,'{$temp}', 0, '".time()."')";
                }
            }
            $slide_model->batchSave($slide);
        }else{
            $sl_id = array();
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                $temp_id = $this->request->getIntParam('slide_id_'.$i);
                if($temp && $temp_id == 0){
                    $slide[] = $temp;
                }
                if($temp_id){
                    $sl_id[] = $temp_id;
                }
            }
            $del_id = array();
            $old_slide = $slide_model->getListByGidSid($resId,$this->curr_sid,1);
            foreach($old_slide as $val){
                if(!in_array($val['ahrs_id'],$sl_id)){
                    $del_id[] = $val['ahrs_id'];
                }
            }
            if(count($slide) <= count($del_id)){
                for($d=0 ; $d < count($del_id) ; $d++){
                    if(isset($slide[$d]) && $slide[$d]){
                        $slide_model->updateSlide($del_id[$d],$slide[$d]);
                        unset($del_id[$d]);
                    }
                }
                if(!empty($del_id)){
                    $slide_model->deleteSlide($resId,$del_id);
                }
            }else{
                $batch_slide = array();
                for($s=0 ; $s < count($slide) ; $s++){
                    if(isset($del_id[$s]) && $del_id[$s]){
                        $slide_model->updateSlide($del_id[$s],$slide[$s]);
                        unset($slide[$s]);
                    }else{
                        $sTemp = plum_sql_quote($slide[$s]);
                        $batch_slide[] = "(NULL, '{$this->curr_sid}', '{$resId}', 1,'{$sTemp}', 0, '".time()."')";
                    }
                }
                if(!empty($batch_slide)){
                    $slide_model->batchSave($batch_slide);
                }
            }
        }
    }
}