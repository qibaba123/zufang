<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/5/7
 * Time: 下午5:05
 */

class App_Controller_Applet_LimitController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct(true);

    }

    /**
     * 秒杀版首页
     */
    public function indexAction()
    {
        if ($this->shop) {
            $info         = array();
            $activityInfo = $this->_index_limit_activity();
            $info['data'] = array(
                'suid'            => $this->suid,
                'template'        => $this->_shop_index_tpl(), // 模板信息
                'slide'           => $this->get_shop_index_slide(0, 4), // 首页幻灯
                'shortcut'        => $this->_shop_index_shortcut(), // 首页分类导航
                'coupon'          => [],
                'times'           => $this->_get_index_times(),
                'activity'        => $activityInfo['allActivity'],
                'waitActivity'    => $activityInfo['waitActivity'],
                'runningActivity' => $activityInfo['runningActivity'],
            );

            if ($info['data']['template']['showcoupon']) {
                $info['data']['coupon'] = $this->get_index_coupon();
            }
            //$this->shop_cfg_updata($version,$base);
            $this->outputSuccess($info);
        } else {
            $this->outputError('店铺不存在，请核实');
        }
    }

    /**
     * 获取首页时间数组
     */
    private function _get_index_times()
    {
        $allTimes     = array(0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22);
        $hour         = date('H', time());
        $index        = floatval(intval($hour) / 2);
        $currHour     = $allTimes[$index];
        $currTimestap = strtotime(date('Y-m-d', time()) . ' ' . $currHour . ':00:00');
        $data         = array();
        $data[]       = array(
            'time'      => date('H', $currTimestap - 3600 * 2) . ':00',
            'timestamp' => $currTimestap - 3600 * 2,
            'desc'      => '已开抢',
            'status'    => 0,
        );

        $data[] = array(
            'time'      => date('H', $currTimestap) . ':00',
            'timestamp' => $currTimestap,
            'desc'      => '抢购中',
            'status'    => 1,
        );

        $data[] = array(
            'time'      => date('H', $currTimestap + 3600 * 2) . ':00',
            'timestamp' => $currTimestap + 3600 * 2,
            'desc'      => '即将开始',
            'status'    => 2,
        );

        $data[] = array(
            'time'      => date('H', $currTimestap + 3600 * 4) . ':00',
            'timestamp' => $currTimestap + 3600 * 4,
            'desc'      => '即将开始',
            'status'    => 2,
        );

        $data[] = array(
            'time'      => date('H', $currTimestap + 3600 * 6) . ':00',
            'timestamp' => $currTimestap + 3600 * 6,
            'desc'      => '即将开始',
            'status'    => 2,
        );

        return $data;
    }

    /*
     * 获取店铺可用的代金券列表
     */
    private function get_index_coupon()
    {
        $coupon_model = new App_Model_Coupon_MysqlCouponStorage();

        $coupon = $coupon_model->fetchShowValidList($this->sid, 0, 0);
        $list   = array();
        foreach ($coupon as $key => $value) {
            $list[] = $this->_format_coupon_data($value, false);
        }

        $received = array_column($list, 'received');
        array_multisort($received, SORT_ASC, $list);

        return $list;

    }

    /**
     * 格式化优惠券数据
     */
    private function _format_coupon_data($coupon, $receive)
    {
        // 获取已经领取的优惠券
        $uid           = plum_app_user_islogin();
        $receive_model = new App_Model_Coupon_MysqlReceiveStorage();
        $myCoupon      = $receive_model->fetchCouponList($this->sid, $uid);
        $data          = array(
            'id'        => $coupon['cl_id'],
            'name'      => $coupon['cl_name'],
            'value'     => $coupon['cl_face_val'],
            'limit'     => $coupon['cl_use_limit'],
            'count'     => $coupon['cl_count'],
            'receive'   => $coupon['cl_had_receive'],
            'received'  => !empty($myCoupon) && isset($myCoupon[$coupon['cl_id']]) && $coupon['cl_receive_limit'] == 1 ? 1 : 0,
            'desc'      => $coupon['cl_use_desc'],
            'type'      => $coupon['cl_use_type'],
            'start'     => date('Y-m-d', $coupon['cl_start_time']),
            'end'       => date('Y-m-d', $coupon['cl_end_time']),
            'colorType' => (intval($coupon['cl_id'] % 4)) + 1,
        );

        if ($receive) {
            $data['used'] = $coupon['cr_is_used'];
        }
        return $data;
    }

    /**
     * 获取店铺模板配置
     */
    private function _shop_index_tpl()
    {
        $data      = array();
        $tpl_model = new App_Model_Limit_MysqlLimitIndexStorage($this->sid);
        $tpl       = $tpl_model->findUpdateBySid();
        if ($tpl) {
            $data = array(
                'title'      => $tpl['ali_title'],
                'isopen'     => $tpl['ali_isopen'],
                'showcoupon' => $tpl['ali_show_coupon'],
                'applytitle' => !empty($tpl['ali_apply_title']) ? $tpl['ali_apply_title'] : '欢迎报名参加活动',
            );
        }
        return $data;
    }

    /**
     * 快捷导航
     */
    private function _shop_index_shortcut()
    {
        $data = array();
        //获取快捷按钮
        $shortcut_storage = new App_Model_Shop_MysqlShopShortcutStorage($this->sid);
        $shortcut         = $shortcut_storage->fetchShortcutShowList(-1);
        if ($shortcut) {
            foreach ($shortcut as $val) {
                $data[] = array(
                    'name' => $val['ss_name'],
                    'icon' => isset($val['ss_icon']) ? $this->dealImagePath($val['ss_icon']) : '',
                    'link' => isset($val['ss_link']) ? $val['ss_link'] : '',
                    'url'  => $this->get_link_by_type($val['ss_link_type'], $val['ss_link'], $val['ss_name']),
                );
            }
        }
        return $data;
    }

    /**
     * 获取限时抢购商品列表
     */
    public function limitGoodsAction()
    {
        $category    = $this->request->getIntParam('category');
        $page        = $this->request->getIntParam('page');
        $name        = $this->request->getStrParam('name');
        $esId        = $this->request->getIntParam('esId');
        $index       = $page * $this->count;
        $limit_model = new App_Model_Limit_MysqlLimitActStorage($this->sid);

        if ($this->applet_cfg['ac_type'] == 12) {
            if ($category) {
                $act_arr                  = $limit_model->getGroupCourse('look', $category, $index, $this->count);
                $info['data']['category'] = $this->_goods_group($category);
            } else {
                $where   = array();
                $act_arr = $limit_model->getAllRunningNotBeginActCourse($where, $index, $this->count, $name);
            }
        } else {
            if ($category) {
                $act_arr                  = $limit_model->getGroupGoods('look', $category, $index, $this->count);
                $info['data']['category'] = $this->_goods_group($category);
            } else {
                $where = array();
                if ($esId) {
                    $where[] = array('name' => 'la_es_id', 'oper' => '=', 'value' => $esId);
                } else {
                    $where[] = " ( la_es_id = 0 OR la_index_show = 1 ) ";
                }
                $act_arr = $limit_model->getAllRunningNotBeginActGoods($where, $index, $this->count, $name);
            }
        }

        $info['data'] = array();

        if (!empty($act_arr)) {
            if ($this->applet_cfg['ac_type'] == 12) {
                foreach ($act_arr as $val) {
                    $info['data'][] = $this->_format_course_details($val, false, $val['la_id']);
                }
            } else {
                foreach ($act_arr as $val) {
                    $info['data'][] = $this->_format_goods_details($val, false, $val['la_id']);
                }
            }

            //抖音 记录入驻店铺浏览
            if ($this->appletType == 4 && $esId) {
                $this->shopVisitRecord($this->member['m_id'], $esId);
            }

            $this->outputSuccess($info);
        } else {
            $this->outputError('数据加载完毕');
        }

    }

    /**
     * 获取商品分组
     */
    private function _goods_group($id)
    {
        $group_model = new App_Model_Limit_MysqlLimitGroupStorage($this->sid);
        $row         = $group_model->getRowById($id);
        $data        = array(
            'name'  => $row['alg_name'],
            'brief' => isset($row['alg_brief']) ? $row['alg_brief'] : '热销商品包你满意',
            'img'   => isset($row['alg_bg']) && $row['alg_bg'] ? $this->dealImagePath($row['alg_bg']) : $this->dealImagePath('/upload/gallery/thumbnail/C5A1A4E4-B65B-5031-F627091DF542-tbl.jpeg'),
        );
        return $data;
    }

    /**
     * 限时抢购活动列表
     */
    public function limitListAction()
    {
        $name          = $this->request->getStrParam('name');
        $limit_storage = new App_Model_Limit_MysqlLimitActStorage($this->sid);
        //新增新的参数，判断是否显示所有的包括已经结束的秒杀活动
        $version = $this->request->getIntParam('version');
        //2018.12.5 不展示已结束的秒杀活动
        $version = 0;
        $list    = $limit_storage->getAllRunningNotBeginAct(array(), $version);
        if ($list) {
            $info = array();
            foreach ($list as $val) {
                $info['data'][] = $this->_limit_activity_detail($val);
            }
            $this->outputSuccess($info);
        } else {
            $this->outputError('暂未添加限时抢购活动');
        }
    }
    /*
     * 秒杀活动详情
     */
    private function _limit_activity_detail($val)
    {
        $data = array();
        if (!empty($val)) {
            $status     = 0;
            $statusNote = '未开始';
            if ($val && $val['la_start_time'] > time()) {
                $status     = App_Helper_LimitBuy::LIMIT_BUY_WAIT;
                $statusNote = '未开始';
            } elseif ($val && $val['la_end_time'] < time()) {
                $status     = App_Helper_LimitBuy::LIMIT_BUY_OVER;
                $statusNote = '已结束';
            } elseif ($val && $val['la_start_time'] < time() && $val['la_end_time'] > time()) {
                $status     = App_Helper_LimitBuy::LIMIT_BUY_RUN;
                $statusNote = '去秒杀';
            }
            $data = array(
                'id'         => $val['la_id'],
                'name'       => $val['la_name'],
                'label'      => $val['la_label'],
                'img'        => $this->dealImagePath($val['la_bg_img']),
                'startTime'  => $val['la_start_time'],
                'endTime'    => $val['la_end_time'],
                'status'     => $status,
                'statusNote' => $statusNote,
                'goodsList'  => $this->_get_limit_goods($val['la_id']),
            );
        }
        return $data;
    }

    private function _get_limit_goods($laid)
    {
        // 获取限时抢购活动商品
        $goods_model = new App_Model_Limit_MysqlLimitGoodsStorage($this->sid);
        $data        = array();
        if ($this->applet_cfg['ac_type'] == 12) {
            $list = $goods_model->getListByActidCourse($laid);
            if (!empty($list)) {
                foreach ($list as $val) {
                    $data[] = $this->_format_course_details($val, false, $laid);
                }
            }
        } else {
            $list = $goods_model->getListByActid($laid);
            if (!empty($list)) {
                foreach ($list as $val) {
                    $data[] = $this->_format_goods_details($val, false, $laid);
                }
            }
        }
        return $data;
    }

    /**
     * 格式化商品数据
     */
    private function _format_goods_details($goods, $detail = false, $laid = 0)
    {
        if ($goods) {
            if (!$laid) {
                //获取正在进行中的抢购商品数组
                $act_model = new App_Model_Limit_MysqlLimitActStorage($this->sid);
                $act_goods = $act_model->getAllRunningGoodsAct();
                foreach ($act_goods as $value) {
                    if ($goods['g_id'] == $value['lg_g_id']) {
                        $laid = $value['la_id'];
                    }
                }
            }

            $data = array(
                'id'           => $goods['g_id'],
                'laid'         => $laid,
                'name'         => $goods['g_name'],
                'cover'        => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
                'price'        => floatval($goods['g_price']),
                'oriPrice'     => floatval($goods['g_ori_price']),
                'brief'        => isset($goods['g_brief']) ? $goods['g_brief'] : '',
                'stock'        => $goods['lg_stock'] ? $goods['lg_stock'] : $goods['g_stock'],
                'stockShow'    => $goods['g_stock_show'],
                'sold'         => $goods['g_sold'],
                'freight'      => $goods['g_unified_fee'],
                'hadSale'      => (round(($goods['g_sold'] / ($goods['g_sold'] + $goods['g_stock']) * 100), 2)) . '%',
                'purchase'     => isset($goods['lg_limit']) && $goods['lg_limit'] > 0 ? $goods['lg_limit'] : $goods['lg_stock'],
                'purchaseNote' => isset($goods['lg_limit']) && $goods['lg_limit'] > 0 ? '每人限购' . $goods['lg_limit'] . '件' : '',
                'independent'  => intval($goods['g_independent_mall']),
            );
            // 是否获取商品详情
            if ($detail) {
                $data['parameter'] = plum_parse_img_path($goods['g_parameter']);
                $data['detail']    = plum_parse_img_path($goods['g_detail']);
                $data['slide']     = $this->_goods_slide($goods['g_id']);
                $data['format']    = $this->_goods_format($goods['g_id']);
                $data['vrurl']     = $goods['g_vr_url'] ? $this->_judge_vrurl($goods['g_vr_url']) : '';
                $data['video']     = $goods['g_video_url'] ? $goods['g_video_url'] : '';

            }

            //是否已经收藏
            $where[] = array('name' => 'c_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'c_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where[] = array('name' => 'c_g_id', 'oper' => '=', 'value' => $goods['g_id']);

            $collection_model  = new App_Model_Goods_MysqlCollectionStorage($this->sid);
            $had               = $collection_model->getRow($where);
            $data['isCollect'] = $had ? 1 : 0;
            if ($laid > 0) {
                //获取限时抢购活动
                $limit_buy = new App_Helper_LimitBuy($this->sid);
                $limit_act = $limit_buy->checkLimitAct($goods['g_id'], $laid);

                $data['limit'] = array(
                    'id'          => $limit_act['la_id'],
                    'name'        => $limit_act['la_name'],
                    'label'       => $limit_act['la_label'],
                    'img'         => $this->dealImagePath($limit_act['la_bg_img']),
                    'startTime'   => $limit_act['la_start_time'],
                    'endTime'     => $limit_act['la_end_time'],
                    'showNum'     => $limit_act['lg_view_num'],
                    'showNumShow' => $limit_act['lg_view_num_show'],
                );

                //进行中的限时抢购活动
                if ($detail) {
                    if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
                        //覆盖原有价格
                        $limit_price         = floatval($limit_act['lg_yh_price']);
                        $data['price']       = $limit_price;
                        $data['restriction'] = intval($limit_act['lg_limit']);

                        if ($data['format']) {
                            foreach ($data['format'] as &$item) {
                                $item['price'] = $limit_price;
                            }
                        }
                        //单独秒杀销量
                        $data['sold'] = $data['limitSold'] = $limit_act['lg_sold'] + $limit_act['lg_virtual_sold'];

                        //若单独设置秒杀数量,取设置值,否则取库存
                        if ($limit_act['lg_stock'] > 0) {
                            $data['limitStock'] = $limit_act['lg_stock'];
                            $data['hadSale']    = $data['limitHadSale']    = (round((($limit_act['lg_sold'] + $limit_act['lg_virtual_sold']) / ($data['limitStock'] + $limit_act['lg_virtual_sold'])) * 100, 2)) . '%';
                        } else {
                            //商品库存
                            $data['limitStock'] = $goods['g_stock'];
                            //将秒杀售出数量与商品相加 防止因库存减少导致超过100%
                            $data['hadSale'] = $data['limitHadSale'] = (round((($limit_act['lg_sold'] + $limit_act['lg_virtual_sold']) / ($data['limitStock'] + $limit_act['lg_virtual_sold'] + $limit_act['lg_sold'])) * 100, 2)) . '%';
                        }
                    }
                } else {
                    //覆盖原有价格
                    $limit_price         = floatval($limit_act['lg_yh_price']);
                    $data['price']       = $limit_price;
                    $data['restriction'] = intval($limit_act['lg_limit']);
                    $data['status']      = $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN ? 1 : 0;
                    if ($data['format']) {
                        foreach ($data['format'] as &$item) {
                            $item['price'] = $limit_price;
                        }
                    }
                    //单独秒杀销量
                    $data['sold'] = $data['limitSold'] = $limit_act['lg_sold'] + $limit_act['lg_virtual_sold'];
                    //若单独设置秒杀数量,取设置值,否则取库存
                    if ($limit_act['lg_stock'] > 0) {
                        $data['limitStock'] = $limit_act['lg_stock'];
                        $data['hadSale']    = $data['limitHadSale']    = (round((($limit_act['lg_sold'] + $limit_act['lg_virtual_sold']) / ($data['limitStock'] + $limit_act['lg_virtual_sold'])) * 100, 2)) . '%';
                    } else {
                        //商品库存
                        $data['limitStock'] = $goods['g_stock'];
                        //将秒杀售出数量与商品相加 防止因库存减少导致超过100%
                        $data['hadSale']    = $data['limitHadSale'] = (round((($limit_act['lg_sold'] + $limit_act['lg_virtual_sold']) / ($data['limitStock'] + $limit_act['lg_virtual_sold'] + $limit_act['lg_sold'])) * 100, 2)) . '%';
                        $data['limitStock'] = $data['limitStock'] + intval($limit_act['lg_sold']);
                    }
                }

                if ($data['limitStock'] > 0) {
                    if ($data['purchaseNote']) {
                        $data['purchaseNote'] = $data['purchaseNote'] . "，共{$data['limitStock']}件";
                    } else {
                        //取商品库存时 将已售与库存相加得到总量
                       
                        $data['purchaseNote'] = "共{$data['limitStock']}件";
                    }
                }

            }
            return $data;
        }
        return false;
    }

    /**
     * 培训用
     * 格式化课程数据
     */
    private function _format_course_details($goods, $detail = false, $laid = 0)
    {
        if ($goods) {
            $stock = '';
            $data  = array(
                'id'       => $goods['atc_id'],
                'laid'     => $laid,
                'name'     => $goods['atc_title'],
                'cover'    => isset($goods['atc_cover']) ? $this->dealImagePath($goods['atc_cover']) : '',
                'price'    => floatval($goods['atc_price']),
                'oriPrice' => floatval($goods['atc_ori_price']),
                'brief'    => isset($goods['atc_brief']) ? $goods['atc_brief'] : '',
                'sold'     => $goods['atc_apply'],
                'hadSale'  => '',
            );
            // 是否获取商品详情
            if ($detail) {
                $data['parameter'] = plum_parse_img_path($goods['atc_outline']);
                $data['detail']    = plum_parse_img_path($goods['atc_detail']);
            }

            //是否已经收藏
            //是否已经收藏
            $where   = array();
            $where[] = array('name' => 'atcc_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'atcc_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where[] = array('name' => 'atcc_atc_id', 'oper' => '=', 'value' => $goods['atc_id']);

            $collection_model  = new App_Model_Train_MysqlTrainCourseCollectionStorage($this->sid);
            $had               = $collection_model->getRow($where);
            $data['isCollect'] = $had ? 1 : 0;
            if ($laid > 0) {
                //获取限时抢购活动
                $limit_buy = new App_Helper_LimitBuy($this->sid);
                $limit_act = $limit_buy->checkLimitAct($goods['atc_id'], $laid);
                //进行中的限时抢购活动
                if ($detail) {
                    if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
                        //覆盖原有价格
                        $limit_price         = floatval($limit_act['lg_yh_price']);
                        $data['price']       = $limit_price;
                        $data['restriction'] = intval($limit_act['lg_limit']);

                        if ($data['format']) {
                            foreach ($data['format'] as &$item) {
                                $item['price'] = $limit_price;
                            }
                        }
                        //单独秒杀销量
                        $data['limitSold'] = $limit_act['lg_sold'];
                        //若单独设置秒杀数量,取设置值,否则取库存
                        $data['limitStock'] = $limit_act['lg_stock'] ? $limit_act['lg_stock'] : $stock;
                        //覆盖原抢购百分比
                        $data['limitHadSale'] = (round(($limit_act['lg_sold'] / ($limit_act['lg_sold'] + $data['limitStock'])) * 100, 2)) . '%';

                    }
                } else {
                    //覆盖原有价格
                    $limit_price         = floatval($limit_act['lg_yh_price']);
                    $data['price']       = $limit_price;
                    $data['restriction'] = intval($limit_act['lg_limit']);
                    $data['status']      = $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN ? 1 : 0;
                    if ($data['format']) {
                        foreach ($data['format'] as &$item) {
                            $item['price'] = $limit_price;
                        }
                    }
                    //单独秒杀销量
                    $data['limitSold'] = $limit_act['lg_sold'];
                    //若单独设置秒杀数量,取设置值,否则取库存
                    $data['limitStock'] = $limit_act['lg_stock'] ? $limit_act['lg_stock'] : $stock;
                    //覆盖原抢购百分比
                    $data['limitHadSale'] = (round(($limit_act['lg_sold'] / ($data['limitStock'])) * 100, 2)) . '%';
                }

            }
            return $data;
        }
        return false;
    }

    /**
     * 获取商品的幻灯
     */
    private function _goods_slide($gid)
    {
        //获取商品幻灯
        $slide_model = new App_Model_Goods_MysqlGoodsSlideStorage($this->sid);
        $slide       = $slide_model->getListByGidSid($gid, $this->sid);
        $data        = array();
        if ($slide) {
            foreach ($slide as $val) {
                $data[] = $this->dealImagePath($val['gs_path']);
            }
        }
        return $data;
    }

    /**
     * 获取商品规格
     */
    private function _goods_format($gid)
    {
        //获取商品规格
        $format_model = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format       = $format_model->getListByGid($gid);
        $data         = array();
        if ($format) {
            foreach ($format as $val) {
                $data[] = array(
                    'id'    => $val['gf_id'],
                    'name'  => $val['gf_name'],
                    'price' => $val['gf_price'],
                    'sold'  => $val['gf_sold'],
                    'stock' => $this->applet_cfg['ac_type'] == 7 ? $val['gf_hotel_stock'] : $val['gf_stock'],
                    'point' => $val['gf_send_point'],
                );
            }
        }
        return $data;
    }

    /**
     * 获取首页的秒杀活动(正在进行中的和未开始的)
     */
    private function _index_limit_activity()
    {
        $act_model               = new App_Model_Limit_MysqlLimitActStorage($this->sid);
        $where[]                 = " ( la_es_id = 0 OR la_index_show = 1 ) ";
        $list                    = $act_model->getAllRunningNotBeginAct($where);
        $data                    = array();
        $data['allActivity']     = array();
        $data['waitActivity']    = array();
        $data['runningActivity'] = array();
        if ($list) {
            foreach ($list as $val) {
                $status = $this->_fetch_activity_status($val['la_start_time'], $val['la_end_time']);
                $item   = array(
                    'id'         => $val['la_id'],
                    'name'       => $val['la_name'],
                    'startTime'  => $val['la_start_time'],
                    'endTime'    => $val['la_end_time'],
                    'status'     => $status['code'],
                    'statusNote' => $status['msg'],
                    'goodsList'  => $this->_get_limit_goods($val['la_id']),
                );
                $data['allActivity'][] = $item;
                if ($item['status'] == 0) {
                    $data['waitActivity'][] = $item;
                }
                if ($item['status'] == 1) {
                    $data['runningActivity'][] = $item;
                }
            }
        }
        return $data;
    }

    /**
     * 根据活动开始时间和结束时间获取活动状态
     */
    private function _fetch_activity_status($startTime, $endTime)
    {
        if ($startTime > time()) {
            //未开始
            $status = array(
                'code' => App_Helper_LimitBuy::LIMIT_BUY_WAIT,
                'msg'  => '未开始',
            );
        } elseif ($endTime < time()) {
            // 已结束
            $status = array(
                'code' => App_Helper_LimitBuy::LIMIT_BUY_OVER,
                'msg'  => '已结束',
            );
        } else {
            $status = array(
                'code' => App_Helper_LimitBuy::LIMIT_BUY_RUN,
                'msg'  => '进行中',
            );
        }
        return $status;
    }

    /**
     * 获取已结束的活动商品列表
     */
    public function endActivityGoodsAction()
    {
        $page      = $this->request->getIntParam('page');
        $index     = $page * $this->count;
        $act_model = new App_Model_Limit_MysqlLimitActStorage($this->sid);
        $where[]   = " ( la_es_id = 0 OR la_index_show = 1 ) ";
        if ($this->applet_cfg['ac_type'] == 12) {
            $list = $act_model->getAllEndActCourse($where, $index, $this->count);
        } else {
            $list = $act_model->getAllEndActGoods($where, $index, $this->count);
        }
        $info['data'] = [];
        if ($this->applet_cfg['ac_type'] == 12) {
            if (!empty($list)) {
                foreach ($list as $val) {
                    $info['data'][] = $this->_format_course_details($val, false, $val['la_id']);
                }
            }
        } else {
            if (!empty($list)) {
                foreach ($list as $val) {
                    $info['data'][] = $this->_format_goods_details($val, false, $val['la_id']);
                }
            }
        }
        if ($list) {
            $this->outputSuccess($info);
        } else {
            $this->outputError("数据加载完毕");
        }
    }

}
