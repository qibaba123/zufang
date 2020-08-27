<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/9/5
 * Time: 下午6:02
 */
class App_Helper_PluginIn {
    /*
     * 检查店铺是否开通微信小程序功能
     */
    public static function checkShopAppletOpen($sid,$appletType = 1) {
        if($appletType==2){   // 百度小程序
            $config_model = new App_Model_Baidu_MysqlBaiduCfgStorage($sid);
            $config     = $config_model->findShopCfg();
        }else if($appletType==3){   // 支付宝小程序
            $config_model = new App_Model_Alixcx_MysqlAlixcxCfgStorage($sid);
            $config     = $config_model->findShopCfg();
        } else if($appletType==4){   // 抖音头条小程序
            $config_model = new App_Model_Toutiao_MysqlToutiaoCfgStorage($sid);
            $config     = $config_model->findShopCfg();
        } else if($appletType && $appletType==5){    //微信公众号配置
            $applet_model = new App_Model_Weixin_MysqlWeixinCfgStorage($sid);
            $config = $applet_model->findShopCfg();
        } else if($appletType && $appletType==6){    //QQ小程序配置
            $applet_cfg = new App_Model_Qq_MysqlQqCfgStorage($sid);
            $config        = $applet_cfg->findShopCfg();
        } else if($appletType && $appletType==7){
            $applet_cfg = new App_Model_Qihoo_MysqlQihooCfgStorage($sid);
            $config        = $applet_cfg->findShopCfg();
        }else{
            $config_model   = new App_Model_Applet_MysqlCfgStorage($sid);
            $config     = $config_model->findShopCfg();
        }

        if ($config) {
            if ($config['ac_expire_time'] > time()) {
                $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $config['ac_expire_time']);
                return array('code' => 0, 'open'=> $config['ac_open_time'], 'expire'=> $config['ac_expire_time'], 'msg' => trim($expire));
            } else {
                return array('code' => 1, 'msg' => "应用已于".date('Y-m-d H:i:s', $config['ac_expire_time'])."到期, 请及时续费! ");
            }
        }
        return array('code' => 2, 'msg' => "应用未开通。");
    }
    /*
     * 检查店铺是否直播购物功能
     */
    public static function checkShopLiveOpen($sid) {
        $config_model   = new App_Model_Live_MysqlCfgStorage($sid);
        $config     = $config_model->findShopCfg();

        if ($config) {
            if ($config['lc_expire_time'] > time()) {
                $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $config['lc_expire_time']);
                return array('code' => 0, 'open'=> $config['lc_open_time'], 'expire'=> $config['lc_expire_time'], 'msg' => trim($expire));
            } else {
                return array('code' => 1, 'msg' => "应用已于".date('Y-m-d H:i:s', $config['lc_expire_time'])."到期, 请及时续费! ");
            }
        }
        return array('code' => 2, 'msg' => "应用未开通。");
    }
    /*
     * 检查店铺是否开通区域代理功能
     */
    public static function checkShopRegionOpen($sid) {
        $config_model   = new App_Model_Region_MysqlCfgStorage($sid);
        $config     = $config_model->findShopCfg();

        if ($config) {
            if ($config['rc_expire_time'] > time()) {
                $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $config['rc_expire_time']);
                return array('code' => 0, 'open'=> $config['rc_open_time'], 'expire'=> $config['rc_expire_time'], 'msg' => trim($expire));
            } else {
                return array('code' => 1, 'msg' => "应用已于".date('Y-m-d H:i:s', $config['rc_expire_time'])."到期, 请及时续费! ");
            }
        }
        return array('code' => 2, 'msg' => "应用未开通。");
    }
    /*
     * 检查店铺是否开通线下门店功能
     */
    public static function checkShopOfflineOpen($sid) {
        $config_model   = new App_Model_Store_MysqlStoreCfgStorage($sid);
        $config     = $config_model->fetchUpdateCfg();

        if ($config) {
            if ($config['oc_expire_time'] > time()) {
                $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $config['oc_expire_time']);
                return array('code' => 0, 'open'=> $config['oc_open_time'], 'expire'=> $config['oc_expire_time'], 'msg' => trim($expire));
            } else {
                return array('code' => 1, 'msg' => "应用已于".date('Y-m-d H:i:s', $config['oc_expire_time'])."到期, 请及时续费! ");
            }
        }
        return array('code' => 2, 'msg' => "应用未开通。");
    }
    /*
     * 检查店铺是否能开通微信红包功能
     */
    public static function checkShopRedpackOpen($sid) {
        $config_model   = new App_Model_Redpack_MysqlCfgStorage($sid);
        $config     = $config_model->findShopCfg();

        if ($config) {
            if ($config['rc_expire_time'] > time()) {
                $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $config['rc_expire_time']);
                //只接受认证服务号开通
                $wxtype     = App_Helper_ShopWeixin::checkWeixinVerifyType($sid);
                if ($wxtype != App_Helper_ShopWeixin::WX_VERIFY_YRZFWH) {
                    return array('code' => -1, 'msg' => '非认证服务号, 无法开启此项功能'.$expire);
                }
                //只接受开通微信自有支付方式的开通
                if (!App_Helper_Trade::checkHasWxpay($sid)) {
                    return array('code' => -2, 'msg' => '请开通微信自有支付方式, 方可使用此项功能'.$expire);
                }
                //未上传证书的不能开通
                if (!App_Helper_Trade::checkHasUploadCert($sid)) {
                    return array('code' => -3, 'msg' => '请上传微信支付证书文件, 方可使用此项功能'.$expire);
                }
                return array('code' => 0, 'open'=> $config['rc_open_time'], 'expire'=> $config['rc_expire_time'], 'msg' => trim($expire));
            } else {
                return array('code' => 1, 'msg' => "应用已于".date('Y-m-d H:i:s', $config['rc_expire_time'])."到期, 请及时续费! ");
            }
        }
        return array('code' => 2, 'msg' => "应用未开通。");
    }
    /*
     * 检查店铺是否开启微分销功能
     */
    public static function checkShopThreeOpen($sid) {
        $config_model   = new App_Model_Three_MysqlCfgStorage($sid);
        $config     = $config_model->findShopCfg();

        if ($config) {
            if ($config['tc_expire_time'] > time()) {
                $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $config['tc_expire_time']);
                //只接受认证服务号开通
                $wxtype     = App_Helper_ShopWeixin::checkWeixinVerifyType($sid);
                if ($wxtype != App_Helper_ShopWeixin::WX_VERIFY_YRZFWH) {
                    return array('code' => -1, 'msg' => '非认证服务号, 无法开启此项功能'.$expire);
                }
                return array('code' => 0, 'open'=> $config['tc_open_time'], 'expire'=> $config['tc_expire_time'], 'msg' => trim($expire),'level' => $config['tc_level']);
            } else {
                return array('code' => 1, 'msg' => "应用已于".date('Y-m-d H:i:s', $config['tc_expire_time'])."到期, 请及时续费! ");
            }
        }
        return array('code' => 2, 'msg' => "应用未开通。");
    }
    /*
     * 检查店铺是否开启一元夺宝功能
     */
    public static function checkShopUnitaryOpen($sid) {
        $config_model   = new App_Model_Unitary_MysqlCfgStorage($sid);
        $config     = $config_model->findShopCfg();

        if ($config) {
            if ($config['uc_expire_time'] > time()) {
                $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $config['uc_expire_time']);
                return array('code' => 0, 'open'=> $config['uc_open_time'], 'expire'=> $config['uc_expire_time'], 'msg' => trim($expire));
            } else {
                return array('code' => 1, 'msg' => "应用已于".date('Y-m-d H:i:s', $config['uc_expire_time'])."到期, 请及时续费! ");
            }
        }
        return array('code' => 2, 'msg' => "应用未开通。");
    }
    /*
     * 检查店铺是否开启APP开店功能
     */
    public static function checkShopAppOpen($sid) {
        $config_model   = new App_Model_App_MysqlCfgStorage();
        $config     = $config_model->findRowBySid($sid);

        if ($config) {
            if ($config['ac_expire_time'] > time()) {
                $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $config['ac_expire_time']);
                return array('code' => 0, 'open'=> $config['ac_open_time'], 'expire'=> $config['ac_expire_time'], 'msg' => trim($expire));
            } else {
                return array('code' => 1, 'msg' => "应用已于".date('Y-m-d H:i:s', $config['ac_expire_time'])."到期, 请及时续费! ");
            }
        }
        return array('code' => 2, 'msg' => "应用未开通。");
    }
    /*
     * 检查店铺是否开启微砍价功能
     */
    public static function checkShopBargainOpen($sid) {
        $config_model   = new App_Model_Bargain_MysqlCfgStorage($sid);
        $config     = $config_model->findShopCfg();

        if ($config) {
            if ($config['bc_expire_time'] > time()) {
                $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $config['bc_expire_time']);
                return array('code' => 0, 'open'=> $config['bc_open_time'], 'expire'=> $config['bc_expire_time'], 'msg' => trim($expire));
            } else {
                return array('code' => 1, 'msg' => "应用已于".date('Y-m-d H:i:s', $config['bc_expire_time'])."到期, 请及时续费! ");
            }
        }
        return array('code' => 2, 'msg' => "应用未开通。");
    }
    /*
     * 检查店铺是否开启云片广告功能
     */
    public static function checkShopAdvertOpen($sid) {
        $config_model   = new App_Model_Advert_MysqlAdvertCfgStorage($sid);
        $config     = $config_model->fetchUpdateCfg();

        if ($config) {
            if ($config['ac_expire_time'] > time()) {
                $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $config['ac_expire_time']);
                return array('code' => 0, 'open'=> $config['ac_open_time'], 'expire'=> $config['ac_expire_time'], 'msg' => trim($expire));
            } else {
                return array('code' => 1, 'msg' => "应用已于".date('Y-m-d H:i:s', $config['ac_expire_time'])."到期, 请及时续费! ");
            }
        }
        return array('code' => 2, 'msg' => "应用未开通。");
    }
    /*
     * 检查店铺是否开启拼团购买功能
     */
    public static function checkGroupBuyOpen($sid) {
        $config_model   = new App_Model_Group_MysqlCfgStorage($sid);
        $config     = $config_model->getRowUpdata();

        if ($config) {
            if ($config['gc_expire_time'] > time()) {
                $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $config['gc_expire_time']);
                return array('code' => 0, 'open'=> $config['gc_open_time'], 'expire'=> $config['gc_expire_time'], 'msg' => trim($expire));
            } else {
                return array('code' => 1, 'msg' => "应用已于".date('Y-m-d H:i:s', $config['gc_expire_time'])."到期, 请及时续费! ");
            }
        }
        return array('code' => 2, 'msg' => "应用未开通。");
    }
    /*
     * 检查店铺是否开启限时抢购功能
     */
    public static function checkShopLimitOpen($sid) {
        $config_model   = new App_Model_Limit_MysqlLimitCfgStorage($sid);
        $config     = $config_model->fetchUpdateCfg();

        if ($config) {
            if ($config['lc_expire_time'] > time()) {
                $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $config['lc_expire_time']);
                return array('code' => 0, 'open'=> $config['lc_open_time'], 'expire'=> $config['lc_expire_time'], 'msg' => trim($expire));
            } else {
                return array('code' => 1, 'msg' => "应用已于".date('Y-m-d H:i:s', $config['lc_expire_time'])."到期, 请及时续费! ");
            }
        }
        return array('code' => 2, 'msg' => "应用未开通。");
    }
    /*
     * 检查店铺是否开启积分商城功能
     */
    public static function checkShopPointOpen($sid) {
        $config_model   = new App_Model_Point_MysqlPointCfgStorage($sid);
        $config     = $config_model->fetchUpdateCfg();

        if ($config) {
            if ($config['pc_expire_time'] > time()) {
                $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $config['pc_expire_time']);
                return array('code' => 0, 'open'=> $config['pc_open_time'], 'expire'=> $config['pc_expire_time'], 'msg' => trim($expire));
            } else {
                return array('code' => 1, 'msg' => "应用已于".date('Y-m-d H:i:s', $config['pc_expire_time'])."到期, 请及时续费! ");
            }
        }
        return array('code' => 2, 'msg' => "应用未开通。");
    }
    /*
     * 未店铺开启营销工具,或续费营销工具
     * @param int $sid
     * @param string $type
     * @param string $expire
     */
    public static function openShopFunc($sid, $type, $expire) {
        $expire = is_numeric($expire) ? intval($expire) : strtotime($expire);
        if ($expire < time()) {
            return;
        }

        switch ($type) {
            //微分销,三级分销功能
            case 'sjfx' :
                $config_model   = new App_Model_Redpack_MysqlCfgStorage($sid);
                $config     = $config_model->findShopCfg();
                if ($config) {
                    $updata = array(
                        'tc_expire_time'    => $expire,
                        'tc_update_time'    => time(),
                    );
                    $config_model->updateById($updata, $config['tc_id']);
                } else {
                    $indata = array(
                        'tc_s_id'       => $sid,
                        'tc_open_time'  => time(),
                        'tc_expire_time'=> $expire,
                        'tc_update_time'=> time(),
                    );
                    $config_model->insertValue($indata);
                }
                break;
            //微信红包,口令红包功能
            case 'wxhb' :
                $config_model   = new App_Model_Redpack_MysqlCfgStorage($sid);
                $config     = $config_model->findShopCfg();

                if ($config) {
                    $updata = array(
                        'rc_expire_time'    => $expire,
                        'rc_update_time'    => time(),
                    );
                    $config_model->updateById($updata, $config['rc_id']);
                } else {
                    $indata = array(
                        'rc_s_id'       => $sid,
                        'rc_open_time'  => time(),
                        'rc_expire_time'=> $expire,
                        'rc_update_time'=> time(),
                    );
                    $config_model->insertValue($indata);
                }
                break;
            //一元夺宝功能
            case 'yydb' :
                $config_model   = new App_Model_Unitary_MysqlCfgStorage($sid);
                $config     = $config_model->findShopCfg();

                if ($config) {
                    $updata = array(
                        'uc_expire_time'    => $expire,
                        'uc_update_time'    => time(),
                    );
                    $config_model->updateById($updata, $config['uc_id']);
                } else {
                    $indata = array(
                        'uc_s_id'       => $sid,
                        'uc_open_time'  => time(),
                        'uc_expire_time'=> $expire,
                        'uc_update_time'=> time(),
                    );
                    $config_model->insertValue($indata);
                }
                break;
            //微砍价功能
            case 'wkj'  :
                $config_model   = new App_Model_Bargain_MysqlCfgStorage($sid);
                $config     = $config_model->findShopCfg();

                if ($config) {
                    $updata = array(
                        'bc_expire_time'    => $expire,
                        'bc_update_time'    => time(),
                    );
                    $config_model->updateById($updata, $config['bc_id']);
                } else {
                    $indata = array(
                        'bc_s_id'       => $sid,
                        'bc_open_time'  => time(),
                        'bc_expire_time'=> $expire,
                        'bc_update_time'=> time(),
                    );
                    $config_model->insertValue($indata);
                }
                break;
            //微信热文广告
            case 'ggfb' :
                $config_model   = new App_Model_Advert_MysqlAdvertCfgStorage($sid);
                $config     = $config_model->fetchUpdateCfg();

                if ($config) {
                    $updata = array(
                        'ac_expire_time'    => $expire,
                        'ac_update_time'    => time(),
                    );
                    $config_model->updateById($updata, $config['ac_id']);
                } else {
                    $indata = array(
                        'ac_s_id'       => $sid,
                        'ac_open_time'  => time(),
                        'ac_expire_time'=> $expire,
                        'ac_update_time'=> time(),
                    );
                    $config_model->insertValue($indata);
                }
                break;
            // 拼团购
            case 'ptg' :
                $config_model   = new App_Model_Group_MysqlCfgStorage($sid);
                $config     = $config_model->findShopCfg();

                if ($config) {
                    $updata = array(
                        'gc_expire_time'    => $expire,
                        'gc_update_time'    => time(),
                    );
                    $config_model->updateById($updata, $config['gc_id']);
                } else {
                    $indata = array(
                        'gc_s_id'       => $sid,
                        'gc_open_time'  => time(),
                        'gc_expire_time'=> $expire,
                        'gc_update_time'=> time(),
                    );
                    $config_model->insertValue($indata);
                }
                break;
            // 限时抢购
            case 'xsqg' :
                $config_model   = new App_Model_Limit_MysqlLimitCfgStorage($sid);
                $config     = $config_model->fetchUpdateCfg();

                if ($config) {
                    $updata = array(
                        'lc_expire_time'    => $expire,
                        'lc_update_time'    => time(),
                    );
                    $config_model->updateById($updata, $config['lc_id']);
                } else {
                    $indata = array(
                        'lc_s_id'       => $sid,
                        'lc_open_time'  => time(),
                        'lc_expire_time'=> $expire,
                        'lc_update_time'=> time(),
                    );
                    $config_model->insertValue($indata);
                }
                break;
            //线下门店
            case 'xxmd' :
                $config_model   = new App_Model_Store_MysqlStoreCfgStorage($sid);
                $config     = $config_model->fetchUpdateCfg();

                if ($config) {
                    $updata = array(
                        'oc_expire_time'    => $expire,
                        'oc_update_time'    => time(),
                    );
                    $config_model->updateById($updata, $config['lc_id']);
                } else {
                    $indata = array(
                        'oc_s_id'       => $sid,
                        'oc_open_time'  => time(),
                        'oc_expire_time'=> $expire,
                        'oc_update_time'=> time(),
                    );
                    $config_model->insertValue($indata);
                }
                break;
            //小程序
            case 'applet' :
                $config_model   = new App_Model_Applet_MysqlCfgStorage($sid);
                $config     = $config_model->findShopCfg();

                if ($config) {
                    $updata = array(
                        'ac_expire_time'    => $expire,
                        'ac_update_time'    => time(),
                    );
                    $config_model->updateById($updata, $config['ac_id']);
                } else {
                    $indata = array(
                        'ac_s_id'       => $sid,
                        'ac_open_time'  => time(),
                        'ac_expire_time'=> $expire,
                        'ac_update_time'=> time(),
                    );
                    $config_model->insertValue($indata);
                }
                break;
        }
    }
}