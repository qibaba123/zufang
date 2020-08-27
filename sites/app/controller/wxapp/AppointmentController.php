<?php


class App_Controller_Wxapp_AppointmentController extends App_Controller_Wxapp_OrderCommonController
{

    public function __construct()
    {
        parent::__construct();
    }

    
    public function secondLink($type='template',$returnInfo = false){
        $link = array(
            array(
                'label' => '界面设置',
                'link'  => '/wxapp/appointment/template',
                'active'=> 'template'
            ),
            array(
                'label' => '预约项目',
                'link'  => '/wxapp/appointment/goods',
                'active'=> 'goods'
            ),
            array(
                'label' => '预约订单',
                'link'  => '/wxapp/appointment/tradeList',
                'active'=> 'tradeList'
            ),
        );
        if($returnInfo){
            return array(
                'link' => $link,
                'linkType' => $type,
                'snTitle'  => '付费预约'
            );
        }else{
            $this->output['secondLink'] = $link;
            $this->output['linkType']   = $type;
            $this->output['snTitle']    = '付费预约';
        }

    }


    public function templateAction(){
        $this->secondLink('template');
        $this->showIndexTpl();
        $this->_show_goods_list();
        $this->showShopTplSlide(0, 2);
        $this->_show_tpl_notice();
        $this->_show_shop_article();
        $this->renderCropTool('/wxapp/index/uploadImg');

        if($this->wxapp_cfg['ac_type'] == 16){
            $this->buildBreadcrumbs(array(
                array('title' => '付费预约管理', 'link' => '/wxapp/appointment/template'),
                array('title' => '页面设置', 'link' => '#'),
            ));
        }else{
            $this->buildBreadcrumbs(array(
                array('title' => '营销工具', 'link' => '#'),
                array('title' => '付费预约管理', 'link' => '/wxapp/appointment/template'),
                array('title' => '页面设置', 'link' => '#'),
            ));
        }
        if($this->menuType == 'toutiao' && $this->wxapp_cfg['ac_type'] == 18){
            $this->output['dyyu'] = true;
        }
        $this->displaySmarty('wxapp/appointment/appointment-template.tpl');
    }

    
    private function _show_tpl_notice(){
        $notice_storage = new App_Model_Applet_MysqlAppointmentNoticeStorage($this->curr_sid);
        $notice_list = $notice_storage->fetchNoticeShowList();
        $data = array();
        if($notice_list){
            foreach ($notice_list as $val){
                $data[] = array(
                    'index'         => $val['apn_weight'],
                    'title'         => $val['apn_title'],
                    'articleId'     => $val['apn_article_id'],
                    'articleTitle'  => $val['apn_article_title']
                );
            }
        }
        $this->output['noticeList'] = json_encode($data);
    }

    
    private function _show_shop_article(){
        $article_model = new App_Model_Applet_MysqlAppletInformationStorage();
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        $sort          = array('ai_create_time' => 'DESC');
        $list          = $article_model->getList($where,0,100,$sort);
        $json = array();
        foreach ($list as $key => $value) {
            $json[] = array(
                'id'      => $value['ai_id'],
                'name'    => $value['ai_title'],
            );
        }
        $this->output['articles'] = json_encode($json);
    }


    
    private function showIndexTpl(){
        $tpl_model = new App_Model_Applet_MysqlAppointmentIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();
        if(empty($tpl)){
            $tpl = array(
                'aai_title'         => '预约',
                'aai_address'       => $this->curr_shop['s_name'],
                'aai_good_title'    => '预约项目',
                'aai_order_title'   => '预约订单',
                'aai_lat'           => '34.77485',
                'aai_lng'           => '113.72052',
                'aai_musttime'      => 1,
                'aai_mustaddress'   => 1,
                'aai_appoint_brief' => '',
                'aai_appoint_link'  => 0,
                'aai_link_title'    => '',
                'aai_show_address'  => 1
            );
        }
        $appoint = array();
        $appoint[] = array(
            'index'         => 0,
            'title'         => $tpl['aai_appoint_brief'],
            'articleId'     => $tpl['aai_appoint_link'],
            'articleTitle'  => $tpl['aai_link_title']
        );
        $this->output['appoint'] = json_encode($appoint);
        $this->output['tpl'] = $tpl;
    }

    
    private function _show_goods_list(){
        $where       = array();
        $where[]     = array('name' => 'g_s_id','oper' => '=','value' => $this->curr_sid);
        $where[]     = array('name' => 'g_type','oper' => '=','value' => 3);
        $where[]     = array('name' => 'g_is_sale','oper' => '=','value' =>1);
        $sort        = array('g_is_top' => 'DESC','g_weight' => 'DESC','g_update_time' => 'DESC');
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $list        = $goods_model->getList($where, 0, 4, $sort);
        $goods       = array();
        foreach ($list as $key => $value) {
            $goods[] = array(
                'id'   => $value['g_id'],
                'name' => $value['g_name'],
                'cover'=> $value['g_cover']
            );
        }
        $this->output['goods'] = json_encode($goods);
    }
    public function saveAppletTplAction(){
        $title    = $this->request->getStrParam('title');
        $image    = $this->request->getStrParam('img');
        $address  = $this->request->getStrParam('address');
        $mobile   = $this->request->getStrParam('mobile');
        $openTime = $this->request->getStrParam('openTime');
        $tpl_id   = $this->request->getIntParam('tpl', 0);
        $goodTitle = $this->request->getStrParam('goodTitle');
        $orderTitle = $this->request->getStrParam('orderTitle');
        $buttonText = $this->request->getStrParam('buttonText');
        $lng       = $this->request->getStrParam('lng');
        $lat       = $this->request->getStrParam('lat');
        $mustTime  = $this->request->getIntParam('mustTime');
        $mustaddress  = $this->request->getIntParam('mustAdress');
        $showaddress  = $this->request->getIntParam('showAdress');
        $appoint = $this->request->getArrParam('appoint');
        $appointTitle  = $this->request->getStrParam('appointTitle');
        $data = array(
            'aai_s_id'                => $this->curr_sid,
            'aai_title'               => $title,
            'aai_head_img'            => $image,
            'aai_address'             => $address,
            'aai_mobile'              => $mobile,
            'aai_open_time'           => $openTime,
            'aai_update_time'         => time(),
            'aai_good_title'          => $goodTitle,
            'aai_order_title'         => $orderTitle,
            'aai_button_text'         => $buttonText,
            'aai_lng'                 => $lng,
            'aai_lat'                 => $lat,
            'aai_musttime'            => $mustTime,
            'aai_mustaddress'         => $mustaddress,
            'aai_appoint_title'       => $appointTitle,
            'aai_appoint_brief'       => $appoint[0]['title'],
            'aai_appoint_link'        => $appoint[0]['articleId'],
            'aai_link_title'          => $appoint[0]['articleTitle'],
        );

        if($this->wxapp_cfg['ac_type'] == 6){
            $data['aai_show_address'] = $showaddress;
        }

        $tpl_model = new App_Model_Applet_MysqlAppointmentIndexStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid();
        if(!empty($tpl_row)){
            $ret = $tpl_model->findUpdateBySid($data);
        }else{
            $tpl['aai_create_time']= time();
            $ret = $tpl_model->insertValue($data);
        }
        $this->_save_train_notice();
        $this->save_shop_slide($tpl_id, 2);//保存幻灯
        if($ret){
            $result = array(
                'ec' => 200,
                'em' => '信息保存成功'
            );
            App_Helper_OperateLog::saveOperateLog("首页模板【{$row['it_name']}】配置保存成功");
        }else{
            $result = array(
                'ec' => 400,
                'em' => '信息保存失败'
            );
        }
        $this->displayJson($result);
    }

    
    private function _save_train_notice(){
        $noticeInfo = $this->request->getArrParam('notice');
        $notice_storage = new App_Model_Applet_MysqlAppointmentNoticeStorage($this->curr_sid);
        if(!empty($noticeInfo)){
            $notice_list = $notice_storage->fetchNoticeShowList();
            if(!empty($notice_list)){
                $del_id = array();
                foreach($notice_list as $val){
                    if(isset($noticeInfo[$val['apn_weight']])){
                        $set = array(
                            'apn_weight'            => $noticeInfo[$val['apn_weight']]['index'],
                            'apn_title'             => $noticeInfo[$val['apn_weight']]['title'],
                            'apn_article_id'        => $noticeInfo[$val['apn_weight']]['articleId'],
                            'apn_article_title'     => $noticeInfo[$val['apn_weight']]['articleTitle'],
                        );
                        $up_ret = $notice_storage->updateById($set,$val['apn_id']);
                        unset($noticeInfo[$val['apn_weight']]);
                    }else{
                        $del_id[] = $val['apn_id'];
                    }
                }
                if(!empty($del_id)){
                    $notice_where = array();
                    $notice_where[] = array('name' => 'apn_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $notice_storage->deleteValue($notice_where);
                }

            }
            if(!empty($noticeInfo)){
                $insert = array();
                foreach($noticeInfo as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['title']}','{$val['articleId']}','{$val['articleTitle']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $notice_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'apn_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $del     = $notice_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }


    
    public function goodsAction(){
        $this->secondLink('goods');

        if($this->wxapp_cfg['ac_type'] == 16){
            $this->buildBreadcrumbs(array(
                array('title' => '付费预约管理', 'link' => '/wxapp/appointment/template'),
                array('title' => '预约项目', 'link' => '#'),
            ));
        }else{
            $this->buildBreadcrumbs(array(
                array('title' => '营销工具', 'link' => '#'),
                array('title' => '付费预约管理', 'link' => '/wxapp/appointment/template'),
                array('title' => '预约项目', 'link' => '#'),
            ));
        }


        $this->_show_goods_list_data();
        $this->_get_appointment_kind();
        $this->output['choseLink']  = $this->showTableLink('goods');
        $this->output['sid'] = $this->curr_sid;
        $this->displaySmarty('wxapp/appointment/goods-list.tpl');
    }

        
    private function showTableLink($type,$param=array()){
        $extra = '';
        if(!empty($param) && is_array($param)){
            foreach($param as $key=>$val){
                $extra .= '&'.$key.'='.$val;
            }
        }
        $link = array();
        switch($type){
            case 'order' :
                $link = array(
                    array(
                        'href'  => '/wxapp/appointment/tradeList?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/appointment/tradeList?status=nopay'.$extra,
                        'key'   => 'nopay',
                        'label' => '待付款'
                    ),
                    array(
                        'href'  => '/wxapp/appointment/tradeList?status=hadpay'.$extra,
                        'key'   => 'hadpay',
                        'label' => '已付款'
                    ),
                    array(
                        'href'  => '/wxapp/appointment/tradeList?status=ship'.$extra,
                        'key'   => 'ship',
                        'label' => '已发货'
                    ),
                    array(
                        'href'  => '/wxapp/appointment/tradeList?status=finish'.$extra,
                        'key'   => 'finish',
                        'label' => '已完成'
                    ),
                    array(
                        'href'  => '/wxapp/appointment/tradeList?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '已退款'
                    ),
                    array(
                        'href'  => '/wxapp/appointment/tradeList?status=closed'.$extra,
                        'key'   => 'closed',
                        'label' => '已关闭'
                    ),
                );
                break;
            case 'goods' :
                $link = array(
                    array(
                        'href'  => '/wxapp/appointment/goods?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '出售中'
                    ),
                    array(
                        'href'  => '/wxapp/appointment/goods?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                );
                break;
        }
        return $link;
    }

    
    private function _show_goods_list_data(){
        $where          = array();
        $where[]        = array('name' => 'g_s_id','oper' => '=','value' => $this->curr_sid);
        $where[]        = array('name' => 'g_type','oper' => '=','value' => 3);
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'g_name','oper' => 'like','value' =>"%{$output['name']}%");
        }

        $output['kind'] = $this->request->getIntParam('kind');
        if($output['kind']){
            $where[] = array('name' => 'g_appointment_kind','oper' => '=','value' =>$output['kind']);
        }
        $output['status'] = $this->request->getStrParam('status','sell');
        switch($output['status']){
            case 'sell':
                $where[] = array('name' => 'g_is_sale','oper' => '=','value' => 1);
                break;
            case 'depot':
                $where[] = array('name' => 'g_is_sale','oper' => '=','value' => 2);
                break;
        }

        $page                = $this->request->getIntParam('page');
        $index               = $page * $this->count;
        $goods_model         = new App_Model_Goods_MysqlGoodsStorage();
        $total               = $goods_model->getCount($where);
        $pageCfg             = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index <= $total){
            $sort = array('g_update_time' => 'DESC');
            $list = $goods_model->getList($where,$index,$this->count,$sort);
        }

        if($list){
            $output['now'] = 1;
        }
        $output['list'] = $list;
        $where_sale = $where_nosale = [];
        $where_sale[] = $where_nosale[] = ['name' => 'g_s_id','oper' => '=','value' => $this->curr_sid];
        $where_nosale[] = $where_sale[] = ['name' => 'g_type','oper' => '=','value' => 3];
        $where_sale[] = ['name' => 'g_is_sale','oper' => '=','value' => 1];
        $where_nosale[] = ['name' => 'g_is_sale','oper' => '=','value' => 2];
        $sale = $goods_model->getCount($where_sale);
        $nosale = $goods_model->getCount($where_nosale);
        $statInfo = [
            'sale' => intval($sale),
            'nosale' => intval($nosale),
        ];
        $output['statInfo'] = $statInfo;


        $this->showOutput($output);
    }

    
    public function addGoodAction(){
        $this->secondLink('goods');
        $id  = $this->request->getIntParam('id');
        $row = array(); $slide = array();$format = array();
        $formatNum = 0;
        $sort      = array();
        if($id){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $row = $goods_model->getRowByIdSid($id,$this->curr_sid);
            if(!empty($row)){
                $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
                $slide          = $slide_model->getSlideByGid($row['g_id']);
                $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
                $format         = $format_model->getListByGid($row['g_id']);
                if($format){
                    $formatNum = count($format) - 1;
                    for($i=0 ; $i <= $formatNum ; $i ++){
                        $sort[] = 'format_id_'.$i;
                    }
                }
            }
        }
        $row['g_appointment_time'] = explode('-', $row['g_appointment_time']);
        $this->output['row'] = $row;
        $this->output['slide']      =  $slide;
        $this->output['format']     =  $format;
        $this->output['messageList'] = $row['g_extra_message']?$row['g_extra_message']:json_encode(array());
        $this->output['formatNum']  = $formatNum;
        $this->output['formatSort'] = implode(',',$sort);
        $this->_get_appointment_kind();
        $this->output['sid']        = $this->curr_sid;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '项目管理', 'link' => '/wxapp/appointment/goods'),
            array('title' => '添加项目', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/appointment/add-goods.tpl");
    }

    
    private function _get_appointment_kind(){
        $kind_model = new App_Model_Applet_MysqlAppointmentKindStorage($this->curr_sid);
        $list = $kind_model->getFirstCategory(0,0);
        $category_select = array();
        if($list){
            foreach ($list as $val){
                $category_select[$val['agk_id']] = $val['agk_name'];
            }
        }
        $this->output['category_select'] = $category_select;
    }

    
    public function saveGoodAction(){
       $result = array(
            'ec' => 400,
            'em' => '请填写完整项目数据'
        );
        $temp_psf = $this->math_price_stock_format();
        $id       = $this->request->getIntParam('id');
        $intField = array('g_type','g_weight');
        $data     = $this->getIntByField($intField);
        $data['g_name']               = $this->request->getStrParam('g_name');
        $data['g_price']              = $temp_psf['price'];
        $data['g_has_format']         = $temp_psf['format'];
        
        $data['g_cover']              = $this->request->getStrParam('g_cover');
        $data['g_brief']              = $this->request->getStrParam('g_brief'); ;
        $data['g_detail']             = $this->request->getStrParam('g_detail');
        $data['g_appointment_length'] = $this->request->getStrParam('g_appointment_length');
        $data['g_appointment_time']   = $this->request->getStrParam('start_time').'-'.$this->request->getStrParam('end_time');
        $data['g_appointment_date']   = $this->request->getStrParam('g_appointment_date');
        $data['g_appointment_kind']   = $this->request->getIntParam('g_appointment_kind');
        $data['g_type']               = 3;
        $data['g_s_id']               = $this->curr_sid;
        $data['g_update_time']        = time();
        $data['g_extra_message']= $this->request->getStrParam('messageList');
        $data['g_number_limit']     =$this->request->getStrParam('g_pnumber_limit');
        $data['g_show_join_list']   =$this->request->getStrParam('show_join_list');
        $data['g_limit']            =$this->request->getStrParam('g_limit');
        $data['g_day_limit']        =$this->request->getStrParam('g_day_limit');
        $data['g_show_num']         =$this->request->getStrParam('g_show_num');
        $data['g_forward']          =$this->request->getStrParam('g_forward');

        $format                       = $this->request->getIntParam('format-num');

        $istop                  = $this->request->getStrParam('g_is_top');
        $data['g_is_top']       = ($istop == 'on' || $istop == 1)? 1 : 0;
        if($data['g_name']){
            $is_add = 0;
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            if($id){
                $ret = $goods_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
            }else{
                $data['g_create_time'] = time();
                $ret = $goods_model->insertValue($data);
                $id  = $ret;
                $is_add = 1;
            }
            if($ret){
                $this->batchGoodsFormat($id,$is_add);
                $this->batchSlide($id,$is_add);
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功',
                );
                App_Helper_OperateLog::saveOperateLog("预约项目【{$data['g_name']}】保存成功");
            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }

    
    public function batchSlide($goId,$is_add=0){
        $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
        $maxNum         = $this->request->getStrParam('slide-img-num');
        $slide          = array();
        if($is_add){
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                if($temp){
                    $slide[] = "(NULL, '{$this->curr_sid}', '{$goId}', '{$temp}', 0, '".time()."')";
                }
            }
            $slide_model->batchSave($slide);
        }else{
            $sl_id = array();
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                $temp_id = $this->request->getIntParam('slide_id_'.$i);
                if($temp && $temp_id == 0){
                    $slide[] = $temp;
                }
                if($temp_id){
                    $sl_id[] = $temp_id;
                }
            }
            $del_id = array();
            $old_slide = $slide_model->getListByGidSid($goId,$this->curr_sid);
            foreach($old_slide as $val){
                if(!in_array($val['gs_id'],$sl_id)){
                    $del_id[] = $val['gs_id'];
                }
            }
            if(count($slide) <= count($del_id)){
                for($d=0 ; $d < count($del_id) ; $d++){
                    if(isset($slide[$d]) && $slide[$d]){
                        $slide_model->updateSlide($del_id[$d],$slide[$d]);
                        unset($del_id[$d]);
                    }
                }
                if(!empty($del_id)){
                    $slide_model->deleteSlide($goId,$del_id);
                }
            }else{
                $batch_slide = array();
                for($s=0 ; $s < count($slide) ; $s++){
                    if(isset($del_id[$s]) && $del_id[$s]){
                        $slide_model->updateSlide($del_id[$s],$slide[$s]);
                        unset($slide[$s]);
                    }else{
                        $sTemp = plum_sql_quote($slide[$s]);
                        $batch_slide[] = "(NULL, '{$this->curr_sid}', '{$goId}', '{$sTemp}', 0, '".time()."')";
                    }
                }
                if(!empty($batch_slide)){
                    $slide_model->batchSave($batch_slide);
                }
            }
        }
    }

    
    private function math_price_stock_format(){
        $data   = array(
            'price' => 0,
            'format'=> 0,
        );
        $maxNum = $this->request->getIntParam('format-num');
        for($i=0; $i <= $maxNum; $i++){
            $price  = $this->request->getFloatParam('format_price_'.$i);
            $data['format'] = $data['format'] + 1;
            if($data['price'] == 0) $data['price'] = $price;
        }

        $data['price'] = $this->request->getFloatParam('g_price');

        return $data;
    }

    
    private function batchGoodsFormat($goId,$is_add=0){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        $maxNum         = $this->request->getIntParam('format-num');
        $go_price       = $this->request->getFloatParam('g_price');
        $formatSort     = $this->request->getStrParam('format-sort');
        $sortArr        = explode(',',$formatSort);
        $format         = array();
        if($is_add){
            for($i=1; $i <= $maxNum; $i++){
                $name       = plum_sql_quote(plum_get_param('format_name_'.$i));
                $tem_price  = $this->request->getFloatParam('format_price_'.$i);

                $sort       = array_search('format_id_'.$i,$sortArr);
                $price      = $tem_price ? $tem_price : $go_price ;
                if($name && $price){
                    $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$name}','{$price}','','{$sort}', 0, '".time()."')";
                }
            }
        }else{
            $gf_id = array();
            for($i=0; $i <= $maxNum; $i++){
                $name    = plum_sql_quote($this->request->getStrParam('format_name_'.$i));
                $price   = $this->request->getFloatParam('format_price_'.$i);
                $id      = $this->request->getIntParam('format_id_'.$i);
                if($name){
                    $sort       = array_search('format_id_'.$i,$sortArr);//gf_sort
                    $temp = array(
                        'gf_name'   => $name,
                        'gf_price'  => $price ? $price : $go_price,
                        'gf_sort'   => $sort,
                    );
                    if($id == 0){
                        $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$temp['gf_name']}','{$temp['gf_price']}','{$temp['gf_stock']}','{$temp['gf_sort']}', 0, '".time()."')";
                    }else{
                        $format_model->updateFormat($id,$temp);
                        $gf_id[] = $id;
                    }
                }
            }
            $del_id = array();
            $old_format = $format_model->getListByGid($goId);
            foreach($old_format as $val){
                if(!in_array($val['gf_id'],$gf_id)){
                    $del_id[] = $val['gf_id'];
                }
            }
            if(!empty($del_id)){
                $format_model->deleteFormat($goId,$del_id);
            }
        }
        if(!empty($format)){
            $format_model->batchSave($format);
        }
    }


    
    public function tradeListAction() {
        $this->secondLink('tradeList');
        $where   = array();
        $this->show_trade_list_data($where, 1, 0, App_Helper_Trade::TRADE_APPOINTMENT);
        $this->output['orderLink']     = $this->showTableLink('order');
        $this->output['print']    = plum_parse_config('type','print');
        $this->output['tradePay'] =  App_Helper_Trade::$trade_pay_type;

        $where[]     = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPOINTMENT );
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where,true);
        $this->buildBreadcrumbs(array(
            array('title' => '付费预约管理', 'link' => '/wxapp/appointment/template'),
            array('title' => '预约订单', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/appointment/trade-list.tpl');
    }

    
    public function tradeDetailAction() {
        $this->secondLink('tradeList');
        $this->output['tradePay'] = App_Helper_Trade::$trade_pay_type;
        $this->output['tradeType']= App_Helper_Trade::$trade_type;

        $this->show_trade_detail_data();
        $this->buildBreadcrumbs(array(
            array('title' => '预约订单', 'link' => '/wxapp/appointment/tradeList'),
            array('title' => '订单详情', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/appointment/trade-detail.tpl');
    }

    
    public function tradeRefundAction(){
        $order_controller = new App_Controller_Wxapp_OrderController();
        $order_controller->tradeRefundAction('appo');
    }

    
    private function show_trade_detail_data(){
        $tid         = $this->request->getStrParam('order_no');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $where       = array();
        $where[]     = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]     = array('name'=>'t_tid','oper'=>'=','value'=>$tid);
        $list        = $trade_model->getAddressList($where, 0, 1, array());
        if(!empty($list) && isset($list[0])){
            $row = $list[0];
            $row['t_remark_extra'] = json_decode($row['t_remark_extra'], true);
            $output['row']  = $row;
            $trade_order        = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
            $output['list']     = $trade_order->getGoodsListByTid($row['t_id']);
            $this->_trade_detail_status_desc($row);
            $output['statusNote'] = plum_parse_config('trade_status');
            $this->showOutput($output);
        }else{
            plum_url_location('订单号错误');
        }
    }

    private function _trade_detail_status_desc($row){
        $desc = array();
        switch($row['t_status']){
            case App_Helper_Trade::TRADE_NO_PAY:
                $desc = array(
                    'icon'      => '!',
                    'class'     => 'primary',
                    'desc'      => '<div>等待买家付款款</div>'
                );
                break;
            case App_Helper_Trade::TRADE_HAD_PAY:
                if(App_Helper_Trade::TRADE_PAY_WXZFZY == $row['t_pay_type']){
                    $account = '<div>买家已将货款支付至您的 微信对公账户，请到<a href="http://pay.weixin.qq.com" target="_blank">微信商户平台</a>查收。</div>';
                }elseif(App_Helper_Trade::TRADE_PAY_HDFK == $row['t_pay_type']){
                    $account = '该订单为 货到付款订单 ';
                }else{
                }
                $desc = array(
                    'icon'      => '!',
                    'class'     => 'primary',
                    'desc'      => $account
                );
                break;
            case App_Helper_Trade::TRADE_SHIP:
                $desc = array(
                    'icon'      => '!',
                    'class'     => 'primary',
                    'desc'      => '<div>已发货、等待用户确认收货。</div>'
                );
                break;
            case App_Helper_Trade::TRADE_FINISH:
                $desc = array(
                    'icon'      => '√',
                    'class'     => 'success',
                    'desc'      => '<div>订单已经完成。</div>'
                );
                break;
            case App_Helper_Trade::TRADE_CLOSED:
                $desc = array(
                    'icon'      => 'X',
                    'class'     => 'danger',
                    'desc'      => '<div>订单已关闭。</div>'
                );
                break;
            case App_Helper_Trade::TRADE_REFUND:
                $desc = array(
                    'icon'      => 'X',
                    'class'     => 'danger',
                    'desc'      => '<div>退款订单。</div>'
                );
                break;
        }
        $this->output['desc'] = $desc;
    }

    
    public function appointmentKindListAction(){
        $this->secondLink('kind');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '付费预约管理', 'link' => '/wxapp/appointment/template'),
            array('title' => '预约项目', 'link' => '/wxapp/appointment/goods'),
            array('title' => '预约项目分类', 'link' => '#'),
        ));
        $this->_show_kind_list_data();
        $this->displaySmarty('wxapp/appointment/kind-list.tpl');
    }

    
    private function _show_kind_list_data(){
        $where          = array();
        $where[]        = array('name' => 'agk_s_id','oper' => '=','value' => $this->curr_sid);
        $page                = $this->request->getIntParam('page');
        $index               = $page * $this->count;
        $kind_model         = new App_Model_Applet_MysqlAppointmentKindStorage($this->curr_sid);
        $total               = $kind_model->getCount($where);
        $pageCfg             = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index <= $total){
            $sort = array('agk_weight' => 'DESC','agk_create_time' => 'DESC');
            $list = $kind_model->getList($where,$index,$this->count,$sort);
        }

        if($list){
            $output['now'] = 1;
        }
        $output['list'] = $list;
        $this->showOutput($output);
    }

    
    public function deleteKindAction(){
        $id = $this->request->getIntParam('id',0);
        $kind_model = new App_Model_Applet_MysqlAppointmentKindStorage($this->curr_sid);
        $kind = $kind_model->getRowById($id);
        $where[] = array('name' => 'agk_s_id','oper' => '=','value' => $this->curr_sid);
        $where[] = array('name' => 'agk_id','oper' => '=','value' => $id);

        $set = array(
            'agk_deleted' => 1
        );
        $res = $kind_model-> updateValue($set,$where);
        if($res){
            App_Helper_OperateLog::saveOperateLog("删除付费预约分类【{$kind['agk_name']}】");
        }

        $this->showAjaxResult($res,'删除');

    }

    
    public function saveKindAction(){
        $name = $this->request->getStrParam('name');
        $weight = $this->request->getIntParam('weight');
        $id   = $this->request->getIntParam('id',0);

        $kind_model = new App_Model_Applet_MysqlAppointmentKindStorage($this->curr_sid);
        $data = array(
            'agk_s_id'  => $this->curr_sid,
            'agk_name'  => $name,
            'agk_weight'=> $weight,
            'agk_logo'  => '',
            'agk_fid'   => 0,
            'agk_level' => 1
        );
        if($id){
            $res = $kind_model->updateById($data,$id);
        }else{
            $data['agk_create_time'] = time();
            $res = $kind_model->insertValue($data);
        }

        if($res){
            App_Helper_OperateLog::saveOperateLog("保存付费预约分类【{$name}】");
        }

        $this->showAjaxResult($res,'保存');
    }


    
    public function orderExcelAction(){
        $where      = array();

        $startDate  = $this->request->getStrParam('startDate');
        $startTime  = $this->request->getStrParam('startTime');
        $endDate    = $this->request->getStrParam('endDate');
        $endTime    = $this->request->getStrParam('endTime');
        $orderStatus = $this->request->getStrParam('orderStatus','all');
        $goodsname = $this->request->getStrParam('goodsname','');

        if($startDate && $startTime && $endDate && $endTime){
            $start = $startDate.' '.$startTime;
            $end = $endDate.' '.$endTime;
            $startTime  = strtotime($start);
            $endTime    = strtotime($end);

            $leader_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
            $where[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPOINTMENT);
            $where[]    = array('name'=>'t_create_time','oper'=>'>=','value'=>$startTime);
            $where[]    = array('name'=>'t_create_time','oper'=>'<','value'=>$endTime);


            if($goodsname){
                $where[]    = array('name'=>'t_title','oper'=>'like','value'=>"%{$goodsname}%");
            }



            $link = App_Helper_Trade::$trade_link_status;
            if($orderStatus && isset($link[$orderStatus]) && $link[$orderStatus]['id'] > 0){
                $where[]= array('name'=>'t_status','oper'=>'=','value'=>$link[$orderStatus]['id']);
            }


            $sort = array('t_id'=>'DESC');
            $count = $leader_model->getCount($where);
            if($count > 5000){
                plum_url_location('当前时间内订单过多，请缩小查询范围');
            }

            $list = $leader_model->getList($where,0,0,$sort);
            if(!empty($list)){
                $tradePay = App_Helper_Trade::$trade_pay_type;
                $statusNote = plum_parse_config('trade_status');
                $rows  = array();
                $rows[]  = array('订单号','购买人昵称','预约项目','数量','订单金额','支付方式','订单状态','下单时间','备注');
                $width   = array(
                    'A' => 20,
                    'B' => 20,
                    'C' => 30,
                    'D' => 10,
                    'E' => 20,
                    'F' => 20,
                    'G' => 20,
                    'H' => 20,
                    'I' => 50,
                );

                foreach($list as $key => $val){
                    $remark_extra = '';
                    foreach (json_decode($val['t_remark_extra'], true) as $v){
                        if($v['value']){
                            $remark_extra .= $v['name'].':'.$v['value'].';';
                        }
                    }

                    $rows[] = array(
                        $val['t_tid'].' ',
                        $this->utf8_str_to_unicode($val['t_buyer_nick']),
                        $val['t_title'],
                        $val['t_num'],
                        $val['t_total_fee'],
                        ($tradePay[$val['t_pay_type']] ? $tradePay[$val['t_pay_type']] : ' '),
                        ($statusNote[$val['t_status']] ? $statusNote[$val['t_status']] : ' '),
                        date('Y-m-d H:i:s',$val['t_create_time']),
                        $remark_extra
                    );
                }
                $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
                $filename = 'order.xls';
                $excel->down_common_excel($rows,$filename,$width);
            }else{
                plum_url_location('当前时间段内没有订单!');
            }
        }else{
            plum_url_location('日期请填写完整!');
        }


    }


    
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
}