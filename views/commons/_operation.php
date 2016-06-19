<?php
use yii\web\View;
use app\models\Operation;
/**
 * @var $model Operation
 * @var $this View
 */
if($model->type==Operation::COMMENT){
    echo $this->render("_comment",["model"=>$model->with]);
}else{
    echo $this->render("_operationDefault",["model"=>$model]);
}