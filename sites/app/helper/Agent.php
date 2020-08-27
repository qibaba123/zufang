<?php

class App_Helper_Agent {
    //关于抖音小程序LOGO和技术支持字样
    //免费版商城：底部的LOGO写死，任何级别代理都不能改，vip和OEM的也只能添加下面技术支持的字样。
    //其他版本：
    //免费代理：默认只有天店通LOGO，不能添加技术支持，
    //高级代理：默认只有天店通LOGO，不能添加技术支持，
    //VIP代理：默认只有天店通LOGO，可添加自己的技术支持，
    //OEM贴牌：可修改LOGO,可添加自己的技术支持
    public static $level_desc = [
        1 => '免费代理', //基础商城100元
        2 => '高级代理',
        3 => 'VIP代理',
        4 => 'OEM贴牌',
        5 => '免费代理' //基础商城300元
    ];

    /*
     * 获得店铺的对应代理商 再获得代理商等级
     */
    public static function checkShopAgentLevel($sid){
        $level = 1;
        $open_storage = new App_Model_Agent_MysqlOpenStorage(0);
        $agent = $open_storage->getAgentBySid($sid);
        if($agent){
            $level = self::checkAgentLevel($agent);
        }
        return $level;
    }


    /*
    * 获得代理商等级
    */
    public static function checkAgentLevel($agent){
        if($agent){
            if($agent['aa_open_oem'] == 1){
                $level = 4;
            } else if($agent['aa_rebate'] == 2){
                $level = 2;
            }elseif ($agent['aa_rebate'] == 1.5 && $agent['aa_open_oem'] == 0){
                $level = 3;
            }elseif ($agent['aa_rebate'] == 1.5 && $agent['aa_open_oem'] == 1){
                $level = 4;
            }elseif ($agent['aa_rebate'] == 3){//免费代理三折版
                $level = 5;
            }else{
                $level = 1;
            }
        }
        return $level;
    }


}