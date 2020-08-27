<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/25
 * Time: 上午11:00
 */
class App_Helper_ReplaceMsg {

    /*
     * 店铺数据，字段名参考pre_shop
     */

    public function __construct(){
    }


    /**
     * 替换餐饮叫号模板消息
     */
    public function replaceMealQueueTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        $tplval  = array(
            $infor['shopName'],$infor['name'],$infor['number'],$infor['before'],$infor['total'],$infor['status'],$infor['time']
        );
        $tplreg   = $cfg[39];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 替换购买会员卡模板消息
     */
    public function replaceMemberCardTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        $tplval  = array(
            $infor['cardName'],$infor['cardNumber'],$infor['expireTime'],$infor['cardRights'],$infor['cardNotice']
        );
        $tplreg   = $cfg[40];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 职位推送变量替换
     */
    public function replacePositionTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        $tplval = array(
            $infor['title'],$infor['cate'],$infor['company'],$infor['salary'],$infor['desc'],$infor['recommendAward'],$infor['entryAward'],$infor['recommendedAward']
        );
        $tplreg   = $cfg[31];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 店铺评论模板替换
     */
    public function replaceShopCommentTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['shopName'],$infor['commentator'],$infor['commentScore'],$infor['commentContent'],$infor['commentTime']
        );
        $tplreg   = $cfg[50];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 电话本入驻审核模板替换
     */
    public function replaceMobileAuditTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['shopName'],$infor['auditResult'],$infor['applyTime'],$infor['auditTime'],$infor['auditRemark']
        );
        $tplreg   = $cfg[51];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

    /**
     * 店铺认领审核模板替换
     */
    public function replaceShopClaimTpl($infor, $tpl){
        $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg    = plum_parse_config('message', 'tmplmsg');
        foreach($infor as $key=>$val){
            $infor[$key] = str_replace("\n", "\\n",$val);
        }
        $tplval = array(
            $infor['shopName'],$infor['auditResult'],$infor['applyTime'],$infor['auditTime'],$infor['auditRemark']
        );
        $tplreg   = $cfg[52];

        return array(
            preg_replace($tplreg, $tplval, $tpl)
        );
    }

}