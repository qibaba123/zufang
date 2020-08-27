<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/6/24
 * Time: 上午：11：30
 * 预约相关接口
 */

class App_Controller_Applet_AppointmentController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct(true);
    }


    /**
     * 首页接口
     */
    public function indexAction(){
        if($this->shop){
            $tplData = $this->_train_index_tpl();
            $info['data'] = array(
                'suid'      => $this->suid,
                'template'  => $tplData,
                'goods'     => $this->_index_goods_list(),
                'notice'    => $this->_index_notice_list(),
                'slide'     => $this->get_shop_index_slide(0, 2),
                'mustTime'  => $tplData['mustTime'],
                'mustAddress' => $tplData['mustAddress'],
                'supportOpen'    => $this->support && isset($this->support['as_audit']) ? intval($this->support['as_audit']) : 0,
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('店铺不存在，请核实');
        }
    }

    /**
     * 获取模板基本信息
     */
    private function _train_index_tpl(){
        $tpl_model = new App_Model_Applet_MysqlAppointmentIndexStorage($this->sid);
        $tpl  = $tpl_model->findUpdateBySid();
        if($tpl){
            $data = array(
                'title'     => isset($tpl['aai_title']) ? $tpl['aai_title'] : '预约',
                'address'   => $tpl['aai_address'],
                'lng'       => $tpl['aai_lng'],
                'lat'       => $tpl['aai_lat'],
                'mobile'    => $tpl['aai_mobile'],
                'openTime'  => $tpl['aai_open_time'],
                'goodTitle' => $tpl['aai_good_title']?$tpl['aai_good_title']:'预约产品',
                'orderTitle'  => $tpl['aai_order_title']?$tpl['aai_order_title']:'预约订单',
                'buttonText'  => $tpl['aai_button_text']?$tpl['aai_button_text']:'预约',
                'mustTime'    => $tpl['aai_musttime'],
                'mustAddress' => $tpl['aai_mustaddress'],
                'appointBrief' => empty($tpl['aai_appoint_brief'])?'':$tpl['aai_appoint_brief'], //预约简介
                'appointLink'  => $tpl['aai_appoint_link'],  //链接的咨询id
                'appointTitle' => empty($tpl['aai_appoint_title'])?'预约简介':$tpl['aai_appoint_title'],
                'showAddress' => intval($tpl['aai_show_address'])
            );
        }else{
            $data = array(
                'title'        => '预约',
                'mustTime'    => 1,
                'mustAddress' => 1,
                'showAddress' => 1
            );
        }
        return $data;
    }


    /**
     * 获取首页商品列表
     */
    public function _index_goods_list(){
        //获取店铺商品
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $sort        = array('g_is_top' => 'DESC','g_weight' => 'DESC', 'g_update_time' => 'DESC');
        $where       = array();
        $where[]     = array('name' => 'g_s_id','oper' => '=','value' => $this->sid);
        $where[]     = array('name' => 'g_type','oper' => '=','value' => 3);
        $where[]     = array('name' => 'g_is_sale','oper' => '=','value' => 1);
//        if($this->sid == 4546 || $this->sid == 4230){
//            $list        = $goods_model->getList($where, 0, 4, $sort); //首页展示只取4条
//        }else{
//            $list        = $goods_model->getList($where, 0, 0, $sort);
//        }
        $list        = $goods_model->getList($where, 0, 4, $sort); //首页展示只取4条
        $info        = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods($val);
            }
        }
        return $info;
    }

    /**
     * 格式化商品数据
     */
    private function _format_goods($goods){
        if($goods){
            $data = array(
                'id'         => $goods['g_id'],
                'name'       => $goods['g_name'],
                'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
            );
            return $data;
        }
        return false;
    }

    /*
     * 获得所有预约商品分类
     */
    public function appointmentKindAction(){
        $kind_model = new App_Model_Applet_MysqlAppointmentKindStorage($this->sid);
        $data = array();
        $list = $kind_model->getFirstCategory(0,0);
        if($list){
            $data[] = array(
                'id'    => 0,
                'name'  => '全部'
            );
            foreach ($list as $val){
                $data[] = array(
                    'id'    => intval($val['agk_id']),
                    'name'  => $val['agk_name']
                );
            }
            $info['data'] = $data;
            $this->outputSuccess($info);
        }else{
            $this->outputError('没有分类');
        }
    }

    /*
     * 预约商品列表
     */
    public function goodsListAction(){
        $page = $this->request->getIntParam('page',0);
        $kind = $this->request->getIntParam('kind',0);
        $index = $page * $this->count;
        $where       = array();
        $where[]     = array('name' => 'g_s_id','oper' => '=','value' => $this->sid);
        $where[]     = array('name' => 'g_type','oper' => '=','value' => 3);
        $where[]     = array('name' => 'g_is_sale','oper' => '=','value' => 1);

        $sort        = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        if($kind){
            $where[]     = array('name' => 'g_appointment_kind','oper' => '=','value' => $kind);
        }
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $list        = $goods_model->getList($where, $index, $this->count, $sort);
        $data        = array();
        if($list){
            foreach ($list as $val){
                $data[] = $this->_format_goods($val);
            }
            $info['data'] = $data;
            $this->outputSuccess($info);
        }else{
            $this->outputError('信息加载完毕');
        }
    }

    /**
     * 获取公告信息
     * @return [type] [description]
     */
    private function _index_notice_list(){
        $notice_storage = new App_Model_Applet_MysqlAppointmentNoticeStorage($this->sid);
        $notice_list = $notice_storage->fetchNoticeShowList();
        $data = array();
        if($notice_list){
            foreach ($notice_list as $val){
                $data[] = array(
                    'title'    => $val['apn_title'],
                    'link'     => $val['apn_article_id'],
                );
            }
        }
        return $data;
    }


    /**
     * 商品详情
     */
    public function goodsDetailAction(){
        $test=$this->request->getStrParam('test');
        $gid = $this->request->getIntParam('gid');
        if($gid){
            //获取店铺商品
            $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
            $goods = $goods_model->getRowById($gid);
            if($goods){
                // 更新阅读量数据
                $r= $goods_model->incrementGoodsShow($goods['g_id'],1,1);
                // 格式化商品显示
                $info['data'] = $this->_format_goods_details($goods,true);
                $this->outputSuccess($info);
            }else{
                $this->outputError('商品不存在');
            }
        }else{
            $this->outputError('商品不存在');
        }
    }

    /**
     * 商品海报
     */
    public function goodsShareAction(){
        $id = $this->request->getIntParam('id');
        $params = array(
            'id'  => $id,
            'sid' => $this->sid,
            'suid' => $this->suid,
            'appType' => $this->appletType
        );
        $shareImg = App_Helper_SharePoster::generateSharePoster('ffyyShare', $params);
        $info['data'] = array(
            'shareImg' => $this->dealImagePath($shareImg),
        );
        $this->outputSuccess($info);
    }


    /**
     * 格式化商品数据
     */
    private function _format_goods_details($goods,$detail=false){
        if($goods){
            $data = array(
                'id'         => $goods['g_id'],
                'name'       => $goods['g_name'],
                'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
                'price'      => floatval($goods['g_price']),
                'length'     => $goods['g_appointment_length'],
                'time'       => $goods['g_appointment_time'],
                'date'       => $goods['g_appointment_date'],
                'limit'      => $goods['g_number_limit'],   //付费预约人数限制
                'join_list'  => $goods['g_show_join_list'], //是否显示预约列表
                'forward_num'=> $goods['g_forward'],        //转发量
                'read_num'   => $goods['g_show_num'],       //阅读量
                'g_limit'    => $goods['g_limit'],          //总报名次数限制
                'g_day_limit'=> $goods['g_day_limit'],      //单日报名次数限制
            );
            $formatData = $this->_goods_format($goods['g_id']);
            if($formatData['minPrice'] && $formatData['maxPrice'] && $formatData['minPrice']!=$formatData['maxPrice']){
                $data['price'] = $formatData['minPrice'].'-'.$formatData['maxPrice'];
            }
            // 是否获取商品详情
            if($detail){
                $tpl = $this->_train_index_tpl();
                $data['buttonText'] = $tpl['buttonText'];
                $data['parameter'] = plum_parse_img_path($goods['g_parameter']);
                $data['detail'] = plum_parse_img_path($goods['g_detail']);
                $data['slide']  = $this->_goods_slide($goods['g_id']);
                $data['format'] = $formatData['format'] ? $formatData['format'] : array();
                $data['vrurl']  = $goods['g_vr_url'] ? $this->_judge_vrurl($goods['g_vr_url']) :'';
            }
            Libs_Log_Logger::outputLog($data);
            return $data;
        }
        return false;
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
    private function _goods_format($gid){
        //获取商品规格
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format = $format_model->getListByGid($gid);
        Libs_Log_Logger::outputLog($format);
        $data['format'] = array();
        if($format){
            $data['minPrice'] = $format[0]['gf_price'];
            $data['maxPrice'] = $format[0]['gf_price'];
            foreach ($format as $val){
                $data['format'][] = array(
                    'id'    => $val['gf_id'],
                    'name'  => $val['gf_name'],
                    'price' => floatval($val['gf_price']),
                    'sold'  => $val['gf_sold'],
                    'stock' => $val['gf_stock'],
                    'point' => $val['gf_send_point'],
                );
                if($val['gf_price']<$data['minPrice']){
                    $data['minPrice'] = $val['gf_price'];
                }
                if($val['gf_price']>$data['maxPrice']){
                    $data['maxPrice'] = $val['gf_price'];
                }
            }
        }
        return $data;
    }

    /*
     * 获取规格的最大值和最小值
     */

    // 付费预约转发计数
    public function setForwadAction(){
        $goods_id=$this->request->getStrParam('goods_id');
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
  

        $sql=$goods_model->formatIncrementSql('g_forward',1,[[
            'name'=>'g_id','oper'=>'=','value'=>$goods_id
        ]],1);
        $res = DB::query($sql);
        return $res?$this->outputSuccess():$this->outputError('转发数据更新失败');
    }
}
