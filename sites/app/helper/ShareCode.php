<?php
 /**
  * 根据数字id生成N位邀请码
  * zhangzc
  * 2019-4-20
  */
class App_Helper_ShareCode{
	// 加解密字符串salt
	CONST KEY='EF5CDG3HQA4B1NOPIJ2RSTUV67MWX89KLYZ';
	public function __construct(){	
	
	}

	/**
     * 生成邀请码
     * @param id ID
     * @return 随机码
     */
	public static function toSerialCode($id,$type='simple') {
		switch ($type) {
			case 'simple':
				return self::toSimpleEncode($id);
				break;
			case 'base64':
			default:
				return self::toBase64SerialCode($id);
				break;
		}
	}

	/**
	 * 生成base64格式的编码
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	private static function toBase64SerialCode($id){
		return base64_encode(base64_encode($id));
	}
	/**
	 * 简单的对称加密算法
	 * @param  int $id [description]
	 * @return [type]         [description]
	 */
	private static function toSimpleEncode($id) {
	    static $source_string = self::KEY;
	    $num = $id;
	    $code = '';
	    while ( $num > 0) {
	        $mod = $num % 35;
	        $num = ($num - $mod) / 35;
	        $code = $source_string[$mod].$code;
	    }
	    if(empty($code[3]))
	        $code = str_pad($code,4,'0',STR_PAD_LEFT);
	    return $code;
	}


	/**
	 * 转码加密格式
	 * @param  [type] $code [description]
	 * @param  string $type [description]
	 * @return [type]       [description]
	 */
	public static function codeToId($code,$type='simple') {
		switch ($type) {
			case 'simple':
				return self::toSimpleDecode($code);
				break;
			case 'base64':
			default:
				return self::toBase64SerialCode($code);
				break;
		}
	}
	/**
	 * simple 方式的解密
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	private static function toSimpleDecode($id) {
	    static $source_string = self::KEY;
	    if (strrpos($id, '0') !== false)
	        $id = substr($id, strrpos($id, '0')+1);
	    $len = strlen($id);
	    $id = strrev($id);
	    $num = 0;
	    for ($i=0; $i < $len; $i++) {
	        $num += strpos($source_string, $id[$i]) * pow(35, $i);
	    }
	    return $num;
	}

	/**
	 * base64方式的解码
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	private static function toBase64Decode($id){
		return base64_decode(base64_decode($id));
	}
}
