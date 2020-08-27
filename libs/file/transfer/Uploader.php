<?php

class Libs_File_Transfer_Uploader {
    //默认上传文件路径
    const UPLOAD_FILE_TYPE  = 'image|gallery';
    //默认上传文件类型
    const UPLOAD_FILE_ALLOW = 'image/jpeg|image/png|image/gif';
    //上传失败时的默认显示文件
    const UPLOAD_FILE_FAIL  = '/public/common/img/info.gif';

    /**
     * 常见的mime类型映射
     * @var array
     */
    protected $mime_map = array(
        //图片文件类型
        'jpg'       => 'image/jpeg',
        'jpeg'      => 'image/jpeg',
        'png'       => 'image/png',
        'gif'       => 'image/gif',
        'tif'       => 'image/tiff',
        'tiff'      => 'image/tiff',
        'bmp'       => 'image/x-ms-bmp',
        'psd'       => 'image/vnd.adobe.photoshop',
        //音频文件类型
        'mp3'       => 'audio/mpeg',
        'mid'       => 'audio/midi',
        'ogg'       => 'audio/ogg',
        'mp4a'      => 'audio/mp4',
        'wav'       => 'audio/wav',
        'wma'       => 'audio/x-ms-wma',
        //视频文件类型
        'avi'       => 'video/x-msvideo',
        'mp4'       => 'video/mp4',
        'mpeg'      => 'video/mpeg',
        'mpg'       => 'video/mpeg',
        'mov'       => 'video/quicktime',
        'wm'        => 'video/x-ms-wmv',
        'flv'       => 'video/x-flv',
        'mkv'       => 'video/x-matroska',
        //压缩文件类型
        'gz'        => 'application/x-gzip',
        'tgz'       => 'application/x-gzip',
        'bz'        => 'application/x-bzip2',
        'bz2'       => 'application/x-bzip2',
        'tbz'       => 'application/x-bzip2',
        'zip'       => 'application/zip',
        'rar'       => 'application/x-rar',
        'tar'       => 'application/x-tar',
        '7z'        => 'application/x-7z-compressed',
        'apk'       => 'application/octet-stream',
        'ipa'       => 'application/octet-stream',
        //文档文件类型
        'doc'       => 'application/vnd.ms-word',
        'dot'       => 'application/msword',
        'docx'      => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'dotx'      => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'docm'      => 'application/vnd.ms-word.document.macroEnabled.12',
        'dotm'      => 'application/vnd.ms-word.template.macroEnabled.12',

        'xls'       => 'application/vnd.ms-excel',
        'xlt'       => 'application/vnd.ms-excel',
        'xla'       => 'application/vnd.ms-excel',
        'xlsx'      => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xltx'      => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'xlsm'      => 'application/vnd.ms-excel.sheet.macroEnabled.12',
        'xltm'      => 'application/vnd.ms-excel.template.macroEnabled.12',
        'xlam'      => 'application/vnd.ms-excel.addin.macroEnabled.12',
        'xlsb'      => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',

        'ppt'       => 'application/vnd.ms-powerpoint',
        'pot'       => 'application/vnd.ms-powerpoint',
        'ppa'       => 'application/vnd.ms-powerpoint',
        'pps'       => 'application/vnd.ms-powerpoint',
        'pptx'      => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'potx'      => 'application/vnd.openxmlformats-officedocument.presentationml.template',
        'ppsx'      => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'ppam'      => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
        'pptm'      => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
        'potm'      => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
        'ppsm'      => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',

        'pdf'       => 'application/pdf',
        'xml'       => 'application/xml',
        'swf'       => 'application/x-shockwave-flash',

        'pem'       => 'application/x-x509-ca-cert',

    );

    /**
     * 文件上传错误类型
     * @var array
     */
    protected $error_map = array(
        UPLOAD_ERR_OK           => '文件上传成功',
        UPLOAD_ERR_INI_SIZE     => '文件尺寸过大',
        UPLOAD_ERR_FORM_SIZE    => '文件过大',
        UPLOAD_ERR_PARTIAL      => '文件部分被上传',
        UPLOAD_ERR_NO_FILE      => '没有上传任何文件',
        UPLOAD_ERR_NO_TMP_DIR   => '未找到临时文件夹',
        UPLOAD_ERR_CANT_WRITE   => '临时文件写入失败',
    );
    /**
     * 错误信息栈，用于保存错误
     * @var array
     */
    public $error_stack    = array();
    /**
     * 上传状态标识，默认上传成功
     * @var bool
     */
    public $error_flag     = true;
    /**
     * 上传目录配置信息
     * @var array
     */
    public $upload_file_config;
    /**
     * 接收文件的存储目录，可以是数组形式，可取值，参考file配置文件，未填写或不正确，将使用默认值
     * @var string|array
     */
    public $upload_file_type;

    /*
     * 尺寸限制为memory_limit >= post_max_size >= upload_max_filesize
     * 三项中的最低值决定着可上传的尺寸
     */
    private $ini_upload_max_file_size;//整型，单位字节，仅可在php.ini中设置
    private $ini_post_max_size;//允许POST数据的最大值，仅可在php.ini中设置
    private $ini_memory_limit;//脚本执行时允许最大内存值，可设置

    /**
     * 是否允许上传
     * @var bool
     */
    private $is_allow_upload = false;
    /**
     * 允许上传时的配置
     * @var array
     */
    private $curr_upload_config;

    /**
     * 上传成功文件信息
     * @var array
     */
    public $upload_success_file = array();

    /**
     * 构造函数，接收上传类型说明，可接收字符串类型，如'image|gallery'，或数组类型，如array('image|avatar', 'media|audio')
     * 可接受的参数值，请参考配置文件，file.php中的type字段
     * @param string|array $upload_type
     */
    public function __construct($upload_type = self::UPLOAD_FILE_TYPE) {
        //判断上传根目录是否存在
        if (!file_exists(PLUM_DIR_UPLOAD)) {
            //递归地创建目录，并赋予775权限，拥有者/用户组可写
            if (!mkdir(PLUM_APP_LOG, 0775, true)) {
                //创建失败，触发错误并返回
                trigger_error('上传根目录创建失败', E_USER_ERROR);
                return null;
            }
        }

        //检查上传目录是否可写
        if (!is_writable(PLUM_DIR_UPLOAD)) {
            //更改目录的权限
            if (!chmod(PLUM_DIR_UPLOAD, 0775)) {
                //更改权限失败，触发错误并返回
                trigger_error('上传根目录不可写', E_USER_ERROR);
                return null;
            }
        }
        //获取配置信息
        $this->upload_file_config       = plum_parse_config('type', 'file', null);
        $this->upload_file_type         = $upload_type ? $upload_type : self::UPLOAD_FILE_TYPE;

        $this->ini_upload_max_file_size = ini_get('upload_max_filesize');
        $this->ini_post_max_size        = ini_get('post_max_size');
        $this->ini_memory_limit         = ini_get('memory_limit');
        $this->error_map[UPLOAD_ERR_INI_SIZE] = "上传文件尺寸不能大于{$this->ini_upload_max_file_size}";

        return $this;
    }

    /**
     * 接收文件
     * @param string $field 接收文件的字段名，为空时，接收所有字段
     * @return array 返回按字段名组装的上传路径
     */
    public function receiveFile($field = '') {
        //全局变量$_FILES不为空
        if (!empty($_FILES)) {
            //指定了接收上传文件字段名
            if ($field) {
                //查找对应字段
                if (isset($_FILES[$field])) {
                    //
                    $ret = $this->_deal_uploaded_file($_FILES[$field]);
                    if (!empty($ret)) {
                        $this->upload_success_file[$field] = $ret;
                    }
                } else {
                    $this->error_flag = false;
                    array_push($this->error_stack, '文件上传失败，原因：字段名'.$field.'未设置');
                }
            } else {
                //未指定上传字段名，将接收所有文件
                foreach ($_FILES as $field => $upload) {
                    $ret = $this->_deal_uploaded_file($upload);
                    if ($ret) {
                        $this->upload_success_file[$field] = $ret;
                    }
                }
            }
        } else {
            $this->error_flag = false;
            array_push($this->error_stack, '文件上传上传，原因：未上传任何文件');
        }

        return $this->upload_success_file;
    }

    /**
     * 处理上传文件
     * @param array $field e.g. array('name' => '', 'type' => '', 'tmp_name' => '', 'error' => 0, 'size' => 100)
     * @return string|array
     */
    private function _deal_uploaded_file($field) {
        //数组上传域
        if (is_array($field['name'])) {
            $success = array();
            foreach ($field['error'] as $key => $err) {
                //上传失败的情况
                if ($err) {
                    $this->error_flag = false;
                    array_push($this->error_stack, '文件上传失败，文件名：'.$field['name'][$key].'；原因：'.$this->error_map[$err]);
                    continue;
                }
                if ($name = $this->_move_uploaded_file($field['name'][$key], $field['type'][$key], $field['tmp_name'][$key], $field['size'][$key])) {
                    $success[$key] = $name;
                }
            }
        } else {
            $success = '';
            if ($field['error']) {
                $this->error_flag = false;
                array_push($this->error_stack, '文件上传失败，文件名：'.$field['name'].'；原因：'.$this->error_map[$field['error']]);
            } else {
                if ($name = $this->_move_uploaded_file($field['name'], $field['type'], $field['tmp_name'], $field['size'])) {
                    $success = $name;
                }
            }
        }
        return $success;
    }

    /**
     * 移动文件到合适位置
     * @param string $name
     * @param string $type
     * @param string $tmp_name
     * @param int $size
     * @return bool|string
     */
    private function _move_uploaded_file($name, $type, $tmp_name, $size) {
        //重置文件上传允许标识
        $this->is_allow_upload = false;
        //判断文件是否被允许上传，函数内部将修改文件上传允许标识
        $this->_is_allow_upload($type, $this->upload_file_type);
        if (!$this->is_allow_upload) {
            //不被允许上传的文件直接返回
            $this->error_flag = false;
            array_push($this->error_stack, '文件上传失败，文件名：'.$name.'；原因：上传目录不存在，或不被允许的上传类型'.$type);
            return false;
        }
        //是否是上传过来的文件，而非系统文件
        if (!is_uploaded_file($tmp_name)) {
            $this->error_flag = false;
            array_push($this->error_stack, '文件上传失败，文件名：'.$name.'；原因：非上传接收文件');
            return false;
        }
        //生成文件名
        $filename       = $this->_generate_random_filename($name);
        $upload_info    = $this->curr_upload_config;//当前上传配置信息
        //开始移动文件，并判断失败情况
        if (!move_uploaded_file($tmp_name, $upload_info['dir'] .'/'.$filename)) {
            $this->error_flag = false;
            array_push($this->error_stack, '文件上传失败，文件名：'.$name.'；原因：无法移动临时文件');
            //原因很多，简单判断磁盘目录是否写满
            if ($size > disk_free_space($upload_info['dir'])) {
                //磁盘目录写满，触发错误
                trigger_error('磁盘空间不足', E_USER_ERROR);
            }
            return false;
        }
        //走到此处才算上传成功
        return $upload_info['path'].'/'.$filename;
    }

    /**
     * 生成随机文件名，原有文件后缀
     */
    private function _generate_random_filename($name) {
        $tmp        = explode('.', $name);
        $extension  = array_pop($tmp);//获取文件拓展名

        list($usec, $sec) = explode(" ", microtime());
        $md5        = strtoupper(md5($usec.$sec));
        $filename   = substr($md5, 0, 8).'-'.substr($md5, 10, 4).'-'.mt_rand(1000, 9999).'-'.substr($md5, 20, 12);

        return $filename.'.'.$extension;
    }

    /**
     * 获取错误信息栈
     * @return array
     */
    public function getErrorStack() {
        return $this->error_stack;
    }

    /**
     * 获取错误标识
     * @return bool
     */
    public function getErrorFlag() {
        return $this->error_flag;
    }

    /**
     * 判断类型是否允许上传，引入递归
     * @param $type
     * @param $upload_type
     * @return bool
     */
    private function _is_allow_upload($type, $upload_type) {
        //单类型
        if (is_array($upload_type)) {
            foreach ($upload_type as $each) {
                $this->_is_allow_upload($type, $each);
            }
        } else if (is_string($upload_type)) {
            $path_info   = explode('|', $upload_type);
            $path_info   = is_array($path_info) && count($path_info) == 2 ? $path_info : explode('|', self::UPLOAD_FILE_TYPE);

            //组装配置信息
            if (isset($this->upload_file_config[$path_info[0]][$path_info[1]])) {
                $upload_info = $this->upload_file_config[$path_info[0]][$path_info[1]];
            } else {
                $upload_info = array(
                    'dir'       => PLUM_DIR_UPLOAD . '/' .implode('/', $path_info),
                    'path'      => PLUM_PATH_UPLOAD . '/' .implode('/', $path_info),
                    'default'   => self::UPLOAD_FILE_FAIL,//上传失败时的默认文件
                    'allow'     => explode('|', self::UPLOAD_FILE_ALLOW),//默认允许的MIME类型
                );
            }
            //文件夹不存在时
            if (!file_exists($upload_info['dir'])) {
                //递归地创建目录，并赋予775权限，拥有者/用户组可写
                if (!mkdir($upload_info['dir'], 0775, true)) {
                    //创建失败，触发错误并返回
                    trigger_error('上传目录创建失败', E_USER_ERROR);
                    return false;
                }
            }
            //检查上传目录是否可写
            if (!is_writable($upload_info['dir'])) {
                //更改目录的权限
                if (!chmod($upload_info['dir'], 0775)) {
                    //更改权限失败，触发错误并返回
                    trigger_error('上传目录不可写', E_USER_ERROR);
                    return false;
                }
            }
            //判断是否是允许的MIME类型
            if (!in_array($type, $upload_info['allow'])) {
                trigger_error('不支持的文件上传类型：'.$type, E_USER_WARNING);
            } else {
                //走到此处的才被允许上传
                $this->is_allow_upload      = true;
                $this->curr_upload_config   = $upload_info;
                return true;
            }
        }
        return false;
    }
}