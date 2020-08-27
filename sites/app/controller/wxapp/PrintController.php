<?php

class App_Controller_Wxapp_PrintController extends App_Controller_Wxapp_InitController
{
    const MATCH_TYPE = 2;
    const ORDER_TYPE = 1;

    public function __construct()
    {

        parent::__construct();
    }

    public function indexAction()
    {
        $trade_print_model = new App_Model_Trade_MysqlPrintStorage();
        $list = $trade_print_model->getListBySid($this->curr_sid);


        $tag = plum_parse_config('tag', 'print');
        if ($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36) {
            $print = plum_parse_config('typeSequence', 'print');
            $tag[] = [
                'label' => '小区名称',
                'field' => '{Community}'
            ];
            $tag[] = [
                'label' => '小区地址',
                'field' => '{CommunityAddr}'
            ];
        } else {
            $print = plum_parse_config('type', 'print');
        }

        foreach ($list as $val) {
            $print[$val['tp_type']]['content'] = $val['tp_content'];
        }

        $this->output['print'] = $print;

        $this->output['tag'] = $tag;
        $this->output['tableTag'] = plum_parse_config('tableTag', 'print');

        $this->buildBreadcrumbs(array(
            array('title' => '打印模版', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/print/template.tpl');
    }

    
    public function saveTemplateAction()
    {
        $data = array();
        $data['tp_type'] = $this->request->getIntParam('type');
        $data['tp_content'] = $this->request->getStrParam('content');
        $data['tp_update_time'] = time();
        if (in_array($data['tp_type'], array(self::MATCH_TYPE, self::ORDER_TYPE))) {
            $trade_print_model = new App_Model_Trade_MysqlPrintStorage();
            $row = $trade_print_model->findUpdateRowBySidType($this->curr_sid, $data['tp_type']);
            if (!empty($row)) {
                $ret = $trade_print_model->findUpdateRowBySidType($this->curr_sid, $data['tp_type'], $data);
            } else {
                $data['tp_s_id'] = $this->curr_sid;
                $data['tp_create_time'] = time();
                $ret = $trade_print_model->insertValue($data);
            }
            $this->showAjaxResult($ret, '保存');
        } else {
            $this->displayJsonError('模版类型错误');
        }
    }

    
    public function ajaxShowAction()
    {
        $data = array(
            'ec' => 400,
            'em' => '模版类型错误'
        );
        $type = $this->request->getIntParam('type');
        $tid  = $this->request->getStrParam('tid');
        $cash = $this->request->getIntParam('cash', 0);
        if (in_array($type, array(self::MATCH_TYPE, self::ORDER_TYPE))) {
            $print_model = new App_Model_Trade_MysqlPrintStorage();
            $row = $print_model->findUpdateRowBySidType($this->curr_sid, $type);
            if (!empty($row)) {
                $content = $row['tp_content'];
            } else {
                if ($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36) {
                    $print = plum_parse_config('typeSequence', 'print');
                } else {
                    $print = plum_parse_config('type', 'print');
                }

                $content = $print[$type]['content'];
            }
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
            if ($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36) {
                $trade = $trade_model->getSequenceTradeRowNew($tid);
            } else {
                $trade = $trade_model->getRowBySid($tid);
            }
            if (!empty($trade)) {
                $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
                if($cash) {
                    $list = $order_model->getGoodsDetailListByTid($trade['t_id']);
                } else {
                    $list = $order_model->getGoodsListByTid($trade['t_id']);
                }
               foreach ($list as $key => $value) {
                    $refund=$value['to_fd_status'] +$value['to_feedback'] +$value['to_fd_result'];
                    if($refund==7)
                        $list[$key]['to_title']='(已退款)'. $value['to_title'];
                }
                $content = $this->_str_replace_tag($content, $trade, $list);
                $tpl = 'wxapp/print/df_empty_' . $type . '.tpl';
            } else {
                $tpl = 'wxapp/print/df_tpl_' . $type . '.tpl';
            }
            $this->output['content'] = $content;
            $this->setLayout('default.tpl');
            $html = $this->fetchSmarty($tpl);
            $data = array(
                'ec' => 200,
                'data' => $html
            );
        }
        $this->displayJson($data);
    }

    
    public function _str_replace_tag($template, $orderRow, $list)
    {
        $payType = plum_parse_config('tradePayType');
        $status = App_Helper_Trade::$trade_status;
        $tbody = explode('<tbody>', $template);
        $endTbody = explode('</tbody>', $tbody[1]);
        $table = $endTbody[0];
        $t_arr = array();
        $totalMoney = 0;
        foreach ($list as $key => $val) {
            $temp = $table;
            $ret = str_replace('{Gid}', $key, $temp);
            $ret = str_replace('{Goods}', $val['to_title'], $ret);
            $ret = str_replace('{Number}', $val['to_num'], $ret);
            $ret = str_replace('{Price}', $val['to_price'], $ret);
            $ret = str_replace('{Money}', $val['to_total'], $ret);
            $ret = str_replace('{GfName}', $val['to_gf_name'], $ret);
            $t_arr[] = $ret;
            $totalMoney = $totalMoney + floatval($val['to_total']);
        }
        $template = preg_replace('/<tbody>(.*?)<\/tbody>/is', implode('', $t_arr), $template);
        $template = str_replace('{Date}', date('Y-m-d H:i:s', $orderRow['t_create_time']), $template);
        $template = str_replace('{OrderNumber}', $orderRow['t_tid'], $template);
        $template = str_replace('{PayType}', $payType[$orderRow['t_pay_type']], $template);
        $template = str_replace('{PayStatus}', $status[$orderRow['t_status']], $template);
        $template = str_replace('{Remark}', $orderRow['t_note'], $template);
        $template = str_replace('{Community}', $orderRow['asc_name'], $template);
        $template = str_replace('{CommunityAddr}', ($orderRow['asc_address'] . $orderRow['asc_address_detail']), $template);
        if ($orderRow['t_type'] == App_Helper_Trade::TRADE_APPOINTMENT || $orderRow['t_express_method'] == 2 || $orderRow['t_express_method'] == 6) {
            $template = str_replace('{Customer}', $orderRow['t_express_company'], $template);
            $template = str_replace('{Phone}', $orderRow['t_express_code'], $template);
            $template = str_replace('{Address}', $orderRow['t_address'], $template);
        } else {
            $template = str_replace('{Customer}', $orderRow['ma_name'], $template);
            $template = str_replace('{Phone}', $orderRow['ma_phone'], $template);
            $template = str_replace('{Address}', $orderRow['ma_province'] . $orderRow['ma_city'] . $orderRow['ma_zone'] . $orderRow['ma_detail'], $template);
        }
        $template = str_replace('{Discount}', ($orderRow['t_promotion_fee'] + $orderRow['t_discount_fee']), $template);
        $template = str_replace('{totalMoney}', $totalMoney, $template);
        if ($orderRow['t_gift']) {//赠品，微蛋糕
            $gift = json_decode($orderRow['t_gift'], true);
            foreach ($gift as $key => $value) {
                $template = str_replace('{Gift' . $key . '}', $value, $template);
            }
        }
        if ($orderRow['t_remark_extra']) {//自定义备注
            $remark = json_decode($orderRow['t_remark_extra'], true);
            $template .= "<div style='margin-left:20px'>";
            foreach ($remark as $key => $value) {
                if ($value['value']) {
                    $template .= "<div>";
                    if ($value['type'] != 'image') {
                        $template .= $value['name'] . ': ' . $value['value'];
                    } else {
                        $template .= $value['name'] . ': <img src="' . $value['value'] . '" width="50px">';
                    }
                    $template .= '</div>';
                }
            }
            $template .= '</div>';
        }
        return $template;

    }


    
    public function ticketPrintSetAction()
    {
        $this->secondLink('cfg');
        $this->buildBreadcrumbs(array(
            array('title' => '打印模板设置', 'link' => '#'),
        ));
        $print_storage = new App_Model_Print_MysqlPrintCfgStorage($this->curr_sid);
        $row = $print_storage->findRowBySid();
        if (!$row) {
            $row = plum_parse_config('default_cfg','print');
        }

        $showLegwork = 0;
        if (in_array($this->wxapp_cfg['ac_type'], [4, 6, 8, 21])) {
            $showLegwork = 1;
        }
        $this->output['showLegwork'] = $showLegwork;

        $this->output['row'] = $row;
        $this->displaySmarty('wxapp/print/ticket-set.tpl');
    }

    public function saveTicketPrintSetAction()
    {
        $feild = array('code_isprint', 'code_bold', 'time_isprint', 'time_bold', 'remark_isprint', 'remark_bold', 'discounts_isprint', 'discounts_bold', 'total_isprint',
            'total_bold', 'receiver_isprint', 'receiver_bold', 'address_isprint', 'address_bold', 'customs_isprint', 'customs_bold', 'print_type', 'print_num', 'qrcode_isprint', 'activity_isprint', 'activity_bold', 'community_isprint', 'community_bold', 'receivetime_isprint', 'receivetime_bold', 'esname_isprint', 'esname_bold', 'esphone_isprint', 'esphone_bold', 'leader_isprint', 'leader_bold', 'senddate_isprint', 'senddate_bold', 'comaddr_isprint', 'comaddr_bold', 'paytype_isprint', 'paytype_bold', 'goods_large', 'postfee_isprint', 'postfee_bold', 'legworknum_isprint', 'legworknum_bold', 'tablenum_large');
        $data = $this->getIntByField($feild, 'apc_');
        $print_storage = new App_Model_Print_MysqlPrintCfgStorage($this->curr_sid);
        $row = $print_storage->findRowBySid();
        if ($row) {
            $ret = $print_storage->findRowBySid($data);
        } else {
            $data['apc_s_id'] = $this->curr_sid;
            $data['apc_create_time'] = time();
            $ret = $print_storage->insertValue($data);
        }

        App_Helper_OperateLog::saveOperateLog("打印模板设置信息保存成功");
        $this->showAjaxResult($ret);
    }

    
    public function secondLink($type = 'list', $menu_num = 2)
    {
        if ($menu_num == 2)
            $link = array(
                array(
                    'label' => '打印机列表',
                    'link' => '/wxapp/print/feieList',
                    'active' => 'list'
                ),
                array(
                    'label' => '打印模板设置',
                    'link' => '/wxapp/print/ticketPrintSet',
                    'active' => 'cfg'
                ),
            );
        else {
            $link = [
                [
                    'label' => '打印机列表',
                    'link' => '/wxapp/print/feieList',
                    'active' => 'list'
                ],
            ];
        }
        $this->output['secondLink'] = $link;
        $this->output['linkType'] = $type;
        $this->output['snTitle'] = '云打印机';
    }


    
    public function feieListAction()
    {

        $this->buildBreadcrumbs(array(
            array('title' => '飞鹅打印机列表', 'link' => '#'),
        ));
        $feie_model = new App_Model_Feie_MysqlFeieListStorage($this->curr_sid);
        $region_helper = new App_Helper_SequenceRegion($this->curr_sid);
        $area_info = $region_helper->get_area_manager($this->uid, $this->company['c_id']);
        if ($area_info) {
            $list = $feie_model->findListBySid(0, $this->uid);
            $this->secondLink('list', 1);
            $this->output['region'] = 1;
        } else {
            $list = $feie_model->findListBySid();
            $this->secondLink('list');
        }
        $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($this->curr_sid);
        $row = $plugin_model->findUpdateBySid('qyhhr');

        if (!$row || $row['apo_expire_time'] < time()) {
            $this->output['show_printer_owner'] = 0;
        } else {
            $this->output['show_printer_owner'] = 1;
        }


        if ($list) {
            $feie_storage = new App_Plugin_Feieyun_Feieyun($this->curr_sid);
            $date = date('Y-m-d', time());
            foreach ($list as &$val) {
                $ret = $feie_storage->queryPrinterStatus($val['afl_sn']);
                if ($ret && $ret['ret'] == 0) {
                    $val['status'] = $ret['data'];
                }
                $orderInfo = $feie_storage->queryOrderInfoByDate($val['afl_sn'], $date);
                if ($orderInfo && $orderInfo['ret'] == 0) {
                    $val['orderNum'] = intval($orderInfo['data']['waiting']);
                }
            }
        }
        if (in_array($this->wxapp_cfg['ac_type'], [4, 6, 8])) {
            $this->output['esTrade'] = 1;
        }

        $firstCategory = [];
        $showCategory = 0;
        if ($this->wxapp_cfg['ac_type'] == 4) {
            $showCategory = 1;
            $firstCategory = $this->_first_goods_category(false);
        }
        $this->output['firstCategory'] = $firstCategory;
        $this->output['showCategory'] = $showCategory;

        $this->output['list'] = $list;
        $this->displaySmarty('wxapp/print/feieprint-list.tpl');
    }

    
    private function _first_goods_category($isJson = 1)
    {
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $first = $category_model->getListBySid();
        $temp = array();
        foreach ($first as $val) {
            if ($val['sk_level'] == 1) {
                $temp[$val['sk_id']] = array(
                    'id' => $val['sk_id'],
                    'index' => $val['sk_weight'],
                    'name' => $val['sk_name'],
                );
            }
        }
        if ($isJson) {
            $category = array();
            foreach ($temp as $tal) {
                $category[] = $tal;
            }
            return $category;
        } else {
            return $temp;
        }
    }

    
    public function savePrintNewAction()
    {
        $id = $this->request->getIntParam('id');
        $sn = $this->request->getStrParam('sn');
        $key = $this->request->getStrParam('key');
        $name = $this->request->getStrParam('name');
        $phoneNum = $this->request->getStrParam('phonenum');
        $kind1 = $this->request->getIntParam('kind1', 0);
        $data = array(
            'afl_key' => $key,
            'afl_name' => $name,
            'afl_phonenum' => $phoneNum,
            'afl_kind1' => $kind1
        );
        $feieyun_storage = new App_Plugin_Feieyun_Feieyun();
        if (!$sn || !$key) {
            $this->displayJsonError('请填写打印机编号');
        }

        $feie_model = new App_Model_Feie_MysqlFeieListStorage($this->curr_sid);
        $row = $feie_model->getRowById($id);
        if ($row) {
            if ($row['afl_sn'] == $sn) {
                $res = $feie_model->updateById($data, $id);
                $this->showAjaxResult($res);
            } else {
                $this->displayJsonError('如果修改打印机编号请删除后重新添加');
            }
        } else {
            $data['afl_sn'] = $sn;
            $data['afl_s_id'] = $this->curr_sid;
            $data['afl_create_time'] = time();
            $region_helper = new App_Helper_SequenceRegion($this->curr_sid);
            $area_info = $region_helper->get_area_manager($this->uid, $this->company['c_id']);
            if ($area_info)
                $data['afl_create_by'] = $this->uid;


            $exist = $feie_model->findRowBySidSn($sn, [], false, 0, false);
            if ($exist) {
                $exist_this = $feie_model->findRowBySidSn($sn, [], true);
                if ($exist_this) {
                    $this->displayJsonError('您已经有这个了');
                }
                $ret = $feie_model->insertValue($data);
                $this->showAjaxResult($ret);
            } else {
                $printContent = $sn . '# ' . $key . '# ';
                if ($name) {
                    $printContent = $printContent . $name . '# ';
                }
                if ($phoneNum) {
                    $printContent = $printContent . $phoneNum;
                }
                $result = $feieyun_storage->addprinter($printContent);
                if (is_array($result) && $result['ret'] == 0 && !empty($result['data']['ok'])) {
                    App_Helper_OperateLog::saveOperateLog("添加打印机，编号【" . $sn . "】");
                    $ret = $feie_model->insertValue($data);
                    $this->showAjaxResult($ret);
                } elseif (is_array($result) && $result['ret'] == 0 && !empty($result['data']['no'])) {
                    $this->displayJsonError($result['data']['no'][0]);
                } else {
                    $this->displayJsonError('添加失败，请稍后重试');
                }
            }
        }

    }

    
    public function printOperateAction()
    {
        $sn = $this->request->getStrParam('sn');
        $id = $this->request->getIntParam('id');
        $type = $this->request->getStrParam('type');
        $feie_model = new App_Model_Feie_MysqlFeieListStorage($this->curr_sid);
        $row = $feie_model->findRowBySidSn($sn);
        if ($row) {
            $feieyun_storage = new App_Plugin_Feieyun_Feieyun();
            switch ($type) {
                case 'delete' :
                    $where_del[] = ['name' => 'afl_sn', 'oper' => '=', 'value' => $sn];
                    $count = $feie_model->getCount($where_del);
                    if (intval($count) > 1) {
                        $result['ret'] = 0;
                    } else {
                        $result = $feieyun_storage->deletePrinter($sn);
                    }
                    $msg = '删除';
                    break;
                case 'waiting' :
                    $result = $feieyun_storage->deletePrinterOrder($sn);
                    $msg = '清空';
                    break;
                case 'test' :
                    $orderInfo = self::_fetch_order_info();
                    $result = $feieyun_storage->printOrder($sn, $orderInfo);
                    $msg = '发送';
                    break;
                case 'automatic' :
                    if ($row['afl_automatic'] == 1) {
                        $msg = '关闭';
                        $update = array('afl_automatic' => 0);
                    } else {
                        $msg = '开启';
                        $update = array('afl_automatic' => 1);
                    }
                    $ret = $feie_model->findRowBySidSn($sn, $update);
                    if ($ret) {
                        $result = array(
                            'ret' => 0
                        );
                    }
                    break;
                case 'estrade' :
                    if ($row['afl_es_trade'] == 1) {
                        $msg = '关闭';
                        $update = array('afl_es_trade' => 0);
                    } else {
                        $msg = '开启';
                        $update = array('afl_es_trade' => 1);
                    }
                    $ret = $feie_model->findRowBySidSn($sn, $update);
                    if ($ret) {
                        $result = array(
                            'ret' => 0
                        );
                    }
                    break;
            }
            if (is_array($result) && $result['ret'] == 0) {
                if ($type == 'delete') {
                    $feie_model->deleteById($id);
                }
                $this->showAjaxResult(1, $msg);
            } else {
                $this->displayJsonError($msg . '失败，请稍后重试');
            }
        } else {
            $this->displayJsonError('打印机不存在');
        }
    }

    
    public function _fetch_order_info()
    {
        $orderInfo = '<CB>测试打印</CB><BR>';
        $orderInfo .= '名称　　　　　 单价  数量 金额<BR>';
        $orderInfo .= '--------------------------------<BR>';
        $orderInfo .= '饭　　　　　 　10.0   10  10.0<BR>';
        $orderInfo .= '炒饭　　　　　 10.0   10  10.0<BR>';
        $orderInfo .= '蛋炒饭　　　　 10.0   100 100.0<BR>';
        $orderInfo .= '鸡蛋炒饭　　　 100.0  100 100.0<BR>';
        $orderInfo .= '西红柿炒饭　　 1000.0 1   100.0<BR>';
        $orderInfo .= '西红柿蛋炒饭　 100.0  100 100.0<BR>';
        $orderInfo .= '西红柿鸡蛋炒饭 15.0   1   15.0<BR>';
        $orderInfo .= '备注：加辣<BR>';
        $orderInfo .= '--------------------------------<BR>';
        $orderInfo .= '合计：xx.0元<BR>';
        $orderInfo .= '送货地点：郑州市金水区xx路xx号<BR>';
        $orderInfo .= '联系电话：13888888888888<BR>';
        $orderInfo .= '订餐时间：2016-08-08 08:08:08<BR>';
        $orderInfo .= '<QR>http://www.tiandiantong.com</QR>';//把二维码字符串用标签套上即可自动生成二维码
        return $orderInfo;
    }

    
    public function sequencePrintShowAction()
    {
        $data = array(
            'ec' => 400,
            'em' => '模版类型错误'
        );
        $type = $this->request->getIntParam('type');
        $id = $this->request->getStrParam('id');

        $print = plum_parse_config('printFormSeq', 'print');
        $content = $print[$type]['content'];

        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage(0);
        $community = $community_model->getCommunityLeaderRow($id);

        $community['shop_phone'] = $this->curr_shop['s_phone'];
        $community['send_number'] = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->curr_sid);
        $community['line_name'] = '';
        $community['line_mobile'] = '';
        if ($type == 2) {
            $route_detail_model = new App_Model_Sequence_MysqlSequenceDeliveryroutedetailStorage($this->curr_sid);
            $route_info = $route_detail_model->getRouteInfo($community['asc_id']);
            $community['line_name'] = $route_info['asdr_name'];
            $community['line_mobile'] = $route_info['asdr_delivery_mobile'];
        }

        if (!empty($community)) {
            $time_0 = strtotime(date('Y-m-d'));
            $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
            $where = [];
            $where[] = ['name' => 'to_s_id', 'oper' => '=', 'value' => $this->curr_sid];
            $where[] = ['name' => 't_home_id', 'oper' => '=', 'value' => $community['asc_id']];
            $where[] = ['name' => 'to_create_time', 'oper' => '>', 'value' => $time_0];
            $where[] = ['name' => 't_status', 'oper' => '>=', 'value' => 3];
            $where[] = ['name' => 't_status', 'oper' => '<', 'value' => 6];
            $list = $order_model->getListTradeGoods($where, 0, 0, []);
            $data = [];
            if ($list) {
                $kindData = [];
                $kind_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
                $kindList = $kind_model->getAllSonCategorySortAsc(0,0);
                if ($kindList) {
                    foreach ($kindList as $kind) {
                        $kindData[$kind['sk_id']] = $kind['sk_name'];
                    }
                }
                foreach ($list as $key => &$item) {
                    $item['category'] = $kindData[$item['g_kind2']] ? $kindData[$item['g_kind2']] : '';
                    if ($type == 1) {
                        if (array_key_exists($item['to_m_nickname'], $data)) {
                            $goods_key = $item['to_g_id'] . '-' . $item['to_gf_id'];
                            if (array_key_exists($goods_key, $data[$item['to_m_nickname']]['goods'])) {
                                $data[$item['to_m_nickname']]['goods'][$goods_key]['num'] += $item['to_num'];
                                $data[$item['to_m_nickname']]['goods'][$goods_key]['total'] += $item['to_total'];
                            } else {
                                $data[$item['to_m_nickname']]['goods'][$goods_key] = [
                                    'gname' => $item['to_title'],
                                    'gfname' => $item['to_gf_name'],
                                    'date' => date('m-d h:i', $item['to_create_time']),
                                    'num' => $item['to_num'],
                                    'total' => $item['to_total']
                                ];
                            }
                        } else {
                            $data[$item['to_m_nickname']] = [
                                'nickname' => $item['to_m_nickname'],
                                'goods' => []
                            ];
                            $goods_key = $item['to_g_id'] . '-' . $item['to_gf_id'];
                            $data[$item['to_m_nickname']]['goods'][$goods_key] = [
                                'gname' => $item['to_title'],
                                'gfname' => $item['to_gf_name'],
                                'date' => date('m-d h:i', $item['to_create_time']),
                                'num' => $item['to_num'],
                                'total' => $item['to_total']
                            ];
                        }

                    } elseif ($type == 2) {
                        if (array_key_exists($item['category'], $data)) {
                            $goods_key = $item['to_g_id'] . '-' . $item['to_gf_id'];
                            if (array_key_exists($goods_key, $data[$item['category']]['goods'])) {
                                $data[$item['category']]['goods'][$goods_key]['num'] += $item['to_num'];
                            } else {
                                $data[$item['category']]['goods'][$goods_key] = [
                                    'gname' => $item['to_title'],
                                    'gfname' => $item['to_gf_name'],
                                    'num' => $item['to_num'],
                                ];
                            }

                        } else {
                            $data[$item['category']] = [
                                'category' => $item['category'],
                                'goods' => []
                            ];
                            $goods_key = $item['to_g_id'] . '-' . $item['to_gf_id'];
                            $data[$item['category']]['goods'][$goods_key] = [
                                'gname' => $item['to_title'],
                                'gfname' => $item['to_gf_name'],
                                'num' => $item['to_num'],
                            ];
                        }
                    }
                }
            }

            $content = $this->_str_replace_tag_seq_new($content, $community, $data, $type);
            $tpl = 'wxapp/print/df_seq_empty_' . $type . '.tpl';
        } else {
            $tpl = 'wxapp/print/df_seq_' . $type . '.tpl';
        }
        $this->output['content'] = $content;
        $this->setLayout('default.tpl');
        $html = $this->fetchSmarty($tpl);
        $data = array(
            'ec' => 200,
            'data' => $html
        );


        $this->displayJson($data);
    }


    public function sequencePrintShowGoodsAction()
    {
        $data = array(
            'ec' => 400,
            'em' => '模版类型错误'
        );
        $type = $this->request->getIntParam('print_type');
        $start_date = $this->request->getStrParam('print_start_date');
        $end_date = $this->request->getStrParam('print_end_date');

        $start_time = $this->request->getStrParam('print_start_time');
        $end_time = $this->request->getStrParam('print_end_time');

        $startTime = 0;
        $endTime = 0;

        if ($start_date && $end_date && $start_time && $end_time) {
            $startTime = strtotime($start_date . ' ' . $start_time);
            $endTime = strtotime($end_date . ' ' . $end_time);
        } else {
            $this->displayJsonError('请选择完整的时间');
        }


        $print = plum_parse_config('printFormSeq', 'print');
        $content = $print[$type]['content'];

        $community['shop_phone'] = $this->curr_shop['s_phone'];
        $community['send_number'] = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->curr_sid);

        $time_0 = strtotime(date('Y-m-d'));
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
        $where = [];
        $where[] = ['name' => 'to_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where[] = ['name' => 'to_create_time', 'oper' => '>', 'value' => $startTime];
        $where[] = ['name' => 'to_create_time', 'oper' => '<', 'value' => $endTime];

        $where[] = ['name' => 't_status', 'oper' => '>=', 'value' => 3];
        $where[] = ['name' => 't_status', 'oper' => '<', 'value' => 6];
        $list = $order_model->getListTradeGoodsCommunity($where, 0, 0, []);
        $data = [];
        if ($list) {
            foreach ($list as $item) {
                $key = $item['to_g_id'] . '-' . $item['to_gf_id'];
                if (array_key_exists($key, $data)) {
                    if (array_key_exists($item['t_home_id'], $data[$key]['community'])) {
                        $data[$key]['community'][$item['t_home_id']]['num'] = $data[$key]['community'][$item['t_home_id']]['num'] + $item['to_num'];
                    } else {
                        $data[$key]['community'][$item['t_home_id']] = [
                            'name' => $item['asc_name'],
                            'num' => $item['to_num']
                        ];
                    }
                } else {
                    $data[$key] = [
                        'gname' => $item['to_title'],
                        'gfname' => $item['to_gf_name'],
                        'community' => []
                    ];
                    $data[$key]['community'][$item['t_home_id']] = [
                        'name' => $item['asc_name'],
                        'num' => $item['to_num']
                    ];
                }
            }
        }


        if (!empty($data)) {

            $content = $this->_str_replace_tag_seq_new($content, $community, $data, $type);
            $tpl = 'wxapp/print/df_seq_empty_' . $type . '.tpl';
        } else {
            $tpl = 'wxapp/print/df_seq_' . $type . '.tpl';
        }
        $this->output['content'] = $content;
        $this->setLayout('default.tpl');
        $html = $this->fetchSmarty($tpl);
        $data = array(
            'ec' => 200,
            'data' => $html
        );


        $this->displayJson($data);
    }


    
    public function _str_replace_tag_seq($template, $orderRow, $list)
    {
        $tbody = explode('<tbody>', $template);
        $endTbody = explode('</tbody>', $tbody[1]);
        $table = $endTbody[0];
        $t_arr = array();
        $totalMoney = 0;
        $totalNum = 0;
        foreach ($list as $key => $val) {
            $temp = $table;
            $ret = str_replace('{OrderTime}', date('m-d H:i', $val['to_create_time']), $temp);
            $ret = str_replace('{MemberName}', $val['to_m_nickname'], $ret);
            $ret = str_replace('{GoodsName}', $val['to_title'], $ret);
            $ret = str_replace('{GoodsFormat}', $val['to_gf_name'], $ret);
            $ret = str_replace('{GoodsNum}', $val['to_num'], $ret);
            $ret = str_replace('{GoodsMoney}', $val['to_total'], $ret);

            $category = $val['category'] ? $val['category'] : '';
            $ret = str_replace('{GoodsCategory}', $category, $ret);
            $t_arr[] = $ret;
            $totalNum = $totalNum + $val['to_num'];
        }
        $template = preg_replace('/<tbody>(.*?)<\/tbody>/is', implode('', $t_arr), $template);
        $template = str_replace('{SendTime}', date('Y-m-d H:i:s', time()), $template);
        $template = str_replace('{SendNumber}', $orderRow['send_number'], $template);
        $template = str_replace('{LeaderName}', $orderRow['asl_name'], $template);
        $template = str_replace('{LeaderMobile}', $orderRow['asl_mobile'], $template);
        $template = str_replace('{CommunityName}', $orderRow['asc_name'], $template);
        $template = str_replace('{Shopphone}', $orderRow['shop_phone'], $template);

        $address = $orderRow['asc_address'] . $orderRow['asc_address_detail'];
        $template = str_replace('{CommunityAddress}', $address, $template);
        $template = str_replace('{GoodsTotal}', $totalNum, $template);
        $template = str_replace('{LineName}', $orderRow['line_name'], $template);
        $template = str_replace('{LineMobile}', $orderRow['line_mobile'], $template);


        return $template;

    }


    
    public function _str_replace_tag_seq_new($template, $orderRow, $list, $type)
    {
        $tbody = explode('<tbody>', $template);
        $endTbody = explode('</tbody>', $tbody[1]);
        $table = $endTbody[0];
        $t_arr = array();
        $totalMoney = 0;
        $totalNum = 0;

        if ($type == 1) {
            foreach ($list as $key => $val) {
                $rowspan = count($val['goods']);
                $i = 0;
                foreach ($val['goods'] as $index => $row) {
                    $ret = "<tr>";
                    $ret .= "<td>{$row['date']}</td>";
                    if ($rowspan > 1) {
                        if ($i == 0) {
                            $ret .= "<td rowspan='{$rowspan}'>{$val['nickname']}</td>";
                        } else {
                            $ret .= '';
                        }
                    } else {
                        $ret .= "<td>{$val['nickname']}</td>";
                    }
                    $ret .= "<td>{$row['gname']}</td>";
                    $ret .= "<td>{$row['gfname']}</td>";
                    $ret .= "<td>{$row['num']}</td>";
                    $ret .= "<td>{$row['total']}</td>";
                    $ret .= "</tr>";
                    $totalNum = $totalNum + $row['num'];
                    $t_arr[] = $ret;
                    $i++;
                }
            }
        } elseif ($type == 2) {
            foreach ($list as $key => $val) {
                $rowspan = count($val['goods']);
                $i = 0;
                foreach ($val['goods'] as $index => $row) {
                    $ret = "<tr>";
                    if ($rowspan > 1) {
                        if ($i == 0) {
                            $ret .= "<td rowspan='{$rowspan}'>{$val['category']}</td>";
                        } else {
                            $ret .= '';
                        }
                    } else {
                        $ret .= "<td>{$val['category']}</td>";
                    }
                    $ret .= "<td>{$row['gname']}</td>";
                    $ret .= "<td>{$row['gfname']}</td>";
                    $ret .= "<td>{$row['num']}</td>";
                    $ret .= "<td></td>";
                    $ret .= "</tr>";
                    $totalNum = $totalNum + $row['num'];
                    $t_arr[] = $ret;
                    $i++;
                }
            }
        } elseif ($type == 3) {
            foreach ($list as $key => $val) {
                $goods_name = $val['gname'] . '<br>' . $val['gfname'];
                $rowspan = count($val['community']);
                $i = 0;
                foreach ($val['community'] as $index => $row) {
                    $ret = "<tr>";
                    if ($rowspan > 1) {
                        if ($i == 0) {
                            $ret .= "<td rowspan='{$rowspan}'>{$goods_name}</td>";
                        } else {
                            $ret .= '';
                        }
                    } else {
                        $ret .= "<td>{$goods_name}</td>";
                    }
                    $ret .= "<td>{$row['name']}</td>";
                    $ret .= "<td>{$row['num']}</td>";
                    $ret .= "<td></td>";
                    $ret .= "</tr>";
                    $totalNum = $totalNum + $row['num'];
                    $t_arr[] = $ret;
                    $i++;
                }
            }
        }
        $template = preg_replace('/<tbody>(.*?)<\/tbody>/is', implode('', $t_arr), $template);
        $template = str_replace('{SendTime}', date('Y-m-d H:i:s', time()), $template);
        $template = str_replace('{SendNumber}', $orderRow['send_number'], $template);
        $template = str_replace('{LeaderName}', $orderRow['asl_name'], $template);
        $template = str_replace('{LeaderMobile}', $orderRow['asl_mobile'], $template);
        $template = str_replace('{CommunityName}', $orderRow['asc_name'], $template);
        $template = str_replace('{Shopphone}', $orderRow['shop_phone'], $template);
        $template = str_replace('{GoodsTotal}', $totalNum, $template);
        $address = $orderRow['asc_address'] . $orderRow['asc_address_detail'];
        $template = str_replace('{CommunityAddress}', $address, $template);

        $template = str_replace('{LineName}', $orderRow['line_name'], $template);
        $template = str_replace('{LineMobile}', $orderRow['line_mobile'], $template);


        return $template;

    }

    public function sequencePrintWordAction()
    {
        $type = $this->request->getIntParam('type');
        $id = $this->request->getStrParam('id');

        $start_date = $this->request->getStrParam('print_start_date');
        $end_date = $this->request->getStrParam('print_end_date');

        $start_time = $this->request->getStrParam('print_start_time');
        $end_time = $this->request->getStrParam('print_end_time');

        $order_status = $this->request->getIntParam('order_status');

        $goods_name = $this->request->getStrParam('goods_name');

        $startTime = 0;
        $endTime = 0;

        if ($start_date && $end_date && $start_time && $end_time) {
            $startDate = $start_date . ' ' . $start_time;
            $endDate = $end_date . ' ' . $end_time;
            $startTime = strtotime($startDate);
            $endTime = strtotime($endDate);
        } else {
            plum_url_location('请选择完整的时间');
        }

        if($startTime >=  $endTime){
            plum_url_location('开始时间应小于结束时间');
        }

        $days = floor(($endTime-$startTime)/86400);
        if($days > 15){
            plum_url_location('两时间相差不能超过15天');
        }

        if($this->curr_sid == 9373){
            $print = plum_parse_config('printWordSeqCustom', 'print');
        }else{
            $print = plum_parse_config('printWordSeq', 'print');
        }
        $logo_path = plum_parse_config('logoPath', 'print');
        $logo_path = $this->dealImagePath($logo_path);
        $content = $print[$type]['content'];

        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage(0);
        $route_model = new App_Model_Sequence_MysqlSequenceDeliveryrouteStorage(0);
        $route_detail_model = new App_Model_Sequence_MysqlSequenceDeliveryroutedetailStorage($this->curr_sid);
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);


        $kind_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $kindList = $kind_model->getAllSonCategorySortAsc(0,0);
        $kindData = [];
        if ($kindList) {
            foreach ($kindList as $kind) {
                $kindData[$kind['sk_id']] = $kind['sk_name'];
            }
        }

        $where_route = [];
        $where_route[] = ['name' => 'asdrt_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_route[] = ['name' => 'asdrt_dr_id', 'oper' => '=', 'value' => $id];
        $route_community_list = $route_detail_model->getList($where_route, 0, 0, ['asdrt_sort' => 'DESC']);
        $route_info = $route_model->getRowById($id);
        $community_ids = [];
        $page_data = [];
        $page_community = [];
        if ($route_community_list) {
            foreach ($route_community_list as $route_row) {
                $community_ids[] = $route_row['asdrt_community_id'];
            }
        }

        $title_str = '';
        if($type == 1){
            $title_str = '路线「'.$route_info['asdr_name'].'」'.'提货单';
        }elseif ($type == 2){
            $title_str = '路线「'.$route_info['asdr_name'].'」'.'交货单';
        }

        if (!empty($community_ids)) {
            foreach ($community_ids as $id) {
                $community = $community_model->getCommunityLeaderRow($id);
                $community['shop_phone'] = $this->curr_shop['s_phone'];
                $community['send_number'] = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->curr_sid);
                $community['line_name'] = '';
                $community['line_mobile'] = '';
                $community['line_name'] = $route_info['asdr_name'];
                $community['line_mobile'] = $route_info['asdr_delivery_mobile'];
                $community['logo_path'] = $logo_path;

                if (!empty($community)) {
                    $where = [];
                    $where[] = ['name' => 'to_s_id', 'oper' => '=', 'value' => $this->curr_sid];
                    $where[] = ['name' => 'to_fd_status', 'oper' => '!=', 'value' => 3];//未被退款
                    $where[] = ['name' => 't_home_id', 'oper' => '=', 'value' => $community['asc_id']];

                    if($goods_name){
                        $where[] = ['name' => 'to_title', 'oper' => 'like', 'value' => "%{$goods_name}%"];
                    }

                    $where[] = ['name' => 'to_create_time', 'oper' => '>=', 'value' => $startTime];
                    $where[] = ['name' => 'to_create_time', 'oper' => '<=', 'value' => $endTime];

                    switch ($order_status){
                        case 1:
                            $where[] = ['name' => 't_status', 'oper' => '>=', 'value' => 3];
                            $where[] = ['name' => 't_status', 'oper' => '<', 'value' => 6];
                            break;
                        case 2:
                            $where[] = ['name' => 't_status', 'oper' => '=', 'value' => 6];
                            break;
                        case 3:
                            $where[] = ['name' => 't_status', 'oper' => '>=', 'value' => 3];
                            $where[] = ['name' => 't_status', 'oper' => '<=', 'value' => 6];
                            break;
                        default:
                            $where[] = ['name' => 't_status', 'oper' => '>=', 'value' => 3];
                            $where[] = ['name' => 't_status', 'oper' => '<', 'value' => 6];
                    }
                    $sequence_day=$this->request->getIntParam('sequence_day',0);
                    if($sequence_day==0){
                        $where[]=['name'=>'to_se_send_time','oper'=>'<=','value'=>$endTime];
                    }

                    $list = $order_model->getListTradeGoods($where, 0, 0, []);
                    $data = [];
                    if ($list) {

                        foreach ($list as $key => &$item) {
                            $item['category'] = $kindData[$item['g_kind2']] ? $kindData[$item['g_kind2']] : '';
                            if ($type == 1) {
                                $member_phone = $item['t_express_code'] ? $item['t_express_code'] : ($item['ma_phone'] ? $item['ma_phone'] :'none');
                                if (array_key_exists($member_phone, $data)) {
                                    $goods_key = $item['to_g_id'] . '-' . $item['to_gf_id'];
                                    if (array_key_exists($goods_key, $data[$member_phone]['goods'])) {
                                        $data[$member_phone]['goods'][$goods_key]['num'] += $item['to_num'];
                                        $data[$member_phone]['goods'][$goods_key]['total'] += $item['to_total'];
                                    } else {
                                        $data[$member_phone]['goods'][$goods_key] = [
                                            'gname' => $item['to_title'],
                                            'gfname' => $item['to_gf_name'],
                                            'date' => date('m-d h:i', $item['to_create_time']),
                                            'num' => $item['to_num'],
                                            'total' => $item['to_price']
                                        ];
                                    }
                                } else {
                                    $data[$member_phone] = [
                                        'nickname' => $item['t_express_company'] ? $item['t_express_company'] : ($item['ma_name'] ? $item['ma_name'] : $item['to_m_nickname']),
                                        'phone' => $item['t_express_code'] ? $item['t_express_code'] : ($item['ma_phone'] ? $item['ma_phone'] :''),
                                        'goods' => []
                                    ];
                                    $goods_key = $item['to_g_id'] . '-' . $item['to_gf_id'];
                                    $data[$member_phone]['goods'][$goods_key] = [
                                        'gname' => $item['to_title'],
                                        'gfname' => $item['to_gf_name'],
                                        'date' => date('m-d h:i', $item['to_create_time']),
                                        'num' => $item['to_num'],
                                        'total' => $item['to_price']
                                    ];
                                }

                            } elseif ($type == 2) {
                                if (array_key_exists($item['category'], $data)) {
                                    $goods_key = $item['to_g_id'] . '-' . $item['to_gf_id'];
                                    if (array_key_exists($goods_key, $data[$item['category']]['goods'])) {
                                        $data[$item['category']]['goods'][$goods_key]['num'] += $item['to_num'];
                                    } else {
                                        $data[$item['category']]['goods'][$goods_key] = [
                                            'gname' => $item['to_title'],
                                            'gfname' => $item['to_gf_name'],
                                            'num' => $item['to_num'],
                                        ];
                                    }

                                } else {
                                    $data[$item['category']] = [
                                        'category' => $item['category'],
                                        'goods' => []
                                    ];
                                    $goods_key = $item['to_g_id'] . '-' . $item['to_gf_id'];
                                    $data[$item['category']]['goods'][$goods_key] = [
                                        'gname' => $item['to_title'],
                                        'gfname' => $item['to_gf_name'],
                                        'num' => $item['to_num'],
                                    ];
                                }
                            }
                        }
                    }
                    $page_community[$id] = $community;
                    if (isset($data) && !empty($data)) {
                        $page_data[$id] = $data;
                    }
                }
            }

            if(!empty($page_data)){
                $startDate = date('Y-m-d-H_i_s',$startTime);
                $endDate = date('Y-m-d-H_i_s',$endTime);
                if($this->curr_sid == 9373){
                    $content = $this->_str_replace_tag_seq_word_custom($content, $page_community, $page_data, $type);
                }else{
                    $content = $this->_str_replace_tag_seq_word($content, $page_community, $page_data, $type);
                }
                $filename = $title_str.'（'.$startDate.'-'.$endDate.'）'.'.doc';
                    $this->downloadWord($content,$filename);

            }else{
                plum_url_location('当前路线中没有商品');
            }
        } else {
            plum_url_location('当前路线中没有小区');
        }
    }


    
    public function _str_replace_tag_seq_word($template, $row_data, $data, $type)
    {
        $td_style = 'text-align:left;padding:2px;border:1.4px solid #000;';
        $td_style_big = 'text-align:center;padding:2px;border:1.4px solid #000;font-size:13px !important';
        $print_str = '';
        $page = 1;
        $template_old = $template;
        $page_count = count($data);
        foreach ($data as $com_id => $list) {
            $template = $template_old;
            $orderRow = $row_data[$com_id];
            $tbody = explode('<tbody>', $template);
            $endTbody = explode('</tbody>', $tbody[1]);
            $table = $endTbody[0];
            $t_arr = array();
            $totalMoney = 0;
            $totalNum = 0;
            $row_num = 1;
            if ($type == 1) {
                foreach ($list as $key => $val) {
                    $rowspan = count($val['goods']);
                    $i = 1;
                    foreach ($val['goods'] as $index => $row) {
                        $ret = "<tr>";
                        $ret .= "<td style='{$td_style_big}'>{$row_num}</td>";
                        $ret .= "<td style='{$td_style}'>{$row['date']}</td>";
                        if ($rowspan > 1) {
                            if ($i == 1) {
                                $ret .= "<td rowspan='{$rowspan}' style='{$td_style}'>{$val['nickname']}</td>";
                                $ret .= "<td rowspan='{$rowspan}' style='{$td_style}'>{$val['phone']}</td>";
                            } else {
                                $ret .= '';
                                $ret .= '';
                            }
                        } else {
                            $ret .= "<td style='{$td_style}'>{$val['nickname']}</td>";
                            $ret .= "<td style='{$td_style}'>{$val['phone']}</td>";
                        }
                        $ret .= "<td style='{$td_style}'>{$row['gname']}</td>";
                        $ret .= "<td style='{$td_style_big}'>{$row['num']}</td>";
                        $ret .= "<td style='{$td_style}'>{$row['gfname']}</td>";
                        $ret .= "<td style='{$td_style}'>{$row['total']}</td>";
                        $ret .= "</tr>";
                        $totalNum = $totalNum + $row['num'];
                        $t_arr[] = $ret;
                        $i++;
                        $row_num++;
                    }
                }
            } elseif ($type == 2) {
                foreach ($list as $key => $val) {
                    $rowspan = count($val['goods']);
                    $i = 1;
                    foreach ($val['goods'] as $index => $row) {
                        $ret = "<tr>";
                        $ret .= "<td style='{$td_style_big}'>{$row_num}</td>";
                        if ($rowspan > 1) {
                            if ($i == 1) {
                                $ret .= "<td rowspan='{$rowspan}' style='{$td_style}'>{$val['category']}</td>";
                            } else {
                                $ret .= '';
                            }
                        } else {
                            $ret .= "<td style='{$td_style}'>{$val['category']}</td>";
                        }
                        $ret .= "<td style='{$td_style}'>{$row['gname']}</td>";
                        $ret .= "<td style='{$td_style_big}'>{$row['num']}</td>";
                        $ret .= "<td style='{$td_style}'>{$row['gfname']}</td>";
                        $ret .= "<td style='{$td_style}'></td>";
                        $ret .= "</tr>";
                        $totalNum = $totalNum + $row['num'];
                        $t_arr[] = $ret;
                        $i++;
                        $row_num++;
                    }
                }
            } elseif ($type == 3) {
                foreach ($list as $key => $val) {
                    $goods_name = $val['gname'] . '<br>' . $val['gfname'];
                    $rowspan = count($val['community']);
                    $i = 1;
                    foreach ($val['community'] as $index => $row) {
                        $ret = "<tr>";
                        $ret .= "<td style='{$td_style_big}'>{$row_num}</td>";
                        if ($rowspan > 1) {
                            if ($i == 1) {
                                $ret .= "<td rowspan='{$rowspan}' style='{$td_style}'>{$goods_name}</td>";
                            } else {
                                $ret .= '';
                            }
                        } else {
                            $ret .= "<td style='{$td_style}'>{$goods_name}</td>";
                        }
                        $ret .= "<td style='{$td_style}'>{$row['name']}</td>";
                        $ret .= "<td style='{$td_style_big}'>{$row['num']}</td>";
                        $ret .= "<td style='{$td_style}'></td>";
                        $ret .= "</tr>";
                        $totalNum = $totalNum + $row['num'];
                        $t_arr[] = $ret;
                        $i++;
                        $row_num++;
                    }
                }
            }
            $template = preg_replace('/<tbody>(.*?)<\/tbody>/is', implode('', $t_arr), $template);
            $template = str_replace('{SendTime}', date('Y-m-d H:i:s', time()), $template);
            $template = str_replace('{SendNumber}', $orderRow['send_number'], $template);
            $template = str_replace('{LeaderName}', $orderRow['asl_name'], $template);
            $template = str_replace('{LeaderMobile}', $orderRow['asl_mobile'], $template);
            $template = str_replace('{CommunityName}', $orderRow['asc_name'], $template);
            $template = str_replace('{Shopphone}', $orderRow['shop_phone'], $template);
            $template = str_replace('{GoodsTotal}', $totalNum, $template);
            $address = $orderRow['asc_address'] . $orderRow['asc_address_detail'];
            $template = str_replace('{CommunityAddress}', $address, $template);

            $template = str_replace('{LineName}', $orderRow['line_name'], $template);
            $template = str_replace('{LineMobile}', $orderRow['line_mobile'], $template);

            $print_str .= $template;
            if ($page < $page_count) {
                $print_str .= "<span><br clear=all style = 'page-break-before:always' ></span>";
            }

            $page++;
        }


        return $print_str;

    }


    
    public function _str_replace_tag_seq_word_custom($template, $row_data, $data, $type)
    {
        $font_size = 'font-size:13px !important;';
        $text_align_center = 'text-align:center;';
        $text_align_left = 'text-align:left;';
        $td_style = $text_align_left.'padding:2px;border:1.4px solid #000;';
        $td_style_center = $text_align_center.'padding:2px;border:1.4px solid #000;';
        $td_style_big = $text_align_center.$font_size.'padding:2px;border:1.4px solid #000;';
        $td_rowspan_start = $text_align_left.'padding:2px;border-left: 1.4px solid #000;border-top: 1.4px solid #000;border-right: 1.4px solid #000;border-bottom: none;';
        $td_rowspan_normal = $text_align_left.'padding:2px;border-left: 1.4px solid #000;border-top: none;border-right: 1.4px solid #000;border-bottom: none';
        $td_rowspan_end = $text_align_left.'padding:2px;border-left: 1.4px solid #000;border-top: none #000;border-right: 1.4px solid #000;border-bottom: 1.4px solid #000;';
        $td_rowspan_total_top = $text_align_center.'padding:2px;border-left: 1.4px solid #000;border-top: 1.4px solid #000;border-right: 1.4px solid #000;border-bottom: none;';
        $td_rowspan_total_bottom = $text_align_center.'padding:2px;border-left: 1.4px solid #000;border-top: none;border-right: 1.4px solid #000;border-bottom: 1.4px solid #000;';
        $td_item_start = $text_align_left.'padding:2px;border-left: 1.4px solid #000;border-top: 1.4px solid #000;border-right: 1.4px solid #000;border-bottom: 0.75px dashed #666;';
        $td_item_normal = $text_align_left.'padding:2px;border-left: 1.4px solid #000;border-top: none;border-right: 1.4px solid #000;border-bottom: 0.75px dashed #666;';
        $td_item_end = $text_align_left.'padding:2px;border-left: 1.4px solid #000;border-top: none #000;border-right: 1.4px solid #000;border-bottom: 1.4px solid #000;';
        $td_item_left_start = 'padding:2px;border-left: 1.4px solid #000;border-top: 1.4px solid #000;border-right: 0.75px dashed #666;border-bottom: 0.75px dashed #666;';
        $td_item_left_normal = 'padding:2px;border-left: 1.4px solid #000;border-top: none;border-right: 0.75px dashed #666;border-bottom: 0.75px dashed #666;';
        $td_item_left_end = 'padding:2px;border-left: 1.4px solid #000;border-top: none;border-right: 0.75px dashed #666;border-bottom: 1.4px solid #000;';
        $td_item_normal_start = 'padding:2px;border-left:none;border-top: 1.4px solid #000;border-right: 0.75px dashed #666;border-bottom: 0.75px dashed #666;';
        $td_item_normal_normal = 'padding:2px;border-left:none;border-top: none;border-right: 0.75px dashed #666;border-bottom: 0.75px dashed #666;';
        $td_item_normal_end = 'padding:2px;border-left:none;border-top: none;border-right: 0.75px dashed #666;border-bottom: border-top: 1.4px solid #000;';
        $td_item_right_start = 'padding:2px;border-left:none;border-top: 1.4px solid #000;border-right: 1.4px solid #000;;border-bottom: 0.75px dashed #666;';
        $td_item_right_normal = 'padding:2px;border-left:none;border-top: none;border-right: 1.4px solid #000;;border-bottom: 0.75px dashed #666;';
        $td_item_right_end = 'padding:2px;border-left:none;border-top: none;border-right: 1.4px solid #000;border-bottom: border-top: 1.4px solid #000;';

        $print_str = '';
        $page = 1;
        $template_old = $template;
        $page_count = count($data);
        foreach ($data as $com_id => $list) {
            $template = $template_old;
            $orderRow = $row_data[$com_id];
            $tbody = explode('<tbody>', $template);
            $endTbody = explode('</tbody>', $tbody[1]);
            $table = $endTbody[0];
            $t_arr = array();
            $totalMoney = 0;
            $totalNum = 0;
            $row_num = 1;
            if ($type == 1) {
                foreach ($list as $key => $val) {
                    $rowspan = count($val['goods']);
                    $i = 1;
                    foreach ($val['goods'] as $index => $row) {
                        $ret = "<tr>";
                        $ret .= "<td style='{$td_style_big}'>{$row_num}</td>";
                        $ret .= "<td style='{$td_style}'>{$row['date']}</td>";
                        if ($rowspan > 1) {
                            if($i == 1){
                                $ret .= "<td style='{$td_rowspan_start}'>{$val['nickname']}</td>";
                                $ret .= "<td style='{$td_rowspan_start}'>{$val['phone']}</td>";

                                $style = $td_item_left_start.$text_align_left;
                                $ret .= "<td style='{$style}'>{$row['gname']}</td>";

                                $style = $td_item_normal_start.$text_align_center.$font_size;
                                $ret .= "<td style='{$style}'>{$row['num']}</td>";

                                $style = $td_item_normal_start.$text_align_left;
                                $ret .= "<td style='{$style}'>{$row['gfname']}</td>";

                                $style = $td_item_right_start.$text_align_left;
                                $ret .= "<td style='{$style}'>{$row['total']}</td>";

                            }elseif ($i == $rowspan){
                                $ret .= "<td style='{$td_rowspan_end}'>{$val['nickname']}</td>";
                                $ret .= "<td style='{$td_rowspan_end}'>{$val['phone']}</td>";

                                $style = $td_item_left_end.$text_align_left;
                                $ret .= "<td style='{$style}'>{$row['gname']}</td>";

                                $style = $td_item_normal_end.$text_align_center.$font_size;
                                $ret .= "<td style='{$style}'>{$row['num']}</td>";

                                $style = $td_item_normal_end.$text_align_left;
                                $ret .= "<td style='{$style}'>{$row['gfname']}</td>";

                                $style = $td_item_right_end.$text_align_left;
                                $ret .= "<td style='{$style}'>{$row['total']}</td>";
                            }else{
                                $ret .= "<td style='{$td_rowspan_normal}'>{$val['nickname']}</td>";
                                $ret .= "<td style='{$td_rowspan_normal}'>{$val['phone']}</td>";

                                $style = $td_item_left_normal.$text_align_left;
                                $ret .= "<td style='{$style}'>{$row['gname']}</td>";

                                $style = $td_item_normal_normal.$text_align_center.$font_size;
                                $ret .= "<td style='{$style}'>{$row['num']}</td>";

                                $style = $td_item_normal_normal.$text_align_left;
                                $ret .= "<td style='{$style}'>{$row['gfname']}</td>";

                                $style = $td_item_right_normal.$text_align_left;
                                $ret .= "<td style='{$style}'>{$row['total']}</td>";
                            }

                        } else {
                            $ret .= "<td style='{$td_style}'>{$val['nickname']}</td>";
                            $ret .= "<td style='{$td_style}'>{$val['phone']}</td>";
                            $ret .= "<td style='{$td_style}'>{$row['gname']}</td>";
                            $ret .= "<td style='{$td_style_big}'>{$row['num']}</td>";
                            $ret .= "<td style='{$td_style}'>{$row['gfname']}</td>";
                            $ret .= "<td style='{$td_style}'>{$row['total']}</td>";
                        }
                        $ret .= "</tr>";
                        $totalNum = $totalNum + $row['num'];
                        $t_arr[] = $ret;
                        $i++;
                        $row_num++;
                    }
                }
            } elseif ($type == 2) {
                foreach ($list as $key => $val) {
                    $rowspan = count($val['goods']);
                    $i = 1;
                    foreach ($val['goods'] as $index => $row) {
                        $ret = "<tr>";
                        $ret .= "<td style='{$td_style_big}'>{$row_num}</td>";
                        if ($rowspan > 1) {
                            if ($i == 1) {
                                $ret .= "<td rowspan='{$rowspan}' style='{$td_style}'>{$val['category']}</td>";
                            } else {
                                $ret .= '';
                            }
                            if($i == 1){
                                $ret .= "<td style='{$td_item_start}'>{$row['gname']}</td>";
                            }elseif ($i == $rowspan){
                                $ret .= "<td style='{$td_item_end}'>{$row['gname']}</td>";
                            }else{
                                $ret .= "<td style='{$td_item_normal}'>{$row['gname']}</td>";
                            }

                        } else {
                            $ret .= "<td style='{$td_style}'>{$val['category']}</td>";
                            $ret .= "<td style='{$td_style}'>{$row['gname']}</td>";
                        }
                        $ret .= "<td style='{$td_style_big}'>{$row['num']}</td>";
                        $ret .= "<td style='{$td_style}'>{$row['gfname']}</td>";
                        $ret .= "<td style='{$td_style}'></td>";
                        $ret .= "</tr>";
                        $totalNum = $totalNum + $row['num'];
                        $t_arr[] = $ret;
                        $i++;
                        $row_num++;
                    }
                }
            } elseif ($type == 3) {
                foreach ($list as $key => $kind) {
                    $j = 1;
                    $kind_rowspan = intval($kind['kind_rowspan']);
                    foreach ($kind['goods'] as $val){
                        $goods_name = $val['gname'] . '<br>' . $val['gfname'];
                        $rowspan = count($val['community']);
                        $i = 1;
                        foreach ($val['community'] as $index => $row) {
                            $ret = "<tr>";
                            $ret .= "<td style='{$td_style_big}'>{$row_num}</td>";

                            if ($kind_rowspan > 1) {
                                if ($j == 1) {
                                    $ret .= "<td style='{$td_rowspan_start}'>{$kind['kname']}</td>";
                                } else if($j == $kind_rowspan) {
                                    $ret .= "<td style='{$td_rowspan_end}'>{$kind['kname']}</td>";
                                } else {
                                    $ret .= "<td style='{$td_rowspan_normal}'>{$kind['kname']}</td>";
                                }
                            } else {
                                $ret .= "<td style='{$td_style}'>{$kind['kname']}</td>";
                            }

                            if ($rowspan > 1) {
                                if ($i == 1) {
                                    $ret .= "<td style='{$td_rowspan_start}'>{$goods_name}</td>";

                                    $style = $td_item_left_start.$text_align_left;
                                    $ret .= "<td style='{$style}'>{$row['name']}</td>";

                                    $style = $td_item_right_start.$text_align_center.$font_size;
                                    $ret .= "<td style='{$style}'>{$row['num']}</td>";

                                } else if ($i == $rowspan) {
                                    $ret .= "<td style='{$td_rowspan_end}'>{$goods_name}</td>";

                                    $style = $td_item_left_end.$text_align_left;
                                    $ret .= "<td style='{$style}'>{$row['name']}</td>";

                                    $style = $td_item_right_end.$text_align_center.$font_size;
                                    $ret .= "<td style='{$style}'>{$row['num']}</td>";

                                } else {
                                    $ret .= "<td style='{$td_rowspan_normal}'>{$goods_name}</td>";

                                    $style = $td_item_left_normal.$text_align_left;
                                    $ret .= "<td style='{$style}'>{$row['name']}</td>";

                                    $style = $td_item_right_normal.$text_align_center.$font_size;
                                    $ret .= "<td style='{$style}'>{$row['num']}</td>";

                                }
                                if($i == 1){
                                    $ret .= "<td style='{$td_rowspan_total_top}'>共{$val['total']}件</td>";
                                }elseif ($i == 2){
                                    if($rowspan > 2){
                                        $curr_rowspan = $rowspan - 1;
                                        $ret .= "<td style='{$td_rowspan_total_bottom}' rowspan='{$curr_rowspan}'></td>";
                                    }else{
                                        $ret .= "<td style='{$td_rowspan_total_bottom}'></td>";
                                    }
                                }else{
                                    $ret .= '';
                                }

                            } else {
                                $ret .= "<td style='{$td_style}'>{$goods_name}</td>";
                                $ret .= "<td style='{$td_style}'>{$row['name']}</td>";
                                $ret .= "<td style='{$td_style_big}'>{$row['num']}</td>";
                                $ret .= "<td style='{$td_style_center}'>共{$val['total']}件</td>";
                            }

                            $ret .= "</tr>";
                            $totalNum = $totalNum + $row['num'];
                            $t_arr[] = $ret;
                            $i++;
                            $j++;
                            $row_num++;
                        }
                    }
                }
            }
            $template = preg_replace('/<tbody>(.*?)<\/tbody>/is', implode('', $t_arr), $template);
            $template = str_replace('{SendTime}', date('Y-m-d H:i:s', time()), $template);
            $template = str_replace('{SendNumber}', $orderRow['send_number'], $template);
            $template = str_replace('{LeaderName}', $orderRow['asl_name'], $template);
            $template = str_replace('{LeaderMobile}', $orderRow['asl_mobile'], $template);
            $template = str_replace('{CommunityName}', $orderRow['asc_name'], $template);
            $template = str_replace('{Shopphone}', $orderRow['shop_phone'], $template);
            $template = str_replace('{GoodsTotal}', $totalNum, $template);
            $address = $orderRow['asc_address'] . $orderRow['asc_address_detail'];
            $template = str_replace('{CommunityAddress}', $address, $template);

            $template = str_replace('{LineName}', $orderRow['line_name'], $template);
            $template = str_replace('{LineMobile}', $orderRow['line_mobile'], $template);
            $template = str_replace('{ShopLogo}', $orderRow['logo_path'], $template);

            $print_str .= $template;
            if ($page < $page_count) {
                $print_str .= "<span><br clear=all style = 'page-break-before:always' ></span>";
            }

            $page++;
        }


        return $print_str;

    }

    
    function downloadWord($content, $fileName = 'new_file.doc')
    {

        if (empty($content)) {
            return;
        }

        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=$fileName");
        $html = '<html xmlns:v="urn:schemas-microsoft-com:vml"
         xmlns:o="urn:schemas-microsoft-com:office:office"
         xmlns:w="urn:schemas-microsoft-com:office:word" 
         xmlns:m="http://schemas.microsoft.com/office/2004/12/omml" 
         xmlns="http://www.w3.org/TR/REC-html40">';
        $html .= '<head><meta charset="UTF-8" /></head>';
        echo $html .'<body>'. $content .'</body>'. '</html>';



    }

    
    function previewWord($content, $fileName = 'new_file.doc')
    {

        if (empty($content)) {
            return;
        }

        $html = '<html>';
        $html .= '<head><meta charset="UTF-8" /></head>';
        echo $html .'<body>'. $content .'</body>'. '</html>';



    }


    public function sequencePrintWordGoodsAction()
    {
        $data = array(
            'ec' => 400,
            'em' => '模版类型错误'
        );
        $type = $this->request->getIntParam('type');
        $start_date = $this->request->getStrParam('print_start_date');
        $end_date = $this->request->getStrParam('print_end_date');

        $start_time = $this->request->getStrParam('print_start_time');
        $end_time = $this->request->getStrParam('print_end_time');

        $order_status = $this->request->getIntParam('order_status',1);

        $route_id = $this->request->getIntParam('route_id');

        $startTime = 0;
        $endTime = 0;

        if ($start_date && $end_date && $start_time && $end_time) {
            $startDate = $start_date . ' ' . $start_time;
            $endDate = $end_date . ' ' . $end_time;
            $startTime = strtotime($startDate);
            $endTime = strtotime($endDate);
        } else {
            plum_url_location('请选择完整的时间');
        }

        if($startTime >=  $endTime){
            plum_url_location('开始时间应小于结束时间');
        }

        $days = floor(($endTime-$startTime)/86400);
        if($days > 15){
            plum_url_location('两时间相差不能超过15天');
        }


        $print = plum_parse_config('printWordSeq', 'print');

        $logo_path = plum_parse_config('logoPath', 'print');
        $logo_path = $this->dealImagePath($logo_path);

        $content = $print[$type]['content'];

        $community['shop_phone'] = $this->curr_shop['s_phone'];
        $community['send_number'] = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->curr_sid);
        $community['logo_path'] = $logo_path;

        $time_0 = strtotime(date('Y-m-d'));
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
        $where = [];
        $where[] = ['name' => 'to_s_id', 'oper' => '=', 'value' => $this->curr_sid];

        $where[] = ['name' => 'to_create_time', 'oper' => '>', 'value' => $startTime];
        $where[] = ['name' => 'to_create_time', 'oper' => '<', 'value' => $endTime];

        switch ($order_status){
            case 1:
                $where[] = ['name' => 't_status', 'oper' => '>=', 'value' => 3];
                $where[] = ['name' => 't_status', 'oper' => '<', 'value' => 6];
                break;
            case 2:
                $where[] = ['name' => 't_status', 'oper' => '=', 'value' => 6];
                break;
            case 3:
                $where[] = ['name' => 't_status', 'oper' => '>=', 'value' => 3];
                $where[] = ['name' => 't_status', 'oper' => '<=', 'value' => 6];
                break;
            default:
                $where[] = ['name' => 't_status', 'oper' => '>=', 'value' => 3];
                $where[] = ['name' => 't_status', 'oper' => '<', 'value' => 6];
        }

        if($route_id){
            $route_detail_model = new App_Model_Sequence_MysqlSequenceDeliveryroutedetailStorage($this->curr_sid);
            $where_route = [];
            $where_route[] = ['name' => 'asdrt_s_id', 'oper' => '=', 'value' => $this->curr_sid];
            $where_route[] = ['name' => 'asdrt_dr_id', 'oper' => '=', 'value' => $route_id];
            $community_ids = [];
            $route_community_list = $route_detail_model->getList($where_route, 0, 0, ['asdrt_sort' => 'DESC']);
            foreach ($route_community_list as $detail){
                $community_ids[] = $detail['asdrt_community_id'];
            }
            if(!empty($community_ids)){
                $where[] = ['name' => 't_home_id', 'oper' => 'in', 'value' => $community_ids];
            }else{
                plum_url_location('当前线路中没有小区');
            }
        }


        $total_count = $order_model->getCountTradeGoodsCommunity($where);
        if($total_count > 3000){
            plum_url_location('当前时间内信息过多，请缩小查询范围');
        }
        $sequence_day=$this->request->getIntParam('sequence_day',0);
        if($sequence_day==0){
            $where[]=['name'=>'to_se_send_time','oper'=>'<=','value'=>$endTime];
        }

        $list = $order_model->getListTradeGoodsCommunityNew($where, 0, 0, []);

        $data = [];


        if($list){
            foreach ($list as $item){
                $key = $item['to_g_id'].'-'.$item['to_gf_id'];
                $item['asdr_id'] = $item['asdr_id'] > 0 ? $item['asdr_id'] : 666666;
                $item['asdr_name'] = $item['asdr_name'] ? $item['asdr_name'] : '其它线路';
                $item['asdrt_sort'] = $item['asdrt_sort'] > 0 ? intval($item['asdrt_sort']) : 0;
                $item['asdr_sort'] = $item['asdr_sort'] > 0 ? intval($item['asdr_sort']) : 999999;
                if(array_key_exists($key,$data)){
                    $data[$key]['total'] = $data[$key]['total'] + $item['to_num'];
                    if(array_key_exists($item['asdr_id'],$data[$key]['line'])){
                        if(array_key_exists($item['t_home_id'],$data[$key]['line'][$item['asdr_id']]['community'])){
                            $data[$key]['line'][$item['asdr_id']]['community'][$item['t_home_id']]['num'] = $data[$key]['line'][$item['asdr_id']]['community'][$item['t_home_id']]['num'] + $item['to_num'];
                        }else{
                            $data[$key]['line'][$item['asdr_id']]['community'][$item['t_home_id']] = [
                                'sort' => $item['asdrt_sort'],
                                'name' => $item['asc_name'],
                                'num' => $item['to_num']
                            ];
                        }
                    }else{
                        $data[$key]['line'][$item['asdr_id']] = [
                            'sort' => $item['asdr_sort'],
                            'line' => $item['asdr_name'],
                            'community' => []
                        ];
                        $data[$key]['line'][$item['asdr_id']]['community'][$item['t_home_id']] = [
                            'sort' => $item['asdrt_sort'],
                            'name' => $item['asc_name'],
                            'num' => $item['to_num']
                        ];
                    }
                }else{
                    $data[$key] = [
                        'gname' => $item['to_title'],
                        'kind'  => $item['g_kind2'],
                        'gfname' => $item['to_gf_name'],
                        'line' => [],
                        'total' => $item['to_num']
                    ];
                    $data[$key]['line'][$item['asdr_id']] = [
                        'sort' => $item['asdr_sort'],
                        'line' => $item['asdr_name'],
                        'community' => []
                    ];
                    $data[$key]['line'][$item['asdr_id']]['community'][$item['t_home_id']] = [
                        'sort' => $item['asdrt_sort'],
                        'name' => $item['asc_name'],
                        'num' => $item['to_num']
                    ];
                }
            }
        }

        $kind_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $kindList = $kind_model->getAllSonCategorySortAsc(0,0);
        $kindData = [];
        if ($kindList) {
            foreach ($kindList as $kind) {
                $kindData[$kind['sk_id']] = $kind['sk_name'];
            }
        }
        $kind_group = [];
        foreach ($data as &$row) {

            $community_arr = [];
            $line_min =  array_column($row['line'],'sort');
            array_multisort($line_min,SORT_ASC,$row['line']);
            foreach ($row['line'] as &$row_line){
                $com_min =  array_column($row_line['community'],'sort');
                array_multisort($com_min,SORT_ASC,$row_line['community']);
                $community_arr = array_merge($community_arr,$row_line['community']);
            }
            $row['community'] = $community_arr;


            if ($kindData[$row['kind']]) {
                if (array_key_exists($row['kind'], $kind_group)) {
                    $kind_group[$row['kind']]['goods'][] = $row;
                    $kind_group[$row['kind']]['kind_rowspan'] += count($row['community']);
                } else {
                    $kind_group[$row['kind']] = [
                        'kname' => $kindData[$row['kind']],
                        'kind_rowspan' => count($row['community']),
                        'goods' => [$row]
                    ];
                }
            } else {
                if (array_key_exists(-1, $kind_group)) {
                    $kind_group[-1]['goods'][] = $row;
                    $kind_group[-1]['kind_rowspan'] += count($row['community']);
                } else {
                    $kind_group[-1] = [
                        'kname' => '其它',
                        'kind_rowspan' => count($row['community']),
                        'goods' => [$row]
                    ];
                }
            }
        }
        $data = $kind_group;



        if (!empty($data)) {
            $startDate = date('Y-m-d-H_i_s',$startTime);
            $endDate = date('Y-m-d-H_i_s',$endTime);
            $page_community[0] = $community;
            $page_data[0] = $data;
            $content = $this->_str_replace_tag_seq_word_custom($content, $page_community, $page_data, $type);
     

            $filename = '仓库分拣单（'.$startDate.'-'.$endDate.'）.doc';

            $this->downloadWord($content,$filename);


        } else {
            plum_url_location('当前时间内没有商品');
        }
    }

    private function dealImagePath($path,$down=false) {
        $absolute   = false;
        $pattern    = '/^http[s]?:\/\//';
        if (preg_match($pattern, $path)) {
            $absolute = true;
        }
        if (!$absolute) {//非绝对路径
            if($down){
                $path = plum_get_base_host() . '/' . ltrim($path, '/');
            }else{
                $path = 'http://imgcov.tiandiantong.com/' . ltrim($path, '/');
            }
        }
        return $path;
    }
}