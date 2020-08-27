<?php


class App_Controller_Applet_CityAuthController extends App_Controller_Applet_InitController {

    public function __construct() {
        parent::__construct();
    }

    
    private function _post_top_pay($topTime,$tid){
        $pay = array(
            'dataArray' => array(),
            'msg'       => '',
        );
        //判断是否填写小程序端的微信支付配置
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();
        if(!$appcfg){
            $pay['msg'] = '该商户暂未填写微信支付配置';
        }
        $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->sid);
        $cost = $cost_storage->findRowByActid($topTime);
        if($cost && $cost['act_cost']>0){
            $money = floatval($cost['act_cost']);
        }else{
            $topCfg = plum_parse_config('top_time','applet');
            $money = floatval($topCfg[$topTime]['amount']);
        }
        if($money>0){
            if($tid){
                $body   = $this->shop['s_name']."发帖置顶";
                $openid     = $this->member['m_openid'];
                $pay_storage = new App_Plugin_Weixin_NewPay($this->sid);
                $notify_url = $this->response->responseHost().'/mobile/wxpay/appletCityPostTop';//回调地址
                $attach = array(
                    'suid'  => $this->shop['s_unique_id'],
                    'mid'   => $this->member['m_id'],
                );
                $other      = array(
                    'attach'    => json_encode($attach),
                );
                // 生成支付参数
                $result = $pay_storage->appletOrderPayRecharge($money,$openid,$tid,$notify_url,$body,$other);
                Libs_Log_Logger::outputLog($result);
                if (is_array($result)) {
                    $params = array(
                        'appId'     => $result['appid'],
                        'timeStamp' => strval(time()),
                        'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                        'package'   => "prepay_id={$result['prepay_id']}",
                        'signType'  => 'MD5',
                    );
                    $params['paySign']  = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $result['app_key']);
                    $pay['dataArray'] = $params;
                } else{
                    $pay['msg'] = '支付错误，请稍后重试';
                }
            }else{
                $pay['msg'] = '支付错误，请重试';
            }
        }else{
            $post_model = new App_Model_City_MysqlCityPostStorage($this->shop['s_id']);
            $record = $post_model->findUpdateByNumber($tid);
            $topTime = $record['acp_top_date']*60*60*24;
            $set = array(
                'acp_istop' => 1,
                'acp_istop_expiration' => time()+$topTime,
                'acp_pay_time'  => time()
            );
            $post_model->findUpdateByNumber($tid,$set);
            $pay['msg'] = '置顶成功';
        }
        return $pay;
    }

    
    private function _save_post_img($images,$acpId){
        if(is_array($images) && !empty($images)){
            $insert = array();
            $imagesData = array();
            foreach($images as $key=>$val){
                if($key<9 && $val && $val!=' '){
                    $insert[] =  " (NULL, '{$val}','{$acpId}','{$this->sid}','{$this->member['m_id']}', '0', '".time()."') ";
                    $imagesData[] = $val;
                }
            }
            if(!empty($insert)){
                $attachment_model = new App_Model_City_MysqlCityPostAttachmentStorage($this->sid);
                $ret = $attachment_model->insertBatch($insert);
                if(!empty($imagesData) && $ret){
                    $imgData = json_encode($imagesData);
                    //检查图片是否存在违法
                    plum_open_backend('post','checkImg',array('imgdata'=>rawurlencode($imgData),'sid'=>$this->sid,'id'=>$acpId));
                    //添加图片水印，需控制（从App_Controller_Wxapp_CityController的showIndexTpl方法复制）
                    $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->sid);
                    $tpl  = $tpl_model->findUpdateBySid(23);
                    if($tpl['aci_open_water_mark']){
                        plum_open_backend('post','addWatermark',array('imgdata'=>rawurlencode($imgData),'sid'=>$this->sid));
                    }
                }
            }
        }
    }

    
    private function save_post_record($postPrice){
        $memberPost_Model = new App_Model_City_MysqlCityMemberPostStorage($this->sid);
        $row = $memberPost_Model->findUpdateByMid($this->uid);
        if($row){
            $tdate = strtotime(date('Y-m-d',time()));
            if($postPrice>0){
                if($row['acm_pay_time']>$tdate){
                    $data['acm_pay_num'] = $row['acm_pay_num'] + 1;
                }else{
                    $data['acm_pay_num'] = 1;
                }
                $data['acm_pay_time'] = time();
            }else{
                if($row['acm_free_time']>$tdate){
                    $data['acm_free_num'] = $row['acm_free_num'] + 1;
                }else{
                    $data['acm_free_num'] = 1;
                }
                $data['acm_free_time'] = time();
            }
            $ret = $memberPost_Model->findUpdateByMid($this->uid,$data);
        }else{
            $data  = array(
                'acm_s_id' => $this->sid,
                'acm_mid'  => $this->uid,
                'acm_free_num'    => $postPrice>0 ? 0 : 1,
                'acm_free_time'   => $postPrice>0 ? 0 : time(),
                'acm_pay_num'     => $postPrice>0 ? 1 : 0,
                'acm_pay_time'    => $postPrice>0 ? time() : 0,
                'acm_create_time' => time()
            );
            $ret = $memberPost_Model->insertValue($data);
        }
    }

    private function _get_article_info($url){
        $content = file_get_contents($url);
        $content_html_pattern = '/msg_title = "(.*?)";/s';
        preg_match($content_html_pattern, $content, $title_matchs);
        if($title_matchs[1]){
            $title = $title_matchs[1];
        }
        $content_html_pattern = '/<div class="rich_media_content ".*?id="js_content".*?>(.*?)<\/div>/s';
        preg_match($content_html_pattern, $content, $content_matchs);
        if($content_matchs[1]){
            $article_content = str_replace('data-src', 'src', $content_matchs[1]);
        }

        $content_html_pattern = '/<iframe.*?data-src=[\'|"].*?vid=(.*?)&amp;.*?><\/iframe>/s';
        preg_match($content_html_pattern, $content, $vid_matchs);
        if(!$vid_matchs[1]){
            $content_html_pattern = '/<iframe.*?src=[\'|"].*?vid=(.*?)[\'|"]><\/iframe>/s';
            preg_match($content_html_pattern, $content, $vid_matchs);
        }
        if($vid_matchs[1]){
            $vid = $vid_matchs[1];
            $videoInfo = array(
                'real_url' => $vid,
                'cover' => "https://puui.qpic.cn/qqvideo_ori/0/".$vid."_496_280/0"
            );
            $videoUrl = $videoInfo['real_url'];
            $videoCover = $videoInfo['cover'];
        }

        $content_html_pattern = '/msg_cdn_url = "(.*?)";/s';
        preg_match($content_html_pattern, $content, $cover_matchs);
        if($cover_matchs[1]){
            $cover = $cover_matchs[1];
        }

        if($title && $cover && $article_content){
            return array(
                'title' => $title,
                'cover' => $cover,
                'content' => $article_content,
                'video' => $videoUrl,
                'videoCover' => $videoCover
            );
        }else{
            $this->outputError('公众号文章获取失败');
        }
    }

    //抓取腾讯视频地址
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
            return array(
                'real_url' => $vid,
                'cover' => "https://puui.qpic.cn/qqvideo_ori/0/".$vid."_496_280/0"
            );
        }else{
            $this->outputError('获取腾讯视频失败');
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


    
    private function _get_redbag_data($money, $num, $isAvg){
        if($isAvg){ //普通红包
            $data = array();
            for($i=0; $i<$num;$i++){
                $data[] = number_format($money/$num,2, ".", "");
            }
            return $data;
        }else{  //随机红包
            $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->sid);
            $tpl = $tpl_model->findUpdateBySid();
            $minMoney = $tpl['aci_single_min'] > 0?$tpl['aci_single_min']:0.01;
            if($money < $num*$minMoney) {
                $this->outputError('红包金额输入不正确');
            }

            $rand_arr = array();
            for($i=0; $i<$num; $i++) {
                $rand = rand(1, 100);
                $rand_arr[] = $rand;
            }

            $rand_sum = array_sum($rand_arr);
            $rand_money_arr = array();
            $rand_money_arr = array_pad($rand_money_arr, $num, $minMoney);  //保证每个红包至少0.01

            foreach ($rand_arr as $key => $r) {
                $rand_money = number_format($money*$r/$rand_sum, 2, ".", "");

                if($rand_money <= $minMoney || number_format(array_sum($rand_money_arr), 2, ".", "") >= number_format($money, 2, ".", "")) {
                    $rand_money_arr[$key] = $minMoney;
                } else {
                    $rand_money_arr[$key] = $rand_money;
                }

            }

            $max_index = $max_rand = 0;
            foreach ($rand_money_arr as $key => $rm) {
                if($rm > $max_rand) {
                    $max_rand = $rm;
                    $max_index = $key;
                }
            }

            unset($rand_money_arr[$max_index]);
            //这里的array_sum($rand_money_arr)一定是小于$money_total的
            $rand_money_arr[$max_index] = number_format($money - array_sum($rand_money_arr), 2, ".", "");

            ksort($rand_money_arr);
            return $rand_money_arr;
        }
    }

    
    public function receiveRedbagAction(){
        $pid = $this->request->getIntParam('pid');
        $password = $this->request->getStrParam('password');
        $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
        $post = $post_model->getRowById($pid);
        if($post['acp_isRedbag']){
            if($post['acp_refund_time'] && $post['acp_refund_time']<time()){
                $this->outputError('红包已过期');
            }
            $num = intval($post['acp_redbag_num']) - intval($post['acp_receive_num']);
            $receive_model = new App_Model_City_MysqlCityRedbagReceiveStorage($this->sid);
            $receive = $receive_model->hadReceive($pid, $this->uid);
            if(!$receive){
                if(($post['acp_redbag_password'] && $password==$post['acp_redbag_password']) || !$post['acp_redbag_password']){
                    if($post['acp_redbag_balance']>0 && $num>0){
                        $money = json_decode($post['acp_redbag_data'], true)[$post['acp_receive_num']];
                        $set = array(
                            'acp_redbag_balance' => $post['acp_redbag_balance'] - $money,
                            'acp_receive_num'    => intval($post['acp_receive_num']) + 1,
                        );
                        $post_model->updateById($set, $pid);
                        //增加会员同城账户的余额
                        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                        $mset = array(
                            'm_deduct_ktx' => $this->member['m_deduct_ktx'] + $money
                        );
                        $member_model->updateById($mset, $this->uid);
                        //记录领取记录
                        $insert = array(
                            'acrr_s_id' => $this->sid,
                            'acrr_m_id' => $this->uid,
                            'acrr_post_id' => $pid,
                            'acrr_post_balance' => number_format($post['acp_redbag_balance'] - $money, 2),
                            'acrr_money' => $money,
                            'acrr_create_time' => time()
                        );
                        $receive_model->insertValue($insert);
                        $balance = $post['acp_redbag_balance'] - $money;
                        $info['data'] = array(
                            'result' => true,
                            'money'  => floatval($money),
                            'receiveNum' => $post['acp_receive_num'] + 1,
                            'balance' => floatval($balance),
                            'msg'    => '恭喜您，领取到'.$money.'元红包'
                        );
                        if(($post['acp_redbag_balance']) - $money <=0){
                            $applet_redis = new App_Model_Applet_RedisAppletStorage($this->sid);
                            $applet_redis->deleteRedbagTask($pid);
                        }
                        $this->outputSuccess($info);
                    }else{
                        $this->outputError('红包已经领完了');
                    }
                }else{
                    $this->outputError('口令有误，请重新输入');
                }
            }else{
                $this->outputError('你已经领取过了');
            }
        }else{
            $this->outputError('本帖不是红包帖');
        }
    }

    
    public function postLikeAction(){
        $pid  = $this->request->getIntParam('pid');
        $like_model = new App_Model_City_MysqlCityPostLikeStorage($this->sid);
        // 是否已经点过赞
        $row = $like_model->getLikeByMidPid($this->member['m_id'],$pid);
        $info['data'] = array(
            'result' => true,
            'msg'    => ''
        );
        // 已经点过赞
        if($row){
            $like_model->deleteById($row['apl_id']);
            $info['data']['msg'] = '取消成功';
            $info['data']['likeList'] = $this->_fetch_post_like($pid);
            // 减少帖子点赞数量
            $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
            $post_model->addReducePostNum($pid,'like','reduce');
            $this->outputSuccess($info);
        }else{
            $data = array(
                'apl_s_id'   => $this->sid,
                'apl_m_id'   => $this->member['m_id'],
                'apl_acp_id' => $pid,
                'apl_time'   => time()
            );
            $ret = $like_model->insertValue($data);
            $info['data']['msg'] = '点赞成功';
            $info['data']['likeList'] = $this->_fetch_post_like($pid);
            // 增加帖子点赞数量
            $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
            $post_model->addReducePostNum($pid,'like','add');

            if($this->sid == 4546){
                Libs_Log_Logger::outputLog('appletType1:'.$this->appletType,'test.log');
            }

            plum_open_backend('index', 'wxappTempl', array('sid' => $this->sid,'applet' => 6, 'tid' => $ret, 'type' => App_Helper_WxappApplet::SEND_SETUP_LIKE,'appletType'=> $this->appletType));


            $this->outputSuccess($info);
        }
    }
    
    private function _fetch_post_like($pid){
        $like_model = new App_Model_City_MysqlCityPostLikeStorage($this->sid);
        $likeList = $like_model->getLikeMemberList($pid);
        $data = array();
        if($likeList){
            foreach ($likeList as $val){
                if($val['m_avatar']){
                    $data['avatar'][] = $this->dealImagePath($val['m_avatar']);
                }
                if($val['m_nickname']){
                    $data['nickname'][] = $val['m_nickname'];
                }
            }
        }
        return $data;
    }

    
    public function deletedPostCommentAction(){
        $cid = $this->request->getIntParam('cid');  // 评论ID
        if($cid){
            $comment_model = new App_Model_City_MysqlCityPostCommentStorage($this->sid);
            $row = $comment_model->getRowById($cid);
            if($row && $row['acc_m_id'] == $this->uid){
                $ret = $comment_model->deleteById($cid);
                if($ret){
                    // 减去帖子评论数量
                    $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
                    $post_model->addReducePostNum($row['acc_acp_id'],'comment','reduce');
                    $info['data'] = array(
                        'result' => true,
                        'msg'    => '删除成功'
                    );
                    $this->outputSuccess($info);
                }else{
                    $this->outputError('删除失败');
                }
            }else{
                $this->outputError('只能删除自己的评论哦');
            }
        }else{
            $this->outputError('删除失败');
        }
    }

    
    public function deletePostAction(){
        $pid = $this->request->getIntParam('pid');
        if($pid){
            $where = array();
            $where[] = array('name'=>'acp_id','oper'=>'=','value'=>$pid);
            $where[] = array('name'=>'acp_m_id','oper'=>'=','value'=>$this->uid);
            $where[] = array('name'=>'acp_s_id','oper'=>'=','value'=>$this->sid);
            $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
            $set = array('acp_deleted'=>1);
            $ret = $post_model->updateValue($set,$where);
            if($ret){
                $info['data'] = array(
                    'result' => true,
                    'msg'    => '删除成功',
                );
                $this->outputSuccess($info);
            }else{
                $this->outputError('删除失败');
            }
        }else{
            $this->outputError('删除失败,请重试');
        }
    }

    
    public function postCollectionAction(){
        $pid  = $this->request->getIntParam('pid');
        $collection_model = new App_Model_City_MysqlCityPostCollectionStorage($this->sid);
        // 是否已经收藏过
        $row = $collection_model->getCollectionByMidPid($this->member['m_id'],$pid);
        $info['data'] = array(
            'result' => true,
            'msg'    => ''
        );
        // 已收藏
        if($row){
            $collection_model->deleteById($row['acc_id']);
            $info['data']['msg'] = '取消成功';
            $this->outputSuccess($info);
        }else{
            $data = array(
                'acc_s_id'   => $this->sid,
                'acc_m_id'   => $this->member['m_id'],
                'acc_acp_id' => $pid,
                'acc_time'   => time()
            );
            $collection_model->insertValue($data);
            $info['data']['msg'] = '收藏成功';
            // 收藏获取积分
            $point_storage = new App_Helper_Point($this->sid);
            $point_storage->gainPointBySource($this->uid,App_Helper_Point::POINT_SOURCE_COLLECTION);
            $this->outputSuccess($info);
        }
    }

    
    private function _shop_apply_payment($id,$category){
        $data = array(
            'need' => 0,    // 是否需要收费：0不需要，1需要
            'msg'  => '',
        );
        $apply_storage = new App_Model_City_MysqlCityShopApplyStorage($this->sid);

        $cate_model = new App_Model_City_MysqlCityPostCategoryStorage($this->sid);
        $row = $cate_model->getRowById($category);
        // 如果需要支付费用
        if($row && $row['acc_price']>0){
            // 生成订单编号
            $number = App_Plugin_Weixin_NewPay::makeMchOrderid($this->sid);
            $updata = array(
                'acs_number' => $number,
                'acs_price'  => $row['acc_price'],
            );
            $apply_storage->updateById($updata,$id);
            //判断是否填写小程序端的微信支付配置
            $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
            $appcfg = $appletPay_Model->findRowPay();
            if(!$appcfg){
                $data['msg'] = '该商户暂未填写微信支付配置';
            }
            $pay_type_storage    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
            $payType = $pay_type_storage->findRowPay();
            if(!$payType || ($payType && $payType['pt_wxpay_applet']==0)){
                $this->outputError('该店铺暂未开启微信支付');
            }

            $body   = $this->shop['s_name']."申请入驻";
            $openid     = $this->member['m_openid'];
            $pay_storage = new App_Plugin_Weixin_NewPay($this->sid);
            $notify_url = $this->response->responseHost().'/mobile/wxpay/appletCityApply';//回调地址
            $attach = array(
                'suid'  => $this->shop['s_unique_id'],
                'mid'   => $this->member['m_id'],
            );
            $other      = array(
                'attach'    => json_encode($attach),
            );
            // 生成支付参数
            $result = $pay_storage->appletOrderPayRecharge($row['acc_price'],$openid,$number,$notify_url,$body,$other);
            Libs_Log_Logger::outputLog($result);
            if (is_array($result)) {
                $params = array(
                    'appId'     => $result['appid'],
                    'timeStamp' => strval(time()),
                    'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                    'package'   => "prepay_id={$result['prepay_id']}",
                    'signType'  => 'MD5',
                );
                $params['paySign']  = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $result['app_key']);
                $data['dataArray'] = $params;
                $data['msg'] = '申请入驻成功，请等待管理员审核';
            }else{
                $data['msg'] = '支付错误，请稍后重试';
            }
            $data['need'] = 1;
        }else{
            // 如果不需要支付则直接支付成功
            $updata = array(
                'acs_pay_status' => 1
            );
            $apply_storage->updateById($updata,$id);
            $data['msg'] = '申请入驻成功，请等待管理员审核';
        }
        return $data;
    }

    
    public function submitPostPayAction(){
        $categoryId = $this->request->getIntParam('categoryId',0);
        $secondId   = $this->request->getIntParam('secondId',0);
        $istop = $this->request->getIntParam('istop',0);    // 是否置顶 ： 0不置顶，1置顶
        $topTime = $this->request->getIntParam('topTime');  // 置顶时间
        $redbagMoney = $this->request->getFloatParam('money'); //红包金额
        $serviceMoney = $this->request->getFloatParam('serviceMoney'); //服务费
        $payType = $this->request->getIntParam('payType',1); //支付方式  1在线支付  3余额支付  4百度支付
        $appid = $this->request->getStrParam('appid');
        $dateId = $this->request->getIntParam('dateId',0);
        $type   = $this->request->getStrParam('type'); //post 发帖, top单独置顶, shop 入驻
        $postType    = $this->request->getIntParam('postType', 1); //帖子类型 1图文 2文章 3短视频
        $videoType   = $this->request->getIntParam('videoType', 1); //视频类型  1本地上传 2腾讯视频
        $videoUrl    = $this->request->getStrParam('videoUrl'); //视频地址
        $articleUrl  = $this->request->getStrParam('articleUrl'); //公众号文章地址
        $mobile   = $this->request->getStrParam('mobile');  // 手机号
        $version  = $this->request->getStrParam('version');   // 版本号
        $town  = $this->request->getIntParam('town');  // 51同镇所属乡镇id
        $isPlugin = $this->request->getIntParam('isPlugin');//插件
        $weixin_appid = $this->request->getStrParam('weixin_appid','');

        // H5支付未传递公众号的appid的时候手动获取一下
        // zhangzc
        // 2019-10-25
        if(empty($weixin_appid) && $this->appletType == 5){
            $appletPay_Model = new App_Model_Weixin_MysqlWeixinCfgStorage($this->sid);
            $weixin_cfg=$appletPay_Model->getRow([
                ['name'=>'ac_s_id','oper'=>'=','value'=>$this->sid]
            ],['ac_appid']);
            if($weixin_cfg){
                $weixin_appid=$weixin_cfg['ac_appid'];
            }else{
                $this->outputError('微信appid未设置');
            }
        }

        $appletType = $this->request->getIntParam('appletType');
        //TODO 城市合伙人测试
        if($this->member['m_id'] == 1033876){
            $town = 11;
        }
        // 获取分类信息
        $cate_model = new App_Model_City_MysqlCityPostCategoryStorage($this->sid);
        $row = $cate_model->getRowById($categoryId);

        //如果是插件，判断是否开通插件
        if($isPlugin){
            $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($this->sid);
            $plugin_row = $plugin_model->findUpdateBySid('post');
            if (!$plugin_row || $plugin_row['apo_expire_time']<time()) {
                $this->outputError('发帖功能暂不可用');
            }
        }

        // 判断是否绑定手机号
        if($type == 'post' && $this->shop['s_check_mobile'] && !$this->member['m_mobile'] && $this->appletType != 5){
            $this->outputError('请先绑定手机号');
        }

        //验证发帖是否超出限制
        if($type == 'post'){
           // $tplId = $this->applet_cfg['ac_index_tpl'];
            $city_model = new App_Model_City_MysqlCityIndexStorage($this->sid);
            $cityIndex = $city_model->findUpdateBySid();

            if(($version && isset($version) && $version>=180) || $appletType == 5){   // 在2.8.0版本之后的才能使用
                // 根据类型获取发帖单价
                $postPrice = $this->_get_post_price_by_category($categoryId,$secondId);
                $row['acc_price'] = $postPrice['price'];
            }else{
                $postNum = $this->_verify_post_count_today($cityIndex,$row['acc_price']);
                if($postNum['code']){
                    $this->outputError('您今日发帖次数已用完，请明天再来');
                }
            }

            // 判断会员是否被封号
            if($this->member['m_status']==1){
                $this->outputError('该账户已被管理员封禁，暂停发布');
            }

            if($mobile){
                if(!plum_is_mobile_phone($mobile) && $this->sid!=7448){   // 马耳他智慧生活是国外使用，手机号不再做验证
                    $this->outputError('请填写正确的手机号或固话');
                }
            }

            if($postType == 2){
                //公众号文章, 进行公众号文章的抓取
                $this->_get_article_info($articleUrl);
            }

            if($postType == 3){
                //本地视频
                if($videoType == 2){
                    //腾讯视频
                    $this->_get_tencent_video();
                }
            }
        }
        //商家入驻 验证手机号
        if($type == 'shop'){
            if($mobile && isset($mobile)){
                //因为加了登录 所以只能是手机号
                if(!plum_is_phone($mobile) && $this->sid!=7448){   // 马耳他智慧生活是国外使用，手机号不再做验证
                    $this->outputError('请填写正确的手机号');
                }else{
                    $esm_model = new App_Model_Entershop_MysqlManagerStorage();
                    $exist = $esm_model->findManagerByMobile($mobile);
                    if($exist){
                        $this->outputError('手机号已被占用,请更换其他号码');
                    }
                }
            }
        }
        //支付订单类型
        $typeArr = array(
            'post' => 1,
            'top'  => 2,
            'shop' => 3,
        );

        // 支付配置
        $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payCfg = $pay_type->findRowPay();
        // 生成订单编号
        $number = App_Plugin_Weixin_NewPay::makeMchOrderid($this->sid);

        //店铺入驻 获得支付配置
        if($dateId){
            $cost_storage = new App_Model_City_MysqlCityApplyCostStorage($this->sid);
            $dateRow = $cost_storage->getRowById($dateId);
        }
        
        if($payType==1){     //在线支付
            $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->sid);
            $cost = $cost_storage->findRowByActid($topTime);
            $acount = 0;
            // 抖音支付
            // zhangzc
            // 2019-08-14
            if($appletType==4){
                if(($row && $row['acc_price']>0) || ($topTime && $cost['act_cost']>0) || ($redbagMoney > 0) || ($dateId && $dateRow['cac_cost'] >  0) ){
                    $alipay_notify_url = $this->response->responseHost().'/alixcx/alipay/appletCityPostPay';//回调地址
                    $attach = array(
                        'suid'  => $this->shop['s_unique_id'],
                        'mid'   => $this->member['m_id'],
                        'cid' => $categoryId,
                        'appid' => $appid,
                        'type'  => $typeArr[$type] ? $typeArr[$type] : 0,
                    );
                    $acount += $redbagMoney;
                    $acount += $serviceMoney;
                    $acount += $row['acc_price'] && $type != 'top' ? $row['acc_price'] : 0; //单独置顶时不再计算分类收费
                    $body   = "支付发帖费用";
                    $openid     = $this->member['m_openid'];

                    // 获取超时关闭时间
                    $over_time     = plum_parse_config('trade_overtime');
                    $overTime = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade']*60 : $over_time['close'];
                    $pay_storage = new App_Plugin_Toutiao_Pay($this->sid);
                    $result = $pay_storage->appletOrderPayRecharge($acount, $openid, $number, $alipay_notify_url, $body, time(), $overTime, $attach);
                    if (is_array($result) && !$result['code']) {
                        $params = array(
                            'app_id'      => $result['appid'],
                            'timestamp'   => $result['timestamp'],
                            'trade_no'    => $result['trade_no'],
                            'merchant_id' => $result['biz_content']['merchant_id'],
                            'uid'         => $result['uid'],
                            'total_amount' => $result['biz_content']['total_amount'],
                            'sign_type'   => 'MD5',
                            'params'      => json_encode(array(
                                'url' => $result['params_url']
                            )),
                        );
                        $params['sign']        = $pay_storage::makeToutiaoSign($params,$result['appsecret']);
                        $params['params']      = $result['params_url'];
                        $params['method']      = 'tp.trade.confirm';
                        $params['pay_channel'] = 'ALIPAY_NO_SIGN';
                        $params['pay_type']    = 'ALIPAY_APP';
                        $params['risk_info']   = $result['biz_content']['risk_info'];
                        $this->outputSuccessWithExit($params);
                    } else{
                        $this->outputError('支付错误，请稍后重试');
                    }
                }else{
                    $this->outputError('支付错误，请稍后重试.');
                }
            }elseif($weixin_appid && $this->appletType == 5){
                    //判断是否填写小程序端的微信支付配置
                    $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                    $appcfg = $appletPay_Model->findRowPay();
                    if(!$appcfg){
                        $this->outputError('该商户暂未填写微信支付配置');
                    }
                if(($row && $row['acc_price']>0) || ($topTime && $cost['act_cost']>0) || ($redbagMoney > 0) || ($dateId && $dateRow['cac_cost'] >  0) ){

                    $acount += $redbagMoney;
                    $acount += $serviceMoney;
                    $acount += $row['acc_price'] && $type != 'top' ? $row['acc_price'] : 0; //单独置顶时不再计算分类收费

                    $appid = $weixin_appid;
                    $body   = "支付发帖费用";
                    $openid     = $this->member['m_openid'];
                    $notify_url = $this->response->responseHost().'/mobile/wxpay/appletCityPostPay';//回调地址
                    // $notify_url = plum_parse_config('notify_url','wxxcx').'/mobile/wxpay/appletCityPostPay';//回调地址
                    $attach = array(
                        'suid'  => $this->shop['s_unique_id'],
                        'mid'   => $this->member['m_id'],
                        'cid' => $categoryId,
                        'appid' => $appid,
                        'type'  => $typeArr[$type] ? $typeArr[$type] : 0,
                    );

                    if($istop){
                        $attach['topTime'] = $topTime;
                        $acount += $cost['act_cost'];
                    }
                    //入驻
                    if($dateRow){
                        $attach['topTime'] = $dateRow['cac_data'];
                        $acount += $dateRow['cac_cost'];
                    }
                    $other      = array(
                        'attach'    => json_encode($attach),
                    );

                    //设置订单分佣及通知信息
                    $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
                    $tcRow         = $copartner_cfg->findShopCfg();
                    if($tcRow['tc_copartner_isopen'] == 1){
                        $deductAccount = $acount - $redbagMoney - $serviceMoney;
                        if($deductAccount > 0){
                            $this->_recharge_copartner_order_deduct($number, floatval($deductAccount), $type);
                        }
                    }

                    $appcfg['weixin_appid'] = $appid;
                    $wx_pay     = new App_Plugin_Weixin_NewPay($this->shop['s_id'],$appcfg);

                    $ret        = $wx_pay->unifiedJsapiOrder($openid, $body, $number, $acount, $notify_url, $other,$appcfg);

                    if (is_array($ret)) {
                        $params = array(
                            'appId'     => $ret['appid'],
                            'timeStamp' => strval(time()),
                            'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                            'package'   => "prepay_id={$ret['prepay_id']}",
                            'signType'  => 'MD5',
                        );
                        $params['paySign']  = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $ret['app_key']);
                        $info['data'] = [
                            'params' => $params,
                            'number' => $number,
                        ];
                        $this->outputSuccess($info);
                    } else {

                        $this->outputError("微信支付发起失败");
                    }
                }else{
                    $this->outputError('微信支付发起失败');
                }

            }else{
                // 判断是否开启微信支付
                if(!$payCfg || ($payCfg && $payCfg['pt_wxpay_applet']==0)){
                    $this->outputError('该商户暂未开启微信支付');
                }
                //判断是否填写小程序端的微信支付配置
                $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                $appcfg = $appletPay_Model->findRowPay();
                if(!$appcfg){
                    $this->outputError('该商户暂未填写微信支付配置');
                }
                $pay_type_storage    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
                $payType = $pay_type_storage->findRowPay();
                if(!$payType || ($payType && $payType['pt_wxpay_applet']==0)){
                    $this->outputError('该店铺暂未开启微信支付');
                }

                
                if(($row && $row['acc_price']>0) || ($topTime && $cost['act_cost']>0) || ($redbagMoney > 0) || ($dateId && $dateRow['cac_cost'] >  0) ){
                    $acount += $redbagMoney;
                    $acount += $serviceMoney;
                    $acount += $row['acc_price'] && $type != 'top' ? $row['acc_price'] : 0; //单独置顶时不再计算分类收费
                    $body   = "支付发帖费用";
                    $openid     = $this->member['m_openid'];
                    $pay_storage = new App_Plugin_Weixin_NewPay($this->sid);
                    $notify_url = $this->response->responseHost().'/mobile/wxpay/appletCityPostPay';//回调地址
                    $attach = array(
                        'suid'  => $this->shop['s_unique_id'],
                        'mid'   => $this->member['m_id'],
                        'cid' => $categoryId,
                        'appid' => $appid,
                        'type'  => $typeArr[$type] ? $typeArr[$type] : 0,
                    );

                    if($istop){
                        $attach['topTime'] = $topTime;
                        $acount += $cost['act_cost'];
                    }
                    //入驻
                    if($dateRow){
                        $attach['topTime'] = $dateRow['cac_data'];
                        $acount += $dateRow['cac_cost'];
                    }

                    //TODO 城市合伙人
                    if($this->sid == 4546 && $town){
                        $attach['town'] = $town;
                    }

                    $other      = array(
                        'attach'    => json_encode($attach),
                    );

                    //设置订单分佣及通知信息
                    $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
                    $tcRow         = $copartner_cfg->findShopCfg();
                    if($tcRow['tc_copartner_isopen'] == 1){
                        $deductAccount = $acount - $redbagMoney - $serviceMoney;
                        if($deductAccount > 0){
                            $this->_recharge_copartner_order_deduct($number, floatval($deductAccount), $type);
                        }
                    }

                    if($this->sid == 4546 || $this->sid == 5741 || $this->uid == 6079278){
                        $acount = 0.01;
                    }
                    //获取分身小程序信息
                    $child_cfg = new App_Model_Applet_MysqlChildStorage();
                    $child = $child_cfg->fetchUpdateWxcfgByAid($appid);
                    if($child){
                        $result = $pay_storage->appletChildOrderPayRecharge($appid,$acount,$openid,$number,$notify_url,$body,$other);
                    }else{
                        // 生成支付参数
                        $result = $pay_storage->appletOrderPayRecharge($acount,$openid,$number,$notify_url,$body,$other);
                    }
                    if (is_array($result)) {
                        $params = array(
                            'appId'     => $result['appid'],
                            'timeStamp' => strval(time()),
                            'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                            'package'   => "prepay_id={$result['prepay_id']}",
                            'signType'  => 'MD5',
                        );
                        $params['paySign']  = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $result['app_key']);
                        $info['data'] = array(
                            'result' => true,
                            'number' => $number,
                            'params' => $params,
                           // 'todayPost' => $this->_get_post_count_today()
                        );
                        $this->outputSuccess($info);
                    }else{
                        $this->outputError('支付错误，请稍后重试..');
                    }
                }else{
                    $this->outputError('支付错误，请稍后重试.');
                }
            }
        }elseif ($payType==3){  // 余额支付
            // 判断是否开启余额支付
            if(!$payCfg || ($payCfg && $payCfg['pt_coin']==0)){
                $this->outputError('该商户暂未开启余额支付');
            }
            //判断账户余额是否冻结
            if($this->member['m_gold_freeze']){
                $this->outputError('账户已被冻结，请联系管理员');
            }

            $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->sid);
            $cost = $cost_storage->findRowByActid($topTime);
            $acount = 0;
            if(($row && $row['acc_price']>0) || ($topTime && $cost['act_cost']>0) || ($redbagMoney > 0) || ($dateId && $dateRow['cac_cost'] > 0)) {
                $acount += $redbagMoney;
                $acount += $serviceMoney;
                $acount += $row['acc_price'] && $type != 'top' ? $row['acc_price'] : 0; //单独置顶时不再计算分类收费
                if($istop){
                    $attach['topTime'] = $topTime;
                    $acount += $cost['act_cost'];
                }
                //入驻
                if($dateRow){
                    $attach['topTime'] = $dateRow['cac_data'];
                    $acount += $dateRow['cac_cost'];
                }

                //TODO 城市合伙人
               // $typeInfo = [];
               // if($this->sid == 4546 && $town){
               //     $typeInfo = [
               //         'type' => $type,
               //         'postCost' => $row['acc_price'] && $type != 'top' ? $row['acc_price'] : 0,
               //         'topCost' => $cost['act_cost'],
               //         'shopCost' => $dateRow['cac_cost'],
               //     ];
               //     $attach['typeInfo'] = $typeInfo;
               // }

                //设置订单分佣及通知信息
                $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
                $tcRow         = $copartner_cfg->findShopCfg();
                if($tcRow['tc_copartner_isopen'] == 1){
                    $deductAccount = $acount - $redbagMoney - $serviceMoney;
                    if($deductAccount > 0){
                        $this->_recharge_copartner_order_deduct($number, floatval($deductAccount), $type);
                    }
                }
                if($this->sid == 4546 && $town){
                    plum_open_backend('index', 'townDeduct', array('sid' => $this->sid,'town' => $town,'type'=>$typeArr[$type] ? $typeArr[$type] : 0,'totalCost'=>$acount - $redbagMoney - $serviceMoney,'number'=>$number));
                }

                //判断会员余额是否足够支付
                $coin   = floatval($this->member['m_gold_coin']);
                $fee    = floatval($acount);    //支付总费用
                if ($fee > $coin) {
                    $this->outputError("账户余额不足");
                }
                $pay_model = new App_Model_City_MysqlCityPostPayStorage($this->shop['s_id']);
                $record = $pay_model->findUpdateByNumber($number);
                // 如果订单号存在则重新生成一个
                if($record){
                    $number = App_Plugin_Weixin_NewPay::makeMchOrderid($this->sid);
                }
                //减少会员金币
                $debit = App_Helper_MemberLevel::goldCoinTrans($this->sid, $this->member['m_id'], -$fee);
                Libs_Log_Logger::outputLog('到这一步了**********************************','test.log');
                Libs_Log_Logger::outputLog($debit,'test.log');

                // 记录使用记录
                App_Helper_MemberLevel::rechargeRecord($this->sid,$number, $this->member['m_id'], $fee);
                if($debit){
                    $data = array(
                        'cpp_s_id'        => $this->shop['s_id'],
                        'cpp_m_id'        => $this->uid,
                        'cpp_number'      => $number,
                        'cpp_acc_id'      => $categoryId,
                        'cpp_create_time' => time(),
                        'cpp_top_time'    => isset($attach['topTime']) && $attach['topTime'] ? $attach['topTime'] : 0,
                        'cpp_money'       => $fee,
                        'cpp_pay_type'    => 3, //余额支付
                        'cpp_type'        => $typeArr[$type] ? $typeArr[$type] : 0,
                        'cpp_town'        => $town

                    );
                    $ret = $pay_model->insertValue($data);
                    if($ret){
                        //是否开通分销功能
                        $order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
                        $order_deduct->completeOrderDeduct($number, $this->member['m_id']);
                        $info['data'] = array(
                            'result' => true,
                            'number' => $number,
                            'msg'    => '支付成功',
                            'params' => '',
                           // 'todayPost' => $this->_get_post_count_today()
                        );
                        $this->outputSuccess($info);

                    }else{
                        $this->outputError('支付错误，请稍后重试...');
                    }
                }else{
                    $this->outputError('支付错误，请稍后重试..');
                }
            }else{
                $this->outputError('支付错误，请稍后重试.');
            }
        }elseif($payType==4){
            // 判断是否开启微信支付
            if(!$payCfg || ($payCfg && $payCfg['pt_wxpay_applet']==0)){
                $this->outputError('该商户暂未开启微信支付');
            }
            //判断是否填写小程序端的微信支付配置
            $appletPay_Model = new App_Model_Baidu_MysqlBaiduPayCfgStorage($this->sid);
            $paycfg = $appletPay_Model->findRowPay();
            if(!$paycfg){
                $this->outputError('该商户暂未填写百度支付配置');
            }
            $pay_type_storage    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
            $payType = $pay_type_storage->findRowPay();
            if(!$payType || ($payType && $payType['pt_baidu_pay']==0)){
                $this->outputError('该店铺暂未开启百度支付');
            }

            $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->sid);
            $cost = $cost_storage->findRowByActid($topTime);
            $acount = 0;
            if(($row && $row['acc_price']>0) || ($topTime && $cost['act_cost']>0) || ($redbagMoney > 0) || ($dateId && $dateRow['cac_cost'] >  0) ){
                $acount += $redbagMoney;
                $acount += $serviceMoney;
                $acount += $row['acc_price'] && $type != 'top' ? $row['acc_price'] : 0; //单独置顶时不再计算分类收费;
                $dealTitle   = "支付发帖费用";
                $attach = array(
                    'suid'  => $this->shop['s_unique_id'],
                    'mid'   => $this->member['m_id'],
                    'categoryId' => $categoryId,
                    'appid' => $appid,
                    'type'  => $typeArr[$type] ? $typeArr[$type] : 0,
                    'town'  => $town,
                    'orderType' => 'order',
                );

                //TODO 城市合伙人
                if($this->sid == 4546 && $town){
                    $typeInfo = [
                        'type' => $type,
                        'postCost' => $row['acc_price'] && $type != 'top' ? $row['acc_price'] : 0,
                        'topCost' => $cost['act_cost'],
                        'shopCost' => $dateRow['cac_cost']
                    ];
                    $attach['typeInfo'] = $typeInfo;
                }

                if($istop){
                    $attach['topTime'] = $topTime;
                    $acount += $cost['act_cost'];
                }
                //入驻
                if($dateRow){
                    $attach['topTime'] = $dateRow['cac_data'];
                    $acount += $dateRow['cac_cost'];
                }

                //设置订单分佣及通知信息
                $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
                $tcRow         = $copartner_cfg->findShopCfg();
                if($tcRow['tc_copartner_isopen'] == 1){
                    $deductAccount = $acount - $redbagMoney - $serviceMoney;
                    if($deductAccount > 0){
                        $this->_recharge_copartner_order_deduct($number, floatval($deductAccount), $type);
                    }
                }

                if($this->sid == 4546 || $this->sid == 5741 || $this->uid == 1444373){
                    $acount = 0.01;
                }

                $pay_storage = new App_Plugin_Baidu_Pay($this->sid);
                $result = $pay_storage->appletOrderPayRecharge($acount,$number,$dealTitle,$attach);
                if (is_array($result)) {
                    $this->outputSuccess(array('data' => $result));
                } else{
                    $this->outputError('支付错误，请稍后重试');
                }
            }else{
                $this->outputError('支付错误，请稍后重试.');
            }
        }else{
            $this->outputError('支付方式错误');
        } 
    }

    
    private function _recharge_copartner_order_deduct($tid, $total, $type) {

        $goods_deduct   = new App_Model_Goods_MysqlDeductStorage($this->sid);
        $order_deduct   = new App_Helper_OrderDeduct($this->sid);

        //使用店铺分佣设置
        $ratio  = $this->_deduct_copartner_translate();
        Libs_Log_Logger::outputLog($ratio);
        $type = $type == 'shop'?5:4;
        //设置商品分佣
        $order_deduct->createOrderDeduct($this->member['m_id'], $tid, $total, $ratio, 0, $type);
    }

    
    private function _deduct_copartner_translate() {
        $three_level  = App_Helper_ShopWeixin::checkShopThreeLevel($this->sid);
        $member_storage   = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($this->uid);
        $deduct_model   = new App_Model_Copartner_MysqlCopartnerDeductCfgStorage();
        $data = array();
        for ($i=0; $i<=$three_level; $i++) {
            $tmp    = "{$i}f";
            //购买人或其上级存在
            $benefit    = $i == 0 ? $member['m_id'] : $member["m_{$tmp}_id"];
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
            $extra = $extra_model->findUpdateExtraByMid($benefit);
            $deduct_list    = $deduct_model->fetchDeductListBySid($this->sid, $extra['ame_copartner']);
            $deduct = $deduct_list[1];
            $data[$i] = $deduct['cdc_'.$i.'f_ratio'];
        }
        return $data;
    }

    
    private function _statistics($type, $num){
        $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->sid);
        $tpl = $tpl_model->findUpdateBySid();
        if($type == 'browse'){
            $set = array('aci_browse_num' => ($tpl['aci_browse_num'] + $num));
            $tpl_model->findUpdateBySid(23, $set);
        }
        if($type == 'issue'){
            $set = array('aci_issue_num' => ($tpl['aci_issue_num'] + $num));
            $tpl_model->findUpdateBySid(23, $set);
        }
        if($type == 'shop'){
            $set = array('aci_shop_num' => ($tpl['aci_shop_num'] + $num));
            $tpl_model->findUpdateBySid(23, $set);
        }
    }

    
    private function _get_withdraw_history($type){
        $withdraw_storage   = new App_Model_Member_MysqlWithDrawalStorage();
        $history = $withdraw_storage->getLastHistory($type,$this->sid, $this->uid);
        $data = array();
        if($history){
            $data = array(
                'realname' => $history['wd_realname'],
                'mobile' => $history['wd_mobile'],
                'account' => $history['wd_account'],
                'bank' => $history['wd_bank'],
                'money' => $history['wd_money'],
                'serviceMoney' => $history['wd_service_money']>0?$history['wd_service_money']:0
            );
        }
        return $data;
    }

    
    private function autoWithDraw($sid,$rid){
        // 主服务器的请求地址
        $url='http://www.tiandiantong.com/mobile/Withdraw/doAutoWithdraw';
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['sid'=>$sid,'rid'=>$rid,'auth'=>md5($sid.$rid.'plum_with_draw')]));
        //运行curl
        curl_exec($ch);
    }

    
    private function _shop_details_format($val,$entershop = false){
        $data = array();
        if(!empty($val)){
            $time=explode('-',$val['acs_open_time']);
            $data = array(
                'id'            => $val['acs_id'],
                'mid'           => intval($val['acs_m_id']),
                'sid'           => $val['acs_s_id'],
                'name'          => $val['acs_name'],
                'logo'          => isset($val['acs_img']) && $val['acs_img'] ? $this->dealImagePath($val['acs_img']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_45_45.png'),
                'logoTemp'      => isset($val['acs_img']) && $val['acs_img'] ? $val['acs_img'] : '',
                'cover'         => isset($val['acs_cover']) && $val['acs_cover'] ? $this->dealImagePath($val['acs_cover']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_75_36.png'),
                'coverTemp'     => isset($val['acs_cover']) && $val['acs_cover'] ? $val['acs_cover'] : '',
                'code'          => isset($val['acs_code_cover']) && $val['acs_code_cover'] ? array($this->dealImagePath($val['acs_code_cover'])) : '',
                'label'         => isset($val['acs_label']) ? preg_split("/[\s,]+/",$val['acs_label']) : '' ,
                'labelTemp'     => isset($val['acs_label']) ? $val['acs_label']: '' ,
                'brief'         => isset($val['acs_brief']) ? $val['acs_brief'] : '',
                'openTime'      => $time[0],
                'closeTime'     => $time[1],
                'mobile'        => $val['acs_mobile'],
                'category'      => $val['acs_category_id'],
                'address'       => $val['acs_address'],
                'lng'           => $val['acs_lng'],
                'lat'           => $val['acs_lat'],
                'aptitude'      => isset($val['acs_aptitude']) && $val['acs_aptitude'] ? $this->dealImagePath($val['acs_aptitude']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_45_45.png'),
                'aptitudeTemp'  => isset($val['acs_aptitude']) && $val['acs_aptitude'] ? $val['acs_aptitude'] : '',
                'area'          => $val['acs_area'],
                'status'        => 2,
                'payQrcode'     => isset($val['acs_pay_qrcode']) && $val['acs_pay_qrcode'] ? $this->dealImagePath($val['acs_pay_qrcode']) : '',
                'payQrcodeTemp' => isset($val['acs_pay_qrcode']) && $val['acs_pay_qrcode'] ? $val['acs_pay_qrcode'] : '',
                'expireTime'    => date('Y-m-d',$val['acs_expire_time']),
                'vrurl'         => $val['acs_vr_url'] ? $this->_judge_vrurl($val['acs_vr_url']) : ''

            );

            $aptitude_arr = json_decode($val['acs_aptitude_arr'],1);
            $aptitudeArrTemp = [];
            if(is_array($aptitude_arr) && !empty($aptitude_arr)){
                $aptitudeArrTemp = $aptitude_arr;
            }
            if($data['aptitudeTemp']){
                $aptitudeArrTemp[] = $data['aptitudeTemp'];
            }
            $aptitudeArr = [];
            foreach ($aptitudeArrTemp as $aptitude){
                $aptitudeArr[] = $this->dealImagePath($aptitude);
            }
            $data['aptitudeArr'] = $aptitudeArr;
            $data['aptitudeTemp'] = $aptitudeArrTemp;

            // 获取分类信息
            $cate_model = new App_Model_City_MysqlCityPostCategoryStorage($this->sid);
            $categoryData = $cate_model->getRowById($val['acs_category_id']);
            $data['categoryName'] = $categoryData['acc_title'];

            if($val['acs_expire_time'] < time()){
                $data['isExpire'] = 1;
            }else{
                $data['isExpire'] = 0;
            }

            if($entershop){
                //获取当前访问的域名
                // 获取店铺的代理商，从代理商里面找到对应的oem地址
                // zhangzc
                // 2019-07-04
                $open_shop_model=new App_Model_Agent_MysqlOpenStorage();
                $oem_info=$open_shop_model->getAgentOemBySid($this->sid);
                if($oem_info['ao_domain'])
                    $curr_domain=$oem_info['ao_domain'];
                else
                    $curr_domain = 'www.tiandiantong.com';
                    // $curr_domain = plum_get_server('http_host'); 不能直接使用小程序的域名
                
                // 判断当前店铺是否开通了多商家商城 否的话 小程序端 我的入住页面不显示后台链接与企商平台入口
                // zhangzc
                // 2019-07-08
                $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($this->sid);
                $row = $plugin_model->findUpdateBySid('sc');

                if (!$row || $row['apo_expire_time']<time() ){  //不可用
                    $data['sc_open']=0;
                }else{                                          //可用
                    $data['sc_open']=1;
                }

                //如果是马耳他智慧生活，添加参数，shop后台登录无需验证手机号格式
                $ext_query = '?';
                if($this->sid == 7448){
                    $ext_query .= 'notcheackmobile=1&';
                }
                $ext_query = rtrim($ext_query,'?');
                $ext_query = rtrim($ext_query,'&');
                $this->output['ext_query'] = $ext_query;

                //$data['loginUrl'] = $this->entershop_login_url;
                $data['loginUrl'] = 'http://'.$curr_domain.'/shop/user/index'.$ext_query;
                $data['account'] = $val['esm_mobile'] ? $val['esm_mobile'] : '';
                $data['password'] = $val['esm_mobile'] ? $val['esm_mobile'] : '';
                $data['showNum'] = $val['acs_show_num'];
                $data['balance'] = floatval($val['es_balance']);//可提现
                //待结算总额
                $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($val['acs_es_id']);
                $noSettled      = $settled_model->statisticEnterShopNoSettled();
                $data['noSettled'] = floatval($noSettled);
                $data['goodsStyle'] = intval($val['es_goods_style']);
            }


        }
        return $data;
    }


    
    private function _shop_details_format_applet($val){
        $data = array();
        if(!empty($val)){
            $time=explode('-',$val['acs_open_time']);
            $data = array(
                'id'            => $val['acs_id'],
                'mid'           => intval($val['acs_m_id']),
                'sid'           => $val['acs_s_id'],
                'name'          => $val['acs_name'],
                'logo'          => isset($val['acs_img']) && $val['acs_img'] ? $this->dealImagePath($val['acs_img']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_45_45.png'),
                'logoTemp'      => isset($val['acs_img']) && $val['acs_img'] ? $val['acs_img'] : '',
                'cover'         => isset($val['acs_cover']) && $val['acs_cover'] ? $this->dealImagePath($val['acs_cover']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_75_36.png'),
                'coverTemp'     => isset($val['acs_cover']) && $val['acs_cover'] ? $val['acs_cover'] : '',
                'label'         => isset($val['acs_label']) ? preg_split("/[\s,]+/",$val['acs_label']) : '' ,
                'labelTemp'     => isset($val['acs_label']) ? $val['acs_label']: '' ,
                'brief'         => isset($val['acs_brief']) ? $val['acs_brief'] : '',
                'openTime'      => $time[0],
                'closeTime'     => $time[1],
                'mobile'        => $val['acs_mobile'],
                'aptitude'      => isset($val['acs_aptitude']) && $val['acs_aptitude'] ? $this->dealImagePath($val['acs_aptitude']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_45_45.png'),
                'aptitudeTemp'  => isset($val['acs_aptitude']) && $val['acs_aptitude'] ? $val['acs_aptitude'] : '',
                'category'      => $val['acs_category_id'],
                'area'          => $val['acs_area'],
                'address'       => $val['acs_address'],
                'lng'           => $val['acs_lng'],
                'lat'           => $val['acs_lat'],
                'status'        => $val['acs_status'],
                'payQrcode'     => isset($val['acs_pay_qrcode']) && $val['acs_pay_qrcode'] ? $this->dealImagePath($val['acs_pay_qrcode']) : '',
                'payQrcodeTemp' => isset($val['acs_pay_qrcode']) && $val['acs_pay_qrcode'] ? $val['acs_pay_qrcode'] : '',
                'showComment'   => intval($this->shop['s_shop_comment'])
            );

            $aptitude_arr = json_decode($val['acs_aptitude_arr'],1);
            $aptitudeArrTemp = [];
            if(is_array($aptitude_arr) && !empty($aptitude_arr)){
                $aptitudeArrTemp = $aptitude_arr;
            }
            if($data['aptitudeTemp']){
                $aptitudeArrTemp[] = $data['aptitudeTemp'];
            }
            $aptitudeArr = [];
            foreach ($aptitudeArrTemp as $aptitude){
                $aptitudeArr[] = $this->dealImagePath($aptitude);
            }
            $data['aptitudeArr'] = $aptitudeArr;
            $data['aptitudeTemp'] = $aptitudeArrTemp;

        }
        return $data;
    }

    
    public function tx2BalanceAction(){
        $money = $this->request->getFloatParam('money');
        if($money <= 0 || $money>$this->member['m_deduct_ktx']){
            $this->outputError('可提现金额不足');
        }
        $member_storage     = new App_Model_Member_MysqlMemberCoreStorage();
        //减少可提现，增加已提现
        $updata = array(
            'm_deduct_ktx'  => (float)$this->member['m_deduct_ktx'] - $money,
            'm_deduct_ytx'  => (float)$this->member['m_deduct_ytx'] + $money,
            'm_gold_coin'   => (float)$this->member['m_gold_coin'] + $money,
        );
        $ret = $member_storage->updateById($updata, $this->member['m_id']);
        if($ret){
            $this->_deal_withdraw_result($money,1,'提现到余额');
            $info['data']= array(
                'msg' => "转出成功",
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('转出失败');
        }
    }

    
    private function _deal_withdraw_result($money,$inout=1,$desc, $type=4){
        $data = array(
            'dd_s_id'           => $this->sid,
            'dd_m_id'           => $this->uid,
            'dd_o_id'           => 0,
            'dd_amount'         => $money,
            'dd_tid'            => '',
            'dd_level'          => 0,
            'dd_inout_put'     => $inout,
            'dd_record_type'    => $type,
            'dd_record_time'    => time(),
            'dd_record_remark'  => $desc
        );
        $book_model = new App_Model_Deduct_MysqlDeductDaybookStorage();
        $book_ret = $book_model->insertValue($data);
    }

    
    public function inoutAction(){
        $page           = $this->request->getIntParam('page');
        $type           = $this->request->getIntParam('type');//1充值 2消费 3提现
        $index          = $page * $this->count;
        $info['data']   = array();
        if(in_array($type,[1,2])){
            $record_model   = new App_Model_Member_MysqlRechargeStorage($this->sid);
            $where[]        = array('name' => 'rr_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]        = array('name' => 'rr_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where[]        = array('name' => 'rr_status', 'oper' => '=', 'value' => $type);
            $sort           = array('rr_create_time' => 'DESC');
            $list   = $record_model->getList($where, $index, $this->count, $sort);
            foreach ($list as $key=>$val){
                if($val['rr_status'] == 1){
                    if($val['rr_pay_type'] == 4){
                        $desc  = '管理员充值';
                    }elseif($val['rr_pay_type'] == 5){
                        $desc  = '帖子打赏';
                    }elseif($val['rr_pay_type'] == 10){//跑腿订单
                        $desc  = '订单退款';
                    }elseif($val['rr_pay_type'] == 11){
                        $desc  = '红包收入';
                    }elseif($val['rr_pay_type'] == 13){
                        $desc  = '会员卡赠送';
                    }elseif($val['rr_pay_type'] == 14){
                        $desc  = '订单关闭退还';
                    }elseif ($val['rr_pay_type'] == 15){
                        $desc  = '订单退款';
                    }elseif ($val['rr_pay_type'] == 18){
                        $desc  = '收银台退款';
                    }else {
                        $desc  = '余额充值';
                    }
                }else{
                    $desc  = '订单支付';
                }
                $info['data'][]  = array(
                    'money'  => $val['rr_gold_coin'] ? $val['rr_gold_coin'] : $val['rr_amount'],
                    'status'    => $val['rr_status'],
                    'statusDesc'=> $desc,
                    'time'      => date('m-d H:i',$val['rr_create_time'])
                );
            }
        }else{
            $book_model = new App_Model_Deduct_MysqlDeductDaybookStorage();
            $where[]    = array('name' => 'dd_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]    = array('name' => 'dd_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where[]    = array('name' => 'dd_record_type', 'oper' => '=', 'value' => 4);//未被删除数据
            $sort       = array('dd_record_time' => 'DESC');
            $list = $book_model->getList($where, $index, $this->count, $sort);
            foreach($list as $val){
                $info['data'][] = array(
                    'status'      => $val['dd_inout_put']==1?2:1,
                    'statusDesc'  => $val['dd_record_remark'],
                    'time'        => date('m-d H:i', $val['dd_record_time']),
                    'money'       => $val['dd_amount'],
                );
            }
            if($this->applet_cfg['ac_type'] == 28){
                //内推 将记录标记为已读
                $where = array();
                $where[]    = array('name' => 'dd_m_id', 'oper' => '=', 'value' => $this->uid);
                $where[]    = array('name' => 'dd_record_type', 'oper' => '=', 'value' => 4);
                $where[]    = array('name' => 'dd_read', 'oper' => '=', 'value' => 0);
                $where[]    = array('name' => 'dd_inout_put', 'oper' => '=', 'value' => 2);
                $set = array('dd_read' => 1);
                $book_model->updateValue($set, $where);
            }
        }
        if($info['data']){
            $this->outputSuccess($info);
        }else{
            $this->outputError('暂无交易记录');
        }

    }


    
    private function _verify_post_count_today($cityIndex,$postPrice){
        //获取用户发布的免费帖数量及收费贴数量
        $memberPost_Model = new App_Model_City_MysqlCityMemberPostStorage($this->sid);
        $row = $memberPost_Model->findUpdateByMid($this->uid);
        $tdate = strtotime(date('Y-m-d',time()));  // 今天0点时间戳
        $freenum = 0;
        $paynum = 0;
        if($row['acm_free_time']>$tdate){
            $freenum = $row['acm_free_num'];  // 已发免费贴数量
        }
        if($row['acm_pay_time']>$tdate){
            $paynum = $row['acm_pay_num'];  // 已发收费贴数量
        }
        $result = array(
            'code'      => 0,
            'postPrice' => $postPrice,
            'msg'       => '允许发帖',
            'freeNum'   => 0,  // 免费贴剩余次数
            'payNum'    => 0,  // 付费贴剩余次数
        );
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        //$member_card    = $offline_member->findUpdateMemberByCardId($this->uid, $this->member['m_level']);

        //获得购买的会员卡
        $where_card[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
        $where_card[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where_card[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
        $member_card    = $offline_member->getList($where_card, 0, 0, array('om_update_time' => 'desc'))[0];
        //获得会员卡等级
        $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
        $cardData = $card_model->getRowById($member_card['om_card_id']);
        $cardLevel = intval($cardData['oc_identity']);
        // 后台添加的会员没有会员卡记录
        if(!$member_card && !isset($member_card['om_expire_time'])){
            $member_card['om_expire_time'] = time()+86400;
        }

        if(($this->member['m_level'] || ($member_card['om_expire_time']>time() && $cardLevel > 0)) && $cityIndex['aci_member_post_num']){
            $currLevel = $cardLevel ? $cardLevel : $this->member['m_level'];
            $memberPostNum = json_decode($cityIndex['aci_member_post_num'],true);
            $allowFreeNum = isset($memberPostNum[$currLevel]['freenum']) && $memberPostNum[$currLevel]['freenum'] ? $memberPostNum[$currLevel]['freenum'] : 0;
            $allowPayNum = isset($memberPostNum[$currLevel]['paynum']) && $memberPostNum[$currLevel]['paynum'] ? $memberPostNum[$currLevel]['paynum'] : 0;
            if($postPrice>0){
                if($allowPayNum){
                    if($paynum>=$allowPayNum){
                        $result = array(
                            'code'      => 1,
                            'postPrice' => $postPrice,
                            'msg'       => '您今日发帖次数已用完，请明天再来'
                        );
                    }else{
                        $result['postPrice'] = 0;
                    }
                    $result['payNum'] = $allowPayNum-$paynum;
                }else{
                    $result['payNum'] = -1;
                }
            }else{
                if($allowFreeNum){
                    if($freenum>=$allowFreeNum){
                        $result = array(
                            'code'      => 1,
                            'postPrice' => $postPrice,
                            'msg'       => '您今日发帖次数已用完，请明天再来'
                        );
                    }else{
                        $result['freeNum'] = $allowFreeNum-$freenum;
                    }
                }else{
                    $result['freeNum'] = -1;
                }
            }
        }else{
            if($cityIndex['aci_post_num']){
//                $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
//                $where = array();
//                $where[]    = array('name' => 'acp_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
//                $count = $post_model->getTodayPostCount($where);
                if($freenum >= $cityIndex['aci_post_num']){
                    $result = array(
                        'code'      => 1,
                        'postPrice' => $postPrice,
                        'msg'       => '您今日发帖次数已用完，请明天再来'
                    );
                }else{
                    $result['freeNum'] = $cityIndex['aci_post_num']-$freenum;
                }
            }else{
                $result['freeNum'] = -1;
            }
        }
        return $result;
    }

    
    public function setPostTopAction(){
        $postId = $this->request->getIntParam('postId',0); //帖子id
        $number = $this->request->getStrParam('number'); //支付订单号
        $topTime = $this->request->getIntParam('topTime',0); //置顶收费id
        $pay_model = new App_Model_City_MysqlCityPostPayStorage($this->sid);
        //获得指定收费配置
        $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->sid);
        $cost = $cost_storage->findRowByActid($topTime);
        //获取帖子相关信息
//        $post_model  = new App_Model_City_MysqlCityPostStorage($this->sid);
//        $post = $post_model->getRowById($postId);

        $topDate = intval($cost['act_data']);
        $dateTime = $topDate*60*60*24;
//        if($this->member['m_id'] == 1033876){
//            $dateTime = 120;
//        }
        $expiration = intval(time()+$dateTime);

        $set = array(
            'acp_istop'           => 1,
            'acp_istop_expiration' => $expiration,
            'acp_top_date'         => $topDate,
            'acp_pay_time'         => time()
        );
        $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);

        if($cost['act_cost'] > 0){
            //置顶收费不为0  获得支付记录
            $payData = $pay_model->findUpdateByNumber($number);
            if($payData && $payData['cpp_top_time'] == $topTime){
                $ret = $post_model->updateById($set,$postId);
            }else{
                $this->outputError('支付信息错误，请重试');
            }
        }else{
            //置顶不收费  直接修改
            $ret = $post_model->updateById($set,$postId);
        }
        if($ret){
             //记录置顶过期时间
            $applet_redis = new App_Model_Applet_RedisAppletStorage($this->sid);
            $applet_redis->recordTopPostTask($postId, $dateTime);

            //如果有订单 订单类型记录为置顶
            if($number){
                $pay_model->findUpdateByNumber($number,array('cpp_type' => 2));
            }

            $info['data'] = array(
                'result' => true,
                'msg'    => '置顶成功'
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('置顶失败');
        }

    }

    
    private function _remove_post_quotes($type){

        $data['type'] = json_decode($type,true);
        $data['redPacket'] = false;
        foreach ($data['type'] as &$value){
            if($value['must']=='true'){
                $value['must'] = true;
                if($value['type']=='redPacket'){
                    $data['redPacket'] = true;
                }
            }else{
                $value['must'] = false;
            }

        }
        return $data;
    }

    
    private function _fetch_member_post_num($indexTpl){
        //获取用户发布的免费帖数量及收费贴数量
        $memberPost_Model = new App_Model_City_MysqlCityMemberPostStorage($this->sid);
        $row = $memberPost_Model->findUpdateByMid($this->uid);
        $tdate = strtotime(date('Y-m-d',time()));  // 今天0点时间戳
        $freenum = 0;
        $paynum = 0;
        $result = array(
            'payNum'  => 0,
            'freeNum' => 0
        );
        if($row['acm_free_time']>$tdate){
            $freenum = $row['acm_free_num'];  // 已发免费贴数量
        }
        if($row['acm_pay_time']>$tdate){
            $paynum = $row['acm_pay_num'];  // 已发收费贴数量
        }
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        //$member_card    = $offline_member->findUpdateMemberByCardId($this->uid, $this->member['m_level']);

        //获得购买的会员卡
        $where_card[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
        $where_card[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where_card[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
        $member_card    = $offline_member->getList($where_card, 0, 0, array('om_update_time' => 'desc'))[0];
        //获得会员卡等级
        $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
        $cardData = $card_model->getRowById($member_card['om_card_id']);
        $cardLevel = intval($cardData['oc_identity']);
        // 后台添加的会员没有会员卡记录
        if(!$member_card && !isset($member_card['om_expire_time'])){
            $member_card['om_expire_time'] = time()+86400;
        }


        if(($this->member['m_level'] || ($member_card['om_expire_time']>time() && $cardLevel > 0)) && $indexTpl['aci_member_post_num']){
            $currLevel = $cardLevel ? $cardLevel : $this->member['m_level'];
            $memberPostNum = json_decode($indexTpl['aci_member_post_num'],true);
            $allowFreeNum = isset($memberPostNum[$currLevel]['freenum']) && $memberPostNum[$currLevel]['freenum'] ? $memberPostNum[$currLevel]['freenum'] : 0;
            $allowPayNum = isset($memberPostNum[$currLevel]['paynum']) && $memberPostNum[$currLevel]['paynum'] ? $memberPostNum[$currLevel]['paynum'] : 0;
            if($allowPayNum){
                $result['payNum'] = $allowPayNum-$paynum;
            }else{
                $result['payNum'] = -1;
            }
            if($allowFreeNum){
                $result['freeNum'] = $allowFreeNum-$freenum;
            }else{
                $result['freeNum'] = -1;
            }
        }else{
            if($indexTpl['aci_post_num']){
                $result['freeNum'] = $indexTpl['aci_post_num']-$freenum;
            }else{
                $result['freeNum'] = -1;
            }
        }
        return $result;
    }

    
    private function _get_post_price_by_category($category,$secondId = 0){
        // 获取分类信息
        $cate_model = new App_Model_City_MysqlCityPostCategoryStorage($this->sid);
        $categoryRow = $cate_model->getRowById($category);

        if($secondId){
            $secondRow = $cate_model->getRowById($secondId);
        }

        // 获取配置信息
        $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->sid);
        $tpl = $tpl_model->findUpdateBySid();

        //获取用户发布的免费帖数量及收费贴数量
        $memberPost_Model = new App_Model_City_MysqlCityMemberPostStorage($this->sid);
        $row = $memberPost_Model->findUpdateByMid($this->uid);
        $tdate = strtotime(date('Y-m-d',time()));  // 今天0点时间戳
        $freenum = 0;
        $paynum = 0;
        if($row['acm_free_time']>$tdate){
            $freenum = intval($row['acm_free_num']);  // 已发免费贴数量
        }
        if($row['acm_pay_time']>$tdate){
            $paynum = intval($row['acm_pay_num']);  // 已发收费贴数量
        }
        $msg = '';   //提示

        //若当前分类为二级且有费用 获得二级级分类费用
        if(isset($secondRow) && floatval($secondRow['acc_price'] > 0)){
            $price = floatval($secondRow['acc_price']);
        }else{
            $price = floatval($categoryRow['acc_price']);
        }
        //$price = $categoryRow['acc_price'];
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        //$member_card    = $offline_member->findUpdateMemberByCardId($this->uid, $this->member['m_level']);

        //获得购买的会员卡
        $where_card[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
        $where_card[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where_card[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
        $member_card    = $offline_member->getList($where_card, 0, 0, array('om_update_time' => 'desc'))[0];
        //获得会员卡等级
        $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
        $cardData = $card_model->getRowById($member_card['om_card_id']);
        $cardLevel = intval($cardData['oc_identity']);
        // 后台添加的会员没有会员卡记录
        if(!$member_card && !isset($member_card['om_expire_time'])){
            $member_card['om_expire_time'] = time()+86400;
        }
        if(($this->member['m_level'] || ($member_card['om_expire_time']>time() && $cardLevel > 0)) && $tpl['aci_member_post_num']){
            $currLevel = $cardLevel ? $cardLevel : $this->member['m_level'];
            $memberPostNum = json_decode($tpl['aci_member_post_num'],true);
            // 允许免费发免费贴次数
            $allowFreeNum = isset($memberPostNum[$currLevel]['freenum']) && $memberPostNum[$currLevel]['freenum'] ? intval($memberPostNum[$currLevel]['freenum']) : 0;
            // 允许免费发收费贴次数
            $allowPayNum = isset($memberPostNum[$currLevel]['paynum']) && $memberPostNum[$currLevel]['paynum'] ? intval($memberPostNum[$currLevel]['paynum']) : 0;
            if($price>0){
                if($allowPayNum>$paynum){
                    $price = 0;
                }else{
                    $msg = '免费发帖次数已使用完毕，本次发帖需要支付一定费用';
                }
            }else{
                if($allowFreeNum>$freenum){
                    $price = 0;
                }else{
                    $price = isset($memberPostNum[$currLevel]['postPrice']) && $memberPostNum[$currLevel]['postPrice'] ? $memberPostNum[$currLevel]['postPrice'] : 0;
                }
            }
        }else{
            if($price==0){
                if($tpl['aci_post_num']>0 && $tpl['aci_post_num']>$freenum){
                    $price = 0;
                }else{
                    $price = $tpl['aci_post_price'];
                    $msg = '免费发帖次数已使用完毕，本次发帖需要支付一定费用';
                }
            }
        }
        $result = array(
            'price' => $price,
            'msg'   => $msg
        );
        return $result;
    }

    //申请店铺认领
    public function claimDetailAction(){
        $acsId = $this->request->getIntParam('acsId');
        $esId  = $this->request->getIntParam('esId');
        $claim_model = new App_Model_City_MysqlCityShopClaimStorage($this->sid);
        $claim = $claim_model->findClaimByMidShop($this->member['m_id'], $acsId, $esId);
        if($claim){
            $statusNote = array(1 => '待审核',  2 => '审核通过', 3 => '审核拒绝');
            $info['data'] = array(
                'status' => $claim['acsc_status'],
                'statusNote' => $statusNote[$claim['acsc_status']],
                'id' => $claim['acsc_id'],
                'dealNote' => $claim['acsc_deal_note'],
            );
            foreach (json_decode($claim['acsc_images'], true) as $val){
                $info['data']['images'] = $this->dealImagePath($val);
            }
            $this->outputSuccess($info);
        }else{
            $info['data'] = array(
                'status' => 0,
                'statusNote' => '未认领',
                'id' => 0,
                'dealNote' => '',
            );

            $this->outputSuccess($info);
        }
    }
}
