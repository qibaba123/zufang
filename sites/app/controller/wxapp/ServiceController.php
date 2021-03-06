<?php


class App_Controller_Wxapp_ServiceController extends App_Controller_Wxapp_InitController{

    const PROMOTION_TOOL_KEY = 'autoreply';

    public function __construct() {
        parent::__construct();
    }


    //VIP管理
    public function vipEditAction(){
        $service_model = new App_Model_Service_MysqlEnterpriseServiceStorage();
        $where[]       = array('name'=>'es_type','oper'=>"=",'value'=>3);
        $row           = $service_model->getRow($where);
        $this->output['row'] = $row;
        $slide_model    = new App_Model_Service_MysqlServiceSlideStorage();
        $slide          = $slide_model->getSlideByGid($row['es_id'], 1);
        $this->output['slide'] = $slide;
        $format_model = new App_Model_Service_MysqlServiceFormatStorage();
        $where        = array();
        $where[]      = array('name'=>"sf_e_id",'oper'=>"=",'value'=>$row['es_id']);
        $format       = $format_model->getList($where,0,0,array());
        $this->output['format'] = $format;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => 'VIP管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/service/vip-edit.tpl');
    }


    //企业服务列表
    public function serviceListAction(){
        $page   = $this->request->getIntParam('page');
        $type   = $this->request->getIntParam('type');
        $type2  = $this->request->getIntParam('type2');
        $type3  = $this->request->getIntParam('type3');
        $index = $page * $this->count;
        $service_model = new App_Model_Service_MysqlEnterpriseServiceStorage();
        if($type){
            $where[]       = array('name'=>'es_type','oper'=>"=",'value'=>$type);
            $this->output['type'] = $type;
            if($type == 1 && $type2){
                $where[]       = array('name'=>'es_second_type','oper'=>"=",'value'=>$type2);
                $this->output['type2'] = $type2;
            }elseif($type == 2 && $type3){
                $where[]       = array('name'=>'es_second_type','oper'=>"=",'value'=>$type3);
                $this->output['type3'] = $type3;
            }
        }else{
            $where[]       = array('name'=>'es_type','oper'=>"in",'value'=>array(1,2));
        }
        if($type){


        }
        $list  = $service_model->getList($where,$index,$this->count,array('es_weight'=>'DESC'));
        $this->output['list'] = $list;
        $this->output['image'] = $this->curr_shop['s_service_image'];
        $this->renderCropTool('/wxapp/index/uploadImg');
        $total  = $service_model->getCount(array());
        $page_libs = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pageHtml']   = $page_libs->render();
        $this->output['type_arr']   = array(
                1 => '企业服务商品',
                2 => '企业服务文章'
        );
        $this->output['type1_arr'] = plum_parse_config('status1','zufang');
        $this->output['type2_arr'] = plum_parse_config('status2','zufang');
        $this->buildBreadcrumbs(array(
            array('title' => '企业服务', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/service/service-list.tpl');
    }

    //保存顶部图片
    public function saveServiceImageAction(){
        $data['s_service_image'] = $this->request->getStrParam('image');
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage($this->curr_sid);
        $ret = $shop_model->updateById($data,$this->curr_sid);
        if($ret){
            $this->displayJsonSuccess(array(),true,'保存成功');
        }else{
            $this->displayJsonError('保存失败');
        }
    }



    //新增或编辑企业服务
    public function addServiceAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $service_model = new App_Model_Service_MysqlEnterpriseServiceStorage();
            $row           = $service_model->getRowById($id);
            $this->output['row'] = $row;
            if(!empty($row)){
                $slide_model    = new App_Model_Service_MysqlServiceSlideStorage();
                $slide          = $slide_model->getSlideByGid($row['es_id'], 1);
            }
            //var_dump($slide);exit;
            $this->output['slide'] = $slide;
            if(!empty($row) && $row['es_type'] == 1){
                $format_model = new App_Model_Service_MysqlServiceFormatStorage();
                $where        = array();
                $where[]      = array('name'=>"sf_e_id",'oper'=>"=",'value'=>$id);
                $format       = $format_model->getList($where,0,0,array());
            }
           // $this->output['format'] = array_column($format,'sf_name','sf_id');
            $this->output['format'] = $format;
        }
        $this->output['type1'] = plum_parse_config('status1','zufang');
        $this->output['type2'] = plum_parse_config('status2','zufang');
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '编辑企业服务', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/service/add-service-new.tpl');

    }

    //删除企业服务
    public function deleteServiceAction(){
        $id = $this->request->getIntParam('id');
        $update['es_deleted'] = 1;
        $service_model = new App_Model_Service_MysqlEnterpriseServiceStorage();
        $ret = $service_model->updateById($update,$id);
        if($ret){
            $this->displayJsonSuccess(array(),true,'删除成功');
        }else{
            $this->displayJsonError('删除失败');
        }
    }


    //保存服务
    public function saveServiceAction(){
        $id   = $this->request->getIntParam('hid_id');
        $data['es_name']     = $this->request->getStrParam('es_name');
        $data['es_weight']   = $this->request->getIntParam('weight');
        $data['es_type']     = $this->request->getIntParam('type');
        $es_type1     = $this->request->getIntParam('type1');
        $es_type2     = $this->request->getIntParam('type2');
        $data['es_logo']     = $this->request->getStrParam('logo');
        $data['es_cover']    = $this->request->getStrParam('cover');
        $data['es_brief']    = $this->request->getStrParam('brief');
        $data['es_content']  = $this->request->getStrParam('content');
        $data['es_price']    = $this->request->getFloatParam('price');
        $service_model = new App_Model_Service_MysqlEnterpriseServiceStorage();
        $data['es_create_time'] = time();
        $is_add = 0;
        if($data['es_type'] == 1){
            $data['es_second_type'] = $es_type1;
        }elseif($data['es_type'] == 2){
            $data['es_second_type'] = $es_type2;
        }
        if($id){
            $ret = $service_model->updateById($data,$id);
        }else{
            $data['es_s_id'] = $this->curr_sid;
            $id = $ret = $service_model->insertValue($data);
            $is_add = 1;
        }
        if($ret){
            $this->batchSlide($id,$is_add);
            $this->_math_receive($id,$is_add,$data['es_type']);
            $this->displayJsonSuccess(array(),true,'保存成功');
        }else{
            $this->displayJsonError('保存失败');
        }
    }


    private function _math_receive($id,$is_add,$type)
    {
        $ret = array();
        $maxNum = $this->request->getIntParam('format-num');
        $format_model = new App_Model_Service_MysqlServiceFormatStorage();
        if(!$is_add){
            $where[]      = array('name'=>'sf_e_id','oper'=>"=",'value'=>$id);
            $format_model->deleteValue($where);
        }
        if($type == 1 || $type == 3){
            for ($i = 0; $i < $maxNum; $i++) {
                $receive_name = $this->request->getStrParam('receive_name_'.$i);
                if($receive_name){
                    $insert = array(
                        'sf_s_id' => $this->curr_sid,
                        'sf_e_id' => $id,
                        'sf_name' => $receive_name,
                        'sf_create_time' => time()
                    );
                    $format_model->insertValue($insert);
                }
            }
        }

    }

    public function batchSlide($resId,$is_add=0){
        $slide_model    = new App_Model_Service_MysqlServiceSlideStorage();
        $maxNum         = $this->request->getStrParam('slide-img-num');
        $slide          = array();
        if($is_add){
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                if($temp){
                    $slide[] = "(NULL, '{$this->curr_sid}', '{$resId}','{$temp}', 0, '".time()."')";
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
                if(!in_array($val['ss_id'],$sl_id)){
                    $del_id[] = $val['ss_id'];
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
                        $batch_slide[] = "(NULL, '{$this->curr_sid}', '{$resId}','{$sTemp}', 0, '".time()."')";
                    }
                }
                if(!empty($batch_slide)){
                    $slide_model->batchSave($batch_slide);
                }
            }
        }
    }













    public function msgListAction(){
        $page   = $this->request->getIntParam('page');
        $index  = $page * $this->count;
        $msg_model  = new App_Model_Applet_MysqlAppletServiceMsgStorage($this->curr_sid);
        $where = array();
        $where[]    = array('name' => 'asm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'asm_deleted', 'oper' => '=', 'value' => 0);
        $total      = $msg_model->getCount($where);
        $list       = array();
        if($total > $index){
            $sort = array('asm_create_time' => 'desc');
            $list = $msg_model->getList($where, $index, $this->count, $sort);
        }
        $this->output['typeNote'] = array(
            'text'  => '文本消息',
            'image' => '图片消息',
            'link'  => '图文链接',
            'miniprogrampage' => '小程序卡片',
        );
        $page_libs = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pageHtml']   = $page_libs->render();
        $this->output['list']       = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '小程序管理', 'link' => '#'),
            array('title' => '自动回复列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/service/msg-tpl.tpl');
    }

    
    public function msgSettingAction(){
        $id = $this->request->getIntParam('id');
        $msg_model  = new App_Model_Applet_MysqlAppletServiceMsgStorage($this->curr_sid);
        $msg = $msg_model->getRowById($id);
        $this->output['msg'] = $msg;
        $this->output['appletCfg'] = $this->wxapp_cfg;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '小程序管理', 'link' => '#'),
            array('title' => '自动回复列表', 'link' => '/wxapp/service/msgList'),
            array('title' => '自动回复配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/service/msg-setting.tpl');
    }

    
    public function saveMessageAction(){
        $id                  = $this->request->getIntParam('id');
        $data['asm_type']    = $this->request->getStrParam('msgType');
        $data['asm_keyword'] = $this->request->getStrParam('msgKeyword');
        $data['asm_content'] = $this->request->getStrParam('msgContent');
        $data['asm_title']   = $this->request->getStrParam('msgTitle');
        $data['asm_desc']    = $this->request->getStrParam('msgDesc');
        $data['asm_path']    = $this->request->getStrParam('msgPath');
        $data['asm_url']     = $this->request->getStrParam('msgUrl');
        $data['asm_cover']   = $this->request->getStrParam('msgCover');

        $msg_model  = new App_Model_Applet_MysqlAppletServiceMsgStorage($this->curr_sid);
        if($id){
            $data['asm_update_time'] = time();
            $ret = $msg_model->updateById($data, $id);
        }else{
            $data['asm_update_time'] = time();
            $data['asm_create_time'] = time();
            $data['asm_s_id'] = $this->curr_sid;
            $ret = $msg_model->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("自动回复配置保存成功");
        }

        $this->showAjaxResult($ret);
    }

    
    public function delMessageAction(){
        $id  = $this->request->getIntParam('id');
        $msg_model  = new App_Model_Applet_MysqlAppletServiceMsgStorage($this->curr_sid);
        $ret = 0;
        if($id){
            $data['asm_deleted'] = 1;
            $ret = $msg_model->updateById($data, $id);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("自动回复配置删除成功");
        }

        $this->showAjaxResult($ret);
    }

    
    public function saveAutoReplyTipsAction(){
        $tips  = $this->request->getStrParam('tips');
        $open  = $this->request->getStrParam('open');

        $set = array('s_auto_reply_tips' => $tips, 's_auto_reply_tips_open' => ($open=='on'?1:0));
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $ret = $shop_model->updateById($set, $this->curr_sid);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("自动回复提示配置保存成功");
        }

        $this->showAjaxResult($ret);
    }
}