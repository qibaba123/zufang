<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/1/19
 * Time: 下午6:15
 */
class App_Controller_Wxapp_ShareposterController extends Libs_Mvc_Controller_FrontBaseController {

    public function __construct() {
        parent::__construct();
        $this->setLayout('default.tpl');
    }

    /**
     * 分享职位页面
     */
    public function jobShareAction(){
        $id  = $this->request->getIntParam('id');
        $mid = $this->request->getIntParam('mid');
        $position_model = new App_Model_Job_MysqlJobPositionStorage(0);
        $job = $position_model->getPositionCategoryById($id);
        $job['workYears']  = $this->_parse_job_cfg_data($job['ajp_work_years'], 'workYears');
        $job['education']  = $this->_parse_job_cfg_data($job['ajp_education'], 'education');
        $job['salaryUnit'] = $this->_parse_job_cfg_data($job['ajp_salary_unit'], 'salaryUnit');
        $job['salaryType'] = $this->_parse_job_cfg_data($job['ajp_salary_type'], 'salaryType');
        $job['label']      = $this->_get_job_label($job);
        $company_model = new App_Model_Job_MysqlJobCompanyStorage(0);
        $company = $company_model->findCompanyByShopId($job['ajp_es_id']);
        $company['ajc_size']    = $this->_parse_job_cfg_data($company['ajc_size'], 'companySize');
        $company['ajc_finance'] = $this->_parse_job_cfg_data($company['ajc_finance'], 'finance');
        $category_model = new App_Model_Job_MysqlJobCategoryStorage(0);
        $category = $category_model->getRowById($company['ajc_cate2']);
        $company['ajc_cate2'] = $category['ajc_name'];
        $job['ajp_desc'] = str_replace("\n", "<br/>",$job['ajp_desc']);
        $code_model = new App_Model_Job_MysqlJobCodeStorage(0);
        $code = $code_model->getCodeByPid($id, $mid);
        $this->output['code']    = $code;
        $this->output['job']     = $job;
        $this->output['company'] = $company;
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($company['ajc_s_id']);
        $cfg        = $applet_cfg->findShopCfg();
        $this->output['cfg'] = $cfg;
        $this->displaySmarty('wxapp/shareposter/job-share.tpl');
    }

    private function _get_job_label($job){
        $label       = array();
        $label_model = new App_Model_Job_MysqlJobPositionLabelStorage(0);
        $labelList   = $label_model->getLabelListNameByPId($job['ajp_id']);
        foreach ($labelList as $value){
            $label[] = $value['ajl_name'];
        }
        $custom = json_decode($job['ajp_custom_label'], true);
        foreach ($custom as $key => $value){
            if(!$value){
                unset($custom[$key]);
            }
        }
        $labels = array_merge($label, $custom);
        $this->output['labels'] = array_slice($labels,0, 5);
    }

    /**
     * 分享公司页面
     */
    public function companyShareAction(){
        $id  = $this->request->getIntParam('id');
        $mid = $this->request->getIntParam('mid');
        $company_model = new App_Model_Job_MysqlJobCompanyStorage(0);
        $company = $company_model->getCompanyCategoryById($id);
        $company['ajc_size']     = $this->_parse_job_cfg_data($company['ajc_size'], 'companySize');
        $company['ajc_finance']  = $this->_parse_job_cfg_data($company['ajc_finance'], 'finance');
        $this->output['company'] = $company;
        $position_model = new App_Model_Job_MysqlJobPositionStorage(0);
        $list = $position_model->getPositionByCid($company['ajc_es_id'], 4);
        $this->output['positionList'] = $list;
        $code_model = new App_Model_Job_MysqlJobCodeStorage(0);
        $code = $code_model->getCodeByCid($id, $mid);
        $this->output['code']    = $code;
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($company['ajc_s_id']);
        $cfg        = $applet_cfg->findShopCfg();
        $this->output['cfg'] = $cfg;
        $this->displaySmarty('wxapp/shareposter/company-share.tpl');
    }

    /**
     * 解析配置文件数据
     * @param $id
     * @param $name
     * @param string $key
     * @param string $type
     * @return bool
     */
    private function _parse_job_cfg_data($id, $name, $key='title', $type='jobcfg'){
        $cfg = plum_parse_config($name, $type);
        foreach ($cfg as $value){
            if($value['id'] == $id){
                return $value[$key];
            }
        }
        return false;
    }

    /**
     * 帖子详情页面
     */
    public function postShareAction(){
        $id  = $this->request->getIntParam('id');
        $sid = $this->request->getIntParam('sid');
        $appType = $this->request->getIntParam('appType');
        $acType = $this->request->getIntParam('acType');
        $suid = $this->request->getStrParam('suid');

        $post_model = new App_Model_City_MysqlCityPostStorage($sid);
        $post = $post_model->getRowById($id);

        if($appType == 5){
            if($post['acp_weixin_qrcode']){
                $post['acp_qrcode'] = $post['acp_weixin_qrcode'];
            }else{
                $post['acp_qrcode'] = $this->create_city_post_weixin_qrcode($id,$sid,$suid,$acType);
            }
        }

        $attachment_model = new App_Model_City_MysqlCityPostAttachmentStorage($sid);
        $images = $attachment_model->fetchAllAttachment($id);
        $category_model = new App_Model_City_MysqlCityPostCategoryStorage($sid);
        $category = $category_model->getRowById($post['acp_acc_id']);
        $post['acp_content'] = str_replace("\n", "<br/>",$post['acp_content']);
        $this->output['post']     = $post;
        $this->output['image']    = $images[0];
        $this->output['category'] = $category;
        $this->displaySmarty('wxapp/shareposter/post-share.tpl');
    }

    /**
     * 砍价分享页面
     */
    public function bargainShareAction(){
        $bjId = $this->request->getIntParam('jid',0);
        $activityId = $this->request->getIntParam('id',0);
        $sid = $this->request->getIntParam('sid');
        $mid = $this->request->getIntParam('mid');

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($mid);

        $join_storage   = new App_Model_Bargain_MysqlJoinStorage($sid);
        $join = $join_storage->getRowById($bjId);
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($sid);
        if($activityId && !$bjId){
            $activity = $bargain_model->getRowById($activityId);
            $qrcode = $activity['ba_qrcode'];
        }else{
            $activity = $bargain_model->getRowById($join['bj_a_id']);
            $qrcode = $join['bj_qrcode'];
        }

        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $goods = $goods_model->getRowById($activity['ba_g_id']);

        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($sid);
        $cfg        = $applet_cfg->findShopCfg();

        $this->output['qrcode']    = $qrcode;
        $this->output['goods']     = $goods;
        $this->output['shareDesc'] = $activity['ba_desc'];
        $this->output['shareImg']  = $activity['ba_image'];
        $this->output['activity']  = $activity;
        $this->output['member']    = $member;
        $this->output['cfg'] = $cfg;
        $this->displaySmarty('wxapp/shareposter/bargain-share.tpl');
    }

    public function resumeDetailAction(){
        $id = $this->request->getIntParam('id');
        $sid = $this->request->getIntParam('sid');
        $resume_model = new App_Model_Job_MysqlJobResumeStorage($sid);
        $resume = $resume_model->getRowById($id);

        $category_model = new App_Model_Job_MysqlJobCategoryStorage($sid);
        $categorySelect = $category_model->fetchCategoryListForSelect();

        $resume['ajr_education']    = $this->_parse_job_cfg_data($resume['ajr_education']?$resume['ajr_education']:1, 'education');
        $resume['ajr_work_years']   = $this->_parse_job_cfg_data($resume['ajr_work_years']?$resume['ajr_work_years']:1, 'workYears');
        $resume['ajr_salary']       = $this->_parse_job_cfg_data($resume['ajr_salary']?$resume['ajr_salary']:1, 'salary');
        $resume['ajr_work_type']    = $this->_parse_job_cfg_data($resume['ajr_work_type']?$resume['ajr_work_type']:1, 'workType');
        $resume['ajr_work_status']  = $this->_parse_job_cfg_data($resume['ajr_work_status']?$resume['ajr_work_status']:1, 'workStatus');
        $resume['ajr_arrival_time'] = $this->_parse_job_cfg_data($resume['ajr_arrival_time']?$resume['ajr_arrival_time']:1, 'arrivalTime');
        $resume['age']              = $this->_get_age($resume['ajr_birthday']);

        if($resume['ajr_purpose_city_amap']){
            $purposeCity = json_decode($resume['ajr_purpose_city_amap'], true);
        }else{
            $purposeCity = $resume['ajr_purpose_city']?json_decode($resume['ajr_purpose_city'], true):[];
        }

        $resume['purposeCity'] = '';
        foreach ($purposeCity as $key => $val){
            $resume['purposeCity'] .= $val['name'];
            if($key < count($purposeCity)-1){
                $resume['purposeCity'] .= '、';
            }
        }

        $this->_get_work_experience($resume['ajr_id'], $sid);
        $this->_get_education_experience($resume['ajr_id'], $sid);
        $this->_get_object_experience($resume['ajr_id'], $sid);

        $this->output['resume'] = $resume;
        $this->output['categorySelect'] = $categorySelect;
        $this->displaySmarty('wxapp/shareposter/resume-detail.tpl');
    }


    private function _get_age($age){
        list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age));
        $now = strtotime("now");
        list($y2,$m2,$d2) = explode("-",date("Y-m-d",$now));
        $age = $y2 - $y1;
        if((int)($m2.$d2) < (int)($m1.$d1))
            $age -= 1;
        return $age;
    }


    //获取工作经历
    private function _get_work_experience($id, $sid){
        if($id){
            $expreience_model = new App_Model_Job_MysqlJobWorkExperienceStorage($sid);
            $list = $expreience_model->getListByRId($id);
            $this->output['workExperience'] = $list;
        }
    }

    //获取教育经历
    private function _get_education_experience($id, $sid){
        if($id){
            $expreience_model = new App_Model_Job_MysqlJobEducationExperienceStorage($sid);
            $list = $expreience_model->getListByRId($id);
            foreach ($list as $key => $value){
                $list[$key]['ajee_education'] = $this->_parse_job_cfg_data($value['ajee_education']?$value['ajee_education']:1, 'education');
            }
            $this->output['educationExperience'] = $list;
        }
    }

    //获取项目经历
    private function _get_object_experience($id, $sid){
        if($id){
            $expreience_model = new App_Model_Job_MysqlJobObjectExperienceStorage($sid);
            $list = $expreience_model->getListByRId($id);
            $this->output['objectExperience'] = $list;
        }

    }

    /**
     * 社区团购
     * 商品分享页面
     */
    public function sequenceGoodsShareAction(){
        $gid = $this->request->getIntParam('id',0);
        $sid = $this->request->getIntParam('sid');
        $mid = $this->request->getIntParam('mid');
        // 秒杀商品的话增加一个秒杀价格
        // zhangzc
        // 2019-07-13
        $seckill_id=$this->request->getIntParam('seckill_id');
        if($seckill_id){
            $limit_goods_model=new App_Model_Limit_MysqlLimitGoodsStorage($sid);
            $seckill_goods_info=$limit_goods_model->getRow([
                ['name'=>'lg_s_id','oper'=>'=','value'=>$sid],
                ['name'=>'lg_actid','oper'=>'=','value'=>$seckill_id],
                ['name'=>'lg_g_id','oper'=>'=','value'=>$gid],
            ]);
            if($seckill_goods_info)
                $this->output['seckillPrice']=floatval($seckill_goods_info['lg_yh_price']);
        }

        $goods_model = new App_Model_Goods_MysqlGoodsStorage($sid);
        $goods = $goods_model->getRowById($gid);

        // 选中「原价 会员价 新人价格」中价格最低的一个
        // zhangzc
        // 2019-07-31
        
        //会员专享价格 
        if($goods['g_show_vip']){
            $vip_price=json_decode($goods['g_vip_price_list'],TRUE);
            if(empty($vip_price))
                $vip_price=[];
            else
                $vip_price=array_column($vip_price,'price');
        }
        $price_list=$vip_price;
        $price_list[]=floatval($goods['g_price']);
      
        // 设置的有新人专享价格的
        if($goods['g_date_price']  && $goods['g_has_window']==2)
            $price_list[]=floatval($goods['g_date_price']);

        // 若规格存在 查询商品规格中最小的值
        if($goods['g_has_format']){
            $format_model   = new App_Model_Goods_MysqlFormatStorage($sid);
            // 规格里面售价的最低价
            $min_format_price=$format_model->getList([
                ['name'=>'gf_s_id','oper'=>'=','value'=>$sid],
                ['name'=>'gf_g_id','oper'=>'=','value'=>$gid]
            ],0,1,['gf_price'=>'ASC'],['gf_price']);
            if($min_format_price[0]['gf_price'])
                $price_list[]=floatval($min_format_price[0]['gf_price']);

             // 规格里面新人专享价的最低价
            if($goods['g_has_window']==2){
                $min_format_newmember_price=$format_model->getList([
                    ['name'=>'gf_s_id','oper'=>'=','value'=>$sid],
                    ['name'=>'gf_g_id','oper'=>'=','value'=>$gid],
                    ['name'=>'gf_newmember_price','oper'=>'>','value'=>0],
                ],0,1,['gf_newmember_price'=>'ASC'],['gf_newmember_price']);
                if($min_format_newmember_price[0]['gf_newmember_price'])
                    $price_list[]=floatval($min_format_newmember_price[0]['gf_newmember_price']);
            }

            // 获取规格里面的会员价
            if($goods['g_show_vip']){
                $vip_format_price=$format_model->getList([
                    ['name'=>'gf_s_id','oper'=>'=','value'=>$sid],
                    ['name'=>'gf_g_id','oper'=>'=','value'=>$goods['g_id']],
                ],0,0,[],['gf_vip_price_list']);
                foreach ($vip_format_price as $vip_format_item) {
                    $vip_format_price_item=json_decode($vip_format_item['gf_vip_price_list'],TRUE);
                    if(empty($vip_format_price_item))
                        $vip_f_price=[];
                    else{
                        $vip_f_price=array_column($vip_format_price_item,'price');
                        $price_list= array_merge($price_list,$vip_f_price);
                    }
                }
            }
            
        } 
        $price_list=array_filter($price_list);
        $goods_price=min($price_list);

        $this->output['name']  = $goods['g_name'];
        $this->output['cover'] = $goods['g_cover'];
        if(floatval($seckill_goods_info['lg_yh_price']))
            $this->output['price'] = $goods['g_price'];
        else
            $this->output['price'] = $goods_price;
        $this->output['oldPrice'] = floatval($goods['g_ori_price']);


        //获得全部参与人数
        // $order_model = new App_Model_Trade_MysqlTradeOrderStorage($sid);
        // $total = $order_model->getGoodsMemberCountByGid($gid);
        $this->output['total'] = $goods['g_sold'] ? $goods['g_sold'] : 0;
        //获得小程序配置
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($sid);
        $appletCfg = $applet_cfg->findShopCfg();
        $this->output['appletCfg'] = $appletCfg;
        //获得商品分享二维码
        $qrcode = $this->_get_share_code($mid,$sid,$gid,0,'goods',$goods['g_cover']);
        $this->output['qrcode'] = $qrcode;
        $this->displaySmarty('wxapp/shareposter/sequence-goods-share.tpl',null,null,false);
    }

    private function _get_share_code($uid, $sid , $gid, $laid, $type, $cover){

        $code_model = new App_Model_Goods_MysqlGoodsCodeStorage($sid);
        $code = $code_model->getCodeByGidMid($gid, $uid);
        if($code) {
            if($code['agc_code'] && file_exists(PLUM_DIR_ROOT.$code['agc_code'])){
                return $code['agc_code'];
            }else{  //图片失效重新生成
                $client_plugin  = new App_Plugin_Weixin_WxxcxClient($sid);
                if($type && $type=='shop'){
                    $str = "id=".$gid.'&mid='.$uid;
                    $url = $client_plugin->fetchWxappShareCode($str, App_Plugin_Weixin_WxxcxClient::SHOP_GOODS_DETAILS_PATH, 210, $cover);
                }else{
                    $str = "id=".$gid.'&laid='.$laid.'&mid='.$uid;
                    $url = $client_plugin->fetchWxappShareCode($str, App_Plugin_Weixin_WxxcxClient::GOODS_DETAIL_CODE_PATH, 210, $cover);
                }
                $updata = array('agc_code'=> $url);
                $code_model->updateById($updata, $code['agc_id']);
                return $url;
            }
        }else{
            return $this->_create_new_qrcode($uid,$sid,$gid,$laid,$type, $cover);
        }
    }

    /**
     * 生成商品二维码
     * $id : 商品id
     * $uid : 会员id
     * $laid : 秒杀商品id
     * ￥type : 商品类型；good普通商品，seckill秒杀商品，group拼团商品，shop多店
     */
    private function _create_new_qrcode($uid,$sid,$id,$laid=0,$type='good', $cover, $childAppid=''){
        if($childAppid){
            $client_plugin  = new App_Plugin_Weixin_WxxcxChild($sid, $childAppid);
        }else{
            $client_plugin  = new App_Plugin_Weixin_WxxcxClient($sid);
        }
        if($type && $type=='shop'){
            $str = "id=".$id.'&mid='.$uid;
            $url = $client_plugin->fetchWxappShareCode($str, App_Plugin_Weixin_WxxcxClient::SHOP_GOODS_DETAILS_PATH, 210, $cover);
        }else{
            $str = "id=".$id.'&laid='.$laid.'&mid='.$uid;
            $url = $client_plugin->fetchWxappShareCode($str, App_Plugin_Weixin_WxxcxClient::GOODS_DETAIL_CODE_PATH, 210, $cover);
        }
        if($url){
            $data = array(
                'agc_s_id' => $sid,
                'agc_g_id' => $id,
                'agc_child_appid' => $childAppid,
                'agc_m_id' => $uid,
                'agc_code' => $url,
                'agc_create_time' => time()
            );
            $code_model = new App_Model_Goods_MysqlGoodsCodeStorage($sid);
            $code_model->insertValue($data);
        }
        return $url;
    }

    /**
     * 房产分享页面
     */
    public function houseShareAction(){
        $id = $this->request->getIntParam('id');
        $resources_model = new App_Model_Resources_MysqlResourcesStorage();
        $row = $resources_model->getRowById($id);

        $this->output['row'] = $row;
        $this->displaySmarty('wxapp/shareposter/house-share.tpl');
    }

    /**
     * 电话本分享页面
     */
    public function mobileShareAction(){
        $id = $this->request->getIntParam('id');
        $sid = $this->request->getIntParam('sid');
        $apply_storage = new App_Model_Mobile_MysqlMobileShopApplyStorage($sid);
        $row = $apply_storage->getRowById($id);

        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($sid);
        $cfg        = $applet_cfg->findShopCfg();

        $this->output['row'] = $row;
        $this->output['cfg'] = $cfg;
        $this->displaySmarty('wxapp/shareposter/mobile-share.tpl');
    }

    /**
     * 新年祝福分享页
     */
    public function blessingShareAction(){
        $sid = $this->request->getIntParam('sid');
        $id  = $this->request->getIntParam('id');
        $mid = $this->request->getIntParam('mid');
        // 获取店铺设置的祝福语
        $blessing_storage = new App_Model_Blessing_MysqlBlessingCfgStorage($sid);
        $blessCfg = $blessing_storage->findUpdateBySid();
        $this->output['blessCfg'] = $blessCfg;
        $blessing = array();
        if($id){
            //根据祝福语id获取一条对应的祝福语
            $blessingList_storage = new App_Model_Blessing_MysqlBlessingListStorage($sid);
            $blessing = $blessingList_storage->findRowByBlessingId($id);
        }elseif ($mid){
            //获取最后一条获取到的最新的祝福设置
            $blessingList_storage = new App_Model_Blessing_MysqlBlessingListStorage($sid);
            $blessing = $blessingList_storage->findRowBySidMid($mid);
        }
        if(empty($blessing)){
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member = $member_storage->getRowById($mid);

            $shop_storage = new App_Model_Shop_MysqlShopCoreStorage();
            $shop = $shop_storage->getRowById($sid);
            $blessing['m_nickname']   = $member['m_nickname'] ? $member['m_nickname'] : $shop['s_name'];
            $blessing['m_avatar']     = $member['m_avatar'];
            $blessing['abl_name']     = plum_parse_config('defaultName','system');
            $blessing['abl_content']  = plum_parse_config('defaultContent','system');
        }
        if(!$sid){
            if($id && $blessing['abl_s_id']){
                $sid = $blessing['abl_s_id'];
            }elseif ($mid){
                $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
                $member = $member_storage->getRowById($mid);
                $sid = $member['m_s_id'];
            }
        }
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($sid);
        $str = "id=".$id.'&mid='.$mid;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::SHOP_BLESSING_SHARE_PATH, 210,'');
        $this->output['blessing'] = $blessing;
        if($url){
            $qrcode = $url;
        }else{
            if($sid){
                $applet_storoge = new App_Model_Applet_MysqlCfgStorage($sid);
                $appletCfg = $applet_storoge->findShopCfg();
                if($appletCfg && $appletCfg['ac_wxacode']){
                    $qrcode = $appletCfg['ac_wxacode'];
                }
            }

        }
        $this->output['qrcode'] = $qrcode;
        $this->displaySmarty('wxapp/shareposter/blessing-share.tpl');
    }
    /**
     * 付费预约详情分享
     */
    public function ffyyShareAction(){
        $id = $this->request->getIntParam('id');
        $sid = $this->request->getIntParam('sid');
        $appType = $this->request->getIntParam('appType');
        $suid = $this->request->getStrParam('suid');
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $goods = $goods_model->getRowById($id);
        if(!$goods['g_qrcode'] && !file_exists(PLUM_DIR_ROOT.$goods['g_qrcode'])){
            $good_model = new App_Model_Goods_MysqlGoodsStorage($sid);
            $client_plugin  = new App_Plugin_Weixin_WxxcxClient($sid);

            $applet_cfg = new App_Model_Applet_MysqlCfgStorage($sid);
            $appletCfg = $applet_cfg->findShopCfg();

            if($appType == 5){
                $text = plum_parse_config('weixin_index','weixin')[$appletCfg['ac_type']]."?suid={$suid}&appletType=5&share=/Generalreservationdetail?id=".$id;
                $url = $this->_get_qrcode_png_url($text);
            }else{
                $str = "id=".$id;
                if(in_array($appletCfg['ac_type'], [6, 8, 18, 21, 27])){
                    $code_path = $client_plugin::GENERAL_RESERVATION_DETAIL1;
                }else{
                    $code_path = $client_plugin::GENERAL_RESERVATION_DETAIL2;
                }
                $url = $client_plugin->fetchWxappShareCode($str, $code_path, 210, $goods['g_cover']);
            }
//            $str = "id=".$id;
//            if(in_array($appletCfg['ac_type'], [6, 8, 18, 21, 27])){
//                $code_path = $client_plugin::GENERAL_RESERVATION_DETAIL1;
//            }else{
//                $code_path = $client_plugin::GENERAL_RESERVATION_DETAIL2;
//            }
//
//            $url = $client_plugin->fetchWxappShareCode($str, $code_path, 210, $goods['g_cover']);
            $goods['g_qrcode'] = $url;
            $updata = array('g_qrcode'=>$url);
            $good_model->updateById($updata,$id);
        }

        $this->output['goods'] = $goods;
        $this->displaySmarty('wxapp/shareposter/ffyy-share.tpl');
    }
    /**
     * 秒杀及普通商品分享
     */
    public function seckillShareAction(){
        $sid = $this->request->getIntParam('sid');
        $id  = $this->request->getIntParam('id');
        $mid = $this->request->getIntParam('mid');
        $childAppid = $this->request->getStrParam('childAppid');
        $appType = $this->request->getIntParam('appType');
        $suid = $this->request->getStrParam('suid');
        $acType = $this->request->getIntParam('acType');

        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $goods = $goods_model->findGoodsBySidGid($sid,$id);
        $goods['seckill']  = 0;  //不是秒杀

        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($sid);
        $cfg        = $applet_cfg->findShopCfg();


        //获取正在进行中的抢购商品数组
        $laid = 0;
        $act_model  = new App_Model_Limit_MysqlLimitActStorage($sid);
        $act_goods= $act_model->getAllRunningNotBeginActGoods(array(), 0, 50);
        foreach($act_goods as $value){
            if($goods['g_id'] == $value['lg_g_id']){
                $laid = $value['la_id'];
            }
        }


        if($laid>0){
            //获取限时抢购活动
            $limit_buy  = new App_Helper_LimitBuy($sid);
            $limit_act  = $limit_buy->checkLimitAct($goods['g_id'],$laid);

            //未开始的秒杀
            if($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_WAIT){
                $goods['seckill']  = 2;
            }

            //进行中的限时抢购活动
            if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
                $goods['seckill']  = 1;
                //覆盖原有价格
                $limit_price    = floatval($limit_act['lg_yh_price']);
                $goods['g_price']  = $limit_price;
            }
        }

        $code_model = new App_Model_Goods_MysqlGoodsCodeStorage($sid);
        $code = $code_model->getCodeByGidMid($id, $mid, $childAppid,$appType);
        if($code['agc_code'] && file_exists(PLUM_DIR_ROOT.$code['agc_code'])){
            $qrcode = $code['agc_code'];
        }else{
            if($appType == 5){
                $qrcode = $this->_create_new_weixin_qrcode($mid, $sid, $id, $laid, $type='good', $goods['g_cover'],$suid,$acType);
            }else{
                $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
                $member   = $member_storage->getRowById($mid);
                $qrcode = $this->_create_new_qrcode($mid, $sid, $id, $laid, $type='good', $member['m_avatar']?$member['m_avatar']:$goods['g_cover'], $childAppid);
            }
        }

        $this->output['goods'] = $goods;
        $this->output['cfg']   = $cfg;
        $this->output['limitAct'] = $limit_act;
        $this->output['qrcode'] = $qrcode;
        $this->displaySmarty('wxapp/shareposter/seckill-share.tpl');
    }
    /**
     * 商家详情分享海报
     */
    public function shopShareAction(){
        $sid  = $this->request->getIntParam('sid');
        $esId = $this->request->getIntParam('esId');
        $appType = $this->request->getIntParam('appType');
        $suid = $this->request->getStrParam('suid');
        $acType = $this->request->getIntParam('acType');

        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($sid);
        $cfg        = $applet_cfg->findShopCfg();
        $data = array();
        if($cfg['ac_type'] == 6){
            $shop_model = new App_Model_City_MysqlCityShopStorage($sid);
            $shop = $shop_model->findUpdateByEsId($esId);
            $data = array(
                'name'          => $shop['acs_name'],
                'logo'          => $shop['acs_img'],
                'cover'         => $shop['acs_cover'],
                'openTime'      => $shop['acs_open_time'],
                'address'       => $shop['acs_address'],
                'mobile'        => $shop['acs_mobile'],
//                'qrcode'        => $shop['acs_qrcode']
            );

            if($appType == 5){
                if($shop['acs_weixin_qrcode'] && file_exists(PLUM_DIR_ROOT.$shop['acs_weixin_qrcode'])){
                    $data['qrcode'] = $shop['acs_weixin_qrcode'];
                }else{
                    $data['qrcode'] = $this->create_city_shop_weixin_qrcode($shop['acs_id'], $sid, $suid,$acType);
                }
            }else{
                if($shop['acs_qrcode'] && file_exists(PLUM_DIR_ROOT.$shop['acs_qrcode'])){
                    $data['qrcode'] = $shop['acs_qrcode'];
                }else{
                    $data['qrcode'] = $this->create_city_shop_qrcode($shop['acs_id'], $sid);
                }
            }
        }

        if($cfg['ac_type'] == 8){
            $shop_model  = new App_Model_Entershop_MysqlEnterShopStorage($sid);
            $shop     = $shop_model->getRowById($esId);
            $data = array(
                'name'          => $shop['es_name'],
                'logo'          => $shop['es_logo'],
                'openTime'      => ($shop['es_business_time'] ?  $shop['es_business_time'] : '00:00' ).'-'.($shop['es_close_time'] ? $shop['es_close_time'] : '23:59'),
                'address'       => ($shop['es_addr'] ? $shop['es_addr'] : '').($shop['es_addr_detail'] ? $shop['es_addr_detail'] : ''),
                'mobile'        => $shop['es_phone'],
                'qrcode'        => $shop['es_qrcode']
            );
            //todo 公众号

            if(!$data['qrcode'] || !file_exists(PLUM_DIR_ROOT.$shop['acs_qrcode'])){
                $data['qrcode'] = $this->create_community_shop_qrcode($shop['es_id'], $sid);
            }
            $slide_model = new App_Model_Entershop_MysqlEnterShopSlideStorage($esId);
            $slide    = $slide_model->getSlideList();
            if($slide && !empty($slide)){
                $data['cover'] = $slide[0]['ess_path'];
            }
        }

        // 判断店铺当前营销活动
        $data['activityList'] = array();
        //优惠券
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $coupon = $coupon_model->fetchValidList($sid,0,1, array(), $esId);
        $this->output['hasCoupon'] = $coupon?1:0;
        //秒杀
        $act_model  = new App_Model_Limit_MysqlLimitActStorage($sid);
        $limit = $act_model->getAllRunningAct($esId);
        $this->output['hasLimit'] = $limit?1:0;

        //拼团
        $group_model  = new App_Model_Group_MysqlBuyStorage($sid);
        $group = $group_model->getCurrentListByType(1,0,1,0,'', $esId);
        $this->output['hasGroup'] = $group?1:0;

        //砍价
        $timeNow = time();
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($sid);
        $where[] = array('name'=>'ba_s_id','oper'=>'=','value'=> $sid);
        $where[] = array('name'=>'ba_es_id','oper'=>'=','value'=> $esId);
        $where[] = array('name'=>'ba_deleted','oper'=>'=','value'=> 0);
        $where[] = array('name'=>'ba_start_time','oper'=>'<','value'=> $timeNow);
        $where[] = array('name'=>'ba_end_time','oper'=>'>','value'=> $timeNow);
        $bargain = $bargain_model->getActivityList($where,0,1,array());
        $this->output['hasBargain'] = $bargain?1:0;

        //预约
        $cfg_model = new App_Model_Community_MysqlCommunityFreeCfgStorage($sid);
        $free = $cfg_model->findupdateByEsId($esId);

        $this->output['hasFree'] = $free['acfc_open'];

        $this->output['shop'] = $data;

        $this->displaySmarty('wxapp/shareposter/shop-share.tpl');
    }

    private function create_community_shop_qrcode($esId, $sid){
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage($sid);
        $row = $es_model->getRowById($esId);
        $cover = $row['es_logo'];
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($sid);
        $str = "id=".$esId;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::ENTERSHOP_DETAIL_PATH, 430 , $cover);
        if($url){
            $updata = array('es_qrcode' => $url);
            $res = $es_model->updateById($updata,$esId);
            return $url;
        }else{
            return false;
        }
    }

    /**
     * 生成店铺二维码
     */
    private function create_city_shop_qrcode($id, $sid){
        $shop_storage = new App_Model_City_MysqlCityShopStorage($sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($sid);
        $str = "id=".$id;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::CITY_SHOP_CODE_PATH, 430);
        if($url){
            $updata = array('acs_qrcode'=>$url);
            $res = $shop_storage->updateById($updata,$id);
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
     * 预约服务详情分销海报
     */
    public function reservationGoodsShareAction(){
        $gid = $this->request->getIntParam('id',0);
        $sid = $this->request->getIntParam('sid');
        $mid = $this->request->getIntParam('mid');

        $goods_model = new App_Model_Goods_MysqlGoodsStorage($sid);
        $goods = $goods_model->getRowById($gid);

        $this->output['name'] = $goods['g_name'];
        $this->output['cover'] = $goods['g_cover'];
        $this->output['price'] = $goods['g_price'];
        $this->output['unit'] = $goods['g_unit'];
        $this->output['brief'] = $goods['g_brief'];
        $this->output['oldPrice'] = floatval($goods['g_ori_price']);

        //获得小程序配置
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($sid);
        $appletCfg = $applet_cfg->findShopCfg();
        $this->output['appletCfg'] = $appletCfg;
        //获得商品分享二维码
        $qrcode = $this->_get_share_code($mid,$sid,$gid,0,'goods',$goods['g_cover']);
        $this->output['qrcode'] = $qrcode;
        $this->displaySmarty('wxapp/shareposter/reservation-goods-share.tpl',null,null,false);
    }


    /**
     * 教育培训课程海报
     */
    public function courseShareAction(){
        $sid = $this->request->getIntParam('sid');
        $id  = $this->request->getIntParam('id');
        $mid = $this->request->getIntParam('mid');
        $childAppid = $this->request->getStrParam('childAppid');

        $course_storage = new App_Model_Train_MysqlTrainCourseStorage($sid);
        $course = $course_storage->getRowById($id);
        $course['seckill']  = 0;  //不是秒杀

        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($sid);
        $cfg        = $applet_cfg->findShopCfg();

        //获取正在进行中的抢购商品数组
        $laid = 0;
        $act_model  = new App_Model_Limit_MysqlLimitActStorage($sid);
        $act_course= $act_model->getAllRunningNotBeginActCourse(array(), 0, 50);
        foreach($act_course as $value){
            if($course['atc_id'] == $value['atc_id']){
                $laid = $value['la_id'];
            }
        }


        if($laid>0){
            //获取限时抢购活动
            $limit_buy  = new App_Helper_LimitBuy($sid);
            $limit_act  = $limit_buy->checkLimitAct($course['atc_id'],$laid);

            //未开始的秒杀
            if($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_WAIT){
                $course['seckill']  = 2;
            }

            //进行中的限时抢购活动
            if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
                $course['seckill']  = 1;
                //覆盖原有价格
                $limit_price    = floatval($limit_act['lg_yh_price']);
                $course['atc_price']  = $limit_price;
            }
        }

        $code_model = new App_Model_Goods_MysqlGoodsCodeStorage($sid);
        $code = $code_model->getCodeByCidMid($id, $mid, $childAppid);
        if(!$code['agc_code'] || !file_exists(PLUM_DIR_ROOT.$code['agc_code'])) {
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member   = $member_storage->getRowById($mid);
            $qrcode = $this->_create_course_qrcode($mid, $sid, $id, $laid, $member['m_avatar'], $childAppid);
        }else{
            $qrcode = $code['agc_code'];
        }

        $this->output['course'] = $course;
        $this->output['cfg']   = $cfg;
        $this->output['limitAct'] = $limit_act;
        $this->output['qrcode'] = $qrcode;
        $this->displaySmarty('wxapp/shareposter/course-share.tpl');
    }

    /**
     * 生成课程二维码
     * $id : 商品id
     * $uid : 会员id
     * $laid : 秒杀商品id
     * ￥type : 商品类型；good普通商品，seckill秒杀商品，group拼团商品，shop多店
     */
    private function _create_course_qrcode($uid,$sid,$id,$laid=0, $cover, $childAppid=''){
        if($childAppid){
            $client_plugin  = new App_Plugin_Weixin_WxxcxChild($sid, $childAppid);
        }else{
            $client_plugin  = new App_Plugin_Weixin_WxxcxClient($sid);
        }

        $str = "id=".$id.'&laid='.$laid.'&mid='.$uid;
        $url = $client_plugin->fetchWxappShareCode($str, App_Plugin_Weixin_WxxcxClient::COURSE_DETAIL_CODE_PATH, 210, $cover);

        if($url){
            $data = array(
                'agc_s_id' => $sid,
                'agc_course_id' => $id,
                'agc_child_appid' => $childAppid,
                'agc_m_id' => $uid,
                'agc_code' => $url,
                'agc_create_time' => time()
            );
            $code_model = new App_Model_Goods_MysqlGoodsCodeStorage($sid);
            $code_model->insertValue($data);
        }
        return $url;
    }

    /**
     * 会务报名海报
     */
    public function meetingShareAction(){
        $sid = $this->request->getIntParam('sid');
        $id  = $this->request->getIntParam('id');

        $meeting_storage  = new App_Model_Meeting_MysqlMeetingStorage($sid);
        $meeting          = $meeting_storage->getRowById($id);

        if(!$meeting['am_qrcode'] || !file_exists(PLUM_DIR_ROOT.$meeting['am_qrcode'])){
            $meeting['am_qrcode'] = $this->_create_meeting_qrcode($sid, $id);
            $meeting_storage->updateById(array('am_qrcode' => $meeting['am_qrcode']), $id);
        }
        $address_model = new App_Model_Address_MysqlAddressCoreStorage();
        $city = $address_model->getRowById($meeting['am_city']);

        $this->output['meeting'] = $meeting;
        $this->output['city'] = $city['region_name'];
        $this->displaySmarty('wxapp/shareposter/meeting-share.tpl');
    }

    /**
     * 生成会务二维码
     * $id : 会议id
     */
    private function _create_meeting_qrcode($sid, $id){
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($sid);
        $str = "meetId=".$id;
        $url = $client_plugin->fetchWxappShareCode($str, App_Plugin_Weixin_WxxcxClient::MEETING_DETAIL_CODE_PATH, 210);

        return $url;
    }

    /**
     * 拍卖商品分享
     */
    public function auctionShareAction(){
        $sid = $this->request->getIntParam('sid');
        $id  = $this->request->getIntParam('id');

        $auction_model = new App_Model_Auction_MysqlAuctionListStorage($sid);
        $auction = $auction_model->getRowById($id);

        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($sid);
        $cfg        = $applet_cfg->findShopCfg();

        if(!$auction['aal_qrcode'] || !file_exists(PLUM_DIR_ROOT.$auction['aal_qrcode'])){
            $auction['aal_qrcode'] = $this->_create_auction_qrcode($sid, $id);
            $auction_model->updateById(array('aal_qrcode' => $auction['aal_qrcode']), $id);
        }

        $this->output['auction'] = $auction;
        $this->output['cfg']   = $cfg;
        $this->displaySmarty('wxapp/shareposter/auction-share.tpl');
    }

    /**
     * 生成拍卖二维码
     * $id : 会议id
     */
    private function _create_auction_qrcode($sid, $id){
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($sid);
        $str = "id=".$id;
        $url = $client_plugin->fetchWxappShareCode($str, App_Plugin_Weixin_WxxcxClient::AUCTION_DETAIL_CODE_PATH, 210);

        return $url;
    }

    /**
     * 房产专家生成海报
     */
    public function expertShareAction(){
        $sid = $this->request->getIntParam('sid');
        $id  = $this->request->getIntParam('id');

        $experts_storage = new App_Model_House_MysqlHouseExpertsStorage($sid);
        $expert = $experts_storage->getRowById($id);
        $address_model = new App_Model_Address_MysqlAddressCoreStorage();
        $zone = $address_model->getRowById($expert['ahe_zone']);
        $expert['area'] = is_numeric($expert['ahe_zone'])?$zone['region_name']:$expert['ahe_zone'];

        $resources_model = new App_Model_Resources_MysqlResourcesStorage();

        $sale_where = $rent_where = array();
        $sale_where[] = $rent_where[] = array('name' => 'ahr_m_id','oper' => '=','value' =>$expert['ahe_m_id']);
        $sale_where[] = $rent_where[] = array('name' => 'ahr_s_id','oper' => '=','value' =>$sid);
        $sale_where[] = $rent_where[] = array('name' => 'ahr_deleted','oper' => '=','value' =>0);
        $sale_where[] = $rent_where[] = array('name' => 'ahr_sale_type', 'oper' => '=', 'value' => 1);

        $this->output['saleCount'] = $resources_model->getCount($sale_where);
        $this->output['rentCount'] = $resources_model->getCount($rent_where);

        $this->output['expert'] = $expert;
        $this->displaySmarty('wxapp/shareposter/expert-share.tpl');
    }


    /*
     * 社区团购新的分享
     * 首页分享 -多个商品的分享信息
     */
    public function sequenceShareAction(){
        $sid = $this->request->getIntParam('sid');
        $mid = $this->request->getIntParam('mid');

        $cfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($sid);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($sid);
        $cfg = $cfg_model->findUpdateBySid();
        if(!$cfg){
            $cfg = [
                'asc_shareposter_bg' => '/public/wxapp/sequence/images/bg1.png',
                'asc_shareposter_num' => 2,
                'asc_shareposter_add' => 2,
                'asc_shareposter_goods' => []
            ];
        }
        $gids = $cfg['asc_shareposter_goods'] ? json_decode($cfg['asc_shareposter_goods'],1) : [];
        $field = ['g_id','g_name','g_cover','g_price','g_ori_price','g_show_vip','g_vip_price_list','g_has_window','g_date_price','g_has_format'];
        if($cfg['asc_shareposter_add'] == 2 || empty($cfg['asc_shareposter_goods'])){
            $where = [];
            $where[] = ['name'=>'g_s_id','oper'=>'=','value'=>$sid];
            $where[] = ['name'=>'g_is_sale','oper'=>'in','value'=>[1,3]];
            $sort = ['g_is_top' => 'desc','g_weight' => 'DESC', 'g_update_time' => 'DESC',];
            $list = $goods_model->getList($where,0,$cfg['asc_shareposter_num'],$sort,$field);
            $goods_list = $list;
        }else{
            $where = [];
            $where[] = ['name'=>'g_s_id','oper'=>'=','value'=>$sid];
            $where[] = ['name'=>'g_id','oper'=>'in','value'=>$gids?$gids:[0]];
            $list = $goods_model->getList($where,0,$cfg['asc_shareposter_num'],[],$field);
            if($list){
                foreach ($list as $val){
                    $index = array_search($val['g_id'],$gids);
                    $goods_list[$index] = $val;
                }
                ksort($goods_list);
            }
        }
        // 获取商品的最低价格
        // zhangzc
        // 2019-07-31
        $format_model   = new App_Model_Goods_MysqlFormatStorage($sid);
        foreach($goods_list as $key => $item){
            $price_list=[];
            // 新人专享价格 +售价 +会员价
            // 解析会员价
            if($item['g_show_vip']){
                $vip_price=json_decode($item['g_vip_price_list'],TRUE);
                if(empty($vip_price))
                    $vip_price=[];
                else{
                    $vip_price=array_column($vip_price,'price');
                    $price_list= $vip_price;
                }
            }

            array_push($price_list,$item['g_price']);
            // 设置的有新人专享价格的
            if($item['g_date_price'] && $item['g_has_window']==2)
                $price_list[]=$item['g_date_price'];


            // 若规格存在 查询商品规格中最小的值
            if($item['g_has_format']){
                // 规格里面售价的最低价
                $min_format_price=$format_model->getList([
                    ['name'=>'gf_s_id','oper'=>'=','value'=>$sid],
                    ['name'=>'gf_g_id','oper'=>'=','value'=>$item['g_id']]
                ],0,1,['gf_price'=>'ASC'],['gf_price']);
                if($min_format_price[0]['gf_price'])
                    $price_list[]=$min_format_price[0]['gf_price'];

                 // 规格里面新人专享价的最低价
                if($item['g_has_window']==2){
                    $min_format_newmember_price=$format_model->getList([
                        ['name'=>'gf_s_id','oper'=>'=','value'=>$sid],
                        ['name'=>'gf_g_id','oper'=>'=','value'=>$item['g_id']],
                        ['name'=>'gf_newmember_price','oper'=>'>','value'=>0],
                    ],0,1,['gf_newmember_price'=>'ASC'],['gf_newmember_price']);
                    if($min_format_newmember_price[0]['gf_newmember_price'])
                        $price_list[]=$min_format_newmember_price[0]['gf_newmember_price'];
                }
                // 获取规格里面的会员价
                if($item['g_show_vip']){
                    $vip_format_price=$format_model->getList([
                        ['name'=>'gf_s_id','oper'=>'=','value'=>$sid],
                        ['name'=>'gf_g_id','oper'=>'=','value'=>$item['g_id']],
                    ],0,0,[],['gf_vip_price_list']);
                    foreach ($vip_format_price as $vip_format_item) {
                        $vip_format_price_item=json_decode($vip_format_item['gf_vip_price_list'],TRUE);
                        if(empty($vip_format_price_item))
                            $vip_f_price=[];
                        else{
                            $vip_f_price=array_column($vip_format_price_item,'price');
                            $price_list= array_merge($price_list,$vip_f_price);
                        }
                    }
                }
                
            } 

            $price_list=array_filter($price_list);
            $goods_price=min($price_list);
            $goods_list[$key]['g_price']=$goods_price;
        }
        $this->output['goods_list'] = $goods_list;
        $this->output['cfg'] = $cfg;
        $qrcode_info = $this->_get_sequence_shareposter_info($sid,$mid);
        $this->output['qrcode_info'] = $qrcode_info;
        //获得商品分享二维码
        $this->displaySmarty('wxapp/shareposter/sequence-goods-share-new.tpl',null,null,false);
    }

    /*
     * 检查并生成社区团购分享海报二维码及团长信息
     */
    private function _get_sequence_shareposter_info($sid, $mid){
        //获得当前用户选择小区、团长信息
        $extra_model = new App_Model_Member_MysqlMemberExtraStorage($sid);
        $extra = $extra_model->getRowSequence($mid);
        $info = [
            'leader' => $extra['asl_name'] ? $extra['asl_name'] : '',
            'address' => $extra['asc_address'].$extra['asc_address_detail']
        ];
        $qrcode_model = new App_Model_Sequence_MysqlSequenceShareposterQrcodeStorage($sid);
        $qrcode_row = $qrcode_model->findUpdateBySidMid($mid);
        if($qrcode_row){
            //存在二维码
//            if($qrcode_row['assq_leader_id'] == $extra['asl_id'] && $qrcode_row['assq_qrcode']){
//                //原二维码团长与当前一直 直接返回
//                $url = $qrcode_row['assq_qrcode'];
//            }
            if(file_exists(PLUM_DIR_ROOT.$qrcode_row['assq_qrcode'])){
                //直接返回
                $url = $qrcode_row['assq_qrcode'];
            }else{
                $client_plugin  = new App_Plugin_Weixin_WxxcxClient($sid);
                $str = "mid=".$mid;
                $url = $client_plugin->fetchWxappShareCode($str, 'pages/index/index', 210);
                $updata = array('assq_qrcode'=>$url);
                $qrcode_model->findUpdateBySidMid($mid,$updata);
            }
        }else{
            $client_plugin  = new App_Plugin_Weixin_WxxcxClient($sid);
            $str = "mid=".$mid;
            $url = $client_plugin->fetchWxappShareCode($str, 'pages/index/index', 210);
            $insert = [
                'assq_s_id' => $sid,
                'assq_m_id' => $mid,
                'assq_qrcode' => $url,
                'assq_create_time' => time()
            ];
            $qrcode_model->insertValue($insert);

        }
        $info['qrcode'] = $url;
        return $info;

    }


    //************************微信二维码相关******************

    /**
     * 生成店铺微信公众号二维码
     */
    private function create_city_shop_weixin_qrcode($id, $sid, $suid, $acType){
        $shop_storage = new App_Model_City_MysqlCityShopStorage($sid);
        $text = plum_parse_config('weixin_index','weixin')[$acType]."?suid={$suid}&appletType=5&share=/ShopDetailnew?id=".$id;
        $url = $this->_get_qrcode_png_url($text);
        if($url){
            $updata = array('acs_weixin_qrcode'=>$url);
            $res = $shop_storage->updateById($updata,$id);
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
     * 生成商品二维码
     * $id : 商品id
     * $uid : 会员id
     * $laid : 秒杀商品id
     * ￥type : 商品类型；good普通商品，seckill秒杀商品，group拼团商品，shop多店
     */
    private function _create_new_weixin_qrcode($uid,$sid,$id,$laid=0,$type='good', $cover,$suid,$acType){

        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($sid);
        if($type && $type=='shop'){
            $text = $text = plum_parse_config('weixin_index','weixin')[$acType]."?suid={$suid}&appletType=5&share=/ShopgoodsDetail?id={$id}&mid={$uid}";
        }else{
            $text = $text = plum_parse_config('weixin_index','weixin')[$acType]."?suid={$suid}&appletType=5&share=/GoodDetail?id={$id}&mid={$uid}&laid={$laid}";

        }
        $url = $this->_get_qrcode_png_url($text);
        if($url){
            $data = array(
                'agc_s_id' => $sid,
                'agc_g_id' => $id,
                'agc_m_id' => $uid,
                'agc_code' => $url,
                'agc_app_type' => 5,
                'agc_create_time' => time()
            );
            $code_model = new App_Model_Goods_MysqlGoodsCodeStorage($sid);
            $code_model->insertValue($data);
        }
        return $url;
    }

    /**
     * 生成店铺微信公众号二维码
     */
    private function create_city_post_weixin_qrcode($id, $sid, $suid, $acType){
        $shop_storage = new App_Model_City_MysqlCityPostStorage($sid);
        $text = plum_parse_config('weixin_index','weixin')[$acType]."?suid={$suid}&appletType=5&share=/PostDetail?pid=".$id;
        $url = $this->_get_qrcode_png_url($text);
        if($url){
            $updata = array('acp_weixin_qrcode'=>$url);
            $res = $shop_storage->updateById($updata,$id);
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
    * 酒店版首页分享海报
    * 首页分享 -多个房间的分享信息
    */
    public function hotelShareAction(){
        $sid = $this->request->getIntParam('sid');
        $mid = $this->request->getIntParam('mid');

        $cfg_model = new App_Model_Hotel_MysqlHotelCfgStorage($sid);
        $applet_model = new App_Model_Applet_MysqlCfgStorage($sid);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($sid);
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop = $shop_model->getRowById($sid);
        $cfg = $cfg_model->findUpdateBySid();
        $applet_cfg = $applet_model->findShopCfg();
        if(!$cfg){
            $cfg = [
                'ahc_shareposter_bg' => '/public/wxapp/hotel/images/bg1.png',
                'ahc_shareposter_num' => 2,
                'ahc_shareposter_add' => 2,
                'ahc_shareposter_goods' => []
            ];
        }
        $cfg['ahc_shareposter_num'] = 2; //目前只有这一种样式


        $gids = $cfg['ahc_shareposter_goods'] ? json_decode($cfg['ahc_shareposter_goods'],1) : [];
        $field = ['g_id','g_name','g_cover','g_price','g_ori_price','g_show_vip','g_vip_price_list','g_has_window','g_date_price','g_has_format'];
        if($cfg['ahc_shareposter_add'] == 2 || empty($cfg['ahc_shareposter_goods'])){
            $where = [];
            $where[] = ['name'=>'g_s_id','oper'=>'=','value'=>$sid];
            $where[] = ['name'=>'g_independent_mall','oper'=>'=','value'=>0];
//            $where[] = ['name'=>'g_is_sale','oper'=>'in','value'=>[1,3]];
            $sort = ['g_is_top' => 'desc','g_weight' => 'DESC', 'g_update_time' => 'DESC',];
            $list = $goods_model->getList($where,0,$cfg['ahc_shareposter_num'],$sort,$field);
            $goods_list = $list;
        }else{
            $where = [];
            $where[] = ['name'=>'g_s_id','oper'=>'=','value'=>$sid];
            $where[] = ['name'=>'g_id','oper'=>'in','value'=>$gids?$gids:[0]];
            $list = $goods_model->getList($where,0,$cfg['ahc_shareposter_num'],[],$field);
            if($list){
                foreach ($list as $val){
                    $index = array_search($val['g_id'],$gids);
                    $goods_list[$index] = $val;
                }
                ksort($goods_list);
            }
        }
        // 获取商品的最低价格
        $format_model   = new App_Model_Goods_MysqlFormatStorage($sid);
        foreach($goods_list as $key => $item){
            $price_list=[];
            // 新人专享价格 +售价 +会员价
            // 解析会员价
            if($item['g_show_vip']){
                $vip_price=json_decode($item['g_vip_price_list'],TRUE);
                if(empty($vip_price))
                    $vip_price=[];
                else{
                    $vip_price=array_column($vip_price,'price');
                    $price_list= $vip_price;
                }
            }

            array_push($price_list,$item['g_price']);
            // 设置的有新人专享价格的
            if($item['g_date_price'] && $item['g_has_window']==2){
                $price_list[]=$item['g_date_price'];
            }

            // 若规格存在 查询商品规格中最小的值
            if($item['g_has_format']){
                // 规格里面售价的最低价
                $min_format_price=$format_model->getList([
                    ['name'=>'gf_s_id','oper'=>'=','value'=>$sid],
                    ['name'=>'gf_g_id','oper'=>'=','value'=>$item['g_id']]
                ],0,1,['gf_price'=>'ASC'],['gf_price']);
                if($min_format_price[0]['gf_price']){
                    $price_list[]=$min_format_price[0]['gf_price'];
                }

                // 获取规格里面的会员价
                if($item['g_show_vip']){
                    $vip_format_price=$format_model->getList([
                        ['name'=>'gf_s_id','oper'=>'=','value'=>$sid],
                        ['name'=>'gf_g_id','oper'=>'=','value'=>$item['g_id']],
                    ],0,0,[],['gf_vip_price_list']);
                    foreach ($vip_format_price as $vip_format_item) {
                        $vip_format_price_item=json_decode($vip_format_item['gf_vip_price_list'],TRUE);
                        if(empty($vip_format_price_item))
                            $vip_f_price=[];
                        else{
                            $vip_f_price=array_column($vip_format_price_item,'price');
                            $price_list= array_merge($price_list,$vip_f_price);
                        }
                    }
                }

            }

            $price_list=array_filter($price_list);
            $goods_price=min($price_list);
            $goods_list[$key]['g_price']=$goods_price;

            $goods_list[$key]['img_flag'] = $key+1;

        }
        $this->output['goods_list'] = $goods_list;
//        $this->output['goods_list_json'] = json_encode($goods_list);
        $this->output['cfg'] = $cfg;
        $this->output['phone'] = $shop['s_phone'];
        $this->output['qrcode'] = $applet_cfg['ac_qrcode'];
        $this->output['title'] = $applet_cfg['ac_name'];
        //获得商品分享二维码
        $this->displaySmarty('wxapp/shareposter/hotel-room-share.tpl',null,null,false);
    }


}