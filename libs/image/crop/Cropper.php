<?php

class Libs_Image_Crop_Cropper {
	const COMMON_CSS_PATH   = '/public/common/css';
	const COMMON_JS_PATH    = '/public/common/js';

	private $_load_bootstrap_   = true;
	private $_load_jquery_      = true;
	private $_html_;

	private $_crop_width_;
	private $_crop_height_;
	private $_aspect_ratio_     = 1;

	private $_action_url_;
	private $_field_name_       = 'icon-upload';

	private $_preview_width_    = 184;
	private $_preview_height_;

	private $_default_image_    = '/public/common/img/tianjia.gif';
	private $_default_title_    = '图片上传';
	private $_multi_image_      = 0;

	//const LIMIT_FILE_SIZE = 2100000;   //上传图片大小限制为2M   2*1024*1024=2097152

	/**
	 * 裁切图片构造函数
	 * @param int $width            初次调用时为缩略图宽度，裁切调用时为裁切图宽度
	 * @param int $height           初次调用时为缩略图高度，裁切调用时为裁切图高度
	 * @param string $action_url    初次调用时传递，设置裁切相应URL
	 * @param string $field_name    初次调用时传递，设置裁切字段名称，特殊说明：设置为数组时，如image[]，将可以自动生成多个图片域
	 */
	public function __construct($width = null, $height = null, $action_url = '', $field_name = '',$title = '',$need_bootstrap=true) {
		$this->_crop_width_     = $width ? intval($width) : 200;
		$this->_crop_height_    = $height ? intval($height) : 200;
		$this->_aspect_ratio_   = $this->_crop_width_ / $this->_crop_height_;
		$this->_preview_height_ = ceil($this->_preview_width_ / $this->_aspect_ratio_);

		$this->_action_url_     = $action_url;
		$field_name = $field_name ? $field_name : $this->_field_name_;
		if($title){
			$this->_default_title_ = $title;
		}
		$this->_field_name_     = $field_name;
		$this->_multi_image_    = strpos($field_name, '[]') ? 1 : 0;
		$this->_load_bootstrap_ = $need_bootstrap;
	}

	public function fetchHtml($default = '',$need_change='') {
		$class_name = strtolower(__CLASS__);
		$temp = explode('_', $class_name);
		array_pop($temp);
		$template_dir = PLUM_DIR_ROOT .'/' . implode('/', $temp) . '/tpl';
		$smarty = new Libs_View_Smarty_SmartyTool($template_dir);
		if($default){
			$this->_default_image_              =  $default;
		}
		$smarty->output['common_css_path']  = self::COMMON_CSS_PATH;
		$smarty->output['common_js_path']   = self::COMMON_JS_PATH;
		$smarty->output['load_bootstrap']   = $this->_load_bootstrap_;
		$smarty->output['load_jquery']      = $this->_load_jquery_;
		$smarty->output['crop_width']       = $this->_crop_width_;
		$smarty->output['aspect_ratio']     = $this->_aspect_ratio_;
		$smarty->output['crop_height']      = $this->_crop_height_;
		$smarty->output['action_url']       = $this->_action_url_;
		$smarty->output['field_name']       = $this->_field_name_;
		$smarty->output['preview_width']    = $this->_preview_width_;
		$smarty->output['preview_height']   = $this->_preview_height_;
		$smarty->output['default_image']    = $this->_default_image_;
		$smarty->output['default_title']    = $this->_default_title_;
		$smarty->output['multi_image']      = $this->_multi_image_;

		$this->_html_['field'] = $smarty->fetchSmarty('crop-field.tpl');
		if($need_change){ //可动态变更上传图片域
			$this->_html_['modal']= $smarty->fetchSmarty('crop-modal-change.tpl');
		}else{
			$this->_html_['modal']= $smarty->fetchSmarty('crop-modal.tpl');
		}
		$this->_html_['mobile']= $smarty->fetchSmarty('crop-mobile.tpl');
		return $this->_html_;
	}

	public function setDefaultImage($image_path) {
		$image_path = $image_path ? $image_path : $this->_default_image_;
		$this->_default_image_ = $image_path;
	}

	public function isLoadBootstrap($type) {
		$this->_load_bootstrap_ = $type ? true : false;
	}

	public function isLoadJquery($type) {
		$this->_load_jquery_    = $type ? true : false;
	}

	private $src; //网络路径
	private $src_path;//磁盘路径
	private $data;
	private $dst;//网络路径
	private $dst_path;//磁盘路径
	private $type;
	private $extension;
	private $msg;
	private $filename;

	private function setData($data) {
		if (!empty($data)) {
			$this->data = json_decode(stripslashes($data));
		}
	}

	private function setFile($file) {
		$errorCode = $file['error'];

		if ($errorCode === UPLOAD_ERR_OK) {
            if($file['size'] < (2 * 1024 * 1024)){
                list(,,$type)   = getimagesize($file['tmp_name']);
                if ($type) {
                    $extension  = image_type_to_extension($type);
                    $path_arr   = $this->_fetch_gallery_path('default');
                    $src_path   = $path_arr['absolute_path'] . $path_arr['file_name'] . $extension;
                    $src        = $path_arr['relative_path'] . $path_arr['file_name'] . $extension;
                    if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG) {
                        if (file_exists($src_path)) {
                            unlink($src_path);
                        }
                        $result = move_uploaded_file($file['tmp_name'], $src_path);

                        if ($result) {
                            $this->filename     = $file['name'];
                            $this->src          = $src;
                            $this->src_path     = $src_path;
                            $this->type         = $type;
                            $this->extension    = $extension;
                        } else {
                            $this->msg = '保存文件失败';
                        }
                    } else {
                        $this->msg = '请上传以下类型的图片: JPG, PNG, GIF';
                    }
                } else {
                    $this->msg = '请上传图片';
                }
            }else{
                $this->msg = $this->codeToMessage(1);
            }
		} else {
			$this->msg = $this->codeToMessage($errorCode);
		}
	}

	public function crop($width,$height) {
	    ini_set('memory_limit', '256M');//临时调整内存使用到256M
      	set_time_limit(0);//设置无超时
		$width	= intval($width); //适配多个尺寸，在同一页面上传
		$height	= intval($height);
		$data 	= plum_get_param('avatar_data');
		$file 	= $_FILES['avatar_file'];
		Libs_Log_Logger::outputLog($file);

		$this->setData($data);
		$this->setFile($file);

		if (!empty($this->src_path) && !empty($data)) {
		    //分配源图片时，占用较大内存
			switch ($this->type) {
				case IMAGETYPE_GIF:
					$src_img = imagecreatefromgif($this->src_path);
					break;

				case IMAGETYPE_JPEG:
					$src_img = imagecreatefromjpeg($this->src_path);
					break;

				case IMAGETYPE_PNG:
					$src_img = imagecreatefrompng($this->src_path);
					imagesavealpha($src_img,true);
					break;
			}
			if (!$src_img) {
				$this->msg = "读取文件失败";
				return;
			}

			$path_arr = $this->_fetch_thumbnail_path($this->src);
			$this->dst_path = $path_arr['thumb_dir_path'];
			$this->dst      = $path_arr['thumb_url_path'];

			$dst_img = imagecreatetruecolor($width, $height);
			imagealphablending($dst_img,false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
			imagesavealpha($dst_img,true);//这里很重要,意思是不要丢了$thumb图像的透明色;

			$x = ceil($this->data->x);
			$y = ceil($this->data->y);
			$w = ceil($this->data->width);
			$h = ceil($this->data->height);

			$result = imagecopyresampled($dst_img, $src_img, 0, 0, $x, $y, $width, $height , $w, $h);
			if ($result) {
				switch ($this->type) {
					case IMAGETYPE_GIF:
						$result = imagegif($dst_img, $this->dst_path);
						break;

					case IMAGETYPE_JPEG:
						$result = imagejpeg($dst_img, $this->dst_path);
						break;

					case IMAGETYPE_PNG:
						$result = imagepng($dst_img, $this->dst_path);
						break;
				}

				if (!$result) {
					$this->msg = "保存裁切图片失败";
				}
			} else {
				$this->msg = "裁切图片失败";
			}
			imagedestroy($src_img);
			imagedestroy($dst_img);
		}
	}

	private function codeToMessage($code) {
		switch ($code) {
			case UPLOAD_ERR_INI_SIZE:
				$message = '上传的文件过大';
				break;

			case UPLOAD_ERR_FORM_SIZE:
				$message = '上传的文件过大';
				break;

			case UPLOAD_ERR_PARTIAL:
				$message = '仅部分文件被上传成功';
				break;

			case UPLOAD_ERR_NO_FILE:
				$message = '未上传文件';
				break;

			case UPLOAD_ERR_NO_TMP_DIR:
				$message = '上传文件临时目录配置错误';
				break;

			case UPLOAD_ERR_CANT_WRITE:
				$message = '文件写入硬盘错误';
				break;

			case UPLOAD_ERR_EXTENSION:
				$message = '文件上传错误';
				break;

			default:
				$message = '未知错误';
		}
		return $message;
	}

	/**
	 * 获取图库路径信息
	 */
	private function _fetch_gallery_path($sub_dir) {
		$dir        = isset($sub_dir) && trim($sub_dir) ? trim($sub_dir) : 'default';
		$gallery    = '/gallery/';
		$filepath   = PLUM_PATH_UPLOAD . $gallery . $dir . '/';
		$fileroot   = PLUM_DIR_UPLOAD . $gallery . $dir . '/';
		if (!is_dir($fileroot)) {
			mkdir($fileroot, 0755);
		}
		list($usec, $sec) = explode(" ", microtime());
		$md5        = strtoupper(md5($usec.$sec));
		$filename   = substr($md5, 0, 8).'-'.substr($md5, 10, 4).'-'.mt_rand(1000, 9999).'-'.substr($md5, 20, 12);

		return array(
			'absolute_path'     => $fileroot,   //绝对路径
			'relative_path'     => $filepath,   //相对路径
			'file_name'         => $filename,   //文件名，不包括扩展名
		);
	}

	/**
	 * 获取缩略图路径
	 * @param $image_path
	 * @return array
	 */
	private function _fetch_thumbnail_path($image_path) {
		$dir        = 'thumbnail';
		$gallery    = '/gallery/';
		$filepath   = PLUM_PATH_UPLOAD . $gallery . $dir . '/';
		$fileroot   = PLUM_DIR_UPLOAD . $gallery . $dir . '/';
		if (!is_dir($fileroot)) {
			@mkdir($fileroot, 0755);
		}
		$temp       = explode('/', $image_path);
		$filename   = array_pop($temp);
		list($imagename, $extension)    = explode('.', $filename);
		$thumb_name         = $imagename."-tbl.".$extension;
		$thumb_dir_path     = $fileroot.$thumb_name;
		$thumb_url_path     = $filepath.$thumb_name;
		if (file_exists($thumb_dir_path)) {//已存在
			$new_thumb_path = $this->_fetch_gallery_path($dir);
			$thumb_dir_path = $new_thumb_path['absolute_path'].$new_thumb_path['file_name'].'.'.$extension;
			$thumb_url_path = $new_thumb_path['relative_path'].$new_thumb_path['file_name'].'.'.$extension;
		}
		return array(
			'thumb_dir_path'    => $thumb_dir_path,
			'thumb_url_path'    => $thumb_url_path,
		);
	}

	public function getResult() {
		return !empty($this->data) ? $this->dst : $this->src;
	}

	public function getMsg() {
		return $this->msg;
	}

	public function getFileName(){
	    return $this->filename;
    }
}