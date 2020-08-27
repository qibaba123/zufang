<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/18
 * Time: 下午11:02
 */
require_once __DIR__ . '/lib/KdtApiOauthClient.php';

class App_Plugin_Youzan_OauthClient extends KdtApiOauthClient {
    private $auto_log   = "auto-shop.log";
    //店铺id
    private $sid;
    //授权的AccessToken
    private $access_token = null;
    /*
     * 有赞店铺配置信息，字段名参考pre_youzan_cfg
     */
    private $youzan_cfg;
    /*
     * 店铺配置信息，字段名参考pre_shop
     */
    private $shop;

    public function __construct($sid) {
        if (!$sid) {
            return null;
        }
        $this->sid  = $sid;

        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop     = $shop_storage->getRowById($sid);

        //获取access token
        $youzan_auth_storage    = new App_Model_Auth_MysqlYouzanAuthStorage();

        $where[]    = array('name' => 'yc_s_id', 'oper' => '=', 'value' => $this->sid);
        $cfg        = $youzan_auth_storage->getRow($where);
        //店铺未授权，或未进行授权，则返回错误
        if (!$cfg || !$cfg['yc_basic_sid']) {
            trigger_error('有赞店铺配置信息查询失败，请检查sid='.$this->sid, E_USER_WARNING);
            return null;
        }
        $this->youzan_cfg   = $cfg;
        //判断access token是否失效
        if ($cfg['yc_token_expires'] < time()) {//已失效，重新获取
            $app_cfg    = plum_parse_config('youzan', 'app');
            $url        = 'https://open.koudaitong.com/oauth/token';
            $params     = array(
                'client_id'     => $app_cfg['client_id'],
                'client_secret' => $app_cfg['client_secret'],
                'grant_type'    => 'refresh_token',
                'refresh_token' => $cfg['yc_refresh_token'],
            );

            $ret = Libs_Http_Client::post($url, $params);
            $ret = json_decode($ret, true);
            if (isset($ret['access_token'])) {
                //更新access token
                $updata = array(
                    'yc_access_token'   => $ret['access_token'],
                    'yc_refresh_token'  => $ret['refresh_token'],
                    'yc_token_expires'  => time()+intval($ret['expires_in']),
                );

                $youzan_auth_storage->updateById($updata, $cfg['yc_id']);

                $this->access_token = $ret['access_token'];
            } else {
                trigger_error('有赞店铺通过refresh token获取access token失败，请检查sid='.$this->sid, E_USER_WARNING);
                return null;
            }
        } else {
            $this->access_token = $cfg['yc_access_token'];
        }
    }

    /*
     * 拉取微信粉丝用户信息列表
     */
    public function pullWeixinFollowers() {
        if (!$this->access_token) {
            return false;
        }
        $method = 'kdt.users.weixin.followers.pull';
        $params = [
            'after_fans_id' => $this->youzan_cfg['yc_last_fans_id'],
            'page_size'     => 50,
        ];

        $data   = $this->post($this->access_token, $method, $params);

        //返回正确数据
        if (isset($data['response'])) {
            if (count($data['response']['users']) > 0) {
                $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
                //获取用户数据并插入数据库
                foreach ($data['response']['users'] as $user) {
                    $indata = array(
                        'm_s_id'        => $this->sid,
                        'm_c_id'        => $this->shop['s_c_id'],//所属公司信息
                        'm_user_id'     => $user['user_id'],//微信粉丝在有赞的唯一ID
                        'm_openid'      => $user['weixin_openid'],//加密后的微信号，每个用户对每个公众号的OpenID是唯一的
                        'm_nickname'    => $user['nick'],
                        'm_avatar'      => $user['avatar'],
                        'm_sex'         => strtoupper($user['sex']) == 'M' ? "M" : "Y",//转换为内部使用
                        'm_province'    => $user['province'],
                        'm_city'        => $user['city'],
                        //'m_points'      => $user['points'],//不保存交易信息
                        //'m_traded_num'  => $user['traded_num'],
                        //'m_traded_money'=> $user['traded_money'],
                        'm_union_id'    => $user['union_id'],
                        'm_is_follow'   => 1,//已关注
                        'm_follow_time' => $user['follow_time'],
                    );
                    $member_storage->insertShopNewMember($this->sid, $indata);
                }
            }

            if ($data['response']['has_next']) {
                $yz_cfg_storage = new App_Model_Auth_MysqlYouzanAuthStorage();
                $updata = array(
                    'yc_last_fans_id'   => $data['response']['last_fans_id'],
                );
                $where[]    = array('name' => 'yc_s_id', 'oper' => '=', 'value' => $this->sid);
                $yz_cfg_storage->updateValue($updata, $where);
                //更新当前last fans id
                $this->youzan_cfg['yc_last_fans_id']    = $updata['yc_last_fans_id'];
                //递归调取
                $this->pullWeixinFollowers();
            }
        }
    }

    /*
     * 获取指定时间段内新创建的订单
     * @param int $pageno   当前页码，默认为1，用于递归调用
     */
    public function getNewSoldTrades($pageno = 1) {
        if (!$this->access_token) {
            return false;
        }
        //获取订单上次更新时间，如无则设置为0
        $start_created  = intval($this->youzan_cfg['yc_last_trade_time']);
        $start_created  = $start_created ? $start_created : 0;
        $this->youzan_cfg['yc_last_trade_time'] = $start_created;
        $start_time     = date('Y-m-d H:i:s', $start_created);
        //设置订单创建结束时间，如无则设置为当前时间
        $end_created    = time();
        $end_time       = date('Y-m-d H:i:s', $end_created);

        $method = 'kdt.trades.sold.get';
        $params = [
            'fields'        => 'tid,num,title,weixin_user_id,buyer_nick,status,post_fee,total_fee,payment,created,update_time,pay_time,feedback',
            'start_created' => $start_time,
            'end_created'   => $end_time,
            'page_no'       => $pageno,
            'page_size'     => 40,
            'use_has_next'  => true,
        ];
        $data   = $this->post($this->access_token, $method, $params);

        if (isset($data['response'])) {
            Libs_Log_Logger::outputLog("获取店铺《{$this->shop['s_name']}》新创建订单数量".count($data['response']['trades']), $this->auto_log);
            if (count($data['response']['trades']) > 0) {
                $order_helper   = new App_Helper_OrderLevel($this->sid);
                //获取用户数据并插入数据库
                foreach ($data['response']['trades'] as $order) {
                    $order_helper->youzanOrderCreateDeal($order);
                }
            }
            if ($data['response']['has_next']) {
                //有下页数据
                //递归调取
                $this->getNewSoldTrades(++$pageno);
            } else {
                //无下页数据时，保存上次交易创建时间
                $yz_cfg_storage = new App_Model_Auth_MysqlYouzanAuthStorage();
                $updata = array(
                    'yc_last_trade_time'   => $end_created,
                );
                $where[]    = array('name' => 'yc_s_id', 'oper' => '=', 'value' => $this->sid);
                $yz_cfg_storage->updateValue($updata, $where);
            }
        } else {
            Libs_Log_Logger::outputLog("有赞店铺《{$this->shop['s_name']}》订单获取失败", $this->auto_log);
            Libs_Log_Logger::outputLog($data, $this->auto_log);
            trigger_error($data['error_response']['msg'], E_USER_ERROR);
        }
    }

    /*
     * 获取起止时间内有状态更新的订单
     */
    public function getUpdateSoldTrades($start_time, $end_time, $pageno = 1) {
        if (!$this->access_token) {
            return false;
        }
        $method = 'kdt.trades.sold.get';
        $params = [
            'fields'        => 'tid,num,title,weixin_user_id,buyer_nick,status,post_fee,total_fee,payment,created,update_time,pay_time,feedback',
            'start_update' => date('Y-m-d H:i:s', $start_time),
            'end_update'   => date('Y-m-d H:i:s', $end_time),
            'page_no'       => $pageno,
            'page_size'     => 40,
            'use_has_next'  => true,
        ];
        $data   = $this->post($this->access_token, $method, $params);

        if (isset($data['response'])) {
            Libs_Log_Logger::outputLog("获取店铺《{$this->shop['s_name']}》状态更新订单数量".count($data['response']['trades']), $this->auto_log);

            if (count($data['response']['trades']) > 0) {
                $order_helper   = new App_Helper_OrderLevel($this->sid);
                //获取用户数据并插入数据库
                foreach ($data['response']['trades'] as $order) {
                    $order_helper->youzanOrderUpdateDeal($order);
                }
            }
            if ($data['response']['has_next']) {
                //有下页数据
                //递归调取
                $this->getUpdateSoldTrades($start_time, $end_time, ++$pageno);
            } else {
                //无下页数据时

            }
        }
    }

    /*
     * 获取店铺基本信息
     */
    public function getShopBasicInfo($accessToken = null) {
        if (!$accessToken) {
            return false;
        }

        $method = 'kdt.shop.basic.get';
        $data   = $this->post($accessToken, $method);

        if (isset($data['response'])) {
            return $data['response'];
        } else {
            return false;
        }
    }

    /*
     * 获取有赞单笔交易的信息，订单状态更新时使用
     * 更新原有订单
     * @param int $status 保存的状态
     */
    public function getTradeOnly($tid, $status = 0) {
        if (!$this->access_token) {
            return false;
        }
        $method = 'kdt.trade.get';
        $params = [
            'fields'        => 'tid,status,update_time,pay_time,feedback',
            'tid'           => $tid,
        ];
        $data   = $this->post($this->access_token, $method, $params);

        if (isset($data['response'])) {
            Libs_Log_Logger::outputLog("获取店铺《{$this->shop['s_name']}》单笔交易{$tid}", $this->auto_log);

            $order_helper   = new App_Helper_OrderLevel($this->sid);
            return $order_helper->youzanOrderUpdateDeal($data['response']['trade'], $status);
        }
        return false;
    }

    /*
     * 获取完整的单笔交易信息，订单修复时使用
     * 创建新订单
     */
    public function getSingleTrade($tid) {
        $flag = false;
        if ($this->access_token) {
            $method = 'kdt.trade.get';
            $params = [
                'fields'        => 'tid,num,title,weixin_user_id,buyer_nick,status,post_fee,total_fee,payment,created,update_time,pay_time,feedback',
                'tid'           => $tid,
            ];
            $data   = $this->post($this->access_token, $method, $params);
            $flag = true;

            if (isset($data['response'])) {
                Libs_Log_Logger::outputLog("获取店铺《{$this->shop['s_name']}》单笔交易{$tid}成功", $this->auto_log);

                $order_helper   = new App_Helper_OrderLevel($this->sid);
                $flag = $order_helper->youzanOrderCreateDeal($data['response']['trade']);
            }
        }
        return $flag;

    }

    /*
     * 获取单笔交易订单数据
     */
    public function fetchSingleTrade($tid) {
        if (!$this->access_token) {
            return false;
        }
        $method = 'kdt.trade.get';
        $params = [
            'fields'        => '',
            'tid'           => $tid,
        ];
        $data   = $this->post($this->access_token, $method, $params);

        if (isset($data['response'])) {
            return $data['response']['trade'];
        }
        return false;
    }

    /*
     * 通过微信openID或有赞用户id获取微信粉丝用户信息
     */
    public function getWeixinFollower($open_id, $open = true) {
        if (!$this->access_token) {
            return false;
        }
        $method = 'kdt.users.weixin.follower.get';
        $rq_key = $open ? "weixin_openid" : "user_id";
        $params = [
            'fields'        => 'user_id,weixin_openid,nick,avatar,follow_time,sex,province,city,points,traded_num,traded_money,union_id,is_follow',
            $rq_key         => $open_id,
        ];
        $data   = $this->post($this->access_token, $method, $params);

        if (isset($data['response'])) {
            $user   = $data['response']['user'];

            $member = App_Helper_MemberLevel::restoreMemberInfo($user, $this->sid);
            return $member;
        }
        return false;
    }

    /*
     * 获取微信粉丝信息
     */
    public function fetchWeixinFollower($open_id, $open = true) {
        if (!$this->access_token) {
            return false;
        }
        $method = 'kdt.users.weixin.follower.get';
        $rq_key = $open ? "weixin_openid" : "user_id";
        $params = [
            'fields'        => 'user_id,weixin_openid,nick,avatar,follow_time,sex,province,city,points,traded_num,traded_money,union_id,is_follow',
            $rq_key         => $open_id,
        ];
        $data   = $this->post($this->access_token, $method, $params);

        if (isset($data['response'])) {
            $user   = $data['response']['user'];

            return $user;
        }
        return false;
    }
    /*
     * 获取全店出售中的商品列表
     */
    public function getGoodsList($page_num = 1, $page_size = 50) {
        if (!$this->access_token) {
            return array('status' => false, 'msg' => "店铺授权失败");
        }
        $method = 'kdt.items.onsale.get';
        $params = [
            'page_no'   => $page_num,
            'page_size' => $page_size,
            'order_by'  => "created:asc",
        ];
        $data   = $this->post($this->access_token, $method, $params);

        if (isset($data['response'])) {
            return $data['response'];
        }
        return array('status' => false, 'msg' => $data['error_response']['msg']);
    }
}