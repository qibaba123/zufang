<?php


class App_Controller_Wxapp_FormController extends App_Controller_Wxapp_InitController
{

    public function __construct()
    {
        parent::__construct();
        $this->mobile_verify_component=[34];
    }

    public function listAction(){
        $form_model = new App_Model_Applet_MysqlCustomFormStorage();
        $where[] = array('name' => 'acf_s_id' , 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acf_deleted' , 'oper' => '=', 'value' => 0);
        $list = $form_model->getList($where);
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '留言管理', 'link' => '/wxapp/form/formData'),
            array('title' => '表单列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/form/form-list.tpl');
    }
    public function startFormTplAction(){
        $id = $this->request->getIntParam('id');
        $form_model = new App_Model_Applet_MysqlCustomFormStorage();
        $set = array('acf_selected' => 0);
        $where = array();
        $where[] = array('name' => 'acf_s_id' , 'oper' => '=', 'value' => $this->curr_sid);
        $form_model->updateValue($set, $where);
        $set = array('acf_selected' => 1);
        $ret = $form_model->updateById($set, $id);

        if($ret){
            $form = $form_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("自定义表单【{$form['acf_header_title']}】启用成功");
        }

        $this->showAjaxResult($ret);
    }
    public function delFormTplAction(){
        $id = $this->request->getIntParam('id');
        $form_model = new App_Model_Applet_MysqlCustomFormStorage();
        $form = $form_model->getRowById($id);
        $set = array('acf_deleted' => 1);
        $ret = $form_model->updateById($set, $id);
        App_Helper_OperateLog::saveOperateLog("自定义表单【".$form['acf_header_title']."】删除成功");
        $this->showAjaxResult($ret);
    }

    public function indexAction(){
        $id = $this->request->getIntParam('id');
        $form_model = new App_Model_Applet_MysqlCustomFormStorage();
        $row = $form_model->getRowById($id);
        $data = $row['acf_data']?json_decode($row['acf_data'],true):[];
        if($this->wxapp_cfg['ac_type'] == 33){
            $carType = false;
            foreach($data as $key=>$val){
                if($val['require'] == 'true'){
                    $data[$key]['require'] = true;
                }else{
                    $data[$key]['require'] = false;
                }
                if($val['type'] == 'carType'){
                    $carType = true;
                }

            }
            if($carType == false){
                $insert = [
                    'type' => 'carType',
                    'data' => [],
                    'require' => true
                ];
                if(empty($data)){
                    $data[] = $insert;
                }else{
                    array_unshift($data,$insert);
                }
            }

        }else{
            foreach($data as $key=>$val){
                if($val['require'] == 'true'){
                    $data[$key]['require'] = true;
                }else{
                    $data[$key]['require'] = false;
                }
            }
        }
        if(in_array($this->wxapp_cfg['ac_type'],$this->mobile_verify_component)){
            $this->output['mobile_component']=TRUE;
        }


        $this->buildBreadcrumbs(array(
            array('title' => '留言管理', 'link' => '/wxapp/form/formData'),
            array('title' => '表单列表', 'link' => '/wxapp/form/list'),
            array('title' => '自定义表单', 'link' => '#'),
        ));
        $this->output['data'] = json_encode($data);
        $this->output['headerTitle'] = $row['acf_header_title'];
        $this->output['id'] = $row['acf_id'];
        $this->output['sid'] = $this->curr_sid;
        $this->displaySmarty('wxapp/form/index.tpl');
    }

    public function saveFormAction(){
        $id = $this->request->getIntParam('id');
        $formData = $this->request->getArrParam('formData');
        $headerTitle = $this->request->getStrParam('headerTitle');
        $cover = $this->request->getStrParam('cover');
        $form_model = new App_Model_Applet_MysqlCustomFormStorage();
        $filepath = '';
        if($cover){
            if (strstr($cover,",")){
                $cover = explode(',',$cover);
                $cover = $cover[1];
            }
            $im     = imagecreatefromstring(base64_decode($cover));
            $filename   = plum_uniqid_base36(true).".jpg";
            imagejpeg($im, PLUM_APP_BUILD."/".$filename);
            imagedestroy($im);
            $filepath   = '/public/build/'.$filename;
        }
        $data = array(
            'acf_s_id' => $this->curr_sid,
            'acf_data' => json_encode($formData),
            'acf_header_title' => $headerTitle,
            'acf_update_time' => time(),
            'acf_cover' => $filepath
        );
        if($id){
            $ret = $form_model->updateById($data, $id);
        }else{
            $ret = $form_model->insertValue($data);
        }
        App_Helper_OperateLog::saveOperateLog("自定义表单【".$headerTitle."】信息保存成功");
        $this->showAjaxResult($ret);
    }

    public function formDataAction(){
        $formid = $this->request->getIntParam('formid');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $data_model = new App_Model_Applet_MysqlCustomFormDataStorage();
        $where[] = array('name' => 'acfd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        if($formid){
            $where[] = array('name' => 'acfd_tpl_id', 'oper' => '=', 'value' => $formid);
        }
        $where[] = array('name' => 'acfd_deleted', 'oper' => '=', 'value' => 0);
        $total = $data_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination']   = $pageCfg->render();
        $this->output['showPage'] = $total > $this->count ? 1 : 0;
        $list = array();
        if($index < $total){
            $sort = array('acfd_create_time' => 'desc');
            $list = $data_model->getListMember($where, $index, $this->count, $sort);
        }

        if($this->wxapp_cfg['ac_type'] == 34){
            $this->buildBreadcrumbs(array(
                array('title' => '骑手管理', 'link' => '#'),
                array('title' => '骑手申请', 'link' => '#'),
            ));
        }else{
            $this->buildBreadcrumbs(array(
                array('title' => '企业管理', 'link' => '#'),
                array('title' => '信息管理', 'link' => '#'),
            ));
        }
        $test = $this->request->getIntParam('test');
        if($test && $test==123){
            foreach ($list as $val){
                $acfdData = json_decode($val['acfd_data'],true);
                plum_msg_dump($acfdData,0);
                foreach ($acfdData as $item){
                    plum_msg_dump($item,0);
                }
            }
            plum_msg_dump($list);
        }

        $sequenceShowAll = 1;
        if($this->wxapp_cfg['ac_type'] == 36){
            $sequenceShowAll = 0;
        }
        $this->output['sequenceShowAll'] = $sequenceShowAll;

        $this->output['list'] = $list;
        $this->output['formid'] = $formid;

        $form_model = new App_Model_Applet_MysqlCustomFormStorage();
        $where = array();
        $where[] = array('name' => 'acf_s_id' , 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acf_deleted' , 'oper' => '=', 'value' => 0);
        $formList = $form_model->getList($where);
        $this->output['formList'] = $formList;
        $where_total = $where_done= [];
        $where_total[] = $where_done[] = ['name'=>'acfd_s_id','oper'=>'=','value'=>$this->curr_sid];
        $where_done[] = ['name'=>'acfd_processed','oper'=>'=','value'=>1];
        $total = $data_model->getSum($where_total);
        $done = $data_model->getSum($where_done);
        $statInfo['total'] = $total ? $total : 0;
        $statInfo['done'] = $done ? $done : 0;
        $notDone = is_numeric($statInfo['total']) && is_numeric($statInfo['done']) ? $statInfo['total'] - $statInfo['done'] : 0;
        $statInfo['notDone'] = $notDone > 0 ? $notDone : 0;
        $this->output['statInfo'] = $statInfo;
        if($this->menuType == 'toutiao' && $this->wxapp_cfg['ac_type'] == 18){
            $this->output['dyyu'] = true;
        }
        $this->displaySmarty('wxapp/form/data-list.tpl');
    }

    public function delFormDataAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $data_model = new App_Model_Applet_MysqlCustomFormDataStorage();
            $set = array(
                'acfd_deleted' => 1
            );
            $ret = $data_model->updateById($set, $id);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("自定义表单数据删除成功");
            }

            $this->showAjaxResult($ret);
        }
    }

    
    public function handleAppointmentAction(){
        $id = $this->request->getIntParam('id');
        $market = $this->request->getStrParam('market');
        if($id){
            $updata = array(
                'acfd_remark'    => $market,
                'acfd_processed' => 1,
            );
            $data_model = new App_Model_Applet_MysqlCustomFormDataStorage();
            $ret = $data_model->updateById($updata,$id);
            if($ret){
                $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
                $appletType = $appletType ? $appletType : 0;

                plum_open_backend('templmsg', 'formDealTempl', array('sid' => $this->curr_sid,'id' => $id,'appletType' => $appletType));
            }

            if($ret){
                App_Helper_OperateLog::saveOperateLog("自定义表单信息处理成功");
            }
            $this->showAjaxResult($ret,'处理');
        }else{
            $this->displayJsonError('处理失败，请稍后重试');
        }
    }

    
    public function importMessageAction(){
        $form_id=$this->request->getIntParam('formid');
        $startDate  = $this->request->getStrParam('startDate');
        $startTime  = $this->request->getStrParam('startTime');
        $endDate    = $this->request->getStrParam('endDate');
        $endTime    = $this->request->getStrParam('endTime');
        $where      = array();
        if(!$form_id)
            plum_url_location('请选择所属表单!');
        else
            $where[]=['name'=>'acfd_tpl_id','oper'=>'=','value'=>$form_id];
        if($startDate && $startTime && $endDate && $endTime){
            $start = $startDate.' '.$startTime;
            $end   = $endDate.' '.$endTime;
            $startTime  = strtotime($start);
            $endTime    = strtotime($end);
         
            $where[]    = array('name'=>'acfd_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[]    = array('name'=>'acfd_create_time','oper'=>'>=','value'=>$startTime);
            $where[]    = array('name'=>'acfd_create_time','oper'=>'<','value'=>$endTime);

            $sort       = array('acfd_create_time' => 'DESC');
            $data_model = new App_Model_Applet_MysqlCustomFormDataStorage();
            $list = $data_model->getListMember($where,0,0,$sort);
            if(!empty($list)){
                $date       = date('Ymd',$_SERVER['REQUEST_TIME']);
                $rows  = array();
                $title  = array();
                foreach ($list as $key => $value){
                    foreach (json_decode($value['acfd_data'], true) as $k => $v){
                        if(array_search($v['data']['title'], $title) === false && $v['type'] != 'submit' && $v['type'] != 'intro'){
                            $title[] = $v['data']['title'];
                        }
                    }
                }
                $title[] = '用户昵称';
                $title[] = '提交时间';
                $title[] = '处理状态';
                $title[] = '处理备注';

                foreach ($title as $key => $value){
                    $rows[0][$key]['value'] = $value;
                    $rows[0][$key]['type']  = 0;
                }


                $charArr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                foreach ($title as $key => $value){
                    $width[$charArr[$key]] = 20;
                }

                foreach($list as $key => $val){
                    foreach (json_decode($val['acfd_data'], true) as $k => $v){
                        foreach ($title as $tk => $tv){
                            if($tv == $v['data']['title']){
                                if($v['type'] == 'upload'){
                                    $rows[$key+1][$tk]['value'] = $v['value'];
                                    $rows[$key+1][$tk]['type'] = 1;
                                }elseif($v['type'] == 'map'){
                                    $rows[$key+1][$tk]['value'] = $v['value'][0];
                                    $rows[$key+1][$tk]['type'] = 0;
                                }elseif($v['type'] == 'checkbox'){
                                    $rows[$key+1][$tk]['value'] = '';
                                    foreach ($v['value'] as $vv){
                                        $rows[$key+1][$tk]['value'] .= $vv.'|';
                                    }
                                    $rows[$key+1][$tk]['type'] = 0;
                                }else{
                                    $rows[$key+1][$tk]['value']  = $v['value'];
                                    $rows[$key+1][$tk]['type'] = 0;
                                }
                            }
                        }
                        $rows[$key+1][count($title) - 4]['value'] = $this->utf8_str_to_unicode($val['m_nickname']);
                        $rows[$key+1][count($title) - 3]['value'] = date("Y-m-d H:i:s", $val['acfd_create_time']);
                        $rows[$key+1][count($title) - 2]['value'] = $val['acfd_processed']==0?'未处理':'已处理';
                        $rows[$key+1][count($title) - 1]['value'] = $val['acfd_remark'];
                    }

                    foreach ($title as $tk => $tv){
                        foreach ($rows[$key+1] as $k => $value){
                            if(!$rows[$key+1][$tk]){
                                $rows[$key+1][$tk]['value']  = '';
                                $rows[$key+1][$tk]['type']  = 0;
                            }
                        }
                    }
                }
                $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
                $excel->down_common_image_excel($rows,$date.'留言信息导出.xls',$width);
            }else{
                plum_url_location('当前时间段内没有留言!');
            }
        }else{
            plum_url_location('日期请填写完整!');
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
                $unicode_str.= '';
            }else{
                $unicode_str.=$val;
            }
        }
        return $unicode_str;
    }

}