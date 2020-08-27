<?php


class App_Controller_Wxapp_RedbagController extends App_Controller_Wxapp_InitController{

    const PROMOTION_TOOL_KEY    = 'zdhb';
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
                'label' => '活动管理',
                'link'  => '/wxapp/redbag/activityList',
                'active'=> 'activity'
            ),
            array(
                'label' => '组队统计',
                'link'  => '/wxapp/redbag/groupList',
                'active'=> 'group'
            ),
        );
        $this->output['secondLink']       = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '组队红包';
    }

    /*
     * 活动列表
     */
    public function activityListAction(){
        $this->secondLink('activity');
        $this->buildBreadcrumbs(array(
            array('title' => '组队红包', 'link' => '#'),
            array('title' => '活动管理', 'link' => '#'),
        ));

        $page = $this->request->getIntParam('page');
        $this->output['activityName'] = $this->request->getStrParam('activityName');
        $index = $page * $this->count;
        $activity_model = new App_Model_Redbag_MysqlRedbagActivityStorage($this->curr_sid);
        $where = [];
        $where[] = ['name' => 'ara_s_id','oper' => '=','value' =>$this->curr_sid];
        if($this->output['activityName']){
            $where[] = ['name' => 'ara_name','oper' => 'like','value' =>"%{$this->output['activityName']}%"];
        }
        $sort = ['ara_update_time'=>'desc'];
        $total      = $activity_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = [];
        if($index < $total){
            $list = $activity_model->getList($where,$index,$this->count,$sort);
        }

        //模版消息
        $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        $where = array();
        $where[] = array('name' => 'awt_s_id','oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'awt_deleted','oper' => '=', 'value' => 0);
        $this->output['msg'] = $tpl_msg_model->getList($where,0,0);

        $this->output['list'] = $list;
        $this->displaySmarty("wxapp/redbag/activity-list.tpl");

    }

    /*
     * 编辑/新增活动
     */
    public function activityEditAction(){
        $this->secondLink('activity');
        $this->buildBreadcrumbs(array(
            array('title' => '组队红包', 'link' => '#'),
            array('title' => '活动管理', 'link' => '/wxapp/redbag/activityList'),
            array('title' => '活动管理', 'link' => '#'),
        ));

        $id = $this->request->getIntParam('id');
        if($id){
            $activity_model = new App_Model_Redbag_MysqlRedbagActivityStorage($this->curr_sid);
            $row = $activity_model->getRowById($id);
            $this->output['row'] = $row;
        }
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty("wxapp/redbag/activity-edit.tpl");

    }

    public function activitySaveAction(){
        $id = $this->request->getIntParam('id');
        $name = $this->request->getStrParam('name');
        $money = $this->request->getFloatParam('money');
        $num = $this->request->getIntParam('num');
        $limit = $this->request->getIntParam('limit');
        $limit_total = $this->request->getIntParam('limit_total');
        $limit_group = $this->request->getIntParam('limit_group');
        $hour = $this->request->getIntParam('hour');
        $share_title = $this->request->getStrParam('share_title');
        $share_img = $this->request->getStrParam('shareImg');
        $rule = $this->request->getStrParam('rule');
        $status = $this->request->getIntParam('status',2);
        if(!$name){
            $this->displayJsonError('请填写活动名称');
        }
        if(!$money || $money < 0){
            $this->displayJsonError('请填写活动奖励');
        }
        if(!$num || $num < 2 || $num > 100){
            $this->displayJsonError('请填写正确的组队所需人数');
        }
        if(!$hour || $hour < 0){
            $this->displayJsonError('请填写组队时间');
        }
        if(!$share_title || !$share_img){
            $this->displayJsonError('请补充转发信息');
        }
        if($limit < 0 || $limit_total < 0 || $limit_group < 0){
            $this->displayJsonError('请填写正确的限制次数');
        }

        $data = [
            'ara_name' => $name,
            'ara_status' => $status,
            'ara_share_title' => $share_title,
            'ara_share_img' => $share_img,
            'ara_rule' => $rule,
            'ara_limit' => $limit,
            'ara_limit_total' => $limit_total,
            'ara_limit_group' => $limit_group,
            'ara_update_time' => time()
        ];
        $activity_model = new App_Model_Redbag_MysqlRedbagActivityStorage($this->curr_sid);
        if($id){
            $res = $activity_model->updateById($data,$id);
        }else{
            $data['ara_num'] = $num;
            $data['ara_money'] = $money;
            $data['ara_hour'] = $hour;
            $data['ara_s_id'] = $this->curr_sid;
            $res = $id = $activity_model->insertValue($data);
        }

        if($res){
            if($status == 1){
                //将其他所有活动改为关闭
                $this->_change_activity_status($id);
            }
            App_Helper_OperateLog::saveOperateLog("红包活动【{$name}】保存成功");
        }
        $this->showAjaxResult($res,'保存');

    }

    /*
     * 修改活动状态
     * 将所有非id的活动改为关闭
     */
    private function _change_activity_status($id){
        $where[] = ['name' => 'ara_s_id','oper' => '=','value' =>$this->curr_sid];
        $where[] = ['name' => 'ara_id','oper' => '!=','value' =>$id];
        $activity_model = new App_Model_Redbag_MysqlRedbagActivityStorage($this->curr_sid);
        $activity_model->updateValue(['ara_status'=>2],$where);

    }

    /*
     * 组队列表统计
     */
    public function groupListAction(){
        $this->secondLink('group');
        $this->buildBreadcrumbs(array(
            array('title' => '组队红包', 'link' => '#'),
            array('title' => '组队统计', 'link' => '#'),
        ));
        $this->count = 10;
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $name = $this->request->getStrParam('activityName');
        $this->output['activityName'] = $name;
        $status = $this->request->getIntParam('status',0);
        $this->output['status'] = $status;
        $where = [];
        $where[] = ['name' => 'arg_s_id','oper' => '=','value' =>$this->curr_sid];
        if($name){
            $where[] = ['name' => 'ara_name','oper' => 'like','value' =>"%{$name}%"];
        }
        $timeNow = time();
        if($status){
            switch ($status){
                case 1:
                    $where[] = ['name' => 'arg_status','oper' => '=','value' =>1];
                    $where[] = ['name' => 'ara_status','oper' => '=','value' =>1];
                    $where[] = ['name' => 'arg_overtime_time','oper' => '>','value' =>$timeNow];
                    break;
                case 2:
                    $where[] = ['name' => 'arg_status','oper' => '=','value' =>2];
                    break;
                case 3:
                    $where[] = "( arg_overtime_time <= {$timeNow} or ara_status = 2 )";
                    $where[] = ['name' => 'arg_status','oper' => '=','value' =>1];
                    break;
            }
        }
        $group_model = new App_Model_Redbag_MysqlRedbagGroupStorage($this->curr_sid);
        $total      = $group_model->getCountActivity($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = [];
        $sort = ['arg_create_time' => 'DESC'];
        if($index < $total){
            $list = $group_model->getListActivity($where,$index,$this->count,$sort);
        }
        if($list){
            foreach ($list as $key => &$val){
                if($val['arg_status'] == 2){
                    $val['joinNum'] = $val['ara_num'];
                    $val['status'] = 2;
                }else{
                    if($val['ara_status'] == 2){
                        //下架的活动组队算作失败
                        $val['status'] = 3;
                    }else{
                        if($val['arg_overtime_time'] > $timeNow){
                            $val['status'] = 1;
                        }else{
                            $val['status'] = 3;
                        }
                    }

                    $moneyArr = json_decode($val['arg_money_arr'],1);
                    $leftNum = is_array($moneyArr) ? count($moneyArr) : 0;
                    $val['joinNum'] = $val['ara_num'] - $leftNum;
                }
            }
        }
        $this->output['list'] = $list;
        //获得统计信息
        $receive_model = new App_Model_Redbag_MysqlRedbagReceiveStorage($this->curr_sid);
        $where_money = [];
        $where_money[] = ['name' => 'arr_s_id','oper' => '=','value' =>$this->curr_sid];
        $moneySum = $receive_model->getSum($where_money);//总领取金额

        $goingNum = $group_model->getCountType('going',$timeNow);
        $failNum = $group_model->getCountType('fail',$timeNow);
        $finishNum = $group_model->getCountType('finish',$timeNow);

        $this->output['statInfo'] = [
            'money' => $moneySum ? $moneySum : 0,
            'goingNum' => $goingNum ? $goingNum : 0,
            'failNum' => $failNum ? $failNum : 0,
            'finishNum' => $finishNum ? $finishNum : 0,
        ];


        $this->displaySmarty('wxapp/redbag/group-list.tpl');
    }

    /*
     * 组队列表统计
     */
    public function groupDetailAction(){
        $this->secondLink('group');
        $this->buildBreadcrumbs(array(
            array('title' => '组队红包', 'link' => '#'),
            array('title' => '组队统计', 'link' => '/wxapp/redbag/groupDetail'),
            array('title' => '组队详情', 'link' => '#'),
        ));
        $this->count = 10;
        $page = $this->request->getIntParam('page');
        $groupId = $this->request->getIntParam('groupId');
        $this->output['groupId'] = $groupId;
        $index = $page * $this->count;
        $name = $this->request->getStrParam('memberName');
        $this->output['memberName'] = $name;
        $where = [];
        $where[] = ['name' => 'arj_s_id','oper' => '=','value' =>$this->curr_sid];
        $where[] = ['name' => 'arj_group','oper' => '=','value' =>$groupId];
        if($name){
            $where[] = ['name' => 'arj_nickname','oper' => 'like','value' =>"%{$name}%"];
        }
        $group_model = new App_Model_Redbag_MysqlRedbagJoinStorage($this->curr_sid);
        $total      = $group_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = [];
        $sort = ['arj_id' => 'DESC'];
        if($index < $total){
//            $list = $group_model->getListMember($where,$index,$this->count,$sort);
            $list = $group_model->getList($where,$index,$this->count,$sort);
        }
        if($list){
            $receive_model = new App_Model_Redbag_MysqlRedbagReceiveStorage($this->curr_sid);
            foreach ($list as $key => &$val){
                $where_receive = [];
                $where_receive[] = ['name' => 'arr_s_id','oper' => '=','value' =>$this->curr_sid];
                $where_receive[] = ['name' => 'arr_m_id','oper' => '=','value' =>$val['arj_m_id']];
                $total = $receive_model->getSum($where_receive);
                $val['moneySum'] = $total ? $total : 0;
                $val['avatar'] = $val['arj_avatar'] ? $val['arj_avatar'] : '/public/wxapp/images/applet-avatar.png';
            }
        }
        $this->output['list'] = $list;
        $this->displaySmarty('wxapp/redbag/group-detail.tpl');
    }

    /*
     * 删除活动
     */
    public function activityDeleteAction(){
        $id = $this->request->getIntParam('id');
        $set = [
            'ara_status' => 2,
            'ara_deleted' => 1
        ];
        $avtivity_model = new App_Model_Redbag_MysqlRedbagActivityStorage($this->curr_sid);
        $row = $avtivity_model->getRowById($id);
        $res = $avtivity_model->updateById($set,$id);

        if($res){
            App_Helper_OperateLog::saveOperateLog("红包活动【{$row['ara_name']}】删除成功");
        }

        $this->showAjaxResult($res,'删除');
    }

    /**
     * 拼团购模版信息保存
     */
    public function redbagMsgAction(){
        $key        = array('zdcg');
        $intField   = array();
        foreach($key as $val){
            $intField[] = $val.'_msgid';
        }
        $data     = $this->getIntByField($intField,'ara_');
        $id       = $this->request->getIntParam('hid_id');
        $avtivity_model = new App_Model_Redbag_MysqlRedbagActivityStorage($this->curr_sid);
        $ret      = $avtivity_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("红包活动模板消息保存成功");
        }

        $this->showAjaxResult($ret,'保存');
    }
}