<?php
use yii\web\View;
use \app\assets\SimditorAsset;
use app\components\JsManager;
/**
 * @var $this View
 */
JsManager::instance()->registers(["js/yii.simditor.js"]);
?>
<h1>simditor</h1>
<textarea id="editor" placeholder="这里输入内容.." autofocus></textarea>