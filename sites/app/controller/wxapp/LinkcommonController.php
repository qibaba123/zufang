<?php
/**
 * Created by PhpStorm.
 * User: Ding
 * Date: 2019/4/15
 * Time: 15:30
 */

class App_Controller_Wxapp_LinkcommonController extends App_Controller_Wxapp_InitController
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 获取企业资讯
     */
    protected function _shop_information(){
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
     * 店铺详情
     */
    protected function _shop_list(){
        if($this->wxapp_cfg['ac_type'] == 6){
            $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
            $sort  = array('acs_create_time' => 'DESC');
            $where = array();
            $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
            $shop    = $shop_storage->getList($where,0,0,$sort);
            $data = array();
            $selectShop = array();
            $data[] = array(
                'id'        => 0,
                'name'      => '请选择',
            );
            if($shop){
                foreach ($shop as $val){
                    $data[] = array(
                        'id'        => $val['acs_id'],
                        'name'      => $val['acs_name'],
                    );
                    $selectShop[$val['acs_id']] = $val['acs_name'];
                }
            }
            $this->output['selectShop'] = $selectShop;
            $this->output['shopList'] = json_encode($data);
        }else{
            $where[] = array('name'=>'es_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'es_status','oper'=>'=','value'=>0);

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
            $this->output['shopList'] = json_encode($data);
            $this->output['selectShop'] = $selectShop;
        }
    }

    /**
     * 店铺详情
     */
    protected function _show_shop_list(){
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $sort  = array('acs_create_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $shop    = $shop_storage->getList($where,0,0,$sort);
        $data = array();
        if($shop){
            foreach ($shop as $val){
                $data[ $val['acs_id']] = array(
                    'imgsrc'    => $val['acs_img'],
                    'name'      => $val['acs_name'],
                );
            }
        }
        $this->output['shopListId'] = json_encode($data);

    }

    /**
     * 获取列表以供使用
     */
    protected function _get_list_for_select(){
        $foldType = plum_parse_config('fold_menu','system');
        $this->output['linkTypeNew'] = array();

        $goodSourceType = array(
            array(
                'id'   => '1',
                'name' => '商品分类'
            ),
            array(
                'id'   => '2',
                'name' => '商品分组'
            ),
        );

        //基础商城和营销商城
        if($this->wxapp_cfg['ac_type'] == 1 || $this->wxapp_cfg['ac_type'] == 21){
            $linkList = plum_parse_config('link','system');
            $linkType = plum_parse_config('link_type','system');
            $weedingType = plum_parse_config('link_type_goods','system');
            $customType  = plum_parse_config('link_type_custom','system');
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            //unset($linkType[0]);  // 去除资讯单页
            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode(array_merge($linkType,$weedingType, $customType));
            unset($foldType[0]); //去掉客服

            if($this->wxapp_cfg['ac_type'] == 21){
                $allMallType = plum_parse_config('link_type_all_mall','system');
                $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$weedingType, $allMallType, $customType), $foldType));
            }else{
                $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$weedingType, $customType), $foldType));
            }
            $this->output['linkTypeNew'] = $this->output['linkType'];
        }

        //同城
        if($this->wxapp_cfg['ac_type'] == 6){
            $linkList = plum_parse_config('link','system');
            $linkType = $linkTypeNew = plum_parse_config('link_type','system');
            $groupType = plum_parse_config('link_type_city','system');
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            unset($linkType[0]);  // 去除资讯单页
            unset($link[16]); // 去除领券中心
            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$groupType), $foldType));
            $this->output['linkTypeNew'] = json_encode(array_merge($linkTypeNew,$groupType, $foldType));

            $goodSourceType = array(
                array(
                    'id'   => '1',
                    'name' => '平台商品分类'
                ),
                array(
                    'id'   => '4',
                    'name' => '商家商品分组'
                ),
            );
        }


        //多店版
        if($this->wxapp_cfg['ac_type'] == 8){
            $linkList = plum_parse_config('link','system');
            $linkType = plum_parse_config('link_type','system');
            $weedingType = plum_parse_config('link_type_community','system');
            $customType  = plum_parse_config('link_type_custom','system');
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            unset($link[10]); //去掉领券中心
            unset($foldType[0]); //去掉客服
            $linkTypeArr = $linkTypeArrNew = array_merge(array_merge($linkType,$weedingType, $customType), $foldType);
            $this->output['linkList'] = json_encode(array_merge($link));
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);

            $goodSourceType = array(
                array(
                    'id'   => '2',
                    'name' => '平台商品分组'
                ),
                array(
                    'id'   => '4',
                    'name' => '商家商品分组'
                ),
                array(
                    'id'   => '3',
                    'name' => '入驻店铺推荐商品'
                ),
            );
        }

        //餐饮版
        if($this->wxapp_cfg['ac_type'] == 4){
            $linkList    = plum_parse_config('link','system');
            $linkType    = plum_parse_config('link_type','system');
            $mealType    = plum_parse_config('link_type_meal','system');
            $customType  = plum_parse_config('link_type_custom','system');
            $link = $linkList[$this->wxapp_cfg['ac_type']];

            $linkTypeArr = $linkTypeArrNew = array_merge($linkType, $customType, $mealType);
            $this->output['linkList'] = json_encode(array_merge($link));
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);

        }

        //知识付费
        if($this->wxapp_cfg['ac_type'] == 27){
            $linkList = plum_parse_config('link','system');
            $linkType = plum_parse_config('link_type','system');
            $weedingType = plum_parse_config('link_type_knowpay','system');
            $customType  = plum_parse_config('link_type_custom','system');
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            //unset($foldType[0]); //去掉客服
            $foldType[4] = array(
                'id'   => '49',
                'name' => '签到'
            );

            $linkTypeArr = $linkTypeArrNew = array_merge(array_merge($linkType,$weedingType, $customType), $foldType);
            $this->output['linkList'] = json_encode(array_merge($link));
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);
        }

        $this->output['goodSourceType'] = json_encode($goodSourceType);
    }

    /**
     * 获取普通商品分组数据
     */
    protected function _ordinary_goods_group(){
        $where      = array();
        $where[]    = array('name' => 'gg_s_id','oper' => '=','value' =>$this->curr_sid);
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
            }
        }
        $this->output['ordinaryGoodsGroup'] = json_encode($data);
    }

    /**
     * 获取店铺促销商品,推荐商品选择推荐商品使用
     */
    protected function _shop_top_goods_list($type = ''){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $where = array();
        if($type == 'mall'){
            $where[]    = array('name' => 'g_es_id', 'oper' => '>', 'value' => 0);
        }else{
            $where[]    = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);
        }
        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,0,'',0,array(),array(),0,0,1,$where);
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
     * 获取秒杀商品分组数据
     */
    protected function _limit_group(){
        $where      = array();
        $where[]    = array('name' => 'alg_s_id','oper' => '=','value' =>$this->curr_sid);
        $group_model    = new App_Model_Limit_MysqlLimitGroupStorage($this->curr_sid);
        $sort = array('alg_create_time' => 'DESC');
        $list = $group_model->getList($where,0,0,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['alg_id'],
                    'name' => $val['alg_name'],
                );
            }
        }
        $this->output['goodsGroup'] = json_encode($data);
    }

    /**
     * 获取店铺的全部分类选择使用
     */
    protected function _shop_kind_list_for_select(){
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        // 获取店铺的所有二级分类
        $kind2 = $kind_model->getAllSonCategory(0,0);
        $data = array();
        if($kind2){
            foreach ($kind2 as $val){
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name']
                );
            }
        }
        $this->output['kindSelect'] = json_encode($data);
    }

    /*
     * 获得平台商品一级分类
     */
    protected function _curr_first_kind_list_for_select(){
        $kind_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $list = $kind_model->getAllFirstCategory();
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name']
                );
            }
        }
        $this->output['currFirstKindSelect'] = json_encode($data);

    }

    /*
     * 获得平台商品二级分类
     */
    protected function _curr_second_kind_list_for_select(){
        $kind_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $list = $kind_model->getAllSonCategory();
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name']
                );
            }
        }
        $this->output['currSecondKindSelect'] = json_encode($data);
    }
    /**
     * 店铺分类列表
     */
    protected function _shop_category($type = 0){
        $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $category = $shortcut_model->fetchShortcutShowList($type);
        $data = array();
        if($category){
            foreach ($category as $val){
                $data[] = array(
                    'id'   => $val['acc_id'],
                    'name' => $val['acc_title'],
                );
            }
        }
        $this->output['shopCategory'] = json_encode($data);
        return $data;
    }

    /*
     * 获得全部文章分类
     */
    protected function _get_information_category(){
        $data = array();
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $where[] = array('name'=>'aic_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>'aic_s_id','oper'=>'=','value'=>$this->curr_sid);
        $list = $category_storage->getList($where,0,0,array('aic_create_time'=>'DESC'));
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id' => $val['aic_id'],
                    'name' => $val['aic_name']
                );
            }
        }
        $this->output['infocateList'] = json_encode($data);
        $this->output['infocateSelect'] = $data;
    }

    /**
     * 获取商品分组数据
     */
    protected function _get_goods_group(){
        $where      = array();
        $where[]    = array('name' => 'gg_s_id','oper' => '=','value' =>$this->curr_sid);
        $group_model    = new App_Model_Goods_MysqlGroupStorage($this->curr_sid);
        $sort = array('gg_create_time' => 'DESC');
        $list = $group_model->getList($where,0,0,$sort);
        $data = array();
        $shopData = array();
        if($list){
            foreach ($list as $val){
                if($val['gg_is_eshop']){
                    $shopData[] = array(
                        'id'   => $val['gg_id'],
                        'name' => $val['gg_name'],
                    );
                }else{
                    $data[] = array(
                        'id'   => $val['gg_id'],
                        'name' => $val['gg_name'],
                    );
                }
            }
        }
        $this->output['goodsGroup'] = json_encode($data);
        $this->output['shopGoodsGroup'] = json_encode($shopData);
    }

    protected function _community_shop_kind_list_for_select(){
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
        $this->output['shopKindSelect'] = json_encode($data);
    }

    protected function show_city_shortcut($type=1){
        $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $shortcut = $shortcut_model->fetchShortcutShowList($type);
        $json = array();
        $postCategory = [];
        foreach($shortcut as $key => $val){
            $json[] = array(
                'id'           => $val['acc_id'],
                'index'        => $key ,
                'title'        => $val['acc_title'],
                'imgsrc'       => $val['acc_img'],
                'type'         => $val['acc_service_type'],
                'price'        => $val['acc_price'],
                'linkUrl'      => $val['acc_link_url'],
                'mobileShow'   => $val['acc_mobile_show'] ==1 ? true : false,
                'addressShow'  => $val['acc_address_show'] ==1 ? true : false,
                'allowComment' => $val['acc_allow_comment'] ==1 ? true : false,
                'verifyComment' => $val['acc_verify_comment'] ==1 ? true : false,
                'isshow'       => $val['acc_isshow'] == 1 ? true : false,
            );
            if($val['acc_service_type'] == 1){
                $postCategory[] = array(
                    'id' => $val['acc_id'],
                    'title' => $val['acc_title']
                );
            }

        }
        if($type == 2){
            $this->output['shortcutCategory'] = json_encode($json);
            $this->output['postCategory'] = json_encode($postCategory);
        }else{
            $this->output['shortcut'] = json_encode($json);
            $this->output['postCategory'] = json_encode($postCategory);
        }

    }

}