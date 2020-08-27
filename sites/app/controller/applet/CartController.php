<?php

/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/5/7
 * Time: 下午5:05
 */
class App_Controller_Applet_CartController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * 商品加入购物车
     */
    public function addCartAction()
    {
        $gid  = $this->request->getIntParam('gid');    // 商品ID
        $gfid = $this->request->getIntParam('gfid');   // 商品规格ID
        $num  = $this->request->getIntParam('num');    // 商品数量，允许传0，num=0表示删除该条购物车记录
        $isAdd  = $this->request->getIntParam('add');   // 加入购物车时传1
        $esId  = $this->request->getIntParam('esId',0);  //入住店铺id
        $checkStock = $this->request->getIntParam('checkStock',0);//通过分类列表直接加入购物车
        $independent = $this->request->getIntParam('independent',0);//是否为独立商城商品
        if(!$esId){
            $esId = $this->request->getIntParam('esid',0);
        }
        $reduce = 0;
        if ($gid) {
            // 查询当前商品在购物车里面已有的数量（改不动了）
            // zhangzc
            // 2019-11-28
            if($this->applet_cfg['ac_type'] == 21){
                $cart_storage = new App_Model_Shop_MysqlShopCartStorage($this->sid);
                $cart_info=$cart_storage->getCartSum($this->member['m_id'], 0,-1,$gid);
                $now_cart_num=$cart_info?intval($cart_info['total']):0;

                // 查找当前商品限购的情况
                $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
                $goods = $goods_model->findGoodsBySidGid($this->sid,$gid);
                $trade_order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                // 存在当日限购
                
                if($isAdd){
                    $into_card_num = $num + $now_cart_num;
                }else{
                    if($gfid){
                        $cart_info_gf   = $cart_storage->getCartSum($this->member['m_id'], 0,-1,$gid,$gfid);
                        $into_card_num  = ($now_cart_num-$cart_info_gf['total']) + $num;
                    }else{
                        $into_card_num = $num;
                    }
                }
                if($goods['g_day_limit']){
                     // 今天的时间戳
                    $today_start=strtotime(date('Ymd',time()));
                    $today_end=$today_start + 24 * 60 * 60;
                    $limit_today=$trade_order_model->getUserBuySum($goods['g_id'],$this->member['m_id'],$today_start,$today_end);
                    $goods_limit_today=intval($limit_today['total']);
                    // 购物车里面已经超过单日限购
                    if($now_cart_num > $goods['g_day_limit'] && $isAdd){
                        $this->outputError('超出商品今日限购数量.');
                    }

                    // 还能加入到购物车的数量

                    if($into_card_num > ($goods['g_day_limit']-$goods_limit_today)){
                        $this->outputError('超出商品今日限购数量');
                    }
                }
              
                // 存在总限购
                if($goods['g_limit']){
                    $limit_all=$trade_order_model->getUserBuySum($goods['g_id'],$this->member['m_id']);
                    $goods_limit_all=intval($limit_all['total']);
                   
                    // 购物车里面已经超过总限购
                    if($now_cart_num >= $goods['g_limit'] && $isAdd){
                        $this->outputError('超出商品总限购数量.');
                    }
                    // 还能加入到购物车里面的数量
                    if($into_card_num  > ($goods['g_limit'] - $goods_limit_all)){
                        $this->outputError('超出商品总限购数量');
                    }
                }
            }


            


            $cart_storage = new App_Model_Shop_MysqlShopCartStorage($this->sid);
            // 查询该商品是否已经加入购物车
            $row = $cart_storage->getGoodsInfo($this->member['m_id'], $gid, $gfid,null,$esId);
            // 如果数量大于0
            if ($num > 0) {
                //验证库存数量
                if($checkStock){
                    $checkNum = $isAdd && $row ? $row['sc_num'] + $num : $num;
                    if($gfid){
                        //有规格，以规格库存为准
                        $format_model = new App_Model_Goods_MysqlFormatStorage($this->sid);
                        $format = $format_model->getRowById($gfid);
                        if($checkNum > $format['gf_stock']){
                            $this->outputError('库存不足');
                        }
                    }else{
                        //无规格，以商品库存为准
                        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
                        $goods = $goods_model->getRowById($gid);
                        if($checkNum > $goods['g_stock']){
                            $this->outputError('库存不足');
                        }
                    }
                }
                if($this->applet_cfg['ac_type'] == 32){
                    //验证预售
                    $redis_goods = new App_Model_Goods_RedisGoodsStorage($this->sid);
                    $ttl = $redis_goods->getGoodsSaleUpTtl($gid);
                    if(!isset($goods) || !$goods) {
                        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
                        $goods = $goods_model->getRowById($gid);
                    }
                    if($goods['g_is_sale'] == 3 || $ttl > 0){
                        $this->outputError('该商品还未开始抢购，不能加入购物车');
                    }
                }


                if ($row) {
                    if($row['sc_num'] > $num && !$isAdd){
                        $reduce = 1;
                    }
                    if($isAdd){
                        $data = array('sc_num' => $num+$row['sc_num']);
                    }else{
                        $data = array('sc_num' => $num);
                    }
                    $ret  = $cart_storage->getGoodsInfo($this->member['m_id'], $gid, $gfid, $data,$esId);
                } else {
                    $data = array(
                        'sc_s_id'     => $this->sid,
                        'sc_es_id'    => $esId,
                        'sc_m_id'     => $this->member['m_id'],
                        'sc_g_id'     => $gid,
                        'sc_gf_id'    => $gfid,
                        'sc_num'      => $num,
                        'sc_add_time' => time(),
                        'sc_independent_mall' => $independent
                    );
                    $ret  = $cart_storage->insertValue($data);
                    //同步添加购物单
                    //后台执行，将商品加入购入单
                    plum_open_backend('index', 'addShopping', array('sid' => $this->sid, 'mid' => $this->member['m_id'],'gid' => $gid, 'gfid' => $gfid, 'esid' => $esId));
                }
            } else { // 数量小于或等于0则直接删除该条记录
                if ($row) {
                    $ret = $cart_storage->deleteById($row['sc_id']);
                    $reduce = 1;
                } else {
                    $ret = 0;
                }
            }
            if ($ret) {
               // $cartNum = $cart_storage->getCartSum($this->member['m_id'],0,$esId);
                $cartNum = $this->_get_cart_sum($independent,$esId);
                //查询当前要加进去的商品的购物车数量
               
                $info['data'] = array(
                    'result'        => true,
                    'msg'           => $reduce ? '已移除购物车' : '已加入购物车',
                    'cartNum'       => $cartNum ? $cartNum : 0,
                );
                if($this->wxapp_cfg['ac_type']==21){
                    $info['data']['cartGoods'] = $into_card_num;
                }
                $this->outputSuccess($info);
            } else {
                $this->outputError('加入购物车失败');
            }
        } else {
            $this->outputError('请选择加入购物车的商品及数量');
        }
    }

    /**
     * 购物车商品列表
     */
    public function cartGoodsListAction()
    {
        $page         = $this->request->getIntParam('page');
        $all          = $this->request->getIntParam('all',0);
        $esid         = $this->request->getIntParam('esId',0);
        $independent = $this->request->getIntParam('independent',0);//是否为独立商城商品
        if(!$esid){
            $esid = $this->request->getIntParam('esid',0);
        }
        if($page>0){
            $this->outputError('数据加载完毕');
        }
        $index        = $page * $this->count;
        $where        = array();
        $where[]      = array('name' => 'sc_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[]      = array('name' => 'sc_es_id', 'oper' => '=', 'value' => $esid);
        $where[]      = array('name' => 'sc_independent_mall', 'oper' => '=', 'value' => $independent);

        $sort         = array('sc_add_time' => 'DESC');
        $cart_storage = new App_Model_Shop_MysqlShopCartStorage($this->sid);
        //$list         = $cart_storage->getGoodsFormat($where, $index, $this->count, $sort,$all);
        $list         = $cart_storage->getGoodsFormat($where, 0, 0, $sort,$all);
        //查看是否是新用户
        $new_member = App_Helper_Sequence::checkNewMember($this->member['m_id'],$this->sid);
        $cart_data = [];
        $cart_data_down = [];
        if ($list) {
            $info = [];
            $info['data'] = [];
            foreach ($list as $val) {
                $stock = $val['g_stock'];
                $limit_goods_model  = new App_Model_Limit_MysqlLimitGoodsStorage($this->sid);
                $limit = $limit_goods_model->getActingByGid($val['g_id'],'');
                //如果存在秒杀并且限购，检查之前购买记录
                if ($limit && $limit['lg_limit']) {
                    $record_model   = new App_Model_Limit_MysqlLimitRecordStorage($this->sid);
                    $had_buy    = $record_model->countBuyNum($this->member['m_id'], $limit['lg_actid'], $val['g_id']);
                    $had_buy    = intval($had_buy)+$val['sc_num'];
                    if ($had_buy > intval($limit['lg_limit'])) {
                        $limit = '';
                    }
                }
                //如果是秒杀且存在规格
                if($val['gf_id'] > 0 && $limit){
                    $limit_goods_format = new App_Model_Limit_MysqlLimitGoodsFormatStorage();
                    $limitFormat = $limit_goods_format->getRowByActIdGfid($limit['la_id'], $val['gf_id']);
                    if($limitFormat){
                        if($limitFormat['lgf_stock'] > 0){
                            $limit['lg_stock'] = $limitFormat['lgf_stock'];
                        }
                        $limit['lg_yh_price'] = $limitFormat['lgf_yh_price'];
                    }
                }
                //如果设置了秒杀数量，替换为设置值
                $stock = isset($limit['lg_stock']) && $limit['lg_stock'] > 0 ? $limit['lg_stock'] : ($val['sc_gf_id'] ? $val['gf_stock'] : $val['g_stock']);
                $uid    = plum_app_user_islogin();
                if(isset($val['gf_price']) && $val['gf_price'] > 0){
                    $price = App_Helper_Trade::getGoodsVipPirce($val['gf_price'], $this->sid, $val['g_id'], $val['gf_id'],$uid);
                }else{
                    $price = App_Helper_Trade::getGoodsVipPirce($val['g_price'], $this->sid, $val['g_id'], 0,$uid);
                }


                $data = array(
                    'id'         => $val['sc_id'],
                    'gid'        => $val['g_id'],
                    'gfid'       => isset($val['gf_id']) && $val['gf_id'] > 0 ? $val['gf_id'] : 0,
                    'name'       => $val['g_name'],
                    'cover'      => isset($val['gf_img']) && $val['gf_img'] ? $this->dealImagePath($val['gf_img']) : $this->dealImagePath($val['g_cover']),
                    'price'      => $limit ? $limit['lg_yh_price']:$price,
                    'isLimit'    => $limit ? 1:0,
                    'limitPrice' => isset($limit['lg_yh_price']) ? $limit['lg_yh_price'] : $val['g_price'],
                    'limitNum'   => isset($limit['lg_limit']) && $limit['lg_limit'] > 0? $limit['lg_limit'] : ($val['g_limit']>0 ? $val['g_limit'] : $stock),
                    'format'     => isset($val['gf_name']) ? $val['gf_name'].' '.$val['gf_name2'].' '.$val['gf_name3'] : '',
                    'num'        => $val['sc_num'],
                    'stock'      => intval($stock),   // 总库存量
                    'checked'    => false,
                    'purchase'     => $val['g_limit'],
                    'isSale'       => $val['g_is_sale'], // 是否正常售卖 1、正常售卖、2下架、3、预售
                    'purchaseNote' => '每人限购'.$val['g_limit'].'件',
                    'canBuy'     => $val['g_is_sale'] == 1 ? 1 : 0,
                    'smallNum'   => (integer)$val['g_small_num'],     //起购数量
                    'newMember' => $val['g_has_window'] == 2 ? $new_member : 0,
                    'newMemberStock' => intval($val['g_hotel_stock']),
                    'newMemberPrice' => floatval($val['g_date_price']),
                    'newMemberFormatPrice' => floatval($val['gf_newmember_price'])
                );


                if($val['g_is_sale'] == 2){
//                    $cart_data_down[] = $data;
                    $info['dataDown'][] = $data;
                }else{
                    $info['data'][] = $data;
//                    $cart_data[] = $data;
                }
            }

//            $info['data'] = array_merge($cart_data,$cart_data_down);

            if(in_array($this->applet_cfg['ac_type'],[32,36])){
                // 购物车商品库存进入redis里的设置
                // zhangzc
                // 2019-08-12
                $trade_redis_model   = new App_Model_Trade_RedisTradeStorage($this->sid); 
                // 查看有无规格 无规格设置商品本来的库存
                if(!empty($info['data'])){
                    foreach ($info['data'] as $key => $val) {
                        $trade_redis_model->sequenceSetGoodsStock($val['gid'],$val['gfid'],$val['stock']);
                    }
                }
            }
            $this->outputSuccess($info);
        } else {
            $this->outputError('数据加载完毕');
        }
    }

    /**
     * 删除购物车商品（或者清空购物车）
     */
    public function deleteCartAction()
    {
        $ids     = $this->request->getStrParam('ids');
        $esId    = $this->request->getIntParam('esId',0);
        $independent = $this->request->getIntParam('independent',0);//是否为独立商城商品


        $where   = array();
        $where[] = array('name' => 'sc_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 'sc_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'sc_independent_mall', 'oper' => '=', 'value' => $independent);
        if($esId && $this->applet_cfg['ac_type'] == 4){
            //餐饮版 只清除清除当前店铺或平台的购物车
            $where[] = array('name' => 'sc_es_id', 'oper' => '=', 'value' => $esId);
        }

        if ($ids) {
            $ids     = explode(',', $ids);
            $where[] = array('name' => 'sc_id', 'oper' => 'in', 'value' => $ids);
        }
        $cart_storage = new App_Model_Shop_MysqlShopCartStorage($this->sid);
        $cartList = $cart_storage->getList($where, 0, 0);
        $delShopping = array();
        foreach ($cartList as $value){
            $delShopping[] = array(
                'gid'  => $value['sc_g_id'],
                'gfId' => $value['sc_gf_id']
            );
        }
        //同步删除购物单
        //后台执行，将商品删除购入单
        plum_open_backend('index', 'delShopping', array('sid' => $this->sid, 'mid' => $this->member['m_id'], 'delShopping' => rawurlencode(json_encode($delShopping))));

        $ret          = $cart_storage->deleteValue($where);
        if ($ret) {
            $cartNum = $cart_storage->getCartSum($this->member['m_id']);
            $info['data'] = array(
                'result' => true,
                'msg'    => '删除购物车商品成功',
                'cartNum' => $cartNum ? $cartNum : 0,
            );
            $this->outputSuccess($info);
        } else {
            $this->outputError('删除购物车商品失败');
        }
    }

    /**
     * 微点餐购物车商品列表，全部取出不再分页(微点餐使用)
     */
    public function cartMealListAction()
    {

        $esId = $this->request->getIntParam('esId',0);
        $where         = array();
        $where[]       = array('name' => 'sc_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[]       = array('name' => 'sc_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]       = array('name' => 'sc_es_id', 'oper' => '=', 'value' => $esId);
        $where[]       = array('name' => 'sc_independent_mall', 'oper' => '=', 'value' => 0);
        $sort          = array('sc_add_time' => 'DESC');
        $cart_storage  = new App_Model_Shop_MysqlShopCartStorage($this->sid);
        $list          = $cart_storage->getMealGoodsFormat($esId,$where, 0, 0, $sort);
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        // 获取商品所属分类信息
        $goods_category = $goods_storage->fetchShopGoodsCategory();
        if ($list) {
            $info = array();
            foreach ($list as $val) {
                $info['data'][] = array(
                    'id'         => $val['sc_id'],
                    'flId'       => $goods_category[$val['g_id']],
                    'mealId'     => $val['g_id'],
                    'mealName'   => $val['g_name'],
                    'boxPrice'   => $val['g_unified_fee'],
                    'formatId'   => isset($val['gf_id']) && $val['gf_id'] > 0 ? $val['gf_id'] : 0,
                    'formatName' => isset($val['gf_name']) ? $val['gf_name'] : '',
                    'mealPrice'  => isset($val['gf_price']) && $val['gf_price'] > 0 ? $val['gf_price'] : $val['g_price'],
                    'mealNum'    => $val['sc_num']
                );
            }
            $this->outputSuccess($info);
        } else {
            $this->outputError('数据加载完毕');
        }
    }

    public function getCartSumAction(){
        $independent = $this->request->getIntParam('independent',0);//是否为独立商城商品
        $total = $this->_get_cart_sum($independent);
        $info['data'] = [
            'cartNum' => $total > 0 ? intval($total) : 0
        ];
        $this->outputSuccess($info);
    }

}
