<?php

namespace app\assets;
use yii\web\AssetBundle;

class ZeptoAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = 'http://apps.bdimg.com/libs/zepto/1.1.4';
    public $css = [
    ];
    public $js = [
        'zepto.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}