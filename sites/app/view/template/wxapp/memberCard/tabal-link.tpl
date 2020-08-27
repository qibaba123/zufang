<ul class="nav nav-tabs" id="myTab">
    <{foreach $tabLink as $key => $tal}>
    <{if $tabKey eq $key}>
    <li class="active">
        <a href="#tab1">
            <!-- <i class="green icon-<{$tal['icon']}> bigger-110"></i> -->
            <{$tal['name']}>
        </a>
    </li>
    <{else}>
    <li>
        <a href="<{$tal['link']}>">
            <!-- <i class="green icon-<{$tal['icon']}> bigger-110"></i> -->
            <{$tal['name']}>
        </a>
    </li>
    <{/if}>
    <{/foreach}>
</ul>