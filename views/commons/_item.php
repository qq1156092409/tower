<?php
use app\models\Item;
use yii\web\View;
/**
 * @var $model Item
 * @var $this View
 */
echo $this->render($model->deleted?"/commons/_itemDisable":"/commons/_itemEnable",[
    "model"=>$model,
    "process"=>$process,
]);