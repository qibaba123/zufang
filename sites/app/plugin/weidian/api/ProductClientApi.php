<?php
/**
 * 微店商品API
 */
class ProductClientApi extends ApiBase {
	public function __construct($access_token) {
		parent::__construct ( $access_token );
	}
	
	/**
	 * 获取单个商品
	 * http://wiki.open.weidian.com/index.php?title=%E8%8E%B7%E5%8F%96%E5%8D%95%E4%B8%AA%E5%95%86%E5%93%81
	 * @return HttpResponse
	 */
	public function getProduct($item_id, $version = "1.0") {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"itemid":"' . $item_id . '"}',
				"public" => parent::buildPublicValue('vdian.item.get', $version ) 
		) );
	}
	/**
	 * 获取全店商品
	 * http://wiki.open.weidian.com/index.php?title=%E8%8E%B7%E5%8F%96%E5%8D%95%E4%B8%AA%E5%95%86%E5%93%81
	 *
	 * @param number $page_num        	
	 * @param number $page_size        	
	 * @param number $orderby        	
	 * @param string $version        	
	 * @return HttpResponse
	 */
	public function getShopProduct($page_num = 1, $page_size = 10, $orderby = 1, $version = "1.0") {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"page_num":' . $page_num . ',"page_size":' . $page_size . ',"orderby":' . $orderby . '}',
				"public" => parent::buildPublicValue ( 'vdian.item.list.get' ) 
		) );
	}
	
	/**
	 * 创建微店商品
	 * http://wiki.open.weidian.com/index.php?title=%E5%88%9B%E5%BB%BA%E5%BE%AE%E5%BA%97%E5%95%86%E5%93%81
	 *
	 * @param array $imgs        	
	 * @param string $stock        	
	 * @param string $price        	
	 * @param string $item_name        	
	 * @param string $fx_fee_rate        	
	 * @param array $skus        	
	 * @param string $merchant_code        
	 * @return HttpResponse	
	 */
	public function createProduct(array $imgs, $stock, $price, $item_name, $fx_fee_rate, array $skus, $merchant_code) {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"imgs":' . json_encode ( $imgs ) . ',"stock":"' . $stock . '","price":"' . $price . '","item_name":"' . $item_name . '","fx_fee_rate":"' . $fx_fee_rate . '","skus":' . json_encode ( $skus ) . ',"merchant_code":"' . $merchant_code . '"}',
				"public" => parent::buildPublicValue ( 'vdian.item.add' ) 
		) );
	}
	/**
	 * 删除单个商品
	 *
	 * @param string $itemid        	
	 * @return true成功，false失败
	 */
	public function deleteProduct($itemid) {
		$response = NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"itemid":"' . $itemid . '"}',
				"public" => parent::buildPublicValue ( 'vdian.item.delete' ) 
		) );
		$res = $response->getDataAsObject ();
		if ($res->status->status_code == 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 上传商品图片
	 * http://wiki.open.weidian.com/index.php?title=%E9%80%9A%E7%94%A8API
	 *
	 * @ignore
	 * @param unknown $img_path    
	 * @return HttpResponse    	
	 */
	public function uploadProductImage($img_path) {
		$url = API_HOST . 'media/upload';
		$parameters = array (
				"access_token" => $this->access_token,
				"media" => $img_path 
		);
		$response = NetUtils::getInstance ()->uploadFile ( $url, $parameters );
		return $response;
	}
	/**
	 * 添加商品图片
	 * http://wiki.open.weidian.com/index.php?title=%E6%B7%BB%E5%8A%A0%E5%95%86%E5%93%81%E5%9B%BE%E7%89%87
	 *
	 * @param string $itemid        	
	 * @param array $imgs        	
	 * @return true成功，false失败
	 */
	public function addProductImage($itemid, array $imgs) {
		$result = NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"itemid":"' . $itemid . '","imgs":' . json_encode ( $imgs ) . '}',
				"public" => parent::buildPublicValue ( 'vdian.item.image.add' ) 
		) )->getDataAsObject ();
		if ($result->status->status_code == 0) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * 删除商品图片
	 * http://wiki.open.weidian.com/index.php?title=%E5%88%A0%E9%99%A4%E5%95%86%E5%93%81%E5%9B%BE%E7%89%87
	 *
	 * @param string $itemid        	
	 * @param array $delete_imgs        	
	 * @return true成功，false失败
	 */
	public function deleteProductImage($itemid, array $delete_imgs) {
		$result = NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"itemid":"' . $itemid . '","delete_imgs":' . json_encode ( $delete_imgs ) . '}',
				"public" => parent::buildPublicValue ( 'vdian.item.image.delete' ) 
		) )->getDataAsObject ();
		if ($result->status->status_code == 0) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * 更新商品信息
	 * http://wiki.open.weidian.com/index.php?title=%E6%9B%B4%E6%96%B0%E5%95%86%E5%93%81%E4%BF%A1%E6%81%AF
	 *
	 * @param string $itemid        	
	 * @param string $stock        	
	 * @param string $price        	
	 * @param string $item_name        	
	 * @param string $fx_fee_rate        	
	 * @param array $skus        	
	 * @param string $merchant_code        	
	 * @return HttpResponse
	 */
	public function updateProductInfo($itemid, $stock, $price, $item_name, $fx_fee_rate, array $skus, $merchant_code = "") {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"stock":"' . $stock . '","price":"' . $price . '","item_name":"' . $item_name . '","fx_fee_rate":"' . $fx_fee_rate . '","itemid":"' . $itemid . '","skus":' . json_encode ( $skus ) . ',"merchant_code":"' . $merchant_code . '"}',
				"public" => parent::buildPublicValue ( 'vdian.item.update' ) 
		) );
	}
	/**
	 * 添加商品型号
	 * http://wiki.open.weidian.com/index.php?title=%E6%B7%BB%E5%8A%A0%E5%95%86%E5%93%81%E5%9E%8B%E5%8F%B7
	 *
	 * @param string $itemid        	
	 * @param array $skus        	
	 * @return HttpResponse
	 */
	public function addProductSKU($itemid, array $skus) {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"skus":' . json_encode ( $skus ) . ',"itemid":"' . $itemid . '"}',
				"public" => parent::buildPublicValue ( 'vdian.item.sku.add' ) 
		) );
	}
	
	/**
	 * 更新商品型号
	 * http://wiki.open.weidian.com/index.php?title=%E6%9B%B4%E6%96%B0%E5%95%86%E5%93%81%E5%9E%8B%E5%8F%B7
	 *
	 * @param string $itemid        	
	 * @param array $skus        	
	 * @return HttpResponse
	 */
	public function updateProductSKU($itemid, array $skus) {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"skus":' . json_encode ( $skus ) . ',"itemid":"' . $itemid . '"}',
				"public" => parent::buildPublicValue ( 'vdian.item.sku.update' ) 
		) );
	}
	/**
	 * 删除商品型号
	 * http://wiki.open.weidian.com/index.php?title=%E5%88%A0%E9%99%A4%E5%95%86%E5%93%81%E5%9E%8B%E5%8F%B7
	 *
	 * @param string $itemid        	
	 * @param array<string> $skus        	
	 * @return HttpResponse
	 */
	public function deleteProductSKU($itemid, array $skus) {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"skus":' . json_encode ( $skus ) . ',"itemid":"' . $itemid . '"}',
				"public" => parent::buildPublicValue ( 'vdian.item.sku.delete' ) 
		) );
	}
	/**
	 * 获取商品分类
	 * http://wiki.open.weidian.com/index.php?title=%E8%8E%B7%E5%8F%96%E5%95%86%E5%93%81%E5%88%86%E7%B1%BB
	 *
	 * @return HttpResponse
	 */
	public function getProductCate() {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => "{}",
				"public" => parent::buildPublicValue ( 'vdian.shop.cate.get' ) 
		) );
	}
	/**
	 * 新增商品分类
	 * http://wiki.open.weidian.com/index.php?title=%E6%96%B0%E5%A2%9E%E5%95%86%E5%93%81%E5%88%86%E7%B1%BB
	 * @return HttpResponse
	 */
	public function addProductCate(array $cates) {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"cates":' . json_encode ( $cates ) . '}',
				"public" => parent::buildPublicValue ( 'vdian.shop.cate.add' ) 
		) );
	}
	/**
	 * 编辑商品分类
	 * http://wiki.open.weidian.com/index.php?title=%E7%BC%96%E8%BE%91%E5%95%86%E5%93%81%E5%88%86%E7%B1%BB
	 *
	 * @param array $cates        	
	 * @return HttpResponse
	 */
	public function editProductCate(array $cates) {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"cates":' . json_encode ( $cates ) . '}',
				"public" => parent::buildPublicValue ( 'vdian.shop.cate.update' ) 
		) );
	}
	/**
	 * 删除商品分类
	 * http://wiki.open.weidian.com/index.php?title=%E5%88%A0%E9%99%A4%E5%95%86%E5%93%81%E5%88%86%E7%B1%BB
	 *
	 * @param unknown $cate_id    
	 * @return true or false    	
	 */
	public function deleteProductCate($cate_id) {
		$response = NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"cate_id":' . $cate_id . '}',
				"public" => parent::buildPublicValue ( 'vdian.shop.cate.delete' ) 
		) );
		if ($response->getDataAsObject ()->status->status_code == 0) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * 设置商品的分类
	 * http://wiki.open.weidian.com/index.php?title=%E8%AE%BE%E7%BD%AE%E5%95%86%E5%93%81%E7%9A%84%E5%88%86%E7%B1%BB
	 *
	 * @param unknown $itemids        	
	 * @param unknown $cate_ids        	
	 * @return HttpResponse
	 */
	public function setProductCate($itemids, $cate_ids) {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"item_ids":' . json_encode ( $itemids ) . ',"cate_ids":' . json_encode ( $cate_ids ) . '}',
				"public" => parent::buildPublicValue ( 'vdian.item.cate.set' ) 
		) );
	}
	/**
	 * 取消商品的分类
	 * http://wiki.open.weidian.com/index.php?title=%E5%8F%96%E6%B6%88%E5%95%86%E5%93%81%E7%9A%84%E5%88%86%E7%B1%BB
	 *
	 * @param unknown $itemid        	
	 * @param unknown $cate_ids   
	 * @return true or false     	
	 */
	public function cancelProductCate($itemid, $cate_ids) {
		$response = NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"itemid":"' . $itemid . '","cate_ids":' . json_encode ( $cate_ids ) . '}',
				"public" => parent::buildPublicValue ( 'vdian.item.cate.cancel' ) 
		) );
		if ($response->getDataAsObject ()->status->status_code == 0) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * 商品上下架
	 * http://wiki.open.weidian.com/index.php?title=%E5%95%86%E5%93%81%E4%B8%8A%E4%B8%8B%E6%9E%B6
	 *
	 * @param unknown $itemid        	
	 * @param unknown $opt     
	 * @return true or false   	
	 */
	public function productOnSale($itemid, $opt) {
		$response = NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"itemid":' . $itemid . ',"opt":' . $opt . '}',
				"public" => parent::buildPublicValue ( 'weidian.item.onSale' ) 
		) );
		$result = $response->getDataAsObject ();
		return $result->status->status_code == 0;
	}
}

?>