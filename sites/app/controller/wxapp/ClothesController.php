<?php

class App_Controller_Wxapp_ClothesController extends App_Controller_Wxapp_InitController{

    public function __construct(){
        parent::__construct();
        $this->_check_clothes_status();
    }
    
    private function _check_clothes_status(){
        $clothes  =  $this->curr_shop['s_clothes_status'];
        if(!$clothes){
            plum_url_location('您还没有开启试衣间功能,请联系工作人员咨询','/wxapp/goods/index');
        }else{
            $this->output['clothes']  = $clothes;
        }
    }

    
    public function clothesAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '/wxapp/goods/index?platform=clothes'),
            array('title' => '试衣间', 'link' => '#')
        ));

        $this->_get_clothes_room_img();
        $this->displaySmarty('wxapp/goods/goods-clothes-new.tpl');
    }
    private function _get_clothes_room_img(){
        $page                = $this->request->getIntParam('page');
        $index               = $this->count * $page;
        $output['gid']       = $this->request->getIntParam('gid');
        $output['type']      = $this->request->getStrParam('type','color');
        $imgType             = array('model'=>array('id'=>1,'desc'=>'模特'),'color'=>array('id'=>2,'desc'=>'面料'));
        $clothes_storage     = new App_Model_Goods_MysqlClothesRoomStorage($this->curr_sid);
        $where               = array();
        $where[]             = array('name'=>'gcri_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($output['type']){
            if($output['type'] == 'color'){
                $where[]             = array('name'=>'gcri_g_id','oper'=>'=','value'=>$output['gid']);
            }else{
                $where[]             = array('name'=>'gcri_copy_status','oper'=>'=','value'=>2);//复用的图片
            }
            $output['desc']  = $imgType[$output['type']]['desc'];
            $where[]         = array('name'=>'gcri_type','oper'=>'=','value'=>$imgType[$output['type']]['id']);
        }
        $sort                = array('gcri_create_time'=>'DESC');
        $output['list']      = $clothes_storage->getList($where,$index,$this->count,$sort);
        $total               = $clothes_storage->getCount($where);
        $pageCfg             = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $product_model     = new App_Model_Goods_MysqlClothesProductStorage($this->curr_sid);
        $output['p_data']  = $product_model->getProductDataByGid($output['gid']);


        $this->output['choseLink'] = array(
            array('href'  => '/wxapp/goods/clothes?type=model&gid='.$output['gid'],'key'=> 'model','label' => '模特'),
            array('href'  => '/wxapp/goods/clothes?type=color&gid='.$output['gid'],'key'=> 'color','label' => '面料'),
        );
        $this->showOutput($output);
    }
    
    public function addRoomProductionAction(){
        $res       = array('ec'=> 400,'em'    => '保存失败，请重试！');
        $data      = array();
        $filedArr  = array('code','name','spec','width','weight');
        foreach ($filedArr as $val){
            $data['gcp_'.$val] = $this->request->getStrParam($val);
        }
        $data['gcp_g_id']   = $this->request->getIntParam('g_id');
        $gcpId              = $this->request->getIntParam('gcp_id');//代表编辑
        if($data && $data['gcp_g_id']){
            $product_model  = new App_Model_Goods_MysqlClothesProductStorage($this->curr_sid);
            if($gcpId){
                $data['gcp_update_time'] = time();
                $ret            = $product_model->updateById($data,$gcpId);
            }else{
                $data['gcp_create_time'] = time();
                $data['gcp_s_id']        = $this->curr_sid;
                $ret            = $product_model->insertValue($data);
            }
            if($ret){
                $res       = array('ec'=> 200,'em'    => '操作成功！');
                App_Helper_OperateLog::saveOperateLog("保存试衣间商品【{$data['gcp_name']}】成功");
            }
        }
        $this->displayJson($res);
    }


    
    public function addRoomImgAction(){
        $res = array('ec'    => 400,'em'    => '上传失败，请重试！');
        $type     = $this->request->getStrParam('type');
        $gid      = $this->request->getIntParam('gid');
        $uploader = new Libs_File_Transfer_Uploader(array('image|gallery'));
        $result   = $uploader->receiveFile('room_img');
        $imgData  = $_FILES['room_img'];
        if($result  && $type){
            $imgType             = array('model'=>1,'color'=>2);
            if($imgData['size'] <= 1048576*2){
                $clothes_storage = new App_Model_Goods_MysqlClothesRoomStorage($this->curr_sid);
                $insertData      = array(
                    'gcri_path'  => $result['room_img'],
                    'gcri_name'  => $imgData['name'],
                    'gcri_type'  => $imgType[$type],
                    'gcri_g_id'  => $gid,
                    'gcri_s_id'  => $this->curr_sid,
                    'gcri_create_time' => time(),
                    'gcri_update_time' => time()
                );
                $ret  =  $clothes_storage->insertValue($insertData);
                if($ret){
                    $res = array('ec'    => 200,'em'    => '上传成功！');
                    App_Helper_OperateLog::saveOperateLog("保存试衣间图片成功");
                }
            }else{
                $res['em'] = '请选择小于2M的图片上传';
            }
        }else{
            $res['em'] = '请选择正确的图片格式';
        }

        $this->displayJson($res);
    }
    
    public function delClothesImgAction(){
        $res = array('ec'    => 400,'em'    => '删除失败！');
        $id  =  $this->request->getIntParam('id');
        if($id){
            $clothes_storage = new App_Model_Goods_MysqlClothesRoomStorage($this->curr_sid);
            $row  = $clothes_storage->getRowById($id);
            if($row['gcri_type']==1){
                unlink(PLUM_DIR_ROOT.$row['gcri_path']);
            }

            $ret  = $clothes_storage->deleteById($id);
            if($ret){
                $res = array('ec'=> 200,'em'=> '删除成功！');
                App_Helper_OperateLog::saveOperateLog("删除试衣间图片成功");
            }
        }
        $this->displayJson($res);
    }
    
    public function copyModelImgAction(){
        $res              = array('ec'    => 400,'em'    => '复用失败！');
        $gid              =  $this->request->getIntParam('gid');
        $clothes_storage  = new App_Model_Goods_MysqlClothesRoomStorage($this->curr_sid);
        $clothesList      = $clothes_storage->getModelListSid();
        if($clothesList){
            $insert = array();
            foreach ($clothesList as $val){
                $insert[]  = "(NULL, {$this->curr_sid}, '{$gid}', '{$val['gcri_path']}', '{$_SERVER['REQUEST_TIME']}', '{$_SERVER['REQUEST_TIME']}','1','2')" ;
            }
            $ret       = $clothes_storage->insertBatch($insert);
            if($ret){
                $res = array('ec'=> 200,'em'=> '复用成功！');
                App_Helper_OperateLog::saveOperateLog("复用试衣间图片成功");
            }
        }else{
            $res['em']     = '当前没有公共图片';
        }
        $this->displayJson($res);
    }

    
    public function saveImgByShopModelAction(){
        $imgArr  =  $this->request->getArrParam('imgArr');
        $result  =  array('ec'=>400,'em'=>'保存失败哦');
        if($imgArr){
            $insert = array();
            foreach ($imgArr as $val){
                $insert[]  = "(NULL, {$this->curr_sid}, '{$val}', '{$_SERVER['REQUEST_TIME']}', '{$_SERVER['REQUEST_TIME']}','1','2')" ;
            }
            $clothes_storage  = new App_Model_Goods_MysqlClothesRoomStorage($this->curr_sid);
            $ret              = $clothes_storage->insertShopBatch($insert);
            if($ret){
                $result  =  array('ec'=>200,'em'=>'保存成功');
                App_Helper_OperateLog::saveOperateLog("保存试衣间模特图片成功");
            }
        }
        $this->displayJson($result);
    }





}