<?php

/**
 * Created by PhpStorm.
 * 处理Table状态栏链接菜单
 * User: zhaoweizhen
 * Date: 16/7/7
 * Time: 下午12:35
 */
class App_Helper_TableMenu{
    /**
     * @param $type
     * @param array $param
     * @return array
     * 根据类型获得table状态链接,@param传递值
     */
    public function showTableLink($type,$param=array()){
        $extra = '';
        if(!empty($param) && is_array($param)){
            foreach($param as $key=>$val){
                $extra .= '&'.$key.'='.$val;
            }
        }
        $link = array();
        switch($type){
            case 'member':
                $link = array(
                    array(
                        'href'  => '/manage/member/list?type=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部会员'
                    ),
                    array(
                        'href'  => '/manage/member/list?type=out'.$extra,
                        'key'   => 'out',
                        'label' => '取消关注'
                    ),
                    array(
                        'href'  => '/manage/member/list?type=slient'.$extra,
                        'key'   => 'slient',
                        'label' => '未关注'
                    ),
                );
                break;
            case 'memberNew':
                $link = array(
                    array(
                        'href'  => '/wxapp/member/list?type=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部会员'
                    ),
                    array(
                        'href'  => '/wxapp/member/list?type=out'.$extra,
                        'key'   => 'out',
                        'label' => '取消关注'
                    ),
                    array(
                        'href'  => '/wxapp/member/list?type=slient'.$extra,
                        'key'   => 'slient',
                        'label' => '未关注'
                    ),
                );
                break;
            case 'threeMember':
                $link = array(
                    array(
                        'href'  => '/manage/three/member?type=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部会员'
                    ),
                    array(
                        'href'  => '/manage/three/member?type=out'.$extra,
                        'key'   => 'out',
                        'label' => '取消关注'
                    ),
                    array(
                        'href'  => '/manage/three/member?type=highest'.$extra,
                        'key'   => 'highest',
                        'label' => '最高级'
                    ),
                    array(
                        'href'  => '/manage/three/member?type=refer'.$extra,
                        'key'   => 'refer',
                        'label' => '官方推荐'
                    ),
                    array(
                        'href'  => '/manage/three/member?type=slient'.$extra,
                        'key'   => 'slient',
                        'label' => '未关注'
                    ),
                );
                break;
            case 'wxappThreeMember':
                $link = array(
//                    array(
//                        'href'  => '/wxapp/three/member?type=all'.$extra,
//                        'key'   => 'all',
//                        'label' => '分销会员'
//                    ),
                    array(
                        'href'  => '/wxapp/three/member?type=highest'.$extra,
                        'key'   => 'highest',
                        'label' => '最高级'
                    ),
//                    array(
//                        'href'  => '/wxapp/three/member?type=normal'.$extra,
//                        'key'   => 'normal',
//                        'label' => '非分销会员'
//                    ),
//                    array(
//                        'href'  => '/distrib/three/member?type=refer'.$extra,
//                        'key'   => 'refer',
//                        'label' => '官方推荐'
//                    ),
                );
                break;
            case 'bargain':
                $link = array(
                    array(
                        'href'  => '/manage/bargain/list?type=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/manage/bargain/list?type=ready'.$extra,
                        'key'   => 'ready',
                        'label' => '准备中'
                    ),
                    array(
                        'href'  => '/manage/bargain/list?type=underway'.$extra,
                        'key'   => 'underway',
                        'label' => '进行中'
                    ),
                    array(
                        'href'  => '/manage/bargain/list?type=finish'.$extra,
                        'key'   => 'finish',
                        'label' => '已经结束'
                    ),
                );
                break;
            case 'order' :
                $link = array(
                    array(
                        'href'  => '/manage/order/index?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/manage/order/index?status=nopay'.$extra,
                        'key'   => 'nopay',
                        'label' => '待付款'
                    ),
                    array(
                        'href'  => '/manage/order/index?status=pay'.$extra,
                        'key'   => 'pay',
                        'label' => '已付款'
                    ),
                    array(
                        'href'  => '/manage/order/index?status=complete'.$extra,
                        'key'   => 'complete',
                        'label' => '已完成'
                    ),
                    array(
                        'href'  => '/manage/order/index?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '已退款'
                    ),
                    array(
                        'href'  => '/manage/order/index?status=close'.$extra,
                        'key'   => 'close',
                        'label' => '已关闭'
                    ),
                );
                break;
            case 'threeOrder' :
                $link = array(
                    array(
                        'href'  => '/manage/three/order?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/manage/three/order?status=nopay'.$extra,
                        'key'   => 'nopay',
                        'label' => '待付款'
                    ),
                    array(
                        'href'  => '/manage/three/order?status=pay'.$extra,
                        'key'   => 'pay',
                        'label' => '已付款'
                    ),
                    array(
                        'href'  => '/manage/three/order?status=complete'.$extra,
                        'key'   => 'complete',
                        'label' => '已完成'
                    ),
                    array(
                        'href'  => '/manage/three/order?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '已退款'
                    ),
                    array(
                        'href'  => '/manage/three/order?status=close'.$extra,
                        'key'   => 'close',
                        'label' => '已关闭'
                    ),
                );
                break;
            case 'distribThreeOrder' :
                $link = array(
                    array(
                        'href'  => '/distrib/three/order?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/distrib/three/order?status=nopay'.$extra,
                        'key'   => 'nopay',
                        'label' => '待付款'
                    ),
                    array(
                        'href'  => '/distrib/three/order?status=pay'.$extra,
                        'key'   => 'pay',
                        'label' => '已付款'
                    ),
                    array(
                        'href'  => '/distrib/three/order?status=complete'.$extra,
                        'key'   => 'complete',
                        'label' => '已完成'
                    ),
                    array(
                        'href'  => '/distrib/three/order?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '已退款'
                    ),
                    array(
                        'href'  => '/distrib/three/order?status=close'.$extra,
                        'key'   => 'close',
                        'label' => '已关闭'
                    ),
                );
                break;
            case 'wxappThreeOrder' :
                $link = array(
                    array(
                        'href'  => '/wxapp/three/order?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/three/order?status=nopay'.$extra,
                        'key'   => 'nopay',
                        'label' => '待付款'
                    ),
                    array(
                        'href'  => '/wxapp/three/order?status=pay'.$extra,
                        'key'   => 'pay',
                        'label' => '已付款'
                    ),
                    array(
                        'href'  => '/wxapp/three/order?status=complete'.$extra,
                        'key'   => 'complete',
                        'label' => '已完成'
                    ),
                    array(
                        'href'  => '/wxapp/three/order?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '已退款'
                    ),
                    array(
                        'href'  => '/wxapp/three/order?status=close'.$extra,
                        'key'   => 'close',
                        'label' => '已关闭'
                    ),
                );
                break;
            case 'goodsratioOrder' :
                $link = array(
                    array(
                        'href'  => '/wxapp/goodsratio/order?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/goodsratio/order?status=nopay'.$extra,
                        'key'   => 'nopay',
                        'label' => '待付款'
                    ),
                    array(
                        'href'  => '/wxapp/goodsratio/order?status=pay'.$extra,
                        'key'   => 'pay',
                        'label' => '已付款'
                    ),
                    array(
                        'href'  => '/wxapp/goodsratio/order?status=complete'.$extra,
                        'key'   => 'complete',
                        'label' => '已完成'
                    ),
                    array(
                        'href'  => '/wxapp/goodsratio/order?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '已退款'
                    ),
                    array(
                        'href'  => '/wxapp/goodsratio/order?status=close'.$extra,
                        'key'   => 'close',
                        'label' => '已关闭'
                    ),
                );
                break;
            case 'goods' :
                $link = array(
                    array(
                        'href'  => '/manage/goods/index?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '出售中'
                    ),
                    array(
                        'href'  => '/manage/goods/index?status=sellout'.$extra,
                        'key'   => 'sellout',
                        'label' => '已售罄'
                    ),
                    array(
                        'href'  => '/manage/goods/index?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                );
                break;
            case 'goodsNew' :
                $link = array(
                    array(
                        'href'  => '/wxapp/goods/index?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '出售中'
                    ),
                    array(
                        'href'  => '/wxapp/goods/index?status=sellout'.$extra,
                        'key'   => 'sellout',
                        'label' => '已售罄'
                    ),
                    array(
                        'href'  => '/wxapp/goods/index?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                );
                break;
            case 'sequenceGoods' :
                $link = array(
                    array(
                        'href'  => '/wxapp/goods/index?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '出售中'
                    ),
                    array(
                        'href'  => '/wxapp/goods/index?status=sellout'.$extra,
                        'key'   => 'sellout',
                        'label' => '已售罄'
                    ),
                    array(
                        'href'  => '/wxapp/goods/index?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                    array(
                        'href'  => '/wxapp/goods/index?status=presell'.$extra,
                        'key'   => 'presell',
                        'label' => '预售'
                    ),
                    array(
                        'href'  => '/wxapp/goods/index?status=recommend'.$extra,
                        'key'   => 'recommend',
                        'label' => '首页推荐'
                    ),
                    array(
                        'href'  => '/wxapp/goods/index?status=supplier_presell'.$extra,
                        'key'   => 'supplier_presell',
                        'label' => '供应商未上架商品'
                    ),
                    array(
                        'href'  => '/wxapp/goods/index?status=verify_wait'.$extra,
                        'key'   => 'verify_wait',
                        'label' => '待审核'
                    ),
                    array(
                        'href'  => '/wxapp/goods/index?status=verify_refuse'.$extra,
                        'key'   => 'verify_refuse',
                        'label' => '未过审'
                    ),
                );
                break;
            case 'sequenceGoodsVerify' :
                $link = array(
                    array(
                        'href'  => '/wxapp/seqregion/goodsVerify?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '出售中'
                    ),
                    array(
                        'href'  => '/wxapp/seqregion/goodsVerify?status=sellout'.$extra,
                        'key'   => 'sellout',
                        'label' => '已售罄'
                    ),
                    array(
                        'href'  => '/wxapp/seqregion/goodsVerify?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                    array(
                        'href'  => '/wxapp/seqregion/goodsVerify?status=presell'.$extra,
                        'key'   => 'presell',
                        'label' => '预售'
                    ),
                    array(
                        'href'  => '/wxapp/seqregion/goodsVerify?status=recommend'.$extra,
                        'key'   => 'recommend',
                        'label' => '首页推荐'
                    ),
//                    array(
//                        'href'  => '/wxapp/seqregion/goodsVerify?status=verify'.$extra,
//                        'key'   => 'verify',
//                        'label' => '未过审'
//                    ),
                    array(
                        'href'  => '/wxapp/seqregion/goodsVerify?status=verify_wait'.$extra,
                        'key'   => 'verify_wait',
                        'label' => '待审核'
                    ),
                    array(
                        'href'  => '/wxapp/seqregion/goodsVerify?status=verify_refuse'.$extra,
                        'key'   => 'verify_refuse',
                        'label' => '已拒绝'
                    ),
                );
                break;
            case 'trainGoods' :
                $link = array(
                    array(
                        'href'  => '/wxapp/group/goodsList?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '拼团中'
                    ),
                    array(
                        'href'  => '/wxapp/group/goodsList?status=sellout'.$extra,
                        'key'   => 'sellout',
                        'label' => '已满额'
                    ),
                    array(
                        'href'  => '/wxapp/group/goodsList?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                );
                break;
            case 'distribGoods' :
                $link = array(
                    array(
                        'href'  => '/distrib/goods/index?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '出售中'
                    ),
                    array(
                        'href'  => '/distrib/goods/index?status=sellout'.$extra,
                        'key'   => 'sellout',
                        'label' => '已售罄'
                    ),
                    array(
                        'href'  => '/distrib/goods/index?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                );
                break;
            case 'settled' :
                $link = array(
                    array(
                        'href'  => '/manage/shop/settled?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/manage/shop/settled?status=doing'.$extra,
                        'key'   => 'doing',
                        'label' => '进行中'
                    ),
                    array(
                        'href'  => '/manage/shop/settled?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '退款'
                    ),
                    array(
                        'href'  => '/manage/shop/settled?status=success'.$extra,
                        'key'   => 'success',
                        'label' => '成功'
                    ),
//                    array(
//                        'href'  => '/manage/shop/settled?status=failed'.$extra,
//                        'key'   => 'failed',
//                        'label' => '失败'
//                    ),
                );
                break;
            case 'shop_withdraw' :
                $link = array(
                    array(
                        'href'  => '/manage/shop/withdraw?audit=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/manage/shop/withdraw?audit=doing'.$extra,
                        'key'   => 'doing',
                        'label' => '审核中'
                    ),
                    array(
                        'href'  => '/manage/shop/withdraw?audit=success'.$extra,
                        'key'   => 'success',
                        'label' => '成功'
                    ),
                    array(
                        'href'  => '/manage/shop/withdraw?audit=refuse'.$extra,
                        'key'   => 'refuse',
                        'label' => '拒绝'
                    ),
                );
                break;
            case 'day_book' :
                $link = array(
                    array(
                        'href'  => '/manage/three/dayBook?type=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/manage/three/dayBook?type=cash'.$extra,
                        'key'   => 'cash',
                        'label' => '返现收入'
                    ),
                    array(
                        'href'  => '/manage/three/dayBook?type=share'.$extra,
                        'key'   => 'share',
                        'label' => '分享收入'
                    ),
                    array(
                        'href'  => '/manage/three/dayBook?type=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '退款收回'
                    ),
                    array(
                        'href'  => '/manage/three/dayBook?type=withdraw'.$extra,
                        'key'   => 'withdraw',
                        'label' => '提现支出'
                    ),
                );
                break;
            case 'distrib_day_book' :
                $link = array(
                    array(
                        'href'  => '/wxapp/three/dayBook?type=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/three/dayBook?type=cash'.$extra,
                        'key'   => 'cash',
                        'label' => '返现收入'
                    ),
                    array(
                        'href'  => '/wxapp/three/dayBook?type=share'.$extra,
                        'key'   => 'share',
                        'label' => '分享收入'
                    ),
                    array(
                        'href'  => '/wxapp/three/dayBook?type=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '退款收回'
                    ),
                    array(
                        'href'  => '/wxapp/three/dayBook?type=withdraw'.$extra,
                        'key'   => 'withdraw',
                        'label' => '提现支出'
                    ),
                );
                break;
            case 'copartner_day_book' :
                $link = array(
                    array(
                        'href'  => '/wxapp/copartner/dayBook?type=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/copartner/dayBook?type=cash'.$extra,
                        'key'   => 'cash',
                        'label' => '返现收入'
                    ),
                    array(
                        'href'  => '/wxapp/copartner/dayBook?type=share'.$extra,
                        'key'   => 'share',
                        'label' => '分享收入'
                    ),
                    array(
                        'href'  => '/wxapp/copartner/dayBook?type=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '退款收回'
                    ),
                    array(
                        'href'  => '/wxapp/copartner/dayBook?type=withdraw'.$extra,
                        'key'   => 'withdraw',
                        'label' => '提现支出'
                    ),
                );
                break;
        }
        return $link;
    }
}