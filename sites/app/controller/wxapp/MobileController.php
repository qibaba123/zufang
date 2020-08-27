<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2018/3/12
 * Time: 17:25
 */

class App_Controller_Wxapp_MobileController extends App_Controller_Wxapp_InitController{

    const PROMOTION_TOOL_KEY    = 'dhb';
    public function __construct()
    {
        parent::__construct();
        // $this->checkToolUsable(self::PROMOTION_TOOL_KEY);
    }

    /**
     * @param string $type
     * 自定义二级链接，根据类型，确定默认选中
     */
    public function secondLink($type='index'){
        $link = array(
            array(
                'label' => '首页配置',
                'link'  => '/wxapp/mobile/index',
                'active'=> 'index'
            ),
            array(
                'label' => '分类列表',
                'link'  => '/wxapp/mobile/categoryList',
                'active'=> 'category'
            ),
            array(
                'label' => '入驻时间设置',
                'link'  => '/wxapp/mobile/applySet',
                'active'=> 'set'
            ),
            array(
                'label' => '入驻店铺',
                'link'  => '/wxapp/mobile/shopList',
                'active'=> 'list'
            ),
            array(
                'label' => '报错信息',
                'link'  => '/wxapp/mobile/errorList',
                'active'=> 'error'
            ),
            /*array(
                'label' => '认领申请',
                'link'  => '/wxapp/mobile/claimList',
                'active'=> 'claim'
            ),*/
        );
        $this->output['secondLink']       = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '电话本';
    }

    /*
    * 电话本分类列表
    */
    public function categoryListAction(){
        $this->secondLink('category');
        $this->buildBreadcrumbs(array(
            array('title' => '电话本管理', 'link' => '#'),
            array('title' => '分类管理', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->_get_category_list();
        $this->displaySmarty("wxapp/mobile/mobile-category-list.tpl");
    }


    private function _get_category_list(){
        $where = array();
        $where[] = array('name' => 'amc_s_id','oper' => '=','value' =>$this->curr_sid);
        $output['name']     = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'amc_title','oper' => 'like','value' =>"%{$output['name']}%");
        }
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $amc_model = new App_Model_Mobile_MysqlMobileShopCategoryStorage($this->curr_sid);
        $total = $amc_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index < $total){
            $sort = array('amc_create_time' => 'DESC');
            $list = $amc_model->getList($where,$index,$this->count,$sort);
            foreach ($list as &$val){
                $val['amc_label'] = json_decode($val['amc_label'],1);
                $val['amc_label'] = json_encode($val['amc_label'],JSON_UNESCAPED_UNICODE);
            }
        }
        $output['list'] = $list;
        $this->showOutput($output);
    }

    /*
     * 获得电话本分类
     */
    private function _get_category_list_select($return = false){
        $where = [];
        $where[] = array('name' => 'amc_s_id','oper' => '=','value' =>$this->curr_sid);
        $sort = ['amc_create_time' => 'desc'];
        $amc_model = new App_Model_Mobile_MysqlMobileShopCategoryStorage($this->curr_sid);
        $list = $amc_model->getList($where,0,0,$sort);
        $data = [];
        if($list){
            foreach ($list as $val){
                $data[$val['amc_id']] = [
                    'title' => $val['amc_title'],
                    'id' => $val['amc_id']
                ];
            }
        }
        if($return){
            return $data;
        }else{
            $this->output['categorySelect'] = $data;
        }
    }

    /**
     * 删除电话本分类
     */
    public function deleteCategoryAction(){
        $id  = $this->request->getIntParam('id');
        $amc_model = new App_Model_Mobile_MysqlMobileShopCategoryStorage($this->curr_sid);
        $row = $amc_model->getRowById($id);
        $ret = $amc_model->deleteDFById($id);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("电话本分类【{$row['amc_title']}】删除成功");
        }

        $this->showAjaxResult($ret,'删除');
    }


    /*
     * 新增电话本分类
     */
//    public function addAction(){
//        $id  = $this->request->getIntParam('id');
//        $labelList = array();
//        if($id){
//            $amc_model = new App_Model_Mobile_MysqlMobileShopCategoryStorage($this->curr_sid);
//            $row = $amc_model->getRowById($id);
//            $label = json_decode($row['amc_label'],1);
//
//            foreach ($label as $key => $val){
//                $labelList[] = array(
//                'index' => $key,
//                'name'  => $val
//                );
//            }
//            $this->output['row'] = $row;
//        }
//
//
//        $this->renderCropTool('/wxapp/index/uploadImg');
//        $this->buildBreadcrumbs(array(
//            array('title' => '类型管理', 'link' => '/wxapp/mobile/index'),
//            array('title' => '类型添加/编辑', 'link' => '#')
//        ));
//        $this->output['labelList'] = json_encode($labelList);
//        $this->displaySmarty('wxapp/mobile/mobile-category-add.tpl');
//
//  }

  /*
   * 保存电话本分类
   */
  public function saveCategoryAction(){
    $id    = $this->request->getIntParam('id',0);
    $title = $this->request->getStrParam('name','');
    $img   = $this->request->getStrParam('logo','');
    $sort  = $this->request->getIntParam('sort',0);
    $label = $this->request->getArrParam('label',array());

    $updata = array(
      'amc_s_id'    => $this->curr_sid,
      'amc_title'   => $title,
      'amc_img'     => $img,
      'amc_sort'    => $sort,
      'amc_label'   => json_encode($label),
      'amc_update_time' => $_SERVER['REQUEST_TIME']
    );

    $amc_model = new App_Model_Mobile_MysqlMobileShopCategoryStorage($this->curr_sid);

    if($id){
      $res = $amc_model->updateById($updata,$id);
    }else{
      $updata['amc_create_time'] = $_SERVER['REQUEST_TIME'];
      $res = $amc_model->insertValue($updata);
    }

      if($res){
          App_Helper_OperateLog::saveOperateLog("电话本分类【{$updata['amc_title']}】保存成功");
      }

    $this->showAjaxResult($res,'保存');

  }


   /**
   * 入驻费用配置
   */
    public function applySetAction(){
        $this->secondLink('set');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $cost_storage = new App_Model_Mobile_MysqlMobileApplyCostStorage($this->curr_sid);
        $where   = array();
        $where[] = array('name' => 'mac_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort = array('mac_data' => 'ASC');
        $total      = $cost_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $list = $cost_storage->getList($where, $index, $this->count, $sort);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '电话本管理', 'link' => '#'),
            array('title' => '入驻收费配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/mobile/mobile-apply-setting.tpl');
    }

  /**
   * 保存入驻费用
   */
  public function saveApplySetAction(){
    $date       = $this->request->getIntParam('date');
    $cost       = $this->request->getFloatParam('cost');
    $id         = $this->request->getIntParam('id');
    $cost_storage = new App_Model_Mobile_MysqlMobileApplyCostStorage($this->curr_sid);

    $data = array(
      'mac_s_id'        => $this->curr_sid,
      'mac_data'        => $date,
      'mac_cost'        => $cost,
      'mac_update_time' => time(),
    );
    if($id){
        $ret = $cost_storage->updateById($data,$id);
    }else{
        $ret = $cost_storage->insertValue($data);
    }

      if($ret){
          App_Helper_OperateLog::saveOperateLog("电话本入驻费用配置保存成功");
      }

    $this->showAjaxResult($ret,'保存');
  }

  /**
   * 删除收费配置
   */
  public function deleteApplySetAction(){
      $id  = $this->request->getIntParam('id');
          $mac_model = new App_Model_Mobile_MysqlMobileApplyCostStorage($this->curr_sid);
      $ret = $mac_model->deleteById($id);
      if($ret){
          App_Helper_OperateLog::saveOperateLog("电话本入驻费用配置删除成功");
      }
      $this->showAjaxResult($ret,'删除');
  }

  /*
   * 电话本首页配置
   */
   public function indexAction(){
       $this->secondLink('index');
      //首页基本配置
      $index_storage = new App_Model_Mobile_MysqlMobileIndexStorage($this->curr_sid);
      $row = $index_storage->findUpdateBySid();
      if($row){
          $this->output['slide'] = $row['ami_index_slide'];
      }else{
          $row['ami_title'] = '电话本';
          $row['ami_ischarge'] = '0';
          $row['ami_show_search'] = 1;
          $row['ami_show_alert'] = 1;
          // $this->output['slide'] = json_encode(array());
          $this->output['slide'] = '';
      }

      $showHide = 0;
      if(in_array($this->wxapp_cfg['ac_type'],[3])){
          $showHide = 1;
      }
      $this->output['showHide'] = $showHide;

      $this->output['row'] = $row;
      $this->renderCropTool('/wxapp/index/uploadImg');
       $this->buildBreadcrumbs(array(
           array('title' => '电话本设置', 'link' => '#'),
       ));
      $this->displaySmarty('wxapp/mobile/mobile-index.tpl');
   }

  /*
   * 保存电话本首页配置
   */
    public function saveMobileIndexAction(){
        $title     = $this->request->getStrParam('title');
        $shopNum   = $this->request->getIntParam('shopNum');
        $browseNum = $this->request->getIntParam('browseNum');
        $ischarge  = $this->request->getIntParam('ischarge');
        $slide = $this->request->getArrParam('slide');
        $agreement = $this->request->getStrParam('agreement');

        $searchShow  = $this->request->getIntParam('searchShow');
        $alertShow  = $this->request->getIntParam('alertShow');

        $index_storage = new App_Model_Mobile_MysqlMobileIndexStorage($this->curr_sid);
        $row = $index_storage->findUpdateBySid();
        $data = array(
            'ami_shop_num' => $shopNum,
            'ami_browse_num' => $browseNum,
            'ami_index_title' => $title,
            'ami_ischarge'    => $ischarge,
            'ami_index_slide' => json_encode($slide),
            'ami_agreement'   => $agreement,
            'ami_show_search' => $searchShow,
            'ami_show_alert'  => $alertShow
        );

        if($row){
//            if($shopNum){
//                $data['ami_shop_num'] = $row['ami_shop_num'] + $shopNum;
//            }
//            if($browseNum){
//                $data['ami_browse_num'] = $row['ami_browse_num'] + $browseNum;
//            }
            if($slide){
                $data['ami_index_slide'] = json_encode($slide);
            }
            $ret = $index_storage->findUpdateBySid($data);
        }else{
//            if($shopNum){
//                $data['ami_shop_num'] = $shopNum;
//            }
//            if($browseNum){
//                $data['ami_browse_num'] = $browseNum;
//            }
            $data['ami_s_id'] = $this->curr_sid;
            $data['ami_create_time'] = time();
            $ret = $index_storage->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("电话本首页配置保存成功");
        }

        $this->showAjaxResult($ret);
    }

    /*
     * 入驻店铺列表
     */
    public function shopListAction(){
        $this->secondLink('list');
        /* $test= $this->request->getIntParam('test');
        if($test==1){
            $this->output['test'] = $test;
        }*/
        $this->buildBreadcrumbs(array(
            array('title' => '电话本管理', 'link' => '#'),
            array('title' => '入驻店铺管理', 'link' => '#'),
        ));
        $this->output['appletCfg'] = $this->wxapp_cfg;
        $this->_get_shop_list();
        $this->_get_category_list_select();
        $this->displaySmarty("wxapp/mobile/mobile-shop-list.tpl");
    }
    /*
     * 获得会员option html
     */
    private function _get_member_option_html(){


    }
    public function ajaxGetMemberAction(){
         $page = $this->request->getIntParam('page',0);
         $count = 10;
         $index = $page * $count;
         $member_model = new App_Model_Member_MysqlMemberCoreStorage();
         $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
         $sort  = array('m_follow_time' => 'DESC');//关注时间倒序排列
         $list = $member_model->getList($where,$index,$count,$sort);
         $result = [];
         if($list){
             foreach ($list as $val){
                 $result[] = array(
                    'id'    => $val['m_id'],
                     'name' => $val['m_nickname']
                 );
             }
         }
         return json_encode($result);
    }

    //入驻店铺列表信息
    private function _get_shop_list(){
        $where = array();
        $where[] = array('name' => 'ams_s_id','oper' => '=','value' =>$this->curr_sid);
        $output['name']     = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'ams_name','oper' => 'like','value' =>"%{$output['name']}%");
        }

        $output['name']     = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'ams_name','oper' => 'like','value' =>"%{$output['name']}%");
        }

        $output['category']     = $this->request->getIntParam('category');
        if($output['category']){
            $where[] = array('name' => 'ams_cate_id','oper' => '=','value' =>$output['category']);
        }
        $output['status'] = $this->request->getIntParam('status');
        $output['statusNote'] = [
            1 => '未到期',
            2 => '已到期',
            3 => '已通过',
            4 => '待审核',
            5 => '已拒绝'
        ];

        if($output['status']){
            switch ($output['status']){
                case 1:
                    $where[] = array('name' => 'ams_status','oper' => '=','value' =>2);
                    $where[] = array('name' => 'ams_expire_time','oper' => '>','value' =>time());
                    break;
                case 2:
                    $where[] = array('name' => 'ams_status','oper' => '=','value' =>2);
                    $where[] = array('name' => 'ams_expire_time','oper' => '<','value' =>time());
                    break;
                case 3:
                    $where[] = array('name' => 'ams_status','oper' => '=','value' =>2);
                    break;
                case 4:
                    $where[] = array('name' => 'ams_status','oper' => '=','value' =>1);
                    break;
                case 5:
                    $where[] = array('name' => 'ams_status','oper' => '=','value' =>3);
                    break;

            }
        }

        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $amc_model = new App_Model_Mobile_MysqlMobileShopApplyStorage($this->curr_sid);
        $total = $amc_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index < $total){
            $sort = array('ams_create_time' => 'DESC');
            $list = $amc_model->fetchListMember($where,$index,$this->count,$sort);
        }
        $cate_model = new App_Model_Mobile_MysqlMobileShopCategoryStorage($this->curr_sid);
        $output['cate'] = $cate_model->fetchCategoryListForSelect();
        $output['list'] = $list;
        $test1 = $this->request->getIntParam('test1');
        if($test1 ==1){
           plum_msg_dump($list);die();
        }

        //获取统计信息
        $where = array();
        $where[] = array('name' => 'ams_s_id','oper' => '=','value' =>$this->curr_sid);
        $total = $amc_model->getCount($where);  //店铺总数量
        $where[] = array('name' => 'ams_status', 'oper' => '=', 'value' => 1);
        $total_dsh = $amc_model->getCount($where);  //待审核
        $where[1] = array('name' => 'ams_status', 'oper' => '=', 'value' => 2);
        $total_ytg = $amc_model->getCount($where);  //已通过
        $where[1] = array('name' => 'ams_m_id', 'oper' => '=', 'value' => 0);
        $total_httj = $amc_model->getCount($where);  //后台添加
        $where[1] = array('name' => 'ams_expire_time', 'oper' => '<', 'value' => time());
        $total_ydq = $amc_model->getCount($where);  //已到期
        $cost_storage = new App_Model_Mobile_MysqlMobileApplyPayStorage($this->curr_sid);
        $where   = array();
        $where[] = array('name' => 'msp_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $total_zsy = $cost_storage->getMoneyCount($where);

        if($_GET['test'] == 1){
            plum_msg_dump($total_zsy,0);
        }

        $output['statInfo'] = [
            'total'     => $total,      //店铺总数量
            'total_zsy' => $total_zsy,  //总收益
            'total_dsh' => $total_dsh,  //待审核
            'total_ytg' => $total_ytg,  //已通过
            'total_httj'=> $total_httj, //后台添加
            'total_ydq'=> $total_ydq    //已到期
        ];
        $this->showOutput($output);
    }

    /**
     * 统计订单信息
     */
    private function _show_order_stat($where=[],$today = true){
        if($today){
            $time = strtotime(date('Y-m-d',time())); // 获取今天0点的时间
            $where[] = array('name'=>'t_create_time','oper'=>'>=','value'=>$time);
        }
        $where[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'t_status','oper'=>'>','value'=>0);
        $where[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));  //获取已付款,已发货,确认收货,已完成的订单,
        $where[] = array('name' => 't_status', 'oper' => '!=', 'value' => App_Helper_Trade::TRADE_CLOSED);
        $where[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        $order_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        return $order_model->statOrderStatistic($where);
    }

  /**
   * 删除入驻门店
   */
    public function deleteShopAction(){
        $id  = $this->request->getIntParam('id');
        $amc_model = new App_Model_Mobile_MysqlMobileShopApplyStorage($this->curr_sid);
        $row = $amc_model->getRowById($id);
        $ret = $amc_model->deleteDFById($id);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("电话本入驻店铺【{$row['ams_name']}】删除成功");
        }

        $this->showAjaxResult($ret,'删除');
    }

    /*
     * 修改到期时间
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
                'ams_expire_time' =>  $expireNow + $expireTime
            );
            $shop_model = new App_Model_Mobile_MysqlMobileShopApplyStorage($this->curr_sid);
            $res = $shop_model->updateById($data,$id);
            if($res){
                $result = array(
                    'ec' => 200,
                    'em' => '修改成功'
                );
                $row = $shop_model->getRowById($id);
                App_Helper_OperateLog::saveOperateLog("电话本入驻店铺【{$row['ams_name']}】修改到期时间成功");
            }
        }else{
            $result = array(
            'ec' => 400,
            'em' => '请填写正确的时间'
            );
        }
        $this->displayJson($result);
    }

    /*
     * 报错记录管理
     */
    public function errorListAction(){
        $this->secondLink('error');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where[] = array('name'=>'mse_s_id','oper'=>'=','value'=>$this->curr_sid);
        $apply_storage = new App_Model_Mobile_MysqlMobileShopErrorStorage($this->curr_sid);
        $total      = $apply_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $sort  = array('mse_time' => 'DESC');
            $list   = $apply_storage->getReportMemberList($where,$index,$this->count,$sort);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '电话本管理', 'link' => '#'),
            array('title' => '报错信息管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/mobile/mobile-error-list.tpl');
    }

    /**
     * 删除报错信息记录
     */
    public function deleteErrorAction(){
        $id  = $this->request->getIntParam('id');
        $mse_model = new App_Model_Mobile_MysqlMobileShopErrorStorage($this->curr_sid);
        $ret = $mse_model->deleteById($id);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("电话本报错记录删除成功");
        }

        $this->showAjaxResult($ret,'删除');
    }


    /*
     * 查看/编辑入驻店铺信息
     */
    public function shopEditAction(){
        $this->secondLink('list');
        $id     = $this->request->getIntParam('id');
        $row    = array();
        if($id){
            $shop_model = new App_Model_Mobile_MysqlMobileShopApplyStorage($this->curr_sid);
            $row         = $shop_model->getRowByIdSid($id,$this->curr_sid);
        }
        //获得分类
        $shortcut_model      = new App_Model_Mobile_MysqlMobileShopCategoryStorage($this->curr_sid);
        $category            = $shortcut_model->fetchShortcutShowList();
        $this->output['category_select'] = $category;
        //获得收费配置
        $cost_model          = new App_Model_Mobile_MysqlMobileApplyCostStorage($this->curr_sid);
        $costList            = $cost_model->findListBySid();
        $this->output['costList'] = $costList;
        $this->output['row'] = $row;
        $this->output['imgs'] = json_decode($row['ams_cover'],1);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '电话本管理', 'link' => '#'),
            array('title' => '入驻店铺管理', 'link' => '/wxapp/mobile/shopList'),
            array('title' => '编辑/新增店铺信息', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/mobile/mobile-shop-edit.tpl");

    }

    /*
     * 保存入驻店铺信息
     */
    public function saveShopEditAction(){
        $id = $this->request->getIntParam('id',0);
        $name = $this->request->getStrParam('name');
        $address = $this->request->getStrParam('addr');
        $detail  = $this->request->getStrParam('addr_detail');
        $logo      = $this->request->getStrParam('logo');
        $content   = $this->request->getStrParam('content');
        $openTime  = $this->request->getStrParam('open_time');
        $closeTime = $this->request->getStrParam('close_time');
        $contact   = $this->request->getStrParam('contact');
        $mobile    = $this->request->getStrParam('mobile');
        $wxcode    = $this->request->getStrParam('wxcode');
        $lng       = $this->request->getStrParam('lng');
        $lat       = $this->request->getStrParam('lat');
        $cate      = $this->request->getIntParam('category');
        $imgArr    = $this->request->getArrParam('imgArr');
        $date      = $this->request->getIntParam('date');
        $management = $this->request->getStrParam('management');
        $video_url  = $this->request->getStrParam('video_url');
        $video_type = $this->request->getIntParam('video_type');
        $istop      = $this->request->getIntParam('istop');
        $data = array(
                'ams_name'          => $name,
                'ams_contacts'      => $contact,
                'ams_mobile'        => $mobile,
                'ams_content'       => $content,
                'ams_address'       => $address,
                'ams_addr_detail'   => $detail,
                'ams_logo'          => $logo,
                'ams_open_time'     => $openTime,
                'ams_close_time'    => $closeTime,
                'ams_wxcode'        => $wxcode,
                'ams_lng'           => $lng,
                'ams_lat'           => $lat,
                'ams_cate_id'       => $cate,
                'ams_management'    => $management,
                'ams_cover'         => json_encode($imgArr),
                'ams_update_time'   => time(),
                'ams_video_url'     => $video_url,
                'ams_video_type'    => $video_type,
                'ams_top'           => $istop
        );
        $shop_model = new App_Model_Mobile_MysqlMobileShopApplyStorage($this->curr_sid);
        if($id){
            $res = $shop_model->updateById($data,$id);
        }else{
            $data['ams_s_id']   = $this->curr_sid;
            $data['ams_status'] = 2; //新添加默认通过
            $data['ams_create_time'] = time();
            $data['ams_expire_time'] = time() + $date * 30 * 86400;
            $res = $shop_model->insertValue($data);
        }
        if($res){
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("电话本入驻店铺【{$name}】保存成功");
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '保存失败'
                );
            }
        $this->displayJson($result);
    }

    /*
     * 入驻店铺付费记录
     */
    public function shopPayRecordAction(){
        $this->secondLink('list');
        $id   = $this->request->getIntParam('id');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $cost_storage = new App_Model_Mobile_MysqlMobileApplyPayStorage($this->curr_sid);
        $where   = array();
        $where[] = array('name' => 'msp_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'msp_ams_id', 'oper' => '=', 'value' => $id);
        $sort = array('msp_create_time' => 'DESC');
        $total      = $cost_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $list = $cost_storage->getList($where, $index, $this->count, $sort);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '电话本管理', 'link' => '#'),
            array('title' => '入驻店铺管理', 'link' => '/wxapp/mobile/shopList'),
            array('title' => '付费记录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/mobile/shop-pay-record.tpl');
    }

    /*
     * 修改电话本所属会员
     */
    public function changeBelongAction(){
        $id = $this->request->getIntParam('id');
        $mid = $this->request->getIntParam('mid');

        $res = FALSE;
        if($id && $mid){
            $shop_model = new App_Model_Mobile_MysqlMobileShopApplyStorage($this->curr_sid);
            $where_row[] = array('name' => 'ams_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where_row[] = array('name' => 'ams_m_id', 'oper' => '=', 'value' => $mid);
            $row = $shop_model->getRow($where_row);
            if($row){
                $this->displayJsonError('该会员已入驻');
            }
            $set = array(
                'ams_m_id' => $mid
            );
            $where[] = array('name' => 'ams_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'ams_id', 'oper' => '=', 'value' => $id);
            $res = $shop_model->updateValue($set,$where);

            if($res){
                $shop = $shop_model->getRowById($id);
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member = $member_model->getRowById($id);
                App_Helper_OperateLog::saveOperateLog("电话本入驻店铺【{$shop['ams_name']}】修改所属用户【{$member['m_nickname']}】成功");
            }
        }
        $this->showAjaxResult($res,'修改');
    }

    /**
     * 处理商家申请入驻信息
     */
    public function handleApplyAction(){
        $id = $this->request->getIntParam('id');
        $market = $this->request->getStrParam('market');
        $status = $this->request->getIntParam('status');

        if($id){
            $updata = array(
                'ams_handle_remark' => $market,
                'ams_status'        => $status?$status:2,
                'ams_handle_time'   => time()
            );
//            $apply_storage = new App_Model_City_MysqlCityShopApplyStorage($this->curr_sid);
            $apply_storage = new App_Model_Mobile_MysqlMobileShopApplyStorage($this->curr_sid);
            $ret = $apply_storage->updateById($updata,$id);
            if($status && $status == 2 && $ret){
//                $this->_copy_shop_info_2_city_shop($id);
                $this->_deal_shop_pass($id);
            }
            // 电话本入驻审核通知
            $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
            $appletType = $appletType ? $appletType : 0;

            plum_open_backend('templmsg', 'mobileAuditTempl', array('sid' => $this->curr_sid, 'id' => $id,'appletType' => $appletType));

            if($ret){
                $str = $status == 2 ? '通过' : '不通过';
                $shop = $apply_storage->getRowById($id);
                App_Helper_OperateLog::saveOperateLog("电话本入驻申请【{$shop['ams_name']}】处理成功，处理结果：{$str}");
            }

            $this->showAjaxResult($ret,'处理');
        }else{
            $this->displayJsonError('处理失败，请稍后重试');
        }
    }

    /**
     * 审核通过 以当前时间为基准记录店铺过期时间
     */
    private function _deal_shop_pass($id){
        $apply_storage = new App_Model_Mobile_MysqlMobileShopApplyStorage($this->curr_sid);
        $row = $apply_storage->getRowById($id);
        $dateLong = $row['ams_first_date'];
        if(!$row['ams_expire_time']) {
            //通过并且是首次处理,计算到期时间
            if ($dateLong) {
                if ($dateLong >= 12) {
                    $expireTime = intval(floor($dateLong / 12)) * 365 * 86400 + intval(($dateLong % 12)) * 30 * 86400;
                }
                else {
                    $expireTime = $dateLong * 30 * 86400;
                }
                $date = time() + $expireTime;
            }
            else {
                //防止添加时间收费之前的申请在通过后无法显示
                $date = time() + (365 * 86400);
            }
            $apply_storage->updateById(array('ams_expire_time'=>$date),$id);
            //增加店铺的数量
            $this->_statistics('shop', 1);
        }

    }

    /**
     * @param $type 统计类型  type=browse 浏览量  type=shop 商家
     * @param $num  数量
     */
    private function _statistics($type, $num){
        //获取配置信息
        $index_storage = new App_Model_Mobile_MysqlMobileIndexStorage($this->curr_sid);
        $row = $index_storage->findUpdateBySid();
        $data = array();
        if($type == 'browse'){
            $data['ami_browse_num'] = $row['ami_browse_num'] + $num;
        }
        if($type == 'shop'){
           $data['ami_shop_num'] = $row['ami_shop_num'] + $num;
        }

        if($row){
            $ret = $index_storage->findUpdateBySid($data);
        }else{
            $data['ami_s_id'] = $this->curr_sid;
            $data['ami_create_time'] = time();
           $ret = $index_storage->insertValue($data);
        }



    }

    /*
     * 电话本认领申请记录
     */
    public function claimListAction(){
        $this->secondLink('list');
        $claim_storage  = new App_Model_Mobile_MysqlMobileClaimStorage($this->curr_sid);
        $page           = $this->request->getIntParam('page');
        $index          = $this->count*$page;
        $where          = array();
        $id             = $this->request->getIntParam('id');
        $where[]        = array('name'=>'ams_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]        = array('name'=>'ams_ams_id','oper'=>'=','value'=>$id);
        $sort           = array('ams_create_time'=>'ASC');
        $total          = $claim_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list            = array();
        if($index < $total){
            $list           = $claim_storage->getList($where,$index,$this->count,$sort);
        }
        $this->output['list'] = $list;
        //查询申请人对应的相关昵称
        $member_storage  = new App_Model_Member_MysqlMemberCoreStorage();
        $memberList      = $member_storage->getMemberNameBysid($this->curr_sid);
        if($this->request->getIntParam('test')==1){
            plum_msg_dump($memberList);die();
        }
        $this->output['status'] = array(0=>'待处理',1=>'已通过',2=>'已拒绝');
        $this->output['memberList'] = $memberList;
        $this->buildBreadcrumbs(array(
            array('title' => '电话本管理', 'link' => '/wxapp/mobile'),
            array('title' => '入驻店铺管理', 'link' => '/wxapp/mobile/shopList'),
            array('title' => '电话本认领列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/mobile/mobile-claim-list.tpl');


    }
    /*
     * 处理电话本申请相关信息
     */
    public function handleClaimAction(){
        $id = $this->request->getIntParam('id');
        $market = $this->request->getStrParam('market');
        $status = $this->request->getIntParam('status');
        $ret = false;
        if($id){
            $updata = array(
                'ams_auth_remark' => $market,
                'ams_status'        => $status?$status:1,
                'ams_auth_time'   => time()
            );
            $apply_storage = new App_Model_Mobile_MysqlMobileShopApplyStorage($this->curr_sid);
            $claim_storage   = new App_Model_Mobile_MysqlMobileClaimStorage($this->curr_sid);

            //将认领的会员绑定到相应店铺
            $claimRow  = $claim_storage->getRowById($id);
            if($status == 1 ){    //一个绑定通过，其他申请认领的相同的状态变为已拒绝
                //判断当前店铺是否已经有人认领
                $applyRow=$apply_storage ->getRowById($claimRow['ams_ams_id']) ;
                if($applyRow['ams_m_id']){
                     $this->displayJsonError('当前店铺已经被人认领，不能分配给另一个人');
                }else{
                    $ret = $claim_storage->updateById($updata,$id);
                    if($ret){
                        $this->_dealClaimStatus($claimRow['ams_ams_id'],$id);

                        $set        = array('ams_m_id'=>$claimRow['ams_mid']);
                        $apply_storage->updateById($set,$claimRow['ams_ams_id']);
                    }else{
                        $this->displayJsonError('处理失败，请稍后重试');
                    }
                }
            }

            if($ret){
                $str = $status == 1 ? '通过' : '不通过';
                $shop = $apply_storage->getRowById($claimRow['ams_ams_id']);
                App_Helper_OperateLog::saveOperateLog("电话本认领申请【{$shop['ams_name']}】处理成功，处理结果：{$str}");
            }

            $this->showAjaxResult($ret,'处理');
        }else{
            $this->displayJsonError('处理失败，请稍后重试');
        }
    }

    public function claimEditAction(){
        $id       = $this->request->getIntParam('id');
        $claim_storage  = new App_Model_Mobile_MysqlMobileClaimStorage($this->curr_sid);
        $this->buildBreadcrumbs(array(
            array('title' => '电话本管理', 'link' => '#'),
            array('title' => '电话本认领列表', 'link' => '/wxapp/mobile/claimlist'),
            array('title' => '查看认领信息', 'link' => '#'),
        ));
        $row       = $claim_storage->getRowById($id);
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member         = $member_storage->getRowById($row['ams_mid']);
        $this->output['name'] = $member['m_nickname'];
        $this->output['row']  = $row;
        $this->output['imgs'] = json_decode($row['ams_content'],1);
        /*if($this->request->getIntParam('test')==1){
            $img = json_deocde($row['ams_content'],1);

            plum_msg_dump($img);die();
        }*/
        $this->displaySmarty('wxapp/mobile/mobile-claim-edit.tpl');

    }
    //处理认领的相同店铺的申请为拒绝  $ams_id  电话本记录id
    private function _dealClaimStatus($ams_id,$id){
        $claim_storage   = new App_Model_Mobile_MysqlMobileClaimStorage($this->curr_sid);
        $set             = array('ams_status'=>2,'ams_auth_time'=>time());
        $where           = array();
        $where[]         = array('name'=>'ams_ams_id','oper'=>'=','value'=>$ams_id);
        $where[]         = array('name'=>'ams_id','oper'=>'<>','value'=>$id);
        $where[]         = array('name'=>'ams_status','oper'=>'=','value'=>0);
        $claim_storage->updateValue($set,$where);
    }

    /**
     * 导出团长数据
     */
    public function shopExcelAction(){
        $where      = array();
        $category = $this->request->getIntParam('category_excel');
        $status = $this->request->getIntParam('status_excel');
        $amc_model = new App_Model_Mobile_MysqlMobileShopApplyStorage($this->curr_sid);
        $where[] = array('name'=>'ams_s_id','oper'=>'=','value'=>$this->curr_sid);

        if($category){
            $where[] = array('name' => 'ams_cate_id','oper' => '=','value' =>$category);
        }
        if($status){
            switch ($status){
                case 1:
                    $where[] = array('name' => 'ams_status','oper' => '=','value' =>2);
                    $where[] = array('name' => 'ams_expire_time','oper' => '>','value' =>time());
                    break;
                case 2:
                    $where[] = array('name' => 'ams_status','oper' => '=','value' =>2);
                    $where[] = array('name' => 'ams_expire_time','oper' => '<','value' =>time());
                    break;
                case 3:
                    $where[] = array('name' => 'ams_status','oper' => '=','value' =>2);
                    break;
                case 4:
                    $where[] = array('name' => 'ams_status','oper' => '=','value' =>1);
                    break;
                case 5:
                    $where[] = array('name' => 'ams_status','oper' => '=','value' =>3);
                    break;
            }
        }

        $sort = array('ams_create_time'=>'DESC');
        //检索条件整理
        //数据展示
        $count = $amc_model->getCount($where);
        if($count > 5000){
            plum_url_location('数据过多，请缩小查询范围!');
        }
        $list = $amc_model->getList($where,0,0,$sort);
        if(!empty($list)){
            $category_list = $this->_get_category_list_select(true);
            $status_list = [
                1 => '待审核',
                2 => '已通过',
                3 => '已拒绝'
            ];
            //数据处理
            $rows  = array();
            $rows[]  = array('名称','分类','地址','联系人','联系电话','入驻时间','到期时间','审核状态');
            $width   = array(
                'A' => 20,
                'B' => 20,
                'C' => 30,
                'D' => 20,
                'E' => 20,
                'F' => 20,
                'G' => 20,
                'H' => 20,

            );

            foreach($list as $key => $val){
                $category_note = $category_list[$val['ams_cate_id']] ? $category_list[$val['ams_cate_id']]['title'] : '';
                $expireTime = $val['ams_expire_time'] >0 ? date('Y-m-d H:i',$val['ams_expire_time']) : '';
                $rows[] = array(
                    $this->utf8_str_to_unicode($val['ams_name']),
                    $category_note,
                    ($val['ams_address'].$val['ams_addr_detail']),
                    $val['ams_contacts'],
                    $val['ams_mobile'],
                    date('Y-m-d H:i',$val['ams_create_time']),
                    $expireTime,
                    $status_list[$val['ams_status']],
                );
            }
            $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
            $filename = '入驻店铺.xls';
            $excel->down_common_excel($rows,$filename,$width);
        }else{
            plum_url_location('未找到店铺!');
        }
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
                $unicode_str.= '';
            }else{
                $unicode_str.=$val;
            }
        }
        $unicode_str = $this->_filter_character($unicode_str);
        return $unicode_str;
    }

    /*
     * 过滤掉昵称中特殊字符
     */
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