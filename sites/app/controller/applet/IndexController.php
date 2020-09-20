<?php


class App_Controller_Applet_IndexController extends Libs_Mvc_Controller_ApiBaseController
{

    private $suid;
    public function __construct(){
        parent::__construct();
        $this->suid = $this->request->getStrParam('suid','gaus0xcyuh');
    }

    
    public function uploadImgAction() {
        Libs_Log_Logger::outputLog(111,'image.log');
        $dir = '/upload/depot/'.$this->suid.'/'.date('Ymd', time()).'/';
        $tool = new App_Helper_Tool();
        $upload = $tool->upload_file_limit_type('image', $dir);
        Libs_Log_Logger::outputLog($upload,'image.log');
        $data = array();
        if($upload['ec'] == 200){
            $data['data'] = array(
                'path' => $this->dealImagePath($upload['url']),
            );

            // 过滤敏感图片
            // zhangzc
            // 2019-11-18
            $sid=[5655,9373,1];
            $index=array_rand($sid);
            $wxclient_help = new App_Plugin_Weixin_WxxcxClient($sid[$index]); 
            $result = $wxclient_help->checkImg($upload['url']);
            if($result && $result['errcode']==87014){
                $this->outputError($result['errmsg']);
            }

            $this->outputSuccess($data);
        }else{
            $this->outputError($upload['em']);
        }
    }
    
    private function _goods_list(){
        $page = $this->request->getIntParam('page');
        //获取店铺商品
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $index  = $page*$this->count;
        $sort   = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        $list  = $goods_model->fetchShopGoodsList($this->sid, $index, $this->count, null, 1, $sort);
        $info = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        return $info;
    }

    
    private function _format_goods_details($goods,$detail=false){
        if($goods){
            $data = array(
                'id'         => $goods['g_id'],
                'name'       => $goods['g_name'],
                'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
                'price'      => floatval($goods['g_price']),
                'oriPrice'   => floatval($goods['g_ori_price']),
                'brief'      => isset($goods['g_brief']) ? $goods['g_brief'] : '',
                'stock'      => $goods['g_stock'],
                'stockShow'  => $goods['g_stock_show'],
                'sold'       => $goods['g_sold'],
                'freight'    => $goods['g_unified_fee']
            );
            // 是否获取商品详情
            if($detail){
                $data['parameter'] = plum_parse_img_path($goods['g_parameter']);
                $data['detail'] = plum_parse_img_path($goods['g_detail']);
                $data['slide']  = $this->_goods_slide($goods['g_id']);
                $data['format'] = $this->_goods_format($goods['g_id']);
                $data['vrurl']  = $goods['g_vr_url'] ? $this->_judge_vrurl($goods['g_vr_url']) :'';

            }
            return $data;
        }
        return false;
    }

    
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

    
    private function _goods_format($gid){
        //获取商品规格
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format = $format_model->getListByGid($gid);
        $data = array();
        if($format){
            foreach ($format as $val){
                $data[] = array(
                    'id'    => $val['gf_id'],
                    'name'  => $val['gf_name'],
                    'price' => $val['gf_price'],
                    'sold'  => $val['gf_sold'],
                    'stock' => $val['gf_stock'],
                    'point' => $val['gf_send_point'],
            );
            }
        }
        return $data;
    }

    
    public function startPageAction(){
        $suid   = $this->request->getStrParam('suid');
        $appletType = $this->request->getIntParam('appletType',1);  // 小程序类型：1微信小程序，2百度小程序，3支付宝小程序
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop   = $shop_model->findShopByUniqid($suid);
        if($shop){
            // 获取模板信息
            $tpl_model = new App_Model_Applet_MysqlAppletSinglePageStorage($shop['s_id']);
            $tpl = $tpl_model->findUpdateBySid(26);
            //获取配置信息
            if($appletType && $appletType==2){   //百度小程序配置
                $applet_cfg = new App_Model_Baidu_MysqlBaiduCfgStorage($shop['s_id']);
                $cfg        = $applet_cfg->findShopCfg();
            }else if($appletType && $appletType==3){   //支付宝小程序配置
                $applet_cfg = new App_Model_Alixcx_MysqlAlixcxCfgStorage($shop['s_id']);
                $cfg        = $applet_cfg->findShopCfg();
            }else if($appletType && $appletType==4){   //头条抖音小程序配置
                $applet_cfg = new App_Model_Toutiao_MysqlToutiaoCfgStorage($shop['s_id']);
                $cfg        = $applet_cfg->findShopCfg();
            }else if($appletType && $appletType==5){    //微信公众号配置
                $applet_model = new App_Model_Weixin_MysqlWeixinCfgStorage($shop['s_id']);
                $cfg = $applet_model->findShopCfg();
            } else if($appletType && $appletType==6){    //QQ小程序配置
                $applet_cfg = new App_Model_Qq_MysqlQqCfgStorage($shop['s_id']);
                $cfg        = $applet_cfg->findShopCfg();
            }else if($appletType && $appletType==7){ //360小程序配置
                $applet_cfg = new App_Model_Qihoo_MysqlQihooCfgStorage($shop['s_id']);
                $cfg        = $applet_cfg->findShopCfg();
            } else{
                $applet_cfg = new App_Model_Applet_MysqlCfgStorage($shop['s_id']);
                $cfg        = $applet_cfg->findShopCfg();
            }

                $data['data'] = array(
                    'temp'         => 26,
                    'isauth'       => $tpl['asp_audit']==1 ? true : false,
                    'headTitle'    => $tpl['asp_head_title'] ? $tpl['asp_head_title'] : '顶部标题',
                    'name'         => $tpl['asp_name'] ? $tpl['asp_name'] : '公司/店铺名称',
                    'mobile'       => $tpl['asp_mobile'] ? $tpl['asp_mobile'] : '13017658065',
                    'address'      => $tpl['asp_address'] ? $tpl['asp_address'] : '河南省郑州市郑东新区CBD商务内环11号',
                    'lng'          => $tpl['asp_lng'] ? $tpl['asp_lng'] : '113.5',
                    'lat'          => $tpl['asp_lat'] ? $tpl['asp_lat'] : '34.5',
                    'content'      => $tpl['asp_content'] ? plum_parse_img_path($tpl['asp_content']) : '',
                    'slide'        => $this->_shop_index_slide($shop['s_id']),
                    'camouflage'   => $this->_camouflage_version($tpl['asp_audio_version'],$shop['s_id']),
                    'versionBase'  => intval($cfg['ac_audit_base']),
                    'indexUrl'     => '/pages/index/index',
                    'shopLogo'     => isset($shop['s_logo']) && $shop['s_logo'] ? $this->dealImagePath($shop['s_logo']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_200_200.png'),
                    'shopName'     => $shop['s_name'],
                    'startImg'     => $this->_get_start_img($shop),
                    'appletadShow' => intval($cfg['ac_appletad_open']),
                    'appletadName' => '我也要做小程序',
                    'followOpen'   => isset($cfg['ac_follow_open']) ? $cfg['ac_follow_open'] : 0,    // 是否开启关注公众号组件
                    'webviewUrl'   => $tpl['asp_audit_web_url'] ? $tpl['asp_audit_web_url'] : ''
                );
            //获取设置的首页信息
            if($cfg['ac_bottom_menu']){
                $bottom_menu = json_decode($cfg['ac_bottom_menu'],true);  //反序列菜单数据
                $list_data = $bottom_menu['list'];
                if($list_data && !empty($list_data)){
                    $index = false;
                    foreach ($list_data as $val){
                        if(isset($val['setIndex']) && $val['setIndex'] && $val['setIndex']==1){
                            $data['data']['indexUrl'] = '/'.$val['pagePath'];
                        }
                        if((isset($val['setIndex']) && $val['setIndex']==1) || $val['pagePath'] =='pages/index/index'){
                            $index = true;
                        }
                    }
                    if(!$index){
                        $data['data']['indexUrl'] = '/'.$list_data[0]['pagePath'];
                    }
                }
            }
            // 类型为工单版时(判断登录信息)
            if($cfg['ac_type']==20){
                $tpl_model = new App_Model_Workorder_MysqlWorkorderIndexStorage($shop['s_id']);
                $where   =array();
                $where[] = array('name' => 'awi_s_id', 'oper' => '=', 'value' => $shop['s_id']);
                $index    = $tpl_model->getRow($where);
                if($index){
                    $data['data']['isLogin']=$index['awi_login_ison']?'open':'close';

                    $uid = plum_app_user_islogin();
                    $data['data']['uid']=$uid;
                    if($uid){
                        $user_model = new App_Model_Workorder_MysqlWorkorderUserStorage($shop['s_id']);
                        $where   =array();
                        $where[] = array('name' => 'awu_s_id', 'oper' => '=', 'value' => $shop['s_id']);
                        $where[] = array('name' => 'awu_m_id', 'oper' => '=', 'value' => $uid);
                        $user    = $user_model->getRow($where);
                        if($user){
                            $data['data']['login']='yes';
                        }else{
                            $data['data']['login']='no';
                        }
                    }
                }
            }

            //基础商城营销商城 判断是否开启了手机号验证以及用户是否通过验证
            if(in_array($cfg['ac_type'],[1,21,6,28,32])){
                $uid = plum_app_user_islogin();
                $applycfg_model = new App_Model_Member_MysqlMemberMobileCfgStorage($shop['s_id']);
                $applycfg = $applycfg_model->findUpdateBySid($shop['s_id']);
                //$applyPlugin = $this->checkToolUsableBool('yhyz',$shop['s_id']); //是否开通了手机号认证
                $applyPlugin = true; //是否开通了手机号认证
                $msg = '';
                $applyStatus = 0;
                $applyMobile = '';
                $applyName = '';
                if($applyPlugin){
                    if($applycfg && $applycfg['mmc_open'] == 1){
                        if($uid){
                            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                            $member = $member_model->getRowById($uid);
                            $apply_model = new App_Model_Member_MysqlMemberMobileApplyStorage($shop['s_id']);
                            $apply = $apply_model->findUpdateByMid($member['m_id'],$shop['s_id']);
                            if($apply){
                                $applyStatus = intval($apply['mma_status']);
                                $applyMobile = $apply['mma_mobile'];
                                $applyName = $apply['mma_name'];
                                if($applyStatus == 1){
                                    $msg = '您已提交请认证，请等待管理员审核';
                                }elseif ($applyStatus == 3){
                                    $reason = $apply['mma_handle_remark'] ? "，原因{$apply['mma_handle_remark']}" : '';
                                    $msg = '审核未通过'.$reason.'，请修改后重新提交';
                                }
                            }
                        }else{
                            $applyStatus = 0;  //开启且没有获得用户id 默认未申请
                        }
                    }else{
                        $applyStatus = 2;  //没有配置或未开启 默认通过
                    }
                }else{
                    $applyStatus = 2;  //没有开通 默认通过
                }
                $data['data']['applyTitle'] = '申请认证';
                $data['data']['applyTip'] = $applycfg['mmc_tip'] ? $applycfg['mmc_tip'] : '';
                $data['data']['applyOpen'] = $applyPlugin && $applycfg['mmc_open'] ? intval($applycfg['mmc_open']) : 0; //是否开通了手机号认证
                $data['data']['applyStatus'] = $applyStatus; //会员手机号认证状态
                $data['data']['applyMsg'] = $msg;
                $data['data']['applyMobile'] = $applyMobile;
                $data['data']['applyName'] = $applyName;
            }
            $this->outputSuccess($data);
        }else{
            $this->outputError('访问出错了，请稍后再来访问');
        }
    }

    
    private function _camouflage_version($version,$sid){
        //获取配置信息
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($sid);
        $cfg        = $applet_cfg->findShopCfg();
        $versionCode = '';
        if($version==1 && $cfg['ac_version'] && $cfg['ac_base']){
            $versionCode = $cfg['ac_version'];
        }elseif ($version==2 && $cfg['ac_audit_version'] && $cfg['ac_audit_base'] && $cfg['ac_version']!=$cfg['ac_audit_version']){
            $versionCode = $cfg['ac_audit_version'];
        }
        return $versionCode;
    }

    
    private function _shop_index_slide($sid){
        $data = array();
        //获取店铺幻灯
        $slide_storage  = new App_Model_Shop_MysqlShopSlideStorage($sid);
        $slide      = $slide_storage->fetchSlideShowList(26);
        if($slide){
            foreach ($slide as $val){
                $data[] = array(
                    'id'   => $val['ss_id'],
                    'link' => $val['ss_link'],
                    'img'  => isset($val['ss_path']) ? $this->dealImagePath($val['ss_path']) : ''
                );
            }
        }
        return $data;

    }

    
    protected function checkToolUsableBool($plugin_id,$sid) {
        $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($sid);
        $row = $plugin_model->findUpdateBySid($plugin_id);
        $cfg_model = new App_Model_Applet_MysqlCfgStorage($sid);
        $appletCfg = $cfg_model->findShopCfg();
        if (!$row || $row['apo_expire_time']<time() || ($plugin_id == 'gdb' && $appletCfg['ac_principal'] == '个人')) {
            return FALSE;
        }else{
            return TRUE;
        }
    }

    
    public function _judge_vrurl($url){
        $ret = plum_is_url($url);;
        if($ret){
            $vrurl = 'https://hz.51fenxiaobao.com/?url='.$url;
        }else{
            $vrurl = 'https://hb.51fenxiaobao.com/tour.html?id='.$url;
        }
        return $vrurl;
    }

    
    public function _get_start_img($shop){
        //获得首页开启的启动图
        $startimg_model = new App_Model_Applet_MysqlAppletStartImgStorage($shop['s_id']);
        $where = array();
        $data = '';
        $where[] = array('name'=>'asi_s_id','oper'=>'=','value'=> $shop['s_id']);
        $where[] = array('name'=>'asi_show','oper'=>'=','value'=> 1);
        $row = $startimg_model->getRow($where);
        if($row && $row['asi_path']){
            $data = array(
                'id'   => intval($row['asi_id']),
                'cover' => $this->dealImagePath($row['asi_path']),
                'time' => intval($row['asi_time'])
            );
        }
        return $data;
    }

    public function getIndexPageAction(){
        $suid   = $this->request->getStrParam('suid');
        $appletType = $this->request->getIntParam('appletType',1);  // 小程序类型：1微信小程序，2百度小程序，3支付宝小程序
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop   = $shop_model->findShopByUniqid($suid);
        if($appletType==2){  // 百度小程序
            $applet_cfg = new App_Model_Baidu_MysqlBaiduCfgStorage($shop['s_id']);
            $cfg        = $applet_cfg->findShopCfg();
        }else{
            $applet_cfg = new App_Model_Applet_MysqlCfgStorage($shop['s_id']);
            $cfg        = $applet_cfg->findShopCfg();
        }
        $path = 'pages/index/index';
        if($cfg['ac_bottom_menu']){
            $bottom_menu = json_decode($cfg['ac_bottom_menu'],true);  //反序列菜单数据
            $list_data = $bottom_menu['list'];
            foreach ($list_data as $key=>$val){
                if(($val['setIndex']) && $val['setIndex']){
                    $path = $val['pagePath'];
                    break;
                }
            }
        }
        $info['data']['path'] = $path;
        $this->outputSuccess($info);
    }


    
    private function groupByInitials(array $data, $targetKey = 'name')
    {
        $data = array_map(function ($item) use ($targetKey) {
            return array_merge($item, [
                'initials' => $this->getInitials($item[$targetKey]),
            ]);
        }, $data);
        $letter_arr = range('A','Z');
        $result_arr = [];
        unset($letter_arr[20]);
        unset($letter_arr[21]);//汉语拼音没有uv开头的
        foreach ($letter_arr as $value){
            $result_arr[] = [
                'name' => $value,
                'citys' => []
            ];
        }

        $data = $this->sortInitials($data,$result_arr);
        return $data;
    }

    
    private function sortInitials(array $data,$result = [])
    {
        $sortData = [];
        foreach ($data as $key => $value) {
            $sortData[$value['initials']][] = $value;
        }
        ksort($sortData);
        if(!$result){
            $result = array(
                array(
                    'name'  => 'ABCDEF',
                    'citys' => [],
                ),
                array(
                    'name'  => 'GHIJ',
                    'citys' => [],
                ),
                array(
                    'name'  => 'KLMN',
                    'citys' => [],
                ),
                array(
                    'name'  => 'OPQR',
                    'citys' => [],
                ),
                array(
                    'name'  => 'STUV',
                    'citys' => [],
                ),
                array(
                    'name'  => 'WXYZ',
                    'citys' => [],
                ),
            );
        }

        foreach ($sortData as $citys){
            foreach ($citys as $val){
                foreach ($result as $key => $value){
                    if(strpos($result[$key]['name'],$val['initials']) !== false){
                        $result[$key]['citys'][] = $val;
                    }
                }
            }
        }
        return $result;
    }

    
    private function getInitials($str)
    {
        if (empty($str)) {return '';}
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z')) {
            return strtoupper($str{0});
        }

        $s1  = iconv('UTF-8', 'gb2312', $str);
        $s2  = iconv('gb2312', 'UTF-8', $s1);
        $s   = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284) {
            return 'A';
        }

        if ($asc >= -20283 && $asc <= -19776) {
            return 'B';
        }

        if ($asc >= -19775 && $asc <= -19219) {
            return 'C';
        }

        if ($asc >= -19218 && $asc <= -18711) {
            return 'D';
        }

        if ($asc >= -18710 && $asc <= -18527) {
            return 'E';
        }

        if ($asc >= -18526 && $asc <= -18240) {
            return 'F';
        }

        if ($asc >= -18239 && $asc <= -17923) {
            return 'G';
        }

        if ($asc >= -17922 && $asc <= -17418) {
            return 'H';
        }

        if ($asc >= -17417 && $asc <= -16475) {
            return 'J';
        }

        if ($asc >= -16474 && $asc <= -16213) {
            return 'K';
        }

        if ($asc >= -16212 && $asc <= -15641) {
            return 'L';
        }

        if ($asc >= -15640 && $asc <= -15166) {
            return 'M';
        }

        if ($asc >= -15165 && $asc <= -14923) {
            return 'N';
        }

        if ($asc >= -14922 && $asc <= -14915) {
            return 'O';
        }

        if ($asc >= -14914 && $asc <= -14631) {
            return 'P';
        }

        if ($asc >= -14630 && $asc <= -14150) {
            return 'Q';
        }

        if ($asc >= -14149 && $asc <= -14091) {
            return 'R';
        }

        if ($asc >= -14090 && $asc <= -13319) {
            return 'S';
        }

        if ($asc >= -13318 && $asc <= -12839) {
            return 'T';
        }

        if ($asc >= -12838 && $asc <= -12557) {
            return 'W';
        }

        if ($asc >= -12556 && $asc <= -11848) {
            return 'X';
        }

        if ($asc >= -11847 && $asc <= -11056) {
            return 'Y';
        }

        if ($asc >= -11055 && $asc <= -10247) {
            return 'Z';
        }
        if($str == '濮阳'){
            return 'P';
        }
        if($str == '亳州'){
            return 'B';
        }
        if($str == '儋州'){
            return 'D';
        }
        if($str == '漯河'){
            return 'L';
        }
        if($str == '泸州'){
            return 'L';
        }
        if($str == '衢州'){
            return 'Q';
        }
        return '';
    }

}

