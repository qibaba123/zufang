<?php
/**
 * 小程序订阅消息相关
 */
class App_Controller_Applet_SubscribeController extends App_Controller_Applet_InitController  {

    public function __construct() {
        parent ::__construct(true);
    }

    /*
     * 获得操作授权的订阅消息模板id
     */
    public function getTplIdsAction(){
        $operate = $this->request->getStrParam('operate');
        $data = [];
        $ids = [];
        $setup_model = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $msg_model = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
        $setup = $setup_model->findOneBySid();
        if($setup){
            $subscribe_cfg = plum_parse_config('auth','subscribeMsg')[$this->applet_cfg['ac_type']];
            $types = $subscribe_cfg[$operate];
            if($types){
                foreach ($types as $type){
                    if($setup["aws_{$type}_open"] && $setup["aws_{$type}_mid"]){
                        $msg_id = $setup["aws_{$type}_mid"];
                        if(!in_array($msg_id,$ids)){
                            $ids[] = $msg_id;
                        }
                    }
                }
                if($ids){
                    $where = [];
                    $where[] = ['name' => 'awt.awt_s_id', 'oper' => '=', 'value' => $this->sid];
                    $where[] = ['name' => 'awt.awt_id', 'oper' => 'in', 'value' => $ids];
                    $where[] = ['name' => 'awt.awt_type', 'oper' => '=', 'value' => 2];
                    $msg_list = $msg_model->findListTpl($where,0,0);
                    foreach ($msg_list as $msg_row){
                        if(!in_array($msg_row['awt_tplid'],$data)){
                            $data[] = $msg_row['awt_tplid'];
                        }
                    }
                }
            }
        }
        $info['data'] = $data;
        $this->outputSuccess($info);
    }

    /*
     * 获得当前小程序所有操作模板消息
     */
    public function getTplIdsAllAction(){
        $data = [];
        $id_tpl = [];
        $ids = [];
        $map_id = [];
        $setup_model = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $msg_model = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
        $setup = $setup_model->findOneBySid();
        $setup = $setup ? $setup : [];
        $subscribe_cfg = plum_parse_config('auth','subscribeMsg')[$this->applet_cfg['ac_type']];

        unset($subscribe_cfg['push']);
        foreach ($subscribe_cfg as $map => $types){
            $now_ids = [];
            foreach ($types as $type) {
                if (isset($setup["aws_{$type}_open"]) && isset($setup["aws_{$type}_mid"]) && $setup["aws_{$type}_open"] && $setup["aws_{$type}_mid"]) {
                    $msg_id = $setup["aws_{$type}_mid"];
                    //将类型对应的消息id计入数组
                    $ids[] = $msg_id;
                    $now_ids[] = $msg_id;
                }
            }
            $map_id[$map] = $now_ids;
        }
        $ids = array_unique($ids);
        if($ids){
            $where = [];
            $where[] = ['name' => 'awt.awt_s_id', 'oper' => '=', 'value' => $this->sid];
            $where[] = ['name' => 'awt.awt_id', 'oper' => 'in', 'value' => $ids];
            $where[] = ['name' => 'awt.awt_type', 'oper' => '=', 'value' => 2];
            $msg_list = $msg_model->findListTpl($where,0,0);

            foreach ($msg_list as $msg_row){
                $id_tpl[$msg_row['awt_id']] = $msg_row['awt_tplid'];
            }
        }

        foreach ($map_id as $key => $id_arr){
            $data[$key] = [];
            foreach ($id_arr as $id){
                if(isset($id_tpl[$id])){
                    $data[$key][] = $id_tpl[$id];
                }
            }
        }

        $info['data'] = $data;
        $this->outputSuccess($info);
    }

    /*
     * 推送消息列表
     */
    public function getTplPushListAction(){
        $data = [];
        $ids = [];
        $auth_data = [];
        $setup_model = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $msg_model = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
        $setup = $setup_model->findOneBySid();
        if($setup){
            $subscribe_cfg = plum_parse_config('auth','subscribeMsg')[$this->applet_cfg['ac_type']];
            $push_cfg = $subscribe_cfg['push'];
            $types = array_keys($push_cfg);
            if($types){
                foreach ($types as $type){
                    if($setup["aws_{$type}_open"] && $setup["aws_{$type}_mid"]){
                        $msg_id = $setup["aws_{$type}_mid"];
                        if(!in_array($msg_id,$ids)){
                            $ids[] = $msg_id;
                        }
                    }
                }
                if($ids){
                    $where = [];
                    $where[] = ['name' => 'awt.awt_s_id', 'oper' => '=', 'value' => $this->sid];
                    $where[] = ['name' => 'awt.awt_id', 'oper' => 'in', 'value' => $ids];
                    $where[] = ['name' => 'awt.awt_type', 'oper' => '=', 'value' => 2];
                    $msg_list = $msg_model->findListTpl($where,0,0);
                    //获得当前订阅记录
//                    $auth_model = new App_Model_Subscribe_MysqlSubscribeAuthStorage($this->sid);
//                    $auth_list = $auth_model->getListByOpenid($this->member['m_openid']);
//                    foreach ($auth_list as $auth_row){
//                        $auth_data[$auth_row['asa_tpl_id']] = $auth_row['asa_num'];
//                    }

                    foreach ($msg_list as $msg_row){
                        if(!key_exists($msg_row['awt_tplid'],$data)){
                            $data[] = [
                                'tplId' => [$msg_row['awt_tplid']],
                                'title' => $msg_row['tpl_title'],
                                'num'   => 0
                                //'num'   => isset($auth_data[$msg_row['awt_tplid']]) ? $auth_data[$msg_row['awt_tplid']] : 0
                            ];
                        }
                    }
                }
            }
        }
        $info['data'] = array_values($data);
        $this->outputSuccess($info);

    }

}