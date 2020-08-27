<?php
/*
 * 社区团购
 */

class App_Controller_Wxapp_SequenceController extends App_Controller_Wxapp_OrderCommonController
{
    const MAX_EXPORT_EXCEL_ROWS = 15000; //单次可以导出的最大的excel的行数
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 小程序首页模板
     */
    public function sequenceTemplateAction()
    {
        $this->buildBreadcrumbs(array(
            array('title' => '小程序首页模板', 'link' => '#'),
        ));
        $cfg     = plum_parse_config('category', 'applet');
        $tpl_ids = $cfg[32]['tpl'];
        $cfg     = $this->wxapp_cfg;
        if ($cfg['ac_type'] == 32) {
            $tpl_model = new App_Model_Shop_MysqlIndexTplStorage();
            $list      = $tpl_model->getListByTidSidType($tpl_ids, $this->curr_sid, 3);
            //获取配置信息
            $row = array();
            foreach ($list as $val) {
                if (empty($row) && $val['it_id'] == $cfg['ac_index_tpl']) {
                    $row = $val;
                    break;
                }
            }
        } else {
            $list = [];
            $row  = [];
        }

        $this->output['cfg']  = $cfg;
        $this->output['list'] = $list;
        $this->output['shop'] = $this->shops[$this->curr_sid];
        $this->output['row']  = $row;
        $this->displaySmarty('wxapp/sequence/sequence-template.tpl');
    }

    /*
     * 首页
     */
    public function indexTplAction()
    {
        $tpl_id = $this->request->getIntParam('tpl', 64);
        $this->_shop_default_tpl();
        //首页基本配置
        $this->showIndexTpl($tpl_id);
        // 选择活动文章
        $this->_shop_information();
        // 首页幻灯
        $this->showShopTplSlide($tpl_id);
        // 获取链接类型及列表
        $this->_get_list_for_select();
        //自营商品一级分类
        $this->_curr_first_kind_list_for_select();
        //自营商品二级分类
        $this->_curr_second_kind_list_for_select();
        //资讯分类
        $this->_get_information_category();
        $this->goodsGroup(); // 获取商品分组
        $this->_get_menu_list(); //获得美食菜单列表
        //获得商品列表
        $this->_shop_goods_list();
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '接龙管理', 'link' => '#'),
            array('title' => '接龙首页配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sequence/index-tpl_' . $tpl_id . '.tpl');
    }

    /**
     * 获取商品分组数据
     */
    private function goodsGroup()
    {
        $where       = array();
        $where[]     = array('name' => 'gg_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $group_model = new App_Model_Goods_MysqlGroupStorage($this->curr_sid);
        $sort        = array('gg_create_time' => 'DESC');
        $list        = $group_model->getList($where, 0, 0, $sort);
        $data        = array();
        $shopData    = array();
        if ($list) {
            foreach ($list as $val) {
                if ($val['gg_is_eshop']) {
                    $shopData[] = array(
                        'id'   => $val['gg_id'],
                        'name' => $val['gg_name'],
                    );
                } else {
                    $data[] = array(
                        'id'   => $val['gg_id'],
                        'name' => $val['gg_name'],
                    );
                }
            }
        }
        $this->output['goodsGroup']     = json_encode($data);
        $this->output['shopGoodsGroup'] = json_encode($shopData);
    }

    /**
     * 获取店铺促销商品,推荐商品选择推荐商品使用
     */
    private function _shop_goods_list()
    {
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $goods_list    = $goods_storage->fetchShopGoodsList($this->curr_sid, 0, 50, '', 0, array(), array(), 0, 0, 0);
        $data          = array();
        if ($goods_list) {
            foreach ($goods_list as $val) {
                $data[] = array(
                    'id'   => $val['g_id'],
                    'name' => $val['g_name'],
                );
            }
        }
        $this->output['goodsList'] = json_encode($data);
    }

    /**
     * 获取企业资讯
     */
    private function _shop_information()
    {
        $where               = array();
        $where[]             = array('name' => 'ai_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]             = array('name' => 'ai_deleted', 'oper' => '=', 'value' => 0);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $sort                = array('ai_create_time' => 'DESC');
        $list                = $information_storage->getList($where, 0, 50, $sort);
        $data                = array();
        if ($list) {
            foreach ($list as $val) {
                $data[] = array(
                    'id'    => $val['ai_id'],
                    'title' => $val['ai_title'],
                    'brief' => $val['ai_brief'],
                    'cover' => $val['ai_cover'],
                );
            }
        }
        $this->output['information'] = json_encode($data);
    }

    private function _get_list_for_select($type = '')
    {
        $linkList  = plum_parse_config('link', 'system');
        $linkType  = plum_parse_config('link_type', 'system');
        $groupType = plum_parse_config('link_type_sequence', 'system');
        $link      = $linkList[$this->wxapp_cfg['ac_type']];
        unset($linkType[3]); // 去除小程序

        $outputLinkType = array_merge($linkType, $groupType);
        //过滤被代理商关闭的功能链接 dn 12-21
        $filterData     = $this->_filter_agent_close_path($link, $outputLinkType);
        $outputLinkType = $filterData['typeData'];
        $link           = $filterData['pathData'];

        $this->output['linkList'] = json_encode($link);
        $this->output['linkType'] = json_encode($outputLinkType);

    }

    /*
     * 获得平台商品二级分类
     */
    private function _curr_second_kind_list_for_select()
    {
        $kind_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $list       = $kind_model->getAllSonCategory();
        $data       = array();
        if ($list) {
            foreach ($list as $val) {
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name'],
                );
            }
        }
        $this->output['currSecondKindSelect'] = json_encode($data);
    }

    /*
     * 获得平台商品一级分类
     */
    private function _curr_first_kind_list_for_select()
    {
        $kind_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $list       = $kind_model->getAllFirstCategory();
        $data       = array();
        if ($list) {
            foreach ($list as $val) {
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name'],
                );
            }
        }
        $this->output['currFirstKindSelect'] = json_encode($data);

    }

    /*
     * 获得全部文章分类
     */
    private function _get_information_category()
    {
        $data             = array();
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $where[]          = array('name' => 'aic_deleted', 'oper' => '=', 'value' => 0);
        $where[]          = array('name' => 'aic_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $list             = $category_storage->getList($where, 0, 0, array('aic_create_time' => 'DESC'));
        if ($list) {
            foreach ($list as $val) {
                $data[] = array(
                    'id'   => $val['aic_id'],
                    'name' => $val['aic_name'],
                );
            }
        }
        $this->output['infocateList']   = json_encode($data);
        $this->output['infocateSelect'] = $data;
    }

    /**
     * 显示tpl设置
     */
    private function showIndexTpl($tpl_id = 64)
    {
        $tpl_model = new App_Model_Sequence_MysqlSequenceIndexStorage($this->curr_sid);
        $tpl       = $tpl_model->findUpdateBySid($tpl_id);

        if (empty($tpl)) {
            $tpl = array(
                'aci_title'       => '首页',
                'aci_tpl_id'      => $tpl_id,
                'asi_coupon_open' => 0,
                'asi_coupon_img'  => '',

            );
        }
        $this->output['tpl'] = $tpl;
    }

    /**
     *添加默认模板
     */
    private function _shop_default_tpl()
    {
        //获取配置信息
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        if (!$cfg['ac_index_tpl'] && $cfg['ac_type'] == 32) {
            $data = array('ac_index_tpl' => 64);
            $applet_cfg->findShopCfg($data);
        }
    }

    /*
     * 保存首页
     */
    public function saveAppletTplAction()
    {
        $tpl_id        = $this->request->getIntParam('tpl_id', 64);
        $head_title    = $this->request->getStrParam('headerTitle'); // 顶部标题
        $couponOpen    = $this->request->getIntParam('couponOpen');
        $couponImg     = $this->request->getStrParam('couponImg');
        $goodsListType = $this->request->getIntParam('goodsListType');
        $data          = array(
            'asi_s_id'           => $this->curr_sid,
            'asi_tpl_id'         => $tpl_id,
            'asi_title'          => $head_title,
            'asi_coupon_img'     => $couponImg,
            'asi_coupon_open'    => $couponOpen,
            'asi_goodslist_type' => $goodsListType,
            'asi_update_time'    => time(),
        );
        // 校验店铺是否可用改模板
        $index_tpl_model = new App_Model_Shop_MysqlIndexTplStorage();
        $row             = $index_tpl_model->getRowBySid($tpl_id, $this->curr_sid);
        if ($row) {
            $index_storage = new App_Model_Sequence_MysqlSequenceIndexStorage($this->curr_sid);
            $index         = $index_storage->findUpdateBySid($tpl_id);
            if ($index) {

                $ret = $index_storage->findUpdateBySid($tpl_id, $data);
            } else {
                $data['asi_create_time'] = time();
                $ret                     = $index_storage->insertValue($data);
            }
            if ($ret) {
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功',
                );
                App_Helper_OperateLog::saveOperateLog("首页模板【{$row['it_name']}】保存成功");
            } else {
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败',
                );
            }
            // 保存幻灯
            $this->save_shop_slide_new($tpl_id);
        } else {
            $result = array(
                'ec' => 400,
                'em' => '模版不可用',
            );
        }
        $this->displayJson($result);

    }

    /*
     * 区域列表
     */
    public function areaListAction()
    {

        // 社区团购区域管理合伙人-判定是否合伙人-获取相应权限
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            if ($area_info['m_area_type'] == 'C') {
                $where[] = ['name' => 'asa_city', 'oper' => '=', 'value' => $area_info['m_area_id']];
            } else if ($area_info['m_area_type'] == 'D') {
                $where[] = ['name' => 'asa_zone', 'oper' => '=', 'value' => $area_info['m_area_id']];
            }

            $this->output['area'] = $area_info;
        }

        $page    = $this->request->getIntParam('page');
        $index   = $page * $this->count;
        $sort    = array('asa_create_time' => 'DESC');
        $where[] = array('name' => 'asa_s_id', 'oper' => '=', 'value' => $this->curr_sid);

        $this->output['name'] = $this->request->getStrParam('name');
        if ($this->output['name']) {
            $where[] = array('name' => 'asa_name', 'oper' => 'like', 'value' => "%{$this->output['name']}%");
        }
        $pro_param                = $this->request->getIntParam('search_province');
        $city_param               = $this->request->getIntParam('search_city');
        $zone_param               = $this->request->getIntParam('search_zone');
        $area_model               = new App_Model_Member_MysqlRegionStorage();
        $province                 = $area_model->get_province();
        $this->output['province'] = $province;

        // 城市
        if ($pro_param) {
            $citys                 = $area_model->get_city_by_parent($pro_param);
            $this->output['citys'] = $citys;
        }

        // 县区
        if ($city_param) {
            $zones                 = $area_model->get_area_by_parent($city_param);
            $this->output['zones'] = $zones;
        }

        if ($pro_param) {
            $where[] = ['name' => 'asa_province', 'oper' => '=', 'value' => $pro_param];
        }
        if ($city_param) {
            $where[] = ['name' => 'asa_city', 'oper' => '=', 'value' => $city_param];
        }
        if ($zone_param) {
            $where[] = ['name' => 'asa_zone', 'oper' => '=', 'value' => $zone_param];
        }

        $area_model                 = new App_Model_Sequence_MysqlSequenceAreaStorage($this->curr_sid);
        $total                      = $area_model->getCount($where);
        $pageCfg                    = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['pagination'] = $pageCfg->render();
        $list                       = $area_model->getListWithArea($where, $index, $this->count, $sort);

        $this->output['showPage'] = $total > $this->count ? 1 : 0;
        $this->output['list']     = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '街道列表', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/sequence/area-list.tpl');
    }

    /*
     * 保存区域
     */
    public function areaSaveAction()
    {
        $result = array(
            'ec' => 400,
            'em' => '保存失败',
        );
        $id           = $this->request->getIntParam('id');
        $name         = $this->request->getStrParam('name');
        $posterName   = $this->request->getStrParam('posterName');
        $posterMobile = $this->request->getStrParam('posterMobile');
        $province     = $this->request->getIntParam('province');
        $city         = $this->request->getIntParam('city');
        $zone         = $this->request->getIntParam('zone');
        if ($name) {
            // 增加区域管理合伙人地域性限制
            // 只能增加当前合伙人所在城市的区域
            // 自动填充省份信息
            $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
            if ($area_info) {
                // 获取默认的省份的id
                $region_model = new App_Model_Member_MysqlRegionStorage();

                // 替换默认省份与市
                if ($area_info['m_area_type'] == 'C') {
                    //城市级区域合伙人 --暂时不会用到
                    // 检测是否拥有添加此区域的权限
                    $is_area = $region_model->getCount([
                        ['name' => 'region_id', 'oper' => '=', 'value' => $zone],
                        ['name' => 'parent_id', 'oper' => '=', 'value' => $area_info['m_area_id']],
                    ]);
                    if (!$is_area) {
                        $this->displayJson(['em' => '无此区域的添加权限'], 1);
                    }

                    $province_id = $region_model->getProvinceByCityId($area_info['m_area_id']);
                    $province    = $province_id['parent_id'];
                    $city        = $area_info['m_area_id'];
                } else if ($area_info['m_area_type'] == 'D') {
                    //区县级区域合伙人
                    $city_res     = $region_model->getProvinceByCityId($area_info['m_area_id']);
                    $city         = $city_res['parent_id'];
                    $province_res = $region_model->getProvinceByCityId($city);
                    $province     = $province_res['parent_id'];
                    $zone         = $area_info['m_area_id'];

                    // 检测是否拥有添加此区域的权限
                    $is_area = $region_model->getCount([
                        ['name' => 'region_id', 'oper' => '=', 'value' => $zone],
                        ['name' => 'parent_id', 'oper' => '=', 'value' => $city],
                    ]);
                    if (!$is_area) {
                        $this->displayJson(['em' => '无此区域的添加权限'], 1);
                    }

                }

            }

            $data = array(
                'asa_name'          => $name,
                'asa_province'      => $province,
                'asa_city'          => $city,
                'asa_zone'          => $zone,
                'asa_poster_name'   => $posterName,
                'asa_poster_mobile' => $posterMobile,
                'asa_update_time'   => time(),
                'asa_create_by'     => $this->uid,
            );
            $area_model = new App_Model_Sequence_MysqlSequenceAreaStorage($this->curr_sid);
            if ($id) {
                $res = $area_model->updateById($data, $id);
            } else {
                $data['asa_create_time'] = time();
                $data['asa_s_id']        = $this->curr_sid;
                $res                     = $area_model->insertValue($data);
            }

            if ($res) {
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功',
                );
                App_Helper_OperateLog::saveOperateLog("区域【{$name}】保存成功");
            }

        } else {
            $result = array(
                'ec' => 400,
                'em' => '请填写区域名称',
            );
        }
        $this->displayJson($result);
    }

    /*
     * 删除区域
     */
    public function areaDeleteAction()
    {
        $id = $this->request->getIntParam('id');
        // 判断区域管理合伙人
        $area_info  = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        $area_model = new App_Model_Sequence_MysqlSequenceAreaStorage($this->curr_sid);
        $row        = $area_model->getRowById($id);
        if ($area_info) {
            $count = $area_model->getCount([
                ['name' => 'asa_create_by', 'oper' => '=', 'value' => $this->uid],
                ['name' => 'asa_id', 'oper' => '=', 'value' => $id],
            ]);
            if (!$count) {
                $this->displayJson(['em' => '无此区域的删除权限'], 1);
            }

        }
        $res = $area_model->deleteDFById($id, $this->curr_sid);

        if ($res) {
            App_Helper_OperateLog::saveOperateLog("区域【{$row['asa_name']}】保存成功");
        }

        $this->showAjaxResult($res, '删除');
    }

    /*
     * 小区列表
     */
    public function communityListAction()
    {
        $page            = $this->request->getIntParam('page');
        $index           = $page * $this->count;
        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
        $where[]         = array('name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort            = array('asc_update_time' => 'DESC');

        $this->output['name'] = $this->request->getStrParam('name');
        if ($this->output['name']) {
            $where[] = array('name' => 'asc_name', 'oper' => 'like', 'value' => "%{$this->output['name']}%");
        }
        $this->output['area'] = $this->request->getIntParam('area', 0);
        if ($this->output['area']) {
            $where[] = array('name' => 'asc_area', 'oper' => '=', 'value' => $this->output['area']);
        }
        $this->output['leader'] = $this->request->getStrParam('leader');
        if ($this->output['leader']) {
            $where[] = array('name' => 'asl_name', 'oper' => 'like', 'value' => "%{$this->output['leader']}%");
        }
        $this->output['verify_status'] = $this->request->getIntParam('verify_status', 2);
        $where[]                       = ['name' => 'asc_status', 'oper' => '=', 'value' => $this->output['verify_status']];

        $seqregion = 0;
        // 社区团购区域管理合伙人
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $seqregion = 1;
            $area_id   = $area_info['m_area_id'];
            if ($area_info['m_area_type'] == 'C') {
                $where[] = ['name' => 'asa_city', 'oper' => '=', 'value' => $area_id];
            } else if ($area_info['m_area_type'] == 'D') {
                $where[] = ['name' => 'asa_zone', 'oper' => '=', 'value' => $area_id];
            }

        }
        $this->output['seqregion'] = $seqregion;

        $total                      = $community_model->getCommunityLeaderCount($where);
        $pageCfg                    = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['pagination'] = $pageCfg->render();
        $list                       = $community_model->getCommunityLeaderList($where, $index, $this->count, $sort);
        $this->output['list']       = $list;
        $this->output['showPage']   = $total > $this->count ? 1 : 0;
        //获得统计信息
        $where_total    = $where_leader    = [];
        $where_total[]  = $where_leader[]  = ['name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_leader[] = ['name' => 'asc_leader', 'oper' => '>', 'value' => 0];

        if ($area_info) {
            $totalCount  = $community_model->getCommunityCountByArea($area_id, $area_info['m_area_type']);
            $leaderCount = $community_model->getLeaderCountByArea($area_id, $area_info['m_area_type']);
        } else {
            $totalCount  = $community_model->getCount($where_total);
            $leaderCount = $community_model->getCount($where_leader);
        }

        $noleaderCount = intval($totalCount) - intval($leaderCount);
        $statInfo      = [
            'total'    => intval($totalCount),
            'leader'   => intval($leaderCount),
            'noleader' => $noleaderCount > 0 ? $noleaderCount : 0,
        ];
        $this->output['statInfo'] = $statInfo;

        $this->_get_area_list(false, $area_info ? $area_id : false, $area_info['m_area_type']);
        $this->buildBreadcrumbs(array(
            array('title' => '社区管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sequence/community-list.tpl');
    }

    /*
     * 新增/编辑小区
     */
    public function communityEditAction()
    {
        $id  = $this->request->getIntParam('id', 0);
        $row = array();
        if ($id) {
            $community_model            = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
            $row                        = $community_model->getRowByIdSid($id, $this->curr_sid);
            $row['asc_address_repalce'] = str_replace(PHP_EOL, ' ', $row['asc_address']);
            $this->output['row']        = $row;
            //获得选择此小区的用户数
            $ame_model                   = new App_Model_Member_MysqlMemberExtraStorage($this->curr_sid);
            $where[]                     = array('name' => 'ame_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[]                     = array('name' => 'ame_se_cid', 'oper' => '=', 'value' => $id);
            $count                       = $ame_model->getCount($where);
            $this->output['true_member'] = $count ? $count : 0;

        }
        $this->buildBreadcrumbs(array(
            array('title' => '社区管理', 'link' => '/wxapp/sequence/communityList'),
            array('title' => '编辑/新增社区', 'link' => '#'),
        ));

        // 社区团购区域管理合伙人
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        $seqregion = 0;
        if ($area_info) {
            $seqregion = 1;
            $area_id   = $area_info['m_area_id'];
            if ($area_info['m_area_type'] == 'C') {
                $where[] = ['name' => 'asa_city', 'oper' => '=', 'value' => $area_id];
            } else if ($area_info['m_area_type'] == 'D') {
                $where[] = ['name' => 'asa_zone', 'oper' => '=', 'value' => $area_id];
            }

        }
        $cfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
        $cfg       = $cfg_model->findUpdateBySid();

        $this->output['seqregion']        = $seqregion;
        $this->output['community_verify'] = intval($cfg['asc_region_community_verify']);
        //获得区域
        $this->_get_area_list(false, $area_info ? $area_id : false, $area_info['m_area_type']);
        $this->displaySmarty('wxapp/sequence/community-edit.tpl');

    }

    /*
     * 获得全部选择区域
     */
    private function _get_area_list($return = false, $is_area = false, $area_type = 'C')
    {
        $data       = array();
        $area_model = new App_Model_Sequence_MysqlSequenceAreaStorage($this->curr_sid);
        $where[]    = array('name' => 'asa_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        if ($is_area) {
            if ($area_type == 'C') {
                $where[] = ['name' => 'asa_city', 'oper' => '=', 'value' => $is_area];
            } else if ($area_type == 'D') {
                $where[] = ['name' => 'asa_zone', 'oper' => '=', 'value' => $is_area];
            }

        }
        $sort = array('asa_create_time' => 'DESC');
        $list = $area_model->getListWithArea($where, 0, 0, $sort);
        if ($list) {
            foreach ($list as $val) {
                $data[$val['asa_id']] = array(
                    'id'   => $val['asa_id'],
                    'name' => $val['asa_name'],
                    'area' => $val['area'],
                );
            }
        }
        if ($return) {
            return $data;
        } else {
            $this->output['areaList']   = json_encode($data);
            $this->output['areaSelect'] = $data;
        }
    }

    /*
     * 保存小区
     */
    public function communitySaveAction()
    {
        $result = array(
            'ec' => 400,
            'em' => '保存失败',
        );
        $id            = $this->request->getIntParam('id');
        $area          = $this->request->getIntParam('area');
        $name          = $this->request->getStrParam('name');
        $shopName      = $this->request->getStrParam('shopName');
        $code          = $this->request->getStrParam('code');
        $address       = $this->request->getStrParam('address');
        $addressDetail = $this->request->getStrParam('addressDetail');
        $postAddress   = $this->request->getStrParam('postAddress');
        $lng           = $this->request->getStrParam('lng');
        $lat           = $this->request->getStrParam('lat');
        $member        = $this->request->getIntParam('member', 0);
        $fakeMember    = $this->request->getIntParam('fakeMember', 0);
        $sequenceNum   = $this->request->getIntParam('sequenceNum', 0);

        if ($fakeMember < 0) {
            $this->displayJsonError('虚拟粉丝数不能低于0');
        }

        if ($sequenceNum < 0) {
            $this->displayJsonError('接龙次数不能低于0');
        }

        // 区域管理合伙人判断添加的社区是否属于当前区域管理者
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $area_model = new App_Model_Sequence_MysqlSequenceAreaStorage($this->curr_sid);
            // 城市还有街道获取是否属于
            if ($area_info['m_area_type'] == 'C') {
                $count = $area_model->getCount([
                    ['name' => 'asa_id', 'oper' => '=', 'value' => $area], //街道id
                    ['name' => 'asa_city', 'oper' => '=', 'value' => $area_info['m_area_id']],
                ]);
            } else if ($area_info['m_area_type'] == 'D') {
                $count = $area_model->getCount([
                    ['name' => 'asa_id', 'oper' => '=', 'value' => $area], //街道id
                    ['name' => 'asa_zone', 'oper' => '=', 'value' => $area_info['m_area_id']],
                ]);
            }

            if (!$count) {
                $this->displayJson(['em' => '无当前街道区域的操作权限'], 1);
            }

        }

        $data = array(
            'asc_area'           => $area,
            'asc_name'           => $name,
            'asc_shop_name'      => $shopName,
            'asc_code'           => $code,
            'asc_address'        => $address,
            'asc_lng'            => $lng,
            'asc_lat'            => $lat,
            'asc_address_detail' => $addressDetail,
            'asc_post_address'   => $postAddress,
            'asc_member'         => $member,
            'asc_fake_member'    => $fakeMember,
            'asc_sequence_num'   => $sequenceNum,
            'asc_update_time'    => time(),
        );
        if ($area_info) {
            $seqcfg_model              = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
            $seq_cfg                   = $seqcfg_model->findUpdateBySid();
            $data['asc_region_add_by'] = $this->uid; //合伙人记录归属id
            if ($seq_cfg['asc_region_community_verify'] == 1) {
                $data['asc_status'] = 1; //合伙人保存小区 标记为待审核
            }

        }

        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
        if ($id) {
            $res = $community_model->updateById($data, $id);
        } else {
            $data['asc_s_id']        = $this->curr_sid;
            $data['asc_create_time'] = time();
            $res                     = $community_model->insertValue($data);
        }
        if ($res) {
            //如果是合伙人上传小区且需要审核
            if (isset($data['asc_status']) && $data['asc_status'] == 1) {
                $message_helper = new App_Helper_ShopMessage($this->curr_sid);
                $message_helper->messageRecord($message_helper::SEQUENCE_REGION_COMMUNITY_SEND);
            }

            $result = array(
                'ec' => 200,
                'em' => '保存成功',
            );
            App_Helper_OperateLog::saveOperateLog("小区【{$name}】保存成功");
        }
        $this->displayJson($result);
    }

    /*
     * 删除小区
     */
    public function communityDeleteAction()
    {
        $id         = $this->request->getIntParam('id');
        $area_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
        $row        = $area_model->getRowById($id);
        // 区域管理合伙人删除对应的社区时判断权限
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);

        if ($area_info) {
            $has_area = $area_model->checkCommunityIsMine($area_info['m_area_id'], $id, $area_info['m_area_type']);
            if (!$has_area) {
                $this->displayJson(['em' => '您没有删除当前社区的权限'], 1);
            }

        }

        $res = $area_model->deleteDFById($id, $this->curr_sid);

        if ($res) {
            App_Helper_OperateLog::saveOperateLog("小区【{$row['asc_name']}】保存成功");
        }

        $this->showAjaxResult($res, '删除');
    }

    /*
     * 团长管理
     */
    public function leaderListAction()
    {
        $page            = $this->request->getIntParam('page');
        $index           = $page * $this->count;
        $community_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
        $where[]         = array('name' => 'asl.asl_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]         = array('name' => 'asl.asl_status', 'oper' => '=', 'value' => 2);

        $this->output['nickname'] = $this->request->getStrParam('nickname');
        if ($this->output['nickname']) {
            $where[] = array('name' => 'm.m_nickname', 'oper' => 'like', 'value' => "%{$this->output['nickname']}%");
        }
        $this->output['truename'] = $this->request->getStrParam('truename');
        if ($this->output['truename']) {
            $where[] = array('name' => 'asl.asl_name', 'oper' => 'like', 'value' => "%{$this->output['truename']}%");
        }
        $this->output['mobile'] = $this->request->getStrParam('mobile');
        if ($this->output['mobile']) {
            $where[] = array('name' => 'asl.asl_mobile', 'oper' => '=', 'value' => $this->output['mobile']);
        }
        $this->output['parentid'] = $this->request->getIntParam('parentid');
        if ($this->output['parentid']) {
            $where[] = array('name' => 'asl.asl_parent_id', 'oper' => '=', 'value' => $this->output['parentid']);
        }

        $where_sum = [];
        // 社区团购 区域管理合伙人 权限
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $where[]                = ['name' => 'asl.asl_region_manager_id', 'oper' => '=', 'value' => $this->uid];
            $this->output['region'] = $area_info;
        }
        // 检测社区团购区域管理合伙人插件是否可用--控制页面是否显示分配团长的功能
        $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($this->curr_sid);
        $row          = $plugin_model->findUpdateBySid('qyhhr');

        if (!$row || $row['apo_expire_time'] < time()) {
            //不可用
            $this->output['show_area_leader'] = 0;
        } else {
            //可用
            $this->output['show_area_leader'] = 1;
        }

        $cfg_storage         = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
        $cfg                 = $cfg_storage->findUpdateBySid();
        $this->output['cfg'] = $cfg;

        $deduct  = $this->request->getStrParam('deduct');
        $percent = $this->request->getStrParam('percent');
        // 按照佣金进行排序
        if ($deduct == 'up') {
            $sort = ['total_deduct' => 'ASC'];
        } else if ($deduct == 'down') {
            $sort = ['total_deduct' => 'DESC'];
        } else if ($percent == 'up') {
            $sort = ['asl_percent' => 'ASC'];
        } else if ($percent == 'down') {
            $sort = ['asl_percent' => 'DESC'];
        } else {
            $sort = array('asl.asl_update_time' => 'DESC');
        }

        // 团长列表增加按照地区与区域合伙人手机号进行搜索
        // zhangzc
        // 2019-04-22
        $area_model               = new App_Model_Member_MysqlRegionStorage();
        $province                 = $area_model->get_province();
        $this->output['province'] = $province;

        $with_search                   = false;
        $pro_param                     = $this->request->getIntParam('province');
        $city_param                    = $this->request->getIntParam('city');
        $zone_param                    = $this->request->getIntParam('zone');
        $region_mobile                 = $this->request->getStrParam('region_mobile');
        $this->output['region_mobile'] = $region_mobile;

        if ($region_mobile) {
            $where[] = ['name' => 'pm.m_mobile', 'oper' => '=', 'value' => $region_mobile];
        }

        // 城市
        if ($pro_param) {
            $citys                 = $area_model->get_city_by_parent($pro_param);
            $this->output['citys'] = $citys;
        }

        // 县区
        if ($city_param) {
            $zones                 = $area_model->get_area_by_parent($city_param);
            $this->output['zones'] = $zones;
        }

        if ($pro_param) {
            $where[] = ['name' => 'asa_province', 'oper' => '=', 'value' => $pro_param];
        }
        if ($city_param) {
            $where[] = ['name' => 'asa_city', 'oper' => '=', 'value' => $city_param];
        }
        if ($zone_param) {
            $where[] = ['name' => 'asa_zone', 'oper' => '=', 'value' => $zone_param];
        }
        if ($pro_param || $city_param || $zone_param || $region_mobile) {
            $with_search = true;
        }

        $total                      = $community_model->getLeaderCount($where, $with_search);
        $pageCfg                    = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['pagination'] = $pageCfg->render();
        $list                       = $community_model->getLeaderList($where, $index, $this->count, $sort, $with_search, true);
        $this->output['list']       = $list;
        $this->output['showPage']   = $total > $this->count ? 1 : 0;

        //统计信息
        $where_total = [];

        $where_total[] = ['name' => 'asl_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = ['name' => 'asl_status', 'oper' => '=', 'value' => 2];
        $where_sum[]   = ['name' => 'asd_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $totalCount    = $community_model->getCount($where_total);
        $deduct_model  = new App_Model_Sequence_MysqlSequenceDeductStorage($this->curr_sid);
        if ($area_info) {
            $deductSum = $deduct_model->deductSumByRegion($area_info['m_area_id'], $area_info['m_area_type']);
        } else {
            $deductSum = $deduct_model->deductSum($where_sum);
        }
        $statInfo = [
            'total' => $area_info ? $total : intval($totalCount),
            'money' => floatval($deductSum['money']),
        ];
        $this->output['statInfo'] = $statInfo;

        $sequenceShowAll = 1;
        if ($this->wxapp_cfg['ac_type'] == 36) {
            $sequenceShowAll = 0;
        }
        $this->output['sequenceShowAll'] = $sequenceShowAll;

        $this->buildBreadcrumbs(array(
            array('title' => '团长管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sequence/leader-list.tpl');
    }

    /*
     * 新增/编辑团长
     */
    public function leaderEditAction()
    {
        $id = $this->request->getIntParam('id', 0);
        // 区域合伙人
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);

        if ($id) {
            $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $row          = $leader_model->getLeaderRow($id);

           
            if ($area_info) {
                if ($row['asl_region_manager_id'] != $this->uid) {
                    plum_redirect_with_msg('无查看权限', $_SERVER['HTTP_REFERER'], true);
                }
            }

            $this->output['row'] = $row;
            if ($row['asl_parent_id'] > 0) {
                $parent                 = $leader_model->getLeaderRow($row['asl_parent_id']);
                $this->output['parent'] = $parent;
            }
        }else{
            $this->output['region'] =$area_info ? true :false;
        }
        $this->buildBreadcrumbs(array(
            array('title' => '团长管理', 'link' => '/wxapp/sequence/leaderList'),
            array('title' => '新增/编辑团长', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/sequence/leader-edit.tpl');
    }

    /*
     * 取消团长（非删除）
     */
    public function leaderRemoveAction()
    {
        $id = $this->request->getIntParam('id');

        // 区域合伙人
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);

        $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
        $res          = $leader_model->getRowUpdateByIdSid($id, $this->curr_sid, array('asl_status' => 4), $area_info ? $this->uid : 0);

        if ($res) {
            $this->_deal_leader_remove($id);
            $leader = $leader_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("取消团长【{$leader['asl_name']}】成功");
        }
        $this->showAjaxResult($res, '操作');
    }

    /*
     * 取消团长后续
     * id 团长id
     */
    private function _deal_leader_remove($id)
    {
        //移除团长与小区的关联记录
        // $aslc_model = new App_Model_Sequence_MysqlSequenceLeaderCommunityStorage($this->curr_sid);
        // $where_aslc[] = array('name'=>'aslc_s_id','oper'=>'=','value'=>$this->curr_sid);
        // $where_aslc[] = array('name'=>'aslc_leader','oper'=>'=','value'=>$id);
        // $aslc_model->deleteValue($where_aslc);
        //  将与此团长关联的小区团长id置零
        $asc_model   = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
        $where_asc[] = array('name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where_asc[] = array('name' => 'asc_leader', 'oper' => '=', 'value' => $id);
        $asc_model->updateValue(array('asc_leader' => 0), $where_asc);
    }

    /*
     * 团长申请管理
     */
    public function leaderApplyListOldAction()
    {
        $page         = $this->request->getIntParam('page');
        $index        = $page * $this->count;
        $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
        $where[]      = array('name' => 'asl_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]      = array('name' => 'asl_status', 'oper' => 'in', 'value' => [1, 2, 3]);

        $this->output['nickname'] = $this->request->getStrParam('nickname');
        if ($this->output['nickname']) {
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$this->output['nickname']}%");
        }
        $this->output['truename'] = $this->request->getStrParam('truename');
        if ($this->output['truename']) {
            $where[] = array('name' => 'asl_name', 'oper' => 'like', 'value' => "%{$this->output['truename']}%");
        }
        $this->output['showid'] = $this->request->getStrParam('showid');
        if ($this->output['showid']) {
            $where[] = array('name' => 'm_show_id', 'oper' => '=', 'value' => $this->output['showid']);
        }

        $sort    = array('asl_status' => 'ASC', 'asl_create_time' => 'DESC');
        $total   = $leader_model->getLeaderCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total, $this->count);

        $this->output['pagination'] = $pageCfg->render();
        $list                       = $leader_model->getLeaderList($where, $index, $this->count, $sort);
        $statusNote                 = array(
            1 => '待审核',
            2 => '已通过',
            3 => '已拒绝',
        );
        $this->output['statusNote'] = $statusNote;
        $this->output['list']       = $list;

        //获得统计信息
        $where_total   = $where_audit   = $where_pass   = [];
        $where_total[] = $where_audit[] = $where_pass[] = ['name' => 'asl_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = $where_audit[] = $where_pass[] = ['name' => 'asl_status', 'oper' => 'in', 'value' => [1, 2, 3]];
        $where_audit[] = ['name' => 'asl_status', 'oper' => '=', 'value' => 1];
        $where_pass[]  = ['name' => 'asl_status', 'oper' => '=', 'value' => 2];
        $totalCount    = $leader_model->getCount($where_total);
        $passCount     = $leader_model->getCount($where_pass);
        $auditCount    = $leader_model->getCount($where_audit);
        $refuseCount   = intval($totalCount) - intval($passCount) - intval($auditCount);
        $statInfo      = [
            'total'  => intval($totalCount),
            'pass'   => intval($passCount),
            'audit'  => intval($auditCount),
            'refuse' => $refuseCount > 0 ? $refuseCount : 0,
        ];
        $this->output['statInfo'] = $statInfo;

        $this->buildBreadcrumbs(array(
            array('title' => '团长申请管理', 'link' => '#'),
        ));
        $this->_get_area_list();
        $this->displaySmarty('wxapp/sequence/leader-apply-list.tpl');
    }

    /*
     * 团长申请管理
     */
    public function leaderApplyListAction()
    {
        $page = $this->request->getIntParam('page');

        $index        = $page * $this->count;
        $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
        $where[]      = array('name' => 'asl_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]      = array('name' => 'asl_status', 'oper' => 'in', 'value' => [1, 2, 3]);

        $this->output['nickname'] = $this->request->getStrParam('nickname');
        if ($this->output['nickname']) {
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$this->output['nickname']}%");
        }
        $this->output['truename'] = $this->request->getStrParam('truename');
        if ($this->output['truename']) {
            $where[] = array('name' => 'asl_name', 'oper' => 'like', 'value' => "%{$this->output['truename']}%");
        }
        $this->output['showid'] = $this->request->getStrParam('showid');
        if ($this->output['showid']) {
            $where[] = array('name' => 'm_show_id', 'oper' => '=', 'value' => $this->output['showid']);
        }

        $this->output['screenType'] = $this->request->getIntParam('screenType', 1);
        $where[]                    = array('name' => 'asl_status', 'oper' => '=', 'value' => $this->output['screenType']);

        $sort = array('asl_status' => 'ASC', 'asl_create_time' => 'DESC');
        // 获取区域合伙人信息
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            if ($area_info['m_area_id'] && $area_info['m_area_id'] > 0) {
                if ($area_info['m_area_type'] == 'C') {
                    $arer_where[] = ['name' => 'asa_city', 'oper' => '=', 'value' => $area_info['m_area_id']];
                } else if ($area_info['m_area_type'] == 'D') {
                    $arer_where[] = ['name' => 'asa_zone', 'oper' => '=', 'value' => $area_info['m_area_id']];
                }
                $arer_where[] = array('name' => 'asa_s_id', 'oper' => '=', 'value' => $this->curr_sid);
                $area_model   = new App_Model_Sequence_MysqlSequenceAreaStorage($this->curr_sid);
                $list         = $area_model->getListWithArea($arer_where, 0, 0);
            }
            $areaIds = array();
            if ($list) {
                foreach ($list as $val) {
                    $areaIds[] = $val['asa_id'];
                }
            }
            if (!empty($areaIds)) {
                $where[] = array('name' => 'asl_apply_area_id', 'oper' => 'in', 'value' => $areaIds);
            }
        }
        $total = $leader_model->getLeaderCount($where);

        $pageCfg                    = new Libs_Pagination_Paginator($total, $this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list                       = $leader_model->getLeaderListCommunity($where, $index, $this->count, $sort);
        $statusNote                 = array(
            1 => '待审核',
            2 => '已通过',
            3 => '已拒绝',
        );
        $this->output['statusNote'] = $statusNote;
        $this->output['list']       = $list;
        $this->output['showPage']   = $total > $this->count ? 1 : 0;

        //获得统计信息
        $where_total   = $where_audit   = $where_pass   = [];
        $where_total[] = $where_audit[] = $where_pass[] = ['name' => 'asl_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = $where_audit[] = $where_pass[] = ['name' => 'asl_status', 'oper' => 'in', 'value' => [1, 2, 3]];
        $where_audit[] = ['name' => 'asl_status', 'oper' => '=', 'value' => 1];
        $where_pass[]  = ['name' => 'asl_status', 'oper' => '=', 'value' => 2];
        $totalCount    = $leader_model->getCount($where_total);
        $passCount     = $leader_model->getCount($where_pass);
        $auditCount    = $leader_model->getCount($where_audit);
        $refuseCount   = intval($totalCount) - intval($passCount) - intval($auditCount);
        $statInfo      = [
            'total'  => intval($totalCount),
            'pass'   => intval($passCount),
            'audit'  => intval($auditCount),
            'refuse' => $refuseCount > 0 ? $refuseCount : 0,
        ];
        $this->output['statInfo']      = $statInfo;
        $this->output['refuse_reason'] = plum_parse_config('sequence_leader_refuse');
        $this->buildBreadcrumbs(array(
            array('title' => '团长申请管理', 'link' => '#'),
        ));
        $this->_get_area_list();
        $this->displaySmarty('wxapp/sequence/leader-apply-list-new.tpl');
    }

    /*
     * 处理团长申请
     */
    public function leaderApplyHandleAction()
    {
        $result = array(
            'ec' => 400,
            'em' => '处理失败',
        );
        $id      = $this->request->getIntParam('id');
        $market  = $this->request->getStrParam('market');
        $status  = $this->request->getIntParam('status');
        $passNum = $this->request->getIntParam('passNum');

        //检查团长数量是否被代理商限制
        $close_cfg = $this->curr_shop['s_agent_close'] ? json_decode($this->curr_shop['s_agent_close'], 1) : [];
        if (isset($close_cfg['leader']) && $close_cfg['leader']['val'] > 0) {
            $leader_limit = $close_cfg['leader']['val'];
            if ($passNum >= $leader_limit) {
                $this->displayJsonError('已超过最大团长数量' . $leader_limit . '，不能添加');
            }
        }

        if ($status && $id) {
            $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $row          = $leader_model->getRowById($id);
            $data         = array(
                'asl_handle_time'   => time(),
                'asl_handle_remark' => $market,
                'asl_status'        => $status,
            );
            $res = $leader_model->getRowUpdateByIdSid($id, $this->curr_sid, $data);
            if ($res) {
                $result = array(
                    'ec' => 200,
                    'em' => '处理成功',
                );
                $str = $status == 2 ? '通过' : '不通过';
                App_Helper_OperateLog::saveOperateLog("处理团长申请【{$row['asl_name']}】成功，处理结果：{$str}");
            }
        }
        $this->displayJson($result);
    }

    /*
     * 处理团长申请拒绝
     */
    public function leaderApplyRefuseAction()
    {
        $result = array(
            'ec' => 400,
            'em' => '处理失败',
        );
        $id         = $this->request->getIntParam('id');
        $market     = $this->request->getStrParam('market');
        $reason     = $this->request->getIntParam('reason');
        $resson_arr = plum_parse_config('sequence_leader_refuse');
        if ($reason > 0) {
            $reason_desc = $resson_arr[$reason];
        } elseif ($reason < 0) {
            $reason_desc = $market;
        } else {
            $reason_desc = '';
        }

        if ($id) {
            $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $row          = $leader_model->getRowById($id);
            $set          = [
                'asl_status'        => 3,
                'asl_handle_time'   => time(),
                'asl_handle_remark' => $reason_desc,
            ];
            $res = $leader_model->updateById($set, $id);
            if ($res) {
                $setup_model = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
                $setup       = $setup_model->findOneBySid();
                if (isset($setup["aws_leader_handle_open"]) && $setup["aws_leader_handle_open"]) {
                    plum_open_backend('templmsg', 'leaderHandleTempl', array('sid' => $this->curr_sid, 'id' => $id, 'mid' => $setup["aws_leader_handle_mid"], 'comid' => 0));
                }
                $result = array(
                    'ec' => 200,
                    'em' => '处理成功',
                );
                App_Helper_OperateLog::saveOperateLog("处理团长申请【{$row['asl_name']}】成功，处理结果：不通过");
            }
        }
        $this->displayJson($result);
    }

    /*
     * 同意团长申请
     */
    public function leaderApplyConfirmAction()
    {
        $result = array(
            'ec' => 400,
            'em' => '处理失败',
        );
        $id          = $this->request->getIntParam('id');
        $market      = $this->request->getStrParam('market');
        $areaName    = $this->request->getStrParam('areaName');
        $comName     = $this->request->getStrParam('comName');
        $areaId      = $this->request->getIntParam('areaId');
        $comId       = $this->request->getIntParam('comId');
        $areaType    = $this->request->getIntParam('areaType');
        $comType     = $this->request->getIntParam('comType');
        $name        = $this->request->getStrParam('name');
        $mobile      = $this->request->getStrParam('mobile');
        $wxcode      = $this->request->getStrParam('wxcode');
        $shopName    = $this->request->getStrParam('shopName');
        $addrDetail  = $this->request->getStrParam('addrDetail');
        $lng         = $this->request->getStrParam('lng');
        $lat         = $this->request->getStrParam('lat');
        $addr        = $this->request->getStrParam('addr');
        $province    = $this->request->getIntParam('province');
        $city        = $this->request->getIntParam('city');
        $zone        = $this->request->getIntParam('zone');
        $fakeMember  = $this->request->getIntParam('fakeMember');
        $sequenceNum = $this->request->getIntParam('sequenceNum');
        $timeNow     = time();
        $com_msg     = '';
        if (!$id) {
            $this->displayJsonError('未找到团长信息');
        }

        //处理街道
        if ($areaId && $areaType == 2) {
            //不作处理
        } elseif ($areaType == 1 && $province && $city && $zone && $areaName) {
            //添加街道
            $area_model  = new App_Model_Sequence_MysqlSequenceAreaStorage($this->curr_sid);
            $area_insert = [
                'asa_s_id'        => $this->curr_sid,
                'asa_name'        => $areaName,
                'asa_province'    => $province,
                'asa_city'        => $city,
                'asa_zone'        => $zone,
                'asa_create_time' => $timeNow,
                'asa_update_time' => $timeNow,
            ];
            $areaId = $area_model->insertValue($area_insert);
        }

        //处理社区
        if ($areaId) {
            $com_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
            if ($comId && $comType == 2) {
                //更新小区信息
                $com_update = [
                    'asc_area'           => $areaId,
                    'asc_leader'         => $id,
                    'asc_shop_name'      => $shopName,
                    'asc_address_detail' => $addrDetail,
                    'asc_update_time'    => $timeNow,
                ];
                $com_model->updateById($com_update, $comId);
            } elseif ($comType == 1 && $comName && $addr && $lng && $lat) {
                //添加小区
                $com_insert = [
                    'asc_s_id'           => $this->curr_sid,
                    'asc_leader'         => $id,
                    'asc_area'           => $areaId,
                    'asc_name'           => $comName,
                    'asc_address'        => $addr,
                    'asc_address_detail' => $addrDetail,
                    'asc_lng'            => $lng,
                    'asc_lat'            => $lat,
                    'asc_shop_name'      => $shopName,
                    'asc_sequence_num'   => $sequenceNum,
                    'asc_fake_member'    => $fakeMember,
                    'asc_create_time'    => $timeNow,
                    'asc_update_time'    => $timeNow,
                ];
                $comId = $com_model->insertValue($com_insert);
            } else {
                $com_msg = '，未获得小区地址，请手动添加小区并关联团长';
            }
        }
        //处理团长
        $leader_model  = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
        $leader_update = [
            'asl_name'          => $name,
            'asl_mobile'        => $mobile,
            'asl_wxcode'        => $wxcode,
            'asl_status'        => 2,
            'asl_handle_time'   => $timeNow,
            'asl_handle_remark' => $market,
            'asl_update_time'   => $timeNow,
        ];
        // 社区团购区域管理合伙人
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $leader_update['asl_region_manager_id'] = $this->uid;
        }
        $res = $leader_model->updateById($leader_update, $id);
        if ($res) {
            $setup_model = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
            $setup       = $setup_model->findOneBySid();
            if (isset($setup["aws_leader_handle_open"]) && $setup["aws_leader_handle_open"]) {
                plum_open_backend('templmsg', 'leaderHandleTempl', array('sid' => $this->curr_sid, 'id' => $id, 'mid' => $setup["aws_leader_handle_mid"], 'comid' => $comId));
            }

            $result = [
                'ec' => 200,
                'em' => '处理成功' . $com_msg,
            ];
            App_Helper_OperateLog::saveOperateLog("处理团长申请【{$name}】成功，处理结果：通过");
        }

        $this->displayJson($result);
    }

    /**
     * 异步获取团长关联
     */
    public function fetchMemberLeaderAction()
    {
        $this->count = 10;
        $id          = $this->request->getIntParam('id');
        $nickname    = $this->request->getStrParam('nickname');
        $truename    = $this->request->getStrParam('truename');
        $page        = $this->request->getIntParam('page', 1);
        $page        = $page >= 1 ? $page : 1;
        $type        = $this->request->getStrParam('type', 'leader');
        $index       = ($page - 1) * $this->count;
        $where       = array();
        if ($type == 'leader' || $type == 'leader-coupon') {
            $where[] = array('name' => 'asl_status', 'oper' => '=', 'value' => 2);
        }
        if ($nickname) {
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$nickname}%");
        }
        if ($truename) {
            $where[] = array('name' => 'asl_name', 'oper' => 'like', 'value' => "%{$truename}%");
        }
        $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);

        // 社区团购区域管理合伙人
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $where[] = ['name' => 'asl_region_manager_id', 'oper' => '=', 'value' => $this->uid];
        }

        $sort         = array('m_show_id' => 'desc');
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $list         = $member_model->getMemberLeaderList($where, $index, $this->count, $sort);
        $total        = $member_model->getMemberLeaderCount($where);
        $tot_page     = ceil($total / $this->count);

        $menu_helper = new App_Helper_Menu();
        $menu        = $menu_helper->ajaxPageLink($tot_page, $page);

        $data = array(
            'ec'       => 200,
            'list'     => $list,
            'pageHtml' => $menu,
        );
        $this->displayJson($data);
    }

    /*
     * 添加团长至小区
     */
    public function addCommunityLeaderAction()
    {
        $result = array(
            'em' => '关联失败',
            'ec' => 400,
        );
        $cid = $this->request->getIntParam('cid'); //小区id
        //$type = $this->request->getStrParam('type');
        $mid = $this->request->getIntParam('mid'); //团长用户id
        $id  = $this->request->getIntParam('id'); //团长id

        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);

        // 区域管理合伙人是否可以添加此社区的团长
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $has_area = $community_model->checkCommunityIsMine($area_info['m_area_id'], $cid, $area_info['m_area_type']);
            if (!$has_area) {
                $this->displayJson(['em' => '您当前没有为该社区设置团长的权限'], 1);
            }

        }

        if ($cid && $id && $mid) {

            // $aslc_model = new App_Model_Sequence_MysqlSequenceLeaderCommunityStorage($this->curr_sid);
            // if($community['asc_leader'] > 0){
            //     //小区已有关联团长，移除原记录
            //     $where_aslc[] = array('name'=>'aslc_s_id','oper'=>'=','value'=>$this->curr_sid);
            //     $where_aslc[] = array('name'=>'aslc_community','oper'=>'=','value'=>$cid);
            //     $where_aslc[] = array('name'=>'aslc_leader','oper'=>'=','value'=>$community['asc_leader']);
            //     $aslc_model->deleteValue($where_aslc);
            // }
            // $data = array(
            //     'aslc_s_id' => $this->curr_sid,
            //     'aslc_m_id' => $mid,
            //     'aslc_leader' => $id,
            //     'aslc_community' => $cid,
            //     'aslc_create_time' => time()
            // );
            // $ret = $aslc_model->insertValue($data);
            // if($ret){

            // }
            $res = $community_model->updateById(array('asc_leader' => $id), $cid);
            if ($res) {
                $result = array(
                    'em' => '关联成功',
                    'ec' => 200,
                );
                $community    = $community_model->getRowById($cid);
                $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
                $leader       = $leader_model->getRowById($id);
                App_Helper_OperateLog::saveOperateLog("关联团长【{$leader['asl_name']}】至小区【{$community['asc_name']}】");
            }
        }
        $this->displayJson($result);
    }

    /*
     * 保存团长信息
     */
    public function leaderSaveAction()
    {
        $result = array(
            'ec' => 400,
            'em' => '保存失败',
        );

        //检查团长数量是否被代理商限制
        $close_cfg = $this->curr_shop['s_agent_close'] ? json_decode($this->curr_shop['s_agent_close'], 1) : [];
        if (isset($close_cfg['leader']) && $close_cfg['leader']['val'] > 0) {
            $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $where_pass   = [];
            $where_pass[] = ['name' => 'asl_s_id', 'oper' => '=', 'value' => $this->curr_sid];
            $where_pass[] = ['name' => 'asl_status', 'oper' => '=', 'value' => 2];
            $passCount    = $leader_model->getCount($where_pass);
            $passNum      = intval($passCount);
            $leader_limit = $close_cfg['leader']['val'];
            if ($passNum >= $leader_limit) {
                $this->displayJsonError('已超过最大团长数量' . $leader_limit . '，不能添加');
            }
        }

        $id           = $this->request->getIntParam('id');
        $mobile       = $this->request->getIntParam('mobile');
        $name         = $this->request->getStrParam('name');
        $mid          = $this->request->getIntParam('mid');
        $percent      = $this->request->getIntParam('percent');
        $parent       = $this->request->getIntParam('parent');
        $parentMid    = $this->request->getIntParam('parentMid');
        $remark       = $this->request->getStrParam('remark');
        $qrcode       = $this->request->getStrParam('qrcode');
        $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
        if ($name && $mobile) {
            $leader = $leader_model->getRowByMid($mid);
            $data   = array(
                'asl_s_id'        => $this->curr_sid,
                'asl_name'        => $name,
                'asl_mobile'      => $mobile,
                'asl_percent'     => $percent,
                'asl_parent_id'   => $parent,
                'asl_parent_mid'  => $parentMid,
                'asl_remark'      => $remark,
                'asl_qrcode'      => $qrcode,
                'asl_update_time' => time(),
            );
            //区域合伙人去掉团长分佣字段
            //zhangzc
            //2020-01-08
            $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
            if($area_info){
                unset($data['asl_percent']);
            }

            // 区域管理合伙人
            $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);

            if ($id) {
                if ($area_info) {
                    $leader = $leader_model->getRow([
                        ['name' => 'asl_id', 'oper' => '=', 'value' => $id],
                    ]);
                    if ($leader && ($leader['asl_region_manager_id'] != $this->uid)) {
                        $this->displayJson(['em' => '无法编辑当前团长信息'], 1);
                    }

                }
                $res = $leader_model->updateById($data, $id);
            } elseif ($leader) {
                //已被取消的团长 再次添加的时候
                if ($area_info) {
                    if ($leader && ($leader['asl_region_manager_id'] != $this->uid)) {
                        $this->displayJson(['em' => '无法编辑当前团长信息'], 1);
                    }

                }
                $data['asl_status'] = 2;
                $res                = $leader_model->updateById($data, $leader['asl_id']);
            } else {
                $data['asl_m_id']              = $mid;
                $data['asl_status']            = 2;
                $data['asl_create_time']       = time();
                $data['asl_create_by']         = $this->uid;
                $data['asl_region_manager_id'] = $this->uid;
                $res                           = $leader_model->insertValue($data);

            }
            if ($res) {
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功',
                );
                App_Helper_OperateLog::saveOperateLog("团长【{$name}】信息保存成功");
            }
        } else {
            $result = array(
                'ec' => 400,
                'em' => '请将信息补充完整',
            );
        }
        $this->displayJson($result);

    }

    /*
     * 供应商申请表
     */
    public function supplierApplyListAction()
    {
        $page         = $this->request->getIntParam('page');
        $index        = $page * $this->count;
        $leader_model = new App_Model_Sequence_MysqlSequenceSupplierStorage($this->curr_sid);
        $where[]      = array('name' => 'ass_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]      = array('name' => 'ass_status', 'oper' => 'in', 'value' => [1, 2, 3]);

        $this->output['nickname'] = $this->request->getStrParam('nickname');
        if ($this->output['nickname']) {
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$this->output['nickname']}%");
        }
        $this->output['showid'] = $this->request->getStrParam('showid');
        if ($this->output['showid']) {
            $where[] = array('name' => 'm_show_id', 'oper' => '=', 'value' => $this->output['showid']);
        }

        $sort                       = array('ass_status' => 'ASC', 'ass_create_time' => 'DESC');
        $total                      = $leader_model->getSupplierCount($where);
        $pageCfg                    = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['pagination'] = $pageCfg->render();
        $list                       = $leader_model->getSupplierList($where, $index, $this->count, $sort);
        $this->output['showPage']   = $total > $this->count ? 1 : 0;
        $statusNote                 = array(
            1 => '待处理',
            2 => '已通过',
            3 => '已拒绝',
        );
        $this->output['statusNote'] = $statusNote;
        $this->output['list']       = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '供应商申请管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sequence/supplier-apply-list.tpl');
    }

    /*
     * 处理团长申请
     */
    public function supplierApplyHandleAction()
    {
        $result = array(
            'ec' => 400,
            'em' => '处理失败',
        );
        $id     = $this->request->getIntParam('id');
        $market = $this->request->getStrParam('market');
        $status = $this->request->getIntParam('status');

        if ($status && $id) {
            $leader_model = new App_Model_Sequence_MysqlSequenceSupplierStorage($this->curr_sid);
            $data         = array(
                'ass_handle_time'   => time(),
                'ass_handle_remark' => $market,
                'ass_status'        => $status,
            );
            $res = $leader_model->getRowUpdateByIdSid($id, $this->curr_sid, $data);
            if ($res) {
                $result = array(
                    'ec' => 200,
                    'em' => '处理成功',
                );
                App_Helper_OperateLog::saveOperateLog("供应商申请处理成功");
            }
        }
        $this->displayJson($result);
    }

    /*
     * 活动列表
     */
    public function activityListAction()
    {
        $page           = $this->request->getIntParam('page');
        $index          = $page * $this->count;
        $activity_model = new App_Model_Sequence_MysqlSequenceActivityStorage($this->curr_sid);
        $where[]        = array('name' => 'asa_s_id', 'oper' => '=', 'value' => $this->curr_sid);

        $this->output['title'] = $this->request->getStrParam('title');
        if ($this->output['title']) {
            $where[] = array('name' => 'asa_title', 'oper' => 'like', 'value' => "%{$this->output['title']}%");
        }

        $sort                       = array('asa_update_time' => 'DESC');
        $total                      = $activity_model->getCount($where);
        $pageCfg                    = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['pagination'] = $pageCfg->render();
        $list                       = $activity_model->getList($where, $index, $this->count, $sort);
        $this->output['showPage']   = $total > $this->count ? 1 : 0;
        $this->output['list']       = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '活动管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sequence/activity-list.tpl');
    }

    /*
     * 添加/编辑活动
     */
    public function activityEditAction()
    {
        $id = $this->request->getIntParam('id');
        if ($id) {
            $activity_model      = new App_Model_Sequence_MysqlSequenceActivityStorage($this->curr_sid);
            $row                 = $activity_model->getRowById($id);
            $this->output['row'] = $row;
            //获得活动图片
            $this->_get_activity_img($id);
        }
        $this->buildBreadcrumbs(array(
            array('title' => '活动管理', 'link' => '/wxapp/sequence/activityList'),
            array('title' => '编辑/修改活动', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/sequence/activity-edit.tpl');
    }

    private function _get_activity_img($id, $return = false)
    {
        $data      = array();
        $img_model = new App_Model_Sequence_MysqlSequenceActivityImgStorage($this->curr_sid);
        $list      = $img_model->fetchImgList($id);
        if ($list) {
            $data = $list;
        }
        if ($return) {
            return $data;
        } else {
            $this->output['imgList'] = $data;
        }
    }

    /*
     * 保存活动
     */
    public function activitySaveAction()
    {
        $id                 = $this->request->getIntParam('id');
        $index_show         = $this->request->getIntParam('index_show', 1);
        $sort               = $this->request->getIntParam('sort');
        $title              = $this->request->getStrParam('title');
        $desc               = $this->request->getStrParam('desc');
        $start              = $this->request->getStrParam('start');
        $end                = $this->request->getStrParam('end');
        $receive_start      = $this->request->getStrParam('receive_start');
        $receive_end        = $this->request->getStrParam('receive_end');
        $avatar             = $this->request->getStrParam('avatar');
        $nickname           = $this->request->getStrParam('nickname');
        $mobile             = $this->request->getStrParam('mobile');
        $show_num           = $this->request->getIntParam('show_num');
        $start_time         = strtotime($start);
        $end_time           = strtotime($end);
        $receive_start_time = strtotime($receive_start);
        $receive_end_time   = strtotime($receive_end);
        // if($this->wxapp_cfg['ac_type'] < 20){
        //     if($start_time > $receive_start_time){
        //         $this->displayJsonError('提货开始时间不能早于活动开始时间');
        //     }
        //     if($end_time > $receive_end_time){
        //         $this->displayJsonError('提货结束时间不能早于活动结束时间');
        //     }
        //     if($end_time < $start_time){
        //         $this->displayJsonError('活动结束时间不能早于活动开始时间');
        //     }
        //     if($receive_end_time < $receive_start_time ){
        //         $this->displayJsonError('提货结束时间不能早于提货开始时间');
        //     }
        // }

        $data = array(
            'asa_title'         => $title,
            'asa_desc'          => $desc,
            'asa_start'         => $start_time,
            'asa_end'           => $end_time,
            'asa_receive_start' => $receive_start_time,
            'asa_receive_end'   => $receive_end_time,
            'asa_avatar'        => $avatar,
            'asa_nickname'      => $nickname,
            'asa_mobile'        => $mobile,
            'asa_sort'          => $sort,
            'asa_index_show'    => $index_show,
            'asa_show_num'      => $show_num,
            'asa_update_time'   => time(),
        );

        $activity_model = new App_Model_Sequence_MysqlSequenceActivityStorage($this->curr_sid);
        if ($id) {
            $res = $activity_model->getRowUpdateByIdSid($id, $this->curr_sid, $data);
        } else {
            $data['asa_create_time'] = time();
            $data['asa_s_id']        = $this->curr_sid;
            $res                     = $id                     = $activity_model->insertValue($data);
        }
        if ($res) {
            $this->_save_activity_img($id);
            App_Helper_OperateLog::saveOperateLog("活动【{$title}】保存成功");
        }
        $this->showAjaxResult($res, '保存');
    }

    /*
     * 保存活动图片
     */
    private function _save_activity_img($id)
    {
        $shortcut       = $this->request->getArrParam('imgArr');
        $shortcut_model = new App_Model_Sequence_MysqlSequenceActivityImgStorage($this->curr_sid);
        if (!empty($shortcut)) {
            $where[]       = array('name' => 'asai_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[]       = array('name' => 'asai_deleted', 'oper' => '=', 'value' => 0); //未删除
            $where[]       = array('name' => 'asai_a_id', 'oper' => '=', 'value' => $id);
            $shortcut_list = $shortcut_model->getList($where, 0, 0);
            if (!empty($shortcut_list)) {
                $del_id = array();
                foreach ($shortcut_list as $val) {
                    $has   = false;
                    $index = 0;
                    foreach ($shortcut as $key => $v) {
                        if ($v['id'] == $val['asai_id']) {
                            $index = $key;
                            $has   = true;
                        }
                    }
                    if ($has) {
                        //存在这个位置的快捷导航，更新
                        $set = array(
                            'asai_sort'        => $index,
                            'asai_path'        => $shortcut[$index]['path'],
                            'asai_create_time' => time(),
                        );

                        $up_ret = $shortcut_model->updateById($set, $val['asai_id']);
                        unset($shortcut[$index]); //然后清理前端传过来的快捷导航
                    } else {
                        //多余的删除
                        $del_id[] = $val['asai_id'];
                    }
                }
                if (!empty($del_id)) {
                    $shortcut_where   = array();
                    $shortcut_where[] = array('name' => 'asai_id', 'oper' => 'in', 'value' => $del_id);
                    $shortcut_where[] = array('name' => 'asai_a_id', 'oper' => '=', 'value' => $id);
                    $shortcut_model->deleteValue($shortcut_where);
                }

            }

            //新增的快捷导航
            if (!empty($shortcut)) {
                $insert = array();
                foreach ($shortcut as $val) {
                    $insert[] = " (NULL, '{$this->curr_sid}', '{$id}', '{$val['path']}', '{$val['index']}', '0', '" . time() . "') ";
                }
                $ins_ret = $shortcut_model->insertBatch($insert);
            }
        } else {
            //若数组为空，则清空该店铺快捷导航
            $where   = array();
            $where[] = array('name' => 'asai_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'asai_a_id', 'oper' => '=', 'value' => $id);
            $shortcut_model->deleteValue($where);
        }
    }

    /*
     * 活动批量上下线
     */
    public function activityShelfAction()
    {
        $ids    = $this->request->getStrParam('ids');
        $id_arr = plum_explode($ids);
        $type   = $this->request->getStrParam('type');
        $result = array(
            'ec' => 400,
            'em' => '您尚未选择活动',
        );
        if (!empty($id_arr)) {
            if ($type == 'down') {
                //下架
                $set = array(
                    'asa_is_on' => 2,
                );
            } else {
                //上架
                $set = array(
                    'asa_is_on' => 1,
                );
            }
            $where          = array();
            $where[]        = array('name' => 'asa_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[]        = array('name' => 'asa_id', 'oper' => 'in', 'value' => $id_arr);
            $activity_model = new App_Model_Sequence_MysqlSequenceActivityStorage($this->curr_sid);
            $ret            = $activity_model->updateValue($set, $where);
            if ($ret) {
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功',
                );
            } else {
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }

    /*
     * 查看活动商品
     */
    public function activityGoodsListAction()
    {
        $page          = $this->request->getIntParam('page');
        $index         = $page * $this->count;
        $id            = $this->request->getIntParam('id');
        $output['aid'] = $id;
        $where[]       = array('name' => 'asag_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]       = array('name' => 'asag_a_id', 'oper' => '=', 'value' => $id);

        $output['name'] = $this->request->getStrParam('name');
        if ($output['name']) {
            $where[] = array('name' => 'g_name', 'oper' => 'like', 'value' => "%{$output['name']}%");
        }
        $output['cate'] = $this->request->getIntParam('cate');
        if ($output['cate']) {
            $where[] = array('name' => 'g_kind2', 'oper' => '=', 'value' => $output['cate']);
        }
        $where[]             = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $asag_model          = new App_Model_Sequence_MysqlSequenceActivityGoodsStorage($this->curr_sid);
        $total               = $asag_model->fetchGoodsCount($where);
        $pageCfg             = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $output['paginator'] = $pageCfg->render();
        $list                = array();

        if ($index <= $total) {
            $sort = array('asag_sort' => 'DESC', 'asag_create_time' => 'DESC');
            $list = $asag_model->fetchGoodsList($where, $index, $this->count, $sort);
        }
        if ($list) {
            $output['now'] = 1;
        }
        $output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '活动管理', 'link' => '/wxapp/sequence/activityList'),
            array('title' => '查看活动商品', 'link' => '#'),
        ));
        $this->_show_goods_category_type();
        $this->showOutput($output);
        $this->displaySmarty('wxapp/sequence/activity-goods-list.tpl');

    }

    /*
     * 编辑活动商品
     */
    public function activityGoodsEditAction()
    {
        $id                  = $this->request->getIntParam('id'); //活动id
        $this->output['aid'] = $id;
        $this->buildBreadcrumbs(array(
            array('title' => '活动管理', 'link' => '/wxapp/sequence/activityList'),
            array('title' => '编辑活动商品', 'link' => '#'),
        ));
        $this->_show_goods_category_type();
        $this->_show_goods_list_data($id);

        $sequenceShowAll = 1;
        if ($this->wxapp_cfg['ac_type'] == 36) {
            $sequenceShowAll = 0;
        }
        $this->output['sequenceShowAll'] = $sequenceShowAll;

        $this->displaySmarty('wxapp/sequence/activity-goods-edit.tpl');
    }

    private function _show_supplier_list()
    {
        $supplier_model = new App_Model_Sequence_MysqlSequenceSupplierInfoStorage($this->curr_sid);
        $data           = [];
        $where          = [];
        $where[]        = ['name' => 'assi_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $list           = $supplier_model->getList($where, 0, 0);
        if ($list) {
            foreach ($list as $val) {
                $data[] = [
                    'name' => $val['assi_name'],
                    'id'   => $val['assi_id'],
                ];
            }
        }
        $this->output['supplierList'] = $data;
    }

    /*
     * 获得分佣比例
     */
    private function _get_goods_ratio($id)
    {
        $ratio       = [];
        $ratio_model = new App_Model_Sequence_MysqlSequenceGoodsDeductStorage($this->curr_sid);
        $row         = $ratio_model->getRowByGid($id);
        if ($row) {
            $ratio = $row;
        }
        $this->output['ratio'] = $ratio;
    }
    /**
     * 社区团购区域管理合伙人单独商品的佣金获取
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    private function _get_region_goods_ratio($goods_id)
    {
        $region_ratio       = [];
        $region_ratio_model = new App_Model_Sequence_MysqlSequenceRegionGoodsDeductStorage($this->curr_sid);
        $row                = $region_ratio_model->getRowByGid($goods_id);
        if ($row) {
            $region_ratio = $row;
        }
        $this->output['region_ratio'] = $region_ratio;
    }

    /**
     * @param int $is_add
     * 展示商品类目
     */
    private function _show_goods_category_type()
    {

        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $temp           = $category_model->getAllSonCategory();
        $category       = array();
        foreach ($temp as $val) {
            $category[$val['sk_id']] = $val['sk_name'];
        }
        $this->output['category'] = $category;
        $this->output['type']     = plum_parse_config('goodsType');
    }

    private function _show_goods_list_data($id)
    {
        // $this->count = 5;
        $where   = array();
        $where[] = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'g_type', 'oper' => 'in', 'value' => array(1, 2));
        $where[] = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);
        //$where[]        = array('name' => 'asag_a_id','oper' => '=','value' => $id);
        $output['name'] = $this->request->getStrParam('name');
        if ($output['name']) {
            $where[] = array('name' => 'g_name', 'oper' => 'like', 'value' => "%{$output['name']}%");
        }

        $output['cate'] = $this->request->getIntParam('cate');
        if ($output['cate']) {
            $where[] = array('name' => 'g_kind2', 'oper' => '=', 'value' => $output['cate']);
        }

        $page                = $this->request->getIntParam('page');
        $index               = $page * $this->count;
        $goods_model         = new App_Model_Goods_MysqlGoodsStorage();
        $total               = $goods_model->getCountSequence($id, $where);
        $output['total']     = $total;
        $pageCfg             = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $output['paginator'] = $pageCfg->render();
        $list                = array();

        if ($index <= $total) {
            $sort = array('g_update_time' => 'DESC');
            $list = $goods_model->getListSequence($id, $where, $index, $this->count, $sort);
        }
        // $asag_model = new App_Model_Sequence_MysqlSequenceActivityGoodsStorage($this->curr_sid);
        // $asagList = $asag_model->getListByAid($id);
        // $gids = [];
        // if($asagList){
        //     foreach ($asagList as $val){
        //         if(!in_array($val['asag_g_id'],$gids)){
        //             $gids[] = $val['asag_g_id'];
        //         }
        //     }
        // }
        if ($list) {
            // foreach ($list as $key => $value){
            //     if(in_array($value['g_id'],$gids)){
            //         $list[$key]['had'] = 1;
            //     }
            // }
            $output['now'] = 1;
        }
        $output['list'] = $list;
        $this->showOutput($output);
    }

    /*
     * 活动添加或移除单个商品
     */
    public function selectGoodsSingleAction()
    {
        $gid  = $this->request->getIntParam('gid');
        $aid  = $this->request->getIntParam('aid');
        $type = $this->request->getStrParam('type');
        $res  = false;
        if ($aid && $gid && $type) {
            $asag_model = new App_Model_Sequence_MysqlSequenceActivityGoodsStorage($this->curr_sid);
            $row        = $asag_model->fetchRow($aid, $gid);
            if ($type == 'add') {
                if ($row) {
                    $this->displayJsonError('商品已经存在');
                } else {
                    $data = array(
                        'asag_s_id'        => $this->curr_sid,
                        'asag_a_id'        => $aid,
                        'asag_g_id'        => $gid,
                        'asag_create_time' => time(),
                    );
                    $res = $asag_model->insertValue($data);
                }
            } elseif ($type == 'remove') {
                if (!$row) {
                    $this->displayJsonError('商品不存在');
                } else {
                    $res = $asag_model->deleteBySidId($row['asag_id'], $this->curr_sid);
                }
            } else {
                $this->displayJsonError('操作异常');
            }

            if ($res) {
                $activity_model = new App_Model_Sequence_MysqlSequenceActivityStorage($this->curr_sid);
                $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
                $activity       = $activity_model->getRowById($aid);
                $goods          = $goods_model->getRowById($aid);
                $str            = $type == 'add' ? '添加' : '移除';
                App_Helper_OperateLog::saveOperateLog("活动【{$activity['asa_title']}】{$str}商品【{$goods['g_name']}】成功");
            }

            $this->showAjaxResult($res, '操作');
        } else {
            $this->displayJsonError('操作异常');
        }

    }

    /*
     * 活动添加或移除多个商品
     */
    public function selectGoodsMultiAction()
    {
        $ids    = $this->request->getStrParam('ids');
        $id_arr = plum_explode($ids);
        $aid    = $this->request->getIntParam('aid');
        $type   = $this->request->getStrParam('type');
        $res    = false;
        if ($aid && $id_arr && $type) {
            $asag_model = new App_Model_Sequence_MysqlSequenceActivityGoodsStorage($this->curr_sid);
            if ($type == 'add') {
                foreach ($id_arr as $val) {
                    $row = $asag_model->fetchRow($aid, $val);
                    if (!$row) {
//如果不存在，添加
                        $data = array(
                            'asag_s_id'        => $this->curr_sid,
                            'asag_a_id'        => $aid,
                            'asag_g_id'        => $val,
                            'asag_create_time' => time(),
                        );
                        $res = $asag_model->insertValue($data);
                    }
                }

            } elseif ($type == 'remove') {
                //全部删除
                $where[] = array('name' => 'asag_s_id', 'oper' => '=', 'value' => $this->curr_sid);
                $where[] = array('name' => 'asag_a_id', 'oper' => '=', 'value' => $aid);
                $where[] = array('name' => 'asag_g_id', 'oper' => 'in', 'value' => $id_arr);
                $res     = $asag_model->deleteValue($where);
            } else {
                $this->displayJsonError('操作异常');
            }

            if ($res) {
                $activity_model = new App_Model_Sequence_MysqlSequenceActivityStorage($this->curr_sid);
                $activity       = $activity_model->getRowById($aid);
                $str            = $type == 'add' ? '添加' : '移除';
                App_Helper_OperateLog::saveOperateLog("活动【{$activity['asa_title']}】批量{$str}商品成功");
            }

            $this->showAjaxResult($res, '操作');
        } else {
            $this->displayJsonError('操作异常');
        }

    }

    /*
     * 修改活动关联商品排序
     */
    public function changeActivityGoodsInfoAction()
    {
        $id         = $this->request->getIntParam('id');
        $value      = $this->request->getIntParam('value');
        $field      = $this->request->getStrParam('field');
        $asag_model = new App_Model_Sequence_MysqlSequenceActivityGoodsStorage($this->curr_sid);
        if ($id) {
            if ($value >= 0) {
                $res = $asag_model->updateById(array('asag_sort' => $value), $id);

                if ($res) {
                    App_Helper_OperateLog::saveOperateLog("活动商品排序保存成功");
                }

                $this->showAjaxResult($res, '保存');
            } else {
                $this->displayJsonError('排序不能小于0');
            }
        } else {
            $this->displayJsonError('操作异常');
        }

    }

    /*
     * 编辑活动关联小区
     */
    public function activityCommunityEditAction()
    {
        $page           = $this->request->getIntParam('page');
        $index          = $page * $this->count;
        $id             = $this->request->getIntParam('id');
        $output['aid']  = $id;
        $where[]        = array('name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $output['name'] = $this->request->getStrParam('name');
        if ($output['name']) {
            $where[] = array('name' => 'asc_name', 'oper' => 'like', 'value' => "%{$output['name']}%");
        }
        $output['area'] = $this->request->getIntParam('area');
        if ($output['area']) {
            $where[] = array('name' => 'asc_area', 'oper' => '=', 'value' => $output['area']);
        }
        $where[] = array('name' => 'asc_status', 'oper' => '=', 'value' => 2);

        $community_model     = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
        $total               = $community_model->getCountSequence($id, $where);
        $pageCfg             = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $output['paginator'] = $pageCfg->render();
        $list                = array();

        if ($index <= $total) {
            //$sort = array('asac_sort' => 'DESC','asac_create_time'=>'DESC');
            $sort = array('asc_weight' => 'DESC', 'asc_create_time' => 'DESC');
            $list = $community_model->getListSequence($id, $where, $index, $this->count, $sort);
        }
        if ($list) {
            $output['now'] = 1;
        }
        $output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '活动管理', 'link' => '/wxapp/sequence/activityList'),
            array('title' => '查看活动商品', 'link' => '#'),
        ));
        $this->_get_area_list();
        $this->showOutput($output);
        $this->displaySmarty('wxapp/sequence/activity-community-edit.tpl');
    }

    /*
     * 活动添加或移除单个小区
     */
    public function selectCommunitySingleAction()
    {
        $gid  = $this->request->getIntParam('gid');
        $aid  = $this->request->getIntParam('aid');
        $type = $this->request->getStrParam('type');
        $res  = false;
        if ($aid && $gid && $type) {
            $asac_model = new App_Model_Sequence_MysqlSequenceActivityCommunityStorage($this->curr_sid);
            $row        = $asac_model->fetchRow($aid, $gid);
            if ($type == 'add') {
                if ($row) {
                    $this->displayJsonError('商品已经存在');
                } else {
                    $data = array(
                        'asac_s_id'        => $this->curr_sid,
                        'asac_a_id'        => $aid,
                        'asac_c_id'        => $gid,
                        'asac_create_time' => time(),
                    );
                    $res = $asac_model->insertValue($data);
                }
            } elseif ($type == 'remove') {
                if (!$row) {
                    $this->displayJsonError('商品不存在');
                } else {
                    $res = $asac_model->deleteBySidId($row['asac_id'], $this->curr_sid);
                }
            } else {
                $this->displayJsonError('操作异常');
            }

            if ($res) {
                $activity_model  = new App_Model_Sequence_MysqlSequenceActivityStorage($this->curr_sid);
                $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
                $activity        = $activity_model->getRowById($aid);
                $community       = $community_model->getRowById($aid);
                $str             = $type == 'add' ? '添加' : '移除';
                App_Helper_OperateLog::saveOperateLog("活动【{$activity['asa_title']}】{$str}小区【{$community['asc_name']}】成功");
            }

            $this->showAjaxResult($res, '操作');
        } else {
            $this->displayJsonError('操作异常');
        }

    }

    /*
     * 活动添加或移除多个小区
     */
    public function selectCommunityMultiAction()
    {
        $ids    = $this->request->getStrParam('ids');
        $id_arr = plum_explode($ids);
        $aid    = $this->request->getIntParam('aid');
        $type   = $this->request->getStrParam('type');
        $res    = false;
        if ($aid && $id_arr && $type) {
            $asac_model = new App_Model_Sequence_MysqlSequenceActivityCommunityStorage($this->curr_sid);
            if ($type == 'add') {
                foreach ($id_arr as $val) {
                    $row = $asac_model->fetchRow($aid, $val);
                    if (!$row) {
                        //如果不存在，添加
                        $data = array(
                            'asac_s_id'        => $this->curr_sid,
                            'asac_a_id'        => $aid,
                            'asac_c_id'        => $val,
                            'asac_create_time' => time(),
                        );
                        $res = $asac_model->insertValue($data);
                    }
                }

            } elseif ($type == 'remove') {
                //全部删除
                $where[] = array('name' => 'asac_s_id', 'oper' => '=', 'value' => $this->curr_sid);
                $where[] = array('name' => 'asac_a_id', 'oper' => '=', 'value' => $aid);
                $where[] = array('name' => 'asac_c_id', 'oper' => 'in', 'value' => $id_arr);
                $res     = $asac_model->deleteValue($where);
            } else {
                $this->displayJsonError('操作异常');
            }

            if ($res) {
                $activity_model = new App_Model_Sequence_MysqlSequenceActivityStorage($this->curr_sid);
                $activity       = $activity_model->getRowById($aid);
                $str            = $type == 'add' ? '添加' : '移除';
                App_Helper_OperateLog::saveOperateLog("活动【{$activity['asa_title']}】批量{$str}小区成功");
            }

            $this->showAjaxResult($res, '操作');
        } else {
            $this->displayJsonError('操作异常');
        }

    }

    /*
     * 开启关闭小区限制
     */
    public function changeActivityLimitAction()
    {
        $id             = $this->request->getIntParam('id');
        $status         = $this->request->getStrParam('status', 0);
        $activity_model = new App_Model_Sequence_MysqlSequenceActivityStorage($this->curr_sid);
        $set            = array(
            'asa_limit_com' => $status,
        );
        $res = $activity_model->getRowUpdateByIdSid($id, $this->curr_sid, $set);

        if ($res) {
            $activity_model = new App_Model_Sequence_MysqlSequenceActivityStorage($this->curr_sid);
            $activity       = $activity_model->getRowById($id);
            $str            = $status == 1 ? '开启' : '关闭';
            App_Helper_OperateLog::saveOperateLog("活动【{$activity['asa_title']}】{$str}小区限制成功");
        }

        $this->showAjaxResult($res, '操作');
    }
    /**
     * 社区团购新的订单列表
     * zhangzc
     * 2020-01-15
     * @return [type] [description]
     */
    public function tradeListNewAction(){
        $trade_model  = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        // 社区团购 区域管理合伙人-仅能查看自己所辖区域的订单列表
        // zhangzc
        // 2019-03-28
        $where     = [];
        $area_info = $this->sequence_region_where($where);

        // 查询订单列表
        // 查询条件获取 （订单类型、订单编号、商品名称、下单时间、买家昵称、收货人名称、收货人电话、小区名称、团长名称、配送方式）
        $this->trade_list($where,$trade_model);
        $trade_status = $this->get_sequence_trade_summary(false,$area_info,$trade_model);
        $this->output['searchTradeInfo'] = $trade_status;
        // 今日销售统计
        $where_today[] = ['name' => 't_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET];
        $today_trade_info = $this->get_sequence_trade_summary(true,$area_info,$trade_model);
        $this->output['todayTradeInfo'] = $today_trade_info;

        $this->displaySmarty('wxapp/sequence/sequence-trade-list.tpl');
    }

    /**
     * 区域合伙人where条件及相关数据
     * zhangzc
     * 2020-01-17
     * @param  [type] $where [description]
     * @return [type]        [description]
     */
    private function sequence_region_where(&$where){

        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);

        // 这里重构的方案在于根据查询条件找到订单中所有的团长的id 拼接出订单查询的sql
        $leader_model    = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
        $area_model      = new App_Model_Sequence_MysqlSequenceAreaStorage($this->curr_sid);
        // 根据区域查出来所有的小区，根据小区查出来所有的团长
        // 查询出来团长被分配到合伙人下面的所有的团长信息
        // 存在
        if(!empty($area_info)){
            if ($area_info['m_area_type'] == 'C') {
                $area_where[] = ['name'=>'asa_city','oper'=>'=','value'=>$area_info['m_area_id']];
            }elseif($area_info['m_area_type'] == 'D'){
                $area_where[] = ['name'=>'asa_zone','oper'=>'=','value'=>$area_info['m_area_id']];
            }
            $m_area_manager_id = $this->uid;
            // 标记传递到页面中指示该用户是合伙人用户
            $this->output['area_info']      = 1;
        }else{
            //主管理用户查看指定合伙人的订单信息
            $m_area_id         = $this->request->getIntParam('area_id', 0);         //区域id
            $m_area_manager_id = $this->request->getIntParam('area_manager', 0);    //区域管理员ID
            if(!empty($m_area_id)){
                if ($m_area_manager_id) {
                    $area_where[] = ['name'=>'asa_zone','oper'=>'=','value'=>$area_info['m_area_id']];
                } else {
                    $area_where[] = ['name' => 'asa_zone', 'oper' => '=', 'value' => $m_area_id];
                }
            }
        }
        if(empty($area_where))
            return [[]];

        // 从区域中读取所拥有的团长
        $area_leaders = $area_model->getLeaderIdsByArea($area_where);
        $area_leaders = array_column($area_leaders,'asc_leader');

        // 后台手动分配给他的团长
        $leader_list = $leader_model->getList([
            ['name'=>'asl_region_manager_id','oper'=>'=','value'=>$m_area_manager_id ]
        ],0,0,[],['asl_id']);
        $leader_ids = array_column($leader_list,'asl_id');
        $leader_ids = array_merge($leader_ids,$area_leaders);


        if(empty($leader_ids)){
            $leader_ids = [-1];
        } 
        $extra_where = ['name'=>'t_se_leader','oper' =>'in','value'=>$leader_ids];
        $where[]     = $extra_where;

        // 判断当前登陆的账号是不是社区合伙人的操作员
        if ($area_info['region_child'] == 1) {
            $this->output['region_child'] = 0;
        } else {
            $this->output['region_child'] = 1;
        }
        return [$extra_where];
    }

    /**
     * 社区团购订单列表重构
     * zhangzc
     * 2020-01-16
     * @param  [type] &$where      [查询条件]
     * @param  [type] $trade_model [订单model]
     * @return [type]              [description]
     */
    private function trade_list(&$where,$trade_model){
        $this->buildBreadcrumbs([
            ['title' => '订单列表', 'link' => '#'],
        ]);
        try{
            $page         = $this->request->getIntParam('page');
            $index        = $page * $this->count;
              

            $fields_trade = ['t_id','t_tid','t_pay_type','t_applet_type','t_se_send_time','t_goods_fee','t_total_fee','t_num','t_feedback','t_buyer_nick','t_express_method','t_status','t_express_time','t_fd_result','t_fd_status','t_note','t_remark_extra','t_type','t_create_time','t_se_num','t_address','t_had_comment','t_independent_mall','t_express_company','t_express_code','t_discount_fee','t_payment','t_coin_payment','t_se_leader','t_refund_time','t_home_id','t_addr_id'];
            
            
            $fields         = array_merge($fields_trade);
            $where_list     = [
                ['name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid],
                ['name' => 't_status', 'oper' => '>', 'value' => 0],
            ];
            $where          = array_merge($where,$where_list);
            // 获取检索条件
            $this->get_trade_list_where($where);

            // 额外数据的显示
            $this->trade_list_extra_data();
            // 分页数据
            $total                     = $trade_model->getSequenceTradeCountRebuild($where);
            $page_lib                  = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
            $this->output['page_html'] = $page_lib->render();
            $this->output['showPage']  = $total > $this->count ? 1 : 0;

            // 列表数据
            $sort                = ['t_id' => 'DESC'];
            $trade_list          = $trade_model->getsequenceTradeListRebuild($where,$index,$this->count,$sort,$fields);
            if(empty($trade_list)){
                throw new Exception("没有更多数据了",4001);
            }
            $tids              = array_column($trade_list, 't_id');

            // 组装每个订单里面子订单的数据
            $trade_order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
            $fields_order      = ['to_title','to_pic','to_price','to_num','to_total','to_t_id'];
            $trade_order_list  = $trade_order_model->getListByGoIds($tids,$fields_order);

            foreach ($trade_order_list as $key => $val) {
                if (isset($trader[$val['to_t_id']]['count'])) {
                    $trader[$val['to_t_id']]['count']++;
                } else {
                    $trader[$val['to_t_id']]['count'] = 1;
                }
                $trader[$val['to_t_id']]['data'][] = $val;
            }

            // 获取团长信息
            $fields_leader = ['asl_id','asl_name','asl_apply_community','asl_mobile'];
            $leader_model  = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $leader_ids    = array_column($trade_list,'t_se_leader');
            if(empty($leader_ids)){
                $leader_ids = [0];
            }
            $leader_list = $leader_model->getList([
                ['name'=>'asl_s_id','oper'=>'=','value'=>$this->curr_sid],
                ['name'=>'asl_id','oper'=>'in','value'=>$leader_ids]
            ],0,0,[],$fields_leader,true);


            // 获取社区信息+附加街道信息
            $fields_community = ['asc_id','asc_name','asc_address','asc_address_detail','asa_name'];
            $community_ids    = array_column($trade_list,'t_home_id');
            if(empty($leader_ids)){
                $community_ids = [0];
            }
            $community_model  = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
            $community_list   = $community_model->getCommunityListWithArea([
                ['name'=>'asc_s_id','oper'=>'=','value'=>$this->curr_sid],
                ['name'=>'asc_id','oper'=>'in','value'=>$community_ids],
            ],$fields_community,true);

            //ma 快递发货地址数据 
            $address_ids   = array_column($trade_list,'t_addr_id');
            if(!empty($address_ids)){
                $address_model = new App_Model_Member_MysqlAddressStorage($this->curr_sid);
                $address_list  = $address_model->getList([
                    ['name'=>'ma_s_id','oper'=>'=','value'=>$this->curr_sid],
                    ['name'=>'ma_id','oper'=>'in','value'=>$address_ids]
                ],0,0,[],['ma_id','ma_name','ma_phone','ma_province','ma_city','ma_zone','ma_detail','ma_pcda'],true);
            }

            // 自提点数据
            // asps.asps_address,asps.asps_address_detail,asps.asps_lng,asps.asps_lat,asps.asps_mobile,asps.asps_manager_nickname,asps.asps_id
            foreach ($trade_list as $key => $val) {
                // 追加团长信息
                if($leader_list[$val['t_se_leader']]){
                    $val = array_merge($val,$leader_list[$val['t_se_leader']]);
                }
                // 追加小区、街道信息
                if($community_list[$val['t_home_id']]){
                    $val = array_merge($val,$community_list[$val['t_home_id']]);
                }
                // 快递收货信息
                if($address_list[$val['t_addr_id']]){
                    $val = array_merge($val,$address_list[$val['t_addr_id']]);
                }
                $trade_list[$key] = $val;
                $trade_list[$key]['t_remark_extra'] = json_decode($val['t_remark_extra'], true);
            }
        }catch(Exception $e){
            $trade_list = [];
            $trader     = [];
        }
        
        $this->output['list']   = $trade_list;
        $this->output['trader'] = $trader;
    }
   /**
    * 获取订单列表的订单汇总信息(去除掉动态查询时的动态变更，只显示今日与总的汇总)
    * zhangzc
    * 2020-01-18
    * @param  boolean $today       [description]
    * @param  [type]  $area_where  [合伙人需要做特殊的查询处理]
    * @param  [type]  $trade_model [description]
    * @return [type]               [description]
    */
    private function get_sequence_trade_summary($today=false,$area_where,$trade_model){
        $where = [
            ['name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid],
            ['name' => 't_status', 'oper' => 'in', 'value' => [3, 4, 5, 6]],
        ];
        // 今日数据统计
        if($today){
            $time    = strtotime(date('Y-m-d', time())); // 获取今天0点的时间
            $where[] = ['name' => 't_create_time', 'oper' => '>=', 'value' => $time];
        }
        // 存在区域合伙人信息的时候处理合伙人可以看到的数据
        if($area_where){
            $where = array_merge($where,$area_where);
        }
        $summary = $trade_model->getTradeListSummary($where);
        return $summary;
    }
    
    /**
     * 订单列表中的选项数据
     * zhanzgc
     * 2020-01-16
     * @param  integer $isrefund  [是否退款订单]
     * @param  [type]  $area_info [合伙人信息是否存在]
     * @return [type]             [description]
     */
    private function trade_list_extra_data($isrefund=0,$area_info){
        // 订单状态的TAB标签
        if($isrefund){
            $link                     = App_Helper_Trade::$trade_refund_link_status;
            $link['rights']['label']  = '退款中';
            $link['closure']['label'] = '退款结束';
        }else{
            $link                     = App_Helper_Trade::$trade_link_status;
            $link['hadpay']['label']  = '已付款';
            $link['finish']['label']  = '已完成';
            $link['refund']['label']  = '退款';
            unset($link['tuan']);
            unset($link['ship']);
        }
        $this->output['link']    = $link;

        // 配送方式显示
        $expressMethod    = [
            1 => '商家配送',
            2 => '门店自取',
            3 => '快递发货',
            6 => '团长配送',
        ];
        $this->output['expressMethod'] = $expressMethod;

        // 订单状态的提示信息
        $this->output['statusNote']   = plum_parse_config('trade_status');

        // 订单类型（状态）
        $this->output['trade_screen'] = plum_parse_config('trade_screen_sequence');

        // 发货状态可用时读取可用的快递（物流）信息
        $express_model = new App_Model_Trade_MysqlExpressStorage();
        $express       = $express_model->getExpressList(1);
        $this->output['express'] = $express;

        // 支付方式
        $this->output['tradePay'] = App_Helper_Trade::$trade_pay_type;

        // 获取打印机
        // 打印机数据获取可以滞后
        $feie_model = new App_Model_Feie_MysqlFeieListStorage($this->curr_sid);
        if ($area_info) {
            $printlist         = $feie_model->findListBySid(0, $this->uid);
            $m_area_manager_id = $this->uid;
        } else {
            $printlist = $feie_model->findListBySid();
        }
        $this->output['printlist'] = $printlist;
        $this->output['print']     = plum_parse_config('type', 'print');

        // 小区选择（导出的时候使用的）
        $this->_get_community_select(false, $area_info ? $area_info['m_area_id'] : 0, $area_info['m_area_type']);
        $this->output['activeRefundReason'] = plum_parse_config('active_refund_reason');
    }
    /**
     * 获取社区团购订单列表的检索条件
     * zhangzc
     * 2020-01-16
     * @param  [type]  &$where   [查询条件]
     * @param  integer $isrefund [是否为退款订单列表]
     * @return [type]            [description]
     */
    private function get_trade_list_where(&$where,$isrefund =0){
        $output['tid']         = $this->request->getStrParam('tid');
        $output['buyer']       = $this->request->getStrParam('buyer');
        $output['phone']       = $this->request->getStrParam('phone');
        $output['start']       = $this->request->getStrParam('start');
        $output['end']         = $this->request->getStrParam('end');
        $output['postType']    = $this->request->getIntParam('postType', 0);
        $leaderId              = $this->request->getIntParam('leader', 0);
        $output['leader']      = $this->request->getStrParam('leaderName', '');
        $output['gname']       = $this->request->getStrParam('gname'); //商品名称
        $output['community']   = $this->request->getStrParam('community', ''); //小区
        $output['harvest']     = $this->request->getStrParam('harvest'); //收货人
        $output['tradeScreen'] = $this->request->getStrParam('tradeScreen', 'valid');  // 订单类型(状态)
        $output['status']      = $this->request->getStrParam('status', 'all');         // 订单状态 Tab栏
        $output['harvest']     = $this->request->getStrParam('harvest');               // 收货人名称

        // 仅查询小程序类型的订单
        $where[] = ['name' => 't_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET];
        // 收货人联系方式
        if ($output['phone']) {
            $where[] = ['name' => 't_express_code', 'oper' => '=', 'value' => $output['phone']];
        }
        // 根据订单id 搜索
        if ($output['tid']) {
            $where[] =['name' => 't_tid', 'oper' => '=', 'value' => $output['tid']];
        }
        // 购买人昵称
        if ($output['buyer']) {
            $where[] =['name' => 't_buyer_nick', 'oper' => 'like', 'value' => "%{$output['buyer']}%"];
        }
        // 时间维度开始
        if ($output['start']) {
            $where[] = ['name' => 't_create_time', 'oper' => '>=', 'value' => strtotime($output['start'])];
        }
        // 时间维度结束
        if ($output['end']) {
            $where[] = ['name' => 't_create_time', 'oper' => '<=', 'value' => (strtotime($output['end']))];
        }
        // 配送方式
        if ($output['postType'] > 0) {
            $where[] = ['name' => 't_express_method', 'oper' => '=', 'value' => $output['postType']];
        }
        // 团长id
        if ($leaderId) {
            $where[] = ['name' => 't_se_leader', 'oper' => '=', 'value' => $leaderId];
        }  
        // 订单类型（状态）
        switch ($output['tradeScreen']) {
            // 有效订单中是指已支付的且未关闭的订单
            case 'valid':
                $where[] = ['name' => 't_status', 'oper' => '<', 'value' => App_Helper_Trade::TRADE_CLOSED];
                break;
            //已关闭订单 
            case 'close':
                $where[] = ['name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_CLOSED];
                break;
            // 已完成的订单
            case 'finished':
                $where[] = ['name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_FINISH];
        }

        // 维权订单
        if ($isrefund == 1) {
            $link    = App_Helper_Trade::$trade_refund_link_status;
            if($link[$output['status']]['id'] > 0){
                $where[] = ['name' => 't_feedback', 'oper' => '=', 'value' => $link[$output['status']]['id']];
            }
        // 正常订单
        } else {
            $link = App_Helper_Trade::$trade_link_status;
            switch ($output['status']) {
                // 已付款的有两个状态
                case 'hadpay':
                    // App_Helper_Trade::TRADE_HAD_PAY, App_Helper_Trade::TRADE_SHIP
                    $where[] = ['name' => 't_status', 'oper' => 'in', 'value' => [3,4]];
                    break;
                default:
                    $t_status = $link[$output['status']]['id'];
                    if(!empty($t_status)){
                        $where[] = ['name' => 't_status', 'oper' => '=', 'value' => $t_status];
                    }
                    break;
            }
        }
               




        // $area_model      = new App_Model_Sequence_MysqlSequenceAreaStorage($this->curr_sid);

        // 商品名称（这里的分页-优化未处理）
        if ($output['gname']) {
            $where[] = ['name' => 'to_title', 'oper' => 'like', 'value' => "%{$output['gname']}%"];
        }
        // 团长名称
        if ($output['leader']) {
            // 根据团长名称获取团长的 主键ids
            $leader_model    = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $leader_ids      = $leader_model->getList([
                ['name'=>'asl_s_id','oper'=>'=','value'=>$this->curr_sid],
                ['name'=>'asl_name','oper'=>'like','value'=>"{$output['leader']}"]
            ],0,0,[],'asl_id');
            if(!empty($leader_ids)){
                $leader_ids = array_column($leader_ids,'asl_id');
                $where[] = ['name' => 't_se_leader', 'oper' => 'in', 'value' => $leader_ids];
            }else{
                $where[] = ['name' => 't_se_leader', 'oper' => '=', 'value' => -1];
            }
        } 
        //小区名称
        if ($output['community']) {
            $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
            $leader_ids      = $community_model->getList([
                ['name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid],
                ['name' => 'asc_name', 'oper' => 'like', 'value' => "%{$output['community']}%"]
            ],0,0,[],['asc_leader']);
            if(!empty($leader_ids)){
                $leader_ids = array_column($leader_ids,'asc_leader');
                $where[] = ['name' => 't_se_leader', 'oper' => 'in', 'value' => $leader_ids];
            }else{
                $where[] = ['name' => 't_se_leader', 'oper' => '=', 'value' => -1];
            }

        }


        // 收货人名称（收货人名称未做优化【快递发货，和真实的收货人信息】）
        if ($output['harvest']) {
            // 获取到收货人名称里面的地址ids
            $address_model = new App_Model_Member_MysqlAddressStorage($this->curr_sid);
            $address_list  = $address_model->getList([
                ['name'=>'ma_s_id','oper'=>'=','value'=>$this->curr_sid],
                ['name' =>'ma_name','oper'=>'like','value'=>"%{$output['harvest']}%"]
            ],0,0,[],['ma_id']);
            if(!empty($address_list)){
                $addr_ids = array_column($address_list,'ma_id');
                $where[]=" (`t_expert_id` IN ({$addr_ids})  OR `t_express_company` like '%{$output['harvest']}%' )";
            }else{
                $where[]=" ( `t_express_company` like '%{$output['harvest']}%' )";
            } 
        }

        $this->showOutput($output);
    }


    /*
     * 订单列表
     */
    public function tradeListAction()
    {
        $where      = [];
        $where_stat = [];
        $this->show_sequence_trade_list_data($where);

        $this->output['tradePay'] = App_Helper_Trade::$trade_pay_type;
        $where_stat[]             = array('name' => 't_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET);
        // 社区团购 区域管理统计今日收益与订单
        $region_helper = new App_Helper_SequenceRegion($this->curr_sid);
        $area_info     = $region_helper->get_area_manager($this->uid, $this->company['c_id']);

        // 判断当前登陆的账号是不是社区合伙人的操作员
        if ($area_info['region_child'] == 1) {
            $this->output['region_child'] = 0;
        } else {
            $this->output['region_child'] = 1;
        }

        //区域合伙人打印机列表获取条件限制
        //区域合伙人只获取自己添加的打印机
        // 寻找打印机
        $feie_model = new App_Model_Feie_MysqlFeieListStorage($this->curr_sid);
        if ($area_info) {
            $printlist         = $feie_model->findListBySid(0, $this->uid);
            $m_area_manager_id = $this->uid;
        } else {
            $printlist = $feie_model->findListBySid();
            // 非区域合伙人账号登录-主管理查看区域管理员的订单信息
            // zhangzc
            // 2019-08-19
            $m_area_id = $this->request->getIntParam('area_id', 0);

            $m_area_manager_id = $this->request->getIntParam('area_manager', 0);
            if ($m_area_id) {
                if ($m_area_manager_id) {
                    $where_stat[] = sprintf('(asa.asa_zone=%s OR `asl_region_manager_id`=%s)', $m_area_id, $m_area_manager_id);
                } else {
                    $where_stat[] = ['name' => 'asa.asa_zone', 'oper' => '=', 'value' => $m_area_id];
                }

                $area_info['m_area_id']   = $m_area_id;
                $area_info['m_area_type'] = 'D';
            }
        }

        if($this->request->getIntParam('test',0) == 0)
            $this->output['todayTradeInfo'] = $this->_show_sequence_order_stat($where_stat, true, $area_info ? $area_info['m_area_id'] : 0, $area_info['m_area_type'], $m_area_manager_id);
        $this->_get_community_select(false, $area_info ? $area_info['m_area_id'] : 0, $area_info['m_area_type']);
        $this->output['activeRefundReason'] = plum_parse_config('active_refund_reason');
        $this->output['printlist'] = $printlist;
        $this->output['print']     = plum_parse_config('type', 'print');
        $this->buildBreadcrumbs(array(
            array('title' => '订单列表', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/sequence/cb-trade-list.tpl');
    }

    /*
     * 获得所有商品
     */
    private function _get_goods_select($return = false)
    {
        $data        = [];
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $where[]     = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort        = array('g_create_time' => 'DESC');
        $list        = $goods_model->getList($where, 0, 0, $sort);
        if ($list) {
            foreach ($list as $val) {
                $data[] = [
                    'id'   => $val['g_id'],
                    'name' => $val['g_name'],
                ];
            }
        }
        if ($return) {
            return $data;
        } else {
            $this->output['goodsSelect'] = $data;
        }

    }

    /**
     * 统计订单信息
     */
    protected function _show_sequence_order_stat($where, $today = true, $area_id = false, $area_type = 'C', $area_manager = 0)
    {
        // 不再动态查询统计数据
        $where = [
            ['name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid],
            ['name' => 't_status', 'oper' => 'in', 'value' => [3, 4, 5, 6]],
        ];
        if ($today) {
            $time    = strtotime(date('Y-m-d', time())); // 获取今天0点的时间
            $where[] = array('name' => 't_create_time', 'oper' => '>=', 'value' => $time);
        }

        // 社区团购 区域管理合伙人订单统计
        if ($area_id) {
            if ($area_type == 'C') {
                $where[] = ['name' => 'asa_city', 'oper' => '=', 'value' => $area_id];
            } else {
                // 修改区域合伙人的订单列表
                // zhangzc
                // 2019-09-16
                if ($area_manager) {
                    $where[] = sprintf('(asa.asa_zone=%s OR `asl_region_manager_id`=%s)', $area_id, $area_manager);
                } else {
                    $where[] = ['name' => 'asa_zone', 'oper' => '=', 'value' => $area_id];
                }

            }
        }

        $order_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        return $order_model->statSequenceOrderStatisticNew($where);
    }

    /**
     * @param array $where
     * @param int $needExpress
     * @param int $isrefund
     * 商城订单，维权列表，积分订单，抽奖订单，通用方法
     */
    public function show_sequence_trade_list_data($where = array(), $needExpress = 1, $isrefund = 0, $type = 0)
    {
        // 社区团购 区域管理合伙人-仅能查看自己所辖区域的订单列表
        // zhangzc
        // 2019-03-28
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            if ($area_info['m_area_type'] == 'C') {
                $where[] = ['name' => 'asa.asa_city', 'oper' => '=', 'value' => $area_info['m_area_id']];
            } else if ($area_info['m_area_type'] == 'D') {
                $where[] = sprintf('(asa.asa_zone=%s OR `asl_region_manager_id`=%s)', $area_info['m_area_id'], $this->uid);
            }
            $m_area_manager_id         = $this->uid;
            $this->output['area_info'] = 1;
        } else {
            $m_area_id         = $this->request->getIntParam('area_id', 0);
            $m_area_manager_id = $this->request->getIntParam('area_manager', 0);
            if ($m_area_id) {
                if ($m_area_manager_id) {
                    $where[] = sprintf('(asa.asa_zone=%s OR `asl_region_manager_id`=%s)', $m_area_id, $m_area_manager_id);
                } else {
                    $where[] = ['name' => 'asa.asa_zone', 'oper' => '=', 'value' => $m_area_id];
                }

                $area_info['m_area_id']   = $m_area_id;
                $area_info['m_area_type'] = 'D';
            }
        }

        $output['status'] = $this->request->getStrParam('status', 'all');
        $expressMethod    = array(
            1 => '商家配送',
            2 => '门店自取',
            3 => '快递发货',
            6 => '团长配送',
        );

        $output['expressMethod'] = $expressMethod;

        // 是否为维权订单
        if ($isrefund == 1) {
            //table上导航链接
            $link                     = App_Helper_Trade::$trade_refund_link_status;
            $link['rights']['label']  = '退款中';
            $link['closure']['label'] = '退款结束';

            // 订单维权状态
            if ($output['status'] && isset($link[$output['status']]) && $link[$output['status']]['id'] > 0) {
                $where[] = array('name' => 't_feedback', 'oper' => '=', 'value' => $link[$output['status']]['id']);
            }
        } else {
            //table上导航链接
            $link = App_Helper_Trade::$trade_link_status;

            //培训版订单没有 支付 退款状态(这是社区团购单独的控制器为啥会出现其他的类型)
            // if ($this->wxapp_cfg['ac_type'] == 12) {
            //     unset($link['hadpay']);
            //     unset($link['refund']);
            // }
            //社区团购没哟
            if ($this->wxapp_cfg['ac_type'] == 32) {
                $link['hadpay']['label'] = '已付款';
                $link['finish']['label'] = '已完成';
                $link['refund']['label'] = '退款';

                unset($link['ship']);
            }

            if ($output['status'] && isset($link[$output['status']]) && $link[$output['status']]['id'] == 0 && $type == App_Helper_Trade::TRADE_AUCTION) {
                $where[] = array('name' => 't_status', 'oper' => '!=', 'value' => 1);
                $where[] = array('name' => 't_status', 'oper' => '!=', 'value' => 7);
            }
            // 订单状态
            if ($output['status'] && isset($link[$output['status']]) && $link[$output['status']]['id'] > 0) {
                if ($output['status'] == 'hadpay') {
                    $where[] = array('name' => 't_status', 'oper' => 'in', 'value' => [App_Helper_Trade::TRADE_HAD_PAY, App_Helper_Trade::TRADE_SHIP]);
                } else {
                    $where[] = array('name' => 't_status', 'oper' => '=', 'value' => $link[$output['status']]['id']);
                }

            } elseif ($output['status'] == 'winNOPay') {
                $where[] = array('name' => 't_status', 'oper' => '=', 'value' => 11);
            }
        }
        unset($link['tuan']);
        $this->output['link']         = $link;
        $this->output['statusNote']   = plum_parse_config('trade_status');
        $this->output['trade_screen'] = plum_parse_config('trade_screen');
        //@todo 获取物流列表，供发货使用,全部状态下或待发货状态下
        if (in_array($output['status'], array('all', 'hadpay')) && $needExpress) {
            $express_model = new App_Model_Trade_MysqlExpressStorage();
            $express       = $express_model->getExpressList(1);
        } else {
            $express = array();
        }
        $this->output['express'] = $express;

        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;

        $sort = array('t_id' => 'DESC');
        //检索条件整理

        $where[]         = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]         = array('name' => 't_status', 'oper' => '>', 'value' => 0);
        $output['title'] = $this->request->getStrParam('title');
        if ($output['title']) {
            $where[] = array('name' => 't_title', 'oper' => 'like', 'value' => "%{$output['title']}%");
        }
        $output['tid'] = $this->request->getStrParam('tid');
        if ($output['tid']) {
            $where[] = array('name' => 't_tid', 'oper' => '=', 'value' => $output['tid']);
        }
        $output['buyer'] = $this->request->getStrParam('buyer');
        if ($output['buyer']) {
            $where[] = array('name' => 't_buyer_nick', 'oper' => 'like', 'value' => "%{$output['buyer']}%");
        }
        // 修改 订单列表查询字段问题
        // zhangzc
        // 2019-03-26
        $output['harvest'] = $this->request->getStrParam('harvest');
        if ($output['harvest']) {
            // $where[] = array('name' => 't_express_company', 'oper' => 'like', 'value' => "%{$output['harvest']}%");
            $where[]=" ( `t_express_company` like '%{$output['harvest']}%' OR ma_name like '%{$output['harvest']}%')";
        }
        $output['phone'] = $this->request->getStrParam('phone');
        if ($output['phone']) {
            $where[] = array('name' => 't_express_code', 'oper' => '=', 'value' => $output['phone']);
        }
        //酒店搜索
        $output['mobile'] = $this->request->getStrParam('mobile');
        if ($output['mobile']) {
            $where[] = array('name' => 't_express_code', 'oper' => '=', 'value' => $output['mobile']);
        }
        $output['realName'] = $this->request->getStrParam('realName');
        if ($output['realName']) {
            $where[] = array('name' => 't_express_company', 'oper' => 'like', 'value' => "%{$output['realName']}%");
        }
        if (!$type) {
            $where[] = array('name' => 't_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET);
        } else {
            $where[] = array('name' => 't_type', 'oper' => '=', 'value' => $type);
        }
        $output['start'] = $this->request->getStrParam('start');
        if ($output['start']) {
            $where[] = array('name' => 't_create_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end'] = $this->request->getStrParam('end');
        if ($output['end']) {
            $where[] = array('name' => 't_create_time', 'oper' => '<=', 'value' => (strtotime($output['end'])));
        }
        //门店id
        $output['esId'] = $this->request->getIntParam('esId', 0);
        if ($output['esId'] > 0) {
            $where[] = array('name' => 't_es_id', 'oper' => '=', 'value' => $output['esId']);
        } elseif ($output['esId'] < 0) {
            $where[] = array('name' => 't_es_id', 'oper' => '=', 'value' => 0);
        }
        $output['postType'] = $this->request->getIntParam('postType', 0);
        if ($output['postType'] > 0) {
            $where[] = array('name' => 't_express_method', 'oper' => '=', 'value' => $output['postType']);
        }
        //自提门店id
        $output['osId'] = $this->request->getIntParam('osId', 0);
        if ($output['osId'] > 0) {
            $where[] = array('name' => 't_store_id', 'oper' => '=', 'value' => $output['osId']);
            if ($this->wxapp_cfg['ac_type'] != 18) {
                $output['postType'] = 2; //有自提门店即为门店自取
            }
        }
        //小区名称
        $output['community'] = $this->request->getStrParam('community', '');
        if ($output['community']) {
            $where[] = array('name' => 'asc_name', 'oper' => 'like', 'value' => "%{$output['community']}%");
        }
        //团长名称
        $output['leader'] = $this->request->getStrParam('leaderName', '');
        $leaderId         = $this->request->getIntParam('leader', 0);

        if ($leaderId) {
            $where[] = array('name' => 'asl_id', 'oper' => '=', 'value' => $leaderId);
        } else if ((!$leaderId) && $output['leader']) {
            $where[] = array('name' => 'asl_name', 'oper' => 'like', 'value' => "%{$output['leader']}%");
        }

        $output['tradeScreen'] = $this->request->getStrParam('tradeScreen', 'valid');
        if ($output['tradeScreen'] && $output['status'] != 'closed') {
            switch ($output['tradeScreen']) {
                case 'valid':
                    $where[] = array('name' => 't_status', 'oper' => '!=', 'value' => App_Helper_Trade::TRADE_CLOSED);
                    break;
                case 'close':
                    $where[] = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_CLOSED);
                    break;
            }
        }
        if($this->request->getIntParam('test',0) == 0)
            $output['searchTradeInfo'] = $this->_show_sequence_order_stat($where, false, $area_info['m_area_id'] ? $area_info['m_area_id'] : 0, $area_info['m_area_type'], $m_area_manager_id);

        // 商品名称
        $output['gname'] = $this->request->getStrParam('gname');
        if ($output['gname']) {
            $where[] = ['name' => 'to_title', 'oper' => 'like', 'value' => "%{$output['gname']}%"];
        }

        //分页，列表数据展示
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $total = $trade_model->getSequenceAddressCountNew($where, 0, $m_area_manager_id);
        $page_lib            = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $output['page_html'] = $page_lib->render();
        $output['showPage']  = $total > $this->count ? 1 : 0;

        $list                = array();
        $trader              = array();
        if ($total > $index) {
            $list = $trade_model->getSequenceAddressListNew($where, $index, $this->count, $sort);
            //@todo 根据订单ID获取交易详情，并统计本次交易产生订单数量
            $ids           = array();
            $store_storage = new App_Model_Cake_MysqlCakeStoreStorage($this->curr_sid);
            foreach ($list as $key => $val) {
                $ids[] = $val['t_id'];
                if ($val['t_store_id']) {
                    $store                   = $store_storage->getRowById($val['t_store_id']);
                    $list[$key]['storeName'] = $store['acs_name'];
                }
            }
            $trade_order = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);

            $temp = $trade_order->getListByGoIds($ids);
            foreach ($temp as $val) {
                if (isset($trader[$val['to_t_id']]['count'])) {
                    $trader[$val['to_t_id']]['count']++;
                } else {
                    $trader[$val['to_t_id']]['count'] = 1;
                }
                $trader[$val['to_t_id']]['data'][] = $val;
            }
        }

        $output['trader'] = $trader;
        foreach ($list as $key => $val) {
            $list[$key]['t_remark_extra'] = json_decode($val['t_remark_extra'], true);
        }
        $output['list'] = $list;
        $this->showOutput($output);
    }

    /*
     * 获得全部小区
     * @params  is_area   社区团购区域管理员的话查询方式区别于总管理员
     */
    private function _get_community_select($return = false, $is_area = false, $area_type = 'C')
    {
        $data            = [];
        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
        $where[]         = array('name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        if ($is_area) {
            $list = $community_model->getCommunitysListByArea($is_area, $area_type);
        } else {
            $list = $community_model->getList($where, 0, 0);
        }

        if ($list) {
            foreach ($list as $val) {
                $data[] = [
                    'id'   => $val['asc_id'],
                    'name' => $val['asc_name'],
                ];
            }
        }
        if ($return) {
            return $data;
        } else {
            $this->output['communitySelect'] = $data;
        }
    }

    /**
     * 维权订单列表
     */
    public function refundListAction()
    {
        $where   = array();
        $where[] = array('name' => 't_feedback', 'oper' => '!=', 'value' => 0);
        $this->show_sequence_trade_list_data($where, 0, 1);
        $this->output['tradePay'] = App_Helper_Trade::$trade_pay_type;
        $this->buildBreadcrumbs(array(
            array('title' => '订单管理', 'link' => '#'),
            array('title' => '退款订单', 'link' => '#'),
        ));
        $this->output['ac_type'] = $this->wxapp_cfg['ac_type'];
        $this->displaySmarty('wxapp/sequence/refund-list.tpl');
    }

    /*
     * 活动群组列表
     */
    public function groupListAction()
    {
        $page         = $this->request->getIntParam('page');
        $index        = $page * $this->count;
        $leader_model = new App_Model_Sequence_MysqlSequenceGroupStorage($this->curr_sid);
        $where[]      = array('name' => 'asg_s_id', 'oper' => '=', 'value' => $this->curr_sid);

        $this->output['nickname'] = $this->request->getStrParam('nickname');
        if ($this->output['nickname']) {
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$this->output['nickname']}%");
        }
        $this->output['truename'] = $this->request->getStrParam('truename');
        if ($this->output['truename']) {
            $where[] = array('name' => 'asl_name', 'oper' => 'like', 'value' => "%{$this->output['truename']}%");
        }
        $this->output['mobile'] = $this->request->getStrParam('mobile');
        if ($this->output['mobile']) {
            $where[] = array('name' => 'asl_mobile', 'oper' => '=', 'value' => $this->output['mobile']);
        }
        $this->output['community'] = $this->request->getStrParam('community');
        if ($this->output['community']) {
            $where[] = array('name' => 'asc_name', 'oper' => '=', 'value' => $this->output['community']);
        }

        $sort                       = array('asg_create_time' => 'DESC');
        $total                      = $leader_model->getGroupLeaderCount($where);
        $pageCfg                    = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['pagination'] = $pageCfg->render();
        $list                       = $leader_model->getGroupLeaderList($where, $index, $this->count, $sort);
        $this->output['list']       = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '活动群组管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sequence/group-list.tpl');
    }

    /*
     * 核销记录
     */
    public function verifyRecordListAction()
    {
        $page         = $this->request->getIntParam('page');
        $index        = $page * $this->count;
        $verify_model = new App_Model_Store_MysqlVerifyStorage($this->curr_sid);
        $where[]      = array('name' => 'ov_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]      = array('name' => 'ov_type', 'oper' => '=', 'value' => 6);

        $this->output['nickname'] = $this->request->getStrParam('nickname');
        if ($this->output['nickname']) {
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$this->output['nickname']}%");
        }
        $this->output['truename'] = $this->request->getStrParam('truename');
        if ($this->output['truename']) {
            $where[] = array('name' => 'asl_name', 'oper' => 'like', 'value' => "%{$this->output['truename']}%");
        }
        $this->output['tid'] = $this->request->getStrParam('tid');
        if ($this->output['tid']) {
            $where[] = array('name' => 'ov_se_tid', 'oper' => '=', 'value' => $this->output['tid']);
        }
        $this->output['code'] = $this->request->getStrParam('code');
        if ($this->output['code']) {
            $where[] = array('name' => 'ov_value', 'oper' => '=', 'value' => $this->output['code']);
        }

        // 社区团购区域管理合伙人 查询核销列表 限制
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            if ($area_info['m_area_type'] == 'C') {
                $where[] = ['name' => 'asa_city', 'oper' => '=', 'value' => $area_info['m_area_id']];
            } elseif ($area_info['m_area_type'] == 'D') {
                $where[] = ['name' => 'asa_zone', 'oper' => '=', 'value' => $area_info['m_area_id']];
            }
        }

        $sort                       = array('ov_record_time' => 'DESC');
        $total                      = $verify_model->sequenceVerifyCount($where, $area_info ? $area_info['m_area_id'] : 0);
        $pageCfg                    = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['showPage']   = $total > $this->count ? 1 : 0;
        $this->output['pagination'] = $pageCfg->render();
        $list                       = $verify_model->sequenceVerifyList($where, $index, $this->count, $sort, $area_info ? $area_info['m_area_id'] : 0);
        $this->output['list']       = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '核销记录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sequence/verify-record-list.tpl');
    }

    /*
     * 编辑/新增商品
     */
    public function goodsListAction()
    {
        $table_menu                = new App_Helper_TableMenu();
        $this->output['choseLink'] = $table_menu->showTableLink('sequenceGoods');
        $where                     = array();
        $where[]                   = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $output['name']            = $this->request->getStrParam('name');
        if ($output['name']) {
            $where[] = array('name' => 'g_name', 'oper' => 'like', 'value' => "%{$output['name']}%");
        }

        $output['cate'] = $this->request->getIntParam('cate');
        if ($output['cate']) {
            $where[] = array('name' => 'g_kind2', 'oper' => '=', 'value' => $output['cate']);
        }
        $output['gtype'] = $this->request->getIntParam('gtype');
        if ($output['gtype']) {
            $where[] = array('name' => 'g_type', 'oper' => '=', 'value' => $output['gtype']);
        }

        //订单状态
        $output['status'] = $this->request->getStrParam('status', 'sell');
        switch ($output['status']) {
            case 'sell':
                $where[] = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
                $where[] = array('name' => 'g_stock', 'oper' => '>', 'value' => 0);
                break;
            case 'sellout':
                $where[] = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
                $where[] = array('name' => 'g_stock', 'oper' => '<=', 'value' => 0);
                break;
            case 'depot':
                $where[] = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 2);
                break;
        }

        $output['sortType'] = $this->request->getStrParam('sortType', 'updateNew');
        switch ($output['sortType']) {
            case 'updateNew':
                $sort = array('g_update_time' => 'DESC');
                break;
            case 'updateOld':
                $sort = array('g_update_time' => 'ASC');
                break;
            case 'createNew':
                $sort = array('g_create_time' => 'DESC');
                break;
            case 'createOld':
                $sort = array('g_create_time' => 'ASC');
                break;
            default:
                $sort = array('g_update_time' => 'DESC');
        }

        $page                = $this->request->getIntParam('page');
        $index               = $page * $this->count;
        $goods_model         = new App_Model_Goods_MysqlGoodsStorage();
        $total               = $goods_model->getCount($where);
        $pageCfg             = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $output['paginator'] = $pageCfg->render();
        $list                = array();
        $deduct              = array();
        if ($index <= $total) {
            if ($this->wxapp_cfg['ac_type'] == 6 || $output['plateform'] == 1) {
                $list = $goods_model->getList($where, $index, $this->count, $sort);
            } else {
                $list = $goods_model->getCommunityShopGoods($where, $index, $this->count, $sort);
            }

            $deduct_gids = array();
            foreach ($list as $key => $val) {
                $deduct_gids[] = $val['g_id'];
                $param         = array(
                    'gid' => $val['g_id'],
                );
                // $val['link'] = $this->composeLink('shop','detail',$param);
                if (!$val['g_qrcode'] && $this->curr_sid != 8503) {
                    $list[$key]['g_qrcode'] = $this->create_qrcode($val['g_id'], $val['g_cover']);
                }
            }
        }
        if ($list) {
            $output['now'] = 1;
        }
        $output['list'] = $list;
        $this->showOutput($output);
        $this->_show_category_type(0);
        $this->buildBreadcrumbs(array(
            array('title' => '活动管理', 'link' => '#'),
            array('title' => '商品中心', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/sequence/goods-list.tpl');
    }

    /**
     * @param int $is_add
     * 展示商品类目
     */
    private function _show_category_type($is_add = 1)
    {
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $temp           = $category_model->getAllSonCategory();
        $category       = array();
        foreach ($temp as $val) {
            $category[$val['sk_id']] = $val['sk_name'];
        }
        $this->output['category'] = $category;
        $this->output['type']     = plum_parse_config('goodsType');
    }
    /**
     * 生成商品二维码
     */
    private function create_qrcode($id, $cover = '')
    {
        $good_model    = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $client_plugin = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        if (!$cover) {
            $good  = $good_model->getRowById($id);
            $cover = $good['g_cover'];
        }
        $str    = "id=" . $id;
        $url    = $client_plugin->fetchWxappShareCode($str, $client_plugin::GOODS_DETAIL_CODE_PATH, 210, $cover);
        $updata = array('g_qrcode' => $url);
        $good_model->updateById($updata, $id);
        return $url;
    }

    /*
     * 编辑/新增商品
     */
    public function goodsEditAction()
    {

        $id                        = $this->request->getIntParam('id');
        $region_id                 = $this->request->getIntParam('region_id');
        $this->output['region_id'] = $region_id;
        $row                       = array();
        $slide                     = array();
        $format                    = array();

        $sequenceShowAll = 1;
        if ($this->wxapp_cfg['ac_type'] == 36) {
            $sequenceShowAll = 0;
        }
        $this->output['sequenceShowAll'] = $sequenceShowAll;

        // 社区团购区域合伙人限制编辑商品信息
        // 先判断是否开通了区域合伙人插件
        // 可用的话显示商品中添加区域合伙人商品佣金比例的字段
        // 如果是修改数据的话需要提取出来此字段的数据
        // 检测社区团购区域管理合伙人插件是否可用
        $area_info     = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        $show_save_tip = 0;
        if ($area_info) {
            $cfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
            $cfg       = $cfg_model->findUpdateBySid();
            if ($cfg['asc_region_goods_verify'] > 0) {
                $show_save_tip = 1;
            }
            $this->output['show_area_leader'] = 0;
        } else {
            $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($this->curr_sid);
            $plugin_row   = $plugin_model->findUpdateBySid('qyhhr');
            if (!$plugin_row || $plugin_row['apo_expire_time'] < time()) {
                //不可用
                $this->output['show_area_leader'] = 0;
            } else {
                //可用
                $this->output['show_area_leader'] = 1;
            }
        }
        $this->output['show_save_tip'] = $show_save_tip;

        if ($id) {
            $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
            $row         = $goods_model->getRowByIdSid($id, $this->curr_sid);

            // 社区团购区域合伙人限制编辑商品信息
            if ($area_info) {
                // 非自己添加的商品限制进行编辑
                if ($row['g_region_add_by'] != $this->uid) {
                    plum_redirect_with_msg('暂时无法编辑该产品', $_SERVER['HTTP_REFERER'], 1);
                }

            }

            $slide_model = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
            $slide       = $slide_model->getSlideByGid($id);
            $this->_get_goods_ratio($id); //获得分佣比例

            // 区域管理合伙人插件可用时读取相应的佣金比例
            if ($plugin_row && $plugin_row['apo_expire_time'] > time()) {
                $this->_get_region_goods_ratio($id);
            }

            $format_model = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
            $format       = $format_model->getListByGid($row['g_id']);
            if (!$row['g_format_type'] && $format) {
                $spec = [
                    [
                        'name'  => '规格',
                        'value' => [],
                    ],
                ];
                foreach ($format as $val) {
                    $spec[0]['value'][] = [
                        'name' => $val['gf_name'],
                        'img'  => $val['gf_img'],
                    ];
                    $dataList[] = array(
                        'spec'           => [$val['gf_name']],
                        'oriPrice'       => $val['gf_ori_price'],
                        'price'          => $val['gf_price'],
                        'stock'          => $val['gf_stock'],
                        'cost'           => $val['gf_cost'],
                        'weight'         => $val['gf_format_weight'],
                        'weightType'     => $val['gf_format_weight_type'],
                        'newmemberPrice' => $val['gf_newmember_price'],
                    );
                }
            } else {
                $spec = $row['g_format_type'] ? json_decode($row['g_format_type'], true) : [];
                foreach ($format as $val) {
                    $dataList[] = array(
                        'spec'           => [$val['gf_name']],
                        'oriPrice'       => $val['gf_ori_price'],
                        'price'          => $val['gf_price'],
                        'stock'          => $val['gf_stock'],
                        'cost'           => $val['gf_cost'],
                        'weight'         => $val['gf_format_weight'],
                        'weightType'     => $val['gf_format_weight_type'],
                        'newmemberPrice' => $val['gf_newmember_price'],
                    );
                }
            }
        }

        //留言模板
        $message_storage                 = new App_Model_Goods_MysqlMessageTemplateStorage();
        $sort                            = array('amt_update_time' => 'DESC');
        $where                           = array();
        $where[]                         = array('name' => 'amt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]                         = array('name' => 'amt_es_id', 'oper' => '=', 'value' => 0);
        $where[]                         = array('name' => 'amt_deleted', 'oper' => '=', 'value' => 0);
        $messageList                     = $message_storage->getList($where, 0, 0, $sort);
        $this->output['messageListData'] = $messageList;

        // 运费模板
        $template_storage         = new App_Model_Shop_MysqlShopDeliveryTemplateStorage();
        $sort                     = array('sdt_update_time' => 'DESC');
        $where                    = array();
        $where[]                  = array('name' => 'sdt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]                  = array('name' => 'sdt_es_id', 'oper' => '=', 'value' => 0);
        $where[]                  = array('name' => 'sdt_deleted', 'oper' => '=', 'value' => 0);
        $tempList                 = $template_storage->getList($where, 0, 0, $sort);
        $this->output['tempList'] = $tempList;

        $this->output['row']        = $row;
        $this->output['slide']      = $slide;
        $this->output['dataList']   = json_encode($dataList ? $dataList : []);
        $this->output['format']     = $format;
        $this->output['formatSort'] = implode(',', $sort);
        $this->output['spec']       = json_encode($spec ? $spec : []);
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '/wxapp/goods/index'),
            array('title' => '新增/编辑商品', 'link' => '#'),
        ));
        //获得供应商
        $this->_show_supplier_list();
        $this->renderCropTool('/wxapp/index/uploadImg');

        $this->displaySmarty('wxapp/sequence/goods-edit-new.tpl');
    }

    /*
     * 会员中心
     */
    public function centerManageAction()
    {
        $center_model = new App_Model_Member_MysqlCenterToolStorage();
        $row          = $center_model->findUpdateBySid($this->curr_sid);
        if (empty($row)) {
            $row = plum_parse_config('center_tool');
        }
        $tradeNav                 = plum_parse_config('trade_nav');
        $this->output['tradeNav'] = json_encode($tradeNav);
        $row['center']            = $this->composeLink('center', 'index', array(), true, 'info');
        $row['ct_style_type']     = 2;
        $this->output['row']      = $row;

        $sequenceShowAll = 1;
        if ($this->wxapp_cfg['ac_type'] == 36) {
            $sequenceShowAll = 0;
        }
        $this->output['sequenceShowAll'] = $sequenceShowAll;

        $this->buildBreadcrumbs(array(
            array('title' => '接龙管理', 'link' => '#'),
            array('title' => '会员中心', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg'); // 上传图片
        $this->displaySmarty('wxapp/member/sequence-member-center.tpl');
    }

    /*
     * 团长营业信息
     */
    public function leaderInfoAction()
    {
        $leaderId = $this->request->getIntParam('id');

        // 社区区域合伙人
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $leader_info  = $leader_model->getLeaderRow($leaderId);
            if ($leader_info['asl_region_manager_id'] != $this->uid) {
                plum_redirect_with_msg('无查看权限', $_SERVER['HTTP_REFERER'], true);
            }

        }

        $this->_leader_info_sum($leaderId);
        $this->_leader_info_day($leaderId);
        $this->buildBreadcrumbs(array(
            array('title' => '团长管理', 'link' => '/wxapp/sequence/leaderList'),
            array('title' => '营业详情', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sequence/leader-info.tpl');
    }

    /*
     * 团长统计
     */
    private function _leader_info_sum($leaderId, $return = false)
    {

        $where          = array();
        $where_refund   = array();
        $where[]        = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6)); //获取已付款,已发货,确认收货,已完成的订单,
        $where_refund[] = array('name' => 't_status', 'oper' => '=', 'value' => 8);
        $where[]        = $where_refund[]        = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]        = $where_refund[]        = array('name' => 't_se_leader', 'oper' => '=', 'value' => $leaderId);
        //$where[] =  $where_refund[] = array('name'=>'t_applet_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET_SEQUENCE);

        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $statistic   = $trade_model->statOrderStatisticNew($where);
        $refund      = $trade_model->statOrderStatisticNew($where_refund);
        $postFee     = $statistic['postFee'] ? floatval($statistic['postFee']) : 0;
        $info        = array(
            'tradeNum'  => $statistic['tradeNum'] ? $statistic['tradeNum'] : 0,
            'goodsNum'  => $statistic['goodsNum'] ? $statistic['goodsNum'] : 0,
            'postFee'   => $postFee,
            'goodsFee'  => $statistic['payment'] ? $statistic['payment'] : 0,
            'refund'    => $refund['payment'] ? floatval($refund['payment']) : 0,
            'refundNum' => $refund['tradeNum'] ? $refund['tradeNum'] : 0,
        );
        if ($return) {
            return $info;
        } else {
            $this->output['info'] = $info;
        }

    }

    /*
     * 团长日收益详情
     */
    private function _leader_info_day($leaderId)
    {
        //$this->count =1;
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;

        $sort           = array('t_create_time' => 'DESC');
        $where[]        = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6));
        $where_refund[] = array('name' => 't_status', 'oper' => '=', 'value' => 8);
        $where[]        = $where_refund[]        = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]        = $where_refund[]        = array('name' => 't_se_leader', 'oper' => '=', 'value' => $leaderId);
        //$where[] = $where_refund[] = array('name'=>'t_applet_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET_SEQUENCE);
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        // if($this->curr_sid == 9373){

        // }else{
        //     $total              = $trade_model->getCount($where);
        // }
        $total                    = $trade_model->getCountByDayCount($where);
        $page_libs                = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['pageHtml'] = $page_libs->render();
        $list                     = $trade_model->getTradeInfoByDayCount($where, $index, $this->count, $sort);
        $this->output['list']     = $list;
    }

    /*
     * 团长佣金信息
     */
    public function leaderDeductRecordAction()
    {
        $leaderId = $this->request->getIntParam('id');
        $status   = $this->request->getIntParam('status', 0);
        $this->_leader_deduct_sum($leaderId, $status);
        $this->_leader_deduct_list($leaderId, $status);
        $this->buildBreadcrumbs(array(
            array('title' => '团长管理', 'link' => '/wxapp/sequence/leaderList'),
            array('title' => '佣金详情', 'link' => '#'),
        ));
        $this->output['status']   = $status;
        $this->output['leaderId'] = $leaderId;
        $this->displaySmarty('wxapp/sequence/leader-deduct-record.tpl');
    }

    public function leaderDeductRecordNewAction()
    {
        $leaderId = $this->request->getIntParam('id');
        $mid      = $this->request->getIntParam('mid');
        $status   = $this->request->getIntParam('status', 0);
        $order_id = $this->request->getStrParam('order_id');

        // 社区区域合伙人
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $leader_info  = $leader_model->getLeaderRow($leaderId);
            if ($leader_info['asl_region_manager_id'] != $this->uid) {
                plum_redirect_with_msg('无查看权限', $_SERVER['HTTP_REFERER'], true);
            }

        }

        $this->_leader_member_deduct($mid);
        $this->_leader_deduct_list($leaderId, $status,$order_id);
        $this->buildBreadcrumbs(array(
            array('title' => '团长管理', 'link' => '/wxapp/sequence/leaderList'),
            array('title' => '佣金详情', 'link' => '#'),
        ));
        $this->output['status']   = $status;
        $this->output['leaderId'] = $leaderId;
        $this->output['mid']      = $mid;
        $this->displaySmarty('wxapp/sequence/leader-deduct-record-new.tpl');
    }

    private function _leader_member_deduct($mid)
    {
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member       = $member_model->getRowById($mid);
        $info         = [
            'ktx' => floatval($member['m_deduct_ktx']),
            'ytx' => floatval($member['m_deduct_ytx']),
            'dsh' => floatval($member['m_deduct_dsh']),
            //'total' => floatval($member['m_deduct_amount']),   //返佣总额
            'total' => $member['m_deduct_ktx'] + $member['m_deduct_ytx'] + $member['m_deduct_dsh'],   //返佣总额
        ];
        $this->output['info'] = $info;
    }

    /*
     * 团长统计
     */
    private function _leader_deduct_sum($leaderId, $status)
    {

        $where   = array();
        $where[] = array('name' => 'asd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'asd_leader', 'oper' => '=', 'value' => $leaderId);
        $where[] = array('name' => 'asd_status', 'oper' => '=', 'value' => $status);

        $deduct_model = new App_Model_Sequence_MysqlSequenceDeductStorage($this->curr_sid);
        $statistic    = $deduct_model->deductSum($where);
        $info         = array(
            'num'   => $statistic['num'] ? $statistic['num'] : 0,
            'money' => $statistic['money'] ? $statistic['money'] : 0,
        );
        $this->output['info'] = $info;
    }

    /**
     * 团长日收益详情
     * @param  [type] $leaderId [description]
     * @param  [type] $status   [description]
     * @param  [type] $order_id [description]
     * @return [type]           [description]
     */
    private function _leader_deduct_list($leaderId, $status,$order_id)
    {
        $this->count = 10;
        $page        = $this->request->getIntParam('page');
        $index       = $page * $this->count;
        $sort        = array('asd_create_time' => 'DESC');
        $where[]     = array('name' => 'asd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]     = array('name' => 'asd_leader', 'oper' => '=', 'value' => $leaderId);
        if(!empty($order_id)){
            $where[]=['name'=>'asd_tid','oper'=>'=','value'=>$order_id];
        }
        $deduct_model             = new App_Model_Sequence_MysqlSequenceDeductStorage($this->curr_sid);
        $total                    = $deduct_model->getCount($where);
        $page_libs                = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['pageHtml'] = $page_libs->render();

        $list        = $deduct_model->getListTrade($where, $index, $this->count, $sort);
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
        if ($list) {
            foreach ($list as $key => $val) {
                $refund_money = 0;
                $goods_list   = $order_model->fetchOrderListByTid($val['t_id']);

                foreach ($goods_list as $k => $v) {
                    if ($v['to_fd_status'] == 3) {
                        $refund_money += $v['to_total'];
                    }
                }

                $list[$key]['goods']        = $goods_list;
                $list[$key]['refund_money'] = $refund_money > 0 ? sprintf("%01.2f", $refund_money) : 0;
            }
        }

        $this->output['list'] = $list;
    }

    /*
     * 商家配送配置
     */
    public function sendCfgAction()
    {
        $this->buildBreadcrumbs(array(
            array('title' => '接龙设置', 'link' => '#'),
            array('title' => '配送配置', 'link' => '#'),
        ));

        $cfg_model = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        $row       = $cfg_model->findUpdateBySid();
        if ($row) {
            $sendCfg = $row;
        } else {
            $insert = array(
                'acs_s_id'        => $this->curr_sid,
                'acs_create_time' => time(),
            );
            $cfg_model->insertValue($insert);
            //重新获得配置信息
            $sendCfg = $cfg_model->findUpdateBySid();

        }
        $this->output['dayTime'] = plum_parse_config('day_time');
        $this->output['sendCfg'] = $sendCfg;
        //配置分段运费

        $this->displaySmarty('wxapp/sequence/send-cfg-new.tpl');
        // $this->displaySmarty('wxapp/sequence/send-cfg.tpl');

    }

    /*
     * 会员添加或移除团长
     */
    public function changeLeaderAction()
    {
        $mid          = $this->request->getIntParam('mid');
        $type         = $this->request->getIntParam('type');
        $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
        $leader       = $leader_model->getRowByMid($mid);
        $id           = $leader['asl_id'];
        $res          = false;
        if ($mid && $type) {
            if ($type == 1) {
                if ($leader) {
                    $res = $leader_model->getRowUpdateByIdSid($id, $this->curr_sid, array('asl_status' => 2));
                } else {
                    $data = array(
                        'asl_s_id'        => $this->curr_sid,
                        'asl_m_id'        => $mid,
                        'asl_status'      => 2,
                        'asl_update_time' => time(),
                        'asl_create_time' => time(),
                        'asl_create_from' => 1,
                    );
                    $res = $leader_model->insertValue($data);
                }

            } else {
                $res = $leader_model->getRowUpdateByIdSid($id, $this->curr_sid, array('asl_status' => 4));
                if ($res) {
                    $this->_deal_leader_remove($id);
                }
            }
        }

        if ($res) {
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $member       = $member_model->getRowById($mid);
            $str          = $type == 1 ? '添加' : '移除';
            App_Helper_OperateLog::saveOperateLog("用户【{$member['m_nickname']}】{$str}团长身份");
        }

        $this->showAjaxResult($res, '操作');

    }

    /*
     * 结算佣金
     */
    public function confirmDeductAction()
    {
        $leaderId     = $this->request->getIntParam('id');
        $money        = $this->request->getStrParam('money');
        $deduct_model = new App_Model_Sequence_MysqlSequenceDeductStorage($this->curr_sid);
        $where        = array();
        $where[]      = array('name' => 'asd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]      = array('name' => 'asd_leader', 'oper' => '=', 'value' => $leaderId);
        $res          = $deduct_model->updateValue(array('asd_status' => 1), $where);
        if ($res) {
            //记录本次结算
            $confirm_model = new App_Model_Sequence_MysqlSequenceDeductConfirmStorage($this->curr_sid);
            $data          = array(
                'asdc_s_id'        => $this->curr_sid,
                'asdc_leader'      => $leaderId,
                'asdc_money'       => $money,
                'asdc_create_time' => time(),
            );
            $confirm_model->insertValue($data);
        }
        $this->showAjaxResult($res, '操作');
    }

    /*
     * 取消关联
     */
    public function removeCommunityLeaderAction()
    {
        $id              = $this->request->getIntParam('id');
        $leaderId        = $this->request->getIntParam('leaderId');
        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);

        // 区域管理合伙人是否可以添加此社区的团长
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $has_area = $community_model->checkCommunityIsMine($area_info['m_area_id'], $id, $area_info['m_area_type']);
            if (!$has_area) {
                $this->displayJson(['em' => '您当前没有解除该社区团长的权限'], 1);
            }

        }
        $res = $community_model->updateById(array('asc_leader' => 0), $id);
        if ($res) {
            $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
            $community       = $community_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("小区【{$community['asa_title']}】移除关联团长成功");
        }

        $this->showAjaxResult($res, '取消');
    }

    /*
     * 供应商自定义表单
     */
    public function supplierFormAction()
    {
        $form_model = new App_Model_Sequence_MysqlSequenceSupplierFormStorage($this->curr_sid);
        $where[]    = array('name' => 'assf_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $row        = $form_model->getRow($where);
        $data       = $row['assf_data'] ? json_decode($row['assf_data'], true) : [];
        foreach ($data as $key => $val) {
            if ($val['require'] == 'true') {
                $data[$key]['require'] = true;
            } else {
                $data[$key]['require'] = false;
            }
        }
        $this->buildBreadcrumbs(array(
            array('title' => '自定义表单', 'link' => '#'),
        ));
        $this->output['formType']    = 1;
        $this->output['data']        = json_encode($data);
        $this->output['headerTitle'] = $row['assf_header_title'];
        $this->displaySmarty('wxapp/sequence/supplier-form.tpl');
    }

    /*
     * 保存供应商自定义表单
     */
    public function saveSupplierFormAction()
    {
        $formData    = $this->request->getArrParam('formData');
        $headerTitle = $this->request->getStrParam('headerTitle');
        $form_model  = new App_Model_Sequence_MysqlSequenceSupplierFormStorage($this->curr_sid);
        $where[]     = array('name' => 'assf_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $row         = $form_model->getRow($where);
        $data        = array(
            'assf_s_id'         => $this->curr_sid,
            'assf_data'         => json_encode($formData),
            'assf_header_title' => $headerTitle,
            'assf_update_time'  => time(),
        );
        if ($row) {
            $ret = $form_model->updateById($data, $row['assf_id']);
        } else {
            $ret = $form_model->insertValue($data);
        }

        if ($ret) {
            App_Helper_OperateLog::saveOperateLog("自定义表单【{$headerTitle}】保存成功");
        }

        $this->showAjaxResult($ret);
    }

    /*
     * 删除供应商申请
     */
    public function delSupplierApplyAction()
    {
        $id          = $this->request->getIntParam('id');
        $apply_model = new App_Model_Sequence_MysqlSequenceSupplierStorage($this->curr_sid);
        $res         = $apply_model->deleteDFById($id, $this->curr_sid);

        if ($res) {
            App_Helper_OperateLog::saveOperateLog("供应商申请删除成功");
        }

        $this->showAjaxResult($res, '删除');
    }

    /*
     * 群组商品统计
     */
    public function groupGoodsSumAction()
    {
        $data    = array();
        $groupId = $this->request->getIntParam('groupId');
        //获得统计信息
        $to_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
        $where[]  = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6)); //获取已付款,已发货,确认收货,已完成的订单,
        $where[]  = array('name' => 'to_se_group', 'oper' => '=', 'value' => $groupId);
        $total    = $to_model->sumPriceNum($where);
        if ($total) {
            foreach ($total as $val) {
                $data[] = array(
                    'gid'   => $val['g_id'],
                    'name'  => $val['g_name'],
                    'cover' => $val['g_cover'],
                    'num'   => $val['totalNum'],
                    'money' => $val['totalMoney'],
                );
            }
        }
        $this->buildBreadcrumbs(array(
            array('title' => '活动群组管理', 'link' => '/wxapp/sequence/groupList'),
            array('title' => '活动商品统计', 'link' => '#'),
        ));
        $this->output['data']    = $data;
        $this->output['groupId'] = $groupId;
        $this->displaySmarty('wxapp/sequence/group-goods-sum.tpl');
    }

    public function communityLeaderGoodsSumAction()
    {
        $data   = array();
        $id     = $this->request->getIntParam('id'); //社区id
        $leader = $this->request->getIntParam('leader');
        $start  = $this->request->getStrParam('start');
        $end    = $this->request->getStrParam('end');
        //获得统计信息
        if ($id && $leader) {
            $to_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);

            $where[] = ['name' => 'to_s_id', 'oper' => '=', 'value' => $this->curr_sid];
            $where[] = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6)); //获取已付款,已发货,确认收货,已完成的订单,
            $where[] = array('name' => 'to_se_leader', 'oper' => '=', 'value' => $leader);
            $where[] = array('name' => 't_home_id', 'oper' => '=', 'value' => $id);

            if (!$start && !$end) {
                $start = $end = date('Y-m-d');
            }

            if ($start) {
                $where[] = array('name' => 't_create_time', 'oper' => '>=', 'value' => strtotime($start));
            }
            if ($end) {
                $where[] = array('name' => 't_create_time', 'oper' => '<=', 'value' => (strtotime($end) + 86400));
            }

            $total = $to_model->sumPriceNumFormat($where);

            if ($total) {
                foreach ($total as $val) {
                    $data[] = array(
                        'gid'    => $val['g_id'],
                        'name'   => $val['g_name'],
                        'format' => ($val['gf_name'] ? $val['gf_name'] : '') . ($val['gf_name2'] ? '-' . $val['gf_name2'] : '') . ($val['gf_name3'] ? '-' . $val['gf_name3'] : ''),
                        'cover'  => $val['gf_id'] && $val['gf_img'] ? $val['gf_img'] : $val['g_cover'],
                        'num'    => $val['totalNum'],
                        'money'  => $val['totalMoney'],
                    );
                }
            }
        }

        $this->buildBreadcrumbs(array(
            array('title' => '小区管理', 'link' => '/wxapp/sequence/communityList'),
            array('title' => '团长商品统计', 'link' => '#'),
        ));
        $this->output['data']   = $data;
        $this->output['leader'] = $leader;
        $this->output['end']    = $end;
        $this->output['start']  = $start;
        $this->output['id']     = $id;
        $this->displaySmarty('wxapp/sequence/community-leader-goods-sum.tpl');
    }

    /*
     * 导出群组商品信息
     */
    public function groupGoodsExcelAction()
    {
        $id          = $this->request->getIntParam('id');
        $group_model = new App_Model_Sequence_MysqlSequenceGroupStorage($this->curr_sid);
        $group       = $group_model->getGroupLeaderRow($id);
        $to_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
        $where[]     = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6)); //获取已付款,已发货,确认收货,已完成的订单,
        $where[]     = array('name' => 'to_se_group', 'oper' => '=', 'value' => $id);
        $total       = $to_model->sumPriceNum($where);
        $data        = [];
        if ($total) {
            foreach ($total as $val) {
                $data[] = array(
                    'gid'   => $val['g_id'],
                    'name'  => $val['g_name'],
                    'cover' => $val['g_cover'],
                    'num'   => $val['totalNum'],
                    'money' => $val['totalMoney'] > 0 ? $val['totalMoney'] : 0,
                );
            }
        } else {
            $data = [];
        }

        $groupData = [
            'id'        => $group['asg_id'],
            'name'      => $group['asl_name'] ? $group['asl_name'] : '',
            'showId'    => $group['m_show_id'],
            'mobile'    => $group['asl_mobile'] ? $group['asl_mobile'] : '',
            'nickname'  => $group['m_nickname'],
            'activity'  => $group['asa_title'],
            'community' => $group['asc_name'],
        ];
        $filename = $group['asa_title'] . '_' . $group['asg_id'] . '.xls';

        if (!empty($data)) {
            $plugin = new App_Plugin_PHPExcel_PHPExcelPlugin();
            $plugin->down_sequence_group_goods($groupData, $data, $filename);
            die();
        }

    }

    /*
     * 导出群组商品信息
     */
    public function comLeaderGoodsExcelAction()
    {
        $id        = $this->request->getIntParam('id');
        $leader    = $this->request->getIntParam('leader');
        $startDate = $this->request->getStrParam('startDate');
        $startTime = $this->request->getStrParam('startTime');
        $endDate   = $this->request->getStrParam('endDate');
        $endTime   = $this->request->getStrParam('endTime');


        if ($startDate && $startTime && $endDate && $endTime) {
            $start           = $startDate . ' ' . $startTime;
            $end             = $endDate . ' ' . $endTime;
            $startTime       = strtotime($start);
            $endTime         = strtotime($end);
            $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
            $community       = $community_model->getCommunityLeaderRow($id);
            $to_model        = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);

            $where[] = ['name' => 'to_s_id', 'oper' => '=', 'value' => $this->curr_sid];
            $where[] = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6)); //获取已付款,已发货,确认收货,已完成的订单,
            $where[] = array('name' => 'to_se_leader', 'oper' => '=', 'value' => $leader);
            $where[] = array('name' => 't_home_id', 'oper' => '=', 'value' => $id);
            $where[] = array('name' => 't_create_time', 'oper' => '>=', 'value' => $startTime);
            $where[] = array('name' => 't_create_time', 'oper' => '<', 'value' => $endTime);
            $total   = $to_model->sumPriceNumFormat($where);
            $data    = [];
            if ($total) {
                foreach ($total as $val) {
                    $data[] = array(
                        'gid'    => $val['g_id'],
                        'name'   => $val['g_name'],
                        'format' => ($val['gf_name'] ? $val['gf_name'] : '') . ($val['gf_name2'] ? '-' . $val['gf_name2'] : '') . ($val['gf_name3'] ? '-' . $val['gf_name3'] : ''),
                        'cover'  => $val['gf_id'] && $val['gf_img'] ? $val['gf_img'] : $val['g_cover'],
                        'num'    => $val['totalNum'],
                        'money'  => $val['totalMoney'],
                    );
                }
            }

            $groupData = [
                'name'      => $community['asl_name'] ? $community['asl_name'] : '',
                'showId'    => $community['m_show_id'],
                'mobile'    => $community['asl_mobile'] ? $community['asl_mobile'] : '',
                'nickname'  => $this->utf8_orderstr_to_unicode($community['m_nickname']),
                'community' => $community['asc_name'],
            ];
            $filename = $community['asc_name'] . '.xls';

            if (!empty($data)) {
                $plugin = new App_Plugin_PHPExcel_PHPExcelPlugin();
                $plugin->down_community_leader_goods($groupData, $data, $filename);
                die();
            }
        } else {
            plum_url_location('日期请填写完整!');
        }

    }

    public function comLeaderGoodsExcelNewAction()
    {
        $ids       = $this->request->getStrParam('ids');
        $id_arr    = plum_explode($ids, '_');
        $startDate = $this->request->getStrParam('startDate');
        $startTime = $this->request->getStrParam('startTime');
        $endDate   = $this->request->getStrParam('endDate');
        $endTime   = $this->request->getStrParam('endTime');

        if ($startDate && $startTime && $endDate && $endTime) {
            $start     = $startDate . ' ' . $startTime;
            $end       = $endDate . ' ' . $endTime;
            $startTime = strtotime($start);
            $endTime   = strtotime($end);

            $community_model   = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
            $where_community   = [];
            $where_community[] = ['name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid];
            // 小区商品汇总导出
            // zhangzc
            // 2019-10-11
            if (isset($id_arr)) {
                $where_community[] = ['name' => 'asc_id', 'oper' => 'in', 'value' => $id_arr];
            }

            $where_community[] = ['name' => 'asc_status', 'oper' => '=', 'value' => 2];
            $sort              = array('asc_update_time' => 'DESC');
            $community_list    = $community_model->getCommunityLeaderList($where_community, 0, 0, $sort);
            $to_model          = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);

            $infoData   = [];
            $has_record = false;
            foreach ($community_list as $community) {
                $where = [];

                $where[] = ['name' => 'to_s_id', 'oper' => '=', 'value' => $this->curr_sid];
                $where[] = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6)); //获取已付款,已发货,确认收货,已完成的订单,
                $where[] = array('name' => 'to_se_leader', 'oper' => '=', 'value' => $community['asl_id']);
                $where[] = array('name' => 't_home_id', 'oper' => '=', 'value' => $community['asc_id']);
                $where[] = array('name' => 't_create_time', 'oper' => '>=', 'value' => $startTime);
                $where[] = array('name' => 't_create_time', 'oper' => '<', 'value' => $endTime);
                $total   = $to_model->sumPriceNumFormat($where);
                $data    = [];

                if ($total) {
                    foreach ($total as $val) {
                        $data[] = array(
                            'gid'    => $val['g_id'],
                            'name'   => $val['g_name'],
                            'format' => ($val['gf_name'] ? $val['gf_name'] : '') . ($val['gf_name2'] ? '-' . $val['gf_name2'] : '') . ($val['gf_name3'] ? '-' . $val['gf_name3'] : ''),
                            'cover'  => $val['gf_id'] && $val['gf_img'] ? $val['gf_img'] : $val['g_cover'],
                            'num'    => $val['totalNum'],
                            'money'  => $val['totalMoney'],
                        );
                    }
                }

                $groupData = [
                    'name'      => $community['asl_name'] ? $community['asl_name'] : '',
                    'showId'    => $community['m_show_id'],
                    'mobile'    => $community['asl_mobile'] ? $community['asl_mobile'] : '',
                    'nickname'  => $this->utf8_orderstr_to_unicode($community['m_nickname']),
                    'community' => $community['asc_name'],
                ];

                if (!empty($data)) {
                    $has_record = true;
                }

                $infoData[] = [
                    'data'      => $data,
                    'groupData' => $groupData,
                ];
            }

            $filename = '商品统计.xls';

            if ($has_record) {
                $plugin = new App_Plugin_PHPExcel_PHPExcelPlugin();
                $plugin->down_community_leader_goods_new($infoData, $filename);
                die();
            } else {
                plum_url_location('当前时间内没有记录!');
            }
        } else {
            plum_url_location('日期请填写完整!');
        }

    }

    /**
     * 社区团购订单导出优化
     * 优化数据库查询次数 ，优化excel数据导出效率
     * 导出的数据中订单总金额与利润没有去除掉已退款的单品
     * 同订单不合并那计算利润的时候是不是应该将利润列进行合并
     * (搜索商品名称的时候提取的是trade_order表中的标题，所以商品改过名字就不太可能被搜索到:优点：能搜索到历史记录中指定的名称版本，缺点：不能搜多到全部的记录)
     * zhangzc
     * 2019-11-12
     * @return [type] [description]
     */
    public function excelOrderNewAction()
    {
        $startDate       = $this->request->getStrParam('startDate');
        $startTime       = $this->request->getStrParam('startTime');
        $endDate         = $this->request->getStrParam('endDate');
        $endTime         = $this->request->getStrParam('endTime');
        $esId            = $this->request->getIntParam('esId');
        $orderType       = $this->request->getIntParam('orderType', -1);
        $addressOrder    = $this->request->getStrParam('addressOrder');
        $goodsOrder      = $this->request->getStrParam('goodsOrder');
        $communityOrder  = $this->request->getIntParam('communityOrder');
        $clearChildOrder = $this->request->getStrParam('clearChildOrder'); // 已退款订单是否包含
        $mergeOrder      = $this->request->getStrParam('mergeOrder');
        $orderStatus     = $this->request->getStrParam('orderStatus', 'all');
        $postType        = $this->request->getIntParam('postType');
        $communityId     = $this->request->getIntParam('communityId', 0);
        $goodsname       = $this->request->getStrParam('goodsname');

        if ($goodsOrder == 'on') {
            $communityOrder = '';
        }
        if ($communityOrder == 'on') {
            $goodsOrder = '';
        }

        $start     = $startDate . ' ' . $startTime;
        $end       = $endDate . ' ' . $endTime;
        $startTime = strtotime($start);
        $endTime   = strtotime($end);
        if (!$startTime || !$endTime) {
            $this->displayJsonError('日期格式错误，请检查后重试!');
        }

        // 要下载的文件名
        $filename = sprintf('orders_%s_%s_%s_%s.xlsx', $this->curr_sid, $startDate, $endDate, rand());

        // 拼装查询条件
        $where = [
            ['name' => 't_create_time', 'oper' => '>=', 'value' => $startTime],
            ['name' => 't_create_time', 'oper' => '<', 'value' => $endTime],
            ['name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid],
            ['name' => 't_type', 'oper' => '=', 'value' => 5],
        ];

        if ($orderType != -1) {
            $where[] = ['name' => 't_applet_type', 'oper' => '=', 'value' => $orderType];
        }

        //筛选配送方式
        if ($postType) {
            $where[] = ['name' => 't_express_method', 'oper' => '=', 'value' => $postType];
        }

        //社区团购小区筛选
        if ($communityId) {
            $where[] = ['name' => 'asc_id', 'oper' => '=', 'value' => $communityId];
        }
        // 社区团购有入住店铺？？？？
        if ($esId) {
            $where[] = ['name' => 't_es_id', 'oper' => '=', 'value' => $esId];
        }

        // 订单状态
        $trade_link = App_Helper_Trade::$trade_link_status;
        if ($orderStatus && isset($trade_link[$orderStatus]) && $trade_link[$orderStatus]['id'] > 0) {
            $where[] = ['name' => 't_status', 'oper' => '=', 'value' => $trade_link[$orderStatus]['id']];
        } else {
            $where[] = ['name' => 't_status', 'oper' => 'in', 'value' => [3, 4, 5, 6]];
        }

        if ($goodsname) {
            $title   = str_replace(" ", "", $goodsname);
            $where[] = ['name' => 'replace(to_title, " ", "")', 'oper' => 'like', 'value' => "%{$title}%"];
        }

        // 社区团购  区域管理合伙人导出订单数据时默认增加一个该管理员所属城市的小区
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            if ($area_info['m_area_type'] == 'C') {
                $where[] = ['name' => 'asa_city', 'oper' => '=', 'value' => $area_info['m_area_id']];
            } else if ($area_info['m_area_type'] == 'D') {
                $where[] = ['name' => 'asa_zone', 'oper' => '=', 'value' => $area_info['m_area_id']];
            }

        }

        // 拼装排序方式
        $sort = ['t_create_time' => 'DESC'];
        if ($communityOrder == 'on') {
            $sort = ['t_home_id' => 'DESC', 't_create_time' => 'DESC'];
        }

        // 导出数据之前先计算导出数据的大致数据量，限制大数据的导出
        $trade_order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);

        $export_num = $trade_order_model->getSequenceCountWithTrade($where);
        if ($export_num > self::MAX_EXPORT_EXCEL_ROWS) {
            $this->displayJsonError('单次导出的（子）订单数量不得超过' . self::MAX_EXPORT_EXCEL_ROWS . '行');
        }

        // 数据查询
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $trade_list  = $trade_model->getSequenceTradeForExcelExport($where, 0, 0, $sort);
        if (empty($trade_list)) {
            $this->displayJsonError('当前时间段内没有订单');
        }

        $excel_rows = [];
        foreach ($trade_list as $key => $row) {
            // 已退款单品不放入到导出数组中去
            if ($clearChildOrder == 'on') {
                $refund_status = intval($row['to_feedback']) + intval($row['to_fd_status']) + intval($row['to_fd_result']);
                if ($refund_status == 7) {
                    continue;
                }
            }
            // 按照商品合并的时候计算的商品的数量统计信息
            if ($goodsOrder == 'on') {
                $gid_sales_nums[$row['to_g_id']] += $row['to_num'];
                $gfid_sales_nums[$row['to_g_id'] . '-' . $row['to_gf_id']] += $row['to_num'];
            }

            $excel_row    = $this->setExcelDataNew($row);
            $excel_rows[] = $excel_row;

            //同一订单合并单元格
            // if($mergeOrder=='on'){
            $merge_order_nums[$row['t_tid']] += 1;
            // }

            //不按照商品进行合并的时候在计算利润
            if ($goodsOrder != 'on') {
                // 计算每一个订单的利润(在不是按照商品合并的时候计算)
                if (array_key_exists($row['t_tid'], $profit)) {
                    $profit[$row['t_tid']]['cost'] += $row['to_cost'] * $row['to_num'];
                } else {
                    $profit[$row['t_tid']] = [
                        'cost'  => $row['to_cost'] * $row['to_num'],
                        'total' => $row['t_total_fee'],
                    ];
                }
            }
        }
        // 如果要按照商品进行排序
        if ($goodsOrder == 'on') {
            $sort_gids  = array_column($excel_rows, 'g_id');
            $sort_gfids = array_column($excel_rows, 'gf_id');
            array_multisort($sort_gids, SORT_DESC, $sort_gfids, SORT_DESC, $excel_rows);
            unset($sort_gids);
            unset($sort_gfids);
        }
        // 将利润数据写入到预备导入的数组中去
        foreach ($excel_rows as $k => $val) {
            if ($goodsOrder == 'on') {
                // 进行合并的时候需要用到的合并的行数
                $merge_gids[$val['g_id']] += 1;
                $merge_gfids[$val['g_id'] . '-' . $val['gf_id']] += 1;
                $excel_rows[$k]['goodsnums']  = $gid_sales_nums[$val['g_id']];
                $excel_rows[$k]['formatnums'] = $gfid_sales_nums[$val['g_id'] . '-' . $val['gf_id']];
                unset($excel_rows[$k]['g_num']);
                unset($excel_rows[$k]['profit']);
            } else {
                $excel_rows[$k]['profit'] = $profit[$val['t_tid']]['total'] - $profit[$val['t_tid']]['cost'];
                unset($excel_rows[$k]['goodsnums']);
                unset($excel_rows[$k]['formatnums']);
            }

            // 导出到excel的时候用不到这两个字段永久剔除
            unset($excel_rows[$k]['g_id']);
            unset($excel_rows[$k]['gf_id']);
        }

        unset($profit);

        // 数据导出至Excel
        $plugin = new App_Plugin_xlsxwriter_XLSXWriterPlugin($filename);
        //根据商品排序
        if ($goodsOrder == 'on') {
            $merge_gids  = array_values($merge_gids);
            $merge_gfids = array_values($merge_gfids);
            $url         = $plugin->sequenceTradeExportWithGoodsSort($excel_rows, $merge_gids, $merge_gfids);
        } else {
            $url = $plugin->sequenceTradeExport($excel_rows, $merge_order_nums, $mergeOrder == 'on' ? true : false);
        }

        // 返回导出的连接地址-返回前端执行下载操作
        if ($url) {
            $this->displayJsonSuccess(['url' => substr($url, 1)]);
        } else {
            $this->displayJsonError('导出数据失败');
        }

    }
    /**
     * 导出的excel 数据拼装
     * zhangzc
     * 2019-11-13
     * @param [type] &$row [description]
     */
    private function setExcelDataNew($row)
    {
        $statusNote    = plum_parse_config('trade_status');
        $tradePay      = App_Helper_Trade::$trade_pay_type;
        $groupType     = plum_parse_config('group_type');
        $expressMethod = array(
            1 => '商家配送',
            2 => '门店自取',
            3 => '快递发货',
            6 => '团长配送',
        );
        //订单编号、会员名称、收货人、电话、收货人省份、收货人城市、收货人地区、收货地址、邮编
        $excel_row['t_tid']        = $row['t_tid'];
        $excel_row['t_buyer_nick'] = $this->utf8_orderstr_to_unicode($row['t_buyer_nick']);

        // 是否是退款订单
        // 0：无退款
        // 2：申请退款
        // 3：拒绝后再申请
        // 4：拒绝退款
        // 7：主动退款|同意退款
        // 8：买家撤销|自动撤销
        // zhangzc
        // 2019-09-19
        $refund_status = intval($row['to_feedback']) + intval($row['to_fd_status']) + intval($row['to_fd_result']);
        if ($refund_status == 7) {
            $excel_row['g_title'] = $row['to_title'] . '(已退款)'; //已退款的单品应该做出来特殊的标记
            $excel_row['g_title'] = [
                'value' => $row['to_title'] . '(已退款)',
                'style' => [
                    'color' => '#ff0000',
                ],
            ];
        } else {
            $excel_row['g_title'] = $row['to_title'];
        }

        // 按照商品合并的时候用到的特殊列 -非商品方式合并 unset掉
        $excel_row['goodsnums'] = 0;

        $excel_row['to_gf_name'] = $row['to_gf_name'];
        $excel_row['g_tp']       = $row['to_price'];
        // 商品合并不需要这个字段 unset掉
        $excel_row['g_num'] = $row['to_num'];

        // 按照商品合并的时候用到的特殊列 -非商品方式合并 unset掉
        $excel_row['formatnums'] = 0;

        $excel_row['o_post_price']   = $row['t_post_fee'];
        $excel_row['o_discount_fee'] = $row['t_discount_fee'];
        $excel_row['o_pay']          = $row['t_payment'];

        if ($row['t_status'] == 8) {
            $excel_row['o_status'] = '已退款';
        } else {
            $excel_row['o_status'] = $statusNote[$row['t_status']];
        }

        $excel_row['o_community']         = $row['asc_name'] ? $row['asc_name'] : '';
        $excel_row['o_community_address'] = $row['asc_address'] ? $row['asc_address'] . $row['asc_address_detail'] : '';

        $excel_row['o_leader_name']    = $row['asl_name'] ? $row['asl_name'] : '';
        $excel_row['o_leader_mobile']  = $row['asl_mobile'] ? $row['asl_mobile'] : '';
        $excel_row['o_express_method'] = $expressMethod[$row['t_express_method']]; //配送方式
        $excel_row['o_exp_company']    = $row['t_express_company'];
        $excel_row['o_exp_code']       = $row['t_express_code'];
        $excel_row['s_name']           = $row['ma_name'];
        $excel_row['s_phone']          = $row['ma_phone'];
        $excel_row['s_province']       = $row['ma_province'];
        //判断是否直辖市 如果直辖市 则市等于省
        if (in_array($row['ma_province'], array('北京市', '上海市', '天津市', '重庆市'))) {
            $city = $row['ma_province'];
        } else {
            $city = $row['ma_city'];
        }
        $excel_row['s_city'] = $city;
        $excel_row['s_zone'] = $row['ma_zone'];

        if ($row['t_express_method'] == 6) {
            $excel_row['s_detail'] = $row['t_address'];
        } else {
            $excel_row['s_detail'] = $excel_row['s_province'] . ' ' . $excel_row['s_city'] . ' ' . $excel_row['s_zone'] . ' ' . $row['ma_detail'];
        }

        // 备注信息
        $excel_row['o_sale_note'] = $row['t_note'] ? '备注: ' . $row['t_note'] . ';' : '';
        foreach (json_decode($row['t_remark_extra'], true) as $va) {
            if ($va['value']) {
                $excel_row['o_sale_note'] .= $va['name'] . ':' . $va['value'] . ';';
            }
        }
        $excel_row['o_paytype'] = $tradePay[$row['t_pay_type']];

        $excel_row['o_createtime']   = $row['t_create_time'] ? date('Y-m-d H:i:s', $row['t_create_time']) : '';
        $excel_row['o_paytime']      = $row['t_pay_time'] ? date('Y-m-d H:i:s', $row['t_pay_time']) : '';
        $excel_row['o_finishtime']   = $row['t_finish_time'] ? date('Y-m-d H:i:s', $row['t_finish_time']) : '';
        $excel_row['o_se_send_time'] = $row['t_se_send_time'] ? date('Y-m-d', $row['t_se_send_time']) : '';
        $excel_row['cost']           = $row['to_cost'];
        // 利润 -先进行站位处理
        $excel_row['profit']       = 0;
        $excel_row['assi_name']    = $row['assi_name'];
        $excel_row['assi_contact'] = $row['assi_contact'];
        $excel_row['assi_mobile']  = $row['assi_mobile'];

        // 标记为字段-导出前需要unset
        $excel_row['g_id']  = $row['to_g_id'];
        $excel_row['gf_id'] = $row['to_gf_id'];

        // 这里是无用的字段如果重构完真的没用的话那就删了，别占地方了
        // $excel_row['s_post']                      = $row['ma_post'];
        // $excel_row['o_goods_price']               = $row['t_goods_fee'];
        // $excel_row['o_total_price']               = $row['t_total_fee'];
        // $excel_row['o_promotion_fee']             = $row['t_promotion_fee'];
        // $excel_row['o_activity']                  = $row['asa_title'] ? $row['asa_title'] : '';
        // $excel_row['order_status']                = ($refund_status==7)?1:0;
        // $excel_row['g_price']                     = $row['to_total'];

        return $excel_row;
    }

    //导出订单
    public function excelOrderActivityAction()
    {
        $startDate    = $this->request->getStrParam('activity_startDate');
        $startTime    = $this->request->getStrParam('activity_startTime');
        $endDate      = $this->request->getStrParam('activity_endDate');
        $endTime      = $this->request->getStrParam('activity_endTime');
        $esId         = $this->request->getIntParam('activity_esId');
        $orderType    = $this->request->getIntParam('activity_orderType', -1);
        $groupType    = $this->request->getStrParam('activity_groupType');
        $addressOrder = $this->request->getStrParam('activity_addressOrder');
        if ($startDate && $startTime && $endDate && $endTime) {
            $start     = $startDate . ' ' . $startTime;
            $end       = $endDate . ' ' . $endTime;
            $startTime = strtotime($start);
            $endTime   = strtotime($end);
            $where     = array();
            $where[]   = array('name' => 't_create_time', 'oper' => '>=', 'value' => $startTime);
            $where[]   = array('name' => 't_create_time', 'oper' => '<', 'value' => $endTime);
            if ($orderType != -1) {
                $where[] = array('name' => 't_applet_type', 'oper' => '=', 'value' => $orderType);
            }
            $orderStatus = $this->request->getStrParam('activity_orderStatus', 'all');

            $sort = array('t_create_time' => 'DESC');
            if ($addressOrder == 'on') {
                $sort = array('ma_province' => 'DESC', 'ma_city' => 'DESC', 'ma_zone' => 'DESC', 'ma_detail' => 'DESC');
            }

            $link        = App_Helper_Group::$group_trade_status;
            $groupStatus = -1;
            if ($groupType && isset($link[$groupType]) && $link[$groupType]['id'] >= 0) {
                $groupStatus = $link[$groupType]['id'];
            }
            if ($groupStatus >= 0) {
                $where[] = array('name' => 'go_status', 'oper' => '=', 'value' => $groupStatus);
            }

            //筛选配送方式
            $postType = $this->request->getIntParam('activity_postType');
            if ($postType) {
                $where[] = array('name' => 't_express_method', 'oper' => '=', 'value' => $postType);
            }
            //社区团购小区筛选
            $communityId = $this->request->getIntParam('activity_communityId', 0);
            if ($communityId) {
                $where[] = array('name' => 'asc_id', 'oper' => '=', 'value' => $communityId);
            }

            //检索条件整理
            $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            if ($esId) {
                $where[] = array('name' => 't_es_id', 'oper' => '=', 'value' => $esId);
            }
            $where[] = array('name' => 't_status', 'oper' => '>', 'value' => 0);
            $where[] = array('name' => 't_type', 'oper' => '=', 'value' => 5);
            //$where[]    = array('name'=>'t_applet_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET_SEQUENCE);
            $activitytitle = $this->request->getStrParam('activity_activitytitle');
            if ($activitytitle) {
                $title   = str_replace(" ", "", $activitytitle);
                $where[] = array('name' => 'replace(asa_title, " ", "")', 'oper' => 'like', 'value' => "%{$title}%");
            }
            $goodsname = $this->request->getStrParam('activity_goodsname');
            if ($goodsname) {
                $title   = str_replace(" ", "", $goodsname);
                $where[] = array('name' => 'replace(g_name, " ", "")', 'oper' => 'like', 'value' => "%{$title}%");
            }
            $link = App_Helper_Trade::$trade_link_status;
            if ($orderStatus && isset($link[$orderStatus]) && $link[$orderStatus]['id'] > 0) {
                $where[] = array('name' => 't_status', 'oper' => '=', 'value' => $link[$orderStatus]['id']);
            }

            // 社区团购  区域管理合伙人导出订单数据时默认增加一个该管理员所属城市的小区
            $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
            if ($area_info) {
                if ($area_info['m_area_type'] == 'C') {
                    $where[] = ['name' => 'pasa.asa_city', 'oper' => '=', 'value' => $area_info['m_area_id']];
                } else if ($area_info['m_area_type'] == 'D') {
                    $where[] = ['name' => 'pasa.asa_zone', 'oper' => '=', 'value' => $area_info['m_area_id']];
                }

            }

            //数据展示
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
            $list        = $trade_model->getSequenceAddressActivityGoodsList($where, 0, 0, $sort);
            if (!empty($list)) {
                $tradePay      = App_Helper_Trade::$trade_pay_type;
                $groupType     = plum_parse_config('group_type');
                $statusNote    = plum_parse_config('trade_status');
                $expressMethod = array(
                    1 => '商家配送',
                    2 => '门店自取',
                    3 => '快递发货',
                    6 => '团长配送',
                );
                $newlist  = array();
                $newslist = array();
                foreach ($list as $key => $val) {

                    //一单多个商品情况
                    $trade_order = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
                    $goodsList   = $trade_order->getGoodsListByTid($val['t_id'], [], false, false, false);

                    foreach ($goodsList as $k => $v) {

                        //订单编号、会员名称、收货人、电话、收货人省份、收货人城市、收货人地区、收货地址、邮编
                        $newlist['t_tid']        = $val['t_tid'];
                        $newlist['t_buyer_nick'] = $val['t_buyer_nick'];
                        $newlist['s_name']       = $val['ma_name'];
                        $newlist['s_phone']      = $val['ma_phone'];
                        $newlist['s_province']   = $val['ma_province'];
                        //判断是否直辖市 如果直辖市 则市等于省
                        if (in_array($val['ma_province'], array('北京市', '上海市', '天津市', '重庆市'))) {
                            $city = $val['ma_province'];
                        } else {
                            $city = $val['ma_city'];
                        }
                        $newlist['s_city']   = $city;
                        $newlist['s_zone']   = $val['ma_zone'];
                        $newlist['s_detail'] = $val['ma_detail'];
                        $newlist['s_post']   = $val['ma_post'];
                        //商品标题、商品订单规格、商品订单数量、商品价格
                        $newlist['g_title']         = $v['to_title'];
                        $newlist['g_gg']            = $v['gf_name'];
                        $newlist['g_tp']            = $v['to_price'];
                        $newlist['g_num']           = $v['to_num'];
                        $newlist['g_price']         = $v['to_total'];
                        $newlist['o_goods_price']   = $val['t_goods_fee'];
                        $newlist['o_post_price']    = $val['t_post_fee'];
                        $newlist['o_total_price']   = $val['t_total_fee'];
                        $newlist['o_discount_fee']  = $val['t_discount_fee'];
                        $newlist['o_promotion_fee'] = $val['t_promotion_fee'];
                        $newlist['cost']            = $v['to_cost'];
                        //优惠方式  间隔
                        $newlist['o_pay'] = $val['t_payment'];
                        //物流公司、物流单号、订单状态（是否发货）、购买方式（支付宝，微信，银行卡）、商家编码(商品)商品编号等信息、维权信息（退，换）
                        $newlist['o_exp_company'] = $val['t_express_company'];
                        $newlist['o_exp_code']    = $val['t_express_code'];
                        if ($val['t_status'] == 8) {
                            $newlist['o_status'] = '已退款';
                        } else {
                            $newlist['o_status'] = $statusNote[$val['t_status']];
                        }
                        $newlist['o_paytype'] = $tradePay[$val['t_pay_type']];
                        //商家编码信息、维权信息（退，换）、订单来源（直购，什么拼团，积分）、
                        //是否为团长订单、订单创建时间、订单付款时间、订单商家备注、订单用户备注、商品发货时间、交易完成时间
                        $newlist['o_createtime'] = $val['t_create_time'] ? date('Y-m-d H:i:s', $val['t_create_time']) : '';
                        $newlist['o_paytime']    = $val['t_pay_time'] ? date('Y-m-d H:i:s', $val['t_pay_time']) : '';
                        $newlist['o_sale_note']  = $val['t_note'] ? '备注: ' . $val['t_note'] . ';' : '';
                        foreach (json_decode($val['t_remark_extra'], true) as $v) {
                            if ($v['value']) {
                                $newlist['o_sale_note'] .= $v['name'] . ':' . $v['value'] . ';';
                            }
                        }

                        $newlist['o_sendtime']       = $val['t_express_time'] ? date('Y-m-d H:i:s', $val['t_express_time']) : '';
                        $newlist['o_finishtime']     = $val['t_finish_time'] ? date('Y-m-d H:i:s', $val['t_finish_time']) : '';
                        $newlist['o_store_name']     = $val['os_name'] ? $val['os_name'] : '';
                        $newlist['o_express_method'] = $expressMethod[$val['t_express_method']]; //配送方式
                        $newlist['o_community']      = $val['asc_name'] ? $val['asc_name'] : '';
                        $newlist['o_activity']       = $val['asa_title'] ? $val['asa_title'] : '';
                        $newlist['o_leader_name']    = $val['asl_name'] ? $val['asl_name'] : '';
                        $newlist['o_leader_mobile']  = $val['asl_mobile'] ? $val['asl_mobile'] : '';
                        $newlist['o_se_send_time']   = $val['t_se_send_time'] ? date('Y-m-d', $val['t_se_send_time']) : '';
                        $newslist[]                  = $newlist;
                    }
                    $columNums[$key] = count($goodsList);
                }
                $filename = 'orders.xls';
                if (!empty($newslist)) {
                    $plugin = new App_Plugin_PHPExcel_PHPExcelPlugin();
                    $plugin->down_orders_sequence($newslist, $filename, $columNums);
                    die();
                }
            } else {
                plum_url_location('当前时间段内没有订单!');
            }
        } else {
            plum_url_location('日期请填写完整!');
        }
    }

    /*
     * 批量打印订单
     */
    public function printOrderListAction()
    {
        $startDate    = $this->request->getStrParam('startDate');
        $startTime    = $this->request->getStrParam('startTime');
        $endDate      = $this->request->getStrParam('endDate');
        $endTime      = $this->request->getStrParam('endTime');
        $esId         = $this->request->getIntParam('esId');
        $orderType    = $this->request->getIntParam('orderType', -1);
        $groupType    = $this->request->getStrParam('groupType');
        $addressOrder = $this->request->getStrParam('addressOrder');
        $sn           = $this->request->getStrParam('sn');
        if (!$sn) {
            $this->displayJsonError('请选择打印机');
        }
        if ($startDate && $startTime && $endDate && $endTime) {
            $start     = $startDate . ' ' . $startTime;
            $end       = $endDate . ' ' . $endTime;
            $startTime = strtotime($start);
            $endTime   = strtotime($end);
            $where     = array();
            $where[]   = array('name' => 't_create_time', 'oper' => '>=', 'value' => $startTime);
            $where[]   = array('name' => 't_create_time', 'oper' => '<', 'value' => $endTime);
            if ($orderType != -1) {
                $where[] = array('name' => 't_applet_type', 'oper' => '=', 'value' => $orderType);
            }
            $orderStatus = $this->request->getStrParam('orderStatus', 'all');

            $sort = array('t_create_time' => 'DESC');
            if ($addressOrder == 'on') {
                $sort = array('ma_province' => 'DESC', 'ma_city' => 'DESC', 'ma_zone' => 'DESC', 'ma_detail' => 'DESC');
            }

            $link        = App_Helper_Group::$group_trade_status;
            $groupStatus = -1;
            if ($groupType && isset($link[$groupType]) && $link[$groupType]['id'] >= 0) {
                $groupStatus = $link[$groupType]['id'];
            }
            if ($groupStatus >= 0) {
                $where[] = array('name' => 'go_status', 'oper' => '=', 'value' => $groupStatus);
            }

            //筛选配送方式
            $postType = $this->request->getIntParam('postType');
            if ($postType) {
                $where[] = array('name' => 't_express_method', 'oper' => '=', 'value' => $postType);
            }
            //社区团购小区筛选
            $communityId = $this->request->getIntParam('communityId', 0);
            if ($communityId) {
                $where[] = array('name' => 'asc_id', 'oper' => '=', 'value' => $communityId);
            }

            //检索条件整理
            $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            if ($esId) {
                $where[] = array('name' => 't_es_id', 'oper' => '=', 'value' => $esId);
            }
            $where[]       = array('name' => 't_status', 'oper' => '>', 'value' => 0);
            $where[]       = array('name' => 't_type', 'oper' => '=', 'value' => 5);
            $activitytitle = $this->request->getStrParam('activitytitle');
            if ($activitytitle) {
                $title   = str_replace(" ", "", $activitytitle);
                $where[] = array('name' => 'replace(asa_title, " ", "")', 'oper' => 'like', 'value' => "%{$title}%");
            }
            $goodsname = $this->request->getStrParam('goodsname');
            if ($goodsname) {
                $title   = str_replace(" ", "", $goodsname);
                $where[] = array('name' => 'replace(g_name, " ", "")', 'oper' => 'like', 'value' => "%{$title}%");
            }
            $link = App_Helper_Trade::$trade_link_status;
            if ($orderStatus && isset($link[$orderStatus]) && $link[$orderStatus]['id'] > 0) {
                $where[] = array('name' => 't_status', 'oper' => '=', 'value' => $link[$orderStatus]['id']);
            }

            // 社区团购  区域管理合伙人导出订单数据时默认增加一个该管理员所属城市的小区
            $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
            if ($area_info) {
                if ($area_info['m_area_type'] == 'C') {
                    $where[] = ['name' => 'pasa.asa_city', 'oper' => '=', 'value' => $area_info['m_area_id']];
                } else if ($area_info['m_area_type'] == 'D') {
                    $where[] = ['name' => 'pasa.asa_zone', 'oper' => '=', 'value' => $area_info['m_area_id']];
                }

            }

            //数据展示
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
            $list        = $trade_model->getSequenceAddressGoodsList($where, 0, 0, $sort);
            if ($list) {
                $print_model = new App_Helper_Print($this->curr_sid);
                $ret         = $print_model->printOrderList($list, $sn);
            } else {
                $this->displayJsonError('当前条件中没有订单');
            }
        } else {
            $this->displayJsonError('日期请填写完整');
        }

        $this->showAjaxResult($ret, '发送订单成功');

    }

    /*
     * 删除活动
     */
    public function deleteActivityAction()
    {
        $id  = $this->request->getIntParam('id');
        $set = [
            'asa_deleted' => 1,
        ];
        $activity_model = new App_Model_Sequence_MysqlSequenceActivityStorage($this->curr_sid);
        $res            = $activity_model->updateById($set, $id);

        if ($res) {
            $activity_model = new App_Model_Sequence_MysqlSequenceActivityStorage($this->curr_sid);
            $activity       = $activity_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("活动【{$activity['asa_title']}】删除成功");
        }

        $this->showAjaxResult($res, '删除');
    }

    /*
     * 订单广告
     */
    public function tradeAdAction()
    {
        $cfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
        $cfg       = $cfg_model->findUpdateBySid();

        // 选择活动文章
        $this->_shop_information();
        // 获取链接类型及列表
        $this->_get_list_for_select();
        //自营商品一级分类
        $this->_curr_first_kind_list_for_select();
        //自营商品二级分类
        $this->_curr_second_kind_list_for_select();
        //资讯分类
        $this->_get_information_category();
        //获得商品列表
        $this->_shop_goods_list();
        $this->renderCropTool('/wxapp/index/uploadImg');

        $sequenceShowAll = 1;
        if ($this->wxapp_cfg['ac_type'] == 36) {
            $sequenceShowAll = 0;
        }
        $this->output['sequenceShowAll'] = $sequenceShowAll;

        $this->output['cfg'] = $cfg;

        $this->buildBreadcrumbs(array(
            // array('title' => '接龙管理', 'link' => '#'),
            array('title' => '配置管理', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/sequence/trade-ad.tpl');
    }

    /*
     * 保存订单广告
     */
    public function saveTradeAdAction()
    {
        $rankOpen            = $this->request->getIntParam('rankOpen');
        $adOpen              = $this->request->getIntParam('adOpen');
        $adImg               = $this->request->getStrParam('adImg');
        $adLinkType          = $this->request->getStrParam('adLinkType');
        $adLink              = $this->request->getStrParam('adLink');
        $sequenceRule        = $this->request->getStrParam('sequenceRule');
        $sequenceInfoOpen    = $this->request->getIntParam('sequenceInfoOpen');
        $sequenceShareMember = $this->request->getIntParam('sequenceShareMember');
        $goodsRecord         = $this->request->getIntParam('goodsRecord');
        $prizeImg            = $this->request->getStrParam('prizeImg');
        $prizeName           = $this->request->getStrParam('prizeName');
        $shareIconOpen       = $this->request->getIntParam('shareIconOpen');
        $cartIconOpen        = $this->request->getIntParam('cartIconOpen');
        $communityIconOpen   = $this->request->getIntParam('communityIconOpen');
        $wxgroupOpen         = $this->request->getIntParam('wxgroupOpen');
        $wxgroupImg          = $this->request->getStrParam('wxgroupImg');
        $wxgroupTitle        = $this->request->getStrParam('wxgroupTitle');
        $wxgroupBrief        = $this->request->getStrParam('wxgroupBrief');
        $communityDesc       = $this->request->getStrParam('communityDesc');
        $communityRange      = $this->request->getIntParam('communityRange');
        $goodsviewRecord     = $this->request->getIntParam('goodsviewRecord');
        $listGoodsRecord     = $this->request->getIntParam('listGoodsRecord');
        $accountantRefund    = $this->request->getIntParam('accountantRefund');
        $accountantWithdraw  = $this->request->getIntParam('accountantWithdraw');
        $communityAlert      = $this->request->getIntParam('communityAlert');
        $reveiveTip          = $this->request->getIntParam('receiveTip');
        $openTime            = $this->request->getStrParam('openTime');
        $closeTime           = $this->request->getStrParam('closeTime');

        $goodsMenuTitle = $this->request->getStrParam('goodsMenuTitle');

        // $storeGoodsLimit = $this->request->getIntParam('storeGoodsLimit');
        // 转发时显示的价格原价或者是会员价的开关
        $goods_forward_price = $this->request->getIntParam('goods_forward_price', 1);
        if ($sequenceInfoOpen && (!$prizeImg || !$prizeName)) {
            $this->displayJsonError('请完善奖品信息');
        }

        $cfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
        $cfg       = $cfg_model->findUpdateBySid();

        $set = [
            'asc_ad_img'                => $adImg,
            'asc_ad_open'               => $adOpen,
            'asc_rank_open'             => $rankOpen,
            'asc_sequence_info'         => $sequenceInfoOpen,
            'asc_sequence_rule'         => $sequenceRule,
            'asc_goods_record'          => $goodsRecord,
            'asc_ad_link'               => $adLink,
            'asc_ad_link_type'          => $adLinkType,
            'asc_update_time'           => time(),
            'asc_prize_img'             => $prizeImg,
            'asc_prize_name'            => $prizeName,
            'asc_share_open'            => $shareIconOpen,
            'asc_cart_open'             => $cartIconOpen,
            'asc_community_open'        => $communityIconOpen,
            'asc_wxgroup_open'          => $wxgroupOpen,
            'asc_wxgroup_img'           => $wxgroupImg,
            'asc_wxgroup_title'         => $wxgroupTitle,
            'asc_wxgroup_brief'         => $wxgroupBrief,
            'asc_community_desc'        => $communityDesc,
            'asc_community_range'       => $communityRange,
            'asc_goods_view_record'     => $goodsviewRecord,
            'asc_list_goods_record'     => $listGoodsRecord,
            'asc_open_time'             => $openTime,
            'asc_close_time'            => $closeTime,
            'asc_community_alert_show'  => $communityAlert,
            'asc_forward_price'         => $goods_forward_price,
            'asc_receive_tip'           => $reveiveTip,
            'asc_sequence_share_member' => $sequenceShareMember,
            'asc_goods_menu_title'      => $goodsMenuTitle,
        ];

        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop_set   = [
            's_accountant_refund'   => $accountantRefund,
            's_accountant_withdraw' => $accountantWithdraw,
        ];
        $shop_model->updateById($shop_set, $this->curr_sid);

        if ($cfg) {
            $res = $cfg_model->findUpdateBySid($set);
        } else {
            $set['asc_create_time'] = time();
            $set['asc_s_id']        = $this->curr_sid;
            $res                    = $cfg_model->insertValue($set);
        }

        if ($res) {
            App_Helper_OperateLog::saveOperateLog("社区团购配置保存成功");
        }

        $this->showAjaxResult($res, '保存');
    }

    /*
     * 编辑活动关联小区
     */
    public function goodsCommunityEditAction()
    {
        $page           = $this->request->getIntParam('page');
        $index          = $page * $this->count;
        $id             = $this->request->getIntParam('id');
        $output['gid']  = $id;
        $where[]        = array('name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $output['name'] = $this->request->getStrParam('name');
        if ($output['name']) {
            $where[] = array('name' => 'asc_name', 'oper' => 'like', 'value' => "%{$output['name']}%");
        }
        $output['area'] = $this->request->getIntParam('area');
        if ($output['area']) {
            $where[] = array('name' => 'asc_area', 'oper' => '=', 'value' => $output['area']);
        }

        // 社区团购获取到区域管理合伙人旗下的所有社区
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            if ($area_info['m_area_type'] == 'C') {
                $where[] = ['name' => 'asa_city', 'oper' => '=', 'value' => $area_info['m_area_id']];
            } else if ($area_info['m_area_type'] == 'D') {
                $where[] = ['name' => 'asa_zone', 'oper' => '=', 'value' => $area_info['m_area_id']];
            }

        }

        $community_model     = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
        $total               = $community_model->getCountGoods($id, $where, 'LEFT', $area_info ? true : false);
        $pageCfg             = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $output['paginator'] = $pageCfg->render();

        // 获取当前可以购买的小区数量
        $limit_community                 = $community_model->getCountGoods($id, $where, 'RIGHT', $area_info ? true : false);
        $this->output['limit_community'] = $limit_community;
        $list                            = array();

        if ($index < $total) {
            //$sort = array('asac_sort' => 'DESC','asac_create_time'=>'DESC');
            $sort = array('asgc_id' => 'DESC', 'asc_weight' => 'DESC', 'asc_create_time' => 'DESC');
            $list = $community_model->getListGoods($id, $where, $index, $this->count, $sort, $area_info ? true : false);
        }
        if ($list) {
            $output['now'] = 1;
        }
        $output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '/wxapp/goods/index'),
            array('title' => '商品限购小区', 'link' => '#'),
        ));
        $this->_get_area_list();
        $this->showOutput($output);
        $this->displaySmarty('wxapp/sequence/goods-community-edit.tpl');
    }

    /*
     * 活动添加或移除单个小区
     */
    public function selectGoodsCommunitySingleAction()
    {
        $cid  = $this->request->getIntParam('cid');
        $gid  = $this->request->getIntParam('gid');
        $type = $this->request->getStrParam('type');
        $res  = 0;
        if ($gid && $cid && $type) {
            $asgc_model = new App_Model_Sequence_MysqlSequenceGoodsCommunityStorage($this->curr_sid);
            $row        = $asgc_model->fetchRow($gid, $cid);
            if ($type == 'add') {
                if ($row) {
                    $this->displayJsonError('商品已经存在');
                } else {
                    $data = array(
                        'asgc_s_id'        => $this->curr_sid,
                        'asgc_g_id'        => $gid,
                        'asgc_c_id'        => $cid,
                        'asgc_create_time' => time(),
                    );
                    $res = $asgc_model->insertValue($data);
                }
            } elseif ($type == 'remove') {
                if (!$row) {
                    $this->displayJsonError('商品不存在');
                } else {
                    $res = $asgc_model->deleteBySidId($row['asgc_id'], $this->curr_sid);
                }
            } else {
                $this->displayJsonError('操作异常');
            }

            if ($res) {
                $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
                $community       = $community_model->getRowById($cid);
                $goods_model     = new App_Model_Goods_MysqlGoodsStorage();
                $goods           = $goods_model->getRowById($gid);
                $str             = $type == 'add' ? '添加' : '移除';
                App_Helper_OperateLog::saveOperateLog("商品【{$goods['g_name']}】{$str}小区【{$community['asc_name']}】成功");
            }

            $this->showAjaxResult($res, '操作');
        } else {
            $this->displayJsonError('操作异常');
        }

    }

    /*
     * 活动添加或移除多个小区
     */
    public function selectGoodsCommunityMultiAction()
    {
        $ids    = $this->request->getStrParam('ids');
        $id_arr = plum_explode($ids);
        $gid    = $this->request->getIntParam('gid');
        $type   = $this->request->getStrParam('type');
        $res    = 0;
        if ($gid && $id_arr && $type) {
            $asgc_model = new App_Model_Sequence_MysqlSequenceGoodsCommunityStorage($this->curr_sid);
            if ($type == 'add') {
                foreach ($id_arr as $val) {
                    $row = $asgc_model->fetchRow($gid, $val);
                    if (!$row) {
//如果不存在，添加
                        $data = array(
                            'asgc_s_id'        => $this->curr_sid,
                            'asgc_g_id'        => $gid,
                            'asgc_c_id'        => $val,
                            'asgc_create_time' => time(),
                        );
                        $res = $asgc_model->insertValue($data);
                    }
                }

            } elseif ($type == 'remove') {
                //全部删除
                $where[] = array('name' => 'asgc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
                $where[] = array('name' => 'asgc_g_id', 'oper' => '=', 'value' => $gid);
                $where[] = array('name' => 'asgc_c_id', 'oper' => 'in', 'value' => $id_arr);
                $res     = $asgc_model->deleteValue($where);
            } else {
                $this->displayJsonError('操作异常');
            }
            if ($res) {
                $goods_model = new App_Model_Goods_MysqlGoodsStorage();
                $goods       = $goods_model->getRowById($gid);
                $str         = $type == 'add' ? '添加' : '移除';
                App_Helper_OperateLog::saveOperateLog("商品【{$goods['g_name']}】批量{$str}小区成功");
            }

            $this->showAjaxResult($res, '操作');
        } else {
            $this->displayJsonError('操作异常');
        }

    }

    /*
     * 开启关闭小区限制
     */
    public function changeGoodsLimitAction()
    {
        $id     = $this->request->getIntParam('id');
        $status = $this->request->getStrParam('status', 0);

        // 社区团购 区域管理合伙人修改商品限购的逻辑与 主管理修改的逻辑不同
        // 社区区域管理合伙人用单独的表去控制
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $region_model = new App_Model_Sequence_MysqlSequenceRegionGoodsStorage($this->curr_sid);
            $isHas        = $region_model->getCount([
                ['name' => 'asrg_shop_id', 'oper' => '=', 'value' => $this->curr_sid],
                ['name' => 'asrg_region_id', 'oper' => '=', 'value' => $area_info['m_area_id']],
                ['name' => 'asrg_goods_id', 'oper' => '=', 'value' => $id],
            ]);
            if ($isHas) {
                //存在就更新
                $where = [
                    ['name' => 'asrg_shop_id', 'oper' => '=', 'value' => $this->curr_sid],
                    ['name' => 'asrg_region_id', 'oper' => '=', 'value' => $area_info['m_area_id']],
                    ['name' => 'asrg_goods_id', 'oper' => '=', 'value' => $id],
                ];
                $data = ['asrg_limit_status' => $status];
                $res  = $region_model->updateValue($data, $where);
            } else {
                //不存在就插入
                $data = [
                    'asrg_goods_id'     => $id,
                    'asrg_region_id'    => $area_info['m_area_id'],
                    'asrg_manager_id'   => $this->uid,
                    'asrg_shop_id'      => $this->curr_sid,
                    'asrg_create_at'    => time(),
                    'asrg_limit_status' => $status,
                ];
                $res = $region_model->insertValue($data);
            }
        } else {
            $activity_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
            $set            = array(
                'g_add_bed' => $status,
            );
            $res = $activity_model->getRowUpdateByIdSid($id, $this->curr_sid, $set);
        }

        if ($res) {
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $goods       = $goods_model->getRowById($id);
            $str         = $status == 1 ? '开启' : '关闭';
            App_Helper_OperateLog::saveOperateLog("商品【{$goods['g_name']}】{$str}小区限制成功");
        }

        $this->showAjaxResult($res, '操作');
    }

    /**
     * 修改配送方式配置
     */
    public function changeCfgOpenAction()
    {
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $this->displayJson(['em' => '无操作权限'], 1);
        }

        $result = array(
            'ec' => 400,
            'em' => '修改失败',
        );
        $type  = $this->request->getStrParam('type');
        $value = $this->request->getStrParam('value');

        $status = $value == 'on' ? 1 : 0;

        if ($type == 'leaderRefund') {
            $data['asc_leader_refund'] = $status;
        }
        $data['asc_update_time'] = time();
        $cfg_storage             = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
        $cfg                     = $cfg_storage->findUpdateBySid();
        if ($cfg) {
            $ret = $cfg_storage->findUpdateBySid($data);
        } else {
            $data['asc_s_id']        = $this->curr_sid;
            $data['asc_create_time'] = time();
            $ret                     = $cfg_storage->insertValue($data);
        }

        if ($ret) {
            $result = array(
                'ec' => 200,
                'em' => ' 修改成功',
            );
            $str = $status == 1 ? '允许' : '禁止';
            App_Helper_OperateLog::saveOperateLog("{$str}团长退款");

        }
        $this->displayJson($result);
    }

    /**
     * 商品推送
     */
    public function goodsGetPushAction()
    {

        // 社区团购区域合伙人限制推送商品信息
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $this->displayJson(['em' => '暂无该商品的推送权限'], 1);
        }

        $id = $this->request->getIntParam('id');
        if ($id) {
            if ($this->curr_sid != 9373) {
                $this->_check_push_time($id);
            }

            //查找当前类型是否开启模板消息
            $setup_model = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
            $setup       = $setup_model->findOneBySid();
            if (isset($setup["aws_se_goods_get_open"]) && $setup["aws_se_goods_get_open"]) {
                $this->_record_push($id);
                plum_open_backend('templmsg', 'goodsGetTempl', array('sid' => $this->curr_sid, 'id' => $id, 'mid' => $setup["aws_se_goods_get_mid"]));
                $this->showAjaxResult(1, '推送');
            } else {
                $this->displayJsonError('请先配置模板消息');
            }
        } else {
            $this->displayJsonError('未找到商品');
        }

    }

    private function _record_push($gid)
    {
        $applet_redis = new App_Model_Applet_RedisAppletStorage($this->curr_sid);
        $time         = 60 * 60 * 2;
        $applet_redis->setGoodsGetPushLast($this->curr_sid, $gid, $time);
    }

    private function _check_push_time($gid)
    {
        $applet_redis = new App_Model_Applet_RedisAppletStorage($this->curr_sid);
        $ttl          = $applet_redis->getGoodsGetPushLast($this->curr_sid, $gid);
        if ($ttl > 0) {
            if ($ttl > 60 * 60) {
                $hour   = floor($ttl / 3600);
                $min    = floor(($ttl - 3600 * $hour) / 60);
                $second = floor((($ttl - 3600 * $hour) - 60 * $min) % 60);
                $this->displayJsonError("推送频率过高,请于{$hour}时{$min}分{$second}秒后再试");
            } elseif ($ttl > 60) {
                $min    = floor($ttl / 60); //获取分钟的整数
                $second = fmod($ttl, 60);
                $this->displayJsonError("推送频率过高,请于{$min}分{$second}秒后再试");
            } else {
                $this->displayJsonError("推送频率过高,请于{$ttl}秒后再试");
            }
        }
    }

    /*
     * 供应商列表
     */
    public function supplierInfoListAction()
    {
        $page            = $this->request->getIntParam('page');
        $index           = $page * $this->count;
        $community_model = new App_Model_Sequence_MysqlSequenceSupplierInfoStorage($this->curr_sid);
        $where[]         = array('name' => 'assi_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort            = array('assi_create_time' => 'DESC');

        $this->output['name'] = $this->request->getStrParam('name');
        if ($this->output['name']) {
            $where[] = array('name' => 'assi_name', 'oper' => 'like', 'value' => "%{$this->output['name']}%");
        }
        $this->output['mobile'] = $this->request->getIntParam('mobile', 0);
        if ($this->output['mobile']) {
            $where[] = array('name' => 'assi_mobile', 'oper' => '=', 'value' => $this->output['mobile']);
        }

        $total                      = $community_model->getCount($where);
        $pageCfg                    = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['pagination'] = $pageCfg->render();
        $list                       = $community_model->getList($where, $index, $this->count, $sort);
        $this->output['showPage']   = $total > $this->count ? 1 : 0;
        $this->output['list']       = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '供应商管理', 'link' => '#'),
            array('title' => '供应商管理', 'link' => '#'),
        ));
        $this->output['host'] = $_SERVER['HTTP_HOST'];
        $this->displaySmarty('wxapp/sequence/supplier-info-list.tpl');
    }

    /*
     * 保存供应商信息
     */
    public function supplierInfoSaveAction()
    {
        $id      = $this->request->getIntParam('id');
        $name    = $this->request->getStrParam('name');
        $mobile  = $this->request->getStrParam('mobile');
        $contact = $this->request->getStrParam('contact');
        $note    = $this->request->getStrParam('note');

        // 供应商后台 添加登录密码与供货时间字段
        // zhangzc
        // 2019-06-24
        $pwd           = $this->request->getStrParam('passwd');
        $supplier_time = $this->request->getStrParam('supplier_time');

        if ($name && $contact && $mobile && $supplier_time) {
            if (!plum_is_mobile($mobile)) {
                $this->displayJsonError('请填写正确的手机号');
            }
            $supplier_model = new App_Model_Sequence_MysqlSequenceSupplierInfoStorage($this->curr_sid);
            $exist          = $supplier_model->findRowByMobile($mobile, $id);
            if ($exist) {
                $this->displayJsonError('手机号已被占用');
            }
            if (!strtotime($supplier_time)) {
                $this->displayJsonError('时间格式错误');
            }

            $data = [
                'assi_name'          => $name,
                'assi_mobile'        => $mobile,
                'assi_contact'       => $contact,
                'assi_note'          => $note,
                'assi_update_time'   => time(),
                'assi_supplier_time' => $supplier_time,
            ];
            if ($id) {
                // 修改的时候密码不为空则更新密码
                if ($pwd) {
                    $data['assi_pass'] = plum_salt_password($pwd);
                }

                $res = $supplier_model->updateById($data, $id);
            } else {
                $data['assi_s_id']        = $this->curr_sid;
                $data['assi_create_time'] = time();
                // 密码为空的时候设置为手机号码
                if ($pwd) {
                    $data['assi_pass'] = plum_salt_password($pwd);
                } else {
                    $data['assi_pass'] = plum_salt_password($mobile);
                }

                $res = $supplier_model->insertValue($data);
            }

            if ($res) {
                App_Helper_OperateLog::saveOperateLog("供应商【{$name}】保存成功");
            }

            $this->showAjaxResult($res);

        } else {
            $this->displayJsonError('请将信息补充完整');
        }
    }

    /*
     * 删除供应商
     */
    public function supplierInfoDeleteAction()
    {
        $id             = $this->request->getIntParam('id');
        $supplier_model = new App_Model_Sequence_MysqlSequenceSupplierInfoStorage($this->curr_sid);
        $row            = $supplier_model->getRowById($id);
        $res            = $supplier_model->deleteDFById($id, $this->curr_sid);
        if ($res) {
            //取消供应商的商品关联
            $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
            $gids        = [];
            $where       = [];
            $where[]     = ['name' => 'g_s_id', 'oper' => '=', 'value' => $this->curr_sid];
            $where[]     = ['name' => 'g_supplier_id', 'oper' => '=', 'value' => $id];
            $list        = $goods_model->getList($where, 0, 0, [], ['g_id', 'g_supplier_id']);
            if ($list) {
                foreach ($list as $val) {
                    $gids[] = $val['g_id'];
                }
                if (!empty($gids)) {
                    $where   = [];
                    $where[] = ['name' => 'g_s_id', 'oper' => '=', 'value' => $this->curr_sid];
                    $where[] = ['name' => 'g_id', 'oper' => 'in', 'value' => $gids];
                    $goods_model->updateValue(['g_supplier_id' => 0], $where);
                }
            }
        }

        if ($res) {
            App_Helper_OperateLog::saveOperateLog("商品【{$row['assi_name']}】删除成功");
        }

        $this->showAjaxResult($res, '删除');

    }
    /**
     * 供应商销售统计（增加注释信息）
     * @return [type] [description]
     */
    public function supplierGoodsSumAction()
    {
        $data  = array();
        $id    = $this->request->getIntParam('id');
        $start = $this->request->getStrParam('start');
        $end   = $this->request->getStrParam('end');
        //获得统计信息
        if ($id) {
            $to_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
            $where[]  = ['name' => 'to_s_id', 'oper' => '=', 'value' => $this->curr_sid];
            $where[]  = array('name' => 'g_supplier_id', 'oper' => '=', 'value' => $id);
            $where[]  = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6)); //获取已付款,已发货,确认收货,已完成的订单,
            if (!$start && !$end) {
                $start = date('Y-m-d').' 00:00:00';
                $end   = date('Y-m-d H:i:s');
            }

            if ($start) {
                $where[] = array('name' => 't_create_time', 'oper' => '>=', 'value' => strtotime($start));
            }
            if ($end) {
                $where[] = array('name' => 't_create_time', 'oper' => '<=', 'value' => strtotime($end));
            }

            // 去除掉已退款的商品订单
            // zhangzc
            // 2019-10-22
            $where[] = ['name' => 'to_fd_result', 'oper' => 'in', 'value' => [0, 1, 3]];
            $total = $to_model->sumPriceNumFormat($where);

            if ($total) {
                foreach ($total as $val) {
                    $data[] = array(
                        'gid'    => $val['g_id'],
                        'name'   => $val['g_name'],
                        'format' => ($val['gf_name'] ? $val['gf_name'] : '') . ($val['gf_name2'] ? '-' . $val['gf_name2'] : '') . ($val['gf_name3'] ? '-' . $val['gf_name3'] : ''),
                        'cover'  => $val['gf_id'] && $val['gf_img'] ? $val['gf_img'] : $val['g_cover'],
                        'num'    => $val['totalNum'],
                        'money'  => $val['totalMoney'],
                    );
                }
            }
        }

        $this->buildBreadcrumbs(array(
            array('title' => '供应商管理', 'link' => '/wxapp/sequence/supplierInfoList'),
            array('title' => '商品统计', 'link' => '#'),
        ));
        $this->output['data']  = $data;
        $this->output['end']   = $end;
        $this->output['start'] = $start;
        $this->output['id']    = $id;
        $this->displaySmarty('wxapp/sequence/supplier-goods-sum.tpl');
    }

    /*
     * 导出群组商品信息
     */
    public function supplierGoodsExcelAction()
    {
        $id        = $this->request->getIntParam('id');
        $startDate = $this->request->getStrParam('startDate');
        $startTime = $this->request->getStrParam('startTime');
        $endDate   = $this->request->getStrParam('endDate');
        $endTime   = $this->request->getStrParam('endTime');
        if ($startDate && $startTime && $endDate && $endTime) {
            $supplier_model = new App_Model_Sequence_MysqlSequenceSupplierInfoStorage($this->curr_sid);
            $supplier       = $supplier_model->getRowById($id);
            if ($supplier) {
                $start     = $startDate . ' ' . $startTime;
                $end       = $endDate . ' ' . $endTime;
                $startTime = strtotime($start);
                $endTime   = strtotime($end);
                $to_model  = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
                $where[]   = ['name' => 'to_s_id', 'oper' => '=', 'value' => $this->curr_sid];
                $where[]   = array('name' => 'g_supplier_id', 'oper' => '=', 'value' => $id);
                $where[]   = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6)); //获取已付款,已发货,确认收货,已完成的订单,
                $where[]   = array('name' => 't_create_time', 'oper' => '>=', 'value' => $startTime);
                $where[]   = array('name' => 't_create_time', 'oper' => '<', 'value' => $endTime);

                // 去除掉已退款的商品订单
                // zhangzc
                // 2019-10-22
                $where[] = ['name' => 'to_fd_result', 'oper' => 'in', 'value' => [0, 1, 3]];

                $total = $to_model->sumPriceNumFormat($where);
                $data  = [];
                if ($total) {
                    foreach ($total as $val) {
                        $data[] = array(
                            'gid'    => $val['g_id'],
                            'name'   => $val['g_name'],
                            'format' => ($val['gf_name'] ? $val['gf_name'] : '') . ($val['gf_name2'] ? '-' . $val['gf_name2'] : '') . ($val['gf_name3'] ? '-' . $val['gf_name3'] : ''),
                            'cover'  => $val['gf_id'] && $val['gf_img'] ? $val['gf_img'] : $val['g_cover'],
                            'num'    => $val['totalNum'],
                            'money'  => $val['totalMoney'],
                        );
                    }
                }

                $groupData = [
                    'name'    => $supplier['assi_name'] ? $supplier['assi_name'] : '',
                    'mobile'  => $supplier['assi_mobile'] ? $supplier['assi_mobile'] : '',
                    'contact' => $supplier['assi_contact'] ? $supplier['assi_contact'] : '',
                ];
                $filename = $supplier['assi_name'] . '.xls';

                if (!empty($data)) {
                    $plugin = new App_Plugin_PHPExcel_PHPExcelPlugin();
                    $plugin->down_supplier_goods($groupData, $data, $filename);
                    die();
                }
            } else {
                plum_url_location('未找到供应商信息!');
            }

        } else {
            plum_url_location('日期请填写完整!');
        }

    }

    /*
     * 配货记录列表
     */
    public function prepareRecordListAction()
    {
        $this->count = 10;
        $page        = $this->request->getIntParam('page');
        $index       = $page * $this->count;
        $status      = $this->request->getIntParam('status', 0);
        $start       = $this->request->getStrParam('start');
        $end         = $this->request->getStrParam('end');
        $data        = [];
        $goodsList   = [];

        $where   = [];
        $where[] = ['name' => 'aspr_s_id', 'oper' => '=', 'value' => $this->curr_sid];

        if ($start) {
            $where[] = ['name' => 'aspr_create_time', 'oper' => '>=', 'value' => strtotime($start)];
        }
        if ($end) {
            $where[] = ['name' => 'aspr_create_time', 'oper' => '<=', 'value' => (strtotime($end) + 86400)];
        }
        if ($status) {
            $where[] = ['name' => 'aspr_status', 'oper' => '=', 'value' => $status];
        }
        $this->output['truename'] = $this->request->getStrParam('truename');
        if ($this->output['truename']) {
            $where[] = array('name' => 'asl_name', 'oper' => 'like', 'value' => "%{$this->output['truename']}%");
        }
        $this->output['community'] = $this->request->getStrParam('community');
        if ($this->output['community']) {
            $where[] = array('name' => 'asc_name', 'oper' => 'like', 'value' => "%{$this->output['community']}%");
        }
        $this->output['mobile'] = $this->request->getStrParam('mobile');
        if ($this->output['mobile']) {
            $where[] = array('name' => 'asl_mobile', 'oper' => '=', 'value' => $this->output['mobile']);
        }

        // 社区团购区域管理合伙人
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);

        $sort                       = ['aspr_create_time' => 'DESC'];
        $prepare_model              = new App_Model_Sequence_MysqlSequencePrepareRecordStorage($this->curr_sid);
        $total                      = $prepare_model->getLeaderCount($where, $area_info ? $area_info['m_area_id'] : 0, $area_info['m_area_type']);
        $pageCfg                    = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['pagination'] = $pageCfg->render();
        $this->output['showPage']   = $total > $this->count ? 1 : 0;
        $list                       = $prepare_model->getLeaderList($where, $index, $this->count, $sort, $area_info ? $area_info['m_area_id'] : 0, $area_info['m_area_type']);
        $statusNote                 = [
            1 => '待确认',
            2 => '已确认',
        ];

        //获得可选择小区列表
        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
        $community_data  = [];
        if ($area_info['m_area_id'] && $area_info['m_area_type']) {
            $community_list = $community_model->getCommunitysListByArea($area_info['m_area_id'], $area_info['m_area_type']);
        } else {
            $where_com      = [];
            $where_com[]    = ['name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid];
            $community_list = $community_model->getList($where_com, 0, 0, []);
        }

        if ($community_list) {
            foreach ($community_list as $com) {
                $community_data[] = [
                    'id'   => $com['asc_id'],
                    'name' => $com['asc_name'],
                ];
            }
        }
        $this->output['communitySelect'] = $community_data;

        if ($list) {
            foreach ($list as $val) {
                $goodsArr  = json_decode($val['aspr_goods'], true);
                $goodsData = [];
                if (is_array($goodsArr) && !empty($goodsArr)) {
                    foreach ($goodsArr as $goods) {
                        if ($goods['name']) {
                            $goodsData[] = [
                                'name' => $goods['name'],
                                'num'  => $goods['num'] ? $goods['num'] : 0,
                            ];
                        }
                    }
                }

                $data[] = [
                    'id'            => $val['aspr_id'],
                    'time'          => date('Y-m-d H:i', $val['aspr_create_time']),
                    'note'          => $val['aspr_note'],
                    'status'        => intval($val['aspr_status']),
                    'statusNote'    => $statusNote[$val['aspr_status']],
                    'goodsData'     => $goodsData,
                    'goodsList'     => json_encode($goodsData, JSON_UNESCAPED_UNICODE),
                    'goodsCount'    => count($goodsData),
                    'leaderName'    => $val['asl_name'] ? $val['asl_name'] : '',
                    'leaderMobile'  => $val['asl_mobile'] ? $val['asl_mobile'] : '',
                    'communityName' => $val['asc_name'] ? $val['asc_name'] : '',
                    'community'     => $val['aspr_cid'],
                    'addMid'        => $val['aspr_add_mid'],
                    'addType'       => $val['aspr_add_type'],
                ];
                $goodsList[$val['aspr_id']] = $goodsData;
            }
        }
        $this->output['list']      = $data;
        $this->output['goodsList'] = json_encode($goodsList, JSON_UNESCAPED_UNICODE);
        $this->output['status']    = $status;
        $this->output['start']     = $start;
        $this->output['end']       = $end;
        $this->buildBreadcrumbs(array(
            array('title' => '团长管理', 'link' => '#'),
            array('title' => '配货记录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sequence/prepare-record-list.tpl');

    }

    /*
     * 保存配货记录
     */
    public function prepareRecordSaveAction()
    {
        $goodsArr  = $this->request->getArrParam('goods');
        $note      = $this->request->getStrParam('note');
        $id        = $this->request->getIntParam('id');
        $status    = $this->request->getIntParam('status', 1);
        $community = $this->request->getIntParam('community', 0);
        // $goodsArr = json_decode($goodsList,1);
        // $this->outputSuccess($goodsArr);
        $goodsData = [];
        $res       = false;
        if ($goodsArr && is_array($goodsArr)) {
            //过滤不填名字的
            foreach ($goodsArr as $goods) {
                if ($goods['name']) {
                    $goodsData[] = [
                        'name' => $goods['name'],
                        'num'  => $goods['num'] ? $goods['num'] : '',
                    ];
                }
            }
            if ($goodsData) {
                $data = [
                    'aspr_goods'       => json_encode($goodsData, JSON_UNESCAPED_UNICODE),
                    'aspr_note'        => $note,
                    'aspr_status'      => $status,
                    'aspr_update_time' => time(),
                ];
                $prepare_model = new App_Model_Sequence_MysqlSequencePrepareRecordStorage($this->curr_sid);
                if ($id) {
                    $res = $prepare_model->updateById($data, $id);
                } else {
                    //后台添加
                    if (!$community) {
                        $this->displayJsonError('请选择小区');
                    }
                    $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
                    $community_row   = $community_model->getCommunityLeaderRow($community);
                    if ($community_row['asl_id']) {
                        $data['aspr_cid']         = $community;
                        $data['aspr_create_time'] = time();
                        $data['aspr_s_id']        = $this->curr_sid;
                        $data['aspr_leader']      = $community_row['asl_id'];
                        $data['aspr_add_type']    = 2;
                        $data['aspr_add_mid']     = $this->uid;
                        $data['aspr_m_id']        = $community_row['asl_m_id'];
                        $res                      = $prepare_model->insertValue($data);

                    } else {
                        $this->displayJsonError('当前小区没有团长');
                    }
                }

                if ($res) {
                    App_Helper_OperateLog::saveOperateLog("配货记录保存成功");
                }

                $this->showAjaxResult($res);
            } else {
                $this->displayJsonError('请填写商品信息.');
            }
        } else {
            $this->displayJsonError('请填写商品信息..');
        }
    }

    /*
     * 合伙人列表
     */
    public function managerListAction()
    {
        $page      = $this->request->getIntParam('page');
        $index     = $page * $this->count;
        $esm_model = new App_Model_Entershop_MysqlManagerStorage($this->curr_sid);
        $where[]   = array('name' => 'esm.esm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort      = array('esm.esm_update_time' => 'DESC');

        $this->output['name'] = $this->request->getStrParam('name');
        if ($this->output['name']) {
            $where[] = array('name' => 'esm.esm_nickname', 'oper' => 'like', 'value' => "%{$this->output['name']}%");
        }
        $this->output['mobile'] = $this->request->getStrParam('mobile');
        if ($this->output['mobile']) {
            $where[] = array('name' => 'esm.esm_mobile', 'oper' => '=', 'value' => $this->output['mobile']);
        }

        $total                      = $esm_model->getCountParent($where);
        $pageCfg                    = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['pagination'] = $pageCfg->render();
        $list                       = $esm_model->getListParent($where, $index, $this->count, $sort);
        $this->output['list']       = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '合伙人管理', 'link' => '#'),
            array('title' => '合伙人列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sequence/manager-list.tpl');
    }

    /*
     * 编辑合伙人
     */
    public function managerEditAction()
    {
        $id  = $this->request->getIntParam('id');
        $row = [];
        if ($id) {
            $esm_model = new App_Model_Entershop_MysqlManagerStorage();
            $row       = $esm_model->getRowById($id);
            if ($row['esm_fid']) {
                $parent                 = $esm_model->getRowById($row['esm_fid']);
                $this->output['parent'] = $parent;
            }
        }
        $this->output['row'] = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '合伙人管理', 'link' => '#'),
            array('title' => '合伙人列表', 'link' => '/wxapp/sequence/managerList'),
            array('title' => '新增/编辑合伙人', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sequence/manager-edit.tpl');
    }

    /*
     * 保存合伙人
     */
    public function managerSaveAction()
    {
        $name    = $this->request->getStrParam('name');
        $mobile  = $this->request->getStrParam('mobile');
        $percent = $this->request->getFloatParam('percent');
        $note    = $this->request->getStrParam('note');
        $fid     = $this->request->getIntParam('fid');
        $id      = $this->request->getIntParam('id', 0);
        if ($name && $mobile) {
            //检查手机号是否被占用
            if ($percent < 0 || $percent > 100) {
                $this->displayJsonError('请填写正确的分佣比例');
            }
            if (!plum_is_mobile($mobile)) {
                $this->displayJsonError('请填写正确的手机号');
            }
            if ($fid && $id && $fid == $id) {
                $this->displayJsonError('自己不能作为自己的上级');
            }
            // if($fid && $id){
            //     $managerIds = [];
            //     $this->_get_children_all([$id],1,$managerIds);
            //     if(key_exists($fid,$managerIds)){
            //         $this->displayJsonError('不能将自己的下级来作为上级');
            //     }
            // }
            $esm_model = new App_Model_Entershop_MysqlManagerStorage();
            $exist     = $esm_model->findManagerByMobile($mobile, 0, 0, $id);
            if ($exist) {
                $this->displayJsonError('手机号已被占用，请更换手机号');
            }

            $data = [
                'esm_nickname'    => $name,
                'esm_percent'     => $percent,
                'esm_note'        => $note,
                'esm_update_time' => time(),
            ];
            if ($id) {
                $row = $esm_model->getRowById($id);
                if (!$row['esm_fid']) {
                    $data['esm_fid'] = $fid;
                }
                $res = $esm_model->updateById($data, $id);
            } else {
                $data['esm_s_id']         = $this->curr_sid;
                $data['esm_fid']          = $fid;
                $data['esm_createtime']   = time();
                $data['esm_manager_type'] = 1;
                $data['esm_mobile']       = $mobile;
                $data['esm_password']     = plum_salt_password($mobile);
                $res                      = $esm_model->insertValue($data);
            }

            if ($res) {
                App_Helper_OperateLog::saveOperateLog("合伙人【{$name}】保存成功");
            }

            $this->showAjaxResult($res, '保存');
        } else {
            $this->displayJsonError('请将信息补充完整');
        }
    }

    /*
     * 递归获得全部下级
     */
    private function _get_children_all($fids, $level, &$managers)
    {
        if (!empty($fids)) {
            $manager_model = new App_Model_Entershop_MysqlManagerStorage();
            $where         = [];
            $where[]       = ['name' => 'esm_s_id', 'oper' => '=', 'value' => $this->curr_sid];
            $where[]       = ['name' => 'esm_fid', 'oper' => 'in', 'value' => $fids];
            $manager_list  = $manager_model->getList($where, 0, 0, [], ['esm_id', 'esm_nickname']);
            $fids          = [];
            if ($manager_list) {
                foreach ($manager_list as $val) {
                    $fids[]                   = $val['esm_id'];
                    $managers[$val['esm_id']] = [
                        'level' => $level,
                        'name'  => $val['esm_nickname'],
                    ];
                }
            }
            $level++;
            $this->_get_children_all($fids, $level, $managers);
        }
    }

    /**
     * 异步获取合伙人关联
     */
    public function fetchManagerAction()
    {
        $this->count = 10;
        $nickname    = $this->request->getStrParam('nickname');
        $mobile      = $this->request->getStrParam('mobile');
        $managerId   = $this->request->getIntParam('managerId');
        $page        = $this->request->getIntParam('page', 1);
        $page        = $page >= 1 ? $page : 1;
        $type        = $this->request->getStrParam('type', 'leader');
        $index       = ($page - 1) * $this->count;
        $where       = array();
        if ($nickname) {
            $where[] = array('name' => 'esm_nickname', 'oper' => 'like', 'value' => "%{$nickname}%");
        }
        if ($mobile) {
            $where[] = array('name' => 'esm_mobile', 'oper' => '=', 'value' => $mobile);
        }
        //获得指定管理员的所有下级
        if ($managerId) {
            $where[]  = array('name' => 'esm_id', 'oper' => '!=', 'value' => $managerId);
            $managers = [];
            $this->_get_children_all([$managerId], 1, $managers);
            $managerIds = array_keys($managers);
            if ($managerIds) {
                $where[] = array('name' => 'esm_id', 'oper' => 'not in', 'value' => $managerIds);

            }
        }
        $where[]      = array('name' => 'esm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]      = array('name' => 'esm_manager_type', 'oper' => '=', 'value' => 1);
        $sort         = array('esm_id' => 'desc');
        $member_model = new App_Model_Entershop_MysqlManagerStorage();
        $list         = $member_model->getList($where, $index, $this->count, $sort);
        $total        = $member_model->getCount($where);
        $tot_page     = ceil($total / $this->count);

        $menu_helper = new App_Helper_Menu();
        $menu        = $menu_helper->ajaxPageLink($tot_page, $page);

        $data = array(
            'ec'       => 200,
            'list'     => $list,
            'pageHtml' => $menu,
        );
        $this->displayJson($data);
    }

    /*
     * 添加合伙人至团长
     */
    public function addLeaderManagerAction()
    {
        $result = array(
            'em' => '关联失败',
            'ec' => 400,
        );
        $res      = false;
        $leaderId = $this->request->getIntParam('leader'); //团长id
        $id       = $this->request->getIntParam('id'); //合伙人id
        if ($leaderId && $id) {
            $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $alsm_model   = new App_Model_Sequence_MysqlSequenceLeaderManagerStorage($this->curr_sid);
            $leader       = $leader_model->getRowById($leaderId);
            if ($leader['asl_manager'] > 0) {
                //团长已有关联合伙人，移除原记录
                $where_alsm[] = array('name' => 'aslm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
                $where_alsm[] = array('name' => 'aslm_leader', 'oper' => '=', 'value' => $leader['asl_id']);
                $alsm_model->deleteValue($where_alsm);
            }
            $data = array(
                'aslm_s_id'        => $this->curr_sid,
                'aslm_leader'      => $leader['asl_id'],
                'aslm_manager'     => $id,
                'aslm_create_time' => time(),
            );
            $ret = $alsm_model->insertValue($data);
            if ($ret) {
                $res = $leader_model->updateById(array('asl_manager' => $id), $leader['asl_id']);
            }
            if ($res) {
                $result = array(
                    'em' => '关联成功',
                    'ec' => 200,
                );
                if ($res) {
                    $leader_model  = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
                    $leader        = $leader_model->getRowById($leader);
                    $manager_model = new App_Model_Entershop_MysqlManagerStorage();
                    $manager       = $manager_model->getRowById($id);

                    App_Helper_OperateLog::saveOperateLog("合伙人【{$manager['esm_name']}】关联团长【{$leader['asl_name']}】成功");
                }
            }

        }
        $this->displayJson($result);
    }

    /*
     * 合伙人提现配置
     */
    public function managerWithdrawCfgAction()
    {
        $cfg_model           = new App_Model_Entershop_MysqlManagerWithdrawCfgStorage($this->curr_sid);
        $cfg                 = $cfg_model->findUpdateBySid();
        $this->output['row'] = $cfg;
        $this->buildBreadcrumbs(array(
            array('title' => '合伙人管理', 'link' => '#'),
            array('title' => '合伙人提现', 'link' => '/wxapp/sequence/managerWithdraw'),
            array('title' => '提现配置', 'link' => '#'),

        ));
        $this->displaySmarty('wxapp/sequence/manager-withdraw-cfg.tpl');
    }

    /*
     * 保存合伙人提现配置
     */
    public function saveManagerWithdrawCfgAction()
    {
        $rate     = $this->request->getFloatParam('rate');
        $min      = $this->request->getFloatParam('min');
        $rule     = $this->request->getStrParam('rule');
        $openWx   = $this->request->getIntParam('openWx');
        $openZfb  = $this->request->getIntParam('openZfb');
        $openBank = $this->request->getIntParam('openBank');
        if ($rate < 0 || $rate > 100) {
            $this->displayJsonError('请填写正确的抽成比例');
        }
        $cfg_model = new App_Model_Entershop_MysqlManagerWithdrawCfgStorage($this->curr_sid);
        $cfg       = $cfg_model->findUpdateBySid();

        $data = [
            'emwc_update_time' => time(),
            'emwc_rate'        => $rate,
            'emwc_min'         => $min,
            'emwc_desc'        => $rule,
            'emwc_wx_open'     => $openWx,
            'emwc_zfb_open'    => $openZfb,
            'emwc_bank_open'   => $openBank,
        ];
        if ($cfg) {
            $res = $cfg_model->findUpdateBySid($data);
        } else {
            $data['emwc_s_id']        = $this->curr_sid;
            $data['emwc_create_time'] = time();
            $res                      = $cfg_model->insertValue($data);
        }

        if ($res) {
            App_Helper_OperateLog::saveOperateLog("合伙人提现配置保存成功");
        }

        $this->showAjaxResult($res, '保存');
    }

    /*
     * 清除团长合伙人
     */
    public function clearManagerAction()
    {
        $result = array(
            'em' => '清除失败',
            'ec' => 400,
        );
        $res      = false;
        $leaderId = $this->request->getIntParam('id'); //团长id
        if ($leaderId) {
            $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $alsm_model   = new App_Model_Sequence_MysqlSequenceLeaderManagerStorage($this->curr_sid);
            $leader       = $leader_model->getRowById($leaderId);
            $where_alsm[] = array('name' => 'aslm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where_alsm[] = array('name' => 'aslm_leader', 'oper' => '=', 'value' => $leaderId);
            $ret          = $alsm_model->deleteValue($where_alsm);
            if ($ret) {
                $res = $leader_model->updateById(array('asl_manager' => 0), $leader['asl_id']);
            }
            if ($res) {
                $result = array(
                    'em' => '清除成功',
                    'ec' => 200,
                );
                App_Helper_OperateLog::saveOperateLog("团长【{$leader['asl_name']}】清除合伙人成功");
            }

        }
        $this->displayJson($result);
    }

    public function managerDeductRecordAction()
    {
        $manager = $this->request->getIntParam('id');
        $status  = $this->request->getIntParam('status');
        $this->_manager_deduct_list($manager, $status);
        $this->buildBreadcrumbs(array(
            array('title' => '合伙人管理', 'link' => '#'),
            array('title' => '合伙人列表', 'link' => '/wxapp/sequence/managerList'),
            array('title' => '佣金详情', 'link' => '#'),
        ));
        $this->output['status']  = $status;
        $this->output['manager'] = $manager;

        $manager_model = new App_Model_Entershop_MysqlManagerStorage();
        $manager_row   = $manager_model->getRowById($manager);
        $info          = [
            'ktx' => floatval($manager_row['esm_deduct_ktx']),
            'ytx' => floatval($manager_row['esm_deduct_ytx']),
            'dsh' => floatval($manager_row['esm_deduct_dsh']),
        ];
        $this->output['info'] = $info;

        $this->displaySmarty('wxapp/sequence/manager-deduct-record.tpl');
    }

    /*
     * 团长日收益详情
     */
    private function _manager_deduct_list($manager, $status)
    {
        //$this->count = 1;
        $page = $this->request->getIntParam('page');

        $index   = $page * $this->count;
        $sort    = array('emd_create_time' => 'DESC');
        $where[] = array('name' => 'emd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'emd_manager', 'oper' => '=', 'value' => $manager);
        if ($status) {
            $where[] = array('name' => 'emd_status', 'oper' => '=', 'value' => $status);
        }
        $deduct_model             = new App_Model_Entershop_MysqlManagerDeductStorage($this->curr_sid);
        $total                    = $deduct_model->getCount($where);
        $page_libs                = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['pageHtml'] = $page_libs->render();
        $list                     = $deduct_model->getList($where, $index, $this->count, $sort);
        $this->output['list']     = $list;
    }

    public function managerWithdrawAction()
    {
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;

        $output = array();
        $sort   = array('emw_create_time' => 'DESC');

        $where          = array();
        $where[]        = array('name' => 'emw_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $output['name'] = $this->request->getStrParam('name');
        if ($output['name']) {
            $where[] = array('name' => 'esm_nickname', 'oper' => 'like', 'value' => "%{$output['name']}%");
        }
        $output['mobile'] = $this->request->getStrParam('mobile');
        if ($output['mobile']) {
            $where[] = array('name' => 'esm_mobile', 'oper' => '=', 'value' => $output['mobile']);
        }
        $output['audit'] = $this->request->getStrParam('audit');
        switch ($output['audit']) {
            case 'refuse':
                $where[] = array('name' => 'emw_status', 'oper' => '=', 'value' => 3);
                break;
            case 'pass':
                $where[] = array('name' => 'emw_status', 'oper' => '=', 'value' => 2);
                break;
            case 'audit':
                $where[] = array('name' => 'emw_status', 'oper' => '=', 'value' => 1);
                break;
        }

        $withdraw_model      = new App_Model_Entershop_MysqlManagerWithdrawStorage($this->curr_sid);
        $total               = $withdraw_model->getManagerCount($where);
        $page_plugin         = new Libs_Pagination_Paginator($total, $this->count, 'jquery', 1);
        $output['paginator'] = $page_plugin->render();
        $list                = array();
        if ($total > $index) {
            $list = $withdraw_model->getManagerList($where, $index, $this->count, $sort);
        }
        $output['list']            = $list;
        $output['withdraw_status'] = [
            1 => ['css' => 'danger', 'label' => '待审核'],
            2 => ['css' => 'primary', 'label' => '审核通过'],
            3 => ['css' => 'warning', 'label' => '审核拒绝'],
        ];
        $output['withdraw_status_new'] = [
            1 => ['class' => 'font-color-audit', 'label' => '待审核'],
            2 => ['class' => 'font-color-pass', 'label' => '审核通过'],
            3 => ['class' => 'font-color-refuse', 'label' => '审核拒绝'],
        ];
        $output['withdrawType'] = App_Helper_Legwork::$withdraw_note;
        $output['banks']        = plum_parse_config('banks');
        $this->showOutput($output);
        $this->buildBreadcrumbs(array(
            array('title' => '合伙人管理', 'link' => '#'),
            array('title' => '合伙人提现', 'link' => '#'),

        ));

        $this->displaySmarty('wxapp/sequence/manager-withdraw-list.tpl');

    }

    public function dealManagerWithdrawAction()
    {
        $id     = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');
        $note   = $this->request->getStrParam('note');

        $withdraw_model = new App_Model_Entershop_MysqlManagerWithdrawStorage($this->curr_sid);
        $row            = $withdraw_model->getRowByIdSid($id, $this->curr_sid);
        if ($row) {
            $set = [
                'emw_status'      => $status,
                'emw_handle_note' => $note,
                'emw_handle_time' => time(),
            ];
            $res = $withdraw_model->updateById($set, $row['emw_id']);
            if ($res) {
                // if($row['emw_type'] == 1){
                //     $field = 'income';
                // }else{
                //     $field = 'goodsfee';
                // }
                $field         = 'deduct';
                $field_ktx     = 'esm_' . $field . '_ktx';
                $field_dsh     = 'esm_' . $field . '_dsh';
                $field_ytx     = 'esm_' . $field . '_ytx';
                $manager_model = new App_Model_Entershop_MysqlManagerStorage($this->curr_sid);

                if ($status == 2) {
                    //通过审核
                    $manager_model->incrementManagerField($row['emw_manager'], -$row['emw_money'], $field_dsh);
                    $manager_model->incrementManagerField($row['emw_manager'], $row['emw_money'], $field_ytx);
                } elseif ($status == 3) {
                    //未通过
                    $manager_model->incrementManagerField($row['emw_manager'], -$row['emw_money'], $field_dsh);
                    $manager_model->incrementManagerField($row['emw_manager'], $row['emw_money'], $field_ktx);
                }
                if ($res) {
                    $manager = $manager_model->getRowById($row['emw_manager']);
                    $str     = $status == 2 ? '通过' : '不通过';
                    App_Helper_OperateLog::saveOperateLog("处理合伙人【{$manager['esm_name']}】提现申请成功，处理结果{$str}");
                }
            }
            $this->showAjaxResult($res, '操作');
        } else {
            $this->displayJsonError('未找到提现信息');
        }
    }

    /**
     * 导出团长数据
     */
    public function leaderExcelAction()
    {
        $where = array();

        // 社区团购 区域管理合伙人 权限
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $where[]                = ['name' => 'asl_region_manager_id', 'oper' => '=', 'value' => $this->uid];
            $this->output['region'] = $area_info;
        }

        $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
        $where[]      = array('name' => 'asl_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]      = array('name' => 'asl_status', 'oper' => '=', 'value' => 2);
        $sort         = array('asl_update_time' => 'DESC');
        //检索条件整理
        //数据展示
        $list = $leader_model->getLeaderList($where, 0, 0, $sort);
        if (!empty($list)) {
            //数据处理
            $rows   = array();
            $rows[] = array('用户名', '会员编号', '姓名', '电话', '分佣比例', '可提现佣金', '已提现佣金', '待审核佣金', '订单总量', '商品总量', '营业额', '配送费', '退款订单', '退款金额', '备注');
            $width  = array(
                'A' => 20,
                'B' => 20,
                'C' => 20,
                'D' => 20,
                'E' => 20,
                'F' => 20,
                'G' => 20,
                'H' => 20,
                'I' => 20,
                'J' => 20,
                'K' => 20,
                'L' => 20,
                'M' => 20,
                'N' => 20,
                'O' => 40,
            );

            foreach ($list as $key => $val) {
                //获得统计信息
                $statInfo = $this->_leader_info_sum($val['asl_id'], true);

                $rows[] = array(
                    $this->utf8_str_to_unicode($val['m_nickname']),
                    $val['m_show_id'],
                    $val['asl_name'],
                    $val['asl_mobile'],
                    $val['asl_percent'] . '%',
                    $val['m_deduct_ktx'],
                    $val['m_deduct_ytx'],
                    $val['m_deduct_dsh'],
                    $statInfo['tradeNum'],
                    $statInfo['goodsNum'],
                    $statInfo['goodsFee'],
                    $statInfo['postFee'],
                    $statInfo['refundNum'],
                    $statInfo['refund'],
                    $val['asl_remark'],
                );
            }
            $excel    = new App_Plugin_PHPExcel_PHPExcelPlugin();
            $filename = '团长信息.xls';
            $excel->down_common_excel($rows, $filename, $width);
        } else {
            plum_url_location('当前时间段内没有会员!');
        }
    }

    /**
     * utf8字符转换成Unicode字符
     */
    private function utf8_orderstr_to_unicode($utf8_str)
    {
        $unicode_str = '';
        for ($i = 0; $i < mb_strlen($utf8_str); $i++) {
            $val = mb_substr($utf8_str, $i, 1, 'utf-8');
            if (strlen($val) >= 4) {
                $unicode = (ord($val[0]) & 0xF) << 18;
                $unicode |= (ord($val[1]) & 0x3F) << 12;
                $unicode |= (ord($val[2]) & 0x3F) << 6;
                $unicode |= (ord($val[3]) & 0x3F);
                $unicode_str .= '';
            } else {
                $unicode_str .= $val;
            }
        }
        $unicode_str = $this->_filter_character($unicode_str);
        return $unicode_str;
    }

    /**
     * utf8字符转换成Unicode字符
     */
    private function utf8_str_to_unicode($utf8_str)
    {
        $unicode_str = '';
        for ($i = 0; $i < mb_strlen($utf8_str); $i++) {
            $val = mb_substr($utf8_str, $i, 1, 'utf-8');
            if (strlen($val) >= 4) {
                $unicode = (ord($val[0]) & 0xF) << 18;
                $unicode |= (ord($val[1]) & 0x3F) << 12;
                $unicode |= (ord($val[2]) & 0x3F) << 6;
                $unicode |= (ord($val[3]) & 0x3F);
                $unicode_str .= '';
            } else {
                $unicode_str .= $val;
            }
        }
        $unicode_str = $this->_filter_character($unicode_str);
        return $unicode_str;
    }

    /*
     * 过滤掉昵称中特殊字符
     */
    private function _filter_character($nickname)
    {
        $nickname = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $nickname);
        $nickname = preg_replace('/[=]/u', '', $nickname);
        $nickname = str_replace(array('"', '\''), '', $nickname);
        $nickname = addslashes(trim($nickname));
        return $nickname;
    }
    //导出订单  拼团+商城订单
    public function excelLeaderDeductAction()
    {
        $start      = $this->request->getStrParam('start');
        $end        = $this->request->getStrParam('end');
        $leaderId   = $this->request->getIntParam('leaderId', 0);
        $mergeOrder = $this->request->getStrParam('mergeOrder');

        if ($start && $end) {
            $startTime = strtotime($start);
            $endTime   = strtotime($end);
            if ($endTime < $start) {
                $temp      = $endTime;
                $endTime   = $startTime;
                $startTime = $temp;
            }

            $where   = array();
            $where[] = array('name' => 'asd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'asd_leader', 'oper' => '=', 'value' => $leaderId);
            $where[] = array('name' => 't_create_time', 'oper' => '>=', 'value' => $startTime);
            $where[] = array('name' => 't_create_time', 'oper' => '<=', 'value' => $endTime);

            $sort         = array('t_create_time' => 'DESC');
            $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $leader       = $leader_model->getRowById($leaderId);

            // $link = App_Helper_Group::$group_trade_status;

            //数据展示
            $deduct_model = new App_Model_Sequence_MysqlSequenceDeductStorage($this->curr_sid);
            $total        = $deduct_model->getCountTrade($where);
            if ($total > 5000) {
                plum_url_location('订单数量过多，请缩小范围!');
            } else {
                $list = $deduct_model->getListTrade($where, 0, 0, $sort);
                if (!empty($list)) {
                    // $tradePay   =  App_Helper_Trade::$trade_pay_type;
                    // $groupType  =  plum_parse_config('group_type');
                    // $statusNote = plum_parse_config('trade_status');
                    // $expressMethod = array(
                    //     1 => '商家配送',
                    //     2 => '门店自取',
                    //     3 => '快递发货'
                    // );
                    $newlist  = array();
                    $newslist = array();
                    $gidnums  = array();
                    $gfidnums = array();
                    foreach ($list as $key => $val) {

                        //一单多个商品情况
                        $trade_order = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
                        $goodsList   = $trade_order->getGoodsListByTid($val['t_id']);

                        foreach ($goodsList as $k => $v) {
                            $gidnums[$v['to_g_id']] += $v['to_num'];
                            $gfidnums[$v['to_g_id'] . '-' . $v['gf_id']] += $v['to_num'];

                            //订单编号、会员名称、收货人、电话、收货人省份、收货人城市、收货人地区、收货地址、邮编
                            $newlist['t_tid']        = $val['asd_tid'];
                            $newlist['t_buyer_nick'] = $this->utf8_orderstr_to_unicode($val['t_buyer_nick']);
                            //商品标题、商品订单规格、商品订单数量、商品价格
                            $newlist['g_id']           = $v['to_g_id'];
                            $newlist['gf_id']          = $v['gf_id'];
                            $newlist['g_title']        = $v['to_title'];
                            $newlist['g_gg']           = $v['to_gf_name'];
                            $newlist['g_tp']           = $v['to_price'];
                            $newlist['g_num']          = $v['to_num'];
                            $newlist['g_price']        = $v['to_total'];
                            $newlist['o_goods_price']  = $val['t_goods_fee'];
                            $newlist['o_post_price']   = $val['t_post_fee'];
                            $newlist['o_total_price']  = $val['t_total_fee'];
                            $newlist['o_payment']      = $val['t_payment'];
                            $newlist['o_create_time']  = date('Y-m-d H:i', $val['t_create_time']);
                            $newlist['o_verify_time']  = date('Y-m-d H:i', $val['asd_create_time']);
                            $newlist['o_deduct_money'] = $val['asd_money'];

                            $newslist[] = $newlist;
                        }
                        if ($mergeOrder == 'on') {
                            //同一订单合并单元格
                            $columNums[$key] = count($goodsList);
                        }
                    }
                    $filename = $leader['asl_name'] . '.xls';
                    if (!empty($newslist)) {
                        $plugin = new App_Plugin_PHPExcel_PHPExcelPlugin();
                        $plugin->down_deduct($newslist, $filename, $columNums);
                        die();
                    }
                } else {
                    plum_url_location('当前时间段内没有订单!');
                }
            }
        } else {
            plum_url_location('日期请填写完整!');
        }
    }

    public function getAreaCommunityAction()
    {
        $areaId    = $this->request->getIntParam('areaId');
        $com_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
        $where     = [];
        $where[]   = ['name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where[]   = ['name' => 'asc_area', 'oper' => '=', 'value' => $areaId];
        $where[]   = ['name' => 'asc_status', 'oper' => '=', 'value' => 2];
        $where[]   = ['name' => 'asc_leader', 'oper' => '=', 'value' => 0]; //未关联团长
        $sort      = ['asc_weight' => 'desc'];
        $list      = $com_model->getList($where, 0, 0, $sort);
        if ($list) {
            $info = [
                'data' => $list,
                'ec'   => 200,
            ];
        } else {
            $info = [
                'data' => [],
                'ec'   => 200,
            ];
        }
        echo json_encode($info);

    }

    /*
     * 保存团长申请说明
     */
    public function saveLeaderRuleAction()
    {
        $leaderRule = $this->request->getStrParam('leaderRule');
        $cfg_model  = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
        $exist      = $cfg_model->findUpdateBySid();
        $timeNow    = time();
        $set        = [
            'asc_leader_rule' => $leaderRule,
            'asc_update_time' => $timeNow,
        ];

        if ($exist) {
            $res = $cfg_model->findUpdateBySid($set);
        } else {
            $set['asc_create_time'] = $timeNow;
            $set['asc_s_id']        = $this->curr_sid;
            $res                    = $cfg_model->insertValue($set);
        }

        if ($res) {
            App_Helper_OperateLog::saveOperateLog("团长申请说明保存成功");
        }

        $this->showAjaxResult($res, '保存');
    }

    /**
     * 更换团长的区域归属--将团长分给区域管理合伙人
     * @return [type] [description]
     */
    public function changeLeaderRegionAreaAction()
    {
        $leader    = $this->request->getIntParam('leader');
        $region    = $this->request->getIntParam('region');
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $this->displayJson(['em' => '无操作权限'], 1);
        }
        $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
        $set          = [
            'asl_region_manager_id' => $region,
        ];
        $where = [
            ['name' => 'asl_s_id', 'oper' => '=', 'value' => $this->curr_sid],
            ['name' => 'asl_id', 'oper' => '=', 'value' => $leader],
        ];
        $res = $leader_model->updateValue($set, $where);

        if ($res) {
            $manager_model = new App_Model_Member_MysqlManagerStorage();
            $manager       = $manager_model->getRowById($region);
            $leader_model  = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
            $leader        = $leader_model->getRowById($leader);

            App_Helper_OperateLog::saveOperateLog("团长【{$leader['asl_name']}】设置区域合伙人【{$manager['m_nickname']}】成功");
        }

        $this->showAjaxResult($res, '设置');
    }

    /**
     * 区域管理合伙人 佣金提现申请
     * @return [type] [description]
     */
    public function regionGetMoneyAction()
    {
        $money = $this->request->getIntParam('money');
        if ($money <= 0) {
            $this->displayJson(['em' => '提现金额必须为大于0的整数'], 1);
        } else if (!is_int($money)) {
            $this->displayJson(['em' => '提现金额必须为大于0的整数'], 1);
        }

        // 区域管理合伙人佣金收益
        $region_brokerage_model  = new App_Model_Sequence_MysqlSequenceRegionBrokerageStorage($this->curr_sid);
        $brokerage_sum           = $region_brokerage_model->getRegionBrokerageSum($this->uid); // 总收益
        $brokerage_already_model = new App_Model_Sequence_MysqlSequenceRegionWithDrawStorage($this->curr_sid);
        $already_money           = $brokerage_already_model->getAlreadySum($this->uid, 1); // 已提现收益+审核中的收益

        if ($money * 100 > ($brokerage_sum - $already_money)) {
            $this->displayJson(['em' => '提现金额不在允许范围内'], 1);
        }

        $data = [
            'arwr_manager_id' => $this->uid,
            'arwr_s_id'       => $this->curr_sid,
            'arwr_type'       => 0,
            'arwr_money'      => $money * 100,
            'arwr_create_at'  => time(),
            'arwr_status'     => 0,
        ];
        $res = $brokerage_already_model->insertValue($data);
        if ($res) {
            $this->displayJson([
                'ec' => 200,
                'em' => '提现申请提交成功',
            ]);
        } else {
            $this->displayJson(['em' => '提交申请提交失败'], 1);
        }
    }

    /**
     * 修改团长推荐奖励的状态以及比例信息
     * @return [type] [description]
     */
    public function leaderRewardPerAction()
    {
        try {
            //只允许主管理员进行修改
            $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
            if ($area_info) {
                throw new Exception("当前用户无修改权限");
            }

            $status     = $this->request->getIntParam('status');
            $reward_per = $this->request->getFloatParam('reward_per');
            $close      = $this->request->getStrParam('close_type', 'open');
            // 开启时需要判断数字类型并进行保存
            if ($close == 'open') {
                if (!is_numeric($reward_per)) {
                    throw new Exception("奖励百分比必须为数字类型");
                }

                $set = ['asc_leader_recmd_reward' => $status, 'asc_leader_recmd_reward_percent' => $reward_per];
            } else {
//关闭的时候不需要进行检测奖励的比例是否存在或者是数字类型
                $set = ['asc_leader_recmd_reward' => 0];
            }

            $seqcfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
            $res          = $seqcfg_model->updateValue($set, [
                ['name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid],
            ]);
            if ($res) {
                App_Helper_OperateLog::saveOperateLog("团长推荐奖励保存成功");
                $this->displayJson(['em' => '修改成功'], 1);
            } else {
                throw new Exception("修改失败");
            }
            $this->displayJson(['em' => 'well done'], 1);
        } catch (Exception $e) {
            $this->displayJson(['em' => $e->getMessage()], 1);
        }

    }

    /**
     * 社区团购团长推荐佣金记录
     * zhangzc
     * 2019-04-26
     * @return [type] [description]
     */
    public function leaderRecmdRecordAction()
    {
        $this->buildBreadcrumbs(array(
            array('title' => '团长管理', 'link' => '#'),
            array('title' => '团长推荐奖励', 'link' => '#'),
        ));
        $page         = $this->request->getIntParam('page');
        $index        = $page * $this->count;
        $leaderID     = $this->request->getIntParam('leader_id', 0);
        $reward_model = new App_Model_Sequence_MysqlSequenceRecmdRewardStorage($this->curr_sid);

        $where = [
            ['name' => 'asrr_leader', 'oper' => '=', 'value' => $leaderID],
        ];
        $sort = ['asrr_create_at' => 'DESC'];

        $total                       = $reward_model->getCount($where);
        $reward_list                 = $reward_model->getRewardList($where, $index, $this->count, $sort);
        $pageCfg                     = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['paginator']   = $pageCfg->render();
        $this->output['reward_list'] = $reward_list;

        $this->displaySmarty('wxapp/sequence/leader-recommand-reward.tpl');
    }

    /*
     * 选择团长推荐团长列表管理
     */
    public function leaderListForSelectAction()
    {
        $page            = $this->request->getIntParam('page');
        $index           = $page * $this->count;
        $community_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
        $where[]         = array('name' => 'asl_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]         = array('name' => 'asl_status', 'oper' => '=', 'value' => 2);
        $mobile          = $this->request->getStrParam('mobile');
        $leader_id       = $this->request->getIntParam('leader_id');
        if ($mobile) {
            $where[] = array('name' => 'asl_mobile', 'oper' => '=', 'value' => $mobile);
        }
        // 去除自己和自己的下级
        if ($leader_id) {
            $where[] = array('name' => 'asl_id', 'oper' => '!=', 'value' => $leader_id);
            $where[] = array('name' => 'asl_parent_id', 'oper' => '!=', 'value' => $leader_id);
        }

        // 社区团购 区域管理合伙人 权限
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            $areaList = array();
            if ($area_info['m_area_id'] && $area_info['m_area_id'] > 0) {
                if ($area_info['m_area_type'] == 'C') {
                    $arer_where[] = ['name' => 'asa_city', 'oper' => '=', 'value' => $area_info['m_area_id']];
                } else if ($area_info['m_area_type'] == 'D') {
                    $arer_where[] = ['name' => 'asa_zone', 'oper' => '=', 'value' => $area_info['m_area_id']];
                }
                $arer_where[] = array('name' => 'asa_s_id', 'oper' => '=', 'value' => $this->curr_sid);
                $area_model   = new App_Model_Sequence_MysqlSequenceAreaStorage($this->curr_sid);
                $areaList     = $area_model->getListWithArea($arer_where, 0, 0);
            }
            $areaIds = array();
            if ($areaList) {
                foreach ($areaList as $val) {
                    $areaIds[] = $val['asa_id'];
                }
            }
            if (!empty($areaIds)) {
                $where[] = array('name' => 'asl_apply_area_id', 'oper' => 'in', 'value' => $areaIds);
            }
            $where[] = ['name' => 'asl_region_manager_id', 'oper' => '=', 'value' => $this->uid];
        }

        $list        = $community_model->getList($where, $index, $this->count);
        $total       = $community_model->getCount($where);
        $tot_page    = ceil($total / $this->count);
        $menu_helper = new App_Helper_Menu();
        $menu        = $menu_helper->ajaxPageLink($tot_page, $page, '', 'getRecommendList');

        $data = array(
            'ec'       => 200,
            'list'     => $list,
            'pageHtml' => $menu,
        );
        $this->displayJson($data);
    }

    /*
     * 设置团长推荐人
     */
    public function setLeaderRecommendAction()
    {
        $recommendId  = $this->request->getIntParam('recommendId');
        $leader_id    = $this->request->getIntParam('leader_id');
        $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
        if ($recommendId && $leader_id) {
            $leader            = $leader_model->getRowByIdSid($leader_id, $this->curr_sid);
            $recommendIdLeader = $leader_model->getRowByIdSid($recommendId, $this->curr_sid);
            if ($leader && $recommendIdLeader) {
                $ret = 0;
                if ($leader['asl_parent_id'] == $recommendId) {
                    $ret = 1;
                } else {
                    if ($recommendIdLeader['asl_parent_id'] != $leader_id) {
                        $set = array('asl_parent_id' => $recommendId);
                        $ret = $leader_model->getRowUpdateByIdSid($leader_id, $this->curr_sid, $set);
                    } else {
                        $this->displayJsonError('选择有误请重新选择');
                    }
                }

                if ($ret) {
                    App_Helper_OperateLog::saveOperateLog("团长【{$leader['asl_name']}】添加推荐人【{$recommendIdLeader['asl_name']}】成功");
                }

                $this->showAjaxResult($ret);
            } else {
                $this->displayJsonError('团长信息不存在，请稍后重试');
            }
        } else {
            $this->displayJsonError('信息不完整，请稍后重试');
        }
    }

   

    /******************************* 添加配送路线相关信息 **********************************
     *                                zhangzc
     *                                2019-07-04
     ************************************************************************************/
    /**
     * 配送路线列表
     * @return [type] [description]
     */
    public function deliveryRouteAction()
    {
        $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
        if ($area_info) {
            plum_redirect_with_msg('无查看权限', $_SERVER['HTTP_REFERER'], true);
        }

        $this->buildBreadcrumbs(array(
            array('title' => '配送路线管理', 'link' => '#'),
        ));

        $page               = $this->request->getIntParam('page');
        $delivery_name      = $this->request->getStrParam('delivery_name');
        $route_name         = $this->request->getStrParam('route_name');
        $delivery_mobile    = $this->request->getStrParam('delivery_mobile');
        $delivery_community = $this->request->getStrParam('delivery_community');

        $index     = $this->count * $page;
        $where_all = [];
        $where[]   = $where_all[]   = ['name' => 'asdr_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where[]   = $where_all[]   = ['name' => 'asdr_deleted', 'oper' => '=', 'value' => 0];
        if ($delivery_name) {
            $where[] = ['name' => 'asdr_delivery_name', 'oper' => 'like', 'value' => "%{$delivery_name}%"];
        }

        if ($route_name) {
            $where[] = ['name' => 'asdr_name', 'oper' => 'like', 'value' => "%{$route_name}%"];
        }

        if ($delivery_mobile) {
            $where[] = ['name' => 'asdr_delivery_mobile', 'oper' => '=', 'value' => $delivery_mobile];
        }

        $is_join = false; //是否使用链接查询（用于在使用小区名称进行查询的时候）
        if ($delivery_community) {
            $where[] = ['name' => 'asc_name', 'oper' => 'like', 'value' => "%{$delivery_community}%"];
            $is_join = true;
        }

        $delivery_route_model = new App_Model_Sequence_MysqlSequenceDeliveryrouteStorage($this->curr_sid);

        $total                     = $delivery_route_model->getRouteCount($where, $is_join);
        $pageCfg                   = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['paginator'] = $pageCfg->render();
        $sort                      = array('asdr_sort' => 'ASC');
        $route_list                = $delivery_route_model->getRouteList($where, $index, $this->count, $sort, $is_join);

        // 查询每个路线中小区的数量(没有主键的暴力匹配)
        // zhangzc
        // 2019-12-04
        $route_detail_model = new App_Model_Sequence_MysqlSequenceDeliveryroutedetailStorage($this->curr_sid);
        //避免没有路线的时候报错 dn 2019-12-05
        if ($route_list) {
            $route_list_count = $route_detail_model->getRouteCountMulti(array_column($route_list, 'asdr_id'));
            foreach ($route_list as $rlkey => $rlval) {
                foreach ($route_list_count as $rlckey => $rlcval) {
                    if ($rlval['asdr_id'] == $rlcval['asdrt_dr_id']) {
                        $route_list[$rlkey]['asdr_delivery_num'] = $rlcval['total'];
                        break;
                    }
                }
            }
        }

        $this->output['route_list'] = $route_list;

        //获得所有配送路线
        $route_list_all                 = $delivery_route_model->getList($where_all, 0, 0, $sort);
        $this->output['route_list_all'] = $route_list_all;

        $this->displaySmarty('wxapp/sequence/route-list.tpl');
    }

    /**
     * 查看路线信息+ 路线中的小区详细信息
     * @return [type] [description]
     */
    public function viewEditRouteAction()
    {
        $this->count = 16;
        $route_id    = $this->request->getIntParam('route_id');
        $this->buildBreadcrumbs(array(
            array('title' => '配送路线管理', 'link' => '/wxapp/sequence/deliveryRoute'),
            array('title' => '配送路线' . ($route_id ? '详情' : '新增'), 'link' => '#'),
        ));

        $route_model = new App_Model_Sequence_MysqlSequenceDeliveryrouteStorage($this->curr_sid);
        $route_info  = $route_model->getRow([
            ['name' => 'asdr_id', 'oper' => '=', 'value' => $route_id],
            ['name' => 'asdr_s_id', 'oper' => '=', 'value' => $this->curr_sid],
            ['name' => 'asdr_deleted', 'oper' => '=', 'value' => 0],
        ]);
        $this->output['route_info'] = $route_info;

        // 读取路线中的小区信息
        $page  = $this->request->getIntParam('page');
        $index = $this->count * $page;
        $where = [
            ['name' => 'asdrt_dr_id', 'oper' => '=', 'value' => $route_id],
        ];
        $sort = ['asdrt_sort' => 'ASC'];

        $route_detail_model = new App_Model_Sequence_MysqlSequenceDeliveryroutedetailStorage($this->curr_sid);
        $total              = $route_detail_model->getRouteCommunityCount($where);

        $pageCfg                        = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['paginator']      = $pageCfg->render();
        $community_list                 = $route_detail_model->getDeliveryDetailList($where, $index, $this->count, $sort);
        $this->output['community_list'] = $community_list;

        $area_model               = new App_Model_Member_MysqlRegionStorage();
        $province                 = $area_model->get_province();
        $this->output['province'] = $province;

        $this->displaySmarty('wxapp/sequence/route-info.tpl');
    }
    /**
     * 创建配送路线
     * @return [type] [description]
     */
    public function createDeliveryRouteAction()
    {
        $route_id        = $this->request->getIntParam('route_id');
        $route_name      = $this->request->getStrParam('route_name');
        $delivery_staff  = $this->request->getStrParam('delivery_staff');
        $delivery_mobile = $this->request->getStrParam('delivery_mobile');
        $communitys      = $this->request->getArrParam('communitys');
        if (!$route_name) {
            $this->displayJsonError('路线名称不能为空！');
        }

        if (!$delivery_staff) {
            $this->displayJsonError('配送员名称不能为空！');
        }

        if (!plum_is_phone($delivery_mobile)) {
            $this->displayJsonError('手机号码格式错误！');
        }

        if (empty($communitys)) {
            $this->displayJsonError('未添加团长信息！');
        }

        DB::$db->cur_link->begin_transaction();

        //现将基本信息写入到路线表中，
        //然后逐条写入选中的社区信息到配送路线-小区关联表中
        //将写入的总数量更新至路线表中总的社区的数量
        $route_model = new App_Model_Sequence_MysqlSequenceDeliveryrouteStorage($this->curr_sid);
        $route_set   = [
            'asdr_s_id'            => $this->curr_sid,
            'asdr_name'            => $route_name,
            'asdr_delivery_name'   => $delivery_staff,
            'asdr_delivery_mobile' => $delivery_mobile,
        ];
        if ($route_id) {
            $route_set['asdr_update_time'] = time();
            $route_exec                    = $route_model->updateById($route_set, $route_id);
        } else {
            $route_set['asdr_create_time'] = time();
            $route_exec                    = $route_model->insertValue($route_set);
        }
        if (!$route_exec) {
            DB::$db->cur_link->rollback();
            $this->displayJsonError('路线信息保存失败!');
        }

        $route_community_model = new App_Model_Sequence_MysqlSequenceDeliveryroutedetailStorage($this->curr_sid);
        $community_num         = 0;
        foreach ($communitys as $value) {
            $rc_set = [
                'asdrt_s_id'         => $this->curr_sid,
                'asdrt_dr_id'        => $route_id ? $route_id : $route_exec,
                'asdrt_community_id' => $value,
                'asdrt_leader_id'    => 0,
                'asdrt_create_time'  => time(),
            ];
            // 插入之前判断当前小区是否已有配送路线
            $is_exist = $route_community_model->getCount([
                ['name' => 'asdrt_s_id', 'oper' => '=', 'value' => $this->curr_sid],
                ['name' => 'asdrt_community_id', 'oper' => '=', 'value' => $value],
                ['name' => 'asdrt_dr_id', 'oper' => '=', 'value' => $route_id ? $route_id : $route_exec],
            ]);
            if ($is_exist) {
                break;
                DB::$db->cur_link->rollback();
                $this->displayJsonError('当前选择的小区中存在已配置过路线的内容');
            }
            $insert_exec = $route_community_model->insertValue($rc_set);
            if ($insert_exec) {
                $community_num++;
            } else {
                break;
            }

        }
        if (!$insert_exec) {
            DB::$db->cur_link->rollback();
            $this->displayJsonError('小区信息保存失败');
        }

        // $num_exec=$route_model->incrementField('asdr_delivery_num',[
        //     ['name'=>'asdr_id','oper'=>'=','value'=>$route_id?$route_id:$route_exec],
        // ],$community_num);
        $num_exec = true;

        if (!$num_exec) {
            DB::$db->cur_link->rollback();
            $this->displayJsonError('路线信息更新失败');
        }
        DB::$db->cur_link->commit();
        App_Helper_OperateLog::saveOperateLog("配送路线【{$route_name}】保存成功");
        $this->displayJsonSuccess(['route_id' => $route_id ? $route_id : $route_exec], true, '保存成功');

    }
    /**
     * 删除配送路线
     * 这样的删除方式不太合理，应该先删除关联的小区信息以后再去删除 配送的路线
     * @return [type] [description]
     */
    public function deleteDeliveryRouteAction()
    {
        //删除配送路线
        $route_id           = $this->request->getIntParam('route_id');
        $no_detail          = false;
        $route_model        = new App_Model_Sequence_MysqlSequenceDeliveryrouteStorage($this->curr_sid);
        $route_detail_model = new App_Model_Sequence_MysqlSequenceDeliveryroutedetailStorage($this->curr_sid);
        $route_count        = $route_detail_model->getCount([
            ['name' => 'asdrt_s_id', 'oper' => '=', 'value' => $this->curr_sid],
            ['name' => 'asdrt_dr_id', 'oper' => '=', 'value' => $route_id],
        ]);
        if (intval($route_count) == 0) {
            $no_detail = true;
        }

        $row = $route_model->getRowById($route_id);
        DB::$db->cur_link->begin_transaction();

        $route_exec = $route_model->updateValue(['asdr_deleted' => 1, 'asdr_delivery_num' => 0], [
            ['name' => 'asdr_id', 'oper' => '=', 'value' => $route_id],
            ['name' => 'asdr_s_id', 'oper' => '=', 'value' => $this->curr_sid],
        ]);
        //同时删除配送路线与小区关联表中对应的数据
        //改为物理删除
        $detail_exec = $route_detail_model->deleteValue([
            ['name' => 'asdrt_dr_id', 'oper' => '=', 'value' => $route_id],
            ['name' => 'asdrt_s_id', 'oper' => '=', 'value' => $this->curr_sid],
        ]);

        if ($route_exec && ($detail_exec || $no_detail)) {
            DB::$db->cur_link->commit();
            App_Helper_OperateLog::saveOperateLog("配送路线【{$row['asdr_name']}】删除成功");
            $this->showAjaxResult(true, '删除');
        } else {
            DB::$db->cur_link->rollback();
            $this->displayJsonError('删除失败');
        }
    }
    /**
     * 删除配送路线中的指定小区
     * @return [type] [description]
     */
    public function deleteDeliveryRouteDetailAction()
    {
        $route_detail_id = $this->request->getIntParam('community_id');
        DB::$db->cur_link->begin_transaction();
        $route_detail_model = new App_Model_Sequence_MysqlSequenceDeliveryroutedetailStorage($this->curr_sid);
        $route__detail_info = $route_detail_model->getRowById($route_detail_id);
        //改为物理删除
        $delete_exec = $route_detail_model->deleteValue([
            ['name' => 'asdrt_id', 'oper' => '=', 'value' => $route_detail_id],
            ['name' => 'asdrt_s_id', 'oper' => '=', 'value' => $this->curr_sid],
        ]);

        $route_model = new App_Model_Sequence_MysqlSequenceDeliveryrouteStorage($this->curr_sid);

        $route_exec = true;

        if ($delete_exec && $route_exec) {
            DB::$db->cur_link->commit();
            $route           = $route_model->getRowById($route__detail_info['asdrt_dr_id']);
            $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
            $community       = $community_model->getRowById($route_detail_id);
            App_Helper_OperateLog::saveOperateLog("配送路线【{$route['asdr_name']}】删除小区【{$community['asc_name']}】成功");
            $this->showAjaxResult(true, '删除');
        } else {
            DB::$db->cur_link->rollback();
            $this->displayJsonError('删除失败');
        }

    }
    /**
     * [查看每个小区中商品的配送统计信息]
     * @return [type] [description]
     */
    public function viewRouteCommunityGoodsAction()
    {
        $route_id = $this->request->getIntParam('route_id');
        $this->buildBreadcrumbs(array(
            array('title' => '配送路线管理', 'link' => '/wxapp/sequence/deliveryRoute'),
            array('title' => '配送路线', 'link' => '/wxapp/sequence/viewEditRoute?route_id=' . $route_id),
            array('title' => '小区统计', 'link' => '#'),
        ));

        $community_id = $this->request->getIntParam('community_id');
        $start        = $this->request->getStrParam('start');
        $end          = $this->request->getStrParam('end');
        $goods_name   = $this->request->getStrParam('goods_name');
        // 统计信息需要剔除已关闭的订单和待付款的订单和已退款的订单
        $where                 = array();
        $where[]               = array('name' => 't_status', 'oper' => 'in', 'value' => array(2, 3, 4, 5, 6));
        $data                  = $this->getCommunityGoodsSum(0, $community_id, $start, $end, $goods_name, $where);
        $this->output['total'] = $data;
        $this->displaySmarty('wxapp/sequence/route-community-order-sum.tpl');
    }
    /**
     * 导出指定路线的配送详细信息（按照时间进行导出）
     * @return [type] [description]
     */
    public function exportRouteDeliveryDataAction()
    {
        $route_id = $this->request->getIntParam('route_id');
        $start    = $this->request->getStrParam('start');
        $end      = $this->request->getStrParam('end');
        $type     = $this->request->getIntParam('type', 1); //type  1.原按小区汇总订单 2.按商品汇总
        $status   = $this->request->getIntParam('status', 0); // 0不包含已完成的订单 1，包含已完成的订单
        if (!(strtotime($start) && strtotime($end))) {
            $this->errorMsg('时间格式错误');
        } else if ((strtotime($end) - strtotime($start)) > 60 * 60 * 24 * 7) {
            $this->errorMsg('导出数据范围最多支持七日');
        }

        // 获取配送路线的基本信息
        $route_model = new App_Model_Sequence_MysqlSequenceDeliveryrouteStorage($this->curr_sid);
        $route_info  = $this->getRouteInfo($route_model, $route_id);
        // 获取路线下所有小区+团长的信息
        $route_community_model = new App_Model_Sequence_MysqlSequenceDeliveryroutedetailStorage($this->curr_sid);
        $community_leader_info = $this->getRouteCommunityAndLeaderInfo($route_community_model, $route_id);
        // 判断是否选择N日后配送的商品订单的导出
        // zhangzc
        // 2019-11-12
        $sequence_day = $this->request->getIntParam('sequence_day', 0);
        if ($sequence_day == 0) {
            $where[] = ['name' => 'to_se_send_time', 'oper' => '<=', 'value' => strtotime($end)];
        }
        // type=2是配送数据导出
        if ($type == 2) {
            $data = [];
            if (empty($community_leader_info)) {
                $this->errorMsg('路线中没有小区');
            }
            $community_ids = [];
            foreach ($community_leader_info as $key => $value) {
                $community_ids[] = $value['asc_id'];
            }
            // 添加已完成的删选条件
            // zhangzc
            // 2019-12-20
            if ($status == 3) {
                $where[] = array('name' => 't_status', 'oper' => 'in', 'value' => array(2, 3, 4, 5, 6));
            } else if ($status == 1) {
                $where[] = array('name' => 't_status', 'oper' => 'in', 'value' => array(2, 3, 4, 5));
            } else if ($status == 2) {
                $where[] = array('name' => 't_status', 'oper' => '=', 'value' => 6);
            }

            $where[] = ['name' => 'to_create_time', 'oper' => '<=', 'value' => strtotime($end)];
            // 去除掉子订单中正在退款的订单
            // zhangzc
            // 2019-12-16
            $where[] = ['name' => 'to_fd_status', 'oper' => '<', 'value' => 1];

            $where[]     = ['name' => 'to_create_time', 'oper' => '>=', 'value' => strtotime($start)];
            $where[]     = ['name' => 't_home_id', 'oper' => 'in', 'value' => $community_ids];
            $trade_order = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
            $order_data  = $trade_order->getOrderTradeExcel($where, 0, 0);
            if (empty($order_data)) {
                $this->errorMsg('当前时间内没有订单');
            } 

            // 牺牲两次读取数据的操作换取 用户的友好提示信息
            $do_export = $this->request->getIntParam('do_export');
            if ($do_export) {
                foreach ($order_data as $k => $v) {
                    $key_ = $v['to_g_id'] . '-' . $v['to_gf_id'];
                    if (key_exists($key_, $data)) {
                        $data[$key_]['num'] = $data[$key_]['num'] + $v['to_num'];
                    } else {
                        $data[$key_] = [
                            'name' => $v['to_gf_name'] ? $v['to_title'] . ' - 「' . $v['to_gf_name'] . '」' : $v['to_title'],
                            'num'  => $v['to_num'],
                        ];
                    }
                }
                $this->routeDeliveryGoodsToExcel($data, $route_info,$start,$end);
            } else {
                $this->displayJsonSuccess();
            }
        } else {
            // 在每个指定的小区中得出要配送的货物的汇总
            if ($community_leader_info) {
                // 添加已完成的删选条件
                // zhangzc
                // 2019-12-20
                if ($status == 3) {
                    $where[] = array('name' => 't_status', 'oper' => 'in', 'value' => array(2, 3, 4, 5, 6));
                } else if ($status == 1) {
                    $where[] = array('name' => 't_status', 'oper' => 'in', 'value' => array(2, 3, 4, 5));
                } else if ($status == 2) {
                    $where[] = array('name' => 't_status', 'oper' => '=', 'value' => 6);
                }
                foreach ($community_leader_info as $key => $value) {
                    // 去除没有数据的小区
                    // zhangzc
                    // 2019-09-21
                    $goods_sum = $this->getCommunityGoodsSum($value['asl_id'], $value['asc_id'], $start, $end, '', $where);
                    if (isset($goods_sum)) {
                        $community_leader_info[$key]['goods_sum'] = $goods_sum;
                    } else {
                        unset($community_leader_info[$key]);
                    }
                }
            }
            // 牺牲两次读取数据的操作换取 用户的友好提示信息
            $do_export = $this->request->getIntParam('do_export');
            if ($do_export) {
                $this->routeDeliveryToExcel($community_leader_info, $route_info,$start,$end);
            } else {
                $this->displayJsonSuccess();
            }
        }
    }
    /**
     * 自定义错误提示（用于批量导出时用）
     * zhangzc
     * 2019-12-24
     * @param  [type] $msg [description]
     * @return [type]      [description]
     */
    private function errorMsg($msg){
        $multi=$this->request->getIntParam('multi');
        if($multi == 1){
            plum_url_location($msg);
        }else{
             $this->displayJsonError($msg);
        }
    }
    /**
     * 获取配送路线的基本信息
     * @param  [type] $model    [description]
     * @param  [type] $route_id [description]
     * @return [type]           [description]
     */
    private function getRouteInfo($model, $route_id)
    {
        if (!$route_id) {
            $this->displayJsonError('当前路线不存在');
        }

        if (!($model instanceof App_Model_Sequence_MysqlSequenceDeliveryrouteStorage)) {
            $this->displayJsonError('数据对象类型错误');
        }

        $route_info = $model->getRow([
            ['name' => 'asdr_id', 'oper' => '=', 'value' => $route_id],
            ['name' => 'asdr_s_id', 'oper' => '=', 'value' => $this->curr_sid],
        ]);
        return $route_info;
    }
    /**
     * 获取路线中所属的社区基本信息与团长基本信息
     * @param  [type] $mdoel    [description]
     * @param  [type] $route_id [description]
     * @return [type]           [description]
     */
    private function getRouteCommunityAndLeaderInfo($model, $route_id)
    {
        if (!$route_id) {
            $this->displayJsonError('当前路线不存在');
        }

        if (!($model instanceof App_Model_Sequence_MysqlSequenceDeliveryroutedetailStorage)) {
            $this->displayJsonError('数据对象类型错误');
        }

        $community_leader = $model->getCommunityAndLeaderInfo($route_id);
        return $community_leader;
    }
    /**
     * 获取小区中商品配送的统计信息
     * @param  [type] $leader_id    [团长id]
     * @param  [type] $community_id [社区id]
     * @param  [type] $start        [开始时间]
     * @param  [type] $end          [结束时间]
     * @param  [type] $goods_name   [商品名称]
     * @return [type]               [description]
     */
    private function getCommunityGoodsSum($leader_id, $community_id, $start, $end, $goods_name = '', $where)
    {
        // 从小区id  获取对应的团长的id
        if (!$leader_id) {
            $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
            $community_info  = $community_model->getRowByIdSid($community_id, $this->curr_sid);
            if (!empty($community_info)) {
                $leader_id = $community_info['asc_leader'];
            } else {
                $this->displayJsonError('小区无团长信息');
            }
        }

        if (strtotime($start) && strtotime($end)) {
            $where[] = ['name' => 'to_create_time', 'oper' => '<=', 'value' => strtotime($end)];
            $where[] = ['name' => 'to_create_time', 'oper' => '>=', 'value' => strtotime($start)];
        }
        if ($community_id) {
            $where[] = ['name' => 't_home_id', 'oper' => '=', 'value' => $community_id];
        }
        //小区id

        // 根据团长id 查询这个团长下面时间维度 以及商品名称 下所有的订单的汇总信息
        $to_model = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
        $total    = $to_model->sumPriceNum($where, $goods_name, true);
        if ($total) {
            foreach ($total as $val) {
                $data[] = array(
                    'gid'    => $val['g_id'],
                    'name'   => $val['g_name'],
                    'cover'  => $val['g_cover'],
                    'num'    => $val['totalNum'],
                    'money'  => $val['totalMoney'],
                    'format' => $val['to_gf_name'],
                );
            }
        }
        return $data;
    }

    /**
     * 导出配送数据到excel表格中去 只导出商品汇总信息
     * @param  [type] $data       [description]
     * @param  [type] $route_info [description]
     * @param  [type] $start      [description]
     * @param  [type] $end        [description]
     * @return [type]             [description]
     */
    private function routeDeliveryGoodsToExcel($data, $route_info,$start,$end)
    {
        require_once PLUM_APP_PLUGIN . '/phpexcel/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        //设置属性
        $objPHPExcel->getProperties()
            ->setCreator("WOLF")
            ->setLastModifiedBy("WOLF")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
        $objActSheet = $objPHPExcel->setActiveSheetIndex(0); //填充表头

        $objActSheet->mergeCells("A1:F1");
        $objActSheet->setCellValue('A1', sprintf('配送员：%s (%s) (%s)', $route_info['asdr_delivery_name'], $route_info['asdr_delivery_mobile'], $route_info['asdr_name']));
        $objActSheet->setCellValue('A2', '商品名称');
        $objActSheet->setCellValue('B2', '数量');

        $objActSheet->getColumnDimension('A')->setAutoSize(true);      
        $objActSheet->getColumnDimension('B')->setAutoSize(true);      
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);#设置单元格宽度
        $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //填充内容
        $step = 3;
        foreach ($data as $key => $row) {
            $objActSheet->setCellValue('A' . $step, $row['name']);
            $objActSheet->setCellValue('B' . $step, $row['num']);
            $step++;
        }

        //4.输出
        $objPHPExcel->getActiveSheet()->setTitle('配送数据');
        $objPHPExcel->setActiveSheetIndex(0);
        $day      = '('.$start.')---('.$end.')';
        $filename = $day .$route_info['asdr_name'].'配送数据.xls';
        ob_end_clean(); //清除缓冲区,避免乱码
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * 导出配送数据到excel表格中去
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    private function routeDeliveryToExcel($data, $route_info,$start,$end)
    {
        require_once PLUM_APP_PLUGIN . '/phpexcel/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

        //设置属性
        $objPHPExcel->getProperties()
            ->setCreator("天点科技")
            ->setLastModifiedBy("天点科技")
            ->setTitle('天点科技')
            ->setSubject('天点科技')
            ->setDescription("天点科技.");
        $objActSheet = $objPHPExcel->setActiveSheetIndex(0); //填充表头

        $objActSheet->mergeCells("A1:F1");
        $objActSheet->setCellValue('A1', sprintf('配送员：%s (%s) (%s)', $route_info['asdr_delivery_name'], $route_info['asdr_delivery_mobile'], $route_info['asdr_name']));
        $objActSheet->setCellValue('A2', '小区名称');
        $objActSheet->setCellValue('B2', '小区地址');
        $objActSheet->setCellValue('C2', '团长名称');
        $objActSheet->setCellValue('D2', '团长电话');
        $objActSheet->setCellValue('E2', '商品名称');
        $objActSheet->setCellValue('F2', '商品数量');
        //填充内容
        $step = 3;
        $i=0;
        foreach ($data as $key => $row) {
            $s_index = $step;
            $objActSheet->setCellValue('A' . ($i + $step), $row['asc_name']);
            $objActSheet->setCellValue('B' . ($i + $step), $row['asc_address']);
            $objActSheet->setCellValue('C' . ($i + $step), $row['asl_name']);
            $objActSheet->setCellValue('D' . ($i + $step), $row['asl_mobile'] . ' ');
            foreach ($row['goods_sum'] as $k => $goods_item) {
                if ($goods_item['format']) {
                    $objActSheet->setCellValue('E' . ($i + $step + $k), $goods_item['name'] . '-「' . $goods_item['format'] . '」');
                } else {
                    $objActSheet->setCellValue('E' . ($i + $step + $k), $goods_item['name']);
                }
                $objActSheet->setCellValue('F' . ($i + $step + $k), $goods_item['num']);
            }

            $step += count($row['goods_sum']) ? (count($row['goods_sum']) - 1) : 0;
            $objPHPExcel->getActiveSheet()->mergeCells("A" . ($i + $s_index) . ":A" . ($i + $step));
            $objPHPExcel->getActiveSheet()->mergeCells("B" . ($i + $s_index) . ":B" . ($i + $step));
            $objPHPExcel->getActiveSheet()->mergeCells("C" . ($i + $s_index) . ":C" . ($i + $step));
            $objPHPExcel->getActiveSheet()->mergeCells("D" . ($i + $s_index) . ":D" . ($i + $step));
            $i++;
        }
        $objActSheet->getColumnDimension('B')->setWidth(40);   
        $objActSheet->getColumnDimension('E')->setWidth(40);      
        $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);

        //4.输出
        $objPHPExcel->getActiveSheet()->setTitle('配送数据');
        $objPHPExcel->setActiveSheetIndex(0);
        $day      = '('.$start.')---('.$end.')';
        $filename = $day .'路线「' . $route_info['asdr_name'] . '」' .'配送数据.xls';
        ob_end_clean(); //清除缓冲区,避免乱码
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * 获取小区名称
     * @return [type] [description]
     */
    public function getCommnunityNotInRouteAction()
    {
        $page  = $this->request->getIntParam('page');
        $index = ($page ? ($page - 1) : 0) * $this->count;

        $district       = $this->request->getIntParam('district');
        $community_name = $this->request->getStrParam('community');

        if ($district) {
            $where[] = ['name' => 'asc_area', 'oper' => '=', 'value' => $district];
        }

        if ($community_name) {
            $where[] = ['name' => 'asc_name', 'oper' => 'like', 'value' => "%{$community_name}%"];
        }

        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
        $list            = $community_model->getCommnunityNotInRoute($where, $index, $this->count, []);

        //ajax分页
        $total       = $community_model->getCommnunityNotInRouteCount($where);
        $total_page  = ceil($total / $this->count);
        $menu_helper = new App_Helper_Menu();
        $menu        = $menu_helper->ajaxPageLink($total_page, $page, $district . '_' . $community_name, 'getCommunityList');
        $data        = array(
            'ec'       => 200,
            'list'     => $list,
            'pageHtml' => $menu,
        );
        $this->displayJson($data);
    }
    /**********************************************************************************/

    /**
     * 根据区县编号获取所属下的街道信息
     * @return [type] [description]
     */
    public function getCommunityCountByAreaAction()
    {
        $district        = $this->request->getIntParam('district');
        $where[]         = ['name' => 'asa_zone', 'oper' => '=', 'value' => $district];
        $community_model = new App_Model_Sequence_MysqlSequenceAreaStorage($this->curr_sid);
        $c_list          = $community_model->getAreaByDistrict($where);
        if ($c_list) {
            $this->displayJsonSuccess($c_list);
        } else {
            $this->displayJsonError('暂无街道数据');
        }
    }
    // 获取区域的列表
    public function getRegionByPIdAction()
    {
        $region_id  = $this->request->getIntParam('region_id');
        $type       = $this->request->getIntParam('type', 0);
        $area_model = new App_Model_Member_MysqlRegionStorage();
        if (!$type) {
            $citys = $area_model->get_city_by_parent($region_id);
        } else {
            $citys = $area_model->get_area_by_parent($region_id);
        }

        if ($citys) {
            $this->displayJson([
                'ec'   => 200,
                'em'   => 'success',
                'data' => $citys,
            ]);
        } else {
            $this->displayJson(['ec' => 400, 'em' => '未获取到城市列表']);
        }

    }

    /******************************* 后台审核供应商自定义添加的商品 **********************************
     *                                zhangzc
     *                                2019-07-10
     ********************************************************************************************/
    /**
     * 供应商商品列表
     * @return [type] [description]
     */
    public function getSupplierGoodsListAction()
    {
        $this->buildBreadcrumbs(array(
            array('title' => '供应商品管理', 'link' => '#'),
            array('title' => '商品列表', 'link' => '#'),
        ));

        $start    = $this->request->getStrParam('start');
        $end      = $this->request->getStrParam('end');
        $status   = $this->request->getIntParam('status', -1);
        $supplier = $this->request->getIntParam('supplier');

        if (strtotime($start) && strtotime($end)) {
            $where[] = ['name' => 'assg_create_time', 'oper' => '>=', 'value' => strtotime($start)];
            $where[] = ['name' => 'assg_create_time', 'oper' => '<=', 'value' => strtotime($end)];
        }
        if ($status > -1) {
            $where[] = ['name' => 'assg_status', 'oper' => '=', 'value' => $status];
        }

        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;

        $supplier_goods_model = new App_Model_Supplier_MysqlSupplierGoodsStorage($this->sid, 0);
        $where[]              = ['name' => 'assg_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        if ($supplier) {
            $where[] = ['name' => 'assg_supplier', 'oper' => '=', 'value' => $supplier];
        }

        $total                     = $supplier_goods_model->getCount($where);
        $pageCfg                   = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $this->output['paginator'] = $pageCfg->render();

        $sort                       = ['assg_status' => 'ASC', 'assg_create_time' => 'DESC'];
        $goods_list                 = $supplier_goods_model->getListWithSupplier($where, $index, $this->count, $sort);
        $this->output['goods_list'] = $goods_list;

        // 获取供应商列表
        $this->output['supplier_list'] = $this->getSupplierList();
        $this->displaySmarty('wxapp/sequence/supplier-goods-list.tpl');
    }

    /**
     * 获取平台供应商的信息列表
     * @return [type] [description]
     */
    private function getSupplierList()
    {
        $community_model = new App_Model_Sequence_MysqlSequenceSupplierInfoStorage($this->curr_sid);
        $where[]         = array('name' => 'assi_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort            = array('assi_create_time' => 'DESC');
        $list            = $community_model->getList($where, $index, $this->count, $sort, ['assi_name', 'assi_id']);
        return $list;
    }

    /**
     * 处理供应商的商品信息 + 审核成功将商品信息同步到平台的商品库中去
     * @return [type] [description]
     */
    public function dealSupplierGoodsAction()
    {
        $g_id     = $this->request->getIntParam('g_id');
        $g_status = $this->request->getStrParam('g_status');
        $remark   = $this->request->getStrParam('g_remark');
        if ($g_status == 'success') {
            $status = 1;
        } else if ($g_status == 'refuse') {
            $status = 2;
        } else {
            $this->displayJsonError('状态不正确');
        }

        $supplier_goods_model = new App_Model_Supplier_MysqlSupplierGoodsStorage($this->sid, 0);
        $where[]              = ['name' => 'assg_id', 'oper' => '=', 'value' => $g_id];
        $where[]              = ['name' => 'assg_s_id', 'oper' => '=', 'value' => $this->curr_sid];

        // 审核通过 更新数据并将 商品数据同步到平台
        $set = [
            'assg_check_time' => time(),
            'assg_status'     => $status,
            'assg_remark'     => $remark,
        ];
        $goods_info = $supplier_goods_model->getRow($where);
        if ($goods_info['assg_status']) {
            $this->displayJsonError('当前商品已审核。请勿重复操作！');
        }

        if ($status == 2) {
            // 更新供应商商品表中对应的数据信息
            $update_exec = $supplier_goods_model->updateValue($set, $where);
        } elseif ($status == 1) {
            // 审核状态时通过的话就需要同步更新到平台的商品库中去

            /**************************商品基本信息的写入******************************/

            // 平台商品
            $goods_model       = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
            $insert_goods_data = [
                'g_s_id'              => $this->curr_sid,
                'g_name'              => $goods_info['assg_g_name'],
                'g_cover'             => $goods_info['assg_g_cover'],
                'g_brief'             => $goods_info['assg_g_brief'],
                'g_cost'              => $goods_info['assg_g_cost'],
                'g_format_type'       => $goods_info['assg_g_format_type'],
                'g_has_format'        => $goods_info['assg_g_has_format'],
                'g_video_url'         => $goods_info['assg_g_video_url'],
                'g_detail'            => $goods_info['assg_g_detail'],
                'g_supplier_id'       => $goods_info['assg_supplier'],
                'g_create_time'       => time(),
                'g_join_discount'     => 0,
                'g_applay_goods_show' => 1, //修改供应商审核通过的商品默认在小程序列表里面显示
                'g_is_sale'           => 11, //特殊标记 供应商审核通过自动转入的商品默认是这个状态
                'g_supplier_export'   => $goods_info['assg_id'], //特殊标记 用来区分是不是供应商审核通过自动转过来的商品
            ];
            $insert_goods_id = $goods_model->insertValue($insert_goods_data);
            // 审核状态为通过的时候 数据写入的顺序做一下改变（先插入后更新状态）
            $set['assg_plate_g_id'] = $insert_goods_id;
            $update_exec            = $supplier_goods_model->updateValue($set, $where);

            /**************************商品幻灯片信息的写入******************************/
            $supplier_slide_model = new App_Model_Supplier_MysqlSupplierGoodsSlideStorage($this->curr_sid, 0);
            $slide_list           = $supplier_slide_model->getListByGidSid($g_id, $this->curr_sid);
            foreach ($slide_list as $key => $slide) {
                $insert_goods_slide[] = "(NULL, '{$this->curr_sid}', '{$insert_goods_id}', '{$slide['assgs_path']}', '{$slide['assgs_sort']}', 0, '{$slide['assgs_create_time']}')";
            }
            $slide_model = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
            $slide_exec  = $slide_model->batchNewSave($insert_goods_slide);
            /**************************商品规格信息的写入******************************/
            $supplier_format_model = new App_Model_Supplier_MysqlSupplierFormatStorage($this->curr_sid, 0);
            $format_list           = $supplier_format_model->getListByGid($g_id);
            foreach ($format_list as $key => $format) {
                $name1          = $format['gf_name'];
                $name2          = $format['gf_name2'];
                $name3          = $format['gf_name3'];
                $img            = $format['gf_img'];
                $weight         = $format['gf_format_weight'];
                $weightType     = $format['gf_format_weight_type'];
                $oriPrice       = $format['gf_ori_price'];
                $newmemberPrice = $format['gf_newmember_price'];
                $sort           = $format['gf_sort'];
                $price          = $format['gf_price'];
                $cost           = $format['gf_cost'];
                $create_time    = $format['gf_create_time'];

                $insert_goods_format[] = "(NULL, '{$this->curr_sid}', '{$insert_goods_id}', '{$name1}','{$name2}','{$name3}','{$img}','{$oriPrice}','{$price}','0','{$weight}','{$weightType}','{$sort}', 0, '{$create_time}','{$cost}','{$newmemberPrice}')";
            }
            $format_model = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
            $format_model->newBatchSave($insert_goods_format);
        }
        if (!$update_exec) {
            $this->displayJsonError('审核失败，请稍后再试');
        }
        $str = $status == 1 ? '通过' : '不通过';
        App_Helper_OperateLog::saveOperateLog("处理供应商商品【{$goods_info['assg_g_name']}】成功，处理结果：{$str}");
        $this->displayJsonSuccess($insert_goods_id, true, '审核成功');
    }
    /**********************************************************************************/

    /*
     * 分享海报配置
     */
    public function shareposterCfgAction()
    {
        $cfg_model   = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $cfg         = $cfg_model->findUpdateBySid();
        if (!$cfg_model) {
            $cfg = [
                'asc_shareposter_open'  => 0,
                'asc_shareposter_bg'    => '/public/wxapp/sequence/images/bg1.png',
                'asc_shareposter_num'   => 2,
                'asc_shareposter_add'   => 1,
                'asc_shareposter_goods' => [],
            ];
        }
        $this->output['cfg'] = $cfg;
        $goods_list          = [];
        $gids                = is_array($cfg['asc_shareposter_goods']) ? $cfg['asc_shareposter_goods'] : json_decode($cfg['asc_shareposter_goods'], 1);
        if (!empty($gids)) {
            $where   = [];
            $where[] = ['name' => 'g_s_id', 'oper' => '=', 'value' => $this->curr_sid];
            $where[] = ['name' => 'g_id', 'oper' => 'in', 'value' => $gids];
            $list    = $goods_model->getList($where, 0, $cfg['asc_shareposter_num'], [], ['g_id', 'g_name', 'g_cover']);
            if ($list) {
                foreach ($list as $val) {
                    $index              = array_search($val['g_id'], $gids);
                    $goods_list[$index] = $val;
                }
                ksort($goods_list);
            }
        }
        $this->output['shareposter_bg'] = plum_parse_config('shareposter_bg');
        $this->output['goods_list']     = $goods_list;

        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '#'),
            array('title' => '商品海报', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/sequence/shareposter-cfg.tpl');

    }

    /*
     * 保存分享海报配置
     */
    public function saveShareposterCfgAction()
    {
        $num   = $this->request->getIntParam('num');
        $open  = $this->request->getIntParam('open');
        $add   = $this->request->getIntParam('add');
        $goods = $this->request->getArrParam('goods');
        $bg    = $this->request->getStrParam('bg');
        $gids  = [];
        if ($add == 1 && is_array($goods) && count($goods) != $num) {
            $this->displayJsonError('请添加正确数量的商品..');
        }
        if (is_array($goods)) {
            foreach ($goods as $val) {
                $gids[] = $val['gid'];
            }
        }

        $set = [
            'asc_shareposter_add'   => $add,
            'asc_shareposter_num'   => $num,
            'asc_shareposter_open'  => $open,
            'asc_shareposter_bg'    => $bg,
            'asc_shareposter_goods' => json_encode($gids),
            'asc_update_time'       => time(),
        ];

        $cfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
        $cfg       = $cfg_model->findUpdateBySid();

        if ($cfg) {
            $res = $cfg_model->findUpdateBySid($set);
        } else {
            $set['asc_s_id']        = $this->curr_sid;
            $set['asc_create_time'] = time();
            $res                    = $cfg_model->insertValue($set);
        }

        if ($res) {
            App_Helper_OperateLog::saveOperateLog("分享海报设置保存成功");
        }

        $this->showAjaxResult($res, '保存');
    }

    /**
     * 帖子管理
     */
    public function postListAction()
    {
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = array();
        $mid   = $this->request->getIntParam('mid');
        if ($mid) {
            $where[] = array('name' => 'asp_m_id', 'oper' => '=', 'value' => $mid);
        }
        $this->output['nickname'] = $this->request->getStrParam('nickname');
        if ($this->output['nickname']) {
            $where[] = array('name' => 'asp_member_nickname', 'oper' => 'like', 'value' => "%{$this->output['nickname']}%");
        }
        $this->output['content'] = $this->request->getStrParam('content');
        if ($this->output['content']) {
            $where[] = array('name' => 'asp_content', 'oper' => 'like', 'value' => "%{$this->output['content']}%");
        }
        $this->output['start'] = $this->request->getStrParam('start');
        if ($this->output['start']) {
            $where[] = array('name' => 'asp_create_time', 'oper' => '>=', 'value' => strtotime($this->output['start']));
        }
        $this->output['end'] = $this->request->getStrParam('end');
        if ($this->output['end']) {
            $where[] = array('name' => 'asp_create_time', 'oper' => '<=', 'value' => (strtotime($this->output['end']) + 86400));
        }
        $this->output['search_community'] = $this->request->getIntParam('search_community');
        if ($this->output['search_community']) {
            $where[] = array('name' => 'asp_com_id', 'oper' => '=', 'value' => $this->output['search_community']);
        }
        $this->output['search_leader'] = $this->request->getIntParam('search_leader');
        if ($this->output['search_leader']) {
            $where[] = array('name' => 'asp_leader_id', 'oper' => '=', 'value' => $this->output['search_leader']);
        }

        $this->output['post_type'] = $this->request->getIntParam('post_type');
        if ($this->output['post_type']) {
            $where[] = array('name' => 'asp_type', 'oper' => '=', 'value' => $this->output['post_type']);
        }

        //筛选信息
        $this->output['screen'] = $this->request->getStrParam('screen');
        if ($this->output['screen']) {
            switch ($this->output['screen']) {
                case 'status0':
                    $where[] = array('name' => 'asp_status', 'oper' => '=', 'value' => 0);
                    break;
                case 'status1':
                    $where[] = array('name' => 'asp_status', 'oper' => '=', 'value' => 1);
                    break;
                case 'top0':
                    $timeNow = time();
                    $where[] = " ( asp_is_top = 0 or asp_top_expire < {$timeNow} )";
                    break;
                case 'top1':
                    $where[] = array('name' => 'asp_is_top', 'oper' => '=', 'value' => 1);
                    $where[] = array('name' => 'asp_top_expire', 'oper' => '>', 'value' => time());
                    break;
                case 'push0':
                    $where[] = array('name' => 'asp_push', 'oper' => '=', 'value' => 0);
                    break;
                case 'push1':
                    $where[] = array('name' => 'asp_push', 'oper' => '=', 'value' => 1);
                    break;
            }
        }
        $sortField            = $this->request->getIntParam('sortField', 1);
        $this->output['sort'] = $sortField;

        $where[]                    = array('name' => 'asp_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]                    = array('name' => 'asp_deleted', 'oper' => '=', 'value' => 0);
        $post_storage               = new App_Model_Sequence_MysqlSequencePostStorage($this->curr_sid);
        $total                      = $post_storage->getCount($where);
        $pageCfg                    = new Libs_Pagination_Paginator($total, $this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list                       = array();
        if ($index < $total) {

            if ($sortField == 1) {
                //发布时间排序
                $sort = array('asp_create_time' => 'DESC');
            } elseif ($sortField == 2) {
                //最新评论时间
                $sort = array('asp_last_comment' => 'DESC');
            } elseif ($sortField == 3) {
                //点赞数量
                $sort = array('asp_like_num' => 'DESC');
            } elseif ($sortField == 4) {
                //回复数量
                $sort = array('asp_comment_num' => 'DESC');
            } else {
                $sort = array('asp_create_time' => 'DESC');
            }

            $list = $post_storage->getList($where, $index, $this->count, $sort);

        }
        foreach ($list as $key => $val) {
            $list[$key]['asp_content'] = $this->utf8_str_to_unicode($val['asp_content']);
        }
        $this->output['list'] = $list;

        $this->output['sortArr'] = array(
            1 => '发布时间',
            2 => '最新评论时间',
            3 => '点赞数量',
            4 => '回复数量',
        );
        $this->_get_all_community();
        $this->_get_all_leader();

        $this->buildBreadcrumbs(array(
            array('title' => '帖子管理', 'link' => '#'),
            array('title' => '帖子列表', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/sequence/post-list-new.tpl');

    }

    /**
     * 帖子封禁
     */
    public function postStatusChangeAction()
    {
        $pid    = $this->request->getIntParam('pid');
        $status = $this->request->getIntParam('status');
        $ret    = 0;
        if ($pid) {
            $post_storage = new App_Model_Sequence_MysqlSequencePostStorage($this->curr_sid);
            $post         = $post_storage->getRowById($pid);
            if ($post) {
                $set = array('asp_status' => $status);
                $ret = $post_storage->updateById($set, $pid);

            }
        }

        if ($ret) {
            $str = $status == 1 ? '封禁' : '解封';
            App_Helper_OperateLog::saveOperateLog("帖子{$str}成功");
        }

        $this->showAjaxResult($ret);
    }

    /**
     * 删除帖子
     */
    public function deletePostAction()
    {
        $id = $this->request->getIntParam('id');
        if ($id) {
            $article_model = new App_Model_Sequence_MysqlSequencePostStorage($this->curr_sid);
            $ret           = $article_model->deleteDFById($id, $this->curr_sid);

            if ($ret) {
                App_Helper_OperateLog::saveOperateLog("帖子删除成功");
            }
        }
        $this->showAjaxResult($ret, '删除');
    }

    /*
     * 获得当前店铺所有小区
     */
    private function _get_all_community()
    {
        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
        $where           = [];
        $where[]         = ['name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $list            = $community_model->getList($where, 0, 0, [], ['asc_id', 'asc_name']);
        $data            = [];
        if ($list) {
            foreach ($list as $val) {
                $data[$val['asc_id']] = [
                    'id'   => $val['asc_id'],
                    'name' => $val['asc_name'],
                ];
            }
        }
        $this->output['communitySelectKey'] = $data;
    }

    /*
     * 获得当前店铺所有团长
     */
    private function _get_all_leader()
    {
        $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($this->curr_sid);
        $where        = [];
        $where[]      = ['name' => 'asl_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where[]      = ['name' => 'asl_status', 'oper' => '=', 'value' => 2];
        $list         = $leader_model->getList($where, 0, 0, [], ['asl_id', 'asl_name']);
        $data         = [];
        if ($list) {
            foreach ($list as $val) {
                $data[$val['asl_id']] = [
                    'id'   => $val['asl_id'],
                    'name' => $val['asl_name'],
                ];
            }
        }
        $this->output['leaderSelectKey'] = $data;
    }

    /**
     * 发帖置顶功能
     */
    public function updateCostTimeAction()
    {
        $res  = array('ec' => '400', 'em' => '置顶失败');
        $pid  = $this->request->getIntParam('id'); //帖子id
        $cost = $this->request->getIntParam('cost'); //置顶费用id
        if ($pid && $cost) {
            $topDate                = intval($cost);
            $dateTime               = $topDate * 60 * 60 * 24;
            $expiration             = intval(time() + $dateTime);
            $data['asp_is_top']     = 3; //后台置顶
            $data['asp_top_expire'] = $expiration;
            $post_model             = new App_Model_Sequence_MysqlSequencePostStorage($this->curr_sid);
            $ret                    = $post_model->updateById($data, $pid);
            if ($ret) {
                $applet_redis = new App_Model_Applet_RedisAppletStorage($this->curr_sid);
                //删除原置顶过期时间
                $applet_redis->deleteSequenceTopPostTask($pid);
                //记录置顶时间
                $applet_redis->recordSequenceTopPostTask($pid, $dateTime);
                $res = array('ec' => '200', 'em' => '置顶成功');
                App_Helper_OperateLog::saveOperateLog("帖子置顶成功");
            }
        } else {
            $this->displayJsonError('置顶失败');
        }
        $this->displayJson($res);
    }

    /**
     * 帖子详情
     */
    public function postDetailsAction()
    {
        $id                   = $this->request->getIntParam('id');
        $post_storage         = new App_Model_Sequence_MysqlSequencePostStorage($this->curr_sid);
        $post                 = $post_storage->getRowById($id);
        $post['asp_content']  = $this->utf8_str_to_unicode($post['asp_content']);
        $this->output['post'] = $post;
        $this->_fetch_post_img($post);
        $this->_comment_list($id);
        $this->buildBreadcrumbs(array(
            array('title' => '帖子管理', 'link' => '#'),
            array('title' => '帖子列表', 'link' => '/wxapp/sequence/postList'),
            array('title' => '帖子详情', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sequence/post-details.tpl');
    }

    /**
     * 获取帖子图片
     */
    private function _fetch_post_img($post)
    {
        $imgList                 = json_decode($post['asp_images'], 1);
        $this->output['imgList'] = $imgList;
    }

    private function _comment_list($pid)
    {
        $count                      = 30; // 帖子评论一次加载30条
        $page                       = $this->request->getIntParam('page');
        $index                      = $page * $count;
        $where[]                    = array('name' => 'aspc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]                    = array('name' => 'aspc_asp_id', 'oper' => '=', 'value' => $pid);
        $comment_model              = new App_Model_Sequence_MysqlSequencePostCommentStorage($this->curr_sid);
        $total                      = $comment_model->getCount($where);
        $pageCfg                    = new Libs_Pagination_Paginator($total, $count);
        $this->output['pagination'] = $pageCfg->render();
        $list                       = $comment_model->getCommentMember($pid, $index, $count);
        foreach ($list as $key => $val) {
            $list[$key]['aspc_content'] = $this->utf8_str_to_unicode($val['aspc_content']);
        }
        $this->output['commentList'] = $list;

    }

    /**
     * 删除帖子评论
     */
    public function deletePostCommentAction()
    {
        $id = $this->request->getIntParam('id');
        if ($id) {
            $comment_model = new App_Model_Sequence_MysqlSequencePostCommentStorage($this->curr_sid);
            $ret           = $comment_model->deleteBySidId($id, $this->curr_sid);
            if ($ret) {
                App_Helper_OperateLog::saveOperateLog("帖子评论删除成功");
            }
        }
        $this->showAjaxResult($ret, '删除');
    }

    /*
     * 分享海报配置
     */
    public function postCfgAction()
    {
        $cfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
        $cfg       = $cfg_model->findUpdateBySid();
        if (!$cfg_model) {
            $cfg = [
                'asc_member_post_day_num' => 0,
                'asc_leader_post_day_num' => 0,
                'asc_leader_top_day'      => 7,
                'asc_leader_post_scope'   => 0,
            ];
        }
        $this->output['cfg'] = $cfg;

        $this->buildBreadcrumbs(array(
            array('title' => '帖子管理', 'link' => '#'),
            array('title' => '发帖设置', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/sequence/post-cfg.tpl');

    }

    /*
     * 保存分享海报配置
     */
    public function savePostCfgAction()
    {
        $scope          = $this->request->getIntParam('scope');
        $member_num     = $this->request->getIntParam('member_num');
        $leader_num     = $this->request->getIntParam('leader_num');
        $leader_top_day = $this->request->getIntParam('leader_top_day');

        $set = [
            'asc_member_post_day_num' => $member_num,
            'asc_leader_post_day_num' => $leader_num,
            'asc_leader_top_day'      => $leader_top_day,
            'asc_leader_post_scope'   => $scope,
            'asc_update_time'         => time(),
        ];

        $cfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
        $cfg       = $cfg_model->findUpdateBySid();

        if ($cfg) {
            $res = $cfg_model->findUpdateBySid($set);
        } else {
            $set['asc_s_id']        = $this->curr_sid;
            $set['asc_create_time'] = time();
            $res                    = $cfg_model->insertValue($set);

        }

        if ($res) {
            App_Helper_OperateLog::saveOperateLog("发帖配置保存成功");
        }

        $this->showAjaxResult($res, '保存');
    }



    /**
     * 社区团购单品退款重构
     * zhangzc
     * 2019-12-21
     * @return [type] [description]
     */
    public function tradeOrderRefundAction()
    {
        $toid = $this->request->getIntParam('toid');
        //一单多个商品情况
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $trade_info  = $trade_model->findTradeByTidToid(null, $toid);

        try {
            // 订单退款状态判断
            if (empty($trade_info)) {
                throw new Exception('子订单不存在');
            }
            // 是否是退款订单
            // 0：无退款
            // 2：申请退款
            // 3：拒绝后再申请
            // 4：拒绝退款
            // 7：主动退款|同意退款
            // 8：买家撤销|自动撤销
            // zhangzc
            // 2019-09-26
            $refund_status = intval($trade_info['to_feedback']) + intval($trade_info['to_fd_status']) + intval($trade_info['to_fd_result']);
            if ($refund_status == 7) {
                throw new Exception('该商品已退款，请勿重复操作');
            }

            // 查询并插入退款记录
            $refund_model = new App_Model_Trade_MysqlTradeRefundStorage($this->curr_sid);
            // 判断退款记录是否存在如果存在的话就不要再插入重复的记录导致重复退款的产生
            $refund_where = [
                ['name' => 'tr_s_id', 'oper' => '=', 'value' => $this->curr_sid],
                ['name' => 'tr_tid', 'oper' => '=', 'value' => $trade_info['t_tid']],
            ];
            $refund_exist = $refund_model->getList($refund_where);
            // 是否要插入新纪录标记
            $insert_new_record=true;
            foreach ($refund_exist as $key => $val) {
                if(empty($val['tr_to_id']) && $val['tr_fd_result'] == 2){
                    throw new Exception("该订单已进行过整单退款的处理，请勿在执行单品退款操作！");
                }
                if(empty($val['tr_to_id']) && $val['tr_status'] == 0){
                    throw new Exception("该订单存在正在进行中的整单退款，请优先进行处理！");
                }
                if($val['tr_to_id'] == $toid && $val['tr_fd_result'] == 2){
                    throw new Exception('当前子订单已进行过退款处理，请勿重复操作');
                }
                if($val['tr_source'] == 1 && $val['tr_to_id'] == $toid && $val['tr_status'] == 0){
                    $insert_new_record = false;
                }
            }


            // 计算要退款的金额
            if ($trade_info['to_fee']) {
                $refund_fee = floatval($trade_info['to_fee'] / 100);
            } else {
                $refund_fee = sprintf('%.2f', ($trade_info['to_total'] / $trade_info['t_goods_fee']) * ($trade_info['t_payment']));
            }

            // 插入退款维权记录
            if($insert_new_record){
                $indata = array(
                    'tr_s_id'        => $this->curr_sid,
                    'tr_wid'         => App_Plugin_Weixin_PayPlugin::makeMchOrderid('W'),
                    'tr_tid'         => $trade_info['t_tid'],
                    'tr_to_id'       => $toid,
                    'tr_reason'      => '系统主动退款', //退款原因
                    'tr_create_time' => time(),
                    'tr_status'      => 0, //退款待处理
                    'tr_money'       => $refund_fee,
                    'tr_source'      => 1,
                );
                $refund_exec = $refund_model->insertValue($indata);
                if (!refund_exec) {
                    throw new Exception("主动退款失败（写入退款记录失败）");
                }
            }
            $trade_info['to_feedback']  = 1;
            $trade_info['to_fd_status'] = 1;

            // 开启了会计审核，退款订单是不能立即退款的
            $account_close = $this->_check_agent_close('account');
            // 财务审核相关记录
            if ($this->curr_shop['s_accountant_refund'] == 1 && $account_close == 0) {
                $account_helper = new App_Helper_Accountant($this->curr_sid, $trade_model);
                $result         = $account_helper->insertIntoAccountant($trade_info, $toid, '系统主动退款', $this->manager);
            } else {
                $refund_helper = new App_Helper_OrderRefund($this->curr_sid, $this->wxapp_cfg, $trade_model);
                $result        = $refund_helper->appletRefund($trade_info, 2, '系统主动退款', $toid, $this->manager, 2);
            }
        } catch (Exception $e) {
            $result = array(
                'ec' => 400,
                'em' => $e->getMessage(),
            );
            $this->displayJson($result);
            return;
        }
        App_Helper_OperateLog::saveOperateLog(sprintf("退款订单【%s】【%s】", $trade_info['t_tid'], $toid));
        $this->displayJson($result);
    }

    /**
     * 服务器出现故障时 团长信息没有回写到订单 执行手动操作
     * zhangzc
     * 2019-08-21
     * @return [type] [description]
     */
    public function syncLeaderInfoAction()
    {
        $tid         = $this->request->getIntParam('tid', 0);
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $trade_info  = $trade_model->getRowById($tid);
        if (!$trade_info) {
            $this->displayJsonError('订单数据不存在');
        }

        $extraData = json_decode($trade_info['t_extra_data'], true);
        $groupId   = intval($extraData['groupId']);
        $leaderId  = intval($extraData['leaderId']);
        $managerId = intval($extraData['managerId']);

        //将群组和订单信息更新至订单
        $updata = array(
            't_se_group'   => $groupId,
            't_se_leader'  => $leaderId,
            't_se_manager' => $managerId,
        );
        $trade_exec = $trade_model->updateById($updata, $trade_info['t_id']);

        $updata_order = array(
            'to_se_group'   => $groupId,
            'to_se_leader'  => $leaderId,
            'to_se_manager' => $managerId,
        );
        $to_model      = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
        $where_order[] = array('name' => 'to_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where_order[] = array('name' => 'to_t_id', 'oper' => '=', 'value' => $trade_info['t_id']);
        $order_exec    = $to_model->updateValue($updata_order, $where_order);
        if ($trade_exec && $order_exec) {
            $this->displayJsonSuccess(null, true, '同步成功');
        } else {
            $this->displayJsonError('同步失败');
        }
    }

    /*
     * 修改配送路线小区排序
     */
    public function changeRouteCommunitySortAction()
    {
        $id           = $this->request->getIntParam('id');
        $sort         = $this->request->getIntParam('sort');
        $detail_model = new App_Model_Sequence_MysqlSequenceDeliveryroutedetailStorage($this->curr_sid);
        $res          = $detail_model->updateById(['asdrt_sort' => $sort], $id);
        $this->showAjaxResult($res, '保存');
    }

    /*
     * 修改配送路线排序
     */
    public function changeRouteSortAction()
    {
        $id           = $this->request->getIntParam('id');
        $sort         = $this->request->getIntParam('sort');
        $detail_model = new App_Model_Sequence_MysqlSequenceDeliveryrouteStorage($this->curr_sid);
        $res          = $detail_model->updateById(['asdr_sort' => $sort], $id);
        $this->showAjaxResult($res, '保存');
    }

    /*
     * 新增/编辑菜单
     */
    public function editMenuAction()
    {
        $id          = $this->request->getIntParam('id');
        $menu_model  = new App_Model_Sequence_MysqlSequenceMenuStorage($this->curr_sid);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);

        $goods_list = [];
        $gids       = [];
        $row        = [];
        $slide      = [];
        if ($id) {
            $row = $menu_model->getRowById($id);
            if ($row) {
                $gids = is_array($row['asm_goods']) ? $row['asm_goods'] : json_decode($row['asm_goods'], 1);
                if (!empty($gids)) {
                    $count   = count($gids);
                    $where   = [];
                    $where[] = ['name' => 'g_s_id', 'oper' => '=', 'value' => $this->curr_sid];
                    $where[] = ['name' => 'g_id', 'oper' => 'in', 'value' => $gids];

                    $list = $goods_model->getList($where, 0, $count, [], ['g_id', 'g_name', 'g_cover']);
                    if ($list) {
                        foreach ($list as $val) {
                            $index              = array_search($val['g_id'], $gids);
                            $goods_list[$index] = $val;
                        }
                        ksort($goods_list);
                    }
                }
                $slide = $row['asm_slide'] ? json_decode($row['asm_slide'], 1) : [];
            }
        }
        $row['asm_type'] = in_array($row['asm_type'], [1, 2]) ? $row['asm_type'] : 1;

        //获得分类数组
        $menuCate                   = $this->_get_menu_category(true);
        $this->output['menuCate']   = $menuCate;
        $this->output['row']        = $row;
        $this->output['goods_list'] = $goods_list;
        $this->output['slide']      = $slide;

        $this->buildBreadcrumbs(array(
            array('title' => '美食区管理', 'link' => '#'),
            array('title' => '菜单列表', 'link' => '/wxapp/sequence/menuList'),
            array('title' => '新增/编辑菜单', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/sequence/add-menu.tpl');

    }

    //获得菜单分类
    /*
     * 获得二级分类
     */
    private function _get_menu_category($return = false)
    {
        $where          = array();
        $where[]        = array('name' => 'asmc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]        = array('name' => 'asmc_deleted', 'oper' => '=', 'value' => 0); //未删除
        $sort           = array('asmc_sort' => 'ASC', 'asmc_id' => 'ASC');
        $shortcut_model = new App_Model_Sequence_MysqlSequenceMenuCategoryStorage($this->curr_sid);
        $list           = $shortcut_model->getList($where, 0, 0, $sort);
        $data           = array();
        if ($list) {
            foreach ($list as $key => $val) {
                $data[$val['asmc_id']] = array(
                    'index' => $key,
                    'id'    => $val['asmc_id'],
                    'title' => $val['asmc_title'],
                    'sort'  => $val['asmc_sort'],
                );
            }
        }
        if ($return) {
            return $data;
        } else {
            $data                     = array_values($data);
            $this->output['menuCate'] = json_encode($data);
        }

    }

    private function _save_menu_category()
    {
        $shortcut       = $this->request->getArrParam('secondCate');
        $shortcut_model = new App_Model_Sequence_MysqlSequenceMenuCategoryStorage($this->curr_sid);
        if (!empty($shortcut)) {
            $where[]       = array('name' => 'asmc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[]       = array('name' => 'asmc_deleted', 'oper' => '=', 'value' => 0); //未删除
            $shortcut_list = $shortcut_model->getList($where, 0, 0);
            if (!empty($shortcut_list)) {
                $del_id = array();
                foreach ($shortcut_list as $val) {
                    $has   = false;
                    $index = 0;
                    foreach ($shortcut as $key => $v) {
                        if ($v['id'] == $val['asmc_id']) {
                            $sort  = $v['sort'];
                            $index = $key;
                            $has   = true;
                        }
                    }
                    if ($has) {
                        //存在这个位置的快捷导航，更新
                        $set = array(
                            'asmc_sort'        => $sort,
                            'asmc_title'       => $shortcut[$index]['title'],
                            'asmc_update_time' => time(),
                        );

                        $up_ret = $shortcut_model->updateById($set, $val['asmc_id']);
                        unset($shortcut[$index]); //然后清理前端传过来的快捷导航
                    } else {
                        //多余的删除
                        $del_id[] = $val['asmc_id'];
                    }
                }
                if (!empty($del_id)) {
                    $shortcut_where   = array();
                    $shortcut_where[] = array('name' => 'asmc_id', 'oper' => 'in', 'value' => $del_id);
                    $shortcut_where[] = array('name' => 'asmc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
                    $shortcut_model->deleteDFByWhere($shortcut_where);
                }

            }

            //新增的快捷导航
            if (!empty($shortcut)) {
                $insert = array();
                foreach ($shortcut as $val) {
                    $insert[] = " (NULL, '{$this->curr_sid}', '{$val['title']}', '{$val['sort']}', '0', '" . time() . "', '" . time() . "') ";
                }
                $ins_ret = $shortcut_model->insertBatch($insert);
            }
        } else {
            //若数组为空，则清空该店铺快捷导航
            $where   = array();
            $where[] = array('name' => 'asmc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $shortcut_model->deleteDFByWhere($where);
        }
    }

    private function _get_menu_slide()
    {
        $slide_model = new App_Model_Sequence_MysqlSequenceMenuSlideStorage($this->curr_sid);
        $where       = [];
        $where[]     = ['name' => 'asms_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $slide       = $slide_model->getList($where, 0, 0, ['asms_weight' => 'ASC']);
        $json        = array();
        foreach ($slide as $key => $val) {
            $json[] = array(
                'index'  => $key,
                'imgsrc' => $val['asms_path'],
                'link'   => $val['asms_link'],
                'weight' => $val['asms_weight'],
                'type'   => $val['asms_link_type'],
            );
        }
        $this->output['slide'] = json_encode($json);
    }

    /**
     * 秒杀商品列表
     */
    private function _limit_list_for_select()
    {
        $limit_model = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        $list        = $limit_model->getAllRunningNotBeginActGoods(array(), 0, 0);
        $data        = array();
        foreach ($list as $val) {
            $data[] = array(
                'id'   => $val['g_id'],
                'name' => $val['g_name'],
            );
        }
        $this->output['limitList'] = json_encode($data);
    }

    /**
     * 获取秒杀商品分组数据
     */
    private function _limit_group()
    {
        $where       = array();
        $where[]     = array('name' => 'alg_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $group_model = new App_Model_Limit_MysqlLimitGroupStorage($this->curr_sid);
        $sort        = array('alg_create_time' => 'DESC');
        $list        = $group_model->getList($where, 0, 0, $sort);
        $data        = array();
        if ($list) {
            foreach ($list as $val) {
                $data[] = array(
                    'id'   => $val['alg_id'],
                    'name' => $val['alg_name'],
                );
            }
        }
        $this->output['limitGoodsGroup'] = json_encode($data);
    }

    /*
     * 菜单首页配置
     */
    public function menuIndexAction()
    {
        //获得菜单分类
        $this->_get_menu_category();
        //获得轮播图
        $this->_get_menu_slide();
        // 选择活动文章
        $this->_shop_information();
        // 获取链接类型及列表
        $this->_get_list_for_select();
        //自营商品一级分类
        $this->_curr_first_kind_list_for_select();
        //自营商品二级分类
        $this->_curr_second_kind_list_for_select();
        //资讯分类
        $this->_get_information_category();
        $this->goodsGroup(); // 获取商品分组
        //获得商品列表
        $this->_shop_goods_list();
        //秒杀商品列表
        $this->_limit_list_for_select();
        //秒杀商品分组
        $this->_limit_group();
        //获得美食菜单列表
        $this->_get_menu_list();

        $cfg_model           = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
        $cfg                 = $cfg_model->findUpdateBySid();
        $this->output['tpl'] = $cfg;

        $this->buildBreadcrumbs(array(
            array('title' => '美食区管理', 'link' => '#'),
            array('title' => '首页管理', 'link' => ''),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/sequence/menu-index.tpl');
    }

    /*
     * 保存菜单首页
     */
    public function saveMenuIndexAction()
    {
        $res_cfg   = $this->_save_index_menu_cfg();
        $res_slide = $this->_save_menu_index_slide();
        $res_cate  = $this->_save_menu_category();
        if ($res_cfg || $res_slide || $res_cate) {

            App_Helper_OperateLog::saveOperateLog("菜单首页信息保存成功");

            $this->showAjaxResult(1);
        } else {
            $this->showAjaxResult(0);
        }

    }

    private function _save_index_menu_cfg()
    {
        $title = $this->request->getStrParam('title');
        $data  = [
            'asc_menu_title'  => $title,
            'asc_update_time' => time(),
        ];
        $cfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
        $cfg       = $cfg_model->findUpdateBySid();
        if ($cfg) {
            $res = $cfg_model->findUpdateBySid($data);
        } else {
            $data['asc_s_id']        = $this->curr_sid;
            $data['asc_create_time'] = time();
            $res                     = $cfg_model->insertValue($data);
        }
        return $res;
    }

    private function _save_menu_index_slide()
    {
        $slide       = $this->request->getArrParam('slide');
        $slide_model = new App_Model_Sequence_MysqlSequenceMenuSlideStorage($this->curr_sid);
        if (!empty($slide)) {
            $slide_list = $slide_model->fetchSlideList();

            if (!empty($slide_list)) {
                $del_id = array();
                foreach ($slide_list as $val) {
                    if (isset($slide[$val['asms_weight']])) {
                        //存在这个位置的幻灯，更新
                        $set = array(
                            'asms_weight'    => $slide[$val['asms_weight']]['index'],
                            'asms_link'      => $slide[$val['asms_weight']]['link'],
                            'asms_link_type' => $slide[$val['asms_weight']]['type'],
                            'asms_path'      => $slide[$val['asms_weight']]['imgsrc'],
                        );
                        $up_ret = $slide_model->updateById($set, $val['asms_id']);
                        unset($slide[$val['asms_weight']]); //然后清理前端传过来的幻灯
                    } else {
                        //多余的删除
                        $del_id[] = $val['asms_id'];
                    }
                }
                if (!empty($del_id)) {
                    $slide_where   = array();
                    $slide_where[] = array('name' => 'asms_id', 'oper' => 'in', 'value' => $del_id);
                    $slide_model->deleteValue($slide_where);
                }

            }
            //新增的幻灯
            if (!empty($slide)) {
                $insert = array();
                foreach ($slide as $val) {
                    $insert[] = " (NULL, {$this->curr_sid}, '{$val['imgsrc']}', '{$val['index']}', '{$val['type']}','{$val['link']}', '" . time() . "')";
                }
                $ins_ret = $slide_model->insertBatch($insert);
            }
        } else {
            //若不存在，则全部删除
            $where   = array();
            $where[] = array('name' => 'asms_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $slide_model->deleteValue($where);
        }
        return true;
    }

    /*
     * 保存菜单
     */
    public function saveMenuAction()
    {
        $id       = $this->request->getIntParam('id');
        $content  = $this->request->getStrParam('content');
        $menuType = $this->request->getIntParam('menuType');
        $cover    = $this->request->getStrParam('cover');
        $shareNum = $this->request->getIntParam('shareNum');
        $likeNum  = $this->request->getIntParam('likeNum');
        $brief    = $this->request->getStrParam('brief');
        $video    = $this->request->getStrParam('video');
        $title    = $this->request->getStrParam('title');
        $goods    = $this->request->getArrParam('goods');
        $imgArr   = $this->request->getArrParam('imgArr');
        $category = $this->request->getIntParam('category');
        $sort     = $this->request->getIntParam('sort', 0);

        if (is_array($goods)) {
            foreach ($goods as $val) {
                $gids[] = $val['gid'];
            }
        }
        $goods_num = count($gids);
        if ($goods_num > 20) {
            $this->displayJsonError('最多添加20件商品');
        }
        if (!$title) {
            $this->displayJsonError('请填写菜单标题');
        }
        if (!$cover) {
            $this->displayJsonError('请上传菜单封面图');
        }

        $menu_model = new App_Model_Sequence_MysqlSequenceMenuStorage($this->curr_sid);

        $data = [
            'asm_type'        => $menuType,
            'asm_text'        => $content,
            'asm_video'       => $video,
            'asm_brief'       => $brief,
            'asm_title'       => $title,
            'asm_cover'       => $cover,
            'asm_category'    => $category,
            'asm_like_num'    => $likeNum,
            'asm_share_num'   => $shareNum,
            'asm_sort'        => $sort,
            'asm_goods'       => $gids ? json_encode($gids) : '',
            'asm_goods_num'   => $goods_num,
            'asm_slide'       => $imgArr ? json_encode($imgArr) : '',
            'asm_update_time' => time(),
        ];
        $isAdd = 0;
        if ($id) {
            $res = $menu_model->updateById($data, $id);
        } else {
            $isAdd                   = 1;
            $data['asm_create_time'] = time();
            $data['asm_s_id']        = $this->curr_sid;
            $res                     = $id                     = $menu_model->insertValue($data);
        }
        if ($res) {
            $this->_save_menu_goods($id, $gids, $isAdd);
            App_Helper_OperateLog::saveOperateLog("菜单{$title}信息保存成功");
        }

        $this->showAjaxResult($res, '保存');

    }

    private function _save_menu_goods($id, $gids, $isAdd = 0)
    {
        $goods_model = new App_Model_Sequence_MysqlSequenceMenuGoodsStorage($this->curr_sid);
        if (!$isAdd) {
            $goods_model->deleteByMenu($id);
        }
        $insert = [];
        if (is_array($gids) && !empty($gids)) {
            foreach ($gids as $gid) {
                $insert[] = " (NULL, '{$this->curr_sid}', '{$gid}', '{$id}', '" . time() . "') ";
            }
            $goods_model->insertBatch($insert);
        }

    }

    /*
     * 修改菜单信息
     */
    public function changeMenuInfoAction()
    {
        $result = array(
            'ec' => 400,
            'em' => '保存失败',
        );
        $id    = $this->request->getIntParam('id');
        $field = $this->request->getStrParam('field');
        $value = $this->request->getFloatParam('value');
        $pre   = 'asm_';

        $model = new App_Model_Sequence_MysqlSequenceMenuStorage($this->curr_sid);
        $str   = '信息';

        if ($id && $field) {
            $menu_field = $pre . $field;
            $set        = array(
                $menu_field => $value,
            );

            $res = $model->getRowUpdateByIdSid($id, $this->curr_sid, $set);
            if ($res) {
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功',
                );
                $menu_info = $model->getRowById($id);

                App_Helper_OperateLog::saveOperateLog("菜单【{$menu_info['g_name']}】{$str}保存成功");
            }
        } else {
            $result = array(
                'ec' => 400,
                'em' => '操作异常',
            );
        }
        $this->displayJson($result);
    }

    /*
     * 菜单列表
     */
    public function menuListAction()
    {

        $where          = [];
        $where[]        = ['name' => 'asm_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $output['name'] = $this->request->getStrParam('name');
        if ($output['name']) {
            $where[] = array('name' => 'asm_title', 'oper' => 'like', 'value' => "%{$output['name']}%");
        }

        $output['cate'] = $this->request->getIntParam('cate');
        if ($output['cate']) {
            $where[] = array('name' => 'asm_category', 'oper' => '=', 'value' => $output['cate']);
        }
        $list                = [];
        $page                = $this->request->getIntParam('page');
        $index               = $page * $this->count;
        $menu_model          = new App_Model_Sequence_MysqlSequenceMenuStorage($this->curr_sid);
        $total               = $menu_model->getCount($where);
        $pageCfg             = new Libs_Pagination_Paginator($total, $this->count, 'jquery', true);
        $output['paginator'] = $pageCfg->render();
        $output['showPage']  = $total > $this->count ? 1 : 0;
        $sort                = ['asm_sort' => 'DESC'];
        if ($index < $total) {
            $list = $menu_model->getList($where, $index, $this->count, $sort);
        }

        if ($list) {
            $output['now'] = 1;
        }
        $menu_cate                = $this->_get_menu_category(true);
        $this->output['menuCate'] = $menu_cate;
        $this->output['list']     = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '美食区管理', 'link' => '#'),
            array('title' => '菜单列表', 'link' => ''),
        ));
        $this->displaySmarty('wxapp/sequence/menu-list.tpl');
    }

    /*
     * 修改菜单分类
     */
    public function changeMenuCateAction()
    {
        $result = array(
            'ec' => 200,
            'em' => '修改失败',
        );

        $ids  = $this->request->getStrParam('ids');
        $cate = $this->request->getIntParam('cate');

        if (!$cate) {
            $this->displayJsonError('请选择分类');
        }
        $ret    = false;
        $id_arr = plum_explode($ids);
        if (is_array($id_arr) && !empty($id_arr)) {
            $menu_model = new App_Model_Sequence_MysqlSequenceMenuStorage($this->curr_sid);
            $where[]    = ['name' => 'asm_s_id', 'oper' => '=', 'value' => $this->curr_sid];
            $where[]    = ['name' => 'asm_id', 'oper' => 'in', 'value' => $id_arr];
            $update     = array('asm_category' => $cate);
            $ret        = $menu_model->updateValue($update, $where);
        }

        if ($ret) {
            $result = array(
                'ec' => 200,
                'em' => '修改成功',
            );

            App_Helper_OperateLog::saveOperateLog("菜单分类批量修改成功");

        }

        $this->displayJson($result);
    }

    /*
     * 删除菜单
     */
    public function deleteMenuAction()
    {
        $id         = $this->request->getStrParam('id');
        $menu_model = new App_Model_Sequence_MysqlSequenceMenuStorage($this->curr_sid);
        $row        = $menu_model->getRowById($id);
        $res        = $menu_model->deleteDFById($id, $this->curr_sid);

        $result = [
            'ec' => 400,
            'em' => '删除失败',
        ];
        if ($res) {
            $result = [
                'ec' => 400,
                'em' => '删除成功',
                'id' => $id,
            ];

            //将菜单的关联商品删除
            $goods_model = new App_Model_Sequence_MysqlSequenceMenuGoodsStorage($this->curr_sid);
            $goods_model->deleteByMenu($id);

            App_Helper_OperateLog::saveOperateLog("菜单{$row['asm_title']}信息删除成功");

        }

        $this->displayJson($result);
    }

    /*
     * 批量删除菜单
     */
    public function multiDeleteMenuAction()
    {
        $ids    = $this->request->getStrParam('ids');
        $id_arr = plum_explode($ids);
        $result = array(
            'ec' => 400,
            'em' => '您尚未选择菜单',
        );
        if (!empty($id_arr)) {
            $set = array(
                'asm_deleted' => 1,
            );
            $where       = array();
            $where[]     = array('name' => 'asm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[]     = array('name' => 'asm_id', 'oper' => 'in', 'value' => $id_arr);
            $goods_model = new App_Model_Sequence_MysqlSequenceMenuStorage($this->curr_sid);

            $ret = $goods_model->updateValue($set, $where);
            if ($ret) {
                //将菜单的关联商品删除
                $goods_model   = new App_Model_Sequence_MysqlSequenceMenuGoodsStorage($this->curr_sid);
                $where_goods   = [];
                $where_goods[] = ['name' => 'asmg_s_id', 'oper' => '=', 'value' => $this->curr_sid];
                $where_goods[] = ['name' => 'asmg_menu_id', 'oper' => 'in', 'value' => $id_arr];
                $goods_model->deleteValue($where_goods);

                $result = array(
                    'ec' => 200,
                    'em' => '删除成功',
                );
                App_Helper_OperateLog::saveOperateLog("菜单批量删除成功");
            } else {
                $result['em'] = '删除失败';
            }
        }
        $this->displayJson($result);
    }

    /**
     * @param bool $return
     * @return array
     * 获得菜单列表
     */
    private function _get_menu_list($return = false)
    {
        $data       = [];
        $menu_model = new App_Model_Sequence_MysqlSequenceMenuStorage($this->curr_sid);
        $where[]    = array('name' => 'asm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $list       = $menu_model->getList($where, 0, 0, [], ['asm_id', 'asm_title']);
        if ($list) {
            foreach ($list as $val) {
                $data[] = [
                    'id'    => $val['asm_id'],
                    'title' => $val['asm_title'],
                ];
            }
        }
        if ($return) {
            return $data;
        } else {
            $this->output['menuList'] = json_encode($data);
        }
    }

    /*----------------------------- 废弃方法Family -----------------------------*/
    //导出订单  拼团+商城订单
    public function excelOrderAction()
    {
        $startDate       = $this->request->getStrParam('startDate');
        $startTime       = $this->request->getStrParam('startTime');
        $endDate         = $this->request->getStrParam('endDate');
        $endTime         = $this->request->getStrParam('endTime');
        $esId            = $this->request->getIntParam('esId');
        $orderType       = $this->request->getIntParam('orderType', -1);
        $groupType       = $this->request->getStrParam('groupType');
        $addressOrder    = $this->request->getStrParam('addressOrder');
        $goodsOrder      = $this->request->getStrParam('goodsOrder');
        $communityOrder  = $this->request->getIntParam('communityOrder');
        $clearChildOrder = $this->request->getStrParam('clearChildOrder');

        if ($goodsOrder == 'on') {
            $communityOrder = '';
        }

        if ($communityOrder == 'on') {
            $goodsOrder = '';
        }

        $mergeOrder = $this->request->getStrParam('mergeOrder');
        if ($startDate && $startTime && $endDate && $endTime) {
            $start     = $startDate . ' ' . $startTime;
            $end       = $endDate . ' ' . $endTime;
            $startTime = strtotime($start);
            $endTime   = strtotime($end);
            $where     = array();
            $where[]   = array('name' => 't_create_time', 'oper' => '>=', 'value' => $startTime);
            $where[]   = array('name' => 't_create_time', 'oper' => '<', 'value' => $endTime);
            if ($orderType != -1) {
                $where[] = array('name' => 't_applet_type', 'oper' => '=', 'value' => $orderType);
            }
            $orderStatus = $this->request->getStrParam('orderStatus', 'all');

            $sort = array('t_create_time' => 'DESC');

            if ($communityOrder == 'on') {
                $sort = array('t_home_id' => 'DESC', 't_create_time' => 'DESC');
            }

            $link        = App_Helper_Group::$group_trade_status;
            $groupStatus = -1;
            if ($groupType && isset($link[$groupType]) && $link[$groupType]['id'] >= 0) {
                $groupStatus = $link[$groupType]['id'];
            }
            if ($groupStatus >= 0) {
                $where[] = array('name' => 'go_status', 'oper' => '=', 'value' => $groupStatus);
            }

            //筛选配送方式
            $postType = $this->request->getIntParam('postType');
            if ($postType) {
                $where[] = array('name' => 't_express_method', 'oper' => '=', 'value' => $postType);
            }
            //社区团购小区筛选
            $communityId = $this->request->getIntParam('communityId', 0);
            if ($communityId) {
                $where[] = array('name' => 'asc_id', 'oper' => '=', 'value' => $communityId);
            }

            //检索条件整理
            $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            if ($esId) {
                $where[] = array('name' => 't_es_id', 'oper' => '=', 'value' => $esId);
            }

            $link = App_Helper_Trade::$trade_link_status;
            if ($orderStatus && isset($link[$orderStatus]) && $link[$orderStatus]['id'] > 0) {
                $where[] = array('name' => 't_status', 'oper' => '=', 'value' => $link[$orderStatus]['id']);
            } else {
                $where[] = array('name' => 't_status', 'oper' => 'in', 'value' => [3, 4, 5, 6]);
            }

            $where[] = array('name' => 't_type', 'oper' => '=', 'value' => 5);

            $goodsname = $this->request->getStrParam('goodsname');
            if ($goodsname) {
                $title   = str_replace(" ", "", $goodsname);
                $where[] = array('name' => 'replace(g_name, " ", "")', 'oper' => 'like', 'value' => "%{$title}%");
            }

            // 社区团购  区域管理合伙人导出订单数据时默认增加一个该管理员所属城市的小区
            $area_info = App_Helper_SequenceRegion::get_area_manager($this->uid,$this->company['c_id']);
            if ($area_info) {
                if ($area_info['m_area_type'] == 'C') {
                    $where[] = ['name' => 'asa_city', 'oper' => '=', 'value' => $area_info['m_area_id']];
                } else if ($area_info['m_area_type'] == 'D') {
                    $where[] = ['name' => 'asa_zone', 'oper' => '=', 'value' => $area_info['m_area_id']];
                }

            }

            //数据展示
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
            $list        = $trade_model->getSequenceAddressGoodsList($where, 0, 0, $sort);

            if (!empty($list)) {
                $newlist  = array();
                $newslist = array();
                $gidnums  = array();
                $gfidnums = array();
                //一单多个商品情况
                $trade_order = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
                $fields      = 'to_t_id,to_g_id,gf_id,to_num,to_title,to_gf_name,to_g_id,to_price,to_num,to_total,assi_name,assi_contact,assi_mobile,to_cost,to_feedback,to_fd_status,to_fd_result';

                foreach ($list as $key => $val) {
                    $newlist    = $this->setExcelData($val);
                    $goodsList  = $trade_order->getGoodsListByTid($val['t_id'], [], false, true, false, $fields);
                    $refund_num = 0;
                    foreach ($goodsList as $k => $v) {
                        // 是否是退款订单
                        // 0：无退款
                        // 2：申请退款
                        // 3：拒绝后再申请
                        // 4：拒绝退款
                        // 7：主动退款|同意退款
                        // 8：买家撤销|自动撤销
                        // zhangzc
                        // 2019-09-19
                        $refund_status = intval($v['to_feedback']) + intval($v['to_fd_status']) + intval($v['to_fd_result']);

                        // 已退款单品不再显示
                        // zhangzc
                        // 2019-09-26
                        if ($refund_status == 7 && $clearChildOrder == 'on') {
                            $refund_num++;
                            continue;
                        }

                        //商品标题、商品订单规格、商品订单数量、商品价格
                        $newlist['g_title']      = $v['to_title'];
                        $newlist['g_gg']         = $v['to_gf_name'];
                        $newlist['g_id']         = $v['to_g_id'];
                        $newlist['gf_id']        = $v['gf_id'];
                        $newlist['g_tp']         = $v['to_price'];
                        $newlist['g_num']        = $v['to_num'];
                        $newlist['g_price']      = $v['to_total'];
                        $newlist['assi_name']    = $v['assi_name'];
                        $newlist['assi_contact'] = $v['assi_contact'];
                        $newlist['assi_mobile']  = $v['assi_mobile'];
                        // 添加成本
                        $newlist['cost'] = $v['to_cost'];

                        // 设置单品退款的标记
                        // zhangzc
                        // 2019-09-19
                        $newlist['o_is_refund'] = ($refund_status == 7) ? 'REFUND' : 'NORMAL';

                        $newslist[] = $newlist;
                        $gidnums[$v['to_g_id']] += $v['to_num'];
                        $gfidnums[$v['to_g_id'] . '-' . $v['gf_id']] += $v['to_num'];
                    }
                    $columNums[$key] = count($goodsList) - $refund_num;
                    // $columNums[$key] = count($newGoodsList[$val['t_id']]);
                }
                unset($list);
                $filename = 'orders_' . $startDate . '_' . $endDate . '.xls';
                if (count($newslist) > 10000) {
                    plum_url_location('单次最多可导出1万条数据!');
                }

                if (!empty($newslist)) {
                    $plugin = new App_Plugin_PHPExcel_PHPExcelPlugin();
                    if ($goodsOrder == 'on') {
                        //根据商品排序
                        //再根据商品id进行排序
                        $gids  = array_column($newslist, 'g_id');
                        $gfids = array_column($newslist, 'gf_id');
                        array_multisort($gids, SORT_DESC, $gfids, SORT_DESC, $newslist);
                        $gidsNum  = array();
                        $gfidsNum = array();
                        foreach ($newslist as $key => $val) {
                            $gidsNum[$val['g_id']]                        = ($gidsNum[$val['g_id']] ? $gidsNum[$val['g_id']] : 0) + 1;
                            $gfidsNum[$val['g_id'] . '-' . $val['gf_id']] = ($gfidsNum[$val['g_id'] . '-' . $val['gf_id']] ? $gfidsNum[$val['g_id'] . '-' . $val['gf_id']] : 0) + 1;
                            foreach ($gidnums as $numkey => $numval) {
                                if ($numkey == $val['g_id']) {
                                    $newslist[$key]['goodsnums'] = $numval;
                                }
                            }
                            foreach ($gfidnums as $numkey => $numval) {
                                if ($numkey == $val['g_id'] . '-' . $val['gf_id']) {
                                    $newslist[$key]['formatnums'] = $numval;
                                }
                            }
                        }
                        $gidsNum  = array_values($gidsNum);
                        $gfidsNum = array_values($gfidsNum);
                        $plugin->down_goods_sort_sequence_orders($newslist, $filename, $gidsNum, $gfidsNum);
                        die();
                    } else {
                        $plugin->down_orders_sequence_new($newslist, $filename, $columNums, $mergeOrder);
                        die();
                    }
                }
            } else {
                plum_url_location('当前时间段内没有订单!');
            }
        } else {
            plum_url_location('日期请填写完整!');
        }
    }
    /**
     * 导出的excel 数据拼装
     * @param [type] $val [description]
     */
    private function setExcelData($val)
    {
        $statusNote    = plum_parse_config('trade_status');
        $tradePay      = App_Helper_Trade::$trade_pay_type;
        $groupType     = plum_parse_config('group_type');
        $expressMethod = array(
            1 => '商家配送',
            2 => '门店自取',
            3 => '快递发货',
            6 => '团长配送',
        );
        //订单编号、会员名称、收货人、电话、收货人省份、收货人城市、收货人地区、收货地址、邮编
        $excel_row['t_tid']        = $val['t_tid'] . ' ';
        $excel_row['t_buyer_nick'] = $this->utf8_orderstr_to_unicode($val['t_buyer_nick']);
        $excel_row['s_name']       = $val['ma_name'];
        $excel_row['s_phone']      = $val['ma_phone'];
        $excel_row['s_province']   = $val['ma_province'];
        //判断是否直辖市 如果直辖市 则市等于省
        if (in_array($val['ma_province'], array('北京市', '上海市', '天津市', '重庆市'))) {
            $city = $val['ma_province'];
        } else {
            $city = $val['ma_city'];
        }
        $excel_row['s_city']          = $city;
        $excel_row['s_zone']          = $val['ma_zone'];
        $excel_row['s_detail']        = $val['ma_detail'];
        $excel_row['s_post']          = $val['ma_post'];
        $excel_row['o_address']       = $val['t_address'];
        $excel_row['o_goods_price']   = $val['t_goods_fee'];
        $excel_row['o_post_price']    = $val['t_post_fee'];
        $excel_row['o_total_price']   = $val['t_total_fee'];
        $excel_row['o_discount_fee']  = $val['t_discount_fee'];
        $excel_row['o_promotion_fee'] = $val['t_promotion_fee'];

        //优惠方式  间隔
        $excel_row['o_pay'] = $val['t_payment'];
        //物流公司、物流单号、订单状态（是否发货）、购买方式（支付宝，微信，银行卡）、商家编码(商品)商品编号等信息、维权信息（退，换）
        $excel_row['o_exp_company'] = $val['t_express_company'];
        $excel_row['o_exp_code']    = $val['t_express_code'];
        if ($val['t_status'] == 8) {
            $excel_row['o_status'] = '已退款';
        } else {
            $excel_row['o_status'] = $statusNote[$val['t_status']];
        }
        $excel_row['o_paytype'] = $tradePay[$val['t_pay_type']];
        //商家编码信息、维权信息（退，换）、订单来源（直购，什么拼团，积分）、
        //是否为团长订单、订单创建时间、订单付款时间、订单商家备注、订单用户备注、商品发货时间、交易完成时间
        $excel_row['o_createtime'] = $val['t_create_time'] ? date('Y-m-d H:i:s', $val['t_create_time']) : '';
        $excel_row['o_paytime']    = $val['t_pay_time'] ? date('Y-m-d H:i:s', $val['t_pay_time']) : '';
        $excel_row['o_sale_note']  = $val['t_note'] ? '备注: ' . $val['t_note'] . ';' : '';
        foreach (json_decode($val['t_remark_extra'], true) as $va) {
            if ($va['value']) {
                $excel_row['o_sale_note'] .= $va['name'] . ':' . $va['value'] . ';';
            }
        }

        $excel_row['o_sendtime']          = $val['t_express_time'] ? date('Y-m-d H:i:s', $val['t_express_time']) : '';
        $excel_row['o_finishtime']        = $val['t_finish_time'] ? date('Y-m-d H:i:s', $val['t_finish_time']) : '';
        $excel_row['o_store_name']        = $val['os_name'] ? $val['os_name'] : '';
        $excel_row['o_express_method']    = $expressMethod[$val['t_express_method']]; //配送方式
        $excel_row['o_express_method_id'] = $val['t_express_method'];
        $excel_row['o_community']         = $val['asc_name'] ? $val['asc_name'] : '';
        $excel_row['o_community_address'] = $val['asc_address'] ? $val['asc_address'] . $val['asc_address_detail'] : '';
        $excel_row['o_activity']          = $val['asa_title'] ? $val['asa_title'] : '';
        $excel_row['o_leader_name']       = $val['asl_name'] ? $val['asl_name'] : '';
        $excel_row['o_leader_mobile']     = $val['asl_mobile'] ? $val['asl_mobile'] : '';
        $excel_row['o_se_send_time']      = $val['t_se_send_time'] ? date('Y-m-d', $val['t_se_send_time']) : '';
        return $excel_row;
    }

    /*
     * 修改小程序颜色主题
     */
    public function themeColorCfgAction()
    {
        $theme_color = plum_parse_config('theme_color');
        foreach ($theme_color as &$val) {
            if ($val['type'] == -1) {
                $val['color1'] = $this->wxapp_cfg['ac_custom_theme_color1'] ? $this->wxapp_cfg['ac_custom_theme_color1'] : $val['color1'];
                $val['color2'] = $this->wxapp_cfg['ac_custom_theme_color2'] ? $this->wxapp_cfg['ac_custom_theme_color2'] : $val['color2'];
            }
            if ($val['type'] == $this->wxapp_cfg['ac_theme_type']) {
                $val['use'] = true;
            }
            if(!$this->wxapp_cfg['ac_theme_type'] && $val['type']==1){
                $val['use'] = true;
            }
        }
//
        //        $this->output['custom1'] = $this->wxapp_cfg['ac_theme_color1'] ? $this->wxapp_cfg['ac_theme_color1'] : $theme_color[0]['color1'];
        //        $this->output['custom2'] = $this->wxapp_cfg['ac_theme_color2'] ? $this->wxapp_cfg['ac_theme_color2'] : $theme_color[0]['color2'];

        $this->output['themeColor'] = json_encode($theme_color, 1);
        $this->buildBreadcrumbs(array(
            array('title' => '页面管理', 'link' => '#'),
            array('title' => '店铺色系', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sequence/theme-color-cfg.tpl');
    }

    /*
     * 保存店铺色系
     */
    public function saveThemeColorCfgAction()
    {
        $data    = $this->request->getArrParam('data');
        $useType = 0;
        $color1  = '';
        $color2  = '';
        foreach ($data as $val) {
            //
            if ($val['use'] == 'true') {
                $useType = $val['type'];
            }
            if ($val['type'] == -1) {
                $color1 = $val['color1'];
                $color2 = $val['color2'];
            }
        }
        $set = [
            'ac_theme_type'          => $useType,
            'ac_custom_theme_color1' => $color1,
            'ac_custom_theme_color2' => $color2,
            'ac_update_time'         => time(),
        ];

        $cfg_model = $this->_get_cfg_by_menutype($this->menuType, $this->curr_sid);
        $res       = $cfg_model->findShopCfg($set);

        //        if($res){
        //            $cfg = $cfg_model->findShopCfg();
        //            $menu_type_str_num = plum_parse_config('menu_type_str_num');
        //            $appletType = $menu_type_str_num[$this->menuType] ? $menu_type_str_num[$this->menuType] : 1;
        //            //重新设置缓存
        //            $shop_redis = new App_Model_Shop_RedisShopQueueStorage();
        //            $shop_redis->setShopCfgInRedis($cfg,$appletType);
        //        }
        $this->showAjaxResult($res, '保存');
    }









    /*废弃方法暂存区*/

    


    /*废弃方法暂存区--(新加方法 往上面加)*/

}
