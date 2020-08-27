<div class="navbar-header pull-right" role="navigation">
    <ul class="nav ace-nav">
        <!--
        <li class="grey">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                任务
                <span class="badge badge-grey">4</span>
            </a>

            <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                <li class="dropdown-header">
                    <i class="icon-ok"></i>
                    还有4个任务完成
                </li>

                <li>
                    <a href="#">
                        <div class="clearfix">
                            <span class="pull-left">软件更新</span>
                            <span class="pull-right">65%</span>
                        </div>

                        <div class="progress progress-mini ">
                            <div style="width:65%" class="progress-bar "></div>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <div class="clearfix">
                            <span class="pull-left">硬件更新</span>
                            <span class="pull-right">35%</span>
                        </div>

                        <div class="progress progress-mini ">
                            <div style="width:35%" class="progress-bar progress-bar-danger"></div>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <div class="clearfix">
                            <span class="pull-left">单元测试</span>
                            <span class="pull-right">15%</span>
                        </div>

                        <div class="progress progress-mini ">
                            <div style="width:15%" class="progress-bar progress-bar-warning"></div>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <div class="clearfix">
                            <span class="pull-left">错误修复</span>
                            <span class="pull-right">90%</span>
                        </div>

                        <div class="progress progress-mini progress-striped active">
                            <div style="width:90%" class="progress-bar progress-bar-success"></div>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="#">
                        查看任务详情
                        <i class="icon-arrow-right"></i>
                    </a>
                </li>
            </ul>
        </li>
        -->
        <li class="purple">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                通知
                <span class="badge badge-important"><{$sys_event_count}></span>
            </a>
            <ul class="pull-right dropdown-navbar navbar-green dropdown-menu dropdown-caret dropdown-close" style="top:96%;">
                <li class="dropdown-header">
                    <i class="icon-warning-sign"></i>
                    <{$sys_event_count}>条通知
                </li>
                <{if $sys_event}>
                <{foreach $sys_event as $item}>
                <li>
                    <a href="<{$item['sn_link']}>" target="_blank">
                        <div class="clearfix">
                            <span class="pull-left gonggao-list"><{$item['se_title']}></span>
                        </div>
                    </a>
                </li>
                <{/foreach}>
                <{else}>
                <li  style="text-align:center;font-size:12px;color:#999;border-bottom: 1px solid #eee;height:40px;line-height:40px;">
                    <span>暂无更多通知~</span>
                </li>
                <{/if}>

                <li>
                    <a href="/manage/system/event">
                        查看所有通知
                        <i class="icon-arrow-right"></i>
                    </a>
                </li>
            </ul>
        </li>

        <li class="purple">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                公告
            </a>
            <ul class="pull-right dropdown-navbar navbar-blue dropdown-menu dropdown-caret dropdown-close" style="top:96%;">
                <li class="dropdown-header">
                    <i class="icon-warning-sign"></i>
                    系统公告&产品动态
                </li>
                <{if $sys_notice}>
                <{foreach $sys_notice as $item}>
                <li>
                    <a href="<{$item['sn_link']}>" target="_blank">
                        <div class="clearfix">
                            <span class="pull-left gonggao-list"><{$item['sn_title']}></span>
                        </div>
                    </a>
                </li>
                <{/foreach}>
                <{else}>
                <li style="text-align:center;font-size:12px;color:#999;border-bottom: 1px solid #eee;height:40px;line-height:40px;">
                    <span>暂无更多公告~</span>
                </li>
                <{/if}>
                <li>
                    <a href="/manage/system/notice">
                        查看所有公告
                        <i class="icon-arrow-right"></i>
                    </a>
                </li>
            </ul>
        </li>

        <li class="light-blue">
            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                <img class="nav-user-photo" onerror="showDefaultImg('shopLogo')" src="<{if $shopRow['s_logo']}><{$shopRow['s_logo']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" style="display: inline-block;height: 40px;width: 40px;margin-top: -2px"/>
                <span class="user-info" style="text-align: center;">
                    <small><{$shopRow['s_name']}></small>
                    <span style="line-height: 1.8;font-size: 14px;">设置</span>
                </span>
                <i class="icon-caret-down"></i>
            </a>

            <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                <li>
                    <a href="/manage/guide/index">
                        <i class="icon-cog"></i>
                        切换店铺
                    </a>
                </li>

                <li>
                    <a href="/manage/manager/personal">
                        <i class="icon-user"></i>
                        账号设置
                    </a>
                </li>

                <li class="divider"></li>

                <li>
                    <a href="/manage/user/logout">
                        <i class="icon-off"></i>
                        退出
                    </a>
                </li>
            </ul>
        </li>
    </ul><!-- /.ace-nav -->
</div><!-- /.navbar-header -->