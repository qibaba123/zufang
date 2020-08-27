<?php


class App_Controller_Applet_KnowledgepayAuthController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct();
    }

    
    public function attendanceAction(){
        $attendance_model = new App_Model_Knowpay_MysqlKnowpayAttendanceStorage($this->sid);
        $where = array();
        $where[] = array('name' => 'aka_day', 'oper' => '=', 'value' => strtotime(date('Y-m-d')));
        $where[] = array('name' => 'aka_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 'aka_s_id', 'oper' => '=', 'value' => $this->sid);
        $row = $attendance_model->getRow($where);
        $data['aka_s_id'] = $this->sid;
        $data['aka_m_id'] = $this->member['m_id'];
        $data['aka_day']  = strtotime(date('Y-m-d'));
        $data['aka_create_time'] = time();
        if(!$row){
            $where = array();
            $where[] = array('name' => 'aka_day', 'oper' => '=', 'value' => strtotime(date('Y-m-d', strtotime('-1 day'))));
            $where[] = array('name' => 'aka_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where[] = array('name' => 'aka_s_id', 'oper' => '=', 'value' => $this->sid);
            $row = $attendance_model->getRow($where);
            if($row){
                $data['aka_continuous_days'] = $row['aka_continuous_days'] + 1;
            }else{
                $data['aka_continuous_days'] = 1;
            }
            // 获取积分
            $pointCfg = $this->_fetch_shop_point_cfg();
            $point  = $pointCfg['aps_register'];
            $point  += ($data['aka_continuous_days'] - 1) * $pointCfg['aps_continuous_add'];
            if($pointCfg['aps_continuous_max'] > 0 && $point>$pointCfg['aps_continuous_max']){
                $point = $pointCfg['aps_continuous_max'];
            }
            $title  = "签到奖励{$point}积分";
//            $point_storage = new App_Helper_Point($this->sid);
//            $point_storage->gainPointBySource($this->member['m_id'],App_Helper_Point::POINT_SOURCE_SIGN);
            // bug修复(签到出现双倍积分)
            // zhangzc
            // 2019-10-12
            //知识付费签到记录与其它版本不同 应该注释上面代码使用下面的 可以在普通签到记录表中也添加一条记录
            // dn 2019-10-17
            $normalSignRecord = [
                'curr_time' => $data['aka_create_time'],
                'times' => $data['aka_continuous_days'] - 1 //持续签到天数 未持续签到(即签到天数为1天)则为0
            ];
             $this->memberPointRecord($this->member['m_id'], $point, $title, App_Helper_Point::POINT_INOUT_INCOME, App_Helper_Point::POINT_SOURCE_SIGN,null,$normalSignRecord);
            $data['aka_points'] = $point;
            $ret = $attendance_model->insertValue($data);
            if($ret){
                if($this->applet_cfg['ac_type'] == 30){
                    //触发完成任务
                    App_Helper_Tool::checkGameTask($this->sid, $this->member['m_id'], 1);
                }
                $info['data'] = array(
                    'result' =>true,
                    'msg'    => '签到成功',
                );
                $this->outputSuccess($info);
            }else{
                $this->outputError('签到失败');
            }
        }else{
            $this->outputError('今天已签到过了');
        }
    }

    
    public function memberPointRecord($mid, $point, $title, $type, $source = App_Helper_Point::POINT_SOURCE_TRADE, $extra = null,$normalSignRecord = false) {
        $point  = abs($point);
        $fee    = $type == App_Helper_Point::POINT_INOUT_INCOME ? $point : -$point;
        //会员积分
        App_Helper_MemberLevel::pointTrans($this->sid, $mid, $fee);

        //修改签到记录表中的记录 目前只有applet_knowpay_attendance接口用到了
        // dn 2019-10-17
        if($normalSignRecord && is_array($normalSignRecord)){
            $sign_model = new App_Model_Point_MysqlPointSignStorage($this->sid);
            $record     = $sign_model->findSignByMid($mid);
            if ($record) {
                $updata = array(
                    'ps_last_signtime'  => $normalSignRecord['curr_time'],
                    'ps_last_times'     => $normalSignRecord['times'],
                );
                $sign_model->updateById($updata, $record['ps_id']);
            } else {
                $indata = array(
                    'ps_s_id'       => $this->sid,
                    'ps_m_id'       => $mid,
                    'ps_last_signtime'  => $normalSignRecord['curr_time'],
                    'ps_last_times' => $normalSignRecord['times'],
                );
                $sign_model->insertValue($indata);
            }
        }

        //记录
        $indata = array(
            'pi_s_id'       => $this->sid,
            'pi_m_id'       => $mid,
            'pi_type'       => $type,
            'pi_title'      => $title,
            'pi_point'      => $point,
            'pi_source'     => $source,
            'pi_extra'      => strval($extra),
            'pi_create_time'=> time(),
        );
        $inout_model    = new App_Model_Point_MysqlInoutStorage($this->sid);
        return $inout_model->insertValue($indata);
    }

    // 获取店铺积分相关配置
    private function _fetch_shop_point_cfg(){
        $point_model = new App_Model_Point_MysqlPointSourceStorage($this->sid);
        return $point_model->findUpdateBySid();
    }

    //学习情况表
    public function studyHistoryAction(){
        $days = $this->request->getIntParam('days', 7);
        $study_model = new App_Model_Knowpay_MysqlKnowpayStudyStorage($this->sid);
        for($i=0; $i<$days; $i++){
            $daysArr[] = strtotime(date('Y-m-d', strtotime('-'.$i.' days')));
        }
        $where = array();
        $where[] = array('name' => 'aks_day', 'oper' => 'in', 'value' => $daysArr);
        $where[] = array('name' => 'aks_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 'aks_s_id', 'oper' => '=', 'value' => $this->sid);
        $sort = array('aks_day' => 'ASC');
        $list = $study_model->getList($where, 0, 0, $sort);
        $data = array();
        foreach ($list as $value){
            $data[$value['aks_day']] = $value;
        }
        $info['data']['history'] = array();
        $recentlyArticleCount = 0;
        $recentlyAudioCount = 0;
        $recentlyVideoCount = 0;
        for($i=($days-1); $i>=0; $i--){
            $day = strtotime(date('Y-m-d', strtotime('-'.$i.' days')));
            $recentlyArticleCount += $data[$day]['aks_study_article_count'];
            $recentlyAudioCount += $data[$day]['aks_study_audio_count'];
            $recentlyVideoCount += $data[$day]['aks_study_video_count'];
            $info['data']['history'][] = array(
                'date' => date('m.d', strtotime('-'.$i.' days')),
                'articleCount' => $data[$day]?$data[$day]['aks_study_article_count']:0,
                'audioCount'   => $data[$day]?$data[$day]['aks_study_audio_count']:0,
                'videoCount'   => $data[$day]?$data[$day]['aks_study_video_count']:0,
            );
        }
        $info['data']['recentlyArticleCount'] = $recentlyArticleCount;
        $info['data']['recentlyAudioCount']   = $recentlyAudioCount;
        $info['data']['recentlyVideoCount']   = $recentlyVideoCount;
        $where = array();
        $where[] = array('name' => 'aks_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 'aks_s_id', 'oper' => '=', 'value' => $this->sid);
        $studyTotal = $study_model->getStudyTotal($where);
        $info['data']['articleTotal'] = $studyTotal['articleCount']?$studyTotal['articleCount']:0;
        $info['data']['audioTotal']   = $studyTotal['audioCount']?$studyTotal['audioCount']:0;
        $info['data']['videoTotal']   = $studyTotal['videoCount']?$studyTotal['videoCount']:0;
        $where = array();
        $where[] = array('name' => 'aks_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 'aks_s_id', 'oper' => '=', 'value' => $this->sid);
        $info['data']['daysTotal']   = $study_model->getCount($where);

        $this->outputSuccess($info);
    }

    
    public function commentKnowledgeAction(){
        $gid = $this->request->getIntParam('gid');
        $kid = $this->request->getIntParam('kid');  // 课程ID
        $pid = $this->request->getIntParam('pid'); //评论id
        $content = $this->request->getStrParam('content');
        $cmid = $this->request->getIntParam('cmid');    // 回复会员ID，（回复别人的评论，评论人的ID）
        $cid =  $this->request->getIntParam('cid');
        // 判断会员是否被封号
        if($this->member['m_status']==1){
            $this->outputError('该账户已被管理员封禁，暂停评论');
        }
        if($kid){
            $knowledge_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($this->sid);
            $row = $knowledge_model->getRowById($kid);
            $gid = $row['akk_g_id'];
        }

        
        $content = plum_sql_quote($content);
        if($content && $content!=' '){
            $data = array(
                'akc_s_id'      => $this->sid,
                'akc_g_id'    => $gid,
                'akc_k_id'    => $kid,
                'akc_c_id'    => $pid,
                'akc_comment'   => $content,
                'akc_m_id'      => $this->member['m_id'],
                'akc_reply_mid' => $cmid,
                'akc_acc_id'    => $cid,
                'akc_time'      => time(),
            );
            $comment_model = new App_Model_Knowpay_MysqlKnowpayCommentStorage($this->sid);
            $ret = $comment_model->insertValue($data);
            if($ret){
                if($cmid>0){
                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $member = $member_model->getRowById($cmid);
                }
                $info['data'] = array(
                    'result' =>true,
                    'msg'    => '评论成功',
                    'comment' => array(
                        'avatar'        => $this->member['m_avatar']?$this->dealImagePath($this->member['m_avatar']):($this->member['m_id']?$this->dealImagePath('/public/wxapp/images/applet-avatar.png'):$this->dealImagePath($this->shop['s_logo'])),
                        'id'            => $ret,
                        'comment'       => plum_strip_sql_quote($content),
                        'mid'           => $this->member['m_id'],
                        'nickname'      => $this->member['m_nickname'],
                        'replyMid'      => isset($member['m_id']) && $member['m_id'] > 0 ? $member['m_id'] : 0,
                        'replyNickname' => isset($member['m_nickname']) && $member['m_nickname'] ? $member['m_nickname'] : '',
                        'replayCount'   => 0,
                        'likeCount'     => 0,
                        'isLike'        => 0,
                        'time'          => $this->_format_date(time(), 'list'),
                        'replyList'     => array()
                    )
                );
                $this->outputSuccess($info);
            }else{
                $this->outputError('评论失败');
            }
        }else{
            $this->outputError('请填写评论内容');
        }
    }

    
    private function _format_date($createTime,$type){
        if($type == 'list'){
            $now = time();
            $res = $now - $createTime;

            switch ($res){
                case $res < 60:
                    $date = '1分钟前';
                    break;
                case (60 <= $res && $res < 3600):
                    $date = floor($res/60).'分钟前';
                    break;
                case (3600 <=$res && $res < 86400) :
                    $date = floor($res/3600).'小时前';
                    break;
                case (86400 <= $res && $res < 86400*2) :
                    $date = '昨天';
                    break;
                default:
                    $date = date('m',$createTime).'月'.date('d',$createTime).'　'.date('H:i',$createTime);
            }

        }else{
            $date = date('m',$createTime).'月'.date('d',$createTime).'　'.date('H:i',$createTime);
        }
        return $date;
    }

    //我的评论
    public function myCommentAction(){
        $count = 10;
        $page = $this->request->getIntParam('page');
        $index = $count * $page;
        $comment_model = new App_Model_Knowpay_MysqlKnowpayCommentStorage($this->sid);
        $list = $comment_model->getCommentMember(0,0,-1,$index,$count,$this->member['m_id']);
        $info['data'] = array();
        foreach ($list as $val){
            $info['data'][$val['akc_g_id']]['comment'][] = $this->_post_comment_format($val);;
        }
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        foreach ($info['data'] as $key => $val){
            $goods = $goods_model->getRowById($key);
            $info['data'][$key]['goods'] = $this->_format_goods_details($goods);
        }
        $info['data'] = array_values($info['data']);
        if($list){
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }
    }

    
    private function _format_goods_details($goods){
        $tpl_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->sid);
        $tpl  = $tpl_model->findUpdateBySid($this->applet_cfg['ac_index_tpl']?$this->applet_cfg['ac_index_tpl']:59);
        if($goods){
            $data = array(
                'id'         => $goods['g_id'],
                'name'       => $goods['g_name'],
                'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
                'price'      => floatval($goods['g_price']),
                'weight'     => floatval($goods['g_goods_weight']),
                'oriPrice'   => floatval($goods['g_ori_price']),
                'brief'      => isset($goods['g_brief']) ? $goods['g_brief'] : '',
                'stock'      => $goods['g_stock'],
                'stockShow'  => $goods['g_stock_show'],
                'sold'       => $goods['g_sold'],
                'soldShow'   => $goods['g_sold_show'],
                'freight'    => $goods['g_unified_fee'],
                'totalNum'   => $goods['g_knowledge_total'],
                'author'     => $goods['g_label'],
                'type'       => $goods['g_knowledge_pay_type']
            );

            switch ($goods['g_knowledge_pay_type']){
                case 1:
                    if($tpl['aki_article_cover_type'] == 2){
                        $data['cover'] = isset($goods['g_cover1']) ? $this->dealImagePath($goods['g_cover1']) : '';
                    }
                    $data['coverType'] = $tpl['aki_article_cover_type'];
                    break;
                case 2:
                    if($tpl['aki_audio_cover_type'] == 2){
                        $data['cover'] = isset($goods['g_cover1']) ? $this->dealImagePath($goods['g_cover1']) : '';
                    }
                    $data['coverType'] = $tpl['aki_audio_cover_type'];
                    break;
                case 3:
                    if($tpl['aki_video_cover_type'] == 1){
                        $data['cover'] = isset($goods['g_cover1']) ? $this->dealImagePath($goods['g_cover1']) : '';
                    }
                    $data['coverType'] = $tpl['aki_video_cover_type'];
                    break;
            }

            //显示已学习的课程数量
            $study_model = new App_Model_Knowpay_MysqlKnowpayStudyStorage($this->sid);
            $where = array();
            $where[] = array('name' => 'aks_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where[] = array('name' => 'aks_s_id', 'oper' => '=', 'value' => $this->sid);
            $studyList = $study_model->getList($where);
            foreach ($studyList as $value){
                foreach (json_decode($value['aks_knowledge_ids'], true) as $val){
                    $hadRead[] = $val;
                }
            }

            $knowpay_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($this->sid);
            $data['hadReadNum'] = $knowpay_model->getKnowledgeCountByGid($goods['g_id'], $hadRead);
            $data['updateNum'] = $knowpay_model->getKnowledgeCountByGid($goods['g_id']);

            $uid    = plum_app_user_islogin();
            $vipData = App_Helper_Trade::getGoodsVipPirce($data['price'], $this->sid, $goods['g_id'], 0,$uid, 1);
            $data['price'] = $vipData['price'];
            $data['isVip'] = $vipData['isVip'];
            $data['isVipPrice'] = $goods['g_had_vip_price'];
            $data['vipLabel'] = '会员折扣';

            $data['label'] = array();
            if(isset($goods['g_custom_label'])){
                $labelArr = preg_split("/[\s,]+/",$goods['g_custom_label']);
                foreach ($labelArr as $val){
                    if($val && isset($val)){
                        $data['label'][] = $val;
                    }
                }
            }
            return $data;
        }
        return false;
    }

    
    private function _post_comment_format($val){
        $data = array();
        if(!empty($val)){
            $data = array(
                'id'            => $val['akc_id'],
                'comment'       => $val['akc_comment'],
                'mid'           => $val['akc_m_id'],
                'nickname'      => $val['m_nickname']?$val['m_nickname']:$this->shop['s_name'],
                'replyMid'      => $val['akc_reply_mid'] ? $val['akc_reply_mid'] : 0,
                'replyNickname' => isset($val['akc_reply_mid']) && isset($val['rm_nickname']) ? $val['rm_nickname'] : $this->shop['s_name']
            );
        }
        return $data;
    }

    
    public function commentLikeAction(){
        $pid  = $this->request->getIntParam('pid');
        $like_model = new App_Model_Knowpay_MysqlKnowpayCommentLikeStorage($this->sid);
        // 是否已经点过赞
        $row = $like_model->getLikeByMidPid($this->member['m_id'],$pid);
        $info['data'] = array(
            'result' => true,
            'msg'    => ''
        );
        // 已经点过赞
        if($row){
            $like_model->deleteById($row['akcl_id']);
            $info['data']['msg'] = '取消成功';
            $this->outputSuccess($info);
        }else{
            $data = array(
                'akcl_s_id'   => $this->sid,
                'akcl_m_id'   => $this->member['m_id'],
                'akcl_akc_id' => $pid,
                'akcl_time'   => time()
            );
            $ret = $like_model->insertValue($data);
            $info['data']['msg'] = '点赞成功';
            $this->outputSuccess($info);
        }
    }

    
    public function pointsMallAction(){
        //签到总天数
        $attendance_model = new App_Model_Knowpay_MysqlKnowpayAttendanceStorage($this->sid);
        if($this->sid == 8298){
            Libs_Log_Logger::outputLog($this->member['m_id'],'test.log');
        }
        $where = array();
        $where[] = array('name' => 'aka_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 'aka_s_id', 'oper' => '=', 'value' => $this->sid);
        $info['data']['attendanceCount'] = $attendance_model->getCount($where);
        //是否签到
        $where = array();
        $where[] = array('name' => 'aka_day', 'oper' => '=', 'value' => strtotime(date('Y-m-d')));
        $where[] = array('name' => 'aka_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 'aka_s_id', 'oper' => '=', 'value' => $this->sid);
        $row = $attendance_model->getRow($where);
        $info['data']['hadAttendance'] = $row?1:0;
        //签到规则
        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->sid);
        $tpl  = $tpl_model->findUpdateBySid();
        $info['data']['rule'] = $tpl['aci_point_rule']?plum_parse_img_path($tpl['aci_point_rule']):'';
        //签到列表
        $days = 7;
        for($i=0; $i<$days; $i++){
            $daysArr[] = strtotime(date('Y-m-d', strtotime('-'.$i.' days')));
        }
        $where = array();
        $where[] = array('name' => 'aka_day', 'oper' => 'in', 'value' => $daysArr);
        $where[] = array('name' => 'aka_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 'aka_s_id', 'oper' => '=', 'value' => $this->sid);
        $sort = array('aka_day' => 'ASC');
        $list = $attendance_model->getList($where, 0, 0, $sort);
        $data = array();
        foreach ($list as $value){
            $data[$value['aka_day']] = $value;
        }
        for($i=($days-1); $i>=0; $i--){
            $info['data']['history'][] = array(
                'date' => date('m.d', strtotime('-'.$i.' days')),
                'hadAttendance' => $data[strtotime(date('Y-m-d', strtotime('-'.$i.' days')))]?1:0,
                'points' => $data[strtotime(date('Y-m-d', strtotime('-'.$i.' days')))]['aka_points']?$data[strtotime(date('Y-m-d', strtotime('-'.$i.' days')))]['aka_points']:0
            );
        }
        //总积分
        $info['data']['points'] = $this->member['m_points'];
        $this->outputSuccess($info);
    }

    //已购
    public function hadBuyListAction()
    {
        $type = $this->request->getStrParam('type'); //limit 秒杀订单 bargain 砍价订单
        $knowpayType   = $this->request->getIntParam('knowpayType');    //知识付费类型 1图文 2音频 3视频
        // 检索条件
        $where = array();
        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 't_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 't_status', 'oper' => 'in', 'value' => array(3,4,5,6));
        $where[] = array('name' => 't_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 't_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET);
        if($knowpayType){
            $where[] = array('name' => 't_knowpay_type', 'oper' => '=', 'value' => $knowpayType);
        }

        if($type == 'limit'){
            //秒杀订单
            $where[] = array('name' => 't_applet_type', 'oper' => '=', 'value' => 1);
        }

        if($type == 'bargain'){
            //砍价订单
            $where[] = array('name' => 't_applet_type', 'oper' => '=', 'value' => 5);
        }

        $data = $this->show_trade_list_data($where);
        if ($data) {
            $info['data'] = $data;
            $this->outputSuccess($info);
        } else {
            $this->outputError('订单数据加载完毕');
        }
    }


    private function show_trade_list_data($where = array())
    {
        $sort = array('t_create_time' => 'DESC');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $list = $trade_model->getKnowpayListAction($where, 0, 0, $sort);
        $data['article'] = array();
        $data['audio'] = array();
        $data['video'] = array();
        if($list){
            foreach ($list as $val){
                if($val['g_knowledge_pay_type'] == 1){
                    $data['article'][] = $this->_format_goods_details($val);
                }
                if($val['g_knowledge_pay_type'] == 2){
                    $data['audio'][] = $this->_format_goods_details($val);
                }
                if($val['g_knowledge_pay_type'] == 3){
                    $data['video'][] = $this->_format_goods_details($val);
                }
                $data['all'][] = $this->_format_trade_goods_details($val);
            }
            return $data;
        }else{
            return false;
        }
    }

    private function _format_trade_goods_details($trade){
        $statusNote = plum_parse_config('trade_status');
        $tpl_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->sid);
        $tpl  = $tpl_model->findUpdateBySid($this->applet_cfg['ac_index_tpl']?$this->applet_cfg['ac_index_tpl']:59);
        $data = array(
            'id'         => $trade['g_id'],
            'name'       => $trade['g_name'],
            'cover'      => isset($trade['g_cover']) ? $this->dealImagePath($trade['g_cover']) : '',
            'brief'      => isset($trade['g_brief']) ? $trade['g_brief'] : '',
            'type'       => $trade['g_knowledge_pay_type'],
            'status'        => $trade['t_status'],
            'statusNote'    => isset($statusNote[$trade['t_status']]) ? $statusNote[$trade['t_status']] : '',
            'tid'           => $trade['t_tid'],
            'oriFee'        => $trade['g_price'],
            'total'         => $trade['t_total_fee'],
        );
        switch ($trade['g_knowledge_pay_type']){
            case 1:
                if($tpl['aki_article_cover_type'] == 2){
                    $data['cover'] = isset($trade['g_cover1']) ? $this->dealImagePath($trade['g_cover1']) : '';
                }
                $data['coverType'] = $tpl['aki_article_cover_type'];
                break;
            case 2:
                if($tpl['aki_audio_cover_type'] == 2){
                    $data['cover'] = isset($trade['g_cover1']) ? $this->dealImagePath($trade['g_cover1']) : '';
                }
                $data['coverType'] = $tpl['aki_audio_cover_type'];
                break;
            case 3:
                if($tpl['aki_video_cover_type'] == 1){
                    $data['cover'] = isset($trade['g_cover1']) ? $this->dealImagePath($trade['g_cover1']) : '';
                }
                $data['coverType'] = $tpl['aki_video_cover_type'];
                break;
        }

        return $data;
    }

    
    public function useRechargeCodeAction(){
        $code = $this->request->getStrParam('code');
        if($code){
            $code_storage = new App_Model_Knowpay_MysqlKnowpayRechargeCodeStorage($this->sid);
            $where[] = array('name' => 'akrc_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'akrc_deleted', 'oper' => '=', 'value' => 0);
            $where[] = array('name' => 'akrc_code', 'oper' => '=', 'value' => $code);
            $row = $code_storage->getRow($where);
            if($row){
                if($row['akrc_expire_time']>time() || $row['akrc_expire_time']==0){
                    if($row['akrc_status']==0){
                        $set = array(
                            'akrc_status' => 1,
                            'akrc_receive_time' => time(),
                            'akrc_m_id'   => $this->member['m_id']
                        );
                        $ret = $code_storage->updateById($set, $row['akrc_id']);
                        //设置会员
                        App_Helper_MemberLevel::setMemberCard($this->member['m_id'], $row['akrc_value'], $this->sid);
                        if($ret){
                            $info['data'] = array(
                                'result' => true,
                                'msg'    => '兑换成功'
                            );
                            $this->outputSuccess($info);
                        }else{
                            $this->outputError('兑换失败，请重试');
                        }
                    }else{
                        $this->outputError('兑换码已被使用');
                    }
                }else{
                    $this->outputError('兑换码已过期');
                }
            }else{
                $this->outputError('兑换码不存在');
            }
        }else{
            $this->outputError('请输入兑换码');
        }
    }

    
    private function _fetch_quotation_like($pid){
        $like_model = new App_Model_Knowpay_MysqlKnowpayQuotationLikeStorage($this->sid);
        $likeList = $like_model->getLikeMemberList($pid);
        $data = array();
        if($likeList){
            foreach ($likeList as $val){
                if($val['m_avatar']){
                    $data['avatar'][] = $this->dealImagePath($val['m_avatar']);
                }else{
                    $data['avatar'][] = $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
                }
                if($val['m_nickname']){
                    $data['nickname'][] = $val['m_nickname'];
                }
            }
        }
        return $data;
    }

    
    public function quotationLikeAction(){
        $qid  = $this->request->getIntParam('id');
        if($qid){
            $like_model = new App_Model_Knowpay_MysqlKnowpayQuotationLikeStorage($this->sid);
            // 是否已经点过赞
            $row = $like_model->getLikeByMidQid($this->member['m_id'],$qid);
            $info['data'] = array(
                'result' => true,
                'msg'    => ''
            );
            // 已经点过赞
            if($row){
                $like_model->deleteById($row['akql_id']);
                $info['data']['msg'] = '取消成功';
                $info['data']['likeList'] = $this->_fetch_quotation_like($qid);
                // 减少帖子点赞数量
                $quotation_model = new App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage($this->sid);
                $quotation_model->addReduceNum($qid,'like','reduce');
                $this->outputSuccess($info);
            }else{
                $data = array(
                    'akql_s_id'   => $this->sid,
                    'akql_m_id'   => $this->member['m_id'],
                    'akql_q_id'   => $qid,
                    'akql_create_time'   => time()
                );
                $ret = $like_model->insertValue($data);
                $info['data']['msg'] = '点赞成功';
                $info['data']['likeList'] = $this->_fetch_quotation_like($qid);
                // 增加帖子点赞数量
                $quotation_model = new App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage($this->sid);
                $quotation_model->addReduceNum($qid,'like','add');
                //plum_open_backend('index', 'wxappTempl', array('sid' => $this->sid,'applet' => 6, 'tid' => $ret, 'type' => App_Helper_WxappApplet::SEND_SETUP_LIKE));
                $this->outputSuccess($info);
            }
        }else{
            $this->outputError('点赞失败');
        }

    }

    
    public function quotationCommentAction(){
        $qid = $this->request->getIntParam('id');  // 语录ID
        $content = $this->request->getStrParam('content');
        $cmid = $this->request->getIntParam('cmid');    // 回复会员ID，（回复别人的评论，评论人的ID）
        $cid =  $this->request->getIntParam('cid');
        // 判断会员是否被封号
        if($this->member['m_status']==1){
            $this->outputError('该账户已被管理员封禁，暂停评论');
        }
//        $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
//        $row = $post_model->getPostRowMemberDistance($qid);

        if($content){
            $wxclient_help = new App_Plugin_Weixin_WxxcxClient(1);   // 默认使用1号店铺的授权信息验证
            $result = $wxclient_help->checkMsg($content);
            if($result && $result['errcode']==87014){
                $this->outputError($result['errmsg']);
            }
        }
        $content = plum_sql_quote($content);
        if($qid && $content && $content!=' '){

            $data = array(
                'akqc_s_id'      => $this->sid,
                'akqc_q_id'    => $qid,
                'akqc_comment'   => $content,
                'akqc_m_id'      => $this->member['m_id'],
                'akqc_reply_mid' => $cmid,
                'akqc_c_id'    => $cid,
                'akqc_create_time' => time(),
            );
            $comment_model = new App_Model_Knowpay_MysqlKnowpayQuotationCommentStorage($this->sid);
            $ret = $comment_model->insertValue($data);
            if($ret){
                if($cmid>0){
                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $member = $member_model->getRowById($cmid);
                }
                // 增加语录评论数量
                $post_model = new App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage($this->sid);
                $post_model->addReduceNum($qid,'comment','add');

                // 更新语录回复时间
                //$post_model->updateById(array('acp_update_time'=>time()),$qid);


                $info['data'] = array(
                    'result' =>true,
                    'msg'    => '评论成功',
                    //'show'   => $show,
                    'comment' => array(
                        'id'            => $ret,
                        'comment'       => plum_strip_sql_quote($content),
                        'mid'           => $this->member['m_id'],
                        'nickname'      => $this->member['m_nickname'],
                        'replyMid'      => isset($member['m_id']) && $member['m_id'] > 0 ? $member['m_id'] : 0,
                        'replyNickname' => isset($member['m_nickname']) && $member['m_nickname'] ? $member['m_nickname'] : ''
                    )
                );
                // 评价订单获取积分
//                $point_storage = new App_Helper_Point($this->sid);
//                $point_storage->gainPointBySource($this->>member['m_id,App_Helper_Point::POINT_SOURCE_COMMENT);
//                plum_open_backend('index', 'wxappTempl', array('sid' => $this->sid,'applet' => 6, 'tid' => $ret, 'type' => App_Helper_WxappApplet::SEND_SETUP_COMMENT));
                $this->outputSuccess($info);
//                if($category['acc_verify_comment'] == 1){
//                    $this->outputError($msg);
//                }else{
//                    $this->outputSuccess($info);
//                }

            }else{
                $this->outputError('评论失败');
            }
        }else{
            $this->outputError('请填写评论内容');
        }

    }

    
    public function deleteQuotationCommentAction(){
        $cid = $this->request->getIntParam('cid');  // 评论ID
        if($cid){
            $comment_model = new App_Model_Knowpay_MysqlKnowpayQuotationCommentStorage($this->sid);
            $row = $comment_model->getRowById($cid);
            if($row && $row['akqc_m_id'] == $this->member['m_id']){
                $ret = $comment_model->deleteById($cid);
                if($ret){
                    // 减去帖子评论数量
                    $post_model = new App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage($this->sid);
                    $post_model->addReduceNum($row['akqc_q_id'],'comment','reduce');
                    $info['data'] = array(
                        'result' => true,
                        'msg'    => '删除成功'
                    );
                    $this->outputSuccess($info);
                }else{
                    $this->outputError('删除失败');
                }
            }else{
                $this->outputError('只能删除自己的评论哦');
            }
        }else{
            $this->outputError('删除失败');
        }
    }

    
    private function _format_receive_list($list){
        $data = array();
        foreach($list as $key=>$val){
            $avatar = $val['m_avatar']?$val['m_avatar']:'/public/wxapp/images/default-avatar.png';
            $data[] = array(
                'avatar'     => $this->dealImagePath($avatar),
                'nickname'   => $val['m_nickname'],
                'reveiveTime' => date('Y-m-d H:i:s', $val['cr_receive_time']),
                'slogan'     => $val['cr_slogan'],
                'endTime'    => date('Y-m-d H:i:s', $val['cl_end_time']),
            );
        }
        return $data;
    }


    public function knowledgeRecordListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $data = [];
        $where = [];
        $where[] = ['name'=> 'akkr_s_id','oper'=> '=','value'=>$this->sid];
        $where[] = ['name'=> 'akkr_m_id','oper'=> '=','value'=>$this->member['m_id']];

        $sort = ['akkr_update_time' => 'DESC'];

        $record_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeRecordStorage($this->sid);
        $list = $record_model->getListGoodsKnowledge($where,$index,$this->count,$sort);
        if($list){
            foreach ($list as $key => $val){
                $cover = $val['akk_cover'] ? $val['akk_cover'] : $val['g_cover'];
                $data[] = [
                    'gid' => $val['akkr_g_id'],
                    'kid' => $val['akkr_k_id'],
                    'gname' => $val['g_name'],
                    'kname' => $val['akk_name'],
                    'cover' => $this->dealImagePath($cover),
                    'date' => date('Y-m-d H:i:s',$val['akkr_update_time']),
                    'type' => $val['g_knowledge_pay_type']
                ];
            }

            $info['data'] = $data;
            $this->outputSuccess($info);

        }else{
            $this->outputError('没有更多信息了');
        }


    }

}
