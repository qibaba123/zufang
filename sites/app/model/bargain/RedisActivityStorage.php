<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/11
 * Time: 下午9:49
 */
class App_Model_Bargain_RedisActivityStorage extends Libs_Redis_RedisClient {
    const BARGAIN_JOINER_KEY_PREFIX = "bargain_joiner_last_";
    const MERCHANT_BARGAIN_JOINER_KEY_PREFIX = "merchant_bargain_joiner_last_";
    /*
     * 店铺id
     */
    private $sid;

    public function __construct($sid) {
        $this->sid = $sid;
        return parent::__construct();
    }

    /**
     * 创建活动开始及结束倒计时
     * 创建及修改均可使用
     * @param int $aid 活动ID
     * @param int $start 开始时间
     * @param int $end 结束时间
     * @return bool
     */
    public function createActivityCountdown($aid, $start, $end) {
        $curr   = time();
        if ($end > $start && $start > $curr) {
            $this->redis->select(1);//操作1号数据库
            //活动开始倒计时
            $ttl1   = $start - $curr;
            $key    = "bargain_activity_start_{$this->sid}_{$aid}";
            $this->redis->setex($key, $ttl1, $key);
            //活动结束倒计时
            $ttl2   = $end - $curr;
            $key    = "bargain_activity_end_{$this->sid}_{$aid}";
            $this->redis->setex($key, $ttl2, $key);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除活动已创建的倒计时
     * @param int $aid
     * @return bool
     */
    public function deleteActivityCountdown($aid) {
        $this->redis->select(1);//操作1号数据库
        //活动开始倒计时
        $key1    = "bargain_activity_start_{$this->sid}_{$aid}";
        $key2    = "bargain_activity_end_{$this->sid}_{$aid}";
        $this->redis->del($key1, $key2);
        return true;
    }

    /**
     * 创建参与者的价格分配列表
     * @param float $price
     * @param int $num
     * @param int $section 分配区间号
     * @param int $jid
     * @return bool
     */
    public function createPriceSection($price, $num, $section, $jid) {
        $price  = floatval($price);
        $num    = intval($num);

        if ($price <= 0 || $num <= 0) {
            return false;
        }
        //生成分配列表
        $price  = $price*100;//转换为分作单位
        $random_helper  = new App_Helper_RedpackRandom($price, $num);
        $list   = $random_helper->compute();
        $joiner_section_key = "bargain_joiner_{$jid}_section_{$section}";

        foreach ($list as $one) {
            $one    = (string)$one/100;//转换回元
            $this->redis->rPush($joiner_section_key, $one);
        }

        return true;
    }

    /**
     * 获取参与者的区间价格
     * @param int $jid
     * @param int $section
     * @return string
     */
    public function fetchSectionPrice($jid, $section) {
        $joiner_section_key = "bargain_joiner_{$jid}_section_{$section}";

        return $this->redis->lPop($joiner_section_key);
    }

    /*
     * 递归获取参与者分配的价格,如果始终获取失败,返回默认值1元
     */
    public function fetchRecursivePrice($jid) {
        $price  = 0;

        for ($i=1; $i<4; $i++) {
            $price  = $this->fetchSectionPrice($jid, $i);
            if ($price) {
                break;
            }
        }

        if (!$price) {
            $price  = 1;
        }
        return $price;
    }

    /*
     * 获取参与者上次被砍价时间节点
     */
    public function getJoinerLast($jid) {
        $left   = $this->redis->ttl(self::BARGAIN_JOINER_KEY_PREFIX.$jid);

        $left   = $left > 0 ? $left : 0;
        return $left;
    }
    /*
     * 设置参与者砍价时间节点
     */
    public function setJoinerLast($jid, $ttl = 0) {
        return $this->redis->setex(self::BARGAIN_JOINER_KEY_PREFIX.$jid, $ttl, "last");
    }

    /**
     * 商家岛
     * 创建参与者的价格分配列表
     * @param float $price
     * @param int $num
     * @param int $section 分配区间号
     * @param int $jid
     * @return bool
     */
    public function createMerchantPriceSection($price, $num, $section, $jid) {
        $price  = floatval($price);
        $num    = intval($num);

        if ($price <= 0 || $num <= 0) {
            return false;
        }
        //生成分配列表
        $price  = $price*100;//转换为分作单位
        $random_helper  = new App_Helper_RedpackRandom($price, $num);
        $list   = $random_helper->compute();
        $joiner_section_key = "merchant_bargain_joiner_{$jid}_section_{$section}";

        foreach ($list as $one) {
            $one    = (string)$one/100;//转换回元
            $this->redis->rPush($joiner_section_key, $one);
        }

        return true;
    }

    /*
     * 商家岛
     * 获取参与者上次被砍价时间节点
     */
    public function getMerchantJoinerLast($jid) {
        $left   = $this->redis->ttl(self::MERCHANT_BARGAIN_JOINER_KEY_PREFIX.$jid);
        $left   = $left > 0 ? $left : 0;
        return $left;
    }

    /*
     * 商家岛
     * 设置参与者砍价时间节点
     */
    public function setMerchantJoinerLast($jid, $ttl = 0) {
        return $this->redis->setex(self::MERCHANT_BARGAIN_JOINER_KEY_PREFIX.$jid, $ttl, "last");
    }

    /**
     * 获取参与者的区间价格
     * @param int $jid
     * @param int $section
     * @return string
     */
    public function fetchMerchantSectionPrice($jid, $section) {
        $joiner_section_key = "merchant_bargain_joiner_{$jid}_section_{$section}";

        return $this->redis->lPop($joiner_section_key);
    }

    /*
     * 递归获取参与者分配的价格,如果始终获取失败,返回默认值1元
     */
    public function fetchMerchantRecursivePrice($jid) {
        $price  = 0;

        for ($i=1; $i<4; $i++) {
            $price  = $this->fetchMerchantSectionPrice($jid, $i);
            if ($price) {
                break;
            }
        }

        if (!$price) {
            $price  = 1;
        }
        return $price;
    }
}