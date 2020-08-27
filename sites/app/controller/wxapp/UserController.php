<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/24
 * Time: 上午11：35
 */

class App_Controller_Wxapp_UserController extends App_Controller_Wxapp_InitController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function userInfoAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '店铺设置', 'link' => '#'),
        ));
        //配置营业时间 基础商城 万能商城 营销商城
        $appletType = intval($this->wxapp_cfg['ac_type']);
        if(in_array($appletType,array(21,1,24))) {
            $this->output['showTime'] = 1;
        }
        $this->_get_shop_notice();
        //显示店铺公告
        if(in_array($this->wxapp_cfg['ac_type'],[1,21,50])){
            $this->output['showNotice'] = 1;
        }

        if(in_array($this->wxapp_cfg['ac_type'],[6,8])){
            $this->output['verifyPasswd'] = 1;
        }
        $this->output['appletCfg'] = $this->wxapp_cfg;

        $this->output['infos']  = array(
            'name'      => $this->curr_shop['s_name'],
            'logo'      => $this->curr_shop['s_logo'],
            'phone'     => $this->curr_shop['s_phone'],
            'contact'   => $this->curr_shop['s_contact'],
            'start_time'=> $this->curr_shop['s_start_time'],
            'end_time'  => $this->curr_shop['s_end_time'],
            'mobile'    => $this->manager['m_mobile'],
            'province'  => $this->company['c_province'],
            'city'      => $this->company['c_city']
        );
        $this->output['manager'] = $this->manager;
        $isTestAccount = 0;
        // 查询测试账号信息
        $cfg = plum_parse_config('category','applet');
        $account =  $cfg[$appletType]['test']['account'];
        if($account==$this->manager['m_mobile']){
            $isTestAccount = 1;
        }
        $this->output['isTestAccount'] = $isTestAccount;

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/update-info.tpl');
    }

    /**
     * 修改小程序appid和appsecret
     */
    public function saveAppletCfgAction(){
        $appid = $this->request->getStrParam('appid');
        $appsecret = $this->request->getStrParam('appsecret');

        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $set = array('ac_appid' => $appid, 'ac_appsecret' => $appsecret);
        $ret     = $applet_model->fetchUpdateCfgBySid($this->curr_sid, $set);

        $this->showAjaxResult($ret);
    }

    /*
     * 获得店铺公告
     */
    private function _get_shop_notice(){
        $notice_storage     = new App_Model_Shop_MysqlShopNoticeStorage($this->curr_sid);
        $notice     = $notice_storage->fetchNoticeShowNew();
        $this->output['notice'] = $notice;
    }

    /**
     * 修改密码
     */
    public function changePasswordAction(){
        $result = array(
            'ec' => 400,
            'em' => '修改失败'
        );
        $old_pass = $this->request->getStrParam('old_pass');
        $new_pass = $this->request->getStrParam('new_pass');
        if($this->uid && $old_pass && $new_pass){
            $manager_model = new App_Model_Member_MysqlManagerStorage();
            $member = $manager_model->getRowById($this->uid);
            if($member['m_password'] == plum_salt_password($old_pass)){
                if($member['m_password'] == plum_salt_password($new_pass)){
                    $result['em'] = '原密码和新密码一致无需修改';
                }else{
                    $set = array('m_password'=>plum_salt_password($new_pass), 'm_change_passwd_time' => time());
                    $ret = $manager_model->updateById($set,$this->uid);
                    if($ret){
                        $result = array(
                            'ec' => 200,
                            'em' => '修改成功'
                        );
                        App_Helper_OperateLog::saveOperateLog("密码修改成功");
                    }
                }
            }else{
                $result['em'] = '原密码错误，请重新输入';
            }
        }else{
            $result['em'] = '输入信息有误请重试';
        }
        $this->displayJson($result);
    }

    /**
     * 修改核销密码
     */
    public function changeVerifyPasswordAction(){
        $result = array(
            'ec' => 400,
            'em' => '修改失败'
        );
        $old_pass = $this->request->getStrParam('old_pass');
        $new_pass = $this->request->getStrParam('new_pass');

        if($this->manager['m_fid'] > 0){
            $this->displayJsonError('只有总管理员可以修改核销密码');
        }

        if($this->uid && $new_pass){
            if($this->curr_shop['s_verify_passwd'] == plum_salt_password($old_pass) || !$this->curr_shop['s_verify_passwd']){
                if($this->curr_shop['s_verify_passwd'] == plum_salt_password($new_pass)){
                    $result['em'] = '原密码和新密码一致无需修改';
                }else{
                    $set = array('s_verify_passwd'=>plum_salt_password($new_pass));
                    $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
                    $ret = $shop_model->updateById($set,$this->curr_sid);
                    if($ret){
                        $result = array(
                            'ec' => 200,
                            'em' => '修改成功'
                        );
                        App_Helper_OperateLog::saveOperateLog("核销密码修改成功");
                    }
                }
            }else{
                $result['em'] = '原密码错误，请重新输入';
            }
        }else{
            $result['em'] = '输入信息有误请重试';
        }
        $this->displayJson($result);
    }

    /**
     * 保存店铺信息
     */
    public function saveShopInfoAction(){

        if($this->manager['m_fid'] > 0){
            $this->displayJsonError('只有总管理员可以修改店铺信息');
        }

        $strField   = array('name','logo','phone','contact','start_time','end_time');
        $str_data   = $this->getStrByField($strField,'s_');
        $data       = $str_data;
        $data['s_update_time']  = time();
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $ret        = $shop_model->updateById($data,$this->curr_sid);
        $province = $this->request->getStrParam('prov');
        $city = $this->request->getStrParam('city');
        if(($province && $province!=$this->company['c_province']) || $city && $city!=$this->company['c_city']){
            $company_storage    = new App_Model_Member_MysqlCompanyCoreStorage();
            $ret = $company_storage->updateById(array('c_province'=>$province,'c_city'=>$city),$this->company['c_id']);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("店铺信息修改成功");
        }

        $this->showAjaxResult($ret,'保存');
    }

    public function testCookieAction(){
        $cookie = $_COOKIE;
        $password = $_COOKIE['plum_login_password'];
        $manager_storage    = new App_Model_Member_MysqlManagerStorage();
        $list = $manager_storage->getManagerByCompany(6142);
        if ($list) {
            $passwords = array();
            foreach ($list as $value) {
                $passwords[] = plum_salt_password($value['m_password']);
            }
            if (!in_array($password, $passwords)) {
                plum_app_user_logout();
                plum_redirect_with_msg('请登录', '/manage/user/index', 3);
            }
        }
    }
}