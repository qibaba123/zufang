<?php


class App_Controller_Wxapp_IndexController extends App_Controller_Wxapp_InitController {

    public function __construct() {
        parent::__construct();
    }

    public function indexAction() {
        $shop = $this->curr_shop;
        if(in_array($shop['s_broker_type'], array(2,3))) {
            plum_url_location('','/wxapp/face/index');
        }
        $area_info=$this->get_area_manager();
        if($area_info){
            $this->output['region_area']=1;
        }
        $cate   = plum_parse_config('category', 'applet');
        $kind   = intval($this->wxapp_cfg['ac_type']);
        $menu   = plum_parse_config('menu', "wxmenu/xcx-".$kind);
        $color  = array('#409FE6', '#F3B87F', '#3EA49B', '#D54958', '#F69580', '#1AEAD1', '#8FCF8F', '#84BDD0', '#849BD0', '#d084c5', '#ff9c45', '#3cd68a', '#b0a2f8');
        $short  = array();
        $menu_arr       = $this->manager['m_fid'] && $this->manager['m_power'] ? unserialize($this->manager['m_power']):array();
        foreach ($menu as $item) {
            if(!empty($menu_arr) && !in_array($item['access'],$menu_arr)){
                continue;// 当没有权限时，跳出本次循环
            }
            if (!empty($item) && $item['commonTools']) {
                if (isset($item['submenu']) && !empty($item['submenu'])) {
                    foreach ($item['submenu'] as $value) {
                        if($menu_arr && !in_array($value['access'],$menu_arr)){
                            continue;
                        }
                        if($value['commonTools']!==false)
                            array_push($short, array('title' => $item['title'], 'color' => $color[array_rand($color)], 'name' => $value['title'], 'link' => $value['link'], 'icon' => $value['icon'],'index-icon'=>$value['index-icon']));
                    }
                } else {
                    array_push($short, array('title' => $item['title'], 'color' => $color[array_rand($color)], 'name' => $item['title'], 'link' => $item['link'], 'icon' => $item['icon'],'index-icon'=>$item['index-icon']));
                }
            }
        }
        $this->output['shortcut']   = $short;
        $this->output['kind']   = $kind;
        $list   = array();
        foreach ($cate as $key => $item) {
            $value  = array(
                'name'  => $item['name'],
                'logo'  => $item['logo'],
                'case'  => $item['case'],
                'id'    => $key,
                'used'  => false,
            );
            if ($key == $this->wxapp_cfg['ac_type']) {
                $value['used']  = true;
            }
            array_push($list, $value);
        }
        $this->output['catelist']   = $list;
        $outinfo    = array(
            'sname'     => $this->shops[$this->curr_sid]['s_name'],
            'suid'      => $this->shops[$this->curr_sid]['s_unique_id'],
            'curr_type' => $this->wxapp_cfg['ac_type'],
            'open_time'     => date('Y-m-d', $this->wxapp_cfg['ac_open_time']),
            'expire_time'   => date('Y-m-d', $this->wxapp_cfg['ac_expire_time']),
            'curr_wxapp'    => $cate[$this->wxapp_cfg['ac_type']],
        );
        $this->output['outinfo']    = $outinfo;
        $notice_model   = new App_Model_System_MysqlNoticeStorage();
        $notice     = $notice_model->fetchAppletList(0, 6, $this->wxapp_cfg['ac_type']);
        $this->output['noticeList'] = $notice;
        if(!$this->manager['m_report_qrcode']){
            $qrcode = $this->_create_manager_report_qrcode($this->manager['m_id']);
            $this->manager['m_report_qrcode'] = $qrcode;
        }
        $this->output['from'] = $this->request->getStrParam('from');
        $this->output['manager'] = $this->manager;
        $this->displaySmarty('wxapp/index-new.tpl');
    }

    private function _create_manager_report_qrcode($mid){
        $str    = 'ambm'.'|'.$mid;
        $client_plugin  = new App_Plugin_Weixin_ClientPlugin(16);
        $result = $client_plugin->fetchSecnestrQrcode($str);
        $manager_model = new App_Model_Member_MysqlManagerStorage();
        if (isset($result['url'])) {
            $suid   = $this->curr_shop['s_unique_id'];
            $filename   = $suid.'-report-'.$mid.'.png';
            $path = PLUM_APP_BUILD.'/spread/';
            $accessPath = PLUM_PATH_PUBLIC.'/build/spread/';
            Libs_Qrcode_QRCode::png($result['url'], $path.$filename, 'Q', 6, 1);
            $set = array('m_report_qrcode' => $accessPath.$filename);
            $manager_model->updateById($set, $mid);
        }
        return $accessPath.$filename;
    }
    public function tplImgAction(){
        $cate   = plum_parse_config('category', 'applet');
        $id     = $this->request->getIntParam('id');
        $this->output['tplimg'] = $cate[$id]['tplimg'];
        $this->buildBreadcrumbs(array(
            array('title' => '管理中心', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/tpl-img.tpl');
    }
    
    public function commonDeleteByIdAction(){
        $result = array(
            'ec' => 400,
            'em' => '删除类型错误'
        );
        $id     = $this->request->getIntParam('id');
        $type   = $this->request->getStrParam('type');
        if($type=='goods'){
            $area_info=$this->get_area_manager();
            if($area_info){
                $this->displayJson(['em'=>'无删除商品的权限'],1);
            }
        }


        switch($type){
            case 'goods':
                $model  = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
                $set    = array('g_deleted' => 1);
                $model->deleteEffectById($id);
                $goods  = $model->getRowById($id);
                $msg    = "商品【".$goods['g_name']."】删除成功";
                break;
            case 'graphic':
                $model  = new App_Model_Auth_MysqlWeixinNewsStorage($this->curr_sid);
                $set    = array('wn_deleted' => 1);
                break;
            case 'wxtplmsg':
                $model  = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->curr_sid);
                $set    = array('wt_deleted' => 1);
                break;
            case 'appletwxtplmsg':
                $model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
                $set    = array('awt_deleted' => 1);
                break;
            case 'goodsGroup':
                $model  = new App_Model_Goods_MysqlGroupStorage($this->curr_sid);
                $set    = array('gg_deleted' => 1);
                $model->deleteEffectById($id);
                $group  = $model->getRowById($id);
                $msg    = "商品分组【".$group['gg_name']."】删除成功";
                break;
            case 'groupGroup':
                $model  = new App_Model_Group_MysqlGroupStorage($this->curr_sid);
                $set    = array('agg_deleted' => 1);
                $model->deleteEffectById($id);
                $group  = $model->getRowById($id);
                $msg    = "拼团分组【".$group['gg_name']."】删除成功";
                break;
            case 'limitGroup':
                $model  = new App_Model_Limit_MysqlLimitGroupStorage($this->curr_sid);
                $set    = array('alg_deleted' => 1);
                $model->deleteEffectById($id);
                $group  = $model->getRowById($id);
                $msg    = "秒杀分组【".$group['gg_name']."】删除成功";
                break;
            case 'unitarySlide':
                $model = new App_Model_Unitary_MysqlSlideStorage();
                $set = array('us_deleted' => 1);
                $msg    = "夺宝活动幻灯图删除成功";
                break;
            case 'pointActivity':
                $model = new App_Model_Point_MysqlActivityStorage();
                $group = $model->getRowById($id);
                $msg    = "积分兑换活动【".$group['pa_name']."】删除成功";
                $set = array('pa_deleted' => 1);
                break;
            case 'resources':
                $model = new App_Model_Resources_MysqlResourcesStorage();
                $group = $model->getRowById($id);
                $msg    = "房源信息【".$group['ahr_title']."】删除成功";
                $set = array('ahr_deleted' => 1);
                break;
            case 'partner':
                $model = new App_Model_Resources_MysqlPartnerStorage();
                $group = $model->getRowById($id);
                $msg    = "房产合作商【".$group['ahp_name']."】删除成功";
                $set = array('ahp_deleted' => 1);
                break;
            case 'apply':
                $model = new App_Model_House_MysqlHouseApplyStorage();
                $msg    = "房源求租求购信息删除成功";
                $set = array('aha_deleted' => 1);
                break;
            case 'mobileCategory':
                $model = new App_Model_Mobile_MysqlMobileShopCategoryStorage($this->curr_sid);
                $group = $model->getRowById($id);
                $msg    = "电话本商家分类【".$group['amc_title']."】删除成功";
                $set = array('amc_deleted' => 1);
                break;
            case 'auction':
                $model = new App_Model_Auction_MysqlAuctionListStorage($this->curr_sid);
                $group = $model->getRowById($id);
                $msg    = "拍卖活动【".$group['aal_title']."】删除成功";
                $set = array('aal_deleted' => 1);
                break;
        }
        if(isset($model) && isset($set)){
            $ret    = $model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
            if($msg){
                App_Helper_OperateLog::saveOperateLog($msg);
            }
            $result = $this->showAjaxResult($ret,'删除',1);
        }
        $this->displayJson($result);
    }

    
    public function uploadImgAction(){
        $width  = $this->request->getIntParam('w', 200);
        $height = $this->request->getIntParam('h', 200);
        $groupid = $this->request->getIntParam('groupid');
        $crop       = new Libs_Image_Crop_Cropper($this->curr_shop['s_unique_id']);
        $crop->crop($width, $height);

        $ret = array(
            'state'  => 200,
            'message' => $crop->getMsg(),
            'result' => $crop->getResult(),
            'filename' => $crop->getFileName()
        );
        if($ret['result']){
            $data = array(
                'sa_s_id'   => $this->curr_sid,
                'sa_g_id'   => $groupid,
                'sa_path'   => $ret['result'],
                'sa_name'   => date('YmdHis',time()),
                'sa_type'   => 1,
                'sa_real_name' => $ret['filename'],
                'sa_width'  => $width,
                'sa_height' => $height,
                'sa_create_time' => time()
            );
            $attachment_model = new App_Model_Shop_MysqlAttachmentStorage();
            $attachment_model->insert($data);
        }
        $this->displayJson($ret);
    }

    
    public function regionAction(){
        $fid  = $this->request->getIntParam('fid');
        $region_model = new App_Model_Member_MysqlRegionStorage();
        $region = $region_model->getListByParent($fid);
        Libs_Log_Logger::outputLog($region);
        $this->displayJsonSuccess($region);
    }

    
    public function amapAction(){
        $fid  = $this->request->getIntParam('fid',-1);
        $fid = $fid == -1 ? 0 : $fid;
        $region_model = new App_Model_App_MysqlAmapStorage();
        $region = $region_model->getListByFid($fid);
        if($fid == 0){
            $region_new = [];
            foreach ($region as $val){
                if(!in_array($val['aa_id'],[25,26,27,2387,2388,2389]) && ($val['aa_level'] != 2 || ($val['aa_level'] == 2 && $val['aa_region_name']))){
                    $region_new[] = $val;
                }
            }
        }else{
            $region_new = [];
            foreach ($region as $val){
                if($val['aa_level'] != 2 || ($val['aa_level'] == 2 && $val['aa_region_name'])){
                    $val['aa_name'] = $val['aa_region_name'] ? $val['aa_region_name'] : $val['aa_name'];
                    $region_new[] = $val;
                }
            }
        }
        $region = $region_new;
        $this->displayJsonSuccess($region);
    }

    
    public function fetchAttachmentAction(){
        $type = $this->request->getStrParam('type');
        $result = array(
            'ec'        => 200,
            'data'      => array(),
            'pageHtml'  => '',
            'count'     => $this->count,
        );
        $page  = $this->request->getIntParam('page',1);
        $index = $this->count * intval($page-1);
        $where = array();
        if($type == 'common'){
            $where[] = array('name'=>'sa_s_id','oper'=>'=','value'=>-1);
        }else{
            $where[] = array('name'=>'sa_s_id','oper'=>'=','value'=>$this->curr_sid);
        }
        $width = $this->request->getIntParam('width');
        if($width){
            $where[] = array('name'=>'sa_width','oper'=>'=','value'=>$width);
        }
        $height = $this->request->getIntParam('height');
        if($height){
            $where[] = array('name'=>'sa_height','oper'=>'=','value'=>$height);
        }
        $gid = $this->request->getIntParam('gid');
        if($gid){
            $where[] = array('name' => 'sa_g_id', 'oper' => '=', 'value' => $gid);
        }

        $attachment_model       = new App_Model_Shop_MysqlAttachmentStorage();
        $result['total']        = $attachment_model->getCount($where);
        $result['totalPage']    = ceil(floatval($result['total'] )/floatval($this->count));
        if($result['totalPage'] > 1){
            $helper = new App_Helper_Menu();
            $result['pageHtml'] = $helper->ajaxImgPageLink($result['totalPage'],$page, $type, $gid);
        }
        if($result['total'] > $index){
            $list  = $attachment_model->getList($where,$index,$this->count,array('sa_create_time'=>'DESC'));
            foreach($list as $val){
                $temp = array(
                    'path'      => $val['sa_path'],
                    'width'     => $val['sa_width'],
                    'height'    => $val['sa_height'],
                    'name'      => $val['sa_name'],
                    'realName'  => $val['sa_real_name']
                );
                $result['data'][] = $temp;
            }
        }
        $this->displayJson($result);
    }

    
    public function fetchAttachmentGroupAction(){
        $result = array(
            'ec'        => 200,
            'data'      => array(),
        );
        $height = $this->request->getIntParam('height');
        $width = $this->request->getIntParam('width');
        $attachment_group_model = new App_Model_Shop_MysqlAttachmentGroupStorage($this->curr_sid);
        $list  = $attachment_group_model->getGroupListAction();
        $attachment_model       = new App_Model_Shop_MysqlAttachmentStorage();
        foreach($list as $val){
            $temp = array(
                'id'        => $val['sag_id'],
                'weight'    => $val['sag_sort'],
                'name'      => $val['sag_name'],
                'count'     => $attachment_model->getCountByGid($this->curr_sid, $val['sag_id'], $height, $width)
            );
            $result['data'][] = $temp;
        }

        $this->displayJson($result);
    }

    
    public function saveAttachmentGroupAction(){
        $result = array(
            'ec' => 400,
            'id' => 0,
            'em' => '保存失败'
        );
        $id     = $this->request->getIntParam('id');
        $name   = $this->request->getStrParam('name');
        $weight = $this->request->getIntParam('weight');

        $attachment_group_model = new App_Model_Shop_MysqlAttachmentGroupStorage($this->curr_sid);
        $data = array(
            'sag_s_id'   => $this->curr_sid,
            'sag_name'   => $name,
            'sag_sort'   => $weight,
        );

        if($id){
            $ret = $attachment_group_model->updateById($data, $id);
        }else{
            $data['sag_create_time'] = time();
            $ret = $attachment_group_model->insertValue($data);
            $id = $ret;
        }
        if($ret){
            $result = array(
                'ec' => 200,
                'id' => $id,
                'em' => '保存成功'
            );
            App_Helper_OperateLog::saveOperateLog("附件图片分组【{$name}】保存成功");
        }

        $this->displayJson($result);
    }

    
    public function delAttachmentGroupAction(){
        $id = $this->request->getIntParam('id');
        $attachment_group_model = new App_Model_Shop_MysqlAttachmentGroupStorage($this->curr_sid);
        $attachment = $attachment_group_model->getRowById($id);
        $set = array(
            'sag_deleted' => 1
        );
        $ret = $attachment_group_model->updateById($set, $id);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("附件图片分组【{$attachment['sag_name']}】保存成功");
        }

        $this->showAjaxResult($ret);
    }

    public function testAction(){
        $this->displaySmarty('wxapp/customtpl/test.tpl');
    }

    
    public function fetchSelectGoodsAction(){
        $name           = $this->request->getStrParam('name');
        $independence   = $this->request->getStrParam('independence',0);
        $count = 18;
        $result = array(
            'ec'        => 200,
            'data'      => array(),
            'pageHtml'  => '',
            'count'     => $count,
        );
        $page  = $this->request->getIntParam('page',1);
        $index = $count * intval($page-1);
        $where = array();

        $where[] = array('name'=>'g_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'g_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>'g_independent_mall','oper'=>'=','value'=>$independence);

        if($this->menuType == 'toutiao' && $this->curr_shop['s_entershop_goods_verify'] == 1){
            $where[]     = array('name' => 'g_is_sale', 'oper' => 'not in', 'value' =>[4,5]);
        }

        if($name){
            $where[] = array('name'=>'g_name','oper'=>'like','value'=> "%{$name}%");
        }
        if($this->wxapp_cfg['ac_type'] == 18){
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>1);
        }

        $goods_model       = new App_Model_Goods_MysqlGoodsStorage();
        $result['total']        = $goods_model->getCount($where);
        $result['totalPage']    = ceil(floatval($result['total'])/floatval($count));
        if($result['totalPage'] > 1){
            $helper = new App_Helper_Menu();
            $result['pageHtml'] = $helper->ajaxGoodsPageLink($result['totalPage'],$page);
        }
        if($result['total'] > $index){
            $list  = $goods_model->getList($where,$index,$count,array('g_create_time'=>'DESC'));
            foreach($list as $val){
                $temp = array(
                    'id'        => $val['g_id'],
                    'cover'     => $val['g_cover'],
                    'name'      => $val['g_name'],
                );
                $result['data'][] = $temp;
            }
        }
        $this->displayJson($result);
    }

    
    public function fetchSelectInformationAction(){
        $name = $this->request->getStrParam('name');
        $count = 18;
        $result = array(
            'ec'        => 200,
            'data'      => array(),
            'pageHtml'  => '',
            'count'     => $count,
        );
        $page  = $this->request->getIntParam('page',1);
        $index = $count * intval($page-1);
        $where = array();

        $where[] = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        if($name){
            $where[] = array('name'=>'ai_title','oper'=>'like','value'=> "%{$name}%");
        }

        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $result['total']        = $information_storage->getCount($where);
        $result['totalPage']    = ceil(floatval($result['total'])/floatval($count));
        if($result['totalPage'] > 1){
            $helper = new App_Helper_Menu();
            $result['pageHtml'] = $helper->ajaxInformationPageLink($result['totalPage'],$page);
        }
        if($result['total'] > $index){
            $list  = $information_storage->getList($where,$index,$count,array('ai_create_time'=>'DESC'));
            foreach($list as $val){
                $temp = array(
                    'id'        => $val['ai_id'],
                    'cover'     => $val['ai_cover'],
                    'name'      => $val['ai_title'],
                );
                $result['data'][] = $temp;
            }
        }
        $this->displayJson($result);
    }

    
    public function fetchSelectCouponAction(){
        $name = $this->request->getStrParam('name');
        $count = 18;
        $result = array(
            'ec'        => 200,
            'data'      => array(),
            'pageHtml'  => '',
            'count'     => $count,
        );
        $page  = $this->request->getIntParam('page',1);
        $index = $count * intval($page-1);
        $where = array();

        if($name){
            $where[] = array('name'=>'cl_name','oper'=>'like','value'=> "%{$name}%");
        }

        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $result['total']        = $coupon_model->fetchValidCount($this->curr_sid, $where);
        $result['totalPage']    = ceil(floatval($result['total'])/floatval($count));
        if($result['totalPage'] > 1){
            $helper = new App_Helper_Menu();
            $result['pageHtml'] = $helper->ajaxCouponPageLink($result['totalPage'],$page);
        }
        if($result['total'] > $index){
            $list = $coupon_model->fetchValidList($this->curr_sid,$index,$count, $where);
            foreach($list as $val){
                $temp = array(
                    'id'    => $val['cl_id'],
                    'name'  => $val['cl_name'],
                    'value' => $val['cl_face_val'],
                    'limit' => $val['cl_use_limit'],
                    'count' => $val['cl_count'],
                    'receive' => $val['cl_had_receive'],
                    'desc'  => $val['cl_use_desc'],
                    'start' => date('Y-m-d', $val['cl_start_time']),
                    'end'   => date('Y-m-d', $val['cl_end_time']),
                );
                $result['data'][] = $temp;
            }
        }
        $this->displayJson($result);
    }

    
    public function fetchSelectGroupAction(){
        $name = $this->request->getStrParam('name');
        $count = 18;
        $result = array(
            'ec'        => 200,
            'data'      => array(),
            'pageHtml'  => '',
            'count'     => $count,
        );
        $page  = $this->request->getIntParam('page',1);
        $index = $count * intval($page-1);
        $where = array();
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->curr_sid);

        if($this->wxapp_cfg['ac_type'] == 12){
            if($name){
                 $where[] = array('name'=>'atc_title','oper'=>'like','value'=> "%{$name}%");
            }
            $result['total']        = $group_model->getCourseCurrentCount($where, 1);
        }else{
            if($name){
                $where[] = array('name'=>'g_name','oper'=>'like','value'=> "%{$name}%");
            }
            $result['total']        = $group_model->getCurrentCount($where, 1);
        }

        $result['totalPage']    = ceil(floatval($result['total'])/floatval($count));
        if($result['totalPage'] > 1){
            $helper = new App_Helper_Menu();
            $result['pageHtml'] = $helper->ajaxGroupPageLink($result['totalPage'],$page);
        }
        if($result['total'] > $index){
            if($this->wxapp_cfg['ac_type'] == 12){
                $list    = $group_model->getCourseCurrentList($index,$count,$where, 1);
                foreach($list as $val){
                    if(time()>$val['gb_end_time']){
                        $statusNote = '已结束';
                    }else if(time()>= $val['gb_start_time'] && time()<=$val['gb_end_time']){
                        $statusNote = '进行中';
                    }else if(time()<$val['gb_start_time']){
                        $statusNote = '未开始';
                    }
                    $temp = array(
                        'id'    => $val['gb_id'],
                        'cover' => $val['atc_cover'],
                        'name'  => $val['atc_title'],
                        'gprice'=> $val['gb_type']==3?$val['gb_tz_price']:$val['gb_price'],
                        'price' => $val['atc_price'] && is_numeric($val['atc_price']) ? $val['atc_price'] : 0,
                        'total' => $val['gb_total'],
                        'hadTotal' => $val['gb_joined'],
                        'statusNote'=> $statusNote,
                        'brief' => $val['atc_brief']
                    );
                    $result['data'][] = $temp;
                }
            }else{
                $list    = $group_model->getCurrentList($index,$count,$where, 1);
                foreach($list as $val){
                    if(time()>$val['gb_end_time']){
                        $statusNote = '已结束';
                    }else if(time()>= $val['gb_start_time'] && time()<=$val['gb_end_time']){
                        $statusNote = '进行中';
                    }else if(time()<$val['gb_start_time']){
                        $statusNote = '未开始';
                    }
                    $temp = array(
                        'id'    => $val['gb_id'],
                        'cover' => $val['g_cover'],
                        'name'  => $val['g_name'],
                        'gprice'=> $val['gb_type']==3?$val['gb_tz_price']:$val['gb_price'],
                        'price' => $val['g_price'],
                        'total' => $val['gb_total'],
                        'hadTotal' => $val['gb_joined'],
                        'statusNote'=> $statusNote,
                        'brief' => $val['g_brief']
                    );
                    $result['data'][] = $temp;
                }
            }

        }
        $this->displayJson($result);
    }

    
    public function fetchSelectSeckillAction(){
        $name = $this->request->getStrParam('name');
        $count = 18;
        $result = array(
            'ec'        => 200,
            'data'      => array(),
            'pageHtml'  => '',
            'count'     => $count,
        );
        $page  = $this->request->getIntParam('page',1);
        $index = $count * intval($page-1);
        $where = array();
        $limit_model = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        if($this->wxapp_cfg['ac_type'] == 12){
            if($name){
                $where[] = array('name'=>'atc_title','oper'=>'like','value'=> "%{$name}%");
            }
            $result['total']        = $limit_model->getAllRunningNotBeginActCourseCount($where);
        }else{
            if($name){
                $where[] = array('name'=>'g_name','oper'=>'like','value'=> "%{$name}%");
            }
            $result['total']        = $limit_model->getAllRunningNotBeginActGoodsCount($where);
        }

        $result['totalPage']    = ceil(floatval($result['total'])/floatval($count));
        if($result['totalPage'] > 1){
            $helper = new App_Helper_Menu();
            $result['pageHtml'] = $helper->ajaxSeckillPageLink($result['totalPage'],$page);
        }
        if($result['total'] > $index){
            if($this->wxapp_cfg['ac_type'] == 12){
                $list    = $limit_model->getAllRunningNotBeginActCourse($where,$index,$count, $name);
                foreach($list as $val){
                    $temp = array(
                        'id'         => $val['atc_id'],
                        'name'       => $val['atc_title'],
                        'cover'      => $val['atc_cover'],
                        'price'      => floatval($val['atc_price']),
                        'oriPrice'   => floatval($val['atc_ori_price']),
                        'brief'      => isset($goods['atc_brief']) ? $val['atc_brief'] : '',
                        'hadSale'    => ''
                    );
                    $limit_buy  = new App_Helper_LimitBuy($this->curr_sid);
                    $limit_act  = $limit_buy->checkLimitAct($val['atc_id']);
                    $temp['oriPrice']  = $temp['price'];
                    $limit_price    = floatval($limit_act['lg_yh_price']);
                    $temp['price']  = $limit_price;
                    $temp['restriction']  = intval($limit_act['lg_limit']);
                    $temp['status'] = $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN?1:0;
                    $temp['limitStock'] = $limit_act['lg_stock'] ? $limit_act['lg_stock'] : $val['g_stock'];
                    $temp['limitHadSale'] = (round($limit_act['lg_sold']/($temp['limitStock']),2)*100).'%';
                    $result['data'][] = $temp;
                }
            }else{
                $list    = $limit_model->getAllRunningNotBeginActGoods($where,$index,$count, $name);
                foreach($list as $val){
                    $temp = array(
                        'id'         => $val['g_id'],
                        'name'       => $val['g_name'],
                        'cover'      => $val['g_cover'],
                        'price'      => floatval($val['g_price']),
                        'oriPrice'   => floatval($val['g_ori_price']),
                        'brief'      => isset($goods['g_brief']) ? $val['g_brief'] : '',
                        'hadSale'    => (round($val['g_sold']/($val['g_sold']+$val['g_stock']),2)*100).'%'
                    );
                    $limit_buy  = new App_Helper_LimitBuy($this->curr_sid);
                    $limit_act  = $limit_buy->checkLimitAct($val['g_id']);
                    $temp['oriPrice']  = $temp['price'];
                    $limit_price    = floatval($limit_act['lg_yh_price']);
                    $temp['price']  = $limit_price;
                    $temp['restriction']  = intval($limit_act['lg_limit']);
                    $temp['status'] = $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN?1:0;
                    $temp['limitStock'] = $limit_act['lg_stock'] ? $limit_act['lg_stock'] : $val['g_stock'];
                    $temp['limitHadSale'] = (round($limit_act['lg_sold']/($temp['limitStock']),2)*100).'%';
                    $result['data'][] = $temp;
                }
            }

        }
        $this->displayJson($result);
    }

    
    public function fetchSelectBargainAction(){
        $name = $this->request->getStrParam('name');
        $count = 18;
        $result = array(
            'ec'        => 200,
            'data'      => array(),
            'pageHtml'  => '',
            'count'     => $count,
        );
        $page  = $this->request->getIntParam('page',1);
        $index = $count * intval($page-1);
        $where = array();
        $where[]    = array('name'=>'ba_s_id','oper'=>'=','value'=>$this->curr_sid);


        $where[]  = array('name'=>'ba_deleted','oper'=>'=','value'=>0);
        $sort = array('ba_status'=>'ASC','ba_create_time' => 'DESC');
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
        if($this->wxapp_cfg['ac_type'] == 12){
            if($name){
                $where[] = array('name'=>'atc_title','oper'=>'like','value'=> "%{$name}%");
            }
            $result['total']        = $bargain_model->getCourseActivityCount($where);
        }else{
            if($name){
                $where[] = array('name'=>'g_name','oper'=>'like','value'=> "%{$name}%");
            }
            $result['total']        = $bargain_model->getActivityCount($where);
        }

        $result['totalPage']    = ceil(floatval($result['total'])/floatval($count));
        if($result['totalPage'] > 1){
            $helper = new App_Helper_Menu();
            $result['pageHtml'] = $helper->ajaxBargainPageLink($result['totalPage'],$page);
        }
        if($result['total'] > $index){
            if($this->wxapp_cfg['ac_type'] == 12){
                $list = $bargain_model->getCourseActivityList($where,$index,$count,$sort);
                foreach($list as $val){
                    $temp = array(
                        'id'       => $val['ba_id'],
                        'cover'    => $val['atc_cover'],
                        'name'     => $val['atc_title'],
                        'brief'     => $val['atc_brief'],
                        'oriPrice' => $val['ba_price'],
                        'minPrice' => $val['ba_kj_price_limit'],
                        'sold'     => $val['ba_join_num'],
                        'status'   => $val['ba_status']==0?'准备中':($val['ba_status']==1?'进行中':'已结束'),
                    );
                    $result['data'][] = $temp;
                }
            }else{
                $list = $bargain_model->getActivityList($where,$index,$count,$sort);
                foreach($list as $val){
                    $temp = array(
                        'id'       => $val['ba_id'],
                        'cover'    => $val['g_cover'],
                        'name'     => $val['g_name'],
                        'brief'     => $val['g_brief'],
                        'oriPrice' => $val['ba_price'],
                        'minPrice' => $val['ba_kj_price_limit'],
                        'sold'     => $val['ba_join_num'],
                        'status'   => $val['ba_status']==0?'准备中':($val['ba_status']==1?'进行中':'已结束'),
                    );
                    $result['data'][] = $temp;
                }
            }
        }
        $this->displayJson($result);
    }

    
    public function fetchSelectPointsAction(){
        $name = $this->request->getStrParam('name');
        $count = 18;
        $result = array(
            'ec'        => 200,
            'data'      => array(),
            'pageHtml'  => '',
            'count'     => $count,
        );
        $page  = $this->request->getIntParam('page',1);
        $index = $count * intval($page-1);
        $where          = array();
        $where[]        = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        if($name){
            $where[] = array('name'=>'g_name','oper'=>'like','value'=> "%{$name}%");
        }
        $where[]  = array('name' => 'g_type','oper' => 'in','value' => array(4,5));
        $where[]  = array('name' => 'g_is_sale','oper' => '=','value' => 1);
        $sort = array('g_update_time' => 'DESC');

        $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $result['total']        = $goods_model->getCount($where);
        $result['totalPage']    = ceil(floatval($result['total'])/floatval($count));
        if($result['totalPage'] > 1){
            $helper = new App_Helper_Menu();
            $result['pageHtml'] = $helper->ajaxPointsPageLink($result['totalPage'],$page);
        }
        if($result['total'] > $index){
            $list = $goods_model->getList($where,$index,$this->count,$sort);
            foreach($list as $val){
                $temp = array(
                    'id'        => $val['g_id'],
                    'cover'     => $val['g_cover'],
                    'name'      => $val['g_name'],
                    'price'     => $val['g_price'],
                    'oriPrice'  => $val['g_ori_price'],
                    'points'    => $val['g_points'],
                    'sold'      => $val['g_sold']
                );
                $result['data'][] = $temp;
            }
        }
        $this->displayJson($result);
    }

    
    public function fetchSelectMemberAction(){
        $name = $this->request->getStrParam('name');
        $count = 18;
        $result = array(
            'ec'        => 200,
            'data'      => array(),
            'pageHtml'  => '',
            'count'     => $count,
        );
        $page  = $this->request->getIntParam('page',1);
        $index = $count * intval($page-1);
        $where = array();
        $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        if($name){
            $where[] = array('name'=>'m_nickname','oper'=>'like','value'=> "%{$name}%");
        }

        $where[] = array('name' => 'm_is_highest', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'm_source', 'oper' => '=', 'value' => 2);
        $where[] = array('name' => 'm_1f_id', 'oper' => '=', 'value' => 0);

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $result['total']        = $member_model->getCount($where);
        $result['totalPage']    = ceil(floatval($result['total'])/floatval($count));
        if($result['totalPage'] > 1){
            $helper = new App_Helper_Menu();
            $result['pageHtml'] = $helper->ajaxMemberPageLink($result['totalPage'],$page);
        }
        if($result['total'] > $index){
            $list = $member_model->getList($where,$index,$count,array());
            foreach($list as $val){
                $temp = array(
                    'id'       => $val['m_id'],
                    'name'     => $val['m_nickname'],
                    'avatar'   => $val['m_avatar']?$val['m_avatar']:'/public/manage/img/zhanwei/zw_fxb_45_45.png',
                );
                $result['data'][] = $temp;
            }
        }
        $this->displayJson($result);
    }

    
    public function fetchSelectShopAction(){
        $name = $this->request->getStrParam('name');
        $count = 18;
        $result = array(
            'ec'        => 200,
            'data'      => array(),
            'pageHtml'  => '',
            'count'     => $count,
        );
        $page  = $this->request->getIntParam('page',1);
        $index = $count * intval($page-1);
        if($this->wxapp_cfg['ac_type'] == 6){
            $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
            $sort  = array('acs_create_time' => 'DESC');
            $where = array();
            $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'acs_status', 'oper' => '=', 'value' => 2);
            if($name){
                $where[] = array('name'=>'acs_name','oper'=>'like','value'=>"%{$name}%");
            }
            $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);

            $result['total']        = $shop_storage->getCount($where);
            $result['totalPage']    = ceil(floatval($result['total'])/floatval($count));
            if($result['totalPage'] > 1){
                $helper = new App_Helper_Menu();
                $result['pageHtml'] = $helper->ajaxShopPageLink($result['totalPage'],$page);
            }
            if($result['total'] > $index){
                $shop    = $shop_storage->getList($where,$index,$count,$sort);
                foreach ($shop as $val){
                    $temp = array(
                        'id'        => $val['acs_id'],
                        'name'      => $val['acs_name']?$val['acs_name']:'店铺名称',
                        'cover'     => $val['acs_cover']?$val['acs_cover']:'/public/manage/img/zhanwei/zw_fxb_45_45.png',
                        'showNum'   => $val['es_show_num'],
                        'label'     => $val['es_label'],
                        'category'  => $val['es_cate2_name']
                    );
                    $result['data'][] = $temp;
                }
            }
        }else{
            $where = array();
            $where[] = array('name'=>'es_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'es_deleted','oper'=>'=','value'=>0);
            if($name){
                $where[] = array('name'=>'es_name','oper'=>'like','value'=>"%{$name}%");
            }

            $sort       = array('es_createtime' => 'DESC');

            $shop_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
            $result['total']        = $shop_model->getCount($where);
            $result['totalPage']    = ceil(floatval($result['total'])/floatval($count));
            if($result['totalPage'] > 1){
                $helper = new App_Helper_Menu();
                $result['pageHtml'] = $helper->ajaxShopPageLink($result['totalPage'],$page);
            }
            if($result['total'] > $index){
                $list = $shop_model->getList($where,$index,$count,$sort);
                foreach($list as $val){
                    $temp = array(
                        'id'       => $val['es_id'],
                        'cover'    => $val['es_logo']?$val['es_logo']:'/public/manage/img/zhanwei/zw_fxb_45_45.png',
                        'name'     => $val['es_name']?$val['es_name']:'店铺名称',
                        'showNum'  => $val['es_show_num'],
                        'label'    => $val['es_label'],
                        'category' => $val['es_cate2_name']
                    );
                    $result['data'][] = $temp;
                }
            }
        }
        $this->displayJson($result);
    }

    
    public function fetchSelectStoreAction(){
        $name = $this->request->getStrParam('name');
        $count = 18;
        $result = array(
            'ec'        => 200,
            'data'      => array(),
            'pageHtml'  => '',
            'count'     => $count,
        );
        $page  = $this->request->getIntParam('page',1);
        $index = $count * intval($page-1);

        $store_model    = new App_Model_Hotel_MysqlHotelStoreStorage($this->curr_sid);
        $sort  = array('ahs_create_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'ahs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        if($name){
            $where[] = array('name'=>'ahs_name','oper'=>'like','value'=>"%{$name}%");
        }
        $where[] = array('name' => 'ahs_deleted', 'oper' => '=', 'value' => 0);

        $result['total']        = $store_model->getCount($where);
        $result['totalPage']    = ceil(floatval($result['total'])/floatval($count));
        if($result['totalPage'] > 1){
            $helper = new App_Helper_Menu();
            $result['pageHtml'] = $helper->ajaxStorePageLink($result['totalPage'],$page);
        }
        if($result['total'] > $index){
            $shop    = $store_model->getList($where,$index,$count,$sort);
            foreach ($shop as $val){
                $temp = array(
                    'id'        => $val['ahs_id'],
                    'name'      => $val['ahs_name']?$val['ahs_name']:'门店名称',
                    'cover'     => $val['ahs_avatar']?$val['ahs_avatar']:'/public/manage/img/zhanwei/zw_fxb_45_45.png',
                );
                $result['data'][] = $temp;
            }
        }

        $this->displayJson($result);
    }
    public function noticeListAction(){
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $notice_model   = new App_Model_System_MysqlNoticeStorage();
        $total      = $notice_model->fetchAppletCount($this->wxapp_cfg['ac_type']);
        $notice     = array();
        if($total > $index){
            $notice     = $notice_model->fetchAppletList($index, $this->count, $this->wxapp_cfg['ac_type']);
        }
        $page_libs      = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pageHtml']   = $page_libs->render();
        $this->output['noticeList'] = $notice;
        $this->displaySmarty('wxapp/notice-list.tpl');
    }

    
    public function deleteAttachmentAction(){
        $imgSrc = $this->request->getArrParam('imgSrc');
        if($imgSrc){
            $where = array();
            $where[] = array('name'=>'sa_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'sa_path','oper'=>'in','value'=>$imgSrc);
            $attachment_model       = new App_Model_Shop_MysqlAttachmentStorage();
            $ret = $attachment_model->deleteValue($where);
            if($ret){
                App_Helper_OperateLog::saveOperateLog("店铺附件删除成功");
            }
        }

        $this->showAjaxResult($ret,'删除');
    }

    
    public function updateAttachmentNameAction(){
        $imgSrc = $this->request->getArrParam('imgSrc');
        $name   = $this->request->getStrParam('name');
        if($imgSrc){
            $where = array();
            $where[] = array('name'=>'sa_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'sa_path','oper'=>'in','value'=>$imgSrc);
            $set = array('sa_real_name' => $name);
            $attachment_model       = new App_Model_Shop_MysqlAttachmentStorage();
            $ret = $attachment_model->updateValue($set, $where);
            if($ret){
                App_Helper_OperateLog::saveOperateLog("店铺附件名称修改成功");
            }
        }
        $this->showAjaxResult($ret,'修改');
    }

    
    public function updateAttachmentGroupAction(){
        $imgSrc = $this->request->getArrParam('imgSrc');
        $group  = $this->request->getStrParam('group');
        if($imgSrc){
            $where = array();
            $where[] = array('name'=>'sa_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'sa_path','oper'=>'in','value'=>$imgSrc);
            $set = array('sa_g_id' => $group);
            $attachment_model       = new App_Model_Shop_MysqlAttachmentStorage();
            $ret = $attachment_model->updateValue($set, $where);
            if($ret){
                App_Helper_OperateLog::saveOperateLog("店铺附件分组修改成功");
            }
        }
        $this->showAjaxResult($ret,'修改');
    }

     
    private function get_area_manager(){
        $manager_model = new App_Model_Member_MysqlManagerStorage();
        $info=$manager_model->getSingleManagerWithArea($this->uid,$this->company['c_id']);
        if($info){
            return [
                'm_area_id'     =>$info['m_area_id'],
                'm_area_type'   =>$info['m_area_type'],
                'region_name'   =>$info['region_name'],
            ];
        }else{
            return null;
        }
    }
}