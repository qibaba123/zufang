<?php

class App_Controller_Applet_HelpController extends App_Controller_Applet_InitController  {

    public function __construct() {
        parent ::__construct(true);
    }

    //商城帮助文章列表
    public function articleListAction(){
        $data = $this->_article_list();
        if($data){
            $this->outputSuccess($data);
        }else{
            $this->outputError('数据加载完毕');
        }
    }

    private function _article_list(){
        $page = $this->request->getIntParam('page');
//        $this->count = 20;
        $goods_model    = new App_Model_Article_MysqlShopHelpStorage();
        $index  = $page*$this->count;
        $sort   = array('ha_sort' => 'DESC');
        $where=array();
        $list  = $goods_model->getList($where, $index, $this->count,$sort);
        $info = array();
        if($list){
            foreach ($list as $val){

                $info['data'][] = array(
                    'id'      => $val['ha_id'],
                    'title'   => $val['ha_title'],
                    'content' => plum_parse_img_path($val['ha_content']),
                    'add_time'=> $val['ha_add_time'],
                );
            }
        }
        return $info;
    }

    /*
     * 帮助中心文章列表
     */
    public function helpCenterListAction(){
        $page = $this->request->getIntParam('page');
        $this->count = 20;
        $goods_model    = new App_Model_Applet_MysqlAppletHelpCenterInfoStorage($this->sid);
        $index  = $page*$this->count;
        $sort   =['ahci_sort' => 'DESC','ahci_update_time'=>'DESC'];
        $where=[];
        $where[] = ['name' => 'ahci_s_id','oper' => '=','value' =>$this->sid];
        $list  = $goods_model->getList($where, $index, $this->count,$sort);
        $info = [];
        $data = [];
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'      => $val['ahci_id'],
                    'title'   => $val['ahci_title'],
                );
            }
        }
        $info['data']['info']['shopPhone'] = $this->shop['s_phone'] ? $this->shop['s_phone'] : '';
        $info['data']['list'] = $data;
        $this->outputSuccess($info);

    }

    /*
     * 帮助中心文章详情
     */
    public function helpCenterDetailAction(){
        $id = $this->request->getIntParam('id');
        $goods_model    = new App_Model_Applet_MysqlAppletHelpCenterInfoStorage($this->sid);
        $row = $goods_model->getRowById($id);
        if($row){
            $data = [
                'id' => $row['ahci_id'],
                'title' => $row['ahci_title'],
                'content' => plum_parse_img_path_new($row['ahci_content']),
            ];
            $info['data'] = $data;
            $this->outputSuccess($info);
        }else{
            $this->outputError('未找到文章信息');
        }
    }

}