<?php
use app\models\Task;
use yii\web\View;
use app\components\JsManager;
/**
 * @var $this View
 * @var $unFinishTasks Task[]
 * @var $finishTasks Task[]
 */
$this->title = Yii::$app->user->identity->activeName . " 创建的任务";
JsManager::instance()->registers(["js/models/yii.task.js"]);
?>
<div class="container workspace simple-stack simple-stack-transition">
<div class="page page-root page-behind simple-pjax">
    <a href="<?=\yii\helpers\Url::to(["tasks","teamID"=>$teamID])?>" class="link-page-behind"
       data-stack=""><?= Yii::$app->user->identity->activeName ?></a>
</div>
<div class="page page-1 simple-pjax">
<div class="page-inner" data-page-name="<?= Yii::$app->user->identity->activeName ?> 创建的任务"
     id="page-member-created-todos">
<h3><?= Yii::$app->user->identity->activeName ?> 创建的任务</h3>

<div class="todolist">
<ul class="todos todos-uncompleted">
    <?php foreach($unFinishTasks as $task){
    echo $this->render("/commons/_task",["model"=>$task,"teamID"=>$teamID]);
    } ?>
</ul>

<ul id="task-completed-list" class="todos todos-completed">
<?php foreach($finishTasks as $task){
    echo $this->render("/commons/_task",["model"=>$task,"teamID"=>$teamID]);
} ?>
</ul>
</div>
    <a id="task-created-more" href="javascript:void(0)" class="link-more-created-todos" data-url="<?=\yii\helpers\Url::to(["more-finish-tasks","teamID"=>$teamID])?>">更多已完成任务</a>
    <img class="simple-tiny-loading" src="data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAAAICVAEAOw==" style="position:static;width:84px;height:15px;" />
</div>

</div>
</div>