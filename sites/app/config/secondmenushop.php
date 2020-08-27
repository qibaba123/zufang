<?php

/*
 * 页面内二级菜单数组
 * key 为shop.php中侧边栏的链接
 * value 为除shio.php侧边栏链接外其它页面的链接
 */


return array(
    //配送
    '/delivery/index'    => array(
        '/delivery/sendCfg',
    ),
    //云打印机
    '/print/feieList'    => array(
        '/print/ticketPrintSet',
    ),


);