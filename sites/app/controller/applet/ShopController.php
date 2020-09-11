<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/5/7
 * Time: 下午5:05
 */

class App_Controller_Applet_ShopController extends App_Controller_Applet_InitController
{

    public function __construct(){
        parent::__construct(true);
    }

    /**
     * 店铺首页
     */


    private function _get_bottom_menu(){
        // 解析配置的菜单信息
        $bottom_data = json_decode($this->applet_cfg['ac_bottom_menu'],1);
        if($this->applet_cfg['ac_navigation_bar']){
            $navigat_data = json_decode($this->applet_cfg['ac_navigation_bar'],true);
        }
        // 设置菜单默认值
        $bottom_menu =array(
            "color"             => $bottom_data['color'] ? $bottom_data['color'] : "#999999",
            "selectedColor"     => $bottom_data['selectedColor'] ? $bottom_data['selectedColor'] : "#f20d00",
            "backgroundColor"   => $bottom_data['backgroundColor'] ? $bottom_data['backgroundColor'] : "#ffffff",
            "borderStyle"       => $bottom_data['borderStyle'] ? $bottom_data['borderStyle'] : "white",
            'navigationBarTitleText'         => $this->applet_cfg['ac_name'],
            'navigationBarBackgroundColor'   => $navigat_data['navigationBarBackgroundColor'] ? $navigat_data['navigationBarBackgroundColor'] : '#FFFFFF',
            'navigationBarTextStyle'         => $navigat_data['navigationBarTextStyle'] &&  $navigat_data['navigationBarTextStyle'] == 'white' ? 'light' : 'dark',
            'list'  => array(),
        );
        if($this->appletType == 5 && is_array($bottom_data) && !empty($bottom_data)){
            if(!empty($bottom_data['list'])){
                foreach ($bottom_data['list'] as $k => $v){
                    $routeInfo = $this->getPageRoute($v['pagePath']);
                    $bottom_menu['list'][$k]['text']     = $v['text'];
                    $bottom_menu['list'][$k]['pagePath'] = $routeInfo['route'];
                    $bottom_menu['list'][$k]['iconPath'] = $this->response->responseHost().'/public/wxapp/icon'.$v['iconPath'];
                    $bottom_menu['list'][$k]['selectedIconPath'] = $this->response->responseHost().'/public/wxapp/icon'.$v['selectedIconPath'];
                }
            }
        }
        return $bottom_menu;
    }

    /**
     * 判断是否开启三级分销
     */
    private function _find_shop_three_distrib(){
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
        $tcRow         = $three_cfg->findShopCfg();
        if($tcRow['tc_isopen'] && $tcRow['tc_istip']){
            return intval($tcRow['tc_isopen']);
        }else{
            return 0;
        }
    }
    //试衣间功能
    public function clothesNowAction(){
       $gid  =  $this->request->getIntParam('gid');
       $data =  $this->_get_goods_clothes_room($gid);
       if($data){
           $info['data']['clothesData'] = $data;
           $this->outputSuccess($info);
       }else{
           $this->outputError('暂时没有数据哦');
       }
    }

    /**
     * 获取商品的试衣间信息
     */
    private function _get_goods_clothes_room($gid=''){
        $clothes_storage = new App_Model_Goods_MysqlClothesRoomStorage($this->sid);
        $imgList   = $clothes_storage->getListByGidSid($gid);//获取试衣间颜色图片
        $newList   = array();
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        if($imgList){
            if($gid){
                $qrcode = $goods_model->getRowById($gid)['g_qrcode'];
                foreach ($imgList as $key=>$val){
                    $newList[$val['gcri_type']][$key]['img']    = $this->dealImagePath($val['gcri_path']);
                    $newList[$val['gcri_type']][$key]['qrcode'] = $qrcode?$this->dealImagePath($qrcode):'';
                }
            }else{
                foreach ($imgList as $key=>$val){
                    $qrcode    = '';
                    if($val['gcri_g_id']){
                        $qrcode = $goods_model->getRowById($val['gcri_g_id'])['g_qrcode'];
                    }
                    $newList[$val['gcri_type']][$key]['img']    = $this->dealImagePath($val['gcri_path']);
                    $newList[$val['gcri_type']][$key]['qrcode'] = $qrcode?$this->dealImagePath($qrcode):'';
                }
            }
            $modelList = $clothes_storage->getModelListSid();
            if($modelList){
                foreach ($modelList as $item){
                    $newList[$item['gcri_type']][] = $this->dealImagePath($item['gcri_path']);
                }
            }
        }
        return array_values($newList);
    }


    /**
     * 获取店铺模板配置
     */
    private function _shop_index_tpl($tpl_id){
        $data = array();
        $tpl_model = new App_Model_Mall_MysqlMallIndexStorage($this->sid);
        $tpl   = $tpl_model->findUpdateBySid($tpl_id);
        if($tpl){
            $data = array(
                'temp'         => $tpl_id,
                'title'        => $tpl['ami_title'],
                'backImg'      => $this->dealImagePath($tpl['ami_head_img']),
                'goodsStyle'   => $tpl['ami_goods_list'],
                'address'      => isset($tpl['ami_address']) ? $tpl['ami_address'] : '',
                'lng'          => isset($tpl['ami_lng']) ?  $tpl['ami_lng'] : '',
                'lat'          => isset($tpl['ami_lat']) ? $tpl['ami_lat'] : '',
                'recommendTitle' => isset($tpl['ami_recommend_tip']) ? $tpl['ami_recommend_tip'] : '推荐商品',
                'searchText'     => isset($tpl['ami_search_tip']) ? $tpl['ami_search_tip'] : '请输入关键词',
            );
            $data['notice'] = array(
                'noticeTitle'    => $tpl['ami_notice_title']?$tpl['ami_notice_title']:'',
                'noticeColor'    => $tpl['ami_notice_color']?$tpl['ami_notice_color']:'',
                //'noticeSize'     => $tpl['ami_notice_size']?$tpl['ami_notice_size']:'',
                'noticeStatus'   => $tpl['ami_notice_status']?1:0,
            );
        }else{
            $template_model = new App_Model_Applet_MysqlAppletTemplateStorage();
            $where = array();
            $where[] = array('name' => 'act_s_id', 'oper' => '=', 'value' => $this->sid);
            $template = $template_model->getRow($where);
            $data = array(
                'temp'           => $tpl_id,
                'title'          => $template['act_header_title'],
            );
        }
        return $data;
    }
    /**
     * 获取头条资讯
     */
    private function _get_shop_notice_list($tpl_id){
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $sort          = array('ai_create_time' => 'DESC');
        $list          = $information_storage->getList($where,0,6,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = $val['ai_title'];
            }
        }
        return $data;
    }



    /**
     *获取模板信息
     */

    /**
     * 获取首页幻灯
     */
    private function _shop_index_slide($tpl_id){
        $data = array();
        //获取店铺幻灯
        $slide_storage  = new App_Model_Shop_MysqlShopSlideStorage($this->sid);
        $slide      = $slide_storage->fetchSlideShowList($tpl_id);
        if($slide){
            foreach ($slide as $val){
                $data[] = array(
                    'id'   => $val['ss_id'],
                    'link' => $val['ss_link'],
                    'type' => intval($val['ss_link_type']),
                    'img'  => isset($val['ss_path']) ? $this->dealImagePath($val['ss_path']) : '',
                    'url'  => $this->get_link_by_type($val['ss_link_type'],$val['ss_link'],$val['ss_article_title']),
                );
            }
        }
        return $data;

    }

    /**
     * 获取商品分组
     */
    private function _shop_index_shortcut($tpl_id){
        $data = array();
        //获取快捷按钮
        $shortcut_storage   = new App_Model_Shop_MysqlShopShortcutStorage($this->sid);
        $shortcut   = $shortcut_storage->fetchShortcutShowList($tpl_id);
        if($shortcut){
            foreach ($shortcut as $val){
                $data[] = array(
                    'name' => $val['ss_name'],
                    'icon' => isset($val['ss_icon']) ? $this->dealImagePath($val['ss_icon']) : '',
                    'link' => isset($val['ss_link']) ? $val['ss_link'] : '',
                    'type' => intval($val['ss_link_type']),
                    'url'  => $this->get_link_by_type($val['ss_link_type'],$val['ss_link'],$val['ss_name']),
                );
            }
        }
        return $data;
    }

    /**
     * 商品列表
     */
    public function goodsListAction(){
        $category = $this->request->getIntParam('category');  //获取商品分组
        //新增我的浏览和收藏商品
        $browse     = $this->request->getIntParam('browse');
        $collect  = $this->request->getIntParam('collect');
        $independent = $this->request->getIntParam('independent');

        $data['link'] = $this->shop['s_all_goods_jump'];

        if($collect){
            $data['data']  = $this->_my_collect_goods($independent);
        }elseif ($browse){
            $data['data']  = $this->_my_browse_goodslist($independent);
        }else{
            if($category){
                $data['data'] = $this->_goods_list_new($category,$independent);
            }else{
                $data['data'] = $this->_goods_list(0,$independent);
            }
        }

        if($data){
            $this->outputSuccess($data);
        }else{
            $this->outputError('数据加载完毕');
        }
    }

    /**
     * 获取商品详情
     */
    public function goodsDetailAction(){
        $gid  = $this->request->getIntParam('gid');
        $laid = $this->request->getIntParam('laid');  // 限时抢购活动id
        $mid  = $this->request->getIntParam('mid'); //分享人id
        if(!$laid){
            $limit_goods_storage = new App_Model_Limit_MysqlLimitGoodsStorage($this->sid);
            $limit_act = $limit_goods_storage->getActByGid($gid, $laid, 1);
            $laid = $limit_act['la_id'];
        }

        if($mid){
            //处理分享动作
            $this->_deal_share($mid, $gid);
        }

        if(empty($gid))
            $this->outputError('商品不存在');


        //获取店铺商品
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $goods = $goods_model->findGoodsBySidGid($this->sid,$gid);
        if(empty($goods))
            $this->outputError('商品不存在..');
            
        $cart_storage = new App_Model_Shop_MysqlShopCartStorage($this->sid);
        $info['data'] = $this->_format_goods_details($goods,true,$laid);
        // 增加商品浏览量
        $set = array(
            'g_show_num'        =>  ($goods['g_show_num'] + 1),
            'g_show_real_num'   =>  ($goods['g_show_real_num']+1)
        );
        $goods_model->updateById($set, $gid);
        //获取商品优惠
        $full_helper    = new App_Helper_FullAct($this->sid);
        $full_act       = $full_helper->getFullActByGid($gid);
        $info['data']['fullAct'] = $this->_format_full_act($full_act);
        //判断商品是否有试衣间
        $clothes   = $this->_get_goods_clothes_room($gid);
        if($clothes[1] && $clothes[0]){
            $info['data']['clothesStatus'] = 1;
        }else{
            $info['data']['clothesStatus'] = 0;
        }
        $info['data']['clothesData'] = $clothes;
        // 判断用户是否允许授权
        $uid    = plum_app_user_islogin();
        //新增如果会员id存在，将该条记录添加到商品浏览记录中
        if($uid){
           $this->_add_browse_good($gid,$uid);
        }
        if(($this->member['m_id'] && $this->member['m_id']>0) || $uid){
            $mid = $this->member['m_id']>0 ? $this->member['m_id'] : $uid;
            $cartNum = $cart_storage->getCartSum($mid,0,$goods['g_es_id']);
            $info['data']['cartNum'] = intval($cartNum);
        }else{
            $info['data']['cartNum'] = 0;
        }
        //获得会员卡跳转类型
        $ct_model  = new App_Model_Member_MysqlCenterToolStorage();
        $centerTool = $ct_model->findUpdateBySid($this->sid);
        $info['data']['membercardJump'] = intval($centerTool['ct_membercard_jump']);

        $this->outputSuccess($info);
        
    }

    private function _deal_share($mid, $gid){
        $goods_deduct   = new App_Model_Goods_MysqlGoodsRatioDeductStorage($this->sid);
        $gd     = $goods_deduct->findOpenDeduct($gid);
        if($gd){
            //单品分销商品，增加单品分销的分享量
            $set = array('grd_share_num' => ($gd['grd_share_num'] + 1));
            $goods_deduct->updateById($set, $gd['grd_id']);
        }
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
        $tcRow         = $three_cfg->findShopCfg();
        if($tcRow['tc_isopen'] || $tcRow['tc_copartner_isopen']){
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $shareMember = $member_storage->findMemberByIdSid($mid, $this->shop['s_id']);
            if($shareMember['m_is_highest'] || $shareMember['m_1f_id']){
                $is_real_member = App_Helper_MemberLevel::isRealMember($this->shop['s_id'], $mid);
                if($is_real_member){
                    $uid    = plum_app_user_islogin();
                    $member = $member_storage->findMemberByIdSid($uid, $this->shop['s_id']);
                    if($mid != $uid && !$member['m_is_highest'] && !$member['m_1f_id']){
                        App_Helper_MemberLevel::setLevelSendMessage($this->shop['s_id'], $uid, $mid);
                    }
                }
            }
        }
    }

    private function _add_browse_good($gid,$uid){
        $browse_model = new App_Model_Goods_MysqlGoodsBrowseStorage($this->sid);
        $row          = $browse_model->getRowByIdSidMid($gid,$this->sid,$uid);
        if(!$row){
            //将记录增加在浏览记录表中
            $insertData = array(
                'gb_s_id'  => $this->sid,
                'gb_m_id'  => $uid,
                'gb_g_id'  => $gid,
                'gb_create_time' => time(),
            );
            $browse_model->insertValue($insertData);
        }
    }

    /**
     * 拼团区块
     */
    private function _fetch_group_list(){
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
        $org_curr   = array();

        $act_arr    = $group_model->getCurrentList(0,5);
        foreach ($act_arr as &$one) {
            $org_curr[] = array(
                'gbId'  => $one['gb_id'],
                'cover' => $this->dealImagePath($one['gb_cover']),
                'name'  => $one['g_name'],
                'gprice'=> $one['gb_type'] == 3?$one['gb_tz_price']:$one['gb_price'],
                'price' => $one['g_price'],
                'total' => $one['gb_total'],
                'listLabel' => $one['g_list_label']
            );
        }
        return $org_curr;
    }

    /**
     * 获取秒杀活动
     */
    private function _limit_activity_list(){
        $data = array();
        $limit_storage = new App_Model_Limit_MysqlLimitActStorage($this->sid);
        $list = $limit_storage->getAllRunningNotBeginAct();
        if($list){
            $goods_model  = new App_Model_Limit_MysqlLimitGoodsStorage($this->sid);
            $goods_list = $goods_model->getListByActid($list[0]['la_id']);
            if (!empty($goods_list)) {
                foreach ($goods_list as $val){
                    $data[] = $this->_format_goods_details($val,false,$list[0]['la_id']);
                }
            }
        }
        return $data;
    }

    /**
     * 格式化满减活动数据
     */
    private function _format_full_act($full_act){
        $data = array();
        foreach($full_act as $val){
            $data[] = array(
                'typeDesc' => $val['type_desc'],
                'name'     => $val['fa_name']
            );
        }
        return $data;
    }

    /**
     * 获取精选商品
     */
    private function _goods_list($top=0,$independent = 0){
        $page     = $this->request->getIntParam('page');
        $recomm   = $this->request->getIntParam('recomm');      // 获取促销商品
        $sortType = $this->request->getIntParam('sortType');  // 商品排序类型
        $keyword  = $this->request->getStrParam('keyword');
        $kind1    = $this->request->getIntParam('kind1');          // 商品分类ID
        $kind2    = $this->request->getIntParam('kind2');          // 商品分类ID
        $cid      = $this->request->getIntParam('cid');   //优惠券id
        $type     = $this->request->getIntParam('ctype'); //优惠券类型
        $priceSort = $this->request->getStrParam('priceSort');
        $showEntershop = $this->request->getIntParam('showEntershop',0);

        $sourcetype     = $this->request->getStrParam('sourcetype');//recommend 推荐商品
        if($top || $recomm || $sourcetype == 'recommend' || $sourcetype == 'recommendEs'){
            $top = 1;
        }
        //获取店铺商品
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $index  = $page*$this->count;
        if($sortType && $sortType==1){
            if($priceSort && $priceSort=='up'){
                $sort   = array('g_price'=>'ASC','g_weight' => 'DESC', 'g_update_time' => 'DESC');
            }else if($priceSort && $priceSort=='down'){
                $sort   = array('g_price'=>'DESC','g_weight' => 'DESC', 'g_update_time' => 'DESC');
            }

        }elseif ($sortType && $sortType==2){
            $sort   = array('g_sold'=>'DESC','g_weight' => 'DESC', 'g_update_time' => 'DESC');
        }elseif ($sortType && $sortType==3){
            $sort   = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        }else if($sortType && $sortType==5){   //新品
            $sort   = array('g_update_time' => 'DESC','g_weight' => 'DESC');
        }else if($sortType && $sortType==6) {   //综合排序
            $sort = array('g_weight' => 'DESC', 'g_update_time' => 'DESC', 'g_price' => 'ASC');
        } else{
            $sort = array('g_weight' => 'DESC', 'g_update_time' => 'DESC', 'g_price' => 'ASC');
        }
        $where = array();
        if($sourcetype == 'recommendEs'){
            $where[] = array('name' => 'g_es_id', 'oper' => '>', 'value' => 0);
        }else{
            if(!$showEntershop){
                $where[] = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);
            }

        }

        if($type == 2){
            $couponGoods_model = new App_Model_Coupon_MysqlCouponGoodsStorage($this->sid);
            $coupon_goods = $couponGoods_model->getListByActid($cid, 0, 0);
            foreach($coupon_goods as $val){
                $goods[] = $val['cg_g_id'];
            }
            if(!empty($goods)){
                $where[] = array('name' => 'g_id', 'oper' => 'in', 'value' => $goods);
            }
        }
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
        $kindRow = $kind_model->getRowById($kind2);

        if($kindRow && $kindRow['sk_independent_mall'] == 1){
            $independent = 1;
        }

        if($kindRow['sk_level'] == 1){
            $kind1 = $kind2;
            $kind2 = '';
        }
        $where[] = array('name' => 'g_applay_goods_show', 'oper' => '=', 'value' => 1);  //前台列表不显示的过滤掉
        $where[] = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);

        if($independent == 1){
            //只显示独立商城的商品
            $where[] = array('name' => 'g_independent_mall', 'oper' => '=', 'value' => 1);
        }else{
            $where[] = array('name' => 'g_independent_mall', 'oper' => '=', 'value' => 0);
        }

        $list  = $goods_model->fetchShopGoodsList($this->sid, $index, $this->count, $keyword, $top, $sort,array(),$kind1,$kind2,1,$where);

        $info = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        return $info;
    }
    /**
     * 获取精选商品
     */
    private function _goods_list_new($category,$independent = 0){
        $page = $this->request->getIntParam('page');
        //获取店铺商品
        $index  = $page*$this->count;
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);

        $diff_goods = [];
        $has_manager = [];
        $community = [];
        $checkCommunity = 0;
        $isSequenceList = 0;
        $presell = 0;
        $hide = 0;
        $uid = plum_app_user_islogin();
        if($this->applet_cfg['ac_type'] == 32 ){
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
            $extra = $extra_model->findUpdateExtraByMid($uid);
            $community = intval($extra['ame_se_cid']);
            $checkCommunity = 1;
            $isSequenceList = 1;
            $presell = 1;
            $hide = 1;

            // 社区团购 区域管理合伙人处理逻辑
            // 根据社区找到这个社区是否有中间层的区域合伙人
            // 如果有区域合伙人的话查询数据的的时候 需要绕过顶级管理员设置的商品限购总开全
            // 判断当前商品在合伙人设置中是否限购
            // if($this->sid==9373){
            $community_model=new App_Model_Sequence_MysqlSequenceCommunityStorage($this->sid);
            $has_manager=$community_model->checkCommunityHasRegionManager($community,$this->shop['s_c_id'],'asa_zone');
            if($has_manager['m_area_id']){
                //读取区域管理所有限购的商品id
                //读取商品小区限购表中该小区可以购买的商品
                //所有限购的商品--可以购买的商品= 不能购买的商品
                //不能购买的商品从现有的列表中剔除

                //社区团购 区域管理合伙人自定义添加的商品只能被自己所辖社区获取
                $manager_where[]="(`g_region_add_by`={$has_manager['m_id']} OR `g_region_add_by`=0)";
                $region_model=new App_Model_Sequence_MysqlSequenceRegionGoodsStorage($this->sid);
                $limit_goods=$region_model->getAllLimitGoods($has_manager['m_area_id']);

                // 获取所有主管理员设置的限购的商品
                $limit_goods_main=$goods_model->getGoodsLimited();


                $limit_goods_main_ids=array_column($limit_goods_main,'g_id');
                $limit_goods_ids=array_column($limit_goods,'asrg_goods_id');
                $limit_goods_ids=array_merge($limit_goods_ids,$limit_goods_main_ids);

                $sequence_goods_community=new App_Model_Sequence_MysqlSequenceGoodsCommunityStorage($this->sid);
                $can_buy_goods=$sequence_goods_community->getGoodsBySidCid($community);

                $diff_goods=array_diff($limit_goods_ids, array_column($can_buy_goods,'asgc_g_id')); //需要被从列表中删除的商品
//                if($diff_goods)
//                    $region_where[]=['name'=>'g_id','oper'=>'not in','value'=>$diff_goods];
//                else
//                    $region_where = [];
            }
        }


        $list        = $goods_model->getGroupGoods('look',$category,$index,$this->count,'',0,$hide,$independent,$has_manager,$diff_goods,$checkCommunity,$community,$presell,$isSequenceList);
        $info = array();
        if($list){
            $new_member = App_Helper_Sequence::checkNewMember($uid,$this->sid);

            foreach ($list as $val){
                $info['goods'][] = $this->_format_goods_details($val,false,0,true,[],$new_member);
            }
        }else{
            $info['goods'] = array();
        }
        $info['category'] = $this->_goods_group($category);
        return $info;
    }
    /**
     * 获取商品分组
     */
    private function _goods_group($id){
        $group_model  = new App_Model_Goods_MysqlGroupStorage($this->sid);
        $row = $group_model->getRowById($id);
        $data = array(
            'name'      => $row['gg_name'],
            'brief'     => isset($row['gg_brief']) ? $row['gg_brief'] : '热销商品包你满意',
            'img'       => isset($row['gg_bg']) && $row['gg_bg'] ? $this->dealImagePath($row['gg_bg']) : $this->dealImagePath('/upload/gallery/thumbnail/C5A1A4E4-B65B-5031-F627091DF542-tbl.jpeg'),
            'listStyle' => $row['gg_list_type'],
        );
        return $data;

    }

    /*
     * 获取我的收藏商品
     */
    private function _my_collect_goods($independent = 0){
        $collection_model    = new App_Model_Goods_MysqlGoodsCollectionStorage($this->sid);
        $page = $this->request->getIntParam('page');
        $uid = plum_app_user_islogin();
        //获取店铺商品
        $index    = $page*$this->count;
        $sort     = array('gc_create_time'=>'DESC');
        $where    = array();
        $where[]  = array('name'=>'gc_s_id','oper'=>'=','value'=>$this->sid);
        $where[]  = array('name'=>'gc_m_id','oper'=>'=','value'=>$uid);
        if($independent == 1){
            $where[]  = array('name'=>'g_independent_mall','oper'=>'=','value'=>1);
        }
        $list   = $collection_model->getGoodsList($where,$index,$this->count,$sort);
        $info = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        return $info;

    }

    /*
     * 获取我的浏览商品记录
     */
    private function _my_browse_goodslist($independent = 0){
        $browse_model    = new App_Model_Goods_MysqlGoodsBrowseStorage($this->sid);
        $page = $this->request->getIntParam('page');
        $uid = plum_app_user_islogin();
        //获取店铺商品
        $index    = $page*$this->count;
        $sort     = array('gb_create_time'=>'DESC');
        $where    = array();
        $where[]  = array('name'=>'gb_s_id','oper'=>'=','value'=>$this->sid);
        $where[]  = array('name'=>'gb_m_id','oper'=>'=','value'=>$uid);
        if($independent == 1){
            $where[]  = array('name'=>'g_independent_mall','oper'=>'=','value'=>1);
        }
        $list   = $browse_model->getGoodsList($where,$index,$this->count,$sort);
        $info = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        return $info;

    }

    /**
     * 获取首页推荐商品
     */
    private function _recommend_goods_list($tpl){
        $recommend_model = new App_Model_Mall_MysqlMallRecommendStorage($this->sid);
        $recommend_list = $recommend_model->fetchRecommendShowList($tpl);
        $data = array();
        if($recommend_list){
            foreach ($recommend_list as $val){
                $data[] = array(
                    'name'  => $val['amr_name'],
                    'price' => $val['amr_price'],
                    'img'   => $this->dealImagePath($val['amr_img']),
                    'link'  => $val['amr_link']
                );
            }

        }
        return $data;
    }

    /**
     * @param $tpl
     * @return array
     * 获取店铺首页展示的分类数据
     */
    private function _shop_kind_list($tpl){
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->sid);
        $kind_list = $kind_model->fetchKindShowList($tpl);
        $data = array();
        if($kind_list){
            foreach ($kind_list as $val){
                $data[] = array(
                    'name'  => $val['amk_name'],
                    'link'  => $val['amk_link'],
                    'img'   => isset($val['amk_img']) && $val['amk_img'] ? $this->dealImagePath($val['amk_img']) : ($this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo']) : ''),
                    'goods' => $this->_goods_list_by_kind($val['amk_link']),
                );
            }
        }
        return $data;
    }

    /**
     * 根据商品分类获取分类下的商品（默认取6个）
     */
    private function _goods_list_by_kind($kind){
        $kind_model = new App_Model_Shop_MysqlKindStorage($this->sid);
        $kindInfo = $kind_model->getRowById($kind);
        $kind1 = 0;
        $kind2 = 0;
        if($kindInfo['sk_level'] == 2){
            $kind2 = $kind;
        }else{
            $kind1 = $kind;
        }
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $goods_list = $goods_storage->fetchShopGoodsListByKind(0,6,$kind1, $kind2);
        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = $this->_format_goods_details($val);
            }
        }
        return $data;
    }

    /*
    * 获得自取/配送时间
    */
    private function _get_receive_time($good = array(),$format = false){

        $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
        $sendCfg = $send_model->findUpdateBySid();

        $timeNow = time();
        $day_plus = 0;
        $dayTime = plum_parse_config('day_time');
        if($sendCfg['acs_sequence_daytime'] && in_array($sendCfg['acs_sequence_daytime'],$dayTime)){
            $timestemp = strtotime($sendCfg['acs_sequence_daytime']);
            if($timeNow > $timestemp){
                $day_plus = 1;
            }
        }
        $days = intval($good['g_sequence_day']);
        $show = intval($good['g_sequence_day_show']);
       // if(!empty($good) && $good['g_sequence_day'] > 0){

       // }else{
       //     $days = intval($sendCfg['acs_sequence_day']);
       // }

        $day_time = $days > 0 ? ($timeNow + ($days + $day_plus) * 86400) : ($timeNow + $day_plus * 86400);
        $sendNote = $this->_get_send_note($sendCfg);
        if($format){
            if($show > 0){
                return $days > 0 || $day_plus > 0 ? date('Y-m-d',$day_time).'开始'.$sendNote : '当日'.$sendNote;
            }else{
                return '';
            }
        }else{
            return $day_time;
        }
    }

    private function _get_send_note($sendCfg = []){
        $note = '发货/提货';
        if($sendCfg['acs_send'] && !$sendCfg['acs_receive']){
            $note = '提货';
        }
        if(!$sendCfg['acs_send'] && $sendCfg['acs_receive']){
            $note = '发货';
        }
        return $note;

    }

    /**
     * 获取商品规格
     */
    private function _goods_format_one($gid,$goods = []){
        //获取商品规格
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format = $format_model->getListByGid($gid);
        $data = [];
        $name_data = [];
        $name_data_new = [];
        $isVip = 0;
        $stock = 0;

        $format_list = [
            [
                'name' => '规格',
                'value' => []
            ]
        ];
        $uid    = plum_app_user_islogin();
        if($format){
            foreach ($format as $val){
                $vipData = App_Helper_Trade::getGoodsVipPirce($val['gf_price'], $this->sid, $gid, $val['gf_id'],$uid, 1);
                $format_data = array(
                    'id'       => $val['gf_id'],
                    'name'     => $val['gf_name'],
                    'oriPrice' => $vipData['isVip']>0 ? $val['gf_price'] : floatval($val['gf_ori_price']),
                    'price'    => $vipData['price'],
                    'sold'     => $val['gf_sold'],
                    'newMemberPrice' => $val['gf_newmember_price'] > 0 ? floatval($val['gf_newmember_price']) : floatval($goods['g_date_price']),
                    'stock'    => $val['gf_stock'] < 0 ? 0 : intval($val['gf_stock']),
                    'point'    => $val['gf_send_point'],
                    'vipPriceList' => $val['gf_vip_price_list']
                );
                $data['value'][] = $format_data;
                $name_data[$val['gf_name'].$val['gf_name2'].$val['gf_name3']] = $format_data;
                $name_data_new[$val['gf_name'].($val['gf_name2']?'-':'').$val['gf_name2'].($val['gf_name3']?'-':'').$val['gf_name3']] = $format_data;
                $stock += $val['gf_stock'] < 0 ? 0 : intval($val['gf_stock']);

                $data['noVipPrice'][] = $val['gf_price'];
                $data['oriPrices'][] = floatval($val['gf_ori_price']);
                $data['prices'][] = $vipData['price'];
                $data['weight'][] = array(
                    'value' => $val['gf_format_weight_type'] == 1?floatval($val['gf_format_weight']):floatval($val['gf_format_weight'] * 1000),
                    'type'  => $val['gf_format_weight_type']
                );
                if($vipData['isVip']){
                    $isVip = 1;
                }

                $format_list[0]['value'][] = [
                    'fIndex' => 0,
                    'checked' => false,
                    'noCheck' => false,
                    'name' => $val['gf_name'],
                    'img'  => $this->dealImagePath($goods['g_cover'])
                ];

            }
        }
        $data['formatOrigin'] = $format;
        $data['isVip'] = $isVip;
        $data['stock'] = $stock;
        $data['nameData'] = $name_data;
        $data['nameDataNew'] = $name_data_new;

        if($goods['g_format_type']){
            $spec = json_decode($goods['g_format_type'], true);
            foreach($spec as $key => $val){
                foreach($val['value'] as $k=>$v){
                    $spec[$key]['value'][$k]['fIndex'] = $key;
                    $spec[$key]['value'][$k]['checked'] = false;
                    $spec[$key]['value'][$k]['noCheck'] = false;
                    $spec[$key]['value'][$k]['img'] = $v['img']?$this->dealImagePath($v['img']):$this->dealImagePath($goods['g_cover']);
                }
            }
            $data['formatList'] = $spec;
        }else{
            $data['formatList'] = $format_list;
        }

        return $data;
    }

    /**
     * 格式化商品数据
     */
    private function _format_goods_details($goods,$detail=false,$laid=0,$allInfo = true,$cartList = [],$changeFormatPrice = false,$newMember = 0){
        if(!$laid){
            //获取正在进行中的抢购商品数组
            $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->sid);
            $act_goods= $act_model->getAllRunningNotBeginActGoods(array(), 0, 50);
            foreach($act_goods as $value){
                if($goods['g_id'] == $value['lg_g_id']){
                    $laid = $value['la_id'];
                }
            }
        }


        if(empty($goods))
            return false;
        $data = array(
            'id'         => $goods['g_id'],
            'esId'       => intval($goods['g_es_id']),
            'esid'       => intval($goods['g_es_id']),
            'name'       => $goods['g_name'],
            'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
            'coverDown'  => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover'],true) : '',
            'price'      => floatval($goods['g_price']),
            'noVipPrice' => floatval($goods['g_price']),
            'shareVipPrice' => intval($this->shop['s_goods_share_vip']),
            'weight'     => floatval($goods['g_goods_weight'])?floatval($goods['g_goods_weight']).($goods['g_goods_weight_type']==1?'g':'Kg').($goods['g_unit_name'] ? ' /'.$goods['g_unit_name'] :''):0,
            'oriPrice'   => floatval($goods['g_ori_price']),
            'brief'      => isset($goods['g_brief']) ? $goods['g_brief'] : '',
            'stock'      => $goods['g_stock']<0?0:$goods['g_stock'],
            'stockShow'  => $goods['g_stock_show'],
            'kind1'      => $goods['g_kind1'],
            'kind2'      => $goods['g_kind2'],
            'sold'       => $goods['g_sold'],
            'soldShow'   => $goods['g_sold_show'],
            'expfeeShow' => intval($goods['g_expfee_show']),
            'freight'    => $goods['g_unified_fee'],
            'hasFormat'  => false,
            'islimit'    => $goods['g_limit'] > 0  ? true : false,
            'purchase'   => isset($goods['g_limit']) && $goods['g_limit'] > 0 ? $goods['g_limit'] : $goods['g_stock'],
            'purchaseNote'   => isset($goods['g_limit']) && $goods['g_limit'] > 0 ? '每人限购'.$goods['g_limit'].'件' : '',
            'isDiscuss'  => intval($goods['g_is_discuss']),
            'discussInfo'=> isset($goods['g_discuss_info']) ? $goods['g_discuss_info'] : '',
            'phone'      => $this->shop['s_phone'] ? $this->shop['s_phone'] : '',
            'showNum'    => $goods['g_show_num'],
            'showNumShow'=> $goods['g_show_num_show'],
            'showVipList'=> $goods['g_show_vip'],
            'unitName'   => $goods['g_unit_name'] ? $goods['g_unit_name'] :'',
            'smallNum'   => (integer)$goods['g_small_num'],
            'listLabel'  => $goods['g_list_label'],
            'independent'=> intval($goods['g_independent_mall']),
            'limitShareTitle' => '',
            'limitShareImg' => '',
            'fakeExampleList' => [],
            'newMember' => $goods['g_has_window'] == 2 ? $newMember : 0,
            'newMemberStock' => intval($goods['g_hotel_stock']),
            'newMemberPrice' => floatval($goods['g_date_price']),
            'hasLimit' => $goods['g_limit'] > 0 || $goods['g_day_limit'] > 0 ? 1 : 0,
            'leastBuy' => isset($goods['g_least_buy']) ? intval($goods['g_least_buy']) : 0,
        );

        //营销商城获取当前用户当日已经购买到的商品的数量
        //zhangzc
        //2019-11-28
        if($this->applet_cfg['ac_type'] == 21){
            $trade_order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $uid = plum_app_user_islogin();
            // 存在当日限购
            if($goods['g_day_limit']){
                 // 今天的时间戳
                $today_start=strtotime(date('Ymd',time()));
                $today_end=$today_start + 24 * 60 * 60;
                $limit_today=$trade_order_model->getUserBuySum($goods['g_id'],$uid,$today_start,$today_end);
                $data['userBuyRecord']['todayNum']=intval($limit_today['total']);
            }
            // 存在总限购
            if($goods['g_limit']){
                $limit_all=$trade_order_model->getUserBuySum($goods['g_id'],$uid);
                $data['userBuyRecord']['allNum']=intval($limit_all['total']);
            }
            // 总的可以购买的数量
            if(!empty($data['userBuyRecord']['allNum'])){
                $temp_diff = $goods['g_limit'] - $data['userBuyRecord']['allNum'];
                $all_can_buy = $temp_diff > 0 ? $temp_diff : 0 ;
            }else{
                $all_can_buy = $goods['g_limit'] ? $goods['g_limit']: $goods['g_stock'];
            }
            // 当日的可以购买的数量
            if(!empty($data['userBuyRecord']['todayNum'])){
                $temp_day_diff = $goods['g_day_limit'] - $data['userBuyRecord']['todayNum'];
                $today_can_buy = $temp_day_diff >0 ? $temp_day_diff : 0;
            }else{
                $today_can_buy = $goods['g_day_limit']?$goods['g_day_limit']:$goods['g_stock'];
            }

            $data['userBuyRecord']['canBuy'] = ($all_can_buy -  $today_can_buy) >0 ? intval($today_can_buy) : intval($all_can_buy);
            $cart_storage = new App_Model_Shop_MysqlShopCartStorage($this->sid);
            $cart_info=$cart_storage->getCartSum($uid, 0,$goods['g_es_id'],$goods['g_id']);
            $data['userBuyRecord']['cartNum']   = ($cart_info['total']!=null)?intval($cart_info['total']):0;

            //列表中一次获得规格信息
            $formatData = $this->_goods_format_one($goods['g_id'],$goods);
            $data['format'] = $formatData['value'] ? $formatData['value'] : '';
            if(!empty($data['format']) && $data['format']){
                $data['hasFormat'] = true;
                $data['isVip'] = $formatData['isVip'];
                $data['formatValue'] = $format_data['data'] = $formatData['nameData'];
                $data['formatValueNew'] = $format_data['newData'] = $formatData['nameDataNew'];
                $data['stock'] = $formatStock = $formatData['stock'];
                $data['formatList']  = $formatData['formatList'];
            }
        }


        if($this->applet_cfg['ac_type'] == 32){
            $goods_redis = new App_Model_Goods_RedisGoodsStorage($this->sid);
            $upTtl = $goods_redis->getGoodsSaleUpTtl($goods['g_id']);
            $downTtl = $goods_redis->getGoodsSaleDownTtl($goods['g_id']);
            $timeNow = time();
            $data['isPresell'] = $upTtl > 0 ? 1 : 0;
            $data['upTime'] = intval($upTtl);
            $data['downTime'] = intval($downTtl);
            $data['upTimeDate'] = $upTtl > 0 ? date('m/d',($timeNow+$upTtl)) : '';
            $data['downTimeDate'] = $downTtl > 0 ? date('m/d',($timeNow+$downTtl)) : '';
        }

        $uid    = plum_app_user_islogin();
        $vipData = App_Helper_Trade::getGoodsVipPirce($data['price'], $this->sid, $goods['g_id'], 0,$uid, 1);

        if($this->applet_cfg['ac_type'] == 6){
            //同城多店
            $data['vipPrice'] = $this->_get_vip_price($goods);
        }
        $data['noVipPrice'] = $data['price'];
        $data['price'] = $vipData['price'];
        $data['isVip'] = $vipData['isVip'];

        $level_model = new App_Model_Member_MysqlLevelStorage();
        $levelList = $level_model->getListBySid($this->sid);
        $data['isVipPrice'] = ($levelList && ($goods['g_had_vip_price'] || $goods['g_join_discount'])) || $vipData['isVipPrice'] ? 1 : 0;
        $data['vipLabel'] = '会员折扣';

        if($goods['g_expfee_type'] == 2){
            $data['freight'] = '根据配送地区收取运费';
        }

        $data['label'] = array();

        $goods['g_is_global'] == 1 ? $data['label'][] = '全球购' : false;
        $goods['g_is_back'] == 1 ? $data['label'][] = '七天退换' : false;
        $goods['g_is_quality'] == 1 ? $data['label'][] = '正品保证' : false;
        $goods['g_is_truth'] == 1 ? $data['label'][] = '如实描述' : false;

        $data['newLabel'] = array();
        if(isset($goods['g_custom_label'])){
            $labelArr = preg_split("/[\s,]+/",$goods['g_custom_label']);
            foreach ($labelArr as $val){
                if($val && isset($val)){
                    $data['newLabel'][] = $val;
                }
            }
        }
        //酒店版
        if($this->applet_cfg['ac_type'] == 7){
            $data['bedInfo'] = $goods['g_bed_info'] ? $goods['g_bed_info'] : '';
            $data['hasWindow'] = $goods['g_has_window'] ? '有窗' : '无窗';
            $data['roomSize'] = $goods['g_room_size'] ? (is_numeric($goods['g_room_size']) ? $goods['g_room_size'].'㎡' : $goods['g_room_size']) : '';
            $data['hotelService'] = $this->_get_store_service($goods['g_id'],2);

            $hotel_model = new App_Model_Hotel_MysqlHotelStoreStorage($this->sid);
            $hotelRow = $hotel_model->getRowById($goods['g_kind1']);
            $data['hotelName'] = $hotelRow['ahs_name'];
            $data['hotelId']   = $hotelRow['ahs_id'];
        }

        // 是否获取商品详情
        if($detail){
            $data['sendDate'] = $this->_get_receive_time($goods,true);
            if(!isset($formatData)){
                $formatData = $this->_goods_format($goods['g_id'],$goods);
                $data['format'] = $formatData['value'] ? $formatData['value'] : '';
                if(!empty($data['format']) && $data['format']){
                    $data['hasFormat'] = true;
                }
                if($data['hasFormat']){
                    $data['isVip'] = $formatData['isVip'];
                    $format_data = $this->_get_format_value($goods['g_id'],true);
                    $data['formatValue'] = $format_data['data'];
                    $data['formatValueNew'] = $format_data['newData'];

                    $formatStock = $format_data['stock'];
                    $data['stock'] = $formatStock;
                }
            }


            // 获取不同规格的价格
            $prices = $formatData['prices']?$formatData['prices']:[];
            //array_push($prices,$data['price']);
            $data['maxPrice'] = !empty($prices) && max($prices)>0 ? floatval(max($prices)) : 0;
            $data['minPrice'] = !empty($prices) && min($prices)>0 ? floatval(min($prices)) : 0;

            $oriPrices = $formatData['oriPrices']?$formatData['oriPrices']:[0];
            $data['maxOriPrice'] = max($oriPrices)>0 ? floatval(max($oriPrices)) : 0;
            $data['minOriPrice'] = min($oriPrices)>0 ? floatval(min($oriPrices)) : 0;

            $noVipPrices = $formatData['noVipPrice']?$formatData['noVipPrice']:[];
            //array_push($noVipPrices,$data['noVipPrice']);
            $data['maxNoVipPrice'] = !empty($noVipPrices) && max($noVipPrices)>0 ? floatval(max($noVipPrices)) : 0;
            $data['minNoVipPrice'] = !empty($noVipPrices) && min($noVipPrices)>0 ? floatval(min($noVipPrices)) : 0;
            $data['vipPriceList'] = $this->_get_vip_price_list($data['price'], $goods['g_vip_price_list'], $formatData['value'], $data['hasFormat']);
            if($allInfo){
                $data['coupon'] = $this->_get_coupon_list_all();
                $data['freight'] = $this->_get_postFee_show($goods);
                $data['video']  = $goods['g_video_url'] ? $goods['g_video_url']:'';
                $data['vrurl']  = $goods['g_vr_url'] ? $this->_judge_vrurl($goods['g_vr_url']):'';
                $data['parameter'] = plum_parse_img_path($goods['g_parameter']);
                //$data['detail'] = $goods['g_detail'];#plum_parse_img_path($goods['g_detail']);
                $data['detail'] = plum_parse_img_path_new($goods['g_detail']);
                $data['slide']  = $this->_goods_slide($goods['g_id']);

                if($goods['g_recommend_goods']){
                    $data['recommendGoods'] = $this->_recommend_goods_info($goods['g_recommend_goods']);
                }
                //判断商品是否被收藏
                $data['isCollect'] = $this->_is_collection_goods($goods['g_id']);

                if($data['slide']){
                    $imagesize = getimagesize($data['slide'][0]);
                    if($imagesize[0]==$imagesize[1]){
                        $data['slideSpecif'] = 1;
                    }else{
                        $data['slideSpecif'] = 0;
                    }
                }
            }
            $data['cartNum'] = intval($cartList[$goods['g_id']]['num']);

            if($data['hasFormat']){

                if(!isset($data['formatList'])){
                    $data['formatList']  = $this->_new_goods_format($goods);
                }

                $data['formatTypes'] = count($data['formatList']);
                $data['formatTypes'] = $data['formatTypes'] >=2 ? 2 : $data['formatTypes'];//列表中不需要2以上
                //将formatList中的value价格更新
                if($changeFormatPrice && $data['formatTypes'] == 1){
                    foreach ($data['format'] as $format_key => $format_row){
                        $data['format'][$format_key]['price'] = $data['formatValue'][$format_row['name']]['price'];
                    }
                }

                $weight = $formatData['weight']?$formatData['weight']:[];
                $data['maxWeight'] = $weight[0];
                $data['minWeight'] = $weight[0];
                foreach ($weight as $val){
                    $data['maxWeight'] = $val['value'] > $data['maxWeight']['value']?$val:$data['maxWeight'];
                    $data['minWeight'] = $val['value'] < $data['minWeight']['value']?$val:$data['minWeight'];
                }
                if($data['minWeight']['value'] || $data['maxWeight']['value']){
                    if($data['minWeight']['value'] && $data['maxWeight']['value'] && $data['minWeight']['value'] != $data['maxWeight']['value']){
                        $data['weight'] = ($data['minWeight']['type']==1?$data['minWeight']['value'].'g':($data['minWeight']['value']/1000).'Kg').'-'.(($data['maxWeight']['type']==1?$data['maxWeight']['value'].'g':($data['maxWeight']['value']/1000).'Kg'));
                    }else{
                        $data['weight'] = $data['minWeight']['value']?(($data['minWeight']['type']==1?$data['minWeight']['value'].'g':($data['minWeight']['value']/1000).'Kg')):(($data['maxWeight']['type']==1?$data['maxWeight']['value'].'g':($data['maxWeight']['value']/1000).'Kg'));
                    }
                }
            }

            //是否正在进行拼团
            $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
            $where = array();
            $where[] = array('name' => 'gb_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'gb_g_id', 'oper' => '=', 'value' => $goods['g_id']);
            $where[] = array('name' => 'gb_start_time', 'oper' => '<=', 'value' => $_SERVER['REQUEST_TIME']);
            $where[] = array('name' => 'gb_end_time', 'oper' => '>', 'value' => $_SERVER['REQUEST_TIME']);
            $group = $group_model->getRow($where);
            $data['gbId'] = $group['gb_id']?$group['gb_id']:0;

            //是否是单品分销商品
            $goods_deduct   = new App_Model_Goods_MysqlGoodsRatioDeductStorage($this->sid);
            $gd     = $goods_deduct->findOpenDeduct($goods['g_id']);
            $data['isDeduct'] = $gd ? 1 : 0;

            //入驻商家商品，返回商家信息
            $data['shop'] = array();
            if($goods['g_es_id']){
                if($this->applet_cfg['ac_type'] == 6){
                    $shop =  $this->_get_city_shop_info($goods['g_es_id']);
                }else{
                    $shop =  $this->_get_shop_info($goods['g_es_id']);
                }
                $data['shop'] = $shop;
            }
        }
        $data['seckill']  = 0;//是否参与秒杀活动
        if($data['minPrice'] > 0){
            $data['price'] = $data['minPrice'];
        }

        //商品分销佣金详情
        $data['deductList'] = array();
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
        $tcRow         = $three_cfg->findShopCfg();
        $round_type = intval($tcRow['tc_round_type']);
        if($this->applet_cfg['ac_type'] == 21 && $tcRow['tc_show_deduct_open']){
            $goods_deduct   = new App_Model_Goods_MysqlGoodsRatioDeductStorage($this->sid);
            $gd     = $goods_deduct->findOpenDeduct($goods['g_id']);
            if(!$gd){
                $has_buy        = $this->member['m_traded_num'];
                //获取店铺分成佣金设置
                $deduct_model   = new App_Model_Shop_MysqlDeductStorage();
                $deduct_list    = $deduct_model->fetchDeductListBySid($this->sid);
                $has_buy++;
                $range      = array_keys($deduct_list);
                sort($range, SORT_NUMERIC);//按数字来比较
                $index = 1;//提成字段索引
                foreach ($range as $val) {
                    $val = intval($val);
                    if ($has_buy < $val) {
                        break;
                    }
                    $index = $val;
                }
                $deduct = $deduct_list[$index];
                if($round_type == 1){
                    $data['deductList'] = array(
                        ceil($data['price']*$deduct['dc_0f_ratio']/100),
                        ceil($data['price']*$deduct['dc_1f_ratio']/100),
                        ceil($data['price']*$deduct['dc_2f_ratio']/100),
                        ceil($data['price']*$deduct['dc_3f_ratio']/100),
                    );
                }elseif ($round_type == 2){
                    $data['deductList'] = array(
                        floor($data['price']*$deduct['dc_0f_ratio']/100),
                        floor($data['price']*$deduct['dc_1f_ratio']/100),
                        floor($data['price']*$deduct['dc_2f_ratio']/100),
                        floor($data['price']*$deduct['dc_3f_ratio']/100),
                    );
                }else{
                    $one=floatval(sprintf('%.2f',$data['price']*$deduct['dc_0f_ratio']/100));
                    $two=floatval(sprintf('%.2f',$data['price']*$deduct['dc_1f_ratio']/100));
                    $three=floatval(sprintf('%.2f',$data['price']*$deduct['dc_2f_ratio']/100));
                    $four=floatval(sprintf('%.2f',$data['price']*$deduct['dc_3f_ratio']/100));
                    $data['deductList'] = array(
                        $one>0?$one:0,
                        $two>0?$two:0,
                        $three>0?$three:0,
                        $four>0?$four:0,
                    );
                }

            }else{
                if($round_type == 1){
                    $data['deductList'] = array(
                        ceil($data['price']*$gd['gd_0f_ratio']/100),
                        ceil($data['price']*$gd['gd_1f_ratio']/100),
                        ceil($data['price']*$gd['gd_2f_ratio']/100),
                        ceil($data['price']*$gd['gd_3f_ratio']/100),
                    );
                }elseif ($round_type == 2){
                    $data['deductList'] = array(
                        floor($data['price']*$gd['gd_0f_ratio']/100),
                        floor($data['price']*$gd['gd_1f_ratio']/100),
                        floor($data['price']*$gd['gd_2f_ratio']/100),
                        floor($data['price']*$gd['gd_3f_ratio']/100),
                    );
                }else{
                    $data['deductList'] = array(
                        round($data['price']*$gd['gd_0f_ratio']/100),
                        round($data['price']*$gd['gd_1f_ratio']/100),
                        round($data['price']*$gd['gd_2f_ratio']/100),
                        round($data['price']*$gd['gd_3f_ratio']/100),
                    );
                }
            }
        }

        if($laid>0){
            //获取限时抢购活动
            $limit_buy  = new App_Helper_LimitBuy($this->sid);
            $limit_act  = $limit_buy->checkLimitAct($goods['g_id'],$laid);

            $limit_goods    = new App_Model_Limit_MysqlLimitGoodsStorage($this->sid);
            $limit_goods->updateById(array('lg_view_num' => $limit_act['lg_view_num']+1), $limit_act['lg_id']);

            if($detail){
                $example_model = new App_Model_Limit_MysqlLimitFakeExampleStorage($this->sid);
                $example_list = $example_model->getExampleList($laid);
                $exampleData = [];
                if($example_list){
                    foreach ($example_list as $example){
                        $exampleData[] = [
                            'title' => $example['lfe_title'] ? $example['lfe_title'] : '秒杀活动',
                            'num'   => $example['lfe_num'],
                            'time'  => date('Y年m月d日',$example['lfe_time'])
                        ];
                    }
                }
                $data['fakeExampleList'] = $exampleData;
            }

            $data['limitStartTime'] = date('n月d日H:i', $limit_act['la_start_time']);
            $data['limitPrice'] = floatval($limit_act['lg_yh_price']);
            $data['limitShareImg'] = $limit_act['la_share_img'] ? $this->dealImagePath($limit_act['la_share_img']) : '';
            $data['limitShareTitle'] = $limit_act['la_share_title'] ? $limit_act['la_share_title'] : '';
            if($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_WAIT){
                $data['seckill']  = 2;
                $data['limit'] = array(
                    'id'         => $limit_act['la_id'],
                    'name'       => $limit_act['la_name'],
                    'label'      => $limit_act['la_label'],
                    'img'        => $this->dealImagePath($limit_act['la_bg_img']),
                    'startTime'  => $limit_act['la_start_time'],
                    'endTime'    => $limit_act['la_end_time'],
                    'showNum'    => $limit_act['lg_view_num'],
                    'showNumShow'=> $limit_act['lg_view_num_show'],
                );
            }

            //进行中的限时抢购活动
            if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
                $data['seckill']  = 1;
                //覆盖原有价格
                $limit_price    = floatval($limit_act['lg_yh_price']);
                $data['price']  = $limit_price;
                $data['noVipPrice']  = $limit_price;
                $data['restriction']  = intval($limit_act['lg_limit']);
                $data['purchase']   = $limit_act['lg_limit'] && $limit_act['lg_limit']>0 ? $limit_act['lg_limit'] : (isset($goods['g_limit']) && $goods['g_limit'] > 0 ? $goods['g_limit'] : $goods['g_stock']);
                $data['purchaseNote']   = isset($goods['g_limit']) && $goods['g_limit'] > 0 ? '每人限购'.$goods['g_limit'].'件' : '';
                if ($data['format']) {
                    foreach ($data['format'] as &$item) {
                        $item['price']   = $limit_price;
                    }
                    foreach ($data['formatValue'] as &$item) {
                        $item['price']   = $limit_price;
                    }
                }//若单独设置秒杀数量,取设置值,否则取库存
                $data['limitStock'] = $limit_act['lg_stock'] ? $limit_act['lg_stock'] : $goods['g_stock'];

                if($data['limitStock'] > 0){
                    if($data['purchaseNote']){
                        $data['purchaseNote'] = $data['purchaseNote']."，共{$data['limitStock']}件";
                    }else{
                        $data['purchaseNote'] = "共{$data['limitStock']}件";
                    }
                }

                $data['limit'] = array(
                    'id'         => $limit_act['la_id'],
                    'name'       => $limit_act['la_name'],
                    'label'      => $limit_act['la_label'],
                    'img'        => $this->dealImagePath($limit_act['la_bg_img']),
                    'startTime'  => $limit_act['la_start_time'],
                    'endTime'    => $limit_act['la_end_time'],
                    'showNum'    => $limit_act['lg_view_num'],
                    'showNumShow'=> $limit_act['lg_view_num_show'],
                );

                $cfg_model = new App_Model_Limit_MysqlLimitCfgStorage($this->sid);
                $limit_cfg = $cfg_model->fetchUpdateCfg();
                //活动加群设置
                $data['wxGroupData'] = array(
                    'show'   => $limit_cfg?$limit_cfg['lc_wxgroup_show']:0,
                    'title'  => $limit_cfg?$limit_cfg['lc_wxgroup_title']:'',
                    'desc'   => $limit_cfg?$limit_cfg['lc_wxgroup_desc']:'',
                    'logo'   => $limit_cfg?$this->dealImagePath($limit_cfg['lc_wxgroup_logo']):'',
                    'qrcode' => $limit_cfg?$this->dealImagePath($limit_cfg['lc_wxgroup_qrcode']):'',
                );


                $record_model   = new App_Model_Limit_MysqlLimitRecordStorage($this->sid);
                //if(($limit_act['lg_limit'] && $limit_act['lg_limit']>0) || ($limit_act['lg_stock'] && $limit_act['lg_stock']>0)){
                if($limit_act['lg_stock'] && $limit_act['lg_stock']>0 && $detail){
                    // 获取已经购买过的数量
                    $had_buy    = $record_model->countBuyNumByActid($limit_act['lg_actid'], $goods['g_id']);
                   // if($limit_act['lg_limit'] && $limit_act['lg_limit']>0){
                   //     $data['stock'] = $limit_act['lg_limit']>=$had_buy ? ($limit_act['lg_limit']-$had_buy) : 0;
                   // }else
                    if ($limit_act['lg_stock'] && $limit_act['lg_stock']>0){
                        $data['stock'] = $limit_act['lg_stock']>=$had_buy ? ($limit_act['lg_stock']-$had_buy) : 0;
                    }
                }

                if($data['hasFormat'] && $data['formatValue']){
                    $limit_format_model = new App_Model_Limit_MysqlLimitGoodsFormatStorage();
                    $prices = [$data['price']];
                    foreach ($data['formatValue'] as $key => $format){
                        //如果秒杀商品有规格，所有规格统一价格
                        /*$data['formatValue'][$key]['price'] = $limit_price;
                        if($limit_act['lg_stock']>0 && $detail){
                            //如果设置了秒杀数量，所有规格统一库存
                            $data['formatValue'][$key]['stock'] = $data['stock'];
                        }*/
                        $had_buy    = $record_model->countBuyNumByActid($limit_act['lg_actid'], $goods['g_id'], $format['id']);
                        //如果秒杀商品有规格，取规格的价格
                        $actFormat = $limit_format_model->getRowByActIdGfid($data['limit']['id'], $format['id']);
                        $data['formatValue'][$key]['price'] = $actFormat?$actFormat['lgf_yh_price']:$limit_price;
                        $data['formatValue'][$key]['stock'] = $actFormat?($actFormat['lgf_stock'] > 0 ? $actFormat['lgf_stock']-$had_buy : $data['formatValue'][$key]['stock']-$had_buy):$data['formatValue'][$key]['stock']-$had_buy;

                        // 获取不同规格的价格
                        $prices[] = $data['formatValue'][$key]['price']?$data['formatValue'][$key]['price']:0;
                    }
                    foreach ($data['formatValueNew'] as $key => $format){
                        //如果秒杀商品有规格，所有规格统一价格
                        /*$data['formatValue'][$key]['price'] = $limit_price;
                        if($limit_act['lg_stock']>0 && $detail){
                            //如果设置了秒杀数量，所有规格统一库存
                            $data['formatValue'][$key]['stock'] = $data['stock'];
                        }*/
                        $had_buy    = $record_model->countBuyNumByActid($limit_act['lg_actid'], $goods['g_id'], $format['id']);
                        //如果秒杀商品有规格，取规格的价格
                        $actFormat = $limit_format_model->getRowByActIdGfid($data['limit']['id'], $format['id']);
                        $data['formatValueNew'][$key]['price'] = $actFormat?$actFormat['lgf_yh_price']:$limit_price;
                        $data['formatValueNew'][$key]['stock'] = $actFormat?($actFormat['lgf_stock'] > 0 ? $actFormat['lgf_stock']-$had_buy : $data['formatValueNew'][$key]['stock']-$had_buy):$data['formatValueNew'][$key]['stock']-$had_buy;

                        // 获取不同规格的价格
                        $prices[] = $data['formatValueNew'][$key]['price']?$data['formatValueNew'][$key]['price']:0;
                    }
                    //array_push($prices,$data['price']);
                    $data['maxPrice'] = !empty($prices) && max($prices)>0 ? floatval(max($prices)) : 0;
                    $data['minPrice'] = !empty($prices) && min($prices)>0 ? floatval(min($prices)) : 0;
                }
            }

        }


        if($data['maxPrice']>0 && $data['minPrice']>0 && $data['maxPrice']==$data['minPrice']){
            $data['minPrice'] = 0;
            $data['maxPrice'] = 0;
        }
        return $data;
    }

    //格式化店铺信息
    private function _get_city_shop_info($esId){
        $shop_model  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        $shop     = $shop_model->getCityShopDetail($esId);
        $data = array();
        if($shop){
            $data = array(
                'id'        => intval($shop['acs_id']),
                'esId'      => intval($shop['es_id']),
                'esid'      => intval($shop['es_id']),
                'name'      => $shop['acs_name'],
                'score'     => $shop['acs_score']>0 && $shop['acs_total_score']>0 ?  round((($shop['acs_score']/$shop['acs_total_score'])*5),1) : 5,   // 星级
                'address'   => $shop['acs_address'],
                'lng'       => $shop['acs_lng'],
                'lat'       => $shop['acs_lat'],
                'mobile'    => $shop['acs_mobile'],
                'vrurl'     => $shop['acs_vr_url'] ? $this->_judge_vrurl($shop['acs_vr_url']) : '',
                'handClose' => intval($shop['es_hand_close'])
            );
        }
        return $data;
    }

    //格式化店铺信息
    private function _get_shop_info($id){
        $shop_model  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        $shop     = $shop_model->getRowByIdMemberExtra($id);
        if($shop){
            $score_desc = plum_parse_config('community_score_desc', 'system');

            if($shop['es_hand_close'] == 0){
                if($shop['es_common_business_time']){
                    $openInfo = $this->_check_shop_status($shop);
                    $openStatus  = $openInfo['openStatus'];
                    $openNote = $openInfo['openNote'];
                }else{
                    $shopOpen = $shop['es_business_time'] ?  $shop['es_business_time'] : '00:00';
                    $shopClose = $shop['es_close_time'] ? $shop['es_close_time'] : '23:59';
                    $timeNow = time();
                    $isOpen = 0;

                    $openTime = strtotime($shopOpen);
                    $closeTime = strtotime($shopClose);
                    if ($openTime >= $closeTime) {
                   // $closeTime = $closeTime + 86400;
                        //获得当天0点时间戳
                        $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                        //获得当天24点时间戳
                        $timeStep_24 = strtotime(date('Y-m-d',$timeNow)) + 86399;
                        if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow) && $timeNow <= $closeTime){
                            $isOpen = true;
                        }
                    }else{
                        if($openTime <= $timeNow && $timeNow <= $closeTime){
                            $isOpen = true;
                        }
                    }
                    if (!$isOpen) {
                        $openStatus  = 2;
                        $openNote = '已打烊';
                    }else{
                        $openStatus  = 1;
                        $openNote = '营业中';
                    }
                }
            }else{
                $openStatus  = 2;
                $openNote = '已打烊';
            }

            if($shop['es_cate1']){
                $category_model = new App_Model_Community_MysqlKindStorage($this->sid);
                $category = $category_model->getRowById($shop['es_cate1']);
                if($category){
                    $cate1_id = $shop['es_cate1'];
                    $cate1_name = $category['ack_name'];
                }else{
                    $cate1_id = 0;
                    $cate1_name = '';
                }
            }else{
                $cate1_id = 0;
                $cate1_name = '';
            }

            $data = array(
                'id'           => $shop['es_id'],
                'isMy'         => $this->member['m_id'] == $shop['es_m_id'] ? 1 : 0,
                'logo'         => $shop['es_logo'] ? $this->dealImagePath($shop['es_logo']) : '',
                'logoTrue'     => $shop['es_logo'] ? $shop['es_logo'] : '',
                'brief'        => $shop['es_brief'] ? $shop['es_brief'] : '',
                'name'         => $shop['es_name'],
                'address'      => ($shop['es_addr'] ? $shop['es_addr'] : '').($shop['es_addr_detail'] ? $shop['es_addr_detail'] : ''),
                'addressTrue'  => $shop['es_addr'] ? $shop['es_addr'] : '',
                'addressDetail' => $shop['es_addr_detail'] ? $shop['es_addr_detail'] : '',
                'firstCateId'  => $cate1_id,
                'firstCateName'=> $cate1_name,
                'lng'          => $shop['es_lng'],
                'lat'          => $shop['es_lat'],
                'mobile'       => $shop['es_phone'],
                'score'        => $shop['es_score'],
                'scoreDesc'    => $score_desc[intval($shop['es_score'])],
                'isCollection' => $this->_is_collection($shop['es_id'], 1),
                'vrurl'        => $shop['es_vr_url'] ? $this->_judge_vrurl($shop['es_vr_url']) : '',
                'showNum'      => $this->number_format($shop['es_show_num']+1),
                'isbuy'        => intval($shop['es_isbuy']),
                'limitOpen'    => intval($shop['es_limit_open']),
                'groupOpen'    => intval($shop['es_group_open']),
                'bargainOpen'  => intval($shop['es_bargain_open']),
                'handClose'    => intval($shop['es_hand_close']),
                'label'         => isset($shop['es_label']) && trim($shop['es_label']) ? preg_split("/[\s,]+/",$shop['es_label']) : '' ,//trim防止全是空格
                'openTime'     => ($shop['es_business_time'] ?  $shop['es_business_time'] : '00:00' ).'-'.($shop['es_close_time'] ? $shop['es_close_time'] : '23:59'),
                'openTimeStart'=> $shop['es_business_time'] ? $shop['es_business_time'] : '',
                'openTimeEnd'=> $shop['es_close_time'] ? $shop['es_close_time'] : '',
                'openStatus'   => $openStatus,
                'openNote'     => $openNote,
                'carNum'       => intval($shop['ame_car_num']),
                'goodsStyle'   => $shop['es_goods_style'] > 0 ? intval($shop['es_goods_style']) : 1,
                'detail'       => plum_parse_img_path($shop['es_shop_detail'])
            );

            //判断当前当前店铺，当前会员是否可认领
            $uid = plum_app_user_islogin();
            $shop_model  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
            $hadShop = $shop_model->getRowByMidSid($uid);
            $data['canClaim'] = 0;
            $data['claimId'] = 0;
            if(!$hadShop && !$shop['es_m_id']){
                $data['canClaim'] = 1;
                $claim_model = new App_Model_City_MysqlCityShopClaimStorage($this->sid);
                $claim = $claim_model->findClaimByMidShop($uid, 0, $shop['es_id']);
                $data['claimId'] = $claim?$claim['acsc_id']:0;
            }

            if($shop['es_common_business_time']){
                $data['openTime'] = $openInfo['openTime'];
            }
            return $data;
        }
        return '';
    }

    /**
     * 帖子是否收藏
     */
    public function _is_collection($id, $type){
        $num = 0;
        $collection_model = new App_Model_Community_MysqlCommunityCollectionStorage($this->sid);
        $row = $collection_model->getCollectionByMidPid($this->uid,$id, $type);
        if($row){
            $num = 1;
        }
        return $num;
    }

    //检查店铺状态
    private function _check_shop_status($shop){
        $openStatus  = 2;
        $openNote = '已打烊';
        $timeNow = time();
        $openTimeStr = '';
        if($shop['es_week'.date('w').'_business_time']){
            $timeArr = json_decode($shop['es_week'.date('w').'_business_time'], true);
            foreach ($timeArr as $time){
                $openTime = strtotime($time['open']);
                $closeTime = strtotime($time['close']);
                if($openTime <= $timeNow && $timeNow <= $closeTime){
                    $openStatus  = 1;
                    $openNote = '营业中';
                }
                $openTimeStr .= $time['open'].'-'.$time['close'].'  ';
            }
        }else{
            $timeArr = json_decode($shop['es_common_business_time'], true);
            foreach ($timeArr as $time){
                $openTimeStr .= $time['open'].'-'.$time['close'].'  ';
                $openTime = strtotime($time['open']);
                $closeTime = strtotime($time['close']);
                if($openTime <= $timeNow && $timeNow <= $closeTime){
                    $openStatus  = 1;
                    $openNote = '营业中';
                }
            }
        }
        return array('openStatus' => $openStatus, 'openNote' => $openNote, 'openTime' => $openTimeStr);
    }

    /**
     * @param $list
     * @param $format
     * @param $hasFormat
     * @return array
     * 获取vip价格列表
     */
    private function _get_vip_price_list($price, $list, $format, $hasFormat){

        $data = array();
        $level_model = new App_Model_Member_MysqlLevelStorage();

        if($hasFormat){
            $hadVipPrice = true;
            foreach ($format as $val){
                $vipPriceList = json_decode($val['vipPriceList'], true);
                if($vipPriceList){
                    foreach ($vipPriceList as $value){
                        if($value['price'] > 0){
                            $data[$value['identity']] = array(
                                'identity'  => $value['identity'],
                                'price' => $data[$value['identity']]['price']?$data[$value['identity']]['price']:array()
                            );
                            $data[$value['identity']]['price'][] = $value['price'];
                        }
                    }
                }
                if(empty($data) || !$hadVipPrice){
                    $hadVipPrice = false;
                    $level_model = new App_Model_Member_MysqlLevelStorage();
                    $level = $level_model->getListBySid($this->sid);
                    if($level){
                        foreach ($level as  $value){
                            if($value['ml_discount']){
                                $data[$value['ml_id']] = array(
                                    'identity'  => $value['ml_id'],
                                    'price' => $data[$value['ml_id']]['price']?$data[$value['ml_id']]['price']:array()
                                );
                                $data[$value['ml_id']]['price'][] = $val['price']* ($value['ml_discount']/10);
                            }
                        }
                    }
                }
            }
            if(!empty($data)){
                foreach ($data as $key => $val){
                    $level = $level_model->getRowById($val['identity']);
                    if($level){
                        $data[$key] = array(
                            'identity' => $level['ml_name'],
                            'price'    => number_format(min($val['price']), 2, ".", "").'-'.number_format(max($val['price']), 2, ".", ""),
                        );
                    }
                }
            }
        }else{
            $vipPriceList = json_decode($list, true);
            if($vipPriceList){
                foreach ($vipPriceList as $value){
                    $level = $level_model->getRowById($value['identity']);
                    if($level){
                        if($value['price'] > 0){
                            $data[$value['identity']] = array(
                                'identity'  => $level['ml_name'],
                                'price' => $value['price']
                            );
                        }
                    }
                }
            }
            if(empty($data)){
                $level_model = new App_Model_Member_MysqlLevelStorage();
                $level = $level_model->getListBySid($this->sid);
                if($level){
                    foreach ($level as  $value){
                        if($value['ml_discount']){
                            $data[$value['ml_id']] = array(
                                'identity'  => $value['ml_name'],
                                'price' => number_format( $price* ($value['ml_discount']/10), 2, ".", "")
                            );
                        }
                    }
                }
            }
        }

        return array_values($data);
    }

    /*
     * 获得展示运费
     */
    private function _get_postFee_show($goods){
        $postFee = 0;
        //获得配送配置
        $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
        $sendCfg = $send_model->findUpdateBySid(null,$goods['g_es_id']);

        if($sendCfg['acs_express_delivery'] == 0 && $sendCfg['acs_send'] == 1){
            //如果开启了商家配送且未开启快递发货 以商家配送费为准
            //基础配送费
//            $basePrice = floatval($sendCfg['acs_base_price']);
//            //计算最大配送费
//            $sendRange = floatval($sendCfg['acs_send_range']);
//            $baseLong = floatval($sendCfg['acs_base_long']);
//            $plusLong = floatval($sendCfg['acs_plus_long']);
//            $plusPrice = floatval($sendCfg['acs_plus_price']);
//            $plusDistance = $sendRange - $baseLong;
//            $num = ceil($plusDistance/$plusLong);
//            $maxFee = $basePrice + $num * $plusPrice;
//            $postFee = number_format($basePrice,2).'-'.number_format($maxFee,2);
            $postFee = $sendCfg['acs_base_price'];
        }else{
            //以商品本身运费为准
            if($goods['g_expfee_type'] == 1){
                //统一运费
                $postFee = $goods['g_unified_fee'];
            }else{
                //运费模板 取模板中的第一条的首件费用
                $city_model = new App_Model_Shop_MysqlShopDeliveryCityStorage($this->sid);
                $where[] = array('name' => 'sdc_temp_id', 'oper' => '=', 'value' =>$goods['g_unified_tpid']);
                $where[] = array('name' => 'sdc_deleted', 'oper' => '=', 'value' =>0);
                $row = $city_model->getRow($where);
                if($row){
                    $postFee = $row['sdc_first_fee'];
                }
            }
        }
        return $postFee;
    }



    //获取vip价的价格区间
    private function _get_vip_price($goods){
        if(!$goods['g_had_vip_price']){
            return 0;
        }else{
            $vipPrice = json_decode($goods['g_vip_price_list'], true);
            $priceArr = array();
            if(!empty($vipPrice)){
                foreach ($vipPrice as $val){
                    $priceArr[] = $val['price'];
                }
            }else{
                $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
                $format         = $format_model->getListByGid($goods['g_id']);
                foreach ($format as $row){
                    $vipPriceList = json_decode($row['gf_vip_price_list'], true);
                    foreach ($vipPriceList as $val){
                        $priceArr[] = $val['price'];
                    }
                }
            }
            $minPrice = min($priceArr);
            $maxPrice = max($priceArr);
            //return $minPrice;
            if($minPrice && $maxPrice && $minPrice != $maxPrice){
                return $minPrice.'-'.$maxPrice;
            }else{
                return $minPrice ? $minPrice : 0;
            }

        }
    }

    /**
     * 获取酒店提供的服务列表
     */
    private function _get_store_service($id, $type = 1){
        $service_model = new App_Model_Hotel_MysqlHotelServiceStorage($this->sid);
        $list = $service_model->findListBySid($id,$type);
        $serviceList = array();
        foreach($list as $val){
            $serviceList[] = array(
                'name' => $val['ahs_name'],
                'icon' => $this->dealImagePath($val['ahs_icon'])
            );
        }
        return $serviceList;
    }

    public function _is_collection_goods($id){
        $num = 0;
        $uid = plum_app_user_islogin();
        $collection_model = new App_Model_Goods_MysqlGoodsCollectionStorage($this->sid);
        $row = $collection_model->getRowByIdSidMid($id,$this->sid,$uid);
        if($row){
            $num = 1;
        }
        return $num;
    }

    /*
     * 获得推荐商品信息
     */
    private function _recommend_goods_info($gids = ''){
        $goodsInfo = array();
        $where     = array();
        $gidArr = json_decode($gids,1);

        if(!empty($gidArr)){
            $where[]    = array('name' => 'g_id', 'oper' => 'in', 'value' => $gidArr);
            $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' =>$this->sid);
            $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
            $g_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
            $goodsList = $g_model->getList($where,0,0,array(),array('g_id','g_name','g_cover','g_price','g_sold'));
            if($goodsList){
                foreach ($goodsList as $goods){
                    $goodsInfo[] = array(
                        'gid'   => intval($goods['g_id']),
                        'name'  => $goods['g_name'],
                        'cover'  => $this->dealImagePath($goods['g_cover']),
                        'price'  => $goods['g_price'],
                        'sold'   => $goods['g_sold'],
                    );
                }
            }
        }
        return $goodsInfo;
    }

    /**
     * 新的获取商品规格的方法
     */
    private function _new_goods_format($goods){
        if($goods['g_format_type']){
            $spec = json_decode($goods['g_format_type'], true);
            foreach($spec as $key => $val){
                foreach($val['value'] as $k=>$v){
                    $spec[$key]['value'][$k]['fIndex'] = $key;
                    $spec[$key]['value'][$k]['checked'] = false;
                    $spec[$key]['value'][$k]['noCheck'] = false;
                    $spec[$key]['value'][$k]['img'] = $v['img']?$this->dealImagePath($v['img']):$this->dealImagePath($goods['g_cover']);
                }
            }
            return $spec;
        }else{
            $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
            $format         = $format_model->getListByGid($goods['g_id']);
            $spec = [
                [
                    'name' => '规格',
                    'value' => []
                ]
            ];
            foreach($format as $key => $val){
                $spec[0]['value'][] = [
                    'fIndex' => 0,
                    'checked' => false,
                    'noCheck' => false,
                    'name' => $val['gf_name'],
                    'img'  => $this->dealImagePath($goods['g_cover'])
                ];
            }
            return $spec;
        }
    }

    /**
     * 获取商品规格数据
     */
    private function _get_format_value($gid,$stock_only=false){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format         = $format_model->getListByGid($gid);
        $data = array();
        $newData = array();
        $uid    = plum_app_user_islogin();
        $stock=0; //库存
        foreach($format as $val){
            $vipData = App_Helper_Trade::getGoodsVipPirce($val['gf_price'], $this->sid, $gid, $val['gf_id'],$uid,1);
            $data[$val['gf_name'].$val['gf_name2'].$val['gf_name3']] = [
                'id'       => $val['gf_id'],
                'price'    => $vipData['price'],
                'oriPrice' => $vipData['isVip']>0 ? $val['gf_price'] : floatval($val['gf_ori_price']),
                'stock'    => $val['gf_stock'] < 0 ? 0 : intval($val['gf_stock']),
                'newMemberPrice' => floatval($val['gf_newmember_price']),
            ];
            $newData[$val['gf_name'].($val['gf_name2']?'-':'').$val['gf_name2'].($val['gf_name3']?'-':'').$val['gf_name3']] = [
                'id'       => $val['gf_id'],
                'price'    => $vipData['price'],
                'oriPrice' => $vipData['isVip']>0 ? $val['gf_price'] : floatval($val['gf_ori_price']),
                'newMemberPrice' => floatval($val['gf_newmember_price']),
                'stock'    => $val['gf_stock'] < 0 ? 0 : intval($val['gf_stock'])
            ];
            $stock+=$val['gf_stock'];
        }
        if($stock_only){
            return [
                'data'      =>$data,
                'newData'   =>$newData,
                'stock'     =>$stock
            ];
        }else{
            return $data;
        }
    }

    /**
     * 获取商品的幻灯
     */
    private function _goods_slide($gid){
        //获取商品幻灯
        $slide_model = new App_Model_Goods_MysqlGoodsSlideStorage($this->sid);
        $slide       = $slide_model->getListByGidSid($gid, $this->sid);
        $data = array();
        if($slide){
            foreach ($slide as $val){
                $data[] = $this->dealImagePath($val['gs_path']);
            }
        }
        return $data;
    }

    /**
     * 获取商品规格
     */
    private function _goods_format($gid,$goods = []){
        //获取商品规格
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format = $format_model->getListByGid($gid);
        $data = array();
        $isVip = 0;
        if($format){
            foreach ($format as $val){
                $data['value'][] = array(
                    'id'       => $val['gf_id'],
                    'name'     => $val['gf_name'],
                    'oriPrice' => floatval($val['gf_ori_price']),
                    'price'    => $val['gf_price'],
                    'sold'     => $val['gf_sold'],
                    'stock'    => $val['gf_stock'],
                    'point'    => $val['gf_send_point'],
                    'newMemberPrice' => $val['gf_newmember_price'] > 0 ? floatval($val['gf_newmember_price']) : floatval($goods['g_date_price']),
                    'vipPriceList' => $val['gf_vip_price_list']
                );

                $uid    = plum_app_user_islogin();
                $vipData = App_Helper_Trade::getGoodsVipPirce($val['gf_price'], $this->sid, $gid, $val['gf_id'],$uid, 1);

                $data['noVipPrice'][] = $val['gf_price'];
                $data['oriPrices'][] = floatval($val['gf_ori_price']);
                $data['prices'][] = $vipData['price'];
                $data['weight'][] = array(
                    'value' => $val['gf_format_weight_type'] == 1?floatval($val['gf_format_weight']):floatval($val['gf_format_weight'] * 1000),
                    'type'  => $val['gf_format_weight_type']
                );
                if($vipData['isVip']){
                    $isVip = 1;
                }
            }
        }
        $data['isVip'] = $isVip;
        return $data;
    }

    /**
     * 获取店铺公告（废弃）
     */
    public function shopNoticeAction(){
        $notice_storage     = new App_Model_Shop_MysqlShopNoticeStorage($this->sid);
        $notice     = $notice_storage->fetchNoticeShowList();
        if($notice){
            foreach ($notice as $val){
                $info['data'][] = array(
                    'title' => $val['sn_title'],
                    'brief' => $val['sn_brief'],
                    'img'   => isset($val['sn_img']) ? $this->dealImagePath($val['sn_img']) : '',
                    'time'  => date('Y-m-d',$val['sn_create_time']),
                );
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('该店铺暂未发布通知公告');
        }
    }


    /**
     * 获取店铺公告新
     */
    public function newShopNoticeAction(){
        $notice_storage     = new App_Model_Shop_MysqlShopNoticeStorage($this->sid);
        $notice     = $notice_storage->fetchNoticeShowNew();
        if($notice){
            $info['data'] = array(
                'title'     => $notice['sn_title'],
                'brief'     => isset($notice['sn_brief']) ? $notice['sn_brief'] : '',
                'img'       => isset($notice['sn_img']) ? $this->dealImagePath($notice['sn_img']) : '',
                'time'      => date('Y-m-d',$notice['sn_create_time']),
                'content'   => isset($notice['sn_content']) ? plum_parse_img_path($notice['sn_content']) : ''
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('该店铺暂未发布通知公告');
        }
    }

    /**
     * 手风琴折叠分类（获取商品分类）
     */
    public function categoryListAction() {
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
        $independent = $this->request->getIntParam('independent',0);
        $kind1      = $kind_model->getFirstCategory(0, 50,true,$independent);//获取最多50个一级分类
        if($kind1){
            $kind2_data = $this->_get_shop_son_category($independent);
            $info = array();
            foreach ($kind1 as $item){
                if($item['sk_name']){
                    $info['data'][] = array(
                        'id'            => $item['sk_id'],
                        'name'          => $item['sk_name'],
                        'logo'          => $item['sk_logo'] && $item['sk_logo_show'] ? $this->dealImagePath($item['sk_logo']) : '',
                        'logoShow'      => intval($item['sk_logo_show']),
                        'subordinate'   => isset($kind2_data[$item['sk_id']]) ? $kind2_data[$item['sk_id']] : array(),
                    );
                }

            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('暂未添加分类');
        }

    }

    // 获取一个店铺的所有二级分类
    private function _get_shop_son_category($independent = 0){
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
        // 获取店铺的所有二级分类
        $kind2 = $kind_model->getAllSonCategorySortAsc(0,0,true,$independent);
        $kind2_data = array();
        foreach ($kind2 as $val){
            if($val['sk_name']){
                $kind2_data[$val['sk_fid']][] = array(
                    'id'        => $val['sk_id'],
                    'name'      => $val['sk_name'],
                    'logo'      => $this->dealImagePath($val['sk_logo']),
                );
            }
        }
        return $kind2_data;
    }
    /**
     * 获取商品分类和对应商品
     */
    private function _get_shop_category_good(){
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);

        // 获取店铺的所有二级分类
        $kind2 = $kind_model->getAllSonCategory(0,0,true);
        $info = array();
        if($kind2){
            foreach ($kind2 as $val){
                $where             = array();
                $where[]           = array('name'=>'g_s_id','oper'=>'=','value'=>$this->sid);
                $where[]           = array('name' => 'g_is_sale', 'oper' => '=', 'value' =>1);
                $where[]           = array('name'=>'g_kind2','oper'=>'=','value'=>$val['sk_id']);
                $sort              = array('g_weight'=>'DESC','g_update_time' => 'DESC');
                $goodsList       = $goods_storage->getList($where,0,6,$sort);
                $data = array();
                if($goodsList){
                    foreach ($goodsList as $v){
                        $data[] = array(
                            'id'         => $v['g_id'],
                            'name'       => $v['g_name'],
                            'cover'      => isset($v['g_cover']) ? $this->dealImagePath($v['g_cover']) : '',
                            'price'      => floatval($v['g_price']),
                            'oriPrice'   => floatval($v['g_ori_price']),
                            'brief'      => isset($v['g_brief']) ? $v['g_brief'] : '',
                            'listLabel'  => $v['g_list_label']
                        );
                    }
                }
                $info[] = array(
                    'id'        => $val['sk_id'],
                    'name'      => $val['sk_name'],
                    'list'      => $data,
                );
            }
        }
        return $info;
    }

    /**
     * 专用48模板-酒水专用
     * 获取对应一级下
     */
    private function _get_kind2_goods_data($tpl){
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->sid);
        $kind_list = $kind_model->fetchKindShowList($tpl);//此时获取的是一级分类
        $data = array();
        if($kind_list){
            foreach ($kind_list as $val){
                $data[] = array(
                    'id'    => $val['amk_id'],
                    'name'  => $val['amk_name'],
                    'link'  => $val['amk_link'],
                    'img'   => isset($val['amk_img']) && $val['amk_img'] ? $this->dealImagePath($val['amk_img']) : ($this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo']) : ''),
                    'kindData' => $this->_get_kind2_goods_data_detail($val['amk_link']),
                );
            }
        }
        return $data;
    }
    /**
     * 获取二级的列表和二级下的推荐商品--酒水使用
     */
    private function _get_kind2_goods_data_detail($kind1){
        $kind_model = new App_Model_Shop_MysqlKindStorage($this->sid);
        $kind = $kind_model->getRowById($kind1);
        if($kind['sk_level'] == 2){
            $kind2[] = $kind;
        }else{
            $kind2      = $kind_model->getSonsByFid($kind1,0,20,true);//获取最多50个一级分类
        }
        $data       = array();
        if($kind2){
            foreach ($kind2 as $val){
                $data[] = array(
                    'link'  => $val['sk_id'],
                    'name'  => $val['sk_name'],
                    'img'   => $val['sk_logo']?$this->dealImagePath($val['sk_logo']):'',
                    'goods' => $this->_get_goods_by_kind2($val['sk_id'])
                );
            }
        }
        return $data;
    }
    /**
     * 获取类目下的推荐商品--酒水使用
     */
    private function _get_goods_by_kind2($kind2){
        $data         =  array();
        $sort = array('g_is_top'=>'DESC','g_update_time'=>'DESC');
        $goods_model  =  new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $list         =  $goods_model->fetchTopShopGoodsList(0,20,$sort,$top = 0,0,$kind2);
        if($list){
            foreach($list as $val){
                $data[] = array(
                    'id'   => $val['g_id'],
                    'name' => $val['g_name']?$val['g_name']:'商品名称',
                    'oldPrice'  => floatval($val['g_ori_price']),
                    'newPrice'  => floatval($val['g_price']),
                    'cover'     => $val['g_cover']?$this->dealImagePath($val['g_cover']):'',
                    'listLabel'  => $val['g_list_label']
                );
            }
        }
        return $data;
    }
    /**
     * 获取店铺赠送的优惠券列表
     */
    private function _get_coupont_list($uid){
        if($uid){
            $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
            $coupon = $coupon_model->fetchShowValidList($this->sid,0,0);
            // 获取已经领取的优惠券
            $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
            $myCoupon = $receive_model->fetchCouponList($this->sid,$uid);
            $list   = array();
            foreach ($coupon as $key => $value) {
                //如果领过了
                if(isset($myCoupon[$value['cl_id']])){
                    unset($coupon[$key]);
                }else{
                    //若优惠券还未领完 赠送一张
                    if($value['cl_had_receive'] < $value['cl_count']) {
                        /*$indata = [
                            'cr_s_id' => $this->sid,
                            'cr_m_id' => $uid,
                            'cr_c_id' => $value['cl_id'],
                            'cr_receive_time' => time(),
                            'cr_expire_time'  => $value['cl_use_time_type'] == 1?$value['cl_use_end_time']:strtotime("+".$value['cl_use_days']." days"),
                        ];
                        $receive_model->insertValue($indata);
                        //设置领取量+1
                        $coupon_model->incrementReceiveCount($value['cl_id'], 1);*/
                        $list[] = [
                            'id' => $value['cl_id'],
                            'name' => $value['cl_name'],
                            'value' => $value['cl_face_val'],
                            'limit' => $value['cl_use_limit'],
                            'count' => $value['cl_count'],
                            'receive' => $value['cl_had_receive'],
                            'desc' => $value['cl_use_desc'],
                            'start' => date('Y-m-d', $value['cl_start_time']),
                            'end' => date('Y-m-d', $value['cl_end_time']),
                        ];
                    }
                }
            }
            return $list;
        }else{
            $this->outputError('获取用户信息失败');
        }

    }

    /*
     * 无脑获得全部理论可用优惠券
     */
    private function _get_coupon_list_all(){
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $coupon = $coupon_model->fetchShowValidList($this->sid,0,0);
        $list = array();
        if($coupon){
            foreach ($coupon as $key => $value) {
                $list[] = [
                    'id' => $value['cl_id'],
                    'name' => $value['cl_name'],
                    'value' => $value['cl_face_val'],
                    'limit' => $value['cl_use_limit'],
                    'count' => $value['cl_count'],
                    'receive' => $value['cl_had_receive'],
                    'desc' => $value['cl_use_desc'],
                    'start' => date('Y-m-d', $value['cl_start_time']),
                    'end' => date('Y-m-d', $value['cl_end_time']),
                ];
            }
        }
        return $list;
    }

    /**
     * 商品分享海报
     */
    public function goodsSharePosterAction(){
        $id = $this->request->getIntParam('id');
        $appid = $this->request->getStrParam('appid');
        $uid  = plum_app_user_islogin();
        //获取分身小程序信息
        $child_cfg = new App_Model_Applet_MysqlChildStorage();
        $child = $child_cfg->fetchUpdateWxcfgByAid($appid);
        $params = array(
            'id'  => $id,
            'mid' => $uid,
            'sid' => $this->sid,
            'childAppid'=> $child?$appid:'',
            'appType' => $this->appletType,
            'suid' => $this->suid,
            'acType' => $this->applet_cfg['ac_type']
        );
		 Libs_Log_Logger::outputLog($params,'share.log');
        $shareImg = App_Helper_SharePoster::generateSharePoster('seckillShare', $params);

        $info['data'] = array(
            'shareImg' => $this->dealImagePath($shareImg)
        );
        $this->outputSuccess($info);
    }

    /*
     * 获取商品详情海报
     */
    public function goodsDetailsPosterAction(){
        $gid = $this->request->getStrParam('gid');   //商品id
        $laid = $this->request->getStrParam('laid');   //秒杀活动id
        $type = $this->request->getStrParam('type','good');   //商品类型；good普通商品，seckill秒杀商品，group拼团商品，shop多店
        if($gid && ($type=='good' || $type=='seckill' || $type=='shop')){
            //获取店铺商品
            $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
            $goods = $goods_model->getRowById($gid);
            if($goods){
                $goods_deduct   = new App_Model_Goods_MysqlGoodsRatioDeductStorage($this->sid);
                $gd     = $goods_deduct->findOpenDeduct($goods['g_id']);
                $info['data'] = array(
                    'id'         => $goods['g_id'],
                    'name'       => $goods['g_name'],
                    'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover'],true) : '',
                    'price'      => floatval($goods['g_price']),
                    'shopName'   => $this->shop['s_name'],
                    'profit'     => $gd?($goods['g_price'] * $gd['grd_1f_ratio']/100):0,
                    'shopLogo'   => isset($this->shop['s_logo']) && $this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo'],true) : $this->applet_cfg['ac_avatar'],
                    'shareDesc'  => $goods['g_name'], #'我挺喜欢的宝贝，分享给你，进来看看还能领优惠券哦~'
                );

                if(!$laid){
                    //获取正在进行中的抢购商品数组
                    $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->sid);
                    $act_goods= $act_model->getAllRunningGoodsAct();
                    foreach($act_goods as $value){
                        if($goods['g_id'] == $value['lg_g_id']){
                            $laid = $value['la_id'];
                        }
                    }
                }

                if($laid > 0){
                    $limit_buy  = new App_Helper_LimitBuy($this->sid);
                    $limit_act  = $limit_buy->checkLimitAct($goods['g_id'],$laid);
                    $limit_price    = floatval($limit_act['lg_yh_price']);
                    $price = $limit_price;
                    $formatData = $this->_goods_format($goods['g_id']);
                    if($formatData){
                        $formatValue = $this->_get_format_value($goods['g_id']);
                        if($formatValue){
                            $prices = [$limit_price];
                            $limit_format_model = new App_Model_Limit_MysqlLimitGoodsFormatStorage();
                            foreach ($formatValue as $key => $format){
                                // 获取不同规格的价格
                                $actFormat = $limit_format_model->getRowByActIdGfid($limit_act['la_id'], $format['id']);
                                $prices[] = $actFormat?$actFormat['lgf_yh_price']:$limit_price;
                            }
                            $price = !empty($prices) && min($prices)>0 ? floatval(min($prices)) : 0;
                        }
                    }
                    $info['data']['price']  = $price;
                }

                if($this->applet_cfg['ac_type'] == 27){
                    $info['data']['qrcode'] = isset($goods['g_qrcode']) && $goods['g_qrcode'] ? $this->dealImagePath($goods['g_qrcode'],true) : $this->dealImagePath($this->_create_knowpay_qrcode($gid,$laid,$type),true);
                    //$info['data']['qrcode'] = $info['data']['shopLogo'];
                }elseif ($this->applet_cfg['ac_type'] == 6 && $type=='shop'){
                    $shop_storage       = new App_Model_Entershop_MysqlEnterShopStorage();
                    $enterShop = $shop_storage->getRowById($goods['g_es_id']);
                    $info['data']['qrcode'] = isset($goods['g_qrcode']) && $goods['g_qrcode'] ? $this->dealImagePath($goods['g_qrcode'],true) : $this->dealImagePath($this->_create_city_shop_goods_qrcode($gid, $enterShop['es_logo']),true);
                }else{
                    //$info['data']['qrcode'] = isset($goods['g_qrcode']) && $goods['g_qrcode'] ? $this->dealImagePath($goods['g_qrcode'],true) : $this->dealImagePath($this->_create_qrcode($gid,$laid,$type, $info['data']['cover']),true);
                    $info['data']['qrcode'] =  $this->dealImagePath($this->_get_share_code($gid,$laid,$type, $info['data']['cover'],$goods['g_independent_mall']), true);
                }
                $this->outputSuccess($info);
            }else{
                $this->outputError('商品不存在或已被删除');
            }
        }elseif($gid && $type=='house'){
            $resources_model = new App_Model_Resources_MysqlResourcesStorage();
            $resources = $resources_model->getRowById($gid);
            if($resources) {
                $info['data'] = array(
                    'id'         => $resources['ahr_id'],
                    'name'       => $resources['ahr_title'],
                    'price'      => $resources['ahr_price'],
                    'shareDesc'  => $resources['ahr_content'],
                    'cover'      => isset($resources['ahr_cover']) ? $this->dealImagePath($resources['ahr_cover'],true) : '',
                    'shopName'   => $this->shop['s_name'],
                    'shopLogo'   => isset($this->shop['s_logo']) && $this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo'],true) : $this->applet_cfg['ac_avatar'],
                );
                $info['data']['qrcode'] = isset($resources['ahr_qrcode']) && $resources['ahr_qrcode']? $this->dealImagePath($resources['ahr_qrcode'], true) : $this->dealImagePath($this->_creat_house_share_code($gid), true);
                $this->outputSuccess($info);
            }else{
                $this->outputError('房源不存在或已被删除');
            }
        }elseif($gid && $type=='group'){
            if($this->applet_cfg['ac_type'] != 12){
                $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
                $detail     = $group_model->fetchGroupGoods($gid);
                $info['data'] = array(
                    'id'         => $detail['gb_id'],
                    'name'       => $detail['g_name'],
                    'cover'      => isset($detail['g_cover']) ? $this->dealImagePath($detail['g_cover'],true) : '',
                    'price'      => floatval($detail['gb_price']),
                    'shopName'   => $this->shop['s_name'],
                    'shopLogo'   => isset($this->shop['s_logo']) && $this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo'],true) : $this->applet_cfg['ac_avatar'],
                    'shareDesc'  => isset($detail['gb_share_desc']) && $detail['gb_share_desc'] ? $detail['gb_share_desc'] : $detail['gb_share_title']
                );
            }else{
                $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
                $detail     = $group_model->fetchGroupCourse($gid);
                $info['data'] = array(
                    'id'         => $detail['gb_id'],
                    'name'       => $detail['atc_title'],
                    'cover'      => isset($detail['atc_cover']) ? $this->dealImagePath($detail['atc_cover'],true) : '',
                    'price'      => floatval($detail['gb_price']),
                    'shopName'   => $this->shop['s_name'],
                    'shopLogo'   => isset($this->shop['s_logo']) && $this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo'],true) : $this->applet_cfg['ac_avatar'],
                    'shareDesc'  => isset($detail['gb_share_desc']) && $detail['gb_share_desc'] ? $detail['gb_share_desc'] : $detail['gb_share_title']
                );
            }

            if($this->appletType == 5){
                if($detail['gb_weixin_share_qrcode']){
                    $info['data']['qrcode'] = $this->dealImagePath($detail['gb_weixin_share_qrcode'],true);
                }else{
                    $qrcode = $this->_create_weixin_group_qrcode($gid,$this->sid,$this->suid,$this->applet_cfg['ac_type']);
                    $info['data']['qrcode'] = $this->dealImagePath($qrcode,true);
                }
            }else{
                if($this->applet_cfg['ac_type'] == 27){
                    $info['data']['qrcode'] = isset($detail['gb_share_qrcode']) && $detail['gb_share_qrcode'] ? $this->dealImagePath($detail['gb_share_qrcode'],true) : $this->dealImagePath($this->_create_knowpay_group_qrcode($gid),true);
                    //知识付费，页面路径不一样
                    $info['data']['qrcode'] = $info['data']['shopLogo'];
                }elseif ($this->applet_cfg['ac_type'] == 18){
                    //预约版，页面路径不一样
                    $info['data']['qrcode'] = isset($detail['gb_share_qrcode']) && $detail['gb_share_qrcode'] ? $this->dealImagePath($detail['gb_share_qrcode'],true) : $this->dealImagePath($this->_create_reserve_group_qrcode($gid),true);
                }else{
                    $info['data']['qrcode'] = isset($detail['gb_share_qrcode']) && $detail['gb_share_qrcode'] ? $this->dealImagePath($detail['gb_share_qrcode'],true) : $this->dealImagePath($this->_create_group_qrcode($gid),true);
                }
            }

            $this->outputSuccess($info);
        }elseif ($gid && $type=='news'){
            $information_model = new App_Model_Applet_MysqlAppletInformationStorage();
            $information = $information_model->getRowByIdSid($gid,$this->sid);

            if($information['ai_cover']){
                //判断资讯封面图是否为外部链接
                $str="/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/";
                if (!preg_match($str,$information['ai_cover'])){
                    $coverPath = $this->dealImagePath($information['ai_cover'],true);
                }else{
                    //外部链接 下载并保存图片
                    $download = $this->_download_article_image($information['ai_cover']);
                    $information_model->updateById(array('ai_cover'=>$download),$gid);
                    $coverPath = $this->dealImagePath($download,true);
                }
            }else{
                $coverPath = '';
            }
            $info['data'] = array(
                'id' => $information['ai_id'],
                'name' => $information['ai_title'],
                'cover' => $coverPath,
                'shopName'   => $this->shop['s_name'],
                'shopLogo'   => isset($this->shop['s_logo']) && $this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo'],true) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_200_200.png',true),
                'shareDesc'  => $information['ai_title'],
            );
            // && file_exists(PLUM_DIR_ROOT.$information['ai_qrcode'])
            // && getimagesize($this->dealImagePath($information['ai_qrcode'],true))

            if($information['ai_qrcode'] && getimagesize($this->dealImagePath($information['ai_qrcode'],true))){

                $info['data']['qrcode'] = $this->dealImagePath($information['ai_qrcode'],true);
            }else{
                $information_model = new App_Model_Applet_MysqlAppletInformationStorage();
                $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->sid);
                $str = "id=".$information['ai_id'];
                $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::INFORMATION_DETAIL, 210, '');
                $info['data']['qrcode'] = $this->dealImagePath($url,true);

                $information_model->updateById(array('ai_qrcode'=>$url),$information['ai_id']);
            }
            $this->outputSuccess($info);
        } else{
            $this->outputError('参数错误，请稍后重试');
        }
    }

    /**
     * 生成房源二维码
     */
    private function _creat_house_share_code($id){
        $resources_model = new App_Model_Resources_MysqlResourcesStorage();
        $client_plugin   = new App_Plugin_Weixin_WxxcxClient($this->sid);
        $str = "id=".$id;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::HOUSE_DETAIL_CODE_PATH, 210);
        $updata = array('ahr_qrcode'=>$url);
        $resources_model->updateById($updata,$id);
        return $url;
    }

    private function _download_article_image($img){
        list($usec, $sec) = explode(" ", microtime());
        $md5        = strtoupper(md5($usec.$sec));
        $name   = substr($md5, 0, 8).'-'.substr($md5, 10, 4).'-'.mt_rand(1000, 9999).'-'.substr($md5, 20, 12);
        $filename = PLUM_DIR_UPLOAD. '/depot/thumbnail/'.$name.'.png';
        $filepath = PLUM_PATH_UPLOAD . '/depot/thumbnail/'.$name.'.png';
        if(!file_exists($filename)){
            $hander = curl_init();
            $fp = fopen($filename,'wb');
            curl_setopt($hander,CURLOPT_URL,$img);
            curl_setopt($hander,CURLOPT_FILE,$fp);
            curl_setopt($hander,CURLOPT_HEADER,0);
            curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($hander,CURLOPT_TIMEOUT,60);
            curl_exec($hander);
            curl_close($hander);
            fclose($fp);
            //数据同步操作
            try {
                $sync = new Libs_Image_DataSync();
                $sync->pushQueue($filepath);
            } catch (Exception $e) {
                Libs_Log_Logger::outputLog($e->getMessage().':'.$filepath, 'imgsrc.log');
            }
        }
        return $filepath;
    }

    /**
     * 获取商品的分享二维码（不同的用户二维码不一样）
     */
    private function _get_share_code($gid, $laid, $type, $cover,$independent = 0){
        $uid    = plum_app_user_islogin();
        $code_model = new App_Model_Goods_MysqlGoodsCodeStorage($this->sid);
        $code = $code_model->getCodeByGidMid($gid, $uid);
        if(!$code['agc_code']) {
            return $this->_create_new_qrcode($gid,$laid,$type, $cover,$independent);
        }else{
            return $code['agc_code'];
        }
    }


    /**
     * 生成商品二维码
     * $id : 商品id
     * $laid : 秒杀商品id
     * ￥type : 商品类型；good普通商品，seckill秒杀商品，group拼团商品，shop多店
     */
    private function _create_new_qrcode($id,$laid=0,$type='good', $cover,$independent = 0){
        $uid    = plum_app_user_islogin();
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->sid);
        if($type && $type=='shop'){
            $str = "id=".$id.'&mid='.$uid;
            $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::SHOP_GOODS_DETAILS_PATH, 210, $cover);
        }elseif (in_array($this->applet_cfg['ac_type'],[4,7]) && $independent == 1){
            $str = "id=".$id.'&mid='.$uid;
            $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::MEAL_MALL_GOODS_DETAIL, 210, $cover);
        }else{
            $str = "id=".$id.'&laid='.$laid.'&mid='.$uid;
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member   = $member_storage->getRowById($uid);
            $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::GOODS_DETAIL_CODE_PATH, 210, $member['m_avatar']?$member['m_avatar']:$cover);
        }
        if($url){
            $data = array(
                'agc_s_id' => $this->sid,
                'agc_g_id' => $id,
                'agc_m_id' => $uid,
                'agc_code' => $url,
                'agc_create_time' => time()
            );
            $code_model = new App_Model_Goods_MysqlGoodsCodeStorage($this->sid);
            $code_model->insertValue($data);
        }
        return $url;
    }

    /**
     * 获取商品的分享二维码（不同的用户二维码不一样）
     */
    private function _get_group_share_code($gid){
        $uid    = plum_app_user_islogin();
        $code_model = new App_Model_Goods_MysqlGoodsCodeStorage($this->sid);
        $code = $code_model->getCodeByGroupIdMid($gid, $uid);
        if(!$code['agc_code']) {
            return $this->_create_new_group_qrcode($gid);
        }else{
            return $code['agc_code'];
        }
    }

    /**
     * 生成拼团二维码
     */
    private function _create_new_group_qrcode($gbid){
        $uid    = plum_app_user_islogin();
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->sid);
        $str = "goodid=".$gbid.'&mid='.$uid;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::GROUP_DETAIL_CODE_PATH, 210);
        $data = array(
            'agc_s_id' => $this->sid,
            'agc_group_id' => $gbid,
            'agc_m_id' => $uid,
            'agc_code' => $url,
            'agc_create_time' => time()
        );
        $code_model = new App_Model_Goods_MysqlGoodsCodeStorage($this->sid);
        $code_model->insertValue($data);
        return $url;
    }

    /**
     * 生成商品二维码
     * $id : 商品id
     * $laid : 秒杀商品id
     * ￥type : 商品类型；good普通商品，seckill秒杀商品，group拼团商品，shop多店
     */
    private function _create_qrcode($id,$laid=0,$type='good', $cover){
        $good_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->sid);
        if($type && $type=='shop'){
            $str = "id=".$id;
            $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::SHOP_GOODS_DETAILS_PATH, 210, $cover);
        }else{
            $str = "id=".$id.'&laid='.$laid;
            $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::GOODS_DETAIL_CODE_PATH, 210, $cover);
        }
        $updata = array('g_qrcode'=>$url);
        $good_model->updateById($updata,$id);
        return $url;
    }

    /**
     * 生成拼团二维码
     */
    private function _create_group_qrcode($gbid){
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->sid);
        $str = "goodid=".$gbid;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::GROUP_DETAIL_CODE_PATH, 210);
        $updata = array('gb_share_qrcode'=>$url);
        $group_model->updateById($updata,$gbid);

        return $url;
    }

    /**
     * 生成拼团二维码
     */
    private function _create_reserve_group_qrcode($gbid){
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->sid);
        $str = "goodid=".$gbid;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::RESERVE_GROUP_DETAIL_CODE_PATH, 210);
        $updata = array('gb_share_qrcode'=>$url);
        $group_model->updateById($updata,$gbid);

        return $url;
    }

    /**
     * 生成商品二维码
     * $id : 商品id
     * $laid : 秒杀商品id
     * ￥type : 商品类型；good普通商品，seckill秒杀商品，group拼团商品，shop多店
     */
    private function _create_knowpay_qrcode($id,$laid=0,$type='good'){
        $good_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->sid);
        $goods = $good_model->getRowById($id);

        $str = "id=".$id.'&laid='.$laid;
        if($goods['g_knowledge_pay_type'] == 1){
            $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::KNOWPAY_ARTICLE_CODE_PATH, 210);
        }

        if($goods['g_knowledge_pay_type'] == 2){
            $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::KNOWPAY_AUDIO_CODE_PATH, 210);
        }

        if($goods['g_knowledge_pay_type'] == 3){
            $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::KNOWPAY_VIDEO_CODE_PATH, 210);
        }

        $updata = array('g_qrcode'=>$url);
        $good_model->updateById($updata,$id);
        return $url;
    }

    /**
     * 生成拼团二维码
     */
    private function _create_knowpay_group_qrcode($gbid){
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->sid);
        $str = "id=".$gbid;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::KNOWPAY_GROUP_CODE_PATH, 210);
        $updata = array('gb_share_qrcode'=>$url);
        $group_model->updateById($updata,$gbid);
        return $url;
    }

    /**
     * 生成公众号拼团二维码
     */
    private function _create_weixin_group_qrcode($id, $sid, $suid, $acType){
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
        if($acType == 27){
            $text = plum_parse_config('weixin_index','weixin')[$acType]."?suid={$suid}&appletType=5&share=/GroupDetail?id=".$id;
        }else{
            $text = plum_parse_config('weixin_index','weixin')[$acType]."?suid={$suid}&appletType=5&share=/GroupGoodDetail?goodid=".$id;
            //http://www.ykuaiqian.com/mobile/city/index?appletType=5&suid=fieipckkqx&share=/GroupGoodDetail?goodid=3?refer_mid=135
        }

        $url = $this->_get_qrcode_png_url($text);
        if($url){
            $updata = array('gb_weixin_share_qrcode'=>$url);
            $res = $group_model->updateById($updata,$id);
            if($res){
                return $url;
            }else{
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }
    /**
     * @param $text
     * @return string
     * 生成微信公众号二维码
     */
    private function _get_qrcode_png_url($text){
        //生成图片存储实际路径
        $hold_dir = PLUM_APP_BUILD.'/spread/';
        //生成图片访问路径
        $access_path = PLUM_PATH_PUBLIC.'/build/spread/';

        $filename = plum_uniqid_base36(true).".png";
        Libs_Qrcode_QRCode::png($text,$hold_dir.$filename, 'Q', 6, 1);
        $url = $access_path.$filename;
        $path = $path = plum_get_base_host() . '/' . ltrim($url, '/');
        $urlVerify = getimagesize($path);  // 验证二维码是否存现
        if(!$urlVerify){
            $url = '';
        }
        return $url;
    }


    /*
     * 生成同城多店二维码
     */
    private function _create_city_shop_goods_qrcode($id, $cover){
        $good_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->sid);
        $str = "id=".$id;
        //$goods = $good_model->getRowById($id);
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::CITY_SHOP_GOODS_DETAIL, 210, $cover);
        $updata = array('g_qrcode'=>$url);
        $good_model->updateById($updata,$id);
        return $url;
    }


    /*
     * 获得全部一级分类及对应商品
     */
    public function firstKindGoodsAction(){

        $uid = plum_app_user_islogin();
        $cate     =  $this->request->getIntParam('cate');
        //$secondCate = $this->request->getIntParam('secondCate');
        $page     = $this->request->getIntParam('page');
        $index    = $page*$this->count;
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $data = array();
        $kinds = array();
        $cartData = array();
        //$secondKind = array();
        $total = 0;
        // 获取店铺的所有一级级分类
        $kind1 = $kind_model->getAllFirstCategory(0,0,true);
        if(!empty($kind1)){
            foreach ($kind1 as $val){
                if($val['sk_name']){
                    $kinds[] = array(
                        'id'        => $val['sk_id'],
                        'name'      => $val['sk_name'],
                    );
                }

            }
        }
        $data['data']['category']=$kinds;
        $where             = array();
        $where_cart        = array();
        $where[] = $where_cart[]  = array('name'=>'g_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = $where_cart[]  = array('name' => 'g_is_sale', 'oper' => '=', 'value' =>1);
        $sort              = array('g_weight'=>'DESC','g_update_time' => 'DESC');
        if($cate){
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$cate);
        }else{
            $firstKind1=reset($kind1);
            $cate = $firstKind1['sk_id'];
//            $data['data']['defaultId']=$firstKind1['sk_id'];
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$cate);
        }




        $where[] = array('name' => 'g_applay_goods_show', 'oper' => '=', 'value' => 1);  //前台列表不显示的过滤掉
        $where[] = array('name' => 'g_type', 'oper' => 'in', 'value' => [1,2]);  //只展示一般商品，除去积分、预约
        $goodsList         = $goods_storage->getList($where,$index, $this->count,$sort);
        $goods = array();
        //获得用户购物车信息
        $cart_storage = new App_Model_Shop_MysqlShopCartStorage($this->sid);
        $where_cart[]  = array('name'=>'sc_m_id','oper'=>'=','value'=>$uid);
        $cartList = $cart_storage->getGoodsCountSum($where_cart,0,0);
        if($cartList){
            foreach ($cartList as $value){
                $cartData[$value['g_id']] = array(
                    'num' => $value['total'],
                    'gid' => $value['g_id'],
                    'id'  => $value['sc_id']
                );
                $total += $value['total'];
            }
        }


        if($goodsList) {
            foreach ($goodsList as $v) {
                $goods[] = $this->_format_goods_details($v,true,0,false,$cartData,true);
            }
        }
        $data['data']['goods'] = $goods;
        //$data['data']['secondCategory'] = $secondKind;
        $data['data']['cartNum'] = $total;
        $this->outputSuccess($data);

    }

    public function categoryGoodsListAction(){
        $uid = plum_app_user_islogin();
        $cate           = $this->request->getIntParam('cate');
        $secondCate     = $this->request->getIntParam('secondCate');
        $page           = $this->request->getIntParam('page');
        $independent    = $this->request->getIntParam('independent',0); 
        $index    = $page*$this->count;
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $data = array();
        $kinds = array();
        $cartData = array();
        $secondKind = array();
        $total = 0;
        // 获取店铺的所有一级级分类
        $kind1 = $kind_model->getAllFirstCategory(0,0,true,$independent);
        if(!empty($kind1)){
            foreach ($kind1 as $val){
                if($val['sk_name']){
                    $kinds[] = array(
                        'id'        => $val['sk_id'],
                        'name'      => $val['sk_name'],
                    );
                }
            }
        }
        $data['data']['category']=$kinds;
        $where             = array();
        $where_cart        = array();
        $where[] = $where_cart[]  = array('name'=>'g_s_id','oper'=>'=','value'=>$this->sid);

        $sort              = array('g_weight'=>'DESC','g_update_time' => 'DESC');

        if($cate){
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$cate);
        }else{
            $firstKind1=reset($kind1);
            $cate = $firstKind1['sk_id'];
            $where[] = array('name'=>'g_kind1','oper'=>'=','value'=>$cate);
        }
        //获得对应二级分类
        $second_cate = $kind_model->getSonsByFid($cate,0,100,true,$independent);
        if(!empty($second_cate)){
            foreach ($second_cate as $sec_val){
                if($sec_val['sk_name']){
                    $secondKind[] = [
                        'id' => $sec_val['sk_id'],
                        'name' => $sec_val['sk_name']
                    ];
                }

            }
        }

        if($secondCate){
            $where[] = array('name'=>'g_kind2','oper'=>'=','value'=>$secondCate);
        }else{
            $secondCate = $secondKind[0]['id'] ? $secondKind[0]['id'] : 0;
            $where[] = array('name'=>'g_kind2','oper'=>'=','value'=>$secondCate);
        }

        $where[] = array('name' => 'g_applay_goods_show', 'oper' => '=', 'value' => 1);  //前台列表不显示的过滤掉
        $where[] = array('name' => 'g_type', 'oper' => 'in', 'value' => [1,2]);  //只展示一般商品，除去积分、预约
        if($this->applet_cfg['ac_type'] != 32 && $this->applet_cfg['ac_type'] != 36){
            $where[] = $where_cart[]  = array('name' => 'g_is_sale', 'oper' => '=', 'value' =>1);
        }else{
            $where[] = $where_cart[]  = array('name' => 'g_is_sale', 'oper' => 'in', 'value' =>[1,3]);
        }

        $uid = plum_app_user_islogin();
        $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
        $extra = $extra_model->findUpdateExtraByMid($uid);
        $community = intval($extra['ame_se_cid']);
        $new_member = false;
        if($this->applet_cfg['ac_type'] == 32){
            $new_member = App_Helper_Sequence::checkNewMember($uid,$this->sid);

            // 社区团购 区域管理合伙人处理逻辑
            // 根据社区找到这个社区是否有中间层的区域合伙人
            // 如果有区域合伙人的话查询数据的的时候 需要绕过顶级管理员设置的商品限购总开全
            // 判断当前商品在合伙人设置中是否限购
               
            $community_model=new App_Model_Sequence_MysqlSequenceCommunityStorage($this->sid);
            $has_manager=$community_model->checkCommunityHasRegionManager($community,$this->shop['s_c_id'],'asa_zone');
            if($has_manager['m_area_id']){
                //读取区域管理所有限购的商品id
                //读取商品小区限购表中该小区可以购买的商品
                //所有限购的商品--可以购买的商品= 不能购买的商品
                //不能购买的商品从现有的列表中剔除
                
                
                //社区团购 区域管理合伙人自定义添加的商品只能被自己所辖社区获取
                $where[]="(`g_region_add_by`={$has_manager['m_id']} OR `g_region_add_by`=0)";
                
                $region_model=new App_Model_Sequence_MysqlSequenceRegionGoodsStorage($this->sid);
                $limit_goods=$region_model->getAllLimitGoods($has_manager['m_area_id']);
                
                // 获取所有主管理员设置的限购的商品
                $limit_goods_main=$goods_storage->getGoodsLimited();

                $limit_goods_main_ids=array_column($limit_goods_main,'g_id');
                $limit_goods_ids=array_column($limit_goods,'asrg_goods_id');
                $limit_goods_ids=array_merge($limit_goods_ids,$limit_goods_main_ids);
                $sequence_goods_community=new App_Model_Sequence_MysqlSequenceGoodsCommunityStorage($this->sid);
                $can_buy_goods=$sequence_goods_community->getGoodsBySidCid($community);

                $diff_goods=array_diff($limit_goods_ids, array_column($can_buy_goods,'asgc_g_id')); //需要被从列表中删除的商品
                if($diff_goods)
                    $region_where[]=['name'=>'g_id','oper'=>'not in','value'=>$diff_goods];
                else
                    $region_where=[];
            }else{
                $where[] =  "((g_add_bed = 1 AND (select count(*) as num from `pre_applet_sequence_goods_community` where asgc_g_id = g_id And asgc_c_id = {$community} ) > 0) or (g_add_bed = 0))";
                // 不存在社区管理员的时候
                $where[]=['name'=>'g_region_add_by','oper'=>'=','value'=>0];
            }
        }
        // 分类商品 售罄商品排序下沉(社区团购版本的排序)
        // zhangzc
        // 2019-08-01
        if($this->applet_cfg['ac_type'] == 32){
            $field=['g_id','g_cover','g_name','g_price','g_stock','g_sold','g_show_num','g_brief','g_limit','g_show_vip','g_fake_buynum','g_had_vip_price','g_join_discount','g_ori_price','g_kind1','g_kind2','g_format_type','g_hotel_stock','g_has_window','g_date_price','g_day_limit','g_least_buy','(case g_stock WHEN 0 THEN 0 else 1 end)'=>'stockby'];
            $sort=['stockby'=>'DESC','g_is_top'=>'DESC','g_weight' => 'DESC', 'g_update_time' => 'DESC', 'g_price' => 'ASC'];
            $goodsList         = $goods_storage->fetchShopGoodsList($this->sid, $index, $this->count, '', 0, $sort,$field,0,0,0,$where,0,0,0,0,true,$has_manager['m_area_id']?1:0,$region_where);
        }else{
            $goodsList         = $goods_storage->getList($where,$index, $this->count,$sort);
        }
        
        $goods = array();
        //获得用户购物车信息
        $cart_storage = new App_Model_Shop_MysqlShopCartStorage($this->sid);
        $where_cart[]  = array('name'=>'sc_m_id','oper'=>'=','value'=>$uid);
        $cartList = $cart_storage->getGoodsCountSum($where_cart,0,0);
        if($cartList){
            foreach ($cartList as $value){
                $cartData[$value['g_id']] = array(
                    'num' => $value['total'],
                    'gid' => $value['g_id'],
                    'id'  => $value['sc_id']
                );
                $total += $value['total'];
            }
        }


        if($goodsList) {
            foreach ($goodsList as $v) {
                $goods[] = $this->_format_goods_details($v,true,0,false,$cartData,true,$new_member);
            }
        }
        $data['data']['goods'] = $goods;
        $data['data']['secondCategory'] = $secondKind;
        $data['data']['cartNum'] = $total;
        $this->outputSuccess($data);

    }

    /*
     * 获得微信js api 配置
     */
    public function getWeixinJsCfgAction(){
       // $plum_session_applet = $this->request->getStrParam('plum_session_applet',0);
        $wx_client  = new App_Plugin_Weixin_ClientPlugin($this->sid,5);
        $url = $this->request->getStrParam('url');
       // $this->request->getRequestUrl()
        $log = false;
//        if($this->sid == 12653){
//            $log = true;
//        }

        $config     = $wx_client->fetchWeixinAppletJsapiTicketSignature($url, [], false, $log);
        $config['session_left_time'] = 0;
        $plum_session_applet = session_id();
        if($plum_session_applet){
            //从redis中获得session过期时间
            $session_name = 'plum_session_applet';
            $redis = new Redis();
            $redis_cfg    = plum_parse_config('session', 'redis');
            if ($redis->connect($redis_cfg['host'], $redis_cfg['port'], $redis_cfg['timeout'])) {
                if($redis_cfg['password']){
                    $redis->auth($redis_cfg['password']);
                }
                $left_time = $redis->ttl($session_name.':'.$plum_session_applet);
                $config['session_left_time'] = $left_time;
                $redis->close();
            }
        }

        $info['data'] = $config;
        $this->outputSuccess($info);
    }
}

