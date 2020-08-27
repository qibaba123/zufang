<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/14
 * Time: 上午11:47
 */
/*
 * 店铺微信助手
 */
class App_Helper_ShopWeixin {

    const QRCODE_FOREVER_TIME   = 1767196800;//2026-01-01 00:00:00 定义为二维码永久日期

    const WX_VERIFY_NO      = 0;//无公众号
    const WX_VERIFY_WRZDYH  = 1;//未认证订阅号
    const WX_VERIFY_YRZDYH  = 2;//已认证订阅号
    const WX_VERIFY_WRZFWH  = 3;//未认证服务号
    const WX_VERIFY_YRZFWH  = 4;//已认证服务号

    const SHOP_MANAGE_RUN   = 0;//正常状态
    const SHOP_MANAGE_VERIFY= 1;//审核状态
    const SHOP_MANAGE_FORBID= 2;//禁用状态
    const SHOP_MANAGE_SINGLE= 3;//单功能店铺

    const SHOP_VERSION_MFB  = 'mfb';//免费版
    const SHOP_VERSION_HZB  = 'hzb';//合作版
    const SHOP_VERSION_TYB  = 'tyb';//体验版
    const SHOP_VERSION_YYB  = 'yyb';//运营版
    const SHOP_VERSION_HHB  = 'hhb';//旗舰版

    const SHOP_MANAGE_OVERDUE = -1; //店铺过期
    
    const THREE_THREE_KIND    = 'tgm';//微信事件类型
    
    /*
     * 店铺信息，字段名参考pre_shop
     */
    private $shop;
    private $sid;
    //生成图片存储实际路径
    private $hold_dir;
    //生成图片访问路径
    private $access_path;

    public function __construct($sid) {
        if (!$sid) {
            return null;
        }
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop     = $shop_storage->getRowById($sid);
        $this->sid      = $sid;

        $this->hold_dir     = PLUM_APP_BUILD.'/spread/';
        $this->access_path  = PLUM_PATH_PUBLIC.'/build/spread/';
        return $this;
    }

    /*
     * 获取店铺微信回调URL及token
     */
    public function fetchWeixinTokenUrl($type = 'weixin') {
        $suid   = $this->shop['s_unique_id'];
        $url    = plum_get_base_host()."/{$type}.php?sid={$suid}";
        $token  = plum_md5_with_salt($suid, $suid);
        $result = array(
            'url'   => $url,
            'token' => $token,
        );

        return $result;
    }

    /*
     * 获取店铺访问链接
     */
    public function fetchShopLink() {
        $suid   = $this->shop['s_unique_id'];
        $center = plum_get_base_host()."/mobile/member/index/suid/{$suid}";
        return array(
            'center'    => $center,
        );
    }

    /*
     * 获取一元夺宝访问链接（管理后台已经废弃）
     */
    public function fetchUnitaryLink() {
        $suid   = $this->shop['s_unique_id'];
        $index = plum_get_base_host()."/mobile/unitary/index/suid/{$suid}";
        return array(
            'index'    => $index,
        );
    }

    /**
     * @param $controller
     * @param string $action
     * @return array
     * 获取链接地址，如一元夺宝，店铺首页访问地址等
     */
    public function fetchIndexLink($controller,$action='index'){
        $suid   = $this->shop['s_unique_id'];
        $index = plum_get_base_host()."/mobile/{$controller}/{$action}/suid/{$suid}";
        return array(
            'index'    => $index,
        );
    }

    /*
     * 生成会员的推广二维码,存储邀请码
     * 可根据会员级别生成永久或临时二维码
     */
    public function createSpreadQrcode($mid, $invite = null) {
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        //获取会员等级说明
        $level      = App_Helper_MemberLevel::fetchMemberLevel($this->sid, $mid);
        $client_plugin  = new App_Plugin_Weixin_ClientPlugin($this->sid);
        if ($level['forever']) {
            //永久二维码,使用字符串类型
            $str    = self::THREE_THREE_KIND.'|'.$mid;
            $result = $client_plugin->fetchSecnestrQrcode($str);
        } else {
            //临时二维码
            $result = $client_plugin->fetchSpreadQrcode($mid, false);
        }
        if (isset($result['url'])) {
            //推广二维码不存在，开始生成
            $text   = $result['url'];
            if (plum_setmod_dir($this->hold_dir)) {
                $suid   = $this->shop['s_unique_id'];
                $tuid   = App_Controller_Mobile_InitController::uidConvert($mid, true);
                $filename   = $suid.'-'.$tuid.'.png';
                Libs_Qrcode_QRCode::png($text, $this->hold_dir.$filename, 'Q', 6, 1);

                //设置并存储会员推广二维码
                $updata = array(
                    'm_spread_qrcode'   => $this->access_path.$filename,
                    'm_wx_ticket'       => $result['ticket'],
                    'm_ticket_expire'   => $level['forever'] ? self::QRCODE_FOREVER_TIME : time()+(int)$result['expire_seconds'],
                    'm_ticket_qrcode_url'   => $result['url'],
                    'm_spread_image'    => '',//二维码推广图片清空，便于重新生成
                );

                if ($invite) {
                    $updata['m_invite_code']    = $invite;
                }
                $member_storage->updateById($updata, $mid);
                return $updata['m_spread_qrcode'];
            }
        }
        return false;
    }
    /*
     * 发送推广二维码画报
     */
    public function sendQrcode($mid) {
        set_time_limit(0);
        //获取会员信息
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($mid);

        $spread     = $member['m_spread_image'];//推广二维码画报
        $qrcode     = $member['m_spread_qrcode'];//推广二维码
        $expire     = intval($member['m_ticket_expire']);//二维码失效时间

        //重新生成二维码
        if ($expire < time()) {
            $this->createSpreadQrcode($mid);
            $member = $member_storage->getRowById($mid);
            $spread = '';//推广二维码画报置空
            $qrcode = $member['m_spread_qrcode'];//获取新的推广二维码
            $expire = intval($member['m_ticket_expire']);//获取新的二维码失效时间
        }
        //推广二维码画报重新生成
        if (!$spread) {
            $center_storage = new App_Model_Member_MysqlMemberCenterStorage();
            $center_cfg     = $center_storage->findUpdateBySid($member['m_s_id']);
            $default_cfg    = plum_parse_config('center_cfg');

            $qrcode_bg      = $center_cfg && $center_cfg['cc_qrcode_bg'] ? $center_cfg['cc_qrcode_bg'] : $default_cfg['cc_qrcode_bg'];
            $avatar_loc     = $center_cfg && $center_cfg['cc_avatar_loc'] ? $center_cfg['cc_avatar_loc'] : $default_cfg['cc_avatar_loc'];
            $avatar_loc     = explode(',', trim($avatar_loc, "()"));
            $qrcode_loc     = $center_cfg && $center_cfg['cc_qrcode_loc'] ? $center_cfg['cc_qrcode_loc'] : $default_cfg['cc_qrcode_loc'];
            $qrcode_loc     = explode(',', trim($qrcode_loc, "()"));

            $basic_path     = PLUM_DIR_ROOT.$qrcode_bg;

            list($b_w, $b_h, $b_type) = getimagesize($basic_path);

            if (in_array($b_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
                $imagecreate    = "imagecreatefrom";
                $imageoutput    = "image";
                $imageext       = '';
                switch ($b_type) {
                    case IMAGETYPE_GIF :
                        $imagecreate    .= "gif";
                        $imageoutput    .= "gif";
                        $imageext       = '.gif';
                        break;
                    case IMAGETYPE_JPEG :
                        $imagecreate    .= "jpeg";
                        $imageoutput    .= "jpeg";
                        $imageext       = '.jpg';
                        break;
                    case IMAGETYPE_PNG :
                        $imagecreate    .= "png";
                        $imageoutput    .= "png";
                        $imageext       = '.png';
                        break;
                }
                $bs_img     = $imagecreate($basic_path);
                $qr_img     = imagecreatefrompng(PLUM_DIR_ROOT.$qrcode);//210*210

                $q_w        = imagesx($qr_img);
                $q_h        = imagesy($qr_img);
                //将二维码图片放置在指定坐标处
                $dst_x      = intval($qrcode_loc[0]);
                $dst_y      = intval($qrcode_loc[1]);
                imagecopy($bs_img, $qr_img, $dst_x, $dst_y, 0, 0, $q_w, $q_h);

                if ($expire == self::QRCODE_FOREVER_TIME) {
                    $text   = "您的二维码为永久推广二维码，永久使用，永不过期";
                } else {
                    $text   = "此二维码将于".date('Y年m月d日', $expire)."过期，过期后请重新生成";
                }
                //在推广图片底部正中写入二维码失效时间
                $tx_c   = imagecolorallocate($bs_img, 0, 0, 0);
                $fontface   = PLUM_DIR_LIB . "/captcha/font/wrvistafs.ttf"; //字体文件
                $tx_pre_w   = 14;
                $tx_w   = ceil((mb_strlen($text)+4)*$tx_pre_w);
                $tx_x   = ceil(($b_w - $tx_w)/2);
                $tx_y   = $b_h - 24;

                imagettftext($bs_img, $tx_pre_w, 0, 100, $tx_y, $tx_c, $fontface, $text);
                //头像昵称不存在时重新获取
                if (!$member['m_avatar'] && !$member['m_nickname']) {
                    $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid);

                    $userinfo       = $weixin_client->fetchUserInfo($member['m_openid']);

                    if ($userinfo) {
                        $member['m_avatar']     = $userinfo['headimgurl'];
                        $member['m_nickname']   = $userinfo['nickname'];

                        $updata = array(
                            'm_avatar'      => $userinfo['headimgurl'],
                            'm_nickname'    => $userinfo['nickname'],
                            'm_sex'         => $userinfo['sex'] == 1 ? '男' : '女',
                            'm_province'    => $userinfo['province'],
                            'm_city'        => $userinfo['city'],
                        );
                        $member_storage->updateById($updata, $member['m_id']);
                    }
                }


                //生成头像
                if ($member['m_avatar']) {
                    $avatar_url = substr($member['m_avatar'], -2) == '/0' ? substr($member['m_avatar'], 0, strlen($member['m_avatar'])-2).'/96' : $member['m_avatar'];

                    $image_data = file_get_contents($avatar_url);

                    list($a_w, $a_h, $a_type) = getimagesizefromstring($image_data);
                    $a_x    = intval($avatar_loc[0]);
                    $a_y    = intval($avatar_loc[1]);

                    if (in_array($a_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {

                        $avatar_img = imagecreatefromstring($image_data);
                        imagecopy($bs_img, $avatar_img, $a_x, $a_y, 0, 0, $a_w, $a_h);
                        imagedestroy($avatar_img);
                    }
                    //生成昵称
                    if ($member['m_nickname']) {
                        $nick   = $member['m_nickname'];

                        $nt_x   = $a_x+$a_w+10;//留出图片空间
                        $nt_y   = $a_y+20;//留出图片高度

                        imagettftext($bs_img, 18, 0, $nt_x, $nt_y, $tx_c, $fontface, $nick);
                    }
                }

                $filename   = plum_random_code(8, false) . '-' . plum_random_code(6, false) . $imageext;
                $imageoutput($bs_img, $this->hold_dir . $filename);

                imagedestroy($bs_img);
                imagedestroy($qr_img);
                $spread   = $this->access_path . $filename;
                //保存推广二维码图片
                $updata     = array(
                    'm_spread_image' => $spread
                );
                $member_storage->updateById($updata, $member['m_id']);
            }
        }
        $client_plugin = new App_Plugin_Weixin_ClientPlugin($this->sid);
        //发送图片信息
        $client_plugin->sendImageMessage($member['m_openid'], $spread);
    }

    /*
     * 记录短信
     */
    public function smsRecord($mobile, $text, $mid, $count = 1) {
        //记录成功发送的短信
        $record_sog     = new App_Model_Shop_MysqlSmsRecordStorage($this->sid);
        $indata = array(
            'sr_s_id'   => $this->sid,
            'sr_m_id'   => $mid,
            'sr_mobile' => $mobile,
            'sr_text'   => $text,
            'sr_count'  => $count,
            'sr_send_time'  => time(),
        );
        $record_sog->insertValue($indata);
        
        //设置剩余短信条数-1,已发送短信条数+1
        $smscfg_sog     = new App_Model_Plugin_MysqlSmsCfgStorage($this->sid);
        $smscfg_sog->incrementSmsTotal(-$count, $count);
    }

    /*
     * 获取店铺导航
     */
    public function fetchShopNav() {
        $menu_sog   = new App_Model_Shop_MysqlMenuStorage();
        $first      = $menu_sog->fetchFirstLevelBySid($this->sid);
        //无一级菜单,或一级菜单超出3个
        if (!$first || count($first) == 0 || count($first) > 3) {
            return false;
        }
        $button     = array();
        foreach ($first as $one) {
            $item   = array('name'  => $one['sm_name']);
            if ($one['sm_has_child']) {
                $item['sub_button'] = array();
                //二级菜单存在
                $second = $menu_sog->fetchSecondLevelByFid($one['sm_id']);
                for ($i = 0; $i < 5; $i++) {
                    if ($second[$i]) {
                        $item['sub_button'][]   = array(
                            'name'  => $second[$i]['sm_name'],
                            'link'  => $second[$i]['sm_link'],
                        );
                    } else {
                        break;
                    }
                }
            } else {
                $item['link']       = $one['sm_link'];
            }
            $button[]   = $item;
        }
        return $button;
    }

    /*
     * 检查微信公众号类型
     */
    public static function checkWeixinVerifyType($sid) {
        $wxcfg_model    = new App_Model_Auth_MysqlWeixinStorage();
        $wxcfg      = $wxcfg_model->findWeixinBySid($sid);

        $type   = self::WX_VERIFY_NO;
        if ($wxcfg && $wxcfg['wc_app_id']) {
            if ($wxcfg['wc_service_type'] == 2) {
                if ($wxcfg['wc_verify_type'] == 0) {
                    $type   = self::WX_VERIFY_YRZFWH;
                } else {
                    $type   = self::WX_VERIFY_WRZFWH;
                }
            } else {
                if ($wxcfg['wc_verify_type'] == 0) {
                    $type   = self::WX_VERIFY_YRZDYH;
                } else {
                    $type   = self::WX_VERIFY_WRZDYH;
                }
            }
        }
        return $type;
    }
    /*
     * 检查店铺是否开通微分销功能
     * 开通微分销层级,0,1,2,3
     * 未开通或已到期的店铺,微分销层级为0
     */
    public static function checkShopThreeLevel($sid, $isopen=1) {
        $level  = 0;
        $three_model    = new App_Model_Three_MysqlCfgStorage($sid);
        $three  = $three_model->findShopCfg();

        if($isopen){
            if ($three && ($three['tc_isopen'] || $three['tc_copartner_isopen'])) {
                $level  = intval($three['tc_level']);
            }
        }else{
            if ($three) {
                $level  = intval($three['tc_level']);
            }
        }

        return $level;
    }

    public function formInputField($label='提成比例',$type='ratio'){
        $level = $this->checkShopThreeLevel($this->sid);
        $html  = '';
        for($i=1;$i<=$level;$i++){
            $html  .= '<div class="space-4"></div>';
            $html  .= '<div class="form-group"><div class="input-group">';
            $html  .= '<div class="input-group-addon input-group-addon-title">'.$this->getNumberByNum($i).$label.'</div>';
            $html  .= '<input type="text" class="form-control" id="level_'.$i.'" placeholder="'.$label.'">';
            if($type == '$type'){
                $html  .= '<div class="input-group-addon">%</div>';
            }
            $html  .= '</div></div>';
        }

        return array(
            'level' => $level,
            'html'  => $html
        );
    }

    public function getNumberByNum($num){
        switch ($num){
            case 0 :
                $number = '自己';
                break;
            case 2 :
                $number = '上二级';
                break;
            case 3 :
                $number = '上三级';
                break;
            case 4 :
                $number = '上四级';
                break;
            case 5 :
                $number = '上五级';
                break;
            case 6 :
                $number = '上六级';
                break;
            default:
                $number = '上级';
        }
        return $number;
    }

    /**
     * @param $level
     * @param string $level
     * @return array
     * 表单表头字段说明
     */
    public function getThByLevel($level,$label='提成比例'){
        $th = array();
        for($i=1 ; $i <= $level ; $i++){
            $th[$i] = $this->getNumberByNum($i).$label;
        }
        return $th;
    }

    /**
     * @param $level
     * @param $pre
     * @param $suf
     * @return array
     * 表单表头字段，等级，字段前缀，字段后缀
     */
    public function getFieldByLevel($level,$pre,$suf){
        $field = array();
        if($level){
            for($i=1 ; $i <= $level ; $i++){
                $field[$i] = $pre.$i.$suf;
            }
        }
        return $field;
    }

    /**
     * @param $label
     * @param $pre
     * @param $suf
     * @return array
     * 获取表单列表的表头和列字段
     */
    public function tableThTdField($label,$pre,$suf){
        $result = array(
            'level' => $this->checkShopThreeLevel($this->sid),
            'th'    => array()
        );
        if($result['level'] >= 1){
            $result['th']    = $this->getThByLevel($result['level'],$label);
            $result['field'] = $this->getFieldByLevel($result['level'],$pre,$suf);
        }
        return $result;
    }
    /*
     * 店铺解绑微信
     */
    public function unbundWeixin() {
        $data     = array(
            'wc_app_id'         => '',
            'wc_app_secret'     => '',
            'wc_access_token'   => '',
            'wc_token_expire'   => 0,
            'wc_app_no'         => '',
            'wc_gh_id'          => '',
            'wc_service_type'   => 0,
            'wc_verify_type'    => -1,
            'wc_name'           => '',
            'wc_avatar'         => '',
            'wc_qrcode'         => '',
            'wc_follow_link'    => '',
            'wc_auth_status'    => 0,
            'wc_auth_access_token'  => '',
            'wc_auth_expire_time'   => 0,
            'wc_auth_refresh_token' => '',
            'wc_jsapi_ticket'      => '',
            'wc_jsapi_expire'       => 0,
            'wc_updatetime'         => $_SERVER['REQUEST_TIME']
        );
        //清空重置
        $weixin_model   = new App_Model_Auth_MysqlWeixinStorage();

        return $weixin_model->updateBySId($data, $this->sid);
    }
    /*
     * 检查店铺是否可以提现
     */
    public function checkShopMemberWithdraw() {
        $check_type     = self::checkWeixinVerifyType($this->sid);

        if ($check_type != self::WX_VERIFY_YRZFWH) {
            return array(
                'errno'     => -1,
                'errmsg'    => '微信红包及微信企业转账提现及支持认证的服务号。',
            );
        }

        $has_wxpay  = App_Helper_Trade::checkHasWxpay($this->sid);
        if ($has_wxpay) {//自有微信支付
            //获取微信支付配置
            $wxpay_storage  = new App_Model_Auth_MysqlWeixinPayStorage($this->sid);
            $wx_pay   = $wxpay_storage->findRowPay();
            if (!$wx_pay || strlen($wx_pay['wp_mchkey']) != 32) {
                return array(
                    'errno'     => -2,
                    'errmsg'    => "微信支付配置中支付商户号及API秘钥填写错误。",
                );
            }

            if (!$wx_pay['wp_sslcert'] || !$wx_pay['wp_sslkey']) {
                return array(
                    'errno'     => -3,
                    'errmsg'    => "微信支付配置中未上传证书。",
                );
            }
            return array(
                'errno'     => 0,
                'errmsg'    => "微信支付配置正确。微信红包、微信企业转账需要到微信支付商户平台-->产品中心开启对应功能。"
            );
        } else {//微信支付代销
            $recharge_span  = "<a href='/manage/shop/basic#recharge&amount=1000'>充值</a>";
            if ($this->shop['s_recharge'] <= 0) {
                return array(
                    'errno'     => -4,
                    'errmsg'    => "您的平台账户可用余额不足 , 请前往{$recharge_span}。",
                );
            } else {
                return array(
                    'errno'     => 0,
                    'errmsg'    => "您的平台账户可用余额为{$this->shop['s_recharge']}元,提现金额大于平台账户余额时将导致提现失败,请及时{$recharge_span}。",
                );
            }
        }
    }

    /**
     * @param $id
     * @param $key
     * 认证服务号获取关注后购买二维码
     */
    public function followToBuy($id,$key){
        $wxType         = $this->checkWeixinVerifyType($this->sid);
        if($wxType == self::WX_VERIFY_YRZFWH){ //认证的服务号
            switch($key){
                case 'group':
                    $str    = App_Helper_Group::GROUP_GROUP_KIND . '|' . $id;
                    $field  = 'gb_share_qrcode';
                    $model  = new App_Model_Group_MysqlBuyStorage($this->sid);
                    break;
                case 'goods':
                    $str    = 'goods|' . $id;
                    $field  = 'g_share_qrcode';
                    $model  = new App_Model_Group_MysqlBuyStorage($this->sid);
                    break;
            }
            if(isset($model) && isset($str) && isset($field)){
                $weixin_plugin  = new App_Plugin_Weixin_ClientPlugin($this->sid);
                $result         = $weixin_plugin->fetchSecnestrQrcode($str);
                if(isset($result['url']) && $result['url']){
                    $set = array($field => $result['url']);
                    $model->getRowUpdateByIdSid($id,$this->sid,$set);
                }
            }
        }
    }
    /*
     * 拉取已关注的会员
     */
    public function pullFollowedUser() {
        set_time_limit(0);
        $sid    = $this->sid;
        $weixin_client  = new App_Plugin_Weixin_ClientPlugin($sid);
        $next_openid    = null;
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();

        do {
            $data   = $weixin_client->fetchAllUserList($next_openid);
            $count  = 0;
            Libs_Log_Logger::outputLog($data);
            if ($data) {
                $total  = intval($data['total']);
                $count  = intval($data['count']);
                $next_openid    = $data['next_openid'];
                $list   = $data['data']['openid'];
                foreach ($list as $item ) {
                    $exist  = $member_model->findUpdateMemberByWeixinOpenid($item, $sid);
                    if (!$exist) {
                        $member = $weixin_client->fetchUserInfo($item);
                        if ($member && $member['subscribe']) {
                            $indata = array(
                                'm_s_id'        => $sid,
                                'm_c_id'        => $this->shop['s_c_id'],
                                'm_openid'      => $item,
                                'm_nickname'    => $member['nickname'],
                                'm_avatar'      => $member['headimgurl'],
                                'm_sex'         => $member['sex'] == 1 ? '男' : '女',
                                'm_province'    => $member['province'],
                                'm_city'        => $member['city'],
                                'm_union_id'    => $member['unionid'] ? $member['unionid'] : '',
                                'm_is_follow'   => 1,
                                'm_follow_time' => date('Y-m-d H:i:s', $member['subscribe_time']),
                                'm_is_slient'   => 0,//置为非观望者
                            );
                            $member_model->insertShopNewMember($sid, $indata);
                        }
                        usleep(300);
                    }
                }
            }
        } while($count == 10000);
    }    
}