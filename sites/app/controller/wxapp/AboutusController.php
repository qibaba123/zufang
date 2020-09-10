<?php



class App_Controller_Wxapp_AboutusController extends App_Controller_Wxapp_InitController{


    public function __construct() {
        parent::__construct();
    }

    //关于我们
    public function indexAction(){
        $about_model = new App_Model_aboutus_MysqlAboutUsStorage();
        $this->output['row'] = $about_model->getRow(array('au_id'=>1));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/about/index.tpl');
    }


    //保存关于我们
    public function saveAboutUsAction(){
        $data['au_c_name']  = $this->request->getStrParam('c_name');
        $data['au_work_start_time'] = $this->request->getStrParam('start_time');
        $data['au_work_end_time'] = $this->request->getStrParam('end_time');
        $data['au_mobile']  = $this->request->getStrParam('mobile');
        $data['au_address'] = $this->request->getStrParam('address');
        $data['au_lng']     = $this->request->getFloatParam('lng');
        $data['au_lat']     = $this->request->getFloatParam('lat');
        $data['au_lat']     = $this->request->getFloatParam('lat');
        $data['au_image']      = $this->request->getStrParam('image');
        $data['au_service_image']      = $this->request->getStrParam('serviceimage');
        $data['au_image1']     = $this->request->getStrParam('image1');
        $data['au_image2']     = $this->request->getStrParam('image2');
        $data['au_brief']     = $this->request->getStrParam('brief');
        $data['au_brief1']     = $this->request->getStrParam('brief1');
        $data['au_brief2']     = $this->request->getStrParam('brief2');
        $about_model = new App_Model_aboutus_MysqlAboutUsStorage();
        $ret = $about_model->updateById($data,1);
        if($ret){
            $this->displayJsonSuccess(array(),true,'保存成功');
        }else{
            $this->displayJsonError('保存失败');
        }
    }

}