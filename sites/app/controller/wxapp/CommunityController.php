<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/20
 * Time: 下午4:17
 */

class App_Controller_Wxapp_CommunityController extends App_Controller_Wxapp_OrderCommonController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 小程序首页模板
     */
    public function communityTemplateAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '小程序首页模板', 'link' => '#'),
        ));
        $cfg = plum_parse_config('category','applet');
        $tpl_ids = $cfg[8]['tpl'];
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $list       = $tpl_model->getListByTidSidType($tpl_ids,$this->curr_sid,3);
        //获取配置信息
        // $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);

        // 头条保存自定义首页配置未生效bug
        // zhangzc
        // 2019-10-19
        if( $this->menuType=='toutiao')
            $applet_cfg = new App_Model_Toutiao_MysqlToutiaoCfgStorage($this->curr_sid);
        else
            $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        
        $cfg        = $applet_cfg->findShopCfg();
        $row        = array();
        foreach($list as $val){
            if(empty($row) && $val['it_id'] == $cfg['ac_index_tpl']){
                $row = $val;
                break;
            }
        }

        $index_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
        $index = $index_model->findUpdateBySid(35);
        $this->output['index'] = $index;

        $this->output['cfg']  = $cfg;
        $this->output['list'] = $list;
        $this->output['shop'] = $this->shops[$this->curr_sid];
        $this->output['row']  = $row;
        $this->displaySmarty('wxapp/community/community-template.tpl');
    }

    /**
     * 首页模板管理
     */
    public function indexTplAction(){
        $tpl_id  = $this->request->getIntParam('tpl', 35);
        //首页基本配置
        $this->showIndexTpl($tpl_id);
        $this->showShopTplSlide($tpl_id);
        $this->_show_category();      //分类列表
        $this->showShopTplShortcut($tpl_id);  // 获取首页分类导航数据
        $this->_show_tpl_notice();
        $this->_shop_information();
        $this->_get_list_for_select();
        $this->_show_goods_list();    //活动列表
        $this->_shop_kind_list_for_select(); //店铺分类
        $this->_shop_list_for_select(); //获取店铺列表
        $this->_get_information_category(); //资讯分类
        $this->_group_list_for_select(); //获取拼团商品列表
        $this->_limit_list_for_select(); //获取秒杀商品列表
        $this->_get_jump_list();//获得跳转小程序
        $this->_bargain_list_for_select();
        $this->renderCropTool('/wxapp/index/uploadImg');
        // 平台商品分组，商家商品分组
        $this->goodsGroup();
        $this->buildBreadcrumbs(array(
            array('title' => '社区主页', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/index-tpl_'.$tpl_id.'.tpl');

    }

    /**
     * 砍价商品列表
     *
     */
    private function _bargain_list_for_select(){
        $where = array();
        $where[]    = array('name'=>'ba_s_id','oper'=>'=','value'=>$this->curr_sid);

        $where[]  = array('name'=>'ba_deleted','oper'=>'=','value'=>0);
        $where[]  = array('name'=>'ba_end_time','oper'=>'>','value'=>time());
        $sort = array('ba_status'=>'ASC','ba_create_time' => 'DESC');
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
        $list = $bargain_model->getActivityList($where,0,0,$sort);
        $data = array();
        foreach($list as $val){
            $data[]= array(
                'id'    => $val['ba_id'],
                'name'  => $val['g_name'],
            );
        }
        $this->output['bargainList'] = json_encode($data);
    }

    /**
     * 拼团商品列表
     *
     */
    private function _group_list_for_select(){
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->curr_sid);

        $list    = $group_model->getCurrentList(0,0,array());
        $data = array();
        foreach($list as $val){
            $data[] = array(
                'id'    => $val['gb_id'],
                'name'  => $val['g_name'],
            );
        }
        $this->output['groupList'] = json_encode($data);
    }

    /**
     * 秒杀商品列表
     *
     */
    private function _limit_list_for_select(){
        $limit_model = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        $list    = $limit_model->getAllRunningNotBeginActGoods(array(),0,0);
        $data = array();
        foreach($list as $val){
            $data[]= array(
                'id'    => $val['g_id'],
                'name'  => $val['g_name'],
            );
        }
        $this->output['limitList'] = json_encode($data);
    }

    /**
     * 获取店铺列表
     */
    private function _shop_list_for_select($all = false){
        $where[] = array('name'=>'es_s_id','oper'=>'=','value'=>$this->curr_sid);
        if(!$all){
            $where[] = array('name'=>'es_status','oper'=>'=','value'=>0);
        }


        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $sort    = array('es_createtime' => 'DESC');
        $list    = $shop_model->getList($where,0,0,$sort);

        $data = array();
        $selectShop = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['es_id'],
                    'name' => $val['es_name']
                );
                $selectShop[$val['es_id']] = $val['es_name'];
            }
        }
        $this->output['shoplist'] = json_encode($data);
        $this->output['selectShop'] = $selectShop;
    }


    /**
     * 获取商品列表
     * @return [type] [description]
     */
    private function _show_goods_list(){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $where[] = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);

//        if($this->menuType == 'toutiao' && $this->curr_shop['s_entershop_goods_verify'] == 1){
//            $where[]     = array('name' => 'g_is_sale', 'oper' => 'not in', 'value' =>[4,5]);
//        }

        $goods = $goods_storage->fetchShopGoodsList($this->curr_sid,0,50,'',0,array(),array(),0,0,1, $where);
        $data = array();
        foreach($goods as $val){
            $data[] = array(
                'id'       => $val['g_id'],
                'name'     => $val['g_name'],
                'cover'    => $val['gb_cover'],
                'price'    => $val['gb_price'],
                'oriprice' => $val['g_price'],
                'total'    => $val['gb_total'],
            );
        }
        $this->output['goods'] = json_encode($data);
    }

    /**
     * 获取店铺的全部分类
     */
    private function _shop_kind_list_for_select(){
        $kind_model     = new App_Model_Community_MysqlKindStorage($this->curr_sid);
        // 获取店铺的所有二级分类
        $kind1 = $kind_model->getFirstCategory(0,0);
        $data = array();
        if($kind1){
            foreach ($kind1 as $val){
                $data[] = array(
                    'id'   => $val['ack_id'],
                    'name' => $val['ack_name']
                );
            }
        }
        $this->output['kindSelect'] = json_encode($data);
    }

    /**
     * 获取列表以供使用
     */
    private function _get_list_for_select($noGoods=0){
        if($this->menuType == 'toutiao'){
            $config_name = 'toutiaosystem';
        }else{
            $config_name = 'system';
        }


        $linkList    = plum_parse_config('link',$config_name);
        $linkType    = plum_parse_config('link_type',$config_name);
        unset($linkType[3]);//去除小程序
        $weedingType = plum_parse_config('link_type_community',$config_name);
        $storeType   = plum_parse_config('link_type_store',$config_name);
        $linkStore   = array_merge($linkType,$storeType);
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        //unset($linkStore[0]);  // 去除资讯单页
        if($noGoods){
            unset($weedingType[0]);  // 商城去除商品详情
        }
        $this->output['linkList'] = json_encode($link);
        $this->output['linkType'] = json_encode(array_merge($linkStore,$weedingType));
    }


    /**
     * 获取首页通知公告
     */
    private function _show_tpl_notice(){
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->curr_sid);
        $notice_list = $notice_storage->fetchNoticeShowList();
        $data = array();
        if($notice_list){
            foreach ($notice_list as $val){
                $data[] = array(
                    'index'         => $val['atn_weight'],
                    'title'         => $val['atn_title'],
                    'imgsrc'       => $val['atn_img'],
                    'articleId'     => $val['atn_article_id'],
                    'articleTitle'  => $val['atn_article_title']
                );
            }
        }
        $this->output['noticeList'] = json_encode($data);
    }
    /**
     * 资讯分类
     */
    private function _get_information_category(){
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $list = $category_storage->getListBySid();
        $category_select = $category_storage->getCategoryListForSelect();
        $categoryList = array();
        if($list){
            foreach ($list as $key => $val){
                $categoryList[] = array(
                    'id'    => $val['aic_id'],
                    'index' => $key,
                    'name'  => $val['aic_name']
                );
            }
        }
        $this->output['categoryList'] = json_encode($categoryList);
        $this->output['category'] = $list;
        $this->output['category_select'] = $category_select;
    }
    /**
     * 获取企业资讯
     */
    private function _shop_information(){
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $sort          = array('ai_create_time' => 'DESC');
        $list          = $information_storage->getList($where,0,50,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'      => $val['ai_id'],
                    'title'   => $val['ai_title'],
                    'brief'   => $val['ai_brief'],
                    'cover'   => $val['ai_cover']
                );
            }
        }
        $this->output['information'] = json_encode($data);
    }

    /**
     * 显示tpl设置
     */
    private function showIndexTpl($tpl_id=35){
        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'aci_title'         => '首页',
                'aci_tpl_id'        => $tpl_id,
                'aci_apply_open'    => 0
            );
        }
        $this->output['tpl'] = $tpl;
    }

    // 保存模板配置
    public function saveAppletTplAction(){
        $tpl_id           = $this->request->getIntParam('tpl_id',35);
        $title            = $this->request->getStrParam('title');
        $searchPlaceholder = $this->request->getStrParam('searchPlaceholder');
        $browseNum    = $this->request->getIntParam('browseNum');    // 浏览量
        $issueNum     = $this->request->getIntParam('issueNum');    // 发布量
        $shopNum      = $this->request->getIntParam('shopNum');    // 店铺数量
        $statIcon     = $this->request->getStrParam('statIcon');   // 店铺数量
        $addMemberNum = $this->request->getIntParam('addMemberNum');    // 增加的会员数量
        $applyOpen    = $this->request->getIntParam('applyOpen');    // 入驻提醒是否开启

        $data = array(
            'aci_s_id'                => $this->curr_sid,
            'aci_tpl_id'              => $tpl_id,
            'aci_title'               => $title,
            'aci_search_tip'         => $searchPlaceholder,
            'aci_browse_num'    => $browseNum,
            'aci_issue_num'     => $issueNum ,
            'aci_shop_num'      => $shopNum,
            'aci_stat_icon'      => $statIcon,
            'aci_add_member'    => $addMemberNum,
            'aci_apply_open'        => $applyOpen,
            'aci_update_time'         => time()
        );
        // 校验店铺是否可用改模板
        $index_tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row   = $index_tpl_model->getRowBySid($tpl_id,$this->curr_sid);
        if($row){
            $ret  = $this->_update_tpl($data, $tpl_id); //更新模板信息
            $this->save_shop_slide_new($tpl_id);//保存幻灯
            $this->save_shop_shortcut_new($tpl_id);
            $this->_save_train_notice($tpl_id);//保存首页公告
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("保存首页模板【{$row['it_name']}】配置成功");
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }

    // 保存商家入驻顶部图片配置
    public function saveTopImageAction(){
        $tpl_id           = $this->request->getIntParam('tpl_id',35);
        $image            = $this->request->getStrParam('image');

        $data = array(
            'aci_s_id'                => $this->curr_sid,
            'aci_tpl_id'             => $tpl_id,
            'aci_top_image'          => $image,
            'aci_update_time'        => time()
        );
        // 校验店铺是否可用改模板
        $index_tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row   = $index_tpl_model->getRowBySid($tpl_id,$this->curr_sid);
        if($row){
            $ret  = $this->_update_tpl($data, $tpl_id); //更新模板信息
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("保存商家入驻顶部图片成功");
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }

    // 保存商家入驻协议
    public function saveProtocolAction(){
        $tpl_id           = $this->request->getIntParam('tpl_id',35);
        $protocol         = $this->request->getStrParam('protocol');

        $data = array(
            'aci_s_id'                => $this->curr_sid,
            'aci_tpl_id'             => $tpl_id,
            'aci_enter_protocol'    => $protocol,
            'aci_update_time'        => time()
        );
        // 校验店铺是否可用改模板
        $index_tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row   = $index_tpl_model->getRowBySid($tpl_id,$this->curr_sid);
        if($row){
            $ret  = $this->_update_tpl($data, $tpl_id); //更新模板信息
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("保存商家入驻协议成功");
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }

    // 保存商家入驻协议
    public function saveRuleAction(){
        $tpl_id           = $this->request->getIntParam('tpl_id',35);
        $rule         = $this->request->getStrParam('rule');

        $data = array(
            'aci_s_id'          => $this->curr_sid,
            'aci_tpl_id'        => $tpl_id,
            'aci_apply_rule'    => $rule,
            'aci_update_time'   => time()
        );
        // 校验店铺是否可用改模板
        $index_tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row   = $index_tpl_model->getRowBySid($tpl_id,$this->curr_sid);
        if($row){
            $ret  = $this->_update_tpl($data, $tpl_id); //更新模板信息
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("保存商家入驻说明成功");
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }

    // 保存会员充值页配置
    public function saveVipCfgAction(){
        $tpl_id           = $this->request->getIntParam('tpl_id',35);
        $privilegeTitle   = $this->request->getStrParam('privilegeTitle');
        $privilegeList   = $this->request->getArrParam('privilegeList');

        $data = array(
            'aci_s_id'                => $this->curr_sid,
            'aci_tpl_id'             => $tpl_id,
            'aci_privilege_title'   => $privilegeTitle,
            'aci_privilege_list'    => json_encode($privilegeList),
            'aci_update_time'        => time()
        );
        // 校验店铺是否可用改模板
        $index_tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row   = $index_tpl_model->getRowBySid($tpl_id,$this->curr_sid);
        if($row){
            $ret  = $this->_update_tpl($data, $tpl_id); //更新模板信息
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("保存用户充值配置成功");
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }


    /**
     *保存首页通知公告
     */
    private function _save_train_notice(){
        $noticeInfo = $this->request->getArrParam('notice');
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->curr_sid);
        if(!empty($noticeInfo)){
            $notice_list = $notice_storage->fetchNoticeShowList();
            if(!empty($notice_list)){
                $del_id = array();
                foreach($notice_list as $val){
                    if(isset($noticeInfo[$val['atn_weight']])){  //存在这个位置的活动，更新
                        $set = array(
                            'atn_weight'            => $noticeInfo[$val['atn_weight']]['index'],
                            'atn_title'             => $noticeInfo[$val['atn_weight']]['title'],
                            'atn_img'               => $noticeInfo[$val['atn_weight']]['imgsrc'],
                            'atn_article_id'        => $noticeInfo[$val['atn_weight']]['articleId'],
                            'atn_article_title'     => $noticeInfo[$val['atn_weight']]['articleTitle'],
                        );
                        $up_ret = $notice_storage->updateById($set,$val['atn_id']);
                        unset($noticeInfo[$val['atn_weight']]); //然后清理前端传过来的活动
                    }else{ //多余的删除
                        $del_id[] = $val['atn_id'];
                    }
                }
                if(!empty($del_id)){
                    $notice_where = array();
                    $notice_where[] = array('name' => 'atn_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $notice_storage->deleteValue($notice_where);
                }

            }

            //新增的课程
            if(!empty($noticeInfo)){
                $insert = array();
                foreach($noticeInfo as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['title']}','{$val['imgsrc']}','{$val['articleId']}','{$val['articleTitle']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $notice_storage->insertBatch($insert);
            }
        }else{ //若数组为空，则清空该店铺通知
            $where   = array();
            $where[] = array('name' => 'atn_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $del     = $notice_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param string $type
     * 自定义二级链接，根据类型，确定默认选中
     */
    public function secondLink($type='index'){
        $link = array(
            array(
                'label' => '充值页设置',
                'link'  => '/wxapp/community/vipCfg',
                'active'=> 'vipCfg'
            ),
            array(
                'label' => '会员卡管理',
                'link'  => '/wxapp/community/vipCard',
                'active'=> 'vipCard'
            ),
            array(
                'label' => '购买记录',
                'link'  => '/wxapp/community/vipOrder',
                'active'=> 'vipOrder'
            )
        );
        $this->output['link']       = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '会员卡';
    }

    /**
     * 充值页设置设置
     */
    public function vipCfgAction(){
        $this->secondLink('vipCfg');
        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();
        $this->output['privilegeList']  = json_encode($tpl['aci_privilege_list']?json_decode($tpl['aci_privilege_list']):[]);
        $this->output['privilegeTitle'] = $tpl['aci_privilege_title'];
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '充值页设置', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/community/vip-cfg.tpl");
    }

    /**
     * 会员卡管理
     */
    public function vipCardAction(){
        $this->secondLink('vipCard');
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'acc_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]    = array('name' => 'acc_deleted','oper' => '=','value' =>0);
        $card_model = new App_Model_Community_MysqlCommunityCardStorage($this->curr_sid);
        //分页处理
        $total      = $card_model->getCount($where);
        //列表数据
        $list       = array();
        if($index <= $total){
            $sort   = array('acc_long_type' => 'ASC','acc_update_time' => 'DESC');
            $list   = $card_model->getList($where,$index,$this->count,$sort);
        }
        $page_libs  = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['type']  = plum_parse_config('vip_card','system');
        $output['pageHtml'] = $page_libs->render();
        $output['list']     = $list;
        $this->showOutput($output);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '会员卡管理', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/community/card-list.tpl");
    }

    /**
     * 保存会员卡
     */
    public function saveVipCardAction(){
        $id    = $this->request->getIntParam('id');
        $type  = $this->request->getIntParam('type');
        $price = $this->request->getFloatParam('price');
        $cardList = plum_parse_config('vip_card','system');
        $data = array(
            "acc_s_id"  => $this->curr_sid,
            "acc_name"  => $cardList[$type]['name'],
            'acc_long_type' => $type,
            'acc_long' => $cardList[$type]['long'],
            'acc_price' => $price,
            'acc_create_time' => time()
        );
        $card_model = new App_Model_Community_MysqlCommunityCardStorage($this->curr_sid);
        if($id){
            $ret = $card_model->updateById($data, $id);
        }else{
            $ret = $card_model->insertValue($data);
        }
        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存会员卡【{$cardList[$type]['name']}】成功");
        }
        $this->showAjaxResult($ret);
    }

    /**
     * 删除会员卡
     */
    public function delVipCardAction(){
        $id = $this->request->getIntParam('id');
        $card_model = new App_Model_Community_MysqlCommunityCardStorage($this->curr_sid);
        $card = $card_model->getRowById($id);
        $data = array(
            'acc_deleted' => 1
        );
        $ret = $card_model->updateById($data, $id);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("删除会员卡【{$card['acc_name']}】成功");
        }

        $this->showAjaxResult($ret);
    }

    /**
     * 充值记录
     */
    public function vipOrderAction(){
        $this->secondLink('vipOrder');
        $this->show_vip_order_list();
        $this->buildBreadcrumbs(array(
            array('title' => '充值记录', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/community/vip-order.tpl");
    }

    public function show_vip_order_list(){
        $page    = $this->request->getIntParam('page');
        $index   = $page * $this->count;
        $sort    = array('acmo_create_time' => 'DESC');
        $where   = array();
        $where[] = array('name' => 'acmo_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $output['tid'] = $this->request->getStrParam('tid');
        if($output['tid']){
            $where[] = array('name' => 'acmo_tid', 'oper' => '=', 'value' => $output['tid']);
        }
        $output['card'] = $this->request->getIntParam('card');
        if($output['card']){
            $where[] = array('name' => 'acmo_cid', 'oper' => '=', 'value' => $output['card']);
        }
        $output['status'] = $this->request->getIntParam('status');
        if($output['status']){
            $where[] = array('name' => 'acmo_status', 'oper' => '=', 'value' => (intval($output['status'])-1));
        }
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }
        $order_model = new App_Model_Community_MysqlCommunityMemberOrderStorage($this->curr_sid);
        $total       = $order_model->getListCount($where);
        $page_libs   = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list        = array();
        if($total > $index){
            $list    = $order_model->getListMember($where,$index,$this->count,$sort);
        }
        $output['paginator'] = $page_libs->render();
        $output['list']      = $list;
        $this->showOutput($output);
    }

    /**
     * 更新模板
     */
    private function _update_tpl($data, $tpl_id){
        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid($tpl_id);
        if(!empty($tpl_row)){
            $tpl_ret = $tpl_model->findUpdateBySid($tpl_id,$data);
        }else{
            $tpl['aci_create_time']= time();
            $tpl_ret = $tpl_model->insertValue($data);
        }
        return $tpl_ret;
    }


    /**
     * 店铺分类
     */

    public function shopCategoryAction(){
        $category = $this->shop_category_son_data();
        $this->buildBreadcrumbs(array(
            array('title' => '店铺类别', 'link' => '#'),
        ));
        $this->output['category'] = json_encode($category);
        $this->displaySmarty('wxapp/community/shop-category.tpl');
    }

    /**
     * @param int $isJson
     * @return array
     * 获取自定义店铺分类数据
     */
    private function shop_category_son_data($isJson=1){
        $category_model = new App_Model_Community_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getListBySid();
        $temp           = array();
        foreach($first as $val){
            if($val['ack_level'] == 1){
                $temp[$val['ack_id']] = array(
                    'id'        => $val['ack_id'],
                    'index'     => $val['ack_weight'],
                    'firstName' => $val['ack_name'],
                    'secondItem'=> array(),
                );
            }elseif($val['ack_fid'] > 0 && $val['ack_level'] == 2){
                $temp[$val['ack_fid']]['secondItem'][] = array(
                    'id'         => $val['ack_id'],
                    'index'      => $val['ack_weight'],
                    'secondName' => $val['ack_name'],
                    'link'       => ""
                );
            }

        }
        if($isJson){
            $category   = array();
            foreach($temp as $tal){
                $category[] = $tal;
            }
            return $category;
        }else{
            return $temp;
        }
    }


    public function saveShopCategoryAction(){
        $category       = $this->request->getArrParam('category');
        $category_model = new App_Model_Community_MysqlKindStorage($this->curr_sid);
        $hasIds         = array();
        $insert         = array();
        if(empty($category)){
            $delete_where   = array();
            $delete_where[] = array('name'=>'ack_s_id','oper'=>'=','value'=>$this->curr_sid);
            $delete_where[] = array('name'=>'ack_deleted','oper'=>'=','value'=>0);
            $category_model->updateValue(array('ack_deleted'=>1),$delete_where);
        }
        foreach($category as $key=>$fal){ //父类
            $fdata = array(
                'ack_name'   => $fal['firstName'],
                'ack_weight' => $key,
                'ack_fid'    => 0,
                'ack_level'  => 1,
                'ack_s_id'   => $this->curr_sid,
            );
            if($fal['id']){
                $fid = $fal['id'];
                $category_model->getRowUpdateByIdSid($fal['id'],$this->curr_sid,$fdata);
            }else{
                if(count($fal['secondItem']) > 0){
                    $fdata['ack_create_time'] = $_SERVER['REQUEST_TIME'];
                    $fid  = $category_model->insertValue($fdata);
                }else{
                    $fid  = 0;
                    $insert[]  = "(NULL, {$this->curr_sid}, '{$fal['firstName']}', '{$key}', '1', '0', '0', '{$_SERVER['REQUEST_TIME']}')" ;
                }
            }
            //子类数据处理
            if($fid > 0){
                $hasIds[]  = $fid;
                foreach($fal['secondItem'] as $sey=>$sal){
                    if($sal['id']){ //更新
                        $hasIds[]  = $sal['id'];
                        $sdata = array(
                            'ack_name'   => $sal['secondName'],
                            'ack_weight' => $sey,
                            'ack_fid'    => $fid,
                            'ack_level'  => 2,
                            'ack_s_id'   => $this->curr_sid,
                        );
                        $category_model->getRowUpdateByIdSid($sal['id'],$this->curr_sid,$sdata);
                    }else{
                        $insert[]  = "(NULL, {$this->curr_sid}, '{$sal['secondName']}', '{$sey}', '2', '{$fid}', '0', '{$_SERVER['REQUEST_TIME']}')" ;
                    }
                }
            }
        }
        if(!empty($hasIds)){
            $category_model->deleteByIds($hasIds,'not in');
        }
        if(!empty($insert) ){
            $category_model->insertBatchValue($insert);
        }
        App_Helper_OperateLog::saveOperateLog("保存店铺分类成功");
        $this->showAjaxResult(true,'保存');
    }

    /**
     * 商家入驻申请信息
     */
    public function shopApplyEnterAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where[] = array('name'=>'es_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'es_m_id','oper'=>'>','value'=>0);//只查询用户申请的
        $where[] = array('name'=>'es_handle_status','oper'=>'>','value'=>0);//已支付
        //$apply_storage = new App_Model_Community_MysqlCommunityShopApplyStorage($this->curr_sid);
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
        $total      = $es_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $sort          = array('es_handle_status'=>'ASC','es_createtime' => 'DESC');
            $list          = $es_model->getList($where,$index,$this->count,$sort);
        }

        $this->output['category'] = $this->_get_select_category();
        $this->output['district'] = $this->_get_select_district();

        if($this->menuType == 'toutiao'){
            foreach ($list as $key => $val){
                $list[$key]['daysValue'] = $this->_format_days_value($val['es_days']);
            }
        }

        $this->output['list'] = $list;
        $this->output['status'] = array(1=>'申请中',2=>'通过',3=>'拒绝');
        $this->buildBreadcrumbs(array(
            array('title' => '申请商家', 'link' => '#'),
        ));
        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();

        $this->output['image'] = $tpl['aci_top_image'];
        $this->output['protocol'] = $tpl['aci_enter_protocol'];
        $this->output['applyRule'] = $tpl['aci_apply_rule'];
        $this->output['personApply'] = $tpl['aci_person_apply'];
        //获取当前访问的域名
        $this->output['curr_domain'] = plum_get_server('http_host');
        // 获取分佣比例
        if($this->menuType == 'toutiao') {
            $toutiaoPay_model = new App_Model_Toutiao_MysqlToutiaoPayStorage($this->curr_sid);
            $appcfg = $toutiaoPay_model->findRowPay();
            $maid = $appcfg['atp_shop_percentage'];
        } else {
            $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->curr_sid);
            $appcfg = $appletPay_Model->findRowPay();
            $maid = $appcfg['ap_shop_percentage'];
        }
        $this->output['maid'] = $maid;   //订单抽成比例
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/community/shop-apply-enter-list-new.tpl');
    }

    private function _format_days_value($days){
        $val = '';

        if($days > 0){
            if($days >= 365 and $days%365 == 0){//以年为单位设置
                $val = ($days/365).'年';
            }elseif ($days == 180){
                $val = '半年';
            }elseif ($days >= 30 && $days < 365 && $days%30 == 0){//以月为单位设置 无论是否进位直接展示月 如18个月
                $val = ($days/30).'个月';
            }else{//以天数为单位 无论是否进位直接展示天  如80天
                $val = $days.'天';
            }
        }

        return $val;
    }

    public function shopApplyEnterOldAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where[] = array('name'=>'acsa_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'acsa_status','oper'=>'>','value'=>0);
        $apply_storage = new App_Model_Community_MysqlCommunityShopApplyStorage($this->curr_sid);
        $total      = $apply_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $sort          = array('acsa_status'=>'ASC','acsa_create_time' => 'DESC');
            $list          = $apply_storage->getList($where,$index,$this->count,$sort);
        }

        $this->output['category'] = $this->_get_select_category();
        $this->output['district'] = $this->_get_select_district();

        $this->output['list'] = $list;
        $this->output['status'] = array(1=>'申请中',2=>'通过',3=>'拒绝');
        $this->buildBreadcrumbs(array(
            array('title' => '申请入驻管理', 'link' => '#'),
        ));
        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();

        $this->output['image'] = $tpl['aci_top_image'];
        $this->output['protocol'] = $tpl['aci_enter_protocol'];
        // 获取分佣比例
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->curr_sid);
        $appcfg = $appletPay_Model->findRowPay();
        $this->output['maid'] = $appcfg['ap_shop_percentage'];   //订单抽成比例
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/community/shop-apply-enter-list.tpl');
    }

    /*
     * 获取等级
     */
    private function _get_select_level(){
        //获得门店等级
        $level_model = new App_Model_Entershop_MysqlEnterShopLevelStorage($this->curr_sid);
        $levelList = $level_model->getListBySid($this->curr_sid,0,0);
        $data = array();
        foreach ($levelList as $val){
            $data[$val['esl_id']] = $val['esl_name'];
        }
        return $data;
    }

    /**
     * 获取分类
     */
    private function _get_select_category(){
        $category_model = new App_Model_Community_MysqlKindStorage($this->curr_sid);
        $category_list  = $category_model->getAllCategorySelect();
        return $category_list;
    }
    /**
     * 获取商圈
     */
    private function _get_select_district(){
        $district_model = new App_Model_Community_MysqlCommunityDistrictStorage($this->curr_sid);
        $district_list  = $district_model->getListBySid();
        $data = array();
        foreach($district_list as $val){
            $data[$val['acd_id']] = array(
                'name' => $val['acd_name'],
                'area_name' => $val['acd_area_name']
            );
        }
        return $data;
    }

    /**
     * 处理商家申请入驻信息
     */
    public function handleApplyAction(){
        $id = $this->request->getIntParam('id');
        $market = $this->request->getStrParam('market');
        $status = $this->request->getIntParam('status');
        $msg = '';
        $addManager = false;
        //$apply_storage = new App_Model_Community_MysqlCommunityShopApplyStorage($this->curr_sid);
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
        $row = $es_model->getRowById($id);
        //通过审核
        if($status == 2){
            $addManager = true;
            $manager_storage    = new App_Model_Entershop_MysqlManagerStorage();
            $exists = $manager_storage->findManagerByMobile($row['es_phone']);

            if($exists){
                $addManager = false;
                $msg = '，手机号已被占用，请手动添加管理员';
                //$this->displayJsonError('该手机号已被注册，请更换手机号');
            }
        }

        if($id){
            $updata = array(
                'es_handle_remark' => $market,
                'es_handle_status' => $status?$status:2,
                'es_handle_time'   => time()
            );

            $ret = $es_model->updateById($updata,$id);
            plum_open_backend('index', 'wxappTempl', array('sid' => $this->curr_sid,'applet' => $this->wxapp_cfg['ac_type'], 'tid' => $id, 'type' => App_Helper_WxappApplet::SEND_SETUP_AUDIT));
            if($ret){
                if($status && $status == 2){
                    //$this->_add_enter_shop($id); //添加入驻商家
                    if($addManager){
                        $this->_add_enter_shop_manager($row);
                    }
                    //增加店铺的数量
                    $this->_statistics('shop', 1);
                    //将到期时间更新至门店
                    $updata = array(
                        'es_open_time' => time(),
                        'es_expire_time' => (time()+((60*60*24)*$row['es_days'])),
                    );
                    $es_model->updateById($updata,$id);

                    $promoter_model = new App_Model_Promoter_MysqlPromoterStorage($this->curr_sid);
                    if($row['es_promoter_id']){
                        $promoter_model->incrementField('ap_shop_num',$row['es_promoter_id'],1); // 添加代理商店铺数量
                    }
                    // 设置区域代理
                    $pro = $promoter_model->findRowByCity($row['es_city'], 2);
                    if($pro) {
                        $es_model->updateById(['es_pro_area'=>$pro['ap_id']], $id);
                    }



//                $pay_model = new App_Model_Community_MysqlCommunityApplyPayStorage($this->curr_sid);
//                $record = $pay_model->findUpdateByNumber($row['es_number']);
////将门店id更新至支付记录表
//                if($record && $row['es_number']){
//                    $pay_model->findUpdateByNumber($row['acsa_number'],array('acap_es_id'=> $row['es_id']));
//                }
                }
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'.$msg
                );

                $str = $status == 2 ? '通过' : '不通过';
                App_Helper_OperateLog::saveOperateLog("处理店铺【{$row['es_name']}】申请成功，处理结果：{$str}");


                $this->displayJson($result);
            }else{
                $this->displayJsonError('处理失败');
            }
        }else{
            $this->displayJsonError('处理失败');
        }
    }

    private function _add_enter_shop_manager($row){

        //新建管理员
        $mgdata = array(
            'esm_s_id'       => $this->curr_sid,
            'esm_es_id'      => $row['es_id'],
            'esm_mobile'     => $row['es_phone'],
            'esm_nickname'   => $row['es_contact'],
            'esm_password'   => plum_salt_password($row['es_phone']),
            'esm_createtime' => time(),
            'esm_status'     => 0,   //正常登陆
        );
        $manager_storage = new App_Model_Entershop_MysqlManagerStorage();
        $mid = $manager_storage->insert($mgdata, true);//获取创建人id
    }

    public function handleApplyOldAction(){
        $id = $this->request->getIntParam('id');
        $market = $this->request->getStrParam('market');
        $status = $this->request->getIntParam('status');

        $apply_storage = new App_Model_Community_MysqlCommunityShopApplyStorage($this->curr_sid);
        $row = $apply_storage->getRowById($id);
        //通过审核
        if($status == 2){
            $manager_storage    = new App_Model_Entershop_MysqlManagerStorage();
            $exists = $manager_storage->findManagerByMobile($row['acsa_mobile']);

            if($exists){
                $this->displayJsonError('该手机号已被注册，请更换手机号');
            }
        }

        if($id){
            $updata = array(
                'acsa_deal_note' => $market,
                'acsa_status'        => $status?$status:2,
                'acsa_deal_time'   => time()
            );
            $apply_storage = new App_Model_Community_MysqlCommunityShopApplyStorage($this->curr_sid);
            $ret = $apply_storage->updateById($updata,$id);
            plum_open_backend('index', 'wxappTempl', array('sid' => $this->curr_sid,'applet' => $this->wxapp_cfg['ac_type'], 'tid' => $id, 'type' => App_Helper_WxappApplet::SEND_SETUP_AUDIT));
            if($status && $status == 2 && $ret){
                $this->_add_enter_shop($id); //添加入驻商家
                //增加店铺的数量
                $this->_statistics('shop', 1);
            }
            $this->showAjaxResult($ret,'处理');
        }else{
            $this->displayJsonError('处理失败，请稍后重试');
        }
    }

    /**
     * @param $type 统计类型  type=browse 浏览量  type=issue 发布量 type=shop 商家
     * @param $num  数量
     */
    private function _statistics($type, $num){
        //获取配置信息
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
        $tpl = $tpl_model->findUpdateBySid(35);   //$cfg['ac_index_tpl']
        if($type == 'browse'){
            $set = array('aci_browse_num' => ($tpl['aci_browse_num'] + $num));
            $tpl_model->findUpdateBySid(35, $set);
        }
        if($type == 'issue'){
            $set = array('aci_issue_num' => ($tpl['aci_issue_num'] + $num));
            $tpl_model->findUpdateBySid(35, $set);
        }
        if($type == 'shop'){
            $set = array('aci_shop_num' => ($tpl['aci_shop_num'] + $num));
            $tpl_model->findUpdateBySid(35, $set);
        }
    }


    //添加入驻商家
    private function _add_enter_shop($id){
        $apply_storage = new App_Model_Community_MysqlCommunityShopApplyStorage($this->curr_sid);
        $row = $apply_storage->getRowById($id);
        if($row){
            // 创建一个默认店铺
            $open_time      = time();
            $category_model = new App_Model_Community_MysqlKindStorage($this->curr_sid);
            $category = $category_model->getAllSonCategorySelect(0,0);

            $pay_model = new App_Model_Community_MysqlCommunityApplyPayStorage($this->curr_sid);
            $record = $pay_model->findUpdateByNumber($row['acsa_number']);

            $data = array(
                'es_unique_id'   => plum_uniqid_base36(),
                'es_contact'     => $row['acsa_contacts'],
                'es_m_id'        => $row['acsa_m_id'],
                'es_phone'       => $row['acsa_mobile'],
                'es_name'        => $row['acsa_shop_name'],
                'es_addr'        => $row['acsa_addr'],
                'es_addr_detail' => $row['acsa_addr_detail'],
                'es_lng'         => $row['acsa_lng'],
                'es_lat'         => $row['acsa_lat'],
                'es_cate1'       => $row['acsa_cate1'],
                'es_cate2'       => $row['acsa_cate2'],
                'es_cate2_name' => $category[$row['acsa_cate2']],
                'es_district1'  => $row['acsa_district1'],
                'es_district2'  => $row['acsa_district2'],
                'es_s_id'        => $this->curr_sid,
                'es_open_time'   => $open_time,
                'es_expire_time' => (time()+((60*60*24)*$row['acsa_days'])),
                'es_createtime'  => time(),
                'es_status'      => App_Helper_ShopWeixin::SHOP_MANAGE_RUN,
                'es_vr_url'      => $row['acsa_vr_url'],
                'es_license'     => $row['acsa_license']
            );
            $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
            $sid = $shop_model->insertValue($data);
            if($sid){
                //新建管理员
                $mgdata = array(
                    'esm_s_id'       => $this->curr_sid,
                    'esm_es_id'      => $sid,
                    'esm_mobile'     => $row['acsa_mobile'],
                    'esm_nickname'   => $row['acsa_contacts'],
                    'esm_password'   => plum_salt_password($row['acsa_mobile']),
                    'esm_createtime' => time(),
                    'esm_status'     => 0,   //正常登陆
                );
                //将门店id更新至支付记录表
                if($record && $row['acsa_number']){
                    $pay_model->findUpdateByNumber($row['acsa_number'],array('acap_es_id'=> $sid));
                }

                $manager_storage = new App_Model_Entershop_MysqlManagerStorage();
                $mid = $manager_storage->insert($mgdata, true);//获取创建人id
            }
        }

    }

    /**
     * 商家管理
     */
    public function shopListAction(){
        $shopName = $this->request->getStrParam('shopName');
        $contact  = $this->request->getStrParam('contact');
        $phone    = $this->request->getStrParam('phone');
        $account  = $this->request->getStrParam('account');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where[] = array('name'=>'es_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'es_handle_status','oper'=>'=','value'=>2); //通过审核
        $where[] = array('name'=>'es_deleted','oper'=>'=','value'=>0);
        if($shopName){
            $where[] = array('name'=>'es_name','oper'=>'like','value'=>"%{$shopName}%");
        }
        if($contact){
            $where[] = array('name'=>'es_contact','oper'=>'like','value'=>"%{$contact}%");
        }
        if($phone){
            $where[] = array('name'=>'es_phone','oper'=>'=','value'=>$phone);
        }

        if($account){
            $where[] = array('name'=>'esm_mobile','oper'=>'=','value'=>$account);
        }

        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $total      = $shop_model->getShopMangerCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $sort          = array('es_createtime' => 'DESC');
            $list          = $shop_model->getShopMangerList($where,$index,$this->count,$sort);
        }
        $categoryData    = $this->_category_son_data(1);
        $this->output['categoryData'] = $categoryData;
        /*if($this->request->getIntParam('test')==1){
            plum_msg_dump($categoryData,1);
        }*/
        //获取当前访问的域名
        $this->output['curr_domain'] = plum_get_server('http_host');

        $this->output['shopLevel'] = $this->_get_select_level();
        $this->output['category'] = $this->_get_select_category();
        $this->output['district'] = $this->_get_select_district();
        $this->output['appletCfg'] = $this->wxapp_cfg;
        $this->output['shopName'] = $shopName;
        $this->output['contact'] = $contact;
        $this->output['phone'] = $phone;

        //抖音功能
        if($this->menuType == 'toutiao'){
            $address_model = new App_Model_Address_MysqlAddressCoreStorage();
            $trade_model = new App_Model_Trade_MysqlTradeStorage();
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $withdraw_storage = new App_Model_Entershop_MysqlEnterShopWithdrawStorage();
            foreach ($list as $key => $val){
                $list[$key]['prov_name'] = $val['es_prov_name'];
                $list[$key]['city_name'] = $val['es_city_name'];
                $list[$key]['zone_name'] = $val['es_zone_name'];

                $where_trade = [];
                $where_trade[] = ['name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid];
                $where_trade[] = ['name'=>'t_es_id','oper'=>'=','value'=>$val['es_id']];
                $where_trade[] = ['name'=>'t_status','oper'=>'in','value'=>[3,4,5,6]];
                $where_trade[] = ['name'=>'t_create_time','oper'=>'>','value'=>strtotime(date('Y-m'))];
                $tradeInfo = $trade_model->statOrderStatisticSingle($where_trade);

                $where_goods = [];
                $where_goods[] = ['name'=>'g_s_id','oper'=>'=','value'=>$this->curr_sid];
                $where_goods[] = ['name'=>'g_es_id','oper'=>'=','value'=>$val['es_id']];
                $where_goods[] = ['name'=>'g_deleted','oper'=>'=','value'=>0];
                $goodsCount = $goods_model->getCount($where_goods);

                $where_withdraw = [];
                $where_withdraw[] = ['name'=>'esw_s_id','oper'=>'=','value'=>$this->curr_sid];
                $where_withdraw[] = ['name'=>'esw_es_id','oper'=>'=','value'=>$val['es_id']];
                $where_withdraw[] = ['name'=>'esw_status','oper'=>'=','value'=>1];
                $withdrawInfo = $withdraw_storage->getStatInfo($where_withdraw);

                $list[$key]['goodsCount'] = intval($goodsCount);
                $list[$key]['tradePayment'] = floatval($tradeInfo['money']);
                $list[$key]['withdraw'] = floatval($withdrawInfo['money']);
            }
        }

        if($list) {
            $time = time();
            $syn  = 'http://'.plum_get_server('http_host').'/shop/user/syslogin';
            foreach($list as $key => $value) {
                $params = array('username' => $value['esm_mobile'], 'check' => $value['esm_password'], 'action' => 'synlogin');
                $code   = plum_authcode(http_build_query($params), 'ENCODE');
                $code   = urlencode($code);

                $sysurl = $syn."/?time={$time}&code={$code}";
                $list[$key]['sysurl'] = $sysurl;
            }
        }

        $this->output['list'] = $list;
        $this->output['sid'] = $this->curr_sid;


        //是否开启了免费预约功能
        if($this->checkToolUsableBool('mfyy')){
            $this->output['showFree'] = 1;
        }else{
            $this->output['showFree'] = 0;
        }


        $this->buildBreadcrumbs(array(
            array('title' => '商家管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/shop-list.tpl');
    }

    /**
     * 修改商家状态
     */
    public function changeStatusAction(){
        $id = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');
        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $set = array(
            'es_status' => $status?0:1
        );

        $ret = $shop_model->updateById($set, $id);

        if($ret){
            $shop = $shop_model->getRowById($id);
            $str = $set['es_status'] == 0 ? '正常' : '封禁';
            App_Helper_OperateLog::saveOperateLog("修改店铺【{$shop['es_name']}】状态：{$str}");
        }

        $this->showAjaxResult($ret);
    }
    /*
     * 关闭或开启店铺买单功能
     */
    public function openBuyAction(){
        $id = $this->request->getIntParam('id');
        $isbuy = $this->request->getIntParam('isbuy');
        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $set = array(
            'es_isbuy' => $isbuy?0:1
        );
        $ret = $shop_model->updateById($set, $id);

        if($ret){
            $str = $set['es_isbuy'] == 1 ? '开启' : '关闭';
            App_Helper_OperateLog::saveOperateLog("{$str}入驻店铺买单");
        }

        $this->showAjaxResult($ret,'操作');
    }

    /**
     * 帖子管理
     */
    public function postListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = array();
        $this->output['nickname'] = $this->request->getStrParam('nickname');
        if($this->output['nickname']){
            $where[]        = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$this->output['nickname']}%");
        }
        $this->output['content'] = $this->request->getStrParam('content');
        if($this->output['content']){
            $where[]        = array('name' => 'acp_content', 'oper' => 'like', 'value' => "%{$this->output['content']}%");
        }
        $this->output['cate'] = $this->request->getIntParam('cate');
        if($this->output['cate'] > 0){
            $where[]        = array('name' => 'acp_cate', 'oper' => '=', 'value' => $this->output['cate']);
        }
        $out['start']   = $this->request->getStrParam('start');
        if($out['start']){
            $where[]    = array('name' => 'acp_create_time', 'oper' => '>=', 'value' => strtotime($out['start']));
        }
        $out['end']     = $this->request->getStrParam('end');
        if($out['end']){
            $where[]    = array('name' => 'acp_create_time', 'oper' => '<=', 'value' => (strtotime($out['end']) + 86400));
        }
        $where[] = array('name'=>'acp_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'acp_deleted','oper'=>'=','value'=>0);
        $post_storage = new App_Model_Community_MysqlCommunityPostStorage($this->curr_sid);
        $total      = $post_storage->getPostListMemberCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $sort          = array('acp_create_time' => 'DESC');
            $list          = $post_storage->getPostListMember($where,$index,$this->count,$sort);
        }
        foreach($list as $key=>$val){
            $list[$key]['acp_content'] = $this->utf8_str_to_unicode($val['acp_content']);
        }

        $this->output['list'] = $list;
        $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->curr_sid);
        $this->output['costList'] = $cost_storage->findListBySid();

        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid(35);
        $this->output['tpl'] = $tpl;
        //获得帖子分类
        $this->_get_post_cate();
        $this->buildBreadcrumbs(array(
            array('title' => '帖子管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/post-list.tpl');
    }


    /**
     * 发帖置顶功能
     */
    public function updateCostTimeAction(){
        $res  =  array('ec'=>'400','em'=>'置顶失败');
        $pid  =  $this->request->getIntParam('id');//帖子id
        $cost =  $this->request->getIntParam('cost');//置顶费用id
        if($pid && $cost){
            $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->curr_sid);
            $cost         = $cost_storage->findRowByActid($cost);
            if($cost && $cost['act_data']){
                $topDate    = intval($cost['act_data']);
                $dateTime   = $topDate*60*60*24;
                $expiration = intval(time()+$dateTime);
                $data['acp_top_date']         = $topDate;
                $data['acp_istop']            = 1;
                $data['acp_istop_expiration'] = $expiration;
                $data['acp_pay_time']         = time();
                $post_model                   = new App_Model_Community_MysqlCommunityPostStorage($this->curr_sid);
                $ret                          = $post_model->updateById($data,$pid);
                if($ret){
                    $applet_redis = new App_Model_Applet_RedisAppletStorage($this->curr_sid);
                    $applet_redis->recordCommunityTopPostTask($pid,$dateTime);
                    $res  =  array('ec'=>'200','em'=>'置顶成功');
                    App_Helper_OperateLog::saveOperateLog("帖子置顶成功");
                }
            }else{
                $res['em']  =  '检查配置是否失效哦';
            }
        }
        $this->displayJson($res);
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
                $unicode_str.= '<span class="emoji-inner emoji'.dechex($unicode).'"></span>';
            }else{
                $unicode_str.=$val;
            }
        }
        return $unicode_str;
    }

    /**
     * 删除帖子
     */
    public function deletePostAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $article_model = new App_Model_Community_MysqlCommunityPostStorage($this->curr_sid);
            $ret = $article_model->deleteDFById($id,$this->curr_sid);
        }
        if($ret){
            App_Helper_OperateLog::saveOperateLog("删除帖子成功");
        }
        $this->showAjaxResult($ret,'删除');
    }

    /**
     * 帖子详情
     */
    public function postDetailsAction(){
        $id = $this->request->getIntParam('id');
        $post_storage = new App_Model_Community_MysqlCommunityPostStorage($this->curr_sid);
        $post = $post_storage->getPostRowMember($id);
        $post['acp_content'] = $this->utf8_str_to_unicode($post['acp_content']);
        $post['acp_images'] = json_decode($post['acp_images'],true);
        $this->output['post'] = $post;
        $this->_comment_list($id);
        $this->buildBreadcrumbs(array(
            array('title' => '帖子管理', 'link' => '/wxapp/community/postList'),
        ));
        $this->displaySmarty('wxapp/community/post-details.tpl');
    }


    private function _comment_list($pid){
        $count = 30;   // 帖子评论一次加载30条
        $page = $this->request->getIntParam('page');
        $index = $page*$count;
        $where[] = array('name'=>'acc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'acc_acp_id','oper'=>'=','value'=>$pid);
        $comment_model = new App_Model_Community_MysqlCommunityPostCommentStorage($this->curr_sid);
        $total      = $comment_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$count);
        $this->output['pagination'] = $pageCfg->render();
        $list = $comment_model->getCommentMember($pid,$index,$count);
        foreach($list as $key => $val){
            $list[$key]['acc_comment'] = $this->utf8_str_to_unicode($val['acc_comment']);
        }
        $this->output['commentList'] = $list;

    }
    /**
     * 删除帖子评论
     */
    public function deletePostCommentAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $comment_model = new App_Model_Community_MysqlCommunityPostCommentStorage($this->curr_sid);
            $ret = $comment_model->deleteBySidId($id,$this->curr_sid);
        }
        if($ret){
            App_Helper_OperateLog::saveOperateLog("删除帖子评论成功");
        }
        $this->showAjaxResult($ret,'删除');
    }

    /**
     * 帖子封禁
     */
    public function postStatusChangeAction(){
        $pid = $this->request->getIntParam('pid');
        $status = $this->request->getIntParam('status');
        $ret = 0;
        if($pid){
            $post_storage = new App_Model_Community_MysqlCommunityPostStorage($this->curr_sid);
            $post = $post_storage->getPostRowMember($pid);
            if($post){
                $set = array('acp_status'=>$status);
                $ret = $post_storage->updateById($set,$pid);
            }
        }
        if($ret){
            $str = $status == 1 ? '封禁' : '解封';
            App_Helper_OperateLog::saveOperateLog("{$str}帖子成功");
        }
        $this->showAjaxResult($ret);
    }
    /**
     * 修改帖子信息
     */
    public function updatePostAction(){
        $id      = $this->request->getIntParam('id');
        $showNum = $this->request->getIntParam('showNum');
        $likeNum = $this->request->getIntParam('likeNum');
        $postCate = $this->request->getIntParam('postCate');
        if($id){
            $post_model = new App_Model_Community_MysqlCommunityPostStorage($this->curr_sid);
            if($likeNum>0){
                $like_ret = $post_model->addReducePostNum($id,'like','add',$likeNum);
            }
            if($showNum>0){
                $show_ret = $post_model->addReducePostNum($id,'show','add',$showNum);
            }
            $cate_ret = $post_model->updateById(array('acp_cate'=>$postCate),$id);
        }
        if($like_ret || $show_ret || $cate_ret){
            $ret = 1;
        }else{
            $ret = 0;
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("修改帖子信息成功");
        }

        $this->showAjaxResult($ret,'修改');
    }

    public function districtAction(){
        $page = $this->request->getIntParam('page');
        $name = $this->request->getStrParam('name');
        $searchProvince = $this->request->getIntParam('searchProvince');
        $searchCity = $this->request->getIntParam('searchCity');
        $searchZone = $this->request->getIntParam('searchZone');

        $index = $page * $this->count;
        $district_model = new App_Model_Community_MysqlCommunityDistrictStorage();
        $address_model = new App_Model_Address_MysqlAddressCoreStorage();
        $where[] = array('name' => 'region_name', 'oper' => '=', 'value' => $this->company['c_city']);
        //避免当城市为直辖市时获得省级行政单位数据
        $where[] = array('name' => 'region_type', 'oper' => '=', 'value' => 2);
        $area = $address_model->getRow($where);
        $this->output['zone'] = $area;
        $area = $address_model->get_area_by_parent($area['region_id']);
        foreach($area as $val){
            $areaSelect[$val['region_id']] = $val['region_name'];
        }
        $where = array();
        if($name){
            $where[] = array('name' => 'acd_name', 'oper' => 'like', 'value' => "%{$name}%");
        }
        if($searchProvince){
            $where[] = array('name' => 'acd_prov_id', 'oper' => 'like', 'value' => $searchProvince);
        }
        if($searchCity){
            $where[] = array('name' => 'acd_city_id', 'oper' => 'like', 'value' => $searchCity);
        }
        if($searchZone){
            $where[] = array('name' => 'acd_area_id', 'oper' => 'like', 'value' => $searchZone);
        }
        $where[] = array('name' => 'acd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acd_deleted', 'oper' => '=', 'value' => 0);
        $sort = array('acd_create_time' => 'desc');
        $total      = $district_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $list = $district_model->getList($where, $index, $this->count, $sort);
        $this->output['area'] = $area;
        $this->output['areaSelect'] = $areaSelect;
        $this->output['provSelect'] = $address_model->get_province_for_select();
        $this->output['searchZone'] = $searchZone;
        $this->output['searchProvince'] = $searchProvince?$searchProvince:$this->output['zone']['parent_id'];
        $this->output['searchCity'] = $searchCity?$searchCity:$this->output['zone']['region_id'];
        $this->output['name'] = $name;
        $this->output['list'] = $list;
        $this->output['pagination'] = $pageCfg->render();
        $this->buildBreadcrumbs(array(
            array('title' => '商圈管理', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/community/district.tpl");
    }

    public function saveDistrictAction(){
        $name = $this->request->getStrParam('name');
        $province = $this->request->getIntParam('province');
        $city = $this->request->getIntParam('city');
        $area = $this->request->getIntParam('area');
        $areaName = $this->request->getStrParam('areaName');
        $id   = $this->request->getIntParam('id');
        $weight = $this->request->getIntParam('weight');
        $district_storage = new App_Model_Community_MysqlCommunityDistrictStorage();

        $address_model = new App_Model_Address_MysqlAddressCoreStorage();
        $areaRow = $address_model->getRowById($area);
        $data=array(
            'acd_prov_id' => $province,
            'acd_city_id' => $city,
            'acd_s_id' => $this->curr_sid,
            'acd_area_id' => $area,
            'acd_area_name' => $areaRow['region_name'],
            'acd_name' => $name,
            'acd_sort' => $weight,
            'acd_create_time' => time()
        );

        if($id){
            $ret = $district_storage->updateById($data, $id);
        }else{
            $ret = $district_storage->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("商圈【{$name}】保存成功");
        }

        $this->showAjaxResult($ret);
    }

    public function deleteDistrictAction(){
        $id = $this->request->getIntParam('id');
        $district_storage = new App_Model_Community_MysqlCommunityDistrictStorage();
        if($id){
            $district = $district_storage->getRowById($id);
            $data = array('acd_deleted' => 1);
            $ret = $district_storage->updateById($data, $id);
            if($ret){
                App_Helper_OperateLog::saveOperateLog("商圈【{$district['acd_name']}】删除成功");
            }
        }
        $this->showAjaxResult($ret);
    }

    //商家入驻配置
    public function inChargeAction(){
        $cost_storage = new App_Model_Community_MysqlCommunityEnterCostStorage($this->curr_sid);
        $where   = array();
        $where[] = array('name' => 'acec_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort = array('acec_date' => 'ASC');
        $list = $cost_storage->getList($where, 0, 0, $sort);
        if($list){
            $this->output['list'] = $list;
        }
        $this->buildBreadcrumbs(array(
            array('title' => '商家入驻', 'link' => '/wxapp/community/shopApplyEnter'),
            array('title' => '入驻费用配置', 'link' => '#')
        ));
        $this->output['costData'] = plum_parse_config('community_enter_time', 'system');
        $this->displaySmarty('wxapp/community/enter-cost-setting.tpl');
    }

    //保存入驻费用
    public function addInChargeAction(){
        $id   = $this->request->getIntParam('id');
        $date = $this->request->getIntParam('date');
        $desc = $this->request->getStrParam('desc');
        $cost = $this->request->getFloatParam('cost');
        $cost_storage = new App_Model_Community_MysqlCommunityEnterCostStorage($this->curr_sid);
        if($id > 0){
            $data = array(
                'acec_cost' => $cost,
                'acec_update_time' => time()
            );
            $ret = $cost_storage->updateById($data, $id);
        }else{
            $data = array(
                'acec_s_id' => $this->curr_sid,
                'acec_desc' => $desc,
                'acec_date' => $date,
                'acec_cost' => $cost,
                'acec_update_time' => time()
            );
            $ret = $cost_storage->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存入驻费用成功");
        }

        $this->showAjaxResult($ret);
    }
    /*
     * 删除入驻费用
     */
    public function deleteInChargeAction(){
        $id   = $this->request->getIntParam('id');
        $cost_storage = new App_Model_Community_MysqlCommunityEnterCostStorage($this->curr_sid);
        $where[] = array('name' => 'acec_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acec_id', 'oper' => '=', 'value' => $id);
        $res = $cost_storage->deleteValue($where);

        if($res){
            App_Helper_OperateLog::saveOperateLog("删除入驻费用成功");
        }

        $this->showAjaxResult($res,'删除');
    }

    /**
     * 商品列表
     */
    public function goodsAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '#'),
        ));
        $this->_show_goods_list_data();
        $this->_show_category();
        $this->output['choseLink']  = $this->showTableLink('goods');
        $this->displaySmarty('wxapp/cake/goods-list.tpl');
    }

    /**
     * 获取状态连接
     * @return [type] [description]
     */
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
                        'href'  => '/wxapp/cake/tradeList?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/cake/tradeList?status=nopay'.$extra,
                        'key'   => 'nopay',
                        'label' => '待付款'
                    ),
                    array(
                        'href'  => '/wxapp/cake/tradeList?status=pay'.$extra,
                        'key'   => 'pay',
                        'label' => '已付款'
                    ),
                    array(
                        'href'  => '/wxapp/cake/tradeList?status=complete'.$extra,
                        'key'   => 'complete',
                        'label' => '已完成'
                    ),
                    array(
                        'href'  => '/wxapp/cake/tradeList?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '已退款'
                    ),
                    array(
                        'href'  => '/wxapp/cake/tradeList?status=close'.$extra,
                        'key'   => 'close',
                        'label' => '已关闭'
                    ),
                );
                break;
            case 'goods' :
                $link = array(
                    array(
                        'href'  => '/wxapp/cake/goods?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '出售中'
                    ),
                    array(
                        'href'  => '/wxapp/cake/goods?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                );
                break;
            case 'pointGoods' :
                $link = array(
                    array(
                        'href'  => '/wxapp/community/pointGoods?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '出售中'
                    ),
                    array(
                        'href'  => '/wxapp/community/pointGoods?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                );
                break;
            case 'settled' :
                $link = array(
                    array(
                        'href'  => '/wxapp/cake/settled?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/cake/settled?status=doing'.$extra,
                        'key'   => 'doing',
                        'label' => '进行中'
                    ),
                    array(
                        'href'  => '/wxapp/cake/settled?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '退款'
                    ),
                    array(
                        'href'  => '/wxapp/cake/settled?status=success'.$extra,
                        'key'   => 'success',
                        'label' => '成功'
                    ),
                );
                break;


        }
        return $link;
    }

    /**
     * 获取商品列表
     */
    private function _show_goods_list_data($isPoint=0){
        $where          = array();
        $where[]        = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        if($isPoint){
            $output['gtype'] = $this->request->getIntParam('gtype');
            if($output['gtype']){
                $where[]        = array('name' => 'g_type','oper' => '=','value' => $output['gtype']);
            }else{
                if($this->wxapp_cfg['ac_type'] == 27){
                    $where[]        = array('name' => 'g_type','oper' => '=','value' => 4);
                }else{
                    $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(4,5));
                }
            }
        }else{
            $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        }
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'g_name','oper' => 'like','value' =>"%{$output['name']}%");
        }
        $output['cate'] = $this->request->getIntParam('cate');
        if($output['cate']){
            $where[] = array('name' => 'g_kind1','oper' => '=','value' =>$output['cate']);
        }

        //商品状态
        $output['status'] = $this->request->getStrParam('status','sell');
        switch($output['status']){
            case 'sell':
                $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>1);
                break;
            case 'depot':
                $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>2);
                break;
        }

        $page                = $this->request->getIntParam('page');
        $index               = $page * $this->count;
        $goods_model         = new App_Model_Goods_MysqlGoodsStorage();
        $total               = $goods_model->getCount($where);
        $pageCfg             = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        $deduct = array();
        if($index <= $total){
            //积分商城按权重排序商品
            //zhangzc
            //2019-08-01
            $sort = array('g_weight'=>'DESC','g_update_time' => 'DESC');
            $list = $goods_model->getList($where,$index,$this->count,$sort);
            $deduct_gids = array();
            foreach($list as &$val){
                $deduct_gids[] = $val['g_id'];
                $param = array(
                    'gid' => $val['g_id']
                );
            }
        }
        if($list){
            $output['now'] = 1;
        }
        $output['list'] = $list;

        //获得统计信息
        $where_sale = $where_nosale = [];
        $where_sale[] = $where_nosale[] = ['name' => 'g_s_id','oper' => '=','value' => $this->curr_sid];
        if($isPoint){
            $where_nosale[] = $where_sale[] = ['name' => 'g_type','oper' => 'in','value' => [4,5]];
        }
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

    /**
     * @param int $is_add
     * 展示商品类目
     */
    private function _show_category(){
        $category_model = new App_Model_Community_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getListBySid();
        $category       = array();
        foreach($first as $val){
            $category[$val['ack_id']] = $val['ack_name'];
        }
        $this->output['category']   =$category ;
    }

    /**
     * @param int $is_add
     * 展示商分类和商品
     */
    private function _show_category_goods(){
        $category_model = new App_Model_Community_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getListBySid();
        $category       = array();
        foreach($first as $val){
            $category[$val['ack_id']] = array(
                'id'   => $val['ack_id'],
                'name' => $val['ack_name'],
                'goods'=> $this->_get_category_goods($val['ack_id'])
            );
        }
        $this->output['categoryGoods']   =$category ;
    }

    /**
     * 获取分类下商品
     */
    private function _get_category_goods($id){
        //获取店铺商品
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $sort        = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        $list        = $goods_model->fetchShopGoodsList($this->curr_sid, 0, array(4,5), null, 0, $sort,array(),$id);
        $info        = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        return $info;
    }

    /**
     * 添加商品
     */
    public function addGoodAction(){
        $id  = $this->request->getIntParam('id');
        $row = array(); $slide = array();$format = array();
        $formatNum = 0;
        $giftNum   = 0;
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
                foreach ($format as $key => $value) {
                    $format[$key]['gf_cake_gift'] = json_decode($value['gf_cake_gift']);
                }
            }
        }
        //展示分类数据 
        $this->_show_category();
        // 商品类型
        if($row['g_cake_gift']){
            $row['g_cake_gift']  = json_decode($row['g_cake_gift']);
        }
        $this->output['row'] = $row;
        //获取幻灯数据
        $this->output['slide']      =  $slide;
        $this->output['format']     =  $format;
        $this->output['formatNum']  = $formatNum;
        $this->output['formatSort'] = implode(',',$sort);

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '/wxapp/cake/goods'),
            array('title' => '添加商品', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/cake/add-goods.tpl");
    }
    /**
     * 选中商品=>积分商品的功能
     */

    public function selectGoodsAction() {
        $this->secondPointLink('pointGoods');
        $this->output['showSecond'] = 1;
        $this->buildBreadcrumbs(array(
            array('title' => '积分商品', 'link' => '/wxapp/community/pointGoods'),
            array('title' => '添加积分商品', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/cake/select-goods.tpl');
    }

    /**
     * 获取全部商品-用于选择
     */
    public function pointSelectAction(){
        $this->count = 10;
        $page     = $this->request->getIntParam('page',1);
        $keyword  = $this->request->getStrParam('keyword');
        $page     = $page >=1 ? $page : 1;
        $index    = ($page - 1)* $this->count;
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $where[]     = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);
        $where[]     = array('name' => 'g_type', 'oper' => 'in', 'value' => [1,2]);

        if($this->wxapp_cfg['ac_type'] == 18){
            //预约版 过滤服务项目和专家
            $where[] = array('name' => 'g_kind1', 'oper' => '!=', 'value' => 1);
            $where[] = array('name' => 'g_kind1', 'oper' => '!=', 'value' => 2);
        }

        $list        = $goods_model->fetchShopGoodsList($this->curr_sid,$index,$this->count,$keyword, 0, array(),array(),0,0,1,$where);
        $total       = $goods_model->fetchCountBySid($this->curr_sid,$keyword,0,0,0,'',$where);
        $tot_page    = ceil($total/$this->count);

        $menu_helper = new App_Helper_Menu();
        //$menu        = $menu_helper->ajaxPageLink($tot_page , $page);
        $menu        = $menu_helper->ajaxGoodsPageLink($tot_page , $page);

        $data = array(
            'ec'        => 200,
            'list'      => $list,
            'pageHtml'  => $menu
        );
        $this->displayJson($data);
    }
    /**
     * 保存选择的商品成为-积分商品
     */
    public function copyPointGoodsAction(){
        $result  =  array('ec'=>400,'em'=>'保存失败');
        $ret = $this->save_point_goods();
        if($ret){
            $result  =  array('ec'=>200,'em'=>'保存成功');
        }
        $this->displayJson($result);
    }

    /**
     * @param $newid
     * 保存参与活动的商品
     */
    private function save_point_goods(){
        $goods          = $this->request->getArrParam('goods');
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        foreach($goods as $val){//$val['gid'] $val['price']:修改的积分数量
            $data     = array();
            $goodData = $goods_model->getRowById($val['gid']);
            foreach ($goodData as $key=>$item){
                $data[$key] = $item;
            }
            $data['g_points'] = $val['price'];
            $data['g_type']   = $data['g_type'] == 1?4:5;
            $data['g_create_time'] = time();
            $data['g_update_time'] = time();
            unset($data['g_id']);
            unset($data['g_qrcode']);
            $ret  = $goods_model->insertValue($data);//新商品的id
            if($ret){
                App_Helper_OperateLog::saveOperateLog("积分商品【".$data['g_name']."】保存成功");
                //为新商品复制原来的规格
                /*$old_format     = $format_model->getListByGid($val['gid']);
                if($old_format){
                    foreach ($old_format as $oval){
                        $format[]   = "(NULL, '{$this->curr_sid}', '{$ret}', '{$oval['gf_name']}','{$oval['gf_price']}','{$oval['gf_points']}','{$oval['gf_stock']}','{$oval['gf_sort']}', '{$oval['gf_sold']}','".time()."', '{$oval['gf_cake_gift']}')";
                    }
                }*/
                //为新商品复制原来的幻灯
                $old_slide      = $slide_model->getListByGidSid($val['gid'],$this->curr_sid);
                if($old_slide){
                    foreach($old_slide as $sval){
                        $slide[] = "(NULL, '{$this->curr_sid}', '{$ret}', '{$sval['gs_path']}', 0, '".time()."')";
                    }
                }
            }
        }
        /*if(!empty($format)){
            $res  = $format_model->batchPointsSave($format);
        }*/
        if(!empty($slide)){
            $ress = $slide_model->batchSave($slide);
        }
        if($ret  || $ress){
            return true;
        }
    }
    /**
     * 保存为积分商品时候
     */







    /**
     * 保存商品
     */
    public function saveGoodAction(){
       $result = array(
            'ec' => 400,
            'em' => '请填写完整商品数据'
        );
        $temp_psf = $this->math_price_stock_format();
        $id       = $this->request->getIntParam('id');  //ID
        $intField = array('g_weight','g_sold','g_stock'); //类型,排序权重,  g_c_id类目已删除
        $data     = $this->getIntByField($intField);
        $data['g_name']         = $this->request->getStrParam('g_name');  // 名称
        $data['g_price']        = $temp_psf['price'];    // 售价
        $data['g_has_format']   = $temp_psf['format']; //规格

        $data['g_type']         = $this->request->getIntParam('g_type', 4);    // 原价
        $data['g_ori_price']    = $this->request->getFloatParam('g_ori_price');    // 原价
        $data['g_points']       = $this->request->getFloatParam('g_points');    // 购买所需积分
        $data['g_unified_fee']  = $this->request->getFloatParam('g_unified_fee'); //运费价格

        $data['g_cover']        = $this->request->getStrParam('g_cover'); //封面图
        $data['g_expfee_type']  = $this->request->getStrParam('g_expfee_type'); //运费类型
        $data['g_unified_tpid']  = $this->request->getStrParam('g_unified_tpid'); //运费模板id
        $data['g_brief']        = $this->request->getStrParam('g_brief'); ; //简介
        $data['g_detail']       = $this->request->getStrParam('g_detail');  //详情
        $stockShow              = $this->request->getStrParam('g_stock_show'); //库存显示
        $data['g_stock_show']   = ($stockShow == 'on' || $stockShow == 1)? 1 : 0;
        $istop                  = $this->request->getStrParam('g_is_top'); //是否店铺推荐
        $special                = $this->request->getStrParam('g_special'); //是否店铺推荐
        $data['g_is_top']       = ($istop == 'on' || $istop == 1)? 1 : 0;
        $data['g_special']      = ($special == 'on' || $special == 1)? 1 : 0;
        $data['g_kind1']        = $this->request->getIntParam('g_kind1');
        $data['g_s_id']         = $this->curr_sid;
        $data['g_update_time']  = time();
        $format                 = $this->request->getIntParam('format-num');
        $data['g_video_url']    = $this->request->getStrParam('g_video');

        if($data['g_name'] && (($data['g_price']>=0 && $format == 0) || $format > 0)){
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
                App_Helper_OperateLog::saveOperateLog("积分商品【".$data['g_name']."】保存成功");
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功',
                );
            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }

    /**
     * @param $goId
     * @param int $is_add 1标注新增
     * 根据商品ID处理商品幻灯
     */
    public function batchSlide($goId,$is_add=0){
        $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
        $maxNum         = $this->request->getStrParam('slide-img-num');
        $slide          = array();
        if($is_add){ //新增，则批量插入
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                if($temp){
                    $slide[] = "(NULL, '{$this->curr_sid}', '{$goId}', '{$temp}', 0, '".time()."')";
                }
            }
            $slide_model->batchSave($slide);
        }else{ //循环更新
            $sl_id = array();
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                $temp_id = $this->request->getIntParam('slide_id_'.$i);
                if($temp && $temp_id == 0){ //新增
                    $slide[] = $temp;
                }
                if($temp_id){ //不变的
                    $sl_id[] = $temp_id;
                }
            }

            //@todo 统计需删除的幻灯
            $del_id = array();
            $old_slide = $slide_model->getListByGidSid($goId,$this->curr_sid);
            foreach($old_slide as $val){
                if(!in_array($val['gs_id'],$sl_id)){
                    $del_id[] = $val['gs_id'];
                }
            }

            //@todo 新增和删除的幻灯，进行处理
            if(count($slide) <= count($del_id)){ //删除的大于等于新增的
                for($d=0 ; $d < count($del_id) ; $d++){
                    if(isset($slide[$d]) && $slide[$d]){
                        $slide_model->updateSlide($del_id[$d],$slide[$d]);
                        unset($del_id[$d]); //移除被占用的幻灯
                    }
                }
                //@todo 真实删除多余的幻灯
                if(!empty($del_id)){
                    $slide_model->deleteSlide($goId,$del_id);
                }
            }else{ //新增的多
                $batch_slide = array();
                for($s=0 ; $s < count($slide) ; $s++){
                    if(isset($del_id[$s]) && $del_id[$s]){
                        $slide_model->updateSlide($del_id[$s],$slide[$s]);
                        unset($slide[$s]); //移除已经更改的幻灯
                    }else{
                        $sTemp = plum_sql_quote($slide[$s]);
                        $batch_slide[] = "(NULL, '{$this->curr_sid}', '{$goId}', '{$sTemp}', 0, '".time()."')";
                    }
                }
                //@todo  批量新增幻灯
                if(!empty($batch_slide)){
                    $slide_model->batchSave($batch_slide);
                }
            }
        }
    }

    /**
     * @return array
     * 获取商铺价格，规格数量信息
     */
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

    /**
     * 商品上下架控制
     */
    public function shelfAction(){
        $ids    = $this->request->getStrParam('ids');
        $id_arr = plum_explode($ids);
        $type   = $this->request->getStrParam('type');
        $result = array(
            'ec' => 400,
            'em' => '您尚未选择商品'
        );
        if(!empty($id_arr)){
            if($type == 'down'){ //下架
                $set = array(
                    'g_is_sale' => 2
                );
            }else{ //上架
                $set = array(
                    'g_is_sale' => 1
                );
            }
            $where   = array();
            $where[] = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
            $where[] = array('name' => 'g_id','oper' => 'in','value' =>$id_arr);
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $ret = $goods_model->updateValue($set,$where);
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
                $str = $type == 'down' ? '下架' : '上架';
                App_Helper_OperateLog::saveOperateLog("商品{$str}成功");
            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }    

    /**
     * @param $goId
     * @param int $is_add
     * 商品规格添加，修改
     */
    private function batchGoodsFormat($goId,$is_add=0){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        $maxNum         = $this->request->getIntParam('format-num');
        $go_price       = $this->request->getFloatParam('g_price');    // 售价
        $formatSort     = $this->request->getStrParam('format-sort');
        $sortArr        = explode(',',$formatSort);
        $format         = array();
        if($is_add){ //新增，则批量插入
            for($i=1; $i <= $maxNum; $i++){
                $name       = plum_sql_quote(plum_get_param('format_name_'.$i));
                $tem_price  = $this->request->getFloatParam('format_price_'.$i);
                $points     = $this->request->getFloatParam('format_points_'.$i);
                $sort       = array_search('format_id_'.$i,$sortArr);
                $price      = $tem_price ? $tem_price : $go_price ;
                if($name && $price){
                    $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$name}','{$price}','{$points}','','{$sort}', 0, '".time()."', '')";
                }
            }
        }else{
            $gf_id = array();
            for($i=0; $i <= $maxNum; $i++){
                $name    = plum_sql_quote($this->request->getStrParam('format_name_'.$i));
                $price   = $this->request->getFloatParam('format_price_'.$i);
                $points  = $this->request->getFloatParam('format_points_'.$i);
                $id      = $this->request->getIntParam('format_id_'.$i);
                if($name){ //新增
                    $sort       = array_search('format_id_'.$i,$sortArr);//gf_sort
                    $temp = array(
                        'gf_name'   => $name,
                        'gf_price'  => $price ? $price : $go_price,
                        'gf_points' => $points,
                        'gf_sort'   => $sort,
                    );
                    if($id == 0){ // 新增，批量处理
                        $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$temp['gf_name']}','{$temp['gf_price']}','{$temp['gf_points']}','{$temp['gf_stock']}','{$temp['gf_sort']}', 0, '".time()."', '')";
                    }else{
                        //@todo 更新商品规格
                        $format_model->updateFormat($id,$temp);
                        $gf_id[] = $id; //记录存在的ID，用于删除
                    }
                }
            }

            //@todo 删除的商品规格
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
        //@todo  批量新增商品规格
        if(!empty($format)){
            $format_model->batchPointsSave($format);
        }
    }

    /**
     * 入驻商家订单列表
     */
    public function shopOrderAction() {
        $esId = $this->request->getIntParam('esId');
        $where[] = array('name' => 't_es_id', 'oper' => '=', 'value' => $esId);
        $this->show_trade_list_data($where);
        $this->output['print'] = plum_parse_config('type','print');
        $this->output['tradePay'] =  App_Helper_Trade::$trade_pay_type;
        $this->output['searchUrl'] = '/wxapp/community/shopOrder';
        $this->output['esId'] = $esId;
        $this->_shop_list_for_select(true);
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where,true);
        $this->buildBreadcrumbs(array(
            array('title' => '商家列表', 'link' => '/wxapp/community/shopList'),
            array('title' => '订单列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/trade-list.tpl');
    }

    /**
     * 积分商城订单列表
     */
    public function pointOrderAction() {
        $this->secondPointLink('pointOrder');
        $where[] = array('name' => 't_es_id', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 't_applet_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET_POINT);
        $this->show_trade_list_data($where);
        $link = App_Helper_Trade::$trade_link_status;
        unset($link['tuan']);
        $this->output['link'] = $link;
        $this->output['pointOrder'] = 1;
        $this->output['print'] = plum_parse_config('type','print');
        $this->output['tradePay'] =  App_Helper_Trade::$trade_pay_type;
        $this->output['searchUrl'] = '/wxapp/community/pointOrder';
        $this->output['appletCfg'] = $this->wxapp_cfg;
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where,true);
        $this->output['orderType'] = 4;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '积分商城', 'link' => '/wxapp/community/pointGoods'),
            array('title' => '积分订单', 'link' => '#'),
        ));

        //隐藏积分商品分类选择
        $hideDeduct = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[32])){
            $hideDeduct = 1;
        }
        $this->output['hideDeduct'] = $hideDeduct;

        $this->displaySmarty('wxapp/community/trade-list.tpl');
    }

    /**
     * 交易订单列表
     */
    public function tradeListAction() {
        $where = array();
        $esId = $this->request->getIntParam('esId',0);
        if($esId > 0){
            $where[] = array('name' => 't_es_id', 'oper' => '=', 'value' => $esId);
        }elseif($esId < 0){
            $where[] = array('name' => 't_es_id', 'oper' => '=', 'value' => 0);
        }
        $this->show_trade_list_data($where);
        $this->_shop_list_for_select(true);
        $this->output['print'] = plum_parse_config('type','print');
        $this->output['tradePay'] =  App_Helper_Trade::$trade_pay_type;
        $this->output['searchUrl'] = '/wxapp/community/tradeList';
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where,true);
        $this->buildBreadcrumbs(array(
            array('title' => '订单列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/trade-list.tpl');
    }

    /*
     * 订单详情
     */
    public function tradeDetailAction($isActivity = '') {
        $this->output['tradePay'] = App_Helper_Trade::$trade_pay_type;
        $this->output['tradeType']= App_Helper_Trade::$trade_applet_type;

        if($isActivity){
            $this->output['isActivity'] = 1;
            $this->secondPointLink('pointOrder');
        }

        $this->show_trade_detail_data();
        $this->buildBreadcrumbs(array(
            array('title' => '订单列表', 'link' => '/wxapp/community/tradeList'),
            array('title' => '订单详情', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/trade-detail.tpl');
    }
    /*
     * 积分订单详情
     */
    public function pointTradeDetailAction() {
        $this->tradeDetailAction('point');
    }

    /**
     * 订单详情数据
     */
    private function show_trade_detail_data(){
        $tid = $this->request->getStrParam('order_no');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'t_tid','oper'=>'=','value'=>$tid);
        $list       = $trade_model->getAddressList($where,0,1,array());
        if(!empty($list) && isset($list[0])){
            $row = $list[0];
            $row['t_remark_extra'] = json_decode($row['t_remark_extra'], true);
            $output['row']  = $row;
            //@todo 待发货情况下获取物流
            $express = array();
            $needSend= 0;
            if($row['t_status'] == App_Helper_Trade::TRADE_HAD_PAY){ // 待发货
                $express_model  = new App_Model_Trade_MysqlExpressStorage();
                $express        = $express_model->getExpressList(1);
                $needSend       = 1;
            }
            $output['needSend'] = $needSend;
            $output['express']  = $express;
            //订单优惠活动
            $coupon = array();
            if($row['t_discount_fee']){
                $trade_coupon_model = new App_Model_Trade_MysqlTradeCouponStorage($this->curr_sid);
                $coupon             = $trade_coupon_model->getListByTid($row['t_tid']);
            }
            $output['coupon']       = $coupon;
            //订单满减活动
            $full   = array();
            if($row['t_promotion_fee']){
                $trade_full_model   = new App_Model_Trade_MysqlTradeFullStorage($this->curr_sid);
                $full               = $trade_full_model->getListByTid($row['t_tid']);
            }
            $output['full']         = $full;
            //一单多个商品情况
            $trade_order        = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
            $output['list']     = $trade_order->getGoodsListByTid($row['t_id']);

            $this->_trade_detail_status_desc($row);
            $output['statusNote'] = plum_parse_config('trade_status');
            $this->express_detail($row['t_company_code'],$row['t_express_code']);
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
                    //$account = '<div>买家已将货款支付至您的 平台账户，请到<a href="/manage/shop/basic" target="_blank">店铺概况</a>查收。</div>';
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
                    'desc'      => '<div>用户已确认收货，订单已经完成。</div>'
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

    private function express_detail($code,$num){
        $data = array();
        $nowStatus = '';
        if($code && $num){
            $track_model = new App_Helper_ExpressTrack();
            $track = $track_model->fetchJsonTrack($code,$num);
            if(!empty($track) && $track['Success']){
                $data = $track['Traces'];
                switch ($track['State']){
                    case 2 :
                        $status = '[在途中]';
                        break;
                    case 3 :
                        $status = '[签收]';
                        break;
                    case 4 :
                        $status = '[问题件]';
                        break;
                    default:
                        $status = '[在途中]';
                        break;
                }
                $nowStatus = $data[count($data)-1]['AcceptTime'].' '.$status.' '. $data[count($data)-1]['AcceptStation'];
            }
        }
        $this->output['nowStatus']  = $nowStatus;
        $this->output['last']       = count($data)-1;
        $this->output['track']      = $data;
    }

    /**
     * 模版启用
     */
    public function startAppletTplAction(){
        $result     = array(
            'ec'    => 400,
            'em'    => '该模版不可用'
        );
        $id         = $this->request->getIntParam('id');
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row        = $tpl_model->getRowBySid($id,$this->curr_sid);
        if($row || $id==0){
            $set = array(
                'ac_index_tpl'   => $id,
                'ac_update_time' => time()
            );
            //获取配置信息
            // $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            // 头条保存自定义首页配置未生效bug
            // zhangzc
            // 2019-10-19
            //获取配置信息
            if( $this->menuType=='toutiao')
                $applet_cfg = new App_Model_Toutiao_MysqlToutiaoCfgStorage($this->curr_sid);
            else
                $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);

            $ret = $applet_cfg->findShopCfg($set);
            if($ret){
                $result     = array(
                    'ec'    => 200,
                    'em'    => ' 启用成功'
                );
                App_Helper_OperateLog::saveOperateLog("首页模板【{$row['it_name']}】启用成功");
            }else{
                $result['em'] = '启用失败';
            }
        }
        $this->displayJson($result);
    }

    /**
     * 配送方式配置
     */
    public function sendMethodAction(){
        $send_storage = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        $send_cfg = $send_storage->findUpdateBySid();
        if(!$send_cfg){
            $data = array(
                'acs_s_id' => $this->curr_sid,
                'acs_send' => 1,
                'acs_receive' => 0,
                'acs_create_time' => time()
            );
            $send_storage->insertValue($data);
        }
        $send_cfg = $send_storage->findUpdateBySid();
        $this->output['cfg'] = $send_cfg;
        $this->displaySmarty('wxapp/cake/send-cfg.tpl');
    }

    /**
     * 修改配送方式配置
     */
    public function changeSendAction(){
        $result     = array(
            'ec'    => 400,
            'em'    => '修改失败'
        );
        $type = $this->request->getStrParam('type');
        $value = $this->request->getStrParam('value');
        $status = $value == 'on'? 1 : 0;
        if($type == 'send'){
            $type_str = '商家配送';
            $data['acs_send'] = $status;
        }
        if($type == 'receive'){
            $type_str = '门店自取';
            $data['acs_receive'] = $status;
        }
        $data['acs_update_time'] = time();
        $send_storage = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        $ret = $send_storage->findUpdateBySid($data);
        if($ret){
            $result     = array(
                'ec'    => 200,
                'em'    => ' 修改成功'
            );
            $status_str = $status == 1 ? '开启' : '关闭';
            App_Helper_OperateLog::saveOperateLog("{$type_str}{$status_str}成功");
        }
        $this->displayJson($result);
    }

    /*********************************积分商城***************************************/
    /**
     * @param string $type
     * 自定义二级链接，根据类型，确定默认选中
     */
    public function secondPointLink($type='index',$returnInfo=false){
        if($this->wxapp_cfg['ac_type'] == 27){
            $link = array(
                array(
                    'label' => '积分商城',
                    'link'  => '/wxapp/knowledgepay/pointCfg',
                    'active'=> 'pointCfg'
                ),
                array(
                    'label' => '积分课程',
                    'link'  => '/wxapp/knowledgepay/pointGoods',
                    'active'=> 'pointCourse'
                ),
                array(
                    'label' => '积分商品',
                    'link'  => '/wxapp/community/pointGoods',
                    'active'=> 'pointGoods'
                ),
                array(
                    'label' => '积分订单',
                    'link'  => '/wxapp/knowledgepay/pointOrder',
                    'active'=> 'pointOrder'
                ),
                array(
                    'label' => '积分来源',
                    'link'  => '/wxapp/community/pointSourceCfg',
                    'active'=> 'pointSourceCfg'
                ),
            );
        }elseif ($this->curr_sid == 10380 || $this->curr_sid == 4230){
            $link = array(
                array(
                    'label' => '积分商城',
                    'link'  => '/wxapp/community/pointCfg',
                    'active'=> 'pointCfg'
                ),
                array(
                    'label' => '积分来源',
                    'link'  => '/wxapp/community/pointSourceCfg',
                    'active'=> 'pointSourceCfg'
                ),
                array(
                    'label' => '积分订单',
                    'link'  => '/wxapp/community/pointOrder',
                    'active'=> 'pointOrder'
                ),
                array(
                    'label' => '积分商品',
                    'link'  => '/wxapp/community/pointGoods',
                    'active'=> 'pointGoods'
                ),
                //新增积分商城优惠券
                array(
                    'label' => '优惠券',
                    'link'  => '/wxapp/community/couponList',
                    'active'=> 'couponList'
                ),
                array(
                    'label' => '运费模板',
                    'link'  => '/wxapp/community/postTpl',
                    'active'=> 'postTpl'
                ),
//                array(
//                    'label' => '会员卡',
//                    'link'  => '/wxapp/community/memberCardList',
//                    'active'=> 'memberCardList'
//                )
            );
        }elseif($this->wxapp_cfg['ac_type'] == 6){
            $link = array(
                array(
                    'label' => '积分商城',
                    'link'  => '/wxapp/community/pointCfg',
                    'active'=> 'pointCfg'
                ),
                array(
                    'label' => '积分来源',
                    'link'  => '/wxapp/community/pointSourceCfg',
                    'active'=> 'pointSourceCfg'
                ),
                array(
                    'label' => '积分订单',
                    'link'  => '/wxapp/community/pointOrder',
                    'active'=> 'pointOrder'
                ),
                array(
                    'label' => '商品分类',
                    'link'  => '/wxapp/community/pointsCategory',
                    'active'=> 'pointsCategory'
                ),
                array(
                    'label' => '积分商品',
                    'link'  => '/wxapp/community/pointGoods',
                    'active'=> 'pointGoods'
                ),
                //新增积分商城优惠券
                array(
                    'label' => '优惠券',
                    'link'  => '/wxapp/community/couponList',
                    'active'=> 'couponList'
                ),
                array(
                    'label' => '会员卡',
                    'link'  => '/wxapp/community/memberCardList',
                    'active'=> 'memberCardList'
                )
            );
        }else{
            $link = array(
                array(
                    'label' => '积分商城',
                    'link'  => '/wxapp/community/pointCfg',
                    'active'=> 'pointCfg'
                ),
                array(
                    'label' => '积分来源',
                    'link'  => '/wxapp/community/pointSourceCfg',
                    'active'=> 'pointSourceCfg'
                ),
                array(
                    'label' => '积分订单',
                    'link'  => '/wxapp/community/pointOrder',
                    'active'=> 'pointOrder'
                ),
                array(
                    'label' => '积分商品',
                    'link'  => '/wxapp/community/pointGoods',
                    'active'=> 'pointGoods'
                ),
                //新增积分商城优惠券
                array(
                    'label' => '优惠券',
                    'link'  => '/wxapp/community/couponList',
                    'active'=> 'couponList'
                ),
                array(
                    'label' => '会员卡',
                    'link'  => '/wxapp/community/memberCardList',
                    'active'=> 'memberCardList'
                )
            );
        }

        if($this->wxapp_cfg['ac_type'] == 30){
            unset($link[4]);
        }

        if(!in_array($this->wxapp_cfg['ac_type'], array(6, 7, 8, 18, 21, 32))){
            unset($link[5]);
        }

        if($this->wxapp_cfg['ac_type'] == 12){
            $link[] = array(
                'label' => '自提门店',
                'link'  => '/wxapp/community/receiveCfg',
                'active'=> 'receive'
            );
        }

        if($returnInfo){
            return array(
                'linkLeft' => $link,
                'linkType' => $type,
                'snTitle'  => '积分商城'
            );
        }else{
            $this->output['linkLeft']   = $link;
            $this->output['linkType']   = $type;
            $this->output['snTitle']    = '积分商城';
        }

    }

    /*
     * 门店自提配置页
     */
    public function receiveCfgAction(){
        $this->secondPointLink('receive');
        $this->buildBreadcrumbs(array(
            array('title' => '积分商城', 'link' => '#'),
            array('title' => '门店自提配置', 'link' => '#'),
        ));
        $cfg_model = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        $row = $cfg_model->findUpdateBySid();
        if(!$row){
            $insert = array(
                'acs_s_id' => $this->curr_sid,
                'acs_create_time' => time()
            );
            $cfg_model->insertValue($insert);
            //重新获得配置信息
            $row = $cfg_model->findUpdateBySid();
        }
        $this->output['sendCfg'] = $row;
        $this->output['isPoint'] = 1;
        $this->_get_receive_store();
        $this->_get_select_store();

        $showManager = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[12])){
            $showManager = 1;
        }
        $this->output['showManager'] = $showManager;

        $this->displaySmarty('wxapp/delivery/delivery-receive-cfg.tpl');
    }


    /*
     * 添加自提门店
     */
    public function addReceiveStoreAction(){
        $this->secondPointLink('receive');
        $this->buildBreadcrumbs(array(
            array('title' => '积分商城', 'link' => '#'),
            array('title' => '门店自提配置', 'link' => '/wxapp/community/receiveCfg'),
            array('title' => '新增/编辑自提门店', 'link' => '#'),
        ));
        $id = $this->request->getIntParam('id');
        if($id){
            $store_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
            $this->output['row'] = $store_model->getRowByIdSid($id,$this->curr_sid);
        }
        $shortcut_model      = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $category            = $shortcut_model->fetchShortcutShowList(1);
        $this->output['category_select'] = $category;
        $this->output['isReceive'] = 1;
        $this->output['isPoint'] = 1;

        $showManager = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[12])){
            $showManager = 1;
        }
        $this->output['showManager'] = $showManager;

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/delivery/add-receive-store.tpl');
    }

    /*
     * 获得自提门店
     */
    public function _get_receive_store($json = FALSE){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'os_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]    = array('name' => 'os_receive_store','oper' => '=','value' =>1);
        $this->output['name'] = $this->request->getStrParam('name');
        if($this->output['name']){
            $where[]    = array('name' => 'os_name','oper' => 'like','value' =>"%{$this->output['name']}%");
        }

        $store_model    = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
        //分页处理
        $total          = $store_model->getCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        //列表数据
        $list   = array();
        if($index <= $total){
            $sort = array('os_create_time' => 'DESC');
            $list = $store_model->getList($where,$index,$this->count,$sort);
        }
        if($json){
            $this->output['storeList'] = json_encode($list);
        }else{
            $this->output['storeList'] = $list;
        }

    }

    /*
     * 获得可选门店
     */
    public function _get_select_store(){
        $where      = array();
        $where[]    = array('name' => 'os_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]    = array('name' => 'os_receive_store','oper' => '=','value' =>0);
        $store_model    = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
        $sort = array('os_create_time' => 'DESC');
        $list = $store_model->getList($where,0,0,$sort);
        $this->output['selectList'] = $list;
    }

    public function postTplAction(){
        $this->secondPointLink('postTpl');
        $delivery_controller = new App_Controller_Wxapp_DeliveryController();
        $delivery_controller->indexAction();
    }

    /**
     * 积分商城设置
     */
    public function pointCfgAction(){
        $this->secondPointLink('pointCfg');
        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();
        $this->output['pointImg']  = $tpl['aci_point_img']?$tpl['aci_point_img']:'';
        $this->output['point']     = $tpl['aci_point']?$tpl['aci_point']:0;
        $this->output['content']   = $tpl['aci_point_rule']?$tpl['aci_point_rule']:'';
        $this->output['ratio']     = intval($tpl['aci_exchange_ratio']);
        $this->output['styleType'] = intval($tpl['aci_style_type']);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '积分商城', 'link' => '/wxapp/community/pointGoods'),
            array('title' => '积分商城', 'link' => '#'),
        ));
        $imgArr = $tpl['aci_point_slide']?json_decode($tpl['aci_point_slide'],1):'';
        $json   = array();
        if($imgArr){
            foreach ($imgArr as $key=>$val){
                $json[] = array(
                    'index'     => $val['index'] ,
                    'imgsrc'    => $val['imgsrc'],
                );
            }
        }
        if(in_array($this->wxapp_cfg['ac_type'], array(6, 7, 8, 18, 21, 32))){
            $this->output['exchangeOpen'] = 1;
        }
        $this->output['slide'] = json_encode($json);
        $this->displaySmarty("wxapp/community/point-cfg.tpl");
    }

    /**
     * 保存积分商城顶部图片
     */
    public function savePointImgAction(){
        $tpl_id           = $this->request->getIntParam('tpl_id',35);
        $pointImg         = $this->request->getStrParam('pointImg');
        $imgArr           = $this->request->getArrParam('imgArr');
        $point            = $this->request->getIntParam('point');
        $ratio            = $this->request->getIntParam('ratio');
        $content          = $this->request->getStrParam('content');
        $styleType        = $this->request->getIntParam('styleType',1);
        /*if($imgArr){
            foreach ($imgArr as $val){
                $newArr[$val['index']] = $val['imgsrc'];
            }
        }*/
        $data = array(
            'aci_s_id'               => $this->curr_sid,
            'aci_tpl_id'             => $tpl_id,
            'aci_point_img'          => $pointImg,
            'aci_point_slide'        => $imgArr?json_encode($imgArr):'',
            'aci_point_rule'         => $content,
            'aci_point'              => $point,
            'aci_exchange_ratio'     => $ratio,
            'aci_style_type'         => $styleType,
            'aci_update_time'        => time()
        );
        // 校验店铺是否可用改模板
        $index_tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row   = $index_tpl_model->getRowBySid($tpl_id,$this->curr_sid);
        if($row){
            $ret  = $this->_update_tpl($data, $tpl_id); //更新模板信息
            if($ret){
                App_Helper_OperateLog::saveOperateLog("积分商城首页配置保存成功");
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }

    /**
     * 积分商品管理
     */
    public function pointGoodsAction(){
        $this->secondPointLink('pointGoods');
        $this->_show_goods_list_data(1);
        $this->output['choseLink']  = $this->showTableLink('pointGoods');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '积分商城', 'link' => '/wxapp/community/pointGoods'),
            array('title' => '积分商品', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/community/point-goods.tpl");
    }


    /*
     * 积分商城优惠券管理
     */
     public function couponListAction(){
         $this->secondPointLink('couponList');
         $this->buildBreadcrumbs(array(
             array('title' => '营销工具', 'link' => '#'),
             array('title' => '积分商城', 'link' => '/wxapp/community/pointGoods'),
             array('title' => '优惠券', 'link' => '#'),
         ));
         $this->_show_coupon_list_data();
         $this->displaySmarty("wxapp/community/coupon-list.tpl");
     }
    //获取优惠券相关数据
    private function _show_coupon_list_data(){
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = array();
        $where[] = array('name' => 'cl_s_id','oper' => '=','value' =>$this->curr_sid);
        $output['name']     = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'cl_name','oper' => 'like','value' =>"%{$output['name']}%");
        }

        //状态 0未开始，1领取中，2已结束
        $output['status'] = $this->request->getStrParam('status','all');
        //coupon_type为1说明优惠券为积分商城优惠券
        $where[] = array('name' => 'cl_coupon_type','oper' => '=','value' =>1);
        switch($output['status']){
            case 'nostart':
                $where[] = array('name' => 'cl_status','oper' => '>','value' =>0);
                break;
            case 'receive':
                $where[] = array('name' => 'cl_status','oper' => '=','value' =>1);
                break;
            case 'end':
                $where[] = array('name' => 'cl_status','oper' => '=','value' =>2);
                break;
        }

        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $total          = $coupon_model->getCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list   = array();
        if($index <= $total){
            $sort = array('cl_update_time' => 'DESC');
            $list = $coupon_model->getList($where,$index,$this->count,$sort);
            foreach($list as &$val){
                $val['link'] = $this->composeLink('coupon','detail',array('cid'=>$val['cl_id']),true,'info');
                if($val['cl_end_time'] <= time()){
                    $val['edit'] = 0;
                }else{
                    $val['edit'] = 1;
                }
            }
        }
        $output['paginator'] = $pageCfg->render();
       // plum_msg_dump($pageCfg->render());die();
        $output['list']      = $list;
        $output['count']     = $total;

        //获得统计信息
//统计信息
        $timeNow = time();
        $where_total = $where_expire = [];
        $where_total[] = $where_expire[] = ['name' => 'cl_s_id','oper' => '=','value' =>$this->curr_sid];
        $where_total[] = $where_expire[] = ['name' => 'cl_es_id','oper' => '=','value' =>0];
        $where_total[] = $where_expire[] = ['name' => 'cl_coupon_type','oper' => '=','value' =>1];
        $where_expire[] = ['name' => 'cl_end_time','oper' => '<','value' =>$timeNow];
        $total = $coupon_model->getCount($where_total);
        $total_expire = $coupon_model->getCount($where_expire);
        $total_going = intval($total) - intval($total_expire);
        $output['statInfo'] = [
            'total' => intval($total),
            'expire' => intval($total_expire),
            'going' => $total_going > 0 ? $total_going : 0
        ];

        $this->showOutput($output);
    }
    /*
     * 编辑或添加新的优惠券
     */
    public function  couponAddAction(){
        $this->secondPointLink('couponList');
        $id  = $this->request->getIntParam('id');
        $row = array();
        if($id){
            $coupon_model = new App_Model_Coupon_MysqlCouponStorage();
            $row = $coupon_model->getRowByIdSid($id,$this->curr_sid);
            if(!empty($row)){
                $row['cl_use_desc'] = plum_textarea_html_to_line($row['cl_use_desc']);
                $this->show_goods_by_actId($row['cl_id'],$row['cl_use_type']);
            }
        }
        //工单版用到
        $cfg        = $this->wxapp_cfg;
        $this->output['shopType']    = $cfg['ac_type'];
        //展示分类数据
        $this->output['row']    = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '积分商城', 'link' => '/wxapp/community/pointGoods'),
            array('title' => '优惠券', 'link' => '/wxapp/community/couponList'),
            array('title' => '优惠券添加', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/community/coupon-add.tpl");
    }

    /**
     * @param $actid
     * @param $type
     * 活动商品展示到前端
     */
    private function show_goods_by_actId($actid,$type){
        $goods   = array();
        if($type == 2){ //指定商品
            $goods_model    = new App_Model_Coupon_MysqlCouponGoodsStorage($this->curr_sid);
            $goods_list     = $goods_model->getListByActid($actid);
            foreach($goods_list as $val){
                $goods[] = array(
                    'id'    => $val['cg_id'],
                    'gid'   => $val['g_id'],
                    'gname' => $val['g_name'],
                );
            }
        }

        $this->output['goods'] = $goods;
    }



    public function addPointGoodsAction(){
        $id  = $this->request->getIntParam('id');
        $this->secondPointLink('pointGoods');
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

        $this->output['row'] = $row;
        //获取幻灯数据
        $this->output['slide']      =  $slide;
        $this->output['format']     =  $format;
        $this->output['formatNum']  = $formatNum;
        $this->output['formatSort'] = implode(',',$sort);

        //运费模板列表
        $template_storage = new App_Model_Shop_MysqlShopDeliveryTemplateStorage();
        $sort = array('sdt_update_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'sdt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'sdt_deleted', 'oper' => '=', 'value' => 0);
        $tempList = $template_storage->getList($where, 0, 0, $sort);

        //获取商品分类列表
        $category_model = new App_Model_Community_MysqlPointsKindStorage($this->curr_sid);
        $where = array();
        $where[] = array('name' => 'apk_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'apk_deleted', 'oper' => '=', 'value' => 0);
        $sort = array('apk_weight' => 'desc');
        $cateList = $category_model->getList($where, 0, 0, $sort);

        $this->output['cateList'] = $cateList;
        $this->output['tempList'] = $tempList;
        $this->output['appletCfg'] = $this->wxapp_cfg;

        //隐藏积分商品分类选择
        $hideCategory = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[32])){
            $hideCategory = 1;
        }
        $this->output['hideCategory'] = $hideCategory;

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '积分商城', 'link' => '/wxapp/community/pointGoods'),
            array('title' => '积分商品', 'link' => '/wxapp/community/pointGoods'),
            array('title' => '添加商品', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/community/add-point-goods.tpl");
    }

    /**
     * 关于我们
     */
    public function aboutUsAction(){
        $index_storage = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
        $index = $index_storage->findUpdateBySid();
        $this->output['aboutus'] = $index['aci_about_us'];
        $this->buildBreadcrumbs(array(
            array('title' => '关于我们', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/aboutus.tpl');
    }

    /**
     * 保存关于我们
     */
    public function saveAboutusAction(){
        $tpl_id           = $this->request->getIntParam('tpl_id',35);
        $about = $this->request->getStrParam('about');    // 关于我们

        $data = array(
            'aci_s_id'                => $this->curr_sid,
            'aci_tpl_id'             => $tpl_id,
            'aci_about_us'           => $about,
            'aci_update_time'        => time()
        );
        // 校验店铺是否可用改模板
        $index_tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row   = $index_tpl_model->getRowBySid($tpl_id,$this->curr_sid);
        if($row){
            $ret  = $this->_update_tpl($data, $tpl_id); //更新模板信息
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("【关于我们】配置信息成功");
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }

    /**
     * 门店提现申请
     */
    public function withdrawAction(){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'esw_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        //状态查询
        $output['audit'] = $this->request->getStrParam('audit','all');
        switch($output['audit']){
            case 'success':
                $where[] = array('name' => 'esw_status','oper' => '=','value' =>1);
                break;
            case 'refuse':
                $where[] = array('name' => 'esw_status','oper' => '=','value' =>2);
                break;
            case 'doing':
                $where[] = array('name' => 'esw_status','oper' => '=','value' =>0);
                break;
        }
        //提现申请时间查询
        $output['start'] = $this->request->getStrParam('start');
        $start           = strtotime($output['start']);
        if($start){
            $where[]     = array('name' => 'esw_create_time','oper' => '>=','value' =>$start);
        }
        $output['end']   = $this->request->getStrParam('end');
        $end             = strtotime($output['end']);
        if($end){
            $where[] = array('name' => 'esw_create_time','oper' => '<=','value' =>$end);
        }

        $withdraw_model = new App_Model_Entershop_MysqlEnterShopWithdrawStorage();
        $total          = $withdraw_model->getShopBankCount($where);
        $page_libs      = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['pageHtml'] =$page_libs->render();

        $list = array();
        if($total > $index){
            $withdraw   = $withdraw_model->getShopBankList($where,$index,$this->count);
            $list       = $withdraw;
        }
        $output['list'] = $list;
        $this->output['choseLink'] = array(
            array(
                'href'  => '/wxapp/community/withdraw?audit=all',
                'key'   => 'all',
                'label' => '全部'
            ),
            array(
                'href'  => '/wxapp/community/withdraw?audit=doing',
                'key'   => 'doing',
                'label' => '审核中'
            ),
            array(
                'href'  => '/wxapp/community/withdraw?audit=success',
                'key'   => 'success',
                'label' => '成功'
            ),
            array(
                'href'  => '/wxapp/community/withdraw?audit=refuse',
                'key'   => 'refuse',
                'label' => '拒绝'
            ),
        );
        //获得模板配置信息
        if($this->wxapp_cfg['ac_type'] == 6){
            $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
            $tpl = $tpl_model->findUpdateBySid(23);
        }else{
            $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
            $tpl = $tpl_model->findUpdateBySid(35);
        }

        $this->output['tpl'] = $tpl;
        $this->output['status'] = array(0=>'待审核',1=>'成功',2=>'已拒绝');
        $this->output['statusNew'] = array(
            0=>['class'=>'font-color-audit','name'=>'待审核'],
            1=>['class'=>'font-color-pass','name'=>'成功'],
            2=>['class'=>'font-color-refuse','name'=>'已拒绝']
        );
        $this->showOutput($output);
        $this->buildBreadcrumbs(array(
            array('title' => '提现列表', 'link' => '#'),
        ));
        $this->output['withdraw_bank_ids'] = plum_parse_config('withdraw_bank_ids');    //微信提现银行代号

        //获得统计信息
        $where_total = $where_pass = $where_audit = [];
        $where_total[] = $where_pass[] = $where_audit[] = ['name' => 'esw_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_pass[] = ['name' => 'esw_status', 'oper' => '=', 'value' => 1];
        $where_audit[] = ['name' => 'esw_status', 'oper' => '=', 'value' => 0];
        $totalInfo = $withdraw_model->getStatInfo($where_total);
        $passInfo = $withdraw_model->getStatInfo($where_pass);
        $auditInfo = $withdraw_model->getStatInfo($where_audit);
        $statInfo = [
            'totalCount' => intval($totalInfo['total']),
            'totalMoney' => floatval($totalInfo['money']),
            'passCount' => intval($passInfo['total']),
            'passMoney' => floatval($passInfo['money']),
            'auditCount' => intval($auditInfo['total']),
            'auditMoney' => floatval($auditInfo['money']),
        ];
        $this->output['statInfo'] = $statInfo;
        $this->displaySmarty('wxapp/community/withdraw.tpl');
    }

    //提现配置页面
    public function withdrawCfgPageAction(){
        //获得模板配置信息
        if($this->wxapp_cfg['ac_type'] == 6){
            $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
            $row = $tpl_model->findUpdateBySid(23);
//            $url = '/wxapp/community/withdraw';
        }elseif ($this->wxapp_cfg['ac_type'] == 4){
            $tpl_model = new App_Model_Meal_MysqlMealIndexStorage($this->curr_sid);
            $tpl_index=$this->applet_cfg['ac_index_tpl']?$this->applet_cfg['ac_index_tpl']:12;
            $row = $tpl_model->findUpdateBySid($tpl_index);
            if($row){
                $row['aci_shop_bank'] = $row['ami_shop_bank'];
                $row['aci_shop_wxbank'] = $row['ami_shop_wxbank'];
                $row['aci_shop_wxbalance'] = $row['ami_shop_wxbalance'];
                $row['aci_withdraw_limit'] = $row['ami_withdraw_limit'];
                $row['aci_shop_withdraw_introduce'] = $row['ami_shop_withdraw_introduce'];
            }
//            $url = '/wxapp/meal/withdraw';
        }else{
            $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
            $row = $tpl_model->findUpdateBySid(35);
//            $url = '/wxapp/community/withdraw';
        }
        $this->output['row'] = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '提现管理', 'link' => '/wxapp/community/withdraw'),
            array('title' => '提现配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/withdraw-cfg.tpl');
    }



    /*
     * 修改商家最低提现金额
     */
    public function saveWithdrawLimitAction(){
        $res = array(
            'ec' => 400 ,
            'em' => '保存失败',
        );
        $limit              = $this->request->getIntParam('aci_withdraw_limit');
        $aci_shop_bank      = $this->request->getIntParam('aci_shop_bank');
        $aci_shop_wxbalance = $this->request->getIntParam('aci_shop_wxbalance');
        $aci_shop_wxbank    = $this->request->getIntParam('aci_shop_wxbank');
        $aci_shop_withdraw_introduce = $this->request->getStrParam('aci_shop_withdraw_introduce');

        $aci_shop_zfb       = $this->request->getIntParam('aci_shop_zfb'); //支付宝配置
        $aci_time_limit     = $this->request->getIntParam('aci_time_limit'); //提现时间限制
        $aci_time_start     = $this->request->getIntParam('aci_time_start', 0); //每月提现开始日期
        $aci_time_end       = $this->request->getIntParam('aci_time_end', 0); //每月提现结束日期


        /* 后来添加其它配置结束 */
        if($this->wxapp_cfg['ac_type'] == 6){
            $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
            $row = $tpl_model->findUpdateBySid(23);
            if($row){
                $set = [
                    'aci_shop_bank'                 => $aci_shop_bank,
                    'aci_shop_wxbalance'            => $aci_shop_wxbalance,
                    'aci_shop_wxbank'               => $aci_shop_wxbank,
                    'aci_shop_withdraw_introduce'   => $aci_shop_withdraw_introduce,
                    'aci_withdraw_limit'            => $limit
                ];
                $ret = $tpl_model->findUpdateBySid(23,$set);
                if($ret){
                    $res = array(
                        'ec' => 200 ,
                        'em' => '保存成功',
                    );
                    App_Helper_OperateLog::saveOperateLog("保存商家提现配置成功");
                }
            }else{
                $res = array(
                    'ec' => 400 ,
                    'em' => '保存失败，请先完成主页配置',
                );
            }
        }elseif ($this->wxapp_cfg['ac_type'] == 4){
            $tpl_model = new App_Model_Meal_MysqlMealIndexStorage($this->curr_sid);
            $tpl_index=$this->applet_cfg['ac_index_tpl']?$this->applet_cfg['ac_index_tpl']:12;
            $row = $tpl_model->findUpdateBySid($tpl_index);
            if($row){
                $set = [
                    'ami_shop_bank'                 => $aci_shop_bank,
                    'ami_shop_wxbalance'            => $aci_shop_wxbalance,
                    'ami_shop_wxbank'               => $aci_shop_wxbank,
                    'ami_shop_withdraw_introduce'   => $aci_shop_withdraw_introduce,
                    'ami_withdraw_limit'            => $limit
                ];
                $ret = $tpl_model->findUpdateBySid($tpl_index,$set);
                if($ret){
                    $res = array(
                        'ec' => 200 ,
                        'em' => '保存成功',
                    );
                    App_Helper_OperateLog::saveOperateLog("保存商家提现配置成功");
                }
            }else{
                $res = array(
                    'ec' => 400 ,
                    'em' => '保存失败，请先完成当前主页配置',
                );
            }
        }else{
            $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
            $row = $tpl_model->findUpdateBySid(35);
            if($row){
                $set = [
                    'aci_shop_bank'                 => $aci_shop_bank,
                    'aci_shop_wxbalance'            => $aci_shop_wxbalance,
                    'aci_shop_wxbank'               => $aci_shop_wxbank,
                    'aci_shop_withdraw_introduce'   => $aci_shop_withdraw_introduce,
                    'aci_withdraw_limit'            => $limit,

                    'aci_shop_zfb'                  => $aci_shop_zfb,
                    'aci_time_limit'                => $aci_time_limit,
                    'aci_time_start'                => $aci_time_start,
                    'aci_time_end'                  => $aci_time_end,
                ];
                $ret = $tpl_model->findUpdateBySid(35,$set);
                if($ret){
                    $res = array(
                        'ec' => 200 ,
                        'em' => '保存成功',
                    );
                    App_Helper_OperateLog::saveOperateLog("保存商家提现配置成功");
                }
            }else{
                $res = array(
                    'ec' => 400 ,
                    'em' => '保存失败，请先完成主页配置',
                );
            }
        }

        $this->displayJson($res);

    }
   /*
    * 修改商家提现百分比
    */
    public function saveWithdrawRateAction(){
        $res = array(
            'ec' => 400 ,
            'em' => '保存失败',
        );
        $rate = $this->request->getIntParam('rate');
        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
        $row = $tpl_model->findUpdateBySid($this->wxapp_cfg['ac_index_tpl']);
        if($row){
            $set = array(
                'aci_withdraw_rate' => $rate
            );
            $ret = $tpl_model->findUpdateBySid($this->wxapp_cfg['ac_index_tpl'],$set);
            if($ret){
                $res = array(
                    'ec' => 200 ,
                    'em' => '保存成功',
                );
                App_Helper_OperateLog::saveOperateLog("保存商家提现抽成百分比成功");
            }
        }else{
            $res = array(
                'ec' => 400 ,
                'em' => '保存失败，请先配置社区主页',
            );
        }
        $this->displayJson($res);

    }

    /**
     * 提现审核
     */
    public function auditWithdrawAction(){
        $res = array(
            'ec' => 400 ,
            'em' => '审核失败',
        );
        $id     = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');
        $note   = $this->request->getStrParam('note');
        if($id && $status){
            $set = array(
                'esw_status'     => $status,
                'esw_audit_note' => $note,
                'esw_audit_time' => time(),
            );
            //获取提现信息（根据类型做判断）
            $withdraw_storage = new App_Model_Entershop_MysqlEnterShopWithdrawStorage(0);
            $row = $withdraw_storage->getRowById($id);
            if($status == 1){   //如果为审核通过
                //获取入驻商家信息
                $es_model = new App_Model_Entershop_MysqlEnterShopStorage($row['esw_s_id']);
                $es_info  = $es_model->getRowById($row['esw_es_id']);
                if($row['esw_withdraw_type'] == 2){ //微信余额提现
                    //$this->displayJsonError($row['esw_s_id']);
                    //获取入驻商家的openid
                    $m_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $m_row   = $m_model->getRowById($es_info['es_m_id']);
                    $newPay_model = new App_Plugin_Weixin_NewPay($row['esw_s_id']);
                    $ret = $newPay_model->appletPayTransfer($m_row['m_openid'],$row['esw_amount'],$row['esw_withdraw_name']);
                    if($ret['code'] != 0){
                        $this->displayJsonError($ret['errmsg']);
                    }else{
                        $set['esw_withdraw_wxtid'] = $ret['send_listid'];
                    }
                }elseif($row['esw_withdraw_type'] == 3){    //微信银行卡提现
                    $newPay_model = new App_Plugin_Weixin_NewPay($row['esw_s_id']);

                    $bank_model = new App_Model_Entershop_MysqlEnterShopBankStorage($row['esw_s_id']);
                    $bank_row = $bank_model->getRowById($row['esw_bank_id']);
                    $bankCard = $row['esw_bank_id'] && $bank_row['esb_bank_card'] ? $bank_row['esb_bank_card'] : $row['esw_withdraw_bank'];
                    $bankType = $row['esw_bank_id'] && $bank_row['esb_bank_code'] ? $bank_row['esb_bank_code'] : $row['esw_bank_type'];
                    $bankUser = $row['esw_bank_id'] && $bank_row['esb_bank_user'] ? $bank_row['esb_bank_user'] : $row['esw_withdraw_name'];

                    $ret = $newPay_model->appletPayBank($bankCard,$bankUser,$bankType,$row['esw_amount']);
                    if($ret['code'] != 0){
                        $this->displayJsonError($ret['errmsg']);
                    }else{
                        $set['esw_withdraw_wxtid'] = $ret['send_listid'];
                    }
                }
            }
            //更新入驻商家提现表
            $ret = $withdraw_storage->updateById($set,$id);
            if($ret){
                $row = $withdraw_storage->getRowById($id);
                //@todo 根据提现状态，修改账户可用余额，锁定余额，并做店铺记录
                $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
                $balanceRet = $shop_model->changeBalanceWithdraw($row['esw_es_id'],$row['esw_amount'],$status);
                //@todo 提现成功，写店铺支出记录
                if($status == 1 && $balanceRet){
                    $shop = $shop_model->getRowById($row['esw_es_id']);
                    $this->withdraw_record_save($row['esw_es_id'],$row['esw_amount'],$shop['es_balance']);
                }
                $res = array(
                    'ec' => 200,
                    'em' => '审核成功',
                );
                $str = $status  == 1 ? '通过' : '不通过';
                App_Helper_OperateLog::saveOperateLog("商家提现审核成功，审核结果：{$strt}");
            }
        }else{
            $res['em'] = '提现状态错误';
        }
        $this->displayJson($res);
    }

    private function withdraw_record_save($sid,$money,$balance){
        $data = array(
            'si_s_id'   => $this->curr_sid,
            'si_es_id'   => $sid,
            'si_name'   => '账户提现',
            'si_amount' => floatval($money),
            'si_balance'=> $balance,
            'si_type'   => 2, //支出
            'si_create_time'   => time()
        );
        $shop_inout_model = new App_Model_Shop_MysqlShopInoutStorage(0);
        $ret = $shop_inout_model->insertValue($data);
    }
    public function pointDetailsListAction(){
        $inout_storage = new App_Model_Point_MysqlInoutStorage(11);
        $point         = $inout_storage->getMemberList(166);
        $type=array(
            '1'=>'订单来源',
            '2'=>'签到来源',
            '3'=>'公排来源',
            '4'=>'退款收回',
            '5'=>'金币兑换',
        );
        if($point){
            $info=array();
            foreach($point as $k=>$v){
                if($v['pi_extra']){
                   $desc=$type[$v['pi_source']].'('.$v['pi_extra'].')';
                }else{
                    $desc=$type[$v['pi_source']];
                }
                $info['data'][]=array(
                    'type'=>$v['pi_type'],
                    'point'=>floor($v['pi_point']),
                    'source'=>$type[$v['pi_source']],
                    'desc'=>$desc,
                );
            }
           plum_msg_dump($info);
        }else{

        }
    }
    /**
     * 积分来源配置管理
     */
    public function pointSourceCfgAction(){
        $this->secondPointLink('pointSourceCfg');
        $point_model = new App_Model_Point_MysqlPointSourceStorage($this->curr_sid);
        $where       = array();
        $where[]     = array('name' => 'aps_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $pointCfg    = $point_model->getRow($where);
        $this->output['pointCfg'] = $pointCfg;

        $countSection = [];
        if($pointCfg){
            $countSectionArr = json_decode($pointCfg['aps_trade_count_section'],1);
            if(!empty($countSectionArr) && is_array($countSectionArr)){
                $countSection = $countSectionArr;
            }
        }
        $this->output['countSection'] = $countSection;
        $showCountSection = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[7])){
            $showCountSection = 1;
        }
        $this->output['showCountSection'] = $showCountSection;

        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '积分商城', 'link' => '/wxapp/community/pointGoods'),
            array('title' => '积分来源', 'link' => '#'),
        ));

        if($this->menuType == 'toutiao' && $this->wxapp_cfg['ac_type'] == 18){
            $this->output['dyyu'] = true;
        }

        $this->displaySmarty("wxapp/community/community-cfg.tpl");
    }

    /*
     * 判断两区间是否有交集
     */
    private function _is_price_cross($min1 = '', $max1 = '', $min2 = '', $max2 = '') {
        $status = $min2 - $min1;
        if ($status > 0) {
            $diff = $min2 - $max1;
            if ($diff >= 0) {
                return false;
            } else {
                return true;
            }
        } else {
            $diff = $max2 - $min1;
            if ($diff > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * 保存积分来源配置
     */
    public function savePointSourceCfgAction(){
        $register     = $this->request->getIntParam('register');    //
        $registerAdd  = $this->request->getIntParam('registerAdd');    //
        $registerMax  = $this->request->getIntParam('registerMax');    //
        $trade        = $this->request->getIntParam('trade');    //
        $commentTotal = $this->request->getIntParam('commentTotal');    //
        $comment      = $this->request->getIntParam('comment');    //
        $collection   = $this->request->getIntParam('collection');    //
        $colTotal     = $this->request->getIntParam('colTotal');    //
        $share        = $this->request->getIntParam('share');    //
        $shareTotal   = $this->request->getIntParam('shareTotal');    //
        $study        = $this->request->getIntParam('study');    //
        $studyTotal   = $this->request->getIntParam('studyTotal');    //
        $post         = $this->request->getIntParam('post');    //
        $postTotal    = $this->request->getIntParam('postTotal');    //
        $read         = $this->request->getIntParam('read');    //
        $readTotal    = $this->request->getIntParam('readTotal');    //
        $member       = $this->request->getIntParam('member');    //
        $pointTotal   = $this->request->getIntParam('pointTotal');    //
        $cashier      = $this->request->getIntParam('cashier');    //
        $id           = $this->request->getIntParam('id');    //
        $sectionArr = $this->request->getArrParam('sectionArr');

        $data = array(
         'aps_register'                 => $register,
         'aps_continuous_add'           => $registerAdd,
         'aps_continuous_max'           => $registerMax,
         'aps_trade'                    => $trade,
         'aps_comment_total'            => $commentTotal,
         'aps_comment'                  => $comment,
         'aps_collection'               => $collection,
         'aps_collection_total'         => $colTotal,
         'aps_share'                    => $share,
         'aps_share_total'              => $shareTotal,
         'aps_study'                    => $study,
         'aps_study_total'              => $studyTotal,
         'aps_post'                     => $post,
         'aps_post_total'               => $postTotal,
         'aps_read_article'             => $read,
         'aps_read_article_total'       => $readTotal,
         'aps_open_member'              => $member,
         'aps_point_total'              => $pointTotal,
         'aps_cashier_pay'              => $cashier,
        );

        $sectionValue = [];
        if(is_array($sectionArr) && !empty($sectionArr) && in_array($this->wxapp_cfg['ac_type'],[7])){
            foreach ($sectionArr as $item){
                if($item['min'] >= 0 && $item['max'] > 0 && $item['value'] > 0){
                    if($item['min'] >= $item['max']){
                        $this->displayJsonError('下单次数最小值必须小于最大值');
                    }
                    $sectionValue[] = $item;
                }
            }
//            Libs_Log_Logger::outputLog($sectionValue,'test.log');
            if(!empty($sectionValue)){
                for($i=0;$i<count($sectionValue);$i++){
                    for($j=$i+1;$j<count($sectionValue);$j++){
                        $cross = $this->_is_price_cross($sectionValue[$i]['min'],$sectionValue[$i]['max'],$sectionValue[$j]['min'],$sectionValue[$j]['max']);
                        if($cross){
                            $this->displayJsonError('下单次数有重复区间');
                        }
                    }
                }
            }
        }
        if($sectionValue){
            $sectionValue = json_encode($sectionValue);
        }else{
            $sectionValue = '';
        }
        $data['aps_trade_count_section'] = $sectionValue;
        $point_model = new App_Model_Point_MysqlPointSourceStorage($this->curr_sid);
        if($id){
            $data['aps_update_time']=time();
            $ret=$point_model->updateById($data,$id);
        }else{
            $data['aps_s_id']=$this->curr_sid;
            $data['aps_create_time']=time();
            $ret=$point_model->insertValue($data);
        }
        if($ret){
            App_Helper_OperateLog::saveOperateLog("积分商城积分来源配置保存成功");
            $result = array(
                'ec' => 200,
                'em' => '信息保存成功'
            );
        }else{
            $result = array(
                'ec' => 400,
                'em' => '信息保存失败'
            );
        }
        $this->displayJson($result);
    }

    /**
     * 入驻店铺商品列表
     */
    public function shopGoodsListAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '商家商品管理', 'link' => '#'),
        ));
        $this->_show_shop_goods_list_data();
        $this->_shop_list_for_select(true); // 获取商家列表
        $this->output['choseLink']  = $link = array(
            array(
                'href'  => '/wxapp/community/shopGoodsList?status=sell',
                'key'   => 'sell',
                'label' => '出售中'
            ),
            array(
                'href'  => '/wxapp/community/shopGoodsList?status=depot',
                'key'   => 'depot',
                'label' => '已下架'
            ),
        );
        $this->displaySmarty('wxapp/community/shop-goods-list.tpl');
    }

    /**
     * 获取商品列表
     */
    private function _show_shop_goods_list_data(){
        $where          = array();
        $where[]        = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]        = array('name' => 'g_es_id','oper' => '!=','value' =>0);
        $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $where[]        = array('name' => 'es_status', 'oper' => '=', 'value' => 0);
        $where[]        = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $output['name'] = $this->request->getStrParam('name');
        $output['shop'] = $this->request->getIntParam('shop');
        if($output['name']){
            $where[] = array('name' => 'g_name','oper' => 'like','value' =>"%{$output['name']}%");
        }
        if($output['shop']){
            $where[] = array('name' => 'g_es_id','oper' => '=','value' =>$output['shop']);
        }

        //商品状态
        $output['status'] = $this->request->getStrParam('status','sell');
        switch($output['status']){
            case 'sell':
                $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>1);
                break;
            case 'depot':
                $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>2);
                break;
        }

        $page                = $this->request->getIntParam('page');
        $index               = $page * $this->count;
        $goods_model         = new App_Model_Goods_MysqlGoodsStorage();
        $total               = $goods_model->getShopGoodsCount($where);
        $pageCfg             = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        $deduct = array();
        if($index <= $total){
            $sort = array('g_update_time' => 'DESC');
            $list = $goods_model->getShopGoodsList($where,$index,$this->count,$sort);
            $deduct_gids = array();
            foreach($list as &$val){
                $deduct_gids[] = $val['g_id'];
                $param = array(
                    'gid' => $val['g_id']
                );
            }
        }
        if($list){
            $output['now'] = 1;
        }
        $output['list'] = $list;
        $this->showOutput($output);
    }

    /**
     * 入驻店铺商品分组
     */
    public function shopGoodsGroupAction(){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'gg_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]    = array('name' => 'gg_is_eshop','oper' => '=','value' =>1);
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[]    = array('name' => 'gg_name','oper' => 'like','value' =>"%{$output['name']}%");
        }

        $group_model    = new App_Model_Goods_MysqlGroupStorage($this->curr_sid);
        //分页处理
        $total          = $group_model->getCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        //列表数据
        $list   = array();
        if($index <= $total){
            $sort = array('gg_create_time' => 'DESC');
            $list = $group_model->getList($where,$index,$this->count,$sort);
            foreach($list as &$val){
                $params = array(
                    'gpid' => $val['gg_id']
                );
                $val['link'] = $this->composeLink('shop','group',$params,true,'none');
            }
        }
        $output['list'] = $list;
        $this->showOutput($output);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '商品分组', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/shop-goods-group.tpl');
    }

    /**
     * 商城首页
     */
    public function mallCfgAction()
    {
        $this->showMallShopTpl();
        $this->showShopTplShortcut(-2);
        $this->showShopTplSlide(0, 6);
        $this->goodsGroup();
        // 店铺选择推荐商品
        $this->_shop_top_goods_list();
        // 店铺推荐商品展示
        $this->_mall_recommend_goods_list();
        // 店铺分类展示
        $this->_shop_mall_kind_list();
        // 链接列表及分类
        $this->_get_list_for_select(1);
        //获取文章列表
        $this->_shop_information();
        $this->_shop_kind_list_for_select(); //店铺分类
        $this->_mall_kind_list_for_select(); //商城店铺分类

        $this->_shop_list_for_select(); //获取店铺列表
        $this->_get_information_category(); //资讯分类
        $this->_group_list_for_select(); //获取拼团商品列表
        $this->_limit_list_for_select(); //获取秒杀商品列表

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '商城配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/mall.tpl');

    }

    /**
     * @param $tpl
     * @return array
     * 获取店铺首页展示的分类数据
     */
    private function _shop_mall_kind_list(){
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->curr_sid);
        $kind_list = $kind_model->fetchKindShowList(0);
        $data = array();
        if($kind_list){
            foreach ($kind_list as $val){
                $data[] = array(
                    'title'     => $val['amk_name'],
                    'link'      => $val['amk_link'],
                    'index'     => $val['amk_weight'],
                    'imgsrc'    => $val['amk_img'],
                    'type'      => $val['amk_goods_list'],
                    'sign'      => $val['amk_sign'],
                );
            }
        }else{
            $data[] = array(
                'title'  => '分类名称',
                'link'   => 1,
                'index'  => 0,
                'type'   => 2,
                'sign'   => '新品上市 先买先得',
                'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_750_180.png'
            );
        }

        $this->output['kindList'] = json_encode($data);
    }

    /**
     * 获取店铺的全部分类选择使用
     */
    private function _mall_kind_list_for_select(){
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        // 获取店铺的所有二级分类
        $kind2 = $kind_model->getAllSonCategory(0,0);
        $data = array();
        if($kind2){
            foreach ($kind2 as $val){
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name'],
                );
            }
        }
//        //获取店铺的所有一级分类
        $kind1 = $kind_model->getAllFirstCategory(0,0);
        $firstKindSelect = array();
        if($kind1){
            foreach ($kind1 as $val){
                $firstKindSelect[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name'],
                );
            }
        }

        $this->output['secondkindSelect'] = json_encode($data);
        $this->output['firstKindSelect'] = json_encode($firstKindSelect);
    }

    /**
     * 显示顶部管理设置
     */
    private function showMallShopTpl(){
        $tpl_model = new App_Model_Mall_MysqlMallUniversalStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid(0);
        if(empty($tpl)){
            $tpl = array(
                'amu_title'      => '店铺首页'
            );
        }
        $this->output['tpl'] = $tpl;
    }

    /**
     * 获取商品分组数据
     */
    private function goodsGroup(){
        $where      = array();
        $where[]    = array('name' => 'gg_s_id','oper' => '=','value' =>$this->curr_sid);
        //$where[]    = array('name' => 'gg_is_eshop','oper' => '=','value' =>1);
        $group_model    = new App_Model_Goods_MysqlGroupStorage($this->curr_sid);
        $sort = array('gg_create_time' => 'DESC');
        $list = $group_model->getList($where,0,0,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['gg_id'],
                    'name' => $val['gg_name'],
                );
                if($val['gg_is_eshop']){
                    $shopData[] = array(
                        'id'   => $val['gg_id'],
                        'name' => $val['gg_name'],
                    );
                }else{
                    $plateformdata[] = array(
                        'id'   => $val['gg_id'],
                        'name' => $val['gg_name'],
                    );
                }
            }
        }
        $this->output['goodsGroup'] = json_encode($data);
        $this->output['plateformGroup'] = json_encode($plateformdata);
        $this->output['shopGoodsGroup'] = json_encode($shopData);
    }

    /**
     * 获取店铺促销商品,推荐商品选择推荐商品使用
     */
    private function _shop_top_goods_list(){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $where          = array();
        $where[]        = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        //$where[]        = array('name' => 'g_es_id','oper' => '!=','value' =>0);
        //$where[]        = array('name' => 'es_status', 'oper' => '=', 'value' => 0);
        $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));

        $where[]        = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);

//        if($this->menuType == 'toutiao' && $this->curr_shop['s_entershop_goods_verify'] == 1){
//            $where[]     = array('name' => 'g_is_sale', 'oper' => 'not in', 'value' =>[4,5]);
//        }

        $sort = array('g_update_time' => 'DESC');
        $goods_list = $goods_model->getShopGoodsList($where,0,0,$sort);
        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = array(
                    'id'   => $val['g_id'],
                    'name' => $val['g_name'],
                );
            }
        }
        $this->output['goodsList'] = json_encode($data);
    }

    /**
     * @param $tpl
     * @return array
     * 获取该模板选择的推荐商品
     */
    private function _mall_recommend_goods_list(){
        $recommend_model = new App_Model_Mall_MysqlMallRecommendStorage($this->curr_sid);
        $recommend_list = $recommend_model->fetchRecommendShowList(0);
        $data = array();
        if($recommend_list){
            foreach ($recommend_list as $val){
                $data[] = array(
                    'name'     => $val['amr_name'],
                    'price'    => $val['amr_price'],
                    'imgsrc'   => isset($val['amr_img']) && $val['amr_img'] ? $val['amr_img'] :'/public/manage/img/zhanwei/zw_fxb_200_200.png',
                    'link'     => $val['amr_link'],
                    'index'    => $val['amr_weight'],
                );
            }

        }
        $this->output['recommendGoods'] = json_encode($data);
    }

    //保存万能商城首页
    public function saveMallCfgAction(){
        $tpl['amu_title']      = $this->request->getStrParam('title');
        $tpl['amu_coupon_title']     = $this->request->getStrParam('coupon_title');//优惠券标题
        $tpl['amu_coupon_sign']      = $this->request->getStrParam('coupon_sign');//优惠券标签
        $tpl['amu_promotion_title']  = $this->request->getStrParam('promotion_title');//促销标题
        $tpl['amu_promotion_sign']   = $this->request->getStrParam('promotion_sign');//促销标签
        $tpl['amu_hot_img']          = $this->request->getStrParam('hot_img');
        $tpl['amu_hot_type']         = $this->request->getIntParam('hot_type');
        $tpl['amu_hot_link']         = $this->request->getIntParam('hot_link');
        $tpl['amu_update_time']      = time();
        // 校验店铺是否可用改模板
        $tpl_model = new App_Model_Mall_MysqlMallUniversalStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid(0);
        if(!empty($tpl_row)){
            $ret = $tpl_model->findUpdateBySid(0,$tpl);
        }else{
            $tpl['amu_s_id']       = $this->curr_sid;
            $tpl['amu_create_time']= time();
            $ret = $tpl_model->insertValue($tpl);
        }
        // 保存幻灯
        $this->save_shop_slide_new(0,6);

        // 保存分类导航
        $this->save_shop_shortcut_new(-2);

        // 保存推荐商品
        $this->_save_shop_recommend();
        // 保存首页分类信息
        $this->_save_mall_shop_kind();
        if($ret){
            $result = array(
                'ec' => 200,
                'em' => '信息保存成功'
            );
            App_Helper_OperateLog::saveOperateLog("平台商城首页配置保存成功");
        }else{
            $result = array(
                'ec' => 400,
                'em' => '信息保存失败'
            );
        }
        $this->displayJson($result);
    }

    /**
     * 保存首页分类
     */
    private function _save_mall_shop_kind(){
        $kind = $this->request->getArrParam('kind');
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->curr_sid);
        if(!empty($kind)){
            $kind_list = $kind_model->fetchKindShowList(0);
            if(!empty($kind_list)){
                $del_id = array();
                foreach($kind_list as $val){
                    if(isset($kind[$val['amr_weight']])){  //存在这个位置的快捷导航，更新
                        $set = array(
                            'amk_weight'        => $kind[$val['amk_weight']]['index'],
                            'amk_name'          => $kind[$val['amk_weight']]['title'],
                            'amk_link'          => $kind[$val['amk_weight']]['link'],
                            'amk_img'           => $kind[$val['amk_weight']]['imgsrc'],
                            'amk_goods_list'    => $kind[$val['amk_weight']]['type'],
                            'amk_sign'          => $kind[$val['amk_weight']]['sign'],
                        );
                        $up_ret = $kind_model->updateById($set,$val['amk_id']);
                        unset($kind[$val['amk_weight']]); //然后清理前端传过来的快捷导航
                    }else{ //多余的删除
                        $del_id[] = $val['amk_id'];
                    }
                }
                if(!empty($del_id)){
                    $kind_where = array();
                    $kind_where[] = array('name' => 'amk_id','oper' => 'in' , 'value' => $del_id);
                    $kind_model->deleteValue($kind_where);
                }

            }

            //新增的快捷导航
            if(!empty($kind)){
                $insert = array();
                foreach($kind as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', 0, '{$val['title']}', '{$val['imgsrc']}','{$val['link']}','{$val['sign']}','{$val['type']}', '{$val['index']}','".time()."') ";
                }
                $ins_ret = $kind_model->newInsertBatch($insert);
            }
        }else{ //若数组为空，则清空该店铺快捷导航
            $where   = array();
            $where[] = array('name' => 'amk_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'amk_tpl_id','oper' => '=' , 'value' => 0);
            $kind_model->deleteValue($where);
        }

    }

    /**
     * 保存首页推荐商品
     */
    private function _save_shop_recommend(){
        $recommend = $this->request->getArrParam('recommendGood');
        $recommend_model = new App_Model_Mall_MysqlMallRecommendStorage($this->curr_sid);
        if(!empty($recommend)){
            $recommend_list = $recommend_model->fetchRecommendShowList(0);
            if(!empty($recommend_list)){
                $del_id = array();
                foreach($recommend_list as $val){
                    if(isset($recommend[$val['amr_weight']])){  //存在这个位置的快捷导航，更新
                        $set = array(
                            'amr_weight' => $recommend[$val['amr_weight']]['index'],
                            'amr_name'   => $recommend[$val['amr_weight']]['name'],
                            'amr_price'  => $recommend[$val['amr_weight']]['price'],
                            'amr_img'    => $recommend[$val['amr_weight']]['imgsrc'],
                            'amr_link'   => $recommend[$val['amr_weight']]['link'],
                        );
                        $up_ret = $recommend_model->updateById($set,$val['amr_id']);
                        unset($recommend[$val['amr_weight']]); //然后清理前端传过来的快捷导航
                    }else{ //多余的删除
                        $del_id[] = $val['amr_id'];
                    }
                }
                if(!empty($del_id)){
                    $recommend_where = array();
                    $recommend_where[] = array('name' => 'amr_id','oper' => 'in' , 'value' => $del_id);
                    $recommend_model->deleteValue($recommend_where);
                }

            }

            //新增的快捷导航
            if(!empty($recommend)){
                $insert = array();
                foreach($recommend as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', 0, '{$val['name']}', '{$val['price']}','{$val['imgsrc']}', '{$val['link']}', '{$val['index']}','','".time()."') ";
                }
                $ins_ret = $recommend_model->insertBatch($insert);
            }
        }else{ //若数组为空，则清空该店铺快捷导航
            $where   = array();
            $where[] = array('name' => 'amr_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'amr_tpl_id','oper' => '=' , 'value' => 0);
            $recommend_model->deleteValue($where);
        }

    }
    /*
     * 新增门店
     */
    public function addShopAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            //获得门店信息
            $where[] = array('name' => 'es_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'es_id', 'oper' => '=', 'value' => $id);
            $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
            $esRow = $es_model->getRow($where);
            $this->output['row'] = $esRow;
            //获得轮播图
            $slide_model    = new App_Model_Entershop_MysqlEnterShopSlideStorage($id);
            $slide          = $slide_model->getSlideList();
            $this->output['slide'] = $slide;
        }

        $this->buildBreadcrumbs(array(
            array('title' => '商家管理', 'link' => '/wxapp/community/shopList'),
            array('title' => '编辑/新增商家', 'link' => '#'),
        ));
        //获得入驻时长配置
        $cost_storage = new App_Model_Community_MysqlCommunityEnterCostStorage($this->curr_sid);
        $where_cost   = array();
        $where_cost[] = array('name' => 'acec_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort = array('acec_date' => 'ASC');
        $list = $cost_storage->getList($where_cost, 0, 0, $sort);
        $this->output['costList'] = $list;

        $address_model = new App_Model_Address_MysqlAddressCoreStorage();
        $this->output['provSelect'] = $address_model->get_province_for_select();
        $this->_get_promoter_list();
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty("wxapp/community/add-shop.tpl");

    }

    private function _get_promoter_list(){
        $promoter_model = new App_Model_Promoter_MysqlPromoterStorage($this->curr_sid);
        $where = [];
        $where[] = ['name' => 'ap_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where[] = ['name' => 'ap_status', 'oper' => '>', 'value' => 0];
        $list = $promoter_model->getList($where,0,0,[],['ap_id','ap_name']);
        $this->output['promoterList'] = $list;
    }

    /*
     * 保存新增门店
     */
    public function saveShopAction(){
        $id = $this->request->getIntParam('id',0);
        $lng = $this->request->getStrParam('lng');
        $lat = $this->request->getStrParam('lat');
        $address = $this->request->getStrParam('address');
        $addressDetail = $this->request->getStrParam('addressDetail');
        $name = $this->request->getStrParam('name');
        $phone = $this->request->getStrParam('phone');
        $contact = $this->request->getStrParam('contact');
        $cate1 = $this->request->getIntParam('cate1');
        $cate2 = $this->request->getIntParam('cate2');
        $cate2Name = $this->request->getStrParam('cate2Name');
        $district1 = $this->request->getIntParam('district1');
        $district2 = $this->request->getIntParam('district2');
        $label     = $this->request->getStrParam('label');
        $logo     = $this->request->getStrParam('logo');
        $vr_url    = $this->request->getStrParam('vr');
        $date      = $this->request->getIntParam('date');
        $shopMaid  = $this->request->getFloatParam('shopMaid');
        $showNum   = $this->request->getIntParam('showNum');
        $isRecommend = $this->request->getIntParam('isRecommend');
        $joinDistrib = $this->request->getIntParam('joinDistrib');
        $detail      = $this->request->getStrParam('detail');
        $brief      = $this->request->getStrParam('brief');
        $sort      = $this->request->getStrParam('sort');
        $cashProportion = $this->request->getFloatParam('cashProportion');

        $promoter = $this->request->getIntParam('promoter');
        $shop_row = [];
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
        if($this->menuType == 'toutiao' && $id){
            $shop_row = $es_model->getRowById($id);
        }

        if(!plum_is_phone($phone)){
            $this->displayJsonError('请填写正确的手机号');
        }

        if(!$id){
            $manager_storage    = new App_Model_Entershop_MysqlManagerStorage();
            $exists = $manager_storage->findManagerByMobile($phone);
            if($exists){
                $this->displayJsonError('该手机号已被注册，请更换手机号');
            }
        }

        $data = array(
//            'es_unique_id'  => plum_uniqid_base36(),
            'es_s_id'       => $this->curr_sid,
            'es_name'       => $name,
            'es_phone'      => $phone,
            'es_contact'    => $contact,
            'es_cate1'      => $cate1,
            'es_cate2'      => $cate2,
            'es_cate2_name' => $cate2Name,
            'es_district1'  => $district1,
            'es_district2'  => $district2,
            'es_logo'       => $logo,
            'es_label'      => $label,
            'es_lng'        => $lng,
            'es_lat'        => $lat,
            'es_addr'       => $address,
            'es_addr_detail' => $addressDetail,
            'es_brief'      => $brief,
            'es_vr_url'     => $vr_url,
            'es_show_num'   => $showNum,
            'es_sort'       => $sort,
            'es_is_recommend' => $isRecommend,
            'es_join_distrib' => $joinDistrib,
            'es_maid_proportion' => $shopMaid,
            'es_handle_status' => 2, //后台新增默认审核通过
            'es_shop_detail' => $detail,
            'es_update_time'=> time(),
            'es_cash_proportion' => $cashProportion
        );

        if($this->menuType == 'toutiao'){
            $prov = $this->request->getIntParam('prov');
            $city = $this->request->getIntParam('city');
            $zone = $this->request->getIntParam('zone');
            $toutiaoAddr = $this->request->getStrParam('toutiaoAddr');
            $shopType = $this->request->getIntParam('shopType');

            if(!$prov || !$city || !$zone){
                $this->displayJsonError('请选择完整的地区');
            }
//            if(!$toutiaoAddr){
//                $this->displayJsonError('请填写地址');
//            }

//            unset($data['es_lat']);
//            unset($data['es_lng']);

            $address_model = new App_Model_Address_MysqlAddressCoreStorage();
            $provName = $address_model->getRowById($prov);
            $cityName = $address_model->getRowById($city);
            $zoneName = $address_model->getRowById($zone);

            $data['es_prov'] = $prov;
            $data['es_city'] = $city;
            $data['es_zone'] = $zone;
            $data['es_prov_name'] = $provName['region_name'];
            $data['es_city_name'] = $cityName['region_name'];
            $data['es_zone_name'] = $zoneName['region_name'];
//            $data['es_addr'] = $toutiaoAddr;
            $data['es_shop_type'] = $shopType;
            $data['es_promoter_id'] = $promoter; //上级代理

            $promoter_model = new App_Model_Promoter_MysqlPromoterStorage($this->curr_sid);
            $pro = $promoter_model->findRowByCity($city, 2);
            if($pro) {
                $data['es_pro_area'] = $pro['ap_id']; //区域代理
            }

        }


        $where[] = array('name'=>'es_s_id','oper'=> '=','value'=>$this->curr_sid);
        $where[] = array('name'=>'es_id','oper'=> '=','value'=>$id);
        if($id){
            if($this->menuType == 'toutiao'){
                if($shop_row && !$shop_row['es_shop_number']){
                    $data['es_shop_number'] = plum_random_code(5);
                }
            }
            //更新二维码
            $data['es_qrcode'] = $this->_create_shop_qrcode($id,$logo);
            $res = $es_model->updateValue($data,$where);
            $this->batchShopSlide($id);
        }else{
            //保存门店信息
            $data['es_unique_id'] = plum_uniqid_base36();
            $data['es_createtime'] = time();
            $data['es_status']= App_Helper_ShopWeixin::SHOP_MANAGE_RUN;
            $data['es_open_time']   = time();
            $data['es_expire_time'] = (time()+((60*60*24)*$date));
            $data['es_add_from'] = plum_parse_config('menu_type_str_num')[$this->menuType] ? plum_parse_config('menu_type_str_num')[$this->menuType] : 1;
            if($this->menuType == 'toutiao'){
                $data['es_shop_number'] = plum_random_code(5);
            }

            $res = $es_model->insertValue($data);
            if($res){
                //创建二维码
                $qrcode = $this->_create_shop_qrcode($res,$logo);
                $es_model->updateById(array('es_qrcode'=>$qrcode),$res);
                $this->_statistics('shop', 1);
                $this->batchShopSlide($res);
                //创建管理员
                $mgdata = array(
                    'esm_s_id'       => $this->curr_sid,
                    'esm_es_id'      => $res,
                    'esm_mobile'     => $phone,
                    'esm_nickname'   => $contact,
                    'esm_password'   => plum_salt_password($phone),
                    'esm_createtime' => time(),
                    'esm_status'     => 0,   //正常登陆
                );
                $manager_storage = new App_Model_Entershop_MysqlManagerStorage();
                $mid = $manager_storage->insert($mgdata, true);//获取创建人id
            }
        }

        if($res){
            if($promoter && $this->menuType == 'toutiao'){
                //抖音多店代理商相关
                $promoter_model = new App_Model_Promoter_MysqlPromoterStorage($this->curr_sid);
                if($shop_row){
                    //修改
                    if($shop_row['es_promoter_id'] != $promoter){
                        if($shop_row['es_promoter_id'] > 0){
                            $es_promoter_row = $promoter_model->getRowById($shop_row['es_promoter_id']);
                            if($es_promoter_row['ap_shop_num'] > 0){
                                //将原代理的店铺数-1
                                $promoter_model->incrementField('ap_shop_num',$shop_row['es_promoter_id'],-1);
                            }
                        }
                        $promoter_model->incrementField('ap_shop_num',$promoter,1);
                    }
                }else{
                    //添加
                    $promoter_model->incrementField('ap_shop_num',$promoter,1);
                }
            }

            App_Helper_OperateLog::saveOperateLog("入驻商家【{$name}】保存成功");
        }

        $this->showAjaxResult($res,'保存');
    }

    /*
     * 获得商圈选择列表
     */
    public function ajaxDistrictListAction(){
        $district = $this->_district_son_data();
        $this->displayJsonSuccess($district);
    }

    private function _district_son_data($isJson=1){
        $district_model = new App_Model_Community_MysqlCommunityDistrictStorage($this->curr_sid);
        $districtList = $district_model->getListBySid();
        $district = array();
        foreach($districtList as $val){
            $district[$val['acd_area_id']] = array(
                'id'   => $val['acd_area_id'],
                'firstName' => $val['acd_area_name'],
                'secondItem' => $district[$val['acd_area_id']]['secondItem'] ? $district[$val['acd_area_id']]['secondItem'] : array()
            );
            $district[$val['acd_area_id']]['secondItem'][] = array(
                'id'         => $val['acd_id'],
                'secondName'       => $val['acd_name']
            );

        }
        if($isJson){
            $districtArr   = array();
            foreach($district as $tal){
                $districtArr[] = $tal;
            }
            return $districtArr;
        }else{
            return $district;
        }
    }

    /*
     * 获得店铺分类
     */
    public function ajaxCategoryListAction(){
        $category = $this->_category_son_data();
        $this->displayJsonSuccess($category);
    }

    private function _category_son_data($isJson=1){
        $category_model = new App_Model_Community_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getListBySid();
        $category           = array();
        foreach($first as $val){
            if($val['ack_level'] == 1){
                $category[$val['ack_id']] = array(
                    'id'        => $val['ack_id'],
                    'firstName' => $val['ack_name'],
                    'secondItem'=> array(),
                );
            }elseif($val['ack_fid'] > 0 && $val['ack_level'] == 2){
                $category[$val['ack_fid']]['secondItem'][] = array(
                    'id'   => $val['ack_id'],
                    'secondName' => $val['ack_name'],
                );
            }

        }
        if($isJson){
            $categoryArr   = array();
            foreach($category as $tal){
                $categoryArr[] = $tal;
            }
            return $categoryArr;
        }else{
            return $category;
        }
    }

    public function batchShopSlide($esId){
        $store_model    = new App_Model_Entershop_MysqlEnterShopSlideStorage($esId);
        $maxNum         = $this->request->getStrParam('slide-img-num');
        $slide          = array();

        $sl_id = array();
        for($i=0; $i<= $maxNum; $i++){
            $temp    = plum_sql_quote(plum_get_param('slide_'.$i));
            $temp_id = $this->request->getIntParam('slide_id_'.$i);
            if($temp && $temp_id == 0){ //新增
                $slide[] = $temp;
            }
            if($temp_id){ //不变的
                $sl_id[] = $temp_id;
            }
        }

        //@todo 统计需删除的幻灯
        $del_id = array();
        $old_slide = $store_model->getListBySid($esId);
        foreach($old_slide as $val){
            if(!in_array($val['ess_id'],$sl_id)){
                $del_id[] = $val['ess_id'];
            }
        }

        //@todo 新增和删除的幻灯，进行处理
        if(count($slide) <= count($del_id)){ //删除的大于等于新增的
            for($d=0 ; $d < count($del_id) ; $d++){
                if(isset($slide[$d])){
                    $store_model->updateSlide($del_id[$d],$slide[$d]);
                    unset($del_id[$d]); //移除被占用的幻灯
                }
            }
            //@todo 真实删除多余的幻灯
            if(!empty($del_id)){
                $store_model->deleteSlide($del_id);
            }
        }else{ //新增的多
            $batch_slide = array();
            for($s=0 ; $s < count($slide) ; $s++){
                if(isset($del_id[$s])){
                    $store_model->updateSlide($del_id[$s],$slide[$s]);
                    unset($slide[$s]); //移除已经更改的幻灯
                }else{
                    $sTemp = plum_sql_quote($slide[$s]);
                    $batch_slide[] = "(NULL, '{$esId}', '{$sTemp}',0 , 0, '".time()."')";
                }
            }
            //@todo  批量新增幻灯
            if(!empty($batch_slide)){
                $store_model->batchSave($batch_slide);
            }
        }
    }

    /*
     * 删除门店
     * 管理员真删除
     */
    public function deleteEnterShopAction(){
        $id = $this->request->getIntParam('id');
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $esm_model = new App_Model_Entershop_MysqlManagerStorage();
        //$apply_model = new App_Model_Community_MysqlCommunityShopApplyStorage($this->curr_sid);
        //删除门店信息
        $where[] = array('name'=>'es_id','oper'=> '=','value'=>$id);
        $where[] = array('name'=>'es_s_id','oper'=> '=','value'=>$this->curr_sid);
        $es_row = $es_model->getRow($where);
        $set = array(
            'es_deleted' => 1
        );
        $res = $es_model->updateValue($set,$where);

        //同时删除门店会员的申请信息
//        if($es_row['es_m_id']){
//            $where_apply[] = array('name'=>'acsa_m_id','oper'=> '=','value'=>$es_row['es_m_id']);
//            $where_apply[] = array('name'=>'acsa_s_id','oper'=> '=','value'=>$this->curr_sid);
//            $set_apply = array(
//                'acsa_deleted' => 1
//            );
//            $apply_model->updateValue($set_apply,$where_apply);
//        }

        //删除管理员信息 真删除
        $where_manager[] = array('name'=>'esm_es_id','oper'=> '=','value'=>$id);
        $where_manager[] = array('name'=>'esm_s_id','oper'=> '=','value'=>$this->curr_sid);
//        $set_manager = array(
//            'esm_deleted' => 1
//        );
//        $res_manager = $esm_model->updateValue($set_manager,$where_manager);
        $res_manager = $esm_model->deleteValue($where_manager);


        if($res && $res_manager){
            $ret = 1;
            //增加店铺的数量
            $this->_statistics('shop', -1);
        }else{
            $ret = 0;
        }
        if($ret){
            App_Helper_OperateLog::saveOperateLog("入驻商家【{$es_row['es_name']}】删除成功");
        }

        $this->showAjaxResult($ret,'删除');

    }

    /*
     * 修改入驻店铺到期时间
     */
    public function changeExpireAction(){
        $id  = $this->request->getIntParam('id');
        $expire = $this->request->getIntParam('expire',0);
        $expireNow = $this->request->getIntParam('now_expire',0);
        $result = array(
            'ec' => 400,
            'em' => '修改失败'
        );
        if($expire){
            if($expire>=12){
                $expireTime = intval(floor($expire/12))*365*86400 + intval(($expire%12))*30*86400;
            }else{
                $expireTime = $expire*30*86400;
            }
            $data = array(
                'es_expire_time' =>  $expireNow + $expireTime
            );
            $shop_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
            $res = $shop_model->updateById($data,$id);
            if($res){
                $result = array(
                    'ec' => 200,
                    'em' => '修改成功'
                );
                $shop = $shop_model->getRowById($id);
                App_Helper_OperateLog::saveOperateLog("入驻店铺【{$shop['es_name']}】修改到期时间成功");
            }
        }else{
            $result = array(
            'ec' => 400,
            'em' => '请填写正确的时间'
            );
        }
        $this->displayJson($result);
    }

    /**
     * 门店等级
     */
    public function levelAction(){
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $this->showTypeByKey('yesNo');
        $level_model = new App_Model_Entershop_MysqlEnterShopLevelStorage($this->curr_sid);
        $total = $level_model->getCountBySid($this->curr_sid);
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $this->output['paginator'] = $page_plugin->render();
        $list = array();
        if($total > $index){
            $list = $level_model->getListBySid($this->curr_sid,$index,$this->count);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '商家管理', 'link' => '/wxapp/community/shopList'),
            array('title' => '商家等级', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/shop-level.tpl');
    }

    /**
     * 保存用户等级
     */
    public function saveLevelAction(){
        $result = array(
            'ec' => 400,
            'em' => '请完善数据'
        );
        $name    = $this->request->getStrParam('name');
        $desc    = $this->request->getStrParam('desc');
        $maxGoods = $this->request->getIntParam('maxGoods');
        $weight  = $this->request->getIntParam('weight');

        if($name && $desc){//&& ($down || $sale || $money || $price || $traded)
            $data  = array();
            $data['esl_s_id']        = $this->curr_sid;
            $data['esl_name']        = $name;
            $data['esl_desc']        = $desc;
            $data['esl_max_goods']   = $maxGoods;
            $data['esl_weight']      = $weight;
            $data['esl_update_time'] = time();
            $id  = $this->request->getIntParam('id');
            $level_model = new App_Model_Entershop_MysqlEnterShopLevelStorage($this->curr_sid);
            if($id){
                $ret = $level_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
            }else{
                $data['esl_create_time'] = time();
                $ret = $level_model->insertValue($data);
            }
            //结果处理
            if($ret){
                App_Helper_OperateLog::saveOperateLog("入驻店铺等级【{$name}】保存成功");
            }

            $result       = $this->showAjaxResult($ret,'保存',true);
        }
        $this->displayJson($result);
    }

    /*
     * 删除门店等级
     */
    public function delLevelAction(){
        $result = array(
            'ec' => 400,
            'em' => '请完善数据'
        );
        $id  = $this->request->getIntParam('id');
        $level_model = new App_Model_Entershop_MysqlEnterShopLevelStorage($this->curr_sid);
        $level = $level_model->getRowById($id);
        if($id){
            $set     = array(
                'esl_deleted'     => 1,
                'esl_name'        => '商家废弃',
                'esl_update_time' => time()
            );
            $ret = $level_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
            //结果处理
            if($ret){
                //@todo  清除门店表门店等级
                $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
                $es_model->clearShopLevel($id,$this->curr_sid);

                $result = array(
                    'ec' => 200,
                    'em' => '删除成功'
                );
                App_Helper_OperateLog::saveOperateLog("入驻店铺等级【{$level['esl_name']}】删除成功");

            }else{
                $result['em'] = '删除失败';
            }
        }
        $this->displayJson($result);
    }

    /**
     * 修改门店等级
     */
    public function changeLevelAction(){
        $result = array(
            'ec' => 400,
            'em' => '请求参数错误'
        );
        $esId   = $this->request->getIntParam('id');
        $level = $this->request->getIntParam('level',0);
        if($esId){
            $set   = array(
                'es_level'         => $level, //门店等级
            );
            $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);

            $where[] = array('name'=>'es_s_id','oper'=> '=','value'=>$this->curr_sid);
            $where[] = array('name'=>'es_id','oper'=> '=','value'=>$esId);
            $ret          = $es_model->updateValue($set,$where);

            if($ret){
                $level_model = new App_Model_Entershop_MysqlEnterShopLevelStorage($this->curr_sid);
                $level = $level_model->getRowById($level);
                $shop = $es_model->getRowById($esId);
                App_Helper_OperateLog::saveOperateLog("修改入驻店铺【{$shop['es_name']}】等级【{$level['esl_name']}】成功");
            }

            $result       = $this->showAjaxResult($ret,'保存',true);
        }
        $this->displayJson($result);
    }


    /*
     * 修改店铺默认抽成比例
     */
//    public function updateDefaultMaidAction(){
//        $defaultmaid = $this->request->getFloatParam('defaultmaid');
//        $update = array('aci_shop_maid' => $defaultmaid);
//        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
//        $ret  = $tpl_model->findUpdateBySid(35,$update);
//        $this->showAjaxResult($ret);
//    }

    /*
     * 修改店铺所属会员
     */
    public function changeBelongAction(){
        $id = $this->request->getIntParam('id');
        $mid = $this->request->getIntParam('mid');
        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $res = FALSE;
        if($id && $mid){
            $where_row[] = array('name' => 'es_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where_row[] = array('name' => 'es_m_id', 'oper' => '=', 'value' => $mid);
            $row = $shop_model->getRow($where_row);
            if($row){
                $this->displayJsonError('该会员已入驻');
            }
            $set = array(
                'es_m_id' => $mid
            );
            $where[] = array('name' => 'es_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'es_id', 'oper' => '=', 'value' => $id);
            $res = $shop_model->updateValue($set,$where);
        }

        if($res){
            $shop = $shop_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("修改入驻店铺【{$shop['es_name']}】关联用户成功");
        }

        $this->showAjaxResult($res,'修改');
    }

    /**
     * 重新生成门店二维码
     */
    public function createShopQrcodeAction(){
        $esId = $this->request->getIntParam('esId');

        $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
        $shop = $es_model->findShopBySid($esId);
//        $store = $store_model->getRowById($id);
//        $esId = $store['ams_es_id'];
//        $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
//        $enterShop = $es_model->findShopBySid($esId);
//        $cover = $enterShop['es_logo'];
        $cover = $shop['es_logo'];
        $url = $this->_create_shop_qrcode($esId,$cover);
        if($url){
            $es_model->updateById(array('es_qrcode'=>$url),$esId);
        }
        $res = array('ec'=> 200,'em'=> '创建成功！','url'=> $url);
        $this->displayJson($res);
    }

    /*
     * 生成门店二维码
     */
    private function _create_shop_qrcode($esId,$cover = ''){

        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        if($this->wxapp_cfg['ac_type'] == 33){
            $path = $client_plugin::CAR_SHOP_DETAIL;
        }else{
            $path = $client_plugin::ENTERSHOP_DETAIL_PATH;
        }
        $str = "id=".$esId;
        $url = $client_plugin->fetchWxappShareCode($str, $path, 430 , $cover);
        return $url;
    }

    /**
     * 重新生成抖音门店二维码
     */
    public function createDouyinShopQrcodeAction(){
        $esId = $this->request->getIntParam('esId');

        $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
        $url = $this->_create_douyin_shop_qrcode($esId);
        if($url){
            $es_model->updateById(array('es_douyin_qrcode'=>$url),$esId);
        }
        $res = array('ec'=> 200,'em'=> '创建成功！','url'=> $url);
        $this->displayJson($res);
    }

    /*
     * 生成抖音门店二维码
     */
    private function _create_douyin_shop_qrcode($esId){

        $client_plugin  = new App_Plugin_Toutiao_XcxClient($this->curr_sid);
        $str = "?id=".$esId;
        $path = $client_plugin::COMMUNITY_SHOP_DETAIL_PATH.$str;

        $url = $client_plugin->fetchShareCode($path,'douyin',430,false);
        return $url;
    }

    /**
     * 门店小程序码下载
     */
    public function downloadShopQrcodeAction() {
        $esId = $this->request->getIntParam('esId');
        if($esId){
            $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
            $shop = $es_model->findShopBySid($esId);

            $file       = PLUM_DIR_ROOT.$shop['es_qrcode'];
            $filesize   = filesize($file);
            $filename   = $shop['es_name'].".jpg";

            plum_send_http_header("Content-type: application/octet-stream");
            plum_send_http_header("Accept-Ranges: bytes");
            plum_send_http_header("Accept-Length:".$filesize);
            plum_send_http_header("Content-Disposition: attachment; filename=".$filename);

            readfile($file);
        }

    }

    /**
     * 抖音门店小程序码下载
     */
    public function downloadDouyinShopQrcodeAction() {
        $esId = $this->request->getIntParam('esId');
        if($esId){
            $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
            $shop = $es_model->findShopBySid($esId);

            $file       = PLUM_DIR_ROOT.$shop['es_douyin_qrcode'];
            $filesize   = filesize($file);
            $filename   = $shop['es_name'].".jpg";

            plum_send_http_header("Content-type: application/octet-stream");
            plum_send_http_header("Accept-Ranges: bytes");
            plum_send_http_header("Accept-Length:".$filesize);
            plum_send_http_header("Content-Disposition: attachment; filename=".$filename);

            readfile($file);
        }

    }

    /**
     * 修改账户信息
     */
    public function changeInfoAction(){
        $id = $this->request->getIntParam('id');
        $esId = $this->request->getIntParam('esid');
        $mobile = $this->request->getStrParam('mobile');
        $password = $this->request->getStrParam('password');

        $manager_storage    = new App_Model_Entershop_MysqlManagerStorage();
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $where[]    = array('name' => 'esm_mobile', 'oper' => '=', 'value' => $mobile);
        $where[]    = array('name' => 'esm_id', 'oper' => '!=', 'value' => $id);
        $exist = $manager_storage->getRow($where);
        if($exist){
            $this->displayJsonError('手机号已被占用');
        }else{
            if(!$id && $esId){
                $mgdata = array(
                    'esm_s_id'       => $this->curr_sid,
                    'esm_es_id'      => $esId,
                    'esm_mobile'     => $mobile,
                    'esm_nickname'   => $password,
                    'esm_password'   => plum_salt_password($password),
                    'esm_createtime' => time(),
                    'esm_status'     => 0,   //正常登陆
                );
                $res  = $manager_storage->insertValue($mgdata);

                if($res){
                    $shop = $es_model->getRowById($id);
                    App_Helper_OperateLog::saveOperateLog("修改入驻店铺【{$shop['es_name']}】登录账号信息成功");
                }

                $this->showAjaxResult($res);
            }else{
                $mset = array('esm_mobile' => $mobile, 'esm_password'=>plum_salt_password($password));
                $mret = $manager_storage->updateById($mset, $id);
                if($mret){
                    $shop = $es_model->getRowById($id);
                    App_Helper_OperateLog::saveOperateLog("修改入驻店铺【{$shop['es_name']}】登录账号信息成功");

                    $this->showAjaxResult(1);
                }else{
                    $this->showAjaxResult(0);
                }
            }

        }
    }

    /**
     * 发起维权页面
     */
    public function tradeRefundAction($isActivity = ''){
        $esId = $this->request->getIntParam('esId');
        $this->show_trade_refund_detail();
        $this->output['option'] = array(
            'refuse' => App_Helper_Trade::FEEDBACK_RESULT_REFUSE ,
            'agree'  => App_Helper_Trade::FEEDBACK_RESULT_AGREE ,
        );
        $this->output['refundStatus'] = array(
            App_Helper_Trade::FEEDBACK_RESULT_REFUSE => '拒绝',
            App_Helper_Trade::FEEDBACK_RESULT_AGREE  => '同意',
        );
        if($isActivity){
            $this->output['isActivity'] = 1;
            $this->output['pointOrder'] = 1;
            $this->secondPointLink('pointOrder');
        }

        if($esId){
            $url = '/wxapp/community/shopOrder?esId='.$esId;
        }else{
            $url = '/wxapp/community/tradeList';
        }

        $this->buildBreadcrumbs(array(
            array('title' => '商城订单', 'link' => $url),
            array('title' => '订单维权', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/order/trade-refund.tpl');
    }

    public function pointTradeRefundAction(){
        $this->tradeRefundAction('point');
    }

    /**
     * 维权相关信息
     */
    private function show_trade_refund_detail()
    {
        $tid = $this->request->getStrParam('order_no');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $where = array();
        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 't_tid', 'oper' => '=', 'value' => $tid);
        $where[] = array('name' => 't_feedback', 'oper' => 'in', 'value' => array(1, 2)); //1维权中2维权结束
        $row = $trade_model->getRow($where);
        if (!empty($row)) {
            $output['row']      = $row;

            //@todo 从redis数据库中获取订单剩余时间
            $redis_model        = new App_Model_Trade_RedisTradeStorage($this->curr_sid);
            $endTime            = $redis_model->getTradeRefundTtl($row['t_id']);
            $output['endTime']  = $endTime;

            //@todo 查询本订单退款详细信息 （最新一条申请）
            $trade_order        = new App_Model_Trade_MysqlTradeRefundStorage($this->curr_sid);
            //$output['refund']   = $trade_order->getLastRecord($row['t_tid']);
            //@todo 获取所有维权记录
            $refundList = $trade_order->getAllRecord($row['t_tid']);
            $output['refundList'] = $refundList;   // 全部列表
            $output['refund']  = $refundList[0];   // 最新一条申请

            //@todo 退款订单状态
            $helper_model       = new App_Helper_Trade($this->curr_sid);
            $output['alert']    = $helper_model->checkAppletTradeRefund($output['row']['t_pay_type'],$output['refund']['tr_money']);

            //@todo 是否可以同意退款 1、未处理；2、已拒绝
            $output['canAgree']   = (($row['t_feedback'] == 1 && $row['t_fd_status'] == 1 ) || ($row['t_feedback'] == 2 && $row['t_fd_result'] == 1 ) && $output['alert']['errno'] == 0) ? 1 : 0;
            //@todo 是否可以拒绝 1、未处理
            $output['canRefuse']   = ($row['t_feedback'] == 1 && $row['t_fd_status'] == 1 ) ? 1 : 0;

            $output['statusNote'] = plum_parse_config('trade_status');
            $output['refundNote'] = plum_parse_config('refund_status');  // 维权结果
            $output['tradePay']   = App_Helper_Trade::$trade_pay_type;
            $this->showOutput($output);
        } else {
            plum_url_location('订单号错误');
        }
    }

    /**
     * 个人中心设置
     */
    public function centerManageAction(){
        $center_model   = new App_Model_Member_MysqlCenterToolStorage();
        $row            = $center_model->findUpdateBySid($this->curr_sid);
        if(empty($row)){
            $row = plum_parse_config('center_tool');
        }

        $navList = json_decode($row['ct_nav_list'], true);

        if(empty($navList)){
            $row['ct_nav_list'] = json_encode(array(
                array(
                    'index' => 0,
                    'open' => false,
                    'title' => '小金库',
                    'imgsrc' => '/public/wxapp/community/images/icon_menu1.png'
                ),
                array(
                    'index' => 1,
                    'open' => false,
                    'title' => '卡券',
                    'imgsrc' => '/public/wxapp/community/images/icon_menu2.png'
                ),
                array(
                    'index' => 2,
                    'open' => false,
                    'title' => '积分商城',
                    'imgsrc' => '/public/wxapp/community/images/icon_menu3.png'
                ),
                array(
                    'index' => 3,
                    'open' => false,
                    'title' => '特权会员',
                    'imgsrc' => '/public/wxapp/community/images/icon_menu4.png'
                ),
            ));
        }else{
            $navList = json_decode($row['ct_nav_list'], true);
            foreach($navList as $key=>$val){
                $navList[$key]['open'] = $val['open'] == 'true'?true:false;
            }
            $row['ct_nav_list'] = json_encode($navList);
        }

        $row['center']  = $this->composeLink('center','index',array(),true,'info');
        $tradeNav = plum_parse_config('trade_nav');
        $this->output['tradeNav'] = json_encode($tradeNav);
        //是否开启了免费预约功能
        if($this->checkToolUsableBool('mfyy')){
            $this->output['showFree'] = 1;
        }else{
            $this->output['showFree'] = 0;
        }
        //验证是否开通了同城分销商
        if($this->checkToolUsableBool('hhr')){
            $this->output['haveHhr'] = 1;
        }else{
            $this->output['haveHhr'] = 0;
        }
        $this->output['row'] = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '社区管理', 'link' => '#'),
            array('title' => '会员中心', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');   // 上传图片
        $this->displaySmarty('wxapp/member/community-member-center.tpl');
    }


    /*
     * 迁移数据
     */
    /*
    public function moveApplyAction(){
        $apply_model = new App_Model_Community_MysqlCommunityShopApplyStorage($this->curr_sid);
        //$where[] = array('name'=>'acsa_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'acsa_status','oper'=>'=','value'=>1);
        $where[] = array('name'=>'acsa_deleted','oper'=>'=','value'=>0);



        $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);

        $list = $apply_model->getList($where,0,0);
        if($list){
            foreach ($list as $val){
                $category_model = new App_Model_Community_MysqlKindStorage($val['acsa_s_id']);
                $category = $category_model->getAllSonCategorySelect(0,0);
                $data = array(
                    'es_m_id'        => $val['acsa_m_id'],
                    'es_unique_id'   => plum_uniqid_base36(),
                    'es_s_id'        => $val['acsa_s_id'],
                    'es_cate1'       => $val['acsa_cate1'],
                    'es_cate2'       => $val['acsa_cate2'],
                    'es_cate2_name'  => $category[$val['acsa_cate2']],
                    'es_district1'   => $val['acsa_district1'],
                    'es_district2'   => $val['acsa_district2'],
                    'es_name'        => $val['acsa_shop_name'],
                    'es_contact'    => $val['acsa_contacts'] ? $val['acsa_contacts'] : '',
                    'es_phone'      => $val['acsa_mobile'],
                    'es_addr'         => $val['acsa_addr'],
                    'es_lng'          => $val['acsa_lng'],
                    'es_lat'          => $val['acsa_lat'],
                    'es_addr_detail' => $val['acsa_addr_detail'] ? $val['acsa_addr_detail'] : '',
                    'es_license'     => $val['acsa_license'] ? $val['acsa_license'] : '',
                    'es_days'         => $val['acsa_days'] ? $val['acsa_days'] : 0,
                    'es_handle_status'       => 1,
                    'es_createtime' => time(),
                    'es_vr_url'       => $val['acsa_vr_url'] ? $val['acsa_vr_url'] : ''
                );
                $es_model->insertValue($data);
            }
        }

    }
    */

    /*
     * 入驻申请详情
     */
    public function applyDetailAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '申请商家', 'link' => '/wxapp/community/shopApplyEnter'),
            array('title' => '申请商家详情', 'link' => '#'),
        ));
        $id = $this->request->getIntParam('id');
        $apply_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
        $row = $apply_model->getRowByIdSid($id,$this->curr_sid);
        $this->output['category'] = $this->_get_select_category();
        $this->output['district'] = $this->_get_select_district();

        $row['daysValue'] = $this->_format_days_value($row['es_days']);

        $address_model = new App_Model_Address_MysqlAddressCoreStorage();
        $prov = $address_model->getRowById($row['es_prov']);
        $city = $address_model->getRowById($row['es_city']);
        $area = $address_model->getRowById($row['es_zone']);
        $row['prov_name'] = $prov['region_name'];
        $row['city_name'] = $city['region_name'];
        $row['zone_name'] = $area['region_name'];


        $this->output['row'] = $row;
        $this->displaySmarty('wxapp/community/shop-apply-detail.tpl');

    }

    /*
     * 帖子分类管理
     */
    public function postCateListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page*$this->count;
        $cate_model = new App_Model_Community_MysqlCommunityPostCateStorage($this->curr_sid);
        $where[] = array('name'=>'acpc_s_id','oper'=>'=','value'=>$this->curr_sid);


        $this->output['name'] = $this->request->getStrParam('name');
        if($this->output['name']){
            $where[] = array('name'=>'acpc_name','oper'=>'like','value'=>"%{$this->output['name']}%");
        }

        $sort = array('acpc_sort'=>'DESC','acpc_update_time'=>'DESC');
        $total = $cate_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pagination']   = $pageCfg->render();
        $list = $cate_model->getList($where,$index,$this->count,$sort);

        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '帖子分类管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/post-cate-list.tpl');
    }

    /*
     * 保存帖子分类
     */
    public function postCateSaveAction(){
        $id = $this->request->getIntParam('id');
        $name = $this->request->getStrParam('name');
        $sort = $this->request->getIntParam('sort');

        $data = array(
            'acpc_s_id' => $this->curr_sid,
            'acpc_name' => $name,
            'acpc_sort' => $sort,
            'acpc_update_time' => time()
        );
        $acpc_model = new App_Model_Community_MysqlCommunityPostCateStorage($this->curr_sid);

        if($id){
            $res = $acpc_model->updateById($data,$id);
        }else{
            $data['acpc_create_time'] = time();
            $res = $acpc_model->insertValue($data);
        }

        if($res){
            App_Helper_OperateLog::saveOperateLog("保存帖子分类【{$name}】成功");
        }

        $this->showAjaxResult($res,'保存');
    }

    /*
     * 删除帖子分类
     */
    public function postCateDeleteAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $acpc_model = new App_Model_Community_MysqlCommunityPostCateStorage($this->curr_sid);
            $category = $acpc_model->getRowById($id);
            $res = $acpc_model->deleteDFById($id);

            if($res){
                App_Helper_OperateLog::saveOperateLog("删除帖子分类【{$category['acpc_name']}】成功");
            }
        }
        $this->showAjaxResult($res,'删除');
    }

    /*
     * 获得所有帖子分类
     */
    private function _get_post_cate($return = false){
        $data = array();
        $acpc_model = new App_Model_Community_MysqlCommunityPostCateStorage($this->curr_sid);
        $sort = array('acpc_sort'=>'DESC','acpc_update_time'=>'DESC');
        $where[] = array('name'=>'acpc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $list = $acpc_model->getList($where,0,0,$sort);
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id' => $val['acpc_id'],
                    'name' => $val['acpc_name']
                );
            }
        }
        if($return){
            return $data;
        }else{
            $this->output['cateSelect'] = $data;
            $this->output['cateList'] = json_encode($data);
        }
    }


    /*
     * 后台手动开启打烊店铺
     */
    public function handCloseShopAction(){
        $id = $this->request->getIntParam('id');
        $type = $this->request->getIntParam('type');
        $set = [
            'es_hand_close' => $type
        ];
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $res = $es_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);

        if($res){
            $shop = $es_model->getRowById($id);
            $str = $type == 1 ? '打烊' : '取消打烊';
            App_Helper_OperateLog::saveOperateLog("{$str}店铺【{$shop['es_name']}】成功");
        }

        $this->showAjaxResult($res,'操作');

    }


    /**
     * 店铺认领列表
     */
    public function claimListAction(){
        $esId = $this->request->getIntParam('esId');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $claim_model = new App_Model_City_MysqlCityShopClaimStorage($this->curr_sid);
        $total      = $claim_model->getClaimCountByShop(0, $esId);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $sort = array('acsc_create_time' => 'desc');
            $list = $claim_model->getClaimListByShop(0, $esId, $index, $this->count, $sort);
        }
        $this->output['statusNote'] = array(1 => '待审核', 2 => '已通过', 3 => '已拒绝');
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '同城管理', 'link' => '#'),
            array('title' => '商家管理', 'link' => '/wxapp/community/shopList'),
            array('title' => '店铺认领', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/shop-claim.tpl');
    }

    /**
     * 店铺认领审核
     */
    public function dealClaimAction(){
        $id     = $this->request->getIntParam('id');
        $market = $this->request->getStrParam('market');
        $status = $this->request->getIntParam('status');

        //获取认领记录
        $claim_model = new App_Model_City_MysqlCityShopClaimStorage($this->curr_sid);
        $claim = $claim_model->getRowById($id);


        $es_model    = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
        $enterShop = $es_model->getRowById($claim['acsc_es_id']);

        //判断当前当前店铺，当前会员是否可认领
        $shop_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $hadShop = $shop_model->findShopByUserEnterShop($claim['acsc_m_id']);

        if($status == 2){
            if(!$enterShop['es_m_id'] && !$hadShop){
                //将入驻店铺的mid设置为认领人的mid
                $set = array('es_m_id' => $claim['acsc_m_id']);
                $es_model->updateById($set, $enterShop['es_id']);
            }else{
                if($enterShop['es_m_id']){
                    $this->displayJsonError("该店铺已被认领");
                }else{
                    $this->displayJsonError("认领人名下已存在店铺");
                }
            }
        }
        $set = array(
            'acsc_status' => $status,
            'acsc_deal_note' => $market,
            'acsc_deal_time' => time()
        );
        $ret = $claim_model->updateById($set, $id);

        if($ret){
            $str = $status == 2 ? '通过' : '不通过';
            App_Helper_OperateLog::saveOperateLog("店铺【{$enterShop['es_name']}】认领审核成功，审核结果：{$str}");
        }

        $this->showAjaxResult($ret);
    }

    /**
     * 会员卡列表
     */
    public function memberCardListAction(){
        $this->secondPointLink('memberCardList');
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'oc_s_id','oper' => '=','value' => $this->curr_sid);
        $where[]    = array('name' => 'oc_type','oper' => '=','value' => 2); //会员卡类型是折扣卡
        $where[]    = array('name' => 'oc_deleted','oper' => '=','value' => 0); //未删除
        $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
        //获取会员卡列表用于选择
        $this->output['cardSelectList'] = $card_model->getList($where);

        $where[]    = array('name' => 'oc_is_points','oper' => '=','value' => 1); //可用积分兑换的会员卡
        //分页处理
        $total      = $card_model->getCount($where);
        //列表数据
        $list       = array();
        if($index <= $total){
            $sort   = array('oc_long_type' => 'ASC','oc_update_time' => 'DESC');
            $list   = $card_model->getListLevel($where,$index,$this->count,$sort);
        }

        $page_libs  = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['pageHtml'] = $page_libs->render();
        $output['list']     = $list;
        $output['type']     = plum_parse_config('discount_card','app');
        $this->showOutput($output);

        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '积分商城', 'link' => '/wxapp/community/pointGoods'),
            array('title' => '会员卡', 'link' => '#'),
        ));

        $this->displaySmarty("wxapp/community/member-card.tpl");
    }

    /**
     * 添加积分会员卡
     */
    public function addPointMemberCardAction(){
        $cardId = $this->request->getIntParam('cardId'); //会员卡的id
        $points = $this->request->getIntParam('points'); //所需积分

        if($cardId && $points){
            $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
            //将会员卡设为可积分兑换的卡
            $set = array('oc_points' => $points, 'oc_is_points' => 1);
            $ret = $card_model->updateById($set, $cardId);

            if($ret){
                $card = $card_model->getRowById($cardId);
                App_Helper_OperateLog::saveOperateLog("添加积分会员卡【{$card['oc_name']}】成功");
            }

            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError("请将数据填写完整");
        }
    }

    /**
     * 删除积分会员卡
     */
    public function delPointMemberCardAction(){
        $cardId = $this->request->getIntParam('cardId'); //会员卡的id

        if($cardId){
            $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
            $card = $card_model->getRowById($cardId);
            //将会员卡设为不可积分兑换的卡
            $set = array('oc_points' => 0, 'oc_is_points' => 0);
            $ret = $card_model->updateById($set, $cardId);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("删除积分会员卡【{$card['oc_name']}】成功");
            }

            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError("删除失败");
        }
    }

    /**
     * 是否显示发布帖子按钮
     */
    public function showPublicBtnAction(){
        $showPublicBtn = $this->request->getIntParam('showPublicBtn');
        $data = array(
            'aci_s_id'                => $this->curr_sid,
            'aci_tpl_id'              => 35,
            'aci_show_public_btn'     => $showPublicBtn,
            'aci_update_time'         => time()
        );
        $ret  = $this->_update_tpl($data, 35); //更新模板信息

        if($ret){
            $str = $showPublicBtn == 1 ? '显示' : '隐藏';
            App_Helper_OperateLog::saveOperateLog("{$str}帖子发布按钮成功");
        }

        $this->showAjaxResult($ret);
    }

    /**
     * 积分商城分类
     */
    public function pointsCategoryAction(){
        $this->secondPointLink('pointsCategory');
        $page = $this->request->getIntParam('page');
        $index = $page*$this->count;
        $shortcut_model = new App_Model_Community_MysqlPointsKindStorage($this->curr_sid);
        $where = array();
        $where[] = array('name' => 'apk_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'apk_deleted', 'oper' => '=', 'value' => 0);
        $sort = array('apk_weight' => 'desc');
        $total = $shortcut_model->getCount($where);
        $list = array();
        if($index<$total){
            $list = $shortcut_model->getList($where,$index,$this->count,$sort);
        }
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '积分商城', 'link' => '/wxapp/community/pointGoods'),
            array('title' => '商品分类', 'link' => '#'),
        ));
        $this->output['list'] = $list;
        $this->displaySmarty('wxapp/community/points-category.tpl');
    }

    /**
     * 保存积分商城分类
     */
    public function savePointsCategoryAction(){
        $name       = $this->request->getStrParam('name');
        $weight     = $this->request->getIntParam('weight');
        $id         = $this->request->getIntParam('id');
        $category_model = new App_Model_Community_MysqlPointsKindStorage($this->curr_sid);

        $data = array(
            'apk_s_id'    => $this->curr_sid,
            'apk_name'    => $name,
            'apk_weight'  => $weight,
        );
        if($id){
            $ret = $category_model->updateById($data,$id);
        }else{
            $data['apk_create_time'] = time();
            $ret = $category_model->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存积分商城分类【{$name}】成功");
        }
        $this->showAjaxResult($ret,'保存');
    }

    /**
     * 删除积分商城分类
     */
    public function deletePointsCategoryAction(){
        $id  = $this->request->getIntParam('id');
        $category_model = new App_Model_Community_MysqlPointsKindStorage($this->curr_sid);
        $category = $category_model->getRowById($id);
        $set = array('apk_deleted' => 1);
        $ret = $category_model->updateById($set, $id);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("删除积分商城分类【{$category['apk_name']}】成功");
        }

        $this->showAjaxResult($ret,'删除');
    }

    /*
     * 开关
     */
    public function changeOpenAction(){
        $result = array(
            'ec' => 400,
            'em' => '修改失败'
        );
        $type    = $this->request->getStrParam('type');
        $value   = $this->request->getStrParam('value');

        $status = $value == 'on' ? 1 : 0;
        $status_note = $status == 1 ? '启用' : '禁用';
        $type_note = '';
        if ($type == 'cart') {
            $type_note = '首页购物车';
            $data['aci_index_cart'] = $status;
        }elseif ($type == 'person'){
            $type_note = '个人申请入驻';
            $data['aci_person_apply'] = $status;
        }
        $data['aci_update_time'] = time();
        $send_storage = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
        $exist = $send_storage->findUpdateBySid(35);
        if($exist) {
            $ret = $send_storage->findUpdateBySid(35, $data);
        }else{
            $data['aci_s_id'] = $this->curr_sid;
            $data['aci_create_time'] = time();
            $ret = $send_storage->insertValue($data);
        }
        if ($ret) {
            $result = array(
                'ec' => 200,
                'em' => ' 修改成功'
            );
            if($status_note && $type_note){
                App_Helper_OperateLog::saveOperateLog($type_note.$status_note."成功");
            }
        }
        $this->displayJson($result);
    }


    /*
     * 修改店铺显示状态
     */
    public function changeShopShowAction(){
        $id = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');

        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
        $set = [
            'es_list_show' => $status
        ];

        $res = $shop_model->updateById($set,$id);

        if($res){
            $shop = $shop_model->getRowById($id);
            $str = $status == 1 ? '显示':'隐藏';
            App_Helper_OperateLog::saveOperateLog("{$str}店铺【{$shop['es_name']}】成功");
        }
        $this->showAjaxResult($res,'操作');
    }



    /**
     *  审核店铺logo图
     */
    public function verifyLogoAction() {
        $page  = $this->request->getIntParam('page');
        $count = $this->count;
        $index = $page * $count;

        $where = [];
        $where[] = ['name'=>'es_s_id', 'oper'=>'=', 'value'=>$this->curr_sid];
        $where[] = ['name'=>'es_logo_status', 'oper'=>'=', 'value'=>1]; //待审核
        $sort = ['es_update_time' => 'desc'];

        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
        $list  = $shop_model->getList($where, $index, $count, $sort);
        $total = $shop_model->getCount($where);

        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $this->output['list']       = $list;

        $this->buildBreadcrumbs(array(
            array('title' => '商家管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/community/verify-shop-logo.tpl');
    }

    public function saveVerifyLogoAction() {
        $esid   = $this->request->getIntParam('esid');
        $note   = $this->request->getStrParam('note');
        $status = $this->request->getIntParam('status');

        $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
        $enter_shop = $es_model->getRowById($esid);
        if($enter_shop && in_array($status, [2,3])) {
            if($status == 2) {
                // 成功
                $upd = [
                    'es_logo_status' => 2, //审核成功
                    'es_logo_img'    => '', //清空
                    'es_logo'        => $enter_shop['es_logo_img'],
                    'es_logo_num'    => $enter_shop['es_logo_num'] +1,
                ];
                $ret = $es_model->updateById($upd, $esid);
            } else if($status ==3) {
                // 审核未通过
                $insert = [
                    'gv_s_id'   => $this->curr_sid,
                    'gv_es_id'  => $esid,
                    'gv_desc'   => $note,
                    'gv_type'   => 2, //logo审核
                    'gv_create_time' => time(),
                    'gv_deleted' => 0,
                ];
                $gv_model = new App_Model_Goods_MysqlGoodsVerifyStorage($this->curr_sid);
                $gv_model->insertValue($insert);

                // 处理enter_shop
                $upd = [
                    'es_logo_status' => 3, // 审核失败
                ];
                $ret = $es_model->updateById($upd, $esid);
            }

            if($ret) {
                $this->displayJsonSuccess(null, null, '操作成功');
            } else {
                $this->displayJsonError('操作失败，请重试');
            }
        } else {
            $this->displayJsonError('数据格式错误');
        }
    }
}