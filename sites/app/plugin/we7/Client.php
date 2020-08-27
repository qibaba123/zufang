<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/1/19
 * Time: 下午12:24
 */
class App_Plugin_We7_Client{

    const AUTH_KEY  = '73ca9c94';//具体值可在data/config.php中获得
    const AUTH_URL  = 'http://wx.tiandiantong.com/api/tdt.php';//同步登录认证URL

    private static $_instance;
    private static $DB;
    private $users_table;

    private function __construct() {
        //初始化数据库对象
        $db_config  = plum_parse_config('we7', 'mysql');
        self::$DB   = new Libs_Mysql_FactoryDB($db_config);
        $this->_init_table();
    }

    private function _init_table() {
        $this->users_table  = 'users';
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __clone() {
        trigger_error("single instance RequestHelper can not be cloned.", E_USER_ERROR);
    }

    public function query() {

    }
    /*
     * 同步注册到微擎
     */
    public function syn_register($sid) {
        $shop_model     = new App_Model_Shop_MysqlShopCoreStorage();
        $shop       = $shop_model->getRowById($sid);
        //已注册过
        if (!empty($shop['s_w_id'])) {
            return false;
        }
        $member = array();
        $pass       = plum_random_code(8);//生成随机密码
        $member['username'] = $shop['s_unique_id'];
        $member['password'] = $pass;

        $member['status'] = 2;
        $member['remark'] = '';
        $member['groupid'] = 3;//users_group 体验、白金、黄金
        $member['starttime'] = time();
        $member['endtime'] = 0;

        $uid = $this->user_register($member);
        if ($uid) {
            //同步写入shop表
            $updata = array(
                's_w_id'    => $uid,
                's_w_pass'  => $pass,//明文密码
            );
            $shop_model->updateById($updata, $sid);
            return $uid;
        }
        return false;
    }
    /**
     * 用户注册
     * PS:密码字段不要加密
     * @param array $user 用户注册信息，需要的字段必须包括 username, password, remark
     * @return int 成功返回新增的用户编号，失败返回 0
     */
    public function user_register($user) {
        if (empty($user) || !is_array($user)) {
            return 0;
        }
        if (isset($user['uid'])) {
            unset($user['uid']);
        }
        $ip     = plum_get_client_ip();
        $curr   = time();
        $user['salt']       = plum_random(8);
        $user['password']   = $this->_user_hash($user['password'], $user['salt']);
        $user['joinip']     = $ip;
        $user['joindate']   = $curr;
        $user['lastip']     = $ip;
        $user['lastvisit']  = $curr;
        if (empty($user['status'])) {
            $user['status'] = 2;
        }
        $ret = self::$DB->insert($this->users_table, $user, true);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        $user['uid'] = $ret;
        return intval($user['uid']);
    }
    /**
     * 计算用户密码
     * @param string $passwordinput 输入字符串
     * @param string $salt 附加字符串
     * @return string
     */
    private function _user_hash($passwordinput, $salt) {
        $passwordinput = "{$passwordinput}-{$salt}-".self::AUTH_KEY;
        return sha1($passwordinput);
    }
    /*
     * 同步登录到微擎
     */
    public function syn_login($sid) {
        $shop_model     = new App_Model_Shop_MysqlShopCoreStorage();
        $shop       = $shop_model->getRowById($sid);
        $wid    = intval($shop['s_w_id']);
        //未注册过
        if (!$wid) {
            $this->syn_register($sid);
        }
        $curr   = time();
        //同步登录
        $params = array('username' => $shop['s_unique_id'], 'password' => $shop['s_w_pass'], 'action' => 'synlogin');
        $code   = plum_authcode(http_build_query($params), 'ENCODE');
        $code   = urlencode($code);

        $attr   = array(
            'type'      => 'text/javascript',
            'src'       => self::AUTH_URL."?time={$curr}&code={$code}",
            'reload'    => 1,
        );

        $script = '<script';
        foreach ($attr as $key => $val) {
            $script .= " {$key}=\"{$val}\"";
        }
        $script .="></script>";
        return $script;
    }
    /*
     * 同步在微擎退出
     */
    public function syn_logout() {
        $curr   = time();
        //同步登录
        $params = array('action' => 'synlogout');
        $code   = plum_authcode(http_build_query($params), 'ENCODE');
        $code   = urlencode($code);

        $attr   = array(
            'type'      => 'text/javascript',
            'src'       => self::AUTH_URL."?time={$curr}&code={$code}",
            'reload'    => 1,
        );

        $script = '<script';
        foreach ($attr as $key => $val) {
            $script .= " {$key}=\"{$val}\"";
        }
        $script .="></script>";
        return $script;
    }
    /*
     * 同步微信到微擎
     */
    public function syn_wechat($sid) {
        $weixin_model   = new App_Model_Auth_MysqlWeixinStorage();
        $wxcfg      = $weixin_model->findWeixinBySid($sid);
        
        //为空时,同步账号
        if (empty($wxcfg['wc_uniacid'])) {
            $account_insert = array(
                'name'          => $wxcfg['wc_name'],
                'description'   => '',
                'groupid'       => 0,
            );
            $uniacid = self::$DB->insert('uni_account', $account_insert, true);
            //获取默认模板的id
            $we7cfg     = plum_parse_config('config', 'we7');
            $style_insert = array(
                'uniacid'       => $uniacid,
                'templateid'    => $we7cfg['template']['id'],
                'name'          => $we7cfg['template']['title'] . '_' . plum_random(4),
            );
            $styleid    = self::$DB->insert('site_styles', $style_insert, true);
            //给公众号添加默认微站
            $multi_insert = array(
                'uniacid'   => $uniacid,
                'title'     => $wxcfg['wc_name'],
                'styleid'   => $styleid,
            );
            $multi_id = self::$DB->insert('site_multi', $multi_insert, true);

            $unisetting_insert = array(
                'creditnames' => serialize(array(
                    'credit1' => array('title' => '积分', 'enabled' => 1),
                    'credit2' => array('title' => '余额', 'enabled' => 1)
                )),
                'creditbehaviors' => serialize(array(
                    'activity' => 'credit1',
                    'currency' => 'credit2'
                )),
                'uniacid' => $uniacid,
                'default_site' => $multi_id,
                'sync' => serialize(array('switch' => 0, 'acid' => '')),
            );
            self::$DB->insert('uni_settings', $unisetting_insert);
            self::$DB->insert('mc_groups', array('uniacid' => $uniacid, 'title' => '默认会员组', 'isdefault' => 1));
            /*
            $fields = self::$DB->fetch_all("SELECT * FROM ".self::$DB->table('profile_fields'));
            foreach($fields as $field) {
                $data = array(
                    'uniacid'   => $uniacid,
                    'fieldid'   => $field['id'],
                    'title'     => $field['title'],
                    'available' => $field['available'],
                    'displayorder' => $field['displayorder'],
                );
                self::$DB->insert('mc_member_fields', $data);
            }
            */
            $account_index_insert = array(
                'uniacid'   => $uniacid,
                'type'      => 3,
                'hash'      => plum_random(8),
                'isconnect' => 1
            );
            $acid = self::$DB->insert('account', $account_index_insert, true);
            //判断接入的公众号类型
            if ($wxcfg['wc_service_type'] = '0' || $wxcfg['wc_service_type'] == '1') {
                if ($wxcfg['wc_verify_type'] > '-1') {
                    $level = '3';
                } else {
                    $level = '1';
                }
            } elseif ($wxcfg['wc_service_type'] = '2') {
                if ($wxcfg['wc_verify_type'] > '-1') {
                    $level = '4';
                } else {
                    $level = '2';
                }
            }
            $wxpltcfg    = plum_parse_config('platform', 'weixin');
            $subaccount_insert = array(
                'acid'      => $acid,
                'uniacid'   => $uniacid,
                'name'      => $wxcfg['wc_name'],
                'account'   => $wxcfg['wc_app_no'],
                'original'  => $wxcfg['wc_gh_id'],
                'level'     => $level,
                'key'       => $wxcfg['wc_app_id'],
                'auth_refresh_token'    => $wxcfg['wc_auth_refresh_token'],
                'encodingaeskey'        => $wxpltcfg['crypt_key'],
                'token'     => $wxpltcfg['verify_token'],
            );
            self::$DB->insert('account_wechats', $subaccount_insert);

            self::$DB->update('uni_account', array('default_acid' => $acid), array('uniacid' => $uniacid));
            //写入创建者
            $shop_model     = new App_Model_Shop_MysqlShopCoreStorage();
            $shop       = $shop_model->getRowById($sid);
            $wid    = intval($shop['s_w_id']);
            self::$DB->insert('uni_account_users',  array('uniacid' => $uniacid, 'uid' => $wid, 'role' => 'owner'));
            //将同步信息写入微信配置表
            $updata = array('wc_uniacid' => $uniacid);
            $weixin_model->updateById($updata, $wxcfg['wc_id']);
        }
    }
}