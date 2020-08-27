<?php

return array(
    'smarty'    => array(
        //限定符配置
        'left_delimiter'    => '<{',
        'right_delimiter'   => '}>',
        'auto_literal'      => true,    //限定符两边出现空格时，自动忽略解析
        //缓存及编译的相关配置
        'caching'           => 0,//缓存模式，可取值0,1,2
        'compile_check'     => 2,//编译检查模式，可取值0,1,2

        'template_dir'      => PLUM_DIR_APP . '/view/template',
//        'template_dir'      => array(
//            PLUM_DIR_APP . '/view',                 //元素0，索引0
//            PLUM_DIR_APP . '/smarty',               //元素1，索引1           $smarty->display('file:[1]foo.tpl'); {include file="file:[1]foo.tpl"}
//            'manage'    => PLUM_DIR_APP . '/manage' //元素2，索引'manage'    $smarty->display('file:[manage]foo.tpl');
//        ),
        'compile_dir'       => PLUM_DIR_APP . '/storage/compile',
        'cache_dir'         => PLUM_DIR_CACHE,
        //layout机制相关配置
        'use_layout'        => true,            //是否使用layout机制
        'layout_dir'        => '/layout',       //layout模板所在目录，相对template的目录路径
        'default_layout'    => 'default.tpl',   //默认layout模板文件名
        'layout_const'      => 'NACHO_CONTENT_FOR_LAYOUT',
        //配置文件相关配置
        'config_dir'        => PLUM_DIR_APP . '/view/config',
        'config_overwrite'  => true,            //默认为true，覆盖相同名称的变量
        //插件机制相关配置
        'plugins_dir'       => PLUM_DIR_APP . '/view/plugin',
    ),
);