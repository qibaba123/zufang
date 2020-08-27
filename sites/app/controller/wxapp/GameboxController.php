<?php

class App_Controller_Wxapp_GameboxController extends App_Controller_Wxapp_InitController {

    public function __construct(){
        parent::__construct();

    }

    
    public function gamboxTemplateAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '小程序首页模板', 'link' => '#'),
        ));
        $cfg = plum_parse_config('category','applet');
        $tpl_ids = $cfg[30]['tpl'];
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $list       = $tpl_model->getListByTidSidType($tpl_ids,$this->curr_sid,3);
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        $row        = array();
        foreach($list as $val){
            if(empty($row) && $val['it_id'] == $cfg['ac_index_tpl']){
                $row = $val;
                break;
            }
        }
        $this->output['cfg']  = $cfg;
        $this->output['list'] = $list;
        $this->output['shop'] = $this->shops[$this->curr_sid];
        $this->output['row']  = $row;
        $this->displaySmarty('wxapp/gamebox/gamebox-template.tpl');
    }

    
    public function indexTplAction(){
        $tpl_id  = $this->request->getIntParam('tpl', 62);
        $this->showIndexTpl($tpl_id);
        $this->showShopTplSlide($tpl_id);
        $this->_shop_information();
        $this->_get_jump_list();
        $this->_get_list_for_select();
        $this->_get_game_for_select();
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '游戏盒子', 'link' => '#'),
            array('title' => '首页配置', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/gamebox/index-tpl_'.$tpl_id.'.tpl');
    }

    
    private function _get_game_for_select($return = false){
        $data = array();
        $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->curr_sid);
        $where[] = array('name'=>'agg_s_id','oper'=>'=','value'=>$this->curr_sid);
        $list = $game_model->getList($where,0,0);
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id' => $val['agg_id'],
                    'name' => $val['agg_name']
                );
            }
        }
        if($return){
            return $data;
        }else{
            $this->output['gameList'] = json_encode($data);
            $this->output['gameSelect'] = $data;
        }

    }

    private function _get_list_for_select($type = ''){
        $linkList = plum_parse_config('link','system');
        $linkType = $linkTypeNew = plum_parse_config('link_type','system');
        $groupType = plum_parse_config('link_type_city','system');
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        unset($linkType[0]);

        if($type == 'mall'){
            unset($groupType[0]);
            $mallType  = plum_parse_config('link_city_mall','system');
            $this->output['mallType'] = json_encode($mallType);
        }

        $this->output['linkList'] = json_encode($link);
        $this->output['linkType'] = json_encode(array_merge($linkType,$groupType));
        $this->output['linkTypeNew'] = json_encode(array_merge($linkTypeNew,$groupType));
    }

    
    private function showIndexTpl($tpl_id=62){
        $tol_model = new App_Model_Gamebox_MysqlGameboxIndexStorage($this->curr_sid);
        $tpl = $tol_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'agi_title'     => '首页',
                'agi_tpl_id'    => $tpl_id,
                'agi_rank_title'=> '排行榜',
                'agi_rank_open' => 1,
                'agi_rank_img'  => '/public/manage/img/zhanwei/zw_fxb_200_200.png'
            );
        }
        $this->output['tpl'] = $tpl;
    }

    
    private function _shop_information(){
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $sort          = array('ai_create_time' => 'DESC');
        $list          = $information_storage->getList($where,0,50,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'      => $val['ai_id'],
                    'title'   => $val['ai_title'],
                    'brief'   => $val['ai_brief'],
                    'cover'   => $val['ai_cover']
                );
            }
        }
        $this->output['information'] = json_encode($data);
    }

    
    public function categoryListAction(){
        $count = 20;
        $page = $this->request->getIntParam('page');
        $index = $page*$count;
        $category_model = new App_Model_Gamebox_MysqlGameboxCategoryStorage($this->curr_sid);
        $where[] = array('name'=>'agc_s_id','oper'=>'=','value'=>$this->curr_sid);

        $category = $category_model->getList($where,$index,$count,array('agc_update_time'=>'desc'));

        foreach ($category as &$val){
            $val['gameCount'] = $this->_get_game_count($val['agc_id']);
        }

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '游戏盒子', 'link' => '#'),
            array('title' => '分类管理', 'link' => '#'),
        ));
        $total = $category_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$count,'jquery',true);
        $this->output['pagination']   = $pageCfg->render();
        $this->output['list'] = $category;
        $this->displaySmarty('wxapp/gamebox/game-category.tpl');
    }

    
    private function _get_game_count($id){
        $count = 0;
        $where[] = array('name'=>'agcl_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'agcl_c_id','oper'=>'=','value'=>$id);
        $link_model = new App_Model_Gamebox_MysqlGameboxCategoryLinkStorage($this->curr_sid);
        $count = $link_model->getGameCount($where);
        return intval($count) ? $count : 0;
    }

    
    public function gameListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = array();
        $where[] = array('name'=>'agg_s_id','oper'=>'=','value'=>$this->curr_sid);

        $this->output['name'] = $this->request->getStrParam('name');
        if($this->output['name']){
            $where[] = array('name'=>'agg_name','oper'=>'like','value'=>"%{$this->output['name']}%");
        }

        $this->output['category'] = $category = $this->request->getIntParam('category');


        $sort = array('agg_update_time' => 'desc');
        if($category){
            $where[] = array('name'=>'agcl_c_id','oper'=>'=','value'=>$category);
            $link_model = new App_Model_Gamebox_MysqlGameboxCategoryLinkStorage($this->curr_sid);
            $total = $link_model->getGameCount($where);
            $list = $link_model->getGameList($where,$index,$this->count,$sort);
        }else{
            $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->curr_sid);
            $total = $game_model->getCount($where);
            $list = $game_model->getList($where,$index,$this->count,$sort);
        }

        $pageCfg = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination']   = $pageCfg->render();
        $this->output['list'] = $list;
        $this->_get_game_category();
        $this->buildBreadcrumbs(array(
            array('title' => '游戏盒子', 'link' => '#'),
            array('title' => '游戏管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/gamebox/game-list.tpl');
    }

    
    private function _get_game_category($return = false){
        $data = array();
        $category_model = new App_Model_Gamebox_MysqlGameboxCategoryStorage($this->curr_sid);
        $where[] = array('name'=>'agc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $category = $category_model->getList($where,0,0,array('agc_update_time'=>'desc'));
        if($category){
            foreach ($category as $key => $val){
                $data[] = array(
                    'id' => $val['agc_id'],
                    'name' => $val['agc_name']
                );
            }
        }
        if($return){
            return $data;
        }else{
            $this->output['categoryList'] = json_encode($data);
            $this->output['categorySelect'] = $data;
        }

    }

    
    private function _save_game_category_link($id,$category){
        $category_model = new App_Model_Gamebox_MysqlGameboxCategoryLinkStorage($this->curr_sid);
        $num = 0;
        if(!empty($category)){
            $category_list = $category_model->getListByGid($id);
            if(!empty($category_list)){
                $del_id = array();
                foreach($category_list as $val){
                    $has = false;
                    $index = 0;
                    foreach($category as $key => $v){
                        if($v['id'] == $val['agcl_id']){
                            $index = $key;
                            $has = true;
                        }
                    }
                    if($has){
                        $set = array(
                            'agcl_c_id'  => $category[$index]['cid']
                        );
                        $up_ret = $category_model->updateById($set,$val['agcl_id']);
                        unset($category[$index]);
                        $num += 1;
                    }else{
                        $del_id[] = $val['agcl_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'agcl_id','oper' => 'in' , 'value' => $del_id);
                    $shortcut_where[] = array('name' => 'agcl_g_id','oper' => '=' , 'value' => $id);
                    $del_ret = $category_model->deleteValue($shortcut_where);
                }

            }
            if(!empty($category)){
                $insert = array();
                foreach($category as $val){
                    $insert[] =  " (NULL,'{$this->curr_sid}', '{$id}','{$val['cid']}') ";
                }
                $ins_ret = $category_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'agcl_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'agcl_g_id','oper' => '=' , 'value' => $id);
            $del_ret = $category_model->deleteValue($where);
        }
        if($up_ret || $del_ret || $ins_ret || $num>0){
            $ret = 1;
        }else{
            $ret = 0;
        }
        return $ret;
    }

    
    private function _get_cate_slide($id){
        $slide_model = new App_Model_Gamebox_MysqlGameboxCategorySlideStorage($this->curr_sid);
        $list = $slide_model->fetchSlideShowList($id);
        $data = array();
        foreach($list as $key => $val){
            $data[] = array(
                'index'     => $key ,
                'imgsrc'    => $val['agcs_path'],
            );
        }
        $this->output['slide'] = json_encode($data);
    }

    private function _save_postcate_slide($cateId){
        $slide = $this->request->getArrParam('slide');
        $slide_model = new App_Model_Gamebox_MysqlGameboxCategorySlideStorage($this->curr_sid);
        if(!empty($slide)){
            $slide_list = $slide_model->fetchSlideShowList($cateId);
            if(!empty($slide_list)){
                $del_id = array();
                foreach($slide_list as $val){
                    if(isset($slide[$val['agcs_weight']])){
                        $set = array(
                            'agcs_weight' => $slide[$val['agcs_weight']]['index'],
                            'agcs_path'   => $slide[$val['agcs_weight']]['imgsrc'],
                        );
                        $up_ret = $slide_model->updateById($set,$val['agcs_id']);
                        unset($slide[$val['agcs_weight']]);
                    }else{
                        $del_id[] = $val['agcs_id'];
                    }
                }
                if(!empty($del_id)){
                    $slide_where = array();
                    $slide_where[] = array('name' => 'agcs_id','oper' => 'in' , 'value' => $del_id);
                    $slide_model->deleteValue($slide_where);
                }
            }
            if(!empty($slide)){
                $insert = array();
                foreach($slide as $val){
                    $insert[] = " (NULL, {$this->curr_sid},  {$cateId}, '{$val['imgsrc']}', '{$val['index']}',  '0', '".time()."')";
                }
                $ins_ret = $slide_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'agcs_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'agcs_cate_id','oper' => '=' , 'value' => $cateId);

            $slide_model->deleteValue($where);
        }
        return true;
    }

    
    public function startAppletTplAction(){
        $result     = array(
            'ec'    => 400,
            'em'    => '该模版不可用'
        );
        $id         = $this->request->getIntParam('id');
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row        = $tpl_model->getRowBySid($id,$this->curr_sid);
        if($row || $id==0){
            $set = array(
                'ac_index_tpl'   => $id,
                'ac_update_time' => time()
            );
            $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            $ret = $applet_cfg->findShopCfg($set);
            if($ret){
                $result     = array(
                    'ec'    => 200,
                    'em'    => ' 启用成功'
                );
                App_Helper_OperateLog::saveOperateLog("首页模板【{$row['it_name']}】启用成功");
            }else{
                $result['em'] = '启用失败';
            }
        }
        $this->displayJson($result);
    }

    
    public function saveCenterAction(){
        $data  = array();
        $fieldArr = array('title');
        foreach($fieldArr as $fal){
            $temp = $this->request->getStrParam($fal);
            $data['ct_center_'.$fal] = $temp;
        }

        $data['ct_style_type']  = $this->request->getIntParam('styleType',1);
        $data['ct_service_title']   = $this->request->getStrParam('serviceTitle');
        $list = $this->request->getArrParam('list');
        foreach($list as $key=>$val){
            if($val['name']){
                $data['ct_'.$key.'_name'] = $val['name'];
            }
            if(in_array($val['isShow'],array(0,1))){
                $data['ct_'.$key.'_show'] = $val['isShow'];
            }
        }
        $data['ct_update_time'] = time();
        $center_model = new App_Model_Member_MysqlCenterToolStorage();
        $centerRow    = $center_model->isExistBySid($this->curr_sid);
        if(!empty($centerRow)){
            $ret = $center_model->findUpdateBySid($this->curr_sid,$data);
        }else{
            $data['ct_s_id'] = $this->curr_sid;
            $data['ct_create_time'] = time();
            $ret = $center_model->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存个人中心设置设置成功");
        }

        $this->showAjaxResult($ret,'保存');
    }
}

