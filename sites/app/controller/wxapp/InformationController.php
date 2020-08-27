<?php


class App_Controller_Wxapp_InformationController extends App_Controller_Wxapp_InitController
{
    private $token;
    private $cookie;
    private $agent;
    public function __construct()
    {
        parent::__construct();
        $cfg = plum_parse_config('cfg', 'gzhcfg');
        $this->token = $cfg['token'];
        $this->cookie = $cfg['cookies'];
        $this->agent = [
            "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0",
            "Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko",
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36",
        ];
    }

    private function get($url, $params = array(), $headers = array(), $misc = array(), $cookie='') {
        if (!empty($params)) {
            $url = $url . '?' . http_build_query($params);
        }
        return self::http($url, 'GET', null, $headers, $misc, $cookie);
    }


    private function http($url, $method, $postfields = NULL, $headers = array(), $misc = array(), $cookie='') {
        $ci = curl_init();
        #curl_setopt($ci, CURLOPT_PROXY, "43.245.184.202:41102");
        curl_setopt($ci, CURLOPT_USERAGENT, 'Tdot Plum Client v0.1');
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ci, CURLOPT_ENCODING, "");
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ci, CURLOPT_HEADER, FALSE);

        switch ($method) {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, TRUE);
                if (!empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                }
                break;
        }

        foreach ($misc as $key => $val) {
            $key    = strtoupper($key);
            switch ($key) {
                case 'REFERER' :
                    curl_setopt($ci, CURLOPT_REFERER, $val);
                    break;
            }
        }

        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt ($ci, CURLOPT_COOKIE , $cookie );
        curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE);

        $response = curl_exec($ci);
        $httpCode = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        if($httpCode != 302){
            return $response;
        }else{
            return $httpCode;
        }
    }

    public function searchAction(){
        $searchType = $this->request->getIntParam('type');
        $key = $this->request->getStrParam('key');
        $count = 20;
        $header = array(
            "Host"=> 'mp.weixin.qq.com',
            "Upgrade-Insecure-Requests"=> '1',
            "Referer"=>  'https://mp.weixin.qq.com/cgi-bin/appmsg?t=media/appmsg_edit_v2&action=edit&isNew=1&type=10&token='.$this->token.'&lang=zh_CN',
        );
        if($searchType == 1){
            $url = "https://mp.weixin.qq.com/cgi-bin/searchbiz?action=search_biz&token=".$this->token."&lang=zh_CN&random=0.6254349379640605&f=json&ajax=1&query=".$key."&begin=0&count=".$count;
            $res = $this->get($url, array(), $header, array(), $this->cookie);
            $data = json_decode($res, true);
        }else{
            $article_html = $this->get($key);
            $content_html_pattern = '/biz = (.*?);/s';
            preg_match($content_html_pattern, $article_html, $biz_matchs);
            if($biz_matchs[1]){
                $biz_arr = explode('||', $biz_matchs[1]);
                foreach ($biz_arr as $v){
                    if(strlen($v)>5){
                        $cover = '';
                        $title = '';
                        $content_html_pattern = '/hd_head_img : "(.*?)"\|\|/s';
                        preg_match($content_html_pattern, $article_html, $cover_matchs);
                        if($cover_matchs[1]){
                            $cover = $cover_matchs[1];
                        }
                        $content_html_pattern = '/nickname = "(.*?)";/s';
                        preg_match($content_html_pattern, $article_html, $title_matchs);
                        if($title_matchs[1]){
                            $title = $title_matchs[1];
                        }
                        $data['list'][0]['url'] = '';
                        $data['list'][0]['round_head_img'] = $cover;
                        $data['list'][0]['nickname'] = $title;
                        $data['list'][0]['fakeid'] = str_replace('"', '', $v);
                    }
                }
            }
        }
        if($data['list']){
            foreach ($data['list'] as $key => $val){
                $data['list'][$key]['round_head_img'] = $this->_download_image($val['round_head_img'], $val['fakeid']);
            }
        }
        $result = array(
            'ec'        => 200,
            'data'      => $data['list']
        );
        $this->displayJson($result);
    }

    private function _download_image($img, $wxno){
        $filename = PLUM_DIR_UPLOAD. '/image/depot/'.$wxno.'.png';
        $filepath = PLUM_PATH_UPLOAD . '/image/depot/'.$wxno.'.png';
        if(!file_exists($filename)){
            $hander = curl_init();
            $fp = fopen($filename,'wb');
            curl_setopt($hander,CURLOPT_URL,$img);
            curl_setopt($hander,CURLOPT_FILE,$fp);
            curl_setopt($hander,CURLOPT_HEADER,0);
            curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($hander,CURLOPT_TIMEOUT,60);
            curl_exec($hander);
            curl_close($hander);
            fclose($fp);
        }
        return $filepath;
    }
    public function addWxappAction(){
        $wxurl = $this->request->getStrParam('url');
        $wxno  = $this->request->getStrParam('wxno');
        $name  = $this->request->getStrParam('name');
        $cover = $this->request->getStrParam('cover');
        $gzh_model = new App_Model_Information_MysqlInformationGzhStorage($this->curr_sid);
        $row = $gzh_model->getRowByWxId($wxno);
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop = $shop_model->getRowById($this->curr_sid);
        $where = array();
        $where[] = array('name' => 'abg_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $list = $gzh_model->getList($where,0,0, array());
        if($list && $shop['s_gzh_num'] == 0){
            $this->displayJsonError('暂无可绑定的公众号，请点击新增');
        }
        if(!$row){
            $this->_get_articles($wxno, $name);
            $data['abg_s_id'] = $this->curr_sid;
            $data['abg_name'] = $name;
            $data['abg_cover'] = $cover;
            $data['abg_wxno'] = $wxno;
            $data['abg_url'] = $wxurl;
            $data['abg_create_time'] = time();
            $data['abg_get_article_time'] = time();
            if($list && $shop['s_gzh_num']){
                $data['abg_is_pay'] = 1;
            }
            $ret = $gzh_model->insertValue($data);
            if($ret && $list){
                App_Helper_OperateLog::saveOperateLog("资讯关联公众号【".$name."】成功");
                $shop_model->updateById(array('s_gzh_num' => ($shop['s_gzh_num'] - 1)), $this->curr_sid);
            }
            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError('此公众号已添加');
        }
    }
    public function removeGzhAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $gzh_model = new App_Model_Information_MysqlInformationGzhStorage($this->curr_sid);
            $gzh = $gzh_model->getRowById($id);
            $ret = $gzh_model->deleteById($id);
            App_Helper_OperateLog::saveOperateLog("删除关联公众号【".$gzh['abg_name']."】成功");
            $this->showAjaxResult($ret);
        }
    }
    public function syncArticlesAction(){
        $id = $this->request->getStrParam('id');
        $gzh_model = new App_Model_Information_MysqlInformationGzhStorage($this->curr_sid);
        $row = $gzh_model->getRowById($id);
        if($row){
            $num = $this->_get_articles($row['abg_wxno'], $row['abg_name']);
            if($num > 0){
                $set = array('abg_get_article_time' => time());
                $gzh_model->updateById($set, $id);
            }
            $ret = array(
                'num' => $num,
                'msg' => '同步成功'
            );
            $this->displayJsonSuccess($ret);
        }else{
            $this->showAjaxResult(0, '同步');
        }
    }

    private function _get_articles($wxno, $name){
        $count = 10;
        $header = array(
            "Host"=> 'mp.weixin.qq.com',
            "Upgrade-Insecure-Requests"=> '1',
            "Referer"=>  'https://mp.weixin.qq.com/cgi-bin/appmsg?t=media/appmsg_edit_v2&action=edit&isNew=1&type=10&token='.$this->token.'&lang=zh_CN',
        );
        $url = "https://mp.weixin.qq.com/cgi-bin/appmsg?action=list_ex&token=".$this->token."&lang=zh_CN&random=0.6254349379640605&type=9&f=json&ajax=1&fakeid=".$wxno."&query=&begin=0&count=".$count;
        $res = $this->get($url, array(), $header, array(), $this->cookie);
        $data = json_decode($res, true);
        $num = 0;

        $article = array();
        foreach ($data['app_msg_list'] as $value){
            $articleTemp = array();
            $articleTemp['title'] = $value['title'];
            $articleTemp['cover'] = $value['cover'];
            $articleTemp['digest'] = $value['digest'];
            $articleTemp['content_url'] = $value['link'];
            $articleTemp['contentId'] = $value['update_time'];
            $article[] = $articleTemp;
        }
        if($article){
            $num = $this->_save_article($article, $wxno, 0,  $name);
        }

        return $num;
    }

    private function _save_article($article, $wxno, $needHost=0, $name){
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $insertData = array();
        foreach ($article as $value){
            $data = array(
                'ai_title'       => $value['title'],
                'ai_cover'       => $this->_download_article_image($value['cover']),
                'ai_brief'       => $value['digest'],
                'ai_wx_real_url' => $value['content_url'],
                'ai_wx_no'       => $wxno,
                'ai_wx_id'       => $value['contentId'],
                'ai_from'        => $name,
                'ai_create_time' => time(),
                'ai_s_id'        => $this->curr_sid,
                'ai_update_time' => time(),
            );
            $where = array();
            $where[] = array('name' => 'ai_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'ai_wx_no', 'oper' => '=', 'value' => $wxno);
            $where[] = array('name' => 'ai_wx_id', 'oper' => '=', 'value' => $value['contentId']);
            $where[] = array('name' => 'ai_deleted', 'oper' => '=', 'value' => 0);
            $row = $information_storage->getRow($where);
            if(!$row){
                if($needHost){
                    $url = 'https://mp.weixin.qq.com'.str_replace('amp;','',$value['content_url']);
                    $content = $this->_get_article_info($url);
                    $data['ai_content'] = $content['article'];
                    $data['ai_video']   = $content['video'];
                }else{
                    $content = $this->_get_article_info($value['content_url'], 1);
                    $data['ai_content'] = $content['article'];
                    $data['ai_video']   = $content['video'];
                }
                $insertData[] = $data;
            }
        }
        foreach ($insertData as $val){
            $information_storage->insertValue($val);
        }
        return count($insertData);
    }

    private function _download_article_image($img){
        list($usec, $sec) = explode(" ", microtime());
        $md5        = strtoupper(md5($usec.$sec));
        $name   = substr($md5, 0, 8).'-'.substr($md5, 10, 4).'-'.mt_rand(1000, 9999).'-'.substr($md5, 20, 12);
        $fileroot   = PLUM_DIR_UPLOAD. '/depot/'.$this->curr_shop['s_unique_id'].'/'.date('Ymd', time()).'/';
        if (!is_dir($fileroot)) {
            @mkdir($fileroot, 0755, true);
        }
        $filename = PLUM_DIR_UPLOAD. '/depot/'.$this->curr_shop['s_unique_id'].'/'.date('Ymd', time()).'/'.$name.'.png';
        $filepath = PLUM_PATH_UPLOAD . '/depot/'.$this->curr_shop['s_unique_id'].'/'.date('Ymd', time()).'/'.$name.'.png';
        if(!file_exists($filename)){
            $hander = curl_init();
            $fp = fopen($filename,'wb');
            curl_setopt($hander,CURLOPT_URL,$img);
            curl_setopt($hander,CURLOPT_FILE,$fp);
            curl_setopt($hander,CURLOPT_HEADER,0);
            curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($hander,CURLOPT_TIMEOUT,60);
            curl_exec($hander);
            curl_close($hander);
            fclose($fp);
            try {
                $sync = new Libs_Image_DataSync();
                $sync->pushQueue($filepath);
            } catch (Exception $e) {
                Libs_Log_Logger::outputLog($e->getMessage().':'.$filepath, 'imgsrc.log');
            }
        }
        return $filepath;
    }


    private function _get_article_info($url, $needReplace = 0){
        if($needReplace){
            $url = str_replace('http', 'https', $url);
        }
        $content = $this->get($url);
        $content_html_pattern = '/<div class="rich_media_content ".*?id="js_content".*?>(.*?)<\/div>/s';
        preg_match($content_html_pattern, $content, $content_matchs);
        if($content_matchs[1]){
            $article_content = str_replace('data-src', 'src', $content_matchs[1]);
        }

        $content_html_pattern = '/<iframe.*?data-src=[\'|"].*?vid=(.*?)&amp;.*?><\/iframe>/s';
        preg_match($content_html_pattern, $content, $vid_matchs);
        if(!$vid_matchs[1]){
            $content_html_pattern = '/<iframe.*?src=[\'|"].*?vid=(.*?)[\'|"]><\/iframe>/s';
            preg_match($content_html_pattern, $content, $vid_matchs);
        }
        if($vid_matchs[1]){
            $vid = $vid_matchs[1];
            $videoInfo = $this->_get_tencent_video($vid);
            $videoUrl = $videoInfo['real_url'];
        }

        return array(
            'article' => $article_content,
            'video' => $videoUrl
        );
    }
    private function _get_tencent_video($vid=''){
        if(!$vid){
            $url = $this->request->getStrParam('videoUrl');
            $urlArr = parse_url($url);
            $arr_query = $this->_convert_url_query($urlArr['query']);
            if($arr_query['vid']){
                $vid  = $arr_query['vid'];
            }else{
                $content = Libs_Http_Client::get($url);
                $content_html_pattern = '/VIDEO_INFO = ({[^}]*.*?)(;.*?var |<\/script>)/s';
                preg_match($content_html_pattern, $content, $video_matchs);
                
                $video_matchs[1] = preg_replace('/(\/\*.*\*\/)/s', '', $video_matchs[1]);
                $videoInfo = json_decode($video_matchs[1], true);
                if(!$videoInfo){
                    $content_html_pattern = '/vid: "(.*?)"/s';
                    preg_match($content_html_pattern, $video_matchs[1], $video_matchs);
                    $videoInfo['vid'] = $video_matchs[1];
                }
                $vid  = $videoInfo['vid'];
            }
            if(!$vid){
                $pathArr = explode('/', $urlArr['path']);
                $vid = str_replace('.html','',$pathArr[count($pathArr)-1]);
            }
        }
        $params = array(
            'isHLS' => false,
            'charge' => 0,
            'vid' => $vid,
            'defaultfmt' => 'auto',
            'defn' => 'shd',
            'defnpayver' => 1,
            'otype' => 'json',
            'platform' => 11001,
            'sdtfrom' => 'v1103',
            'host' => 'v.qq.com'
        );
        $baseUrl = 'http://h5vv.video.qq.com/getinfo?';
        $paramsArr = [];
        foreach ($params as $key => $val){
            $paramsArr[] = $key.'='.$val;
        }
        $paramsStr = join('&', $paramsArr);
        $content = Libs_Http_Client::get($baseUrl.$paramsStr);
        $content_html_pattern = '/=(.*);/s';
        preg_match($content_html_pattern, $content, $info_matchs);
        $infoInfo = json_decode($info_matchs[1], true);
        $fvkey = $infoInfo['vl']['vi'][0]['fvkey'];
        $fn = $infoInfo['vl']['vi'][0]['fn'];
        $self_host = $infoInfo['vl']['vi'][0]['ul']['ui'][0]['url'];
        if($self_host && $fn && $fvkey){
            return array(
                'real_url' => $vid,
                'cover' => "https://puui.qpic.cn/qqvideo_ori/0/".$vid."_496_280/0"
            );
        }else{
            return false;
        }
    }

    private function _convert_url_query($query)
    {
        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }

    public function gzhSettingAction(){
        $wxnoid = $this->request->getIntParam('wxnoid');
        $showType = $this->request->getIntParam('showType');
        $gzh_model = new App_Model_Information_MysqlInformationGzhStorage($this->curr_sid);
        $set = array('abg_show_type' => $showType);
        $ret = $gzh_model->updateById($set, $wxnoid);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存公众号文章展示样式成功");
        }

        $this->showAjaxResult($ret);
    }

}
