<?php

namespace app\assets;
use yii\web\AssetBundle;

class JqueryFileUploadAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web/plugins/jqueryFileUpload';
    public $js=[
        //blueimp
        'js/blueimp/canvas-to-blob.min.js',
        'js/blueimp/jquery.blueimp-gallery.min.js',
        'js/blueimp/load-image.all.min.js',
        'js/blueimp/tmpl.min.js',
        //file upload
        'js/jquery.iframe-transport.js',
        'js/jquery.fileupload.js',
//        'js/jquery.fileupload-angular.js',
        'js/jquery.fileupload-process.js',
        'js/jquery.fileupload-audio.js',
        'js/jquery.fileupload-image.js',
        'js/jquery.fileupload-jquery-ui.js',
        'js/jquery.fileupload-ui.js',
        'js/jquery.fileupload-validate.js',
        'js/jquery.fileupload-video.js',
//        'js/main.js',
    ];
    public $css=[
        "css/jquery.fileupload.css",
        "css/jquery.fileupload-ui.css",
    ];
    public $depends=[
        'app\assets\JqueryUIAsset',
    ];
}