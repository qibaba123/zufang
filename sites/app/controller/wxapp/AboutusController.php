<?php



class App_Controller_Wxapp_AboutusController extends App_Controller_Wxapp_InitController{


    public function __construct() {
        parent::__construct();
    }

    //关于我们清除视频
    public function emptyvideoAction(){
        $id = $this->request->getIntParam('id');
        $about_model = new App_Model_aboutus_MysqlAboutUsStorage();
        $update['au_video'] = '';
        $ret = $about_model->updateById($update,$id);
        if($ret){
            $this->displayJsonSuccess(array(),true,'清除成功');
        }else{
            $this->displayJsonError('清除失败');
        }
    }

    //保存上传视频
    public function getlinkAction(){
      //  $type    = $this->request->getIntParam('type');
        $dir     = '/upload/gallery/thumbnail/';
        $tool    = new App_Helper_Tool();
        $upload  = $tool->upload_video_limit_type('link', $dir,0,1);
        //var_dump($upload);exit;
        $this->displayJson($upload);
    }


    //关于我们
    public function indexAction(){
        $about_model = new App_Model_aboutus_MysqlAboutUsStorage();
        $this->output['row'] = $about_model->getRow(array('au_id'=>1));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/about/index.tpl');
    }

    //上传原图片方法
    public function uploadImageAction() {
        $uploader   = new Libs_File_Transfer_Uploader('image|gallery');
        $ret = $uploader->receiveFile('');
        if (!$ret) {
            $this->displayJsonError("上传失败，请重试");
        }
        $this->displayJsonSuccess(array('error' => 0,'url' => plum_deal_image_url($ret['images'])));

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
        $data['au_image1']     = $this->request->getStrParam('add_img2');
   //     $data['au_image2']     = $this->request->getStrParam('image2');
        $data['au_brief']     = $this->request->getStrParam('brief');
        $data['au_brief1']     = $this->request->getStrParam('brief1');
        $data['au_brief2']     = $this->request->getStrParam('brief2');
        $data['au_video_image']   = $this->request->getStrParam('videoimage');
        $data['au_video']         = $this->request->getStrParam('video');
        $about_model = new App_Model_aboutus_MysqlAboutUsStorage();
        $ret = $about_model->updateById($data,1);
        if($ret){
            $this->displayJsonSuccess(array(),true,'保存成功');
        }else{
            $this->displayJsonError('保存失败');
        }
    }

}