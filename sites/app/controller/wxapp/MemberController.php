<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/18
 * Time: 上午9:26
 */

class App_Controller_Wxapp_MemberController extends App_Controller_Wxapp_InitController {

    public function __construct() {

        parent::__construct();
    }

    public function delareaAction(){
        $id     = $this->request->getIntParam('id');
        $area_model   = new App_Model_Three_MysqlThreeAreaStorage($this->curr_sid);
        $res = $area_model->deleteById($id);
        if($res){
            $request = array(
                'ec' => 200,
                'em' => '清除成功'
            );
        }else{
            $request = array(
                'ec' => 400,
                'em' => '清除失败'
            );
        }
        $this->displayJson($request);
    }

    public function addareaAction(){
        $id     = $this->request->getIntParam('id');
        $pro    = $this->request->getIntParam('pro');
        $area   = $this->request->getIntParam('area');
        $city   = $this->request->getIntParam('city');
        $street = $this->request->getIntParam('street');
        $pro_name    = $this->request->getStrParam('pro_name');
        $area_name   = $this->request->getStrParam('area_name');
        $city_name   = $this->request->getStrParam('city_name');
        $street_name = $this->request->getStrParam('street_name');
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $area_model   = new App_Model_Three_MysqlThreeAreaStorage($this->curr_sid);
        $where[]      = array('name'=>'ta_pro','oper'=>"=",'value'=>$pro);
        $where[]      = array('name'=>'ta_area','oper'=>"=",'value'=>$area);
        $where[]      = array('name'=>'ta_city','oper'=>"=",'value'=>$city);
        $where[]      = array('name'=>'ta_street','oper'=>"=",'value'=>$street);
        //$where[]      = array('name'=>'m_is_highest','oper'=>">",'value'=>0);
        $row          = $area_model->getRow($where);
        if($row){
            $this->displayJsonError('此区域已有分销商');
        }else{
            $aupdate['ta_pro'] = $pro;
            $aupdate['ta_city'] = $city;
            $aupdate['ta_area'] = $area;
            $aupdate['ta_street'] = $street;
            $aupdate['ta_pro_name'] = $pro_name;
            $aupdate['ta_city_name'] = $city_name;
            $aupdate['ta_area_name'] = $area_name;
            $aupdate['ta_street_name'] = $street_name;
            $aupdate['ta_create_time'] = time();
            $aupdate['ta_m_id'] = $id;
            $aupdate['ta_s_id'] = $this->curr_sid;
            $res = $area_model->insertValue($aupdate);
            if($res){
                $request = array(
                    'ec' => 200,
                    'em' => '增加成功'
                );
            }else{
                $request = array(
                    'ec' => 400,
                    'em' => '增加失败'
                );
            }
            $this->displayJson($request);
        }
    }

    public function savelevelnewAction(){
        $id     = $this->request->getIntParam('id');
        $dc_level = $this->request->getIntParam('dc_level');
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $update['m_is_highest'] = $dc_level;
        $update['m_update_time'] = time();
        $ret = $member_model->updateById($update,$id);
        if($ret){
            $res = array(
                'ec' => 200,
                'em' => '设置成功'
            );
        }else{
            $res = array(
                'ec' => 400,
                'em' => '设置失败'
            );
        }
        $this->displayJson($res);
    }



    public function delHighestAction(){
        $id           = $this->request->getIntParam('id');
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $update['m_is_highest'] = 0;
        $ret = $member_model->updateById($update,$id);
        $area_model   = new App_Model_Three_MysqlThreeAreaStorage($this->curr_sid);
        $where[]      = array('name'=>'ta_m_id','oper'=>'=','value'=>$id);
        $res          = $area_model->deleteValue($where);
        if($ret && $res){
            $request = array(
                'ec' => 200,
                'em' => '取消成功'
            );
        }else{
            $request = array(
                'ec' => 400,
                'em' => '取消失败'
            );
        }
        $this->displayJson($request);
    }

    public function saveareaAction(){
        $id     = $this->request->getIntParam('id');
        $pro    = $this->request->getIntParam('pro');
        $area   = $this->request->getIntParam('area');
        $city   = $this->request->getIntParam('city');
        $street = $this->request->getIntParam('street');
        $dc_level = $this->request->getIntParam('dc_level');
        $pro_name    = $this->request->getStrParam('pro_name');
        $area_name   = $this->request->getStrParam('area_name');
        $city_name   = $this->request->getStrParam('city_name');
        $street_name = $this->request->getStrParam('street_name');
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $area_model   = new App_Model_Three_MysqlThreeAreaStorage($this->curr_sid);
        $where[]      = array('name'=>'ta_pro','oper'=>"=",'value'=>$pro);
        $where[]      = array('name'=>'ta_area','oper'=>"=",'value'=>$area);
        $where[]      = array('name'=>'ta_city','oper'=>"=",'value'=>$city);
        $where[]      = array('name'=>'ta_street','oper'=>"=",'value'=>$street);
        //$where[]      = array('name'=>'m_is_highest','oper'=>">",'value'=>0);
        $row          = $area_model->getRow($where);
        if($row){
            $this->displayJsonError('此区域已有分销商');
        }else{
            $aupdate['ta_pro'] = $pro;
            $aupdate['ta_city'] = $city;
            $aupdate['ta_area'] = $area;
            $aupdate['ta_street'] = $street;
            $aupdate['ta_pro_name'] = $pro_name;
            $aupdate['ta_city_name'] = $city_name;
            $aupdate['ta_area_name'] = $area_name;
            $aupdate['ta_street_name'] = $street_name;
            $aupdate['ta_create_time'] = time();
            $aupdate['ta_m_id'] = $id;
            $aupdate['ta_s_id'] = $this->curr_sid;
            $res = $area_model->insertValue($aupdate);
            $update['m_is_highest'] = $dc_level;
            $ret = $member_model->updateById($update,$id);
            if($ret && $res){
                $request = array(
                    'ec' => 200,
                    'em' => '设置成功'
                );
            }else{
                $request = array(
                    'ec' => 400,
                    'em' => '设置失败'
                );
            }
            $this->displayJson($request);
        }
    }


    public function getareaAction(){
        $level = $this->request->getIntParam('level');
        $fid   = $this->request->getIntParam('fid');
        $data  = $this->getArea($level,$fid);
        echo json_encode($data);
    }

    public function getArea($level,$fid = 0){
        $url = 'http://api.tianapi.com/txapi/area/index';
        $params = array(
            'key'      => 'd6b1178a4f609db55cf5565c555d41d1',
        );
        if($level == 1){
            $params['country'] = 1;
        }elseif($level == 2){
            $params['province'] = $fid;
        }elseif($level == 3){
            $params['city']     = $fid;
        }elseif($level == 4){
            $params['county']   = $fid;
        }
        $res      = Libs_Http_Client::get($url, $params);
        $ret      = json_decode($res, 1);

        if($ret['newslist']){
            if($level == 1){
                foreach ($ret['newslist']  as $val){
                    $data[] = array(
                        'id'   => $val['provinceid'],
                        'name' => $val['provincename']
                    );
                }

            }elseif($level == 2){
                foreach ($ret['newslist']  as $val) {
                    $data[] = array(
                        'id'   => $val['cityid'],
                        'name' => $val['cityname']
                    );
                }
            }elseif($level == 3){
                foreach ($ret['newslist']  as $val) {
                    $data[] = array(
                        'id'   => $val['countyid'],
                        'name' => $val['countyname']
                    );
                }
            }elseif($level == 4){
                foreach ($ret['newslist']  as $val) {
                    $data[] = array(
                        'id'   => $val['townid'],
                        'name' => $val['townname']
                    );
                }
            }
            return $data;
        }
        return [];
    }


    public function listOldAction(){
        $this->_show_member_data_list();
        $table_menu = new App_Helper_TableMenu();
        $this->output['choseLink'] = $table_menu->showTableLink('memberNew');
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $this->output['mLevel'] = $level_model->getListBySidForSelect($this->curr_sid);
        $this->output['memberCategory'] = $this->_get_member_category();
        $this->output['sid'] = $this->curr_sid;
        //餐饮多店版 获得当前店铺下所有门店
        if($this->wxapp_cfg['ac_type'] == 4 && $this->wxapp_cfg['ac_index_tpl'] == 55){
            $shop_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
            $where_shop[] = array('name'=>'es_s_id','oper'=>'=','value'=>$this->curr_sid);
            $this->output['shopList'] = $shop_model->getList($where_shop,0,0);

        }
        $memberSource  = array(
            1 => '公众号',2=>'小程序',3=>'客户端',5=>'后台添加'
        );
        $this->output['memberSource'] = $memberSource;
        $addMember = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[6,21,1,8,24,18,27,32])){
            $addMember = 1;
        }
        $canBan = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[6,21,26])){
            $canBan = 1;
        }
        $this->output['addMember'] = $addMember;
        $this->output['canBan'] = $canBan;

        $this->buildBreadcrumbs(array(
            array('title' => '会员管理', 'link' => '#'),
            array('title' => '会员列表', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');

        // 优化社区团购会员列表小屏幕一屏幕显示不全问题
        // 2019-0318
        // zhangzc
        if( $this->wxapp_cfg['ac_type'] == 32){
            $this->displaySmarty('wxapp/member/seq-member-list.tpl');
        }else{
            $this->displaySmarty('wxapp/member/member-list.tpl');
        }

    }

    private function _show_member_data_list(){
        $page  = $this->request->getIntParam('page');
        $sortType = $this->request->getStrParam('sortType','showid_desc');

        $index = $page * $this->count;

        $member_sort_type = plum_parse_config('member_sort_type');
        $sortInfo = explode('_',$sortType);
        $sort_type = $sortInfo[0];
        $sort_val = strtolower($sortInfo[1]) == 'desc' || strtolower($sortInfo[1]) == 'asc' ? $sortInfo[1] : 'desc';
        $sort  = array('m_id' => 'DESC');//关注时间倒序排列
        if(in_array($sort_type,['showid','point','coin','deduct','tradenum','trademoney'])){
            foreach ($member_sort_type as $key => &$sort_row){
                if($key == $sort_type){
                    $sort_row['checked'] = 1;
                    $sort_row['sort'] = $sort_val == 'desc' ? 'asc' : 'desc';
                    $sort = [$sort_row['field'] => $sort_val];
                }else{
                    $sort_row['checked'] = 0;
                    $sort_row['sort'] = 'desc';
                }
            }
        }
        $this->output['sortType'] = $sortType;
        $this->output['sort_type'] = $sort_type;
        $this->output['member_sort_type'] = $member_sort_type;
//        $sort  = array('m_id' => 'DESC');//关注时间倒序排列
        $filed = array();

        $where = array();
        $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        if(in_array($this->wxapp_cfg['ac_type'],[6,21,1,8,24,18,27,32])){   //有后台添加的用户
            $where[] = array('name' => 'm_source', 'oper' => 'in', 'value' => array(2,3,5));
        }else{     // 只展示用户来源为小程序的用户
            $where[] = array('name' => 'm_source', 'oper' => 'in', 'value' => array(2,3));
        }



        $output = array();

        //会员来源查询
        $output['source'] = $this->request->getIntParam('source');
        if($output['source']){
            $where[] = array('name' => 'm_source', 'oper' => '=', 'value' => $output['source']);
        }

        //类型枚举，all全部，highest最高级会员，refer推荐人,out跑路人（没有关注或不再关注人,slient观望者
        $output['type'] = $this->request->getStrParam('type','all');
        if($output['type'] == 'slient'){
            $where[] = array('name' => 'm_is_slient', 'oper' => '=', 'value' => 1);
        }else{ //除了观望者，其他状态都过滤掉观望者
            //$where[] = array('name' => 'm_is_slient', 'oper' => '=', 'value' => 0);
            if($output['type'] == 'highest'){
                $where[] = array('name' => 'm_is_highest', 'oper' => '=', 'value' => 1);
            }elseif($output['type'] == 'refer'){
                $where[] = array('name' => 'm_is_refer', 'oper' => '=', 'value' => 1);
            }elseif($output['type'] == 'out'){
                $where[] = array('name' => 'm_is_follow', 'oper' => '=', 'value' => 0);
            }
        }

        //会员编号查询
        $output['mid'] = $this->request->getIntParam('mid');
        if($output['mid']){
            $where[] = array('name' => 'm_show_id', 'oper' => '=', 'value' => $output['mid']);
        }
        $output['rmid'] = $this->request->getIntParam('realMid'); //真正的Mid
        if($output['rmid']){
            $where[] = array('name' => 'm_id', 'oper' => '=', 'value' => $output['rmid']);
        }

        $output['category'] = $this->request->getIntParam('category');
        if($output['category']){
            $where[] = array('name' => 'ame_cate', 'oper' => '=', 'value' => $output['category']);
        }

        $output['mobile'] = $this->request->getStrParam('mobile'); //手机号
        if($output['mobile']){
            $where[] = array('name' => 'm_mobile', 'oper' => '=', 'value' => $output['mobile']);
        }

        $output['remark'] = $this->request->getStrParam('remark'); //备注
        if($output['remark']){
            $where[] = array('name' => 'm_remark', 'oper' => 'like', 'value' => "%{$output['remark']}%");
        }

        $output['searchlv'] = $this->request->getIntParam('searchlv'); //备注
        if($output['searchlv']){
            $where[] = array('name' => 'm_level', 'oper' => '=', 'value' => $output['searchlv']);
        }

        //上级，上二级，上三级查询功能
        for($i=1;$i<=3;$i++){
            $fid = $this->request->getIntParam($i.'f_id');
            if($fid){
                $where[] = array('name' => 'm_'.$i.'f_id', 'oper' => '=', 'value' => $fid);
            }
        }

        //会员昵称查询
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }else
            $where[] = array('name' => 'm_nickname', 'oper' => '!=', 'value' => '风猫');   //用户昵称为风猫的用户之间过滤

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        if($this->wxapp_cfg['ac_type'] ==32){
            $total = $member_model->getMemberLeaderCount($where);
            $list = array();
            if($total > $index){
                $list = $member_model->getMemberLeaderList($where,$index,$this->count,$sort);
                $output['level'] = $this->show_member_level_info($list);
            }
        }else{
            $total = $member_model->getMemberExtraCount($where);
            $list = array();
            if($total > $index){
                $list = $member_model->getMemberExtraList($where,$index,$this->count,$sort);
                $output['level'] = $this->show_member_level_info($list);
            }

//            $total = $member_model->getCount($where);
//            $list = array();
//            if($total > $index){
//                $list = $member_model->getList($where,$index,$this->count,$sort,$filed);
//                $output['level'] = $this->show_member_level_info($list);
//            }
        }

        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $output['paginator'] = $page_plugin->render();
        $output['list'] = $list;

        //获得统计信息
        $where_total = $where_verify = $where_noverify = $where_ban = [];
        $where_total[] = $where_verify[] = $where_noverify[] = $where_ban[] = ['name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        if(in_array($this->wxapp_cfg['ac_type'],[6,21,1,8,24,18,27,32])){   //有后台添加的用户
            $where_total[] = $where_verify[] = $where_noverify[] = $where_ban[] = ['name' => 'm_source', 'oper' => 'in', 'value' => array(2,3,5)];
        }else{     // 只展示用户来源为小程序的用户
            $where_total[] = $where_verify[] = $where_noverify[] = $where_ban[] = ['name' => 'm_source', 'oper' => 'in', 'value' => array(2,3)];
        }
        $where_ban[] = ['name' => 'm_status', 'oper' => '=', 'value' => 1];
        $totalToday = $member_model->getMemberCountTime($where_total,'today');
        $total7days = $member_model->getMemberCountTime($where_total,'7days');
        $total = $member_model->getMemberCountTime($where_total);
        $totalBan   = $member_model->getMemberCountTime($where_ban);

        $totalCate = 0;
        if($output['category']){
            $where_total[] = array('name' => 'ame_cate', 'oper' => '=', 'value' => $output['category']);
            if($this->wxapp_cfg['ac_type'] == 32){
                $totalCate = $member_model->getMemberLeaderCount($where_total);
            }else{
                $totalCate = $member_model->getMemberExtraCount($where_total);
            }
        }
        $output['statInfo'] = [
            'totalToday' => intval($totalToday),
            'total7days' => intval($total7days),
            'total'     => intval($total),
            'totalBan'  => intval($totalBan),
            'totalCate'=> intval($totalCate)
        ];



        $this->showOutput($output);
    }


    public function listAction(){
        $this->_show_member_data_list_new();
        $table_menu = new App_Helper_TableMenu();
        $this->output['choseLink'] = $table_menu->showTableLink('memberNew');
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $this->output['mLevel'] = $level_model->getListBySidForSelect($this->curr_sid);
        $this->output['memberCategory'] = $this->_get_member_category();
        $this->output['sid'] = $this->curr_sid;
        //餐饮多店版 获得当前店铺下所有门店
        if($this->wxapp_cfg['ac_type'] == 4 && $this->wxapp_cfg['ac_index_tpl'] == 55){
            $shop_model = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
            $where_shop[] = array('name'=>'es_s_id','oper'=>'=','value'=>$this->curr_sid);
            $this->output['shopList'] = $shop_model->getList($where_shop,0,0);

        }
        $memberSource  = array(
            1 => '公众号',2=>'小程序',5=>'后台添加'
        );
        $this->output['memberSource'] = $memberSource;
        $addMember = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[6,21,1,8,24,18,27,32])){
            $addMember = 1;
        }
        $canBan = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[6,21,26])){
            $canBan = 1;
        }
        $hideTrade = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[3])){
            $hideTrade = 1;
        }
        $showThree = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[6,7,8,12])){
            $showThree = 1;
        }
        $hideLevel = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[8,3,26,33,34,37])){
            $hideLevel = 1;
        }

        $sequenceShowAll = 1;
        if($this->wxapp_cfg['ac_type'] == 36){
            $sequenceShowAll = 0;
        }
        $this->output['sequenceShowAll'] = $sequenceShowAll;

        $this->output['addMember'] = $addMember;
        $this->output['canBan'] = $canBan;
        $this->output['hideTrade'] = $hideTrade;
        $this->output['showThree'] = $showThree;
        $this->output['hideLevel'] = $hideLevel;


        $broker_type = $this->curr_shop['s_broker_type'];
        if($broker_type == 2) {
            $this->output['cash'] = 'cash';
        }

        $this->buildBreadcrumbs(array(
            array('title' => '会员管理', 'link' => '#'),
            array('title' => '会员列表', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $pro  = $this->getArea(1,0);
        $this->output['pro'] = $pro;
        // 优化社区团购会员列表小屏幕一屏幕显示不全问题
        // 2019-0318
        // zhangzc
        $deduct_model   = new App_Model_Shop_MysqlDeductStorage();
        $decuct         = $deduct_model->getList(array(),0,0,array());
        $this->output['decuct'] = $decuct;
        $this->output['deduct'] = array_column($decuct,'dc_buy_num','dc_id');
        $this->displaySmarty('wxapp/member/member-list-new.tpl');
    }

    private function _show_member_data_list_new(){
        $page  = $this->request->getIntParam('page');
        $sortType = $this->request->getStrParam('sortType','showid_desc');
        $wxappTest = $this->request->getIntParam('wxappTest',0);

        $index = $page * $this->count;

        $member_sort_type = plum_parse_config('member_sort_type');
        $sortInfo = explode('_',$sortType);
        $sort_type = $sortInfo[0];
        $sort_val = strtolower($sortInfo[1]) == 'desc' || strtolower($sortInfo[1]) == 'asc' ? $sortInfo[1] : 'desc';
        $sort  = array('m_id' => 'DESC');//关注时间倒序排列
        if(in_array($sort_type,['id','point','coin','deduct','tradenum','trademoney'])){
            foreach ($member_sort_type as $key => &$sort_row){
                if($key == $sort_type){
                    $sort_row['checked'] = 1;
                    $sort_row['sort'] = $sort_val == 'desc' ? 'asc' : 'desc';
                    $sort = [$sort_row['field'] => $sort_val];
                }else{
                    $sort_row['checked'] = 0;
                    $sort_row['sort'] = 'desc';
                }
            }
        }
        $this->output['sortType'] = $sortType;
        $this->output['sort_type'] = $sort_type;
        $this->output['member_sort_type'] = $member_sort_type;
        $filed = array();

        $where = array();
        $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);



        $output = array();


        //会员来源查询
        $output['source'] = $this->request->getIntParam('source');
        if($output['source']){
            if($output['source'] == 2){
                //各版本小程序
                $where[] = array('name' => 'm_source', 'oper' => 'in', 'value' => [2,3,4,6]);
            }else{
                $where[] = array('name' => 'm_source', 'oper' => '=', 'value' => $output['source']);
            }
        }

        //类型枚举，all全部，highest最高级会员，refer推荐人,out跑路人（没有关注或不再关注人,slient观望者
        $output['type'] = $this->request->getStrParam('type','all');
        if($output['type'] == 'slient'){
            $where[] = array('name' => 'm_is_slient', 'oper' => '=', 'value' => 1);
        }else{ //除了观望者，其他状态都过滤掉观望者
            //$where[] = array('name' => 'm_is_slient', 'oper' => '=', 'value' => 0);
            if($output['type'] == 'highest'){
                $where[] = array('name' => 'm_is_highest', 'oper' => '=', 'value' => 1);
            }elseif($output['type'] == 'refer'){
                $where[] = array('name' => 'm_is_refer', 'oper' => '=', 'value' => 1);
            }elseif($output['type'] == 'out'){
                $where[] = array('name' => 'm_is_follow', 'oper' => '=', 'value' => 0);
            }
        }

        //会员编号查询
        $output['mid'] = $this->request->getIntParam('mid');
        if($output['mid']){
            $where[] = array('name' => 'm_show_id', 'oper' => '=', 'value' => $output['mid']);
        }
        $output['rmid'] = $this->request->getIntParam('realMid'); //真正的Mid
        if($output['rmid']){
            $where[] = array('name' => 'm_id', 'oper' => '=', 'value' => $output['rmid']);
        }

        $output['category'] = $this->request->getIntParam('category');
        if($output['category']){
            $where[] = array('name' => 'ame_cate', 'oper' => '=', 'value' => $output['category']);
        }

        $output['mobile'] = $this->request->getStrParam('mobile'); //手机号
        if($output['mobile']){
            $where[] = array('name' => 'm_mobile', 'oper' => '=', 'value' => $output['mobile']);
        }

        $output['remark'] = $this->request->getStrParam('remark'); //备注
        if($output['remark']){
            $where[] = array('name' => 'm_remark', 'oper' => 'like', 'value' => "%{$output['remark']}%");
        }

        $output['authorization'] = $this->request->getIntParam('authorization',0);
        if($output['authorization'] >= 0){
            $where[] = array('name' => 'm_is_slient', 'oper' => '=', 'value' => $output['authorization']);
        }

        $output['searchlv'] = $this->request->getIntParam('searchlv'); //备注
        if($output['searchlv']){
            $where[] = array('name' => 'm_level', 'oper' => '=', 'value' => $output['searchlv']);
        }

        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $startTime = strtotime($output['start']);
            $where[]    = array('name' => 'unix_timestamp(m_follow_time)', 'oper' => '>=', 'value' => $startTime);
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $endTime = strtotime($output['end']) + 86399;
            $where[]    = array('name' => 'unix_timestamp(m_follow_time)', 'oper' => '<=', 'value' => $endTime);
        }


        //上级，上二级，上三级查询功能
        for($i=1;$i<=3;$i++){
            $fid = $this->request->getIntParam($i.'f_id');
            if($fid){
                $where[] = array('name' => 'm_'.$i.'f_id', 'oper' => '=', 'value' => $fid);
            }
        }

        //会员昵称查询
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
            // like查询的时候 去除掉排序优化查询性能
            // zhangzc
            // 2019-09-11
            $sort=[];
        }else{
            // 风猫昵称出现的比较多的店铺在查询的时候，排除这个名字(总比原来所有的小程序都要搜索排除风猫这个名字要快点)
            // zhangzc
            // 2019-09-11
            if(in_array($this->sid,[8421,8202,5387,6684,4656,8311,6682,6248,8048,6252,6640,4969,7964,4546,7065,8055,5741,7891,7962]))
                $where[] = array('name' => 'm_nickname', 'oper' => '!=', 'value' => '风猫');   //用户昵称为风猫的用户直接过滤
        }


        if($this->curr_sid == 5904){
            $test = 1;
        }else{
            $test = 0;
        }

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        if($this->wxapp_cfg['ac_type'] ==32){
            $total = $member_model->getMemberLeaderCount($where);
            $list = array();
            if($total > $index){
                $list = $member_model->getMemberLeaderListNew($where,$index,$this->count,$sort,$wxappTest);
                $output['level'] = $this->show_member_level_info($list);
            }
        }else{
            $total = $member_model->getMemberExtraCount($where);
            $list = array();
            if($total > $index){
                $list = $member_model->getMemberExtraListNew($where,$index,$this->count,$sort);
                $output['level'] = $this->show_member_level_info($list);
            }
        }

        if($_REQUEST['test']==123){
            plum_msg_dump($total);
        }

        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $output['paginator'] = $page_plugin->render();
        foreach ($list as $kk=>$vv){
            $area_model = new App_Model_Three_MysqlThreeAreaStorage($this->curr_sid);
            $where      = array();
            $where[]    = array('name'=>"ta_m_id",'oper'=>"=",'value'=>$vv['m_id']);
            $area_list  = $area_model->getList($where,0,0,array('ta_create_time'=>'DESC'));
            $area       = array();
            foreach ($area_list as $av){
                $area[] = array(
                    'id'   => $av['ta_id'],
                    'area' => $av['ta_pro_name'].'-'.$av['ta_city_name'].'-'.$av['ta_area_name'].'-'.$av['ta_street_name'],
                );

            }
            $list[$kk]['area'] = $area;
        }

        $output['list'] = $list;
        $output['showPage'] = $total > $this->count ? 1 : 0;
        //获得统计信息

        $where_total = $where_verify = $where_noverify = $where_ban = [];
        $where_total[] = $where_verify[] = $where_noverify[] = $where_ban[] = ['name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid];

        $broker_type = $this->curr_shop['s_broker_type'];// 店铺类型
        if($broker_type !=2) {
            if(in_array($this->wxapp_cfg['ac_type'],[6,21,1,8,24,18,27,32])){   //有后台添加的用户
                $where_total[] = $where_verify[] = $where_noverify[] = $where_ban[] = ['name' => 'm_source', 'oper' => 'in', 'value' => array(1,2,3,5,6,7)];
            }else{     // 只展示用户来源为小程序的用户
                $where_total[] = $where_verify[] = $where_noverify[] = $where_ban[] = ['name' => 'm_source', 'oper' => 'in', 'value' => array(1,2,3,4,6,7)];
            }
        }

        $where_ban[] = ['name' => 'm_status', 'oper' => '=', 'value' => 1];
        $totalToday = $member_model->getMemberCountTime($where_total,'today');
        $total7days = $member_model->getMemberCountTime($where_total,'7days');
        $total = $member_model->getMemberCountTime($where_total);
        $totalBan   = $member_model->getMemberCountTime($where_ban);

        $totalCate = 0;
        if($output['category']){
            $where_total[] = array('name' => 'ame_cate', 'oper' => '=', 'value' => $output['category']);
            if($this->wxapp_cfg['ac_type'] == 32){
                $totalCate = $member_model->getMemberLeaderCount($where_total);
            }else{
                $totalCate = $member_model->getMemberExtraCount($where_total);
            }
        }
        $output['statInfo'] = [
            'totalToday' => intval($totalToday),
            'total7days' => intval($total7days),
            'total'     => intval($total),
            'totalBan'  => intval($totalBan),
            'totalCate'=> intval($totalCate)
        ];




        $this->showOutput($output);
    }

    //会员积分记录
    public function getMemberPointDetailAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '会员管理', 'link' => '#'),
            array('title' => '会员积分明细', 'link' => '#'),
        ));
        $mid = $this->request->getIntParam('mid');
        $inout_model    = new App_Model_Point_MysqlInoutStorage($this->curr_sid);
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $sort  = array('pi_id' => 'DESC');
        $where = [];
        $where[] = array('name' => 'pi_m_id', 'oper' => '=', 'value' => $mid);
        $list  = $inout_model->getList($where,$index,$this->count,$sort);
        $total = $inout_model->getCount($where);
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $output['paginator'] = $page_plugin->render();
        $output['list'] = $list;
        $this->showOutput($output);
        $this->displaySmarty('wxapp/member/member-point-list.tpl');
    }

    /*会员中心管理*/
    public function centerManageAction(){
        $center_model   = new App_Model_Member_MysqlCenterToolStorage();
        $row            = $center_model->findUpdateBySid($this->curr_sid);
        if(empty($row)){
            $row = plum_parse_config('center_tool');
        }
        $row['center']  = $this->composeLink('center','index',array(),true,'info');
        $this->output['row'] = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '店铺管理', 'link' => '#'),
            array('title' => '会员中心', 'link' => '#'),
        ));

        $tradeNav = plum_parse_config('trade_nav');
        $this->output['tradeNav'] = json_encode($tradeNav);

        $this->renderCropTool('/wxapp/index/uploadImg');   // 上传图片
        $this->displaySmarty('wxapp/member/member-center.tpl');
    }

    /*
     *  营销商城等会员中心相关
     */
    public function mallCenterManageAction(){
        $center_model   = new App_Model_Member_MysqlCenterToolStorage();
        $row            = $center_model->findUpdateBySid($this->curr_sid);
        if(empty($row)){
            $row = plum_parse_config('center_tool');
        }
        if($row['ct_nav_list']){
            $navList = json_decode($row['ct_nav_list'], true);
        }
        if(!$row['ct_nav_list'] || empty($navList)){
            $centerDefault = plum_parse_config('member_center');
            $row['ct_nav_list'] = json_encode($centerDefault);
        }else{
            foreach($navList as $key=>$val){
                $navList[$key]['open'] = $val['open'] == 'true'?true:false;
            }
            $row['ct_nav_list'] = json_encode($navList);
        }
        $row['center']  = $this->composeLink('center','index',array(),true,'info');

        $tradeNav = plum_parse_config('trade_nav');
        $this->output['tradeNav'] = json_encode($tradeNav);

        $knowledgepay_status = $this->_check_knowledgepay_show();
        $this->output['knowledgepay_status'] = $knowledgepay_status;

        $this->output['row'] = $row;
        $this->output['appletCfg'] = $this->wxapp_cfg;
        $this->buildBreadcrumbs(array(
            array('title' => '店铺管理', 'link' => '#'),
            array('title' => '会员中心', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');   // 上传图片
        if($this->menuType == 'toutiao'){
            $this->displaySmarty('wxapp/member/fenxiao-member-center-toutiao.tpl');
        }else{
            $this->displaySmarty('wxapp/member/fenxiao-member-center.tpl');
        }
    }

    /*
     *  预约版会员中心相关
     */
    public function appointmentCenterManageAction(){
        $center_model   = new App_Model_Member_MysqlCenterToolStorage();
        $row            = $center_model->findUpdateBySid($this->curr_sid);
        if(empty($row)){
            $row = plum_parse_config('center_tool');
        }
        if($row['ct_nav_list']){
            $navList = json_decode($row['ct_nav_list'], true);
        }
        if(!$row['ct_nav_list'] || empty($navList)){
            $centerDefault = plum_parse_config('member_center');
            $defaultData = array();
            foreach ($centerDefault as $val){
                if($val['index'] != 2){
                    $defaultData[] = $val;
                }
            }
            $row['ct_nav_list'] = json_encode($defaultData);
        }else{
            foreach($navList as $key=>$val){
                $navList[$key]['open'] = $val['open'] == 'true'?true:false;
            }
            $row['ct_nav_list'] = json_encode($navList);
        }
        $row['center']  = $this->composeLink('center','index',array(),true,'info');
        $this->output['row'] = $row;

        $tradeNav = plum_parse_config('trade_nav');
        $this->output['tradeNav'] = json_encode($tradeNav);

        $this->buildBreadcrumbs(array(
            array('title' => '会员中心', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');   // 上传图片
        if($this->menuType == 'toutiao' && $this->wxapp_cfg['ac_type'] == 18){
            //抖音预约版本
            $this->output['dyyu'] = true;
        }
        $this->displaySmarty('wxapp/member/reservation-member-center.tpl');
    }

    /**
     * 保存会员等级
     */
    public function saveCenterAction(){
        $data  = array();
        //字符串数据
        $fieldArr = array('title','bg','color');
        foreach($fieldArr as $fal){
            $temp = $this->request->getStrParam($fal);
            if($temp && isset($temp)){
                $data['ct_center_'.$fal] = $temp;
            }
        }
        //广告设置
        $data['ct_advert_link'] = $this->request->getStrParam('ad_link');
        $data['ct_advert_img']  = $this->request->getStrParam('ad_img');
        $data['ct_advert_show'] = $this->request->getIntParam('advert');
        $data['ct_nav_list'] = json_encode($this->request->getArrParam('navList'));

        $data['ct_topstyle']   = $this->request->getIntParam('topstyle');
        $data['ct_style_type']   = $this->request->getIntParam('styleType',1);
        $data['ct_service_title']   = $this->request->getStrParam('serviceTitle');
        $data['ct_membercard_jump'] = $this->request->getIntParam('membercardJump',0);

        if(in_array($this->wxapp_cfg['ac_type'],[6])){
            $data['ct_verify_mobile']   = $this->request->getIntParam('verifyMobile',0);
        }

        $default_icon = plum_parse_config('knowpay_nav_icon');
        $icon_keys = array_keys($default_icon);

        //确定名称 和显示
        $list = $this->request->getArrParam('list');
        $knowpay_nav = [];
        foreach($list as $key=>$val){
            if($val['name']){
                $data['ct_'.$key.'_name'] = $val['name'];
            }
            if($this->wxapp_cfg['ac_type'] == 27 && in_array($key,$icon_keys)){
                if ($val['isShow'] === 'false' || $val['isShow'] === false){
                    $data['ct_'.$key.'_show'] = 0;
                }elseif ($val['isShow'] === 'true' || $val['isShow'] === true){
                    $data['ct_'.$key.'_show'] = 1;
                }
                $knowpay_nav[$key] = $val['icon'];

            }else{
                if(in_array($val['isShow'],array(0,1))){
                    $data['ct_'.$key.'_show'] = $val['isShow'];
                }
            }
        }
        $data['ct_knowpay_nav'] = json_encode($knowpay_nav);
        $data['ct_update_time'] = time();
        //保存整理的数据
        $center_model = new App_Model_Member_MysqlCenterToolStorage();
        $centerRow    = $center_model->isExistBySid($this->curr_sid);
        if(!empty($centerRow)){
            // 如果个人中心配置存在，则验证下是否是上传的背景图，不再保存默认背景图
            if(!stristr($data['ct_center_bg'],'/upload/gallery/') && !stristr($data['ct_center_bg'],'/upload/depot/')){
                unset($data['ct_center_bg']);
            }
            $ret = $center_model->findUpdateBySid($this->curr_sid,$data);

        }else{
            $data['ct_s_id'] = $this->curr_sid;
            $data['ct_create_time'] = time();
            $ret = $center_model->insertValue($data);
        }
        App_Helper_OperateLog::saveOperateLog("会员中心配置信息保存成功");
        $this->showAjaxResult($ret,'保存');
    }

    /**
     * 修改会员状态
     */
    public function  changeStatusAction(){
        $id     = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');
        $changeStatus = 0;
        if($status == 0){
            $changeStatus = 1;
        }
        if($status == 1){
            $changeStatus = 0;
        }
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $set = array('m_status' => $changeStatus);
        $ret = $member_model->updateById($set, $id);

        if($ret){
            $row = $member_model->getRowById($id);
            $str = $changeStatus == 1 ? '封禁' : '解封';
            App_Helper_OperateLog::saveOperateLog("{$str}用户【{$row['m_nickname']}】成功");
        }

        $this->showAjaxResult($ret,'修改');
    }

    /**
     * 根据会员昵称获取会员列表
     */
    public function memberAction(){
        $data       = array(
            'ec'    => 400,
            'em'    => '未查到相关会员'
        );
        $nickname   = $this->request->getStrParam('nickname');

        $menu_type_source_cfg = plum_parse_config('menu_type_member_source_select');
        $source = $menu_type_source_cfg[$this->menuType] ? $menu_type_source_cfg[$this->menuType] : 2; //默认为小程序


        $text       = json_encode($nickname);
        $text       = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i",function($str){
            return addslashes($str[0]);
        },$text);
        $nickname   = json_decode($text);
        if($nickname){
            $mem_model  = new App_Model_Member_MysqlMemberCoreStorage();
            if(is_numeric($nickname)){
                $list       = $mem_model->getMemberSelect($this->curr_sid,$nickname,$source);
            }else{
                $where      = array();
                $where[]    = array('name'=>'m_s_id','oper'=>'=','value'=>$this->curr_sid);
                $where[]    = array('name'=>'m_nickname','oper'=>'like','value'=>"%{$nickname}%");
                $where[]    = array('name'=>'m_source','oper'=>'=','value'=>$source);
                $list       = $mem_model->getList($where,0,0);
            }

            if(!empty($list)){
                $mem = array();
                foreach($list as $val){
                    $mem[] = array(
                        'id'       => $val['m_id'],
                        'nickname' => $val['m_nickname'],
                        'show'     => $val['m_show_id']
                    );
                }
                $data       = array(
                    'ec'    => 200,
                    'data'  => $mem,
                );
            }
        }
        $this->displayJson($data);
    }

    private function _get_recharge_change(){
        $threeSale  = new App_Helper_ShopWeixin($this->curr_sid); //分销等级
        $level = $threeSale->formInputField('获得金额');
        $th    = $threeSale->getThByLevel($level['level'],'获得金额');

        $field = $threeSale->getFieldByLevel($level['level'],'rv_','f_coin');
        $this->output['thLevel']    = $th;
        $this->output['fieldLevel'] = $field;
        $this->output['levelHtml']  = $level['html'];
        $this->output['level']      = $level['level'];
        $this->output['sid']        = $this->curr_sid;

        $recharge_model = new App_Model_Member_MysqlRechargeValueStorage($this->curr_sid);
        $list = $recharge_model->fetchValueList();

        $level_model = new App_Model_Member_MysqlLevelStorage();
        $levelList = $level_model->getListBySidForSelect($this->curr_sid);

        $this->output['list'] = $list;
        $this->output['levelList'] = $levelList;
    }

    /**
     * 金币充值转换配置
     */
    public function rechargeChangeAction(){
        $threeSale  = new App_Helper_ShopWeixin($this->curr_sid); //分销等级
        $level = $threeSale->formInputField('获得金额');
        $th    = $threeSale->getThByLevel($level['level'],'获得金额');

        $field = $threeSale->getFieldByLevel($level['level'],'rv_','f_coin');
        $this->output['thLevel']    = $th;
        $this->output['fieldLevel'] = $field;
        $this->output['levelHtml']  = $level['html'];
        $this->output['level']      = $level['level'];
        $this->output['sid']        = $this->curr_sid;

        $recharge_model = new App_Model_Member_MysqlRechargeValueStorage($this->curr_sid);
        $list = $recharge_model->fetchValueList();

        $level_model = new App_Model_Member_MysqlLevelStorage();
        $levelList = $level_model->getListBySidForSelect($this->curr_sid);

        $this->output['list'] = $list;
        $this->output['levelList'] = $levelList;
        $this->buildBreadcrumbs(array(
            array('title' => '会员管理', 'link' => '#'),
            array('title' => '会员充值', 'link' => '/wxapp/member/rechargeChange'),
            array('title' => '充值金额', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/member/recharge-money.tpl");
    }

    /**
     * 保存充值金额
     */
    public function saveValueAction(){
        $result     = array(
            'ec'    => 400,
            'em'    => '请输入整数'
        );
        $id         = $this->request->getIntParam('id');
        $money      = $this->request->getIntParam('money');
        $coin       = $this->request->getIntParam('coin');
        $limit      = $this->request->getIntParam('limit');
        $identity   = $this->request->getIntParam('identity');
        $weight     = $this->request->getIntParam('weight');
        $backgroundColor = $this->request->getStrParam('backgroundColor');
        $level      = App_Helper_ShopWeixin::checkShopThreeLevel($this->curr_sid);
        if($money > 0 && $coin > 0){
            $data = array(
                'rv_money'  => $money,
                'rv_coin'   => $coin,
                'rv_limit'  => $limit,
                'rv_identity' => $identity,
                'rv_weight' => $weight,
                'rv_background_color' => $backgroundColor,
                'rv_create_time' => time()
            );
            for($i=1; $i<=3; $i++){
                if($i <= $level){
                    $data['rv_'.$i.'f_coin'] = $this->request->getFloatParam('coin_'.$i);
                }else{
                    $data['rv_'.$i.'f_coin'] = 0;
                }
            }
            $recharge_model = new App_Model_Member_MysqlRechargeValueStorage($this->curr_sid);
            $row = $recharge_model->getRowUpdateByIdSid($id,$this->curr_sid);
            if(!empty($row)){
                $ret = $recharge_model->updateById($data,$id);
            }else{
                $data['rv_s_id'] = $this->curr_sid;
                $ret = $recharge_model->insertValue($data);
            }
            if($ret){
                $result     = array(
                    'ec'    => 200,
                    'em'    => '保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("充值金额保存成功");
            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }

    /**
     * 删除充值金额配置项
     */
    public function delValueAction(){
        $recharge_model = new App_Model_Member_MysqlRechargeValueStorage($this->curr_sid);
        $id  = $this->request->getIntParam('id');
        $ret = $recharge_model->deleteBySidId($id,$this->curr_sid);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("充值金额删除成功");
        }

        $this->showAjaxResult($ret,'删除');
    }

    /**
     * 充值记录
     */
    public function recordAction(){
        $page           = $this->request->getIntParam('page');
        $index          = $page * $this->count;
        $where          = array();
        $where[]        = array('name' => 'rr_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]        = array('name' => 'rr_status', 'oper' => '=', 'value' => 1); //仅充值(增加)记录
        $recharge_model = new App_Model_Member_MysqlRechargeStorage($this->curr_sid);
        $total          = $recharge_model->getMemberCount($where);
        $list           = array();
        if($total > $index){
            $sort       = array('rr_create_time' => 'DESC');
            $list       = $recharge_model->getMemberList($where,$index,$this->count,$sort);
        }
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $paginator      = $pageCfg->render();
        $this->output['applet']    = $this->wxapp_cfg;
        $this->output['paginator'] = $paginator;
        $this->output['list']      = $list;
        $this->output['otherTip'] = plum_parse_config('other_tip');
        $this->output['allowType'] = plum_parse_config('show_recharge_tip','allow');
        $this->buildBreadcrumbs(array(
            array('title' => '会员管理', 'link' => '#'),
            array('title' => '会员充值', 'link' => '/wxapp/member/rechargeChange'),
            array('title' => '充值记录', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/member/recharge-record.tpl");
    }

    /**
     * 导出充值记录
     */
    public function importRechargeAction(){
        $startDate  = $this->request->getStrParam('startDate');
        $startTime  = $this->request->getStrParam('startTime');
        $endDate    = $this->request->getStrParam('endDate');
        $endTime    = $this->request->getStrParam('endTime');

        if($startDate && $startTime && $endDate && $endTime){
            $start = $startDate.' '.$startTime;
            $end   = $endDate.' '.$endTime;
            $startTime  = strtotime($start);
            $endTime    = strtotime($end);
            $where      = array();

            $recharge_model = new App_Model_Member_MysqlRechargeStorage($this->curr_sid);

            $where[]    = array('name' => 'rr_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[]    = array('name' => 'rr_status', 'oper' => '=', 'value' => 1); //仅充值(增加)记录
            $where[]    = array('name' => 'rr_create_time','oper'=>'>=','value'=>$startTime);
            $where[]    = array('name' => 'rr_create_time','oper'=>'<','value'=>$endTime);

            $sort = array('rr_create_time' => 'DESC');
            //检索条件整理
            //数据展示
            $list = $recharge_model->getMemberList($where,0,0,$sort);
            if(!empty($list)){
                $date       = date('Ymd',$_SERVER['REQUEST_TIME']);
                //数据处理
                $rows  = array();
                $rows[]  = array('订单编号','会员昵称','支付金额','获得金额','支付方式', '备注	', '管理员', '管理员电话', '时间');
                $width   = array(
                    'A' => 20,
                    'B' => 20,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                    'F' => 20,
                    'G' => 20,
                    'H' => 20,
                    'I' => 20,
                );
                $typeNote = array(1 => '微信支付', 2 => '余额支付', 3 => '充值码充值', 4 => '管理员充值',10=>'订单退款',13=> '会员卡赠送');
                foreach($list as $key => $val){
                    $manager_name = $val['manager_name'] ? $val['manager_name'] : '';
                    $manager_mobile = $val['manager_mobile'] ? $val['manager_mobile'].' ' : '';
                    $rows[] = array(
                        $val['rr_tid']." ",
                        $this->utf8_str_to_unicode($val['m_nickname']),
                        $val['rr_amount'],
                        $val['rr_gold_coin'],
                        $typeNote[$val['rr_pay_type']],
                        $val['rr_remark'],
                        $manager_name,
                        $manager_mobile,
                        date("Y-m-d H:i:s",$val['rr_create_time']),
                    );
                }
                $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
                $excel->down_common_excel($rows,$date.'充值记录.xls',$width);
            }else{
                plum_url_location('当前时间段内没有收支记录!');
            }
        }else{
            plum_url_location('日期请填写完整!');
        }
    }

    /**
     * 充值配置
     */
    public function cfgAction(){
        $recharge_cfg = new App_Model_Member_MysqlRechargeCfgStorage();
        $row = $recharge_cfg->findRowUpdate($this->curr_sid);
        $this->output['row']      = $row;
        $this->output['applet']   = $this->wxapp_cfg;
        $this->output['shop']     = $this->curr_sid;
        $this->_get_recharge_change();
        $this->buildBreadcrumbs(array(
            array('title' => '会员管理', 'link' => '#'),
            array('title' => '会员充值', 'link' => '/wxapp/member/rechargeChange'),
            array('title' => '充值配置', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/member/recharge-cfg.tpl");
    }

    /**
     * 保存充值配置信息
     */
    public function saveCfgAction(){
        $data = array();
        $data['rc_open_zdy']   = $this->request->getIntParam('open');
        $data['rc_open_remark']   = $this->request->getIntParam('remark');
        $data['rc_desc']       = $this->request->getStrParam('desc');
        $data['rc_update_time']= time();

        $recharge_cfg = new App_Model_Member_MysqlRechargeCfgStorage();
        $row = $recharge_cfg->findRowUpdate($this->curr_sid);
        if(!empty($row)){
            $ret = $recharge_cfg->findRowUpdate($this->curr_sid,$data);
        }else{
            $data['rc_s_id']        = $this->curr_sid;
            $data['rc_create_time'] = time();
            $ret = $recharge_cfg->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("充值配置保存成功");
        }

        $this->showAjaxResult($ret,'保存');
    }

    /**
     * 添加备注信息
     */
    public function memberRemarkAction(){
        $id             = $this->request->getIntParam('id');
        $remark         = $this->request->getStrParam('remark');
        $mobile         = $this->request->getStrParam('mobile');
        $realname         = $this->request->getStrParam('realname');
        $source         = $this->request->getIntParam('source');
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();

        if($mobile && !plum_is_mobile($mobile)){
            $this->displayJsonError('手机号格式不正确');
        }

        $set=array(
            'm_remark'      => $remark,
            'm_mobile'      => $mobile,
            'm_realname'    => $realname,
            'm_update_time' => time()
        );
        $member = $member_model->getRowById($id);
        //后台添加的用户 可编辑昵称头像
        if($source == 5){
            $set['m_nickname'] = $this->request->getStrParam('nickname');
            $set['m_avatar'] = $this->request->getStrParam('avatar');
        }
        $res=$member_model->updateById($set,$id);

        if($res){
            App_Helper_OperateLog::saveOperateLog("修改【{$member['m_nickname']}】用户信息成功");
        }

        $this->showAjaxResult($res,'保存');
    }

    /**
     * 会员等级
     */
    public function levelAction(){
        $this->showTypeByKey('yesNo');
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $this->output['list'] = $level_model->getListBySid($this->curr_sid);
        $this->buildBreadcrumbs(array(
            array('title' => '会员管理', 'link' => '/wxapp/member/list'),
            array('title' => '会员等级', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/member/level.tpl');
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
        $down    = $this->request->getIntParam('down');
        $sale    = $this->request->getFloatParam('sale');
        $money   = $this->request->getFloatParam('money');
        $price   = $this->request->getFloatParam('price');
        $weight  = $this->request->getIntParam('weight');
        $forever = $this->request->getIntParam('forever');
        $traded  = $this->request->getIntParam('traded');
        $is_vip  = $this->request->getIntParam('is_vip');
        $discount= $this->request->getFloatParam('discount');
        $postnum = $this->request->getIntParam('postnum');
        $invitenum = $this->request->getIntParam('invitenum');
        $oneProportion= $this->request->getIntParam('oneProportion');   //会员分佣比例
        $twoProportion= $this->request->getIntParam('twoProportion');   //会员分佣比例
        if($name && $desc && $weight){//&& ($down || $sale || $money || $price || $traded)
            $data  = array();
            $data['ml_s_id']        = $this->curr_sid;
            $data['ml_name']        = $name;
            $data['ml_desc']        = $desc;
            $data['ml_is_vip']      = $is_vip;
            $data['ml_weight']      = $weight;
            $data['ml_is_forever']  = $forever;
            $data['ml_sale_amount'] = $sale;
            $data['ml_down_count']  = $down;
            $data['ml_traded_num']  = $traded;
            $data['ml_traded_money']= $money;
            $data['ml_buy_money']   = $price;
            $data['ml_update_time'] = time();
            $data['ml_discount']    = $discount;
            $data['ml_1f_proportion']    = $oneProportion;
            $data['ml_2f_proportion']    = $twoProportion;

            //房产版会员等级发布数量
            if($this->wxapp_cfg['ac_type'] == 16 && $postnum){
                $data['ml_city_post_num'] = $postnum;
            }

            //招聘会员等级每日邀请量
            if($this->wxapp_cfg['ac_type'] == 28 && $invitenum){
                $data['ml_job_invite_num'] = $invitenum;
            }

            $id  = $this->request->getIntParam('id');
            $level_model = new App_Model_Member_MysqlLevelStorage();

            $levelRow = $level_model->getLevelByInfo($this->curr_sid,$weight,$traded,$money,$discount);
            if($levelRow && $levelRow['ml_id'] != $id && $this->wxapp_cfg['ac_type'] != 28 && $this->wxapp_cfg['ac_type'] != 16){
                if($traded != 0 && $levelRow['ml_traded_num'] == $traded){
                    $this->displayJsonError('成功交易数不允许出现重复请修改');
                }
                if($money != 0 && $levelRow['ml_traded_money'] == $money){
                    $this->displayJsonError('累计消费金额不允许出现重复请修改');
                }
                if($discount <= 0){
                    $this->displayJsonError('会员折扣不允许为0');
                }
                if($levelRow['ml_discount'] == $discount){
                    $this->displayJsonError('会员折扣不允许出现重复请修改');
                }
                if($levelRow['ml_weight'] == $weight){
                    $this->displayJsonError('会员等级权重不允许出现重复请修改');
                }
            }

//            $weightRow = $level_model->getLevelByTypeSid($this->curr_sid,$weight);
//            if($weightRow && $weightRow['ml_id'] != $id){
//                $this->displayJsonError('会员等级权重不允许出现重复请修改');
//            }

            if($id){
                $ret = $level_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
            }else{
                $data['ml_create_time'] = time();
                $ret = $level_model->insertValue($data);
            }
            App_Helper_OperateLog::saveOperateLog("会员等级【".$name."】保存成功");

            //结果处理
            $result       = $this->showAjaxResult($ret,'保存',true);
        }
        $this->displayJson($result);
    }

    /*
     * 删除会员等级
     */
    public function delLevelAction(){
        $result = array(
            'ec' => 400,
            'em' => '请完善数据'
        );
        $id  = $this->request->getIntParam('id');
        $level_model = new App_Model_Member_MysqlLevelStorage();
        if($id){
            $level = $level_model->getRowById($id);
            $set     = array(
                'ml_deleted'     => 1,
                'ml_name'        => '商家废弃',
                'ml_update_time' => time()
            );
            $ret = $level_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
            //结果处理
            if($ret){
                App_Helper_OperateLog::saveOperateLog("会员等级【".$level['ml_name']."】删除成功");
                //@todo  清除会员表会员等级
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member_model->clearMemberLevel($id,$this->curr_sid);

                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }

    /**
     * 修改会员等级
     */
    public function changeLevelAction(){
        $result = array(
            'ec' => 400,
            'em' => '请求参数错误'
        );
        $mid   = $this->request->getIntParam('id');
        $level = $this->request->getIntParam('level');
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $level_model = new App_Model_Member_MysqlLevelStorage();
        if($mid && $level !=0 ){
            $set   = array(
                'm_level'         => $level > 0 ? $level : 0, //会员等级
                'm_spread_qrcode' => '', //推广二维码清空
                'm_spread_image'  => '',//带推广二维码的图片清空
                'm_ticket_expire' => 0  //token立即失效
            );
            $ret          = $member_model->getRowUpdateByIdSid($mid,$this->curr_sid,$set);
            $result       = $this->showAjaxResult($ret,'保存',true);
        }

        if($result['ec'] == 200){
            $member = $member_model->getRowById($mid);
            if($level > 0){
                $level = $level_model->getRowById($level);
                $levelName = $level['ml_name'];
            }else{
                $levelName = '清除用户等级';
            }

            App_Helper_OperateLog::saveOperateLog("修改用户【{$member['m_nickname']}】等级【{$levelName}】成功");
        }

        $this->displayJson($result);
    }

    /**
     * 销毁会员海报操作
     */
    public function destroySpreadAction(){
        $mid   = $this->request->getIntParam('id');
        if($mid){
            $set   = array(
                'm_spread_image'    => '',
                'm_ticket_expire'   => 0
            );
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $ret          = $member_model->getRowUpdateByIdSid($mid,$this->curr_sid,$set);

            if($ret){
                $member = $member_model->getRowById($mid);
                App_Helper_OperateLog::saveOperateLog("用户【{$member['m_nickname']}】海报销毁成功");
            }

            $this->showAjaxResult($ret,'销毁');
        }else{
            $this->displayJsonError('请求参数错误');
        }
    }

    /**
     * 设为官方推荐人和最高级
     */
    public function setReferBestAction(){
        $result = array(
            'ec' => 400,
            'em' => '请求参数错误'
        );
        $id   = $this->request->getIntParam('showId');
        $type = $this->request->getStrParam('type');
        if($id && $type){
            $where = array();
            $where[] = array('name' => 'm_show_id', 'oper' => '=', 'value' => $id);
            $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $member = $member_model->getRow($where);
            if($member){
                $code       = $this->get_invite_code($member['m_invite_code']);
                $exist_code = $member_model->checkCode($this->curr_sid,$code,$member['m_id']);
                if($exist_code == 0){
                    switch($type){
                        case 'highest': //设为最高级
                            $set = array(
                                'm_is_highest'  => 1,
                                'm_invite_code' => $code,
                                'm_update_time' => time()
                            );
                            break;
                        case 'refer': //设为官方推荐人
                            $set = array(
                                'm_is_refer'    => 1,
                                'm_is_highest'  => 1,
                                'm_invite_code' => $code,
                                'm_update_time' => time()
                            );
                            break;
                    }
                    //存在上级的，则不能成为最高级
                    if($member['m_1f_id'] != 0 && $type == 'highest'){
                        $set = array();
                        $result['em'] = '存在上级，不能设为最高级';
                        $this->displayJson($result,true);
                    }elseif($member['m_1f_id'] != 0){
                        $set['m_is_highest'] = 0;
                    }

                    if(isset($set)){
                        if($this->curr_sid == 12){
                            $ret = true;
                        }else{
                            $ret = $member_model->updateValue($set,$where);
                        }
                        if($ret){
                            $result = array(
                                'ec' => 200,
                                'em' => '设置成功'
                            );
                            App_Helper_OperateLog::saveOperateLog("设置用户【{$member['m_nickname']}】为官方推荐人和最高级");
                        }else{
                            $result['em'] = '设置失败';
                        }
                    }else{
                        $result['em'] = '未知添加类型';
                    }
                }else{
                    $result['em'] = '该编号已经存在';
                }
            }else{
                $result['em'] = '无法查到该用户信息';
            }
        }
        $this->displayJson($result);
    }

    /**
     * 取消官方推荐
     */
    public function cancelReferAction(){
        $id   = $this->request->getIntParam('id');
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $set = array(
            'm_is_refer' => 0
        );
        $ret = $member_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);

        if($ret){
            $member = $member_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("用户【{$member['m_nickname']}】取消官方推荐成功");
        }

        $this->showAjaxResult($ret,'取消');
    }

    /**
     * 修改会员截止时间
     */
    public function changeLongAction(){
        $id    = $this->request->getIntParam('id');
        $date  = $this->request->getStrParam('date');
        $time  = strtotime($date);
        $ret   = false;
        if($time && $id){
            $set = array(
                'm_level_long'  => $time,
                'm_update_time' => time(),
            );
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $ret = $member_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);

            if($ret){
                $member = $member_model->getRowById($id);
                App_Helper_OperateLog::saveOperateLog("用户【{$member['m_nickname']}】修改付费会员到期时间成功");
            }

        }
        $this->showAjaxResult($ret,'修改');
    }

    /**
     * @param $m_code
     * @return mixed|string
     * 返回推荐码
     * 1、以前端传递过来的code为准
     * 2、以数据库存在的推荐码次之
     * 3、都不存在，则生成一个推荐码
     */
    private function get_invite_code($m_code){
        $code = $this->request->getStrParam('code');
        if($code){
            $save_code = $code;
        }elseif($m_code){
            $save_code = $m_code;
        }else{
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $save_code = $member_model->getInviteCode();
        }
        return $save_code;
    }



    /**
     * 管理员操作会员余额
     */
    public function newSaveRechargeAction(){
        $result = array(
            'ec' => 400,
            'em' => '请输入正确的金额'
        );
        $mid   = $this->request->getIntParam('mid');
        $coin  = $this->request->getStrParam('coin');
        $remark = $this->request->getStrParam('remark');
        $pwd   = $this->request->getStrParam('pwd');
        $operate = $this->request->getIntParam('operate');
        $manager_id = $this->manager['m_id'];
        //验证金额
        if(floatval($coin)) {

            //验证密码
            $manager_model = new App_Model_Member_MysqlManagerStorage();
            $member = $manager_model->getRowById($this->uid);
            if ($member['m_password'] != plum_salt_password($pwd)) {
                $result = [
                    'ec' => 400,
                    'em' => '密码错误，请重新输入'
                ];
            }
            else {
                if($operate){
                    $opName = '充值';
                    $opCoin = $coin;
                    $status = 1;
                }else{
                    $opName = '扣费';
                    $opCoin = -$coin;
                    $status = 2;
                }
                $result = [
                    'ec' => 400,
                    'em' => $opName.'失败'
                ];
                if ($mid) {
                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $record_model = new App_Model_Member_MysqlRechargeStorage($this->curr_sid);

                    $member = $member_model->getRowById($mid);

                    // 限制单次充值的最大金额为1万
                    // 限制用户最大余额为10万、
                    // zhangzc
                    // 2019-09-05
                    if($opCoin>10000){
                        $this->displayJsonError('单次充值金额最高为1万');
                    }
                    if(($member['m_gold_coin']+$opCoin)>100000){
                        $this->displayJsonError('用户最大可用余额最高为10万元');
                    }

                    $ret = $member_model->incrementMemberGoldcoin($mid, $opCoin);

                    if ($ret) {
                        $insert = [
                            'rr_s_id' => $this->curr_sid,
                            'rr_m_id' => $mid,
                            'rr_amount' => $coin,
                            'rr_gold_coin' => $coin,
                            'rr_remark' => $remark ? $remark : '管理员'.$opName,
                            'rr_status' => $status,
                            'rr_pay_type' => 4, //管理员操作
                            'rr_manager_id' => $manager_id,
                            'rr_create_time' => time()
                        ];
                        $res = $record_model->insertValue($insert);
                        plum_open_backend('templmsg', 'coinChangeTempl', array('sid' => $this->curr_sid, 'id' => $res));

                        App_Helper_OperateLog::saveOperateLog("为会员【".$member['m_nickname']."】".$opName."余额【".$coin."】");
                        if ($res) {
                            $result = [
                                'ec' => 200,
                                'em' => $opName.'成功'
                            ];
                        }
                    }
                }
            }
        }
        $this->displayJson($result);
    }

    /*
     * 管理员批量会员充值
     */
    public function saveMultiRechargeAction(){
        $result = array(
            'ec' => 400,
            'em' => '请输入正确的金额'
        );
        $ids   = $this->request->getArrParam('ids');
        $coin  = $this->request->getStrParam('coin');
        $remark = $this->request->getStrParam('remark');
        $pwd   = $this->request->getStrParam('pwd');
        $remark = $remark ? $remark : '管理员充值';
        $manager_id = $this->manager['m_id'];
        //验证金额
        if(floatval($coin)) {
            //验证密码
            $manager_model = new App_Model_Member_MysqlManagerStorage();
            $member = $manager_model->getRowById($this->uid);
            if ($member['m_password'] != plum_salt_password($pwd)) {
                $result = [
                    'ec' => 400,
                    'em' => '密码错误，请重新输入'
                ];
            }else {
                $result = [
                    'ec' => 400,
                    'em' => '充值失败'
                ];

                if (!empty($ids) && is_array($ids)) {
                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $record_model = new App_Model_Member_MysqlRechargeStorage($this->curr_sid);
                    //批量修改会员余额
                    $res = $member_model->incrementMultiMemberGoldcoin($ids,$this->curr_sid,$coin);
                    if($res){
                        //批量插入记录
                        $insert = array();
                        foreach ($ids as $val){
                            $insert[] = "(NULL, '{$this->curr_sid}', '{$val}', '{$coin}', '{$coin}', '1', '4', '{$remark}','{$manager_id}','".time()."')";
                        }
                        $ret = $record_model->batchData($insert);
                        if($ret){
                            $result = [
                                'ec' => 200,
                                'em' => '充值成功'
                            ];
                        }
                        App_Helper_OperateLog::saveOperateLog("批量充值成功");
                    }
                }
            }
        }
        $this->displayJson($result);
    }

    /**
     * 管理员会员扣费 已弃用
     */
    public function splitMoneyAction(){
        $result = array(
            'ec' => 400,
            'em' => '请输入正确的金额'
        );
        $mid   = $this->request->getIntParam('mid');
        $amount  = $this->request->getStrParam('amount');
        //验证金额
        if(floatval($amount)) {
            //验证密码
            if ($mid) {
                $result = [
                    'ec' => 400,
                    'em' => '扣费失败'
                ];
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $record_model = new App_Model_Member_MysqlRechargeStorage($this->curr_sid);
                $insert = [
                    'rr_s_id' => $this->curr_sid,
                    'rr_m_id' => $mid,
                    'rr_amount' => $amount,
                    'rr_gold_coin' => $amount,
                    'rr_remark' => '管理员扣费',
                    'rr_status' => 2,
                    'rr_pay_type' => 4, //管理员操作
                    'rr_create_time' => time()
                ];
                $res = $record_model->insertValue($insert);

                if ($res) {
                    $ret = $member_model->incrementMemberGoldcoin($mid, -$amount);
                    if ($ret) {
                        $result = [
                            'ec' => 200,
                            'em' => '扣除成功'
                        ];
                    }
                }
            }
        }
        $this->displayJson($result);
    }

    /**
     * 修改会员账户冻结状态
     */
    public function  freezeGoldAction(){
        $id     = $this->request->getIntParam('mid');
        $status = $this->request->getIntParam('status');

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $set = array('m_gold_freeze' => $status);
        $ret = $member_model->updateById($set, $id);

        if($ret){
            $member = $member_model->getRowById($id);
            $str = $status == 1 ? '冻结' : '解除冻结';
            App_Helper_OperateLog::saveOperateLog("用户【{$member['m_nickname']}】{$str}余额成功");
        }

        $this->showAjaxResult($ret,'操作');
    }

    /**
     * 餐饮用
     * 设置服务员
     */
    public function  setWaiterAction(){
        $id     = $this->request->getIntParam('mid');
        $status = $this->request->getIntParam('status');

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $set = array('m_is_waiter' => $status);
        $ret = $member_model->updateById($set, $id);

        if($ret){
            $member = $member_model->getRowById($id);
            $str = $status == 1 ? '设置为服务员' : '取消设置服务员';
            App_Helper_OperateLog::saveOperateLog("用户【{$member['m_nickname']}】{$str}成功");
        }

        $this->showAjaxResult($ret,'操作');
    }

    /**
     * 餐饮用
     * 设置服务员
     */
    public function  setWaiterNewAction(){
        $id     = $this->request->getIntParam('mid');
        $status = $this->request->getIntParam('isWaiter');
        $shopId = $this->request->getIntParam('shop');
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $set = array('m_is_waiter' => $status , 'm_waiter_shop' => $shopId);
        $ret = $member_model->updateById($set, $id);

        if($ret){
            $member = $member_model->getRowById($id);
            $str = $status == 1 ? '设置为服务员' : '取消设置服务员';
            App_Helper_OperateLog::saveOperateLog("用户【{$member['m_nickname']}】{$str}成功");
        }


        $this->showAjaxResult($ret,'操作');
    }

    /*
     * 管理员操作积分
     */
    public function savePointAction(){
        $result = array(
            'ec' => 400,
            'em' => '请输入正确的数值'
        );
        $mid   = $this->request->getIntParam('mid');
        $point  = $this->request->getStrParam('point');
        $remark = $this->request->getStrParam('remark');
        $pwd   = $this->request->getStrParam('pwd');
        $operate = $this->request->getIntParam('operate');
        $manager_id = $this->manager['m_id'];
        //验证金额
        if(intval($point)) {
            //验证密码
            $manager_model = new App_Model_Member_MysqlManagerStorage();
            $member = $manager_model->getRowById($this->uid);
            if ($member['m_password'] != plum_salt_password($pwd)) {
                $result = [
                    'ec' => 400,
                    'em' => '密码错误，请重新输入'
                ];
            }
            else {
                if($operate){
                    $opName = '增加';
                    $inout_type = App_Helper_Point::POINT_INOUT_INCOME;
                }else{
                    $opName = '扣除';
                    $inout_type = App_Helper_Point::POINT_INOUT_OUTPUT;
                }
                $result = [
                    'ec' => 400,
                    'em' => $opName.'失败'
                ];
                if ($mid) {

                    $point_helper = new App_Helper_Point($this->curr_sid);
                    $inout_title  = $remark ? $remark : "管理员".$opName.$point."积分";
                    $res = $point_helper->memberPointRecord(
                        $mid,
                        $point,
                        $inout_title,
                        $inout_type,
                        App_Helper_Point::POINT_SOURCE_MANAGER,
                        null,
                        $manager_id
                    );

                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $member = $member_model->getRowById($mid);
                    App_Helper_OperateLog::saveOperateLog("为会员【".$member['m_nickname']."】".$opName."积分【".$point."】");
                    if($res){
                        $result = [
                            'ec' => 200,
                            'em' => $opName.'成功'
                        ];
                    }
                }
            }
        }
        $this->displayJson($result);
    }

    /*
     * 管理员批量增加积分
     */
    public function saveMultiPointAction(){
        $result = array(
            'ec' => 400,
            'em' => '请输入正确的数值'
        );
        $ids   = $this->request->getArrParam('ids');
        $point  = $this->request->getStrParam('point');
        $remark = $this->request->getStrParam('remark');
        $pwd   = $this->request->getStrParam('pwd');
        $manager_id = $this->manager['m_id'];
        if(intval($point)){
            //验证密码
            $manager_model = new App_Model_Member_MysqlManagerStorage();
            $member = $manager_model->getRowById($this->uid);
            if ($member['m_password'] != plum_salt_password($pwd)) {
                $result = [
                    'ec' => 400,
                    'em' => '密码错误，请重新输入'
                ];
            }else {
                if (!empty($ids) && is_array($ids)) {
                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    //批量修改会员积分
                    $res = $member_model->incrementMultiMemberPoint($ids,$this->curr_sid,$point);
                    if($res){
                        $record_model = new App_Model_Point_MysqlInoutStorage($this->curr_sid);
                        $point_helper = new App_Helper_Point($this->curr_sid);
                        $inout_title  = $remark ? $remark : "管理员增加{$point}积分";
                        $inout_type   = $point_helper::POINT_INOUT_INCOME;
                        $inout_source   = $point_helper::POINT_SOURCE_MANAGER;
                        $insert = array();
                        foreach ($ids as $val){
                            $insert[] = "(NULL, '{$this->curr_sid}', '{$val}', '{$inout_type}', '{$inout_title}', '{$point}', '{$inout_source}', '','{$manager_id}','".time()."')";
                        }
                        $ret = $record_model->batchData($insert);
                        if($ret){
                            $result = [
                                'ec' => 200,
                                'em' => '增加成功'
                            ];
                        }

                        App_Helper_OperateLog::saveOperateLog("批量增加积分成功");

                    }
                }
            }
        }
        $this->displayJson($result);

    }


    /*
     * 转移会员到另外一个会员名下
     *
     */

    public function transferMemberAction(){
        $pendMid   = $this->request->getIntParam('pendMid');  // 待转移会员id
        $targetMid = $this->request->getIntParam('targetMid');   // 目标会员id
        $self      = $this->request->getStrParam('self');
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $pendMember = $member_model->getRowById($pendMid);
        $targetMember = $member_model->getRowById($targetMid);
        if($pendMember && $targetMember){
            if($self == 'on'){
                // 转移会员
                $result = $member_model->shiftMemberToOther($pendMid,$targetMid);
                // 修改目标会员的下级数量
                $targetField = array('m_1c_count','m_2c_count','m_3c_count');
                $targetInc = array(1,$pendMember['m_1c_count'],$pendMember['m_2c_count']);
                $tarret = $member_model->incrementMemberLevelCount($targetMember['m_id'], $targetField, $targetInc);
                if(!$pendMember['m_1f_id']){   // 如果上级不存在则直接转移,不再修改上级数量
                    if ($targetMember['m_1f_id']){   // 目标会员有上一级
                        $oneField = array('m_2c_count','m_3c_count');
                        $oneInc = array(1,$pendMember['m_1c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $oneField, $oneInc);
                    }elseif ($targetMember['m_2f_id']){    // 目标会员有上一级和上二级
                        $twoField = array('m_3c_count');
                        $twoInc = array(1);
                        $member_model->incrementMemberLevelCount($targetMember['m_2f_id'], $twoField, $twoInc);
                    }
                }else if($pendMember['m_1f_id'] && !$pendMember['m_2f_id']){    // 上-级存在，上二级不存在
                    // 修改待转移会员上一级的下级数量
                    $pendOneField = array('m_1c_count','m_2c_count','m_3c_count');
                    $pendOneInc = array(-1, -$pendMember['m_1c_count'],-$pendMember['m_2c_count']);
                    $member_model->incrementMemberLevelCount($pendMember['m_1f_id'], $pendOneField, $pendOneInc);
                    if(!$targetMember['m_1f_id']){

                    }else if($targetMember['m_1f_id'] && !$targetMember['m_2f_id']){   // 目标会员上一级存在，上二级和上三级不存在
                        // 修改目标会员上级的下级数量
                        $targetoneField = array('m_2c_count','m_3c_count');
                        $targetoneInc = array(1,$pendMember['m_1c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $targetoneField, $targetoneInc);
                    }else{
                        // 修改目标会员上一级的下级数量
                        $targetOneField = array('m_2c_count','m_3c_count');
                        $targetOneInc = array(1,$pendMember['m_1c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $targetOneField, $targetOneInc);
                        // 修改目标会员上二级的下级数量
                        $targetTwoField = array('m_3c_count');
                        $targetTwoInc = array($pendMember['m_1c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_2f_id'], $targetTwoField, $targetTwoInc);
                    }
                }else if($pendMember['m_1f_id'] && $pendMember['m_2f_id'] && !$pendMember['m_3f_id']){   // 上一级和上二级存在
                    // 修改待转移会员上一级的下级数量
                    $pendOneField = array('m_1c_count','m_2c_count','m_3c_count');
                    $pendOneInc = array(-1, -$pendMember['m_1c_count'],-$pendMember['m_2c_count']);
                    $member_model->incrementMemberLevelCount($pendMember['m_1f_id'], $pendOneField, $pendOneInc);

                    // 修改待转移会员上二级的下级数量
                    $pendTwoField = array('m_2c_count','m_3c_count');
                    $pendTwoInc = array(-1,-$pendMember['m_1c_count']);
                    $member_model->incrementMemberLevelCount($pendMember['m_2f_id'], $pendTwoField, $pendTwoInc);

                    if(!$targetMember['m_1f_id']){   //待转移会员不存在上级

                    }else if($targetMember['m_1f_id'] && !$targetMember['m_2f_id']){   // 目标会员上一级存在，上二级和上三级不存在
                        // 修改目标会员上级的下级数量
                        $targetoneField = array('m_2c_count','m_3c_count');
                        $targetoneInc = array(1,$pendMember['m_1c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $targetoneField, $targetoneInc);
                    }else{
                        // 修改目标会员上一级的下级数量
                        $targetOneField = array('m_2c_count','m_3c_count');
                        $targetOneInc = array(1,$pendMember['m_1c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $targetOneField, $targetOneInc);
                        // 修改目标会员上二级的下级数量
                        $targetTwoField = array('m_3c_count');
                        $targetTwoInc = array($pendMember['m_1c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_2f_id'], $targetTwoField, $targetTwoInc);
                    }
                }else if($pendMember['m_1f_id'] && $pendMember['m_2f_id'] && $pendMember['m_3f_id']){    // 上三级均存在
                    // 修改待转移会员上一级的下级数量
                    $pendOneField = array('m_1c_count','m_2c_count','m_3c_count');
                    $pendOneInc = array(-1, -$pendMember['m_1c_count'],-$pendMember['m_2c_count']);
                    $member_model->incrementMemberLevelCount($pendMember['m_1f_id'], $pendOneField, $pendOneInc);

                    // 修改待转移会员上二级的下级数量
                    $pendTwoField = array('m_2c_count','m_3c_count');
                    $pendTwoInc = array(-1,-$pendMember['m_1c_count']);
                    $member_model->incrementMemberLevelCount($pendMember['m_2f_id'], $pendTwoField, $pendTwoInc);

                    // 修改待转移会员上三级的下级数量
                    $pendTwoField = array('m_3c_count');
                    $pendTwoInc = array(-1);
                    $member_model->incrementMemberLevelCount($pendMember['m_3f_id'], $pendTwoField, $pendTwoInc);

                    if($targetMember['m_1f_id'] && !$targetMember['m_2f_id']){   // 目标会员上一级存在，上二级和上三级不存在
                        // 修改目标会员上级的下级数量
                        $targetoneField = array('m_2c_count','m_3c_count');
                        $targetoneInc = array(1,$pendMember['m_1c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $targetoneField, $targetoneInc);
                    }else{
                        // 修改目标会员上一级的下级数量
                        $targetOneField = array('m_2c_count','m_3c_count');
                        $targetOneInc = array(1,$pendMember['m_1c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $targetOneField, $targetOneInc);
                        // 修改目标会员上二级的下级数量
                        $targetTwoField = array('m_3c_count');
                        $targetTwoInc = array($pendMember['m_1c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_2f_id'], $targetTwoField, $targetTwoInc);
                    }
                }
            }else{
                $result = $member_model->shiftMemberFromOneToAnother($pendMid,$targetMid);
                // 修改目标会员的下级数量
                $targetField = array('m_1c_count','m_2c_count','m_3c_count');
                $targetInc = array($pendMember['m_1c_count'],$pendMember['m_2c_count'],$pendMember['m_3c_count']);
                $tarret = $member_model->incrementMemberLevelCount($targetMember['m_id'], $targetField, $targetInc);
                // 修改待转移会员的下级数量
                $pendField = array('m_1c_count','m_2c_count','m_3c_count');
                $pendInc = array(-$pendMember['m_1c_count'],-$pendMember['m_2c_count'],-$pendMember['m_3c_count']);
                $pendret = $member_model->incrementMemberLevelCount($pendMember['m_id'], $pendField, $pendInc);
                if(!$pendMember['m_1f_id']){   // 如果上级不存在则直接转移,不再修改上级数量
                    if ($targetMember['m_1f_id']){   // 目标会员有上一级
                        $oneField = array('m_2c_count','m_3c_count');
                        $oneInc = array($pendMember['m_1c_count'],$pendMember['m_2c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $oneField, $oneInc);
                    }elseif ($targetMember['m_2f_id']){    // 目标会员有上一级和上二级
                        $twoField = array('m_3c_count');
                        $twoInc = array($pendMember['m_1c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_2f_id'], $twoField, $twoInc);
                    }
                }else if($pendMember['m_1f_id'] && !$pendMember['m_2f_id']){    // 上-级存在，上二级不存在
                    if(!$targetMember['m_1f_id']){
                        // 修改待转移会员上一级的下级数量
                        $pendOneField = array('m_2c_count','m_3c_count');
                        $pendOneInc = array(-$pendMember['m_1c_count'],-$pendMember['m_2c_count']);
                        $member_model->incrementMemberLevelCount($pendMember['m_1f_id'], $pendOneField, $pendOneInc);
                    }else if($targetMember['m_1f_id'] && !$targetMember['m_2f_id']){   // 目标会员上一级存在，上二级和上三级不存在
                        // 如果待转移会员和目标会员上级不相同
                        if($targetMember['m_1f_id']!=$pendMember['m_1f_id']){
                            // 修改目标会员上级的下级数量
                            $targetoneField = array('m_2c_count','m_3c_count');
                            $targetoneInc = array($pendMember['m_1c_count'],$pendMember['m_2c_count']);
                            $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $targetoneField, $targetoneInc);
                            // 修改待转移会员上一级的下级数量
                            $pendOneField = array('m_2c_count','m_3c_count');
                            $pendOneInc = array(-$pendMember['m_1c_count'],-$pendMember['m_2c_count']);
                            $member_model->incrementMemberLevelCount($pendMember['m_1f_id'], $pendOneField, $pendOneInc);
                        }
                    }else{
                        if($targetMember['m_2f_id']==$pendMember['m_1f_id']){  // 如果待转移会员的上一级和目标会员的上二级相同
                            // 修改目标会员上一级的下级数量
                            $targetOneField = array('m_2c_count','m_3c_count');
                            $targetOneInc = array($pendMember['m_1c_count'],$pendMember['m_2c_count']);
                            $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $targetOneField, $targetOneInc);
                            // 修改目标会员上二级的下级数量
                            $targetTwoField = array('m_2c_count','m_3c_count');
                            $targetTwoInc = array(-$pendMember['m_1c_count'],($pendMember['m_1c_count']-$pendMember['m_2c_count']));
                            $member_model->incrementMemberLevelCount($targetMember['m_2f_id'], $targetTwoField, $targetTwoInc);

                        }else{
                            // 修改待转移会员上一级的下级数量
                            $pendOneField = array('m_2c_count','m_3c_count');
                            $pendOneInc = array(-$pendMember['m_1c_count'],-$pendMember['m_2c_count']);
                            $member_model->incrementMemberLevelCount($pendMember['m_1f_id'], $pendOneField, $pendOneInc);

                            // 修改目标会员上二级的下级数量
                            $targetTwoField = array('m_3c_count');
                            $targetTwoInc = array($pendMember['m_1c_count']);
                            $member_model->incrementMemberLevelCount($targetMember['m_2f_id'], $targetTwoField, $targetTwoInc);
                            // 修改目标会员上一级的下级数量
                            $targetOneField = array('m_2c_count','m_3c_count');
                            $targetOneInc = array($pendMember['m_1c_count'],$pendMember['m_2c_count']);
                            $member_model->incrementMemberLevelCount($pendMember['m_1f_id'], $targetOneField, $targetOneInc);
                        }
                    }
                }else if($pendMember['m_1f_id'] && $pendMember['m_2f_id'] && !$pendMember['m_3f_id']){   // 上一级和上二级存在
                    if(!$targetMember['m_1f_id']){   //待转移会员不存在上级
                        // 修改待转移会员上一级的下级数量
                        $pendOneField = array('m_2c_count','m_3c_count');
                        $pendOneInc = array(-$pendMember['m_1c_count'],-$pendMember['m_2c_count']);
                        $member_model->incrementMemberLevelCount($pendMember['m_1f_id'], $pendOneField, $pendOneInc);

                        // 修改待转移会员上二级的下级数量
                        $pendTwoField = array('m_3c_count');
                        $pendTwoInc = array(-$pendMember['m_1c_count']);
                        $member_model->incrementMemberLevelCount($pendMember['m_1f_id'], $pendTwoField, $pendTwoInc);
                    }else if($targetMember['m_1f_id'] && !$targetMember['m_2f_id']){   // 目标会员上一级存在，上二级和上三级不存在
                        // 如果待转移会员和目标会员上级不相同
                        if($targetMember['m_1f_id']==$pendMember['m_2f_id']){
                            // 修改待转移会员上二级的下级数量
                            $pendTwoField = array('m_2c_count','m_3c_count');
                            $pendTwoInc = array($pendMember['m_1c_count'],-$pendMember['m_1c_count']+$pendMember['m_2c_count']);
                            $member_model->incrementMemberLevelCount($targetMember['m_2f_id'], $pendTwoField, $pendTwoInc);
                            // 修改待转移会员上一级的下级数量
                            $pendOneField = array('m_2c_count','m_3c_count');
                            $pendOneInc = array(-$pendMember['m_1c_count'],-$pendMember['m_2c_count']);
                            $member_model->incrementMemberLevelCount($pendMember['m_1f_id'], $pendOneField, $pendOneInc);
                        }else{
                            // 修改待转移会员上二级的下级数量
                            $pendTwoField = array('m_3c_count');
                            $pendTwoInc = array(-$pendMember['m_1c_count']);
                            $member_model->incrementMemberLevelCount($targetMember['m_2f_id'], $pendTwoField, $pendTwoInc);
                            // 修改待转移会员上一级的下级数量
                            $pendOneField = array('m_2c_count','m_3c_count');
                            $pendOneInc = array(-$pendMember['m_1c_count'],-$pendMember['m_2c_count']);
                            $member_model->incrementMemberLevelCount($pendMember['m_1f_id'], $pendOneField, $pendOneInc);
                            // 修改目标会员上级的数量
                            $targetOneField = array('m_2c_count','m_3c_count');
                            $targetOneInc = array($pendMember['m_1c_count'],$pendMember['m_2c_count']);
                            $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $targetOneField, $targetOneInc);
                        }
                    }else{
                        if($pendMember['m_2f_id']==$targetMember['m_2f_id']){   // 上二级相同
                            // 修改目标会员上级的下级数量
                            $targetOneField = array('m_2c_count','m_3c_count');
                            $targetOneInc = array($pendMember['m_1c_count'],$pendMember['m_2c_count']);
                            $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $targetOneField, $targetOneInc);
                            // 修改待转移会员上一级的下级数量
                            $pendOneField = array('m_2c_count','m_3c_count');
                            $pendOneInc = array(-$pendMember['m_1c_count'],-$pendMember['m_2c_count']);
                            $member_model->incrementMemberLevelCount($pendMember['m_1f_id'], $pendOneField, $pendOneInc);
                        }elseif($pendMember['m_1f_id']!=$targetMember['m_1f_id']){
                            // 修改待转移会员上二级会员数量
                            $pendTwoField = array('m_3c_count');
                            $pendTwoInc = array($pendMember['m_1c_count']);
                            $member_model->incrementMemberLevelCount($pendMember['m_2f_id'], $pendTwoField, $pendTwoInc);
                            // 修改待转移会员上一级的下级数量
                            $pendOneField = array('m_2c_count','m_3c_count');
                            $pendOneInc = array($pendMember['m_1c_count'],$pendMember['m_2c_count']);
                            $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $pendOneField, $pendOneInc);

                            // 修改目标会员上二级的下级数量
                            $targetTwoField = array('m_3c_count');
                            $targetTwoInc = array($pendMember['m_1c_count']);
                            $member_model->incrementMemberLevelCount($targetMember['m_2f_id'], $targetTwoField, $targetTwoInc);
                            // 修改目标会员上一级的下级数量
                            $targetOneField = array('m_2c_count','m_3c_count');
                            $targetOneInc = array($pendMember['m_1c_count'],$pendMember['m_2c_count']);
                            $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $targetOneField, $targetOneInc);
                        }
                    }
                }else if($pendMember['m_1f_id'] && $pendMember['m_2f_id'] && $pendMember['m_3f_id']){    // 上三级均存在
                    // 修改待转移会员上二级会员数量
                    $pendTwoField = array('m_3c_count');
                    $pendTwoInc = array($pendMember['m_1c_count']);
                    $member_model->incrementMemberLevelCount($pendMember['m_2f_id'], $pendTwoField, $pendTwoInc);
                    // 修改待转移会员上一级的下级数量
                    $pendOneField = array('m_2c_count','m_3c_count');
                    $pendOneInc = array($pendMember['m_1c_count'],$pendMember['m_2c_count']);
                    $member_model->incrementMemberLevelCount($pendMember['m_1f_id'], $pendOneField, $pendOneInc);

                    if($targetMember['m_1f_id'] && !$targetMember['m_2f_id']){
                        // 修改目标会员上一级的下级数量
                        $targetOneField = array('m_2c_count','m_3c_count');
                        $targetOneInc = array($pendMember['m_1c_count'],$pendMember['m_2c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $targetOneField, $targetOneInc);
                    }elseif($targetMember['m_1f_id'] && $targetMember['m_2f_id']){
                        // 修改目标会员上一级的下级数量
                        $targetOneField = array('m_2c_count','m_3c_count');
                        $targetOneInc = array($pendMember['m_1c_count'],$pendMember['m_2c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $targetOneField, $targetOneInc);
                        // 修改目标会员上二级的下级数量
                        $targetTwoField = array('m_3c_count');
                        $targetTwoInc = array($pendMember['m_1c_count']);
                        $member_model->incrementMemberLevelCount($targetMember['m_1f_id'], $targetTwoField, $targetTwoInc);
                    }
                }
            }
        }
        if($tarret || $pendret){

            App_Helper_OperateLog::saveOperateLog("转移用户【{$pendMember['m_nickname']}】下级至【{$targetMember['m_nickname']}】成功");

            $this->showAjaxResult(1,'转移');
        }else{
            $this->displayJsonError('转移失败');
        }
    }

    /*
     * 保存新的会员信息
     */
    public function addMemberAction(){
        $username      = $this->request->getStrParam('name');
        $avatar        = $this->request->getStrParam('avatar');
        $memberModel   = new App_Model_Member_MysqlMemberCoreStorage();
        $count         = $memberModel->getCountMemberBySource($this->curr_sid,5);
        if($count <200){
            //判断当前店铺虚拟用户的数量
            $data          = array(
                'm_s_id'   => $this->curr_sid,
                'm_source' => 5,  //后台添加用户，虚拟用户
                'm_c_id'   => $this->curr_shop['s_c_id'],
                'm_nickname'=> $username,
                'm_avatar'  => $avatar,
                'm_follow_time' =>date('Y-m-d H:i:s',time()),
                'm_openid'   => plum_random_code(32,false),
            );
            $res  = $memberModel->insertShopNewMember($this->curr_sid,$data);
            if($res){
                $ret = array(
                    'ec' => 200,
                    'em' => '添加会员成功'
                );
                App_Helper_OperateLog::saveOperateLog("用户【{$username}】添加成功");
            }else{
                $ret = array(
                    'ec' => 400,
                    'em' => '添加失败'
                );
            }
        }else{
            $ret = array(
                'ec' => 400,
                'em' => '你当前添加的会员数量已经达到了上限，最多添加200个!'
            );
        }
        $this->displayJson($ret);

    }


    //招聘内推会员列表
    public function jobMemberListAction(){
        $this->_show_job_member_data_list();
        $table_menu = new App_Helper_TableMenu();
        $this->output['choseLink'] = $table_menu->showTableLink('memberNew');
        $this->output['sid'] = $this->curr_sid;

        $addMember = 0;
        $addMember = 1;
        $this->output['addMember'] = $addMember;

        $memberSource  = array(
            1 => '公众号',2=>'小程序',3=>'客户端',5=>'后台添加'
        );
        $this->output['memberSource'] = $memberSource;

        $this->buildBreadcrumbs(array(
            array('title' => '会员管理', 'link' => '#'),
            array('title' => '会员列表', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/member/job-member-list.tpl');
    }

    private function _show_job_member_data_list(){
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $sort  = array('m_follow_time' => 'DESC');//关注时间倒序排列
        $filed = array();

        $where = array();
        $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'm_source', 'oper' => 'in', 'value' => [2,5]);

        $where[] = array('name' => 'm_nickname', 'oper' => '!=', 'value' => '风猫');   //用户昵称为风猫的用户之间过滤

        $output = array();
        //会员昵称查询
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }

        //会员编号查询
        $output['mid'] = $this->request->getIntParam('mid');
        if($output['mid']){
            $where[] = array('name' => 'm_show_id', 'oper' => '=', 'value' => $output['mid']);
        }
        $output['authorization'] = $this->request->getIntParam('authorization',0);
        if($output['authorization'] >= 0){
            $where[] = array('name' => 'm_is_slient', 'oper' => '=', 'value' => $output['authorization']);
        }


        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $total = $member_model->getCount($where);

        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $output['paginator'] = $page_plugin->render();
        $list = array();
        if($total > $index){
            $list = $member_model->getJobMemberList($where,$index,$this->count,$sort);
            $send_model = new App_Model_Job_MysqlJobSendStorage($this->curr_sid);
            $employee_model = new App_Model_Job_MysqlJobEmployeeStorage($this->curr_sid);
            $company_model = new App_Model_Job_MysqlJobCompanyStorage($this->curr_sid);
            foreach ($list as $key => $value){
                $list[$key]['entry'] = $send_model->getEntryRowByMidPid($value['m_id']);
                $employee = $employee_model->getHadEmployeeRowByEsIdMId($value['m_id']);
                $company = $company_model->findCompanyByShopId($employee['aje_es_id']);
                $list[$key]['company'] = $company['ajc_company_name'];
            }
        }
        $output['list'] = $list;
        $this->showOutput($output);
    }


    /*
     * 签到管理
     */
    public function attendenceRecordAction(){
        //$this->count = 1;
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $list = array();

        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }
        //会员编号查询
        $output['showId'] = $this->request->getIntParam('showId');
        if($output['showId']){
            $where[] = array('name' => 'm_show_id', 'oper' => '=', 'value' => $output['mid']);
        }
        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 'ps_last_signtime', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 'ps_last_signtime', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }
        $sort = array('ps_last_signtime'=>'DESC');
        $sign_model = new App_Model_Point_MysqlPointSignStorage($this->curr_sid);
        $total = $sign_model->getListMemberCount($where);

        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $output['paginator'] = $page_plugin->render();

        if($total > $index){
            $list = $sign_model->getListMember($where,$index,$this->count,$sort);

        }
        $this->buildBreadcrumbs(array(
            array('title' => '会员管理', 'link' => '#'),
            array('title' => '签到记录', 'link' => '#'),
        ));
        $output['list'] = $list;
        $this->showOutput($output);
        $this->displaySmarty('wxapp/member/attendence-record.tpl');
    }


    //导出订单  拼团+商城订单
    public function excelOrderAction(){
        $startDate  = $this->request->getStrParam('startDate');
        $startTime  = $this->request->getStrParam('startTime');
        $endDate    = $this->request->getStrParam('endDate');
        $endTime    = $this->request->getStrParam('endTime');
        $esId       = $this->request->getIntParam('esId');
        $addressOrder = $this->request->getStrParam('addressOrder');
        if($startDate && $startTime && $endDate && $endTime){
            $start = $startDate.' '.$startTime;
            $end = $endDate.' '.$endTime;
            $startTime  = strtotime($start);
            $endTime    = strtotime($end);
            $where      = array();
            $where[]    = array('name'=>'t_create_time','oper'=>'>=','value'=>$startTime);
            $where[]    = array('name'=>'t_create_time','oper'=>'<','value'=>$endTime);
            $orderStatus = $this->request->getStrParam('orderStatus','all');

            $sort       = array('t_create_time' => 'DESC');
            if($addressOrder=='on'){
                $sort = array('ma_province' => 'DESC', 'ma_city' => 'DESC' , 'ma_zone' => 'DESC', 'ma_detail' => 'DESC');
            }
            //筛选配送方式
            $postType = $this->request->getIntParam('postType');
            if($postType){
                $where[] = array('name'=>'t_express_method','oper'=>'=','value'=>$postType);
            }
            //检索条件整理
            $where[]    = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[]    = array('name'=>'t_es_id','oper'=>'=','value'=>$esId);
            $where[]    = array('name'=>'t_status','oper'=>'>','value'=>0);
            $where[]    = array('name'=>'t_type','oper'=>'=','value'=>5);
            $goodstitle = $this->request->getStrParam('goodstitle');
            if($goodstitle){
                $title = str_replace(" ", "", $goodstitle);
                $where[]= array('name'=>'replace(t_title, " ", "")','oper'=>'like','value'=>"%{$title}%");
            }
            $link = App_Helper_Trade::$trade_link_status;
            if($orderStatus && isset($link[$orderStatus]) && $link[$orderStatus]['id'] > 0){
                $where[]= array('name'=>'t_status','oper'=>'=','value'=>$link[$orderStatus]['id']);
            }
            //数据展示
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
            $list = $trade_model->getAddressList($where,0,0,$sort);
            if(!empty($list)){
                $tradePay   =  App_Helper_Trade::$trade_pay_type;
                $groupType  =  plum_parse_config('group_type');
                $statusNote = plum_parse_config('trade_status');
                $expressMethod = array(
                    1 => '商家配送',
                    2 => '门店自取',
                    3 => '快递发货'
                );
                $newlist  = array();
                $newslist = array();
                foreach($list as $key => $val){

                    //一单多个商品情况
                    $trade_order        = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
                    $goodsList          = $trade_order->getGoodsListByTid($val['t_id']);

                    foreach($goodsList as $k => $v){

                        //订单编号、会员名称、收货人、电话、收货人省份、收货人城市、收货人地区、收货地址、邮编
                        $newlist['t_tid']           = $val['t_tid'];
                        $newlist['t_buyer_nick']    = $val['t_buyer_nick'];
                        $newlist['s_name']          = $val['ma_name'];
                        $newlist['s_phone']         = $val['ma_phone'];
                        $newlist['s_province']      = $val['ma_province'];
                        //判断是否直辖市 如果直辖市 则市等于省
                        if(in_array($val['ma_province'],array('北京市','上海市','天津市','重庆市'))){
                            $city = $val['ma_province'];
                        }else{
                            $city = $val['ma_city'];
                        }
                        $newlist['s_city']          = $city;
                        $newlist['s_zone']          = $val['ma_zone'];
                        $newlist['s_detail']        = $val['ma_detail'];
                        $newlist['s_post']          = $val['ma_post'];
                        //商品标题、商品订单规格、商品订单数量、商品价格
                        $newlist['g_title']         = $v['to_title'];
                        $newlist['g_gg']            = $v['gf_name'];
                        $newlist['g_tp']            = $v['to_price'];
                        $newlist['g_num']           = $v['to_num'];
                        $newlist['g_price']         = $v['to_total'];
                        $newlist['o_goods_price']   = $val['t_goods_fee'];
                        $newlist['o_post_price']    = $val['t_post_fee'];
                        $newlist['o_total_price']   = $val['t_total_fee'];
                        $newlist['o_discount_fee']   = $val['t_discount_fee'];
                        $newlist['o_promotion_fee']  = $val['t_promotion_fee'];
                        //优惠方式  间隔
                        $newlist['o_pay']           = $val['t_payment'];
                        //物流公司、物流单号、订单状态（是否发货）、购买方式（支付宝，微信，银行卡）、商家编码(商品)商品编号等信息、维权信息（退，换）
                        $newlist['o_exp_company']   = $val['t_express_company'];
                        $newlist['o_exp_code']      = $val['t_express_code'];
                        if($val['t_status'] == 8){
                            $newlist['o_status']    = '已退款';
                        }else{
                            $newlist['o_status']    = $statusNote[$val['t_status']];
                        }
                        $newlist['o_paytype']       = $tradePay[$val['t_pay_type']];
                        //商家编码信息、维权信息（退，换）、订单来源（直购，什么拼团，积分）、
                        //是否为团长订单、订单创建时间、订单付款时间、订单商家备注、订单用户备注、商品发货时间、交易完成时间
                        $newlist['o_createtime']    = $val['t_create_time'] ? date('Y-m-d H:i:s',$val['t_create_time']) : '';
                        $newlist['o_paytime']       = $val['t_pay_time'] ? date('Y-m-d H:i:s',$val['t_pay_time']) : '';
                        $newlist['o_sale_note']     = $val['t_note']?'备注: '.$val['t_note'].';':'';
                        foreach (json_decode($val['t_remark_extra'], true) as $v){
                            if($v['value']){
                                $newlist['o_sale_note'] .= $v['name'].':'.$v['value'].';';
                            }
                        }

                        $newlist['o_sendtime']      = $val['t_express_time'] ? date('Y-m-d H:i:s',$val['t_express_time']) : '';
                        $newlist['o_finishtime']    = $val['t_finish_time'] ? date('Y-m-d H:i:s',$val['t_finish_time']) : '';
                        $newlist['o_store_name']         = $val['os_name'] ? $val['os_name'] : '';
                        $newlist['o_express_method']         = $expressMethod[$val['t_express_method']];//配送方式
                        $newslist[] = $newlist;
                    }
                    $columNums[$key] = count($goodsList);
                }
                $filename  = 'orders.xls';
                if(!empty($newslist)){
                    $plugin    = new App_Plugin_PHPExcel_PHPExcelPlugin();
                    $plugin->down_orders($newslist,$filename, $columNums);
                    die();
                }
            }else{
                plum_url_location('当前时间段内没有订单!');
            }
        }else{
            plum_url_location('日期请填写完整!');
        }
    }

    /**
     * 导出会员数据
     */
    public function importMemberAction(){
        $adminMember = $this->request->getStrParam('adminMember');
        $startDate  = $this->request->getStrParam('startDate');
        $startTime  = $this->request->getStrParam('startTime');
        $endDate    = $this->request->getStrParam('endDate');
        $endTime    = $this->request->getStrParam('endTime');

        $nickname = $this->request->getStrParam('excel_nickname');
        $showid = $this->request->getStrParam('excel_showid');
        $mobile = $this->request->getStrParam('excel_mobile');
        $source = $this->request->getIntParam('excel_source');
        $level = $this->request->getIntParam('excel_level');
        $category = $this->request->getIntParam('excel_category');
        $authorization = $this->request->getIntParam('excel_authorization',-1);

        $startTime = $startTime ? $startTime : '00:00:01';
        $endTime = $endTime ? $endTime : '23:59:59';

        if($startDate && $startTime && $endDate && $endTime){
            $start = $startDate.' '.$startTime;
            $end   = $endDate.' '.$endTime;
            $startTime  = strtotime($start);
            $endTime    = strtotime($end);
            $where      = array();
            $where[]    = array('name'=>'m_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[]    = array('name'=>'unix_timestamp(m_follow_time)','oper'=>'>=','value'=>$startTime);
            $where[]    = array('name'=>'unix_timestamp(m_follow_time)','oper'=>'<','value'=>$endTime);

            if($showid){
                $where[] = ['name'=>'m_show_id','oper'=>'=','value'=>$showid];
            }
            if($mobile){
                $where[] = ['name'=>'m_mobile','oper'=>'=','value'=>$mobile];
            }
            if($source){
                $where[] = ['name'=>'m_source','oper'=>'=','value'=>$source];
            }
            if($level){
                $where[] = ['name'=>'m_level','oper'=>'=','value'=>$level];
            }
            if($category){
                $where[] = ['name'=>'m_level','oper'=>'=','value'=>$level];
            }
            if($authorization >= 0){
                $where[] = ['name'=>'m_is_slient','oper'=>'=','value'=>$authorization];
            }


            // if($adminMember!='on'){
            //     $where[]    = array('name'=>'m_source','oper'=>'!=','value'=>5);
            // }
            if($nickname){
                $where[] = ['name'=>'m_nickname','oper'=>'like','value'=>"%{$nickname}%"];
            }

            $sort       = array('unix_timestamp(m_follow_time)' => 'DESC');
            //检索条件整理
            //数据展示
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $list = $member_model->getMemberExtraList($where,0,0,$sort);

            if(count($list) > 10000){
                plum_url_location('当前时间段数据量过多，请重新选择时间');
            }
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $level_list = $level_model->getListBySidForSelect($this->curr_sid);
            $category_list = $this->_get_member_category();
            $memberSource  = array(
                1 => '公众号',2=>'小程序',3=>'客户端',5=>'后台添加'
            );

            if(!empty($list)){
                $date       = date('Ymd',$_SERVER['REQUEST_TIME']);
                //数据处理
                $rows  = array();
                $rows[]  = array('昵称','用户编号','openID','手机号','真实姓名','用户等级','用户分类','用户来源','余额','积分','关注时间','备注');
                $width   = array(
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
                );

                foreach($list as $key => $val){

                    $level_name = $level_list[$val['m_level']] ? $level_list[$val['m_level']] : '无';
                    $category_name = $category_list[$val['ame_cate']]['mc_name'] ? $category_list[$val['ame_cate']]['mc_name'] : '无';
                    $source_name = $memberSource[$val['m_source']] ? $memberSource[$val['m_source']] : '小程序';


                    $rows[] = array(
                        $this->utf8_str_to_unicode($val['m_nickname']),
                        $val['m_show_id'],
                        $val['m_openid'],
                        $val['m_mobile'],
                        $val['m_realname'],
                        $level_name,
                        $category_name,
                        $source_name,
                        $val['m_gold_coin'],
                        $val['m_points'],
                        $val['m_follow_time'],
                        $val['m_remark']
                    );
                }
                $excel = new App_Plugin_PHPExcel_PHPExcelPlugin();
                $excel->down_common_excel($rows,$date.'会员导出.xls',$width);
            }else{
                plum_url_location('当前时间段内没有会员!');
            }
        }else{
            plum_url_location('日期请填写完整!');
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

    public function saveRemarkAction(){
        $mid = $this->request->getIntParam('mid');
        $source = $this->request->getIntParam('source');
        $remark = $this->request->getStrParam('remark');
        $data = [
            'm_remark' => $remark,
            'm_update_time' => time()
        ];

        //后台添加用户
        if($source == 5){
            $avatar = $this->request->getStrParam('avatar');
            $nickname = $this->request->getStrParam('nickname');
            if(!$avatar || !$nickname){
                $this->displayJsonError('昵称或头像不能为空');
            }
            $data['m_avatar'] = $avatar;
            $data['m_nickname'] = $nickname;
        }

        $member_model = new App_Model_Member_MysqlMemberCoreStorage($this->curr_sid);
        $res = $member_model->updateById($data,$mid);

        if($res){
            $member = $member_model->getRowById($mid);
            App_Helper_OperateLog::saveOperateLog("用户【{$member['m_nickname']}】信息修改成功");
        }

        $this->showAjaxResult($res,'保存');
    }

    /**
     * 会员详情
     */
    public function memberDetailAction(){
        $id             = $this->request->getIntParam('id');
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $crop           = new Libs_Image_Crop_Cropper($this->curr_shop['s_unique_id'], 200, 140, '/index/logoUpload/w/600/h/420', 'logo','景点logo图',false);
        $detail         = $member_model->getRowById($id);
        $this->output['detail']      = $detail;
        $this->output['avatar']   = $crop->fetchHtml($detail['m_avatar']);
        $this->buildBreadcrumbs(array(
            array('title' => '会员信息', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty("wxapp/member/member-show.tpl");
    }


    public function memberDetailNewAction(){
        $id             = $this->request->getIntParam('id');

        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $row         = $member_model->getMemberExtraRow($id);
        //获得会员等级
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $this->output['mLevel'] = $mLevel = $level_model->getListBySidForSelect($this->curr_sid);

        //获得最新一条会员卡购买记录
        $order_model = new App_Model_Store_MysqlOrderStorage($this->curr_sid);
        $where = [];
        $timeNow = time();
        $where[] = ['name' => 'oo_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where[] = ['name' => 'oo_m_id', 'oper' => '=', 'value' => $id];
        $sort = ['oo_create_time'=>'desc'];
        $order = $order_model->getList($where,0,1,$sort)[0];
        $this->output['memberCategory'] = $memberCategory = $this->_get_member_category();
        $data = [
            'source' => $row['m_source'],
            'showId' => $row['m_show_id'],
            'avatar' => $row['m_avatar'] ? $row['m_avatar'] : '/public/wxapp/images/applet-avatar.png',
            'nickname' => $row['m_nickname'],
            'mobile'   => $row['m_mobile'] ? $row['m_mobile'] : ($order['oo_telphone'] ? $order['oo_telphone'] : '无'),
            'truename'   => $row['m_realname'] ? $row['m_realname'] : ($order['oo_name'] ? $order['oo_name'] : '无'),
            'birthday'   => $order['oo_birthday'] && $order['oo_birthday'] != 'null' ? $order['oo_birthday'] : '无',
            'sex' => $row['m_sex'],
            'level' => $row['m_level'] ? $mLevel[$row['m_level']] : '无',
            'status' => $row['m_status'],
            'address' => $row['m_province'] || $row['m_city'] ? $row['m_province'].' '.$row['m_city'] : '无',
            'openid' => $row['m_openid'],
            'coin' => $row['m_gold_coin'],
            'tradeNum' => $row['m_traded_num'],
            'tradeMoney' => $row['m_traded_money'],
            'point' => $row['m_points'],
            'followTime' => $row['m_follow_time'] ? $row['m_follow_time'] : '',
            'm_1f_id' => $row['m_1f_id'],
            'mid' => $row['m_id'],
            'levelId' => $row['m_level'],
            'remark' => $row['m_remark'],
            'category' => $row['ame_cate'] > 0 && $memberCategory[$row['ame_cate']] ? $memberCategory[$row['ame_cate']]['mc_name'] : '无'
        ];

        $update = [];
        $brith = '';
        if(!$row['m_mobile'] && $order['oo_telphone']){
            $update['m_mobile'] = $order['oo_telphone'];
        }
        if(!$row['m_realname'] && $order['oo_name']){
            $update['m_realname'] = $order['oo_name'];
        }
        if(!$row['ame_birth'] && $order['oo_birthday'] && $order['oo_birthday'] != 'null'){
            $brith = $order['oo_birthday'];
        }
        if(!empty($update)){
            $member_model->updateById($update,$row['m_id']);
        }
        if($brith){
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->curr_sid);
            $extra_model->findUpdateExtraByMid($row['m_id'],['ame_birth' => $brith,'ame_update_time' => time()]);
        }


        //获得会员卡
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->curr_sid);
        $where_offline = [];
        $where_offline[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where_offline[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $id);
        $where_offline[]    = array('name' => 'om_type', 'oper' => '=', 'value' => 2);
        $where_offline[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => $timeNow);
        $member_card    = $offline_member->getList($where_offline, 0, 0, array('om_update_time' => 'desc'));
        $cardid = $member_card[0]['om_card_id'];
        $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
        $card   = $card_model->getRowById($cardid);
        $data['offlineCard'] = $card['oc_name'] ? $card['oc_name'] : '无';

        //获得用户未使用优惠券数量
        $where_going = [];
        $where_going[] = ['name' => 'cl_s_id','oper' => '=','value' =>$this->curr_sid];
        $where_going[] = ['name' => 'cr_m_id','oper' => '=','value' =>$id];
        $where_going[] = ['name' => 'cl_coupon_type','oper' => '=','value' =>0];
        $coupon_model = new App_Model_Coupon_MysqlReceiveStorage($this->curr_sid);
        $coupon_count = $coupon_model->getReceiveStat($where_going,'going');
        $data['couponCount'] = intval($coupon_count['total']);

        //获得下级数量和上级名称
        $where_three = [];
        $where_three[] = ['name' => 'm_id', 'oper' => '=', 'value' => $id];
        $three_row = $member_model->getMemberBySubordinateRow($where_three);
        $three_list[] = $three_row;
        $this->output['level'] = $this->show_member_level_info($three_row);
//        $three_count_arr = [];
        $threeTotal = 0;
        for ($i=1; $i<=3; $i++) {
            $where_three_count = [];
            $where_three_count[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where_three_count[] = array('name' => 'm_'.$i.'f_id', 'oper' => '=', 'value' => $id);
            $three_total = $member_model->getCount($where_three_count);
//            $three_count_arr['total'.$i] = $three_total;
            $threeTotal += $three_total;
        }
        $data['threeTotal'] = $threeTotal;
//        var_dump($three_count_arr);die;
        $checkArr = $this->_check_show_hide();
        $this->output['showStatus'] = $checkArr['showStatus'];
        $this->output['hideThree'] = $checkArr['hideThree'];
        $this->output['hideCoin'] = $checkArr['hideCoin'];
        $this->output['hideCoupon'] = $checkArr['hideCoupon'];
        $this->output['hideLevel'] = $checkArr['hideLevel'];
        $this->output['hideCard'] = $checkArr['hideCard'];
        $this->output['hidePoints'] = $checkArr['hidePoints'];


        $this->output['row']      = $data;

        $this->buildBreadcrumbs(array(
            array('title' => '用户管理', 'link' => '#'),
            array('title' => '用户列表', 'link' => '/wxapp/member/list'),
            array('title' => '用户基本资料', 'link' => '#'),
        ));
        $this->_detail_table_link_show('detail',$id);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty("wxapp/member/member-detail.tpl");
    }
    /*
     * 通用检查隐藏和显示
     */
    private function _check_show_hide(){
        $showStatus = 0;//显示用户状态
        $hideThree = 0;//隐藏分销
        $hideCountCard = 0;//隐藏计次卡
        $hideCoupon = 0;//隐藏优惠券
        $hideCoin = 0;//隐藏余额
        $hideLevel = 0;//隐藏会员等级
        $hideCard = 0; //隐藏会员卡
        if(in_array($this->wxapp_cfg['ac_type'],[6,21,26])){
            $showStatus = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],[1,2,3,4,7,9,10,11,13,15,16,17,19,20,26,28,30,32,33,34])){
            $hideThree = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],[2,6,8,9,10,11,16,19,26,27,28,30,32,33,34])){
            $hideCountCard = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],[3,9,10,11,12,16,19,26,27,28,33])){
            $hideCoin = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],[3,9,10,16,19,26,28,30,33])){
            $hideCoupon = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],[2,3,9,10,11,19,26,28,30,33,34])){
            $hideLevel = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],[2,3,9,10,11,19,26,28,30,33,34])){
            $hideCard = 1;
        }
        $hidePoints = 0;//隐藏积分
        if(in_array($this->wxapp_cfg['ac_type'],[34])){
            $hidePoints = 1;
        }


        $data = [
            'showStatus' => $showStatus,
            'hideThree' => $hideThree,
            'hideCountCard' => $hideCountCard,
            'hideCoin' => $hideCoin,
            'hideCoupon' => $hideCoupon,
            'hideLevel' => $hideLevel,
            'hideCard' => $hideCard,
            'hidePoints' => $hidePoints,
        ];
        return $data;
    }

    /*
     * 新会员详情顶部导航
     */
    private function _detail_table_link_show($key,$mid){
        $checkArr = $this->_check_show_hide();
        $data = array(
            'detail' => array(
                'name' => '用户信息明细',
                'link' => '/wxapp/member/memberDetailNew?id='.$mid,
                'icon' => 'user'
            ),
        );

        if(!$checkArr['hideCoin']){
            $data['coin'] = [
                'name' => '储值明细',
                'link' => '/wxapp/member/memberCoinRecord?mid='.$mid,
                'icon' => 'money'
            ];
        }
        if(!$checkArr['hidePoint']){
            $data['point'] = [
                'name' => '积分明细',
                'link' => '/wxapp/member/memberPointRecord?mid='.$mid,
                'icon' => 'star'
            ];
        }
        if(!$checkArr['hideCard']){
            $data['card'] = [
                'name' => '会员卡明细',
                'link' => '/wxapp/member/memberCardOrder?mid='.$mid,
                'icon' => 'qrcode'
            ];
        }
        if(!$checkArr['hideCoupon']){
            $data['coupon'] = [
                'name' => '优惠券明细',
                'link' => '/wxapp/member/memberCouponRecord?mid='.$mid,
                'icon' => 'tag'
            ];
        }
        if(!$checkArr['hideCountCard']){
            $data['countcard'] = [
                'name' => '计次卡明细',
                'link' => '/wxapp/member/memberCountCardOrder?mid='.$mid,
                'icon' => 'barcode'
            ];
        }

        $this->output['tabKey']  = $key;
        $this->output['tabLink'] = $data;
    }

    /**
     * 余额记录
     */
    public function memberCoinRecordAction(){
        $page           = $this->request->getIntParam('page');
        $status         = $this->request->getIntParam('status',1);
        $mid            = $this->request->getIntParam('mid');
        $start   = $this->request->getStrParam('start');
        $end     = $this->request->getStrParam('end');
        $index          = $page * $this->count;
        $where          = array();
        $where[]        = array('name' => 'rr_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]        = array('name' => 'rr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]        = array('name' => 'rr_status', 'oper' => '=', 'value' => $status);
        if($start){
            $where[]    = ['name' => 'rr_create_time', 'oper' => '>=', 'value' => strtotime($start)];
        }
        if($end){
            $where[]    = ['name' => 'rr_create_time', 'oper' => '<=', 'value' => (strtotime($end) + 86400)];
        }
        $recharge_model = new App_Model_Member_MysqlRechargeStorage($this->curr_sid);
        $total          = $recharge_model->getMemberCount($where);
        $list           = array();
        if($total > $index){
            $sort       = array('rr_create_time' => 'DESC');
            $list       = $recharge_model->getMemberList($where,$index,$this->count,$sort);
        }
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $paginator      = $pageCfg->render();

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($mid);

        $this->output['paginator'] = $paginator;
        $this->output['list']      = $list;
        $this->output['status']    = $status;
        $this->output['mid']       = $mid;
        $this->output['member']    = $member;
        $this->output['start'] = $start;
        $this->output['end'] = $end;
        $this->buildBreadcrumbs(array(
            array('title' => '用户管理', 'link' => '#'),
            array('title' => '用户列表', 'link' => '/wxapp/member/list'),
            array('title' => '充值记录', 'link' => '#'),
        ));
        $this->_detail_table_link_show('coin',$mid);
        $this->displaySmarty("wxapp/member/member-coin-record.tpl");
    }

    /**
     * 积分记录
     */
    public function memberPointRecordAction(){
        $page           = $this->request->getIntParam('page');
        $status         = $this->request->getIntParam('status',1);
        $mid            = $this->request->getIntParam('mid');
        $start   = $this->request->getStrParam('start');
        $end     = $this->request->getStrParam('end');
//        $this->count = 3;
        $index          = $page * $this->count;
        $where          = array();
        $where[]        = array('name' => 'pi_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]        = array('name' => 'pi_m_id', 'oper' => '=', 'value' => $mid);
        $where[]        = array('name' => 'pi_type', 'oper' => '=', 'value' => $status);
        if($start){
            $where[]    = ['name' => 'pi_create_time', 'oper' => '>=', 'value' => strtotime($start)];
        }
        if($end){
            $where[]    = ['name' => 'pi_create_time', 'oper' => '<=', 'value' => (strtotime($end) + 86400)];
        }
        $recharge_model = new App_Model_Point_MysqlInoutStorage($this->curr_sid);
        $total          = $recharge_model->getCount($where);
        $list           = array();
        if($total > $index){
            $sort       = array('pi_create_time' => 'DESC');
            $list       = $recharge_model->getList($where,$index,$this->count,$sort);
        }
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $paginator      = $pageCfg->render();

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($mid);

        $this->output['paginator'] = $paginator;
        $this->output['list']      = $list;
        $this->output['status']    = $status;
        $this->output['mid']       = $mid;
        $this->output['member']    = $member;
        $this->output['start'] = $start;
        $this->output['end'] = $end;
        $this->buildBreadcrumbs(array(
            array('title' => '用户管理', 'link' => '#'),
            array('title' => '用户列表', 'link' => '/wxapp/member/list'),
            array('title' => '积分明细', 'link' => '#'),
        ));
        $this->_detail_table_link_show('point',$mid);
        $this->displaySmarty("wxapp/member/member-point-record.tpl");
    }

    /**
     * 会员卡购买记录
     */
    public function memberCardOrderAction(){
        $page           = $this->request->getIntParam('page');
        $status         = $this->request->getIntParam('status',1);
        $mid            = $this->request->getIntParam('mid');
        $start   = $this->request->getStrParam('start');
        $end     = $this->request->getStrParam('end');
//        $this->count = 3;
        $index          = $page * $this->count;
        $sort    = array('oo_create_time' => 'DESC');
        $where   = array();
        $where[] = array('name' => 'oo_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'oo_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'oo_card_type', 'oper' => '=', 'value' => 2);
        $where[] = array('name' => 'oo_status', 'oper' => '=', 'value' => 2);//只查已付款

        if($start){
            $where[]    = ['name' => 'oo_pay_time', 'oper' => '>=', 'value' => strtotime($start)];
        }
        if($end){
            $where[]    = ['name' => 'oo_pay_time', 'oper' => '<=', 'value' => (strtotime($end) + 86400)];
        }

        $recharge_model = new App_Model_Store_MysqlOrderStorage($this->curr_sid);
        $total          = $recharge_model->getMemberCardCount($where);
        $list           = array();
        if($total > $index){
            $list       = $recharge_model->getMemberCardList($where,$index,$this->count,$sort);
        }
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $paginator      = $pageCfg->render();

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($mid);

        $this->output['paginator'] = $paginator;
        $this->output['list']      = $list;
        $this->output['status']    = $status;
        $this->output['mid']       = $mid;
        $this->output['member']    = $member;
        $this->output['start'] = $start;
        $this->output['end'] = $end;

        //获得会员卡
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->curr_sid);
        $where_offline = [];
        $where_offline[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where_offline[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        $where_offline[]    = array('name' => 'om_type', 'oper' => '=', 'value' => 2);
        $where_offline[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
        $member_card    = $offline_member->getList($where_offline, 0, 0, array('om_update_time' => 'desc'));
        if(!$member_card){
            //获得最近一条过期的
            $where_offline = [];
            $where_offline[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where_offline[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
            $where_offline[]    = array('name' => 'om_type', 'oper' => '=', 'value' => 2);
            $member_card    = $offline_member->getList($where_offline, 0, 0, array('om_update_time' => 'desc'));
        }
        $cardid = $member_card[0]['om_card_id'];
        $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
        $card   = $card_model->getRowById($cardid);
        $offlineCard['cardTitle'] = $card['oc_name'] ? $card['oc_name'] : '';
        $offlineCard['expireTime'] = $member_card[0]['om_expire_time'] ?date('Y-m-d',$member_card[0]['om_expire_time']) : '';
        $offlineCard['expireStatus'] = $member_card[0]['om_expire_time'] && $member_card[0]['om_expire_time'] >time() ? 1 : 2;
        $this->output['offlineCard'] = $offlineCard;

        $this->buildBreadcrumbs(array(
            array('title' => '用户管理', 'link' => '#'),
            array('title' => '用户列表', 'link' => '/wxapp/member/list'),
            array('title' => '会员卡明细', 'link' => '#'),
        ));
        $this->_detail_table_link_show('card',$mid);
        $this->displaySmarty("wxapp/member/member-card-order.tpl");
    }

    /**
     * 会员优惠券明细
     */
    public function memberCouponRecordAction(){
        $page    = $this->request->getIntParam('page');
        $type    = $this->request->getStrParam('type','going');
        $mid     = $this->request->getIntParam('mid');
        $start   = $this->request->getStrParam('start');
        $end     = $this->request->getStrParam('end');
//        $this->count = 3;
        $index          = $page * $this->count;
        $sort    = array('cl_update_time' => 'DESC');
        $where   = array();
        $where_total = [];
        $where[] = $where_total[] = array('name' => 'cr_s_id', 'oper' => '=', 'value' => $this->curr_sid);
//        $where[] = $where_total[] = array('name' => 'cl_coupon_type','oper' => '=','value' =>0);
        $where[] = $where_total[] = array('name' => 'cr_m_id', 'oper' => '=', 'value' => $mid);
        $timeNow = time();
        if($type == 'used'){
            //已使用
            $where[] = ['name' => 'cr_is_used', 'oper' => '=', 'value' => 1];
        }
        if($type == 'going'){
            //未使用未到期
            $where[] = ['name' => 'cr_is_used', 'oper' => '=', 'value' => 0];
            $where[] = ['name' => 'cl_start_time','oper' => '<','value' =>$timeNow];
            $where[] = ['name' => 'cl_end_time','oper' => '>','value' =>$timeNow];
        }
        if($type == 'expire'){
            //未使用已到期
            $where[] = ['name' => 'cr_is_used', 'oper' => '=', 'value' => 0];
//            $where[] = ['name' => 'cl_end_time','oper' => '!=','value' =>0];
            $where[] = ['name' => 'cl_end_time','oper' => '<','value' =>$timeNow];
        }

        if($start){
            $where[]    = ['name' => 'cl_update_time', 'oper' => '>=', 'value' => strtotime($start)];
        }
        if($end){
            $where[]    = ['name' => 'cl_update_time', 'oper' => '<=', 'value' => (strtotime($end) + 86400)];
        }

        $recharge_model = new App_Model_Coupon_MysqlReceiveStorage($this->curr_sid);
        $total          = $recharge_model->getReceiveCount($where);
        $list           = array();
        if($total > $index){
            $list       = $recharge_model->getReceiveList($where,$index,$this->count,$sort);
        }
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $paginator      = $pageCfg->render();

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($mid);

        if($list){
            foreach ($list as $key => $val){
                if($val['cr_is_used'] == 0){
                    if($val['cl_start_time'] < $timeNow && $val['cl_end_time'] > $timeNow){
                        $list[$key]['currStatus'] = 0;
                    }else{
                        $list[$key]['currStatus'] = 2;
                    }
                }else{
                    $list[$key]['currStatus'] = 1;
                }
            }
        }

        $this->output['paginator'] = $paginator;
        $this->output['list']      = $list;
        $this->output['type']    = $type;
        $this->output['mid']       = $mid;
        $this->output['member']    = $member;
        $this->output['start'] = $start;
        $this->output['end'] = $end;

        $usedStat =  $recharge_model->getReceiveStat($where_total,'used');
        $goingStat =  $recharge_model->getReceiveStat($where_total,'going');
        $expireStat =  $recharge_model->getReceiveStat($where_total,'expire');
        $statInfo['usedTotal'] = intval($usedStat['total']);
        $statInfo['usedMoney'] = floatval($usedStat['money']);
        $statInfo['goingTotal'] = intval($goingStat['total']);
        $statInfo['goingMoney'] = floatval($goingStat['money']);
        $statInfo['expireTotal'] = intval($expireStat['total']);
        $statInfo['expireMoney'] = floatval($expireStat['money']);
        $this->output['statInfo'] = $statInfo;

        $this->buildBreadcrumbs(array(
            array('title' => '用户管理', 'link' => '#'),
            array('title' => '用户列表', 'link' => '/wxapp/member/list'),
            array('title' => '优惠券明细', 'link' => '#'),
        ));
        $this->_detail_table_link_show('coupon',$mid);
        $this->displaySmarty("wxapp/member/member-coupon-record.tpl");
    }

    /**
     * 计次卡购买记录
     */
    public function memberCountCardOrderAction(){
        $page           = $this->request->getIntParam('page');
        $status         = $this->request->getIntParam('status',1);
        $mid            = $this->request->getIntParam('mid');
        $start   = $this->request->getStrParam('start');
        $end     = $this->request->getStrParam('end');
//        $this->count = 3;
        $index          = $page * $this->count;
        $sort    = array('oo_create_time' => 'DESC');
        $where   = array();
        $where[] = array('name' => 'oo_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'oo_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'oo_card_type', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'oo_status', 'oper' => '=', 'value' => 2);//只查已付款

        if($start){
            $where[]    = ['name' => 'oo_pay_time', 'oper' => '>=', 'value' => strtotime($start)];
        }
        if($end){
            $where[]    = ['name' => 'oo_pay_time', 'oper' => '<=', 'value' => (strtotime($end) + 86400)];
        }

        $recharge_model = new App_Model_Store_MysqlOrderStorage($this->curr_sid);
        $total          = $recharge_model->getMemberCardCount($where);
        $list           = array();
        if($total > $index){
            $list       = $recharge_model->getMemberCardList($where,$index,$this->count,$sort);
        }
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $paginator      = $pageCfg->render();

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($mid);

        $this->output['paginator'] = $paginator;
        $this->output['list']      = $list;
        $this->output['status']    = $status;
        $this->output['mid']       = $mid;
        $this->output['member']    = $member;
        $this->output['start'] = $start;
        $this->output['end'] = $end;

        //同城版关联入驻店铺
        if($this->wxapp_cfg['ac_type'] == 6){
            $store_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
            $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);//未删除
            $this->output['storeList'] = $store_model->getList($where,0,0,array(),array(),true);

            $old_store_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
            $this->output['storeListOld'] = $old_store_model->getAllListBySid();

        }else{
            $store_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
            $this->output['storeList'] = $store_model->getAllListBySid();
        }

        //获得会员卡
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->curr_sid);
        $where_offline = [];
        $where_offline[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where_offline[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        $where_offline[]    = array('name' => 'om_type', 'oper' => '=', 'value' => 1);
        $where_offline[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
        $member_card    = $offline_member->getList($where_offline, 0, 0, array('om_update_time' => 'desc'));
        if(!$member_card){
            //获得最近一条过期的
            $where_offline = [];
            $where_offline[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where_offline[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
            $where_offline[]    = array('name' => 'om_type', 'oper' => '=', 'value' => 1);
            $member_card    = $offline_member->getList($where_offline, 0, 0, array('om_update_time' => 'desc'));
        }
        $cardid = $member_card[0]['om_card_id'];
        $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
        $card   = $card_model->getRowById($cardid);
        $offlineCard['cardTitle'] = $card['oc_name'] ? $card['oc_name'] : '';
        $offlineCard['expireTime'] = $member_card[0]['om_expire_time'] ?date('Y-m-d',$member_card[0]['om_expire_time']) : '';
        $offlineCard['leftNum'] = $member_card[0]['om_left_num'] ? $member_card[0]['om_left_num'] : 0;
        $offlineCard['cardNum'] = $member_card[0]['om_card_num'] ? $member_card[0]['om_card_num'] : '';
        $offlineCard['expireStatus'] = $member_card[0]['om_expire_time'] && $member_card[0]['om_expire_time'] >time() ? 1 : 2;
        $this->output['offlineCard'] = $offlineCard;
        $this->output['urlType'] = 'order';
        $this->buildBreadcrumbs(array(
            array('title' => '用户管理', 'link' => '#'),
            array('title' => '用户列表', 'link' => '/wxapp/member/list'),
            array('title' => '计次卡明细', 'link' => '#'),
        ));
        $this->_detail_table_link_show('countcard',$mid);
        $this->displaySmarty("wxapp/member/member-countCard-order.tpl");
    }


    /**
     * 计次卡核销记录
     */
    public function memberCountCardVerifyAction(){
        $page           = $this->request->getIntParam('page');
        $status         = $this->request->getIntParam('status',1);
        $mid            = $this->request->getIntParam('mid');
//        $this->count = 3;
        $index          = $page * $this->count;
        $sort    = array('ov_record_time' => 'DESC');
        $where   = array();
        $where[] = array('name' => 'ov_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'ov_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'ov_type', 'oper' => '=', 'value' => 1);

        $recharge_model = new App_Model_Store_MysqlVerifyStorage($this->curr_sid);
        $total          = $recharge_model->getStoreMemberCount($where);
        $list           = array();
        if($total > $index){
            $list       = $recharge_model->getStoreMemberList($where,$index,$this->count,$sort);
        }
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $paginator      = $pageCfg->render();

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($mid);

        $this->output['paginator'] = $paginator;
        $this->output['list']      = $list;
        $this->output['status']    = $status;
        $this->output['mid']       = $mid;
        $this->output['member']    = $member;

        //同城版关联入驻店铺
        if($this->wxapp_cfg['ac_type'] == 6){
            $store_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
            $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);//未删除
            $this->output['storeList'] = $store_model->getList($where,0,0,array(),array(),true);

            $old_store_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
            $this->output['storeListOld'] = $old_store_model->getAllListBySid();

        }else{
            $store_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
            $this->output['storeList'] = $store_model->getAllListBySid();
        }


        //获得会员卡
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->curr_sid);
        $where_offline = [];
        $where_offline[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where_offline[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        $where_offline[]    = array('name' => 'om_type', 'oper' => '=', 'value' => 1);
        $where_offline[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
        $member_card    = $offline_member->getList($where_offline, 0, 0, array('om_update_time' => 'desc'));
        if(!$member_card){
            //获得最近一条过期的
            $where_offline = [];
            $where_offline[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where_offline[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
            $where_offline[]    = array('name' => 'om_type', 'oper' => '=', 'value' => 1);
            $member_card    = $offline_member->getList($where_offline, 0, 0, array('om_update_time' => 'desc'));
        }
        $cardid = $member_card[0]['om_card_id'];
        $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
        $card   = $card_model->getRowById($cardid);
        $offlineCard['cardTitle'] = $card['oc_name'] ? $card['oc_name'] : '';
        $offlineCard['expireTime'] = $member_card[0]['om_expire_time'] ?date('Y-m-d',$member_card[0]['om_expire_time']) : '';
        $offlineCard['leftNum'] = $member_card[0]['om_left_num'] ? $member_card[0]['om_left_num'] : 0;
        $offlineCard['cardNum'] = $member_card[0]['om_card_num'] ? $member_card[0]['om_card_num'] : '';
        $offlineCard['expireStatus'] = $member_card[0]['om_expire_time'] && $member_card[0]['om_expire_time'] >time() ? 1 : 2;
        $this->output['offlineCard'] = $offlineCard;
        $this->output['urlType'] = 'verify';
        $this->buildBreadcrumbs(array(
            array('title' => '用户管理', 'link' => '#'),
            array('title' => '用户列表', 'link' => '/wxapp/member/list'),
            array('title' => '计次卡明细', 'link' => '#'),
        ));

        $this->_detail_table_link_show('countcard',$mid);
        $this->displaySmarty("wxapp/member/member-countCard-verify.tpl");
    }

    private function _get_member_category(){
        $where = [];
        $where[] = ['name' => 'mc_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $category_model = new App_Model_Member_MysqlMemberCategoryStorage($this->curr_sid);
        $sort = ['mc_update_time'=>'DESC'];
        $list = $category_model->getList($where,0,0,$sort,[],true);
        return $list ? $list : [];
    }

    /*
     * 分类列表
     */
    public function memberCategoryListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = [];
        $where[] = ['name' => 'mc_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $category_model = new App_Model_Member_MysqlMemberCategoryStorage($this->curr_sid);
        $total = $category_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pagination']   = $pageCfg->render();
        $sort = ['mc_update_time'=>'DESC'];
        $list = $category_model->getList($where,$index,$this->count,$sort);
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '用户管理', 'link' => '#'),
            array('title' => '用户分类', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/member/member-category.tpl');
    }

    /*
     * 保存分类
     */
    public function memberCategorySaveAction(){
        $id = $this->request->getIntParam('id');
        $name = $this->request->getStrParam('name');
        if($name){
            $data = [
                'mc_name' => $name,
                'mc_update_time' => time()
            ];
            $category_model = new App_Model_Member_MysqlMemberCategoryStorage($this->curr_sid);
            if($id){
                $res = $category_model->updateById($data,$id);
            }else{
                $data['mc_create_time'] = time();
                $data['mc_s_id'] = $this->curr_sid;
                $res = $category_model->insertValue($data);
            }
            App_Helper_OperateLog::saveOperateLog("用户分类【".$name."】保存成功");
            $this->showAjaxResult($res,'保存');
        }else{
            $this->displayJsonError('请输入名称');
        }
    }

    /*
     * 删除分类
     */
    public function memberCategoryDeleteAction(){
        $id = $this->request->getIntParam('id');
        $category_model = new App_Model_Member_MysqlMemberCategoryStorage($this->curr_sid);
        $category = $category_model->getRowById($id);
        $res = $category_model->deleteById($id);
        if($res){
            App_Helper_OperateLog::saveOperateLog("用户分类【".$category['mc_name']."】删除成功");
            //将所有此分类的用户分类清零
            $ame_model = new App_Model_Member_MysqlMemberExtraStorage($this->curr_sid);
            $where = [];
            $where[] = ['name' => 'ame_s_id', 'oper' => '=', 'value' => $this->curr_sid];
            $where[] = ['name' => 'ame_cate', 'oper' => '=', 'value' => $id];
            $ame_model->updateValue(['ame_cate'=>0],$where);
        }
        $this->showAjaxResult($res,'删除');
    }

    /*
     * 修改用户分类
     */
    public function changeMemberCategoryAction(){
        $id = $this->request->getIntParam('cate');
        $mid = $this->request->getIntParam('mid');
        $mids    = $this->request->getStrParam('mids','');
        $mid_arr = plum_explode($mids);
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        if($id){
            if(!$mid && empty($mid_arr)){
                $this->displayJsonError('请选择用户');
            }

            // -1为清除分类
            $id = $id == -1 ? 0 : $id;
            $set = ['ame_cate'=>$id,'ame_update_time'=>$_SERVER['REQUEST_TIME']];
            $res_update = 0;
            $res_single = 0;
            $res_insert = 0;
            //批量修改
            if(is_array($mid_arr) && !empty($mid_arr)){
                $updateArr = [];
                $insertArr = [];
                $ame_model = new App_Model_Member_MysqlMemberExtraStorage($this->curr_sid);
                foreach ($mid_arr as $val){
                    $exist = $ame_model->findUpdateExtraByMid($val);
                    if($exist){
                        $updateArr[] = $val;
                    }else{
                        $insertArr[] = "(NULL, {$this->curr_sid}, '{$val}', '{$id}', '{$_SERVER['REQUEST_TIME']}' , '{$_SERVER['REQUEST_TIME']}')" ;
                    }
                }
                if(!empty($updateArr)){
                    $where_update = [];
                    $where_update[] = ['name' => 'ame_s_id', 'oper' => '=', 'value' => $this->curr_sid];
                    $where_update[] = ['name' => 'ame_m_id', 'oper' => 'in', 'value' => $updateArr];
                    $res_update = $ame_model->updateValue($set,$where_update);
                }
                if(!empty($insertArr)){
                    $res_insert = $ame_model->batchInsert($insertArr);
                }
            }
            //单独修改
            if($mid){
                $ame_model = new App_Model_Member_MysqlMemberExtraStorage($this->curr_sid);
                $exist = $ame_model->findUpdateExtraByMid($mid);
                if($exist){
                    $res_single = $ame_model->findUpdateExtraByMid($mid,$set);
                }else{
                    $set['ame_s_id'] = $this->curr_sid;
                    $set['ame_m_id'] = $mid;
                    $set['ame_create_time'] = $_SERVER['REQUEST_TIME'];
                    $res_single = $ame_model->insertValue($set);
                }
            }
            if($res_single || $res_update || $res_insert){
                if($res_single){
                    $member = $member_model->getRowById($mid);
                    App_Helper_OperateLog::saveOperateLog("用户【{$member['m_nickname']}】修改分类成功");
                }elseif (!$res_single && ($res_update || $res_insert)){
                    App_Helper_OperateLog::saveOperateLog("批量修改用户分类成功");
                }

                $this->showAjaxResult(true,'保存');
            }else{
                $this->showAjaxResult(false,'保存');
            }
        }else{
            $this->displayJsonError('请选择分类');
        }

    }

    /**
     * 储值卡充值权益
     */
    public function rechargeRightAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = [];
        $where[] = ['name' => 'rr_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where[] = ['name' => 'rr_deleted', 'oper' => '=', 'value' => 0];
        $right_model = new App_Model_Member_MysqlRechargeRightStorage();
        $total = $right_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pagination']   = $pageCfg->render();
        if($total > $index){
            $sort       = array('rr_money' => 'ASC');
            $list       = $right_model->getList($where,$index,$this->count,$sort);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '会员管理', 'link' => '#'),
            array('title' => '会员充值', 'link' => '/wxapp/member/rechargeChange'),
            array('title' => '充值权益', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/member/recharge-right.tpl');
    }

    /**
     * 保存储值卡权益
     */
    public function saveRechargeRightAction(){
        $id       = $this->request->getIntParam('id');
        $discount = $this->request->getFloatParam('discount');
        $money    = $this->request->getFloatParam('money');

        $data = array(
            'rr_s_id'  => $this->curr_sid,
            'rr_money' => $money,
            'rr_discount' => $discount,
            'rr_update_time' => time()
        );

        $right_model = new App_Model_Member_MysqlRechargeRightStorage();

        if($id){
            $ret = $right_model->updateById($data, $id);
        }else{
            $data['rr_create_time'] = time();
            $ret = $right_model->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("储值卡权益保存成功");
        }

        $this->showAjaxResult($ret);
    }

    /**
     * 删除储值卡权益
     */
    public function delRechargeRightAction(){
        $id = $this->request->getIntParam('id');

        $ret = 0;
        if($id){
            $right_model = new App_Model_Member_MysqlRechargeRightStorage();
            $set = array('rr_deleted' => 1);
            $ret = $right_model->updateById($set, $id);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("储值卡权益删除成功");
        }

        $this->showAjaxResult($ret, '删除');
    }


    /**
     * 异步获取商品分组关联
     */
    public function getMemberSelectAction(){
        $this->count= 10;
        $keyword  = $this->request->getStrParam('keyword');
        $cash     = $this->request->getStrParam('cash'); // 新
        $page     = $this->request->getIntParam('page',1);
        $type     = $this->request->getStrParam('type');
        $page     = $page >=1 ? $page : 1;
        $index    = ($page - 1)* $this->count;

        $where = [];
        $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'm_is_slient', 'oper' => '=', 'value' => 0);
        if(!$cash) {
            $where[] = array('name' => 'm_source', 'oper' => 'in', 'value' => [2,3,4,6]);
        }

        if($keyword){
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$keyword}%");
            // like查询的时候 去除掉排序优化查询性能
            // zhangzc
            // 2019-09-11
            $sort=[];
        }else{
            // 风猫昵称出现的比较多的店铺在查询的时候，排除这个名字(总比原来所有的小程序都要搜索排除风猫这个名字要快点)
            // zhangzc
            // 2019-09-11
            if(in_array($this->sid,[8421,8202,5387,6684,4656,8311,6682,6248,8048,6252,6640,4969,7964,4546,7065,8055,5741,7891,7962]))
                $where[] = array('name' => 'm_nickname', 'oper' => '!=', 'value' => '风猫');   //用户昵称为风猫的用户直接过滤
        }

        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $list = $member_model->getList($where,$index,$this->count,['m_id' => 'DESC'],['m_id','m_nickname','m_avatar']);
        $total = $member_model->getCount($where);

        $tot_page    = ceil($total/$this->count);

        $menu_helper = new App_Helper_Menu();

        if($type == 'coupon_gift'){
            $page_method='fetchMemberPageData';
        }else{
            $page_method='fetchPageData';
        }

        $menu        = $menu_helper->ajaxPageLink($tot_page , $page, '', $page_method);

        $data = array(
            'ec'        => 200,
            'list'      => $list,
            'pageHtml'  => $menu
        );
        $this->displayJson($data);
    }



}