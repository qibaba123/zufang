<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/26
 * Time: 下午3:04
 */
class App_Controller_Wxapp_ManagerController extends App_Controller_Wxapp_InitController {

    private $manager_model;

    public function __construct() {

        parent::__construct();
        $this->manager_model = new App_Model_Member_MysqlManagerStorage();
    }

    /**
     * @param int $plugin
     * @param string $pluginLinkType
     * 获取管理员列表
     * 注意:新增 绑定 m_bind_sid : 绑定线下门店的id(收银台辅助字段)
     */
    public function managerListAction($plugin = 0,$pluginLinkType = '') {
        //获取当前组织的所有店铺管理员
        $where   = array();
        $where[] = array('name' => 'ma.m_c_id', 'oper' => '=', 'value' => $this->company['c_id']);
        // 去除掉社区团购区域管理员的相关数据
        // zhangzc
        // 2019-03-19
        $where[]=['name'=>'m_area_status','oper'=>'=','value'=>0];
        //$where[] = array('name' => 'm_fid', 'oper' => '>', 'value' => 0);
        $sort    = array('ma.m_fid' => 'ASC');
        $manager_list         = $this->manager_model->getListWithMember($where, 0, 0, $sort);
        foreach ($manager_list as $key => $val){
            if(!$val['m_report_qrcode']){
                $qrcode = $this->_create_manager_report_qrcode($val['m_id']);
                $manager_list[$key]['m_report_qrcode'] = $qrcode;
            }
        }
        $this->output['applet'] = $this->wxapp_cfg;
        $this->output['list'] = $manager_list;

        $bread = [
            array('title' => '设置', 'link' => '#'),
            array('title' => '管理员', 'link' => '/wxapp/manager/managerList'),
        ];
        //如果是收银台插件使用
        $this->output['plugin'] = $plugin;
        if($plugin == 1){
            $plugin_cfg = plum_parse_config('plugin_cfg','cashier');
            $this->output['link']       = $plugin_cfg['link'];
            $this->output['linkType']   = $pluginLinkType;
            $this->output['snTitle']    = $plugin_cfg['snTitle'];
            $bread = $plugin_cfg['breadcrumbs'][$pluginLinkType];
        }

        $this->buildBreadcrumbs($bread);
        //$this->output['curr_sid']   = $this->curr_sid;
        $this->output['storeList']  = $this->_get_offine_shop();//商户下的所有线下门店
        if($this->curr_sid == '5655' || in_array($this->curr_shop['s_broker_type'],[2,3]) || $plugin == 1){
            $this->output['face']   = true;
            $this->displaySmarty('wxapp/manager/manager-new.tpl');
        }else{
            $this->displaySmarty('wxapp/manager/manager.tpl');
        }

    }

    /**
     * @param $mid
     * @return string
     * 绑定门店
     */
    public function bindStoreAction(){
        $res   = array('ec'=>400,'em'=>'绑定失败');
        $id    = $this->request->getIntParam('id');
        $store = $this->request->getIntParam('store');
        if($id && $store){
            $row = $this->manager_model->getRowById($id);//获取管理员数据
            if($row && !$row['m_bind_sid']){
                $set  = array('m_bind_sid'=>$store);
                $ret  = $this->manager_model->updateById($set,$id);
                if($ret){
                    $res   = array('ec'=>200,'em'=>'绑定成功');
                }
            }else{
                $res['em'] = '该管理员暂时无法绑定门店哦';
            }
        }
        $this->displayJson($res);
    }

    /**
     * @param $mid
     * @return string
     * 解除绑定
     * 店员解除绑定店铺后,将自动清除该店铺下所有的机器绑定
     */
    public function delBindAction(){
        $res  = array('ec'=>400,'em'=>'解绑失败');
        $mid  = $this->request->getIntParam('mid');
        $osid = $this->request->getIntParam('osid');
        if($mid && $osid){
            $row = $this->manager_model->getRowById($mid);//获取管理员数据
            if($row && $row['m_bind_sid'] == $osid){
                $set = array('m_bind_sid'=>'');
                $ret = $this->manager_model->updateById($set,$mid);
                if($ret){
                    $cash_model = new App_Model_Cash_MysqlBindRecordStorage($this->curr_sid);
                    $cash_model->delDataBy($this->curr_sid,$osid,$mid);

                    $this->_del_machine_members($osid, $row); // 处理绑定机器
                }
                if($ret){
                    $res  = array('ec'=>200,'em'=>'解绑成功');
                }
            }else{
                $res['em'] = '解绑异常';
            }
        }
        $this->displayJson($res);
    }

    // 处理绑定过的机器
    private function _del_machine_members($osid, $row) {
        $str      = '/(\s{2})?\S*\s?\:?\s?\('.$row['m_job_number'].'\)(\s{2}\|?)?/';
        $str_end  = '/(\s{2}\|?)?$/';

        $cash_model = new App_Model_Cash_MysqlBindRecordStorage($this->curr_sid);
        $where[] = ['name'=>'cbr_s_id', 'oper'=>'=', 'value'=>$this->curr_sid];
        $where[] = ['name'=>'cbr_bind_level', 'oper'=>'=', 'value'=>1];
        $where[] = ['name'=>'cbr_bind_status', 'oper'=>'=', 'value'=>1];
        $where[] = ['name'=>'cbr_deleted', 'oper'=>'=', 'value'=>0];
        $where[] = ['name'=>'cbr_os_id', 'oper'=>'=', 'value'=>$osid]; // 门店

        $list = $cash_model->getList($where, 0, 0);
        if($list) {
            foreach($list as $value) {
                $tmp    = trim(preg_replace($str, '', $value['cbr_members']));
                $result = preg_replace($str_end, '', $tmp);

                $cash_model->updateById(['cbr_members' => $result], $value['cbr_id']);
            }
        }
    }






    private function _create_manager_report_qrcode($mid){
        //永久二维码,使用字符串类型
        $str    = 'ambm'.'|'.$mid;
        $client_plugin  = new App_Plugin_Weixin_ClientPlugin(16);
        $result = $client_plugin->fetchSecnestrQrcode($str);
        if (isset($result['url'])) {
            $suid   = $this->curr_shop['s_unique_id'];
            $filename   = $suid.'-report-'.$mid.'.png';
            $path = PLUM_APP_BUILD.'/spread/';
            $accessPath = PLUM_PATH_PUBLIC.'/build/spread/';
            Libs_Qrcode_QRCode::png($result['url'], $path.$filename, 'Q', 6, 1);
            $set = array('m_report_qrcode' => $accessPath.$filename);
            $this->manager_model->updateById($set, $mid);
        }
        return $accessPath.$filename;
    }

    public function saveManagerAction(){
        $result = array(
            'ec' => 400,
            'em' => '参数请求错误'
        );
        $id   = $this->request->getIntParam('id');
        $data = array();
        $mobile   = $this->request->getStrParam('mobile');
        $nickname = $this->request->getStrParam('nickname');
        $password = $this->request->getStrParam('password');
        $status   = $this->request->getIntParam('status');
        $login    = $this->request->getIntParam('login');
        $sex      = $this->request->getStrParam('sex');
        $number   = $this->request->getStrParam('number');//工号
        $osId     = $this->request->getIntParam('osId');//门店id
        $data['m_mobile']   = $mobile;
        $data['m_nickname'] = $nickname;
        $data['m_sex']      = $sex == 'M' ? 'M' : 'F';
        $data['m_status']   = $status;
        $data['m_login_client']   = $login;
        //$data['m_job_number']     = $number;
        $data['m_bind_sid']       = $osId?$osId:0;
        if($password){
            $data['m_password'] = plum_salt_password($password);
        }
        $data['m_update_time'] = time();
        //错误过滤
        if(plum_is_phone($mobile)){
            $hasMobile = $this->manager_model->checkMobile($mobile,$id);
            if(!$hasMobile){
                if($id){
                    $where = array();
                    $where[] = array('name' => 'm_c_id', 'oper' => '=', 'value' => $this->company['c_id']);
                    $where[] = array('name' => 'm_id', 'oper' => '=', 'value' => $id);
                    $ret = $this->manager_model->updateValue($data,$where);
                }else{
                    $data['m_power']       = serialize(array('index-index'));
                    $data['m_c_id']        = $this->company['c_id'];
                    $data['m_createtime']  = time();
                    $data['m_fid']         = $this->uid;
                    $data['m_job_number']  = $this->_get_manage_job_number();
                    $ret = $this->manager_model->insertValue($data);
                }

                if($ret){
                    $result = array(
                        'ec' => 200,
                        'em' => '保存成功'
                    );
                    App_Helper_OperateLog::saveOperateLog("管理员【{$nickname}】保存成功");
                }else{
                    $result['em'] = '操作失败';
                }
            }else{
                $result['em'] = '手机号已存在';
            }
        }else{
            $result['em'] = '请输入有效的手机号';
        }


        $this->displayJson($result);
    }

    /**
     * 获取编号
     */
    private function _get_manage_job_number($id=''){
        $where   = array();
        $where[] = array('name' => 'ma.m_c_id', 'oper' => '=', 'value' => $this->company['c_id']);
        // 去除掉社区团购区域管理员的相关数据
        $where[] = ['name'=>'m_area_status','oper'=>'=','value'=>0];
        $sort    = array('ma.m_fid' => 'ASC','ma.m_createtime'=>'ASC');
        $manager_list  = $this->manager_model->getListWithMember($where, 0, 0, $sort);
        $total   = count($manager_list)+1;
        return '100'.$total;
    }





    public function deleteManagerAction(){
        $result = array(
            'ec' => 400,
            'em' => '参数请求错误'
        );
        $id   = $this->request->getIntParam('mid');
        if($id && $id != $this->company['c_founder_id']){
            $row = $this->manager_model->getRowById($id);
            $where = array();
            $where[] = array('name' => 'm_c_id', 'oper' => '=', 'value' => $this->company['c_id']);
            $where[] = array('name' => 'm_id', 'oper' => '=', 'value' => $id);
            $where[] = array('name' => 'm_fid', 'oper' => '!=', 'value' => 0);

            $ret = $this->manager_model->deleteValue($where);
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '删除成功'
                );
                App_Helper_OperateLog::saveOperateLog("管理员【{$row['m_nickname']}】删除成功");
            }else{
                $result['em'] = '删除失败';
            }
        }elseif($id == $this->company['c_founder_id']){
            $result['em'] = '公司创建人不能删除';
        }
        $this->displayJson($result);
    }

    public function settingRoleAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '设置', 'link' => '/wxapp/manager/managerList'),
            array('title' => '设置管理员权限', 'link' => '#'),
        ));
        //获取小程序类别
        $kind   = intval($this->wxapp_cfg['ac_type']);
        if(in_array($this->curr_shop['s_broker_type'],[2,3])){
            $menus   = plum_parse_config('menu', "face/pay-1");
        }else{
            $menus   = plum_parse_config('menu', "wxmenu/xcx-".$kind);
        }

        $output['id']   = $this->request->getIntParam('id');
        $where          = array();
        $where[]        = array('name' => 'm_id', 'oper' => '=', 'value' => $output['id']);
        $mess           = $this->manager_model->getRow($where);
        $menu_arr       = array();
        $i = 1;
        foreach($menus as $menu){
            $fkey = $i;
            $menu_arr[] = array(
                'id'        => $i,
                'fid'       => 0,
                'key'       => $menu['access'],
                'name'      => $menu['title'],
                'select'    => in_array($menu['access'],unserialize($mess['m_power']))?true:undefined,
            );
            $i++;
            foreach($menu['submenu'] as $submenu){
                $menu_arr[] = array(
                    'id'        => $i,
                    'fid'       => $fkey,
                    'key'       => $submenu['access'],
                    'name'      => $submenu['title'],
                    'select'    => in_array($submenu['access'],unserialize($mess['m_power']))?true:undefined,
                );
                $i++;
            }
        }
        $output['menu_arr']= $menu_arr;
        //app菜单
        $app_menus   = plum_parse_config('menu', "appmenu/app-".$kind);
        $app_menu_arr = [];
        foreach ($app_menus as $k => $app_menu){
            $app_menu_arr[] = [
                'id'   => $k+1,
                'name' => $app_menu['title'],
                'key'  => $app_menu['access'],
                'select' => in_array($app_menu['access'],unserialize($mess['m_app_power'])) ? true : undefined
            ];
        }
        $output['app_menu_arr'] = $app_menu_arr;
        $app_power = 0;
        if(!empty($app_menu_arr)){
            $app_power = 1;
        }

        $output['app_power'] = $app_power;

        $this->showOutput($output);
        $this->displaySmarty('wxapp/manager/setRole.tpl');
    }

    /*
     * 保存子管理员设置的权限
     */
    public function saveSubManageRoleAction(){
        $id = $this->request->getIntParam('id');
        $role = $this->request->getArrParam('sel');
        $app_role = $this->request->getArrParam('app_sel');
        if($id && ($role || $app_role)){
            //获取当前组织的所有店铺管理员
            $where   = array();
            $where[] = array('name' => 'm_id', 'oper' => '=', 'value' => $id);
            $where[] = array('name' => 'm_c_id', 'oper' => '=', 'value' => $this->company['c_id']);
            $where[] = array('name' => 'm_fid', 'oper' => '=', 'value' => $this->uid);
            $row = $this->manager_model->getRow($where);
            if($row){
                $updata = array(
                    'm_power' => serialize($role),
                    'm_app_power' => serialize($app_role)
                );
                $ret = $this->manager_model->updateValue($updata,$where);

                if($ret){
                    App_Helper_OperateLog::saveOperateLog("管理员【{$row['m_nickname']}】权限保存成功");
                }

                $this->showAjaxResult($ret,'保存');
            }else{
                $this->displayJsonError('管理员不存在');
            }
        }else{
            $this->displayJsonError('参数错误');
        }
    }

    /**
     * 解绑管理员公众号会员
     */
    public function unbindMemberAction(){
        $id  = $this->request->getIntParam('id');
        $set = array('m_weixin_mid' => 0);
        $row = $this->manager_model->getRowById($id);
        $ret = $this->manager_model->updateById($set, $id);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("管理员【{$row['m_nickname']}】解绑公众号会员成功");
        }
        $this->showAjaxResult($ret);
    }

    /**
     * 修改接收微信报告状态
     */
    public function changeReportStatusAction(){
        $id  = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');
        $set = array('m_report_open' => $status==1?0:1);
        $ret = $this->manager_model->updateById($set, $id);

        if($ret){
            $str = $set['m_report_open'] == 1 ? '开启' : '关闭';
            $row = $this->manager_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("管理员【{$row['m_nickname']}】{$str}接收微信报告");
        }

        $this->showAjaxResult($ret);
    }

    /**
     * 管理员操作日志
     */
    public function operateLogListAction(){
        $this->output['manager'] = $this->request->getIntParam('manager');
        $this->output['start']   = $this->request->getStrParam('start');
        $this->output['end']     = $this->request->getStrParam('end');

        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $operate_model = new App_Model_Member_MysqlManagerOperateLogStorage();

        $where = array();
        $where[] = array('name' => 'mol_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        if($this->output['manager']){
            $where[] = array('name' => 'mol_mid', 'oper' => '=', 'value' => $this->output['manager']);
        }

        if($this->output['start']){
            $where[] = array('name' => 'mol_create_time', 'oper' => '>=', 'value' => strtotime($this->output['start']));
        }

        if($this->output['end']){
            $where[] = array('name' => 'mol_create_time', 'oper' => '<=', 'value' => strtotime($this->output['end']));
        }

        $this->output['list'] = $operate_model->getManagerList($where, $index, $this->count, array('mol_create_time' => 'desc'));

        $this->output['managerList'] = $this->manager_model->getManagerByCompany($this->company['c_id']);

        //分页处理
        $total          = $operate_model->getCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();

        $this->buildBreadcrumbs(array(
            array('title' => '操作日志', 'link' => ''),
        ));


        $this->displaySmarty('wxapp/manager/operate-log-list.tpl');
    }

    /**
     * 操作日志详情
     */
    public function operateLogDetailAction(){
        $id = $this->request->getIntParam('id');
        $operate_model = new App_Model_Member_MysqlManagerOperateLogStorage();
        $row = $operate_model->getManagerRowById($id);
        $row['mol_change_data'] = json_decode($row['mol_change_data'], true);
        $this->output['row'] = $row;

        $this->buildBreadcrumbs(array(
            array('title' => '操作日志', 'link' => '/wxapp/manager/operateLogList'),
            array('title' => '操作日志详情', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/manager/operate-log-detail.tpl');
    }
}