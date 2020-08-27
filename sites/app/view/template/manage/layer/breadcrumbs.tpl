<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
        <{foreach $bread_crumbs as $index => $item}>
        <li>
            <{if $index == 0}>
            <i class="icon-home home-icon"></i>
            <{/if}>
            <a href="<{$item['link']}>"><{$item['title']}></a>
        </li>
        <{/foreach}>
    </ul><!-- .breadcrumb -->

</div>