<?php
use app\models\Project;
use app\models\Task;
use app\models\UserLog;
use yii\web\View;
use app\components\JsManager;
/**
 * @var Project[] $projects;
 * @var Task[] $tasks;
 * @var $userLog UserLog;
 * @var $this View
 */

$this->title=\Yii::$app->user->identity->activeName;
$this->params["active"]=6;
JsManager::instance()->registers([
    "js/yii.time.js",
    "js/models/yii.task.js",
]);
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax">
        <div class="page-inner page-member" id="page-member" data-guid="c24e8e36ccaf43b787229ff595efc41d"
             data-since="2015-01-31 08:18:04 UTC" data-page-name="邓健强" data-self="true">
            <?=$this->render("_top",["teamID"=>$teamID,"userLog"=>$userLog])?>
            <p class="page-tips moveout inbox-moveout"></p>

            <div class="member-section member-todos">
                <select id="project-filter" class="task-filter-project">
                    <option value="-1">所有项目</option>
                    <?php foreach($projects as $project){ ?>
                        <option value="<?=$project->id?>"><?=$project->name?></option>
                    <?php } ?>
                </select>
                <div class="boxes" data-sort-url="/members/c24e8e36ccaf43b787229ff595efc41d/sort_todo">
                    <?php foreach (\app\models\Task::box() as $id => $box) { ?>
                        <div class="box box-<?= $box["name"]?> <?=(isset($tasks[$id])&&count($tasks[$id])>0)?"":"empty"?>" data-box="<?= $id ?>">
                            <h5 class="box-title"><i class="twr <?=$box["iconClass"]?>"></i><?=$box["chinese"]?></h5>
                            <p class="box-empty-desc"><?= $box["emptyText"] ?></p>
                            <div class="todolist">
                                <ul class="todos todos-uncompleted ui-sortable">
                                    <?php if(isset($tasks[$id])){foreach($tasks[$id] as $task){
                                        echo $this->render("/commons/_task",["model"=>$task,"teamID"=>$teamID,"hasEdit"=>true]);
                                    }} ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="more">
                    <a href="<?=\yii\helpers\Url::to(["finished-tasks","teamID"=>$teamID])?>" data-stack="true">查看已完成任务</a>
                    <a href="<?=\yii\helpers\Url::to(["created-tasks","teamID"=>$teamID])?>" data-stack="true">查看创建任务</a>
                </div>
            </div>


        </div>
    </div>
</div>