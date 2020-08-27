<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 16/12/7
 * Time: 上午11:30
 * 订单打印相关数据
 */

class App_Helper_Print
{
    public $sid;
    public $shop;
    public function __construct($sid)
    {
        $this->sid  = $sid;
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage($sid);
        $this->shop = $shop_model->getRowById($sid);
    }
    //@params $region_manager 区域合伙人id
    //@params $rg_choise 社区团购自动打印的订单筛选打印机状态
    public function printOrder($number,$sn='',$esId = 0,$region_manager=0,$rg_choice=false){

        $feie_model = new App_Model_Feie_MysqlFeieListStorage($this->sid);
        if($sn){ //单个打印
            $list[0] = $feie_model->findRowBySidSn($sn);
        }else {
            // 获取店铺的打印机列表
            $list = $feie_model->findListBySid($esId,$region_manager,1,$rg_choice);
        }

        $error=[];
        $num = 0;
        if($list){
            // 获取打印机配置
            $print_storage = new App_Model_Print_MysqlPrintCfgStorage($this->sid);
            foreach ($list as $val){
                $printCfg = $print_storage->findRowBySid(array(),$val['afl_es_id']);
                $str = self::_order_print_str($number,$printCfg,$val['afl_kind1']);
                if($str){
                    $feie_storage = new App_Plugin_Feieyun_Feieyun($this->sid);
                    if($val['afl_automatic'] ==1 || $sn){
                        if($printCfg && $printCfg['apc_print_num']){
                            for($i=1;$i<=$printCfg['apc_print_num'];$i++){
                                $ret = $feie_storage->printOrder($val['afl_sn'],$str);
                                if(is_array($ret) && $ret['ret'] == 0 ){
                                    $num+=1;
                                }else{
                                    $error=$ret;
                                }
                            }
                        }else{
                            $ret = $feie_storage->printOrder($val['afl_sn'],$str);
                            if(is_array($ret) && $ret['ret'] == 0 ){
                                $num+=1;
                            }else{
                                $error=$ret;
                            }
                        }
                    }
                }
            }
        }
        if($num)
            return $num;
        else
            return $error;
    }

    /*
     * 批量打印订单
     */
    public function printOrderList($tradeList,$sn='',$esId = 0){

        $feie_model = new App_Model_Feie_MysqlFeieListStorage($this->sid);
        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $applet     = $applet_model->findShopCfg();

        if($sn){ //单个打印
            $list[0] = $feie_model->findRowBySidSn($sn);
        }
//        else {
//            // 获取店铺的打印机列表
//            $list = $feie_model->findListBySid($esId);
//        }
        $num = 0;
        if($list){
            // 获取打印机配置
            $print_storage = new App_Model_Print_MysqlPrintCfgStorage($this->sid);
            $feie_storage = new App_Plugin_Feieyun_Feieyun($this->sid);
            foreach ($list as $val){
                $printCfg = $print_storage->findRowBySid(array(),$val['afl_es_id']);
                foreach ($tradeList as $trade){
                    $str = self::_order_print_str_trade($trade,$printCfg,$applet);
                    if($str){
                        $ret = $feie_storage->printOrder($val['afl_sn'],$str);
                        if(is_array($ret) && $ret['ret'] == 0 ){
                            $num+=1;
                        }
                    }
                }
            }
        }
        return $num;
    }


    /*
     * 打印拼团成功订单
     */
    public function printGroupOrder($joiner,$sn = '',$esId){
        $feie_model = new App_Model_Feie_MysqlFeieListStorage($this->sid);
        if($sn){ //单个打印
            $list[0] = $feie_model->findRowBySidSn($sn);
        }else {
            // 获取店铺的打印机列表
            $list = $feie_model->findListBySid($esId,false);
        }
        $num = 0;
        if($list){
            $print_storage = new App_Model_Print_MysqlPrintCfgStorage($this->sid);
            foreach ($list as $val){
                foreach ($joiner as $item){
                    $printCfg = $print_storage->findRowBySid(array(),$val['afl_es_id']);
                    $str = self::_order_print_str($item['gm_tid'],$printCfg);
                    if($str){
                        $feie_storage = new App_Plugin_Feieyun_Feieyun();
                        if($val['afl_automatic'] ==1 || $sn){
                            if($printCfg && $printCfg['apc_print_num']){
                                for($i=1;$i<=$printCfg['apc_print_num'];$i++){
                                    $ret = $feie_storage->printOrder($val['afl_sn'],$str);

                                    if(is_array($ret) && $ret['ret'] == 0 ){
                                        $num+=1;
                                    }
                                }
                            }else{
                                $ret = $feie_storage->printOrder($val['afl_sn'],$str);
                                if(is_array($ret) && $ret['ret'] == 0 ){
                                    $num+=1;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $num;
    }

    /*
     * 订单打印数据,不需要再查出订单
     */
    private function _order_print_str_trade($trade,$printCfg,$applet,$kind1 = 0){
        if($trade){
            //获取交易订单商品
            $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $order = $order_model->fetchOrderListByTid($trade['t_id']);

            if($printCfg && $printCfg['apc_print_type']==2){
                if($applet['ac_type']==4 && $trade['t_independent_mall'] != 1){
                    $str = $this->_meal_order_wide($trade,$order,$applet,$kind1);
                }else if($applet['ac_type']==7){
                    $str = $this->_hotel_order_wide($trade,$order,$applet);
                }else{   //不存在小程序的则全部是商城订单
                    $str = $this->_mall_order_wide($trade,$order,$applet);
                }
            }else{
                if($applet['ac_type']==4 && $trade['t_independent_mall'] != 1){
                    $str = $this->_meal_order($trade,$order,$applet,$kind1);
                }else if($applet['ac_type']==7){
                    $str = $this->_hotel_order($trade,$order,$applet);
                } else{   //不存在小程序的则全部是商城订单
                    $str = $this->_mall_order_new($trade,$order,$applet);
                }
            }

            if($str){
                // $strHtml = htmlegitntities($str);
//                    $info['data'] = array(
//                        'result' => true,
//                        'print'  => html_entity_decode($str)
//                    );
                return $str;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /*
     * 订单打印数据
     */
    public function _order_print_str($number,$printCfg,$kind1 = 0){
        if($number){
            //获取当前店铺的小程序配置
            $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
            $applet     = $applet_model->findShopCfg();
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
            if($applet['ac_type'] == 32 || $applet['ac_type'] == 36){
//                if($this->sid == 9373){
//                    $trade = $trade_model->getSequenceTradeRowNew($number);
//                }else{
//                    $trade = $trade_model->getSequenceTradeRow($number);
//                }
                $trade = $trade_model->getSequenceTradeRowNew($number);
            }else{
                $trade = $trade_model->getRowBySid($number);
            }
            if($trade){
                //获取交易订单商品
                $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                $order = $order_model->fetchOrderListByTid($trade['t_id']);

                if($printCfg && $printCfg['apc_print_type']==2){
                    if($applet['ac_type']==4){
                        $str = $this->_meal_order_wide($trade,$order,$applet,$kind1);
                    }else if($applet['ac_type']==7){
                        $str = $this->_hotel_order_wide($trade,$order,$applet);
                    }else{   //不存在小程序的则全部是商城订单
                        $str = $this->_mall_order_wide($trade,$order,$applet);
                    }
                }else{
                    if($applet['ac_type']==4){
                        $str = $this->_meal_order($trade,$order,$applet,$kind1);
                    }else if($applet['ac_type']==7){
                        $str = $this->_hotel_order($trade,$order,$applet);
                    } else{   //不存在小程序的则全部是商城订单
                        $str = $this->_mall_order_new($trade,$order,$applet);
                    }
                }

                if($str){
                    // $strHtml = htmlegitntities($str);
//                    $info['data'] = array(
//                        'result' => true,
//                        'print'  => html_entity_decode($str)
//                    );
                    return $str;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    /*
     * 根据数量输出空格
     */
    private function _print_space($num,$type='emsp'){
        $str = '';
        $space = ' ';
        $maxspace = '　';
        if($num>0){
            for($i=0;$i<$num;$i++){
                if($type=='ensp'){  //半角空格
                    //$str.='&ensp;';
                    $str.=$space;
                }else{
                    //$str.='&emsp;';
                    $str.=$maxspace;
                }
            }
        }
        return $str;

    }
    /*
     * 商城正常订单数据
     */
    private function _mall_order($trade,$goods){
        // 获取收货地址
        $str = '';
        $str .= '<CB>'.$this->shop['s_name'].'</CB><BR>';
        $str .=  '<BR>';
        $str .= '名称　　　　　 单价  数量 金额<BR>';
        $str .= '--------------------------------<BR>';
        // 拼接商品内容
        foreach ($goods as $val) {
            // 拼接标题
            $titleLenght = mb_strlen($val['to_title']);
            if (mb_strlen($val['to_title']) > 7) {
                //$title = mb_substr($val['to_title'], 0, 7);
                $title = $val['to_title'];
            } else {
                $titleSpace = $this->_print_space(7 - $titleLenght);
                $title = $val['to_title'] . $titleSpace;
            }
            // 拼接单价floatval
            $price = round($val['to_price'], 1);
            $priceLength = mb_strlen($price);
            $priceSpace = $this->_print_space((7 - $priceLength), 'ensp');
            $priceStr = ' ' . $price . $priceSpace;
            // 拼接数量
            $numLength = mb_strlen($val['to_num']);
            $numSpace = $this->_print_space(4 - $numLength, 'ensp');
            $numStr = $val['to_num'] . $numSpace;
            //拼接总价
            // 拼接单价floatval
            $total = round($val['to_total'], 1);
            if(mb_strlen($val['to_title']) > 7){
                $str .= $title. '<BR>';
                $titleSpace = $this->_print_space(7);
                $str .= $titleSpace . $priceStr . $numStr . $total . '<BR>';
            }else{
                $str .= $title . $priceStr . $numStr . $total . '<BR>';
            }

        }
        $str .= '--------------------------------<BR>';
        //合计
        $str .= '<L>合计：' . $trade['t_total_fee'] . '</L><BR>';
        // 备注
        $str .= '备注：' . $trade['t_note'] . '<BR>';
        $str .= '收货人：' . $trade['ma_name'] . '　' . $trade['ma_phone'] . '<BR>';
        $str .= '收货地址：' . $trade['ma_province'] . $trade['ma_city'] . $trade['ma_zone'] . $trade['ma_detail'].'<BR>';
        $str .=  '<BR>';
        $str .=  '<BR>';
        return $str;
    }

    /*
     * 餐饮版本订单数据
     */
    private function _meal_order($trade,$goods,$applet,$kind1 = 0){
        $payType = App_Helper_Trade::$trade_pay_type_note;
        $payStatus = App_Helper_Trade::$trade_status;
        $todayNum      = $this->_get_trade_number($trade);
        // 获取收货地址
        $str = '';
        $str .= '<CB>'.$this->shop['s_name'].'('.$todayNum.')'.'</CB><BR>';
        $str .=  '<BR>';
        $str .= '名称　　　　　 单价  数量 金额<BR>';
        $str .= '--------------------------------<BR>';
        $kinds = array();
        $kindsData = array();
        $goods_total_fee = 0;
        if($kind1 > 0 ){
            foreach ($goods as $val){
                if($val['to_g_kind1'] == $kind1){
                    $kinds[] = intval($val['to_g_kind1']);
                    $kindsData[$val['to_g_kind1']][] = $val;
                    $goods_total_fee += $val['to_total'];
                }
            }
        }else{
            foreach ($goods as $val){
                $kinds[] = intval($val['to_g_kind1']);
                $kindsData[$val['to_g_kind1']][] = $val;
            }
        }
        $kinds = array_unique($kinds);
        //获取店铺分类信息
        $category_model = new App_Model_Shop_MysqlKindStorage($this->sid);
        $category_list = [];
        if($kinds){
            $category_list = $category_model->getFirstCategoryByIds($kinds);
        }

        $print_storage = new App_Model_Print_MysqlPrintCfgStorage($this->sid);
        $row = $print_storage->findRowBySid();

        if($row['apc_goods_large']){
            $fontWeight = '<L>';
            $fontWeightEnd = '</L>';
        }else{
            $fontWeight = '';
            $fontWeightEnd = '';
        }

        foreach ($kindsData as $key => $list){
            if($category_list[$key]['sk_name']){
                $str .= '<CB>'.$category_list[$key]['sk_name'].'</CB><BR>';
            }
            $str .= '--------------------------------<BR>';
            foreach ($list as $val) {
                // 拼接单价floatval
                $price = round($val['to_price'], 1);
                $priceLength = mb_strlen($price);
                $priceSpace = $this->_print_space((7 - $priceLength), 'ensp');
                $priceStr = ' ' . $price . $priceSpace;
                // 拼接数量
                $numLength = mb_strlen($val['to_num']);
                $numSpace = $this->_print_space(4 - $numLength, 'ensp');
                $numStr = $val['to_num'] . $numSpace;
                //拼接总价
                // 拼接单价floatval
                $total = round($val['to_total'], 1);
                // 判断标题长度，显示不同
                if(mb_strlen($val['to_title']) > 7){
                    $str .= $fontWeight.$val['to_title'].'|'.$val['to_gf_name']. $fontWeightEnd .'<BR>';
                    $titleSpace = $this->_print_space(7);
                    $str .= ' '.$fontWeight.$titleSpace . $priceStr . $numStr . $total .$fontWeightEnd. '<BR>';
                }else{
                    $titleLenght = mb_strlen($val['to_title']) + mb_strlen($val['to_gf_name']) + 1;
                    $titleSpace = $this->_print_space(7 - $titleLenght);
                    $title = $fontWeight.$val['to_title'].'|'.$val['to_gf_name'] . $titleSpace.$fontWeightEnd;
                    $str .= $fontWeight.$title . $priceStr . $numStr . $total . $fontWeightEnd.'<BR>';
                }
            }
        }
//        // 拼接商品内容
//        foreach ($goods as $val) {
//            // 拼接标题
//            $titleLenght = mb_strlen($val['to_title']);
//            if (mb_strlen($val['to_title']) > 7) {
//                $title = mb_substr($val['to_title'], 0, 7);
//            } else {
//                $titleSpace = $this->_print_space(7 - $titleLenght);
//                $title = $val['to_title'] . $titleSpace;
//            }
//            // 拼接单价floatval
//            $price = round($val['to_price'], 1);
//            $priceLength = mb_strlen($price);
//            $priceSpace = $this->_print_space((7 - $priceLength), 'ensp');
//            $priceStr = ' ' . $price . $priceSpace;
//            // 拼接数量
//            $numLength = mb_strlen($val['to_num']);
//            $numSpace = $this->_print_space(4 - $numLength, 'ensp');
//            $numStr = $val['to_num'] . $numSpace;
//            //拼接总价
//            // 拼接单价floatval
//            $total = round($val['to_total'], 1);
//            $str .= $title . $priceStr . $numStr . $total . '<BR>';
//        }
        $str .= '--------------------------------<BR>';

        //配送顺序号
        if($row['apc_legworknum_isprint'] && $trade['t_legwork_num'] > 0){
            if($row['apc_legworknum_bold']){
                $str .= '<B>配送顺序号：' . $trade['t_legwork_num'].'号' . '</B><BR>';
            }else{
                $str .= '配送顺序号：' . $trade['t_legwork_num'].'号' . '<BR>';
            }
        }

        if($trade['t_meal_type']==1){
            $str .= '类型：外卖<BR>';
            if($trade['t_meal_send_time'] && isset($trade['t_meal_send_time'])){
                $str .= '送达时间：'.$trade['t_meal_send_time'] . '<BR>';
            }
        }else{
            $str .= '类型：堂食<BR>';
            if($row['apc_tablenum_large']){
                $str .= '<L>包间/桌号：' . $trade['t_home'] . '</L><BR>';
            }else{
                $str .= '包间/桌号：' . $trade['t_home'] . '<BR>';
            }
        }
        $str .= '订单号：' . $trade['t_tid'] . '<BR>';



        $str .= $this->_get_meal_shop($trade['t_es_id']);
        $str .= '下单时间：' . date('Y-m-d H:i',$trade['t_create_time']) . '<BR>';
        $str .= '--------------------------------<BR>';
        //合计
        if($kind1 > 0){
            $str .= '<L>合计：' . $goods_total_fee . '</L><BR>';
        }else{
            $str .= '<L>合计：' . $trade['t_total_fee'] . '</L><BR>';
        }
        $payNote = $trade['t_pay_type'] == 4 ? '现金/刷卡' : $payType[$trade['t_pay_type']];
        $str .= '<L>支付方式：' . $payNote. '</L><BR>';
        if($trade['t_pay_type']==4 && $trade['t_payment']>0){
            $str .= '<L>预支付金额：' . $trade['t_payment']. '元</L><BR>';
        }
        $status = $trade['t_pay_type']==4 || $trade['t_pay_type']==8 ? '现金（刷卡）请核对' : $payStatus[$trade['t_status']];
        $str .= '<L>支付状态：' . $status . '</L><BR>';
        if($trade['t_meal_type']==1){
            $str .= '<L>联系人：' . $trade['ma_name'] . '　' . $trade['ma_phone'] . '</L><BR>';
            $str .= '<L>收货地址：' . $trade['ma_province'] . $trade['ma_city'] . $trade['ma_zone'] . $trade['ma_detail'].'</L><BR>';
        }
        // 备注
        $str .= '<L>备注：' . $trade['t_note'] . '</L><BR>';

//        $print_storage = new App_Model_Print_MysqlPrintCfgStorage($this->sid);
//        $row = $print_storage->findRowBySid();
//        if($row['apc_qrcode_isprint']){
//            //获得小程序二维码
//            $qrcode = PLUM_DIR_ROOT.$applet['ac_wxacode'];
//            $file_path = App_Helper_Image::updateImageSize($qrcode,350,350);
//            if($fp = fopen($file_path,"r", 0)){
//                $filesize = filesize($file_path);
//                $content = fread($fp, $filesize);
//                $file_content = chunk_split(base64_encode($content));
//                $str .= '<BR><C><BASE64>'.$file_content.'<BASE64></C><BR>';
//            }
//            fclose($fp);
//        }

//        $str .= '收货人：' . $trade['ma_name'] . '　' . $trade['ma_phone'] . '<BR>';
//        $str .= '收货地址：' . $trade['ma_province'] . $trade['ma_city'] . $trade['ma_zone'] . $trade['ma_detail'].'<BR>';
        $str .=  '<BR>';
        $str .=  '<BR>';
        return $str;
    }

    /**
     * @param $tid
     * @return array获取该订单是今天第几单
     */
    private function _get_trade_number($trade){
        $num = 1;
        if($trade['t_create_time']>0){
            $where = array();
            $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
            //$where[] = array('name' => 't_status', 'oper' => '>=', 'value' => 3);
            $where[] = array('name' => 't_create_time', 'oper' => '>', 'value' => strtotime(date('y-m-d')));
            $where[] = array('name' => 't_create_time', 'oper' => '<=', 'value' => $trade['t_create_time']);
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
            $num = $trade_model->currentOrderNum($where);
        }
        return $num;

    }

    /*
     * 酒店版本订单数据
     */
    private function _hotel_order($trade,$goods,$applet){
        $payType = App_Helper_Trade::$trade_pay_type_note;
        $payStatus = App_Helper_Trade::$trade_status;
        // 获取收货地址
        $str = '';
        $str .= '<CB>'.$this->shop['s_name'].'</CB><BR>';
        $str .=  '<BR>';
        $str .= '名称　　　　 单价  数量    金额<BR>';
        $str .= '--------------------------------<BR>';
        // 拼接商品内容
        foreach ($goods as $val) {
            // 拼接标题
            $titleLenght = mb_strlen($val['to_title']);
            if (mb_strlen($val['to_title']) > 6) {
                $title = mb_substr($val['to_title'], 0, 6);
            } else {
                $titleSpace = $this->_print_space(6 - $titleLenght);
                $title = $val['to_title'] . $titleSpace;
            }
            // 拼接单价floatval
            $price = round($val['to_price'], 1);
            $priceLength = mb_strlen($price);
            $priceSpace = $this->_print_space((5 - $priceLength), 'ensp');
            $priceStr = ' ' .$price . $priceSpace;
            // 拼接数量

            $numLength = mb_strlen($trade['t_room_num'].'间'.'*'.$val['to_num'].'晚');
            $numSpace = $this->_print_space(4 - $numLength, 'ensp');
            $numStr = $trade['t_room_num'].'间'.'*'.$val['to_num'].'晚' . $numSpace.'   ';
            //拼接总价
            // 拼接单价floatval
            $total = round($trade['t_total_fee'], 1);
            $str .= $title . $priceStr . $numStr . $total . '<BR>';
        }
        $str .= '--------------------------------<BR>';
        $str .= '入驻时间：' . date('Y-m-d', $trade['t_receive_start_time']).'至'.date('Y-m-d', $trade['t_receive_end_time']) . '<BR>';
        $str .= '住客姓名：' . implode('，',json_decode($trade['t_express_company'], true))  . '<BR>';
        $str .= '联系电话：' . $trade['t_express_code'] . '<BR>';
        $str .= '订单号：' . $trade['t_tid'] . '<BR>';
        $str .= '下单时间：' . date('Y-m-d H:i:s', $trade['t_create_time']) . '<BR>';
        $str .= '--------------------------------<BR>';

        //合计
        $str .= '<L>合计：' . $trade['t_total_fee'] . '</L><BR>';
        $payNote = $trade['t_pay_type'] == 4 ? '现金/刷卡' : $payType[$trade['t_pay_type']];
        $status = $trade['t_pay_type']==4 || $trade['t_pay_type']==8 ? '现金（刷卡）请核对' : $payStatus[$trade['t_status']];
        $str .= '<L>支付方式：' . $payNote. '</L><BR>';
        $str .= '<L>支付状态：' . $status . '</L><BR>';

        // 备注
        $str .= '<L>备注：' . $trade['t_note'] . '</L><BR>';

//        $print_storage = new App_Model_Print_MysqlPrintCfgStorage($this->sid);
//        $row = $print_storage->findRowBySid();
//        if($row['apc_qrcode_isprint']){
//            //获得小程序二维码
//            $qrcode = PLUM_DIR_ROOT.$applet['ac_wxacode'];
//            $file_path = App_Helper_Image::updateImageSize($qrcode,350,350);
//            if($fp = fopen($file_path,"r", 0)){
//                $filesize = filesize($file_path);
//                $content = fread($fp, $filesize);
//                $file_content = chunk_split(base64_encode($content));
//                $str .= '<BR><C><BASE64>'.$file_content.'<BASE64></C><BR>';
//            }
//            fclose($fp);
//        }

        $str .=  '<BR>';
        $str .=  '<BR>';
        return $str;
    }

    /*
     * 80餐饮版订单数据
     */
    private function _meal_order_wide_old($trade,$goods){
        $payType = App_Helper_Trade::$trade_pay_type_note;
        $payStatus = App_Helper_Trade::$trade_status;
        $todayNum      = $this->_get_trade_number($trade);
        // 获取收货地址
        $str = '';
        $str .= '<CB>'.$this->shop['s_name'].'('.$todayNum.')'.'</CB><BR>';
        $str .=  '<BR>';
        $str .= '名称                     单价   数量    金额<BR>';
        $str .= '------------------------------------------------<BR>';
        $kinds = array();
        $kindsData = array();
        foreach ($goods as $val){
            $kinds[] = intval($val['to_g_kind1']);
            $kindsData[$val['to_g_kind1']][] = $val;
        }
        $kinds = array_unique($kinds);
        //获取店铺分类信息
        $category_model = new App_Model_Shop_MysqlKindStorage($this->sid);
        $category_list = $category_model->getFirstCategoryByIds($kinds);
        foreach ($kindsData as $key => $list){
            $str .= '<CB>'.$category_list[$key]['sk_name'].'</CB><BR>';
            $str .= '------------------------------------------------<BR>';
            foreach ($list as $val) {
                // 拼接单价floatval
                $price = round($val['to_price'], 1);
                $priceLength = mb_strlen($price);
                $priceSpace = $this->_print_space((7 - $priceLength), 'ensp');
                $priceStr = ' ' . $price . $priceSpace;
                // 拼接数量
                $numLength = mb_strlen($val['to_num']);
                $numSpace = $this->_print_space(7 - $numLength, 'ensp');
                $numStr = $val['to_num'] . $numSpace;
                //拼接总价
                // 拼接单价floatval
                $total = round($val['to_total'], 1);
                // 判断标题长度，显示不同
                $titleLenght = mb_strlen($val['to_title']);
                if($titleLenght*2 > 25){
                    $str .= $val['to_title']. '<BR>';
                    $titleSpace = $this->_print_space(24,'ensp');
                    $str .= ' '.$titleSpace . $priceStr . $numStr . $total . '<BR>';
                }else{
                    $titleSpace = $this->_print_space((25 - ($titleLenght*2)),'ensp');
                    $title = $val['to_title'] . $titleSpace;
                    $str .= $title . $priceStr . $numStr . $total . '<BR>';
                }
            }
        }
        $str .= '------------------------------------------------<BR>';

        $str .= '<B>包间/桌号：' . $trade['t_home'] . '</B><BR>';
        $str .= '<B>订单号：' . $trade['t_tid'] . '</B><BR>';
        $str .= '<B>下单时间：' . date('Y-m-d H:i',$trade['t_create_time']) . '</B><BR>';
        $str .= '------------------------------------------------<BR>';
        //合计
        $str .= '<B>合计：' . $trade['t_total_fee'] . '</B><BR>';
        $payNote = $trade['t_pay_type'] == 4 ? '现金/刷卡' : $payType[$trade['t_pay_type']];
        $str .= '<B>支付方式：' . $payNote. '</B><BR>';
        if($trade['t_pay_type']==4 && $trade['t_payment']>0){
            $str .= '<B>预支付金额：' . $trade['t_payment']. '元</B><BR>';
        }
        $status = $trade['t_pay_type']==4 || $trade['t_pay_type']==8 ? '现金（刷卡）请核对' : $payStatus[$trade['t_status']];
        $str .= '<B>支付状态：' . $status . '</B><BR>';
        // 备注
        $str .= '<B>备注：' . $trade['t_note'] . '</B><BR>';
        $str .=  '<BR>';
        $str .=  '<BR>';
        return $str;

    }

    /*
    * 80餐饮版订单数据
    */
    private function _meal_order_wide($trade,$goods,$applet,$kind1=0){
        $payType = App_Helper_Trade::$trade_pay_type_note;
        $payStatus = App_Helper_Trade::$trade_status;
        $todayNum      = $this->_get_trade_number($trade);
        // 获取收货地址
        $str = '';
        $str .= '<CB>'.$this->shop['s_name'].'('.$todayNum.')'.'</CB><BR>';
        $str .=  '<BR>';
        $str .= '名称                     单价   数量    金额<BR>';
        $str .= '------------------------------------------------<BR>';
        $kinds = array();
        $kindsData = array();
        $goods_total_fee = 0;
        if($kind1 > 0){
            foreach ($goods as $val){
                if($val['to_g_kind1'] == $kind1){
                    $kinds[] = intval($val['to_g_kind1']);
                    $kindsData[$val['to_g_kind1']][] = $val;
                    $goods_total_fee += $val['to_total'];
                }
            }
        }else{
            foreach ($goods as $val){
                $kinds[] = intval($val['to_g_kind1']);
                $kindsData[$val['to_g_kind1']][] = $val;
            }
        }

        $kinds = array_unique($kinds);
        //获取店铺分类信息
        $category_model = new App_Model_Shop_MysqlKindStorage($this->sid);
        $category_list = [];
        if($category_list){
            $category_list = $category_model->getFirstCategoryByIds($kinds);
        }

        $print_storage = new App_Model_Print_MysqlPrintCfgStorage($this->sid);
        $row = $print_storage->findRowBySid();

        if($row['apc_goods_large']){
            $fontWeight = '<L>';
            $fontWeightEnd = '</L>';
        }else{
            $fontWeight = '';
            $fontWeightEnd = '';
        }

        foreach ($kindsData as $key => $list){
//            $str .= '<C>'.$category_list[$key]['sk_name'].'</C><BR>';
//            $str .= '------------------------------------------------<BR>';
            foreach ($list as $val) {
                // 拼接单价floatval
                $price = round($val['to_price'], 1);
                $priceLength = mb_strlen($price);
                $priceSpace = $this->_print_space((7 - $priceLength), 'ensp');
                $priceStr = ' ' . $price . $priceSpace;
                // 拼接数量
                $numLength = mb_strlen($val['to_num']);
                $numSpace = $this->_print_space(7 - $numLength, 'ensp');
                $numStr = $val['to_num'] . $numSpace;
                //拼接总价
                // 拼接单价floatval
                $total = round($val['to_total'], 1);
                // 判断标题长度，显示不同
                //$titleLenght = mb_strlen($val['to_title']);
                $titleLenght = (strlen($val['to_title']) + mb_strlen($val['to_title'],'UTF8'))/2;
                if($titleLenght > 25){
                    $str .= '<L>'.$val['to_title']. '</L><BR>';
                    $titleSpace = $this->_print_space(24,'ensp');
                    $str .= ' <L>'.$titleSpace . $priceStr . $numStr . $total . '</L><BR>';
                }else{
                    $titleSpace = $this->_print_space((25 - ($titleLenght)),'ensp');
                    $title = $val['to_title'] . $titleSpace;
                    $str .= '<L>'.$title . $priceStr . $numStr . $total . '</L><BR>';
                }
            }
        }
        $str .= '------------------------------------------------<BR>';
        //配送顺序号
        if($row['apc_legworknum_isprint'] && $trade['t_legwork_num'] > 0){
            if($row['apc_legworknum_bold']){
                $str .= '<B>配送顺序号：' . $trade['t_legwork_num'].'号' . '</B><BR>';
            }else{
                $str .= '配送顺序号：' . $trade['t_legwork_num'].'号' . '<BR>';
            }
        }

        if($trade['t_meal_type']==1){
            $str .= '类型：外卖<BR>';
            if($trade['t_meal_send_time'] && isset($trade['t_meal_send_time'])){
                $str .= '送达时间：'.$trade['t_meal_send_time']. '<BR>';
            }
        }else{
            $str .= '类型：堂食<BR>';
            $str .= '包间/桌号：' . $trade['t_home'] . '<BR>';
        }

        $str .= '订单号：' . $trade['t_tid'] . '<BR>';

        $str .= $this->_get_meal_shop($trade['t_es_id']);
        $str .= '下单时间：' . date('Y-m-d H:i',$trade['t_create_time']) . '<BR>';
        $str .= '------------------------------------------------<BR>';
        //合计
        if($kind1 > 0){
            $str .= '<L>合计：' . $goods_total_fee . '</L><BR>';
        }else{
            $str .= '<L>合计：' . $trade['t_total_fee'] . '</L><BR>';
        }
        $payNote = $trade['t_pay_type'] == 4 ? '现金/刷卡' : $payType[$trade['t_pay_type']];
        $str .= '<L>支付方式：' . $payNote. '</L><BR>';
        if($trade['t_pay_type']==4 && $trade['t_payment']>0){
            $str .= '<L>预支付金额：' . $trade['t_payment']. '元</L><BR>';
        }
        $status = $trade['t_pay_type']==4 || $trade['t_pay_type']==8 ? '现金（刷卡）请核对' : $payStatus[$trade['t_status']];
        $str .= '<L>支付状态：' . $status . '</L><BR>';
        if($trade['t_meal_type']==1){
            $str .= '<L>联系人：' . $trade['ma_name'] . '　' . $trade['ma_phone'] . '</L><BR>';
            $str .= '<L>收货地址：' . $trade['ma_province'] . $trade['ma_city'] . $trade['ma_zone'] . $trade['ma_detail'].'</L><BR>';
        }
        // 备注
        $str .= '<L>备注：' . $trade['t_note'] . '</L><BR>';
        $str .=  '<BR>';

//        $print_storage = new App_Model_Print_MysqlPrintCfgStorage($this->sid);
//        $row = $print_storage->findRowBySid();
//        if($row['apc_qrcode_isprint']){
//            //获得小程序二维码
//            $qrcode = PLUM_DIR_ROOT.$applet['ac_wxacode'];
//            $file_path = App_Helper_Image::updateImageSize($qrcode,350,350);
//            if($fp = fopen($file_path,"r", 0)){
//                $filesize = filesize($file_path);
//                $content = fread($fp, $filesize);
//                $file_content = chunk_split(base64_encode($content));
//                $str .= '<BR><C><BASE64>'.$file_content.'<BASE64></C><BR>';
//            }
//            fclose($fp);
//        }
        return $str;

    }

    private function _get_meal_shop($esId){
        if($esId){
            $shop_model = new App_Model_Meal_MysqlMealStoreStorage($this->sid);
            $shop = $shop_model->findUpdateByEsId($esId);
            if($shop['ams_title']){
                return '订单号：' . $shop['ams_title'] . '<BR>';
            }else{
                return '';
            }
        }else{
            return '';
        }
    }


    /*
     * 80mm商城正常订单数据
     */
    private function _mall_order_wide($trade,$goods,$applet){
        // 获取收货地址
        $str = '';
        $str .= '<CB>'.$this->shop['s_name'].'</CB><BR>';
        $str .=  '<BR>';
        $str .= '名称                     单价   数量    金额<BR>';
        $str .= '------------------------------------------------<BR>';
        // 拼接商品内容
        foreach ($goods as $val) {
            // 拼接单价floatval
            $price = round($val['to_price'], 1);
            $priceLength = mb_strlen($price);
            $priceSpace = $this->_print_space((7 - $priceLength), 'ensp');
            $priceStr = ' ' . $price . $priceSpace;
            // 拼接数量
            $numLength = mb_strlen($val['to_num']);
            $numSpace = $this->_print_space(7 - $numLength, 'ensp');
            $numStr = $val['to_num'] . $numSpace;
            //拼接总价
            // 拼接单价floatval
            $total = round($val['to_total'], 1);

            if($val['to_gf_name']){
                $currTitle = $val['to_title'].'（'.$val['to_gf_name'].'）';
            }else{
                $currTitle = $val['to_title'];
            }
            // 判断标题长度，显示不同
            $titleLenght = mb_strlen($currTitle);
            if($titleLenght*2 > 25){
                $str .= $currTitle. '<BR>';
                $titleSpace = $this->_print_space(24,'ensp');
                $str .= ' '.$titleSpace . $priceStr . $numStr . $total . '<BR>';
            }else{
                $titleSpace = $this->_print_space((25 - ($titleLenght*2)),'ensp');
                $title = $currTitle . $titleSpace;
                $str .= $title . $priceStr . $numStr . $total . '<BR>';
            }

        }
        $str .= '------------------------------------------------<BR>';
        //合计
//        $str .= '<L>合计：' . $trade['t_total_fee'] . '</L><BR>';
//        // 备注
//        $str .= '备注：' . $trade['t_note'] . '<BR>';
//        $str .= '收货人：' . $trade['ma_name'] . '　' . $trade['ma_phone'] . '<BR>';
//        $str .= '收货地址：' . $trade['ma_province'] . $trade['ma_city'] . $trade['ma_zone'] . $trade['ma_detail'].'<BR>';
        $str .= $this->_fetch_mall_isprint_str($trade,$applet);
        $str .=  '<BR>';
        $str .=  '<BR>';
        return $str;
    }

    /*
    * 80mm酒店版本订单数据
    */
    private function _hotel_order_wide($trade,$goods,$applet){
        $payType = App_Helper_Trade::$trade_pay_type_note;
        $payStatus = App_Helper_Trade::$trade_status;
        // 获取收货地址
        $str = '';
        $str .= '<CB>'.$this->shop['s_name'].'</CB><BR>';
        $str .=  '<BR>';
        $str .= '名称                     单价   数量    金额<BR>';
        $str .= '------------------------------------------------<BR>';
        // 拼接商品内容
        foreach ($goods as $val) {
            // 拼接单价floatval
            $price = round($val['to_price'], 1);
            $priceLength = mb_strlen($price);
            $priceSpace = $this->_print_space((7 - $priceLength), 'ensp');
            $priceStr = ' ' .$price . $priceSpace;
            // 拼接数量
            $numLength = mb_strlen($trade['t_room_num'].'间'.'*'.$val['to_num'].'晚');
            $numSpace = $this->_print_space(7 - $numLength, 'ensp');
            $numStr = $trade['t_room_num'].'间'.'*'.$val['to_num'].'晚' . $numSpace.'   ';
            //拼接总价
            // 拼接单价floatval
            $total = round($trade['t_total_fee'], 1);
            // 判断标题长度，显示不同
            $titleLenght = mb_strlen($val['to_title']);
            if($titleLenght*2 > 25){
                $str .= $val['to_title']. '<BR>';
                $titleSpace = $this->_print_space(24,'ensp');
                $str .= ' '.$titleSpace . $priceStr . $numStr . $total . '<BR>';
            }else{
                $titleSpace = $this->_print_space((25 - ($titleLenght*2)),'ensp');
                $title = $val['to_title'] . $titleSpace;
                $str .= $title . $priceStr . $numStr . $total . '<BR>';
            }
        }
        $str .= '------------------------------------------------<BR>';
        $str .= '入驻时间：' . date('Y-m-d', $trade['t_receive_start_time']).'至'.date('Y-m-d', $trade['t_receive_end_time']) . '<BR>';
        $str .= '住客姓名：' . implode('，',json_decode($trade['t_express_company'], true))  . '<BR>';
        $str .= '联系电话：' . $trade['t_express_code'] . '<BR>';
        $str .= '订单号：' . $trade['t_tid'] . '<BR>';
        $str .= '下单时间：' . date('Y-m-d H:i:s', $trade['t_create_time']) . '<BR>';
        $str .= '------------------------------------------------<BR>';

        //合计
        $str .= '<L>合计：' . $trade['t_total_fee'] . '</L><BR>';
        $payNote = $trade['t_pay_type'] == 4 ? '现金/刷卡' : $payType[$trade['t_pay_type']];
        $status = $trade['t_pay_type']==4 || $trade['t_pay_type']==8 ? '现金（刷卡）请核对' : $payStatus[$trade['t_status']];
        $str .= '<L>支付方式：' . $payNote. '</L><BR>';
        $str .= '<L>支付状态：' . $status . '</L><BR>';

        // 备注
        $str .= '<L>备注：' . $trade['t_note'] . '</L><BR>';

        $str .=  '<BR>';

//        $print_storage = new App_Model_Print_MysqlPrintCfgStorage($this->sid);
//        $row = $print_storage->findRowBySid();
//        if($row['apc_qrcode_isprint']){
//            //获得小程序二维码
//            $qrcode = PLUM_DIR_ROOT.$applet['ac_wxacode'];
//            $file_path = App_Helper_Image::updateImageSize($qrcode,350,350);
//            if($fp = fopen($file_path,"r", 0)){
//                $filesize = filesize($file_path);
//                $content = fread($fp, $filesize);
//                $file_content = chunk_split(base64_encode($content));
//                $str .= '<BR><C><BASE64>'.$file_content.'<BASE64></C><BR>';
//            }
//            fclose($fp);
//        }

        $str .= '---------------------<CUT>--------------------------<BR>';
        $str .=  '<BR>';
        return $str;
    }

    private function _mall_order_new($trade,$goods,$applet){
        // 获取收货地址
        $str = '';
        $str .= '<CB>'.$this->shop['s_name'].'</CB><BR>';
        $str .=  '<BR>';
        $str .= '名称　　　　　 单价  数量 金额<BR>';
        $str .= '--------------------------------<BR>';
        // 拼接商品内容
        foreach ($goods as $val) {
            if($val['to_gf_name']){
                $currTitle = $val['to_title'].'（'.$val['to_gf_name'].'）';
            }else{
                $currTitle = $val['to_title'];
            }
            // 拼接标题
            $titleLenght = (strlen($currTitle) + mb_strlen($currTitle,'UTF8')) / 2 ;
            if ($titleLenght > 14) {
                $title = $currTitle;
            } else {
                $titleSpace = $this->_print_space(15 - $titleLenght,'ensp');
                $title = $currTitle . $titleSpace;
            }
            // 拼接单价floatval
            $price = $val['to_price'];
            $priceLength = mb_strlen($price);
            $priceSpace = $this->_print_space((7 - $priceLength), 'ensp');
            $priceStr = $price . $priceSpace;
            // 拼接数量
            $numLength = mb_strlen($val['to_num']);
            $numSpace = $this->_print_space(4 - $numLength, 'ensp');
            $numStr = $val['to_num'] . $numSpace;
            //拼接总价
            // 拼接单价floatval
            $total = $val['to_total'];
            if($titleLenght > 14){
                $str .= $title. '<BR>';
                $titleSpace = $this->_print_space(15,'ensp');
                $str .= $titleSpace . $priceStr . $numStr . $total . '<BR>';
            }else{
                $str .= $title . $priceStr . $numStr . $total . '<BR>';
            }

        }
        $str .= '--------------------------------<BR>';
        $str .= $this->_fetch_mall_isprint_str($trade,$applet);
//        //合计
//        $str .= '<L>合计：' . $trade['t_total_fee'] . '</L><BR>';
//        // 备注
//        $str .= '备注：' . $trade['t_note'] . '<BR>';
//        $str .= '收货人：' . $trade['ma_name'] . '　' . $trade['ma_phone'] . '<BR>';
//        $str .= '收货地址：' . $trade['ma_province'] . $trade['ma_city'] . $trade['ma_zone'] . $trade['ma_detail'].'<BR>';
        $str .=  '<BR>';
        $str .=  '<BR>';
        return $str;
    }

    private function _fetch_mall_isprint_str($trade,$applet){
        $print_storage = new App_Model_Print_MysqlPrintCfgStorage($this->sid);
        $row = $print_storage->findRowBySid();

        if(!$row){
            $row = plum_parse_config('default_cfg','print');
        }

        $payType = App_Helper_Trade::$trade_pay_type;
        $str = '';
        if($row){
            //配送顺序号
            if($row['apc_legworknum_isprint'] && $trade['t_legwork_num'] > 0){
                if($row['apc_legworknum_bold']){
                    $str .= '<B>配送顺序号：' . $trade['t_legwork_num'].'号' . '</B><BR>';
                }else{
                    $str .= '配送顺序号：' . $trade['t_legwork_num'].'号' . '<BR>';
                }
            }

            if($row['apc_total_isprint']){  // 订单总价
                if($row['apc_total_bold']){
                    $str .= '<B>合计：' . $trade['t_total_fee'] . '</B><BR>';
                }else{
                    $str .= '合计：' . $trade['t_total_fee'] . '<BR>';
                }
            }
            if($row['apc_postfee_isprint']){  // 订单配送费
                if($row['apc_postfee_bold']){
                    $str .= '<B>配送费：' . $trade['t_post_fee'] . '</B><BR>';
                }else{
                    $str .= '配送费：' . $trade['t_post_fee'] . '<BR>';
                }
            }

            if($row['apc_code_isprint']){  // 订单编号
                if($row['apc_code_bold']){
                    $str .= '<B>订单号：' . $trade['t_tid'] . '</B><BR>';
                }else{
                    $str .= '订单号：' . $trade['t_tid'] . '<BR>';
                }
            }
            if($row['apc_time_isprint']){
                if($row['apc_time_bold']){
                    $str .= '<B>下单时间：' .date('Y-m-d H:i', $trade['t_create_time']). '</B><BR>';
                }else{
                    $str .= '下单时间：' .date('Y-m-d H:i', $trade['t_create_time']). '<BR>';
                }
            }
            if($row['apc_paytype_isprint']){
                if($row['apc_paytype_bold']){
                    $str .= '<B>支付方式：' .($payType[$trade['t_pay_type']] ? $payType[$trade['t_pay_type']] : ''). '</B><BR>';
                }else{
                    $str .= '支付方式：' .($payType[$trade['t_pay_type']] ? $payType[$trade['t_pay_type']] : ''). '<BR>';
                }
            }
            if($row['apc_receiver_isprint']){
                if($trade['t_express_method']==2 || $trade['t_express_method'] == 6){   // 门店自取
                    if($row['apc_receiver_bold']){
                        $str .= '<B>联系人：' . $trade['t_express_company'] . '　' . $trade['t_express_code'] . '</B><BR>';
                        if($applet['ac_type'] != 32 && $applet['ac_type'] != 36){
                            $str .= '<B>自提门店：' . $trade['os_name']  . '</B><BR>';
                        }
                    }else{
                        $str .= '联系人：' . $trade['t_express_company'] . '　' . $trade['t_express_code'] . '<BR>';
                        if($applet['ac_type'] != 32 && $applet['ac_type'] != 36){
                            $str .= '自提门店：'  . $trade['os_name'] . '<BR>';
                        }
                    }
                }else{
                    if($row['apc_receiver_bold']){
                        $str .= '<B>联系人：' . $trade['ma_name'] . '　' . $trade['ma_phone'] . '</B><BR>';
                    }else{
                        $str .= '联系人：' . $trade['ma_name'] . '　' . $trade['ma_phone'] . '<BR>';
                    }
                }
            }
            if($row['apc_address_isprint']){
                if($trade['t_express_method'] == 6){
                    if($row['apc_address_bold']){
                        $str .= '<B>收货地址：' . $trade['t_address'].'</B><BR>';
                    }else{
                        $str .= '收货地址：' . $trade['t_address'] .'<BR>';
                    }
                }elseif($trade['t_express_method']!=2){   // 不是门店自取
                    if($row['apc_address_bold']){
                        $str .= '<B>收货地址：' . $trade['ma_province'] . $trade['ma_city'] . $trade['ma_zone'] . $trade['ma_detail'].'</B><BR>';
                    }else{
                        $str .= '收货地址：' . $trade['ma_province'] . $trade['ma_city'] . $trade['ma_zone'] . $trade['ma_detail'].'<BR>';
                    }
                }
            }
            //社区团购
            if($applet['ac_type'] == 32 || $applet['ac_type'] == 36){
//                if($row['apc_activity_isprint']){
//                    if($row['apc_activity_bold']){
//                        $str .= '<B>活动名称：' . $trade['asa_title'].'</B><BR>';
//                    }else{
//                        $str .= '活动名称：' . $trade['asa_title'].'<BR>';
//                    }
//                }
                if($row['apc_community_isprint']){
                    if($row['apc_community_bold']){
                        $str .= '<B>小区名称：' . $trade['asc_name'].'</B><BR>';
                    }else{
                        $str .= '小区名称：' . $trade['asc_name'].'<BR>';
                    }
                }
                if($row['apc_comaddr_isprint']){
                    if($row['apc_comaddr_bold']){
                        $str .= '<B>小区地址：' . $trade['asc_address'].($trade['asc_address_detail'] ? $trade['asc_address_detail'] : '').'</B><BR>';
                    }else{
                        $str .= '小区地址：' . $trade['asc_address'].($trade['asc_address_detail'] ? $trade['asc_address_detail'] : '').'<BR>';
                    }
                }
                if($row['apc_leader_isprint']){
                    if($row['apc_leader_bold']){
                        $str .= '<B>团长名称：' . $trade['asl_name'].'</B><BR>';
                    }else{
                        $str .= '团长名称：' . $trade['asl_name'].'<BR>';
                    }
                }
//                if($row['apc_receivetime_isprint']){
//                    if($trade['asa_receive_start'] && $trade['asa_receive_end']){
//                        if($row['apc_receivetime_bold']){
//                            $str .= '<B>自提/配送时间：' . date('Y-m-d H:i',$trade['asa_receive_start']).'到'.date('Y-m-d H:i',$trade['asa_receive_end']).'</B><BR>';
//                        }else{
//                            $str .= '自提/配送时间：' . date('Y-m-d H:i',$trade['asa_receive_start']).'到'.date('Y-m-d H:i',$trade['asa_receive_end']).'<BR>';
//                        }
//                    }else{
//                        if($row['apc_receivetime_bold']){
//                            $str .= '<B>自提/配送时间：' .'</B><BR>';
//                        }else{
//                            $str .= '自提/配送时间：' .'<BR>';
//                        }
//                    }
//                }
                if($row['apc_senddate_isprint']){
                    if($trade['t_se_send_time']){
                        if($row['apc_senddate_bold']){
                            $str .= '<B>自提/配送时间：' . date('Y-m-d',$trade['t_se_send_time']).'</B><BR>';
                        }else{
                            $str .= '自提/配送时间：' . date('Y-m-d',$trade['t_se_send_time']).'<BR>';
                        }
                    }else{
                        if($row['apc_senddate_bold']){
                            $str .= '<B>自提/配送时间：' .'</B><BR>';
                        }else{
                            $str .= '自提/配送时间：' .'<BR>';
                        }
                    }
                }


            }

            if(($applet['ac_type'] == 6 || $applet['ac_type'] == 8) && $trade['t_es_id'] > 0){
                $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
                if($applet['ac_type'] == 6){
                    $entershop = $es_model->getCityShopDetail($trade['t_es_id']);
                    $shopName = $entershop['acs_name'] ? $entershop['acs_name'] : ($entershop['es_name'] ? $entershop['es_name'] : '');
                    $shopPhone = $entershop['acs_mobile'] ? $entershop['acs_mobile'] : ($entershop['es_phone'] ? $entershop['es_phone'] : '');
                }else{
                    $entershop = $es_model->getRowById($trade['t_es_id']);
                    $shopName = $entershop['es_name'] ? $entershop['es_name'] : '';
                    $shopPhone = $entershop['es_phone'] ? $entershop['es_phone'] : '';
                }
                if($row['apc_esname_isprint']){
                    if($row['apc_esname_bold']){
                        $str .= '<B>商家名称：' . $shopName.'</B><BR>';
                    }else{
                        $str .= '商家名称：' . $shopName.'<BR>';
                    }
                }
                if($row['apc_esphone_isprint']){
                    if($row['apc_esphone_bold']){
                        $str .= '<B>商家电话：' . $shopPhone.'</B><BR>';
                    }else{
                        $str .= '商家电话：' . $shopPhone.'<BR>';
                    }
                }

            }

            if($row['apc_customs_isprint']){
                $data = json_decode($trade['t_remark_extra'], true);
                if($row['apc_customs_bold']){
                    foreach ($data as $key => $val){
                        if($val['type'] != 'image'){
                            $str .= '<B>'.$val['name'].'：' . $val['value'] . '</B><BR>';
                        }
                    }
                }else{
                    foreach ($data as $key => $val){
                        if($val['type'] != 'image'){
                            $str .= $val['name'].'：' . $val['value'] . '<BR>';
                        }
                    }
                }
            }

//            if($row['apc_qrcode_isprint']){
//                //获得小程序二维码
//                $qrcode = PLUM_DIR_ROOT.$applet['ac_wxacode'];
//                $file_path = App_Helper_Image::updateImageSize($qrcode,350,350);
//                if($fp = fopen($file_path,"r", 0)){
//                    $filesize = filesize($file_path);
//                    $content = fread($fp, $filesize);
//                    $file_content = chunk_split(base64_encode($content));
//                    $str .= '<BR><C><BASE64>'.$file_content.'<BASE64></C><BR>';
//                }
//                fclose($fp);
//            }

        }else{
            $str .= '<B>合计：' . $trade['t_total_fee'] . '</B><BR>';
            $str .= '订单号：' . $trade['t_tid'] . '<BR>';
            $str .= '下单时间：' .date('Y-m-d H:i', $trade['t_create_time']). '<BR>';
            $str .= '备注：' . $trade['t_note'] . '<BR>';
            // 备注
            if($trade['t_express_method'] == 2){
                $str .= '联系人：' . $trade['t_express_company'] . '　' . $trade['t_express_code'] . '<BR>';
                if($applet['ac_type'] != 32 && $applet['ac_type'] != 36){
                    $str .= '自提门店：' . $trade['os_name'].'<BR>';
                }
            }else{
                $str .= '联系人：' . $trade['ma_name'] . '　' . $trade['ma_phone'] . '<BR>';
                $str .= '收货地址：' . $trade['ma_province'] . $trade['ma_city'] . $trade['ma_zone'] . $trade['ma_detail'].'<BR>';
            }


        }
        return $str;
    }


}
