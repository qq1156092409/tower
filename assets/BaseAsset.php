<?php
namespace app\assets;
use yii\web\AssetBundle;

class BaseAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web/js';
    public $js=[
        "yii.form.js",
        "baidu_static.js",
    ];
    public $depends=[
        'yii\web\YiiAsset',
    ];
} 