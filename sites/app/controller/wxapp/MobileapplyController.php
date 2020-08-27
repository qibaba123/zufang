<?php
/**
手机认证
 */

class App_Controller_Wxapp_MobileapplyController extends App_Controller_Wxapp_InitController{

    const PROMOTION_TOOL_KEY    = 'yhyz';
    public function __construct()
    {
        parent::__construct();
        //$this->checkToolUsable(self::PROMOTION_TOOL_KEY);
    }

    /*
     * 手机号审核管理
     */
    public function indexAction(){
        //$this->count = 1;
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $list = array();

        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }

        $output['mobile'] = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[] = array('name' => 'mma_mobile', 'oper' => '=', 'value' => $output['mobile']);
        }

        //会员编号查询
        $output['showId'] = $this->request->getIntParam('showId');
        if($output['showId']){
            $where[] = array('name' => 'm_show_id', 'oper' => '=', 'value' => $output['mid']);
        }
        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 'mma_update_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 'mma_update_time', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }

        $sort = array('mma_update_time'=>'DESC');
        $apply_model = new App_Model_Member_MysqlMemberMobileApplyStorage($this->curr_sid);
        $total = $apply_model->getListMemberCount($where);

        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $output['paginator'] = $page_plugin->render();

        if($total > $index){
            $list = $apply_model->getListMember($where,$index,$this->count,$sort);

        }
        $this->buildBreadcrumbs(array(
            array('title' => '会员管理', 'link' => '#'),
            array('title' => '手机号认证', 'link' => '#'),
        ));

        //获得配置信息
        $cfg_model = new App_Model_Member_MysqlMemberMobileCfgStorage();
        $mobileCfg = $cfg_model->findUpdateBySid($this->curr_sid);
        $output['mobileCfg'] = $mobileCfg;

        $output['list'] = $list;
        $this->showOutput($output);
        $this->displaySmarty('wxapp/member/mobile-apply.tpl');
    }

    /*
     * 审核手机号
     */
    public function handleMemberMobileAction(){
        $id = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');
        $remark = $this->request->getStrParam('remark');
        if($id && $status){
            $apply_model = new App_Model_Member_MysqlMemberMobileApplyStorage($this->curr_sid);
            $row = $apply_model->getRowByIdSid($id,$this->curr_sid);
            if($row){
                $updata = array(
                    'mma_status' => $status,
                    'mma_handle_time' => time(),
                    'mma_handle_remark' => $remark,
                );

                $res = $apply_model->updateById($updata,$id);
                if($res){
                    //将会员表中审核状态更新
                    $data = array(
                        'm_mobile_check' => $status
                    );
                    if($status == 2){
                        $data['m_mobile'] = $row['mma_mobile'];
                    }
                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $member_model->updateById($data,$row['mma_m_id']);
                    $result = array(
                        'ec'    => 200,
                        'em'    => '审核成功'
                    );
                    $str = $status == 2 ? '通过' : '不通过';
                    App_Helper_OperateLog::saveOperateLog("用户验证申请【{$row['mma_name']}】审核成功，审核结果：{$str}");
                    //发送订阅消息
                    $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
                    $appletType = $appletType ? $appletType : 0;
                    plum_open_backend('templmsg', 'mobileApplyTempl', array('sid' => $this->curr_sid, 'id' => $id, 'appletType' => $appletType));

                    $this->displayJson($result);
                }else{
                    $this->displayJsonError('审核失败.');
                }
            }else{
                $this->displayJsonError('未找到相关信息');
            }
        }else{
            $this->displayJsonError('审核失败..');
        }
    }

    /*
     * 开启关闭手机号认证
     */
    public function mobileApplyAutoVerifyAction(){
        $result = array(
            'ec' => 400,
            'em' => '修改失败'
        );
        $value   = $this->request->getStrParam('value','');
        $open = $value == 'on' ? 1 : 0;
        $cfg_model = new App_Model_Member_MysqlMemberMobileCfgStorage();
        $row = $cfg_model->findUpdateBySid($this->curr_sid);
        if($row){
            $data = array(
                'mmc_auto_verify' => $open,
                'mmc_update_time' => time()
            );
            $res = $cfg_model->findUpdateBySid($this->curr_sid,$data);
        }else{
            $data = array(
                'mmc_s_id' => $this->curr_sid,
                'mmc_auto_verify' => $open,
                'mmc_update_time' => time()
            );
            $res = $cfg_model->insertValue($data);
        }

        if ($res) {
            $result = array(
                'ec' => 200,
                'em' => ' 修改成功'
            );
            $str = $open == '1' ? '开启' : '关闭';
            App_Helper_OperateLog::saveOperateLog("{$str}手机号认证自动验证通过成功");
        }
        $this->displayJson($result);
    }

    /*
    * 开启关闭手机号认证
    */
    public function mobileApplyOpenAction(){
        $result = array(
            'ec' => 400,
            'em' => '修改失败'
        );
        $value   = $this->request->getStrParam('value','');
        $open = $value == 'on' ? 1 : 0;
        $cfg_model = new App_Model_Member_MysqlMemberMobileCfgStorage();
        $row = $cfg_model->findUpdateBySid($this->curr_sid);
        if($row){
            $data = array(
                'mmc_open' => $open,
                'mmc_update_time' => time()
            );
            $res = $cfg_model->findUpdateBySid($this->curr_sid,$data);
        }else{
            $data = array(
                'mmc_s_id' => $this->curr_sid,
                'mmc_open' => $open,
                'mmc_update_time' => time()
            );
            $res = $cfg_model->insertValue($data);
        }

        if ($res) {
            $result = array(
                'ec' => 200,
                'em' => ' 修改成功'
            );
            $str = $open == '1' ? '开启' : '关闭';
            App_Helper_OperateLog::saveOperateLog("{$str}手机号认证成功");
        }
        $this->displayJson($result);
    }

    /*
     * 保存提示信息
     */
    public function saveTipAction(){
        $result = array(
            'ec' => 400,
            'em' => '保存失败'
        );
        $tip   = $this->request->getStrParam('tip','');
        $cfg_model = new App_Model_Member_MysqlMemberMobileCfgStorage();
        $row = $cfg_model->findUpdateBySid($this->curr_sid);
        if($row){
            $data = array(
                'mmc_tip' => $tip,
                'mmc_update_time' => time()
            );
            $res = $cfg_model->findUpdateBySid($this->curr_sid,$data);
        }else{
            $data = array(
                'mmc_s_id' => $this->curr_sid,
                'mmc_tip' => $tip,
                'mmc_update_time' => time()
            );
            $res = $cfg_model->insertValue($data);
        }

        if ($res) {
            $result = array(
                'ec' => 200,
                'em' => ' 保存成功'
            );
            App_Helper_OperateLog::saveOperateLog("保存手机号认证提示信息成功");
        }
        $this->displayJson($result);
    }
}