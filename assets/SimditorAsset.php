<?php
namespace app\assets;
use yii\web\AssetBundle;

class SimditorAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web/plugins/simditor';
    public $js=[
        "scripts/module.js",
        "scripts/hotkeys.js",
        "scripts/uploader.js",
        "scripts/simditor.js",
        "scripts/simditor-dropzone.js",
        "scripts/simditor-autosave.js",
        "scripts/simditor-emoji.js",
    ];
    public $css=[
        //使用application.css
//        "styles/simditor.css",
//        "styles/simditor-emoji.css",
    ];
    public $depends=[
        'yii\web\YiiAsset',
    ];
}