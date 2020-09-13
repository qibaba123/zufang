<?php


class App_Controller_Wxapp_SlideController extends App_Controller_Wxapp_InitController
{
    public function __construct()
    {
        parent::__construct();
//        $this->hold_dir     = PLUM_APP_BUILD.'/spread/';
//        $this->access_path  = PLUM_PATH_PUBLIC.'/build/spread/';
    }


    //首页导航
    public function indexNavAction(){
        $nav_model = new App_Model_Index_MysqlIndexNavStorage();
        $list      = $nav_model->getList(array(),0,0,array('in_weight'=>"DESC"));
        $this->output['list'] = $list;
        $this->output['type'] = array(
            1 => '企业服务',
            2 => '园区服务',
            3 => '学习园地',
            4 => '关于我们',
        );
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '首页导航管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/currency/nav.tpl');
    }

    //保存首页导航
    public function saveNavAction(){
        $id = $this->request->getIntParam('id',0);
//        $category = $this->request->getIntParam('category');
//        $categoryOld = $this->request->getIntParam('categoryOld');
        $sort = $this->request->getIntParam('sort');
        $type = $this->request->getIntParam('type');
        $path = $this->request->getStrParam('path');
        //$gid  = $this->request->getIntParam('gid',0);
        $name = $this->request->getStrParam('name');

        if($path){
            $nav_model = new App_Model_Index_MysqlIndexNavStorage();
            $data = array(
                'in_weight'    => $sort,
                'in_logo'      => $path,
                'in_type'      => $type,
                'in_name'      => $name,
                'in_create_time'  => time()
            );
            if($id){
                $res = $nav_model -> updateById($data,$id);
            }else{
                $res = $nav_model -> insertValue($data);
            }
            $this->showAjaxResult($res,'保存');
        }else{
            $this->displayJsonError('添加失败');
        }

    }


    //幻灯管理
    public function informationSlideAction() {
        $this->informationSecondLink('cate');
        $slide_model = new App_Model_Slide_MysqlSlideStorage();
        $where       = array();

        $sort        = array('sl_weight'=>'DESC','sl_id'=>'DESC');
        $list        = $slide_model->getList($where,0,0,$sort);
        $this->output['list']  = $list;
//        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
////        $where1      = array('name'=>'g_deleted','oper'=>'=','value'=>0);
//        $where       = array();
//        $where[]     = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
//        $where[]     = array('name' => 'g_independent_mall','oper' => '=','value' =>0);
//        $where[]     = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
//        $sort        =  array('g_weight'=>'ASC','g_id' => 'DESC');
//        $goods       = $goods_model->getList($where,0,0,$sort);
//
//        $this->output['goods'] = $goods;
        $infor_model = new App_Model_Applet_MysqlAppletInformationStorage();
        $this->output['information'] = $infor_model->getList(array(),0,0,array('ai_sort'=>'DESC'));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '幻灯片管理', 'link' => '#'),
        ));
        $slide_type = plum_parse_config('slide_type','juqingshe');
        $this->output['slide_type'] = $slide_type;
        $this->displaySmarty('wxapp/currency/slide.tpl');
    }


    public function saveSlideAction(){
        $id = $this->request->getIntParam('id',0);
//        $category = $this->request->getIntParam('category');
//        $categoryOld = $this->request->getIntParam('categoryOld');
        $sort = $this->request->getIntParam('sort');
        $type = $this->request->getIntParam('type');
        $path = $this->request->getStrParam('path');
        //$gid  = $this->request->getIntParam('gid',0);
        $ainame = $this->request->getStrParam('ainame');
        $aiid   = $this->request->getIntParam('aiid');

        if($path){
            $slide_model = new App_Model_Slide_MysqlSlideStorage();
            $data = array(
                'sl_s_id'      => $this->curr_sid,
                'sl_weight'    => $sort,
                'sl_img'       => $path,
                'sl_link'      => $aiid,
                'sl_type'      => $type,
                'sl_link_name' => $ainame,
                'sl_add_time'  => time()
            );
            if($id){
                $res = $slide_model -> updateById($data,$id);
            }else{
                $res = $slide_model -> insertValue($data);
            }
            $this->showAjaxResult($res,'保存');
        }else{
            $this->displayJsonError('添加失败');
        }

    }

    public function deleteSlideAction(){
        $id = $this->request->getIntParam('id',0);
        $slide_model = new App_Model_Slide_MysqlSlideStorage();
        $res = $slide_model->deleteById($id);
        $this->showAjaxResult($res,'删除');
    }



    public function secondLink($type='index'){
        $link = array(
            array(
                'label' => '首页视频',
                'link'  => '/wxapp/currency/conductVideo',
                'active'=> 'video'
            ),
            array(
                'label' => '背景音乐',
                'link'  => '/wxapp/currency/backgroundMusic',
                'active'=> 'music'
            ),
            array(
                'label' => 'VR全景',
                'link'  => '/wxapp/currency/vrUrl',
                'active'=> 'vrUrl'
            ),
        );
        $this->output['link']       = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = 'VR/音视频设置';
    }


    public function appointmentListAction(){
        $page = $this->request->getIntParam('page');
        $mobile = $this->request->getStrParam('mobile');
        $index = $page*$this->count;
        $where = array();
        $where[] = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'ai_es_id','oper'=>'=','value'=>0);
        if($mobile){
            $where[] = array('name'=>'ai_mobile','oper'=>'=','value'=>$mobile);
        }
        $sort = array('ai_processed'=>'ASC','ai_create_time'=>'DESC');

        $appointment_storage = new App_Model_Applet_MysqlWeddingAppointmentStorage($this->curr_sid);
        $total = $appointment_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pageHtml']   = $pageCfg->render();
        $this->output['appCfg'] = $this->wxapp_cfg;
        $list = array();
        if($index<$total){
            $list = $appointment_storage->getList($where,$index,$this->count,$sort);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '模块管理', 'link' => '#'),
            array('title' => '预约管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/currency/appointment.tpl');
    }


    public function handleAppointmentAction(){
        $id = $this->request->getIntParam('id');
        $market = $this->request->getStrParam('market');
        if($id){
            $updata = array(
                'ai_remark'    => $market,
                'ai_processed' => 1,
            );
            $appointment_storage = new App_Model_Applet_MysqlWeddingAppointmentStorage($this->curr_sid);
            $ret = $appointment_storage->updateById($updata,$id);
            $this->showAjaxResult($ret,'处理');
        }else{
            $this->displayJsonError('处理失败，请稍后重试');
        }
    }

    public function deleteAppointmentAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $updata = array(
                'ai_deleted' => 1,
            );
            $appointment_storage = new App_Model_Applet_MysqlWeddingAppointmentStorage($this->curr_sid);
            $ret = $appointment_storage->updateById($updata,$id);
            $this->showAjaxResult($ret,'删除');
        }else{
            $this->displayJsonError('删除失败，请稍后重试');
        }
    }

    public function articleListAction(){
        $page       = $this->request->getIntParam('page');
        $where      = array();
        $where[]    = array('name'=>'aa_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'aa_deleted','oper'=>'=','value'=>0);
        $index      = $page * $this->count;

        $article_model  = new App_Model_Applet_MysqlAppletArticleStorage();
        $total      = $article_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $output['pagination']   = $pageCfg->render();

        $list = array();
        if($index < $total){
            $sort = array('aa_create_time' => 'DESC');
            $list = $article_model->getList($where,$index,$this->count,$sort);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '文章管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/currency/article-list.tpl');
    }


    public function addArticleAction(){
        $id = $this->request->getIntParam('id');
        $row = array();
        if($id){
            $article_model = new App_Model_Applet_MysqlAppletArticleStorage();
            $row = $article_model->getRowById($id);
        }
        $this->output['row'] = $row;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '文章管理', 'link' => '/wxapp/currency/articleList'),
            array('title' => '添加文章', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/currency/add-article.tpl');
    }


    public function saveArticleAction(){
        $title   = $this->request->getStrParam('title');
        $brief   = $this->request->getStrParam('brief');
        $cover   = $this->request->getStrParam('cover');
        $content = $this->request->getParam('content');
        $id      = $this->request->getIntParam('id');
        if($title && $cover && $content){
            $data = array(
                'aa_title'       => $title,
                'aa_cover'       => $cover,
                'aa_brief'       => $brief,
                'aa_content'     => $content,
                'aa_create_time' => time(),
                'aa_s_id'        => $this->curr_sid,
            );
            $article_model = new App_Model_Applet_MysqlAppletArticleStorage();
            if($id){
                $ret = $article_model->updateById($data,$id);
            }else{
                $ret = $article_model->insertValue($data);
            }
            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError('请将信息填写完整');
        }
    }


    public function conductVideoAction(){
        $this->secondLink('video');
        $qiniu_cfg = plum_parse_config('access','qiniu');
        $key = $this->curr_shop['s_unique_id'].'.mp4';
        $qiniu_client = new App_Plugin_Qiniu_Client();
        $token = $qiniu_client->getUploadToken($key);
        $video_storage = new App_Model_Applet_MysqlAppletVideoStorage($this->curr_sid);
        $row = $video_storage->fetchShopVideo(null,false);
        $this->output['row']  = $row;
        $this->output['token'] = $token;
        $this->output['key'] = $key;
        $this->output['qnDomain'] = $qiniu_cfg['host'];
        $this->buildBreadcrumbs(array(
            array('title' => '配置管理', 'link' => '#'),
            array('title' => '音视频配置', 'link' => '/wxapp/currency/conductVideo'),
            array('title' => '视频管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/currency/new-video.tpl');
    }


    public function backgroundMusicAction(){
        $this->secondLink('music');
        $video_storage = new App_Model_Applet_MysqlAppletVideoStorage($this->curr_sid);
        $row = $video_storage->fetchShopVideo(null,false);
        $this->output['row']  = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '配置管理', 'link' => '#'),
            array('title' => '音视频配置', 'link' => '/wxapp/currency/conductVideo'),
            array('title' => '音频管理', 'link' => '#'),
        ));
        $qiniu_cfg = plum_parse_config('access','qiniu');
        $key = $this->curr_shop['s_unique_id'].'.mp3';
        $qiniu_client = new App_Plugin_Qiniu_Client();
        $token = $qiniu_client->getUploadToken($key);
        $this->output['token'] = $token;
        $this->output['key'] = $key;
        $this->output['qnDomain'] = $qiniu_cfg['host'];
        $this->displaySmarty('wxapp/currency/new-music.tpl');
    }


    public function vrUrlAction(){
        $this->secondLink('vrUrl');
        $video_storage = new App_Model_Applet_MysqlAppletVideoStorage($this->curr_sid);
        $row = $video_storage->fetchShopVideo(null,false);
        $this->output['row']  = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '配置管理', 'link' => '#'),
            array('title' => 'VR/音视频配置', 'link' => '/wxapp/currency/conductVideo'),
            array('title' => 'VR管理', 'link' => '#'),
        ));
        $business_domain = plum_parse_config('business_domain','wxxcx');
        $curr_business = $this->wxapp_cfg['ac_auth_business_domain'] ? json_decode($this->wxapp_cfg['ac_auth_business_domain'],true) : array();
        $diff_array = array_diff($business_domain,$curr_business);
        if(!empty($diff_array)){
            $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
            $ret = $wxxcx_client->getWebDomain();
            if($ret && !$ret['errcode']){
                $curr_diff = array_diff($business_domain,$ret['webviewdomain']);
                if(!empty($curr_diff)){
                    $action = 'add';
                    if(empty($ret['webviewdomain'])){
                        $action = 'set';
                    }
                    $add = $wxxcx_client->addWebDomain($curr_diff,$action);
                    if($add){
                        $setData = array('ac_auth_business_domain'=>json_encode($business_domain));
                        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
                        $applet_model->findShopCfg($setData);
                    }
                }else if(empty($curr_business)){
                    $setData = array('ac_auth_business_domain'=>json_encode($business_domain));
                    $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
                    $applet_model->findShopCfg($setData);
                }
            }
        }
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/currency/vrurl.tpl');
    }

    public function saveVrUrlAction(){
        $musicUrl= $this->request->getStrParam('vrUrl');
        $open= $this->request->getIntParam('open');
        $title= $this->request->getStrParam('title');
        $cover= $this->request->getStrParam('cover');
        $updata = array(
            'av_vr_url'   => $musicUrl,
            'av_vr_isopen' => $open,
            'av_vr_share_title' => $title,
            'av_vr_share_cover' => $cover
        );
        $video_storage = new App_Model_Applet_MysqlAppletVideoStorage($this->curr_sid);
        $row = $video_storage->fetchShopVideo(null,false);
        if($row){

            $ret = $video_storage->fetchShopVideo($updata,false);
        }else{
            $updata['av_s_id'] = $this->curr_sid;
            $updata['av_update_time'] = time();
            $ret = $video_storage->insertValue($updata);
        }
        App_Helper_OperateLog::saveOperateLog("VR全景配置信息保存成功");
        $this->showAjaxResult($ret);
    }

    private function _get_video_time($url){
        $session_url = $url.'?avinfo';
        $result = file_get_contents($session_url);
        $result = json_decode($result,true);
        if($result){
            $time = round($result['format']['duration']);
            return $time;
        }
        return false;

    }
    private function _update_video_time($url){
        $m= new ffmpeg_movie($url, false);
        return $m->getDuration();//显示时长秒数
    }


    public function saveVideoOpenAction(){
        $open = $this->request->getIntParam('open');
        $videoTime = $this->request->getIntParam('videoTime');
        $videoUrl = $this->request->getStrParam('videoUrl');
        $updata = array(
            'av_is_open'    => $open,
            'av_video_url'  => $videoUrl,
            'av_time'       => $videoTime
        );
        $video_storage = new App_Model_Applet_MysqlAppletVideoStorage($this->curr_sid);
        $row = $video_storage->fetchShopVideo(null,false);
        if($row){
            $ret = $video_storage->updateById($updata,$row['av_id']);
        }else{
            $updata['av_s_id'] = $this->curr_sid;
            $updata['av_update_time'] = time();
            $ret = $video_storage->insertValue($updata);
        }
        App_Helper_OperateLog::saveOperateLog("首页视频配置信息保存成功");
        $this->showAjaxResult($ret);
    }


    public function saveVideoOpenSwitchAction(){
        $result = array(
            'ec' => 400,
            'em' => '失败'
        );
        $open = $this->request->getIntParam('open');
        $updata = array(
            'av_is_open'    => $open,
        );
        $video_storage = new App_Model_Applet_MysqlAppletVideoStorage($this->curr_sid);
        $row = $video_storage->fetchShopVideo(null,false);
        if($row){
            $ret = $video_storage->updateById($updata,$row['av_id']);
        }else{
            $updata['av_s_id'] = $this->curr_sid;
            $updata['av_update_time'] = time();
            $ret = $video_storage->insertValue($updata);
        }
        if($ret){
            $result = array(
                'ec' => 200,
                'em' => '成功',
                'open' => $open
            );
        }
        $this->displayJson($result,true);
    }


    public function saveMusicAction(){
        $title= $this->request->getStrParam('title');
        $musicUrl= $this->request->getStrParam('musicUrl');
        $open= $this->request->getIntParam('open');
        $updata = array(
            'av_music_isopen' => $open
        );
        if($title){
            $updata['av_music_title'] = $title;
        }
        if($musicUrl){
            $updata['av_music_url'] = $musicUrl;
        }
        $updata['av_update_time'] = time();
        $video_storage = new App_Model_Applet_MysqlAppletVideoStorage($this->curr_sid);
        $row = $video_storage->fetchShopVideo(null,false);
        if($row){
            $ret = $video_storage->fetchShopVideo($updata,false);
        }else{
            $updata['av_s_id'] = $this->curr_sid;
            $ret = $video_storage->insertValue($updata);
        }
        App_Helper_OperateLog::saveOperateLog("背景音乐配置信息保存成功");
        $this->showAjaxResult($ret);
    }


    public function saveMusicOpenAction(){
        $result = array(
            'ec'    => 400,
            'em'    => '失败'
        );
        $open= $this->request->getIntParam('open');
        $video_storage = new App_Model_Applet_MysqlAppletVideoStorage($this->curr_sid);
        $row = $video_storage->fetchShopVideo(null,false);
        $update = array(
            'av_music_isopen' => $open
        );
        if($row){
            $ret = $video_storage->fetchShopVideo($update,false);
        }else{
            $update['av_s_id'] = $this->curr_sid;
            $update['av_update_time'] = time();
            $ret = $video_storage->insertValue($update);
        }
        if($ret){
            $result = array(
                'ec'    => 200,
                'em'    => '成功',
                'open'  => $open
            );
            App_Helper_OperateLog::saveOperateLog("背景音乐".($open==1?'开启':'关闭')."成功");
        }
        $this->displayJson($result,1);
    }


    public function deletedArticleAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $article_model = new App_Model_Applet_MysqlAppletArticleStorage();
            $ret = $article_model->deleteDFById($id,$this->curr_sid);
        }
        $this->showAjaxResult($ret,'删除');
    }


    public function payStyleAction() {
        $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->curr_sid);
        $type = $pay_type->findRowPay();
        if(empty($type)){
            $type = array(
                'pt_s_id'       => $this->curr_sid,
                'pt_wxpay_ds'   => 0,
                'pt_wxpay_zy'   => 0,
                'pt_alipay'     => 0,
                'pt_cash'       => 0,
                'pt_coin'       => 0,
                'pt_wxpay_applet' => 0,
                'pt_baidu_pay'    => 0,
                'pt_alipay_applet'=>0,
                'pt_create_time'=> time()
            );
            $pay_type->insertValue($type);
        }
        $this->output['payType'] = $type;
        $pay_model      = new App_Model_Applet_MysqlAppletPayStorage($this->curr_sid);
        $appletPay         = $pay_model->findRowPay();
        $pay_model      = new App_Model_Baidu_MysqlBaiduPayCfgStorage($this->curr_sid);
        $baiduPay       = $pay_model->findRowPay();


        $sequenceShowAll = 1;
        if($this->wxapp_cfg['ac_type'] == 36){
            $sequenceShowAll = 0;
        }
        $this->output['sequenceShowAll'] = $sequenceShowAll;

        $this->output['appletPay'] = $appletPay;
        $this->output['baiduPay']  = $baiduPay;
        $this->output['applet_cfg'] = $this->wxapp_cfg;
        $this->output['secretKey'] = plum_salt_password(plum_random_code(8));
        $this->buildBreadcrumbs(array(
            array('title' => '配置管理', 'link' => '#'),
            array('title' => '支付配置', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/currency/paystyle.tpl");
    }


    public function savePayAction(){
        $pre    = 'ap_';
        $req_key= array('appid','mchid','mchkey','sslcert','sslkey');
        $result = $this->deal_save_pay($pre,$req_key);
        $this->displayJson($result);
    }


    public function saveBaiduPayAction(){
        Libs_Log_Logger::outputLog('百度支付配置');
        $pre    = 'abp_';
        $req_key= array('dealid','appkey','public_key','public_rsa_key','private_rsa_key');
        Libs_Log_Logger::outputLog($req_key);
        $result = $this->deal_save_pay($pre,$req_key);
        $this->displayJson($result);
    }


    public function saveAlipayAction(){
        $pre = 'ap_';
        $req_key = array('pid','account','key','ssl_pub','ssl_pri');
        $result = $this->deal_save_pay($pre,$req_key);
        $this->displayJson($result);
    }

    private function deal_save_pay($pre,$req_key){
        $data = array();
        foreach($req_key as $val){
            $data[$pre.$val] = $this->request->getStrParam($val);
        }
        $data[$pre.'update_time'] = time();
        Libs_Log_Logger::outputLog($data);
        switch($pre){
            case 'ap_':
                $pay_model      = new App_Model_Applet_MysqlAppletPayStorage($this->curr_sid);
                break;
            case 'abp_':
                $pay_model      = new App_Model_Baidu_MysqlBaiduPayCfgStorage($this->curr_sid);
                break;
            case 'atp_':
                $pay_model      = new App_Model_Toutiao_MysqlToutiaoPayStorage($this->curr_sid);
                break;

            default:
                $pay_model   = new App_Model_Auth_MysqlAlipayPayStorage($this->curr_sid);
                break;
        }
        $row            = $pay_model->findRowPay();
        if($row){
            $ret = $pay_model->updateById($data,$row[$pre.'id']);
        }else{
            $data[$pre.'s_id'] = $this->curr_sid;
            $data[$pre.'create_time'] = time();
            Libs_Log_Logger::outputLog($data);
            $ret = $pay_model->insertValue($data);
        }
        if($ret){
            if($data['ap_sslcert'] && $data['ap_sslkey'] && !$row['ap_pubpem']){
                $this->_save_applet_public_key();
            }
            App_Helper_OperateLog::saveOperateLog("支付配置信息保存成功");
            $result = array(
                'ec' => 200,
                'em' => '保存成功'
            );
        }else{
            $result = array(
                'ec' => 400,
                'em' => '保存失败'
            );
        }
        return $result;
    }


    public function changePayAction(){
        $result = array(
            'ec' => 400,
            'em' => '请填写相关支付配置'
        );
        $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->curr_sid);
        $row = $pay_type->findRowPay();

        $type  = $this->request->getStrParam('type');
        $check = true;
        if($type == 'wxpay_applet' && $row['pt_wxpay_applet'] == 0){
            $mchid      = $this->request->getStrParam('mchid');
            if(!$mchid){
                $check = false;
            }
            $mchkey     = $this->request->getStrParam('mchkey');
            if(!$mchkey){
                $check = false;
            }
        }
        if($check){
            $set = $this->pay_type_field($type,$row['pt_'.$type]);
            $ret = $pay_type->findRowPay($set);
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '修改成功'
                );
            }else{
                $result['em'] = '修改失败';
            }
        }
        $this->displayJson($result);
    }


    private function pay_type_field($type,$key){
        $field = array('wxpay_ds','wxpay_zy','alipay','cash','coin','wxpay_applet','baidu_pay');
        $set   = array();
        if($key == 1){
            $set['pt_'.$type] = 0;
        }else{
            $set['pt_'.$type] = 1;
            if($type == 'wxpay_ds'){
                $set['pt_wxpay_zy'] = 0;
            }elseif($type == 'wxpay_zy'){
                $set['pt_wxpay_ds'] = 0;
            }
        }
        return $set;
    }


    public function informationSecondLink($type='list'){
        $link = array(
            array(
                'label' => '分类管理',
                'link'  => '/wxapp/currency/informationCate',
                'active'=> 'cate'
            ),
            array(
                'label' => '文章列表',
                'link'  => '/wxapp/currency/informationList',
                'active'=> 'list'
            ),

        );
        if($this->wxapp_cfg['ac_type'] == 1 || $this->wxapp_cfg['ac_type'] == 3 || $this->wxapp_cfg['ac_type'] == 6 || $this->wxapp_cfg['ac_type'] == 13 || $this->wxapp_cfg['ac_type'] == 21 || $this->wxapp_cfg['ac_type'] == 27 || $this->wxapp_cfg['ac_type'] == 28){
            array_push($link, array(
                'label' => '付费管理',
                'link'  => '/wxapp/currency/informationCardType',
                'active'=> 'pay'
            ));
        }
        $this->output['secondLink'] = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '资讯管理';
    }

    public function informationCateAction(){
        $this->informationSecondLink('cate');
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $list = $category_storage->getListBySid();
        $category_select = $category_storage->getCategoryListForSelect();
        $categoryList = array();
        if($this->wxapp_cfg['ac_type'] == 7){
            $category_page_link = '/pages/informationSpecial/informationSpecial';
        }else{
            $category_page_link = '/pages/informationPage/informationPage';
        }

        if($list){
            foreach ($list as $key => $val){
                $categoryList[] = array(
                    'id'    => $val['aic_id'],
                    'index' => $key,
                    'name'  => $val['aic_name'],
                    'page'  => $category_page_link.'?id='.$val['aic_id'].'&title='.$val['aic_name']
                );
            }
        }
        $this->output['categoryList'] = json_encode($categoryList);
        $this->output['categoryListSelect'] = $categoryList;
        $this->output['category'] = $list;
        $this->output['category_select'] = $category_select;
        $this->output['applet_cfg'] = $this->wxapp_cfg;



        $this->output['category_page_link'] = $category_page_link;
        $this->buildBreadcrumbs(array(
            array('title' => '模块管理', 'link' => '#'),
            array('title' => '资讯管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/currency/information-cate.tpl');
    }


    public function informationListAction(){
        $this->informationSecondLink('list');
        $page       = $this->request->getIntParam('page');
        $wxno       = $this->request->getStrParam('wxno');
        $page_link = '/pages/informationDetail/informationDetail';
        $this->output['page_link'] = $page_link;

        $index      = $page * $this->count;
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        if($wxno){
            $where[]       = array('name'=>'ai_wx_no','oper'=>'like','value'=>"%{$wxno}%");
        }
        $title = $this->request->getStrParam('title');
        if($title){
            $where[]       = array('name'=>'ai_title','oper'=>'like','value'=>"%{$title}%");
        }
        $this->output['title'] = $title;

        $categoryId = $this->request->getIntParam('categoryId');
        if($categoryId){
            $where[]       = array('name'=>'ai_category','oper'=>'=','value'=>$categoryId);
        }
        $this->output['categoryId'] = $categoryId;

        $startTime   = $this->request->getStrParam('start');
        if($startTime){
            $where[]    = array('name' => 'ai_create_time', 'oper' => '>=', 'value' => strtotime($startTime));
        }
        $this->output['start'] = $startTime;

        $endTime     = $this->request->getStrParam('end');
        if($endTime){
            $where[]    = array('name' => 'ai_create_time', 'oper' => '<=', 'value' => (strtotime($endTime) + 86400));
        }
        $this->output['end'] = $endTime;
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $total      = $information_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination']   = $pageCfg->render();
        $list = array();
        if($index < $total){
            $sort          = array('ai_create_time' => 'DESC');
            $list          = $information_storage->getList($where,$index,$this->count,$sort);
        }
        $this->output['shopId'] = $this->curr_sid;
        $this->output['list'] = $list;
        $this->output['showPage'] = $total > $this->count ? 1 : 0;
        $this->_get_information_category();
        $where_sum = [];
        $where_sum[] = ['name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid];
        $infoStat = $information_storage->getSumInfo($where_sum);
        $push_model = new App_Model_Tplmsg_MysqlPushHistoryStorage();
        $where_push = [];
        $where_push[] = ['name'=>'aph_s_id','oper'=>'=','value'=>$this->curr_sid];
        $where_push[] = ['name'=>'aph_information_id','oper'=>'>','value'=>0];
        $where_push[] = ['name'=>'ai_deleted','oper'=>'=','value'=>0];
        $pushStat = $push_model->getSum($where_push,'information');
        $this->output['statInfo'] = [
            'infoTotal' => $infoStat['infoTotal'] ? $infoStat['infoTotal'] : 0,
            'commentSum' => $infoStat['commentSum'] ? $infoStat['commentSum'] : 0,
            'showSum' => $infoStat['showSum'] ? $infoStat['showSum'] : 0,
            'likeSum' => $infoStat['likeSum'] ? $infoStat['likeSum'] : 0,
            'pushTotal' => $pushStat['pushTotal'] ? $pushStat['pushTotal'] : 0,
            'pushMemberSum' => $pushStat['pushMemberSum'] ? $pushStat['pushMemberSum'] : 0,
        ];

        $this->buildBreadcrumbs(array(
            array('title' => '模块管理', 'link' => '#'),
            array('title' => '资讯管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/currency/information-list.tpl');
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


    public function changeInformationCateAction(){
        $ids = $this->request->getStrParam('ids');
        $category  = $this->request->getIntParam('custom_cate');
        $id_arr = plum_explode($ids);

        if(!empty($id_arr)){
            $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
            $set = array('ai_category' => $category);
            $where = array();
            $where[] = array('name' => 'ai_id', 'oper' => 'in', 'value' => $id_arr);
            $ret = $information_storage->updateValue($set, $where);
        }

        if($ret){
            $result = array(
                'ec' => 200,
                'em' => '修改成功'
            );
        }else{
            $result = array(
                'ec' => 400,
                'em' => '修改失败'
            );
        }

        $this->displayJson($result);
    }


    public function informationMultiDeleteAction(){
        $ids = $this->request->getStrParam('ids');
        $id_arr = plum_explode($ids);
        if(!empty($id_arr)){
            $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
            $set = array('ai_deleted' => 1);
            $where = array();
            $where[] = array('name' => 'ai_id', 'oper' => 'in', 'value' => $id_arr);
            $ret = $information_storage->updateValue($set, $where);
        }

        if($ret){
            $result = array(
                'ec' => 200,
                'em' => '删除成功'
            );
        }else{
            $result = array(
                'ec' => 400,
                'em' => '删除失败'
            );
        }

        $this->displayJson($result);
    }


    public function addInformationAction(){
        $id = $this->request->getIntParam('id');
        $row = array();
        $goodsList = array();
        $agoodsList = array();
        $relatedInfo = array();
        if($id){
            $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
            $row = $information_storage->getRowById($id);
            if($row['ai_g_id']){
                $gidArr = json_decode($row['ai_g_id'],1);
                if(!empty($gidArr)){
                    $where_goods = array();
                    $where_goods[]    = array('name' => 'g_id', 'oper' => 'in', 'value' => $gidArr);
                    $where_goods[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' =>$this->curr_sid);
                    $where_goods[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
                    $g_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
                    $goodsList = $g_model->getList($where_goods,0,10,array(),array('g_id','g_name'));
                }
                $this->output['goodsList'] = $goodsList;
            }

            if($row['ai_ag_id']){
                $agidArr = json_decode($row['ai_ag_id'],1);
                if(!empty($agidArr)){
                    $where_goods = array();
                    $where_goods[]    = array('name' => 'g_id', 'oper' => 'in', 'value' => $agidArr);
                    $where_goods[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' =>$this->curr_sid);
                    $where_goods[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
                    $g_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
                    $agoodsList = $g_model->getList($where_goods,0,10,array(),array('g_id','g_name'));
                }
                $this->output['appointmentGoodsList'] = $agoodsList;
            }

            if($row['ai_related_info']){
                $informationArr = $this->_get_information_cate_group($id,FALSE);
                $relatedInfo = json_decode($row['ai_related_info'],1);
                if(!empty($relatedInfo)){
                    foreach ($relatedInfo as &$info){
                        $info['selectInfo'] = $informationArr[$info['cateId']];
                    }
                }
            }

        }
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $category_select = $category_storage->getCategoryListForSelect();
        $row['ai_video'] = ($row['ai_video'] && !plum_is_url($row['ai_video']))?$this->_get_tencent_video($row['ai_video']):$row['ai_video'];
        $row['ai_content'] = htmlentities($row['ai_content']);
        $this->output['row'] = $row;
        $this->output['category_select'] = $category_select;
        $this->output['informationArr'] = $this->_get_information_cate_group($id,true);
        $chooseGoods = 0;
        $applet_cfg = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        $shopType = array(1,13,21,24,6,8,32,27);
        if(in_array($cfg['ac_type'],$shopType)){
            $chooseGoods = 1;
        }


        $showAllow = 0;
        $extra = [];
        if(in_array($cfg['ac_type'],[6])){
            $showAllow = 1;
            $extra_model = new App_Model_Applet_MysqlAppletInformationExtraStorage($this->curr_sid);
            $extra = $extra_model->findUpdateExtraByAid($id);
        }

        $this->output['extra'] = $extra;
        $this->output['showAllow'] = $showAllow;
        $this->output['chooseGoods'] = $chooseGoods;
        $this->output['curr_sid'] = $this->curr_sid;
        $this->output['relatedInfo'] = $relatedInfo;
        $this->buildBreadcrumbs(array(
            array('title' => '资讯列表', 'link' => '/wxapp/currency/informationList'),
            array('title' => '添加资讯', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/currency/add-information.tpl');
    }


    public function saveInformationAllAction(){
        $result = array(
            'ec' => 400,
            'em' => '保存失败'
        );
        $ret_cate = $this->_save_category();
        $ret_style= $this->_save_information_style();
        if ($ret_cate && $ret_style){
            $result = array(
                'ec' => 200,
                'em' => '保存成功'
            );
        }elseif ($ret_cate && !$ret_style){
            $result = array(
                'ec' => 400,
                'em' => '资讯列表样式保存失败'
            );
        }elseif (!$ret_cate && $ret_style){
            $result = array(
                'ec' => 400,
                'em' => '资讯分类保存失败'
            );
        }
        $this->displayJson($result,true);
    }

    private function _save_information_style(){
        $style = $this->request->getIntParam('styleId');
        $ret = 0;
        if($style){
            if($style == $this->wxapp_cfg['ac_information_style']){
                $ret = 1;
            }else{
                $set = array('ac_information_style'=>$style);
                $wxxcx_model = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
                $ret = $wxxcx_model->updateById($set,$this->wxapp_cfg['ac_id']);
            }
        }
        return $ret;
    }

    private function _save_category(){
        $categoryList = $this->request->getArrParam('categoryList');
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $num = 0;
        if(!empty($categoryList)){
            $category_list = $category_storage->getListBySid();
            if(!empty($category_list)){
                $del_id = array();
                foreach($category_list as $val){
                    $has = false;
                    $index = 0;
                    foreach($categoryList as $key => $v){
                        if($v['id'] == $val['aic_id']){
                            $index = $key;
                            $has = true;
                        }
                    }
                    if($has){
                        $set = array(
                            'aic_sort'  => $index,
                            'aic_name'  => $categoryList[$index]['name']
                        );
                        $up_ret = $category_storage->updateById($set,$val['aic_id']);
                        unset($categoryList[$index]);
                        $num += 1;
                    }else{
                        $del_id[] = $val['aic_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'aic_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $category_storage->deleteValue($shortcut_where);
                }

            }
            if(!empty($categoryList)){
                $insert = array();
                foreach($categoryList as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['name']}','{$val['index']}', '0', '".time()."') ";
                }
                $ins_ret = $category_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'aic_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $del_ret = $category_storage->deleteValue($where);
        }
        if($up_ret || $del_ret || $ins_ret || $num>0){
            $ret = 1;
        }else{
            $ret = 0;
        }
        return $ret;
    }



    public function saveCategoryAction(){
        $categoryList = $this->request->getArrParam('categoryList');
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $num = 0;
        if(!empty($categoryList)){
            $category_list = $category_storage->getListBySid();
            if(!empty($category_list)){
                $del_id = array();
                foreach($category_list as $val){
                    $has = false;
                    $index = 0;
                    foreach($categoryList as $key => $v){
                        if($v['id'] == $val['aic_id']){
                            $index = $key;
                            $has = true;
                        }
                    }
                    if($has){
                        $set = array(
                            'aic_sort'  => $index,
                            'aic_name'  => $categoryList[$index]['name']
                        );
                        $up_ret = $category_storage->updateById($set,$val['aic_id']);
                        unset($categoryList[$index]);
                        $num += 1;
                    }else{
                        $del_id[] = $val['aic_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'aic_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $category_storage->deleteValue($shortcut_where);
                }

            }
            if(!empty($categoryList)){
                $insert = array();
                foreach($categoryList as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['name']}','{$val['index']}', '0', '".time()."') ";
                }
                $ins_ret = $category_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'aic_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $del_ret = $category_storage->deleteValue($where);
        }
        if($up_ret || $del_ret || $ins_ret || $num>0){
            $ret = 1;
        }else{
            $ret = 0;
        }
        $this->showAjaxResult($ret);
    }

    private function _save_shop_category($category){
        $data = array(
            'ssc_s_id' => $this->curr_sid,
            'ssc_name' => $category,
            'ssc_type' => 2,
            'ssc_create_time' => time(),
        );
        $category_storage = new App_Model_Shop_MysqlShopServiceCategoryStorage($this->curr_sid);
        $ret = $category_storage->insertValue($data);
    }


    public function saleInformationAction(){
        $title   = $this->request->getStrParam('title');
        $brief   = $this->request->getStrParam('brief');
        $cover   = $this->request->getStrParam('cover');
        $video   = $this->request->getStrParam('video');
        $articleFrom = $this->request->getStrParam('articleFrom');
        $content = $this->request->getParam('content');
        $id      = $this->request->getIntParam('id');
        $category = $this->request->getIntParam('category');
        $sort     = $this->request->getIntParam('sort');
        $urlType  = $this->request->getIntParam('urlType');
        $recommend  = $this->request->getIntParam('recommend');
        $price  = $this->request->getFloatParam('price');
        $gids    = $this->request->getArrParam('gids',array());
        $agids    = $this->request->getArrParam('agids',array());
        $relatedInfo = $this->request->getArrParam('relatedInfo',array());
        $showNum = $this->request->getStrParam('showNum','');
        $likeNum = $this->request->getStrParam('likeNum','');
        $customTime = $this->request->getStrParam('customTime','');
        $displayType = $this->request->getIntParam('displayType',1);
        $goodsType = $this->request->getIntParam('goodsType',1);
        $appointmentGoodsType = $this->request->getIntParam('appointmentGoodsType',1);
        if(strstr($video, 'v.qq.com') !== false){
            $video = $this->_get_tencent_video();
        }
        if($title && $cover && $content){
            $data = array(
                'ai_title'       => $title,
                'ai_cover'       => $cover,
                'ai_brief'       => $brief,
                'ai_category'    => $category,
                'ai_content'     => $content,
                'ai_video'       => $video,
                'ai_sort'        => $sort,
                'ai_g_id'        => json_encode($gids),
                'ai_ag_id'       => json_encode($agids),
                'ai_related_info'=> json_encode($relatedInfo),
                'ai_price'       => $price,
                'ai_s_id'        => $this->curr_sid,
                'ai_video_type'  => $urlType,
                'ai_isrecommend' => $recommend,
                'ai_from'        => $articleFrom,
                'ai_show_num'    => intval($showNum),
                'ai_like_num'    => intval($likeNum),
                'ai_display_type' => $displayType,
                'ai_goods_type'  => $goodsType,
                'ai_appointment_goods_type'  => $appointmentGoodsType,
            );

            $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
            if($id){
                if($customTime){//自定义创建时间
                    $data['ai_create_time'] =  strtotime($customTime);
                }
                $data['ai_update_time'] = time();
                $ret = $information_storage->updateById($data,$id);
            }else{
                $data['ai_create_time'] = $customTime ? strtotime($customTime) :time();
                $data['ai_update_time'] = time();
                $ret = $id = $information_storage->insertValue($data);
            }
            $this->_save_shop_information($title,$cover,$brief,$category,$content);
            $result = [
                'ec' => 200,
                'em' => '保存成功',
                'id' => $id
            ];
            if($ret){
                if(in_array($this->wxapp_cfg['ac_type'],[6])){
                    $this->_save_allow($id);
                }
                App_Helper_OperateLog::saveOperateLog("资讯【".$title."】保存成功");
                $this->displayJson($result);
            }else{
                $this->displayJsonError('保存失败');
            }
        }else{
            $this->displayJsonError('请将信息填写完整');
        }
    }

    private function _save_allow($id){
        $allowComment = $this->request->getIntParam('allowComment');
        $extra_model = new App_Model_Applet_MysqlAppletInformationExtraStorage($this->curr_sid);
        $extra = $extra_model->findUpdateExtraByAid($id);

        $set = [
            'aie_allow_comment' => $allowComment,
        ];

        if($extra){
            $res = $extra_model->findUpdateExtraByAid($id,$set);
        }else{
            $set['aie_ai_id'] = $id;
            $set['aie_s_id'] = $this->curr_sid;
            $set['aie_update_time'] = time();
            $res = $extra_model->insertValue($set);
        }
    }


    private function _save_shop_information($title,$cover,$brief,$category,$content){
        $data = array(
            'ss_category'    => $category,
            'ss_title'       => $title,
            'ss_cover'       => $cover,
            'ss_brief'       => $brief,
            'ss_content'     => $content,
            'ss_type'        => 2,
            'ss_create_time' => time(),
            'ss_s_id'        => $this->curr_sid,
        );
        $article_model = new App_Model_Shop_MysqlShopServiceInformationStorage();
        $ret = $article_model->insertValue($data);
    }


    public function deletedInformationAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
            $information = $information_storage->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("资讯【".$information['ai_title']."】删除成功");
            $ret = $information_storage->deleteDFById($id,$this->curr_sid);
        }
        $this->showAjaxResult($ret,'删除');
    }


    public function informationStyleAction(){
        $this->output['applet_cfg'] = $this->wxapp_cfg;
        $this->displaySmarty('wxapp/currency/information-style.tpl');
    }


    public function saveInformationStyleAction(){
        $style = $this->request->getIntParam('styleId');
        if($style){
            $set = array('ac_information_style'=>$style);
            $wxxcx_model = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
            $ret = $wxxcx_model->updateById($set,$this->wxapp_cfg['ac_id']);
        }
        $this->showAjaxResult($ret);
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


    private function _get_cash_recode(){
        $this->output['paytype'] = App_Helper_Trade::$trade_pay_type;
        $page       = $this->request->getIntParam('page');
        $enterId    = $this->request->getIntParam('enterId');
        $index      = $page * $this->count;
        $cash_recode= new App_Model_Cash_MysqlRecordStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'cr_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($enterId && $enterId>0){
            $where[]    = array('name'=>'cr_es_id','oper'=>'=','value'=>$enterId);
        }
        $startTime   = $this->request->getStrParam('start');
        if($startTime){
            $where[]    = array('name' => 'cr_pay_time', 'oper' => '>=', 'value' => strtotime($startTime));
        }
        $this->output['start'] = $startTime;
        $endTime     = $this->request->getStrParam('end');
        if($endTime){
            $where[]    = array('name' => 'cr_pay_time', 'oper' => '<=', 'value' => (strtotime($endTime) + 86400));
        }
        $this->output['end'] = $endTime;
        $total      = $cash_recode->findCashRecordMemberCount($where);
        $page_libs  = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list       = array();
        if($total > $index){
            $sort   = array('cr_pay_time'=>'DESC');
            $list = $cash_recode->findCashRecordMember($where,$index,$this->count,$sort);
        }
        $this->output['paginator'] = $page_libs->render();
        $this->output['list']      = $list;
        $this->output['enterId']   = $enterId;

        $where_total = $where_refund = [];
        $where_total[] = $where_refund[] = ['name'=>'cr_s_id','oper'=>'=','value'=>$this->curr_sid];
        if($enterId && $enterId>0){
            $where_total[] = $where_refund[] = ['name'=>'cr_es_id','oper'=>'=','value'=>$enterId];
        }
        $where_total[] = ['name'=>'cr_isrefund','oper'=>'=','value'=>0];
        $where_refund[] = ['name'=>'cr_isrefund','oper'=>'=','value'=>1];

        $todayInfo = $cash_recode->getSumInfo($where_total,true);
        $totalInfo = $cash_recode->getSumInfo($where_total);
        $refundInfo = $cash_recode->getSumInfo($where_refund);
        $this->output['statInfo'] = [
            'todayTotal' => $todayInfo['total'] ? $todayInfo['total'] : 0,
            'todayMoney' => $todayInfo['money'] ? $todayInfo['money'] : 0,
            'totalTotal' => $totalInfo['total'] ? $totalInfo['total'] : 0,
            'totalMoney' => $totalInfo['money'] ? $totalInfo['money'] : 0,
            'refundTotal' => $refundInfo['total'] ? $refundInfo['total'] : 0,
            'refundMoney' => $refundInfo['money'] ? $refundInfo['money'] : 0,
        ];

        if(in_array($this->wxapp_cfg['ac_type'],[8])){
            $this->output['showSearch'] = 1;

        }
        if($this->wxapp_cfg['ac_type'] == 8){
            $this->_get_entershop_list();
        }
    }


    private function _get_entershop_list(){
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $where = array();
        $where[] = array('name' => 'es_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $list = $es_model->getList($where,0,100,array(),array('es_id','es_name'),true);
        $this->output['shopList'] = $list;
    }


    public function pemcertAction() {
        $uploader   = new Libs_File_Transfer_Uploader('cert|pem');
        $ret = $uploader->receiveFile('pem_cert');

        if (!$ret) {
            $this->displayJsonError("上传失败，请重试");
        }
        $this->displayJsonSuccess(array('path' => $ret['pem_cert']));
    }

    public function sharecfgAction() {
        $this->buildBreadcrumbs(array(
            array('title' => '配置管理', 'link' => '#'),
            array('title' => '分享设置', 'link' => '#'),
        ));
        $this->output['row']    = $this->wxapp_cfg;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/currency/share-cfg.tpl');
    }

    public function openShareAction() {
        $open   = $this->request->getIntParam('open');

        $open   = $open ? 1 : 0;
        $wxapp_model = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
        $wxapp_model->updateById(array('ac_share_open' => $open), $this->wxapp_cfg['ac_id']);
        $this->displayJsonSuccess();
    }

    public function openShareImgAction() {
        $shareImg   = $this->request->getStrParam('shareImg');
        $shareCover = $this->request->getStrParam('shareCover','');
        $shareTitle = $this->request->getStrParam('shareTitle','');
        $shareCustom = $this->request->getIntParam('shareCustom',0);
        if($shareImg && $shareImg==$this->wxapp_cfg['ac_share_addr'] && $shareCover && $shareCover==$this->wxapp_cfg['ac_share_cover'] && $shareTitle && $this->wxapp_cfg['ac_share_title']==$shareTitle && $shareCustom && $shareCustom==$this->wxapp_cfg['ac_share_custom'] ){
            $this->displayJsonError('保存成功');
        }

        if($shareImg || $shareCover){
            $wxapp_model    = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);

            $set = array(
                'ac_share_addr' => $shareImg,
                'ac_share_cover' => $shareCover,
                'ac_share_custom' => $shareCustom,
                'ac_share_title' => $shareTitle
            );
            $ret = $wxapp_model->updateById($set, $this->wxapp_cfg['ac_id']);
            App_Helper_OperateLog::saveOperateLog("分享海报配置信息保存成功");
            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError('请上传海报宣传图');
        }
    }

    public function kefucfgAction() {
        $this->buildBreadcrumbs(array(
            array('title' => '配置管理', 'link' => '#'),
            array('title' => '客服设置', 'link' => '#'),
        ));
        $has_func   = json_decode($this->wxapp_cfg['ac_func_scope'], true);
        $this->output['auth_state'] = in_array(19, $has_func) ? true : false;
        $this->output['row']    = $this->wxapp_cfg;
        $this->renderCropTool('/wxapp/index/uploadImg');

        $show = $this->request->getIntParam('show',0);
        $this->output['show'] = $show;

        $sequenceShowAll = 1;
        if($this->wxapp_cfg['ac_type'] == 36){
            $sequenceShowAll = 0;
        }
        $this->output['sequenceShowAll'] = $sequenceShowAll;

        $this->displaySmarty('wxapp/currency/kefu-cfg.tpl');
    }
    public function kfhfSaveAction(){
        $keyword = $this->request->getStrParam('keyword','');
        $cover = $this->request->getStrParam('cover','');
        $data = [
            'keyword'   => $keyword,
            'cover'     => $cover
        ];
        $this->displayJsonSuccess($data,true,'保存成功');
    }

    public function openKefuAction() {
        $open   = $this->request->getIntParam('open');

        $open   = $open ? 1 : 0;
        $wxapp_model = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
        $wxapp_model->updateById(array('ac_kefu_open' => $open), $this->wxapp_cfg['ac_id']);
        $this->displayJsonSuccess();
    }

    public function kefuMobileOpenAction(){
        $value   = $this->request->getStrParam('value','');
        $open = $value == 'on' ? 1 : 0;
        $wxapp_model = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
        $wxapp_model->updateById(array('ac_kefu_mobile' => $open), $this->wxapp_cfg['ac_id']);
        $this->displayJsonSuccess();
    }
    public function wxcardAction() {
        $page = $this->request->getIntParam('page');
        $index = $page*$this->count;
        $this->buildBreadcrumbs(array(
            array('title' => '配置管理', 'link' => '#'),
            array('title' => '微信卡券', 'link' => '#'),
        ));
        $wechat_model   = new App_Model_Auth_MysqlWeixinStorage();
        $wechat         = $wechat_model->findWeixinBySid($this->curr_sid);

        $this->output['wechat']     = empty($wechat) ? null : $wechat;
        $card_model = new App_Model_Wechat_MysqlCardStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'wc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $total      = $card_model->getCount($where);
        $page_libs  = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list = array();
        if($total > $index){
            $sort   = array('wc_add_time'=>'DESC');
            $list   = $card_model->getList($where,$index,$this->count,$sort);
            foreach ($list as &$value){
                $value['wc_data_info'] = json_decode($value['wc_data_info'],true);
            }
        }
        $this->output['paginator'] = $page_libs->render();

        $this->output['auth_code']   = $this->fetchWxAuthCode();
        $this->output['list']  = $list;
        $this->displaySmarty('wxapp/currency/wxcard-list.tpl');
    }

    public function syncCouponAction(){
        $client = new App_Plugin_Weixin_CardPlugin($this->curr_sid);
        $card   = $client->fetchCardList(0, 50);
        $num = 0;
        if($card && $card['errcode']==0 && $card['card_id_list']){
            foreach ($card['card_id_list'] as $val){
                $card_model = new App_Model_Wechat_MysqlCardStorage($this->curr_sid);
                $row = $card_model->findCardByID($val);
                if(!$row){
                    $result = $client->fetchCardDetail($val);
                    $type = strtolower($result['card']['card_type']);
                    $data = array(
                        'wc_s_id'        => $this->curr_sid,
                        'wc_card_type'   => $result['card']['card_type'],
                        'wc_card_id'     => $result['card'][$type]['base_info']['id'],
                        'wc_logo_url'    => $result['card'][$type]['base_info']['logo_url'],
                        'wc_code_type'    => $result['card'][$type]['base_info']['code_type'],
                        'wc_brand_name'  => $result['card'][$type]['base_info']['brand_name'],
                        'wc_title'       => $result['card'][$type]['base_info']['title'],
                        'wc_card_json'   => json_encode($result['card']),
                        'wc_color'       => $result['card'][$type]['base_info']['color'],
                        'wc_notice'      => $result['card'][$type]['base_info']['notice'],
                        'wc_description' => $result['card'][$type]['base_info']['description'],
                        'wc_data_info'   => json_encode($result['card'][$type]['base_info']['date_info']),
                        'wc_add_time'    => $result['card'][$type]['base_info']['create_time'],
                        'wc_is_swipe_card' => $result['card'][$type]['base_info']['pay_info']['swipe_card']['is_swipe_card']?1:0,
                        'wc_time'        => time()
                    );
                    $ret = $card_model->insertValue($data);
                    $client_plugin = new App_Plugin_Weixin_ClientPlugin($this->curr_sid);
                    $udata = [
                        'card_id' => $data['wc_card_id'],
                        $type => [
                            "base_info"=> [
                                "center_title"=>"立即使用",
                                "center_app_brand_user_name"=> $this->wxapp_cfg['ac_gh_id']."@app",
                                "center_app_brand_pass"=> "pages/index/index",
                            ],
                        ]
                    ];
                    $client_plugin->updateCard($udata);
                    $num += 1;
                }
            }
        }
        $this->showAjaxResult($num,'同步');
    }


    public function delCouponAction(){
        $id = $this->request->getIntParam('id');
        $card_model = new App_Model_Wechat_MysqlCardStorage($this->curr_sid);
        $ret = $card_model->deleteById($id);
        $this->showAjaxResult($ret, '删除');
    }


    public function cardBackgroundAction(){
        $wechat_model   = new App_Model_Auth_MysqlWeixinStorage();
        $wechat         = $wechat_model->findWeixinBySid($this->curr_sid);
        if(!$wechat){
            plum_url_location('请先授权微信公众号');
        }
        $card_model = new App_Model_Wechat_MysqlCardStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'wc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $sort   = array('wc_add_time'=>'DESC');
        $list   = $card_model->getList($where,0,5,$sort);
        $this->output['cardList'] = $list;
        $this->output['background']  = $wechat['wc_card_background'];
        $this->output['logo']  = $wechat['wc_avatar'];
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '微信卡券', 'link' => '/wxapp/currency/wxcard'),
            array('title' => '广告设置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/wxcard/card-background.tpl');
    }


    public function saveCardBackgroundAction(){
        $background = $this->request->getStrParam('background');
        $wechat_model   = new App_Model_Auth_MysqlWeixinStorage();
        $wechat         = $wechat_model->findWeixinBySid($this->curr_sid);
        if($wechat && $background){
            $set = array('wc_card_background' => $background);
            $ret = $wechat_model->updateById($set,$wechat['wc_id']);
        }
        $this->showAjaxResult($ret);
    }



    public function fetchWebContentAction(){
        $url = $this->request->getStrParam('url');
        $type = $this->request->getIntParam('type', 1);
        if($url){
            if($type == 1){
                $apiset_model = new App_Plugin_Aliyun_Apiset();
                $ret = $apiset_model->extractNewsData($url);
                $ret['result']['img_list'][0]['url'] = $this->_download_article_image($ret['result']['img_list'][0]['url']);
            }else{
                $client_storage = new App_Plugin_Querylist_Query();
                $article = $client_storage->queryWxArticle($url);
                $ret['result']['title']   = $article['info']['title'];
                $ret['result']['content'] = $article['content'];
                $ret['result']['video']   = $article['video'];
                $ret['result']['cover']   = $article['info']['cover'];
                $ret['result']['desc']    = $article['info']['desc'];
            }
            if($ret['errcode'] == 0){
                $this->displayJsonSuccess($ret['result']);
            }else{
                $this->displayJsonError($ret['errmsg']);
            }
        }
    }

    private function _download_article_image($img){
        list($usec, $sec) = explode(" ", microtime());
        $md5        = strtoupper(md5($usec.$sec));
        $name   = substr($md5, 0, 8).'-'.substr($md5, 10, 4).'-'.mt_rand(1000, 9999).'-'.substr($md5, 20, 12);
        $filename = PLUM_DIR_UPLOAD. '/gallery/thumbnail/'.$name.'.png';
        $filepath = PLUM_PATH_UPLOAD . '/gallery/thumbnail/'.$name.'.png';
        if(!file_exists($filename)){
            $hander = curl_init();
            $fp = fopen($filename,'wb');
            curl_setopt($hander,CURLOPT_URL,$img);
            curl_setopt($hander,CURLOPT_FILE,$fp);
            curl_setopt($hander,CURLOPT_HEADER,0);
            curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($hander,CURLOPT_TIMEOUT,60);
            curl_exec($hander);
            curl_close($hander);
            fclose($fp);
        }
        return $filepath;
    }
    private function _get_tencent_video($vid=''){
        if(!$vid){
            $url = $this->request->getStrParam('video');
            $urlArr = parse_url($url);
            $arr_query = $this->_convert_url_query($urlArr['query']);
            if($arr_query['vid']){
                $vid  = $arr_query['vid'];
            }else{
                $content = Libs_Http_Client::get($url);
                $content_html_pattern = '/VIDEO_INFO = ({[^}]*.*?)(;.*?var |<\/script>)/s';
                preg_match($content_html_pattern, $content, $video_matchs);

                $video_matchs[1] = preg_replace('/(\/\*.*\*\/)/s', '', $video_matchs[1]);
                $videoInfo = json_decode($video_matchs[1], true);
                if(!$videoInfo){
                    $content_html_pattern = '/vid: "(.*?)"/s';
                    preg_match($content_html_pattern, $video_matchs[1], $video_matchs);
                    $videoInfo['vid'] = $video_matchs[1];
                }
                $vid  = $videoInfo['vid'];
            }
            if(!$vid){
                $pathArr = explode('/', $urlArr['path']);
                $vid = str_replace('.html','',$pathArr[count($pathArr)-1]);
            }
        }
        $params = array(
            'isHLS' => false,
            'charge' => 0,
            'vid' => $vid,
            'defaultfmt' => 'auto',
            'defn' => 'shd',
            'defnpayver' => 1,
            'otype' => 'json',
            'platform' => 11001,
            'sdtfrom' => 'v1103',
            'host' => 'v.qq.com'
        );
        $baseUrl = 'http://h5vv.video.qq.com/getinfo?';
        $paramsArr = [];
        foreach ($params as $key => $val){
            $paramsArr[] = $key.'='.$val;
        }
        $paramsStr = join('&', $paramsArr);
        Libs_Log_Logger::outputLog($baseUrl.$paramsStr);
        $content = Libs_Http_Client::get($baseUrl.$paramsStr);
        $content_html_pattern = '/=(.*);/s';
        preg_match($content_html_pattern, $content, $info_matchs);
        $infoInfo = json_decode($info_matchs[1], true);
        $fvkey = $infoInfo['vl']['vi'][0]['fvkey'];
        $fn = $infoInfo['vl']['vi'][0]['fn'];
        $self_host = $infoInfo['vl']['vi'][0]['ul']['ui'][0]['url'];
        if($self_host && $fn && $fvkey){
            $real_url = $vid;
            return $real_url;
        }else{
            return $vid;
        }
    }

    private function _convert_url_query($query)
    {
        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }


    public function bindCategoryAction(){
        $cid = $this->request->getIntParam('cid');
        $sourceId = $this->request->getIntParam('sourceId');
        $gzh_model = new App_Model_Information_MysqlInformationGzhStorage($this->curr_sid);
        $gzh = $gzh_model->getRowById($sourceId);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        if($gzh && $cid){
            $where = array();
            $where[] = array('name' => 'ai_wx_no', 'oper' => '=', 'value' => $gzh['abg_wxno']);
            $where[] = array('name' => 'ai_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $set = array('ai_category' => $cid);
            $information_storage->updateValue($set, $where);
            $set = array('abg_cate_id' => $cid);
            $ret = $gzh_model->updateById($set,$sourceId);
            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError('请选择内容源');
        }
    }


    public function delBindCategoryAction(){
        $id = $this->request->getIntParam('id');
        $gzh_model = new App_Model_Information_MysqlInformationGzhStorage($this->curr_sid);
        if($id){
            $set = array('abg_cate_id' => 0);
            $ret = $gzh_model->updateById($set,$id);
            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError('操作失败');
        }
    }



    private function _deal_es_cash_refund($cash){
        $store_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $entershop       = $store_model->getRowById($cash['cr_es_id']);
        $shopbalance    = intval(100*$entershop['es_balance']);//单位分
        $inout_model    = new App_Model_Shop_MysqlShopInoutStorage($this->curr_sid);
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->curr_sid);
        $appcfg = $appletPay_Model->findRowPay();
        if($entershop['es_maid_proportion'] && $entershop['es_maid_proportion']>0){
            $maid = $entershop['es_maid_proportion']/100;
        }elseif($appcfg['ap_shop_percentage'] && $appcfg['ap_shop_percentage']>0){
            $maid = $appcfg['ap_shop_percentage']/100;
        }else{
            $maid      = plum_parse_config('wxpay_point', 'weixin');
        }
        $less       = ceil($cash['cr_money']*$maid*100);
        $indata     = array(
            'si_s_id'   => $this->curr_sid,
            'si_es_id'  => $cash['cr_es_id'],
            'si_name'   => '买单退款',
            'si_amount' => $cash['cr_money'],
            'si_balance'=> ($shopbalance-$cash['cr_money']*100+$less)/100,
            'si_type'   => 2,
            'si_create_time'    => time(),
        );
        $inout_model->insertValue($indata);
        $store_model->incrementShopBalance($cash['cr_es_id'], -($cash['cr_money']-($less/100)));
    }

    public function sslListAction(){
        $page         = $this->request->getIntParam('page');
        $index        = $page*$this->count;
        $where        = array();
        $where[]      = array('name'=>'ss_s_id','oper'=>'=','value'=>$this->curr_sid);
        $sort         = array('ss_create_time'=>'DESC');
        $ssl          = new   App_Model_Shop_MysqlShopSslStorage();
        $list         = $ssl->getSslList($where,$index,$this->count,$sort);

        $this->output['list'] = $list;
        $status       = plum_parse_config('ssl_status');
        $this->output['status']   = $status;
        $total      = $ssl->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pageHtml']   = $pageCfg->render();
        $this->buildBreadcrumbs(array(
            array('title' => 'SSl证书管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/currency/ssl-list.tpl');
    }


    public function wxAlipayChargeQrcodeAction() {
        $allow_type = array('wxpay' => 'wx_pub_qr', 'alipay' => 'alipay_qr');
        $channel    = $this->request->getStrParam('channel');
        $channel    = in_array($channel, array_keys($allow_type)) ? $allow_type[$channel] : current($allow_type);
        $buyssl_price   = plum_parse_config('buyssl', 'agent');
        if($channel=='wx_pub_qr'){
            $ret = $this->_wx_pay_cfg($buyssl_price*100);
            if (is_array($ret)){
                $qrcode = $ret['code_url'];
            }else{
                plum_redirect("/public/manage/images/qrcode-placeholder.png");
            }
        }else{
            $ret = $this->_alipay_pay_cfg($buyssl_price*100);
            if (is_array($ret)){
                $qrcode = $ret['qr_code'];
            }else{
                plum_redirect("/public/manage/images/qrcode-placeholder.png");
            }
        }
        Libs_Qrcode_QRCode::png($qrcode);
    }


    private function _wx_pay_cfg($amount){
        $tid = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->uid);
        $body   = $this->curr_shop['s_name']."购买ssl证书";
        $pay_storage = new App_Plugin_Weixin_SubPay(0);
        $notify_url = $this->response->responseHost().'/manage/notify/wxpayBuySslNotify';//回调地址
        $attach = array(
            'suid' => $this->curr_shop['s_unique_id'],
            'mid'  => $this->manager['m_id'],
        );
        $other      = array(
            'attach'    => json_encode($attach),
        );
        return $pay_storage->agentPayRecharge(floatval($amount),$tid,$notify_url,$body,$other);
    }


    private function _alipay_pay_cfg($amount){
        $out_trade_no = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->uid);
        $subject   = $this->curr_shop['s_name']."购买ssl证书";
        $notify_url = $this->response->responseHost().'/manage/notify/alipayBuySslNotify';//回调地址
        $amount = floatval($amount/100);
        $attach = array(
            'suid' => $this->curr_shop['s_unique_id'],
            'mid'  => $this->manager['m_id'],
        );
        $body = json_encode($attach);
        $ali_qrpay = new App_Plugin_Alipaysdk_NewClient(0);
        $result      = $ali_qrpay->agentPayRecharge($out_trade_no, $subject,$body, $amount,$notify_url);
        return $result;

    }


    public function updateSslAction(){
        $strField = array('domain','company','department','mobile','name','job','tel','address');
        $data     = $this->getStrByField($strField,'ss_');
        $tid = $this->request->getStrParam('ssltid');
        $ret = 0;
        if($tid){
            $ssl_storage = new   App_Model_Shop_MysqlShopSslStorage();
            $row = $ssl_storage->findUpdateSslByTid($tid);
            if($row && $row['ss_status']==1){
                $ret = $ssl_storage->findUpdateSslByTid($tid,$data);
            }
        }
        $this->showAjaxResult($ret);
    }


    private function _save_applet_public_key(){
        $wxpay_plugin   = new App_Plugin_Weixin_NewPay($this->curr_sid);
        $ret = $wxpay_plugin->appletPublicKey();
        if($ret['code']==0){
            $updata = array(
                'ap_pubpem' => $ret['filename']
            );
            $pay_model      = new App_Model_Applet_MysqlAppletPayStorage($this->curr_sid);
            $pay_model->findRowPay($updata);
        }
    }


    public function informationCommentListAction(){
        $page = $this->request->getIntParam('page');
        $aid  = $this->request->getIntParam('aid');
        $index      = $page * $this->count;
        $comment_model = new App_Model_Applet_MysqlAppletInformationCommentStorage($this->curr_sid);
        $total      = $comment_model->getCommentCount($aid);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination']   = $pageCfg->render();
        $list = array();
        if($index < $total){
            $list = $comment_model->getCommentMember($aid,$index,$this->count);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '资讯管理', 'link' => '/wxapp/currency/informationList'),
            array('title' => '资讯评论', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/currency/comment-list.tpl');

    }


    public function replyInformationCommentAction(){
        $result = array(
            'ec' => 400,
            'em' => '回复失败'
        );
        $cid = $this->request->getIntParam('cid');
        $mid = $this->request->getIntParam('mid');
        $aid = $this->request->getIntParam('aid');
        $content = $this->request->getStrParam('content');
        $content = plum_sql_quote($content);
        if($aid && $content && $content != '' && $cid && $mid){
            $data = array(
                'aic_s_id'      => $this->curr_sid,
                'aic_ai_id'     => $aid,
                'aic_comment'   => $content,
                'aic_m_id'      => -1,
                'aic_reply_mid' => $mid,
                'aic_aic_id'    => $cid,
                'aic_time'      => time(),
            );
            $comment_model = new App_Model_Applet_MysqlAppletInformationCommentStorage($this->curr_sid);
            $ret = $comment_model->insertValue($data);
            if($ret){
                $information_model = new App_Model_Applet_MysqlAppletInformationStorage();
                $information_model->addReduceInformationNum($aid,'comment','add');
                $result = array(
                    'ec' => 200,
                    'em' => '回复成功'
                );
            }
            $this->displayJson($result);
        }
    }


    public function deleteInformationCommentAction(){
        $aid = $this->request->getIntParam('aid');
        $ret = 0;
        if($aid){
            $comment_model = new App_Model_Applet_MysqlAppletInformationCommentStorage($this->curr_sid);
            $ret = $comment_model->deleteBySidId($aid,$this->curr_sid);
        }
        $this->showAjaxResult($ret,'删除');
    }


    public function qiniuAction() {
        $qiniu_model      = new App_Model_Applet_MysqlAppletQiniuStorage($this->curr_sid);
        $qiniu       = $qiniu_model->findRowCfg();

        $this->output['qiniu']       = $qiniu;
        $this->buildBreadcrumbs(array(
            array('title' => '音视频管理', 'link' => '/wxapp/currency/video'),
            array('title' => '七牛配置', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/currency/qiniu.tpl");
    }


    public function saveQiniuAction(){
        $data['aq_bucket_zone'] = $this->request->getIntParam('zone');
        $data['aq_access_key'] = $this->request->getStrParam('ak');
        $data['aq_secret_key'] = $this->request->getStrParam('sk');
        $data['aq_bucket_name'] = $this->request->getStrParam('name');
        $data['aq_host'] = $this->request->getStrParam('host');
        $hostchange = $this->request->getIntParam('hostchange');
        $data['aq_update_time'] = time();

        $qiniu_model      = new App_Model_Applet_MysqlAppletQiniuStorage($this->curr_sid);

        $row    = $qiniu_model->findRowCfg();
        if($row){
            $oldhost = $row['aq_host'];
            $ret = $qiniu_model->updateById($data,$row['aq_id']);
            if($oldhost != $data['aq_host']){
                if($hostchange){
                    plum_open_backend('index', 'qiniuChangeHost', array('sid' => $this->curr_sid, 'oldhost' => $oldhost, 'newhost' => $data['aq_host']));
                }
            }
        }else{
            $data['aq_s_id'] = $this->curr_sid;
            $data['aq_create_time'] = time();
            $ret = $qiniu_model->insertValue($data);
        }
        App_Helper_OperateLog::saveOperateLog("七牛配置信息保存成功");
        $this->showAjaxResult($ret);
    }


    public function videoAction(){
        $page = $this->request->getIntParam('page');
        $index = $page*$this->count;

        $video_model = new App_Model_Applet_MysqlAppletQiniuVideoStorage($this->curr_sid);
        $where[] = array('name' => 'aqv_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort = array('aqv_update_time' => 'desc');
        $total = $video_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index <= $total){
            $list = $video_model->getList($where, $index, $this->count, $sort);
        }
        $qiniu_model      = new App_Model_Applet_MysqlAppletQiniuStorage($this->curr_sid);
        $qiniu       = $qiniu_model->findRowCfg();
        if($qiniu){
            $url  = plum_parse_config('url', 'qiniu');
            $this->output['qiniu'] = $qiniu;
            $this->output['uploadUrl'] = $url[$qiniu['aq_bucket_zone']];
            $this->output['qnDomain'] = 'http://'.$qiniu['aq_host'];
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '插件管理', 'link' => '#'),
            array('title' => '音视频管理', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/currency/qiniu-video.tpl");
    }

    public function uploadCfgAction(){
        $type = $this->request->getStrParam('type');
        $key  = $this->request->getStrParam('key');
        $qiniu_model      = new App_Model_Applet_MysqlAppletQiniuStorage($this->curr_sid);
        $qiniu       = $qiniu_model->findRowCfg();
        if($qiniu){
            if(!$key){
                $key = plum_random_code(8).$type;
            }
            $qiniu_client = new App_Plugin_Qiniu_Client($qiniu['aq_access_key'], $qiniu['aq_secret_key'], $qiniu['aq_bucket_name']);
            $token = $qiniu_client->getUploadToken($key);
            $data['token'] = $token;
            $data['key'] = $key;
            $this->displayJsonSuccess($data);
        }else{
            $this->displayJsonError('请配置七牛信息');
        }
    }


    public function saveQiniuVideoAction(){
        $id = $this->request->getIntParam('id');
        $name = $this->request->getStrParam('name');
        $type = $this->request->getStrParam('type');
        $duration = $this->request->getIntParam('duration');
        $videoUrl = $this->request->getStrParam('videoUrl');
        $ret = 0;
        if($videoUrl){
            $data = array(
                'aqv_s_id'       => $this->curr_sid,
                'aqv_title'      => $name,
                'aqv_video_url'  => $videoUrl,
                'aqv_type'        => $type,
                'aqv_time'        => $duration,
                'aqv_update_time'=> time(),
            );
            $video_model = new App_Model_Applet_MysqlAppletQiniuVideoStorage($this->curr_sid);
            if($id){
                $params = array(
                    'urls' => array($videoUrl)
                );
                $qiniu_model      = new App_Model_Applet_MysqlAppletQiniuStorage($this->curr_sid);
                $qiniu       = $qiniu_model->findRowCfg();
                $qiniu_client = new App_Plugin_Qiniu_Client($qiniu['aq_access_key'], $qiniu['aq_secret_key'], $qiniu['aq_bucket_name']);
                $ret = $qiniu_client->refreshCdn($params);
                $video_model->updateById($data, $id);
                $ret = $id;
            }else{
                $ret = $video_model->insertValue($data);
            }
        }
        $this->showAjaxResult($ret,'上传');
    }

    public function deleteVideoAction(){
        $id = $this->request->getIntParam('id');
        $qiniu_model      = new App_Model_Applet_MysqlAppletQiniuStorage($this->curr_sid);
        $qiniu       = $qiniu_model->findRowCfg();
        $qiniu_client = new App_Plugin_Qiniu_Client($qiniu['aq_access_key'], $qiniu['aq_secret_key'], $qiniu['aq_bucket_name']);
        $video_model = new App_Model_Applet_MysqlAppletQiniuVideoStorage($this->curr_sid);
        $video = $video_model->getRowById($id);
        $key = explode('/',$video['aqv_video_url'])[count(explode('/',$video['aqv_video_url']))-1];
        $ret = $qiniu_client->delete($key);
        $video_model = new App_Model_Applet_MysqlAppletQiniuVideoStorage($this->curr_sid);
        $ret = $video_model->deleteById($id);
        $this->showAjaxResult($ret,'删除');
    }
    public function noRechargeAction(){
        $wxxcx_client = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $pret1 = $wxxcx_client->testpay(1);
        $qret1 = $wxxcx_client->testqy(1);
        $pret2 = $wxxcx_client->testpay(2);
        $qret2 = $wxxcx_client->testqy(2);
        $rfret = $wxxcx_client->testrf();
        $qyrfret = $wxxcx_client->testqyrf();
        $billret = $wxxcx_client->testbill();
        if($pret1['code']==0 && $qret1['err_code']=='SUCCESS' && $pret2['code']==0 && $qret2['err_code'] == 'SUCCESS'
            && $rfret['refund_fee']=="552" && $qyrfret['err_code']=='SUCCESS' && $billret){
            $this->showAjaxResult(1,'升级');
        }else{
            $this->showAjaxResult(0,'升级');
        }
    }

    public function activityAction(){
        $id = $this->request->getIntParam('id');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $activity_model = new App_Model_Wechat_MysqlActivityStorage($this->curr_sid);
        $where[] = array('name' => 'wa_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'wa_c_id', 'oper' => '=', 'value' => $id);
        $where[] = array('name' => 'wa_deleted', 'oper' => '=', 'value' => 0);
        $total      = $activity_model->getCount($where);
        $page_libs  = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list = array();
        if($total > $index){
            $sort   = array('wa_create_time'=>'DESC');
            $list   = $activity_model->getList($where,$index,$this->count,$sort);
        }
        $this->output['paginator'] = $page_libs->render();
        $this->output['list'] = $list;
        $this->output['card_id'] = $id;
        $this->buildBreadcrumbs(array(
            array('title' => '卡券列表', 'link' => '/wxapp/currency/wxcard'),
            array('title' => '立减金活动', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/currency/wxactivity-list.tpl");
    }
    public function createActivityAction(){
        $cid = $this->request->getIntParam('cid');
        $data['wa_activity_bg_color'] = $this->request->getStrParam('color');
        $data['wa_begin_time'] = strtotime($this->request->getStrParam('begin_time'));
        $data['wa_end_time'] =  strtotime($this->request->getStrParam('end_time'));
        $data['wa_gift_num'] =  $this->request->getIntParam('gift_num');
        $data['wa_max_partic_times_act'] =  $this->request->getIntParam('max_partic_times_act');
        $data['wa_max_partic_times_one_day'] =  $this->request->getIntParam('max_partic_times_one_day');
        $data['wa_min_amt'] =  $this->request->getFloatParam('min_amt');
        $card_model = new App_Model_Wechat_MysqlCardStorage($this->curr_sid);
        $card = $card_model->getRowById($cid);
        $client = new App_Plugin_Weixin_ClientPlugin($this->curr_sid);
        if($data['wa_begin_time']<time()){
            $this->displayJsonError('活动开始时间需大于当前时间');
        }
        if($data['wa_begin_time']>$data['wa_end_time']){
            $this->displayJsonError('活动结束时间需大于开始时间');
        }
        if(json_decode($card['wc_data_info'], true)['end_timestamp'] <= $data['wa_end_time'] + 7200){
            $this->displayJsonError('活动结束时间需提前卡券失效时间2小时，当前卡券失效时间为'.date('Y-m-d H:i:s', json_decode($card['wc_data_info'], true)['end_timestamp']));
        }
        $basic  = array(
            'activity_bg_color'     => $data['wa_activity_bg_color'],
            'activity_tinyappid'    => $this->wxapp_cfg['ac_appid'],
            'begin_time'            => $data['wa_begin_time'],
            'end_time'              => $data['wa_end_time'],
            'gift_num'              => $data['wa_gift_num'],
            'max_partic_times_act'  => $data['wa_max_partic_times_act'],
            'max_partic_times_one_day'  => $data['wa_max_partic_times_one_day'],
            'mch_code'              => $this->wxapp_cfg['ac_mch_id'],
        );
        if(!$basic['mch_code']){
            $pay_model      = new App_Model_Applet_MysqlAppletPayStorage($this->curr_sid);
            $appletPay         = $pay_model->findRowPay();
            $basic['mch_code'] = $appletPay['ap_mchid'];
        }

        $card   = array(array(
            'card_id'       => $card['wc_card_id'],
            'min_amt'       =>  $data['wa_min_amt'] * 100,
            'total_user'    => true,
        ));

        $ret    = $client->createCardActivity($basic, $card);
        if($ret['errcode']==0&&$ret['result']['activity_id']){
            $data['wa_s_id'] = $this->curr_sid;
            $data['wa_c_id'] = $cid;
            $data['wa_create_time'] = time();
            $data['wa_activity_id'] = $ret['result']['activity_id'];
            $activity_model = new App_Model_Wechat_MysqlActivityStorage($this->curr_sid);
            $ret = $activity_model->insertValue($data);
            $this->showAjaxResult($ret,'创建');
        }else{
            $this->showAjaxResult(0,'创建');
        }
    }


    public function informationCardTypeAction(){
        $this->informationSecondLink('pay');
        $card_type = plum_parse_config('information_card_type');
        $card_storage = new App_Model_Information_MysqlInformationCardStorage($this->curr_sid);
        $where[]    = array('name' => 'aic_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $cardList = $card_storage->getList($where,0,0,array('aic_create_time'=>'DESC'));
        $this->buildBreadcrumbs(array(
            array('title' => '资讯管理', 'link' => '#'),
            array('title' => '资讯会员类型', 'link' => '#'),
        ));
        $this->output['list'] = $cardList;
        $this->output['type'] = $card_type;
        $this->displaySmarty('wxapp/currency/information-card.tpl');
    }



    public function saveInformationCardTypeAction(){
        $id = $this->request->getIntParam('id');
        $title = $this->request->getStrParam('title');
        $price = $this->request->getFloatParam('price');
        $type = $this->request->getIntParam('type');
        $time  = $this->request->getIntParam('time');
        $data = array(
            'aic_s_id'  => $this->curr_sid,
            'aic_title' => $title,
            'aic_money' => $price,
            'aic_type'  => $type,
            'aic_time'  => $time,
        );
        $card_storage = new App_Model_Information_MysqlInformationCardStorage($this->curr_sid);
        if($id){
            $ret = $card_storage->fetchRowById($id,$data);
        }else{
            $data['aic_create_time'] = time();
            $ret = $card_storage->insertValue($data);
        }
        App_Helper_OperateLog::saveOperateLog("付费会员类型【".$title."】保存成功");
        $this->showAjaxResult($ret);
    }


    public function deletedInformationCardAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $card_storage = new App_Model_Information_MysqlInformationCardStorage($this->curr_sid);
            $ret = $card_storage->deleteDFById($id,$this->curr_sid);
        }
        $this->showAjaxResult($ret,'删除');
    }


    public function saveShopRewardAction(){
        $open = $this->request->getIntParam('open');
        $percentage = $this->request->getIntParam('percentage');
        $postOpen = $this->request->getIntParam('postOpen');
        $type = $this->request->getIntParam('type');
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        if($type && $type==2){
            $set = array('s_post_percentage'=>$percentage,'s_post_reward'=>$postOpen);
        }else{
            $set = array('s_information_reward'=>$open);
        }
        $ret = $shop_model->updateById($set,$this->curr_sid);
        $this->showAjaxResult($ret);
    }


    public function saveShopShowAllImgAction(){
        $open = $this->request->getIntParam('open');
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();

        $set = array('s_post_img_show_all'=>($open==1?1:0));

        $ret = $shop_model->updateById($set,$this->curr_sid);
        $this->showAjaxResult($ret);
    }

    public function getInformationMemberListAction(){
        $this->informationSecondLink('pay');
        $page = $this->request->getIntParam('page',0);
        $index = $page * $this->count;
        $record_model = new App_Model_Information_MysqlInformationMemberCardStorage($this->curr_sid);
        $where = array();
        $where[]       = array('name'=>'aim_s_id','oper'=>'=','value'=>$this->curr_sid);

        $total = $record_model->getCount($where);
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $this->output['paginator'] = $page_plugin->render();
        $list = array();
        if($total > $index){
            $sort = array('aim_create_time' => 'DESC');
            $list = $record_model->getRecordWithMember($where,$index,$this->count,$sort);
        }

        $this->output['list'] = $list;
        $where_total = $where_normal = [];
        $where_total[] = $where_normal[] = ['name'=>'aim_s_id','oper'=>'=','value'=>$this->curr_sid];
        $where_normal[] = ['name'=>'aim_expire_time','oper'=>'>','value'=>time()];
        $total = $record_model->getSum($where_total);
        $normal = $record_model->getSum($where_normal);
        $statInfo['total'] = $total ? $total : 0;
        $statInfo['normal'] = $normal ? $normal : 0;
        $expire = is_numeric($statInfo['total']) && is_numeric($statInfo['normal']) ? $statInfo['total'] - $statInfo['normal'] : 0;
        $statInfo['expire'] = $expire > 0 ? $expire : 0;
        $this->output['statInfo'] = $statInfo;


        $this->buildBreadcrumbs(array(
            array('title' => '资讯管理', 'link' => '/wxapp/currency/informationList'),
            array('title' => '资讯会员列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/currency/information-card-record.tpl');
    }


    public function getInformationPayRecordAction(){
        $this->informationSecondLink('pay');
        $page = $this->request->getIntParam('page',0);
        $title = $this->request->getStrParam('title');
        $index = $page * $this->count;
        $record_model = new App_Model_Information_MysqlInformationPayStorage($this->curr_sid);
        $where = array();
        $where[]       = array('name'=>'aip_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($title){
            $where[]       = array('name'=>'ai_title','oper'=>'like','value'=>"%$title%");
            $this->output['title'] = $title;
        }
        $startTime   = $this->request->getStrParam('start');
        if($startTime){
            $where[]    = array('name' => 'aip_pay_time', 'oper' => '>=', 'value' => strtotime($startTime));
            $this->output['start'] = $startTime;

        }

        $endTime     = $this->request->getStrParam('end');
        if($endTime){
            $where[]    = array('name' => 'aip_pay_time', 'oper' => '<=', 'value' => (strtotime($endTime) + 86400));
            $this->output['end'] = $endTime;

        }

        $total = $record_model->getRecordWithMemInfoCount($where);
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $this->output['paginator'] = $page_plugin->render();
        $list = array();
        if($total > $index){
            $sort = array('aip_pay_time' => 'DESC');
            $list = $record_model->getRecordWithMemInfo($where,$index,$this->count,$sort);
        }

        $this->output['list'] = $list;
        $stat = $record_model->getSumInfo($where);
        $this->output['statInfo'] = [
            'total' => $stat['total'] ? $stat['total'] : 0,
            'money' => $stat['money'] ? $stat['money'] : 0
        ];
        $this->buildBreadcrumbs(array(
            array('title' => '资讯管理', 'link' => '/wxapp/currency/informationList'),
            array('title' => '资讯付费记录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/currency/information-pay-record.tpl');
    }



    public function getInformationCardPayRecordAction(){
        $this->informationSecondLink('pay');
        $page = $this->request->getIntParam('page',0);
        $index = $page * $this->count;
        $record_model = new App_Model_Information_MysqlInformationCardPayStorage($this->curr_sid);
        $where = array();
        $where[]       = array('name'=>'aicp_s_id','oper'=>'=','value'=>$this->curr_sid);

        $total = $record_model->getCount($where);
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $this->output['paginator'] = $page_plugin->render();
        $list = array();
        if($total > $index){
            $sort = array('aicp_create_time' => 'DESC');
            $list = $record_model->getRecordWithMem($where,$index,$this->count,$sort);
        }

        $this->output['list'] = $list;
        $where_sum = [];
        $where_sum[] = ['name'=>'aicp_s_id','oper'=>'=','value'=>$this->curr_sid];
        $stat = $record_model->getSumInfo($where_sum);
        $this->output['statInfo'] = [
            'total' => $stat['total'] ? $stat['total'] : 0,
            'money' => $stat['money'] ? $stat['money'] : 0
        ];
        $this->buildBreadcrumbs(array(
            array('title' => '资讯管理', 'link' => '/wxapp/currency/informationList'),
            array('title' => '资讯付费记录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/currency/information-card-pay-record.tpl');
    }



    public function _get_information_cate_group($except = 0,$isJson = true){
        $info_model = new App_Model_Applet_MysqlAppletInformationStorage();
        $where[] = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($except){
            $where[] = array('name'=>'ai_id','oper'=>'!=','value'=>$except);
        }
        $sort    = array('ai_create_time'=>'DESC');
        $list = $info_model->getList($where,0,0,$sort,array('ai_id','ai_category','ai_title'));
        $data= array();
        if($list){
            foreach ($list as $val){
                $data[$val['ai_category']][] = array(
                    'id'    => $val['ai_id'],
                    'cate'  => $val['ai_category'],
                    'title' => $val['ai_title'],
                );
            }
        }
        if($isJson){
            return json_encode($data);
        }else{
            return $data;
        }

    }


    public function _get_information_select(){
        $info_model = new App_Model_Applet_MysqlAppletInformationStorage();
        $where[] = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $sort    = array('ai_create_time'=>'DESC');
        $list = $info_model->getList($where,0,50,$sort,array('ai_id','ai_category','ai_title'));
        $data = array();
        if(!empty($list)){
            foreach ($list as $val){
                $data[$val['ai_id']] = $val['ai_title'];
            }
        }
        $this->output['information_select'] = $data;
    }


    public function gzhBindAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $this->informationSecondLink('gzh');
        $gzh_model = new App_Model_Information_MysqlInformationGzhStorage($this->curr_sid);
        $where = array();
        $where[] = array('name' => 'abg_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $gzhList = $gzh_model->getList($where, 0, 0, array('abg_create_time' => 'asc'));
        $info_model = new App_Model_Applet_MysqlAppletInformationStorage();
        foreach ($gzhList as $key => $val){
            $where = array();
            $where[] = array('name' => 'ai_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'ai_wx_no', 'oper' => '=', 'value' => $val['abg_wxno']);
            $where[] = array('name' => 'ai_deleted', 'oper' => '=', 'value' => 0);
            $gzhList[$key]['informationCount'] = $info_model->getCount($where);
        }
        $this->output['gzhList'] = $gzhList;
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $where = array();
        $where[] = array('name'=>'aic_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>'aic_s_id','oper'=>'=','value'=>$this->curr_sid);
        $total = $category_storage->getCount($where);
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $this->output['paginator'] = $page_plugin->render();
        $list = array();
        if($total > $index){
            $list = $category_storage->getListGzh($where, $index, $this->count, array('aic_create_time'=>'DESC'));
        }
        $this->output['categoryList'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '资讯管理', 'link' => '/wxapp/currency/informationList'),
            array('title' => '公众号关联', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/currency/gzh-bind.tpl');
    }


    public function helpCenterInfoListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $info_storage = new App_Model_Applet_MysqlAppletHelpCenterInfoStorage($this->curr_sid);
        $where   = array();
        $where[] = array('name' => 'ahci_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort = array('ahci_sort' => 'DESC','ahci_update_time'=>'DESC');
        $total      = $info_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $list = $info_storage->getList($where, $index, $this->count, $sort);
        }
        $this->output['list'] = $list;

        $this->buildBreadcrumbs(array(
            array('title' => '帮助中心', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/currency/help-center-info-list.tpl');
    }


    public function helpCenterInfoEditAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $info_storage = new App_Model_Applet_MysqlAppletHelpCenterInfoStorage($this->curr_sid);
            $row = $info_storage->getRowById($id);
            $this->output['row'] = $row;
        }
        $this->buildBreadcrumbs(array(
            array('title' => '帮助中心', 'link' => '/wxapp/currency/helpCenterInfoList'),
            array('title' => '新增/编辑内容', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/currency/help-center-info-edit.tpl');
    }


    public function helpCenterInfoSaveAction(){
        $id = $this->request->getIntParam('id');
        $title = $this->request->getStrParam('title');
        $content = $this->request->getParam('content');
        $sort = $this->request->getIntParam('sort');
        $info_storage = new App_Model_Applet_MysqlAppletHelpCenterInfoStorage($this->curr_sid);
        $data = [
            'ahci_content' => $content,
            'ahci_sort' => $sort,
            'ahci_title' => $title,
            'ahci_update_time' => time()
        ];

        if(!$title){
            $this->displayJsonError('请填写标题');
        }
        if(!$content){
            $this->displayJsonError('请填写内容');
        }

        if($id){
            $res = $info_storage->updateById($data,$id);
        }else{
            $data['ahci_create_time'] = time();
            $data['ahci_s_id'] = $this->curr_sid;
            $res = $info_storage->insertValue($data);
        }
        App_Helper_OperateLog::saveOperateLog("帮助中心文章【".$title."】信息保存成功");
        $this->showAjaxResult($res,'保存');
    }


    public function helpCenterInfoDeleteAction(){
        $id = $this->request->getIntParam('id');
        $info_storage = new App_Model_Applet_MysqlAppletHelpCenterInfoStorage($this->curr_sid);
        $res = $info_storage->deleteDFById($id,$this->curr_sid);
        $this->showAjaxResult($res,'删除');
    }


    public function getShopMessageAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $message_storage = new App_Model_Shop_MysqlShopMessageStorage($this->curr_sid);

        $where[] = array('name' => 'sm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort = array('sm_create_time' => 'desc');
        if($this->wxapp_cfg['ac_type'] == 32){
            $area_info=$this->get_area_manager();
            if($area_info){
                if($area_info['m_area_type']=='C')
                    $where[] = "(  
                        ((sm.sm_type = 1 OR sm.sm_type = 2 OR sm.sm_type = 4 ) AND asa.asa_city = {$area_info['m_area_id']})  OR
                        ((sm.sm_type = 10 OR sm.sm_type = 11) AND sm.sm_to_manager = {$area_info['m_id']})
                    )";
                else if($area_info['m_area_type']=='D')
                    $where[] = "(  
                        ((sm.sm_type = 1 OR sm.sm_type = 2 OR sm.sm_type = 4 ) AND asa.asa_zone = {$area_info['m_area_id']})  OR
                        ((sm.sm_type = 10 OR sm.sm_type = 11) AND sm.sm_to_manager = {$area_info['m_id']})
                    )";

                $list = $message_storage->getListSeqregion($where, $index, 10, $sort);
            }else{
                $not_show = [
                    App_Helper_ShopMessage::SEQUENCE_REGION_GOODS_VERIFY,
                    App_Helper_ShopMessage::SEQUENCE_REGION_COMMUNITY_VERIFY
                ];
                $where[] = ['name' => 'sm_type', 'oper' => 'not in', 'value' => $not_show];
                $list = $message_storage->getList($where, $index, 10, $sort);
            }
        }else{
            $list = $message_storage->getList($where, $index, 10, $sort);
        }


        $data = array();

        foreach ($list as $val){
            $item = array(
                'id'    => $val['sm_id'],
                'title' => $val['sm_title'],
                'content' => $val['sm_content'],
                'time' => date('Y-m-d H:i:s', $val['sm_create_time']),
                'read' => $val['sm_read'],
            );
            switch ($val['sm_type']){
                case App_Helper_ShopMessage::TRADE_HAD_PAY:
                    $item['link'] = '/wxapp/order/tradeDetail?order_no='.$val['sm_tid'];
                    break;
                case App_Helper_ShopMessage::TRADE_RIGHTS:
                    $item['link'] = '/wxapp/order/tradeRefund?order_no='.$val['sm_tid'];
                    break;
                case App_Helper_ShopMessage::APPLY_THREE_WITHDRAW:
                    $item['link'] = $this->wxapp_cfg['ac_type'] == 6?'/wxapp/copartner/withdraw':'/wxapp/three/withdraw';
                    break;
                case App_Helper_ShopMessage::REMIND_DELIVER:
                    $item['link'] = '/wxapp/order/tradeList?status=hadpay';
                    break;
                case App_Helper_ShopMessage::LEAVING_MESSAGE:
                    $item['link'] = '/wxapp/form/formData';
                    break;
                case App_Helper_ShopMessage::LEAVING_APPLET_AUTH:
                    $item['link'] = '/wxapp/setup/code';
                    break;
                case App_Helper_ShopMessage::APPLY_WITHDRAW:
                    $item['link'] = '/wxapp/city/withdraw';
                    break;
                case App_Helper_ShopMessage::LEAVING_SHOP_ENTER:
                    $item['link'] = $this->wxapp_cfg['ac_type'] == 6?'/wxapp/city/applyDetail?id='.$val['sm_tid']:'/wxapp/community/applyDetail?id='.$val['sm_tid'];
                    break;
                case App_Helper_ShopMessage::SEQUENCE_LEADER_APPLY:
                    $item['link'] = '/wxapp/sequence/leaderApplyList';
                    break;
                case App_Helper_ShopMessage::SEQUENCE_REGION_GOODS_SEND:
                    $item['link'] = '/wxapp/seqregion/goodsVerify';
                    break;
                case App_Helper_ShopMessage::SEQUENCE_REGION_COMMUNITY_SEND:
                    $item['link'] = '/wxapp/seqregion/communityVerify';
                    break;
                case App_Helper_ShopMessage::SEQUENCE_REGION_GOODS_VERIFY:
                    $item['link'] = '/wxapp/goods/index';
                    break;
                case App_Helper_ShopMessage::SEQUENCE_REGION_COMMUNITY_VERIFY:
                    $item['link'] = '/wxapp/sequence/communityList';
                    break;
                case App_Helper_ShopMessage::LEAVING_SHOP_CLAIM:
                    $item['link'] = '/wxapp/city/claimList/acsId/'.$val['sm_tid'];
                    break;
                case App_Helper_ShopMessage::LEAVING_MOBILE_ENTER:
                    $item['link'] ='/wxapp/mobile/shopEdit/?id='.$val['sm_tid'];
                    break;
                case App_Helper_ShopMessage::SEQUENCE_SUPPLIER_GOODS_SEND:
                    $item['link'] ='/wxapp/sequence/getSupplierGoodsList';
                    break;
                default:
                    $item['link'] = '/';
            }
            $data[] = $item;
        }

        if($list){
            $this->displayJsonSuccess($data);
        }else{
            $this->displayJsonError("数据记载完毕");
        }
    }


    public function setReadAction(){
        $id = $this->request->getIntParam('id');
        $set = array('sm_read' => 1);
        $message_storage = new App_Model_Shop_MysqlShopMessageStorage($this->curr_sid);

        if($id){
            $ret = $message_storage->updateById($set, $id);
        }else{
            $where = array();
            $where[] = array('name' => 'sm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'sm_read', 'oper' => '=', 'value' => 0);

            $ret = $message_storage->updateValue($set, $where);
        }
        $this->showAjaxResult($ret);
    }



    private function _save_pay_record($data){
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_storage->findUpdateMemberByWeixinOpenid($data['data']['openid'],$this->curr_sid);
        $indata = array(
            'cr_tid'        => $data['data']['out_trade_no'],
            'cr_s_id'       => $this->curr_sid,
            'cr_es_id'      => 0,
            'cr_money'      => intval($data['data']['total_fee'])/100,
            'cr_m_id'       => $member['m_id'],
            'cr_from'       => 2,
            'cr_pay_type'   => App_Helper_Trade::TRADE_PAY_WXZFZY,//微信支付
            'cr_pay_time'   => time(),
            'cr_online_money' => intval($data['data']['total_fee'])/100,
        );
        $cash_model    = new App_Model_Cash_MysqlRecordStorage($this->curr_sid);
        return $cash_model->insertValue($indata);
    }

    private function get_area_manager(){
        $manager_model = new App_Model_Member_MysqlManagerStorage();
        $info=$manager_model->getSingleManagerWithArea($this->uid,$this->company['c_id']);
        if($info){
            return [
                'm_id'          =>$info['m_id'],
                'm_area_id'     =>$info['m_area_id'],
                'm_area_type'   =>$info['m_area_type'],
                'region_name'   =>$info['region_name'],
            ];
        }else{
            return null;
        }
    }



    public function uploadVerifyAction(){
        $type = $this->request->getStrParam('type');
        $mergecode_model = new App_Model_Applet_MysqlMergeQrcodeStorage($this->curr_sid);
        if (!empty($_FILES)) {
            if (isset($_FILES['verify'])) {
                $field = $_FILES['verify'];
                if($field['type'] != 'text/plain'){
                    $this->displayJsonError("上传失败，请上传txt类型的文件");
                }
                $tmp_name = $field['tmp_name'];
                $absolute_path = PLUM_DIR_UPLOAD.'/mergecode/';
                $relative_path = PLUM_PATH_UPLOAD.'/mergecode/';
                if (!is_dir($absolute_path)) {
                    @mkdir($absolute_path, 0755);
                }
                $filename = $field['name'];
                if (move_uploaded_file($tmp_name, $absolute_path.$filename)) {
                    if($type == 'weixin'){
                        $mergecode_model->findUpdateBySid(array('amq_weixin_path' => $relative_path.$filename));
                    }
                    if($type == 'baidu'){
                        $mergecode_model->findUpdateBySid(array('amq_baidu_path' => $relative_path.$filename));
                    }
                    if($type == "ali"){
                        $mergecode_model->findUpdateBySid(array('amq_ali_path' => $relative_path.$filename));
                    }
                    $this->displayJsonSuccess(array('path' => $relative_path.$filename), true);
                }
            }
        }
        $this->displayJsonError("上传失败，请重试");
    }



    //首页活动图管理
    public function diagramAction() {
        $diagram_model = new App_Model_Slide_MysqlDiagramStorage();
        $list          = $diagram_model->getList(array(),0,0,array('di_id'=>'ASC'));
//        plum_msg_dump($list,1);
        $this->output['list']  = $list;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/currency/diagram.tpl');
    }

    public function saveDiagramAction(){
        $id    = $this->request->getIntParam('id',1);
        $title = $this->request->getStrParam('title');
        $path  = $this->request->getStrParam('path');
        if($path){
            $diagram_model = new App_Model_Slide_MysqlDiagramStorage();
            $data = array(
                'di_img'       => $path,
                'di_title'     => $title,
            );
            $res = $diagram_model -> updateById($data,$id);
            $this->showAjaxResult($res,'保存');
        }else{
            $this->displayJsonError('添加失败');
        }

    }

}