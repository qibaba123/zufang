<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/8/1
 * Time: 下午5:05
 */

class App_Controller_Applet_ParkController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct();

    }


    //获取办公室/工位列表
    public function houseListAction(){
        $page   = $this->request->getIntParam('page');
        $type   = $this->request->getIntParam('type'); // 1.工位 2.办公室
        $pro    = $this->request->getIntParam('pro');
        $city   = $this->request->getIntParam('city');
        $area   = $this->request->getIntParam('area');
        $park   = $this->request->getIntParam('park');
        $index  = $page * $this->count;
        $house_model = new App_Model_Resources_MysqlResourcesStorage();
        $where[] = array('name'=>"ahr_type",'oper'=>"=",'value'=>$type);
        if($pro){
            $where[] = array('name'=>"ahr_province",'oper'=>"=",'value'=>$pro);
        }
        if($city){
            $where[] = array('name'=>"ahr_city",'oper'=>"=",'value'=>$city);
        }
        if($area){
            $where[] = array('name'=>"ahr_zone",'oper'=>"=",'value'=>$area);
        }
        if($park){
            $where[] = array('name'=>"ahr_park",'oper'=>"=",'value'=>$park);
        }
        $list = $house_model->getList($where,$index,$this->count,array('ahr_weight'=>"DESC"));
        foreach($list as $val){
            $data['list'][] = array(
                'id'   => $val['ahr_id'],
                'name' => $val['ahr_title'],
                'number' => $val['ahr_number'],
                'cover'  => $this->dealImagePath($val['ahr_cover']),
                'brief'  => $val['ahr_brief'],
                'price'  => $val['ahr_price'],
                'stock'  => $val['ahr_stock']
            );
        }
        if($list){
            $this->displayJsonSuccess($data,true,'获取成功');
        }else{
            $this->displayJsonError('没有数据');
        }

    }

    //办公室/工位详情
    public function houseDetailsAction(){
        $id   = $this->request->getIntParam('id');
        $house_model = new App_Model_Resources_MysqlResourcesStorage();
        $row  = $house_model->getRowById($id);
        $data = array(
            'id'   => $row['ahr_id'],
            'name' => $row['ahr_title'],
            'number' => $row['ahr_number'],
          //  'cover'  => $this->dealImagePath($row['ahr_cover']),
            'brief'  => $row['ahr_brief'],
            'price'  => $row['ahr_price'],
            'stock'  => $row['ahr_stock'],
            'content'  => plum_parse_img_path($row['ahr_content']),
        );
        $slide_model = new App_Model_Resources_MysqlResourcesSlideStorage($this->sid);
        $slide_list  = $slide_model->getListByGidSid($id,$this->sid,1);
        $slide = array();
        foreach($slide_list as $val){
            $slide[] = array(
                'image' => $this->dealImagePath($val['ahrs_path'])
            );
        }
        $data['slide'] = $slide;
        $collet_model  = new App_Model_Member_MysqlMemberColletStorage();
        $where         = array();
        $where[]       = array('name'=>'mc_m_id','oper'=>"=",'value'=>$this->member['m_id']);
        $where[]       = array('name'=>'mc_c_id','oper'=>"=",'value'=>$id);
        $where[]       = array('name'=>'mc_type','oper'=>"=",'value'=>2);
        $collet        = $collet_model->getRow($where);
        $data['is_collet'] = $collet?1:0;   //0.未关注  1.已关注
        $this->displayJsonSuccess($data,true,'获取成功');

    }



    //获取园区接口
    public function getparkAction(){
        $area = $this->request->getIntParam('area_id');
        $park_model = new App_Model_Park_MysqlAddressParkStorage();
        $where[] = array('name'=>"ap_area",'oper'=>"=",'value'=>$area);
        $list    = $park_model->getList($where,0,0,array('ap_weight'=>'DESC'));
        foreach($list as $val){
            $data['list'][] = array(
                'id' => $val['ap_id'],
                'name' => $val['ap_name']
            );
        }
        if($list){
            $this->displayJsonSuccess($data,true,'获取成功');
        }else{
            $this->displayJsonError('没有数据');
        }
    }


    //企业服务
    public function serviceListAction(){
        //首页企业服务
        $service_model = new App_Model_Service_MysqlEnterpriseServiceStorage();
        $service       = $service_model->getList(array(),0,0,array('es_weight'=>'DESC'));
        foreach($service as $val){
            if($val['es_type'] == 1){
            $data['goods'][] = array(
                'id'   => $val['es_id'],
                'name' => $val['es_name'],
                'type' => $val['es_type'],
                'logo' => $this->dealImagePath($val['es_logo'])
            );
            }else{
                $data['information'][] = array(
                    'id'   => $val['es_id'],
                    'name' => $val['es_name'],
                    'type' => $val['es_type'],
                    'logo' => $this->dealImagePath($val['es_logo'])
                );
            }
        }
        //企业服务顶部图片
        $data['top_image'] = $this->dealImagePath($this->shop['s_service_image']);
//        if($service){
            $this->displayJsonSuccess($data,true,'获取成功');
//        }else{
//            $this->displayJsonError('获取失败');
//        }
    }


    //企业服务详情
    public function serviceDetailAction(){
        $id = $this->request->getIntParam('id');
        $service_model = new App_Model_Service_MysqlEnterpriseServiceStorage();
        $row        = $service_model->getRowById($id);
        $data   = array(
            'id'    => $row['es_id'],
            'name'  => $row['es_name'],
            'cover' => $this->dealImagePath($row['es_cover']),
            'brief' => $row['es_brief'],
            'price' => $row['es_price'],
            'content' => plum_parse_img_path($row['es_content']),
            'type'    => $row['es_type']
        );
        if($row['es_status'] != 0){
            $format_model = new App_Model_Service_MysqlServiceFormatStorage();
            $where[]      = array('name'=>"sf_e_id",'oper'=>"=",'name'=>$id);
            $format_list  = $format_model->getList($where,0,0,array('sf_create_time'=>'DESC'));
            foreach($format_list as $val){
                $data['format'][] = $val['sf_name'];
            }
        }
        $collet_model  = new App_Model_Member_MysqlMemberColletStorage();
        $where         = array();
        $where[]       = array('name'=>'mc_m_id','oper'=>"=",'value'=>$this->member['m_id']);
        $where[]       = array('name'=>'mc_c_id','oper'=>"=",'value'=>$id);
        $collet        = $collet_model->getRow($where);
        $data['is_collet'] = $collet?1:0;   //0.未关注  1.已关注
        $this->displayJsonSuccess($data,true,'获取成功');
    }


    //企业服务收藏
    public function colletAction(){
        $type = $this->request->getIntParam('type');//1.服务 2.工位/办公室
        $id   = $this->request->getIntParam('id');//收藏ID
        $status   = $this->request->getIntParam('status');//0.未收藏 1.已收藏
        $collet_model  = new App_Model_Member_MysqlMemberCollletStorage();
        if($status == 1){
            $update['mc_deleted'] = 1;
            $ret = $collet_model->updateById($update,$id);
            $em  = '取消';
        }else{
            $insert = array(
                'mc_s_id' => $this->sid,
                'mc_m_id' => $this->member['m_id'],
                'mc_type' => $type,
                'mc_c_id' => $id,
                'mc_create_time' => time()
            );
            $ret = $collet_model->insertValue($insert);
            $em  = '收藏';
        }

        if($ret){
            $this->displayJsonSuccess(array(),true,$em.'成功');
        }else{
            $this->displayJsonError($em.'失败');
        }
    }

    //我的收藏列表
    public function myColletAction(){
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $collet_model  = new App_Model_Member_MysqlMemberCollletStorage();
        $service_model = new App_Model_Service_MysqlEnterpriseServiceStorage();
        $where[]  = array('name'=>"mc_m_id",'oper'=>'=','value'=>$this->member['m_id']);
        $list     = $collet_model->getList($where,$index,$this->count,array('mc_create_time'=>'DESC'));
        foreach($list as $val){
            if($val['mc_type'] == 1){

            }elseif($val['mc_type'] == 2){

            }
            $data['list'][] = array(
                ''
            );
        }
    }




}
