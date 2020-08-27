<?php


class App_Controller_Wxapp_TrainController extends App_Controller_Wxapp_OrderCommonController {
    public function __construct() {
        parent::__construct();

    }


    
    public function trainTemplateAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '小程序首页模板', 'link' => '#'),
        ));
        $cfg = plum_parse_config('category','applet');
        $tpl_ids = $cfg[12]['tpl'];
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
        $this->output['list'] = $list;
        $this->output['shop'] = $this->shops[$this->curr_sid];
        $this->output['row']  = $row;
        $this->displaySmarty('wxapp/train/train-template.tpl');
    }



    
    public function indexTplAction(){
        $tpl_id  = $this->request->getIntParam('tpl', 11);
        $this->_shop_default_tpl();
        $this->showIndexTpl($tpl_id);
        $this->showShopTplSlide($tpl_id);
        $this->_show_tpl_course($tpl_id);
        $this->_show_tpl_student($tpl_id);
        $this->_show_shop_article();
        $this->_show_tpl_notice();
        $this->_show_tpl_teacher();
        $this->_shop_information();
        $this->showActiveList($tpl_id);
        $this->_select_course_list();
        $this->showShopTplShortcut($tpl_id);
        $this->_shop_mobile_address();
        $this->_get_list_for_select($tpl_id);
        $this->_get_information_category();
        $this->_select_course_cate_list();
        $this->_get_course_index_list($tpl_id);
        $this->_get_custom_form_list();
        $this->_get_jump_list();
        $this->renderCropTool('/wxapp/index/uploadImg');

        $this->displaySmarty('wxapp/train/index-tpl_'.$tpl_id.'.tpl');

    }

    
    private function _get_custom_form_list(){
        $form_model = new App_Model_Applet_MysqlCustomFormStorage();
        $where[] = array('name' => 'acf_s_id' , 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acf_deleted' , 'oper' => '=', 'value' => 0);
        $list = $form_model->getList($where);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id' => $val['acf_id'],
                    'name' => $val['acf_header_title']
                );
            }
        }
        $this->output['formlist'] = json_encode($data);
    }

    
    private function _shop_default_tpl(){
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        if(!$cfg['ac_index_tpl']){
            $data = array('ac_index_tpl'=>11);
            $applet_cfg->findShopCfg($data);
        }
    }

    
    private function showIndexTpl($tpl_id=11){
        $tpl_model = new App_Model_Train_MysqlTrainIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'ati_title'         => '首页',
                'ati_course_title'  => '推荐课程',
                'ati_coach_title'   => '师资力量',
                'ati_field_title'   => '学员风采',
                'ati_commendInfo_title' => '资讯',
                'ati_infoBox_title' => '推荐资讯',
                'ati_address'       => '这里填写地址',
                'ati_lng'           => '113.72052',
                'ati_lat'           => '34.77485',
                'ati_tpl_id'        => $tpl_id,
            );
        }
        if($tpl_id == 56) {
            $infoBox = json_decode($tpl['ati_infoBox_data'], 1);
            $this->output['infoBox'] = $infoBox ? json_encode($infoBox) : json_encode([
                [
                    'index' => 0,
                    'title' => '标题一',
                    'brief' => '标题二',
                    'link' => 0
                ],
                [
                    'index' => 1,
                    'title' => '标题一',
                    'brief' => '标题二',
                    'link' => 0
                ]
            ]);
        }
        $this->output['tpl'] = $tpl;
    }

    
    private function _get_course_index_list($tpl_id = 56){
        $courseIndex_storage = new App_Model_Train_MysqlTrainCourseIndexStorage($this->curr_sid);
        $list = $courseIndex_storage->fetchCourseIndexShowList(0,8,$tpl_id);
        $courseIndex = array();
        if($list){
            foreach ($list as $val){
                $courseIndex[] = array(
                    'index' => $val['atci_weight'],
                    'title' => $val['atci_title'],
                    'link'  => $val['atci_link'],
                );
            }
        }
        $this->output['courseIndex'] = json_encode($courseIndex);

    }

    
    private function _show_tpl_teacher(){
        $teacher_storage = new App_Model_Train_MysqlTrainTeacherStorage($this->curr_sid);
        $where[]      = array('name' => 'att_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $teacher_list = $teacher_storage->getList($where, 0, 4, array('att_weight' => 'ASC'));
        $data = array();
        if($teacher_list){
            foreach ($teacher_list as $val){
                $data[] = array(
                    'index'     => $val['att_weight'],
                    'name'      => $val['att_name'],
                    'imgsrc'    => $val['att_avatar'],
                    'courseFl'  => $val['att_course'],
                    'aptitudes' => $val['att_grade'],
                    'content'   => $val['att_content'],
                    'brief'     => $val['att_brief'],
                    'classifyList' => json_decode($val['att_tags'])
                );
            }
        }
        $this->output['teacherList'] = json_encode($data);
    }

    
    private function _show_shop_article(){
        $article_model     = new App_Model_Applet_MysqlAppletArticleStorage();
        $where         = array();
        $where[]       = array('name'=>'aa_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]       = array('name'=>'aa_deleted','oper'=>'=','value'=>0);
        $sort          = array('aa_create_time' => 'DESC');
        $list          = $article_model->getList($where,0,0,$sort);
        $json = array();
        foreach ($list as $key => $value) {
            $json[] = array(
                'id'      => $value['aa_id'],
                'name'    => $value['aa_title'],
            );
        }
        $this->output['articles'] = json_encode($json);
    }

    
    private function _shop_information(){
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $sort          = array('ai_isrecommend' => 'DESC','ai_sort' => 'DESC','ai_create_time' => 'DESC');
        $list          = $information_storage->getList($where,0,50,$sort);
        $data = array();
        $dataCate = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'      => $val['ai_id'],
                    'title'   => $val['ai_title'],
                    'brief'   => $val['ai_brief'],
                    'cover'   => $val['ai_cover']
                );
            }

            foreach ($list as $value){
                $dataCate[$value['ai_category']][] = array(
                    'id'      => $value['ai_id'],
                    'title'   => $value['ai_title'],
                    'brief'   => $value['ai_brief'],
                    'cover'   => $value['ai_cover'],
                    'show'    => $value['ai_show_num']
                );
            }
        }
        $this->output['information'] = json_encode($data);
        $this->output['informationCate'] = json_encode($dataCate);
    }

    
    private function _get_information_category(){
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $list = $category_storage->getListBySid();
        $category_select = $category_storage->getCategoryListForSelect();
        $categoryList = array();
        if($list){
            foreach ($list as $key => $val){
                $categoryList[] = array(
                    'id'    => $val['aic_id'],
                    'index' => $key,
                    'name'  => $val['aic_name']
                );
            }
        }
        $this->output['categoryList'] = json_encode($categoryList);
        $this->output['category'] = $list;
        $this->output['category_select'] = $category_select;
    }

    
    public function showShopTplShortcut($tpl_id=31){
        $shortcut_model = new App_Model_Shop_MysqlShopShortcutStorage($this->curr_sid);
        $shortcut = $shortcut_model->fetchShortcutShowList($tpl_id);
        $json = array();
        foreach($shortcut as $key => $val){
            $json[] = array(
                'index'        => $val['ss_weight'] ,
                'title'        => $val['ss_name'],
                'imgsrc'       => $val['ss_icon'],
                'link'         => $val['ss_link'],
                'articleId'    => $val['ss_link'],
                'articleTitle' => $val['ss_article_title'],
                'type'         => $val['ss_link_type'],
            );
        }
        $this->output['shortcut'] = json_encode($json);
    }


    
    private function showActiveList($tpl_id=3){
        $service_model = new App_Model_Shop_MysqlShopServiceStorage($this->curr_sid);
        $active = $service_model->fetchServiceShowList($tpl_id, 2);
        $json = array();
        foreach($active as $key => $val){
            $json[] = array(
                'index'        => $key ,
                'name'         => $val['ss_title'],
                'imgsrc'       => $val['ss_icon'],
                'articleId'    => $val['ss_link'],
                'intro'        => $val['ss_brief'],
                'label'        => $val['ss_label'],
                'articleTitle' => $val['ss_article_title'],
            );
        }
        $this->output['activeList'] = json_encode($json);
    }



    
    private function _show_tpl_course($tpl_id){
        $coursr_storage = new App_Model_Train_MysqlTrainRecommendStorage($this->curr_sid);
        $course_model = new App_Model_Train_MysqlTrainCourseStorage($this->curr_sid);
        $course_list = $coursr_storage->fetchRecommendShowList($tpl_id);
        $json = array();
        if($course_list){
            foreach($course_list as $key => $val){
                if($val['atr_tpl_id'] == 56){
                    $courseRow = $course_model->getRowById($val['atr_link']);
                    $curr_price = $courseRow['atc_price'];
                }else{
                    $curr_price = $val['atr_price'];
                }

                $json[] = array(
                    'index'        => $val['atr_weight'] ,
                    'name'         => $val['atr_title'],
                    'imgsrc'       => $val['atr_icon'],
                    'articleId'    => $val['atr_link'],
                    'articleTitle' => $val['atr_course_title'],
                    'price'        => $curr_price ? $curr_price : '',
                    'brief'        => $val['atr_brief'],
                );
            }
        }
        $this->output['courseList'] = json_encode($json);
    }

    
    private function _show_tpl_notice(){
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->curr_sid);
        $notice_list = $notice_storage->fetchNoticeShowList();
        $data = array();
        if($notice_list){
            foreach ($notice_list as $val){
                $data[] = array(
                    'index'         => $val['atn_weight'],
                    'title'         => $val['atn_title'],
                    'articleId'     => $val['atn_article_id'],
                    'articleTitle'  => $val['atn_article_title']
                );
            }
        }
        $this->output['noticeList'] = json_encode($data);
    }


    
    private function _show_tpl_student($tpl_id,$index=0){
        $mien_storage = new App_Model_Train_MysqlTrainMienStorage($this->curr_sid);
        $mien_list = $mien_storage->fetchMienShowList();
        $json = array();
        if($mien_list){
            foreach($mien_list as $key => $val){
                $json[] = array(
                    'index'        => $val['atm_weight'] ,
                    'imgsrc'       => $val['atm_img'],
                );
            }
        }
        if($this->request->getIntParam('test')==1){
          plum_msg_dump($json);
        }

        $this->output['studentList'] = json_encode($json);
    }

    
    private function _select_course_cate_list(){
        $where = array();
        $where[] = array('name'=>'att_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'att_deleted','oper'=>'=','value'=>0);
        $sort = array('att_create_time'=>'DESC');
        $type_model = new App_Model_Train_MysqlTrainCourseTypeStorage($this->curr_sid);
        $list = $type_model->getList($where,0,0,$sort);
        $courseCate = array();
        if($list){
            foreach ($list as $val){
                $courseCate[] = array(
                    'id'    => $val['att_id'],
                    'name'  => $val['att_name']
                );
            }
        }
        $this->output['courseCate'] = json_encode($courseCate);
        $this->output['courseCate_select'] = $courseCate;
    }
    
    private function _select_course_list(){
        $where = array();
        $where[] = array('name'=>'atc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'atc_deleted','oper'=>'=','value'=>0);
        $sort = array('atc_create_time'=>'DESC');
        $course_storage = new App_Model_Train_MysqlTrainCourseStorage($this->curr_sid);
        $list = $course_storage->getList($where,0,0,$sort);
        $course = array();
        $courseWithCate = array();
        if($list){
            foreach ($list as $val){
                $course[] = array(
                    'id'   => $val['atc_id'],
                    'name' => $val['atc_title'],
                    'cover'=> $val['atc_cover'],
                    'price'=> $val['atc_price'],
                    'apply'=> $val['atc_apply'],
                );
            }

            foreach ($list as $value){
                $courseWithCate[$value['atc_type_id']][] = array(
                    'id'   => $value['atc_id'],
                    'name' => $value['atc_title'],
                    'cover'=> $value['atc_cover'],
                    'price'=> $value['atc_price'],
                    'apply'=> $value['atc_apply'],
                );
            }
        }
        $this->output['courses'] = json_encode($course);
        $this->output['courseWithCate'] = json_encode($courseWithCate);
    }
    
    private function _shop_mobile_address(){
        $about_storage = new App_Model_Shop_MysqlShopAboutUsStorage($this->curr_sid);
        $row = $about_storage->findUpdateBySid();
        $this->output['contact'] = $row;
    }
    
    private function _get_list_for_select($tpl_id){
        $linkList = plum_parse_config('link','system');
        $linkType = plum_parse_config('link_type','system');
        $linkTypeTrain = plum_parse_config('link_type_train','system');
        $linkType = array_merge($linkType,$linkTypeTrain);
        $linkTypesNew = array(
            array(
                'id'   => '1',
                'name' => '资讯详情'
            ),
            array(
                'id'   => '106',
                'name' => '小程序'
            ),
        );
        $this->output['linkTypesNew'] = json_encode($linkTypesNew);

        $link = $linkList[$this->wxapp_cfg['ac_type']];
        $this->output['linkList'] = json_encode($link);
        $this->output['linkType'] = json_encode($linkType);
    }
    private function _save_train_course($tpl_id){
        $courseList = $this->request->getArrParam('courseInfo');
        $coursr_storage = new App_Model_Train_MysqlTrainRecommendStorage($this->curr_sid);
        if(!empty($courseList)){
            $course_list = $coursr_storage->fetchRecommendShowList($tpl_id);
            if(!empty($course_list)){
                $del_id = array();
                foreach($course_list as $val){
                    if(isset($courseList[$val['atr_weight']])){
                        $set = array(
                            'atr_weight'            => $courseList[$val['atr_weight']]['index'],
                            'atr_title'             => $courseList[$val['atr_weight']]['name'],
                            'atr_icon'              => $courseList[$val['atr_weight']]['imgsrc'],
                            'atr_link'              => $courseList[$val['atr_weight']]['articleId'],
                            'atr_price'             => $courseList[$val['atr_weight']]['price'],
                            'atr_brief'             => $courseList[$val['atr_weight']]['brief'],
                            'atr_course_title'      => $courseList[$val['atr_weight']]['articleTitle'],
                        );
                        $up_ret = $coursr_storage->updateById($set,$val['atr_id']);
                        unset($courseList[$val['atr_weight']]);
                    }else{
                        $del_id[] = $val['atr_id'];
                    }
                }
                if(!empty($del_id)){
                    $activity_where = array();
                    $activity_where[] = array('name' => 'atr_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $coursr_storage->deleteValue($activity_where);
                }

            }
            if(!empty($courseList)){
                $insert = array();
                foreach($courseList as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', {$tpl_id}, '{$val['name']}','{$val['imgsrc']}','{$val['articleId']}','{$val['price']}','{$val['brief']}','{$val['articleTitle']}', '{$val['index']}', '0', '".time()."') ";
                }
                $ins_ret = $coursr_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'atr_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'atr_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $del     = $coursr_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }

    
    private function _save_train_notice(){
        $noticeInfo = $this->request->getArrParam('notice');
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->curr_sid);
        if(!empty($noticeInfo)){
            $notice_list = $notice_storage->fetchNoticeShowList();
            if(!empty($notice_list)){
                $del_id = array();
                foreach($notice_list as $val){
                    if(isset($noticeInfo[$val['atn_weight']])){
                        $set = array(
                            'atn_weight'            => $noticeInfo[$val['atn_weight']]['index'],
                            'atn_title'             => $noticeInfo[$val['atn_weight']]['title'],
                            'atn_article_id'        => $noticeInfo[$val['atn_weight']]['articleId'],
                            'atn_article_title'     => $noticeInfo[$val['atn_weight']]['articleTitle'],
                        );
                        $up_ret = $notice_storage->updateById($set,$val['atn_id']);
                        unset($noticeInfo[$val['atn_weight']]);
                    }else{
                        $del_id[] = $val['atn_id'];
                    }
                }
                if(!empty($del_id)){
                    $notice_where = array();
                    $notice_where[] = array('name' => 'atn_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $notice_storage->deleteValue($notice_where);
                }

            }
            if(!empty($noticeInfo)){
                $insert = array();
                foreach($noticeInfo as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['title']}','','{$val['articleId']}','{$val['articleTitle']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $notice_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'atn_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $del     = $notice_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }

    
    private function _save_train_student(){
        $studentInfo = $this->request->getArrParam('studentInfo');
        $mien_storage = new App_Model_Train_MysqlTrainMienStorage($this->curr_sid);
        if(!empty($studentInfo)){
            $mien_list = $mien_storage->fetchMienShowList();
            if(!empty($mien_list)){
                $del_id = array();
                foreach($mien_list as $val){
                    if(isset($studentInfo[$val['atm_weight']])){
                        $set = array(
                            'atm_weight'            => $studentInfo[$val['atm_weight']]['index'],
                            'atm_img'              => $studentInfo[$val['atm_weight']]['imgsrc'],
                        );
                        $up_ret = $mien_storage->updateById($set,$val['atm_id']);
                        unset($studentInfo[$val['atm_weight']]);
                    }else{
                        $del_id[] = $val['atm_id'];
                    }
                }
                if(!empty($del_id)){
                    $activity_where = array();
                    $activity_where[] = array('name' => 'atm_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $mien_storage->deleteValue($activity_where);
                }

            }
            if(!empty($studentInfo)){
                $insert = array();
                foreach($studentInfo as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['imgsrc']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $mien_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'atm_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $del     = $mien_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }

    
    public function courseListAction(){
        $page  = $this->request->getIntParam('page');
        $index = $this->count*$page;
        $where = array();
        $where[] = array('name'=>'atc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'atc_deleted','oper'=>'=','value'=>0);
        $sort = array('atc_create_time'=>'DESC');
        $course_storage = new App_Model_Train_MysqlTrainCourseStorage($this->curr_sid);
        $total = $course_storage->getCount($where);
        $list  = array();
        if($index<$total){
            $list = $course_storage->getList($where,$index,$this->count,$sort);
        }
        $page_libs            = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pageHtml']   = $page_libs->render();

        if($list){
            foreach ($list as $key => $val){
                if(is_numeric($val['atc_price'])  || is_float($val['atc_price'])){
                    $list[$key]['editVipPrice'] = 1;
                }else{
                    $list[$key]['editVipPrice'] = 0;
                }
            }
        }

        $this->output['list'] = $list;
        $tpl_model = new App_Model_Train_MysqlTrainIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($this->wxapp_cfg['ac_index_tpl']);
        $this->output['indexCfg'] = $tpl;
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $list = $level_model->getListBySid($this->curr_sid);
        $this->output['levelList'] = $list;
        $this->output['levelCount'] = count($list);
        $this->buildBreadcrumbs(array(
            array('title' => '课程列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/train/course-list.tpl');
    }

    
    public function addCourseAction(){
        $id = $this->request->getIntParam('id');
        $course_storage = new App_Model_Train_MysqlTrainCourseStorage($this->curr_sid);
        $row = $course_storage->getRowById($id);
        $type_storage = new App_Model_Train_MysqlTrainCourseTypeStorage($this->curr_sid);
        $type = $type_storage->findListForSelect();

        $messageList = json_decode($row['atc_extra_message'],1);
        if(!empty($messageList)){
            $this->output['messageList'] = json_encode($messageList);
        }else{
            $this->output['messageList'] = json_encode(array());
        }

        $this->output['type'] = $type;
        $this->output['row'] = $row;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/train/add-course.tpl');
    }

    
    public function saveCourseAction(){
        $title    = $this->request->getStrParam('course-title');
        $type     = $this->request->getIntParam('course-type');
        $price    = $this->request->getStrParam('course-price');
        $cover    = $this->request->getStrParam('course_cover_img');
        $brief    = $this->request->getStrParam('course-brief');
        $content  = $this->request->getParam('article-detail');
        $apply    = $this->request->getIntParam('course-apply');
        $oriPrice = $this->request->getStrParam('course-ori-price');
        $id       = $this->request->getIntParam('hid_id');
        $hour     = $this->request->getIntParam('course-hour');
        $startTime= $this->request->getStrParam('course-start-time');
        $endTime  = $this->request->getStrParam('course-end-time');
        $outline  = $this->request->getStrParam('article-outline');
        $joinDiscount = $this->request->getStrParam('atc_join_discount');
        $listLabel = $this->request->getStrParam('atc_list_label');
        $exchangeCost = $this->request->getStrParam('atc_exchange_cost');
        $messageList  = $this->request->getStrParam('messageList');
        $shareTitle  = $this->request->getStrParam('atc_share_title');
        $shareImg  = $this->request->getStrParam('course_share_img');
        $sort = $this->request->getIntParam('atc_sort',0);
        $teacher=$this->request->getStrParam('teacher-detail');


        if($title && $type  && $cover){
            $type_storage = new App_Model_Train_MysqlTrainCourseTypeStorage($this->curr_sid);
            $type_select = $type_storage->findListForSelect();
            $data = array(
                'atc_s_id'      => $this->curr_sid,
                'atc_title'     => $title,
                'atc_brief'     => $brief,
                'atc_type_id'   => $type,
                'atc_type_name' => $type_select[$type],
                'atc_price'     => $price,
                'atc_cover'     => $cover,
                'atc_content'   => $content,
                'atc_apply'     => $apply,
                'atc_ori_price' => $oriPrice,
                'atc_hour'      => $hour,
                'atc_start_time'=> $startTime ? strtotime($startTime) : 0,
                'atc_end_time'  => $endTime ? strtotime($endTime) : 0,
                'atc_outline'   => $outline,
                'atc_extra_message' => $messageList,
                'atc_teacher'   => $teacher,
                'atc_join_discount' => ($joinDiscount == 'on' || $joinDiscount == 1)? 1 : 0,
                'atc_list_label' => $listLabel,
                'atc_exchange_cost' => $exchangeCost,
                'atc_share_title' => $shareTitle,
                'atc_share_img' => $shareImg,
                'atc_sort' => $sort
            );

            $course_storage = new App_Model_Train_MysqlTrainCourseStorage($this->curr_sid);
            if($id){
                $ret = $course_storage->updateById($data,$id);
            }else{
                $data['atc_create_time'] = time();
                $ret = $course_storage->insertValue($data);
            }

            if($ret){
                App_Helper_OperateLog::saveOperateLog("课程类型【".$title."】保存成功");
            }

            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError('请将信息填写完整后提交');
        }

    }


    
    

    
    

    
    


    private function _save_course_index($tpl_id = 56){
        $courseIndex_storage = new App_Model_Train_MysqlTrainCourseIndexStorage($this->curr_sid);
        $courseIndex = $this->request->getArrParam('courseIndex');
        if(!empty($courseIndex)){
            $course_list = $courseIndex_storage->fetchCourseIndexShowList(0,0,$tpl_id);
            if(!empty($course_list)){
                $del_id = array();
                foreach($course_list as $val){
                    if(isset($courseIndex[$val['atci_weight']])){
                        $set = array(
                            'atci_weight'            => $courseIndex[$val['atci_weight']]['index'],
                            'atci_link'              => $courseIndex[$val['atci_weight']]['link'],
                            'atci_tpl_id'            => $tpl_id,
                            'atci_title'             => $courseIndex[$val['atci_weight']]['title']
                        );
                        $up_ret = $courseIndex_storage->updateById($set,$val['atci_id']);
                        unset($courseIndex[$val['atci_weight']]);
                    }else{
                        $del_id[] = $val['atci_id'];
                    }
                }
                if(!empty($del_id)){
                    $activity_where = array();
                    $activity_where[] = array('name' => 'atci_id','oper' => 'in' , 'value' => $del_id);
                    $activity_where[] = array('name' => 'atci_tpl_id','oper' => '=' , 'value' => $tpl_id);
                    $del_ret = $courseIndex_storage->deleteValue($activity_where);
                }

            }
            if(!empty($courseIndex)){
                $insert = array();
                foreach($courseIndex as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$tpl_id}','{$val['title']}','{$val['link']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $courseIndex_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'atci_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'atci_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $del     = $courseIndex_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
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
        if($row || $id == 0){
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
                if($ret){
                    App_Helper_OperateLog::saveOperateLog("首页模板【".$row['it_name']."】启用成功");
                }
            }else{
                $result['em'] = '启用失败';
            }
        }
        $this->displayJson($result);
    }

    public function giftGoodsAction(){
        $this->count = 10;
        $page     = $this->request->getIntParam('page',1);
        $keyword  = $this->request->getStrParam('keyword');
        $page     = $page >=1 ? $page : 1;
        $index    = ($page - 1)* $this->count;
        $goods_model = new App_Model_Train_MysqlTrainCourseStorage($this->curr_sid);
        $where[]     = array('name' => 'atc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        if($keyword){
            $where[]     = array('name' => 'atc_title', 'oper' => 'like', 'value' => "%$keyword%");
        }
        $list        = $goods_model->getList($where,$index,$this->count,array('atc_create_time'=>'DESC'));
        $total       = $goods_model->getCount($where);
        $tot_page    = ceil($total/$this->count);

        $menu_helper = new App_Helper_Menu();
        $menu        = $menu_helper->ajaxGoodsPageLink($tot_page , $page);
        $data = [];
        foreach ($list as &$val){
            if(is_numeric($val['atc_price'])){
                $val['g_id'] = $val['atc_id'];
                $val['g_cover'] = $val['atc_cover'];
                $val['g_name'] = $val['atc_title'];
                $val['g_price'] = $val['atc_price'];
                $data[] = $val;
            }
        }

        $data = array(
            'ec'        => 200,
            'list'      => $data,
            'pageHtml'  => $menu
        );
        $this->displayJson($data);
    }
    public function exchangeListAction(){
        $page  = $this->request->getIntParam('page');
        $exchange_status = $this->request->getIntParam('exchange_status');
        $name = $this->request->getStrParam('name');
        $index = $this->count*$page;
        $where = array();
        $where[] = array('name'=>'atce_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($exchange_status){
            $where[] = array('name'=>'atce_status','oper'=>'=','value'=>$exchange_status);
        }
        $this->output['exchange_status'] = $exchange_status;

        if($name){
            $where[] = array('name'=>'atce_name','oper'=>'like','value'=>"%{$name}%");
        }
        $this->output['name'] = $name;

        $sort = array('atce_create_time'=>'DESC');
        $exchange_storage = new App_Model_Train_MysqlTrainCourseExchangeStorage($this->curr_sid);
        $total = $exchange_storage->getExchangeMemberCount($where);
        $list  = array();
        if($index<$total){
            $list = $exchange_storage->getExchangeMemberList($where,$index,$this->count,$sort);
        }
        $page_libs            = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pageHtml']   = $page_libs->render();
        foreach ($list as $key => $val){
            $list[$key]['atce_info_list'] = json_decode($val['atce_info_list'],1);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '报名列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/train/exchange-list.tpl');
    }

}