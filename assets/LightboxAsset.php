<?php
namespace app\assets;

use yii\web\AssetBundle;

class LightboxAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web/plugins/lightbox2/src';
    public $js=[
        "js/lightbox.js",
    ];
    public $css=[
        "css/lightbox.css"
    ];
    public $depends=[
        'yii\web\JqueryAsset',
    ];
} 