<?php

class App_Controller_Wxapp_FullController extends App_Controller_Wxapp_InitController{

    public function __construct(){
        parent::__construct();
    }

    
    public function secondLink($type='coupon'){
        $link = array(
            array(
                'label' => '优惠券',
                'link'  => '/wxapp/coupon/index',
                'active'=> 'coupon'
            ),
            array(
                'label' => '满减促销',
                'link'  => '/wxapp/full/index',
                'active'=> 'full'
            ),
        );
        $this->output['secondLink'] = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '优惠满减活动';
    }

    public function indexAction() {
        $this->secondLink('full');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '优惠满减', 'link' => '/wxapp/coupon/index'),
            array('title' => '满减活动', 'link' => '#'),
        ));
        $this->full_list_data();
        $this->output['nowTime'] = $_SERVER['REQUEST_TIME'];
        $this->output['type']    = plum_parse_config('full_type');
        $this->output['use_type']= plum_parse_config('full_use_type');

        $this->displaySmarty('wxapp/full/list.tpl');
    }

    
    private function full_list_data(){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'fa_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'fa_es_id', 'oper' => '=', 'value' => 0);
        $output['name']     = $this->request->getStrParam('name');
        if($output['name']) {
            $where[]    = array('name' => 'fa_name', 'oper' => '=', 'value' => "%{$output['name']}%");
        }

        $act_model  = new App_Model_Full_MysqlFullActStorage($this->curr_sid);
        $total      = $act_model->getCount($where);
        $list       = array();
        if($index < $total){
            $sort   = array('fa_update_time' => 'DESC');
            $list   = $act_model->getList($where,$index,$this->count,$sort);
            foreach($list as &$val){
                $val['link'] = $this->composeLink('full','index');
            }
        }
        $page_libs  = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['pageHtml'] = $page_libs->render();
        $output['list']     = $list;
        $full_model = new App_Model_Trade_MysqlTradeFullStorage($this->curr_sid);
        $where_total = $where_post = [];
        $where_total[] = $where_post[] = ['name' => 'tf_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = ['name' => 'tf_type', 'oper' => 'in', 'value' => [1,2,3]];
        $where_post[] = ['name' => 'tf_type', 'oper' => '=', 'value' => 4];
        $total_info = $full_model->getStatInfoAction($where_total);
        $post_info = $full_model->getStatInfoAction($where_post);
        $statInfo = [
            'total' => intval($total_info['total']),
            'money' => intval($total_info['money']),
            'postTotal' => intval($post_info['total']),
        ];
        $output['statInfo'] = $statInfo;

        $this->showOutput($output);
    }

    
    public function addAction() {
        $this->secondLink('full');
        $id   = $this->request->getIntParam('id');
        $row  = array();
        if($id){
            $act_model  = new App_Model_Full_MysqlFullActStorage($this->curr_sid);
            $row        = $act_model->getRowUpdateByIdSid($id,$this->curr_sid);
        }
        $def_val   = array(
            array(
                'id'    => 0,
                'limit' => '',
                'value' => '',
            )
        );
        $rules['type_1']    = $def_val;
        $rules['type_3']    = $def_val;
        $rules['type_4']    = $def_val;
        $rules['type_2']    =  array(
            array(
                'id'    => 0,
                'limit' => '',
                'value' => '',
                'name'  => '',
            )
        );
        if(!empty($row)){
            $this->show_goods_by_actId($row['fa_id'],$row['fa_use_type']);
            $rules['type_'.$row['fa_type']]   = $this->get_rules_by_actid($row['fa_id'],$row['fa_type']);
            $add    = 'edit';
        }else{
            $this->output['kind'] = 1;
            $add    = 'add';
        }
        $singleType = 0;
        if($this->wxapp_cfg['ac_type'] == 32){
            $singleType = 1;
        }
        $this->output['singleType'] = $singleType;
        $this->output['isAdd']  = $add;
        $this->output['row']    = $row;
        $this->output['rules']  = $rules;
        $this->buildBreadcrumbs(array(
            array('title' => '满减活动', 'link' => '/wxapp/full/index'),
            array('title' => '添加活动', 'link' => '#'),
        ));
        $this->output['type'] = plum_parse_config('full_type');
        $this->displaySmarty('wxapp/full/add.tpl');
    }

    
    private function get_rules_by_actid($actid,$type){
        $fr_kind    = 1;
        $rule_model = new App_Model_Full_MysqlFullRuleStorage($this->curr_sid);
        $list       = $rule_model->getListByActid($actid);
        if($type == 2){
            $ga_id = array();
            foreach($list as $val){
                $ga_id[] = $val['fr_value'];
            }
            if(!empty($ga_id)){
                $gift_model  = new App_Model_Gift_MysqlGiftActStorage($this->curr_sid);
                $gift        = $gift_model->getListByIds($ga_id,'in',0,0);
            }
        }
        $rule = array();
        foreach($list as $fal){
            $fr_kind    = $fal['fr_kind'];
            if($type  == 2 && isset($gift[$fal['fr_value']])){
                $temp = array(
                    'id'    => $fal['fr_id'],
                    'limit' => $fal['fr_limit'],
                    'value' => $fal['fr_value'],
                    'name'  => $gift[$fal['fr_value']]['ga_name']
                );
            }else{
                $temp = array(
                    'id'    => $fal['fr_id'],
                    'limit' => $fal['fr_limit'],
                    'value' => $fal['fr_value'],
                );
            }
            $rule[] = $temp;
        }
        $this->output['kind'] = $fr_kind;
        return $rule;
    }

    
    private function show_goods_by_actId($actid,$type){
        $goods   = array();
        if($type == 2){
            $goods_model    = new App_Model_Full_MysqlFullGoodsStorage($this->curr_sid);
            $goods_list     = $goods_model->getListByActid($actid);
            foreach($goods_list as $val){
                $goods[] = array(
                    'id'    => $val['fg_id'],
                    'gid'   => $val['fg_gid'],
                    'gname' => $val['g_name'],
                );
            }
        }
        $this->output['goods'] = $goods;
    }

    
    public function saveFullAction(){
        $field                  = array('name','desc');
        $data                   = $this->getStrByField($field,'fa_');
        $data['fa_update_time'] = $_SERVER['REQUEST_TIME'];
        $data['fa_type']        = $this->request->getIntParam('type');
        $data['fa_use_type']    = $this->request->getIntParam('use_type');

        if(!in_array($data['fa_type'],array(1,2,3,4))){
            $this->displayJsonError('错误的活动类型');
        }

        $start                  = $this->request->getStrParam('start_time');
        $end                    = $this->request->getStrParam('end_time');
        $data['fa_start_time']  = strtotime($start);
        $data['fa_end_time']    = strtotime($end);
        if($data['fa_start_time'] <= $_SERVER['REQUEST_TIME'] ||  $data['fa_start_time'] >= $data['fa_end_time']){
            $this->displayJsonError('请选择正确的时间');
        }
        $id         = $this->request->getIntParam('id');
        $act_model  = new App_Model_Full_MysqlFullActStorage($this->curr_sid);
        if($id){
            $ret = $act_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
        }else{
            $data['fa_create_time'] = $_SERVER['REQUEST_TIME'];
            $data['fa_s_id']        = $this->curr_sid;
            $ret = $act_model->insertValue($data);
            $id  = $ret;
        }
        if($ret && $id) {
            $this->deal_activity_rule($id);
            $this->deal_can_used_goods($id);
        }
        App_Helper_OperateLog::saveOperateLog("满减活动【".$data['fa_name']."】保存成功");
        $this->showAjaxResult($ret , '保存');
    }

    
    private function deal_activity_rule($newid){
        $old_act_id  = $this->request->getIntParam('id');
        $rules       = $this->request->getArrParam('rules');
        $type        = $this->request->getIntParam('type');
        $kind        = $this->request->getIntParam('kind');
        $fr_kind     = $type == 1 ? 1 : $kind;
        $rule_model  = new App_Model_Full_MysqlFullRuleStorage($this->curr_sid);
        $insert      = array();
        foreach($rules as $val){
            $limit = floatval($val['limit']);
            $value = $type == 3 ? floatval($val['value']) : intval($val['value']);

            $id    = intval($val['id']);
            if($id){
                $has_id[] = $id;
                $set      = array(
                    'fr_limit' => $val['limit'],
                    'fr_kind'  => $fr_kind,
                    'fr_value' => $value,
                );
                $rule_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
            }else{
                $insert[] = "(null,{$this->curr_sid},{$newid},{$limit},{$fr_kind},{$value},{$_SERVER['REQUEST_TIME']})";
            }
        }
        if(isset($has_id) && $old_act_id){
            $rule_model->deleteHasExist($old_act_id,$has_id,'not in');
        }
        if(!empty($insert)){
            $rule_model->insertBacth($insert);
        }

    }

    
    private function deal_can_used_goods($newid){
        $old_act_id   = $this->request->getIntParam('id');
        $act_type     = $this->request->getIntParam('type');
        $goods        = $this->request->getArrParam('goods');
        $use_type     = $this->request->getIntParam('use_type');
        $goods_model  = new App_Model_Full_MysqlFullGoodsStorage($this->curr_sid);
        if($use_type == 1){
            $goods_model->deleteHasExist($newid);
        }else{
            $goods_model  = new App_Model_Full_MysqlFullGoodsStorage($this->curr_sid);
            $insert       = array();
            foreach($goods as $val){
                $gid = intval($val['gid']);
                $id  = intval($val['id']);
                if($id){
                    $has_id[] = $val['id'];
                    $set      = array(
                        'fg_gid'         => $gid,
                        'fg_update_time' => $_SERVER['REQUEST_TIME'],
                    );
                    $goods_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
                }else{
                    $insert[] = "(null,{$this->curr_sid},{$newid},{$gid},{$act_type},{$_SERVER['REQUEST_TIME']})";
                }
            }
            if(isset($has_id) && $old_act_id){
                $goods_model->deleteHasExist($old_act_id,$has_id,'not in');
            }
            if(!empty($insert)){
                $goods_model->insertBacth($insert);
            }
        }

    }

    
    public function delFullAction(){
        $id = $this->request->getIntParam('id');
        $full_model = new App_Model_Full_MysqlFullActStorage($this->curr_sid);
        $full = $full_model->getRowById($id);
        $set        = array(
            'fa_deleted' => 1
        );
        $ret    = $full_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
        App_Helper_OperateLog::saveOperateLog("满减活动【".$full['fa_name']."】删除成功");
        $this->showAjaxResult($ret,'删除');
    }


}