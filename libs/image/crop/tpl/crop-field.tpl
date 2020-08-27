<div class="container">
    <{if $multi_image}>
    <{foreach $image_array as $val}>
    <div class="avatar-view cropper-box" style="width: <{$crop_width}>px; height: <{$crop_height}>px;" title="<{$default_title}>">
        <img src="<{$val}>" alt="<{$default_title}>">
        <input type="hidden" id="avatar-field" class="avatar-field" name="<{$field_name}>" value="<{$val}>"/>
        <i class="icon-delete crop-delete"></i>
    </div>
    <{/foreach}>
    <{/if}>
    <!-- Current avatar -->
    <div class="avatar-view cropper-box" style="width: <{$crop_width}>px; height: <{$crop_height}>px;" title="<{$default_title}>">
        <img src="<{$default_image}>" alt="<{$default_title}>">
        <input type="hidden" class="avatar-field" name="<{$field_name}>" value="<{$default_image}>"/>
    </div>
</div>