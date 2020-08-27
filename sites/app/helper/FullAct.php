<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/11/1
 * Time: 上午9:15
 */
class App_Helper_FullAct {

    const FULL_ACT_MANJIAN  = 1;//满减
    const FULL_ACT_MANSONG  = 2;//满送
    const FULL_ACT_MANZHE   = 3;//满折
    const FULL_ACT_MANYOU   = 4;//满邮

    private $sid;

    public static $full_act_desc    = array(
        self::FULL_ACT_MANJIAN  => '满减',
        self::FULL_ACT_MANSONG  => '满送',
        self::FULL_ACT_MANZHE   => '满折',
        self::FULL_ACT_MANYOU   => '满邮',
    );
    public function __construct($sid) {
        $this->sid  = $sid;
    }
    /*
     * 获取单个商品参与的满优惠活动列表
     */
    public function getFullActByGid($gid) {
        $full_model = new App_Model_Full_MysqlFullActStorage($this->sid);

        $full_all   = $full_model->getAllRunningAct();
        $fgoods_model   = new App_Model_Full_MysqlFullGoodsStorage($this->sid);

        $full_curr  = array();
        foreach ($full_all as &$item) {
            $item['type_desc']  = self::$full_act_desc[$item['fa_type']];
            if ($item['fa_use_type'] == 1) {
                $full_curr[]    = $item;
            } else {
                $has_join   = $fgoods_model->actExistGid($gid, $item['fa_id']);
                if ($has_join) {
                    $full_curr[]    = $item;
                }
            }
        }
        return $full_curr;
    }
    /*
     * 获取多个商品,及商品总价可参与的优惠活动列表
     * @param   array $gids 商品id数组
     * @param   float $amount 商品总价格
     * @param   int   $sum 商品总数量
     * @param   bool  $isallow 是否允许使用优惠
     */
    public function getFullActByGidsAmount(array $gids, $amount, $sum, $single_info,$isallow = true,$esId = 0) {
        // 判断是否允许使用优惠
        if(!$isallow){
            return array();
        }
        $amount = floatval($amount);
        $full_model = new App_Model_Full_MysqlFullActStorage($this->sid);

        $full_all   = $full_model->getAllRunningAct($esId);

        $fgoods_model   = new App_Model_Full_MysqlFullGoodsStorage($this->sid);
        $rule_model = new App_Model_Full_MysqlFullRuleStorage($this->sid);
        $act = array();

        $in_act_total = 0;
        $in_act_num = 0;

        foreach ($full_all as $key => &$item) {
            $item['type_desc']  = self::$full_act_desc[$item['fa_type']];
            //根据活动ID获取规则列表,按照限制递增
            $list   = $rule_model->getListByActid($item['fa_id']);
            if ($list) {
                //获取最低限制
                $low    = current($list);
                if ($item['fa_use_type'] == 1) {//全部商品可用
                    if ($low['fr_kind'] == 1) {//满额计算
                        $limit  = $amount;
                    } else {//满件计算
                        $limit  = $sum;
                    }
                    if($limit >= intval($low['fr_limit'])){
                        $act[$key] = $full_all[$key];
                        $act[$key]['limit'] = $limit;
                    }

                } else {

                    foreach ($gids as $gid) {
                        $has_join   = $fgoods_model->actExistGid($gid, $item['fa_id']);

                        if($has_join){
                            $in_act_total +=  $single_info[$gid]['total'];
                            $in_act_num +=  $single_info[$gid]['num'];
                        }
                    }
                    if ($low['fr_kind'] == 1) {//满额计算
                        $limit  = $in_act_total;
                    } else {//满件计算
                        $limit  = $in_act_num;
                    }
                    if($limit >= intval($low['fr_limit'])){
                        $act[$key] = $full_all[$key];
                        $act[$key]['limit'] = $limit;
                    }

                }
            }

            $in_act_total = 0;
            $in_act_num = 0;
        }

        $full_all = $act;


        foreach ($full_all as $key => &$item) {
            $list   = $rule_model->getListByActid($item['fa_id']);
            $sort   = array_reverse($list);
            $item_limit  = $item['limit'];

            foreach ($sort as &$one) {
                if($item_limit >= intval($one['fr_limit'])) {
                    switch ($item['fa_type']) {
                        case self::FULL_ACT_MANJIAN :
                            $one['rule_desc']   = "减{$one['fr_value']}元";
                            break;
                        case self::FULL_ACT_MANSONG :
                            $one['rule_desc']   = "送赠品";
                            break;
                        case self::FULL_ACT_MANZHE :
                            $one['rule_desc']   = "打{$one['fr_value']}折";
                            break;
                        case self::FULL_ACT_MANYOU :
                            $one['rule_desc']   = "包邮";
                    }
                    $item['rule']   = $one;
                    break;
                }
            }
        }

        return $full_all;
    }
    //2019.3.14
    public function getFullActByGidsAmountOld2(array $gids, $amount, $sum, $single_info,$isallow = true,$esId = 0) {
        // 判断是否允许使用优惠
        if(!$isallow){
            return array();
        }
        $amount = floatval($amount);
        $full_model = new App_Model_Full_MysqlFullActStorage($this->sid);

        $full_all   = $full_model->getAllRunningAct($esId);

        $fgoods_model   = new App_Model_Full_MysqlFullGoodsStorage($this->sid);
        $rule_model = new App_Model_Full_MysqlFullRuleStorage($this->sid);
        $act = array();
        foreach ($full_all as $key => &$item) {
            $item['type_desc']  = self::$full_act_desc[$item['fa_type']];
            //根据活动ID获取规则列表,按照限制递增
            $list   = $rule_model->getListByActid($item['fa_id']);
            if ($list) {
                //获取最低限制
                $low    = current($list);
                if ($item['fa_use_type'] == 1) {//全部商品可用
                    if ($low['fr_kind'] == 1) {//满额计算
                        $limit  = $amount;
                    } else {//满件计算
                        $limit  = $sum;
                    }
                    if($limit >= intval($low['fr_limit'])){
                        $act[$key] = $full_all[$key];
                    }

                } else {
                    foreach ($gids as $gid) {
                        $has_join   = $fgoods_model->actExistGid($gid, $item['fa_id']);
                        if ($has_join) {
                            if ($low['fr_kind'] == 1) {//满额计算
                                $limit  = $single_info[$gid]['total'];
                            } else {//满件计算
                                $limit  = $single_info[$gid]['num'];
                            }
                            if($limit >= intval($low['fr_limit'])){
                                $act[$key] = $full_all[$key];
                            }
                        }
                    }
                }
            }


        }

        $full_all = $act;
        foreach ($full_all as $key => &$item) {
            $list   = $rule_model->getListByActid($item['fa_id']);
            $sort   = array_reverse($list);
            foreach ($sort as &$one) {
                if ($limit >= intval($one['fr_limit'])) {
                    switch ($item['fa_type']) {
                        case self::FULL_ACT_MANJIAN :
                            $one['rule_desc']   = "减{$one['fr_value']}元";
                            break;
                        case self::FULL_ACT_MANSONG :
                            $one['rule_desc']   = "送赠品";
                            break;
                        case self::FULL_ACT_MANZHE :
                            $one['rule_desc']   = "打{$one['fr_value']}折";
                            break;
                        case self::FULL_ACT_MANYOU :
                            $one['rule_desc']   = "包邮";
                    }
                    $item['rule']   = $one;
                    break;
                }
            }
        }

        return $full_all;
    }

    public function getFullActByGidsAmountOld1(array $gids, $amount, $sum, $single_fee,$isallow = true) {
        // 判断是否允许使用优惠
        if(!$isallow){
            return array();
        }
        $amount = floatval($amount);
        $full_model = new App_Model_Full_MysqlFullActStorage($this->sid);

        $full_all   = $full_model->getAllRunningAct();



        $fgoods_model   = new App_Model_Full_MysqlFullGoodsStorage($this->sid);

        //首先按照商品过滤,不满足条件的活动将被剔除
        $act = array();
        foreach ($full_all as $key => &$item) {
            $item['type_desc']  = self::$full_act_desc[$item['fa_type']];
            if ($item['fa_use_type'] == 1) {//全部商品可用
                //不做处理
                $act[$key] = $full_all[$key];
            } else {
                foreach ($gids as $gid) {
                    $has_join   = $fgoods_model->actExistGid($gid, $item['fa_id']);
                    if ($has_join) {
                        $act[$key] = $full_all[$key];
                    }
//                    else{
//                        $amount -= $single_fee[$gid];
//                    }
                }
            }
        }



        $full_all = $act;

        //然后按照订单总价,商品总数过滤
        $rule_model = new App_Model_Full_MysqlFullRuleStorage($this->sid);
        foreach ($full_all as $key => &$item) {
            //根据活动ID获取规则列表,按照限制递增
            $list   = $rule_model->getListByActid($item['fa_id']);
            if (!$list) {
                unset($full_all[$key]);
                continue;
            }
            //获取最低限制
            $low    = current($list);
            if ($low['fr_kind'] == 1) {//满额计算
                $limit  = $amount;
            } else {//满件计算
                $limit  = $sum;
            }

            if (intval($low['fr_limit']) > $limit) {
                unset($full_all[$key]);
                continue;
            }
            //筛选出最大优惠
            $sort   = array_reverse($list);
            foreach ($sort as &$one) {
                if ($limit >= intval($one['fr_limit'])) {
                    switch ($item['fa_type']) {
                        case self::FULL_ACT_MANJIAN :
                            $one['rule_desc']   = "减{$one['fr_value']}元";
                            break;
                        case self::FULL_ACT_MANSONG :
                            $one['rule_desc']   = "送赠品";
                            break;
                        case self::FULL_ACT_MANZHE :
                            $one['rule_desc']   = "打{$one['fr_value']}折";
                            break;
                        case self::FULL_ACT_MANYOU :
                            $one['rule_desc']   = "包邮";
                    }
                    $item['rule']   = $one;
                    break;
                }
            }
        }

        return $full_all;
    }
    /*
     * 获取多个商品可使用的优惠券列表
     * 订购的商品id
     * 会员id
     * amount ：订单金额
     * $isallow : 是否允许使用优惠劵
     * groupLimit 限制多个商品的优惠券使用（多个商品包含一个优惠商品时不可用）
     */
    public function getCouponListByGids(array $gids, $mid, $amount,$islimit=false,$isallow = true, $esId=0,$groupLimit=TRUE) {

        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
        $coupon = $receive_model->fetchMemberValidCoupon($mid, $this->sid, $esId);
        $youhuiq= array();
        if($isallow){
            if ($coupon && !$islimit) {
                foreach ($coupon as $one) {
                    if (($amount >= intval($one['cl_use_limit'])) || ($one['cl_use_limit']==0)) {
                        $youhuiq[]    = $one;
                    }
                }
            }elseif($coupon && $islimit){   // 如果不需要验证是否可用则直接返回会员的所有优惠券
                $youhuiq = $coupon;
            }
            //滤掉商品不适合的优惠券
            $coupon_goods   = new App_Model_Coupon_MysqlCouponGoodsStorage($this->sid);
            $new_coupon_list=[];
            foreach ($youhuiq as $key => $item) {
                if ($item['cl_use_type'] == 2) {
                    foreach ($gids as $gid) {
                        $has_join   = $coupon_goods->actExistGid($gid, $item['cl_id']);
                        if (!$has_join && $groupLimit) {
                            unset($youhuiq[$key]);
                            continue 2;
                        }else if($has_join && !$groupLimit){
                            $new_coupon_list[$item['cr_c_id']]=$item;
                        }
                    }
                }else{
                    $new_coupon_list=$youhuiq;
                }
            }
        }  
        if(!$groupLimit)
            $youhuiq=$new_coupon_list;
        return $youhuiq;
    }

    /*
     * 获取多个商品可使用的优惠券列表
     * 商品限制使用以限制商品总价格为准而非订单总价为准
     */
    public function getCouponListByGidsNew(array $gids, $mid, $amount,$islimit=false,$isallow = true, $esId=0,array $goodsData,$communityLeaderId = 0) {
        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
        $coupon = $receive_model->fetchMemberValidCoupon($mid, $this->sid, $esId);
        $coupon_goods   = new App_Model_Coupon_MysqlCouponGoodsStorage($this->sid);
        $youhuiq= array();
        if($isallow){
            if ($coupon && !$islimit) {
                foreach ($coupon as $one) {
                    //将不在可使用小区的团长帖子优惠券剔除
                    if(($coupon['cr_leader'] > 0 && $coupon['cr_leader'] == $communityLeaderId) || $coupon['cr_leader'] == 0){
                        if($one['cl_use_type'] == 2){//有商品使用限制
                            //获得
                            $goodsLimit = $coupon_goods->getGoodsLimit($one['cl_id']);
                            $limitGids = [];//限制的商品id
                            $limitPrice = 0;//已购买的限制商品总价
                            $inLimit = false;//是否购买了限制的商品

                            if($goodsLimit){
                                foreach ($goodsLimit as $limit){
                                    $limitGids[] = $limit['cg_g_id'];
                                }
                            }

                            foreach ($limitGids as $gid){
                                if(in_array($gid,$gids)){
                                    $inLimit = true;
                                    $limitPrice += $goodsData[$gid]['goodsFee'];
                                }
                            }

                            if($inLimit && ($one['cl_use_limit'] == 0 || $limitPrice >= intval($one['cl_use_limit']))){
                                $youhuiq[] = $one;
                            }

                        }else{
                            if (($amount >= intval($one['cl_use_limit'])) || ($one['cl_use_limit']==0)) {
                                $youhuiq[]    = $one;
                            }
                        }
                    }
                }
            }elseif($coupon && $islimit){   // 如果不需要验证是否可用则直接返回会员的所有优惠券
                $youhuiq = $coupon;
            }

        }
        return $youhuiq;
    }

    /*
     * （微订餐）获取多个商品,及商品总价可参与的满减活动列表
     * @param   array $gids 商品id数组
     * @param   float $amount 商品总价格
     * @param   int   $sum 商品总数量
     */
    public function getMealFullActByGidsAmount(array $gids, $amount, $noActAmount , $esId = 0) {
        $amount = floatval($amount);
        $full_model = new App_Model_Meal_MysqlMealFullActivityStorage($this->sid);
        if($esId){
            $full_all   = $full_model->findListWithEsId($esId);
        }else{
            $full_all   = $full_model->findListBySid();
        }
        $actAmount  = $amount - $noActAmount;
        $actAll = array();
        foreach ($full_all as $key => &$item) {
            if($item['amf_type'] == 1 && $item['amf_limit'] <= $actAmount){
                $actAll[] = array(
                    'id'    => $item['amf_id'],
                    'limit' => $item['amf_limit'],
                    'value' => $item['amf_value'], 
                );
            }
        }
        $act = array(
            'limit' => 0,
        );
        foreach ($actAll as $key => $value) {
            //取满减限制更大的
            if($value['limit'] > $act['limit']){
                $act = $value;
            //若满减限制相同  取额度更大的
            }elseif ($value['limit'] == $act['limit'] && $value['value'] > $act['value']){
                $act = $value;
            }
        }
        if($act['limit'] != 0){
            return $act;
        }else{
            return array();
        }
    }

    /*
     * 获取多个课程可使用的优惠券列表
     * 订购的商品id
     * 会员id
     * amount ：订单金额
     */
    public function getCouponListByCourseIds(array $courseIds = array(), $mid, $amount,$islimit=false) {
        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
        $coupon = $receive_model->fetchMemberValidCoupon($mid, $this->sid);
        $youhuiq= array();
        if ($coupon && !$islimit) {
            foreach ($coupon as $one) {
                if (($amount >= intval($one['cl_use_limit'])) || ($one['cl_use_limit']==0)) {
                    $youhuiq[]    = $one;
                }
            }
        }elseif($coupon && $islimit){   // 如果不需要验证是否可用则直接返回会员的所有优惠券
            $youhuiq = $coupon;
        }
        //滤掉商品不适合的优惠券
//        $coupon_goods   = new App_Model_Coupon_MysqlCouponGoodsStorage($this->sid);
//        foreach ($youhuiq as $key => $item) {
//            if ($item['cl_use_type'] == 2) {
//                foreach ($courseIds as $gid) {
//                    $has_join   = $coupon_goods->actExistGid($gid, $item['cl_id']);
//                    if (!$has_join) {
//                        unset($youhuiq[$key]);
//                        continue 2;
//                    }
//                }
//            }
//        }
        return $youhuiq;
    }
}