<?php

class App_Controller_Wxapp_FahuoyiController extends Libs_Mvc_Controller_FrontBaseController{


    public function __construct() {
        parent::__construct();

    }

    public function indexAction(){
        $v       = $this->request->getParam('v');
        $method  = $this->request->getParam('method');
        $app_key = $this->request->getParam('app_key');
        $format  = $this->request->getParam('format');
        $timestamp   = $this->request->getParam('timestamp');
        $sign_method = $this->request->getParam('sign_method');
        $sign        = $this->request->getParam('sign');
        $access_token= $this->request->getParam('access_token');
//        Libs_Log_Logger::outputLog($app_key,'fahuoyi.log');
//        Libs_Log_Logger::outputLog($sign,'fahuoyi.log');
        $time_type     = $this->request->getStrParam('time_type');
        $time_from     = $this->request->getParam('time_from');
        $time_to       = $this->request->getParam('time_to');
        $page_size     = $this->request->getIntParam('page_size');
        $page_no       = $this->request->getIntParam('page_no');
        $status        = $this->request->getStrParam('status');
        $order_id        = $this->request->getStrParam('order_id');
        $is_part_ship    = $this->request->getParam('is_part_ship');
        $order_item_ids  = $this->request->getParam('order_item_ids');
        $waybill_no      = $this->request->getParam('waybill_no');
        $logistics_code  = $this->request->getParam('logistics_code');
        $paramArr = array(
            'v' => $v,
            'method' => $method,
            'app_key' => $app_key,
            'format'  => $format,
            'timestamp' => $timestamp,
            'sign_method' => $sign_method,
            'access_token' => $access_token,
            'time_type'    => $time_type,
            'time_from'    => $time_from,
            'time_to'      => $time_to,
            'page_size'    => $page_size,
            'page_no'      => $page_no,
            'status'       => $status,
            'order_id'     => $order_id,
            'is_part_ship' => $is_part_ship,
            'order_item_ids' => $order_item_ids,
            'waybill_no'     => $waybill_no,
            'logistics_code' => $logistics_code
        );
        $signnew = $this->calcSign($paramArr,123456);
        //Libs_Log_Logger::outputLog($sign,'fahuoyi.log');
        //Libs_Log_Logger::outputLog($signnew,'fahuoyi.log');
        if($sign != $signnew){
            $data = array(
                'error_code' => 103,
                'error_message' => '参数有误，原因：密码不正确'
            );
           echo json_encode($data);exit;
        }
        // if($sign){
        //    $password = base64_encode('123456');
        //    Libs_Log_Logger::outputLog($password,'fahuoyi.log');
        //   if($sign != $password){
        //       $data = false;
        //     echo json_encode($data);
        //}
        // }
//Libs_Log_Logger::outputLog( $method,'fahuoyi.log');
        if($method == 'get.products'){
            $this->get_products();
        }elseif($method == 'get.orders'){//获取多个订单接口
            $data = $this->get_orders($time_type,$time_from,$time_to,$page_size,$page_no,$status);
        }elseif($method == 'get.order'){//获取单个订单接口
            $order_id  = $this->request->getParam('order_id');
            $data = $this->get_orders($time_type,$time_from,$time_to,$page_size,$page_no,$status,$order_id);
        }elseif($method == 'ship.order'){
            $data  = $this->ship_order($order_id,$is_part_ship,$order_item_ids,$waybill_no,$logistics_code);
        }elseif($method == 'reship.order'){
            $data  = $this->ship_order($order_id,$is_part_ship,$order_item_ids,$waybill_no,$logistics_code);
        }
      //Libs_Log_Logger::outputLog( $time_type,'fahuoyi.log');
      //Libs_Log_Logger::outputLog( $time_from,'fahuoyi.log');
     // Libs_Log_Logger::outputLog( $time_to,'fahuoyi.log');
        Libs_Log_Logger::outputLog( json_encode($data),'fahuoyi.log');
        // plum_msg_dump(json_encode($data),1);
        echo json_encode($data);
        //$this->displayJson($data);
    }



    public function calcSign($paramArr,$appSecret) {
        ksort($paramArr);
        $str = "";
        foreach ($paramArr as $key => $value) {
            if($key != '' && $value != ''){
                $str.= $key.$value;
            }
        }
        $str = $appSecret . $str . $appSecret;
        $sign = strtoupper(md5($str));
        return $sign;
    }

    //订单发货
    public function ship_order($order_id,$is_part_ship,$order_item_ids,$waybill_no,$logistics_code){
//        $order_id        = $this->request->getStrParam('order_id');
//        $is_part_ship    = $this->request->getParam('is_part_ship');
//        $order_item_ids  = $this->request->getParam('order_item_ids');
//        $waybill_no      = $this->request->getParam('waybill_no');
//        $logistics_code  = $this->request->getParam('logistics_code');
        if($is_part_ship == true){
            $data['success'] = false;
        }else{
            $trade_model = new App_Model_Trade_MysqlTradeStorage();
            $update['t_company_code']    = $logistics_code;
            $update['t_express_code']    = $waybill_no;
            $update['t_express_time']    = time();
            $update['t_status']          = 4;
            $update['t_need_express']    = 1;
            $ret = $trade_model->updateById($update,$order_id);
            if($ret){
                $data['success'] = true;
            }else{
                $data['success'] = false;
            }

        }
        return $data;
    }

    //获取多个订单
    public function get_orders($time_type,$time_from,$time_to,$page_size,$page_no,$status,$id = 0){
//        $time_type     = $this->request->getStrParam('time_type');
//        $time_from     = $this->request->getParam('time_from');
//        $time_to       = $this->request->getParam('time_to');
//        $page_size     = $this->request->getIntParam('page_size');
//        $page_no       = $this->request->getIntParam('page_no');
//        $status        = $this->request->getStrParam('status');
        $time_from     = strtotime($time_from);
        $time_to       = strtotime($time_to);
        //   Libs_Log_Logger::outputLog($page_no,'fahuoyi.log');
        //    Libs_Log_Logger::outputLog($page_size,'fahuoyi.log');
        //  Libs_Log_Logger::outputLog($time_type,'fahuoyi.log');
        //  Libs_Log_Logger::outputLog($time_from,'fahuoyi.log');
        //  Libs_Log_Logger::outputLog($time_to,'fahuoyi.log');
        //  Libs_Log_Logger::outputLog($status,'fahuoyi.log');
        $trade_model   = new App_Model_Trade_MysqlTradeStorage();
        $page          = $page_no - 1;
        $count         = $page_size;
        $index         = $page*$count;
        $status_arr    = explode(',',$status);
        if(in_array('wait_buyer_pay',$status_arr)){
            $type[]  = 1;
        }elseif(in_array('wait_seller_ship',$status_arr)){
            $type[]  = 3;
        }elseif(in_array('shipped',$status_arr)){
            $type[]  = 4;
        }elseif(in_array('finished',$status_arr)){
            $type[]  = 6;
        }elseif(in_array('canceled',$status_arr)){
            $type[]  = 7;
        }
        $status = array(
            1 => 'wait_buyer_pay' ,
            3 => 'wait_seller_ship',
            4 => 'shipped',
            6 => 'finished',
            7 => 'canceled',

        );
        $shipping_type = array(
            1 => 'seller_delivery',
            2 => 'self_pickup',
            3 => 'express',
        );
        $refund_status = array(
            1 => 'seller_delivery',
            2 => 'express',
            3 => 'self_pickup',
        );
        if($id){
            $where[]       = array('name'=>"t_id",'oper'=>'=','value'=>$id);
            $trade_list    = $trade_model->getTradeListLight($where,$index,$count,array('t_pay_time'=>'DESC'));
            $val           = $trade_list[0];
            if($val){
                $extra  = json_decode($val['t_remark_extra'],true);
                $goods_model = new App_Model_Goods_MysqlGoodsStorage();
                //$goodsarr    = json_decode($val['t_extra_data'],true);
                $order_model   = new App_Model_Trade_MysqlTradeOrderStorage();
                $owhere[]      = array('name'=>"to_t_id",'oper'=>'=','value'=>$val['t_id']);
                $order_list    = $order_model->getList($owhere,0,0,array());
                foreach($order_list as $v){
                    //$good = $goods_model->getRowById($val);
                    $where = array();
                    $where[]      = array('name'=>"to_t_id",'oper'=>'=','value'=>$val['t_id']);
                    $where[]      = array('name'=>"to_g_id",'oper'=>'=','value'=>$v['to_g_id']);
                    $row          = $order_model->getTradeRow($where);
                    //  Libs_Log_Logger::outputLog($row,'wxpay.log');
                    if($row['t_feedback'] != 0){
                        if($row['t_fd_status'] == 1){
                            $refund_status = 'wait_seller_agree';
                        }elseif($row['t_fd_status'] == 2){
                            $refund_status = 'wait_buyer_return_goods';
                        }elseif($row['t_fd_status'] == 3 && $row['t_fd_result'] == 2){
                            $refund_status = 'success';
                        }elseif ($row['t_fd_status'] == 3 && $row['t_fd_result'] == 1){
                            $refund_status = 'eller_refuse_buyer';
                        }elseif ($row['t_fd_status'] == 3 && $row['t_fd_result'] == 3){
                            $refund_status = 'closed';
                        }
                    }else{
                        $refund_status = NULL;
                    }
                    if($row['t_status'] == 8){
                        if($row['t_express_time']) {
                            $t_status = 'shipped';
                        }else{
                            $t_status = 'wait_seller_ship';
                        }
                    }else{
                        $t_status =  $status[$row['t_status']];
                    }
                    // Libs_Log_Logger::outputLog($t_status,'fahuoyi.log');
                    $order_items[] = array(
                        'id'     => $row['g_id'],
                        'status' => $t_status,
                        'title' => $row['g_name'],
                        'weight' =>$row['g_goods_weight_type'] == 1?($row['to_num']*$row['g_goods_weight'])/1000:($row['to_num']*$row['g_goods_weight']),
                        'product_id' => $row['g_id'] ,
                        'product_external_id' => NULL,
                        'sku_id' => NULL,
                        'sku_external_id' => NULL,
                        'sku_properties' => $row['gf_name'].$row['gf_name2'].$row['gf_name3'],
                        'image_url' => $row['g_cover']?'https://jdfs.jixuantiant.com'.$row['g_cover']:NULL,
                        'price' => $row['to_price'],
                        'quantity' => $row['to_num'],
                        'discounts' => 0,
                        'adjustments' => 0,
                        'is_gift' => false,
                        'refund_status' => $refund_status,

                    );

                }
                $data = array(
                    'id'  => $val['t_id'],
                    'consignee_name' => $val['ma_name'],
                    'province'       => $val['ma_province'],
                    'city'           => $val['ma_city'],
                    'district'       => $val['ma_zone'],
                    'town'           => NULL,
                    'street'         => $val['ma_detail'],
                    'zip_code'       => $val['ma_post'],
                    'telephone'      => NULL,
                    'mobile'         => $val['ma_phone'],
                    'status'         => $t_status,
                    'payment_type'   => 'online',
                    'order_time'     =>   $val['t_create_time']?date('Y-m-d H:i:s',$val['t_create_time']):NULL,
                    'payment_time'     => $val['t_pay_time']?date('Y-m-d H:i:s',$val['t_pay_time']):NULL,
                    'shipping_time'    => $val['t_express_time']?date('Y-m-d H:i:s',$val['t_express_time']):NULL,
                    'shipping_type'    => $shipping_type[$val['t_express_method']],
                    'end_time'         => $val['t_finish_time']?date('Y-m-d H:i:s',$val['t_finish_time']):NULL,
                    'modified_time'    => $val['t_pay_time']?date('Y-m-d H:i:s',$val['t_pay_time']):NULL,
                    'payments'         => $val['t_goods_fee'],
                    'discounts'        => $val['t_discount_fee'],
                    'shipping_cost'    => $val['t_post_fee'],
                    'buyer_username'   => $val['t_buyer_nick'],
                    'buyer_remarks'    => $val['t_remark_extra']?$extra['value']:NULL,
                    'seller_flag'      => 1,
                    'seller_remarks'   => $val['t_express_note'],
                    'nvoice_type'      => 1,
                    'nvoice_name'      => NULL,
                    'invoice_content'  => NULL,
                    'shop_id'          => 'JDYX_DEV',
                    'order_items'      => $order_items
                );
            }else{
                 $data = array(
                'error_code' => 201,
                'error_message' => '订单不存在'
            );
            }

        }else{
            if($time_type == 'created'){
                $where[]       = array('name'=>"t_create_time",'oper'=>'>=','value'=>$time_from);
                $where[]       = array('name'=>"t_create_time",'oper'=>'<','value'=>$time_to);
            }elseif($time_type == 'modified'){
                //$where[]       = array('name'=>"t_create_time",'oper'=>'>=','value'=>$time_from);
               $where[]       = array('name'=>"t_create_time",'oper'=>'<','value'=>$time_to);
            }
            if($type){
                $where[]       = array('name'=>"t_status",'oper'=>'in','value'=>$type);
            }
         //  Libs_Log_Logger::outputLog( $where,'fahuoyi.log');
            $count         = $trade_model->getCount($where);
            $data['count'] = (int)$count;
            $trade_list    = $trade_model->getTradeListLight($where,$index,$count,array('t_pay_time'=>'DESC'));
           // Libs_Log_Logger::outputLog( $trade_list,'fahuoyi.log');
            if($trade_list){
                foreach ($trade_list as $val){
                    $extra  = json_decode($val['t_remark_extra'],true);
                    $goods_model = new App_Model_Goods_MysqlGoodsStorage();
                    //$goodsarr    = json_decode($val['t_extra_data'],true);
                    $order_model   = new App_Model_Trade_MysqlTradeOrderStorage();
                    $owhere[]      = array('name'=>"to_t_id",'oper'=>'=','value'=>$val['t_id']);
                    $order_list    = $order_model->getList($owhere,0,0,array());
                    foreach($order_list as $v){
                        //$good = $goods_model->getRowById($val);
                        $where = array();
                        $where[]      = array('name'=>"to_t_id",'oper'=>'=','value'=>$val['t_id']);
                        $where[]      = array('name'=>"to_g_id",'oper'=>'=','value'=>$v['to_g_id']);
                        $row          = $order_model->getTradeRow($where);
                        //  Libs_Log_Logger::outputLog($row,'wxpay.log');
                        if($row['t_feedback'] != 0){
                            if($row['t_fd_status'] == 1){
                                $refund_status = 'wait_seller_agree';
                            }elseif($row['t_fd_status'] == 2){
                                $refund_status = 'wait_buyer_return_goods';
                            }elseif($row['t_fd_status'] == 3 && $row['t_fd_result'] == 2){
                                $refund_status = 'success';
                            }elseif ($row['t_fd_status'] == 3 && $row['t_fd_result'] == 1){
                                $refund_status = 'eller_refuse_buyer';
                            }elseif ($row['t_fd_status'] == 3 && $row['t_fd_result'] == 3){
                                $refund_status = 'closed';
                            }
                        }else{
                            $refund_status = NULL;
                        }
                        if($val['t_status']==8){
                            if($val['t_express_time']) {
                                $t_status = 'shipped';
                            }else{
                                $t_status = 'wait_seller_ship';
                            }
                        }else{
                            $t_status =  $status[$val['t_status']];
                        }
                        $order_items[] = array(
                            'id'     => $row['g_id'],
                            'status' => $t_status,
                            'title' => $row['g_name'],
                            'weight' =>$row['g_goods_weight_type'] == 1?($row['to_num']*$row['g_goods_weight'])/1000:($row['to_num']*$row['g_goods_weight']),
                            'product_id' => $row['g_id'] ,
                            'product_external_id' => NULL,
                            'sku_id' => NULL,
                            'sku_external_id' => NULL,
                            'sku_properties' => $row['gf_name'].$row['gf_name2'].$row['gf_name3'],
                            'image_url' => $row['g_cover']?'https://jdfs.jixuantiant.com'.$row['g_cover']:NULL,
                            'price' => $row['to_price'],
                            'quantity' => $row['to_num'],
                            'discounts' => 0,
                            'adjustments' => 0,
                            'is_gift' => false,
                            'refund_status' => $refund_status,

                        );

                    }
                    $data['orders'][] = array(
                        'id'  => $val['t_id'],
                        'consignee_name' => $val['ma_name'],
                        'province'       => $val['ma_province'],
                        'city'           => $val['ma_city'],
                        'district'       => $val['ma_zone'],
                        'town'           => NULL,
                        'street'         => $val['ma_detail'],
                        'zip_code'       => $val['ma_post'],
                        'telephone'      => NULL,
                        'mobile'         => $val['ma_phone'],
                        'status'         => $t_status,
                        'payment_type'   => 'online',
                        'order_time'     =>   $val['t_create_time']?date('Y-m-d H:i:s',$val['t_create_time']):NULL,
                        'payment_time'     => $val['t_pay_time']?date('Y-m-d H:i:s',$val['t_pay_time']):NULL,
                        'shipping_time'    => $val['t_express_time']?date('Y-m-d H:i:s',$val['t_express_time']):NULL,
                        'shipping_type'    => $shipping_type[$val['t_express_method']],
                        'end_time'         => $val['t_finish_time']?date('Y-m-d H:i:s',$val['t_finish_time']):NULL,
                        'modified_time'    => $val['t_pay_time']?date('Y-m-d H:i:s',$val['t_pay_time']):NULL,
                        'payments'         => $val['t_goods_fee'],
                        'discounts'        => $val['t_discount_fee'],
                        'shipping_cost'    => $val['t_post_fee'],
                        'buyer_username'   => $val['t_buyer_nick'],
                        'buyer_remarks'    => $val['t_remark_extra']?$extra['value']:NULL,
                        'seller_flag'      => 1,
                        'seller_remarks'   => $val['t_express_note'],
                        'nvoice_type'      => 1,
                        'nvoice_name'      => NULL,
                        'invoice_content'  => NULL,
                        'shop_id'          => 'JDYX_DEV',
                        'order_items'      => $order_items
                    );

                }
            }else{
                $data['orders'] = array();
                $data['count']  = 0;
            }
        }



        return $data;
    }


    //获取商品列表
    public function get_products(){
        $modified_from = $this->request->getParam('modified_from');
        $modified_to   = $this->request->getParam('modified_to');
        $page_size     = $this->request->getParam('page_size');
        $page_no       = $this->request->getParam('page_no');
        $page          = $page_no - 1;
        $count         = $page_size;
        $index         = $page*$count;
        $trade_model   = new App_Model_Trade_MysqlTradeStorage();
        $where[]       = array('name'=>"t_pay_time",'oper'=>'>=','value'=>$modified_from);
        $where[]       = array('name'=>"t_pay_time",'oper'=>'<','value'=>$modified_to);
        $trade_list    = $trade_model->getList($where,$index,$count,array('t_update_time'=>'DESC'));
        if($trade_list){
            foreach($trade_list as $val){
                $data['products'] = array(
                    'id'    => $val['t_id'],
                    'url'   => '',
                    'title' => $val['t_title'],
                    'external_id' => '',
                    'picture'     => $val['t_pic']?$this->dealImagePath($val['t_pic']):'',
                    'status'      => $val['t_deleted']?'onSale':'deleted',
                    'creation_time' => $val['t_create_time'],
                    'modified_time'  => ''
                );
            }
        }else{
            $data['products'] = array();
        }
    }



}
