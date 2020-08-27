<link href="<{$common_css_path}>/cropper.min.css" rel="stylesheet">
<link href="<{$common_css_path}>/crop-avatar.css" rel="stylesheet">
<div class="container" id="crop-avatar" style="display: none;">
    <!-- Cropping modal -->
    <div id="avatar-modal">
        <div class="modal-content" data-title="<{$default_title}>">
            <form class="avatar-form" action="<{$action_url}>" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <div class="avatar-body">
                        <!-- Upload image and data -->
                        <div class="avatar-upload">
                            <input class="avatar-src" name="avatar_src" type="hidden">
                            <input class="avatar-data" name="avatar_data" type="hidden">
                            <label for="avatarInput" style="height:35px;line-height: 35px;">本地上传</label>
                            <span class="upload-input">选择文件<input class="avatar-input" id="avatarInput" name="avatar_file" type="file"></span>
                        </div>
                        <!-- Crop and preview -->
                        <div class="crop-preview">
                            <div class="crop">
                                <div class="avatar-wrapper"></div>
                            </div>
                            <div class="preview">
                                <div style="margin: 0 auto;width: 184px;" class="avatar-preview preview-lg"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- /.modal -->
    <!-- Loading state -->
    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
</div>
<{if $load_jquery}>
<script src="<{$common_js_path}>/jquery-1.11.1.min.js"></script>
<{/if}>
<script src="/public/plugin/layer/layer.js"></script>
<script src="<{$common_js_path}>/cropper.min.js"></script>
<script>
    (function (factory) {
        if (typeof define === "function" && define.amd) {
            define(["jquery"], factory);
        } else {
            factory(jQuery);
        }
    })(function ($) {
        "use strict";
        var console = window.console || {log: $.noop};

        function CropAvatar($element) {
            this.$container = $element;
            this.$multiImage= parseInt('<{$multi_image}>');
            this.$aspectRatio   = parseFloat('<{$aspect_ratio}>');
            this.$previewWidth  = 184;
            //图片上传域
            this.$avatarView = $(".cropper-box");
            this.$avatar = this.$avatarView.find("img");
            this.$avatarField = this.$avatarView.find('input:hidden');

            this.$avatarModal = this.$container.find("#avatar-modal");
            this.$loading = this.$container.find(".loading");

            this.$avatarForm = this.$avatarModal.find(".avatar-form");
            this.$avatarUpload = this.$avatarForm.find(".avatar-upload");
            this.$avatarSrc = this.$avatarForm.find(".avatar-src");
            this.$avatarData = this.$avatarForm.find(".avatar-data");
            this.$avatarInput = this.$avatarForm.find(".avatar-input");
            this.$avatarSave = this.$avatarForm.find(".avatar-save");

            this.$avatarWrapper = this.$avatarModal.find(".avatar-wrapper");
            this.$avatarPreview = this.$avatarModal.find(".avatar-preview");

            this.init();
        }

        CropAvatar.prototype = {
            constructor: CropAvatar,

            support: {
                fileList: !!$("<input type=\"file\">").prop("files"),
                fileReader: !!window.FileReader,
                formData: !!window.FormData
            },

            init: function () {
                this.support.datauri = this.support.fileList && this.support.fileReader;

                if (!this.support.formData) {
                    this.initIframe();
                }

                //this.initTooltip();
                this.initModal();
                this.addListener();
            },

            addListener: function () {
                this.$avatarView.on("click", $.proxy(this.click, this));
                this.$avatarInput.on("change", $.proxy(this.change, this));
                this.$avatarForm.on("submit", $.proxy(this.submit, this));
            },

            initTooltip: function () {
                this.$avatarView.tooltip({
                    placement: "bottom"
                });
            },

            initModal: function () {
                //this.$avatarModal.modal("hide");
                this.initPreview();
            },

            initPreview: function () {
                var url = this.$avatar.attr("src");
                this.$avatarPreview.empty().html('<img src="' + url + '">');
                this.$previewHeight = Math.ceil(this.$previewWidth/this.$aspectRatio);
                this.$avatarPreview.css('width', this.$previewWidth).css('height', this.$previewHeight);
            },

            initIframe: function () {
                var iframeName = "avatar-iframe-" + Math.random().toString().replace(".", ""),
                        $iframe = $('<iframe name="' + iframeName + '" style="display:none;"></iframe>'),
                        firstLoad = true,
                        _this = this;

                this.$iframe = $iframe;
                this.$avatarForm.attr("target", iframeName).after($iframe);

                this.$iframe.on("load", function () {
                    var data,
                            win,
                            doc;
                    try {
                        win = this.contentWindow;
                        doc = this.contentDocument;

                        doc = doc ? doc : win.document;
                        data = doc ? doc.body.innerText : null;
                    } catch (e) {

                    }
                    if (data) {
                        _this.submitDone(data);
                    } else {
                        if (firstLoad) {
                            firstLoad = false;
                        } else {
                            _this.submitFail("Image upload failed!");
                        }
                    }

                    _this.submitEnd();
                });
            },

            click: function (ev) {
                console.log(ev);
                var that = this;
                this.$avatarModal = layer.open({
                    type: 1, //page层
                    area: '800px',
                    title: '图片上传',
                    offset : '100px',
                    shade: 0.6, //遮罩透明度
                    moveType: 1, //拖拽风格，0是默认，1是传统拖动
                    shift: -1, //0-6的动画形式，-1不开启
                    content: this.$container,
                    btn : ['保存', '取消'],
                    success : function () {
                        $('#crop-avatar').css('display', 'block');
                    },
                    yes : function() {
                        that.submit();
                    },
                    cancel : function() {
                        that.$avatarSrc.val("");
                        that.$avatarData.val("");
                        that.stopCropper();
                    }
                });
                //点击父类
                if ($(ev.target).hasClass('cropper-box')) {
                    this.$avatarView    = $(ev.target);
                } else {
                    //点击子类
                    this.$avatarView    = $(ev.target).parents('.cropper-box');
                }
                this.$avatar        = this.$avatarView.find('img');
                this.$avatarField   = this.$avatarView.find('input:hidden');
                this.$cropWidth     = this.$avatarView.data('width');
                this.$cropHeight    = this.$avatarView.data('height');
                this.$groupId       = this.$avatarView.data('groupid');
                this.$aspectRatio   = parseFloat(this.$cropWidth/this.$cropHeight);
                this.initPreview();
            },

            change: function () {
                var files,
                        file;
                if (this.support.datauri) {
                    files = this.$avatarInput.prop("files");
                    if (files.length > 0) {
                        file = files[0];
                        if (this.isImageFile(file)) {
                            this.read(file);
                        }
                    }
                } else {
                    file = this.$avatarInput.val();
                    if (this.isImageFile(file)) {
                        this.syncUpload();
                    }
                }
            },

            submit: function () {
                if (!this.$avatarSrc.val() && !this.$avatarInput.val()) {
                    return false;
                }
                if (this.support.formData) {
                    this.ajaxUpload();
                    return false;
                }
            },

            isImageFile: function (file) {
                if (file.type) {
                    return /^image\/\w+$/.test(file.type);
                } else {
                    return /\.(jpg|jpeg|png|gif)$/.test(file);
                }
            },

            read: function (file) {
                var _this = this,
                        fileReader = new FileReader();
                fileReader.readAsDataURL(file);
                fileReader.onload = function () {
                    _this.url = this.result;
                    _this.startCropper();
                };
                // 读取图片时获取图片大小，如果图片过大则提示
                if(document.getElementById('avatarInput').files[0] != undefined){
                    var fileSize = document.getElementById('avatarInput').files[0].size;  // 获取上传图片的大小单为B
                    fileSize = parseFloat((fileSize/(1024*1024)).toFixed(1));
                    if(fileSize>2){
                        layer.msg('图片过大，请将图片压缩至2M以内再上传');
                    }
                }
            },

            startCropper: function () {
                var _this = this;

                if (this.active) {
                    this.$img.cropper("replace", this.url);
                } else {
                    this.$img = $('<img src="' + this.url + '">');
                    this.$avatarWrapper.empty().html(this.$img);
                    this.$img.cropper({
                            aspectRatio: this.$aspectRatio,
                            preview: this.$avatarPreview.selector,
                            done: function (data) {
                                var json = [
                                    "{" + '"x":' + data.x,
                                    '"y":' + data.y,
                                    '"height":' + data.height,
                                    '"width":' + data.width + "}"
                                ].join();

                                _this.$avatarData.val(json);
                            }
                        });

                        this.active = true;
                    }
                },

                stopCropper: function () {
                    if (this.active) {
                        this.$img.cropper("destroy");
                        this.$img.remove();
                        this.active = false;
                    }
                },

                ajaxUpload: function () {
                    var url = this.$avatarForm.attr("action"),
                        data = new FormData(this.$avatarForm[0]),
                        _this = this;
                    url = url + "/w/"+this.$cropWidth+"/h/"+this.$cropHeight+"/groupid/"+this.$groupId;
                    if(document.getElementById('avatarInput').files[0] != undefined){
                        var fileSize = document.getElementById('avatarInput').files[0].size;  // 获取上传图片的大小单为B
                        fileSize = parseFloat((fileSize/(1024*1024)).toFixed(1));
                        if(fileSize>2){
                            layer.msg('图片过大，请将图片压缩至2M以内再上传');
                            return false;
                        }
                    }
                    $.ajax(url, {
                        type: "post",
                        data: data,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            _this.submitStart();
                        },
                        success: function (data) {
                            _this.submitDone(data);
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            _this.submitFail(textStatus || errorThrown);
                        },
                        complete: function () {
                            _this.submitEnd();
                        }
                    });
                },

                syncUpload: function () {
                    this.$avatarSave.click();
                },

                submitStart: function () {
                    this.$loading.fadeIn();
                },

                submitDone: function (data) {
                    console.log(data);
                    try {
                        data = $.parseJSON(data);
                    } catch (e) {

                    }
                    if (data && data.state === 200) {
                        if (data.result) {
                            this.url = data.result;
                            if (this.support.datauri || this.uploaded) {
                                this.uploaded = false;
                                this.cropDone();
                            } else {
                                this.uploaded = true;
                                this.$avatarSrc.val(this.url);
                                this.startCropper();
                            }
                            this.$avatarInput.val("");
                            if(typeof onImageChange == 'function'){
                                onImageChange();
                            }
                        } else if (data.message) {
                            this.alert(data.message);
                        }
                    } else {
                        this.alert("Failed to response");
                    }
                },

                submitFail: function (msg) {
                    this.alert(msg);
                },

                submitEnd: function () {
                    this.$loading.fadeOut();
                },

                cropDone: function () {
                    this.$avatarSrc.val("");
                    this.$avatarData.val("");
                    this.$avatar.attr("src", this.url);
                    this.$avatarField.val(this.url);
                    this.stopCropper();
                    layer.close(this.$avatarModal);
                    if (this.$multiImage) {
                        this.clone();
                    }
                },
                clone: function() {
                    var     imgPath         = '<{$default_image}>',
                            avatarViewClone = this.$avatarView.clone(true);
                    avatarViewClone.find('img').attr('src', imgPath);
                    avatarViewClone.find('input').val(imgPath);
                    this.$avatarView.find('input').after('<i class="crop-delete icon-delete-act"></i>');
                    this.$avatarView.parent().append(avatarViewClone);
                },

                alert: function (msg) {
                    var $alert = [
                        '<div class="alert alert-danger avater-alert">',
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>',
                        msg,
                        '</div>'
                    ].join("");
                    this.$avatarUpload.after($alert);
                }
            };
            $.CropAvatar = CropAvatar;
            $(function () {
                new CropAvatar($("#crop-avatar"));
                $('.avatar-view').on('click', '.crop-delete', function(ev) {
                    ev.stopPropagation();
                    $(ev.target).parent().remove();
                });
            });
        });
</script>