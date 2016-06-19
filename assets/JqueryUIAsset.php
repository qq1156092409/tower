<?php
namespace app\assets;
use yii\web\AssetBundle;

class JqueryUIAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web/plugins/jquery-ui-1.10.4.custom';
    public $js=[
        "js/jquery-ui-1.10.4.custom.min.js",
    ];
    public $css=[
//        "css/ui-lightness/jquery-ui-1.10.4.custom.min.css"
    ];
    public $depends=[
        'yii\web\JqueryAsset',
    ];
}