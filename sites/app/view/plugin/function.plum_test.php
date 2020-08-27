<?php
/**
 * 自定义Smarty插件
 */

/**
 * Smarty 梅雨CMS测试函数插件
 *
 * Type:     function
 * Name:     梅雨CMS测试
 * Date:     2016-01-29
 * Purpose:  输出plum测试值
 * 模板中使用 <{plum_test}>
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string|null
 */

function smarty_function_plum_test($params, Smarty_Internal_Template $template) {
    return 'plum_test';
}
