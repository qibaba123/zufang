<?php

define('DEFAULT_DIR_MODE', 0775);
define('PLUM_AUTH_TOKEN', 'plum');//默认的认证token
//define('PLUM_IMG_HOST_PATH','jdfs.jixuantiant.com');   //图片加速域名
define('PLUM_IMG_HOST_PATH','myd.jixuantiant.com');   //图片加速域名

/**
 * @author thomas<thomas@ikinvin.com>
 * @since 2014-03-24
 */
//-------------------------获取变量------------------------------------
/**
 * 根据名称获取变量
 * @param $name
 * @param string $default
 * @return string
 */
function plum_get_param($name, $default = '') {
    return isset($_REQUEST[$name]) ? trim($_REQUEST[$name]) : $default;
}
/**
 * 根据名称获取整型变量
 * @param $name
 * @param int $default
 * @return int
 */
function plum_get_int_param($name, $default = 0) {
    return isset($_REQUEST[$name]) ? intval($_REQUEST[$name]) : $default;
}

/**
 * 根据名称获取浮点型变量
 * @param string $name
 * @param int $default
 * @return float|int
 */
function plum_get_float_param($name, $default = 0) {
    return isset($_REQUEST[$name]) ? floatval($_REQUEST[$name]) : $default;
}
/**
 * 根据名称判断变量是否传递
 * @param string $name
 * @return bool
 */
function plum_get_isset_param($name) {
    return isset($_REQUEST[$name]) ? true : false;
}
/**
 * 根据名称获取数组变量
 * @param $name
 * @param array $default
 * @return array
 */
function plum_get_arr_param($name, $default = array()) {
    return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
}

/**
 * @param $param
 * @param string $default
 * @return string
 * 通过三目运算，判断变量是否存在
 */
function plum_get_param_is_set($arr,$key, $default = ''){
    return isset($arr[$key]) ? $arr[$key] : $default;
}
//--------------------------获取服务器变量---------------------------------------
function plum_get_server($name, $default = '') {
    $name = strtoupper($name);
    return isset($_SERVER[$name]) ? trim($_SERVER[$name]) : $default;
}

/**
 * 检测当前是否为测试环境
 * @param mixed $test_host 测试环境的host名称
 * @return bool
 */
function plum_check_test_env($test_host = array()) {
    $curr_host  = plum_get_server('HTTP_HOST');
    if (empty($test_host)) {
        $test_host  = plum_parse_config('test_host', 'app', array());
    } else {
        if (is_string($test_host)) {
            $test_host = array($test_host);
        }
    }

    if (in_array($curr_host, $test_host)) {
        return true;
    }
    return false;
}
//--------------------------获取配置---------------------------------------
/**
 * 获取配置文件
 * @param string $type
 * @return array
 */
function plum_get_config($type = 'app') {
    if (!$type) {
        return array();
    }
    static $config = array();
    if (isset($config[$type])) {
        return $config[$type];
    }
    $config_file = PLUM_DIR_CONFIG . '/' . $type . '.php';
    $data = array();
    if (file_exists($config_file)) {
        $data = @include_once $config_file;
    }
    $config[$type] = $data;
    return $data;
}

/**
 * 解析配置文件
 * @param $name
 * @param string $type
 * @param string $default
 * @return mixed
 */
function plum_parse_config($name, $type = 'app', $default = '') {
    //避免每次都检测测试环境
    static $env = null;
    if (!$env) {
        $curr_host  = plum_get_server('HTTP_HOST');
        $app_cfg    = plum_get_config('app');
        $test_host  = isset($app_cfg['test_host']) ? $app_cfg['test_host'] : array();

        if (in_array($curr_host, $test_host)) {
            $env    = PLUM_TESTING_ENV;
        } else {
            $env    = PLUM_ENV;
        }
    }

    $config = plum_get_config($type);
    if (empty($config) || !$name) {
        return $default;
    }
    //规则：先获取当前环境下的配置字段，若无，则获取默认字段，否则返回默认值
    return isset($config[$env.':'.$name]) ? $config[$env.':'.$name] : (isset($config[$name]) ? $config[$name] : $default);
}

/**
 * 检查数组键值是否存在
 * @param $key
 * @param array $array
 * @param string $default
 * @return string
 */
function plum_check_array_key($key, $array = array(), $default = '') {
    if (is_array($array) && isset($array[$key])) {
        return $array[$key];
    }
    return $default;
}

/**
 * 通过数字id获取索引数组值
 * @param int $id
 * @param array $array 索引数组，字符串作为索引键，value必须包含id字段，且id从1开始递增
 *  array(
        'click'     => array(
            'id'    => 1,
            'type'  => 'click',
            'extra' => 'key',
        ),
        'view'     => array(
            'id'    => 2,
            'type'  => 'view',
            'extra' => 'url',
        ),
    );
 * @param array $default 返回的默认值
 * @return array
 */
function plum_fetch_value_byid($id, array $array, $default = array()) {
    $id     = intval($id)-1 < 0 ? 0 : intval($id)-1;
    if (is_array($array)) {
        $keys   = array_keys($array);
        $index  = $keys[$id];
        if ($array[$index]) {
            return $array[$index];
        }
    }
    return $default;
}

/**
 * URL地址跳转
 * @param string $url
 * @param bool $absolute 是否为绝对路径，默认false
 * @param bool $permanent 是否为永久性地址转移, 默认false
 */
function plum_redirect($url, $absolute = false, $permanent = false) {
    $pattern    = '/^http[s]?:\/\//';
    if (preg_match($pattern, $url)) {
        $absolute = true;
    }
    if (!$absolute) {//非绝对路径
        $url = plum_get_base_host() . '/' . ltrim($url, '/');
    }

    if (!headers_sent()) {
        if($permanent) {
            header("HTTP/1.1 301 Moved Permanently");
        }
        header("Location: {$url}");
    } else {
        echo '<script type="text/javascript">';
        echo "window.location.href='{$url}'";
        echo '</script>';
    }
    exit;
}

/*
 * 获取请求的HOST
 */
function plum_get_base_host() {
    $http_type  = 'http://';
    if (plum_get_server('https') == 'on') {
        $http_type  = 'https://';
    }
    $server_port    = plum_get_server('server_port', 80);
    if ($server_port == 443) {
        $http_type  = 'https://';
        $server_port    = 80;
    }
    $http_host      = plum_get_server('http_host');
    $host = $http_type . $http_host . ($server_port == 80 ? '' : ':'.$server_port);
    return $host;
}

/**
 * 自定义cookie设置方法，默认可以用来处理session cookie
 * @param int $lifetime 存活时间，单位为秒，默认为0，即关闭浏览器即失效
 * @param null $name    cookie名称，默认为session name
 * @param null $value   cookie对应值，默认为session id
 * @param string $path  cookie存储路径，默认为整站
 * @return bool
 */
function plum_set_cookie($lifetime = 0, $name = null, $value = null, $path = '/') {
    $lifetime       = $lifetime > 0 ? intval($lifetime) : 0;
    //默认用来处理session
    $name           = $name ? $name : ini_get('session.name');
    $value          = $value ? $value : session_id();
    $request_time   = (int) plum_get_server('REQUEST_TIME', time());
    $expire         = $lifetime > 0 ? $request_time + $lifetime : 0;

    if (!setrawcookie($name, $value, $expire, $path)) {
        trigger_error("set cookie name:{$name},value:{$value} failed!", E_USER_WARNING);
        return false;
    }
    return true;
}

/**
 * 通过设置cookie失效时间，达到记住用户功能
 * @param int $lifetime
 * @param string $path
 */
function plum_remember_login_user($lifetime, $path = '/') {
    plum_set_cookie($lifetime, null, null, $path);
}
/**
 * 为密码加盐，增加混淆性
 * @param string $pass 明文密码
 * @return string
 */
function plum_salt_password($pass) {
    return md5('@&!#plum'.md5($pass).'plum$^%*');
}

/**
 * 对字符串前后加盐后并加密
 * @param string $str
 * @param mixed $salt
 * @return string
 */
function plum_md5_with_salt($str, $salt) {
    if (!$str || !$salt) {
        return false;
    }
    $prefix_salt = $suffix_salt = $salt;
    if (is_array($salt) && count($salt) == 2) {
        list($prefix_salt, $suffix_salt) = $salt;
    }
    return md5($prefix_salt.md5($str).$suffix_salt);
}
/**
 * URL跳转加错误提示
 * @param string $msg 提示信息
 * @param string $url 跳转URL，URL为空是将后退
 * @param int $countdown 跳转前等待时间
 * @param bool $absolute URL是否为绝对路径
 */
function plum_redirect_with_msg($msg, $url = '', $countdown = 3, $absolute = false) {
    $pattern        = '/^http[s]?:\/\//';
    if (preg_match($pattern, $url)) {
        $absolute   = true;
    }
    if (!$absolute && $url) {//非绝对路径
        $url = plum_get_base_host() . '/' . ltrim($url, '/');
    }

    $msg        = $msg ? trim($msg) : '跳转提示';
    $countdown  = intval($countdown);

    include 'tpl/redirect.tpl';
    exit;
}

function plum_redirect_with_output(array $output, $url, $countdown = 3, $absolute = false) {
    $pattern        = '/^http[s]?:\/\//';
    if (preg_match($pattern, $url)) {
        $absolute   = true;
    }
    if (!$absolute && $url) {//非绝对路径
        $url = plum_get_base_host() . '/' . ltrim($url, '/');
    }
    $msg    = $output['msg'];
    $msg        = $msg ? trim($msg) : '跳转提示';
    $script = isset($output['script']) ? $output['script'] : '';

    $countdown  = intval($countdown);

    include 'tpl/redirect.tpl';
    exit;
}
/**
 * 验证是否为邮箱
 * @param $email
 * @return bool
 */
function plum_is_email($email) {
    $pattern = '/^[A-Za-z0-9]+([-_\.][A-Za-z0-9]+)*@([A-Za-z0-9]+[-\.])+[A-Za-z0-9]{2,5}$/i';
    if (preg_match($pattern, $email)) {
        return true;
    }
    return false;
}

/**
 * 验证手机号正确
 * @param $phone
 * @return bool
 */
function plum_is_phone($phone) {
    $pattern = '/^(0|86|17951)?(13[0-9]|15[012356789]|16[012356789]|17[012356789]|18[0-9]|19[012356789]|14[57])[0-9]{8}$/';
    if (preg_match($pattern, $phone)) {
        return true;
    }
    return false;
}

/**
 * 手机号验证，通用版
 * @param $mobile
 * @return bool
 */
function plum_is_mobile($mobile) {
    $pattern = '/^1(\d{10})$/';
    if (preg_match($pattern, $mobile)) {
        return true;
    }
    return false;
}

/**
 * 验证手机号或者固话
 * @param $phone
 * @return bool
 */
function plum_is_mobile_phone($phone){
    if(preg_match('/^((0[0-9]{2,3}\-)|(0[0-9]{2,3}))?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$|^(0|86|17951)?(13[0-9]|15[012356789]|16[012356789]|17[012356789]|18[0-9]|19[012356789]|14[57])[0-9]{8}$/',$phone)){
        return true;
    }else{
        return false;
    }
}


/**
 * 密码长度验证
 * @param $pass
 * @return bool
 */
function plum_passlen_check($pass) {
    $length = strlen($pass);
    if ($length < 6 || $length > 50) {
        return false;
    }
    return true;
}
/**
 * 是否为中文姓名
 * @param $name
 * @return bool
 */
function plum_is_realname($name) {
    if (preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/', $name)) {
        return true;
    }
    return false;
}
/*
 * 是否是正确的URL地址
 */
function plum_is_url($url) {
    //$pattern    = '/^((http|https):\/\/)?[\w-_.]+(\/[\w-_]+)*\/?$/';
    $pattern    = '/https?:\/\/\S+/';

    return preg_match($pattern, $url);
}

/**
 * 判断是否是HTTPS域名
 */
function plum_is_https_url($url) {
    //$pattern    = '/^((http|https):\/\/)?[\w-_.]+(\/[\w-_]+)*\/?$/';
    $pattern    = '/https:\/\/\S+/';

    return preg_match($pattern, $url);
}
#pragma mark - UTF-8字符处理
/**
 * 检验字符是否为UTF-8编码
 * @param $text
 * @return bool
 */
function plum_validate_utf8($text) {
    if (strlen($text) == 0) {
        return TRUE;
    }
    // With the PCRE_UTF8 modifier 'u', preg_match() fails silently on strings
    // containing invalid UTF-8 byte sequences. It does not reject character
    // codes above U+10FFFF (represented by 4 or more octets), though.
    return (preg_match('/^./us', $text) == 1);
}
/**
 * 获取UTF-8编码的字符长度
 * @param $text
 * @return int
 */
function plum_utf8_strlen($text) {
    if (plum_validate_utf8($text)) {
        return mb_strlen($text, 'UTF-8');
    }
    return 0;
}
/**
 * 截取指定长度的字符
 * @param $str
 * @param int $length
 * @param string $replace
 * @return string
 */
function plum_utf8_str_truncate($str, $length = 10, $replace = '……') {
    if (plum_utf8_strlen($str) <= $length) {
        return $str;
    } else {
        return mb_substr($str, 0, $length) . $replace;
    }
}
/**
 * 用户名格式：只能是数字，字母，下划线组成
 * @param $username
 * @return bool
 */
function plum_is_username($username){
    if(preg_match('/^[0-9a-zA-Z_\x{4e00}-\x{9fa5}]+$/u',$username)){
        return true;
    }else{
        return false;
    }
}

function plum_is_idcard($idcard){
    if(preg_match('/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/',$idcard)){
        return true;
    }else{
        return false;
    }
}
/**
 * @param $msg
 * @param bool $exit
 * 以清晰的格式打印数组或者对象
 */
function plum_msg_dump($msg, $exit = true){
    header("Content-Type: text/html; charset=UTF-8");
    echo '<pre>';
    var_dump($msg);
    echo '</pre>';
    if($exit){
        exit('this is end');
    }
}

/**
 * @param $descTemp
 * @return string
 * 文本域换行替换
 */
function plum_textarea_line_to_html($content){
    $temp = explode("\n",$content);
    return implode('<br/>',$temp);
}

function plum_textarea_html_to_line($content){
    $temp = explode("<br/>",$content);
    return implode('\n',$temp);
}

function plum_nl_br($str){
    $str = nl2br($str);
    $str = str_replace(array("\r\n", "\r", "\n"), "<br />", $str);
    return $str;
}

/**
 * @param $key
 * @param $str
 * @return array
 * 字符串截取，并以数组形式返回真实存在的数据
 */
function plum_explode($str,$key=','){
    $temp_arr =  explode($key,$str);
    $data     = array();
    foreach($temp_arr as $val){
        if($val){
            $data[] = $val;
        }
    }
    return $data;
}

function plum_url_location($msg='',$url=''){
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>";
    if(!empty($msg))echo "alert('$msg');";
    if($url){
        echo "window.location.href='$url'";
    }else{
        echo " window.history.back(-1);";
    }
    echo "</script>";
    exit();
}

/**
 * @param $str
 * @return mixed|string
 * 剔除html标签
 */
function plum_strip_html_tags($str) {
    $str = htmlspecialchars_decode($str);
    $str = strip_tags($str);
    $str = trim($str);
    $str = preg_replace('/\s(?=\s)/', '', $str);
    $str = preg_replace('/[\n\r\t]/', '', $str);
    $str = preg_replace('/<img.*?src="(.*?)".*?>/is', '', $str);
    return $str;
}

/**
 * @param $str
 * @return mixed|string
 * 剔除html标签  测试版
 */
function plum_strip_html_tags_new($str) {
    $str = htmlspecialchars_decode($str);
    $str = strip_tags($str);
    $str = trim($str);
    $str = preg_replace('/\s(?=\s)/', '', $str);
    $str = preg_replace('/[\n\r\t]/', '', $str);
    return $str;
}

/**
 * @param $str
 * @return mixed
 * 剔除手机号，将手机号换成***
 */
function plum_strip_mobile($str){
    $pattern = '/(1\d{10})/';
    $replace = '***';
    return preg_replace($pattern, $replace, $str);
}
/**
 * 解析REQUEST_URI，并返回数组形式的请求参数列表
 * @说明1: '/'分隔的请求参数只能包含有字母、数字
 * @说明2: 只解析形如“域名'/参数'?更多”单引号之间的内容
 * @return array
 */
function plum_parse_request_uri() {
    $uri        = plum_get_server('REQUEST_URI', '/');
    $pattern    = '/^\/+([a-zA-Z0-9\/]+)(\?|&)?.*/i';
    $query      = array();

    if (preg_match($pattern, $uri, $match)) {
        $rep_pat = '/\/+/';
        $rep_str = '/';
        $tmp = $match[1];
        $tmp = trim($tmp, '/');//去除两端无用的'/'
        $tmp = preg_replace($rep_pat, $rep_str, $tmp);//替换多余的'/'
        $query = explode('/', $tmp);
    }
    return $query;
}

/**
 * 判断目录是否存在，创建并修改权限
 * @param string $uri
 * @return bool
 */
function plum_setmod_dir($uri) {
    //检查目录是否存在
    if (!file_exists($uri)) {
        //递归地创建目录，并赋予775权限，拥有者/用户组可写
        if (!mkdir($uri, DEFAULT_DIR_MODE, true)) {
            //创建失败，触发错误并退出
            trigger_error($uri.'目录创建失败', E_USER_ERROR);
            return false;
        }
    }
    //检查目录是否可写
    if (!is_writable($uri)) {
        //更改目录的权限
        if (!chmod($uri, DEFAULT_DIR_MODE)) {
            //更改权限失败，触发错误并退出
            trigger_error($uri.'目录不可写', E_USER_ERROR);
            return false;
        }
    }
    return true;
}

/**
 * 加解密
 * @param string $string 待加密或解密的字符串
 * @param string $operation DECODE==解密 ENCODE==加密
 * @param string $key   加解密TOKEN
 * @param int $expiry
 * @return string
 */
function plum_authcode($string, $operation = 'DECODE', $key = PLUM_AUTH_TOKEN, $expiry = 0) {

    $ckey_length = 4;

    $key  = md5($key);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}

/**
 * 获取加密后的session值
 * @param mixed $output
 * @return string
 */
function plum_fetch_auth_session($output) {
    //获取auth session配置
    $session_config = plum_parse_config('auth', 'session');
    $out_arr = array();
    if (is_numeric($output)) {
        $out_arr[$session_config['uid_key']] = $output;
    } else {
        $out_arr    = $output;
    }
    return plum_authcode(serialize($out_arr), 'ENCODE', $session_config['auth_token']);
}
/**
 * @param $img_src
 * @return string
 * 处理图片，补全路径
 */
function plum_deal_image_url($url){
    if($url && !stristr($url,'http')){
        //$url = plum_get_base_host().$url;
        $url = 'http://'.PLUM_IMG_HOST_PATH.$url;
    }elseif(!$url){
        $url = '';
    }
    return $url;
}

/**
 * @param $idCard
 * @return array
 * 根据身份证号获取生日和性别
 */
function plum_get_sex_birthday_by_idcard($idCard){
    $length = strlen($idCard);
    $data = array(
        'ec' => 400,
        'birthday' => '',
        'sex'      => '',
    );
    if($length == 15){
        $tyear  = "19".substr($idCard,6,2);
        $tmonth = substr($idCard,8,2);
        $tday   = substr($idCard,10,2);
        $birthday = $tyear.'-'.$tmonth.'-'.$tday;
        $sex = substr($idCard, -2 , 1) % 2 ? 1 : 0;
        $data = array(
            'ec'  => 200,
            'sex' => $sex,
            'birthday' => $birthday,
        );
    }elseif($length == 18){
        $tyear  = substr($idCard,6,4);
        $tmonth = substr($idCard,10,2);
        $tday   = substr($idCard,12,2);
        $birthday = $tyear.'-'.$tmonth.'-'.$tday;
        $sex = substr($idCard, -2 , 1) % 2 ? 1 : 0;
        $data = array(
            'ec'  => 200,
            'sex' => $sex,
            'birthday' => $birthday,
        );
    }
    return $data;
}

/**
 * @param $str
 * @param int $limit
 * @return array
 * 按要求截取字符串
 */
function plum_brief_limit_lenth($str,$limit=50){
    $lenth = mb_strlen($str);
    if($lenth > $limit){
        $data = array(
            'content' => mb_substr($str,0,$limit),
            'more'    => 1
        );
    }else{
        $data = array(
            'content' => $str,
            'more'    => 0
        );
    }
    return $data;
}

/**
 * 产生不重复随机码，默认包含一个字母
 * @param int $length
 * @param bool $only 单个字母
 * @return mixed
 */
function plum_random_code($length = 6, $only = true) {
    if ($length < 4) {
        return false;
    }
    $num_str    = '1234567890';
    $let_str    = 'ABCDEFGHJKLMNPQRSTUVWXYZ';//去除I和O，防止识别混淆，长度24
    $result     = '';//结果字符串
    if ($only) {
        $letter     = $let_str[rand(0, 23)];
        $shf_str    = str_repeat($num_str, $length-1);//数字串重复次数
        $rand_str   = str_shuffle($shf_str);//打乱
        $rand_str   = substr($rand_str, 0, $length-1);//总长度-1的字符串
        $insert_pos = rand(0, $length-1);//插入字母位置

        for ($i=0; $i<$length; $i++) {
            if ($i == $insert_pos) {
                $result .= $letter;
            }
            if ($i<$length-1) {
                $result .= $rand_str[$i];
            }
        }
    } else {
        $rand_str = str_repeat($num_str, rand(2, $length-1)).$let_str;//随机串
        $rand_str = str_shuffle($rand_str);//打乱
        $result   = substr($rand_str, 0, $length);
    }

    return $result;
}

/**
 * 获取随机字符串
 * @param int $numLength 包含数字的长度
 * @param int $letterLength 包含字母的长度
 * @return mixed
 */
function plum_random_num_letter($numLength = 3, $letterLength = 3) {
    $length = $numLength + $letterLength;
    if ($length < 6) {
        return false;
    }

    $num_str    = '1234567890';
    $let_str    = 'ABCDEFGHJKLMNPQRSTUVWXYZ';//去除I和O，防止识别混淆，长度24
    $result     = '';//结果字符串
    $result_let = '';
    //字母部分
    for ($i=0;$i<$letterLength;$i++){
        $result_let .= $let_str[rand(0, 23)];
    }
    //数字部分
    $shf_str    = str_repeat($num_str, $length-1);//数字串重复次数
    $rand_str   = str_shuffle($shf_str);//打乱
    $result_num   = substr($rand_str, 0, $numLength);//
    $insert_pos = rand(0, $length-1);//插入字母位置

    for ($i=0; $i<$length; $i++) {
        if ($i == $insert_pos) {
            $result .= $result_let;
        }
        if ($i<$length-1) {
            $result .= $result_num[$i];
        }
    }
    $result = str_shuffle($result);
    return $result;
}


/**
 * 获取随机字符串
 * @param number $length 字符串长度
 * @param boolean $numeric 是否为纯数字
 * @return string
 */
function plum_random($length, $numeric = FALSE) {
    $seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
    if ($numeric) {
        $hash = '';
    } else {
        $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
        $length--;
    }
    $max = strlen($seed) - 1;
    for ($i = 0; $i < $length; $i++) {
        $hash .= $seed{mt_rand(0, $max)};
    }
    return $hash;
}
/**
 * @param bool|false $more_entropy
 * @return string
 * 生成唯一性ID
 */
function plum_uniqid_base36($more_entropy=false) {
    $s = uniqid('', $more_entropy);
    if (!$more_entropy)
        return base_convert($s, 16, 36);

    $hex = substr($s, 0, 13);
    $dec = $s[13] . substr($s, 15); // skip the dot
    return base_convert($hex, 16, 36) . base_convert($dec, 10, 36);
}

/**
 * @param $content
 * @return mixed|string
 * 图片路径替换成带http的绝对路径
 */
function plum_parse_img_path($content) {
    //$host = $_SERVER['HTTP_HOST'];
    /*$host = PLUM_IMG_HOST_PATH;
    if (!$content) {
        return '';
    }
    //$pattern = '/<img src=\"(.+?)\"(.*?)\/>/i';
    $pattern = '/<img .*?src=[\"|\'](?!http)(.+?)[\"|\'](.*?)\/>/i';
    $replace = '<img src="http://'.$host.'$1"$2/>';
    return preg_replace($pattern, $replace, $content);*/
    $host = PLUM_IMG_HOST_PATH;
    if (!$content) {
        return '';
    }
    $pattern = '/<img (.*?)src=\"(?!http)(.+?)\"(.*?)\/>/i';
    $replace = '<img $1src="http://'.$host.'$2"$3/>';
    return preg_replace($pattern, $replace, $content);
}

/**
 * @param $content
 * @return mixed|string
 * 图片路径替换成带http的绝对路径 (测试)
 */
function plum_parse_img_path_new($content) {
    //$host = $_SERVER['HTTP_HOST'];
    $host = PLUM_IMG_HOST_PATH;
    if (!$content) {
        return '';
    }
    $pattern = '/<img (.*?)src=[\'\"](?!http)(.+?)[\'\"](.*?)\/>/i';//匹配单引号或双引号
    $replace = '<img $1src="http://'.$host.'$2"$3/>';
    return preg_replace($pattern, $replace, $content);
}

/*
 * 发送HTTP响应头
 */
function plum_send_http_header($header) {
    //头文件未发送的情况下
    if (!headers_sent()) {
        header($header);
    }
}
/*
 * 返回状态及错误描述的便利方法
 */
function plum_return_errcode($status = true, $msg = '') {
    return array(
        'status'    => $status,
        'msg'       => $msg,
    );
}

/**
 * @param $str
 * @return array|string
 * 在控制器层防止Sql注入
 */
function plum_sql_quote($str)
{
    //trim() 函数移除字符串两侧的空白字符或其他预定义字符。
    //htmlspecialchars() 函数把预定义的字符转换为 HTML 实体(防xss攻击)。
    //预定义的字符是：
    //& （和号）成为 &amp;
    //" （双引号）成为 &quot;
    //' （单引号）成为 '
    //< （小于）成为 &lt;
    //> （大于）成为 &gt;
    return quotes(htmlspecialchars(trim($str)));
}
//防sql注入
function quotes($content)
{
    //if $content is an array
    if (is_array($content))
    {
        foreach ($content as $key=>$value)
        {
            //$content[$key] = mysql_real_escape_string($value);
            /*addslashes() 函数返回在预定义字符之前添加反斜杠的字符串。
            预定义字符是：
            单引号（'）
            双引号（"）
            反斜杠（\）
            NULL */
            $content[$key] = addslashes($value);
        }
    } else
    {
        //if $content is not an array
        //$content=mysql_real_escape_string($content);
        $content=addslashes($content);
    }
    return $content;
}
/**
 * 获取客户端IP
 * @return string
 */
function plum_get_client_ip() {
    static $ip = '';
    $ip = $_SERVER['REMOTE_ADDR'];
    if(isset($_SERVER['HTTP_CDN_SRC_IP'])) {
        $ip = $_SERVER['HTTP_CDN_SRC_IP'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
        foreach ($matches[0] AS $xip) {
            if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                $ip = $xip;
                break;
            }
        }
    }
    return $ip;
}
/**
 * 开启后台进程
 * @param string $ctrl
 * @param string $action
 * @param array $params 键值对形式,值为简单数据类型,不可为数组、对象等
 */
function plum_open_backend($ctrl, $action, $params = array()) {
    $bin    = plum_parse_config('php_bin', 'console');
    $bin    = $bin ? $bin : 'php';
    $script = PLUM_DIR_ROOT.'/scripts/console.php';

    $cmd    = $bin." {$script} '{$ctrl}/{$action}' ";
    if (!empty($params)) {
        foreach($params as $key => $val) {
            $cmd    .= "{$key}={$val} ";
        }
    }
    $cmd    = escapeshellcmd($cmd);
    $cmd    .= "&";
    pclose(popen($cmd, 'r'));
}


/**
 * @param $str
 * @return mixed|string
 * 剔除html标签  , 输出时对转义字符进行反转义
 */
function plum_strip_sql_quote($str) {
    $str = htmlspecialchars_decode($str);
    $str = strip_tags($str);
    $str = trim($str);
    $str = stripslashes($str);
    $str = preg_replace('/\s(?=\s)/', '', $str);
    $str = preg_replace('/[\n\r\t]/', '', $str);
    $str = preg_replace('/<img.*?src="(.*?)".*?>/is', '', $str);
    return $str;
}