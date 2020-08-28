<?php
//自定义
return array(
    'default'   => array(
        'host'      => "127.0.0.1",
        'remotehost' => "114.116.53.61",
        'port'      => "3306",
        'user'      => "zufang",
        'pass'      => "zufang12306",
        'dbname'    => "zufang",
        'tablepre'  => 'pre_',
    ),
    'test:default'  => array(
        'host'      => "127.0.0.1",
        'port'      => "3306",
        'user'      => "zufang",
        'pass'      => "zufang12306",
        'dbname'    => "zufang",
        'tablepre'  => 'pre_',
    ),
    'drupal'    => array(
        'database' 	=> 'zufang',
        'username' 	=> 'zufang',
        'password' 	=> 'zufang12306',
        'host' 		=> '127.0.0.1',
        'port' 		=> '3306',
        'driver' 	=> 'mysql',
        'prefix' 	=> 'dpl_',
    ),
    'test:drupal'    => array(
        'database' 	=> 'zufang',
        'username' 	=> 'zufang',
        'password' 	=> 'zufang12306',
        'host' 		=> '127.0.0.1',
        'port' 		=> '3306',
        'driver' 	=> 'mysql',
        'prefix' 	=> 'dpl_',
    ),
);
