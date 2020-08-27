<?php

return array(
    /**
     * 上传文件类型，及对应目录，仅支持两层目录，如image/avatar
     * 需要上传的文件夹需要在此处配置，否则上传到默认文件夹image/gallery，并按图片类型处理
     */
    'type'  => array(
        'cert'      => array(
            'pem'   => array(
                'dir'       => PLUM_DIR_UPLOAD . '/cert/pem',
                'path'      => PLUM_PATH_UPLOAD . '/cert/pem',
                'allow'     => array(
                    'application/x-x509-ca-cert',
                    'application/octet-stream',
                ),//该目录下允许上传的文件MIME类型
            ),
        ),
        'image'     => array(
            //头像
            'avatar'    => array(
                'dir'       => PLUM_DIR_UPLOAD . '/image/avatar',
                'path'      => PLUM_PATH_UPLOAD . '/image/avatar',
                'default'   => '/public/common/img/info.gif',//上传失败时的默认文件
                'allow'     => array(
                    'image/jpeg', 'image/png', 'image/gif'
                ),//该目录下允许上传的文件MIME类型
            ),
            //缩略图
            'thumbnail' => array(
                'dir'       => PLUM_DIR_UPLOAD . '/image/thumbnail',
                'path'      => PLUM_PATH_UPLOAD . '/image/thumbnail',
                'default'   => '',
                'allow'     => array(
                    'image/jpeg', 'image/png', 'image/gif',
                ),
            ),
            //图片默认文件
            'gallery' => array(
                'dir'       => PLUM_DIR_UPLOAD . '/image/gallery',
                'path'      => PLUM_PATH_UPLOAD . '/image/gallery',
                'default'   => '',
                'allow'     => array(
                    'image/jpeg', 'image/png', 'image/gif',
                ),
            ),
        ),
        'media'     => array(
            //音频文件
            'audio'     => array(
                'dir'       => PLUM_DIR_UPLOAD . '/media/audio',
                'path'      => PLUM_PATH_UPLOAD . '/media/audio',
                'default'   => '',
                'allow'     => array(
                    'audio/mpeg', 'audio/midi', 'audio/ogg', 'audio/mp4', 'audio/wav', 'audio/x-ms-wma',
                ),
            ),
            //视频文件
            'video'     => array(
                'dir'       => PLUM_DIR_UPLOAD . '/media/video',
                'path'      => PLUM_PATH_UPLOAD . '/media/video',
                'default'   => '',
                'allow'     => array(
                    'video/x-msvideo', 'video/mp4', 'video/mpeg', 'video/quicktime', 'video/x-ms-wmv', 'video/x-flv', 'video/x-matroska',
                ),
            ),
        ),
        'document'  => array(
            //批量发货文件 ，只允许上传csv类型的文件
            'deliver'   => array(
                'dir'       => PLUM_DIR_UPLOAD . '/document/deliver',
                'path'      => PLUM_PATH_UPLOAD . '/document/deliver',
                'default'   => '',
                'allow'     => array(
                    'application/vnd.ms-excel',
                ),
            ),
            //办公文件
            'office'   => array(
                'dir'       => PLUM_DIR_UPLOAD . '/document/office',
                'path'      => PLUM_PATH_UPLOAD . '/document/office',
                'default'   => '',
                'allow'     => array(
                    'application/vnd.ms-word', 'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
                    'application/octet-stream',
                    'application/vnd.ms-powerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/vnd.openxmlformats-officedocument.presentationml.template',
                    'application/pdf',
                ),
            ),
            //归档文件
            'archive'   => array(
                'dir'       => PLUM_DIR_UPLOAD . '/document/archive',
                'path'      => PLUM_PATH_UPLOAD . '/document/archive',
                'default'   => '',
                'allow'     => array(
                    'application/x-gzip',
                    'application/x-bzip2',
                    'application/zip',
                    'application/x-rar',
                    'application/x-tar',
                    'application/x-7z-compressed',
                ),
            ),
            //源代码文件
            'source'   => array(
                'dir'       => PLUM_DIR_UPLOAD . '/document/source',
                'path'      => PLUM_PATH_UPLOAD . '/document/source',
                'default'   => '',
                'allow'     => array()
            ),
            //其他文件
            'default'   => array(
                'dir'       => PLUM_DIR_UPLOAD . '/document/default',
                'path'      => PLUM_PATH_UPLOAD . '/document/default',
                'default'   => '',
                'allow'     => array()
            ),
        ),
    ),
);