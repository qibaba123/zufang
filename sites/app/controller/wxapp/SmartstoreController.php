<?php


class App_Controller_Wxapp_SmartstoreController extends App_Controller_Wxapp_InitController {

    const PROMOTION_TOOL_KEY    = 'sjfx';
    const WEIXIN_PAT_REDPACK    = 1;//微信红包形式
    const WEIXIN_PAY_TRANSFER   = 2;//微信企业转账到零钱
    const WEIXIN_PAY_BANK       = 3;//微信企业转账到银行卡

    public function __construct() {
        parent::__construct();

    }
    
    private function _shop_default_tpl(){
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        if(!$cfg['ac_index_tpl']){
            $data = array('ac_index_tpl'=>51);
            $applet_cfg->findShopCfg($data);
        }
    }

    
    public function showStoreService($tpl_id){
        $service_model = new App_Model_Smart_MysqlStoreServiceStorage($this->curr_sid);
        $service = $service_model->getStoreRowBySid($tpl_id,$this->curr_sid);
        $json = array();
        foreach($service as $key => $val){
            $json[] = array(
                'index'     => $key ,
                'title'     => $val['ass_name'],
                'imgsrc'    => $val['ass_cover']

            );
        }
        $this->output['service'] = json_encode($json);
    }
    private function _save_store_service($tpl_id,$ass_id){
        $service_model = new App_Model_Smart_MysqlStoreServiceStorage($this->curr_sid);
        $service       = $this->request->getArrParam('service');
        if(!empty($service)){
            $service_list = $service_model->getStoreRowBySid($tpl_id,$this->curr_sid);
            if(!empty($service_list)){
                $del_id = array();
                foreach($service_list as $val){
                    if(isset($service[$val['ass_sort']])){
                        $set = array(
                            'ass_ass_id'          => $ass_id,
                            'ass_sort'            => $service[$val['ass_sort']]['index'],
                            'ass_name'            => $service[$val['ass_sort']]['title'],
                            'ass_cover'           => $service[$val['ass_sort']]['imgsrc'],
                            'ass_update_time'     => time(),
                        );
                        $up_ret = $service_model->updateById($set,$val['ass_id']);
                        unset($service[$val['ass_sort']]);
                    }else{
                        $del_id[] = $val['ass_id'];
                    }
                }
                if(!empty($del_id)){
                    $service_where = array();
                    $service_where[] = array('name' => 'ass_id','oper' => 'in' , 'value' => $del_id);
                    $service_model->deleteValue($service_where);
                }

            }
            if(!empty($service)){
                $insert = array();
                foreach($service as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$tpl_id}','{$ass_id}','{$val['title']}','{$val['imgsrc']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $service_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'ass_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $service_model->deleteValue($where);
        }
    }
    
    public function delDynamicAction(){
        $id         = $this->request->getIntParam('id');
        $dynamic_storage = new App_Model_Smart_MysqlStoreDynamicStorage($this->curr_sid);
        if($id){
            $set    = array(
                'asd_deleted' => 1
            );
            $ret    = $dynamic_storage->updateById($set, $id);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("店铺动态删除成功");
            }

            $this->showAjaxResult($ret);
        }
    }
    
    public function batchSlide($resId,$is_add=0){
        $slide_model    = new App_Model_Smart_MysqlStoreDynamicSlideStorage($this->curr_sid);
        $maxNum         = $this->request->getStrParam('slide-img-num');
        $slide          = array();
        if($is_add){
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                if($temp){
                    $slide[] = "(NULL, '{$this->curr_sid}', '{$resId}','{$temp}', 0, '".time()."')";
                }
            }
            $slide_model->batchSave($slide);
        }else{
            $sl_id = array();
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                $temp_id = $this->request->getIntParam('slide_id_'.$i);
                if($temp && $temp_id == 0){
                    $slide[] = $temp;
                }
                if($temp_id){
                    $sl_id[] = $temp_id;
                }
            }
            $del_id = array();
            $old_slide = $slide_model->getListByDidSid($resId);
            foreach($old_slide as $val){
                if(!in_array($val['ads_id'],$sl_id)){
                    $del_id[] = $val['ads_id'];
                }
            }
            if(count($slide) <= count($del_id)){
                for($d=0 ; $d < count($del_id) ; $d++){
                    if(isset($slide[$d]) && $slide[$d]){
                        $slide_model->updateSlide($del_id[$d],$slide[$d]);
                        unset($del_id[$d]);
                    }
                }
                if(!empty($del_id)){
                    $slide_model->deleteSlide($resId,$del_id);
                }
            }else{
                $batch_slide = array();
                for($s=0 ; $s < count($slide) ; $s++){
                    if(isset($del_id[$s]) && $del_id[$s]){
                        $slide_model->updateSlide($del_id[$s],$slide[$s]);
                        unset($slide[$s]);
                    }else{
                        $sTemp = plum_sql_quote($slide[$s]);
                        $batch_slide[] = "(NULL, '{$this->curr_sid}', '{$resId}','{$sTemp}', 0, '".time()."')";
                    }
                }
                if(!empty($batch_slide)){
                    $slide_model->batchSave($batch_slide);
                }
            }
        }
    }
    
    private function _show_store_list($json=true){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'ass_s_id','oper' => '=','value' =>$this->curr_sid);
        $store_model    = new App_Model_Smart_MysqlStoreStorage($this->curr_sid);
        $total          = $store_model->getCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index <= $total){
            $sort = array('ass_create_time' => 'DESC');
            $list = $store_model->getList($where,$index,$this->count,$sort);
        }
        if($json){
            $this->output['storeList'] = json_encode($list);
        }else{
            $this->output['storeList'] = $list;
        }
    }
    
    public function delStoreAction(){
        $id     = $this->request->getIntParam('id');
        $set    = array(
            'ass_deleted' => 1
        );
        $store_model = new App_Model_Smart_MysqlStoreStorage($this->curr_sid);
        $ret = $store_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("店铺删除成功");
        }

        $this->showAjaxResult($ret);
    }
}