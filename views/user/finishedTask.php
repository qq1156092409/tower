<?php
use app\models\Task;
use app\components\JsManager;
/**
 * @var $teamID int
 * @var $dayTasks Task[]
 * @var $startTime string
 */
JsManager::instance()->registers(["js/models/yii.task.js",]);
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax page-behind">
        <a class="link-page-behind" data-stack="" href="<?= \yii\helpers\Url::to(["tasks", "teamID" => $teamID])?>"><?=\Yii::$app->user->identity->activeName?></a>
    </div>
    <div class="page page-1 simple-pjax">
        <div class="page-inner" data-page-name="<?=\Yii::$app->user->identity->activeName?> 已完成的任务" id="page-member-completed-todos">
            <h3><?=\Yii::$app->user->identity->activeName?> 已完成的任务</h3>
            <?php foreach($dayTasks as $day=>$itemTasks){
                echo $this->render("finishedTask_day",["day"=>$day,"itemTasks"=>$itemTasks,"teamID"=>$teamID]);
            } ?>
            <?php if($startTime){ ?>
            <a href="<?=\yii\helpers\Url::to(["","teamID"=>$teamID,"endTime"=>$startTime])?>" id="btn-load-more" class="task-finished-more" style="display: block;">加载更多内容</a>
            <?php } ?>
        </div>
    </div>
</div>