<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/8/1
 * Time: 下午5:05
 */

class App_Controller_Applet_MemberController extends App_Controller_Applet_InitController
{
    public function __construct()
    {
        parent::__construct();

    }

    //我的接口
    public function meAction(){
        $member = $this->member;
        $data = array(
            'id' => $member['m_id'],
            'nickname' => $member['m_nickname'],
            'avatar'   => $this->dealImagePath($member['m_avatar']),
        );
        $data['is_vip'] = 0;//是否开通VIP
        if($member['m_vip_end_time'] > time()){
            $data['is_vip'] = 1;
        }

    }


    public function meDataAction(){
        $member = $this->member;
        $data   = array(
            'avatar'   => $this->dealImagePath($member['m_avatar']),
            'realname' => $member['m_realname'],
            'mobile'   => $member['m_mobile'],
            'pro'      => $member['m_pro_name'],
            'city'     => $member['m_city_name'],
            'area'     => $member['m_area_name'],
            'address'  => $member['m_address'],
            'brief'    => $member['m_brief']
        );
        $this->displayJsonSuccess($data,true,'获取成功');
    }

    public function saveDataAction() {
        $data['m_avatar']     = $this->request->getStrParam('avatar');
        $data['m_realname']   = $this->request->getStrParam('realname');
        $data['m_mobile']     = $this->request->getStrParam('mobile');
        $data['m_pro_name']    = $this->request->getStrParam('pro');
        $data['m_pro_name']   = $this->request->getStrParam('city');
        $data['m_area_name']   = $this->request->getStrParam('area');
        $data['m_address']    = $this->request->getStrParam('address');
        $data['m_brief']      = $this->request->getStrParam('brief');
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member_storage->updateById($data, $this->member['m_id']);
        $info = array(
            'data' => "修改成功"
        );
        $this->outputSuccess($info);
    }


//   public function findareaAction(){
//        $id   = $this->request->getIntParam('id');
//        $type = $this->request->getIntParam('type');
//        $address_model = new App_Model_Address_MysqlAddressCoreStorage();
//        $where[]       = array('name'=>'parent_id','oper'=>'=','value'=>$id);
//        $where[]       = array('name'=>'region_type','oper'=>'=','value'=>$type);
//        $list          = $address_model->getList($where,0,0,array());
//        foreach ($list as $val){
//            $info['pro'] = array(
//                'id'   => $val['region_id'],
//                'name' => $val['region_name']
//            );
//        }
//        if($list){
//            $this->outputSuccess($info);
//        }else{
//            $this->displayJsonError('没有数据');
//        }
//    }


    public function getstreetAction(){
        $level = $this->request->getIntParam('level');
        $fid   = $this->request->getStrParam('fid');
        $data  = $this->getArea($level,$fid);
        $ret   = array(
            'ec' => 200,
            'em' => '获取成功',
            'data' => $data
        );
        $this->displayJson($ret);
    }

    public function findareaAction(){
        $level = $this->request->getIntParam('level');
        $fid   = $this->request->getIntParam('fid');
        if($level == 1){
            $pro  = $this->getArea($level,$fid);
            foreach($pro as $key=>$val){
                $city  = $this->getArea(2,$val['id']);
                $citylist   = array();
                foreach ($city as $k => $v){
                    $area = $this->getArea(3,$v['id']);
                    $arealist   = array();
                    foreach($area as $vv){
                        $arealist[] = array(
                            'id'   => $vv['id'],
                            'name' => $vv['name'],
                        );
                    }
                    $citylist[] = array(
                        'id'   => $v['id'],
                        'name' => $v['name'],
                        'arealist' => $arealist
                    );
                }
                $data['prolist'][] = array(
                    'id'   => $val['id'],
                    'name' => $val['name'],
                    'citylist' => $citylist,
                );
            }

        }else{
            $data  = $this->getArea($level,$fid);
        }

        $this->displayJson($data);
    }
    public function getArea($level,$fid = 0){
        $url = 'http://api.tianapi.com/txapi/area/index';
        $params = array(
            'key'      => 'd6b1178a4f609db55cf5565c555d41d1',
        );
        if($level == 1){
            $params['country'] = 1;
        }elseif($level == 2){
            $params['province'] = $fid;
        }elseif($level == 3){
            $params['city']     = $fid;
        }elseif($level == 4){
            $params['county']   = $fid;
        }
        $res      = Libs_Http_Client::get($url, $params);
        $ret      = json_decode($res, 1);

        if($ret['newslist']){
            if($level == 1){
                foreach ($ret['newslist']  as $val){
                    $data[] = array(
                        'id'   => $val['provinceid'],
                        'name' => $val['provincename']
                    );
                }

            }elseif($level == 2){
                foreach ($ret['newslist']  as $val) {
                    $data[] = array(
                        'id'   => $val['cityid'],
                        'name' => $val['cityname']
                    );
                }
            }elseif($level == 3){
                foreach ($ret['newslist']  as $val) {
                    $data[] = array(
                        'id'   => $val['countyid'],
                        'name' => $val['countyname']
                    );
                }
            }elseif($level == 4){
                foreach ($ret['newslist']  as $val) {
                    $data[] = array(
                        'id'   => $val['townid'],
                        'name' => $val['townname']
                    );
                }
            }
            return $data;
        }
        return [];
    }


    public function saveareaAction(){
      	  // Libs_Log_Logger::outputLog(111,'three.log');
        $pro    = $this->request->getStrParam('pro');
        $city   = $this->request->getStrParam('city');
        $area   = $this->request->getStrParam('area');
        $street = $this->request->getStrParam('street');
        $pro_name    = $this->request->getStrParam('pro_name');
        $city_name   = $this->request->getStrParam('city_name');
        $area_name   = $this->request->getStrParam('area_name');
        $street_name = $this->request->getStrParam('street_name');
        $data['m_pro_id']    = $pro;
        $data['m_city_id']   = $city;
        $data['m_area_id']   = $area;
        $data['m_street_id'] = $street;
        $data['m_pro_name']    = $pro_name;
        $data['m_city_name']   = $city_name;
        $data['m_area_name']   = $area_name;
        $data['m_street_name'] = $street_name;
        $data['m_is_area']     = 1;
        $member_model  = new App_Model_Member_MysqlMemberCoreStorage();
        $ret           = $member_model->updateById($data,$this->member['m_id']);
        if($ret && $this->member['m_1f_id'] == 0 && $this->member['m_is_highest'] == 0){
            $where       =  array();
            $area_model   = new App_Model_Three_MysqlThreeAreaStorage($this->curr_sid);
            $where[]      = array('name'=>'ta_pro','oper'=>"=",'value'=>$pro);
            $where[]      = array('name'=>'ta_area','oper'=>"=",'value'=>$area);
            $where[]      = array('name'=>'ta_city','oper'=>"=",'value'=>$city);
            $where[]      = array('name'=>'ta_street','oper'=>"=",'value'=>$street);
            $row          = $area_model->getRow($where);
           //Libs_Log_Logger::outputLog(row['ta_m_id'],'three.log');
            if($row && $row['ta_m_id'] != $this->member['m_id']){
                //$update['m_1f_id'] = $row['m_id'];
                // $member_model->updateById($update,$this->member['m_id']);
                App_Helper_MemberLevel::setLevelSendMessage($this->shop['s_id'], $this->member['m_id'], $row['ta_m_id']);
            }
        }
        if($ret){
            $request = array(
                'ec' => 200,
                'em' => '保存成功'
            );
        }else{
            $request = array(
                'ec' => 400,
                'em' => '保存失败'
            );
        }
        $this->displayJson($request);

    }


    /**
     * 根据经纬度解析详细地址
     * @param  [type] $lng [经度]
     * @param  [type] $lat [纬度]
     * @return [type]      [description]
     */
    public function getAddressFromLngLat($lng,$lat){
        $url = 'https://restapi.amap.com/v3/geocode/regeo';
        $params = array(
            'location' => $lng.','.$lat,
            'key'      => plum_parse_config('mapKay'),
        );
        $res      = Libs_Http_Client::get($url, $params);
        Libs_Log_Logger::outputLog($res,'member.log');
        $location = json_decode($res, 1);
        if($location['status'] == 1){
            $location_obj = $location['regeocode']['addressComponent'];
            $province = $location_obj['province'];
            $city     = $location_obj['city'];
            $area     = $location_obj['district'];
            return [
                'pro'   => $province,
                'city'  => is_array($city) ? '' : $city,
                'area'  => is_array($area) ? '' : $area,
            ];
        }
        return [];
    }

    /**
     * 验证会员信息
     */
    public function userInfoAction()
    {
        $member     = $this->member;
        if (empty($member)) {
            $this->outputError('获取用户信息失败或账号已被禁用');
        }
        $info['data']   = [
            'mid'                 => $member['m_id'],
            'nickname'            => $member['m_nickname'],
            'avatar'              => $member['m_avatar'] ? $this->dealImagePath($member['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
            'sex'                 => $member['m_sex'],
            'slient'              => $member['m_is_slient'],
            'mobile'              => isset($member['m_mobile']) ? $member['m_mobile'] : '',
            'plum_session_applet' => session_id(),
            'followTime'          => $member['m_follow_time'],
        ];

        $this->outputSuccess($info);
    }

    /**
     * 验证会员信息
     */
    public function userInfoNewAction()
    {
        $shareMid   = $this->request->getIntParam('shareMid');
        $appletType = $this->request->getIntParam('appletType');
        $member     = $this->member;
        if (empty($member)) {
            $this->outputError('获取用户信息失败或账号已被禁用');
        }
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $where[]        = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]        = array('name' => 't_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[]        = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_FINISH);
        $total          = $trade_model->getCount($where);
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        $level          = $offline_member->currLevel($this->member['m_id']);
        $info['data']   = [
            'appid'               => $this->applet_cfg['ac_appid'],
            'mid'                 => $member['m_id'],
            'showId'              => $member['m_show_id'],
            'nickname'            => $member['m_nickname'],
            'unionId'             => $member['m_union_id'] ? $member['m_union_id'] : '',
            'avatar'              => $member['m_avatar'] ? $this->dealImagePath($member['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
            'sex'                 => $member['m_sex'],
            'slient'              => $member['m_is_slient'],
            'money'               => (float) $member['m_gold_coin'],
            'points'              => $member['m_points'],
            'mobile'              => isset($member['m_mobile']) ? $member['m_mobile'] : '',
            'isVip'               => $member['m_level_long'] > time() ? 1 : 0,
            'plum_session_applet' => session_id(),
            'level'               => $this->_get_level_name($level ? $level : $member['m_level']),
            'deduct_ktx'          => (float) $member['m_deduct_ktx'],
            'deduct_ytx'          => (float) $member['m_deduct_ytx'],
            'deduct_dsh'          => (float) $member['m_deduct_dsh'],
            'followTime'          => $member['m_follow_time'],
            'isdistrib'           => ($member['m_is_highest'] > 0 || $member['m_1f_id'] > 0) ? 1 : 0,
            'isapply'             => $this->_is_apply_branch($member),
            'total'               => $total,
            'haveCard'            => $this->_check_member_card($member['m_id']) || $this->_check_vcaimao_card()['memberData'] ? 1 : 0,
            'haveVcmCard'         => $this->_check_vcaimao_card() ? 1 : 0,
            'haveUnionid'         => isset($member['m_union_id']) && $member['m_union_id'] && ($this->_check_vcaimao_card() || !$this->_check_vcaimao_card()) ? 1 : 0,
            'iosShow'             => $this->_is_open_apply(),
            'shareAlertShow'      => 0,
            'shareAlertNote'      => '',
            'goodsfee_ktx'        => 0,
            'goodsfee_ytx'        => 0,
            'goodsfee_dsh'        => 0,
        ];
        //多维度币种账户的，则显示多币种账户数据，目前只真对7126号店铺
        if ($this->sid == 7126) {
            $account_model = new App_Model_City_MysqlCityAccountStorage($this->sid);
            $list          = $account_model->getListByMid($this->uid);
            $temp          = array();
            foreach ($list as $val) {
                $temp[] = array(
                    'id'    => $val['aca_acc_id'],
                    'title' => $val['aca_acc_name'],
                    'ktx'   => $val['aca_ktx'],
                );
            }
            $info['data']['account'] = $temp;
        }

        $extra_model                  = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
        $extra                        = $extra_model->findUpdateExtraByMid($member['m_id']);
        $info['data']['educationArr'] = array('高中', '专科', '本科', '硕士', '博士', '博士后');
        $info['data']['education']    = $extra['ame_education'] ? $extra['ame_education'] : '';
        $info['data']['industry']     = $extra['ame_industry'] ? $extra['ame_industry'] : '';
        $info['data']['profession']   = $extra['ame_profession'] ? $extra['ame_profession'] : '';
        $info['data']['birth']        = $extra['ame_birth'] ? $extra['ame_birth'] : '';

        if ($this->applet_cfg['ac_type'] == 33) {
            $share_model                = new App_Model_Car_MysqlCarShareDeductStorage($this->sid);
            $shareSum                   = $share_model->getSum($member['m_id']);
            $info['data']['deduct_car'] = $shareSum ? floatval($shareSum) : 0;
        } else if ($this->applet_cfg['ac_type'] == 34 || $this->sid == 4546) {
            $share_model                    = new App_Model_Legwork_MysqlLegworkShareDeductStorage($this->sid);
            $shareSum                       = $share_model->getSum($member['m_id']);
            $info['data']['deduct_legwork'] = $shareSum ? floatval($shareSum) : 0;
        } else if ($this->applet_cfg['ac_type'] == 32) {
            $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->sid);
            $leader       = $leader_model->getRowByMid($member['m_id']);
            if ($leader) {
                switch ($leader['asl_status']) {
                    case 1:
                        $info['data']['leaderMsg']    = '您的申请已经提交，请耐心等待';
                        $info['data']['leaderReason'] = '';
                        $info['data']['tzcenterShow'] = 0;
                        break;
                    case 2:
                        $info['data']['leaderMsg']    = '';
                        $info['data']['leaderReason'] = '';
                        $info['data']['tzapplyShow']  = 0;
                        break;
                    case 3:
                        $info['data']['leaderMsg']    = '很遗憾，您的申请未通过平台审核';
                        $info['data']['leaderReason'] = $leader['asl_handle_remark'] ? $leader['asl_handle_remark'] : '';
                        $info['data']['tzcenterShow'] = 0;
                        break;
                    case 4:
                        $info['data']['leaderMsg']    = '管理员撤销了您的团长身份';
                        $info['data']['leaderReason'] = '';
                        $info['data']['tzcenterShow'] = 0;
                        break;
                }
                $info['data']['leaderStatus'] = intval($leader['asl_status']);
            } else {
                $info['data']['leaderStatus'] = 0;
                $info['data']['leaderMsg']    = '';
                $info['data']['leaderReason'] = '';
                $info['data']['tzcenterShow'] = 0;
            }

            if ($shareMid) {
                $share_extra = $extra_model->findUpdateExtraByMid($shareMid);
                if ($share_extra['ame_se_cid'] && !$extra['ame_se_cid']) {
                    if ($extra) {
                        $com_res = $extra_model->findUpdateExtraByMid($member['m_id'], ['ame_se_cid' => $share_extra['ame_se_cid']]);
                    } else {
                        $extra_insert = [
                            'ame_s_id'        => $member['m_s_id'],
                            'ame_m_id'        => $member['m_id'],
                            'ame_se_cid'      => $share_extra['ame_se_cid'],
                            'ame_create_time' => time(),
                            'ame_update_time' => time(),
                        ];
                        $com_res = $extra_model->insertValue($extra_insert);
                    }
                }
            }
        } else if ($this->applet_cfg['ac_type'] == 37 || $this->sid == 10043) {
            $rider_model = new App_Model_Handy_MysqlHandyRiderStorage($this->sid);
            $rider       = $rider_model->findRowByMid($member['m_id']);
            if ($rider) {
                $info['data']['goodsfee_ktx'] = (float) $rider['ahr_goodsfee_ktx'];
                $info['data']['goodsfee_ytx'] = (float) $rider['ahr_goodsfee_ytx'];
                $info['data']['goodsfee_dsh'] = (float) $rider['ahr_goodsfee_dsh'];
            }
        }


        $this->outputSuccess($info);
    }

    private function signAppletForToutiao(&$info){
        //抖音报名小程序
        if ($this->applet_cfg['ac_type'] == 38) {
            $info['data']['remind_id']  = 0;
            $info['data']['remind_num'] = 0;
            $info['data']['isnewuser']  = 1;
            //活动审核通过通知
            //是否有刚审核通过的活动
            $activity_model = new App_Model_Enroll_MysqlEnrollActivityCoreStorage($this->sid);
            $where          = array();
            $where[]        = array('name' => 'aea_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]        = array('name' => 'aea_m_id', 'oper' => '=', 'value' => $this->uid);
            $where[]        = array('name' => 'aea_has_reminded', 'oper' => '=', 'value' => 0);
            $where[]        = array('name' => 'aea_status', 'oper' => '=', 'value' => 2);
            $activity       = $activity_model->getList($where, 0, 5);

            if ($activity) {
                $info['data']['remind_id']  = $activity[0]['aea_id'];
                $info['data']['remind_num'] = count($activity);
            }

            //如果没有发布过活动就是新用户
            $where    = array();
            $where[]  = array('name' => 'aea_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]  = array('name' => 'aea_m_id', 'oper' => '=', 'value' => $this->uid);
            $field    = array('aea_id');
            $activity = $activity_model->getRowContainDeleted($where, $field);
            if ($activity) {
                $info['data']['isnewuser'] = 0;
            }
        }
    }

    /*
     * 判断是否购买过会员卡且未到期
     * 包括计次卡和折扣卡
     */
    private function _check_member_card($mid)
    {
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        $where[]        = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]        = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        $where[]        = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time()); //未到期
        $member_card    = $offline_member->getList($where, 0, 0, array('om_update_time' => 'desc'));
        if ($member_card) {
            return 1;
        } else {
            return 0;
        }
    }

    /*
     * 判断是否开通了微财猫会员卡
     */
    private function _check_vcaimao_card()
    {
        //查询是否已经开通了微财猫会员卡
        $vcm_model = new App_Model_Wechat_MysqlVcmWxpayStorage($this->sid);
        $cfg       = $vcm_model->findUpdateBySid();
        if ($cfg && $cfg['vw_device_id'] && $cfg['vw_pay_secret'] && $cfg['vw_isopen']) {
            //获取微财猫微信会员信息
            $client     = new App_Plugin_Vcaimao_PayClient($this->sid);
            $memberInfo = $client->getMemberInfo($this->member['m_union_id'], $this->member['m_openid']);
            if ($memberInfo && !$memberInfo['errcode'] && $memberInfo['data']) {
                $cfg['memberData'] = $memberInfo['data'];
            }
            return $cfg;
        }
        return false;
    }

    /**
     * 判断是否申请过分销员
     */
    private function _is_apply_branch($member)
    {
        $ispply       = 0;
        $branch_model = new App_Model_Shop_MysqlShopBranchStorage($this->sid);
        $row          = $branch_model->findBranchByMid($member['m_id']);
        if ($row) {
            if ($row['sb_status'] == 0) {
                // 正在审核中
                $ispply = 1;
            } elseif ($row['sb_status'] == 2) {
                // 被拒绝
                $ispply = 0;
            } else {
                // 已通过
                if (($member['m_is_highest'] > 0 || $member['m_1f_id'] > 0)) {
                    $ispply = 2;
                } else {
                    $ispply = 0;
                }
            }
        } else {
            $ispply = 0;
        }
        return $ispply;
    }

    /*
     * 查询是否开启iOS的分销申请功能
     */
    private function _is_open_apply()
    {
        //@todo 查询分销配置
        $copartner_cfg = new App_Model_Three_MysqlCfgStorage($this->sid);
        $tcRow         = $copartner_cfg->findShopCfg();
        $iosapply      = $tcRow && $tcRow['tc_ios_apply'] ? $tcRow['tc_ios_apply'] : 0;
        return $iosapply;
    }

    /**
     * 获取会员等级名称
     */
    private function _get_level_name($id)
    {
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $level       = $level_model->getRowById($id);
        $name        = $level ? $level['ml_name'] : '';
        return $name;
    }

    /**
     * 会员页
     */
    public function memberLevelAction()
    {
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        $level          = $offline_member->currLevel($this->member['m_id']);
        $level_model    = new App_Model_Member_MysqlLevelStorage();
        $level          = $level_model->getRowById($level ? $level : $this->member['m_level']);
        $list           = $level_model->getListBySid($this->sid, 0);
        $info['data']   = array(
            'level' => $level ? $level['ml_name'] : '普通会员',
            'list'  => $this->_format_level($list),
        );
        $this->outputSuccess($info);
    }

    /**
     * 格式化会员等级列表
     */
    private function _format_level($list)
    {
        $data = array();
        foreach ($list as $val) {
            $data[] = array(
                'name'  => $val['ml_name'],
                'brief' => $val['ml_desc'],
            );
        }
        return $data;
    }

    /**
     * 修改会员信息
     */
    public function updateMemberInfoAction()
    {
        $avatar     = $this->request->getStrParam('avatar');
        $nickname   = $this->request->getStrParam('nickname');
        $mobile     = $this->request->getStrParam('mobile');
        $sex        = $this->request->getStrParam('sex');
        $city       = $this->request->getStrParam('city');
        $province   = $this->request->getStrParam('province');
        $education  = $this->request->getStrParam('education');
        $industry   = $this->request->getStrParam('industry');
        $profession = $this->request->getStrParam('profession');
        $birth      = $this->request->getStrParam('birth');
        $comId      = $this->request->getIntParam('comId', 0);
        $updata     = array();
        if ($avatar) {
            $updata['m_avatar'] = $avatar;
        }
        if ($nickname) {
            $updata['m_nickname'] = $nickname;
        }
        if ($city) {
            $updata['m_c ity'] = $city;
        }
        if ($province) {
            $updata['m_province'] = $province;
        }
        if ($sex) {
            $sex             = in_array($sex, array('男', '女')) ? $sex : '无';
            $updata['m_sex'] = $sex;
        }
        if ($mobile && plum_is_mobile_phone($mobile)) {
            $updata['m_mobile'] = $mobile;
        }
        if ($education) {
            $extraUpdata['ame_education'] = $education;
        }
        if ($industry) {
            $extraUpdata['ame_industry'] = $industry;
        }
        if ($profession) {
            $extraUpdata['ame_profession'] = $profession;
        }
        if ($birth) {
            $extraUpdata['ame_birth'] = $birth;
        }
        if ($comId) {
            $updata['m_se_community'] = $comId;
        }
        // 获取用户unionID
        $userinfo = $this->_fetch_member_info();
        if ($userinfo) {
            $updata['m_union_id'] = $userinfo['unionId'];
        }
        if (!empty($updata) || !empty($extraUpdata)) {
            if ($avatar != $this->member['m_avatar']) {
                if (strpos($avatar, 'http') !== false) {
                    //如果头像是外部链接
                    $dl_avatar                    = $this->_download_member_avatar($avatar);
                    $extraUpdata['ame_dl_avatar'] = $dl_avatar;
                } else {
                    $extraUpdata['ame_dl_avatar'] = $avatar;
                }
            }
            $updata['m_is_slient'] = 0;
            $member_storage        = new App_Model_Member_MysqlMemberCoreStorage();
            $member_storage->updateById($updata, $this->member['m_id']);
            if (!empty($extraUpdata)) {
                $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
                $extra       = $extra_model->findUpdateExtraByMid($this->member['m_id']);
                if (!$extra) {
                    $extraUpdata['ame_s_id'] = $this->sid;
                    $extraUpdata['ame_m_id'] = $this->member['m_id'];
                    $extra_model->insertValue($extraUpdata);
                } else {
                    $extra_model->updateById($extraUpdata, $extra['ame_id']);
                }
            }
            $info = array(
                'data' => "修改成功",
            );
            //用户更新完头像后删除他分享过的所有的二维码 修复 用户头像更换后生成的新商品二维码还是老的头像的问题
            //zhangzc
            //2019-08-13
            if ($this->member['m_id']) {
                $code_model = new App_Model_Goods_MysqlGoodsCodeStorage($this->sid);
                $code_model->deleteValue([
                    ['name' => 'agc_m_id', 'oper' => '=', 'value' => $this->member['m_id']],
                ]);
            }

            $this->outputSuccess($info);

        } else {
            $this->outputError("修改失败，请重试");
        }
    }

    private function _download_member_avatar($img)
    {
        list($usec, $sec) = explode(" ", microtime());
        $md5              = strtoupper(md5($usec . $sec));
        $name             = substr($md5, 0, 8) . '-' . substr($md5, 10, 4) . '-' . mt_rand(1000, 9999) . '-' . substr($md5, 20, 12);
        $filename         = PLUM_DIR_UPLOAD . '/depot/thumbnail/' . $name . '.png';
        $filepath         = PLUM_PATH_UPLOAD . '/depot/thumbnail/' . $name . '.png';
        if (!file_exists($filename)) {
            // $hander = curl_init();
            // $fp = @fopen($filename,'wb');
            // curl_setopt($hander,CURLOPT_URL,$img); //需要获取的url地址
            // curl_setopt($hander,CURLOPT_FILE,$fp); //设置输出文件的位置
            // curl_setopt($hander,CURLOPT_HEADER,0); //启用时会将头文件的信息作为数据流输出
            // curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1); //启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器
            // curl_setopt($hander,CURLOPT_TIMEOUT,60); //设置cURL允许执行的最长秒数
            // curl_setopt($hander,CURLOPT_RETURNTRANSFER,1); //将curl_exec()获取的信息以文件流的形式返回，而不是直接输出
            // curl_exec($hander);
            // curl_close($hander);
            // fclose($fp);
            $img = file_get_contents($img);
            file_put_contents($filename, $img);
            //数据同步操作
            try {
                $sync = new Libs_Image_DataSync();
                $sync->pushQueue($filepath);
            } catch (Exception $e) {
                Libs_Log_Logger::outputLog($e->getMessage() . ':' . $filepath, 'imgsrc.log');
            }
        }
        return $filepath;

    }

    /**
     * 修改手机号
     */
    public function savePhoneAction()
    {
        $code          = $this->request->getStrParam('code'); // 用户code
        $iv            = $this->request->getStrParam('iv'); // 加密算法的初始向量
        $encryptedData = $this->request->getParam('encryptedData'); // 加密后的数据
        $appid         = $this->request->getStrParam('appid'); // 小程序APPID

        if ($code) {
            // 通过code换取用户的openID
            //$result = App_Helper_WeixinEvent::getWxopenid($this->applet_cfg['ac_appid'],$this->applet_cfg['ac_appsecret'],$code);
            if ($appid && mb_strlen($appid) == 18) {
                $curr_appid = $appid;
            } else {
                $curr_appid = $this->applet_cfg['ac_appid'];
            }
            if ($this->appletType == 4) {
                $toutiao_client = new App_Plugin_Toutiao_XcxClient();
                $result         = $toutiao_client::getToutiaoOpenid($curr_appid, $this->applet_cfg['ac_appsecret'], $code);
            } else {
                $result = App_Helper_WeixinEvent::getWxopenid($curr_appid,$this->applet_cfg['ac_appsecret'],$code);
            }

            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            // 获取到用户的openID
            if ($result) {
                if ($result['session_key'] && $iv && $encryptedData) {
                    $mobileinfo = $this->_get_user_info($result['session_key'], $iv, $encryptedData);
                    if ($mobileinfo) {
                        $data = array(
                            'm_mobile' => $mobileinfo['phoneNumber'],
                        );
                        $uid = $member_storage->getRowUpdateByIdSid($this->member['m_id'], $this->sid, $data);
                        //是否开开通了客服记录插件 且开启了手机号绑定
                        if ($this->checkToolUsable('kf') && $this->applet_cfg['ac_kefu_mobile']) {
                            $record_model = new App_Model_Member_MysqlKefuUseStorage($this->sid);
                            $record       = $record_model->findUpdateByMid($this->member['m_id']);
                            if ($record) {
                                $set = array(
                                    'kur_mobile'      => $mobileinfo['phoneNumber'],
                                    'kur_update_time' => time(),
                                );
                                $record_model->findUpdateByMid($this->member['m_id'], $set);
                            } else {
                                $set = array(
                                    'kur_s_id'        => $this->sid,
                                    'kur_m_id'        => $this->member['m_id'],
                                    'kur_mobile'      => $mobileinfo['phoneNumber'],
                                    'kur_update_time' => time(),
                                    'kur_create_time' => time(),
                                );
                                $record_model->insertValue($set);
                            }
                        }

                        $info = array(
                            'data' => $mobileinfo['phoneNumber'],
                        );
                        $this->outputSuccess($info);
                    } else {
                        $this->outputError('获取信息失败，请重试。');
                    }
                } else {
                    $this->outputError('获取信息失败，请重试。。');
                }
            } else {
                $this->outputError('获取用户信息失败.');
            }
        } else {
            $this->outputError('获取用户信息失败..');
        }
    }

    /*
     * encryptedData和iv解密获取用户信息
     */
    public function _get_user_info($sessionKey, $iv, $encryptedData)
    {
        if ($sessionKey && $iv && $encryptedData) {
            // 解密数据
            $wxBizDataCrypt = new App_Plugin_Weixin_DecryptInfo();
            $decryptData    = $wxBizDataCrypt->getUserInfo($this->curr_appid, $sessionKey, $encryptedData, $iv);
            $userInfo       = json_decode($decryptData['data'], true);
            if ($decryptData['code'] == 0) {
                return $userInfo;
            }
        }
        return false;
    }

    /**
     * 会员中心配置显示信息
     */
    public function memberCenterAction()
    {
        $center_model = new App_Model_Member_MysqlCenterToolStorage();
        $row          = $center_model->findUpdateBySid($this->sid);
        if (empty($row)) {
            $row = plum_parse_config('center_tool');
        }
        //判断是否开启了名片插件，不再做验证
        if ($this->checkToolUsable('mpj')) {
            $mpjOpen = 1;
        } else {
            $mpjOpen = 1;
        }
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        $level          = $offline_member->currLevel($this->member['m_id']);
        $member         = $this->member;
        $info['data']   = array(
            'verifyMobile'       => intval($row['ct_verify_mobile']),
            'nickname'           => $member['m_nickname'],
            'points'             => $member['m_points'],
            'level'              => $this->_get_level_name($level ? $level : $member['m_level']),
            'coin'               => $member['m_gold_coin'],
            'mobile'             => $member['m_mobile'] ? $member['m_mobile'] : '',
            'haveCard'           => $this->_check_member_card($member['m_id']),
            'avatar'             => $member['m_avatar'] ? $this->dealImagePath($member['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
            'title'              => $row['ct_center_title'], // 顶部标题
            'background'         => $this->_deal_center_background($row), // 背景
            'color'              => $row['ct_center_color'], // 字体显示颜色
            'qdan_show'          => $row['ct_qdan_show'], //签到按钮显示
            'myptShow'           => intval($row['ct_mypt_show']), //我的拼团
            'mycjShow'           => $row['ct_mycj_show'], //我的抽奖
            'myfxShow'           => intval($row['ct_myfx_show']), //分销中心
            'myactShow'          => intval($row['ct_myact_show']), //账户充值
            'myjfShow'           => 0, #$row['ct_myjf_show'],//我的积分
            'myyhqShow'          => intval($row['ct_myyhq_show']), //优惠券
            'mywithShow'         => intval($row['ct_mywith_show']), //余额提现
            'myinfoShow'         => 0, #$row['ct_myinfo_show'],//修改资料
            'myaddrShow'         => intval($row['ct_myaddr_show']), //地址管理
            'mycartShow'         => intval($row['ct_mycart_show']), //购物车
            'myscShow'           => intval($row['ct_mysc_show']), //收藏
            'myftShow'           => intval($row['ct_myft_show']), //发帖
            'myplShow'           => intval($row['ct_mypl_show']), //评论
            'myddShow'           => intval($row['ct_mydd_show']), //订单
            'mylpqShow'          => intval($row['ct_mylpq_show']), //礼品券
            'jfshopShow'         => intval($row['ct_jfshop_show']), //积分商城
            'bespeakShow'        => intval($row['ct_mybespeak_show']), //我的预约
            'serviceShow'        => intval($row['ct_service_show']), //客服电话
            'aboutusShow'        => intval($row['ct_aboutus_show']), //关于我们
            'myvipShow'          => 0, #$row['ct_myvip_show'],//特级会员
            'mycardShow'         => intval($row['ct_mycard_show']), //我的会员
            'kefuShow'           => intval($row['ct_kefu_show']), //客服
            'partnerShow'        => 0, #$row['ct_partner_show'],//合伙人
            'regionShow'         => 0, #$row['ct_region_show'],//区域代理商
            'mybrShow'           => intval($row['ct_mybr_show']), //我的足迹
            'goodsDeductShow'    => (intval($row['ct_mygd_show']) && $this->shop['s_goods_deduct']) ? 1 : 0, //单品分销商品列表
            'goodsDeductName'    => $row['ct_mygd_name'], //单品分销商品列表
            'shareProfitShow'    => (intval($row['ct_mygdp_show']) && $this->shop['s_goods_deduct']) ? 1 : 0, //单品分销收益
            'shareProfitName'    => $row['ct_mygdp_name'], //单品分销收益
            'mobileBookShow'     => intval($row['ct_mobilebook_show']), //电话本显示
            'mobileBookName'     => $row['ct_mobilebook_name'], //电话本名称
            'myptName'           => $row['ct_mypt_name'], //分销中心
            'mycjName'           => $row['ct_mycj_name'], //分销中心
            'myfxName'           => $row['ct_myfx_name'], //分销中心
            'myactName'          => $row['ct_myact_name'], //账户充值
            'myjfName'           => $row['ct_myjf_name'],
            'myyhqName'          => $row['ct_myyhq_name'], //优惠券
            'mywithName'         => $row['ct_mywith_name'], //余额提现
            'myinfoName'         => $row['ct_myinfo_name'], //修改资料
            'myaddrName'         => $row['ct_myaddr_name'], //地址管理
            'mycartName'         => $row['ct_mycart_name'], //购物车
            'myvipName'          => $row['ct_myvip_name'], //特级会员
            'mycardName'         => $row['ct_mycard_name'], //我的会员
            'myscName'           => $row['ct_mysc_name'], //收藏
            'mybrName'           => $row['ct_mybr_name'],
            'myftName'           => $row['ct_myft_name'], //发帖
            'myplName'           => $row['ct_mypl_name'], //评论
            'myddName'           => $row['ct_mydd_name'], //订单
            'mylpqName'          => $row['ct_mylpq_name'], //礼品券
            'partnerName'        => $row['ct_partner_name'], //特级会员
            'kefuName'           => $row['ct_kefu_name'], //客服
            'regionName'         => $row['ct_region_name'],
            'advertShow'         => intval($row['ct_advert_show']), //广告显示
            'jfshopName'         => $row['ct_jfshop_name'], //积分商城名称
            'bespeakName'        => $row['ct_mybespeak_name'], //我的预约名称
            'serviceName'        => $row['ct_service_name'], //客服电话名称
            'aboutusName'        => $row['ct_aboutus_name'], //关于我们名称
            'informationShow'    => intval($row['ct_myread_show']), //付费阅读是否显示
            'informationName'    => $row['ct_myread_name'], //付费阅读名称
            'myyqmShow'          => intval($row['ct_myyqm_show']), //邀请码是否显示
            'myyqmName'          => $row['ct_myyqm_name'], //邀请码名称
            'mystudyShow'        => intval($row['ct_mystudy_show']), //学习情况是否显示
            'mystudyName'        => $row['ct_mystudy_name'], //学习情况名称
            'mydyShow'           => intval($row['ct_mydy_show']), //订阅是否显示
            'mydyName'           => $row['ct_mydy_name'], //订阅名称
            'mymsShow'           => intval($row['ct_myms_show']), //秒杀是否显示
            'mymsName'           => $row['ct_myms_name'], //秒杀名称
            'mykjShow'           => intval($row['ct_mykj_show']), //砍价是否显示
            'mykjName'           => $row['ct_mykj_name'], //砍价名称
            'myinviteShow'       => intval($row['ct_myinvite_show']), //邀请赚金币是否显示
            'myinviteName'       => $row['ct_myinvite_name'], //邀请赚金币名称
            'mycooperationShow'  => intval($row['ct_mycooperation_show']), //商务合作是否显示
            'mycooperationName'  => $row['ct_mycooperation_name'], //商务合作名称
            'myreturnShow'       => intval($row['ct_myreturn_show']), //订单返现是否显示
            'myMsShow'           => intval($row['ct_myms_show']), //我的秒杀显示
            'myMsName'           => $row['ct_myms_name'] ? $row['ct_myms_name'] : '我的秒杀', //我的秒杀名称
            'myKjShow'           => intval($row['ct_mykj_show']), //我的砍价显示
            'myKjName'           => $row['ct_mykj_name'] ? $row['ct_mykj_name'] : '我的砍价', //我的砍价名称
            'myreturnName'       => $row['ct_myreturn_name'], //订单返现名称
            'mychatShow'         => intval($row['ct_mychat_show']), //私信是否显示
            'mychatName'         => $row['ct_mychat_name'], //私信名称
            'mympShow'           => $mpjOpen ? intval($row['ct_mymp_show']) : 0, //我的名片显示
            'mympName'           => $row['ct_mymp_name'], //我的名片名称
            'mympjShow'          => $mpjOpen ? intval($row['ct_mympj_show']) : 0, //我的名片夹显示
            'mympjName'          => $row['ct_mympj_name'], //我的名片夹名称
            'advertImg'          => $this->dealImagePath($row['ct_advert_img']),
            'advertLink'         => $row['ct_advert_link'],
            'myphoneShow'        => intval($row['ct_myphone_show']), //我的手机号  修改
            'myphoneName'        => !empty($row['ct_myphone_name']) ? $row['ct_myphone_name'] : '', //我的手机号
            'myphoneNum'         => empty($member['m_mobile']) ? '' : $member['m_mobile'],
            'myhxShow'           => intval($row['ct_myhx_show']),
            'myhxName'           => $row['ct_myhx_name'] ? $row['ct_myhx_name'] : '我的核销', //我的核销
            'myfreeShow'         => $this->checkToolUsable('mfyy') ? intval($row['ct_myfree_show']) : 0,
            'myfreeName'         => $row['ct_myfree_name'] ? $row['ct_myfree_name'] : '预约订单', //免费预约订单
            'couponShow'         => intval($row['ct_coupon_show']),
            'couponName'         => $row['ct_coupon_name'] ? $row['ct_coupon_name'] : '优惠券大厅',
            'tzapplyShow'        => intval($row['ct_tzapply_show']),
            'tzapplyName'        => $row['ct_tzapply_name'] ? $row['ct_tzapply_name'] : '申请当团长',
            'tzinfoShow'         => intval($row['ct_tzinfo_show']),
            'tzinfoName'         => $row['ct_tzinfo_name'] ? $row['ct_tzinfo_name'] : '团长信息',
            'tzcenterShow'       => intval($row['ct_tzcenter_show']),
            'tzcenterName'       => $row['ct_tzcenter_name'] ? $row['ct_tzcenter_name'] : '团长管理中心',
            'gysapplyShow'       => intval($row['ct_gysapply_show']),
            'gysapplyName'       => $row['ct_gysapply_name'] ? $row['ct_gysapply_name'] : '我是供应商',
            'myappoShow'         => intval($row['ct_myappo_show']),
            'myappoName'         => $row['ct_myappo_name'] ? $row['ct_myappo_name'] : '付费预约',
            'carshareShow'       => intval($row['ct_carshare_show']),
            'carshareName'       => $row['ct_carshare_name'] ? $row['ct_carshare_name'] : '邀请有礼',
            'carshopcollectShow' => intval($row['ct_carshopcollect_show']),
            'carshopcollectName' => $row['ct_carshopcollect_name'] ? $row['ct_carshopcollect_name'] : '关注服务商',
            'carbargainShow'     => intval($row['ct_carbargain_show']),
            'carbargainName'     => $row['ct_carbargain_name'] ? $row['ct_carbargain_name'] : '我的砍价',
            'applyruleShow'      => intval($row['ct_applyrule_show']),
            'applyruleName'      => $row['ct_applyrule_name'] ? $row['ct_applyrule_name'] : '加入跑男',
            'helpcenterShow'     => intval($row['ct_helpcenter_show']),
            'helpcenterName'     => $row['ct_helpcenter_name'] ? $row['ct_helpcenter_name'] : '帮助中心',
            'mymallddShow'       => intval($row['ct_mymalldd_show']),
            'mymallddName'       => $row['ct_mymalldd_name'] ? $row['ct_mymalldd_name'] : '我的商城订单',
            'invoiceShow'        => intval($row['ct_invoice_show']),
            'invoiceName'        => $row['ct_invoice_name'] ? $row['ct_invoice_name'] : '我的发票',
            'mywifiShow'         => intval($row['ct_mywifi_show']),
            'mywifiName'         => $row['ct_mywifi_name'] ? $row['ct_mywifi_name'] : '我的wifi',
            'exchangeShow'       => intval($row['ct_exchange_show']),
            'exchangeName'       => $row['ct_exchange_name'] ? $row['ct_exchange_name'] : '我的报名',
            'redbagShow'         => intval($row['ct_redbag_show']),
            'redbagName'         => $row['ct_redbag_name'] ? $row['ct_redbag_name'] : '组队红包',
            'lotteryShow'        => intval($row['ct_lottery_show']),
            'lotteryName'        => $row['ct_lottery_name'] ? $row['ct_lottery_name'] : '抽奖',
            //'appletadShow'  => intval($row['ct_appletad_show']),
            //'appletadName'  => $row['ct_appletad_show'] ? $row['ct_appletad_show'] : '我也要做小程序',
            'topstyle'           => $row['ct_topstyle'] == 1 ? 1 : 2,
            'styleType'          => $row['ct_style_type'] > 0 ? intval($row['ct_style_type']) : 1,
            'myserviceTitle'     => $row['ct_service_title'] ? $row['ct_service_title'] : '我的服务',
            'membercardJump'     => intval($row['ct_membercard_jump']),
            'myvaultShow'        => intval($row['ct_myvault_show']),
            'myvaultName'        => $row['ct_myvault_name'] ? $row['ct_myvault_name'] : '小金库',
            'pickstationShow'    => intval($row['ct_pickstation_show']),
            'pickstationName'    => $row['ct_pickstation_name'] ? $row['ct_pickstation_name'] : '自提点管理',
            'actcenterShow'      => intval($row['ct_actcenter_show']),
            'actcenterName'      => $row['ct_actcenter_name'] ? $row['ct_actcenter_name'] : '活动中心',
            'complaintShow'      => intval($row['ct_complaint_show']),
            'complaintName'      => $row['ct_complaint_name'] ? $row['ct_complaint_name'] : '投诉中心',
            'invitenewShow'      => intval($row['ct_invitenew_show']),
            'invitenewName'      => $row['ct_invitenew_name'] ? $row['ct_invitenew_name'] : '新人邀请',
            'shopapplyShow'      => intval($row['ct_shopapply_show']),
            'shopapplyName'      => $row['ct_shopapply_name'] ? $row['ct_shopapply_name'] : ($this->applet_cfg['ac_type'] == 27 ? '讲师入驻' : '申请入驻'),
            'riderinfoShow'      => intval($row['ct_riderinfo_show']),
            'riderinfoName'      => $row['ct_riderinfo_name'] ? $row['ct_riderinfo_name'] : '帮手信息',
            'ridercommentShow'   => intval($row['ct_ridercomment_show']),
            'ridercommentName'   => $row['ct_ridercomment_name'] ? $row['ct_ridercomment_name'] : '帮手评价',
            'stepShow'           => intval($row['ct_step_show']),
            'stepName'           => $row['ct_step_name'] ? $row['ct_step_name'] : '微信步数',
            'subscribeShow'      => intval($row['ct_subscribe_show']),
            'subscribeName'      => $row['ct_subscribe_name'] ? $row['ct_subscribe_name'] : '订阅消息',
            'marketorderShow'    => intval($row['ct_marketorder_show']),
            'marketorderName'    => $row['ct_marketorder_name'] ? $row['ct_marketorder_name'] : '市场订单',
            'isdistrib'          => ($this->member['m_is_highest'] > 0) ? 1 : 0,
//            'expertcenterShow'      => intval($row['ct_expertcenter_show']),
            //            'expertcenterName'      => $row['ct_expertcenter_name'] ? $row['ct_expertcenter_name'] : '讲师管理中心',
        );

        if ($this->appletType == 4 && in_array($this->applet_cfg['ac_type'], [21]) && $this->applet_cfg['ac_show_knowledge'] == 0) {
            //营销商城抖音版未开启此功能 把知识付费菜单隐藏 订单默认显示
            $info['data']['mystudyShow'] = 0;
            $info['data']['mydyShow']    = 0;
            //$info['data']['myddShow'] = 1;

        }
        //抖音多店私信配置处理
        if ($this->appletType == 4 && in_array($this->applet_cfg['ac_type'], [8])) {
            $msg_model                    = new App_Model_Car_MysqlCarChatMsgStorage($this->sid);
            $where_msg[]                  = array('name' => 'accm_s_id', 'oper' => '=', 'value' => $this->sid);
            $where_msg[]                  = array('name' => 'accm_read', 'oper' => '=', 'value' => 0);
            $where_msg[]                  = array('name' => 'accm_to_mid', 'oper' => '=', 'value' => $this->member['m_id']);
            $msgCount                     = $msg_model->getCount($where_msg);
            $info['data']['msgCountDy']   = $msgCount ? $msgCount : 0;
            $info['data']['mychatShowDy'] = 1;
            $info['data']['mychatNameDy'] = '客服消息';

            $info['data']['promoterShow'] = intval($row['ct_promoter_show']);
            $info['data']['promoterName'] = $row['ct_promoter_name'] ? $row['ct_promoter_name'] : '推广员';

            $info['data']['proposeShow'] = intval($row['ct_propose_show']);
            $info['data']['proposeName'] = $row['ct_propose_name'] ? $row['ct_propose_name'] : '投诉与建议';

            $promoter_model                 = new App_Model_Promoter_MysqlPromoterStorage($this->sid);
            $promoter                       = $promoter_model->findRowByMid($this->member['m_id']);
            $info['data']['promoterStatus'] = $promoter['ap_status'] == 1 ? 1 : 2;

            //管理的店铺是否已经到期
            $enter_shop  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
            $enterData   = $enter_shop->getRowByMidSid($this->member['m_id']);
            $closeStatus = 0;
            if ($enterData && $enterData['es_handle_status'] == 2 && $enterData['es_status'] == 0 && $enterData['es_expire_time'] < time()) {
                $closeStatus = 1;
            }
            $info['data']['closeStatus'] = $closeStatus;
            $info['data']['esId']        = $enterData['es_id'] ? $enterData['es_id'] : 0;
        }
        //抖音基础商城处理
        if ($this->appletType == 4 && $this->applet_cfg['ac_type'] == 1) {
            $info['data']['myptShow']   = 0;
            $info['data']['mycjShow']   = 0;
            $info['data']['myyhqShow']  = 0;
            $info['data']['mywithShow'] = 0;
            $info['data']['myfxShow']   = 0;
            $info['data']['jfshopShow'] = 0;
            $info['data']['mycjShow']   = 0;
            $info['data']['stepShow']   = 0;
        }

        //获取配置信息
        //        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $cfg = $this->applet_cfg;

        $info['data']['appletadShow'] = intval($cfg['ac_appletad_open']);
        $info['data']['appletadName'] = '我也要做小程序';

        //知识付费 判断是否签到
        if ($cfg['ac_type'] == 27 || $cfg['ac_type'] == 30 || $cfg['ac_type'] == 12) {
            $attendance_model              = new App_Model_Knowpay_MysqlKnowpayAttendanceStorage($this->sid);
            $where                         = array();
            $where[]                       = array('name' => 'aka_day', 'oper' => '=', 'value' => strtotime(date('Y-m-d')));
            $where[]                       = array('name' => 'aka_m_id', 'oper' => '=', 'value' => $this->uid);
            $where[]                       = array('name' => 'aka_s_id', 'oper' => '=', 'value' => $this->sid);
            $hadAttendance                 = $attendance_model->getRow($where);
            $info['data']['hadAttendance'] = $hadAttendance ? 1 : 0;
        }

        if ($cfg['ac_type'] == 6 || $cfg['ac_type'] == 27 || $cfg['ac_type'] == 8 || $cfg['ac_type'] == 33) {
            // $apply_storage = new App_Model_City_MysqlCityShopApplyStorage($this->sid);
            //同城版 判断是否入驻
            if ($cfg['ac_type'] == 6) {
                $apply_storage = new App_Model_City_MysqlCityShopStorage($this->sid);
                $userShop      = $apply_storage->findShopByUser($this->uid);
                if ($userShop) {
                    $info['data']['myShop']     = 'yes';
                    $info['data']['shopStatus'] = $userShop['acs_status'];

                } else {
                    $info['data']['myShop']     = 'no';
                    $info['data']['shopStatus'] = 0;
                }

                //同城版 判断是否开通分销中心
                if (!$this->checkToolUsable('hhr')) {
                    $data['myfxShow'] = 0;
                }

                //获得未读私信数量
                $msg_model                = new App_Model_Car_MysqlCarChatMsgStorage($this->sid);
                $where_msg[]              = array('name' => 'accm_s_id', 'oper' => '=', 'value' => $this->sid);
                $where_msg[]              = array('name' => 'accm_read', 'oper' => '=', 'value' => 0);
                $where_msg[]              = array('name' => 'accm_to_mid', 'oper' => '=', 'value' => $this->member['m_id']);
                $msgCount                 = $msg_model->getCount($where_msg);
                $info['data']['msgCount'] = $msgCount ? $msgCount : 0;
            }

            //多店版 二手车 判断是否入驻
            if ($cfg['ac_type'] == 8 || $cfg['ac_type'] == 33 || $cfg['ac_type'] == 27) {
                $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
                $userShop = $es_model->findShopByUser($this->sid, $this->uid, false);
                if ($userShop) {
                    $info['data']['myShop']     = 'yes';
                    $info['data']['shopStatus'] = $userShop['es_handle_status'];
                    if ($this->appletType == 4) {
                        //抖音的当申请后可以将申请入口隐藏掉
                        $info['data']['shopapplyShow'] = 0;
                    }
                } else {
                    $info['data']['myShop']     = 'no';
                    $info['data']['shopStatus'] = 0;
                }
                if ($cfg['ac_type'] == 27 && $userShop['es_handle_status'] == 2) {
                    $info['data']['shopapplyName'] = $row['ct_expertcenter_name'] ? $row['ct_expertcenter_name'] : '讲师管理中心';
                }
            }

            $info['data']['navList'] = array();
            $openNum                 = 0;
            $navList                 = json_decode($row['ct_nav_list'], true);
            if ($navList) {
                foreach ($navList as $val) {
                    if ($val['open'] == 'true') {
                        $openNum++;
                    }
                    $info['data']['navList'][] = array(
                        'open' => $val['open'] == 'true' ? 1 : 0,
                        'name' => $val['title'],
                        'icon' => $this->dealImagePath($val['imgsrc']),
                    );
                }
            }
            if (!$openNum) {
                $info['data']['navList'] = array();
            }
        }

        //营销商城版 中心页导航
        if ($cfg['ac_type'] == 21 || $cfg['ac_type'] == 18) {
            $info['data']['navList'] = array();
            $openNum                 = 0;
            $navList                 = json_decode($row['ct_nav_list'], true);
            if ($navList) {
                foreach ($navList as $val) {
                    if ($val['open'] == 'true') {
                        $openNum++;
                    }
                    $info['data']['navList'][] = array(
                        'open' => $val['open'] == 'true' ? 1 : 0,
                        'name' => $val['title'],
                        'icon' => $this->dealImagePath($val['imgsrc']),
                    );
                }
            }
            if (!$openNum) {
                $info['data']['navList'] = array();
            }
        }
        //社区团购 是否是团长
        if ($cfg['ac_type'] == 32 || $cfg['ac_type'] == 36) {
            //是否是自提点管理人
            $manager_model   = new App_Model_Sequence_MysqlSequencePickStationManagerStorage($this->sid);
            $station_manager = $manager_model->findRowByMid($this->member['m_id']);
            if (!$station_manager) {
                $info['data']['pickstationShow'] = 0; //不是管理人 不显示
            }

            $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->sid);
            $leader       = $leader_model->getRowByMid($member['m_id']);
            if ($leader) {
                switch ($leader['asl_status']) {
                    case 1:
                        $info['data']['leaderMsg']    = '您的申请已经提交，请耐心等待';
                        $info['data']['leaderReason'] = '';
                        $info['data']['tzcenterShow'] = 0;
                        break;
                    case 2:
                        $info['data']['leaderMsg']    = '';
                        $info['data']['leaderReason'] = '';
                        $info['data']['tzapplyShow']  = 0;
                        break;
                    case 3:
                        $info['data']['leaderMsg']    = '很遗憾，您的申请未通过平台审核';
                        $info['data']['leaderReason'] = $leader['asl_handle_remark'] ? $leader['asl_handle_remark'] : '';
                        $info['data']['tzcenterShow'] = 0;
                        break;
                    case 4:
                        $info['data']['leaderMsg']    = '管理员撤销了您的团长身份';
                        $info['data']['leaderReason'] = '';
                        $info['data']['tzcenterShow'] = 0;
                        break;
                }
                $info['data']['leaderStatus'] = intval($leader['asl_status']);
            } else {
                $info['data']['leaderStatus'] = 0;
                $info['data']['leaderMsg']    = '';
                $info['data']['leaderReason'] = '';
                $info['data']['tzcenterShow'] = 0;
            }

            //获得当前会员可用的优惠券数量
            $coupon_model                = new App_Model_Coupon_MysqlReceiveStorage();
            $time                        = time();
            $where_coupon[]              = array('name' => 'cr_s_id', 'oper' => '=', 'value' => $this->sid);
            $where_coupon[]              = array('name' => 'cr_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where_coupon[]              = array('name' => 'cr_is_used', 'oper' => '=', 'value' => 0); //未被使用
            $where_coupon[]              = array('name' => 'cl_start_time', 'oper' => '<', 'value' => $time); //已开始
            $where_coupon[]              = array('name' => 'cl_end_time', 'oper' => '>', 'value' => $time); //未失效
            $where_coupon[]              = array('name' => 'cl_deleted', 'oper' => '=', 'value' => 0); //未删除
            $couponCount                 = $coupon_model->getReceiveCount($where_coupon);
            $info['data']['couponCount'] = $couponCount ? intval($couponCount) : 0;

            $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
            $member_card    = $offline_member->getUnexpireMemberInfo($member['m_id'], 2);
            $levelName      = '';
            if ($member_card) {
                $card_model  = new App_Model_Store_MysqlCardStorage($this->sid);
                $card        = $card_model->getRowById($member_card['om_card_id']);
                $identity    = intval($card['oc_identity']);
                $level_model = new App_Model_Member_MysqlLevelStorage();
                $level       = $level_model->getRowById($identity);
                $levelName   = $level ? $level['ml_name'] : '';
            } elseif ($member['m_level'] > 0) {
                $identity    = $member['m_level'];
                $level_model = new App_Model_Member_MysqlLevelStorage();
                $level       = $level_model->getRowById($identity);
                $levelName   = $level ? $level['ml_name'] : '';
            }
            $info['data']['levelName'] = $levelName ? $levelName : '普通用户';
        }

        if ($this->applet_cfg['ac_type'] == 27) {
            //获得优惠券数量
            $coupon_model                = new App_Model_Coupon_MysqlReceiveStorage();
            $time                        = time();
            $where_coupon[]              = array('name' => 'cr_s_id', 'oper' => '=', 'value' => $this->sid);
            $where_coupon[]              = array('name' => 'cr_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where_coupon[]              = array('name' => 'cr_is_used', 'oper' => '=', 'value' => 0); //未被使用
            $where_coupon[]              = array('name' => 'cl_start_time', 'oper' => '<', 'value' => $time); //已开始
            $where_coupon[]              = array('name' => 'cl_end_time', 'oper' => '>', 'value' => $time); //未失效
            $where_coupon[]              = array('name' => 'cl_deleted', 'oper' => '=', 'value' => 0); //未删除
            $couponCount                 = $coupon_model->getReceiveCount($where_coupon);
            $info['data']['couponCount'] = $couponCount ? intval($couponCount) : 0;

            //获得知识付费订单数量
            $trade_model              = new App_Model_Trade_MysqlTradeStorage($this->sid);
            $where_buy                = array();
            $where_buy[]              = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
            $where_buy[]              = array('name' => 't_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where_buy[]              = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6));
            $where_buy[]              = array('name' => 't_deleted', 'oper' => '=', 'value' => 0);
            $where_buy[]              = array('name' => 't_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET);
            $where_buy[]              = array('name' => 't_knowpay_type', 'oper' => '>', 'value' => 0);
            $buyCount                 = $trade_model->getCount($where_buy);
            $info['data']['buyCount'] = intval($buyCount);

            $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
            $member_card    = $offline_member->getUnexpireMemberInfo($member['m_id'], 2);
            $levelName      = '';
            if ($member_card) {
                $card_model  = new App_Model_Store_MysqlCardStorage($this->sid);
                $card        = $card_model->getRowById($member_card['om_card_id']);
                $identity    = intval($card['oc_identity']);
                $level_model = new App_Model_Member_MysqlLevelStorage();
                $level       = $level_model->getRowById($identity);
                $levelName   = $level ? $level['ml_name'] : '';
            } elseif ($member['m_level'] > 0) {
                $identity    = $member['m_level'];
                $level_model = new App_Model_Member_MysqlLevelStorage();
                $level       = $level_model->getRowById($identity);
                $levelName   = $level ? $level['ml_name'] : '';
            }
            $info['data']['levelName'] = $levelName ? $levelName : '普通用户';

            $default_icon = plum_parse_config('knowpay_nav_icon');
            $knowpay_nav = json_decode($row['ct_knowpay_nav'],1);
            foreach ($default_icon as $icon_key => $icon_item){
                $info['data'][$icon_key.'Icon'] = isset($knowpay_nav[$icon_key]) && $knowpay_nav[$icon_key] ? $this->dealImagePath($knowpay_nav[$icon_key]) : $this->dealImagePath($icon_item);
            }

        }

        /**
         * 游戏盒子
         */
        if ($this->applet_cfg['ac_type'] == 30) {
            $task_model                        = new App_Model_Gamebox_MysqlGameboxTaskStorage($this->sid);
            $progress_model                    = new App_Model_Gamebox_MysqlGameboxTaskProgressStorage($this->sid);
            $where                             = array();
            $where[]                           = array('name' => 'agtp_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]                           = array('name' => 'agtp_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where[]                           = array('name' => 'agtp_status', 'oper' => '=', 'value' => 2);
            $where[]                           = array('name' => 'agtp_create_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d', time())));
            $info['data']['finishedTaskCount'] = $progress_model->getCount($where);
            $where                             = array();
            $where[]                           = array('name' => 'agt_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]                           = array('name' => 'agt_deleted', 'oper' => '=', 'value' => 0);
            $info['data']['taskCount']         = $task_model->getCount($where);
            $taskList                          = $task_model->getList($where, 0, 3, array('agt_sort' => 'ASC', 'agt_create_time' => 'DESC'));

            $history_model = new App_Model_Gamebox_MysqlGameboxHistoryStorage($this->sid);
            $where         = array();
            $where[]       = array('name' => 'agh_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]       = array('name' => 'agh_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where[]       = array('name' => 'agh_update_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d', time())));
            $playNum       = $history_model->getCount($where);

            $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->sid);

            foreach ($taskList as $value) {
                $progress = $progress_model->getRowByTidMid($value['agt_id'], $this->member['m_id']);
                if ($value['agt_type'] == 3) {
                    $game = $game_model->getRowById($value['agt_game_id']);
                }
                $info['data']['taskList'][] = array(
                    'id'      => $value['agt_id'],
                    'type'    => $value['agt_type'],
                    'title'   => $value['agt_name'],
                    'points'  => $value['agt_points'],
                    'gameNum' => $value['agt_game_num'],
                    'status'  => $progress ? $progress['agtp_status'] : 0,
                    'appid'   => $game ? $game['agg_appid'] : '',
                    'gameId'  => $value['agt_game_id'],
                    'playNum' => $playNum > $value['agt_game_num'] ? $value['agt_game_num'] : $playNum,
                );
            }
        }
        //二手车
        if ($this->applet_cfg['ac_type'] == 33) {
            //获得在售车源数
            $resource_model = new App_Model_Car_MysqlCarResourceStorage($this->sid);
            $where_re[]     = array('name' => 'acr_s_id', 'oper' => '=', 'value' => $this->sid);
            $where_re[]     = array('name' => 'acr_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $resourceCount  = $resource_model->getCount($where_re);
            //获得收藏的车源数
            $collect_model = new App_Model_Community_MysqlCommunityCollectionStorage($this->sid);
            $where_co[]    = array('name' => 'acc_s_id', 'oper' => '=', 'value' => $this->sid);
            $where_co[]    = array('name' => 'acc_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where_co[]    = array('name' => 'acc_type', 'oper' => '=', 'value' => 5);
            $collectCount  = $collect_model->getCount($where_co);
            //获得收到的砍价数
            $bargain_model = new App_Model_Car_MysqlCarBargainStorage($this->sid);
            $where_ba[]    = array('name' => 'acb_s_id', 'oper' => '=', 'value' => $this->sid);
            $where_ba[]    = array('name' => 'acb_car_mid', 'oper' => '=', 'value' => $this->member['m_id']);
            $bargainCount  = $bargain_model->getCount($where_ba);
            //获得未读私信数量
            $msg_model               = new App_Model_Car_MysqlCarChatMsgStorage($this->sid);
            $where_msg[]             = array('name' => 'accm_s_id', 'oper' => '=', 'value' => $this->sid);
            $where_msg[]             = array('name' => 'accm_read', 'oper' => '=', 'value' => 0);
            $where_msg[]             = array('name' => 'accm_to_mid', 'oper' => '=', 'value' => $this->member['m_id']);
            $msgCount                = $msg_model->getCount($where_msg);
            $info['data']['carInfo'] = [
                'carNum'     => $resourceCount ? $resourceCount : 0,
                'collectNum' => $collectCount ? $collectCount : 0,
                'bargainNum' => $bargainCount ? $bargainCount : 0,
                'msgNum'     => $msgCount ? $msgCount : 0,
            ];

        }

        if ($this->applet_cfg['ac_type'] == 35) {
            $where_answer   = [];
            $where_question = [];
            $where_buy      = [];
            $where_history  = [];
            $answer_model   = new App_Model_Answerpay_MysqlAnswerpayAnswerStorage($this->sid);
            $question_model = new App_Model_Answerpay_MysqlAnswerpayQuestionStorage($this->sid);
            $buy_model      = new App_Model_Answerpay_MysqlAnswerpayAnswerBuyStorage($this->sid);
            $history_model  = new App_Model_Answerpay_MysqlAnswerpayQuestionHistoryStorage($this->sid);

            $where_answer[] = ['name' => 'aaa_s_id', 'oper' => '=', 'value' => $this->sid];
            $where_answer[] = ['name' => 'aaa_m_id', 'oper' => '=', 'value' => $this->uid];
            $count_answer   = $answer_model->getCount($where_answer);

            $where_question[] = ['name' => 'aaq_s_id', 'oper' => '=', 'value' => $this->sid];
            $where_question[] = ['name' => 'aaq_m_id', 'oper' => '=', 'value' => $this->uid];
            $count_question   = $question_model->getCount($where_question);

            $where_buy[] = ['name' => 'aaab_s_id', 'oper' => '=', 'value' => $this->sid];
            $where_buy[] = ['name' => 'aaab_m_id', 'oper' => '=', 'value' => $this->uid];
            $count_buy   = $buy_model->getCount($where_buy);

            $where_history[] = ['name' => 'aaqh_s_id', 'oper' => '=', 'value' => $this->sid];
            $where_history[] = ['name' => 'aaqh_m_id', 'oper' => '=', 'value' => $this->uid];
            //获得两个月前月初时间戳
            $thismonth = date('m');
            $thisyear  = date('Y');
            if ($thismonth <= 2) {
                $curr_month = 12 - $thismonth;
                $curr_year  = $thisyear - 1;
            } else {
                $curr_month = $thismonth - 2;
                $curr_year  = $thisyear;
            }
            $curr_day        = $curr_year . '-' . $curr_month . '-1';
            $curr_time       = strtotime($curr_day);
            $where_history[] = ['name' => 'aaqh_update_time', 'oper' => '>', 'value' => $curr_time];

            $count_history               = $history_model->getCount($where_history);
            $info['data']['answerNum']   = intval($count_answer);
            $info['data']['questionNum'] = intval($count_question);
            $info['data']['buyNum']      = intval($count_buy);
            $info['data']['historyNum']  = intval($count_history);
        }
        //校园跑腿
        if ($this->applet_cfg['ac_type'] == 37) {
            $rider_model = new App_Model_Handy_MysqlHandyRiderStorage($this->sid);
            $rider       = $rider_model->findRowByMid($this->member['m_id']);
            if ($rider) {
                $custom_data               = $rider['ahr_custom_data'] ? json_decode($rider['ahr_custom_data'], 1) : [];
                $info['data']['riderInfo'] = [
                    'id'                  => $rider['ahr_id'],
                    'name'                => $rider['ahr_name'],
                    'mobile'              => $rider['ahr_mobile'],
                    'status'              => intval($rider['ahr_status']),
                    'data'                => $custom_data,
                    'audit'               => intval($rider['ahr_audit']),
                    'depositTid'          => $rider['ahr_deposit_tid'] ? $rider['ahr_deposit_tid'] : '',
                    'depositStatus'       => 0,
                    'depositRefundStatus' => 0,
                    'depositRefundNote'   => '',
                ];

                if ($rider['ahr_deposit_tid']) {
                    $deposit_model                                    = new App_Model_Handy_MysqlHandyRiderDepositStorage($this->sid);
                    $deposit                                          = $deposit_model->findUpdateTradeByTid($rider['ahr_deposit_tid']);
                    $info['data']['riderInfo']['depositStatus']       = intval($deposit['ahrd_status']);
                    $info['data']['riderInfo']['depositRefundStatus'] = intval($deposit['ahrd_refund_audit']);
                    $info['data']['riderInfo']['depositRefundNote']   = $deposit['ahrd_refund_note'] ? $deposit['ahrd_refund_note'] : '';
                }

            } else {
                $info['data']['riderInfo'] = '';
            }

        }

        $info['data']['information'] = $this->_is_information_card();
        // 获取不同类型订单数量
        $orderNum     = $this->_member_order_count_type();
        $info['data'] = array_merge($info['data'], $orderNum);
        $this->outputSuccess($info);
    }

    private function _is_information_card()
    {
        $data = array(
            'isopen'     => 0,
            'expireTime' => '未开通',
        );
        // 获取会员卡是否存在
        $card_model = new App_Model_Information_MysqlInformationMemberCardStorage($this->shop['s_id']);
        $card       = $card_model->fetchRowById($this->uid);
        if ($card) {
            if ($card['aim_expire_time'] > time()) {
                $data = array(
                    'isopen'     => 1,
                    'expireTime' => date('Y-m-d', $card['aim_expire_time']),
                );
            } else {
                $data['expireTime'] = '已到期';
            }
        }
        return $data;
    }

    /*
     * 不同类型处理会员中心背景图
     */
    private function _deal_center_background($row)
    {

        if ($row['ct_style_type'] && $row['ct_style_type'] == 2 && $row['ct_topstyle'] == 0 && in_array($this->applet_cfg['ac_type'], array(1, 21, 24))) {
            $img = '';
        } elseif (in_array($this->applet_cfg['ac_type'], array(7, 32))) {
            $img = $row['ct_center_bg'] && !stristr($row['ct_center_bg'], 'shk_02.png') ? $this->dealImagePath($row['ct_center_bg']) : '';
        } else {
            $img = $row['ct_center_bg'] ? $this->dealImagePath($row['ct_center_bg']) : $this->dealImagePath('/public/manage/centermanage/images/shk_02.png');
        }
        return $img;
    }

    /**
     * 获取会员不同类型订单数量
     */
    private function _member_order_count_type()
    {
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $data        = array(
            'dfkNum'  => $trade_model->fetchMemberCountByType($this->member['m_id'], 'dfk', $this->applet_cfg['ac_type']),
            'dctNum'  => $trade_model->fetchMemberCountByType($this->member['m_id'], 'dct', $this->applet_cfg['ac_type']),
            'dfhNum'  => $trade_model->fetchMemberCountByType($this->member['m_id'], 'dfh', $this->applet_cfg['ac_type']),
            'dshNum'  => $trade_model->fetchMemberCountByType($this->member['m_id'], 'dsh', $this->applet_cfg['ac_type']),
            'tkwqNum' => $trade_model->fetchMemberCountByType($this->member['m_id'], 'tkwq', $this->applet_cfg['ac_type']),
        );
        //待核销 相当于待发货+待收货
        $data['dhxNum'] = $data['dfhNum'] + $data['dshNum'];

        return $data;
    }

    /**
     * 会员金币充值
     */
    public function rechargeCfgAction()
    {
        //获取店铺的充值配置
        $config_model           = new App_Model_Member_MysqlRechargeCfgStorage();
        $config                 = $config_model->findRowUpdate($this->sid);
        $info                   = array();
        $info['data']['list']   = array();
        $info['data']['prompt'] = isset($config['rc_desc']) ? $config['rc_desc'] : '';
        $info['data']['custom'] = isset($config['rc_open_zdy']) ? $config['rc_open_zdy'] : 1;
        $info['data']['remark'] = isset($config['rc_open_remark']) ? intval($config['rc_open_remark']) : 0;
        $value_model            = new App_Model_Member_MysqlRechargeValueStorage($this->sid);
        $list                   = $value_model->fetchGradeValueList();
        if ($list) {
            foreach ($list as $item) {
                $info['data']['list'][] = array(
                    'id'              => $item['rv_id'],
                    'money'           => $item['rv_money'],
                    'coin'            => floatval($item['rv_coin']),
                    'weight'          => $item['rv_weight'],
                    'backgroundColor' => $item['rv_background_color'] ? $item['rv_background_color'] : '',
                    'give'            => floatval($item['rv_coin'] - $item['rv_money']),
                    'isIdentity'      => $item['rv_identity'] && $item['ml_id'] > 0 ? 1 : 0,
                    'levelName'       => isset($item['ml_name']) && $item['ml_name'] ? $item['ml_name'] : '',
                    'levelDesc'       => isset($item['ml_desc']) && $item['ml_desc'] ? $item['ml_desc'] : '',
                    'levelDiscount'   => isset($item['ml_discount']) && $item['ml_discount'] ? $item['ml_discount'] : '',
                    'isVip'           => isset($item['ml_is_vip']) && $item['ml_is_vip'] ? $item['ml_is_vip'] : 0,
                    'backgroundImg'   => $this->dealImagePath('/public/wxapp/images/memberCard2.png'),
                );
            }
        }
        $this->outputSuccess($info);
    }
    /**
     * 会员充值金币微信支付订单
     */
    public function rechargePayAction()
    {
        $pid          = $this->request->getIntParam('pid'); //选择呢的充值配置id
        $price        = $this->request->getIntParam('price'); //充值的金额
        $remark       = $this->request->getStrParam('remark');
        $weixin_appid = $this->request->getStrParam('weixin_appid');
        $appletType   = $this->request->getIntParam('appletType');
        $version      = $this->request->getIntParam('version', 1); // 头条小程序版本，1只有支付宝支付，2收银台支付（包含微信H5和支付宝）
        // $pay_type   = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        // $payType    = $pay_type->findRowPay();
        // if(!$payType || ($payType && $payType['pt_wxpay_applet']==0)){
        //     $this->outputError('该店铺暂未开启微信支付');
        // }
        if ($appletType == 1) {
            $openid_auth = App_Plugin_Weixin_ClientPlugin::openIDVerify($this->member['m_openid']);
            if (!$openid_auth) {
                $this->outputError('用户信息验证失败');
            }
        }
        if ($this->member) {
            //获取充值金额，为十进制整数
            if ($price > 0) {
                if ($pid) {
                    $value_model = new App_Model_Member_MysqlRechargeValueStorage($this->sid);
                    $value       = $value_model->findValueById($pid);
                    if (!$value || $value['rv_money'] != $price) {
                        $this->outputError("充值金额不正确");
                    }
                    if ($value['rv_limit'] > 0) {
                        $record_storage = new App_Model_Member_MysqlRechargeStorage($this->shop['s_id']);
                        $where          = array();
                        $where[]        = array('name' => 'rr_s_id', 'oper' => '=', 'value' => $this->sid);
                        $where[]        = array('name' => 'rr_pid', 'oper' => '=', 'value' => $pid);
                        $where[]        = array('name' => 'rr_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
                        $recordNum      = $record_storage->getCount($where);
                        if ($recordNum >= $value['rv_limit']) {
                            $this->outputError("已超过限购次数");
                        }
                    }
                }
                /*组织数据 开始*/
                $body   = "{$this->shop['s_name']}会员余额充值{$price}";
                $tid    = App_Plugin_Weixin_NewPay::makeMchOrderid($this->shop['s_id']); //生成唯一性订单ID
                $amount = $price;
                //设置订单分佣及通知信息
                /*$copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
                $tcRow         = $copartner_cfg->findShopCfg();
                if($tcRow['tc_copartner_isopen'] == 1){
                $this->_recharge_copartner_order_deduct($tid, $price);
                }else{
                $this->_recharge_order_deduct($tid, $price);
                }*/
                //                if($this->sid == 11 || $this->sid == 5655 || $this->sid==4298 || $this->sid == 4697 || $this->sid == 5474 || $this->sid == 8298 || $this->sid == 4546 || $this->sid == 9800 || $this->sid == 9373){
                //                    $amount      = 0.01;
                //                }
                $attach = array(
                    'suid'       => $this->shop['s_unique_id'],
                    'pid'        => $pid,
                    'muid'       => $this->uidConvert(intval($this->member['m_id'])),
                    'appletType' => 'toutiao',
                );
                $other = array('attach' => json_encode($attach));

                // $notify_url  = plum_parse_config('notify_url','wxxcx').'/mobile/wxpay/appletMemberRechargeNotify';//回调地址
                $notify_url = $this->response->responseHost() . '/mobile/wxpay/appletMemberRechargeNotify'; //回调地址

                if ($this->member['m_id'] == 5623429 || $this->member['m_id'] == 5754194) {
                    $amount = 0.01;
                }
                if ($weixin_appid && $this->appletType == 5) {
                    $pay_model                 = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                    $appletPay                 = $pay_model->findRowPay();
                    $appletPay['weixin_appid'] = $weixin_appid;
                    $has_wxpay                 = App_Helper_Trade::checkHasWxpay($this->sid);
                    if ($has_wxpay) {
                        $wx_pay = new App_Plugin_Weixin_NewPay($this->shop['s_id'], true);
                        $ret    = $wx_pay->unifiedJsapiOrder($this->member['m_openid'], $body, $tid, $amount, $notify_url, $other, $appletPay);
                    } else {
                        $this->outputError("微信支付发起失败");
                    }
                } else if ($appletType == 4) {
                    // 抖音头条小程序支付
                    // 获取超时关闭时间
                    $over_time   = plum_parse_config('trade_overtime');
                    $overTime    = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade'] * 60 : $over_time['close'];
                    $pay_storage = new App_Plugin_Toutiao_Pay($this->sid);
                    if ($version == 2) {
                        $notify_url = $this->response->responseHost() . '/toutiao/notify/appletMemberRechargeNotify'; //回调地址
                        $result     = $pay_storage->appletOrderPayRecharge($amount, $this->member['m_openid'], $tid, $notify_url, $body, time(), $overTime, $attach);
                        if (is_array($result) && !$result['code']) {
                            $params = array(
                                'merchant_id'  => $result['biz_content']['merchant_id'],
                                'app_id'       => $result['appid'],
                                'sign_type'    => 'MD5',
                                'timestamp'    => $result['timestamp'],
                                'product_code' => 'pay',
                                'payment_type' => 'direct',
                                'out_order_no' => $result['trade_no'],
                                'uid'          => $result['uid'],
                                'total_amount' => $result['biz_content']['total_amount'],
                                'currency'     => 'CNY',
                                'subject'      => $body,
                                'body'         => $body,
                                'trade_time'   => time(),
                                'valid_time'   => 1800,
                                'notify_url'   => plum_get_base_host(),
                                'alipay_url'   => $result['params_url'],
                                'wx_url'       => $result['wxinfo'] && $result['wxinfo']['mweb_url'] ? $result['wxinfo']['mweb_url'] : '',
                                'version'      => '2.0',
                            );
                            if ($params['wx_url'] && $result['wxinfo'] && $result['wxinfo']['trade_type']) {
                                $params['wx_type'] = $result['wxinfo']['trade_type'];
                            }
                            $params['sign']      = $pay_storage::makeToutiaoSign($params, $result['appsecret']);
                            $params['risk_info'] = $result['biz_content']['risk_info'];
                            $this->outputSuccess(array('data' => $params));
                        } else {
                            $this->outputError('支付错误，请稍后重试');
                        }
                    } else {
                        $alipay_notify_url = $this->response->responseHost() . '/alixcx/alipay/appletMemberRechargeNotify'; //回调地址
                        $result            = $pay_storage->appletOrderPayRecharge($amount, $this->member['m_openid'], $tid, $alipay_notify_url, $body, time(), $overTime, $attach);
                        if (is_array($result) && !$result['code']) {
                            $params = array(
                                'app_id'       => $result['appid'],
                                'timestamp'    => $result['timestamp'],
                                'trade_no'     => $result['trade_no'],
                                'merchant_id'  => $result['biz_content']['merchant_id'],
                                'uid'          => $result['uid'],
                                'total_amount' => $result['biz_content']['total_amount'],
                                'sign_type'    => 'MD5',
                                'params'       => json_encode(array(
                                    'url' => $result['params_url'],
                                )),
                            );
                            $params['sign']        = $pay_storage::makeToutiaoSign($params, $result['appsecret']);
                            $params['params']      = $result['params_url'];
                            $params['method']      = 'tp.trade.confirm';
                            $params['pay_channel'] = 'ALIPAY_NO_SIGN';
                            $params['pay_type']    = 'ALIPAY_APP';
                            $params['risk_info']   = $result['biz_content']['risk_info'];
                            $this->outputSuccessWithExit($params);
                        } else {
                            $this->outputError('支付错误，请稍后重试');
                        }
                    }
                } else {
                    $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                    $appcfg          = $appletPay_Model->findRowPay();
                    if ($appcfg && $appcfg['ap_sub_pay'] == 1) {
                        // 服务商模式下支付
                        $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                        $ret            = $subPay_storage->unifiedJsapiOrder($this->applet_cfg['ac_appid'], $this->member['m_openid'], $amount, $tid, $notify_url, $body, $other);
                    } else {
                        $pay_storage = new App_Plugin_Weixin_NewPay($this->sid);
                        $ret         = $pay_storage->appletOrderPayRecharge($amount, $this->member['m_openid'], $tid, $notify_url, $body, $other);
                    }
                }

                if (is_array($ret)) {
                    $params = array(
                        'appId'     => $ret['appid'],
                        'timeStamp' => strval(time()),
                        'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                        'package'   => "prepay_id={$ret['prepay_id']}",
                        'signType'  => 'MD5',
                    );

                    $remark_model  = new App_Model_Member_MysqlRechargeRemarkStorage($this->sid);
                    $remark_insert = [
                        'rrr_s_id'        => $this->sid,
                        'rrr_tid'         => $tid,
                        'rrr_remark'      => $remark,
                        'rrr_create_time' => time(),
                    ];
                    $remark_model->insertValue($remark_insert);

                    $params['paySign'] = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $ret['app_key']);
                    $this->outputSuccess(array('data' => $params));
                } else {
                    $this->outputError("微信支付发起失败");
                }
            } else {
                $this->outputError("充值金额不合法");
            }
        } else {
            $this->outputError("在线支付发起失败");
        }

    }

    /**
     * 会员充值金币百度支付订单
     */
    public function rechargeBaiduPayAction()
    {
        $pid      = $this->request->getIntParam('pid'); //选择呢的充值配置id
        $price    = $this->request->getIntParam('price'); //充值的金额
        $pay_type = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payType  = $pay_type->findRowPay();
        if (!$payType || ($payType && $payType['pt_baidu_pay'] == 0)) {
            $this->outputError('该店铺暂未开启百度支付');
        }
        //获取充值金额，为十进制整数
        if ($price > 0) {
            if ($pid) {
                $value_model = new App_Model_Member_MysqlRechargeValueStorage($this->sid);
                $value       = $value_model->findValueById($pid);
                if (!$value || $value['rv_money'] != $price) {
                    $this->outputError("充值金额不正确");
                }
                if ($value['rv_limit'] > 0) {
                    $record_storage = new App_Model_Member_MysqlRechargeStorage($this->shop['s_id']);
                    $where          = array();
                    $where[]        = array('name' => 'rr_s_id', 'oper' => '=', 'value' => $this->sid);
                    $where[]        = array('name' => 'rr_pid', 'oper' => '=', 'value' => $pid);
                    $where[]        = array('name' => 'rr_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
                    $recordNum      = $record_storage->getCount($where);
                    if ($recordNum >= $value['rv_limit']) {
                        $this->outputError("已超过限购次数");
                    }
                }
            }
            /*组织数据 开始*/
            $body   = "{$this->shop['s_name']}会员余额充值{$price}";
            $tid    = App_Plugin_Weixin_NewPay::makeMchOrderid($this->shop['s_id']); //生成唯一性订单ID
            $amount = $price;
            //设置订单分佣及通知信息
            /*$copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
            $tcRow         = $copartner_cfg->findShopCfg();
            if($tcRow['tc_copartner_isopen'] == 1){
            $this->_recharge_copartner_order_deduct($tid, $price);
            }else{
            $this->_recharge_order_deduct($tid, $price);
            }*/
            if ($this->sid == 11 || $this->sid == 5655 || $this->sid == 4298 || $this->sid == 4697 || $this->sid == 5474 || $this->sid == 8298 || $this->sid == 4546 || $this->sid == 9800) {
                $amount = 0.01;
            }
            $attach = array(
                'suid'      => $this->shop['s_unique_id'],
                'pid'       => $pid,
                'mid'       => $this->member['m_id'],
                'orderType' => 'recharge',
            );
            $pay_storage = new App_Plugin_Baidu_Pay($this->sid);
            $result      = $pay_storage->appletOrderPayRecharge($amount, $tid, $body, $attach);
            if (is_array($result)) {
                $this->outputSuccess(array('data' => $result));
            } else {
                $this->outputError("微信支付发起失败");
            }
        } else {
            $this->outputError("充值金额不合法");
        }
    }

    /**
     * 会员充值金币支付宝支付订单
     */
    public function rechargeAlipayPayAction()
    {
        $pid      = $this->request->getIntParam('pid'); //选择呢的充值配置id
        $price    = $this->request->getIntParam('price'); //充值的金额
        $pay_type = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payType  = $pay_type->findRowPay();
        if (!$payType || ($payType && $payType['pt_alipay_applet'] == 0)) {
            $this->outputError('该店铺暂未开启支付宝支付');
        }
        //获取充值金额，为十进制整数
        if ($price > 0) {
            if ($pid) {
                $value_model = new App_Model_Member_MysqlRechargeValueStorage($this->sid);
                $value       = $value_model->findValueById($pid);
                if (!$value || $value['rv_money'] != $price) {
                    $this->outputError("充值金额不正确");
                }
                if ($value['rv_limit'] > 0) {
                    $record_storage = new App_Model_Member_MysqlRechargeStorage($this->shop['s_id']);
                    $where          = array();
                    $where[]        = array('name' => 'rr_s_id', 'oper' => '=', 'value' => $this->sid);
                    $where[]        = array('name' => 'rr_pid', 'oper' => '=', 'value' => $pid);
                    $where[]        = array('name' => 'rr_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
                    $recordNum      = $record_storage->getCount($where);
                    if ($recordNum >= $value['rv_limit']) {
                        $this->outputError("已超过限购次数");
                    }
                }
            }
            /*组织数据 开始*/
            $body       = "{$this->shop['s_name']}会员余额充值{$price}元";
            $tid        = App_Plugin_Weixin_NewPay::makeMchOrderid($this->shop['s_id']); //生成唯一性订单ID
            $amount     = $price;
            $notify_url = $this->response->responseHost() . '/alixcx/alipay/appletMemberRechargeNotify'; //回调地址
            //设置订单分佣及通知信息
            /*$copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
            $tcRow         = $copartner_cfg->findShopCfg();
            if($tcRow['tc_copartner_isopen'] == 1){
            $this->_recharge_copartner_order_deduct($tid, $price);
            }else{
            $this->_recharge_order_deduct($tid, $price);
            }*/
            $attach = array(
                'suid'      => $this->shop['s_unique_id'],
                'pid'       => $pid,
                'mid'       => $this->member['m_id'],
                'orderType' => 'recharge',
            );
            $pay_storage = new App_Plugin_Alixcx_XcxClient($this->sid);
            $result      = $pay_storage->fetchTradeCreate($this->member['m_openid'], $tid, $amount, $body, $attach, $notify_url);
            if (is_array($result) && !$result['errcode']) {
                $data['data'] = array(
                    'outTradeNO' => $result['out_trade_no'],
                    'tradeNO'    => $result['trade_no'],
                );
                $this->outputSuccess($data);
            } else {
                $this->outputError('支付错误，请稍后重试');
            }
        } else {
            $this->outputError("充值金额不合法");
        }
    }

    /*
     * 商城订单提成记录
     * $tid 订单ID
     * $ttid    订单号
     */
    private function _recharge_copartner_order_deduct($tid, $total)
    {

        $order_deduct = new App_Helper_OrderDeduct($this->sid);

        //使用店铺分佣设置
        $ratio = $this->_deduct_copartner_translate();
        //设置商品分佣
        $order_deduct->createOrderDeduct($this->member['m_id'], $tid, $total, $ratio, 0, 2);
    }

    private function _deduct_copartner_translate()
    {
        $three_level    = App_Helper_ShopWeixin::checkShopThreeLevel($this->sid);
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member         = $member_storage->getRowById($this->uid);
        $deduct_model   = new App_Model_Copartner_MysqlCopartnerDeductCfgStorage();
        $data           = array();
        for ($i = 0; $i <= $three_level; $i++) {
            $tmp = "{$i}f";
            //购买人或其上级存在
            $benefit     = $i == 0 ? $member['m_id'] : $member["m_{$tmp}_id"];
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
            $extra       = $extra_model->findUpdateExtraByMid($benefit);
            $deduct_list = $deduct_model->fetchDeductListBySid($this->sid, $extra['ame_copartner']);
            $deduct      = $deduct_list[1];
            $data[$i]    = $deduct['cdc_' . $i . 'f_ratio'];
        }
        return $data;
    }

    /*
     * 商城订单提成记录
     * $tid 订单ID
     * $ttid    订单号
     */
    private function _recharge_order_deduct($tid, $total)
    {

        //获取店铺分成佣金设置
        $deduct_model = new App_Model_Shop_MysqlDeductStorage();
        $deduct_list  = $deduct_model->fetchDeductListBySid($this->sid, 2);

        $goods_deduct = new App_Model_Goods_MysqlDeductStorage($this->sid);
        $order_deduct = new App_Helper_OrderDeduct($this->sid);

        //使用店铺分佣设置
        $ratio = $this->_deduct_translate($deduct_list[1]);
        //设置商品分佣
        $order_deduct->createOrderDeduct($this->member['m_id'], $tid, $total, $ratio, 0, 2);
    }

    /*
     * 提成比例转换
     */
    private function _deduct_translate($deduct)
    {
        return array(0 => $deduct['dc_0f_ratio'], 1 => $deduct['dc_1f_ratio'], 2 => $deduct['dc_2f_ratio'], 3 => $deduct['dc_3f_ratio']);
    }

    /**
     * 余额收支记录
     */
    public function memberRechargeListAction()
    {
        $page         = $this->request->getIntParam('page');
        $index        = $page * $this->count;
        $record_model = new App_Model_Member_MysqlRechargeStorage($this->sid);
        $where[]      = array('name' => 'rr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]      = array('name' => 'rr_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $sort         = array('rr_create_time' => 'DESC');

        $total = $record_model->getCount($where);
        if ($total == 0) {
            $this->outputError("暂无收支记录");
        }
        $list = $record_model->getList($where, $index, $this->count, $sort);
        $data = array();
        if ($list) {
            foreach ($list as $key => $val) {
                if ($val['rr_status'] == 1) {
                    if ($val['rr_pay_type'] == 4) {
                        $desc = '管理员充值';
                    } elseif ($val['rr_pay_type'] == 10) {
                        $desc = '订单退款';
                    } elseif ($val['rr_pay_type'] == 11) {
                        $desc = '红包收入';
                    } elseif ($val['rr_pay_type'] == 13) {
                        $desc = '会员卡赠送';
                    } elseif ($val['rr_pay_type'] == 14) {
                        $desc = '订单关闭退还';
                    } elseif ($val['rr_pay_type'] == 15) {
                        $desc = '订单退款';
                    } elseif ($val['rr_pay_type'] == 17) {
                        $desc = '卡密充值';
                    } elseif ($val['rr_pay_type'] == 18) {
                        $desc = '收银台退款';
                    } else {
                        $desc = '余额充值';
                    }
                } else {
                    $desc = '订单支付';
                }
                $data[] = array(
                    'payMoney'   => $val['rr_amount'],
                    'getCoin'    => $val['rr_gold_coin'],
                    'payType'    => $val['rr_pay_type'],
                    'status'     => $val['rr_status'],
                    'statusDesc' => $desc,
                    'time'       => date('Y-m-d H:i:s', $val['rr_create_time']),
                );
            }
            if ($data) {
                $info['data'] = $data;
                $this->outputSuccess($info);
            } else {
                $this->outputError("数据异常请稍后重试");
            }
        } else {
            $this->outputError("数据已经加载完毕");
        }

    }

    /**
     * 用户id，十进制与32进制之间相互转换
     * @param mixed $num 待转换的数字，10进制或32进制
     * @param bool $dec $num是否为十进制
     * @return mixed
     */
    public static function uidConvert($num, $dec = true)
    {
        if ($dec) {
            return base_convert($num, 10, 32);
        } else {
            return base_convert($num, 32, 10);
        }
    }

    /*
     * 申请手机号审核
     */
    public function submitMobileApplyAction()
    {
        $mobile = $this->request->getStrParam('mobile');
        $name   = $this->request->getStrParam('name');
        $status = $this->request->getIntParam('status', 0);
        if ($mobile && $name) {

            $wxclient_help = new App_Plugin_Weixin_WxxcxClient(1); // 默认使用1号店铺的授权信息验证
            $result        = $wxclient_help->checkMsg($content);
            if ($result && $result['errcode'] == 87014) {
                $this->outputError($result['errmsg']);
            }

            $apply_model = new App_Model_Member_MysqlMemberMobileApplyStorage($this->sid);
            $exist       = $apply_model->findRowByMobile($mobile, $this->sid);
            if ($exist && $exist['mma_m_id'] != $this->member['m_id']) {
                $this->outputError('手机号已经存在');
            }

            if (strlen($mobile) == 11) {
                $row  = $apply_model->findupdateByMid($this->member['m_id'], $this->sid);
                $data = array(
                    'mma_name'        => $name,
                    'mma_mobile'      => $mobile,
                    'mma_update_time' => time(),
                    'mma_status'      => 1, //待审核
                );

                $mobileCfg_model = new App_Model_Member_MysqlMemberMobileCfgStorage($this->sid);
                $mobileCfg       = $mobileCfg_model->findUpdateBySid($this->sid);
                if ($mobileCfg && $mobileCfg['mmc_auto_verify'] == 1) {
                    //提交即通过
                    $data['mma_status'] = 2;
                }

                if ($row) {
                    //已经有申请
                    $id = $row['mma_id'];
                    $ret = $apply_model->findupdateByMid($this->member['m_id'], $this->sid, $data);
                } else {
                    $data['mma_s_id'] = $this->sid;
                    $data['mma_m_id'] = $this->member['m_id'];
                    $ret = $id = $apply_model->insertValue($data);
                }
                if ($ret) {
                    //将会员表中审核状态更新
                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $member_model->updateById(array('m_mobile_check' => 1), $this->member['m_id']);
                    $info['data'] = array(
                        'applyStatus' => 1,
                        'applyMsg'    => $data['mma_status'] == 2 ? '申请成功' : '申请成功，请等待管理员审核',
                    );
                    plum_open_backend('templmsg', 'mobileApplyTempl', array('sid' => $this->sid, 'id' => $id, 'appletType' => $this->appletType));


                    $this->outputSuccess($info);
                } else {
                    $this->outputError('申请失败');
                }
            } else {
                $this->outputError('请填写正确的手机号');
            }
        } else {
            $this->outputError('请将信息填写完整');
        }
    }
    /*
     * 基础商城营销商城 判断是否开启了手机号验证以及用户是否通过验证
     * 已弃用 返回信息合并至applet_start_page
     */
    public function checkMobileApplyAction()
    {
        $member      = $this->member;
        $msg         = '';
        $applyStatus = 0;
        $applyMobile = '';
        $applyName   = '';
        $cfg_model   = new App_Model_Member_MysqlMemberMobileCfgStorage($this->sid);
        $cfg         = $cfg_model->findUpdateBySid($this->sid);
        $applyPlugin = $this->checkToolUsable('yhyz'); //是否开通了手机号认证
        if ($applyPlugin) {
            $applyOpen = $cfg ? intval($cfg['mmc_open']) : 0;
            if ($cfg && $cfg['mmc_open'] == 1) {
                $apply_model = new App_Model_Member_MysqlMemberMobileApplyStorage($this->sid);
                $apply       = $apply_model->findUpdateByMid($member['m_id'], $this->sid);
                if ($apply) {
                    $applyStatus = intval($apply['mma_status']);
                    $applyMobile = $apply['mma_mobile'];
                    $applyName   = $apply['mma_name'];
                    if ($applyStatus == 1) {
                        $msg = '您已提交请认证，请等待管理员审核';
                    } elseif ($applyStatus == 3) {
                        $reason = $apply['mma_handle_remark'] ? "，原因{$apply['mma_handle_remark']}" : '';
                        $msg    = '审核未通过' . $reason . '，请修改后重新提交';
                    }
                }
            } else {
                $applyStatus = 2; //没有配置或未开启 默认通过
            }
        } else {
            $applyStatus = 2; //功能未开通 默认通过
        }

        $info['data']['applyTitle']  = '申请认证';
        $info['data']['applyTip']    = $cfg['mmc_tip'] ? $cfg['mmc_tip'] : '';
        $info['data']['applyOpen']   = $applyOpen; //是否开启了手机号认证
        $info['data']['applyStatus'] = $applyStatus; //会员手机号认证状态
        $info['data']['applyMsg']    = $msg;
        $info['data']['applyMobile'] = $applyMobile;
        $info['data']['applyName']   = $applyName;

        $this->outputSuccess($info);
    }
    /*
     * 微财猫获取用户unionID
     */
    public function getUserUninonidAction()
    {
        $code          = $this->request->getStrParam('code'); // 用户code
        $iv            = $this->request->getStrParam('iv'); // 加密算法的初始向量
        $encryptedData = $this->request->getParam('encryptedData'); // 加密后的数据
        // 获取用户授权方式
        $auth = App_Plugin_Weixin_WxxcxClient::weixinAuthType($this->sid);
        if ($auth == App_Plugin_Weixin_WxxcxClient::WEIXIN_AUTH_OPEN) {
            // 获取用户的openID
            $wxxcx_client = new App_Plugin_Weixin_WxxcxClient($this->sid);
            $result       = $wxxcx_client->fetchOpenidByCode($this->curr_appid, $code);
        } else {
            $result = App_Helper_WeixinEvent::getWxopenid($this->curr_appid, $this->applet_cfg['ac_appsecret'], $code);
        }
        if ($result && $result['unionid']) {
            $updata       = array('m_union_id' => $result['unionid']);
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $member_model->updateById($updata, $this->uid);
            $info['data'] = array(
                'result' => true,
                'msg'    => '获取成功',
                'data'   => $result,
            );
            $this->outputSuccess($info);
        } else if ($result && $result['openid']) {
            // 获取到用户的openID
            if ($result['session_key'] && $iv && $encryptedData) {
                $userinfo = $this->_get_user_info($result['session_key'], $iv, $encryptedData);
                if ($userinfo) {
                    $updata       = array('m_union_id' => $userinfo['unionId']);
                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $member_model->updateById($updata, $this->uid);
                    $info['data'] = array(
                        'result' => true,
                        'msg'    => '获取成功',
                        'data'   => $userinfo,
                    );
                    $this->outputSuccess($info);
                } else {
                    $this->outputError('获取失败');
                }
            }
        } else {
            $this->outputError('获取失败，请稍后重试');
        }
    }

    /*
     * 获取用户会员卡信息
     */
    public function getMemberCardInfoAction()
    {
        if ($this->member['m_openid'] && $this->member['m_union_id']) {
            //获取微信会员信息
            $client     = new App_Plugin_Vcaimao_PayClient($this->sid);
            $memberInfo = $client->getMemberInfo($this->member['m_union_id'], $this->member['m_openid']);
            if ($memberInfo && !$memberInfo['errcode'] && $memberInfo['data']) {
                $info['data'] = array(
                    'cardid'    => $memberInfo['data']['cardid'],
                    'extraData' => $memberInfo['data']['extraData'],
                    'openid'    => $memberInfo['data']['openid'],
                    'code'      => $memberInfo['data']['code'],
                    'name'      => $memberInfo['data']['name'],
                    'status'    => $memberInfo['data']['status'],
                    'levelName' => $memberInfo['data']['level_name'],
                    'bonus'     => $memberInfo['data']['bonus'],
                    'balance'   => round(($memberInfo['data']['balance'] / 100), 2),
                );
                $this->outputSuccess($info);
            } else {
                $this->outputError('获取用户信息失败');
            }
        } else {
            $this->outputError('获取会员卡信息失败');
        }
    }

    /*
     * 微信小程序获取用户信息
     * 通过code iv  encryptedData 获取用户信息
     */
    public function _fetch_member_info()
    {
        $code          = $this->request->getStrParam('code'); // 用户code
        $iv            = $this->request->getStrParam('iv'); // 加密算法的初始向量
        $encryptedData = $this->request->getParam('encryptedData'); // 加密后的数据
        $signature     = $this->request->getParam('signature'); // 签名（头条小程序使用）
        $rawData       = $this->request->getParam('rawData'); // 签名（头条小程序使用）
        if ($this->appletType == 4) {
            $result = App_Plugin_Toutiao_XcxClient::getToutiaoOpenid($this->curr_appid, $this->applet_cfg['ac_appsecret'], $code);
        } else {
            // 获取用户授权方式
            $auth = App_Plugin_Weixin_WxxcxClient::weixinAuthType($this->sid);
            if ($auth == App_Plugin_Weixin_WxxcxClient::WEIXIN_AUTH_OPEN) {
                // 获取用户的openID
                $wxxcx_client = new App_Plugin_Weixin_WxxcxClient($this->sid);
                $result       = $wxxcx_client->fetchOpenidByCode($this->curr_appid, $code);
            } else {
                $result = App_Helper_WeixinEvent::getWxopenid($this->curr_appid, $this->applet_cfg['ac_appsecret'], $code);
            }
            if ($result && $result['unionid']) {
                $result['unionId'] = $result['unionid'];
                return $result;
            }
        }
        // 获取到用户的openID
        if ($result['openid']) {
            if ($result['session_key'] && $iv && $encryptedData) {
                $userinfo = $this->_get_user_info($result['session_key'], $iv, $encryptedData);
                if ($userinfo) {
                    return $userinfo;
                }
            }
        }
        return false;
    }

    /**
     * 获取余额核销二维码
     */
    public function balanceVerifyQrcodeAction()
    {
        if (!$this->member['m_invite_code']) {
            $code = plum_random_code();
            //将生成的邀请码插入数据库
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $updata         = array(
                'm_invite_code' => $code,
            );
            $member_storage->updateById($updata, $this->member['m_id']);
            $this->member['m_invite_code'] = $code;
        }

        $hold_dir    = PLUM_APP_BUILD . '/spread/';
        $access_path = PLUM_PATH_PUBLIC . '/build/spread/';

        //开始生成核销二维码
        if (plum_setmod_dir($hold_dir)) {
            $params = array(
                'code' => $this->member['m_invite_code'],
                'time' => time(),
            );
            $filename = time() . '-' . $this->member['m_invite_code'] . '.png';

            Libs_Qrcode_QRCode::png(json_encode($params), $hold_dir . $filename, 'Q', 6, 1);

            $info['data']['time']     = 3 * 60;
            $info['data']['timeDesc'] = "二维码3分钟内有效";
            $info['data']['code']     = $this->dealImagePath($access_path . $filename);

            $this->outputSuccess($info);
        } else {
            $this->outputError("获取失败");
        }
    }

    /*
     * 仅检查用户信息是否存在
     */
    public function checkMemberInfoAction()
    {
        if ($this->member) {
            $this->outputSuccess();
        } else {
            $this->outputError('');
        }
    }
    /*
     * 团长邀请
     */
    public function delegationInvitedaAction(){
        $htsId          = $this->request->getIntParam('htsId'); //分享人id
        $member_storage        = new App_Model_Member_MysqlMemberCoreStorage();
        if($htsId){
            $member_row = $member_storage->getRowById($htsId);

        }else{
            $this->outputError('用户信息错误');
        }

    }

    /*
       * 团长邀请
     */
    public function delegationInvitedAction()
    {
        $id      = $this->request->getIntParam('htsId');  //分享人id
//        $showCom = $this->request->getIntParam('showCom');
        if ($id) {
            //判断是否已经是老用户
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
            $extra       = $extra_model->findUpdateExtraByMid($id);
            if($extra){
                $this->outputError('您已是会员');
            }else{
                //查询是否是团长
                $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage();  //团长列表
                $leader_row  = $leader_model->getRowById($id);
                if($leader_row){
                    //查询团长是否有分配的小区
                    $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage();
                    $where[]   = array('name' => 'asc_s_id', 'oper' => '=', 'value' => $this->sid);
                    $where[]   = array('name' => 'asc_deleted', 'oper' => '=', 'value' => 0);
                    $where[]   = array('name' => 'asc_leader', 'oper' => '=', 'value' => $leader_row['asl_id']);
                    $community_row = $community_model->getRow($where);
                    $insert = [
                        'ame_s_id'        => $this->sid,
                        'ame_m_id'        => $this->member['m_id'],
                        'ame_se_cid'      => $community_row['asc_id'],
                        'ame_create_time' => time(),
                    ];
                    $res = $extra_model->insertValue($insert);
                    if ($res) {
                        $info['data'] = array(
                            'msg' => '保存成功',
                        );
                        $this->outputSuccess($info);
                    } else {
                        $this->outputError('保存失败');
                    }
                }else{
                    $insert = [
                        'ame_s_id'        => $this->sid,
                        'ame_m_id'        => $this->member['m_id'],
                        'ame_se_cid'      => '176',
                        'ame_create_time' => time(),
                    ];
                    $res = $extra_model->insertValue($insert);
                    if ($res) {
                        $info['data'] = array(
                            'msg' => '保存成功',
                        );
                        $this->outputSuccess($info);
                    } else {
                        $this->outputError('保存失败');
                    }
                }
            }
        } else {
            $this->outputError('数据错误');
        }
    }

    /*
  * 获取团长分享二维码信息
  */
    public function getDelegationImgAction()
    {
        $htsId = $this->request->getIntParam('htsId', 0);
        $str = "htsId=".$htsId;
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->sid);
        $url = $client_plugin->fetchWxappShareCode($str);
        $info['data'] = array(
            'img' => $this->dealImagePath($url),
        );
        $this->outputSuccess($info);
    }


}
