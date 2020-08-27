<?php
/**
 * 实现类机制自动加载
 */
/*
 *注册自动加载类的函数
 */
function _plum_auto_loader($classname) {
    $arr = explode('_', $classname);
    if ('libs' == strtolower($arr[0])) {
        $class = array_pop($arr);
        array_shift($arr);//移除前缀
        $path = '/'.strtolower(implode('/', $arr)).'/';
        if (!class_exists($classname)) {
            @include_once PLUM_DIR_LIB . $path . $class . '.php';
        }
    } else if ('app' == strtolower($arr[0])) {
        $class = array_pop($arr);
        array_shift($arr);//移除前缀
        $path = '/'.strtolower(implode('/', $arr)).'/';
        if (!class_exists($classname)) {
            @include_once PLUM_DIR_APP . $path. $class.'.php';
        }
    }
}
spl_autoload_register('_plum_auto_loader');