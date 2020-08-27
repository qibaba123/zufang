<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/1/19
 * Time: 下午6:15
 */

class App_Controller_Site_UpdateController extends App_Controller_Site_HeadController {

    public function __construct() {
        parent::__construct(true);
    }

    public function indexAction(){
        $files = scandir(PLUM_DIR_ROOT."/sites/app/config/wxmenu/");
        $db_config = plum_parse_config('default', 'mysql');
        $this->output['dbhost'] = $db_config['remotehost'];
        $this->output['dbuser'] = $db_config['user'];
        $this->output['dbpasswd'] = $db_config['pass'];
        $this->output['dbname'] = $db_config['dbname'];
      
        $applet_model = new App_Model_Applet_MysqlCfgStorage();
        $applet     = $applet_model->getRow();
        $this->output['appletType'] = $applet['ac_type'];
      
        $this->displaySmarty('site/update.tpl');
    }


    public function setupAction(){
        set_time_limit(0);
        $zipname = $this->request->getStrParam('zipname');
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
        $this->_run_shell();//运行后台进程
        //清除店铺登录的redis
        $redis_shop = new App_Model_Shop_RedisShopQueueStorage();
        $redis_shop->delHashKey();
        //开通插件
        $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($sid);
        $plugins    = plum_parse_config('plugin', 'wxmenu/xcx-'.$appletType);
        foreach($plugins as $key => $plugin){
          $open = $plugin_model->findUpdateBySid($key);
          if(!$open){
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
        }
        $this->displayJsonSuccess();
    }
  
     private function _run_shell(){
        $trade_shell = shell_exec("ps -ef | grep trade/create | grep -v grep");
        if(!$trade_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php trade/create");
        }else{
            shell_exec("kill -9 ".array_values(array_filter(explode(' ', $trade_shell)))[1]);
        	shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php trade/create");
        }
        $answerpay_shell = shell_exec("ps -ef | grep answerpay/create | grep -v grep");
        if(!$answerpay_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php answerpay/create");
        }else{
            shell_exec("kill -9 ".array_values(array_filter(explode(' ', $answerpay_shell)))[1]);
        	shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php answerpay/create");
        }
        $group_shell = shell_exec("ps -ef | grep group/create | grep -v grep");
        if(!$group_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php group/create");
        }else{
            shell_exec("kill -9 ".array_values(array_filter(explode(' ', $group_shell)))[1]);
        	shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php group/create");
        }
        $daemon_shell = shell_exec("ps -ef | grep daemon/create | grep -v grep");
        if(!$daemon_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php daemon/create");
        }else{
            shell_exec("kill -9 ".array_values(array_filter(explode(' ', $daemon_shell)))[1]);
        	shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php daemon/create");
        }
        $knowledge_shell = shell_exec("ps -ef | grep knowledge/create | grep -v grep");
        if(!$knowledge_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php knowledge/create");
        }else{
            shell_exec("kill -9 ".array_values(array_filter(explode(' ', $knowledge_shell)))[1]);
        	shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php knowledge/create");
        }
        $goods_shell = shell_exec("ps -ef | grep goods/create | grep -v grep");
        if(!$goods_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php goods/create");
        }else{
            shell_exec("kill -9 ".array_values(array_filter(explode(' ', $goods_shell)))[1]);
        	shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php goods/create");
        }
        $applet_shell = shell_exec("ps -ef | grep applet/create | grep -v grep");
        if(!$applet_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php applet/create");
        }else{
            shell_exec("kill -9 ".array_values(array_filter(explode(' ', $applet_shell)))[1]);
        	shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php applet/create");
        }
        $member_shell = shell_exec("ps -ef | grep member/create | grep -v grep");
        if(!$member_shell){
            shell_exec("php ".PLUM_DIR_ROOT."/scripts/console.php member/create");
        }else{
            shell_exec("kill -9 ".array_values(array_filter(explode(' ', $member_shell)))[1]);
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
              curl_setopt($hander,CURLOPT_TIMEOUT,360);
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

}