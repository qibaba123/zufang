<?php
/**
 * @author thomas<thomas@ikinvin.com>
 * @since 2014-03-28
 */
require_once 'libs/Smarty.class.php';
class Libs_View_Smarty_SmartyTool extends Smarty{

    public $output = array();

    public function __construct($template_dir) {
        parent::__construct();
        $this->_initSmarty($template_dir);
    }

    private function _initSmarty($template_dir) {
        $this->left_delimiter   = '<{';
        $this->right_delimiter  = '}>';

        $this->caching          = Smarty::CACHING_OFF;
        $this->compile_check    = Smarty::COMPILECHECK_CACHEMISS;

        $compile_dir    = PLUM_DIR_APP . '/storage/compile';
        $cache_dir      = PLUM_DIR_APP . '/storage/cache';

        $this->setTemplateDir($template_dir);
        $this->setCompileDir($compile_dir);
        $this->setCacheDir($cache_dir);

        if (!file_exists($compile_dir)) {
            mkdir($compile_dir, 755);
        }
        if (!file_exists($cache_dir)) {
            mkdir($cache_dir, 755);
        }
    }

    public function fetchSmarty($template) {
        foreach ($this->output as $name => $value) {
            $this->assign($name, $value);
        }
        return $this->fetch($template);
    }
}
