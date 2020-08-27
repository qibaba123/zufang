<?php

class App_Controller_Wxapp_GiftcardController extends App_Controller_Wxapp_LinkcommonController{

//    const PROMOTION_TOOL_KEY = 'wkj';
    public function __construct(){
        parent::__construct();
//        $this->checkToolUsable(self::PROMOTION_TOOL_KEY);
    }
    /**
     * @param string $type
     * 自定义二级链接，根据类型，确定默认选中
     */
    public function secondLink($type='frontpage'){
        $link = array(
            array(
                'label' => '首页管理',
                'link'  => '/wxapp/giftcard/index',
                'active'=> 'frontpage'
            ),
            array(
                'label' => '充值卡管理',
                'link'  => '/wxapp/giftcard/coinCardList',
                'active'=> 'coin'
            ),
            array(
                'label' => '购买记录',
                'link'  => '/wxapp/giftcard/cardBuyList',
                'active'=> 'buy'
            ),
            array(
                'label' => '核销记录',
                'link'  => '/wxapp/giftcard/cardUseList',
                'active'=> 'use'
            ),
        );


        $sinTitle = '礼品卡管理';
        $this->output['secondLink'] = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = $sinTitle;
    }


    /*
     * 充值卡管理
     */
    public function coinCardListAction(){
        $this->secondLink('coin');
        $page = $this->request->getIntParam('page');
        $card_model = new App_Model_Giftcard_MysqlGiftCardStorage($this->curr_sid);
        $where = [];
        $where[] = ['name' => 'agc_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where[] = ['name' => 'agc_type', 'oper' => '=', 'value' => 1];

        $index      = $page * $this->count;
        $total      = $card_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $output['pagination']   = $pageCfg->render();
        $list = [];
        if($index < $total){
            $sort = ['agc_sort'=>'DESC','agc_create_time'=>'DESC'];
            $list = $card_model->getList($where,$index,$this->count,$sort);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '礼品卡管理', 'link' => '#'),
            array('title' => '充值卡管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/giftcard/coin-card-list.tpl');
    }

    /*
     * 添加编辑充值卡
     */
    public function editCoinCardAction(){
        $this->secondLink('coin');
        $id = $this->request->getIntParam('id');
        $this->output['cardType'] = 1; //充值卡
        $row = [];
        if($id){
            $card_model = new App_Model_Giftcard_MysqlGiftCardStorage($this->curr_sid);
            $row = $card_model->getRowById($id);
        }
        $this->output['row'] = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '礼品卡管理', 'link' => '#'),
            array('title' => '充值卡管理', 'link' => '/wxapp/giftcard/coinCardList'),
            array('title' => '新增/编辑充值卡', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/giftcard/edit-card.tpl');
    }

    /*
     * 保存礼品卡
     */
    public function saveCardAction(){
        $id = $this->request->getIntParam('id');
        $name = $this->request->getStrParam('name');
        $cover = $this->request->getStrParam('cover');
        $price = $this->request->getFloatParam('price');
        $coin  = $this->request->getFloatParam('coin');
        $sort  = $this->request->getIntParam('sort');
        $cardType  = $this->request->getIntParam('cardType');
        $rule = $this->request->getStrParam('rule');

        if(!$name){
            $this->displayJsonError('请填写充值卡名称');
        }

        if($price <= 0){
            $this->displayJsonError('价格必须大于零');
        }

        if($coin <= 0){
            $this->displayJsonError('获得金额必须大于零');
        }

        $data = [
            'agc_name' => $name,
            'agc_cover' => $cover,
            'agc_price' => $price,
            'agc_coin'  => $coin,
            'agc_sort'  => $sort,
            'agc_rule'  => $rule,
            'agc_update_time' => time()
        ];

        $card_model = new App_Model_Giftcard_MysqlGiftCardStorage($this->curr_sid);
        if($id){
            $res = $card_model->updateById($data,$id);
        }else{
            $data['agc_s_id'] = $this->curr_sid;
            $data['agc_type'] = $cardType;
            $data['agc_create_time'] = time();
            $res = $card_model->insertValue($data);
        }

        if($res){
            App_Helper_OperateLog::saveOperateLog("礼品卡【{$name}】保存成功");
        }

        $this->showAjaxResult($res);
    }

    /*
     * 删除礼品卡
     */
    public function deleteCardAction(){
        $id = $this->request->getIntParam('id');
        $card_model = new App_Model_Giftcard_MysqlGiftCardStorage($this->curr_sid);
        $card = $card_model->getRowById($id);
        $res = $card_model->deleteDFById($id,$this->curr_sid);

        if($res){
            App_Helper_OperateLog::saveOperateLog("礼品卡【{$card['agc_name']}】删除成功");
        }

        $this->showAjaxResult($res,'删除');
    }

    /*
     * 首页管理
     */
    public function indexAction(){
        $this->secondLink('frontpage');
        // 首页幻灯
        $this->showShopTplSlide(0,14);
        $this->showIndexTpl();
        // 选择活动文章
        $this->_shop_information();
        //店铺列表
        $this->_shop_list();
        $this->_show_shop_list();
        $this->_get_list_for_select();

        // 普通商品分组
        $this->_ordinary_goods_group();
        // 获取店铺商品
        $this->_shop_top_goods_list();
        $this->_limit_group();//秒杀商品分组
        //店铺的所有二级分类
        $this->_shop_kind_list_for_select();
        //店铺分类
//        $this->_shop_category();
        //自营商品一级分类
        $this->_curr_first_kind_list_for_select();
        //自营商品二级分类
        $this->_curr_second_kind_list_for_select();
        //获得所有店铺分类
        $this->_shop_category(2);
        //获得跳转小程序
        $this->_get_jump_list();
        //资讯分类
        $this->_get_information_category();
        //商品分组
        $this->_get_goods_group();
        //多店店铺分类
        $this->_community_shop_kind_list_for_select();
        $this->showShopTplShortcut(-4);
        $this->show_city_shortcut(2);
        $this->_get_gift_card_cover();

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '礼品卡管理', 'link' => '#'),
            array('title' => '首页管理', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/giftcard/gift-card-index.tpl');
    }

    private function _get_gift_card_cover(){
        $cover_model = new App_Model_Giftcard_MysqlGiftCardCoverStorage($this->curr_sid);
        $data = [];
        $list = $cover_model->getListBySid();
        if($list){
            foreach ($list as $val){
                $data[] = [
                    'id' => $val['agcc_id'],
                    'imgsrc' => $val['agcc_img'],
                    'index' => $val['agcc_sort'],
                    'name' => $val['agcc_name']
                ];
            }
        }
        $this->output['coverList'] = json_encode($data);
        $this->output['coverSelect'] = $data;
    }

    /**
     * 显示tpl设置
     */
    private function showIndexTpl(){
        $tpl_model = new App_Model_Giftcard_MysqlGiftCardSettingStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();
        if(empty($tpl)){
            $tpl = array(
                'agcs_title'         => '礼品卡',
                'agcs_list_title'    => ''
            );
        }
        $this->output['tpl'] = $tpl;
    }

    /*
     * 保存首页
     */
    public function saveGiftCardIndexAction(){
        $head_title   = $this->request->getStrParam('headerTitle');    // 顶部标题
        $list_title   = $this->request->getStrParam('listTitle');
        $data = [
            'agcs_title' => $head_title,
            'agcs_list_title' => $list_title,
            'agcs_update_time' => time()
        ];
        $tpl_model = new App_Model_Giftcard_MysqlGiftCardSettingStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();
        if($tpl){
            $ret = $tpl_model->findUpdateBySid($data);
        }else{
            $data['agcs_create_time'] = time();
            $data['agcs_s_id'] = $this->curr_sid;
            $ret = $tpl_model->insertValue($data);
        }
        $this->save_shop_slide_new(0,14);
        $this->save_card_cover();
        if($ret){
            $result = array(
                'ec' => 200,
                'em' => '信息保存成功'
            );
            App_Helper_OperateLog::saveOperateLog("保存礼品卡首页信息");
        }else{
            $result = array(
                'ec' => 400,
                'em' => '信息保存失败'
            );
        }
        $this->displayJson($result);
    }

    /**
     * @param $tpl_id
     * @return bool
     * 新的保存模板幻灯（可以保存幻灯类型）
     */
    private function save_card_cover(){
        $cover = $this->request->getArrParam('coverList');
        $cover_model = new App_Model_Giftcard_MysqlGiftCardCoverStorage($this->curr_sid);
        if(!empty($cover)){
            $cover_list = $cover_model->getListBySid();
            if(!empty($cover_list)){
                $del_id = array();
                foreach($cover_list as $val){
                    if(isset($cover[$val['agcc_sort']])){  //存在这个位置的封面，更新
                        $set = array(
                            'agcc_sort' => $cover[$val['agcc_sort']]['index'],
                            'agcc_name' => $cover[$val['agcc_sort']]['name'],
                            'agcc_img' => $cover[$val['agcc_sort']]['imgsrc'],
                        );
                        $up_ret = $cover_model->updateById($set,$val['agcc_id']);
                        unset($cover[$val['agcc_sort']]); //然后清理前端传过来的幻灯
                    }else{ //多余的删除
                        $del_id[] = $val['agcc_id'];
                    }
                }
                if(!empty($del_id)){
                    $cover_where = array();
                    $cover_where[] = array('name' => 'agcc_id','oper' => 'in' , 'value' => $del_id);
                    $cover_model->deleteValue($cover_where);
                }

            }
            //新增的幻灯
            if(!empty($cover)){
                $insert = array();
                foreach($cover as $val){
                    $insert[] = " (NULL, '{$this->curr_sid}',  '{$val['name']}', '{$val['imgsrc']}', '{$val['index']}','".time()."')";
                }
                $ins_ret = $cover_model->insertBatch($insert);
            }
        }else{ //若不存在，则全部删除
            $where   = array();
            $where[] = array('name' => 'agcc_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $cover_model->deleteValue($where);
        }
        return true;
    }


    /*
     * 购买记录管理
     */
    public function cardBuyListAction(){
        $this->secondLink('buy');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;

        $where = [];
        $where[] = ['name' => 'agcb_s_id','oper' => '=','value' =>$this->curr_sid];

        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[]= array('name'=>'agcb_name','oper'=>'like','value'=>"%{$output['name']}%");

        }
        $output['number']  = $this->request->getStrParam('number');
        if($output['number']){
            $where[]= array('name'=>'agcb_number','oper'=>'=','value'=>$output['number']);
        }
        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 'agcb_create_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 'agcb_create_time', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }

        $sort = ['agcb_id' => 'desc'];
        $buy_model = new App_Model_Giftcard_MysqlGiftCardBuyStorage($this->curr_sid);

        $total          = $buy_model->getCardTradeCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list = $buy_model->getCardTradeList($where,$index,$this->count,$sort);
        $this->showOutput($output);
        $this->output['list'] = $list;

        $this->buildBreadcrumbs(array(
            array('title' => '礼品卡管理', 'link' => '#'),
            array('title' => '购买记录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/giftcard/card-buy-list.tpl');
    }

    /*
     * 购买记录导出
     */
    public function cardBuyExcelAction(){
        $where = [];
        $where[] = ['name' => 'agcb_s_id','oper' => '=','value' =>$this->curr_sid];

        $name = $this->request->getStrParam('name');
        if($name){
            $where[]= array('name'=>'agcb_name','oper'=>'like','value'=>"%{$name}%");
        }
        $number  = $this->request->getStrParam('number');
        if($number){
            $where[]= array('name'=>'agcb_number','oper'=>'=','value'=>$number);
        }
        $start   = $this->request->getStrParam('start');
        if($start){
            $where[]    = array('name' => 'agcb_create_time', 'oper' => '>=', 'value' => strtotime($start));
        }
        $end     = $this->request->getStrParam('end');
        if($end){
            $where[]    = array('name' => 'agcb_create_time', 'oper' => '<=', 'value' => (strtotime($end) + 86400));
        }
        $buy_model = new App_Model_Giftcard_MysqlGiftCardBuyStorage($this->curr_sid);
        $sort = ['agcb_id' => 'desc'];
        $total          = $buy_model->getCardTradeCount($where);
        if($total > 5000){
            plum_url_location('数据过多，请缩小查询范围');
        }elseif (intval($total) == 0){
            plum_url_location('查询范围内没有数据');
        }else{
            $list = $buy_model->getCardTradeList($where,0,0,$sort);
            $rows = [];
            $rows[] = ['卡号','礼品卡名称','买家','购买时间','状态'];
            $width = array_combine(['A','B','C','D','E'],[20,20,20,15,10]);

            foreach ($list as $key => $val){
                if($val['agcb_status'] == 1){
                    $statusNote = '未激活';
                }elseif ($val['agcb_status'] == 2){
                    $statusNote = '已激活';
                }elseif ($val['agcb_status'] == 3){
                    $statusNote = '已用完';
                }else{
                    $statusNote = ' ';
                }

                $rows[] = [
                    $val['agcb_number'],
                    $val['agcb_name'],
                    $this->utf8_str_to_unicode($val['agct_m_nickname']),
                    date('Y-m-d H:i',$val['agcb_create_time']),
                    $statusNote
                ];
            }

            $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
            $filename = '购买记录.xls';
            $excel->down_common_excel($rows,$filename,$width);
        }
    }

    /**
     * utf8字符转换成Unicode字符
     */
    private function utf8_str_to_unicode($utf8_str) {
        $unicode_str = '';
        for($i=0;$i<mb_strlen($utf8_str);$i++){
            $val = mb_substr($utf8_str,$i,1,'utf-8');
            if(strlen($val) >= 4){
                $unicode = (ord($val[0]) & 0xF) << 18;
                $unicode |= (ord($val[1]) & 0x3F) << 12;
                $unicode |= (ord($val[2]) & 0x3F) << 6;
                $unicode |= (ord($val[3]) & 0x3F);
                $unicode_str.= '';
            }else{
                $unicode_str.=$val;
            }
        }
        $unicode_str = $this->_filter_character($unicode_str);
        return $unicode_str;
    }

    /*
     * 过滤掉昵称中特殊字符
     */
    private function _filter_character($nickname) {
        $nickname = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $nickname);
        $nickname = preg_replace('/[=]/u', '', $nickname);
        $nickname = str_replace(array('"','\''), '', $nickname);
        $nickname  = addslashes(trim($nickname));
        return $nickname;
    }


    /*
     * 核销记录管理
     */
    public function cardUseListAction(){
        $this->secondLink('use');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;

        $where = [];
        $where[] = ['name' => 'agcu_s_id','oper' => '=','value' =>$this->curr_sid];

        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[]= array('name'=>'agcb_name','oper'=>'like','value'=>"%{$output['name']}%");

        }
        $output['shopName'] = $this->request->getStrParam('shopName');
        if($output['shopName']){
            if($output['shopName'] == '平台'){
                $where[]= array('name'=>'agcu_verify_role','oper'=>'=','value'=>1);
            }else{
                $where[]= " ( es.es_name like '%{$output['shopName']}%' or os.os_name like '%{$output['shopName']}%' ) ";
            }

        }
        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 'agcu_create_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 'agcu_create_time', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }

        $sort = ['agcu_id' => 'desc'];
        $buy_model = new App_Model_Giftcard_MysqlGiftCardUseStorage($this->curr_sid);

        $total          = $buy_model->getUseCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list = $buy_model->getUseList($where,$index,$this->count,$sort);
        $this->showOutput($output);
        $this->output['list'] = $list;

        $this->buildBreadcrumbs(array(
            array('title' => '礼品卡管理', 'link' => '#'),
            array('title' => '核销记录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/giftcard/card-use-list.tpl');
    }


    /*
     * 核销记录导出
     */
    public function cardUseExcelAction(){
        $where = [];
        $where[] = ['name' => 'agcu_s_id','oper' => '=','value' =>$this->curr_sid];

        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[]= array('name'=>'agcb_name','oper'=>'like','value'=>"%{$output['name']}%");

        }
        $output['shopName'] = $this->request->getStrParam('shopName');
        if($output['shopName']){
            if($output['shopName'] == '平台'){
                $where[]= array('name'=>'agcu_verify_role','oper'=>'=','value'=>1);
            }else{
                $where[]= " ( es.es_name like '%{$output['shopName']}%' or os.os_name like '%{$output['shopName']}%' ) ";
            }

        }
        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 'agcu_create_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 'agcu_create_time', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }

        $sort = ['agcu_id' => 'desc'];
        $use_model = new App_Model_Giftcard_MysqlGiftCardUseStorage($this->curr_sid);
        $sort = ['agcb_id' => 'desc'];
        $total          = $use_model->getUseCount($where);
        if($total > 5000){
            plum_url_location('数据过多，请缩小查询范围');
        }elseif (intval($total) == 0){
            plum_url_location('查询范围内没有数据');
        }else{
            $list = $use_model->getUseList($where,0,0,$sort);
            $rows = [];
            $rows[] = ['礼品卡名称','核销门店','用户昵称','核销金额','核销时间'];
            $width = array_combine(['A','B','C','D','E'],[20,20,20,10,15]);

            foreach ($list as $key => $val){
                if($val['agcu_verify_role'] == 2){
                    $shopName = $val['es_name'] ? $val['es_name'] : '';
                }elseif ($val['agcu_verify_role'] == 3){
                    $shopName = $val['os_name'] ? $val['os_name'] : '';
                }else{
                    $shopName = '平台';
                }
                $rows[] = [
                    $val['agcb_name'],
                    $shopName,
                    $this->utf8_str_to_unicode($val['agcu_m_nickname']),
                    $val['agcu_money'],
                    date('Y-m-d H:i',$val['agcu_create_time']),
                ];
            }

            $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
            $filename = '核销记录.xls';
            $excel->down_common_excel($rows,$filename,$width);
        }
    }
}

