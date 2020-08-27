<?php


class App_Controller_Wxapp_CarController extends App_Controller_Wxapp_InitController {

    public function __construct() {
        parent::__construct();
    }

    
    public function shopListAction(){
        $shopName = $this->request->getStrParam('shopName');
        $contact  = $this->request->getStrParam('contact');
        $phone    = $this->request->getStrParam('phone');

        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where[] = array('name'=>'es_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'es_handle_status','oper'=>'=','value'=>2);
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
        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $total      = $shop_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $sort          = array('es_createtime' => 'DESC');
            $list          = $shop_model->getShopMangerList($where,$index,$this->count,$sort);
        }
        $this->output['curr_domain'] = plum_get_server('http_host');

        $this->output['category'] = $this->_get_shop_category();
        $this->output['shopName'] = $shopName;
        $this->output['contact'] = $contact;
        $this->output['list'] = $list;
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->curr_sid);
        $appcfg = $appletPay_Model->findRowPay();
        $this->output['maid'] = $appcfg['ap_shop_percentage'];

        $this->buildBreadcrumbs(array(
            array('title' => '服务商管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/car/shop-list.tpl');
    }

    
    private function _get_shop_category(){
        $category_model = new App_Model_Community_MysqlKindStorage($this->curr_sid);
        $category_list  = $category_model->getFirstCategory();
        return $category_list;
    }

    
    public function getFirstChar($s0){
        $fchar = ord($s0{0});
        if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($s0{0});
        $s1 = iconv("UTF-8","gb2312", $s0);
        $s2 = iconv("gb2312","UTF-8", $s1);
        if($s2 == $s0){$s = $s1;}else{$s = $s0;}
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if($asc >= -20319 and $asc <= -20284) return "A";
        if($asc >= -20283 and $asc <= -19776) return "B";
        if($asc >= -19775 and $asc <= -19219) return "C";
        if($asc >= -19218 and $asc <= -18711) return "D";
        if($asc >= -18710 and $asc <= -18527) return "E";
        if($asc >= -18526 and $asc <= -18240) return "F";
        if($asc >= -18239 and $asc <= -17923) return "G";
        if($asc >= -17922 and $asc <= -17418) return "H";
        if($asc >= -17922 and $asc <= -17418) return "I";
        if($asc >= -17417 and $asc <= -16475) return "J";
        if($asc >= -16474 and $asc <= -16213) return "K";
        if($asc >= -16212 and $asc <= -15641) return "L";
        if($asc >= -15640 and $asc <= -15166) return "M";
        if($asc >= -15165 and $asc <= -14923) return "N";
        if($asc >= -14922 and $asc <= -14915) return "O";
        if($asc >= -14914 and $asc <= -14631) return "P";
        if($asc >= -14630 and $asc <= -14150) return "Q";
        if($asc >= -14149 and $asc <= -14091) return "R";
        if($asc >= -14090 and $asc <= -13319) return "S";
        if($asc >= -13318 and $asc <= -12839) return "T";
        if($asc >= -12838 and $asc <= -12557) return "W";
        if($asc >= -12556 and $asc <= -11848) return "X";
        if($asc >= -11847 and $asc <= -11056) return "Y";
        if($asc >= -11055 and $asc <= -10247) return "Z";
        return 'Z#';
    }

    
    public function fetchSelectCarAction(){
        $name = $this->request->getStrParam('name');
        $count = 18;
        $result = array(
            'ec'        => 200,
            'data'      => array(),
            'pageHtml'  => '',
            'count'     => $count,
        );
        $page  = $this->request->getIntParam('page',1);
        $index = $count * intval($page-1);
        $where = array();
        $where[] = array('name'=>'acr_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'acr_deleted','oper'=>'=','value'=>0);
        if($name){
            $where[] = "( cb_name like '%{$name}%' or ct_name like '%{$name}%' )";
        }

        $sort       = array('acr_is_top' => 'DESC','acr_top_expire'=>'DESC','acr_create_time' => 'desc');

        $shop_model = new App_Model_Car_MysqlCarResourceStorage($this->curr_sid);
        $result['total']        = $shop_model->getResourceCount($where);
        $result['totalPage']    = ceil(floatval($result['total'])/floatval($count));
        if($result['totalPage'] > 1){
            $helper = new App_Helper_Menu();
            $result['pageHtml'] = $helper->ajaxShopPageLink($result['totalPage'],$page);
        }
        if($result['total'] > $index){
            $list = $shop_model->getResourceList($where,$index,$count,$sort);
            foreach($list as $val){
                $temp = array(
                    'id'       => $val['acr_id'],
                    'cover'    => $val['acr_cover']?$val['acr_cover']:'/public/manage/img/zhanwei/zw_fxb_45_45.png',
                    'name'     => $val['cb_name'].' '.$val['ct_name'],
                    'price'    => $val['acr_price'] > 0 ? $val['acr_price'].'万' : '价格面议',
                    'mile'     => $val['acr_mile'].'万公里',
                );
                $result['data'][] = $temp;
            }
        }
        $this->displayJson($result);
    }


    
    public function goodsListAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '#'),
        ));
        $this->_show_goods_list_data();
        $this->_show_category();
        $this->output['choseLink']  = $link = array(
            array(
                'href'  => '/wxapp/car/goodsList?status=sell',
                'key'   => 'sell',
                'label' => '出售中'
            ),
            array(
                'href'  => '/wxapp/car/goodsList?status=depot',
                'key'   => 'depot',
                'label' => '已下架'
            ),
        );
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $list = $level_model->getListBySid($this->curr_sid);
        $this->output['levelList'] = $list;

        $this->displaySmarty('wxapp/car/car-goods-list.tpl');
    }


    
    private function _show_goods_list_data(){
        $where          = array();
        $where[]        = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]        = array('name' => 'g_es_id','oper' => '>','value' =>0);
        $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'g_name','oper' => 'like','value' =>"%{$output['name']}%");
        }
        $output['shop'] = $this->request->getStrParam('shop');
        if($output['shop']){
            $where[] = array('name' => 'es_name','oper' => 'like','value' =>"%{$output['shop']}%");
        }
        $output['cate'] = $this->request->getIntParam('cate');
        if($output['cate']){
            $where[] = array('name' => 'g_kind1','oper' => '=','value' =>$output['cate']);
        }
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
        $total               = $goods_model->getShopGoodsCount($where,'city');
        $pageCfg             = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        $deduct = array();
        if($index < $total){
            $sort = array('g_update_time' => 'DESC');
            $list = $goods_model->getShopGoodsList($where,$index,$this->count,$sort,'city');
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

    
    private function _show_category(){
        $category_model = new App_Model_Entershop_MysqlGoodsCategoryStorage($this->curr_sid);
        $first          = $category_model->getListBySid();
        $category       = array();
        $kindSelect       = array();
        foreach($first as $val){
            $category[$val['esgc_id']] = $val['esgc_name'];
            $kindSelect[] = array(
                'id'   => $val['esgc_id'],
                'name' => $val['esgc_name']
            );
        }
        $this->output['category']   =$category ;
        $this->output['kindSelect']   = json_encode($kindSelect) ;
    }

    
    private function create_qrcode($id){
        $good_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);

        $row = $good_model->getRowById($id);
        $cover = $row['g_cover'] ? $row['g_cover'] : '';
        $str = "id=".$id;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::CAR_GOODS_DETAIL, 210 , $cover);
        $updata = array('g_qrcode'=>$url);
        $good_model->updateById($updata,$id);
        return $url;
    }

    
    public function createQrcodeAction(){
        $id = $this->request->getIntParam('id');
        $url = $this->create_qrcode($id);
        $res = array('ec'=> 200,'em'=> '创建成功！','url'=> $url);
        $this->displayJson($res);
    }






}