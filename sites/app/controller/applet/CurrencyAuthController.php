<?php


class App_Controller_Applet_CurrencyAuthController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct();

    }

    
    public function informationCollectionAction(){
        $id  = $this->request->getIntParam('id');
        $collection_model = new App_Model_Article_MysqlInformationCollectionStorage($this->sid);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();

        // 是否已经收藏过
        $row = $collection_model->getCollectionByMidPid($this->member['m_id'],$id);
        $info['data'] = array(
            'result' => true,
            'msg'    => ''
        );
        // 已收藏
        if($row){
            $collection_model->deleteById($row['aic_id']);
            $information_storage->addReduceInformationNum($id,'collection','reduce');
            $info['data']['msg'] = '取消成功';
            $info['data']['isCollection'] = 0;
            $this->outputSuccess($info);
        }else{
            $information_storage->addReduceInformationNum($id,'collection','add');
            $data = array(
                'aic_s_id'   => $this->sid,
                'aic_m_id'   => $this->member['m_id'],
                'aic_ai_id' => $id,
                'aic_time'   => time()
            );
            $collection_model->insertValue($data);
            $info['data']['msg'] = '收藏成功';
            $info['data']['isCollection'] = 1;
            // 收藏获取积分
            $point_storage = new App_Helper_Point($this->sid);
            $point_storage->gainPointBySource($this->uid,App_Helper_Point::POINT_SOURCE_COLLECTION);
            $this->outputSuccess($info);
        }
    }

    
    public function myInformationCommentAction(){
        $page = $this->request->getIntParam('page');
        $index = $this->count * $page;
        $comment_model = new App_Model_Applet_MysqlAppletInformationCommentStorage($this->sid);
        $data = [];
        $where = [];
        $where[] = ['name' => 'aic_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'aic_m_id', 'oper' => '=', 'value' => $this->member['m_id']];
        $sort = ['aic_time'=>'desc'];
        $list = $comment_model->getCommentListInformation($where,$index,$this->count,$sort);
        if($list){
            foreach ($list as $val){
                $data[] = [
                    'id' => $val['aic_id'],
                    'infoId' => $val['aic_ai_id'],
                    'title' => $val['ai_title'],
                    'brief' => $val['ai_brief'],
                    'cover' => $this->dealImagePath($val['ai_cover']),
                    'comment' => isset($val['aic_comment']) ? plum_strip_sql_quote($val['aic_comment']) : '',
                ];
            }
            $info['data'] = $data;
            $this->outputSuccess($info);
        }else{
            $this->outputError('没有更多信息了');
        }
    }

}