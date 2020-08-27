<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/24
 * Time: 上午9:50
 */
class App_Helper_RedpackRandom {
    //最小红包额度
    private $min_money  = 1;
    //最大红包额度
    private $max_money;
    //分发总金额
    private $money;
    //分发份数
    private $count;
    //每个红包最大是平均值的倍数
    private $times  = 2.1;

    /*
     * 若要生成分,请将$money乘以100得到分
     */
    public function __construct($money, $count) {
        $this->max_money    = $money;
        $this->money        = $money;
        $this->count        = $count;
    }

    /*
     * 拆分计算红包
     */
    public function compute() {
        $money  = $this->money;
        $count  = $this->count;
        if (!$this->_is_right($money, $count)) {
            return false;
        }

        $list   = array();
        $max    = ($money * $this->times) / $count;
        $max    = $max > $this->max_money ? $this->max_money : $max;

        for ($i=0; $i<$count; $i++) {
            $one    = $this->_random_redpack($money, $this->min_money, $max, $count-$i);
            array_push($list, $one);
            $money  -= $one;
        }
        return $list;
    }

    /*
     * 随机红包额度
     */
    private function _random_redpack($money, $mins, $maxs, $count) {
        if ($count == 1) {
            return $money;
        }

        if ($mins == $maxs) {
            return $mins;
        }

        $max = $maxs > $money ? $money : $maxs;
        //随机产生一个红包
        $one = round((mt_rand(0, 9999)/10000)*($max - $mins) + $mins) % $max + 1;
        $tmp_money  = $money - $one;
        //判断分配方案是否正确
        if ($this->_is_right($tmp_money, $count-1)) {
            return $one;
        } else {
            $avg = $tmp_money / ($count -1);
            if ($avg < $this->min_money) {
                //递归调用，修改红包最大金额
                return $this->_random_redpack($money, $mins, $one, $count);
            } else if ($avg > $this->max_money) {
                //递归调用，修改红包最小金额
                return $this->_random_redpack($money, $one, $maxs, $count);
            }
        }
        return $one;
    }

    /*
     * 判断红包数额是否正确
     */
    private function _is_right($money, $count) {
        if ($money <= 0 || $count <= 0) {
            return false;
        }

        $avg    = $money/$count;
        if ($avg < $this->min_money) {
            return false;
        }
        if ($avg > $this->max_money) {
            return false;
        }

        return true;
    }
}