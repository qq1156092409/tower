<?php
namespace app\assets;
use yii\web\AssetBundle;

class FileInputAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web/plugins/bootstrap-fileinput';
    public $js=[
        //plugins
        "js/plugins/canvas-to-blob.min.js",
        //js
        "js/fileinput.min.js",
        "js/fileinput_locale_zh.js",
    ];
    public $css=[
        "css/fileinput.min.css",
    ];
    public $depends=[
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}