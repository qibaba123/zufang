<?php

class App_Controller_Wxapp_AnswerController extends App_Controller_Wxapp_InitController{
    const PROMOTION_TOOL_KEY = 'dt';

    public function __construct(){
        parent::__construct();
        $this->checkAgentClose('answer');
    }
    
    public function secondLink($type='index'){
        $link = array(
            array(
                'label' => '答题配置',
                'link'  => '/wxapp/answer/index',
                'active'=> 'index'
            ),
            array(
                'label' => '答题类型',
                'link'  => '/wxapp/answer/answerCfg',
                'active'=> 'answer'
            ),
            array(
                'label' => '题目管理',
                'link'  => '/wxapp/answer/subjectList',
                'active'=> 'list'
            ),
            array(
                'label' => '奖品管理',
                'link'  => '/wxapp/answer/awardList',
                'active'=> 'award'
            ),
            array(
                'label' => '排行榜',
                'link'  => '/wxapp/answer/rank',
                'active'=> 'rank'
            ),

        );

        if(in_array($this->wxapp_cfg['ac_type'],[21])){
            $link[] = array(
                'label' => '订单答题',
                'link'  => '/wxapp/answer/sendCfg',
                'active'=> 'sendCfg'
            );
        }

        if($this->curr_sid==7126){
            $link[]=array(
                    'label' => '币种管理',
                    'link'  => '/wxapp/answer/currency',
                    'active'=> 'currency'
            );
        }
        $this->output['link']       = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '答题';
    }
    public function indexAction() {
        $this->secondLink('index');
        $cfg_model = new App_Model_Answer_MysqlAnswerCfgStorage($this->curr_sid);
        $cfg       = $cfg_model->fetchUpdateCfg();
        if($this->curr_sid==7126){
            $currency_model = new App_Model_Answer_MysqlCurrencyStorage(7126);
            $where=array();
            $where[]    = array('name' => 'acc_s_id', 'oper' => '=', 'value' => 7126);
            $sort       = array('acc_create_time'=>'DESC');
            $list       = $currency_model->getList($where,0,0,$sort);
            $data=array();
            foreach($list as $k=>$v){
               $data[$v['acc_id']]=$v['acc_name'];
            }
            $this->output['currency'] = $data;
        }

        $this->output['cfg'] = $cfg;
        $this->output['imgs']= json_decode($cfg['asc_slide'],1);
        $this->output['sid'] = $this->curr_sid;
        $this->buildBreadcrumbs(array(
            array('title' => '答题配置管理', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty("wxapp/answer/cfg-new.tpl");
    }

    public function sendCfgAction(){
        $this->secondLink('sendCfg');
        $cfg_model = new App_Model_Answer_MysqlAnswerCfgStorage($this->curr_sid);
        $cfg       = $cfg_model->fetchUpdateCfg();
        $subjectType  = array();
        if($cfg['asc_redpacket_open']){
            $subjectType[1] = '红包赛';
        }
        if($cfg['asc_award_open']){
            $subjectType[2] = '奖品赛';
        }
        if($cfg['asc_points_open']){
            $subjectType[3] = '积分赛';
        }
        $this->output['stype'] = $subjectType;

        $this->output['row'] = $cfg;
        $this->buildBreadcrumbs(array(
            array('title' => '答题管理', 'link' => '/wxapp/answer/index'),
            array('title' => '订单答题', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty("wxapp/answer/send-subject.tpl");
    }
    public function saveSendCfgAction(){
        $isopen  = $this->request->getStrParam('isopen');
        $snum    = $this->request->getIntParam('subjectNum');
        $type    = $this->request->getIntParam('type');
        $cover   = $this->request->getStrParam('cover');
        $cfg_model = new App_Model_Answer_MysqlAnswerCfgStorage($this->curr_sid);
        if($isopen == 'on'){
            $open = 1;
        }else{
            $open = 0;
        }
        $set = array('asc_isopen_subject'=> $open,'asc_send_snum'=>$snum,'asc_subject_cover'
        =>$cover,'asc_subject_type'=>$type);
        $res = $cfg_model->fetchUpdateCfg($set);
        if($res){
            $this->showAjaxResult($res,'保存');
        }else{
            $this->displayJsonError('保存失败');
        }
    }
    public function saveCfgAction() {
        $id              = $this->request->getIntParam('id');
        $shareNum        = $this->request->getIntParam('shareNum');
        $allowCard       = $this->request->getIntParam('allowCard');
        $rule            = $this->request->getStrParam('rule');
        $imgArr          = $this->request->getArrParam('imgArr');
        $phone           = $this->request->getStrParam('award_phone');
        $shareTitle      = $this->request->getStrParam('shareTitle');
        $shareCover      = $this->request->getStrParam('shareCover');
        $openTime        = $this->request->getStrParam('openTime');
        $endTime         = $this->request->getStrParam('endTime');
        $answerTime      = $this->request->getIntParam('answerTime');
        $data=array(
            'asc_share_num'        => $shareNum,
            'asc_allow_card'       => $allowCard,
            'asc_s_id'             => $this->curr_sid,
            'asc_rule'             => $rule,
            'asc_slide'            => json_encode($imgArr),
            'asc_award_phone'      => $phone,
            'asc_share_title'      => $shareTitle,
            'asc_share_cover'      => $shareCover,
            'asc_update_time'      => time(),
            'asc_open_time'        => $openTime,
            'asc_end_time'         => $endTime,
            'asc_answer_time'      => $answerTime > 60 ? 60 : $answerTime,

        );

        $cfg_model = new App_Model_Answer_MysqlAnswerCfgStorage($this->curr_sid);
        if($id){
            $ret=$cfg_model->fetchUpdateCfg($data);
        }else{
            $data['asc_create_time']=time();
            $ret=$cfg_model->insertValue($data);
        }
        if($ret){

            App_Helper_OperateLog::saveOperateLog("保存答题基本配置成功");
            $this->showAjaxResult($ret,'保存');

        }else{
            $this->displayJsonError('保存失败');
        }
    }
    public function saveAnswerCfgAction() {
        $id              = $this->request->getIntParam('id');
        $currency        = $this->request->getIntParam('currency');
        $redPacket_type  = $this->request->getIntParam('redPacket_type');
        $min             = $this->request->getFloatParam('min');
        $max             = $this->request->getFloatParam('max');
        $answerNum       = $this->request->getIntParam('answerNum');
        $right           = $this->request->getIntParam('right');
        $moreNum         = $this->request->getIntParam('moreNum');
        $redPacket       = $this->request->getIntParam('redPacket');
        $openTime        = $this->request->getStrParam('openTime');
        $endTime         = $this->request->getStrParam('endTime');
        $awardId         = $this->request->getIntParam('award_id');
        $awardIdOld      = $this->request->getIntParam('award_id_old');
        $awardNum        = $this->request->getIntParam('award_num');
        $awardSubNum     = $this->request->getIntParam('award_sub_num');
        $awardSubRight   = $this->request->getIntParam('award_sub_right');
        $awardAnswerNum  = $this->request->getIntParam('award_answer_num');
        $awardOpenTime   = $this->request->getStrParam('award_open_time');
        $awardEndTime    = $this->request->getStrParam('award_end_time');
        $points           = $this->request->getIntParam('points');
        $pointsType       = $this->request->getIntParam('points_type');
        $pointsMax        = $this->request->getIntParam('points_max');
        $pointsSubNum     = $this->request->getIntParam('points_sub_num');
        $pointsSubRight   = $this->request->getIntParam('points_sub_right');
        $pointsAnswerNum  = $this->request->getIntParam('points_answer_num');
        $pointsChanceCost = $this->request->getIntParam('points_chance_cost');
        $pointsOpenTime   = $this->request->getStrParam('points_open_time');
        $pointsEndTime    = $this->request->getStrParam('points_end_time');



        $data=array(

            'asc_s_id'             => $this->curr_sid,
            'asc_subject_num'      => $answerNum,
            'asc_answer_right'     => $right,
            'asc_answer_num'       => $moreNum,
            'asc_redpacket_num'    => $redPacket,
            'asc_redpacket_type'   => $redPacket_type,
            'asc_redpacket_min'    => $min,
            'asc_redpacket_max'    => $max,
            'asc_open_time'        => $openTime,
            'asc_end_time'         => $endTime,
            'asc_award_id'         => $awardId,
            'asc_award_num'        => $awardNum,
            'asc_award_sub_num'    => $awardSubNum,
            'asc_award_sub_right'  => $awardSubRight,
            'asc_award_answer_num' => $awardAnswerNum,
            'asc_award_open_time'  => $awardOpenTime,
            'asc_award_end_time'   => $awardEndTime,
            'asc_points'           => $points,
            'asc_points_type'      => $pointsType,
            'asc_points_max'       => $pointsMax,
            'asc_points_sub_num'    => $pointsSubNum,
            'asc_points_sub_right'  => $pointsSubRight,
            'asc_points_answer_num' => $pointsAnswerNum,
            'asc_points_chance_cost'=> $pointsChanceCost,
            'asc_points_open_time'  => $pointsOpenTime,
            'asc_points_end_time'   => $pointsEndTime,
            'asc_update_time'       => time()
        );
        if($currency){
            $currency_model  = new App_Model_Answer_MysqlCurrencyStorage(7126);
            $currencyRow     = $currency_model->getRowById($currency);
            $data['asc_currency']      = $currency;
            $data['asc_currency_name'] = $currencyRow['acc_name'];
        }
        $cfg_model = new App_Model_Answer_MysqlAnswerCfgStorage($this->curr_sid);
        if($id){
            $ret=$cfg_model->fetchUpdateCfg($data);
        }else{
            $data['asc_create_time']=time();
            $ret=$cfg_model->insertValue($data);
        }
        if($ret){
            if($awardId && $awardIdOld && ($awardId != $awardIdOld)){
                $award_model = new App_Model_Answer_MysqlSubjectAwardStorage($this->curr_sid);
                $award_model->refreshAwardsUse($awardId,$awardIdOld);
            }
            App_Helper_OperateLog::saveOperateLog("保存答题类型配置成功");
            $this->showAjaxResult($ret,'保存');

        }else{
            $this->displayJsonError('保存失败');
        }
    }
    public function answerCfgAction() {
        $this->secondLink('answer');
        $cfg_model = new App_Model_Answer_MysqlAnswerCfgStorage($this->curr_sid);
        $cfg       = $cfg_model->fetchUpdateCfg();
        if($this->curr_sid==7126){
            $currency_model = new App_Model_Answer_MysqlCurrencyStorage(7126);
            $where=array();
            $where[]    = array('name' => 'acc_s_id', 'oper' => '=', 'value' => 7126);
            $sort       = array('acc_create_time'=>'DESC');
            $list       = $currency_model->getList($where,0,0,$sort);
            $data=array();
            foreach($list as $k=>$v){
               $data[$v['acc_id']]=$v['acc_name'];
            }
            $this->output['currency'] = $data;
        }

        $award_model = new App_Model_Answer_MysqlSubjectAwardStorage($this->curr_sid);
        $awardList   = $award_model->fetchAwardsBySid($this->curr_sid);
        $this->output['awardList'] = $awardList;

        $this->output['cfg'] = $cfg;
        $this->output['sid'] = $this->curr_sid;
        $this->buildBreadcrumbs(array(
            array('title' => '答题类型配置', 'link' => '#'),
        ));
        $this->output['wxapp_cfg']=$this->wxapp_cfg['ac_type'];

        $this->displaySmarty("wxapp/answer/answer-cfg.tpl");
    }
    public function saveCfgCheckedAction() {
        $id              = $this->request->getIntParam('id');
        $value           = $this->request->getStrParam('value');
        $type            = $this->request->getStrParam('type');
        $status = $value == 'on' ? 1 : 0;
        $status_note = $status == 1 ? '开启' : '关闭';
        $data=array(
            'asc_s_id'             => $this->curr_sid,
        );
        if ($type == 'shareAllow') {
            $data['asc_open_share_card'] = $status;
            $type_note = '分享领取复活卡';
        }
        if ($type == 'question') {
            $data['asc_open_public_question'] = $status;
            $type_note = '公共题库';
        }
        if ($type == 'open') {
            $data['asc_open'] = $status;
            $type_note = '答题活动';
        }
        if ($type == 'award_open') {
            $data['asc_award_open'] = $status;
            $type_note = '奖品赛';
        }
        if ($type == 'points_open') {
            $data['asc_points_open'] = $status;
            $type_note = '积分赛';
        }
        if ($type == 'redpacket_open') {
            $data['asc_redpacket_open'] = $status;
            $type_note = '红包赛';
        }
        $cfg_model = new App_Model_Answer_MysqlAnswerCfgStorage($this->curr_sid);
        if($id){
            $ret=$cfg_model->fetchUpdateCfg($data);
        }else{
            $data['asc_create_time']=time();
            $ret=$cfg_model->insertValue($data);
        }
        if($ret){
            if($status_note && $type_note){
                App_Helper_OperateLog::saveOperateLog($status_note.$type_note);
            }

            $this->showAjaxResult($ret,'保存');
        }else{
            $this->displayJsonError('保存失败');
        }
    }
    public function subjectListAction() {
        $this->secondLink('list');
        $name          = $this->request->getStrParam('name');
        $degreeNum     = $this->request->getStrParam('degreeNum');
        $type          = $this->request->getStrParam('type');
        $page          = $this->request->getIntParam('page');
        $subject_model = new App_Model_Answer_MysqlSubjectStorage($this->curr_sid);
        $index         = $page * $this->count;
        $where=array();
        if($type=='public'){
            $where[]   = array('name' =>'as_s_id', 'oper' => '=', 'value' => 0);
            $this->output['type'] = 'public';
        }else{
            $where[]    = array('name' =>'as_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $this->output['type'] = 'pri';
        }
        if($name){
            $where[]   = array('name' =>'as_question', 'oper' => 'like', 'value' =>"%$name%");
            $this->output['name'] = $name;
        }
        if($degreeNum){
            $where[]   = array('name' =>'as_degree', 'oper' => '=', 'value' =>$degreeNum);
            $this->output['degreeNum'] = $degreeNum;
        }
        $sort       = array('as_create_time'=>'DESC');
        $list       = $subject_model->getList($where,$index,$this->count,$sort);
        $total      = $subject_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $this->output['list'] = $list;
        $degree=array(
            '1'=>'简单',
            '2'=>'较简单',
            '3'=>'一般',
            '4'=>'较难',
            '5'=>'困难',
        );
        $this->output['degree'] = $degree;
        $this->buildBreadcrumbs(array(
            array('title' => '题目管理', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/answer/subject-list.tpl");
    }
    public function subjectAction() {
        $this->secondLink('list');
        $id              = $this->request->getIntParam('id');
        $type            = $this->request->getStrParam('type');
        $subject_model   = new App_Model_Answer_MysqlSubjectStorage($this->curr_sid);
        if($id){
            $row     = $subject_model->getRowById($id);
            $this->output['row'] = $row;
            $this->output['type'] = $type;
        }
        $degree=array(
            '1'=>'简单',
            '2'=>'较简单',
            '3'=>'一般',
            '4'=>'较难',
            '5'=>'困难',
        );
        $this->output['degree'] = $degree;
        $answer=array(
            '1'=>'选项一',
            '2'=>'选项二',
            '3'=>'选项三',
            '4'=>'选项四',
        );
        $this->output['answer'] = $answer;
        $this->buildBreadcrumbs(array(
            array('title' => '题目列表', 'link' => '/wxapp/answer/subjectList'),
            array('title' => '题目编辑', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty("wxapp/answer/addSubject.tpl");
    }
    public function saveSubjectAction() {
        $id              = $this->request->getIntParam('id');
        $question        = $this->request->getStrParam('question');
        $questionCover        = $this->request->getStrParam('questionCover');
        $answer          = $this->request->getIntParam('answer');
        $item1           = $this->request->getStrParam('item1');
        $item2           = $this->request->getStrParam('item2');
        $item3           = $this->request->getStrParam('item3');
        $item4           = $this->request->getStrParam('item4');
        $degree          = $this->request->getIntParam('degree');
        $data=array(
            'as_question'       => $question,
            'as_answer'         => $answer,
            'as_item1'          => $item1,
            'as_item2'          => $item2,
            'as_item3'          => $item3,
            'as_item4'          => $item4,
            'as_degree'         => $degree,
            'as_s_id'           => $this->curr_sid,
            'as_question_cover' => $questionCover
        );
        $subject_model   = new App_Model_Answer_MysqlSubjectStorage($this->curr_sid);
        if($id){
            $ret=$subject_model->updateById($data,$id);
        }else{
            $data['as_create_time']=time();
            $ret=$subject_model->insertValue($data);
        }
        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存题目成功");
            $this->showAjaxResult($ret,'保存');

        }else{
            $this->displayJsonError('保存失败');
        }
    }
    public function deleteSubjectAction() {
        $id              = $this->request->getIntParam('id');
        $subject_model   = new App_Model_Answer_MysqlSubjectStorage($this->curr_sid);
        if($id){
            $set=array(
                'as_deleted'=>1
            );
            $ret=$subject_model->updateById($set,$id);
            if($ret){
                App_Helper_OperateLog::saveOperateLog("删除题目成功");
                $this->showAjaxResult($ret,'删除');
            }else{
                $this->displayJsonError('删除失败');
            }
        }else{
            $this->displayJsonError('删除失败');
        }

    }
    public function excelSubjectAction(){
        $uploader   = new Libs_File_Transfer_Uploader('document|office');
        $ret = $uploader->receiveFile('files');
        if(isset($ret['files'])){
            $excel_plugin = new App_Plugin_PHPExcel_PHPExcelPlugin();
            $dir = mb_substr($ret['files'],1,mb_strlen($ret['files']));
            $data = $excel_plugin->get_excel_subject_info($dir,'subject');
            if(isset($data['data']) && !empty($data['data'])){
                $ins_value = array();
                foreach($data['data'] as $key=>$val){
                    $val['as_question'] = plum_sql_quote($val['as_question']);
                    $val['as_answer'] = plum_sql_quote($val['as_answer']);
                    $val['as_item1'] = plum_sql_quote($val['as_item1']);
                    $val['as_item2'] = plum_sql_quote($val['as_item2']);
                    $val['as_item3'] = plum_sql_quote($val['as_item3']);
                    $val['as_item4'] = plum_sql_quote($val['as_item4']);
                    $val['as_degree'] = plum_sql_quote($val['as_degree']);
                    $ins_value[] = "(null,{$this->curr_sid},'{$val['as_question']}','{$val['as_answer']}','{$val['as_item1']}','{$val['as_item2']}','{$val['as_item3']}','{$val['as_item4']}','{$val['as_degree']}',0,'".time()."')";
                }
                $subject_storage = new App_Model_Applet_MysqlAppletSubjectStorage($this->curr_sid);
                $insert = $subject_storage->insertBatch($ins_value);
                if($insert){
                    $msg = '题目导入成功';
                    App_Helper_OperateLog::saveOperateLog($msg);
                    $this->showAjaxResult($insert,$msg);
                }else{
                    $this->displayJsonError('题目保存失败');
                }
            }else{
               $this->displayJsonError('数据为空');
            }
        }else{
            $this->displayJsonError('文件上传失败');
        }
    }
    public function currencyAction() {
        $this->secondLink('currency');
        $page           = $this->request->getIntParam('page');
        $currency_model = new App_Model_Answer_MysqlCurrencyStorage(7126);
        $where=array();
        $where[]    = array('name' => 'acc_s_id', 'oper' => '=', 'value' => 7126);
        $index         = $page * $this->count;
        $sort       = array('acc_create_time'=>'DESC');
        $list       = $currency_model->getList($where,$index,$this->count,$sort);
        $total      = $currency_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '币种管理', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/answer/currency-list.tpl");
    }
    public function saveCurrencyAction() {
        $id              = $this->request->getIntParam('id');
        $name            = $this->request->getStrParam('name');
        $data=array(
            'acc_name'       => $name,
            'acc_s_id'       => 7126,
        );
        $currency_model = new App_Model_Answer_MysqlCurrencyStorage(7126);
        if($id){
            $ret=$currency_model->updateById($data,$id);
        }else{
            $data['acc_create_time']=time();
            $ret=$currency_model->insertValue($data);
        }
        if($ret){
            $this->showAjaxResult($ret,'保存');

        }else{
            $this->displayJsonError('保存失败');
        }
    }
    public function deleteCurrencyAction() {
        $id              = $this->request->getIntParam('id');
        $currency_model = new App_Model_Answer_MysqlCurrencyStorage(7126);
        if($id){
            $set=array(
                'acc_deleted'=>1
            );
            $ret=$currency_model->updateById($set,$id);
            if($ret){
                $this->showAjaxResult($ret,'删除');

            }else{
                $this->displayJsonError('删除失败');
            }
        }else{
            $this->displayJsonError('删除失败');
        }

    }

    
    public function awardListAction() {
        $this->secondLink('award');
        $name          = $this->request->getStrParam('name');
        $page          = $this->request->getIntParam('page');
        $subject_model = new App_Model_Answer_MysqlSubjectAwardStorage($this->curr_sid);
        $index         = $page * $this->count;
        $where=array();
        if($name){
            $where[]   = array('name' =>'asa_name', 'oper' => 'like', 'value' =>"%$name%");
            $this->output['name'] = $name;
        }
        $where[]    = array('name' => 'asa_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort       = array('asa_create_time'=>'DESC');
        $list       = $subject_model->getList($where,$index,$this->count,$sort);
        $total      = $subject_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '奖品管理', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty("wxapp/answer/subject-award-list.tpl");
    }

   
    public function saveAwardAction(){
        $id    = $this->request->getIntParam('id',0);
        $name  = $this->request->getStrParam('name','');
        $cover = $this->request->getStrParam('cover','');
        $price = $this->request->getStrParam('price',0);

        $updata = array(
            'asa_s_id'    => $this->curr_sid,
            'asa_name'   => $name,
            'asa_cover'   => $cover,
            'asa_price'   => $price,
            'asa_update_time' => $_SERVER['REQUEST_TIME']
        );

        $asa_model = new App_Model_Answer_MysqlSubjectAwardStorage($this->curr_sid);

        if($id){
            $res = $asa_model->updateById($updata,$id);
        }else{
            $updata['asa_create_time'] = $_SERVER['REQUEST_TIME'];
            $res = $asa_model->insertValue($updata);
        }
        if($res){
            App_Helper_OperateLog::saveOperateLog("答题奖品【{$name}】保存成功");
        }
        $this->showAjaxResult($res,'保存');

  }

    
    public function deleteAwardAction(){
        $id  = $this->request->getIntParam('id');
        $asa_model = new App_Model_Answer_MysqlSubjectAwardStorage($this->curr_sid);
        $data = $asa_model->getRowById($id);
        $ret = $asa_model->deleteDFById($id);
        if($ret){
            App_Helper_OperateLog::saveOperateLog("答题奖品【{$data['asa_name']}】删除成功");
        }
        $this->showAjaxResult($ret,'删除');
    }

    
    public function awardRecordListAction(){
        $this->secondLink('award');
        $code          = $this->request->getStrParam('code');
        $awardId       = $this->request->getStrParam('awardId');
        $page          = $this->request->getIntParam('page');
        $subject_model = new App_Model_Answer_MysqlSubjectAwardRecordStorage($this->curr_sid);
        $award_model   = new App_Model_Answer_MysqlSubjectAwardStorage($this->curr_sid);
        $index         = $page * $this->count;
        $where=array();
        if($code){
            $where[]   = array('name' =>'asar_code', 'oper' => 'like', 'value' =>"%$code%");
            $this->output['code'] = $code;
        }
        if($awardId){
            $where[]   = array('name' =>'asar_award_id', 'oper' => '=', 'value' =>$awardId);
            $this->output['awardId'] = $awardId;
        }
        $sort       = array('asar_create_time'=>'DESC');
        $list       = $subject_model->fetchAwardRecordList($where,$index,$this->count,$sort,false,false);
        $total      = $subject_model->fetchAwardRecordList($where,0,0,array(),false,true);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $this->output['list'] = $list;
        $this->output['awards'] = $award_model->fetchAwardsBySid($this->curr_sid);
        $this->buildBreadcrumbs(array(
            array('title' => '奖品管理', 'link' => '/wxapp/answer/awardList'),
            array('title' => '查看获奖信息', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/answer/subject-award-record.tpl");
    }

    
    public function checkAwardAction(){
        $mid    = $this->request->getStrParam('mid');
        $code  = $this->request->getStrParam('code');
        $asar_model = new App_Model_Answer_MysqlSubjectAwardRecordStorage($this->curr_sid);
        $row = $asar_model->getRowByCode($mid,$code);
        if($row){
            if($row['asar_status'] == 1){
                $result = array(
                    'ec' => 400,
                    'em' => '该奖品已核销，请刷新页面'
                );
            }else{
               $updata = array(
                    'asar_status' => 1,
                   'asar_verify_time' => time()
                );
                $res = $asar_model->updateById($updata,$row['asar_id']);
                if($res){
                    $result = array(
                        'ec' => 200,
                        'em' => '核销成功'
                    );
                    App_Helper_OperateLog::saveOperateLog("答题奖品核销码【{$code}】核销成功");
                }else{
                    $result = array(
                        'ec' => 400,
                        'em' => '核销失败，请重试'
                    );
                }
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '奖品不存在，请刷新页面'
            );
        }
        $this->displayJson($result);
    }

    
    public function rankAction(){
        $this->secondLink('rank');
        $nickname = $this->request->getStrParam('nickname','');
        $page     = $this->request->getIntParam('page');
        $index    = $this->count * $page;
        $where = array();
        if($nickname){
            $where[] = array('name'=>'m_nickname','oper'=>'like','value'=>"%{$nickname}%");

        }
        $this->output['nickname'] = $nickname;
        $win_model = new App_Model_Answer_MysqlSubjectWinRankStorage($this->curr_sid);
        $list   = $win_model->getRankList($where,$index,$this->count);
        $total  = $win_model->getRankListCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        if($list){
            if($nickname){
                foreach ($list as $key => &$val){
                    $memRank = $win_model->getMemberRank($val['aswr_m_id']);
                    $val['rank'] = $memRank['rank'] && $val['aswr_win'] > 0 ? $memRank['rank'] : '无胜场';
                }
            }else{
                foreach ($list as $key => &$val){
                    $val['rank'] = $key + ($page * $this->count) + 1;
                }
            }
        }
        $this->buildBreadcrumbs(array(
            array('title' => '答题管理', 'link' => '/wxapp/answer/index'),
            array('title' => '排行榜', 'link' => '#'),
        ));
        $this->output['list'] = $list;
        $where = array();
        $total = $win_model->getRankListCount($where);
        $total_rs = $win_model->getRankListCount($where,true);
        $where[] = array('name' => 'aswr_win', 'oper' => '=', 'value' => 1);
        $total_zqcs = $win_model->getRankListCount($where);
        $where[0] = array('name' => 'aswr_win', 'oper' => '=', 'value' => 0);
        $total_cwcs = $win_model->getRankListCount($where);

        $this->output['statInfo'] = [
            'total'     => $total ? $total : 0,
            'total_rs' => $total_rs ? $total_rs : 0,
            'total_zqcs' => $total_zqcs ? $total_zqcs : 0,
            'total_cwcs' => $total_cwcs ? $total_cwcs : 0,
        ];

        $this->displaySmarty('wxapp/answer/subject-rank-list.tpl');
    }

    
    public function changeWinNumAction(){
        $result = array(
            'ec' => 400,
            'em' => '保存失败'
        );
        $id = $this->request->getIntParam('id');
        $num = $this->request->getIntParam('num');
        if($id && $num >= 0){
            $update = array(
                'aswr_win' => $num
            );
            $win_model = new App_Model_Answer_MysqlSubjectWinRankStorage($this->curr_sid);
            $res = $win_model->updateById($update,$id);
            if($res){
                $result = array(
                    'ec' => 200,
                    'em' => '修改成功'
                );
                App_Helper_OperateLog::saveOperateLog("答题排行榜修改成功");
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '数据异常'
            );
        }
        $this->displayJson($result,1);
    }


}