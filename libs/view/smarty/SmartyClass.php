<?php
/**
 * @author thomas<thomas@ikinvin.com>
 * @since 2014-03-28
 */
require_once 'libs/Smarty.class.php';

class Libs_View_Smarty_SmartyClass extends Smarty{
    /*
     * layout机制相关变量
     */
    private $_use_layout_   = true;
    private $_layout_dir_   = '/layout';
    private $_layout_       = 'default.tpl';
    private $_layout_const_ = 'NACHO_CONTENT_FOR_LAYOUT';

    public function __construct() {
        parent::__construct();
        $this->_initSmarty();
    }

    /**
     * 显示模板资源
     * @param string $tpl
     * @param mixed $cache_id
     * @param mixed $compile_id
     * @param mixed $use_layout 是否使用layout机制，可为null || false || true || string
     */
    public function display($tpl, $cache_id = null, $compile_id = null, $use_layout = null) {
        //处理use_layout参数
        if (is_bool($use_layout)) {
            $this->_use_layout_ = $use_layout;
        } else if (is_string($use_layout)) {
            $this->_use_layout_ = true;
            $this->_layout_     = $use_layout;
        }
        //使用layout机制
        if ($this->_use_layout_) {
            $this->assign($this->_layout_const_, $tpl);

            $tpl = trim($this->_layout_dir_, '/') . '/' . $this->_layout_;
        }
        //调用Smarty原始函数
        parent::display($tpl, $cache_id, $compile_id);
    }

    /*
     * 更改默认layout文件
     */
    public function setLayout($layout) {
        $this->_layout_  = $layout;
    }

    /**
     * 初始化smarty模板信息
     */
    private function _initSmarty() {
        //获取smarty的配置信息
        $cfg = plum_parse_config('smarty', 'view');
        //layout机制相关配置
        $this->_use_layout_             = plum_check_array_key('use_layout', $cfg, $this->_use_layout_);
        $this->_layout_dir_             = plum_check_array_key('layout_dir', $cfg, $this->_layout_dir_);
        $this->_layout_const_           = plum_check_array_key('layout_const', $cfg, $this->_layout_const_);
        $this->_layout_                 = plum_check_array_key('default_layout', $cfg, $this->_layout_);
        //设置左右限定符
        $this->smarty->left_delimiter   = plum_check_array_key('left_delimiter', $cfg, '<{');
        $this->smarty->right_delimiter  = plum_check_array_key('right_delimiter', $cfg, '}>');

        $this->smarty->caching          = plum_check_array_key('caching', $cfg, Smarty::CACHING_OFF);
        $this->smarty->compile_check    = plum_check_array_key('compile_check', $cfg, Smarty::COMPILECHECK_CACHEMISS);
        //获取各配置目录
        $template_dir   = plum_check_array_key('template_dir', $cfg, PLUM_DIR_APP . '/view/template');
        $compile_dir    = plum_check_array_key('compile_dir', $cfg, PLUM_DIR_APP . '/storage/compile');
        $cache_dir      = plum_check_array_key('cache_dir', $cfg, PLUM_DIR_CACHE);
        $config_dir     = plum_check_array_key('config_dir', $cfg, PLUM_DIR_APP . '/view/config');
        $plugins_dir    = plum_check_array_key('plugins_dir', $cfg, PLUM_DIR_APP . '/view/plugin');

        $this->smarty->setTemplateDir($template_dir);
        $this->smarty->setCompileDir($compile_dir);
        $this->smarty->setCacheDir($cache_dir);
        $this->smarty->setConfigDir($config_dir);
        $this->smarty->setPluginsDir(array(SMARTY_DIR.'plugins', $plugins_dir));

        //判断模板编译目录是否存在
        if (!file_exists($compile_dir)) {
            //递归地创建目录，并赋予775权限，拥有者/用户组可写
            if (!mkdir($compile_dir, 0775, true)) {
                //创建失败，触发错误并返回
                trigger_error('模板编译目录创建失败', E_USER_ERROR);
                return null;
            }
        }

        //检查模板编译目录是否可写
        if (!is_writable($compile_dir)) {
            //更改目录的权限
            if (!chmod($compile_dir, 0775)) {
                //更改权限失败，触发错误并返回
                trigger_error('模板编译目录不可写', E_USER_ERROR);
                return null;
            }
        }

        //判断模板缓存目录是否存在
        if (!file_exists($cache_dir)) {
            //递归地创建目录，并赋予775权限，拥有者/用户组可写
            if (!mkdir($cache_dir, 0775, true)) {
                //创建失败，触发错误并返回
                trigger_error('模板缓存目录创建失败', E_USER_ERROR);
                return null;
            }
        }

        //检查模板缓存目录是否可写
        if (!is_writable($cache_dir)) {
            //更改目录的权限
            if (!chmod($cache_dir, 0775)) {
                //更改权限失败，触发错误并返回
                trigger_error('模板缓存目录不可写', E_USER_ERROR);
                return null;
            }
        }
    }
}