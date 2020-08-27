<?php

class App_Controller_Applet_BargainController extends App_Controller_Applet_InitController {
    
    public $sid;
    
    private $aid;
    
    private $activity;

    const MAX_BARGAIN_NUM   = 3;//单活动、单会员最大砍价次数

    public function __construct() {
        parent::__construct(true);
        $this->sid  = $this->shop['s_id'];
    }
    
    private function _get_mem_avatar($aid){
      $data = [];
      $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
      $sort  = array('bj_join_time' => 'DESC');
      $field = array('bj_m_avatar');//只获取头像
      $list  = $join_storage->fetchMemberByAid($aid,0,10,$sort,$field);
      if($list){
        foreach ($list as $val){
          $data[] = $this->dealImagePath($val['bj_m_avatar']);
        }
      }
      return $data;
    }

    
    private function _shop_index_shortcut(){
        $data = array();
        //获取快捷按钮
        $shortcut_storage   = new App_Model_Shop_MysqlShopShortcutStorage($this->sid);
        $shortcut   = $shortcut_storage->fetchShortcutShowList(-5);
        if($shortcut){
            foreach ($shortcut as $val){
                $data[] = array(
                    'name' => $val['ss_name'],
                    'icon' => isset($val['ss_icon']) ? $this->dealImagePath($val['ss_icon']) : '',
                    'link' => isset($val['ss_link']) ? $val['ss_link'] : '',
                    'type' => $val['ss_link_type'],
                    'url'  => $this->get_link_by_type($val['ss_link_type'],$val['ss_link'],$val['ss_name']),
                );
            }
        }
        return $data;
    }

    
    private function _shop_index_tpl(){
        $data = array();
        $tpl_model = new App_Model_Bargain_MysqlBargainIndexStorage($this->sid);
        $tpl   = $tpl_model->findUpdateBySid();
        if($tpl){
            $data = array(
                'title'        => $tpl['abi_title'],
                'ipopen'       => $tpl['abi_isopen']?$tpl['abi_isopen']:0,
                'isopen'       => $tpl['abi_isopen']?$tpl['abi_isopen']:0,
                'applytitle'   => !empty($tpl['abi_apply_title'])?$tpl['abi_apply_title']:'欢迎报名参加活动'
            );
        }
        return $data;
    }

    
    public function getShareInfoAction(){
        $bjId = $this->request->getIntParam('jid',0);
        $activityId = $this->request->getIntParam('activityId',0);
        $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
        $join = $join_storage->getRowById($bjId);
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->sid);
        if($activityId && !$bjId){
            $activity = $bargain_model->getRowById($activityId);
            $qrcode = $this->appletType == 5 ? $activity['ba_weixin_qrcode'] :$activity['ba_qrcode'];
            $str = "id=".$activity['ba_id'];
        }else{
            $activity = $bargain_model->getRowById($join['bj_a_id']);
            $qrcode = $this->appletType == 5 ? $join['bj_weixin_qrcode'] : $join['bj_qrcode'];
            $str = "id=".$activity['ba_id']."&jid=".$bjId;
        }

       if(!$qrcode){
           if($this->appletType == 5){
               if($this->applet_cfg['ac_type'] == 27){
                   $text = '';
               }else{
                   $text = plum_parse_config('weixin_index','weixin')[$this->applet_cfg['ac_type']]."?suid={$this->suid}&appletType=5&share=/BargainGoodDetail?id={$activity['ba_id']}&jid={$bjId}";
               }
               $qrcode = $this->_get_qrcode_png_url($text);
               if($qrcode && $bjId){
                   $join_storage->updateById(array('bj_weixin_qrcode'=>$qrcode),$bjId);
               }elseif ($qrcode && !$bjId && $activityId){
                   $bargain_model->updateById(array('ba_weixin_qrcode'=>$qrcode),$activityId);
               }
           }else{
               //生成分享海报
               $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->shop['s_id']);
               if($this->applet_cfg['ac_type'] == 27){
                   $qrcode = $client_plugin->fetchWxappShareCode($str, $client_plugin::KNOWPAY_BARGAIN_CODE_PATH, 210);
               }else{
                   $qrcode = $client_plugin->fetchWxappShareCode($str, $client_plugin::BARGAIN_DETAIL_CODE_PATH, 210);
               }
               if($qrcode && $bjId){
                   $join_storage->updateById(array('bj_qrcode'=>$qrcode),$bjId);
               }elseif ($qrcode && !$bjId && $activityId){
                   $bargain_model->updateById(array('ba_qrcode'=>$qrcode),$activityId);
               }
           }
        }

        $uid  = plum_app_user_islogin();
        $params = array(
            'id'  => $activityId,
            'mid' => $uid,
            'sid' => $activity['ba_s_id'],
            'jid' => $bjId
        );
        $shareImg = App_Helper_SharePoster::generateSharePoster('bargainShare', $params);

        $info['data'] = array(
            'shareImg' => $this->dealImagePath($activity['ba_image'], true),
            'shareDesc' => $activity['ba_desc'] ? $activity['ba_desc'] : '',
            'shareQrcode' => $this->dealImagePath($qrcode, true),
            'bargainShareImg' => $this->dealImagePath($shareImg)
        );
        $this->outputSuccess($info);
    }

    
    private function _get_qrcode_png_url($text){
        if(!$text){
            return '';
        }
        //生成图片存储实际路径
        $hold_dir = PLUM_APP_BUILD.'/spread/';
        //生成图片访问路径
        $access_path = PLUM_PATH_PUBLIC.'/build/spread/';

        $filename = plum_uniqid_base36(true).".png";
        Libs_Qrcode_QRCode::png($text,$hold_dir.$filename, 'Q', 6, 1);
        $url = $access_path.$filename;
        $path = $path = plum_get_base_host() . '/' . ltrim($url, '/');
        $urlVerify = getimagesize($path);  // 验证二维码是否存现
        if(!$urlVerify){
            $url = '';
        }
        return $url;
    }

    
    private function _fetch_activity_status($activity){
        $status = 0;
        $timeNow = time();
        if($activity['ba_start_time']>$timeNow){   // 未开始准备中
            $status = 0;
        }elseif($activity['ba_start_time']<$timeNow && $activity['ba_end_time']>$timeNow && (($activity['ba_goods_stock'] > 0 && ($activity['ba_goods_stock'] - $activity['ba_buy_num']) > 0) || ($activity['ba_goods_stock'] == 0 && $activity['g_stock'] > 0 && in_array($this->applet_cfg['ac_type'],[21,8,6])))){   // 正在进行中
            $status = 1;
        }
        elseif($activity['ba_end_time']<$timeNow || ($activity['ba_goods_stock'] > 0 && ($activity['ba_goods_stock'] - $activity['ba_buy_num']) <= 0) || ($activity['ba_goods_stock'] == 0 && $activity['g_stock'] <= 0 && in_array($this->applet_cfg['ac_type'],[21,8,6]))){  //已结束
            $status = 2;
        }
        return $status;
    }

    
    private function _fetch_status_and_stock($activity){
        $status = 0;
        $timeNow = time();
        if($activity['ba_start_time']>$timeNow){   // 未开始准备中
            $status = 0;
        }elseif($activity['ba_start_time']<$timeNow && $activity['ba_end_time']>$timeNow){   // 正在进行中
            $status = 1;
        }elseif($activity['ba_end_time']<$timeNow){  //已结束
            $status = 2;
        }
        if($activity['ba_goods_stock'] > 0){
            $stock = $activity['ba_goods_stock'] -$activity['ba_buy_num'];
        }else{
            $stock =  $activity['g_stock'];
        }

        $data = [
            'status' => $status,
            'stock'  => $stock
        ];

        return $data;
    }




}