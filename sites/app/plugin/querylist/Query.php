<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/7/4
 * Time: 上午8:10
 */
require_once __DIR__ . '/phpQuery.php';
require_once __DIR__ . '/QueryList.php';

use QL\QueryList;

class App_Plugin_Querylist_Query {

    public function __construct() {
    }

    /**
     * 通用采集页面方法
     * @param string $url
     * @param array $rules
     * @return array
     */
    public function query($url, $rules) {
        $data = QueryList::Query($url, $rules)->data;

        return $data;
    }

    /**
     * 采集微信公众号文章详情
     */
    public function queryWxArticle($url){
        $rules = [
            'content' => ['#js_content', 'html', '', function($content){
                return str_replace('data-src', 'src', $content);
            }],
            'video'   => ['iframe', 'data-src', '', function($content){
                $urlArr = parse_url($content);
                $queryArr = explode('&', $urlArr['query']);
                $params = array();
                foreach ($queryArr as $param) {
                    $item = explode('=', $param);
                    $params[$item[0]] = $item[1];
                }
                return $params['vid'];
            }],
            'info'    => ['body', 'html', '', function($content){
                $info = array();
                $content_html_pattern = '/msg_title = "(.*?)";/s';
                preg_match($content_html_pattern, $content, $title_matchs);
                if($title_matchs[1]){
                    $info['title'] = $title_matchs[1];
                }

                $content_html_pattern = '/msg_cdn_url = "(.*?)";/s';
                preg_match($content_html_pattern, $content, $cover_matchs);
                if($cover_matchs[1]){
                    list($usec, $sec) = explode(" ", microtime());
                    $md5        = strtoupper(md5($usec.$sec));
                    $name   = substr($md5, 0, 8).'-'.substr($md5, 10, 4).'-'.mt_rand(1000, 9999).'-'.substr($md5, 20, 12);
                    $filename = PLUM_DIR_UPLOAD. '/gallery/thumbnail/'.$name.'.png';
                    $filepath = PLUM_PATH_UPLOAD . '/gallery/thumbnail/'.$name.'.png';
                    if(!file_exists($filename)){
                        $hander = curl_init();
                        $fp = fopen($filename,'wb');
                        curl_setopt($hander,CURLOPT_URL,$cover_matchs[1]);
                        curl_setopt($hander,CURLOPT_FILE,$fp);
                        curl_setopt($hander,CURLOPT_HEADER,0);
                        curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
                        curl_setopt($hander,CURLOPT_TIMEOUT,60);
                        curl_exec($hander);
                        curl_close($hander);
                        fclose($fp);
                    }
                    $info['cover'] = $filepath;
                }

                $content_html_pattern = '/msg_desc = "(.*?)";/s';
                preg_match($content_html_pattern, $content, $desc_matchs);
                if($desc_matchs[1]){
                    $info['desc'] = $desc_matchs[1];
                }
                return $info;
            }]
        ];

        $data = QueryList::Query($url, $rules)->data;
        return $data[0];
    }

}