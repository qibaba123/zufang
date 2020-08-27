<?php
/**
 * 处理收货地址
 */
class App_Controller_Applet_AddressController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct();
    }

    //收货地址列表
    public function addressListAction()
    {
        $address_model = new App_Model_Member_MysqlAddressStorage($this->shop['s_id']);
        $list          = $address_model->fetchAddrListByMid($this->member['m_id']);
        if ($list) {
            $res = array();
            foreach ($list as $val) {
                $distance    = 0;
                $range       = 0;
                $addressInfo = false;
                if ($val['ma_lng'] && $val['ma_lat']) {
                    // 地址存在获取店铺经纬度,计算配送地址
                    $tpl_model = new App_Model_Meal_MysqlMealIndexStorage($this->sid);
                    $tpl       = $tpl_model->findUpdateBySid($this->applet_cfg['ac_index_tpl']);
                    $distance  = $this->getDistance($tpl['ami_lat'], $tpl['ami_lng'], $val['ma_lat'], $val['ma_lng']);
                    $distance  = floor($distance / 1000);
                    $range     = $tpl['ami_post_range'];

                    $addressInfo = $this->_get_address_by_lat_lng($val['ma_lng'], $val['ma_lat']);
                }
                $temp              = array();
                $temp['id']        = $val['ma_id'];
                $temp['name']      = $val['ma_name'];
                $temp['mobile']    = $val['ma_phone'];
                $temp['isdefault'] = $val['ma_default'];
                $temp['post']      = $val['ma_post'];
                $temp['province']  = $addressInfo['prov'] ? $addressInfo['prov'] : $val['ma_province'];
                $temp['city']      = $addressInfo['city'] ? $addressInfo['city'] : $val['ma_city'];
                $temp['area']      = isset($val['ma_zone']) ? $val['ma_zone'] : '';
                $temp['address']   = $val['ma_detail'];
                $temp['lng']       = $val['ma_lng'];
                $temp['lat']       = $val['ma_lat'];
                $temp['pcda']      = empty($val['ma_pcda']) ? $val['ma_province'].$val['ma_city'].$val['ma_zone'] : $val['ma_pcda'];
                if ($this->applet_cfg['ac_type'] == 34) {
                    $temp['detail'] = ($val['ma_detail'] ? $val['ma_detail'] . '—' : '') . $val['ma_province'] . $val['ma_city'] . $val['ma_zone'];
                } else {
                    $temp['detail'] = $val['ma_province'] . $val['ma_city'] . $val['ma_zone']. $val['ma_pcda'] . $val['ma_detail'];
                }

                $temp['detailNew']   = $val['ma_province'] . $val['ma_city'] . $val['ma_zone'];
                $temp['dispatching'] = $distance <= $range ? 1 : 0;
                $temp['prompt']      = '不在配送范围内，商家拒绝接单...';

                $res[] = $temp;
            }
            $info['data'] = $res;
            $this->outputSuccess($info);
        } else {
            $this->outputError('该用户未添加收货地址');
        }
    }

    //删除收货地址
    public function deleteAddressAction()
    {
        $id            = $this->request->getIntParam('id');
        $address_model = new App_Model_Member_MysqlAddressStorage($this->sid);
        $where         = array();
        $where[]       = array('name' => 'ma_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[]       = array('name' => 'ma_id', 'oper' => '=', 'value' => $id);
        $address       = $address_model->getRow($where);
        if ($address) {
            $set = array('ma_deleted' => 1);
            $res = $address_model->updateById($set, $id);
            if ($res) {
                $info['data'] = array(
                    'msg' => '删除收货地址成功！',
                );
                $this->outputSuccess($info);
            } else {
                $this->outputError('删除收货地址失败！');
            }
        } else {
            $this->outputError('该地址不存在或已被删除');
        }
    }

    /**
     * 新的保存用户地址接口
     * (之前产品都是吃屎的么做特么这么混淆不清的功能)
     * zhangzc
     * 2020-01-14
     */
    public function addAddressAction()
    {
        $id      = $this->request->getIntParam('id');
        $name    = $this->request->getStrParam('name'); //收货人
        $mobile  = $this->request->getStrParam('mobile'); // 手机号
        $code    = $this->request->getStrParam('code'); //邮编 可空
        $pro     = $this->request->getStrParam('pro'); //省
        $city    = $this->request->getStrParam('city'); //市
        $area    = $this->request->getStrParam('area'); //区
        $street    = $this->request->getStrParam('street'); //区
        $default = $this->request->getIntParam('default', 0);
        $address = $this->request->getStrParam('address'); //街道信息
        $lng     = $this->request->getStrParam('lng'); //地址经度
        $lat     = $this->request->getStrParam('lat'); //地址纬度
        $pcda    = $this->request->getStrParam('pcda'); //  前端地图组件传来的 省份+城市+地区+简略位置的信息 也就是小程序地图组件中的address
 
        // 手机号验证
        if (!plum_is_mobile_phone($mobile)) { 
            // 马耳他智慧生活是国外使用，手机号不再做验证
            if($this->sid != 7448){
                $this->outputError('请输入正确的手机号码或固话');
            }
        }
        // 收货人验证
        if(empty($name)){
            $this->outputError('请填写收货人');
        }
        // 详细地址认证
        if(empty($address)){
            $this->outputError('请填写详细地址');
        }
        $map_model = new App_Helper_Map($this->sid);
        // 如果传递的有经纬度信息 则不验证省市区信息
       try{
            if($lng && $lat){
                if(empty($pro)){
                    // 根据坐标获取省市区
                    $location = $map_model->getAddressFromLngLat($lng,$lat);
                    if(empty($location)){
                        $this->outputError('地图接口数据解析失败!');
                    }
                    extract($location);
                }
               
            // 如果未传递经纬度根据查询到的省市区信息获取经纬度
            }else{
                if(in_array('',[$pro,$city,$area])){
                    // 马耳他智慧生活是国外使用，地址不填省市区
                    // 外卖与跑腿不验证省市区
                    if(!in_array($this->applet_cfg['ac_type'],[4,34]) && $this->sid != 7448){
                        $this->outputError('请完善省市区信息');
                    }
                }
                // 根据省市区获取坐标
                $location = $map_model->getLocationFromAddress($pro,$city,$area,$address);
                if(empty($location)){
                    $this->outputError('地图接口数据解析失败');
                }
                extract($location);
            }
       }catch(Exception $e){
            $this->outputError($e->getMessage());
       }
            
        $data = array(
            'ma_m_id'     => $this->member['m_id'],
            'ma_s_id'     => $this->sid,
            'ma_name'     => $name,
            'ma_phone'    => $mobile,
            'ma_post'     => $code,
            'ma_province' => $pro,
            'ma_city'     => $city,
            'ma_zone'     => $area,
            'ma_street'     => $street,
           // 'ma_pcda'     => $pcda,
            'ma_detail'   => $address,
            'ma_lng'      => $lng,
            'ma_lat'      => $lat,
            'ma_add_time' => time(),
        );

        $address_model = new App_Model_Member_MysqlAddressStorage($this->sid);
        // 重新设定默认值需要清空之前设置的默认值
        if ($default == 1) {
            $data['ma_default'] = $default;
            $where[]            = array('name' => 'ma_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $set                = array('ma_default' => 0);
            $address_model->updateValue($set, $where);
        }
        // 编辑
        if (!empty($id)) {
            $res = $address_model->updateValue($data,[
                ['name' =>'ma_id','oper' =>'=','value'=>$id],
                ['name' =>'ma_m_id','oper'=>'=','value'=>$this->member['m_id']]
            ]);
            if (!$res) {
                $this->outputError('收货地址信息编辑失败');
            } 
            $info['data'] = array(
                'id'  => $id,
                'msg' => '编辑收货地址成功！',
            );
            $this->outputSuccess($info);
        } else {
            $res = $address_model->insertValue($data);
            if (!$res) {
                $this->outputError('新增收货地址失败！');
            }
            $distance = 0;
            $range    = 0;
            if ($data['ma_lng'] && $data['ma_lat']) {
                // 地址存在获取店铺经纬度,计算配送地址
                $tpl_model = new App_Model_Meal_MysqlMealIndexStorage($this->sid);
                $tpl       = $tpl_model->findUpdateBySid($this->applet_cfg['ac_index_tpl']);
                $distance  = $this->getDistance($tpl['ami_lat'], $tpl['ami_lng'], $data['ma_lat'], $data['ma_lng']);
                $distance  = floor($distance / 1000);
                $range     = $tpl['ami_post_range'];
            }
            $info['data'] = array(
                'msg'     => '新增收货地址成功',
                'address' => array(
                    'id'          => $res,
                    'name'        => $data['ma_name'],
                    'mobile'      => $data['ma_phone'],
                    'isdefault'   => $data['ma_default'],
                    'post'        => $data['ma_post'],
                    'province'    => $data['ma_province'],
                    'city'        => isset($data['ma_city']) ? $data['ma_city'] : '',
                    'area'        => isset($data['ma_zone']) ? $data['ma_zone'] : '',
                    'address'     => $data['ma_detail'],
                    'detail'      => $data['ma_province'] . $data['ma_city'] . $data['ma_zone'] . $data['ma_detail'],
                    'dispatching' => $distance < $range ? 1 : 0,
                    'prompt'      => '不在配送范围内，商家拒绝接单..',
                ),
            );
            $this->outputSuccess($info);
        }
    }


    //设置默认收货地址
    public function defaultAction()
    {
        // 传地址id  ma_id   ma_default 1默认
        $id            = $this->request->getIntParam('id');
        $esId          = $this->request->getIntParam('esId');
        $moreDay       = $this->request->getIntParam('moreDay', 0);
        $address_model = new App_Model_Member_MysqlAddressStorage($this->shop['s_id']);
        $where         = array();
        $where[]       = array('name' => 'ma_id', 'oper' => '=', 'value' => $id);
        $where[]       = array('name' => 'ma_default', 'oper' => '=', 'value' => 0);
        $address       = $address_model->getRow($where);
        $legworkRet    = [];
        if ($address) {
            // 如果该地址不是默认地址再去修改
            if ($address['ma_default'] != 1) {
                // 设置为默认地址
                $res = $address_model->setDefaultAddress($this->member['m_id'], $id);
                if ($res) {
                    $legwork_model = new App_Model_Legwork_MysqlOtherLegworkCfgStorage($this->sid);
                    $legworkCfg    = $legwork_model->findUpdateBySidEsId($esId);

                    $distance    = 0;
                    $range       = 0;
                    $addressInfo = false;
                    if ($address['ma_lng'] && $address['ma_lat']) {
                        // 地址存在获取店铺经纬度,计算配送地址
                        $lng = $address['ma_lng'];
                        $lat = $address['ma_lat'];
                    } else {
                        //地址不存在经纬度  根据地址反解
                        //根据收货地址获得经纬度 再进行计算
                        $url    = 'http://restapi.amap.com/v3/geocode/geo';
                        $params = array(
                            'address' => $address['ma_province'] . $address['ma_city'] . $address['ma_zone'] . $address['ma_detail'],
                            'city'    => $address['ma_city'],
                            'output'  => 'JSON',
                            'key'     => plum_parse_config('mapKay'), //web服务key
                        );
                        $res         = Libs_Http_Client::get($url, $params);
                        $geoArr      = json_decode($res, 1);
                        $location    = $geoArr['geocodes'][0]['location'];
                        $locationArr = explode(',', $location);
                        $lng         = $locationArr[0] ? $locationArr[0] : '';
                        $lat         = $locationArr[1] ? $locationArr[1] : '';
                        if ($lng && $lat) {
                            //更新
                            $address_model->updateById(['ma_lng' => $lng, 'ma_lat' => $lat], $address['ma_id']);
                        }
                    }
                    if ($this->applet_cfg['ac_type'] == 4) {
                        if ($esId) {
                            $store_model = new App_Model_Meal_MysqlMealStoreStorage($this->sid);
                            $store       = $store_model->fetchStoreDetail($esId);
                            $distance    = $this->getDistance($store['ams_lat'], $store['ams_lng'], $lat, $lng);
                            $shopLng     = $store['ams_lng'];
                            $shopLat     = $store['ams_lat'];
                            $distance    = floor($distance / 1000);
                            $range       = $store['ams_post_range'];
                            $post_fee    = floatval($store['ams_post_fee']);
                        } else {
                            $tpl_model = new App_Model_Meal_MysqlMealIndexStorage($this->sid);
                            $tpl       = $tpl_model->findUpdateBySid($this->applet_cfg['ac_index_tpl'] ? $this->applet_cfg['ac_index_tpl'] : 12);
                            $distance  = $this->getDistance($tpl['ami_lat'], $tpl['ami_lng'], $lat, $lng);
                            $distance  = floor($distance / 1000);
                            $shopLng   = $tpl['ami_lng'];
                            $shopLat   = $tpl['ami_lat'];
                            $range     = $tpl['ami_post_range'];
                            $post_fee  = floatval($tpl['ami_post_fee']);
                        }
                        $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
                        $sendCfg    = $send_model->findUpdateBySid(null, $esId);

                        if ($legworkCfg['aolc_open'] == 1 && $legworkCfg['aolc_appid'] && $moreDay == 0) {
                            $legworkRet = $this->_get_legwork_post_price($legworkCfg['aolc_appid'], $shopLat, $shopLng, $lat, $lng);
                        }
                    }

                    $info['data'] = array(
                        'addressData' => array(
                            'id'          => $address['ma_id'],
                            'name'        => $address['ma_name'],
                            'mobile'      => $address['ma_phone'],
                            'lng'         => $lng,
                            'lat'         => $lat,
                            'isdefault'   => 1,
                            'post'        => $address['ma_post'],
                            'province'    => $addressInfo['prov'] ? $addressInfo['prov'] : $address['ma_province'],
                            'city'        => $addressInfo['city'] ? $addressInfo['city'] : $address['ma_city'],
                            'area'        => isset($address['ma_zone']) ? $address['ma_zone'] : '',
                            'address'     => $address['ma_detail'],
                            'detail'      => $address['ma_province'] . $address['ma_city'] . $address['ma_zone'] .$address['ma_pcda'] . $address['ma_detail'],
                            'dispatching' => $distance < $range ? 1 : 0,
                            'prompt'      => '不在配送范围内，商家拒绝接单.',
                            'postFee'     => $post_fee,
                            'postInfo'    => '',
                        ),
                        'result'      => true,
                        'msg'         => '设置默认地址成功',
                    );

                    if ($this->applet_cfg['ac_type'] == 34) {
                        $info['data']['addressData']['detail'] = ($address['ma_detail'] ? $address['ma_detail'] . '—' : '') . $address['ma_province'] . $address['ma_city'] . $address['ma_zone'];
                    }

                    if ($legworkRet) {
                        if ($legworkRet['errcode'] == 0) {
                            $info['data']['dispatching'] = 1;
                            $postFee                     = $postFeeTrue                     = $legworkRet['data']['price'];
                            $sectionArr                  = json_decode($legworkCfg['aolc_price_section'], 1);
                            if (is_array($sectionArr)) {
                                foreach ($sectionArr as $item) {
                                    if ($postFee >= $item['min'] && $postFee < $item['max']) {
                                        $postFeeTrue = $postFee - $item['value'];
                                        break;
                                    }
                                }
                            }
                            $info['data']['addressData']['postFee']  = $postFeeTrue > 0 ? $postFeeTrue : 0;
                            $info['data']['addressData']['postInfo'] = json_encode($legworkRet['data']);
                        } else {
                            $info['data']['addressData']['dispatching'] = 0;
                            $info['data']['addressData']['prompt']      = $legworkRet['msg'];
                        }
                    }
                    $this->outputSuccess($info);
                } else {
                    $this->outputError('设置默认地址失败');
                }
            } else {
                $this->outputError('该地址已是默认地址');
            }
        } else {
            $this->outputError('该地址不存在或已被删除');
        }
    }

    /*
     * 获得配送费用
     */
    public function _get_legwork_post_price($appid, $fromLat, $fromLng, $toLat, $toLng)
    {

        $applet_model   = new App_Model_Applet_MysqlCfgStorage();
        $where_applet[] = ['name' => 'ac_appid', 'oper' => '=', 'value' => $appid];
        $applet         = $applet_model->getRow($where_applet);
        $legwork_sid    = $applet['ac_s_id'];
        $distance       = 0;
        if ($fromLat && $fromLng && $toLat && $toLng && $legwork_sid) {
            //获得两点间最短骑行距离
            $url    = 'https://restapi.amap.com/v4/direction/bicycling?parameters';
            $params = array(
                'origin'      => $fromLng . ',' . $fromLat,
                'destination' => $toLng . ',' . $toLat,
                'output'      => 'JSON',
                'key'         => plum_parse_config('mapKay'), //web服务key
            );
            $res         = Libs_Http_Client::post($url, $params);
            $geoArr      = json_decode($res, 1);
            $mapDistance = floatval($geoArr['data']['paths'][0]['distance']);
            $distance    = round($mapDistance / 1000, 3);
        }
        $data = array(
            'needSum'       => false,
            'price'         => '',
            'basicDistance' => 0,
            'basicPrice'    => 0,
            'plusDistance'  => 0,
            'plusPrice'     => 0,
        );

        if ($distance) {
            //获得配送配置
            $cfg_model     = new App_Model_Legwork_MysqlLegworkCfgStorage($legwork_sid);
            $cfg           = $cfg_model->findUpdateBySid();
            $basicDistance = floatval($cfg['alc_basic_distance']);
            $basicPrice    = floatval($cfg['alc_basic_price']);
            $maxDistance   = floatval($cfg['alc_max_distance']);
            if ($basicDistance > 0) {
                if (($maxDistance > 0 && $maxDistance > $distance) || $maxDistance <= 0) {
                    $data = array(
                        'needSum'       => true,
                        'price'         => $basicPrice,
                        'basicDistance' => $basicDistance,
                        'basicPrice'    => $basicPrice,
                        'plusDistance'  => 0,
                        'plusPrice'     => 0,
                    );
                    if ($basicDistance < $distance) {
                        $plusDistance = floatval($cfg['alc_plus_distance']);
                        $plusPrice    = floatval($cfg['alc_plus_price']);
                        if ($plusDistance && $plusPrice) {
                            $dif       = $distance - $basicDistance;
                            $num       = ceil($dif / $plusDistance);
                            $plusTotal = $num * $plusPrice;
                            $total     = $basicPrice + $plusTotal;
                            $data      = array(
                                'needSum'       => true,
                                'price'         => $total,
                                'basicDistance' => $basicDistance,
                                'basicPrice'    => $basicPrice,
                                'plusDistance'  => $dif,
                                'plusPrice'     => $plusTotal,
                            );
                        }
                    }
                } else {
                    return array(
                        'errcode' => 400,
                        'msg'     => "超出配送范围",
                    );
                }
            }
        } else {
            return array(
                'errcode' => 400,
                'msg'     => "暂无法配送，请选择其他配送方式",
            );
        }

        $data['distance'] = $distance;
        $data['fromLng']  = $fromLng;
        $data['fromLat']  = $fromLat;
        $data['toLng']    = $toLng;
        $data['toLat']    = $toLat;

        return array(
            'errcode' => 0,
            'msg'     => "",
            'data'    => $data,
        );
    }

    /**
     * 获取蜂鸟配送配送费
     */
    private function _get_ele_post_fee($esId, $lng, $lat)
    {
        //获取门店

        $store_model = new App_Model_Store_MysqlStoreStorage($this->sid);
        $where       = array();
        $where[]     = array('name' => 'os_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]     = array('name' => 'os_es_id', 'oper' => '=', 'value' => $esId);
        $where[]     = array('name' => 'os_is_deleted', 'oper' => '=', 'value' => 0);
        $where[]     = array('name' => 'os_ele_store_id', 'oper' => '!=', 'value' => '');
        $storeList   = $store_model->getList($where, 0, 0, array());

        $storeIds = array();
        foreach ($storeList as $value) {
            $storeIds[] = $value['os_ele_store_id'];
        }

        $ele      = new App_Plugin_Food_AnubisEle();
        $storeRet = $ele->queryChainStore($storeIds);

        $distanceArrInfo = [];
        $storeArr        = [];
        if ($storeRet && $storeRet['errcode'] == 0) {
            foreach ($storeRet['result'] as $val) {
                if ($val['status'] == 2) {
                    //获取距离
                    $url    = 'https://restapi.amap.com/v3/direction/walking';
                    $params = array(
                        'origin'      => $val['longitude'] . ',' . $val['latitude'],
                        'destination' => $lng . ',' . $lat,
                        'output'      => 'JSON',
                        'key'         => plum_parse_config('mapKay'), //web服务key
                    );
                    $res               = Libs_Http_Client::get($url, $params);
                    $distanceArr       = json_decode($res, 1);
                    $distanceArrInfo[] = $distanceArr['route']['paths'][0]['distance'];
                    $val['distance']   = $distanceArr['route']['paths'][0]['distance'];
                    $storeArr[]        = $val;
                }
            }
        }
        $store = $storeArr[array_search(min($distanceArrInfo), $storeArr)];
        if (!$store || ($store['status'] != 2 && $this->sid != 11 && $this->sid != 5741)) {
            return array(
                'errcode' => 400,
                'msg'     => "暂无法配送，请选择其他配送方式",
            );
        } else {
            $city       = $store['city'];
            $post_model = new App_Model_Plugin_MysqlElePostCfgStorage();
            $post       = $post_model->findRowByCity($city);

            $baseCfg = plum_parse_config('base', 'ele');
            $grade   = $post['epc_grade'] ? $post['epc_grade'] : $post['epc_type'];
            $baseFee = $baseCfg[$grade ? $grade : '代理城市'];

            if (
                (time() >= strtotime('2019-01-28') && time() <= strtotime('2019-02-03')) ||
                (time() >= strtotime('2019-02-11') && time() <= strtotime('2019-02-17'))
            ) {
                $baseFee += 5;
            }

            if ((time() >= strtotime('2019-02-04') && time() <= strtotime('2019-02-10'))) {
                $baseFee += 10;
            }

            $checkSend = $ele->queryDelivery($store['chain_store_code'], $lng, $lat, 3);
            if ($checkSend['errcode'] != 0) {
                return array(
                    'errcode' => 400,
                    'msg'     => $checkSend['errmsg'],
                );
            }
            //获取距离
            $distance    = $store['distance'];
            $distance    = $distance / 1000; //获取到的是米 ，转化成千米
            $distanceCfg = plum_parse_config('distance', 'ele');
            $distanceFee = 0;
            if ($distance > 6) {
                return array(
                    'errcode' => 400,
                    'msg'     => "超出配送范围",
                );
            } else {
                foreach ($distanceCfg as $val) {
                    if ($distance >= $val['min'] && $distance < $val['max']) {
                        $distanceFee = $val['fee'];
                        break;
                    }
                }
            }
            //计算时间
            $ele_cfg_model = new App_Model_Plugin_MysqlEleCfgStorage($this->sid);
            $eleCfg        = $ele_cfg_model->fetchUpdateCfg(null, $esId);
            $timeCfg       = plum_parse_config('time', 'ele');
            $nowTime       = time() + ($eleCfg['ec_send_timeout'] ? $eleCfg['ec_send_timeout'] * 60 : 10 * 60);
            $timeFee       = 0;
            foreach ($timeCfg as $key => $val) {
                if ($nowTime >= strtotime($val['min']) && $nowTime <= strtotime($val['max'])) {
                    $timeFee = $val['fee'];
                }
            }
            //计算重量
            $weightCfg   = plum_parse_config('weight', 'ele');
            $tradeWeight = 1;
            if (strstr($tradeWeight, 'Kg')) {
                $tradeWeight = floatval($tradeWeight);
            } else {
                $tradeWeight = floatval($tradeWeight) / 1000;
            }
            if ($tradeWeight > 15) {
                return array(
                    'errcode' => 400,
                    'msg'     => "超出配送重量",
                );
            } else {
                $weightFee = 0;
                foreach ($weightCfg as $key => $val) {
                    if ($tradeWeight > strtotime($val['min']) && $tradeWeight <= strtotime($val['max'])) {
                        $weightFee = $val['fee'];
                    }
                }
                $postFee = $baseFee + $distanceFee + $timeFee + $weightFee;

                return array(
                    'errcode' => 0,
                    'postFee' => $postFee,
                    'storeId' => $store['chain_store_code'],
                );
            }
        }
    }

    /*
     * 根据经纬度获得当前地址
     */
    public function getAddressNowAction()
    {
        $lng = $this->request->getStrParam('lng');
        $lat = $this->request->getStrParam('lat');
        if ($lng && $lat) {
            $data         = $this->_get_address_by_lat_lng($lng, $lat);
            $info['data'] = $data;
            $this->outputSuccess($info);
        } else {
            $this->outputError('地址获取失败');
        }
    }
}
