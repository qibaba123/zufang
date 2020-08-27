<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/1/19
 * Time: 下午6:15
 */

class App_Controller_Site_InstallController extends App_Controller_Site_HeadController {

    public function __construct() {
        parent::__construct(true);
    }

    public function indexAction(){
        $externalContent = file_get_contents('http://checkip.dyndns.com/');
        preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
        $externalIp = $m[1];
        $this->output['externalIp'] = $externalIp;
        $db_config = plum_parse_config('default', 'mysql');
        $this->output['dbname'] = $db_config['dbname'];
        $this->output['dbuser'] = $db_config['user'];
        $this->output['dbpasswd'] = $db_config['pass'];
        $this->displaySmarty('site/install.tpl');
    }
  
    public function setupAction(){
        set_time_limit(0);
        $zipname = $this->request->getStrParam('zipname');
        $host    = $this->request->getStrParam('host');
        $name    = $this->request->getStrParam('name');
        $user    = $this->request->getStrParam('user');
        $passwd  = $this->request->getStrParam('passwd');
		$shoudong = $this->request->getStrParam('shoudong');
        if(!$shoudong){
        	//开始下载压缩文件
        	$this->_download_zip("https://www.tiandiantong.com/public/build/".$zipname);
        }else{
        	$this->_download_zip();
        }
        //开始覆盖安装
        $this->_overwrite();
        //删除文件
        $this->_del_dir(PLUM_DIR_ROOT. '/installcode/');
        //创建上传目录
        $uploadPath = PLUM_DIR_ROOT. '/upload/';
        if(!is_dir($uploadPath)){
           @mkdir($uploadPath, 0755);
        }
        $galleryPath = PLUM_DIR_ROOT. '/upload/gallery/';
        if(!is_dir($galleryPath)){
           @mkdir($galleryPath, 0755);
        }
        $thumbnailPath = PLUM_DIR_ROOT. '/upload/gallery/thumbnail/';
        if(!is_dir($thumbnailPath)){
           @mkdir($thumbnailPath, 0755);
        }
        $defaultPath = PLUM_DIR_ROOT. '/upload/gallery/default/';
        if(!is_dir($defaultPath)){
           @mkdir($defaultPath, 0755);
        }
        $buildPath = PLUM_DIR_ROOT. '/public/build/';
        if(!is_dir($buildPath)){
           @mkdir($buildPath, 0755);
        }
        $spreadPath = PLUM_DIR_ROOT. '/public/build/spread/';
        if(!is_dir($spreadPath)){
           @mkdir($spreadPath, 0755);
        }
        //设置数据库配置文件
        $content = file_get_contents(PLUM_DIR_ROOT."/sites/app/config/mysql.php");
        $pattern = '/([\'\"]remotehost[\'\"].*?=>.*?[\'\"]).*?([\'\"])/i';//匹配单引号或双引号
        $content = preg_replace($pattern, '${1}'.$host.'${2}', $content);
        $pattern = '/([\'\"]user[\'\"].*?=>.*?[\'\"]).*?([\'\"])/i';//匹配单引号或双引号
        $content = preg_replace($pattern, '${1}'.$user.'${2}', $content);
        $pattern = '/([\'\"]username[\'\"].*?=>.*?[\'\"]).*?([\'\"])/i';//匹配单引号或双引号
        $content = preg_replace($pattern, '${1}'.$user.'${2}', $content);
        $pattern = '/([\'\"]database[\'\"].*?=>.*?[\'\"]).*?([\'\"])/i';//匹配单引号或双引号
        $content = preg_replace($pattern, '${1}'.$name.'${2}', $content);
        $pattern = '/([\'\"]dbname[\'\"].*?=>.*?[\'\"]).*?([\'\"])/i';//匹配单引号或双引号
        $content = preg_replace($pattern, '${1}'.$name.'${2}', $content);
        $pattern = '/([\'\"]pass[\'\"].*?=>.*?[\'\"]).*?([\'\"])/i';//匹配单引号或双引号
        $content = preg_replace($pattern, '${1}'.$passwd.'${2}', $content);
        $pattern = '/([\'\"]password[\'\"].*?=>.*?[\'\"]).*?([\'\"])/i';//匹配单引号或双引号
        $content = preg_replace($pattern, '${1}'.$passwd.'${2}', $content);
        file_put_contents(PLUM_DIR_ROOT."/sites/app/config/mysql.php", $content);
        $this->_run_shell();//运行后台进程
        //清除店铺登录的redis
        $redis_shop = new App_Model_Shop_RedisShopQueueStorage();
        $redis_shop->delHashKey();
        $this->displayJsonSuccess();
    }
  
    private function _download_template_cover(){
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $list       = $tpl_model->getList();
        foreach($list as $val){
            $filename = PLUM_DIR_ROOT.$val['it_img'];
            $zip_dir = $fileroot.'tdtcode/';
            if(!file_exists($filename)){
                //去除URL连接上面可能的引号
                $hander = curl_init();
                $fp = fopen($filename,'wb');
                curl_setopt($hander,CURLOPT_URL,"http://www.tiandiantong.com".$val['it_img']);
                curl_setopt($hander,CURLOPT_FILE,$fp);
                curl_setopt($hander,CURLOPT_HEADER,0);
                curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
                curl_setopt($hander,CURLOPT_TIMEOUT,60);
                curl_exec($hander);
                curl_close($hander);
                fclose($fp);
            }
        }
    }
  
  
    private function _run_shell(){
        $trade_shell = shell_exec("ps -ef | grep trade/create | grep -v grep");
        if(!$trade_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php trade/create");
        }
        $answerpay_shell = shell_exec("ps -ef | grep answerpay/create | grep -v grep");
        if(!$answerpay_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php answerpay/create");
        }
        $group_shell = shell_exec("ps -ef | grep group/create | grep -v grep");
        if(!$group_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php group/create");
        }
        $daemon_shell = shell_exec("ps -ef | grep daemon/create | grep -v grep");
        if(!$daemon_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php daemon/create");
        }
        $knowledge_shell = shell_exec("ps -ef | grep knowledge/create | grep -v grep");
        if(!$knowledge_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php knowledge/create");
        }
        $goods_shell = shell_exec("ps -ef | grep goods/create | grep -v grep");
        if(!$goods_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php goods/create");
        }
        $applet_shell = shell_exec("ps -ef | grep applet/create | grep -v grep");
        if(!$applet_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php applet/create");
        }
        $member_shell = shell_exec("ps -ef | grep member/create | grep -v grep");
        if(!$member_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php member/create");
        }
    }
    
  
    private function _del_dir($path){
        //如果是目录则继续
        if(is_dir($path)){
            //扫描一个文件夹内的所有文件夹和文件并返回数组
            $p = scandir($path);
            foreach($p as $val){
                //排除目录中的.和..
                if($val !="." && $val !=".."){
                    //如果是目录则递归子目录，继续操作
                    if(is_dir($path.$val)){
                        //子目录中操作删除文件夹和文件
                        $this->_del_dir($path.$val.'/');
                        //目录清空后删除空文件夹
                        @rmdir($path.$val.'/');
                    }else{
                        //如果是文件直接删除
                        unlink($path.$val);
                    }
                }
            }
        }
        @rmdir($path);
    }
  
    private function _overwrite(){
        $path = PLUM_DIR_ROOT. '/installcode/';
        $files = $this->_get_overwirte_files($path);
        foreach($files as $file){
          $overwritefile = str_replace($path, '', $file);
          $overwriteType = explode('/', $overwritefile)[0];
          if($overwriteType == 'applet'){
            $content = file_get_contents($file);
            file_put_contents(PLUM_DIR_ROOT.'/sites/app/controller/'.$overwritefile, $content);
          }
          
          if($overwriteType == 'wxapp'){
            $content = file_get_contents($file);
            file_put_contents(PLUM_DIR_ROOT.'/sites/app/controller/'.$overwritefile, $content);
          }
          
          if($overwriteType == 'mobile'){
            $content = file_get_contents($file);
            file_put_contents(PLUM_DIR_ROOT.'/sites/app/controller/'.$overwritefile, $content);
          }
          
          if($overwriteType == 'console'){
            $content = file_get_contents($file);
            file_put_contents(PLUM_DIR_ROOT.'/sites/app/controller/'.$overwritefile, $content);
          }
          
          if($overwriteType == 'helper'){
            $content = file_get_contents($file);
            file_put_contents(PLUM_DIR_ROOT.'/sites/app/'.$overwritefile, $content);
          }
          
          if($overwriteType == 'model'){
            $dirArr = explode('/', $overwritefile);
            array_pop($dirArr);
            $dirpath = PLUM_DIR_ROOT.'/sites/app/';
            foreach($dirArr as $dir){
              $dirpath .= lcfirst($dir).'/';
              if(!is_dir($dirpath)){
                @mkdir($dirpath, 0755);
              }
            }
            $content = file_get_contents($file);
            file_put_contents(PLUM_DIR_ROOT.'/sites/app/'.$overwritefile, $content);
          }
          
          if($overwriteType == 'view'){
            $dirArr = explode('/', $overwritefile);
            array_pop($dirArr);
            array_shift($dirArr);
            $dirpath = PLUM_DIR_ROOT.'/sites/app/view/template/wxapp/';
            foreach($dirArr as $dir){
              $dirpath .= lcfirst($dir).'/';
              if(!is_dir($dirpath)){
                @mkdir($dirpath, 0755);
              }
            }
            $content = file_get_contents($file);
            file_put_contents(PLUM_DIR_ROOT.'/sites/app/view/template/wxapp/'.str_replace('view/', '', $overwritefile), $content);
          }
          
          if($overwriteType == 'config'){
            $dirArr = explode('/', $overwritefile);
            array_pop($dirArr);
            $dirpath = PLUM_DIR_ROOT.'/sites/app/';
            foreach($dirArr as $dir){
              $dirpath .= lcfirst($dir).'/';
              if(!is_dir($dirpath)){
                @mkdir($dirpath, 0755);
              }
            }
            
            $content = file_get_contents($file);
            file_put_contents(PLUM_DIR_ROOT.'/sites/app/'.$overwritefile, $content);
          }
          
          if($overwriteType == 'public'){
            $dirArr = explode('/', $overwritefile);
            array_pop($dirArr);
            $dirpath = PLUM_DIR_ROOT.'/';
            foreach($dirArr as $dir){
              $dirpath .= $dir.'/';
              if(!is_dir($dirpath)){
                @mkdir($dirpath, 0755);
              }
            }
            $content = file_get_contents($file);
            file_put_contents(PLUM_DIR_ROOT.'/'.$overwritefile, $content);
          }
          
          if($overwriteType == 'shopwxapp'){
            $content = file_get_contents($file);
            file_put_contents(PLUM_DIR_ROOT.'/sites/app/controller/'.str_replace('shopwxapp', 'shop', $overwritefile), $content);
          }
          
          if($overwriteType == 'shopview'){
            $dirArr = explode('/', $overwritefile);
            array_pop($dirArr);
            array_shift($dirArr);
            $dirpath = PLUM_DIR_ROOT.'/sites/app/view/template/shop/';
            foreach($dirArr as $dir){
              $dirpath .= lcfirst($dir).'/';
              if(!is_dir($dirpath)){
                @mkdir($dirpath, 0755);
              }
            }
            $content = file_get_contents($file);
            file_put_contents(PLUM_DIR_ROOT.'/sites/app/view/template/shop/'.str_replace('shopview/', '', $overwritefile), $content);
          }
          
          if($overwriteType == 'supplierwxapp'){
            $content = file_get_contents($file);
            file_put_contents(PLUM_DIR_ROOT.'/sites/app/controller/'.str_replace('supplierwxapp', 'supplier', $overwritefile), $content);
          }
          
          if($overwriteType == 'supplierview'){
            $dirArr = explode('/', $overwritefile);
            array_pop($dirArr);
            array_shift($dirArr);
            $dirpath = PLUM_DIR_ROOT.'/sites/app/view/template/supplier/';
            foreach($dirArr as $dir){
              $dirpath .= lcfirst($dir).'/';
              if(!is_dir($dirpath)){
                @mkdir($dirpath, 0755);
              }
            }
            $content = file_get_contents($file);
            file_put_contents(PLUM_DIR_ROOT.'/sites/app/view/template/supplier/'.str_replace('supplierview/', '', $overwritefile), $content);
          }
        }
    }
  
    private function _get_overwirte_files($path){
        $files = scandir($path);
        $fileItem = [];
        foreach($files as $v) {
            $newPath = $path . $v;
            if(is_dir($newPath) && $v != '.' && $v != '..') {
                $fileItem = array_merge($fileItem, $this->_get_overwirte_files($newPath . '/'));
            }else if(is_file($newPath)){
                $fileItem[] = $newPath;
            }
        }
        return $fileItem;
    }
  
    private function _download_zip($url){
        $fileroot = PLUM_DIR_ROOT. '/installcode/';
        $filename = $fileroot.'tdtcode.zip';
        if (!is_dir($fileroot)) {
            @mkdir($fileroot, 0755);
        }
        $zip_dir = $fileroot.'tdtcode/';
        if($url){
          if(!file_exists($filename)){
              //去除URL连接上面可能的引号
              $hander = curl_init();
              $fp = fopen($filename,'wb');
              curl_setopt($hander,CURLOPT_URL,$url);
              curl_setopt($hander,CURLOPT_FILE,$fp);
              curl_setopt($hander,CURLOPT_HEADER,0);
              curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
              curl_setopt($hander,CURLOPT_TIMEOUT,180);
              curl_exec($hander);
              curl_close($hander);
              fclose($fp);
          }
        }

        //实例化ZipArchive类
        $zip = new ZipArchive();
        //打开压缩文件，打开成功时返回true
        if ($zip->open($filename) === true && !is_dir($zip_dir)) {
            //解压文件到获得的路径a文件夹下
            $zip->extractTo($fileroot);
            //关闭
            $zip->close();
            unlink($filename);
        } else {
            if(is_dir($zip_dir)){
                unlink($filename);
            }
        }
    }
  
    public function settingAction(){
        $appletType = $this->request->getIntParam('appletType');
        $this->output['appletType'] = $appletType;
        $this->displaySmarty('site/setting.tpl');
    }
 
    //店铺信息设置
    public function saveSettingAction(){
        $appletType = $this->request->getIntParam("appletType");
        $company  = $this->request->getStrParam('company');
        $mobile   = $this->request->getStrParam('mobile');
        $password = $this->request->getStrParam('password');
        $appid    = $this->request->getStrParam('appid');
        $appsecret = $this->request->getStrParam('appsecret');
      
        if($appletType && $company && $mobile && $password){
            $company_storage    = new App_Model_Member_MysqlCompanyCoreStorage();
            //第一步创建公司
            $cpdata = array(
                'c_name'        => $company,
                'c_max_build'   => 1,            //最多创建店铺数
                'c_area'        => '',
                'c_created'     => time(),
                'c_founder_id'  => 0,            //先设为0，后续修改
                'c_province'    => 0,
                'c_source'      => '',  // 注册来源
                'c_city'        => 0,
                'c_type'        => 0
            );
            $cid    = $company_storage->insertValue($cpdata);//获取新创建的公司id
            //第二步新建管理员
                  $manager_storage    = new App_Model_Member_MysqlManagerStorage();
            $mgdata = array(
                'm_c_id'        => $cid,
                'm_mobile'      => $mobile,
                'm_nickname'    => '',
                'm_password'    => plum_salt_password($password),
                'm_createtime'  => time(),
                'm_status'      => 0,   //正常登陆
            );
            $mid = $manager_storage->insert($mgdata, true);//获取创建人id
            // 第三步创建店铺，创建一个默认店铺
            $open_time      = time();
            $data = array(
                's_unique_id'   => plum_uniqid_base36(),
                's_contact'     => '',
                's_phone'       => $mobile,
                's_name'        => $company,
                's_type'        => 0,        //自有店铺
                's_c_id'        => $cid,
                's_open_time'   => $open_time,
                's_expire_time' => time() + 10*365*12*3600,
                's_createtime'  => time(),
                's_weight'      => 0,
                's_status'      => App_Helper_ShopWeixin::SHOP_MANAGE_RUN,
                's_version'     => App_Helper_ShopWeixin::SHOP_VERSION_MFB,//免费版
            );
            $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
            $sid = $shop_model->insertValue($data);
          
            // 第四步添加小程序信息
            $applet_category    = plum_parse_config('category', 'applet');
            $ac_index_tpl = $applet_category[$appletType]['tpl'][0] ? $applet_category[$appletType]['tpl'][0] : 0 ;  // 获取默认的首页模板
            //开通应用
            $applet_model   = new App_Model_Applet_MysqlCfgStorage($sid);
            $indata = array(
                'ac_s_id'           => $sid,
                'ac_type'           => $appletType,  //订购类型
                'ac_open_time'      => time(),
                'ac_expire_time'    => (time()+10*365*12*3600),
                'ac_update_time'    => time(),
                'ac_index_tpl'      => $ac_index_tpl,   //默认首页模板
                'ac_self_renewal'   => 0,
                'ac_appid'          => $appid,
                'ac_appsecret'      => $appsecret
            );
            $ret = $applet_model->insertValue($indata);
            //开通插件
            $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($sid);
            $plugins    = plum_parse_config('plugin', 'wxmenu/xcx-'.$appletType);
            foreach($plugins as $key => $plugin){
              $indata = array(
                  'apo_s_id'          => $sid,
                  'apo_a_id'          => 0,
                  'apo_plugin_id'     => $key,  //订购类型
                  'apo_open_time'     => time(),
                  'apo_expire_time'   => time()+10*365*12*3600,
                  'apo_update_time'   => time(),
              );
              $plugin_model->insertValue($indata);
            }
            //把默认模板的展示图下载下来
            $this->_download_template_cover();
            $this->showAjaxResult($sid);
        }else{
            $this->displayJsonError('请将信息填写完整');
        }
    
    }

}