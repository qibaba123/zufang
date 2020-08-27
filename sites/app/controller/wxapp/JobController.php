<?php


class App_Controller_Wxapp_JobController extends App_Controller_Wxapp_InitController {


    public function __construct() {
        parent::__construct();
    }

    
    public function jobTemplateAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '小程序首页模板', 'link' => '#'),
        ));
        $cfg = plum_parse_config('category','applet');
        $tpl_ids = $cfg[28]['tpl'];
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $list       = $tpl_model->getListByTidSidType($tpl_ids,$this->curr_sid,3);
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        $row        = array();
        foreach($list as $val){
            if(empty($row) && $val['it_id'] == $cfg['ac_index_tpl']){
                $row = $val;
                break;
            }
        }
        $this->output['cfg']  = $cfg;
        $this->output['list'] = $list;
        $this->output['shop'] = $this->shops[$this->curr_sid];
        $this->output['row']  = $row;
        $this->displaySmarty('wxapp/job/job-template.tpl');
    }


    
    public function indexTplAction(){
        $tpl_id  = $this->request->getIntParam('tpl', 61);
        $this->_shop_default_tpl();
        $this->showIndexTpl($tpl_id);
        $this->showShopTplSlide($tpl_id);
        $this->_shop_information();
        $this->showShortcut($tpl_id);
        $this->_get_list_for_select();
        $this->_get_job_label_list();
        $this->_shop_kind_list_for_select();
        $this->_get_position_list();
        $this->_get_jump_list();
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '求职管理', 'link' => '#'),
            array('title' => '求职首页配置', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/job/index-tpl_'.$tpl_id.'.tpl');
    }

    
    private function _get_position_list(){

        $position_storage = new App_Model_Job_MysqlJobPositionStorage($this->curr_sid);
        $where[] = array('name' => 'ajp_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'ajp_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'ajp_deleted', 'oper' => '=', 'value' => 0);
        $positionList = $position_storage->getList($where, 0, 0);
        $data = array();
        if($positionList){
            foreach ($positionList as $val){
                $data[] = array(
                    'id'   => $val['ajp_id'],
                    'name' => $val['ajp_title'],
                );
            }
        }
        $this->output['positionList'] = json_encode($data);
    }

    
    private function _shop_kind_list_for_select(){
        $kind_model     = new App_Model_Job_MysqlJobCategoryStorage($this->curr_sid);
        $kind2 = $kind_model->getAllSonCategory(1,0);
        $data = array();
        if($kind2){
            foreach ($kind2 as $val){
                $data[] = array(
                    'id'   => $val['ajc_id'],
                    'name' => $val['ajc_name']
                );
            }
        }
        $kind1 = $kind_model->getAllFirstCategory(2,0);
        $firstKindSelect = array();
        if($kind1){
            foreach ($kind1 as $val){
                $firstKindSelect[] = array(
                    'id'   => $val['ajc_id'],
                    'name' => $val['ajc_name']
                );
            }
        }
        $company_model = new App_Model_Job_MysqlJobCompanyStorage($this->curr_sid);
        $where = [];
        $where[] = array('name' => 'ajc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'ajc_status', 'oper' => '=', 'value' => 2);
        $sort = array('ajc_create_time' => 'DESC');
        $kind3 = $company_model->getList($where,0,0,$sort);
        $companySelect = array();
        if($kind3){
            foreach ($kind3 as $val){
                $companySelect[] = array(
                    'id'   => $val['ajc_id'],
                    'name' => $val['ajc_company_name']
                );
            }
        }
        $this->output['kindSelect'] = json_encode($data);
        $this->output['firstKindSelect'] = json_encode($firstKindSelect);
        $this->output['companySelect'] = json_encode($companySelect);
    }

    
    private function _get_job_label_list(){
        $label_model = new App_Model_Job_MysqlJobLabelStorage($this->curr_sid);
        $labelList   = $label_model->getListBySid();
        $labels      = array();
        $partTimeLibels      = array();
        foreach ($labelList as $val){
            $labels[] = array(
                'id'    => $val['ajl_id'],
                'index' => $val['ajl_index'],
                'name'  => $val['ajl_name']
            );

        }
        $this->output['labels'] = json_encode($labels);
        $this->output['partTimeLabels'] = json_encode($partTimeLibels);

    }

    
    private function _shop_default_tpl(){
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        if(!$cfg['ac_index_tpl']){
            $data = array('ac_index_tpl'=>61);
            $applet_cfg->findShopCfg($data);
        }
    }

    
    private function showShortcut($tpl_id){
        $shortcut_model = new App_Model_Shop_MysqlShopShortcutStorage($this->curr_sid);
        $shortcut = $shortcut_model->fetchShortcutShowList($tpl_id);
        $json = array();
        foreach($shortcut as $key => $val){
            $json[] = array(
                'index'        => $key ,
                'title'        => $val['ss_name'],
                'imgsrc'       => $val['ss_icon'],
                'link'         => $val['ss_link'],
                'articleId'    => $val['ss_link'],
                'selectedSite' => array(
                    'id'   => $val['ss_link'],
                    'name' => $val['ss_name']
                ),
                'type'         => $val['ss_link_type']
            );
        }
        $this->output['shortcut'] = json_encode($json);
    }

    
    private function showIndexTpl($tpl_id=61){
        $tpl_model = new App_Model_Job_MysqlJobIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        $type = array(
            array('index'=>0,'name'=>'为您推荐','must'=>true,'type'=>'recommend'),
            array('index'=>1,'name'=>'附近职位','must'=>true,'type'=>'nearby'),
            array('index'=>2,'name'=>'高薪职位','must'=>true,'type'=>'fat'),
            array('index'=>3,'name'=>'内推职位','must'=>true,'type'=>'award')
        );

        if(empty($tpl)){
            $tpl = array(
                'aji_title'      => '店铺首页',
                'aji_search_tip' => '请输入职位',
                'aji_tpl_id'     => $tpl_id,
                'aji_stat_open'  => 0,
                'aji_enter_open'  => 0,
            );
        }

        if(!$tpl['aji_position_type']){
            $tpl['aji_position_type'] = json_encode($type);
        }else{
            $tpl['aji_position_type'] = $this->_remove_post_quotes($tpl['aji_position_type']);
        }
        if(empty($tpl['aji_open_job_time']))
            $tpl['aji_open_job_time']=0;
        $this->output['tpl'] = $tpl;
    }

    
    private function _remove_post_quotes($type){
        $type = json_decode($type,true);
        foreach ($type as $key => &$value){
            if($value['must']=='true'){
                $value['must'] = true;
            }else{
                $value['must'] = false;
            }
        }
        return json_encode($type);
    }


    
    private function _shop_information(){
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $sort          = array('ai_create_time' => 'DESC');
        $list          = $information_storage->getList($where,0,50,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'      => $val['ai_id'],
                    'title'   => $val['ai_title'],
                    'brief'   => $val['ai_brief'],
                    'cover'   => $val['ai_cover']
                );
            }
        }
        $this->output['information'] = json_encode($data);
    }


    private function _get_list_for_select(){
        $linkList = plum_parse_config('link','system');
        $linkType = plum_parse_config('link_type','system');
        $groupType = plum_parse_config('link_type_job','system');

        $link = $linkList[$this->wxapp_cfg['ac_type']];
        $noLink = array(
            array(
                'id'   => '0',
                'name' => '无跳转'
            ),
        );

        $this->output['linkList'] = json_encode($link);
        $this->output['linkType'] = json_encode(array_merge($noLink,$linkType,$groupType));
    }
    private function _save_job_labels($pType){
        if($pType == 3){
            $labels      = $this->request->getArrParam('partTimelabels');
        }else{
            $labels      = $this->request->getArrParam('labels');
        }

        $label_model = new App_Model_Job_MysqlJobLabelStorage($this->curr_sid);
        $labelList   = $label_model->getListBySid($pType);
        $delArr      = array();
        $update      = array();
        $labelIdArr  = array();
        foreach ($labels as $val){
            $labelIdArr[] = $val['id'];
        }

        foreach ($labelList as $val){
            $key = array_search($val['ajl_id'],$labelIdArr);
            if($key !== false){
                $update[] = $labels[$key];
                unset($labels[$key]);
            }else{
                $delArr[] = $val['ajl_id'];
            }
        }

        foreach ($update as $val){
            $set = array('ajl_name' => $val['name'], 'ajl_index' => $val['index']);
            $label_model->updateById($set, $val['id']);
        }

        $insert = array();
        foreach ($labels as $val){
            $insert[] =  " (NULL, '{$this->curr_sid}', '{$val['name']}', '{$val['index']}','".time()."', '0', '{$pType}') ";
        }
        $label_model->insertBatchLabel($insert);
        if(!empty($delArr)){
            $where[] = array('name' => 'ajl_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'ajl_id', 'oper' => 'in', 'value' => $delArr);
            $where[] = array('name' => 'ajl_p_type', 'oper' => '=', 'value' => $pType);
            $label_model->deleteValue($where);
        }
    }



    
    private function goods_category_son_data($isJson=1,$type,$pType = 2){
        $category_model = new App_Model_Job_MysqlJobCategoryStorage($this->curr_sid);
        $first          = $category_model->getListBySid($type,$pType);
        $temp           = array();
        foreach($first as $val){
            if($val['ajc_level'] == 1){
                $temp[$val['ajc_id']] = array(
                    'id'        => $val['ajc_id'],
                    'index'     => $val['ajc_weight'],
                    'firstName' => $val['ajc_name'],
                    'imgSrc'    => $val['ajc_logo'] ? $val['ajc_logo'] : '/public/manage/img/zhanwei/zw_fxb_640_200.png',
                    'imgShow'   => $val['ajc_logo_show'],
                    'secondItem'=> array(),
                );
            }elseif($val['ajc_fid'] > 0 && $val['ajc_level'] == 2){
                $temp[$val['ajc_fid']]['secondItem'][] = array(
                    'id'         => $val['ajc_id'],
                    'index'      => $val['ajc_weight'],
                    'secondName' => $val['ajc_name'],
                    'imgSrc'     => $val['ajc_logo'],
                    'link'       => ""
                );
            }

        }
        if($isJson){
            $category   = array();
            foreach($temp as $tal){
                $category[] = $tal;
            }
            return $category;
        }else{
            return $temp;
        }
    }

    private function _parse_job_cfg_data($id, $name, $key='title', $type='jobcfg'){
        $cfg = plum_parse_config($name, $type);
        foreach ($cfg as $value){
            if($value['id'] == $id){
                return $value[$key];
            }
        }
        return false;
    }


    
    private function _deal_shop_pass($id){
        $company_model = new App_Model_Job_MysqlJobCompanyStorage($this->curr_sid);
        $row = $company_model->getRowById($id);
        if($row['ajc_es_id'] != 0){
            $data['es_name']        = $row['ajc_company_name'];
            $data['es_cate1']       = $row['ajc_cate1'];
            $data['es_cate2']       = $row['ajc_cate2'];
            $data['es_brief']       = $row['ajc_brief'];
            $data['es_contact']     = $row['ajc_contacts'];
            $data['es_phone']       = $row['ajc_mobile'];
            $data['es_logo']        = $row['ajc_logo'];
            $data['es_addr']        = $row['ajc_addr'];
            $data['es_addr_detail'] = $row['ajc_addr_detail'];
            $data['es_lng']         = $row['ajc_lng'];
            $data['es_lat']         = $row['ajc_lat'];
            $data['es_license']     = $row['ajc_license'];
            $data['es_open_time']   = time();
            $data['es_expire_time'] = time() + 365*24*60*60;
            $data['es_status']      = 0;
            $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
            $es_id    = $es_model->updateById($data, $row['ajc_es_id']);
            if ($es_id) {
                $manager_model = new App_Model_Entershop_MysqlManagerStorage();
                $mData['esm_status'] = 0;
                $manager_model->updateByEsId($mData, $es_id);
            }
        }
    }

    
    private function utf8_str_to_unicode($utf8_str) {
        $unicode_str = '';
        for($i=0;$i<mb_strlen($utf8_str);$i++){
            $val = mb_substr($utf8_str,$i,1,'utf-8');
            if(strlen($val) >= 4){
                $unicode = (ord($val[0]) & 0xF) << 18;
                $unicode |= (ord($val[1]) & 0x3F) << 12;
                $unicode |= (ord($val[2]) & 0x3F) << 6;
                $unicode |= (ord($val[3]) & 0x3F);
                $unicode_str.= '<span class="emoji-inner emoji'.dechex($unicode).'"></span>';
            }else{
                $unicode_str.=$val;
            }
        }
        return $unicode_str;
    }

    
    public function positionListAction(){
        $this->_show_position_list();
        $this->buildBreadcrumbs(array(
            array('title' => '职位管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/job/position-list.tpl');
    }

    
    private function _show_position_list($pType = 0){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = array();
        $this->output['name'] = $this->request->getStrParam('name');
        if($this->output['name']){
            $where[]        = array('name' => 'ajp_title', 'oper' => 'like', 'value' => "%{$this->output['name']}%");
        }
        $this->output['company'] = $this->request->getStrParam('company');
        if($this->output['company']){
            $where[]        = array('name' => 'ac.ajc_company_name', 'oper' => 'like', 'value' => "%{$this->output['company']}%");
        }
        $this->output['id'] = $this->request->getStrParam('id');
        if($this->output['id']){
            $where[]        = array('name' => 'ajp_id', 'oper' => '=', 'value' => $this->output['id']);
        }

        $searchType = $this->request->getIntParam('search_type',0);
        $pType = $searchType ? $searchType : $pType;

        if($pType == 3){
            $where[]        = array('name' => 'ajp_type', 'oper' => '=', 'value' => 3);
        }else if ($pType == 4){
            $where[]        = array('name' => 'ajp_type', 'oper' => '=', 'value' => 4);
        }else{
            $where[]        = array('name' => 'ajp_type', 'oper' => 'in', 'value' => [1,2]);
        }
        $this->output['pType'] = $pType;

        $this->output['search_province']     = $this->request->getStrParam('search_province');
        $this->output['search_city']     = $this->request->getStrParam('search_city');
        if($this->output['search_city']){
            $amap_model = new App_Model_App_MysqlAmapStorage();
            $amap = $amap_model->getRowById($this->output['search_city']);
            $where[] = array('name' => 'ajp_city_code','oper' => '=','value' =>$amap['aa_city_code']);
        }

        $position_model = new App_Model_Job_MysqlJobPositionStorage($this->curr_sid);
        $where[]    = array('name' => 'ajp_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'ajp_deleted', 'oper' => '=', 'value' => 0);
        $total      = $position_model->getPositionCategoryCompanyCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $list          = $position_model->getPositionCategoryCompanyList($where, $index,$this->count);
        }
        $this->output['list'] = $list;
        $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->curr_sid);
        $this->output['costList'] = $cost_storage->findListBySid();
    }

    
    private function _get_job_label($job){
        $label  = array();
        $label_model = new App_Model_Job_MysqlJobPositionLabelStorage(0);
        $labelList   = $label_model->getLabelListNameByPId($job['ajp_id']);
        foreach ($labelList as $value){
            $label[] = $value['ajl_name'];
        }
        $custom = json_decode($job['ajp_custom_label'], true);
        $labels = array_merge($label, $custom);
        $labelStr = '';
        foreach ($labels as $index => $val){
            if($val){
                if($index < (count($labels)-1)){
                    $labelStr .= ($val.",");
                }else{
                    $labelStr .= ($val);
                }
            }
        }
        return $labelStr;
    }

    
    public function resumeListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = array();

        $search_city = 0;
        $this->output['search_province']     = $this->request->getStrParam('search_province');
        $this->output['search_city']     = $this->request->getStrParam('search_city');
        if($this->output['search_city']){
            $where[] = array('name' => 'ajrc_city_id','oper' => '=','value' =>$this->output['search_city']);
            $search_city = 1;
        }

        $resume_model = new App_Model_Job_MysqlJobResumeStorage($this->curr_sid);
        $where[]    = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        if($search_city){
            $total      = $resume_model->getCityResumeMemberCount($where);
        }else{
            $total      = $resume_model->getCount($where);
        }

        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            if($search_city){
                $list          = $resume_model->getCityResumeMemberList($where, $index,$this->count);
            }else{
                $list          = $resume_model->getResumeMemberList($where, $index,$this->count);
            }

        }

        $where = array();
        $where[]    = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'ajr_public', 'oper' => '=', 'value' => 1);
        $publicTotal    = $resume_model->getCount($where);
        $where = array();
        $where[]    = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'ajr_public', 'oper' => '=', 'value' => 0);
        $privateTotal   = $resume_model->getCount($where);

        $this->output['publicTotal'] = $publicTotal;
        $this->output['privateTotal'] = $privateTotal;
        $this->output['total'] = $total;
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '简历管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/job/resume-list.tpl');
    }

    
    private function _get_age($age){
        list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age));
        $now = strtotime("now");
        list($y2,$m2,$d2) = explode("-",date("Y-m-d",$now));
        $age = $y2 - $y1;
        if((int)($m2.$d2) < (int)($m1.$d1))
            $age -= 1;
        return $age;
    }
    private function _get_work_experience($id){
        if($id){
            $expreience_model = new App_Model_Job_MysqlJobWorkExperienceStorage($this->curr_sid);
            $list = $expreience_model->getListByRId($id);
            $this->output['workExperience'] = $list;
        }
    }
    private function _get_education_experience($id){
        if($id){
            $expreience_model = new App_Model_Job_MysqlJobEducationExperienceStorage($this->curr_sid);
            $list = $expreience_model->getListByRId($id);
            foreach ($list as $key => $value){
                $list[$key]['ajee_education'] = $this->_parse_job_cfg_data($value['ajee_education']?$value['ajee_education']:1, 'education');
            }
            $this->output['educationExperience'] = $list;
        }
    }
    private function _get_object_experience($id){
        if($id){
            $expreience_model = new App_Model_Job_MysqlJobObjectExperienceStorage($this->curr_sid);
            $list = $expreience_model->getListByRId($id);
            $this->output['objectExperience'] = $list;
        }

    }

    
    private function _get_prov_city(){
        $company_storage = new App_Model_Member_MysqlCompanyCoreStorage();
        $company = $company_storage->getRowById($this->curr_shop['s_c_id']);
        $data = array(
            'prov'      => $company['c_province'],
            'city'      => $company['c_city'],
        );
        return $data;
    }

    
    private function _get_job_label_edit($job){
        $lable  = array();
        $label_model = new App_Model_Job_MysqlJobPositionLabelStorage($this->curr_sid);
        $labelList   = $label_model->getLabelListNameByPId($job['ajp_id']);
        foreach ($labelList as $value){
            $lable[] = $value['ajl_name'];
        }
        return $lable;
    }
    public function _get_address_by_lat_lng($lng=0,$lat=0){
        
        if(!$lng || !$lat){
            $lat   =  $this->request->getStrParam('lat');
            $lng   =  $this->request->getStrParam('lng');
        }
        if($lat && $lng){
            $key  =  plum_parse_config('mapKay');
            $ret  =  Libs_Http_Client::get('http://restapi.amap.com/v3/geocode/regeo?output=json&location='.$lng.','.$lat.'&key='.$key.'&radius=1000&extensions=all');
            $ret_arr = json_decode($ret,1);
            $adr  =  $ret_arr['regeocode']['formatted_address'];
            $province = $ret_arr['regeocode']['addressComponent']['province'];
            $adcode = $ret_arr['regeocode']['addressComponent']['adcode'];
            $citycode = $ret_arr['regeocode']['addressComponent']['citycode'];
            $city  = $ret_arr['regeocode']['addressComponent']['city'];
            $district = $ret_arr['regeocode']['addressComponent']['district'];
            $township = $ret_arr['regeocode']['addressComponent']['township'];
            $building = $ret_arr['regeocode']['addressComponent']['building']['name'];
            if(!$building){
                $building = $ret_arr['regeocode']['addressComponent']['neighborhood']['name'];
            }

            $data = array(
                'address' => str_replace($province.$city, '', $adr),
                'building' => $building?$building:str_replace($province.$city, '', $adr),
                'prov' => $province,
                'adcode' => $adcode,
                'citycode' => $citycode,
                'district' => is_array($district)?(is_array($township)?'':$township):$district,
                'city' => $city?$city:($province ? $province : ''),
            );
        }else{
            $company_storage = new App_Model_Member_MysqlCompanyCoreStorage();
            $company = $company_storage->getRowById($this->shop['s_c_id']);
            $data = array(
                'address'   => $company['c_province'].$company['c_city'],
                'building'  => '',
                'prov'      => $company['c_province'],
                'city'      => $company['c_city'],
            );
        }
        return $data;
    }

    private function _get_position_desc_img(){
        $maxNum         = $this->request->getStrParam('slide-img-num');
        $slide          = array();
        for($i=0; $i< $maxNum; $i++){
            $temp = $this->request->getStrParam('slide_'.$i);
            $temp = plum_sql_quote($temp);
            $slide[] = $temp;
        }
        return json_encode($slide);
    }

    
    private function _save_position_label($id){
        $label = $this->request->getStrParam('labels');
        $company = $this->request->getIntParam('company');
        $label = json_decode($label, true);
        $label_model = new App_Model_Job_MysqlJobPositionLabelStorage($this->curr_sid);
        $labelList = $label_model->getLabelListByPId($id);
        $delArr = array();
        foreach ($labelList as $val){
            $key = array_search($val['ajpl_l_id'],$label);
            if($key !== false){
                unset($label[$key]);
            }else{
                $delArr[] = $val['ajpl_l_id'];
            }
        }
        $insert = array();
        foreach ($label as $val){
            $insert[] =  " (NULL, '{$this->curr_sid}', '{$company}', '{$id}', '{$val}','0', '".time()."') ";
        }
        $label_model->insertBatchPostCategory($insert);
        if(!empty($delArr)){
            $where[] = array('name' => 'ajpl_ajp_id', 'oper' => '=', 'value' => $id);
            $where[] = array('name' => 'ajpl_l_id', 'oper' => 'in', 'value' => $delArr);
            $label_model->deleteValue($where);
        }
    }

    
    public function startAppletTplAction(){
        $result     = array(
            'ec'    => 400,
            'em'    => '该模版不可用'
        );
        $id         = $this->request->getIntParam('id');
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row        = $tpl_model->getRowBySid($id,$this->curr_sid);
        if($row || $id==0){
            $set = array(
                'ac_index_tpl'   => $id,
                'ac_update_time' => time()
            );
            $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            $ret = $applet_cfg->findShopCfg($set);
            if($ret){
                $result     = array(
                    'ec'    => 200,
                    'em'    => ' 启用成功'
                );
                App_Helper_OperateLog::saveOperateLog("首页模板【{$row['it_name']}】启用成功");

            }else{
                $result['em'] = '启用失败';
            }
        }
        $this->displayJson($result);
    }

    
    private function _get_shop_son_category($type = 1){
        $category_model = new App_Model_Job_MysqlJobCategoryStorage($this->curr_sid);
        $kind2 = $category_model->getAllSonCategory($type,0,0);
        $kind2_data = array();
        foreach ($kind2 as $val){
            $kind2_data[$val['ajc_fid']][] = array(
                'id'        => $val['ajc_id'],
                'name'      => $val['ajc_name'],
            );
        }
        return $kind2_data;
    }

    
    private function _get_city_list_new(){
        $address_model = new App_Model_App_MysqlAmapStorage();
        $cityList = $address_model->getCity();
        $data = array();
        foreach($cityList as $val){
            $data[] = array(
                'id'   => $val['aa_id'],
                'name' => $val['aa_region_name'],
                'code' => $val['aa_city_code'],
            );
        }

        $cityList = array_values($this->groupByInitials($data, 'name'));
        $this->output['cityList'] = json_encode($cityList,JSON_UNESCAPED_UNICODE);
    }

    
    private function _get_city_list(){
        $address_model = new App_Model_Address_MysqlAddressCoreStorage();
        $cityList = $address_model->get_city();
        $data = array();
        foreach($cityList as $val){
            $data[] = array(
                'id'   => $val['region_id'],
                'name' => $val['region_name'],
            );
        }

        $cityList = array_values($this->groupByInitials($data, 'name'));
        $this->output['cityList'] = json_encode($cityList,JSON_UNESCAPED_UNICODE);
    }


    private function groupByInitials(array $data, $targetKey = 'name')
    {
        $data = array_map(function ($item) use ($targetKey) {
            return array_merge($item, [
                'initials' => $this->getInitials($item[$targetKey]),
            ]);
        }, $data);
        $data = $this->sortInitials($data);
        return $data;
    }

    
    private function sortInitials(array $data)
    {
        $sortData = [];
        foreach ($data as $key => $value) {
            $sortData[$value['initials']][] = $value;
        }
        ksort($sortData);
        $result = array(
            array(
                'name'  => 'ABCDEF',
                'citys' => [],
            ),
            array(
                'name'  => 'GHIJ',
                'citys' => [],
            ),
            array(
                'name'  => 'KLMN',
                'citys' => [],
            ),
            array(
                'name'  => 'OPQR',
                'citys' => [],
            ),
            array(
                'name'  => 'STUV',
                'citys' => [],
            ),
            array(
                'name'  => 'WXYZ',
                'citys' => [],
            ),
        );
        foreach ($sortData as $citys){
            foreach ($citys as $val){
                foreach ($result as $key => $value){
                    if(strpos($result[$key]['name'],$val['initials']) !== false){
                        $result[$key]['citys'][] = $val;
                    }
                }
            }
        }
        return $result;
    }

    
    private function getInitials($str)
    {
        if (empty($str)) {return '';}
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z')) {
            return strtoupper($str{0});
        }

        $s1  = iconv('UTF-8', 'gb2312', $str);
        $s2  = iconv('gb2312', 'UTF-8', $s1);
        $s   = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284) {
            return 'A';
        }

        if ($asc >= -20283 && $asc <= -19776) {
            return 'B';
        }

        if ($asc >= -19775 && $asc <= -19219) {
            return 'C';
        }

        if ($asc >= -19218 && $asc <= -18711) {
            return 'D';
        }

        if ($asc >= -18710 && $asc <= -18527) {
            return 'E';
        }

        if ($asc >= -18526 && $asc <= -18240) {
            return 'F';
        }

        if ($asc >= -18239 && $asc <= -17923) {
            return 'G';
        }

        if ($asc >= -17922 && $asc <= -17418) {
            return 'H';
        }

        if ($asc >= -17417 && $asc <= -16475) {
            return 'J';
        }

        if ($asc >= -16474 && $asc <= -16213) {
            return 'K';
        }

        if ($asc >= -16212 && $asc <= -15641) {
            return 'L';
        }

        if ($asc >= -15640 && $asc <= -15166) {
            return 'M';
        }

        if ($asc >= -15165 && $asc <= -14923) {
            return 'N';
        }

        if ($asc >= -14922 && $asc <= -14915) {
            return 'O';
        }

        if ($asc >= -14914 && $asc <= -14631) {
            return 'P';
        }

        if ($asc >= -14630 && $asc <= -14150) {
            return 'Q';
        }

        if ($asc >= -14149 && $asc <= -14091) {
            return 'R';
        }

        if ($asc >= -14090 && $asc <= -13319) {
            return 'S';
        }

        if ($asc >= -13318 && $asc <= -12839) {
            return 'T';
        }

        if ($asc >= -12838 && $asc <= -12557) {
            return 'W';
        }

        if ($asc >= -12556 && $asc <= -11848) {
            return 'X';
        }

        if ($asc >= -11847 && $asc <= -11056) {
            return 'Y';
        }

        if ($asc >= -11055 && $asc <= -10247) {
            return 'Z';
        }
        if($str == '濮阳'){
            return 'P';
        }
        if($str == '亳州'){
            return 'B';
        }
        if($str == '儋州'){
            return 'D';
        }
        if($str == '漯河'){
            return 'L';
        }
        if($str == '泸州'){
            return 'L';
        }
        if($str == '衢州'){
            return 'Q';
        }
        return '';
    }

    
    private function _get_part_time_label($pType = 3){
        $project_model = new App_Model_Job_MysqlJobLabelStorage($this->curr_sid);
        $list = $project_model->getListBySid($pType);
        $data = [];
        if($list){
            foreach ($list as $key => $val){
                $data[] = array(
                    'id'    => $val['ajl_id'],
                    'index' => $val['ajl_index'],
                    'name'  => $val['ajl_name']
                );
            }
        }
        return $data;
    }


    
    private function _save_part_time_label($pType){
        if($pType == 3){
            $labels      = $this->request->getArrParam('partTimeLabel');
        }elseif ($pType == 4){
            $labels      = $this->request->getArrParam('workTimeLabel');
        }else{
            return false;
        }

        $label_model = new App_Model_Job_MysqlJobLabelStorage($this->curr_sid);
        $labelList   = $label_model->getListBySid($pType);
        $delArr      = array();
        $update      = array();
        $labelIdArr  = array();
        foreach ($labels as $val){
            $labelIdArr[] = $val['id'];
        }

        foreach ($labelList as $val){
            $key = array_search($val['ajl_id'],$labelIdArr);
            if($key !== false){
                $update[] = $labels[$key];
                unset($labels[$key]);
            }else{
                $delArr[] = $val['ajl_id'];
            }
        }

        foreach ($update as $val){
            $set = array('ajl_name' => $val['name'], 'ajl_index' => $val['index']);
            $label_model->updateById($set, $val['id']);
        }

        $insert = array();
        foreach ($labels as $val){
            $insert[] =  " (NULL, '{$this->curr_sid}', '{$val['name']}', '{$val['index']}','".time()."', '0', '{$pType}') ";
        }
        $label_model->insertBatchLabel($insert);
        if(!empty($delArr)){
            $where[] = array('name' => 'ajl_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'ajl_id', 'oper' => 'in', 'value' => $delArr);
            $where[] = array('name' => 'ajl_p_type', 'oper' => '=', 'value' => $pType);
            $label_model->deleteValue($where);
        }
        return true;
    }

    
    public function changeOpenAction(){
        $result = array(
            'ec' => 400,
            'em' => '修改失败'
        );
        $type    = $this->request->getStrParam('type');
        $value   = $this->request->getStrParam('value');

        $status = $value == 'on' ? 1 : 0;
        $status_note = $status == 1 ? '启用' : '禁用';
        $type_note = '';
        if ($type == 'companyAutoPass') {
            $type_note = '公司自动审核';
            $data['aji_company_auto_pass'] = $status;
        }
        $data['aji_update_time'] = time();
        $send_storage = new App_Model_Job_MysqlJobIndexStorage($this->curr_sid);
        $exist = $send_storage->findUpdateBySid(61);
        if($exist) {
            $ret = $send_storage->findUpdateBySid(61, $data);
        }else{
            $data['aji_s_id'] = $this->curr_sid;
            $data['aji_create_time'] = time();
            $ret = $send_storage->insertValue($data);
        }
        if ($ret) {
            $result = array(
                'ec' => 200,
                'em' => ' 修改成功'
            );
            if($status_note && $type_note){
                App_Helper_OperateLog::saveOperateLog($type_note.$status_note."成功");
            }
        }
        $this->displayJson($result);
    }
}
