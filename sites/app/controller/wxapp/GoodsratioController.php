<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/9/2
 * Time: 下午3:20
 *
 */
class App_Controller_Wxapp_GoodsratioController extends App_Controller_Wxapp_InitController {

    const PROMOTION_TOOL_KEY    = 'dpfx';
    const WEIXIN_PAT_REDPACK    = 1;//微信红包形式
    const WEIXIN_PAY_TRANSFER   = 2;//微信企业转账到零钱
    const WEIXIN_PAY_BANK       = 3;//微信企业转账到银行卡

    private $application_status = null;

    public function __construct() {
        parent::__construct();
        // $expire = "  应用已开通, 到期时间: ".date('Y-m-d H:i:s', $this->wxapp_cfg['ac_expire_time']);
        // $this->application_status   = array('code'=>0,'expire'=>$this->wxapp_cfg['ac_expire_time'],'msg' => trim($expire),'level'=>3);
        // $this->checkToolUsable(self::PROMOTION_TOOL_KEY);
    }
    /**
     * @param string $type
     * 自定义二级链接，根据类型，确定默认选中
     */
    public function secondLink($type='index'){
        $link = array(
            array(
                'label' => '商品分佣',
                'link'  => '/wxapp/goodsratio/goodsRatio',
                'active'=> 'goods'
            ),
            array(
                'label' => '分佣记录',
                'link'  => '/wxapp/goodsratio/order',
                'active'=> 'order'
            ),
            array(
                'label' => '会员提现',
                'link'  => '/wxapp/goodsratio/withdraw',
                'active'=> 'withdraw'
            ),
        );
        $this->output['link']       = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '商品分佣';
    }

    /**
     * 添加单品分销商品
     */
    public function goodsRatioAction(){
        $this->secondLink('goods');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '单品分销', 'link' => '/wxapp/goodsRatio/goodsRatio'),
            array('title' => '单品分销', 'link' => '#'),
        ));
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $this->get_goods_list();

        $deduct_model = new App_Model_Goods_MysqlGoodsRatioDeductStorage($this->curr_sid);
        $where[] = array('name' => 'grd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort = array('grd_create_time' => 'desc');
        $total = $deduct_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index <= $total) {
            $list = $deduct_model->getGoodsList($where, $index, $this->count, $sort);
        }
        $this->output['list'] = $list;
        $this->displaySmarty('wxapp/goodsratio/addGoods.tpl');
    }

    private function get_goods_list(){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $sort        = array('g_weight' => 'DESC','g_update_time'=>'DESC');
        $field       = array('g_id','g_name');
        $where[]     = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);
        $goods       = $goods_model->fetchShopGoodsList($this->curr_sid,0,0,'',0,$sort,$field, 0, 0, 1, $where);
        $this->output['goodsList'] = $goods;
    }

    /**
     * 保存分销比例
     */
    public function saveRatioAction(){
        $result = array(
            'ec' => 400,
            'em' => '商品信息错误'
        );
        $data = array();
        $g_id = $this->request->getIntParam('gid');
        $data['grd_is_used']     = $this->request->getIntParam('used');
        $data['grd_update_time'] = time();
        for($i=0; $i<=1; $i++){
            $data['grd_'.$i.'f_ratio'] = $this->request->getFloatParam('ratio_'.$i);
        }
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $goods = [];
        $deduct_model = new App_Model_Goods_MysqlGoodsRatioDeductStorage($this->curr_sid);
        $deduct = $deduct_model->fetchUpdateRow($g_id);
        if($deduct){ //更新
            $ret = $deduct_model->fetchUpdateRow($g_id,$data);
        }else{
            $goods = $goods_model->findGoodsBySidGid($this->curr_sid,$g_id);

            if(!empty($goods)){
                $data['grd_g_id'] = $g_id;
                $data['grd_s_id'] = $this->curr_sid;
                $data['grd_create_time'] = time();
                $ret = $deduct_model->insertValue($data);
            }
        }
        if(isset($ret) && $ret){
            $goods_model->changeDeduct($g_id,$data['grd_is_used']);
            if(empty($goods)){
                $goods = $goods_model->getRowById($g_id);
            }
            App_Helper_OperateLog::saveOperateLog("保存商品【{$goods['g_name']}】单品分销比例成功");
            $result = array(
                'ec' => 200,
                'em' => '保存成功'
            );
        }else{
            $result['em'] =  '保存失败';
        }
        $this->displayJson($result);
    }

    /**
     * 保存分销比例
     */
    public function delRatioAction(){
        $id = $this->request->getIntParam('id');

        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $deduct_model = new App_Model_Goods_MysqlGoodsRatioDeductStorage($this->curr_sid);
        $deduct = $deduct_model->getRowById($id);
        $ret = $deduct_model->deleteById($id);
        $goods_model->changeDeduct($deduct['gd_g_id'],0);
        if($ret){
            $goods = $goods_model->getRowById($deduct['gd_g_id']);
            App_Helper_OperateLog::saveOperateLog("删除商品【{$goods['g_name']}】单品分销比例成功");
        }
        $this->showAjaxResult($ret);
    }

    /**
     * 开启或关闭商品分销
     */
    public function openGoodsDeductAction(){
        $status = $this->request->getIntParam('status');
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $set = array('s_goods_deduct'=>$status);
        $ret = $shop_model->updateById($set,$this->curr_sid);

        if($ret){
            $str = $status > 1 ? '开启' : '关闭';
            App_Helper_OperateLog::saveOperateLog("{$str}单品分销成功");
        }

        $this->showAjaxResult($ret);
    }

    /******************分销订单**********************/
    public function orderAction() {
        $this->secondLink('order');
        $this->showTypeByKey('trade_status');
        $table_menu = new App_Helper_TableMenu();
        $this->output['choseLink'] = $table_menu->showTableLink('goodsratioOrder');

        $where[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where,true);

        $this->_show_order_data_list();
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '单品分销', 'link' => '/wxapp/goodsratip/goodsRatio'),
            array('title' => '分销订单', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/goodsratio/order-list.tpl');
    }

    private function _show_order_data_list(){
        $page = $this->request->getIntParam('page');
        $index= $page * $this->count;
        $sort   = array('od_create_time' => 'DESC');//订单生成时间倒序排列
        //必须是自己公司，当前店铺的订单
        $where = array();
        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'od_share_goods', 'oper' => '=', 'value' => 1);
        $where[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );

        //检索查询，条件整理
        $output = array();

        //订单编号
        $output['tid'] = $this->request->getStrParam('tid');
        if($output['tid']){
            $where[] = array('name' => 't_tid', 'oper' => '=', 'value' => $output['tid']);
        }
        //商品标题检索
        $output['title'] = $this->request->getStrParam('title');
        if($output['title']){
            $where[] = array('name' => 't_title', 'oper' => 'like', 'value' => "%{$output['title']}%");
        }

        //购买人昵称检索
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 't_buyer_nick', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }

        //订单状态
        $output['status'] = $this->request->getStrParam('status','all');
        $status = plum_parse_config('trade_status_search');
        if(isset($status[$output['status']]) && $status[$output['status']]){
            $where[] = array('name' => 't_status', 'oper' => '=', 'value' => $status[$output['status']]);
        }

        //分享人查询功能
        $fid = $this->request->getIntParam('1f_id');
        if($fid){
            $where[] = array('name' => 'od_1f_id', 'oper' => '=', 'value' => $fid);
        }

        //会员编号检索
        $output['mid'] = $this->request->getIntParam('mid');
        if($output['mid']){
            $where[] = array('name' => 't_m_id', 'oper' => '=', 'value' => $output['mid']);
        }


        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 't_create_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 't_create_time', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }

        $deduct_storage  = new App_Model_Shop_MysqlOrderDeductStorage($this->curr_sid);
        //订单总数
        $total = $deduct_storage->getDeductByMidSidCount($where, 1);
        $output['searchTradeInfo'] = $this->_show_order_stat($where,FALSE);
        //分页功能
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery');
        $this->output['paginator'] = $page_plugin->render();

        //订单列表数据
        $list = array();
        if($total > $index){
            $list = $deduct_storage->getDeductByMidSid($where,$index,$this->count,$sort, 1);
            $this->output['level'] = $this->show_member_level_info($list,'od_');
        }
        $output['list'] = $list;
        $this->showOutput($output);
    }


    /******************佣金提现（withdraw）**********************/
    /*
     * 提现
     */
    public function withdrawAction() {
        $this->secondLink('withdraw');
        $this->_get_withdraw_list_data();
        $this->output['tx_ma_map']      = plum_parse_config('applet_tx_ma_map');
        $this->output['withdrawType']   = plum_parse_config('applet_tx_map');
        $helper_model           = new App_Helper_ShopWeixin($this->curr_sid);
        $this->output['alert']  = $helper_model->checkShopMemberWithdraw();
        $this->showTypeByKey('withdraw_status');
        $this->output['bankList'] = plum_parse_config('withdraw_bank_ids');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '单品分销', 'link' => '/wxapp/goodsratio/goodsratio'),
            array('title' => '会员提现', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/goodsratio/withdraw-list.tpl');
    }

    private function _get_withdraw_list_data(){
        $output = array();
        $page = $this->request->getIntParam('page');
        $index= $page * $this->count;
        $sort = array('wd_create_time' => 'DESC');

        $where = array();
        $where[] = array('name' => 'wd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $output['name']   = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'wd_realname', 'oper' => 'like', 'value' => "%{$output['name']}%");
        }
        $output['mobile'] = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[] = array('name' => 'wd_mobile', 'oper' => '=', 'value' => $output['mobile']);
        }
        $output['audit']  = $this->request->getStrParam('audit');
        switch($output['audit']){
            case 'refuse':
                $where[] = array('name' => 'wd_audit', 'oper' => '=', 'value' => 2);
                break;
            case 'pass':
                $where[] = array('name' => 'wd_audit', 'oper' => '=', 'value' => 1);
                break;
            case 'audit':
                $where[] = array('name' => 'wd_audit', 'oper' => '=', 'value' => 0);
                break;
        }

        $withdraw_model = new App_Model_Member_MysqlWithDrawalStorage();
        $total          = $withdraw_model->getMemberCount($where);
        $page_plugin    = new Libs_Pagination_Paginator($total,$this->count,'jquery');
        $output['paginator'] = $page_plugin->render();
        $list  = array();
        if($total > $index){
            $list = $withdraw_model->getMemberList($where,$index,$this->count,$sort);
        }
        $output['list'] = $list;

        //获取统计信息
        $where = array();
        $where[] = array('name' => 'wd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $total = $withdraw_model->getAllCount($where);  //累计提现申请
        $where[] = array('name' => 'wd_audit', 'oper' => '=', 'value' => 0);
        $total_dsh = $withdraw_model->getAllCount($where);  //待审核
        $where[1] = array('name' => 'wd_audit', 'oper' => '=', 'value' => 1);
        $total_ytg = $withdraw_model->getCount($where);  //已通过
        $output['statInfo'] = [
            'total'     => $total['mycount'],      //累计提现申请
            'total_money' => $total['mymoney'],  //累计申请金额
            'total_dsh' => $total_dsh['mycount'],  //待审核提现
            'total_dsh_money' => $total_dsh['mymoney'],  //待审核金额
            'total_ytg' => $total_ytg['mycount'], //已通过提现
            'total_ytg_money'=> $total_ytg['mymoney']    //已通过金额
        ];

        $this->showOutput($output);
    }
    /**
     * 申请提现处理
     * 只能处理状态为0的订单
     */
    public function dealWithdrawAction(){
        $id     = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');
        $type   = $this->request->getIntParam('type');
        $note   = $this->request->getStrParam('note');
        if($status == 1 && !$type){
            $this->displayJsonError('请选择转账方式');
        }
        $result = array(
            'ec' => 400,
            'em' => '请求参数错误'
        );
        if($id && $status){
            $set = array(
                'wd_audit'      => $status,
                'wd_audit_note' => $note,
                'wd_audit_time' => time()
            );
            $where   = array();
            $where[] = array('name'=>'wd_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'wd_id','oper'=>'=','value'=>$id);
            //未处理的申请，才能进行操作
            $where[] = array('name'=>'wd_audit','oper'=>'=','value'=>0);
            $withdraw_model = new App_Model_Member_MysqlWithDrawalStorage();
            $record = $withdraw_model->getRow($where);
            if($record){
                $flag = true; //状态
                $tid  = '';
                if(($record['wd_type'] == 1 || $record['wd_type'] == 3) && $status == 1 && in_array($type,array(1,2,3))){ //微信红包,转账到零钱，转账到银行卡
                    $payRes = $this->_applet_weixin_auto_deal($record,$type);
                    if(!empty($payRes) && $payRes['errno'] == true){
                        $tid = $payRes['send_listid']; //汇款订单号
                    }else{
                        $flag = false;
                        $result['em'] = isset($payRes['errmsg']) ? $payRes['errmsg'] :'微信红包支付失败';
                    }
                }
                //可以更改订单状态
                if($flag){
                    if($status == 1){
                        $set['wd_curr_type']  = $type;
                    }
                    $ret = $withdraw_model->updateValue($set,$where);
                    //修改用户金额，并通过时记录交易流水
                    $this->_deal_withdraw_result($record,$status,$tid);
                    if($ret){
                        $result = array(
                            'ec' => 200,
                            'em' => '处理成功'
                        );
                        $str = $status == 1 ? '通过' : '不通过';
                        App_Helper_OperateLog::saveOperateLog("处理单品分销提现申请成功，处理结果：{$str}");
                    }else{
                        $result['em'] = '处理失败';
                    }
                }
            }
        }
        $this->displayJson($result);
    }

    /**
     * @param array $record
     * @param $status
     * @param string $tid
     * @return bool
     * 转账成功后，1、处理用户金额；2、记录流水
     */
    private function _deal_withdraw_result(array $record,$status,$tid=''){
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $money_ret = $member_model->dealWithdrawMoney($record['wd_m_id'],$record['wd_money'],$status);

        if($status == 1){//审核通过，则记录流水
            $data = array(
                'dd_s_id'           => $this->curr_sid,
                'dd_m_id'           => $record['wd_m_id'],
                'dd_o_id'           => $record['wd_id'],
                'dd_amount'         => $record['wd_money'],
                'dd_tid'            => $tid,
                'dd_level'          => 0,
                'dd_record_type'    => 4,
                'dd_record_time'    => time(),
                'dd_record_remark'  => '提现申请通过记录流水'
            );
            $book_model = new App_Model_Deduct_MysqlDeductDaybookStorage();
            $book_ret = $book_model->insertValue($data);
        }
        if($money_ret || $book_ret){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 回滚
     */
    public function rollbackWithdrawAction(){
        $data = array(
            'ec' => 400,
            'em' => '状态错误'
        );
        $this->displayJson($data,true); //回滚暂时隐藏

        $id = $this->request->getIntParam('id');
        $withdraw_model = new App_Model_Member_MysqlWithDrawalStorage();
        $row            = $withdraw_model->getRowByIdSid($id,$this->curr_sid);
        if($row['wd_audit'] == 1){
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $deduct_ret   = $member_model->rollbackWithdraw($row['wd_money'],$this->curr_sid,$row['wd_m_id']);
            if($deduct_ret){
                $set = array(
                    'wd_audit' => 0 //再次回到待审核
                );
                $ret  = $withdraw_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
                if($ret){
                    App_Helper_OperateLog::saveOperateLog("回滚单品分销提现申请成功");
                }

                $data = $this->showAjaxResult($ret,'回滚',1);
            }else{
                $data['em'] = '回滚金额失败';
            }
        }
        $this->displayJson($data);
    }

    /**
     * 微信配置
     */
    public function withdrawCfgAction(){
        $this->secondLink('withdraw');
        $cgf_model =  new App_Model_Shop_MysqlWithdrawCfgStorage();
        $row = $cgf_model->findCfgBySid($this->curr_sid);
        $this->output['row'] = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '提现管理', 'link' => '/wxapp/goodsratio/withdraw'),
            array('title' => '提现配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/goodsratio/withdraw-cfg.tpl');
    }

    /**
     * 重新生成商品二维码
     */
    public function createQrcodeAction(){
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $str = '1'; //此参数传空无法请求到二维码
        $apply_qrcode = $client_plugin->fetchWxappShareCode($str, $client_plugin::DISTRIB_BECOME_PARTNER_PATH, 210);
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        if($apply_qrcode){
            $updata = array('tc_apply_qrcode'=>$apply_qrcode);
            $three_cfg->findShopCfg($updata);
        }
        $res = array('ec'=> 200,'em'=> '创建成功！','url'=> $apply_qrcode);
        $this->displayJson($res);
    }
    /*
     * 下载二维码
     */
    public function downloadQrcodeAction(){
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tcRow         = $three_cfg->findShopCfg();
        if($tcRow['tc_apply_qrcode']){
            $file       = PLUM_DIR_ROOT.$tcRow['tc_apply_qrcode'];
            $filesize   = filesize($file);
            $filename   = $this->curr_shop['s_name'].".jpg";

            plum_send_http_header("Content-type: application/octet-stream");
            plum_send_http_header("Accept-Ranges: bytes");
            plum_send_http_header("Accept-Length:".$filesize);
            plum_send_http_header("Content-Disposition: attachment; filename=".$filename);

            readfile($file);
        }
    }

    public function branchCfgAction(){
        $this->secondLink('branchCfg');
        $three_model = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $row         = $three_model->getRowValue();
        $this->output['row'] = $row;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '合伙人审核', 'link' => '/distrib/three/branch'),
            array('title' => '页面配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/branch/branch-cfg.tpl');
    }

    /**
     * 提现相关配置
     */
    public function saveWithdrawCfgAction(){
        $result = array(
            'ec' => 400,
            'em' => '请求参数错误'
        );
        $data['wc_desc']       = $this->request->getStrParam('wc_desc');
        $data['wc_min']        = $this->request->getIntParam('wc_min');
        //$data['wc_wx_actname'] = $this->request->getStrParam('wc_wx_actname');
        //$data['wc_wx_open']    = $this->request->getIntParam('wc_wx_open');   // 红包提现
        $data['wc_change_open']= $this->request->getIntParam('wc_wx_open');     // 微信零钱提现
        $data['wc_bank_open']  = $this->request->getIntParam('wc_bank_open');   // 银行卡提现
        $data['wc_auto']  = $this->request->getIntParam('wc_auto');   // 自动提现
        $data['wc_mobile_open']  = $this->request->getIntParam('wc_mobile_open');   // 微信提现手机开启
        $data['wc_account_open']  = $this->request->getIntParam('wc_account_open');   // 微信提现账户开启
        $data['wc_bank_mobile_open']  = $this->request->getIntParam('wc_bank_mobile_open');   // 银行卡提现手机开启
        $data['wc_update_time']= time();
        $data['wc_rate']          = $this->request->getFloatParam('wc_rate');
        if($data['wc_min'] < 1){
            $result['em'] = '提现最低额度限制不得低于1元';
        }else{
            $cgf_model =  new App_Model_Shop_MysqlWithdrawCfgStorage();
            $row = $cgf_model->findCfgBySid($this->curr_sid);
            if($row && isset($row['wc_id']) && $row['wc_id']){
                $ret = $cgf_model->updateById($data,$row['wc_id']);
            }else{
                $data['wc_s_id'] = $this->curr_sid;
                $data['wc_createtime'] = time();
                $ret = $cgf_model->insertValue($data);
            }

            if($ret){
                $this->_save_applet_public_key();
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("单品分销提现配置保存成功");
            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }
    /**
     * 保存支付配置公钥
     */
    private function _save_applet_public_key(){
        $pay_model      = new App_Model_Applet_MysqlAppletPayStorage($this->curr_sid);
        $payCfg = $pay_model->findRowPay();
        if($payCfg && $payCfg['ap_sslcert'] && $payCfg['ap_sslkey'] && !$payCfg['ap_pubpem']){
            $wxpay_plugin   = new App_Plugin_Weixin_NewPay($this->curr_sid);
            $retsult = $wxpay_plugin->appletPublicKey();
            if($retsult['code']==0){
                $updata = array(
                    'ap_pubpem' => $retsult['filename']
                );
                $pay_model->findRowPay($updata);
            }
        }
    }
    /******************佣金提现结束**********************/

    /*
    * 小程序微信自动提现处理
    */
    private function _applet_weixin_auto_deal(array $record, $pay_type = self::WEIXIN_PAT_REDPACK) {
        //非微信转账类型
        if (!in_array($record['wd_type'],array(self::WEIXIN_PAT_REDPACK,self::WEIXIN_PAY_BANK))) {
            return array('errno' => false, 'errmsg' => '非微信转账类型');
        }
        //待审核才能提现
        if ($record['wd_audit'] != 0) {
            return array('errno' => false, 'errmsg' => '非待审核状态');
        }
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($record['wd_m_id']);

//        $pay_model      = new App_Model_Trade_MysqlPayTypeStorage($this->curr_sid);
//        $type           = $pay_model->findUpdateCfgBySid();
        $pay_storage    = new App_Model_Auth_MysqlPayTypeStorage($this->curr_sid);
        $payCfg = $pay_storage->findRowPay();
        //开通微信自有
        if ($payCfg && $payCfg['pt_wxpay_applet']) {
            $wxpay_plugin   = new App_Plugin_Weixin_NewPay($this->curr_sid);
            $money          = $record['wd_money']-$record['wd_service_money'];
            if ($pay_type == self::WEIXIN_PAT_REDPACK) {  //$record['wd_money']
                $ret    = $wxpay_plugin->appletSendRedpack($member['m_openid'],$money);
            } else if($pay_type == self::WEIXIN_PAY_TRANSFER) {
                $ret    = $wxpay_plugin->appletSendRedpack($member['m_openid'],$money);
            } else if($pay_type == self::WEIXIN_PAY_BANK) {
                $ret    = $wxpay_plugin->appletSendRedpack($member['m_openid'],$money);
            }
        }

        if (!$ret['code']) {
            return array('errno' => true, 'errmsg' => '微信转账成功');
        } else {
            return array('errno' => false, 'errmsg' => $ret['errmsg']);
        }
    }


    /**
     * 开启或关闭三级分销
     */
    public function openThreeDistribAction(){
        $status = $this->request->getIntParam('status');
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tcRow         = $three_cfg->findShopCfg();
        if($tcRow){
            $set = array('tc_isopen'=>$status);
            $ret = $three_cfg->findShopCfg($set);
        }else{
            $updata = array(
                'tc_type'           => 1,
                'tc_open_time'      => $this->wxapp_cfg['ac_open_time'],
                'tc_expire_time'    => $this->wxapp_cfg['ac_expire_time'],
                'tc_update_time'    => time(),
                'tc_s_id'           => $this->curr_sid,
                'tc_is_branch'      => 0,
                'tc_level'          => 3,
                'tc_isopen'         => $status
            );
            $ret = $three_cfg->insertValue($updata);
        }
        if($ret){
            $str = $status > 0 ? '开启' : '关闭';
            App_Helper_OperateLog::saveOperateLog("{$str}三级分销成功");
        }

        $this->showAjaxResult($ret);
    }

    /**
     * 统计订单信息
     */
    private function _show_order_stat($where,$today = true){
        if($today){
            $time = strtotime(date('Y-m-d',time())); // 获取今天0点的时间
            $where[] = array('name'=>'t_create_time','oper'=>'>=','value'=>$time);
        }

        $where[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));  //获取已付款,已发货,确认收货,已完成的订单,
        $where[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $order_model = new App_Model_Shop_MysqlOrderDeductStorage($this->curr_sid);
        return $order_model->statOrderStatistic($where, 1);
    }

    /*
     * 获取会员上月的销售额排行
     */

    public function LastMonthLevelAction($mid){
        $member_relation = new App_Model_Member_MysqlMemberRelationStorage();
        $where = array();
        // 获取上月的开始时间和上月的截止时间
        $startTime = strtotime(date('Y',time()).'-'.(date('m',time())-1).'-01');  // 上月1号时间
        $endTime = strtotime(date('Y-m',time()).'-01');  // 本月1号时间
        $where[] = array('name'=>'mr_f_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>'mr_create_time','oper'=>'>','value'=>$startTime);
        $where[] = array('name'=>'mr_create_time','oper'=>'<','value'=>$endTime);
        $oneCount = $member_relation->getCount($where);  // 获取上月直接发展的上一级的数量

        // 获取该会员上月发展的下二级的数量 (也就是该会员下级发展的下一级)
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();

        $memberList = $member_storage->fetchFirstLevelList($mid,0,0);
    }

    /**
     * 清空会员关系
     */

    public function emptyMemberShipAction(){
        $where = array();
        $where[] = array('name'=>'m_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'m_source','oper'=>'=','value'=>2);
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $list = $member_model->getList($where,0,0);
        if($this->curr_shop['s_empty_membership']){
            $this->displayJsonError('已经清空过一次，不能再操作了');
        }
        if($list){
            if(count($list)<50){
                $update = array(
                    'm_is_highest' => 0,  // 是否是最高级
                    'm_1f_id'      => 0,  //
                    'm_2f_id'      => 0,
                    'm_3f_id'      => 0,
                    'm_1c_count'        => 0,
                    'm_2c_count'        => 0,
                    'm_3c_count'        => 0,
                    'm_deduct_amount'   => 0,
                    'm_deduct_ktx'      => 0,
                    'm_deduct_ytx'      => 0,
                    'm_deduct_dsh'      => 0,
                );
                $ret = $member_model->updateValue($update,$where);
                if($ret){
                    $mids = array();
                    foreach ($list as $value){
                        $mids[] = $value['m_id'];
                    }
                    if(!empty($mids)){
                        $member_relation = new App_Model_Member_MysqlMemberRelationStorage();
                        $where = array();
                        $where[] = array('name'=>'mr_f_id','oper'=>'in','value'=>$mids);
                        $where[] = array('name'=>'mr_s_id','oper'=>'in','value'=>$mids);
                        $member_relation->deletedMemberRelation($where);
                    }
                    $updateShop = array('s_empty_membership'=>1);
                    $shop_storage = new App_Model_Shop_MysqlShopCoreStorage();
                    $shop_storage->updateById($updateShop,$this->curr_shop['s_id']);
                }

                if($ret){
                    App_Helper_OperateLog::saveOperateLog("清空会员关系成功");
                }

                $this->showAjaxResult($ret,'清空信息');
            }else{
                $this->displayJsonError('会员人数超过限制不能清空会员');
            }
        }else{
            $this->displayJsonError('暂无会员信息');
        }
    }
}