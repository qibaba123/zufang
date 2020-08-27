<?php
class OrderClientApi extends ApiBase {
	public function __construct($access_token) {
		parent::__construct ( $access_token );
	}
	/**
	 * 获取订单列表
	 * http://wiki.open.weidian.com/index.php?title=%E8%8E%B7%E5%8F%96%E8%AE%A2%E5%8D%95%E5%88%97%E8%A1%A8
	 *
	 * @param unknown $order_type        	
	 * @param unknown $page_num        	
	 * @param unknown $add_start        	
	 * @param unknown $add_end        	
	 * @return HttpResponse
	 */
	public function getOrderList($order_type, $page_num, $add_start, $add_end) {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"page_num":' . $page_num . ',"order_type":"' . $order_type . '","add_start":"' . $add_start . '","add_end":"' . $add_end . '"}',
				"public" => parent::buildPublicValue ( "vdian.order.list.get" ) 
		) );
	}
	/**
	 * 获取订单详情
	 * http://wiki.open.weidian.com/index.php?title=%E8%8E%B7%E5%8F%96%E8%AE%A2%E5%8D%95%E8%AF%A6%E6%83%85
	 *
	 * @return HttpResponse
	 */
	public function getOrderDetails($order_id) {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"order_id":"' . $order_id . '"}',
				"public" => parent::buildPublicValue ( "vdian.order.get" ) 
		) );
	}
	/**
	 * 订单发货
	 * http://wiki.open.weidian.com/index.php?title=%E8%AE%A2%E5%8D%95%E5%8F%91%E8%B4%A7
	 *
	 * @param unknown $order_id        	
	 * @param unknown $express_type        	
	 * @param unknown $express_no        	
	 * @param string $express_custom  
	 * @return HttpResponse      	
	 */
	public function orderDeliver($order_id, $express_type, $express_no, $express_custom = "", $express_custom = "") {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"order_id":"' . $order_id . '","express_type":"' . $express_type . '","express_no":"' . $express_no . '","express_custom":"' . $express_custom . '"}',
				"public" => parent::buildPublicValue ( "vdian.order.deliver" ) 
		) );
	}
	/**
	 * 修改物流信息
	 * http://wiki.open.weidian.com/index.php?title=%E4%BF%AE%E6%94%B9%E7%89%A9%E6%B5%81%E4%BF%A1%E6%81%AF
	 *
	 * @param unknown $order_id        	
	 * @param unknown $express_type        	
	 * @param unknown $express_no        	
	 * @param string $express_note        	
	 * @param string $express_custom       
	 * @return HttpResponse 	
	 */
	public function modifyExpress($order_id, $express_type, $express_no, $express_note = "", $express_custom = "") {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"order_id":"' . $order_id . '","express_type":"' . $express_type . '","express_no":"' . $express_no . '","express_note":"' . $express_note . '","express_custom":"' . $express_custom . '"}',
				"public" => parent::buildPublicValue ( "vdian.order.express.modify" ) 
		) );
	}
	/**
	 * 修改订单价格
	 * http://wiki.open.weidian.com/index.php?title=%E4%BF%AE%E6%94%B9%E8%AE%A2%E5%8D%95%E4%BB%B7%E6%A0%BC
	 *
	 * @param unknown $order_id        	
	 * @param unknown $total_items_price        	
	 * @param unknown $express_price  
	 * @return HttpResponse      	
	 */
	public function modifyOrderPrice($order_id, $total_items_price, $express_price) {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"order_id":"' . $order_id . '","total_items_price":"' . $total_items_price . '","express_price":"' . $express_price . '"}',
				"public" => parent::buildPublicValue ( "vdian.order.modify" ) 
		) );
	}
	
	/**
	 * 订单退款
	 * http://wiki.open.weidian.com/index.php?title=%E8%AE%A2%E5%8D%95%E9%80%80%E6%AC%BE
	 *
	 * @param unknown $order_id        	
	 * @param unknown $is_accept     
	 * @return HttpResponse   	
	 */
	public function orderRefundAccept($order_id, $is_accept) {
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => '{"order_id":"' . $order_id . '","is_accept":"' . $is_accept . '"}',
				"public" => parent::buildPublicValue ( "vdian.order.refund.accept" ) 
		) );
	}
}

?>