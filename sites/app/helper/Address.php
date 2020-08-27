<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/2/16
 * Time: 下午7:35
 */
class App_Helper_Address {

    private $china_address_table;
    /*
     * 直辖市列表
     */
    public $china_under_government;

    public function __construct() {
        $this->china_address_table  = 'dpl_china_address';
        $this->china_under_government   = array(
            2   => '北京',
            25  => '上海',
            27  => '天津',
            32  => '重庆',
            33  => '香港',
            34  => '澳门',
            35  => '台湾'
        );
    }
    /*
     * 根据父ID获取所有下级区域
     * @param int $pid 1为中国的ID
     */
    public function getAllRegion($pid = 1) {
        $pid    = intval($pid);
        if ($pid > 0) {
            $sql    = "SELECT * FROM `{$this->china_address_table}` WHERE `parent_id`=".$pid;

            $list   = DB::fetch_all($sql);

            return $list;
        }

        return false;
    }

    public function getRegionByID($rgid) {
        $rgid   = intval($rgid);
        $sql    = "SELECT * FROM `{$this->china_address_table}` WHERE `region_id`=".$rgid;

        return DB::fetch_first($sql);
    }

    /**
     * 根据省市区关键词获取数据
     * @param string $p
     * @param string|null $c
     * @param string $z
     * @param int $level
     * @return array|bool
     */
    public function getLevelRegion($p, $c = null, $z = null, $level = 3) {
        $province_arr   = $this->getAllRegion(1);//所有省列表
        $province       = null;
        foreach ($province_arr as $item) {
            $pattern    = "/{$item['region_name']}/u";
            $flag       = preg_match($pattern, $p);
            /*if(!$flag){
                $pattern    = "/{$p}/u";
                $flag       = preg_match($pattern, $item['region_name']);
            }*/
            if ($flag == 1) {
                $province   = $item;
                break;
            }
        }
        if (!$province) {
            //@todo 获取不到时,做一次补查
            return false;
        }
        //仅获取省级
        if ($level == 1) {
            return array(
                1   => $province,
            );
        }

        $city_arr   = $this->getAllRegion($province['region_id']);//所有市列表
        $city       = null;
        if (!$c) {
            $city   = $city_arr[0];//设置为第一个
        } else {
            foreach ($city_arr as $item) {
                $tmp    = mb_substr($item['region_name'], 0, 2, 'UTF-8');
                $pattern    = "/{$tmp}/u";
                $flag   = preg_match($pattern, $c);
                if ($flag == 1) {
                    $city   = $item;
                    break;
                }
            }
        }
        //仅获取市级
        if ($level == 2) {
            $ret    = array(
                1   => $province,
            );
            if ($city) {
                $pid    = $province['region_id'];
                //非直辖市
                if (!in_array($pid, array_keys($this->china_under_government))) {
                    $ret[2] = $city;
                }
            }
            return $ret;
        }

        $zone   = null;
        if ($city) {
            $zone_arr   = $this->getAllRegion($city['region_id']);//所有区县列表
            foreach ($zone_arr as $item) {
                $tmp    = mb_substr($item['region_name'], 0, 2, 'UTF-8');
                $pattern= "/{$tmp}/u";
                $flag   = preg_match($pattern, $z);
                if ($flag == 1) {
                    $zone   = $item;
                    break;
                }
            }
        }
        //区县数据获取失败
        if (!$zone) {
            $z_str  = mb_substr($z, 0, 2, 'UTF-8');
            $sql    = "SELECT * FROM `{$this->china_address_table}` WHERE `region_name` LIKE '{$z_str}%' AND `region_type`=3";

            $zone_list  = DB::fetch_all($sql);
            foreach ($zone_list as $item) {
                $city_tmp   = $this->getRegionByID($item['parent_id']);

                if ($city_tmp && $city_tmp['parent_id'] == $province['region_id']) {
                    $city   = $city_tmp;
                    $zone   = $item;
                    break;
                }
            }
        }

        if (!$zone) {
            return false;
        }

        return array(
            1     => $province,
            2     => $city,
            3     => $zone,
        );
    }
}