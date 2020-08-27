<?php
/**
 * CPS API
 */
class CPSClientApi extends ApiBase {
	public function __construct($access_token) {
		parent::__construct ( $access_token );
	}
	/**
	 * 搜索CPS商品
	 * http://wiki.open.weidian.com/index.php?title=%E6%90%9C%E7%B4%A2CPS%E5%95%86%E5%93%81
	 *
	 * @param unknown $keyword        	
	 * @param number $page_size        	
	 * @param number $page        	
	 * @param string $min_price        	
	 * @param string $max_price        	
	 * @param string $min_cps_rate        	
	 * @param string $man_cps_rate        	
	 * @return HttpResponse
	 */
	public function searchCPSProduct($keyword, $page_size = 20, $page = 1, $min_price = null, $max_price = null, $min_cps_rate = null) {
		$param = array (
				"keyword" => $keyword,
				"page_size" => $page_size,
				"page" => $page 
		);
		if (! empty ( $min_price )) {
			$param ["min_price"] = $min_cps_rate;
		}
		if (! empty ( $max_price )) {
			$param ["max_price"] = $max_price;
		}
		if (! empty ( $min_cps_rate )) {
			$param ["min_cps_rate"] = $min_cps_rate;
		}
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => json_encode($param),
				"public" => parent::buildPublicValue ( "vdian.cps.item.search" ) 
		) );
	}
	/**
	 * 获取CPS商品
	 * http://wiki.open.weidian.com/index.php?title=%E8%8E%B7%E5%8F%96CPS%E5%95%86%E5%93%81
	 *
	 * @param unknown $itemid        	
	 * @return HttpResponse
	 */
	public function getCPSProduct($itemid) {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"itemid":"' . $itemid . '"}',
				"public" => parent::buildPublicValue ( "vdian.cps.item.get" ) 
		) );
	}
	/**
	 * 获取商品公开信息
	 * http://wiki.open.weidian.com/index.php?title=%E8%8E%B7%E5%8F%96%E5%95%86%E5%93%81%E5%85%AC%E5%BC%80%E4%BF%A1%E6%81%AF
	 *
	 * @param unknown $itemid        	
	 * @return HttpResponse
	 */
	public function getProductPublicInfo($itemid) {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"itemid":"' . $itemid . '"}',
				"public" => parent::buildPublicValue ( "vdian.item.getpublic" ) 
		) );
	}
}

?>