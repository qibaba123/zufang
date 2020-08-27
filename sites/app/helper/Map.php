<?php 
class App_Helper_Map{
	private $sid;
	private $map_key;
	public function __construct($sid=null){
		$this->sid 		= $sid;
		$this->map_key 	= plum_parse_config('mapKay');
	}
	/**
	 * 根据坐标位置获取骑行距离
	 * @param  [type] $origin      [起点经纬度]
	 * @param  [type] $destination [终点经纬度]
	 * @return [type]              [description]
	 */
	public function getBicyclingDistance($origin,$destination){
		$url    = 'https://restapi.amap.com/v4/direction/bicycling';
		$params = [
			'origin'		=> $origin,
			'destination'	=> $destination,
			'key'			=> $this->map_key, 
		];
		$res      = Libs_Http_Client::get($url, $params);
		$geoArr   = json_decode($res, 1);
		if($geoArr['errcode'] != 0){
			throw new Exception($geoArr['errdetail']);
		}
		$paths = $geoArr['data']['paths'];
		$distance = 0;
		foreach ($paths as $key => $val) {
			if($distance == 0){
				$distance = $val['distance'];
			}else if($distance > $val['distance']) {
				$distance = $val['distance'];
			}
		}
		return $distance / 1000;
	}
	/**
	 * 根据坐标位置获取直线距离
	 * @param  [type] $origin      [起点经纬度]
	 * @param  [type] $destination [终点经纬度]
	 * @return [type]              [description]
	 */
	public function getLineDistance($origin,$destination){
		$origin_location		= explode(',',$origin);
		$lng					= $origin_location[0];
		$lat					= $origin_location[1];
		$destination_location	= explode(',',$destination);
		$shopLng				= $destination_location[0];
		$shopLat				= $destination_location[1];
		$distance    = (2 * 6378.137 * asin(sqrt(pow(sin(pi() * ($lng - $shopLng) / 360), 2) + cos(pi() * $lat / 180) * cos($shopLat * pi() / 180) * pow(sin(pi() * ($lat - $shopLat) / 360), 2))));
		return $distance;
	}
	/**
	 * 根据地址信息获取经纬度
	 * @param  [type] $pro    [省份]
	 * @param  [type] $city   [城市]
	 * @param  [type] $zone   [地区]
	 * @param  [type] $detail [详细地址]
	 * @return [type]         [description]
	 */
	public function getLocationFromAddress($pro,$city,$zone,$detail){
		$url		= 'http://restapi.amap.com/v3/geocode/geo';
		$address	= $pro.$city.$zone.$detail;
		if(empty($address)){
			throw new Exception("请填写您的地址信息");			
		}
        $params = [
            'address' => $address,
            'city'    => $city,
            'output'  => 'JSON',
            'key'     => $this->map_key, 
        ];
        $res      = Libs_Http_Client::get($url, $params);
        $geoArr   = json_decode($res, 1);
        if($geoArr['infocode'] != 10000){
        	throw new Exception($geoArr['info'], 2);
        }
        $location = $geoArr['geocodes'][0]['location'];
        if (empty($location)) {
            throw new Exception('地址信息获取失败（经纬度获取失败）');
        }
        $locationArr = explode(',', $location);
        $lng         = $locationArr[0];
        $lat         = $locationArr[1];
        return [
        	'lng'	=> $locationArr[0],
        	'lat'	=> $locationArr[1],
        ];
	}

	/**
     * 根据经纬度解析详细地址
     * @param  [type] $lng [经度]
     * @param  [type] $lat [纬度]
     * @return [type]      [description]
     */
    public function getAddressFromLngLat($lng,$lat){
        $url = 'https://restapi.amap.com/v3/geocode/regeo';
        $params = array(
            'location' => $lng.','.$lat,
            'key'      => $this->map_key,
        );
        $res      = Libs_Http_Client::get($url, $params);
       Libs_Log_Logger::outputLog($res,'address.log');
        $location = json_decode($res, 1);
        if($location['status'] == 1){
            $location_obj = $location['regeocode']['addressComponent'];
            $province = $location_obj['province'];
            $city     = $location_obj['city'];
            $area     = $location_obj['district'];
            return [
                'pro'   => $province,
                'city'  => is_array($city) ? '' : $city,
                'area'  => is_array($area) ? '' : $area,
            ];
        }
        return [];
    }
}