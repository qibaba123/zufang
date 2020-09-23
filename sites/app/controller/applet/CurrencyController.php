<?php


class App_Controller_Applet_CurrencyController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct(true);

    }

    
    public function videoAction(){
        // 获取是否一添加视频
        $video_storage = new App_Model_Applet_MysqlAppletVideoStorage($this->sid);
        $row = $video_storage->fetchShopVideo(null,false);
        if($row){
        //if(($row['av_video_url']&&$row['av_is_open']) || ($row['av_music_url'] && $row['av_music_isopen']) || ($row['av_vr_url'] && $row['av_vr_isopen'])){
            $info['data'] = array(
                'time'        => $this->_video_time($row['av_time']),
                'open'        => $row['av_is_open'],   //是否开启视频
                'url'         => isset($row['av_video_url']) && $row['av_video_url'] && $row['av_is_open']==1 ? $row['av_video_url'] : '',
                'musicUrl'    => isset($row['av_music_url']) && $row['av_music_url'] && $row['av_music_isopen']==1 ? $row['av_music_url'].'?v='.time() : '',
                'musicTitle'  => isset($row['av_music_title']) && $row['av_music_title'] ? $row['av_music_title'] : $this->shop['s_name'],
                'vrurl'       => isset($row['av_vr_url']) && $row['av_vr_url'] && $row['av_vr_isopen']==1  ? $this->_judge_vrurl($row['av_vr_url']) : '',
                'vrTitle'     => 'VR全景',
                'vrShareTitle' => isset($row['av_vr_share_title']) && $row['av_vr_share_title'] ? $row['av_vr_share_title'] : $this->shop['s_name'],
                'vrShareCover' => isset($row['av_vr_share_cover']) && $row['av_vr_share_cover'] ? $this->dealImagePath($row['av_vr_share_cover']) : '',
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('暂未添加数据');
        }
    }

    
    private function _video_time($time){
        if($time>60){
            $min = floor($time/60);   //获取分钟的整数
            $second = fmod($time,60);
            return $min.'’'.$second.'”';
        }else{
            return $time.'”';
        }
    }

    
    public function saveAppointmentAction(){
        $name    = $this->request->getStrParam('name');
        $mobile  = $this->request->getStrParam('mobile');
        $avatar  = $this->request->getStrParam('avatar');
        $content = $this->request->getStrParam('content');    //预约内容
        $remark  = $this->request->getStrParam('remark');      //备注信息
        $prompt  = $this->request->getStrParam('prompt');      // 提示信息
        $number  = $this->request->getIntParam('number');   // 订餐预订人数
        $time    = $this->request->getStrParam('time');     // 订餐预订时间
        $esId    = $this->request->getIntParam('esId',0);   //预约门店id
        $uid     = plum_app_user_islogin();
        //新增预约会员id
        if($mobile){
            if(!plum_is_mobile($mobile)){
               $this->outputError('手机号格式错误');
            }
        }
        if($name || $mobile || $content || $remark){
            $data = array(
                'ai_s_id'        => $this->sid,
                'ai_es_id'       => $esId,
                'ai_name'        => $name,
                'ai_mobile'      => $mobile,
                'ai_content'     => $content,
                'ai_extra'       => $remark,
                'ai_avatar'      => $avatar,
                'ai_population'  => $number,
                'ai_time'        => isset($time) && $time ? strtotime($time) : '',
                'ai_create_time' => time(),
                'ai_m_id'        => $uid,
            );
            $appointment_storage = new App_Model_Applet_MysqlWeddingAppointmentStorage($this->sid);
            $ret = $appointment_storage->insertValue($data);
            if($ret){
                $info['data'] = array(
                    'result' => true,
                    'msg'    => isset($prompt) ? $prompt.'成功' :'预约成功',
                    'mess'   => array(
                        'name'    => isset($data['ai_name']) && $data['ai_name'] ? $data['ai_name'] : '匿名',
                        'avatar'  => isset($data['ai_avatar']) && $data['ai_avatar'] ? $this->dealImagePath($data['ai_avatar']) : $this->dealImagePath('/public/wxapp/images/zhanwei_avatar.png')  ,
                        'content' => isset($data['ai_content']) ? $data['ai_content'] : '',
                        'time'    => date('Y-m-d H:i',$data['ai_create_time']),
                    ),
                );
//                // 获取店铺通知短信配置
//                $sms_storage = new App_Model_Shop_MysqlShopSmsStorage($this->sid);
//                $sms = $sms_storage->findUpdateBySid();
//                // 开通通知提醒
//                if($sms && $sms['ss_xcxyytz_s'] ==1){
//                    //获取短信剩余条数
//                    $smscfg_sog     = new App_Model_Plugin_MysqlSmsCfgStorage($this->sid);
//                    $smscfg         = $smscfg_sog->fetchUpdateCfg();
//                    // 短信条数大于0
//                    if($smscfg && $smscfg['sc_useable']>0){
//                        // 发送短信
//                        $ucpaas_plugin  = new App_Plugin_Sms_UcpaasPlugin();
//                        $result = $ucpaas_plugin->sendNoticeSms($this->shop['s_phone'], 'xcxyytz' ,array($this->applet_cfg['ac_name']));
//                        if($result && $result['code'] == 0){
//                            $shop_helper    = new App_Helper_ShopWeixin($this->sid);
//                            $shop_helper->smsRecord($this->shop['s_phone'], $result['text'], 0);
//                        }
//                    }
//                }
                //短信通知
                $sms_helper = new App_Helper_Sms($this->sid);
                $sms_helper->sendNoticeSms(array(), 'xcxyytz',$this->applet_cfg['ac_name']);

                $notice_model = new App_Helper_JiguangPush($this->sid);    //推送通知
                $notice_model->pushNotice($notice_model::LEAVING_MESSAGE);
                $this->outputSuccess($info);
            }else{
                $msg = isset($prompt) ? $prompt.'失败，请重试' :'预约失败，请重试';
                $this->outputError($msg);
            }
        }else{
            $msg = isset($prompt) ? $prompt.'信息有误请重试' :'预约信息有误请重试';
            $this->outputError($msg);
        }
    }

    
    public function informationCategoryAction(){
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->sid);
        $list = $category_storage->getListBySid();
        if($list){
            $info = array();
            foreach ($list as $val){
                $info['data'][] = array(
                    'id'   => $val['aic_id'],
                    'name' => $val['aic_name']
                );
            }
            $recommend = $this->_fetch_information_recommend();
            if($recommend && !empty($recommend)){
                $info['data'] = array_merge($recommend,$info['data']);
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('暂未添加分类');
        }
    }

    
    private function _fetch_information_recommend(){
        $recommend = array();
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        $where[]       = array('name'=>'ai_isrecommend','oper'=>'=','value'=>1);
        $count = $information_storage->getCount($where);
        if($count>0){
            $recommend[] = array(
                'id'   => 0,
                'name' => '推荐',
            );
        }
        return $recommend;
    }

    
    public function informationListAction(){
        $page          = $this->request->getIntParam("page");
       // $category      = $this->request->getIntParam("categoryId");  // 所属分类
        $index         = $page * $this->count;
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);

//        if($category > 0) {
//            $where[] = array('name' => 'ai_category', 'oper' => '=', 'value' => $category);
//        }
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $sort          = array('ai_sort'=>'DESC','ai_create_time' => 'DESC');
        $list          = $information_storage->getList($where,$index,$this->count,$sort);
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->sid);
        if($list){
            $info  = array();
            foreach ($list as $key => $value) {
                $categoryRow = $category_storage->getRowById($value['ai_category']);
                $content = plum_parse_img_path($value['ai_content']);
                preg_match_all('/<img.*?src="(.*?)".*?>/is',$content,$images);
                $info['data']['list'][] = array(
                    'id'      => $value['ai_id'],
                    'title'   => $value['ai_title'],
                    'cover'   => $this->dealImagePath($value['ai_cover']),
                    'brief'   => $value['ai_brief'],
                   // 'category' => $categoryRow['aic_name']?$categoryRow['aic_name']:'',
                    'time'    => date('Y-m-d ',$value['ai_create_time']),
                    'showNum' => $this->number_format($value['ai_show_num']),
                );
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }
    }
    //获得资讯分类轮播图
    private function _get_information_slide($category){

        $slide_model = new App_Model_Information_MysqlInformationSlideStorage($this->sid);
        $where[]       = array('name'=>'ais_s_id','oper'=>'=','value'=>$this->sid);
        $where[]       = array('name'=>'ais_deleted','oper'=>'=','value'=>0);
        $where[]       = array('name'=>'ais_category','oper'=>'=','value'=>$category);
        $list = $slide_model->getList($where,0,6,array('ais_sort'=>'DESC'));
        $slide = array();
        if($list){
            foreach ($list as $val){
               if($val['ais_path']){
                   $slide[] = $this->dealImagePath($val['ais_path']);
               }
            }
        }
        return $slide;
    }

    //新 获得资讯分类轮播图
    private function _new_get_information_slide($category){

        $slide_model = new App_Model_Information_MysqlInformationSlideStorage($this->sid);
        $where[]       = array('name'=>'ais_s_id','oper'=>'=','value'=>$this->sid);
        $where[]       = array('name'=>'ais_deleted','oper'=>'=','value'=>0);
        $where[]       = array('name'=>'ais_category','oper'=>'=','value'=>$category);
        $list = $slide_model->getList($where,0,6,array('ais_sort'=>'DESC'));
        $slide = array();
        if($list){
            foreach ($list as $val){
               if($val['ais_path']){
                   $slide[] = array(
                       'link'   => intval($val['ais_link_id']),
                       'img'    => $this->dealImagePath($val['ais_path']),
                       'url'    => $val['ais_link_id'] ? $this->get_link_by_type(1,$val['ais_link_id'],'') : '' //目前只有文章类型
                   );

               }
            }
        }
        return $slide;
    }

    
    public function informationDetailsAction(){
        $id = $this->request->getIntParam('id');
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $row = $information_storage->getRowByIdSid($id,$this->sid);

        if($row){
            $info = $this->_information_details($row);
            // 增加文章的浏览量
            $this->_add_information_show_num($row['ai_id']);
            $uid = plum_app_user_islogin();
            if($uid){
                $point_storage = new App_Helper_Point($this->sid);
                $point_storage->gainPointBySource($uid,App_Helper_Point::POINT_SOURCE_READ);
            }
            $this->outputSuccess($info);

        }else{
            $this->outputError('该信息不存在或已删除');
        }

    }

    
    private function _information_details($row){
        $uid = plum_app_user_islogin();

        // 是否已经收藏过
//
//        $collection_model = new App_Model_Article_MysqlInformationCollectionStorage($this->sid);
//        $collection = $collection_model->getCollectionByMidPid($uid,$row['ai_id']);

        $info['data'] = array(
            'id'       => $row['ai_id'],
            'title'    => (string)$row['ai_title'],
            'cover'    => $this->dealImagePath($row['ai_cover']),
            'brief'    => $row['ai_brief'],
            'content'  => preg_replace('/<style.*?>(.*?)<\/style>/s', '', plum_parse_img_path($row['ai_content'])),
            'time'     => date('Y-m-d',$row['ai_create_time']),
            'showNum'  => $this->number_format($row['ai_show_num']+1),
        );
        return $info;
    }

    
    private function _get_like_avatar($id,$likeNum){
        $maxNum = 8;
        $likeNum = intval($likeNum);
        $data = array();
        if($likeNum > 0){
            $like_model = new App_Model_Applet_MysqlAppletInformationLikeStorage($this->sid);
            $like_record = $like_model->getLikeMemberList($id,0,$maxNum);
            if($like_record){
                foreach ($like_record as $val){
                    $data[] = array(
                        'mid' => intval($val['m_id']),
                        'avatar' => $val['m_avatar'] ? $this->dealImagePath($val['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png')
                    );
                    //$data[] = $val['m_avatar'] ? $this->dealImagePath($val['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
                }
            }
            $showNum = $likeNum <= $maxNum ? $likeNum : $maxNum;
            $num = count($data);
            if($num < $showNum){
                $diff = $showNum - $num;
                $fakeAvatar = plum_parse_config('fake_avatar');
                //$fakeData = array();
                for($i=0;$i<$diff;$i++){
                    $data[] = array(
                        'mid' => -1,
                        'avatar' => $this->dealImagePath($fakeAvatar[$i])
                    );
                }
            }
            //$data = array_merge($data,$fakeData);
        }

        return $data;

    }

    
    private function _get_tencent_video($vid=''){
        if(!$vid){
            $url = $this->request->getStrParam('videoUrl');
            $urlArr = parse_url($url);
            $arr_query = $this->_convert_url_query($urlArr['query']);
            if($arr_query['vid']){
                $vid  = $arr_query['vid'];
            }else{
                $content = Libs_Http_Client::get($url);
                $content_html_pattern = '/VIDEO_INFO = ({[^}]*.*?)(;.*?var |<\/script>)/s';
                //$content_html_pattern = '/vid: "(.*?)"/s';
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
        $content = Libs_Http_Client::get($baseUrl.$paramsStr);
        $content_html_pattern = '/=(.*);/s';
        preg_match($content_html_pattern, $content, $info_matchs);
        $infoInfo = json_decode($info_matchs[1], true);
        $fvkey = $infoInfo['vl']['vi'][0]['fvkey'];
        $fn = $infoInfo['vl']['vi'][0]['fn'];
        $self_host = $infoInfo['vl']['vi'][0]['ul']['ui'][0]['url'];
        if($self_host && $fn && $fvkey){
            $real_url = $self_host.$fn.'?vkey='.$fvkey;
            return $real_url;
        }else{
            $content = Libs_Http_Client::get("https://mp.weixin.qq.com/mp/videoplayer?action=get_mp_video_play_url&__biz=&mid=&idx=&vid=".$vid."&lang=zh_CN&f=json&ajax=1");
            $videoArr = json_decode($content, true);
            if($videoArr['url_info'][0]){
                return $videoArr['url_info'][0]['url'];
            }
        }
    }

    private function _convert_url_query($query){
        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }

    
    private function _information_related_info($info = ''){
        $relatedInfo = array();
        $where = array();
        $infoIdArr = array();
        $infoArr = json_decode($info,1);
        if(!empty($infoArr)){
            //获得文章id数组
            foreach ($infoArr as $val){
                if($val['infoId']){
                    $infoIdArr[] = $val['infoId'];
                }
            }
            if(!empty($infoIdArr)){
                $where[]    = array('name' => 'ai_id', 'oper' => 'in', 'value' => $infoIdArr);
                $where[]    = array('name' => 'ai_s_id', 'oper' => '=', 'value' =>$this->sid);
                $info_model = new App_Model_Applet_MysqlAppletInformationStorage();
                $list = $info_model->getList($where,0,5,array(),array('ai_id','ai_title','ai_show_num','ai_cover'));
                if($list){
                    foreach ($list as $row){
                        $relatedInfo[] = array(
                            'id'        => intval($row['ai_id']),
                            'title'     => $row['ai_title'],
                            'cover'     => $row['ai_cover'] ? $this->dealImagePath($row['ai_cover']) : '',
                            'showNum'   => $row['ai_show_num']
                        );
                    }
                }
            }
        }
        return $relatedInfo;
    }
    
    private function _information_goods_info($gids = ''){
        $goodsInfo = array();
        $where     = array();
        $gidArr = json_decode($gids,1);
        $uid    = plum_app_user_islogin();
        if(!empty($gidArr)){
            $where[]    = array('name' => 'g_id', 'oper' => 'in', 'value' => $gidArr);
            $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' =>$this->sid);
            $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
            $g_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
            $goodsList = $g_model->getList($where,0,10,array(),array('g_id','g_name','g_cover','g_price','g_es_id','g_is_discuss'));
            if($goodsList){
                foreach ($goodsList as $goods){
                    $vipData = App_Helper_Trade::getGoodsVipPirce($goods['g_price'],$this->sid,$goods['g_id'],0, $uid,1);
                    $price = $vipData['price'];
                    $isVip = $vipData['isVip'];
                    $goodsInfo[] = array(
                        'gid'   => intval($goods['g_id']),
                        'esId'  => intval($goods['g_es_id']),
                        'isDiscuss' => intval($goods['g_is_discuss']),
                        'name'  => $goods['g_name'],
                        'isVip' => $isVip,
                        'cover'  => $this->dealImagePath($goods['g_cover']),
                        'price'  => $price ? $price : $goods['g_price'],
                        'discussInfo'=> isset($goods['g_discuss_info']) ? $goods['g_discuss_info'] : '',
                    );
                }
            }
        }
        return $goodsInfo;
    }

    
    private function _is_member_card($uid,$row){
        // 获取会员卡是否存在
        $card_model = new App_Model_Information_MysqlInformationMemberCardStorage($this->shop['s_id']);
        $card = $card_model->fetchRowById($uid);
        if($card && $card['aim_expire_time']>time()){
            return true;
        }
        // 获取文章是否支付
        $pay_model = new App_Model_Information_MysqlInformationPayStorage($this->shop['s_id']);
        $record = $pay_model->fetchRowById($uid,$row['ai_id']);
        if($record){
            return true;
        }
        return false;
    }

    
    private function _information_card(){
        $data = array();
        $card_storage = new App_Model_Information_MysqlInformationCardStorage($this->shop['s_id']);
        $cardList = $card_storage->fetchListBySid();
        if($cardList){
            foreach ($cardList as $val){
                $data[] = array(
                    'id'     => $val['aic_id'],
                    'title'  => $val['aic_title'],
                    'money'  => floatval($val['aic_money']),
                    'type'   => 'member',
                );
            }
        }
        return $data;
    }

    
    public function appletJumpListAction(){
        $jump_storage = new App_Model_Applet_MysqlAppletJumpStorage($this->sid);
        $list = $jump_storage->fetchJumpList();
        if($list){
            $info = array();
            foreach ($list as $val){
                $info['data']['list'][] = array(
                    'name'       => $val['aj_name'],
                    'logo'       => $this->dealImagePath($val['aj_logo']),
                    'brief'      => isset($val['aj_brief']) ? $val['aj_brief'] : '',
                    'background' => $this->dealImagePath($val['aj_background']),
                    'appid'      => $val['aj_appid'],
                    'path'       => isset($val['aj_path']) ? $val['aj_path'] : '',
                    'extra'      => isset($val['aj_extra']) ? $val['aj_extra'] : ''
                );
            }
            $info['data']['style'] = 1;
            $this->outputSuccess($info);
        }else{
            $this->outputError('暂未添加跳转小程序');
        }
    }

    
    private function _format_coupon_data($coupon, $receive,$myCoupon=array()){
        $color = plum_parse_config('coupon_color','system');
        $data = array(
            'id'        => $coupon['cl_id'],
            'name'      => $coupon['cl_name'],
            'value'     => $coupon['cl_face_val'],
            'limit'     => $coupon['cl_use_limit'],
            'count'     => $coupon['cl_count'],
            'receive'   => $coupon['cl_had_receive'],
            'desc'      => $coupon['cl_use_desc'],
            'type'      => $coupon['cl_use_type'],
            'start'     => date('Y-m-d', $coupon['cl_start_time']),
            'end'       => date('Y-m-d', $coupon['cl_end_time']),
            'colorType' => (intval($coupon['cl_id']%4))+1,
            'color'     => $color[(intval($coupon['cl_id']%3))+1],
            'received'  => !empty($myCoupon) && isset($myCoupon['cr_c_id']) ? 1 : 0,
        );

        if($receive){
            $data['used'] = $coupon['cr_is_used'];
        }
        return $data;
    }

    
    private function _format_time($time){
        $today = strtotime(date('Y-m-d',time()));    // 今天0点时间
        if($time>$today){
            $date = '今天';
        }elseif($time<$today && $time>($today-86400)){
            $date = '昨天';
        }else{
            $date = date('Y-m-d',$time);
        }
        return $date;
    }

    public function commentInformationAction(){
        $aid = $this->request->getIntParam('aid');  // 帖子ID
        $content = $this->request->getStrParam('content');
        $cmid = $this->request->getIntParam('cmid');    // 回复会员ID，（回复别人的评论，评论人的ID）
        $cid =  $this->request->getIntParam('cid');
        $uid = plum_app_user_islogin();
        if(!$uid){
            $this->outputError('请先授权后再评论');
        }
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($uid);
        // 判断会员是否被封号
        if(!$member || $member['m_status']==1){
            $this->outputError('该账户不存在或未授权');
        }
        if($content){
            $wxclient_help = new App_Plugin_Weixin_WxxcxClient(1);   // 默认使用1号店铺的授权信息验证
            $result = $wxclient_help->checkMsg($content);
            if($result && $result['errcode']==87014){
                $this->outputError($result['errmsg']);
            }
        }
        $content = plum_sql_quote($content);
        if($aid && $content && $content!=' '){
            $data = array(
                'aic_s_id'      => $this->sid,
                'aic_ai_id'     => $aid,
                'aic_comment'   => $content,
                'aic_m_id'      => $member['m_id'],
                'aic_reply_mid' => $cmid,
                'aic_aic_id'    => $cid,
                'aic_time'      => time(),
            );
            $comment_model = new App_Model_Applet_MysqlAppletInformationCommentStorage($this->sid);
            $ret = $comment_model->insertValue($data);
            if($ret){
                if($cmid != 0){
                    $commMmember = $member_model->getRowById($cmid);
                }
                // 增加文章评论数量
                $information_model = new App_Model_Applet_MysqlAppletInformationStorage($this->sid);
                $information_model->addReduceInformationNum($aid,'comment','add');
                $info['data'] = array(
                    'result' =>true,
                    'msg'    => '评论成功',
                    'comment' => array(
                        'id'            => $ret,
                        'comment'       => plum_strip_sql_quote($content),
                        'mid'           => $uid,
                        'nickname'      => $member['m_nickname'],
                        'avatar'        => $member['m_avatar'] ? $member['m_avatar'] : $this->dealImagePath($member['m_avatar']),
                        'replyMid'      => $cmid == -1 ? '-1' : (isset($commMmember['m_id']) && $commMmember['m_id'] > 0 ? $commMmember['m_id'] : 0),
                        'replyNickname' => $cmid == -1 ? $this->applet_cfg['ac_name'] : (isset($commMmember['m_nickname']) && $commMmember['m_nickname'] ? $commMmember['m_nickname'] : ''),
                        'time'          => date('m-d H:i',$data['aic_time']),
                        'replyList'     => array()
                    )
                );
                $this->outputSuccess($info);
            }else{
                $this->outputError('评论失败');
            }
        }else{
            $this->outputError('请填写评论内容');
       }
    }
    
    public function informationCommentListAction(){
        $aid = $this->request->getIntParam('aid');
        $page = $this->request->getIntParam('page');
        $index = $page*$this->count;
        $where = array();
        $where[]    = array('name' => 'aic_aic_id', 'oper' => '=', 'value' => 0);
        $comment_model = new App_Model_Applet_MysqlAppletInformationCommentStorage($this->sid);
        $list = $comment_model->getCommentMember($aid,$index,$this->count,$where);
        if($list){
            $info = array();
            foreach ($list as $key => $val){
                $info['data'][$key] = $this->_post_comment_format($val);
                $info['data'][$key]['replyList'] = array();
                $where = array();
                $where[]    = array('name' => 'aic_aic_id', 'oper' => '=', 'value' => $val['aic_id']);
                $sort = array('aic_time'=>'ASC');
                $replyList = $comment_model->getCommentMember($aid,0,0,$where,$sort);
                if($replyList){
                    foreach ($replyList as $item){
                        $info['data'][$key]['replyList'][] = $this->_post_comment_format($item);
                    }
                }
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }

    }
    
    private function _post_comment_format($val){
        $data = array();
        if(!empty($val)){
            $data = array(
                'id'            => $val['aic_id'],
                'comment'       => isset($val['aic_comment']) ? plum_strip_sql_quote($val['aic_comment']) : '',
                'mid'           => $val['aic_m_id'],
                'nickname'      => $val['aic_m_id'] == -1 ? $this->applet_cfg['ac_name'] : $val['m_nickname'],
                'avatar'        => $val['m_avatar'] ? $val['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                'replyMid'      => $val['aic_reply_mid'] != 0 ? $val['aic_reply_mid'] : 0,
                'replyNickname' => $val['aic_reply_mid'] == -1 ? $this->applet_cfg['ac_name'] : (isset($val['aic_reply_mid']) && isset($val['rm_nickname']) ? $val['rm_nickname'] : ''),
                'time'          => date('m-d H:i',$val['aic_time']),
            );
        }
        return $data;
    }

    
    public function informationLikeAction(){
        $uid = plum_app_user_islogin();
        if(!$uid){
            $this->outputError('请先授权');
        }
        $aid  = $this->request->getIntParam('aid');
        $like_model = new App_Model_Applet_MysqlAppletInformationLikeStorage($this->sid);
        // 是否已经点过赞
        $row = $like_model->getLikeByMidAid($uid,$aid);
        $info['data'] = array(
            'result' => true,
            'msg'    => '',
            'isLike' => 0,
        );
        $information_model = new App_Model_Applet_MysqlAppletInformationStorage($this->sid);

        // 已经点过赞
        if($row){
            $like_model->deleteById($row['ail_id']);
            $info['data']['msg'] = '取消成功';
            // 减少文章点赞数量
            $information_model->addReduceInformationNum($aid,'like','reduce');
            //$this->outputSuccess($info);
        }else{
            $data = array(
                'ail_s_id'   => $this->sid,
                'ail_m_id'   => $uid,
                'ail_ai_id'  => $aid,
                'ail_time'   => time(),
            );
            $like_model->insertValue($data);
            $info['data']['msg'] = '点赞成功';
            $info['data']['isLike'] = 1;
            // 增加文章点赞数量
            $information_model->addReduceInformationNum($aid,'like','add');


            //$this->outputSuccess($info);
        }
        //重新获得当前点赞数量 和点赞会员头像
        $row = $information_model->getRowById($aid);
        $info['data']['likeNum'] = $this->number_format($row['ai_like_num']);
        $info['data']['likeNumTrue'] = intval($row['ai_like_num']);
        $info['data']['likeAvatars'] = $this->_get_like_avatar($aid,$row['ai_like_num']);
        $this->outputSuccess($info);
    }

    
    public function _information_like($aid){
        $uid = plum_app_user_islogin();
        $num = 0;
        $like_model = new App_Model_Applet_MysqlAppletInformationLikeStorage($this->sid);
        // 是否已经点过赞
        $row = $like_model->getLikeByMidAid($uid,$aid);
        if($row){
            $num = 1;
        }
        return $num;
    }

    
    public function addShareAction(){
        $aid = $this->request->getIntParam('aid');
        if($aid){
            $information_model = new App_Model_Applet_MysqlAppletInformationStorage($this->sid);
            $ret = $information_model->addReduceInformationNum($aid,'share','add');
            if($ret){
                $info['data'] = array(
                    'result' => true,
                    'msg'    => '分享成功'
                );
                $this->outputSuccess($info);
            }else{
                $this->outputError('分享失败');
            }
        }else{
            $info['data'] = array(
                'result' => true,
                'msg'    => '分享成功'
            );
            $this->outputSuccess($info);
        }
        
    }

    
    private function _add_information_show_num($aid){
        $information_model = new App_Model_Applet_MysqlAppletInformationStorage($this->sid);
        $ret = $information_model->addReduceInformationNum($aid,'show','add');
    }

    
    public function customFormAction(){
        $id = $this->request->getIntParam('id');

        $form_model = new App_Model_Applet_MysqlCustomFormStorage();

        if(!$id){
            $where[] = array('name' => 'acf_s_id' , 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'acf_selected' , 'oper' => '=', 'value' => 1);
            $where[] = array('name' => 'acf_deleted' , 'oper' => '=', 'value' => 0);
            $row = $form_model->getRow($where);
        }else{
            $row = $form_model->getRowById($id);
        }

        $judgeImg = '';
        $memberMobile = '';
        if($this->applet_cfg['ac_type'] == 33 || $this->sid == 4546){
            $cfg_model = new App_Model_Car_MysqlCarCfgStorage($this->sid);
            $cfg = $cfg_model->findUpdateBySid();
            $judgeImg = $cfg['acc_judge_img'] ? $this->dealImagePath($cfg['acc_judge_img']) : '';
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $uid = plum_app_user_islogin();
            if($uid){
                $member = $member_model->getRowById($uid);
                $memberMobile = $member['m_mobile'] ? $member['m_mobile'] : '';
            }
        }

        if($row){
            $formData = json_decode($row['acf_data'],true);
            foreach ($formData as $key => $val){
                if($val['type'] == 'intro'){
                    $formData[$key]['data']['detail'] = plum_parse_img_path($val['data']['detail']);
                }else{
                    if($formData[$key]['data']['detail']){
                        unset($formData[$key]['data']['detail']);
                    }
                }
            }
            $info['data'] = array(
                'judgeImg' => $judgeImg,
                'memberMobile' => $memberMobile,
                'phone'    => $this->shop['s_phone'],
                'id'       => $row['acf_id'],
                'title'    => $row['acf_header_title'],
                'formData' => $formData
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('表单数据不存在');
        }
    }


    // 自定义表单中发送手机验证码
    // zhangzc
    // 2019-02-15
    public function submitFormAction(){
        $tplId  = $this->request->getIntParam('id');
        $data = $this->request->getStrParam('data');
        $carType = $this->request->getIntParam('carType');
        $carBrand = $this->request->getIntParam('carBrand');
        $formId=$this->request->getStrParam('formId');
        if($this->sid==11291 || $this->sid==10043){
            if(is_object($data)) {
                $array = (array)$data;
                Libs_Log_Logger::outputLog('1234567897979797878','test.log');
            }
            Libs_Log_Logger::outputLog($tplId,'test.log');
            Libs_Log_Logger::outputLog($array,'test.log');
            Libs_Log_Logger::outputLog($data,'test.log');
            Libs_Log_Logger::outputLog('这是支付提交的申请，这是支付提交的申请，这是支付提交的申请，这是支付提交的申请，这是支付提交的申请，这是支付提交的申请，这是支付提交的申请，这是支付提交的申请，','test.log');
        }
        // 获取json 数据中的用户手机号验证的相关信息
        // 2019-02-15
        // zhangzc
//        $mobile=$code=$timestamp=$signature='';
//        foreach (json_decode($data) as  $val) {
//            if($val->type=='verifyCode'){
//                $mobile=$val->value->mobile;
//                $code=$val->value->code;
//                $timestamp=$val->value->timestamp;
//                $signature=$val->value->signature;
//                $sms_model= new App_Plugin_Sms_UcpaasPlugin();
//                $verify_res=$sms_model->webSendVerify($mobile,$code,$timestamp,null,null,false);
//                if (!is_array($verify_res)) {
//                    $this->outputError($sms_model->verify_code_error[ $verify_res]);
//                }
//                if (!$signature || $signature != $verify_res['signature']) {
//                    $this->outputError("验证码不正确，请重新输入");
//                }
//                break;
//            }
//        }


        $data_model = new App_Model_Applet_MysqlCustomFormDataStorage();
        $uid = plum_app_user_islogin();
//        if(!$uid){
//            $this->outputError('请重新授权后重试');
//        }

        if(!$carBrand && $carType){
            $type_model = new App_Model_Car_MysqlCarBrandStorage();
            $type = $type_model->getRowById($carType);
            $carBrand = $type['ct_cb_id'];
        }

        $insert = array(
            'acfd_s_id' => $this->sid,
            'acfd_m_id' => $uid,
            'acfd_tpl_id' => $tplId,
            'acfd_data' => $data,
            'acfd_car_type' => $carType,
            'acfd_car_brand' => $carBrand,
            'acfd_create_time' =>time(),
            'acfd_form_id'     =>$formId,
        );
        $ret = $data_model->insertValue($insert);
        if($ret){
            //短信通知
            $sms_helper = new App_Helper_Sms($this->sid);
            $sms_helper->sendNoticeSms(array(), 'xcxyytz',$this->applet_cfg['ac_name']);

            $info['data'] = array(
                'result' => true,
                'msg'    => '提交成功'
            );
            $notice_model = new App_Helper_JiguangPush($this->sid);    //推送通知
            $notice_model->pushNotice($notice_model::LEAVING_MESSAGE);
            // 后台店铺消息
            $message_helper = new App_Helper_ShopMessage($this->sid);
            $message_helper->messageRecord($message_helper::LEAVING_MESSAGE);
            $this->outputSuccess($info);
        }else{
            $this->outputError('提交失败，请重试');
        }
    }


    
    public function fetchAgentSupportAction(){
        $row = $this->support;
        if($row && !empty($row)){
            $slide = array();
            if(isset($row['as_slide']) && $row['as_slide']){
                foreach (json_decode($row['as_slide'],true) as $value){
                    $slide[] = $this->dealImagePath($value['imgsrc']);
                }
            }
            $info['data'] = array(
                'headTitle'    => $row['as_head_title'] ? $row['as_head_title'] : '顶部标题',
                'name'         => $row['as_name'] ? $row['as_name'] : '公司/店铺名称',
                'mobile'       => $row['as_mobile'] ? $row['as_mobile'] : '130XXXXXXXX',
                'address'      => $row['as_address'] ? $row['as_address'] : '河南省郑州市郑东新区CBD商务内环11号',
                'lng'          => $row['as_lng'] ? $row['as_lng'] : '113.5',
                'lat'          => $row['as_lat'] ? $row['as_lat'] : '34.5',
                'content'      => plum_parse_img_path($row['as_content']),
                'slide'        => $slide,
                'open'         => $row['as_audit'],
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('暂未配置技术支持信息');
        }

    }

    
    public function suspensionMenuAction(){
        $suspensionMenu = $this->suspensionMenu;
        $indexMenu = $this->indexMenu;

        $about_model = new App_Model_Shop_MysqlShopAboutUsStorage($this->sid);
        $about_row   = $about_model->findUpdateBySid();

        $info['data']['suspensionMenuShow'] = $this->suspensionMenuShow;
        $info['data']['mobile'] = $about_row['sa_mobile'] ? $about_row['sa_mobile'] : $this->shop['s_phone'];
        $info['data']['nickname'] = '';
        $info['data']['city'] = '';
        $info['data']['indexUrl'] = '/pages/index/index';
        $uid = plum_app_user_islogin();
        if($uid){
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member = $member_storage->getRowById($uid);
            $info['data']['nickname'] = $member['m_nickname'];
            $info['data']['city'] = $member['m_city'];
        }
        if($suspensionMenu){
            $info['data']['suspensionMenu'] = $suspensionMenu;
            $info['data']['btnImg'] = $this->applet_cfg['ac_suspension_menu_img'] && isset($this->applet_cfg['ac_suspension_menu_img']) ? $this->dealImagePath($this->applet_cfg['ac_suspension_menu_img']) : '';
        }else{
            $info['data']['suspensionMenu'] = array();
        }
        if($indexMenu){
            $info['data']['indexMenu'] = $indexMenu;
        }else{
            $info['data']['indexMenu'] = array();
        }
        //获取设置的首页信息
        if($this->applet_cfg['ac_bottom_menu']){
            $bottom_menu = json_decode($this->applet_cfg['ac_bottom_menu'],true);  //反序列菜单数据
            $list_data = $bottom_menu['list'];
            if($list_data && !empty($list_data)){
                foreach ($list_data as $val){
                    if(isset($val['setIndex']) && $val['setIndex'] && $val['setIndex']==1){
                        $info['data']['indexUrl'] = '/'.$val['pagePath'];
                    }
                }
            }
        }
        $this->outputSuccess($info);
    }

    
    public function saveFormIdsAction(){
        $uid = plum_app_user_islogin();
        if($uid){
            $ids = $this->request->getStrParam('formIds');
            $formids_model = new App_Model_Member_MysqlMemberFormidsStorage($this->sid);
            $where[] = array('name' => 'af_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'af_m_id', 'oper' => '=', 'value' => $uid);
            $formids = $formids_model->getRow($where);
            if($formids){
                if($formids['af_ids'] == 'null' || !$formids['af_ids']){
                    $exist_ids = [];
                }else{
                    $exist_ids = json_decode($formids['af_ids'], true);
                }
                foreach($exist_ids as $key=>$val){
                    if($val['expire']<time()){
                        unset($exist_ids[$key]);
                    }
                }
                if(!$exist_ids){
                    $exist_ids = [];
                }
                $add_ids = json_decode($ids,true);
                if($add_ids){
                    $ids = array_merge($exist_ids, $add_ids);
                }
                $data = array('af_ids' => json_encode($ids), 'af_expire_time' => time() + (60*60*24*7));
                $formids_model->updateById($data, $formids['af_id']);
            }else{
                $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
                $member = $member_storage->getRowById($uid);
                $data = array(
                    'af_s_id' => $this->sid,
                    'af_m_id' => $uid,
                    'af_openid' => $member['m_openid'],
                    'af_ids' => $ids,
                    'af_expire_time' => time() + (60*60*24*7)
                );
                $formids_model->insertValue($data);
            }
        }
    }


    
    public function addressByLngLatAction(){
        $lng = $this->request->getStrParam('lng');
        $lat = $this->request->getStrParam('lat');
        if($lng && $lat){
            $data = $this->_get_address_by_lat_lng($lng,$lat);
            if($data){
                $info['data'] = $data;
                $this->outputSuccess($info);
            }else{
                $this->outputError('地址解析失败');
            }
        }else{
            $this->outputError('获取经纬度失败，请稍后重试');
        }
    }

    //七牛云视频上传
    public function advertisementCfgAction(){
        $setup_model = new App_Model_Applet_MysqlAppletAdvertisementStorage($this->sid);
        $row = $setup_model->findOneBySid();

        $info['data'] = array(
            'postListAdId'            => $row['aa_pl_id']?$row['aa_pl_id']:'',   //帖子列表广告id
            'postListAdOpen'          => $row['aa_pl_open']?$row['aa_pl_open']:0,//帖子列表广告开启
            'postDetailAdId'          => $row['aa_pd_id']?$row['aa_pd_id']:'',   //帖子详情广告id
            'postDetailAdOpen'        => $row['aa_pd_open']?$row['aa_pd_open']:0,//帖子详情广告开启
            'informationListAdId'     => $row['aa_il_id']?$row['aa_il_id']:'',   //资讯列表广告id
            'informationListAdOpen'   => $row['aa_il_open']?$row['aa_il_open']:0,//资讯列表广告开启
            'informationDetailAdId'   => $row['aa_id_id']?$row['aa_id_id']:'',   //资讯详情广告id
            'informationDetailAdOpen' => $row['aa_id_open']?$row['aa_id_open']:0,//资讯详情广告开启
            'tradePayAdId'            => $row['aa_tp_id']?$row['aa_tp_id']:'',   //订单支付完成广告id
            'tradePayAdOpen'          => $row['aa_tp_open']?$row['aa_tp_open']:0,//订单支付完成广告开启
            'shopListAdId'            => $row['aa_sl_id']?$row['aa_sl_id']:'',   //门店列表广告id
            'shopListAdOpen'          => $row['aa_sl_open']?$row['aa_sl_open']:0,//门店列表广告开启
            'limitAdId'               => $row['aa_wms_id']?$row['aa_wms_id']:'',   //秒杀首页广告id
            'limitAdOpen'             => $row['aa_wms_open']?$row['aa_wms_open']:0,//秒杀首页广告开启
            'bargainAdId'             => $row['aa_wkj_id']?$row['aa_wkj_id']:'',   //砍价首页广告id
            'bargainAdOpen'           => $row['aa_wkj_open']?$row['aa_wkj_open']:0,//砍价首页广告开启
            'groupAdId'               => $row['aa_wpt_id']?$row['aa_wpt_id']:'',   //拼团首页广告id
            'groupAdOpen'             => $row['aa_wpt_open']?$row['aa_wpt_open']:0,//拼团首页广告开启
            'prizeIndexAdId'          => $row['aa_prize_id']?$row['aa_prize_id']:'',   //抽奖页广告id
            'prizeIndexAdOpen'        => $row['aa_prize_open']?$row['aa_prize_open']:0,//抽奖页广告开启
            'mobileListAdId'          => $row['aa_dhbl_id']?$row['aa_dhbl_id']:'',   //电话本列表广告id
            'mobileListAdOpen'        => $row['aa_dhbl_open']?$row['aa_dhbl_open']:0,//电话本列表广告开启
            'mobileDetailAdId'        => $row['aa_dhbd_id']?$row['aa_dhbd_id']:'',   //电话本详情广告id
            'mobileDetailAdOpen'      => $row['aa_dhbd_open']?$row['aa_dhbd_open']:0,//电话本详情广告开启
            'subjectIndexAdId'        => $row['aa_dti_id']?$row['aa_dti_id']:'',   //答题首页广告id
            'subjectIndexAdOpen'      => $row['aa_dti_open']?$row['aa_dti_open']:0,//答题首页广告开启
            'subjectAlertAdId'        => $row['aa_dta_id']?$row['aa_dta_id']:'',   //答题提示页广告id
            'subjectAlertAdOpen'      => $row['aa_dta_open']?$row['aa_dta_open']:0,//答题提示页广告开启
            'payShortAdId'            => $row['aa_ps_id']?$row['aa_ps_id']:'',   //收银台广告id
            'payShortAdOpen'          => $row['aa_ps_open']?$row['aa_ps_open']:0,//收银台广告开启
            'businessCardAdId'        => $row['aa_mpj_id']?$row['aa_mpj_id']:'',   //我的名片页id
            'businessCardAdOpen'      => $row['aa_mpj_open']?$row['aa_mpj_open']:0,//我的名片页开启
            'pointGoodsAdId'          => $row['aa_pg_id']?$row['aa_pg_id']:'',   //积分商城广告id
            'pointGoodsAdOpen'        => $row['aa_pg_open']?$row['aa_pg_open']:0,//积分商城广告开启
            'gameRecommendAdId'       => $row['aa_game_recommend_id']?$row['aa_game_recommend_id']:'',   //游戏推荐列表页id
            'gameRecommendAdOpen'     => $row['aa_game_recommend_open']?$row['aa_game_recommend_open']:0,//游戏推荐列表页广告开启
            'gameRankAdId'            => $row['aa_game_rank_id']?$row['aa_game_rank_id']:'',   //游戏排行榜id
            'gameRankAdOpen'          => $row['aa_game_rank_open']?$row['aa_game_rank_open']:0,//游戏排行榜广告开启
            'gameLotteryAdId'         => $row['aa_game_lottery_id']?$row['aa_game_lottery_id']:'',   //游戏抽奖页id
            'gameLotteryAdOpen'       => $row['aa_game_lottery_open']?$row['aa_game_lottery_open']:0,//游戏抽奖页开启
            'gameTaskAdId'            => $row['aa_game_task_id']?$row['aa_game_task_id']:'',   //游戏任务页id
            'gameTaskAdOpen'          => $row['aa_game_task_open']?$row['aa_game_task_open']:0,//游戏任务页开启

            'jobIndexAdId'            => $row['aa_job_index_id']?$row['aa_job_index_id']:'',   //内推首页id
            'jobIndexAdOpen'          => $row['aa_job_index_open']?$row['aa_job_index_open']:0,//内推首页开启
            'jobListAdId'            => $row['aa_job_list_id']?$row['aa_job_list_id']:'',   //内推职位列表页id
            'jobListAdOpen'          => $row['aa_job_list_open']?$row['aa_job_list_open']:0,//内推职位列表页开启
            'jobDetailAdId'            => $row['aa_job_detail_id']?$row['aa_job_detail_id']:'',   //内推职位详情页id
            'jobDetailAdOpen'          => $row['aa_job_detail_open']?$row['aa_job_detail_open']:0,//内推职位详情页开启
            'jobResumeAdId'            => $row['aa_job_resume_id']?$row['aa_job_resume_id']:'',   //内推简历大厅页id
            'jobResumeAdOpen'          => $row['aa_job_resume_open']?$row['aa_job_resume_open']:0,//内推简历大厅页开启'
            'zdhbAdId'            => $row['aa_zdhb_id']?$row['aa_zdhb_id']:'',   //组队红包页id
            'zdhbAdOpen'          => $row['aa_zdhb_open']?$row['aa_zdhb_open']:0,//组队红包页开启
            'prizeBaiduId'          => $row['aa_prize_baidu_id']?$row['aa_prize_baidu_id']:'',   //抽奖页百度应用id
            'dhblBaiduId'          => $row['aa_dhbl_baidu_id']?$row['aa_dhbl_baidu_id']:'',   //电话本列表百度应用id
            'ilBaiduId'          => $row['aa_il_baidu_id']?$row['aa_il_baidu_id']:'',   //资讯列表百度应用id
            'idBaiduId'          => $row['aa_id_baidu_id']?$row['aa_id_baidu_id']:'',   //资讯详情id
            'dhbdBaiduId'          => $row['aa_dhbd_baidu_id']?$row['aa_dhbd_baidu_id']:'',   //电话本详情百度应用id
            'psBaiduId'          => $row['aa_ps_baidu_id']?$row['aa_ps_baidu_id']:'',   //收银台百度应用id
        );

        $this->outputSuccess($info);
    }


    
    public function blessingCfgAction(){
        $blessingId = $this->request->getIntParam('blessingId');
        $mid = $this->request->getIntParam('mid');
        $blessingMusic = plum_parse_config('blessingMusic','system');
        if($mid){
            $uid = $mid;
        }else{
            $uid = plum_app_user_islogin();
        }
        if($uid){
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member = $member_storage->getRowById($uid);
        }

        $festival = plum_parse_config('festival','blessing');
        $cover = plum_parse_config('cover','blessing');
        $music = plum_parse_config('music','blessing');
        $festival_keys = array_keys($festival);
        $data = array(
            'shopName'        => $this->shop['s_name'],
            'shopLogo'        => isset($this->shop['s_logo']) && $this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_200_200.png'),
            'defaultName'     => plum_parse_config('defaultName','system'),
            'defaultContent'  => plum_parse_config('defaultContent','system'),
            'blessingName'    => '',
            'blessingContent' => '',
            'music'           => $blessingMusic[rand(1,5)],
            'blessNickname'   => isset($member['m_nickname']) && $member['m_nickname'] ? $member['m_nickname'] : $this->shop['s_name'],
            'blessAvatar'     => isset($member['m_avatar']) && $member['m_avatar'] ? $this->dealImagePath($member['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
            'blessingId'      => 0,

        );

        // 获取店铺设置的祝福语
        $blessing_storage = new App_Model_Blessing_MysqlBlessingCfgStorage($this->sid);
        $cfg = $blessing_storage->findUpdateBySid();
        if($cfg){
            $data['defaultName']    = $cfg['abc_blessing_title'];
            $data['defaultContent'] = $cfg['abc_blessing'];
            $data['music']          = $cfg['abc_music'];
        }
        //获得节日key和名称
//        $festival_key = $cfg['abc_festival'] ? $cfg['abc_festival'] : $festival_keys[0];
        $festival_key = $cfg['abc_festival'] ? $cfg['abc_festival'] : 'ldj';
        $data['festival'] = $festival[$festival_key];
        $data['title'] = $festival[$festival_key].'祝福';
        //背景图
        $data['cover'] = $cfg['abc_cover'] ? $this->dealImagePath($cfg['abc_cover']) : $this->dealImagePath($cover[$festival_key][0]['url']);
//        $data['cover'] = $this->dealImagePath('/public/wxapp/blessing/images/background/cj/bg_01.gif');
        //背景音乐
        $music_arr = $music[$festival_key];
        $data['music'] = $cfg['abc_music'] ? $cfg['abc_music'] : $music_arr[rand(1,count($music_arr))]['url'];

        if($blessingId){
            //根据祝福语id获取一条对应的祝福语
            $blessingList_storage = new App_Model_Blessing_MysqlBlessingListStorage($this->sid);
            $blessing = $blessingList_storage->findRowByBlessingId($blessingId);
            if($blessing){
                $data['blessNickname']   = $blessing['m_nickname'] ? $blessing['m_nickname'] : $this->shop['s_name'];
                $data['blessAvatar']     = $blessing['m_avatar'] ? $this->dealImagePath($blessing['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
                $data['blessingName']    = $blessing['abl_name'];
                $data['blessingContent'] = $blessing['abl_content'];
                $data['blessingId']      = $blessing['abl_id'];
            }
        }else{
            //获取最后一条获取到的最新的祝福设置
            $blessingList_storage = new App_Model_Blessing_MysqlBlessingListStorage($this->sid);
            $row = $blessingList_storage->findRowBySidMid($uid);
            if($row){
                $data['blessingName']    = $row['abl_name'];
                $data['blessingContent'] = $row['abl_content'];
                $data['blessNickname']   = $row['m_nickname'] ? $row['m_nickname'] : $this->shop['s_name'];
                $data['blessAvatar']     = $row['m_avatar'] ? $this->dealImagePath($row['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
                $data['blessingId']      = $row['abl_id'];
            }
        }
        $this->outputSuccess(array('data'=>$data));
    }

    
    public function saveBlessingAction(){
        $name = $this->request->getStrParam('name');
        $content = $this->request->getStrParam('content');
        $uid = plum_app_user_islogin();
        if($uid){
            if($name && $content){
                $data = array(
                    'abl_s_id'        => $this->sid,
                    'abl_m_id'        => $uid,
                    'abl_name'        => $name,
                    'abl_content'     => $content,
                    'abl_create_time' => time()
                );
                $blessingList_storage = new App_Model_Blessing_MysqlBlessingListStorage($this->sid);
                $ret = $blessingList_storage->insertValue($data);
                if($ret){
                    $info['data'] = array(
                        'result' => true,
                        'blessingId' => $ret,
                    );
                    $this->outputSuccess($info);
                }else{
                    $this->outputError('网络错误请重试');
                }
            }else{
                $this->outputError('请将信息填写完整');
            }
        }else{
            $this->outputError('请先授权后再试');
        }
    }

    
    public function blessingShareAction(){
        $mid = $this->request->getIntParam('mid');
        $id  = $this->request->getIntParam('id');
        $params = array(
            'sid' => $this->sid,
            'mid' => $mid,
            'id'  => $id
        );
        $shareImg = App_Helper_SharePoster::generateSharePoster('blessingShare', $params);
        $info['data'] = array(
            'shareImg' => $this->dealImagePath($shareImg)
        );
        $this->outputSuccess($info);
    }


    
    private function _format_wifi($val,$isDetail = false){
        if($val){
            $data = [
                'id' => $val['acw_id'],
                'ssid' => $val['acw_ssid'],
                'bssid' => $val['acw_bssid'],
                'password' => $val['acw_password'] ? $val['acw_password'] : '',
                'brief' => $val['acw_brief'] ? $val['acw_brief'] : '',
                'time' => $val['acw_update_time'] ? date('Y-m-d H:i',$val['acw_update_time']) : date('Y-m-d H:i',$val['acw_create_time']),
                'qrcode' => $val['acw_applet_code'] ? $this->dealImagePath($val['acw_applet_code'],true) : ''
            ];
//            if($isDetail){
//                $data['qrcode'] =
//            }

            return $data;
        }
        return false;
    }

    
    public function waterMarkAction(){

        $info['data']['supportOpen']   = $this->support && isset($this->support['as_audit']) ? intval($this->support['as_audit']) : 0;
        $info['data']['openWatermark'] = $this->openWatermark;

        if($this->appletType == 4){
            $default_wartermark = plum_parse_config('default_wartermark','agent');
            $level = App_Helper_Agent::checkShopAgentLevel($this->sid);

            switch ($level){
                case 1:
                case 5:
                case 2:
                    $info['data']['watermark']     = '';
                    $info['data']['watermarkImg']  = $this->dealImagePath($default_wartermark['logo']);
                    break;
                case 3:
                    $info['data']['watermark']     = $this->watermark;
                    $info['data']['watermarkImg']  = $this->dealImagePath($default_wartermark['logo']);
                    break;
                case 4:
                    $info['data']['watermark']     = $this->watermark;
                    $info['data']['watermarkImg']  = $this->watermarkImg;
                    break;
                default:
                    $info['data']['watermark']     = '';
                    $info['data']['watermarkImg']  = $this->dealImagePath($default_wartermark['logo']);
            }

            if($this->applet_cfg['ac_type'] == 1){
//                $info['data']['watermark']     = '';
                //任何等级的代理商基础商城都只有固定的logo
                $info['data']['watermarkImg']  = $this->dealImagePath($default_wartermark['logo']);
            }

          
        }else{
            $info['data']['watermark']     = $this->watermark;
            $info['data']['watermarkImg']  = $this->watermarkImg;
        }



        $info['data']['supportMobile'] = $this->support && isset($this->support['as_mobile']) ? $this->support['as_mobile'] : '';
		$info['data']['watermark'] = '';
      $info['data']['openWatermark'] = '';
        $this->outputSuccess($info);
    }

    
    public function appletErrorLogAction(){
        $brand       = $this->request->getStrParam('brand');
        $model       = $this->request->getStrParam('model');
        $wxVersion   = $this->request->getStrParam('wxVersion');
        $system      = $this->request->getStrParam('system');
        $SDKVersion  = $this->request->getStrParam('SDKVersion');
        $suid        = $this->request->getStrParam('suid');
        $appid       = $this->request->getStrParam('appid');
        $type        = $this->request->getStrParam('type');
        $error       = $this->request->getStrParam('error');
        $currentPage = $this->request->getStrParam('currentPage');

        $log_model  = new App_Model_Applet_MysqlAppletErrorLogStorage();

        $data = array(
            'ael_suid'         => $suid,
            'ael_appid'        => $appid,
            'ael_brand'        => $brand,
            'ael_model'        => $model,
            'ael_wx_version'   => $wxVersion,
            'ael_system'       => $system,
            'ael_sdk_version'  => $SDKVersion,
            'ael_error'        => $error,
            'ael_type'         => $type,
            'ael_current_page' => $currentPage,
            'ael_create_time'  => time()
        );

        $log_model->insertValue($data);
    }


       //获取省市区
       public function getareaAction(){
        $address_model = new App_Model_Address_MysqlAddressCoreStorage();
        //$where[]       = array('name'=>'parent_id','oper'=>'=','value'=>$id);
        $where[]       = array('name'=>'region_type','oper'=>'=','value'=>1);
        $list          = $address_model->getList($where,0,0,array());
        foreach ($list as $val){
            $where = array();
            $where[]       = array('name'=>'parent_id','oper'=>'=','value'=>$val['region_id']);
            $where[]       = array('name'=>'region_type','oper'=>'=','value'=>2);
            $city_list     = $address_model->getList($where,0,0,array());
            $city          = array();
            foreach($city_list as $v){
                $where  = array();
                $where[]       = array('name'=>'parent_id','oper'=>'=','value'=>$v['region_id']);
                $where[]       = array('name'=>'region_type','oper'=>'=','value'=>3);
                $area_list     = $address_model->getList($where,0,0,array());
                $area          = array();
                foreach ($area_list as $vv){
                    $area[] = array(
                        'id'   => $vv['region_id'],
                        'name' => $vv['region_name']
                    );
                }
                $city[] = array(
                    'id'   => $v['region_id'],
                    'name' => $v['region_name'],
                    'area' => $area,
                );
            }
            $info['pro'][] = array(
                'id'   => $val['region_id'],
                'name' => $val['region_name'],
                'city' => $city
            );
        }
        if($list){
            $this->outputSuccess($info);
        }else{
            $this->displayJsonError('没有数据');
        }
    }



}