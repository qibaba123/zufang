<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2018/12/14
 * Time: 2:13 PM
 * @desc 微信小程序购物单相关处理
 * @link https://developers.weixin.qq.com/miniprogram/introduction/widget/order/
 */
class App_Plugin_Weixin_MallWidget extends App_Plugin_Weixin_WxxcxClient {

    public function __construct($sid){
        parent::__construct($sid);
    }
    /*
     * 检查访问token
     */
    private function _check_token() {

    }
    /*
     * 导入或添加已支付完成的订单
     * @link https://developers.weixin.qq.com/miniprogram/introduction/widget/order/quickstart/orderlist/import.html
     */
    public function importOrder($data) {
        $this->_check_token();

        $req_url    = "https://api.weixin.qq.com/mall/importorder?action=add-order&access_token={$this->access_token}";
        $params     = array(
            'order_list'    => is_array($data) ? $data : [$data],
        );
        $result = Libs_Http_Client::post($req_url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 更新已支付订单的状态
     * @link https://developers.weixin.qq.com/miniprogram/introduction/widget/order/quickstart/orderlist/update.html
     */
    public function updateOrder($data) {
        $this->_check_token();

        $req_url    = "https://api.weixin.qq.com/mall/importorder?action=update-order&access_token={$this->access_token}";
        $params     = array(
            'order_list'    => is_array($data) ? $data : [$data],
        );
        $result = Libs_Http_Client::post($req_url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 删除用户"已购订单"中的订单
     * @link https://developers.weixin.qq.com/miniprogram/introduction/widget/order/quickstart/orderlist/delete.html
     * @param string $open_id 用户openID
     * @param string $order_id 订单ID
     */
    public function deleteOrder($open_id, $order_id) {
        $this->_check_token();

        $req_url    = "https://api.weixin.qq.com/mall/deleteorder?access_token={$this->access_token}";
        $params     = array(
            'user_open_id'  => $open_id,
            'order_id'      => $order_id,
        );
        $result = Libs_Http_Client::post($req_url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }

    /*
     * 导入或添加购物车中的商品到想买清单
     * @link https://developers.weixin.qq.com/miniprogram/introduction/widget/order/quickstart/cartlist/import.html
     *
     * @param array|object $data
     */
    public function importProduct($open_id, $data) {
        $this->_check_token();

        $req_url    = "https://api.weixin.qq.com/mall/addshoppinglist?access_token={$this->access_token}";
        $params     = array(
            'user_open_id'  => $open_id,
            'sku_product_list'  => is_array($data) ? $data : [$data],
        );
        $result = Libs_Http_Client::post($req_url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 从用户的"想买清单"中删除商品
     * @link https://developers.weixin.qq.com/miniprogram/introduction/widget/order/quickstart/cartlist/delete.html
     */
    public function deleteProduct($open_id, $data) {
        $this->_check_token();

        $req_url    = "https://api.weixin.qq.com/mall/deleteshoppinglist?access_token={$this->access_token}";
        $params     = array(
            'user_open_id'  => $open_id,
            'sku_product_list'  => is_array($data) ? $data : [$data],
        );
        $result = Libs_Http_Client::post($req_url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }

    /*
     * 更新商品信息
     * @link https://developers.weixin.qq.com/miniprogram/introduction/widget/order/quickstart/goods/update.html
     */
    public function updateProduct($data) {
        $this->_check_token();

        $req_url    = "https://api.weixin.qq.com/mall/importproduct?access_token={$this->access_token}";
        $params     = array(
            'product_list'  => is_array($data) ? $data : [$data],
        );
        $result = Libs_Http_Client::post($req_url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 查询商品信息
     * @link https://developers.weixin.qq.com/miniprogram/introduction/widget/order/quickstart/orderlist/import.html
     */
    public function queryProduct($data) {
        $this->_check_token();

        $req_url    = "https://api.weixin.qq.com/mall/queryproduct?access_token={$this->access_token}&type=batchquery";
        $params     = array(
            'key_list'  => is_array($data) ? $data : [$data],
        );
        $result = Libs_Http_Client::post($req_url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 设置小程序购物车页面路径
     * @link https://developers.weixin.qq.com/miniprogram/introduction/widget/order/quickstart/manage/shoppingcart_path.html
     */
    public function setCartPath($path) {
        $this->_check_token();

        $req_url    = "https://api.weixin.qq.com/mall/brandmanage?action=set_shoppingcart_path&access_token={$this->access_token}";
        $params     = array(
            'shoppingcart_path'  => $path,
        );
        $result = Libs_Http_Client::post($req_url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 对输出结果进行格式化处理
     * @link https://smartprogram.baidu.com/docs/develop/third/error/
     */
    private function _format_response_output($res) {
        $code   = array();

        if ($res['errcode'] != 0) {//errno != 0
            $code['errcode']    = $res['errcode'];
            $code['errmsg']     = $res['errmsg'];
        } else {
            $code['errcode']    = 0;
            $code['errmsg']     = '获取成功';
        }

        unset($res['errcode']);
        unset($res['errmsg']);

        $code['data']   = empty($res) ? null : $res;

        return $code;
    }
}