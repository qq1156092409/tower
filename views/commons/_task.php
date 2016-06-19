<?php
use app\models\Task;
/**
 * @var $model Task
 * @var $hasEdit bool
 */
if($model->status==Task::FINISHED){
    $view="/commons/_taskFinish";
}else{
    $view="/commons/_taskUnFinish";
}
echo $this->render($view,["model"=>$model,"hasEdit"=>$hasEdit]);