<?php
/**
 * 小程序订阅消息相关
 */
class App_Controller_Applet_SubscribeAuthController extends App_Controller_Applet_InitController  {

    public function __construct() {
        parent ::__construct();
    }

    /*
     * 推送消息列表 分组
     * 不用这个
     */
    public function getTplPushListGroupAction(){
        $data = [];
        $setup_model = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $msg_model = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
        $setup = $setup_model->findOneBySid();
        if($setup){
            $subscribe_cfg = plum_parse_config('auth','subscribeMsg')[$this->applet_cfg['ac_type']];
            $push_cfg = $subscribe_cfg['push'];
            $types = array_keys($push_cfg);
            if($types){
                foreach ($types as $item){
                    $ids = [];
                    $tpl_ids = [];
                    foreach ($item['types'] as $type){
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
                            if(!key_exists($msg_row['awt_tplid'],$tpl_ids)){
                                $tpl_ids[] = $msg_row['awt_tplid'];
                            }
                        }
                        if($tpl_ids){

                        }
                    }

                }

            }
        }
        $info['data'] = array_values($data);
        $this->outputSuccess($info);

    }



    /*
     * 保存订阅消息模板授权
     */
    public function saveAuthAction(){
        $tpls = $this->request->getStrParam('tplIds');
        $tpls_arr = json_decode($tpls,1);
        if(is_array($tpls_arr) && !empty($tpls_arr)){
            //获得当前授权模板id
            $subscribe_model = new App_Model_Subscribe_MysqlSubscribeAuthStorage($this->sid);
            if(count($tpls_arr) == 1){
                $row = $subscribe_model->fetchRow($this->member['m_openid'],$tpls_arr[0]);
                $list[] = $row;
            }else{
                $list = $subscribe_model->getListByOpenid($this->member['m_openid']);
            }

            $tpls_now = [];
            $tpls_now_ids = [];
            $id_nums = [];
            foreach ($list as $val){
                $tpls_now[$val['asa_tpl_id']] = [
                    'num' => $val['asa_num'],
                    'id'  => $val['asa_id']
                ];
                $tpls_now_ids[] = $val['asa_tpl_id'];
            }
            $insert = [];
            foreach ($tpls_arr as $k => $v){
                //已经授权过的增加
                if(in_array($v,$tpls_now_ids)){
                    $id_nums[$tpls_now[$v]['id']] = $tpls_now[$v]['num'] + 1;
                }else{
                    $insert[] =  " (NULL, '{$this->sid}', '{$this->member['m_id']}', '{$this->member['m_openid']}', '{$v}', '1', '".time()."') ";
                }
            }
            if($insert){
                $subscribe_model->insertBatch($insert);
            }
            if($id_nums){
                $subscribe_model->multiUpdateNum($id_nums);
            }
            $info['data'] = [
                'msg' => '订阅成功'
            ];
            $this->outputSuccess($info);
        }else{
            $this->outputError('模板id不存在');
        }


    }


    /*
     * 保存订阅消息模板授权
     * 一次根据前端请求的信息 保存指定的数量
     */
    public function saveAuthNewAction(){
        //ct_13hg1jnZmNeKQ8L7ejLjsjKATWqqzKEPWndBAOdA => '3'
        $tpls = $this->request->getStrParam('tplIds');


        $tplIds = json_decode($tpls,1);
        $tpls_arr = array_keys($tplIds);
        if(is_array($tpls_arr) && !empty($tpls_arr)){
            //获得当前授权模板id
            $subscribe_model = new App_Model_Subscribe_MysqlSubscribeAuthStorage($this->sid);
            if(count($tpls_arr) == 1){
                $row = $subscribe_model->fetchRow($this->member['m_openid'],$tpls_arr[0]);
                $list[] = $row;
            }else{
                $list = $subscribe_model->getListByOpenid($this->member['m_openid']);
            }

            $tpls_now = [];
            $tpls_now_ids = [];
            $id_nums = [];
            foreach ($list as $val){
                $tpls_now[$val['asa_tpl_id']] = [
                    'num' => $val['asa_num'],
                    'id'  => $val['asa_id']
                ];
                $tpls_now_ids[] = $val['asa_tpl_id'];
            }
            $insert = [];
            foreach ($tplIds as $k => $v){
                if($v > 0){
                    //已经授权过的增加
                    if(in_array($k,$tpls_now_ids)){
                        $id_nums[$tpls_now[$k]['id']] = $tpls_now[$k]['num'] + $v;
                    }else{
                        $insert[] =  " (NULL, '{$this->sid}', '{$this->member['m_id']}', '{$this->member['m_openid']}', '{$k}', '{$v}', '".time()."') ";
                    }
                }

            }
            if($insert){
                $subscribe_model->insertBatch($insert);
            }
            if($id_nums){
                $subscribe_model->multiUpdateNum($id_nums);
            }
            $info['data'] = [
                'msg' => '订阅成功'
            ];
            $this->outputSuccess($info);
        }else{
            $this->outputError('模板id不存在');
        }


    }

}