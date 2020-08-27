<style>
	.breadcrumbs {
	    position: relative;
	    border-bottom: 1px solid #e5e5e5;
	    background-color: #f9f9f9;
	    min-height: 41px;
	    line-height: 40px;
	    padding: 10px 12px 10px 12px;
	    display: block;
   	}
   	.breadcrumb > li + li:before {
	    font-family: FontAwesome;
	    font-size: 14px;
	    content: "/";
	    color: #b2b6bf;
	    margin-right: 2px;
	    padding: 0 5px 0 2px;
	    position: relative;
	    top: 1px;
	}
	.breadcrumbs li img{
		display: inline-block;
		width:14px;
		height:14px;
		margin-top:-4px;
	}
	.breadcrumbs li a{
		color:#999;
	}
	.breadcrumbs li:hover a{
		color:#0077DD;
	}
</style>
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>
	<div class="breadcrumbs-wrap" style="background-color:#fff;">
	    <ul class="breadcrumb">
	        <{foreach $bread_crumbs as $index => $item}>
	        <li>
	            <{if $index == 0}>
	            <!--<i class="icon-home home-icon"></i>-->
	            <img src="/public/wxapp/images/icon_home.png" alt="" />
	            <{/if}>
	            <a href="<{$item['link']}>"><{$item['title']}></a>
	        </li>
	        <{/foreach}>
	    </ul><!-- .breadcrumb -->
	</div>
</div>