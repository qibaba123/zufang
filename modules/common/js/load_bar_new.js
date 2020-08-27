(function($){
    $(document).ready(function(){
        var request_uri     = $('#request-uri0').val(),
            file_type       = $('#file-type0').val(),
            upload_multi    = $('#upload-multi0').val();
        $('#file-upload0').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image0');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path0').val(ret.url);
                    console.log(ret.url);
                    console.log(789);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri1').val();
            file_type       = $('#file-type1').val();
            upload_multi    = $('#upload-multi1').val();
        $('#file-upload1').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image1');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path1').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri2').val();
            file_type       = $('#file-type2').val();
            upload_multi    = $('#upload-multi2').val();
        $('#file-upload2').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image2');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path2').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri3').val();
            file_type       = $('#file-type3').val();
            upload_multi    = $('#upload-multi3').val();
        $('#file-upload3').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image3');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path3').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri4').val();
        file_type       = $('#file-type4').val();
        upload_multi    = $('#upload-multi4').val();
        $('#file-upload4').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image4');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path4').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri5').val();
            file_type       = $('#file-type5').val();
            upload_multi    = $('#upload-multi5').val();
        $('#file-upload5').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image5');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path5').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri6').val();
            file_type       = $('#file-type6').val();
            upload_multi    = $('#upload-multi6').val();
        $('#file-upload6').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image6');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path6').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri7').val();
        file_type       = $('#file-type7').val();
        upload_multi    = $('#upload-multi4').val();
        $('#file-upload7').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image7');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path7').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri8').val();
        file_type       = $('#file-type8').val();
        upload_multi    = $('#upload-multi8').val();
        $('#file-upload8').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image8');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path8').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri9').val();
        file_type       = $('#file-type9').val();
        upload_multi    = $('#upload-multi9').val();
        $('#file-upload9').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image9');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path9').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri10').val();
        file_type       = $('#file-type10').val();
        upload_multi    = $('#upload-multi10').val();
        $('#file-upload10').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image10');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path10').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri11').val();
        file_type       = $('#file-type11').val();
        upload_multi    = $('#upload-multi11').val();
        $('#file-upload11').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image11');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path11').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri12').val();
        file_type       = $('#file-type12').val();
        upload_multi    = $('#upload-multi12').val();
        $('#file-upload12').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image12');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path12').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri13').val();
        file_type       = $('#file-type13').val();
        upload_multi    = $('#upload-multi13').val();
        $('#file-upload13').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image13');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path13').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri14').val();
        file_type       = $('#file-type14').val();
        upload_multi    = $('#upload-multi14').val();
        $('#file-upload14').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image14');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path14').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri15').val();
        file_type       = $('#file-type15').val();
        upload_multi    = $('#upload-multi15').val();
        $('#file-upload15').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image15');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path15').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri16').val();
        file_type       = $('#file-type16').val();
        upload_multi    = $('#upload-multi16').val();
        $('#file-upload16').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image16');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path16').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri17').val();
        file_type       = $('#file-type17').val();
        upload_multi    = $('#upload-multi17').val();
        $('#file-upload17').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image17');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path17').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri18').val();
        file_type       = $('#file-type18').val();
        upload_multi    = $('#upload-multi18').val();
        $('#file-upload18').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image18');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path18').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });
        request_uri     = $('#request-uri19').val();
        file_type       = $('#file-type19').val();
        upload_multi    = $('#upload-multi19').val();
        $('#file-upload19').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image19');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path19').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });

        request_uri     = $('#request-uri20').val();
        file_type       = $('#file-type20').val();
        upload_multi    = $('#upload-multi20').val();
        $('#file-upload20').uploadify({
            'formData'     : {
                'timestamp' : '222'
            },
            'fileObjName'   : 'uploadFile',
            'fileTypeExts'  : file_type,
            'buttonClass'   : 'btn btn-primary',
            'buttonText'    : '选择文件上传',
            'height'        : 40,
            'multi'         : upload_multi,
            'swf'           : '/modules/common/uploadify/uploadify.swf',
            'uploader'      : request_uri,
            'onUploadSuccess' : function(file, data, response) {
                var ret = $.parseJSON(data);
                if (ret.ec == 200) {
                    var image_field = $('#file-image20');
                    if (image_field) {
                        image_field.attr('src', ret.url);
                    }
                    $('#file-path20').val(ret.url);
                } else {
                    alert(ret.em);
                }
            }
        });

    });
})(jQuery);