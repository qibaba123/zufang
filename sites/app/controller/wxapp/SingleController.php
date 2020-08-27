<?php

class App_Controller_Wxapp_SingleController extends App_Controller_Wxapp_InitController{

    public function __construct(){
        parent::__construct();
    }

    
    private function showShopTpl($tpl_id=26){
        $tpl_model = new App_Model_Applet_MysqlAppletSinglePageStorage($this->curr_sid);
        $tpl = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'asp_tpl_id'        => $tpl_id,
                'asp_head_title'   => '这里填写顶部标题',
                'asp_name'         => '这里填写公司、/店铺名称',
                'asp_mobile'       => '186XXXXXXXX',
                'asp_address'      => '河南省郑州市郑东新区CBD商务内环11号金成东方国际',
                'asp_lng'          => '113.5',
                'asp_lat'          => '34.5',
                'asp_content'      => '这里添加图文信息',
                'asp_jump_open'    => 0,
                'asp_jump_background' => '',
                'asp_jump_appid'   => '',
                'asp_background_music'   => '',
            );
        }
        $this->output['tpl'] = $tpl;
        $menu_model = new App_Model_Applet_MysqlAppletSingleMenuStorage($this->curr_sid);
        $where[] = array('name' => 'asm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'asm_asp_id', 'oper' => '=', 'value' => $tpl['asp_id']);
        $menu_list = $menu_model->getList($where, 0, 0, array('asm_index' => 'asc'));
        $meunList = array();
        foreach($menu_list as $val){
            $meunList[] = array(
                'index' => $val['asm_index'],
                'isShow'=> $val['asm_show']==1?true:false,
                'name'  => $val['asm_name'],
                'type'  => $val['asm_type'],
                'icon'  => $val['asm_icon'],
                'content'=>$val['asm_content'],
                'category' => $val['asm_category']
            );
        }
        $this->output['meunList'] = json_encode($meunList?$meunList:'');
    }

    
    private function showShopTplJump($tpl_id=26){
        $tpl_model = new App_Model_Applet_MysqlAppletSinglePageJumpStorage($this->curr_sid);
        $tpl = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'aspj_tpl_id'        => $tpl_id,
                'aspj_head_title'   => '这里填写顶部标题',
                'aspj_name'         => '这里填写公司名称',
                'aspj_jump_background' => '',
                'aspj_jump_appid'   => '',
                'aspj_background_music'   => '',
            );
        }
        $this->output['tpl'] = $tpl;
    }

    
    private function _show_index_slide($tpl_id=26){
        $slide_model = new App_Model_Shop_MysqlShopSlideStorage($this->curr_sid);
        $slide = $slide_model->fetchSlideShowList($tpl_id);
        $json = array();
        foreach($slide as $key => $val){
            $json[] = array(
                'index'     => $key ,
                'imgsrc'    => $val['ss_path'],
                'link'      => $val['ss_link'],
                'articleId' => $val['ss_link'],
                'articleTitle' => $val['ss_article_title'],

            );
        }
        $this->output['slide'] = json_encode($json);
    }
    public function saveAppletTplAction(){
        $tpl_id = $this->wxapp_cfg['ac_index_tpl'] ? $this->wxapp_cfg['ac_index_tpl'] : 26;
        $tpl['asp_head_title']= $this->request->getStrParam('title');
        $tpl['asp_background_music']= $this->request->getStrParam('music');
        $tpl['asp_name']      = $this->request->getStrParam('name');
        $tpl['asp_address']   = $this->request->getStrParam('address');
        $tpl['asp_mobile']    = $this->request->getStrParam('mobile');
        $tpl['asp_lng']       = $this->request->getStrParam('longitude');
        $tpl['asp_lat']       = $this->request->getStrParam('latitude');
        $tpl['asp_appoint_btn_img'] = $this->request->getStrParam('bottomImg');
        $tpl['asp_content']   = $this->request->getParam('content');
        $appointInfo                = $this->request->getArrParam('appointInfo');
        $bottomMenu               = $this->request->getArrParam('bottomMenu');
        $jumpInfo                = $this->request->getArrParam('jumpInfo');
        $tpl['asp_appoint_ison']     = $appointInfo['isOn']=='false'?0:1;
        $tpl['asp_appoint_title']    = $appointInfo['title'];
        $tpl['asp_appoint_btn_text'] = $appointInfo['btnTxt'];
        $tpl['asp_bottom_bg_color']    = $bottomMenu['bgColor'];
        $tpl['asp_bottom_text_color'] = $bottomMenu['textColor'];
        $tpl['asp_jump_open']        = $jumpInfo['isOn']=='false'?0:1;
        $tpl['asp_jump_background']  = $jumpInfo['background'];
        $tpl['asp_jump_appid']       = $jumpInfo['appid'];

        if($tpl_id == 63){
            $tpl['asp_brief']            = $this->request->getStrParam('brief');
            $tpl['asp_logo']             = $this->request->getStrParam('logo');
            $tpl['asp_img_title']        = $this->request->getStrParam('imgTitle');
            $tpl['asp_video_img']        = $this->request->getStrParam('videoImg');
            $tpl['asp_video_url']        = $this->request->getStrParam('videoUrl');
            $videoShow                   = $this->request->getStrParam('videoShow');
            $imgShow                     = $this->request->getStrParam('imgShow');
            $mapShow                     = $this->request->getStrParam('mapShow');
            $tpl['asp_video_show'] = $videoShow == 'true' ? 1 : 0;
            $tpl['asp_img_show'] = $imgShow == 'true' ? 1 : 0;
            $tpl['asp_map_show'] = $mapShow == 'true' ? 1 : 0;
        }
        $index_tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row   = $index_tpl_model->getRowBySid($tpl_id,$this->curr_sid);
        if($row){
            $tpl_model = new App_Model_Applet_MysqlAppletSinglePageStorage($this->curr_sid);
            $tpl_row = $tpl_model->findUpdateBySid($tpl_id);
            if(!empty($tpl_row)){
                $ret = $tpl_model->findUpdateBySid($tpl_id,$tpl);
            }else{
                $tpl['asp_tpl_id']     = $tpl_id;
                $tpl['asp_s_id']       = $this->curr_sid;
                $tpl['asp_create_time']= time();
                $ret = $tpl_model->insertValue($tpl);
            }
            $result = $this->save_shop_slide_new($tpl_id);
            $this->save_bottom_menu($ret?$ret:$tpl_row['asp_id']);
            if($this->wxapp_cfg['ac_index_tpl'] == 63){
                $this->_save_index_img($tpl_id);
            }
            if($ret || $result){
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("首页模板【{$row['it_name']}】保存成功");
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }
    public function saveAppletTplJumpAction(){
        $tpl_id = $this->wxapp_cfg['ac_index_tpl'] ? $this->wxapp_cfg['ac_index_tpl'] : 26;
        $tpl['aspj_head_title']= $this->request->getStrParam('title');
        $jumpInfo                = $this->request->getArrParam('jumpInfo');
        $tpl['aspj_jump_background']  = $jumpInfo['background'];
        $tpl['aspj_jump_appid']       = $jumpInfo['appid'];
        $index_tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row   = $index_tpl_model->getRowBySid($tpl_id,$this->curr_sid);
        if($row){
            $tpl_model = new App_Model_Applet_MysqlAppletSinglePageJumpStorage($this->curr_sid);
            $tpl_row = $tpl_model->findUpdateBySid($tpl_id);
            if(!empty($tpl_row)){
                $ret = $tpl_model->findUpdateBySid($tpl_id,$tpl);
            }else{
                $tpl['aspj_tpl_id']     = $tpl_id;
                $tpl['aspj_s_id']       = $this->curr_sid;
                $tpl['aspj_create_time']= time();
                $ret = $tpl_model->insertValue($tpl);
            }
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("跳转页信息配置保存成功");
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }
    private function save_bottom_menu($id){
        $menuList = $this->request->getArrParam('menuList');
        $menu_model = new App_Model_Applet_MysqlAppletSingleMenuStorage($this->curr_sid);
        $where[] = array('name' => 'asm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'asm_asp_id', 'oper' => '=', 'value' => $id);
        $menu_list = $menu_model->getList($where, 0, 0, array('asm_index' => 'asc'));
        $categoryMenu = array(
            2 => 'phone',
            3 => 'address',
            4 => 'appoint'
        );
        foreach($menuList as $key => $val){
            $data = array();
            $data['asm_s_id'] = $this->curr_sid;
            $data['asm_asp_id'] = $id;
            $data['asm_index'] = $val['index'];
            $data['asm_show'] = $val['isShow']=='true'?1:0;
            $data['asm_name'] = $val['name'];
            $data['asm_type'] = $val['category'] > 1 ? $categoryMenu[$val['category']] : 'article'.$key;
            $data['asm_icon'] = $val['icon'];
            $data['asm_content'] = $val['content'];
            $data['asm_category'] = $val['category'] && $val['category']>0 ? $val['category'] : 1;
            if($menu_list[$val['index']]){
                $menu_model->updateById($data, $menu_list[$val['index']]['asm_id']);
            }else{
                $data['asm_create_time'] = time();
                $menu_model->insertValue($data);
            }
        }
    }

    
    private function _get_index_img($tpl_id=63){
        $data = array();
        $indexImg_model = new App_Model_Applet_MysqlAppletSingleIndexImgStorage($this->curr_sid);
        $indexImg_list = $indexImg_model->fetchImgShowList($tpl_id);
        if($indexImg_list){
            foreach ($indexImg_list as $key => $val){
                $data[] =array(
                    'index'     => $key ,
                    'imgsrc'    => $val['asii_path'],
                );
            }
        }
        $this->output['indexImg'] = json_encode($data);
    }

    
    private function _save_index_img($tpl_id=63){
        $indexImg = $this->request->getArrParam('indexImg');
        $indexImg_model = new App_Model_Applet_MysqlAppletSingleIndexImgStorage($this->curr_sid);
        if(!empty($indexImg)){
            $indexImg_list = $indexImg_model->fetchImgShowList($tpl_id);
            if(!empty($indexImg_list)){
                $del_id = array();
                foreach($indexImg_list as $val){
                    if(isset($indexImg[$val['asii_weight']])){
                        $set = array(
                            'asii_weight' => $indexImg[$val['asii_weight']]['index'],
                            'asii_path'   => $indexImg[$val['asii_weight']]['imgsrc'],
                        );
                        $up_ret = $indexImg_model->updateById($set,$val['asii_id']);
                        unset($indexImg[$val['asii_weight']]);
                    }else{
                        $del_id[] = $val['asii_id'];
                    }
                }
                if(!empty($del_id)){
                    $indexImg_where = array();
                    $indexImg_where[] = array('name' => 'asii_id','oper' => 'in' , 'value' => $del_id);
                    $indexImg_model->deleteValue($indexImg_where);
                }

            }
            if(!empty($indexImg)){
                $insert = array();
                foreach($indexImg as $val){
                    $insert[] = " (NULL, {$this->curr_sid},  {$tpl_id},  '{$val['imgsrc']}', '{$val['index']}', '0', '".time()."')";
                }
                $ins_ret = $indexImg_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'asii_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'asii_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $indexImg_model->deleteValue($where);
        }
        return true;
    }
}