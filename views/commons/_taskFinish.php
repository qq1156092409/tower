<?php
use yii\helpers\Url;
use app\models\Task;
/**
 * @var $model Task
 * @var $teamID int
 */
$finishTime=date("n月j日",strtotime($model->lastOperation->create));
?>
<li id="task-<?=$model->id?>" class="todo completed" data-guid="0735c628b56c4f34b1df665d6391a8d6" data-sort="60416.0" data-sequence-mine="0.0"
    data-sort-url="/projects/aa98f7dace494574b9c3c5c56b9e5350/todos/0735c628b56c4f34b1df665d6391a8d6/reorder"
    data-project-guid="aa98f7dace494574b9c3c5c56b9e5350" data-project-name="_课堂-web"
    data-creator-guid="c24e8e36ccaf43b787229ff595efc41d" data-updated-at="1422601897" data-closed-at="1422601897">
    <div class="todo-actions actions">
        <div class="inr">
            <a href="https://tower.im/projects/aa98f7dace494574b9c3c5c56b9e5350/todos/0735c628b56c4f34b1df665d6391a8d6/destroy"
               data-visible-to="creator,admin" class="del" data-remote="true"
               data-cf="确定要删除这条任务吗？" title="删除">删除</a>
        </div>
    </div>
    <div class="todo-wrap">
        <div class="simple-checkbox checked" style="height: 16px; width: 16px;">
            <div class="checkbox-container btn-task-open" style="border: 1.6px solid;" data-url="<?=Url::to(["/task/open","id"=>$model->id])?>">
                <div class="checkbox-tick"
                     style="border-right-width: 2.24px; border-right-style: solid; border-bottom-width: 2.24px; border-bottom-style: solid;">
                </div>
            </div>
            <input type="checkbox" name="todo-done" checked="" class="checkbox-input" style="display: none;"></div>
        <span class="todo-content">
            <span class="raw"><?=$model->name?></span>
            <span class="content-non-linkable">
                <span class="todo-rest" title="<?=$model->name?>"><?=$model->name?></span>
            </span>
            <span class="content-linkable">
                <a href="<?=$model->getViewUrl()?>"
                   class="todo-rest" data-stack="true" title="<?=$model->name?>"><?=$model->name?></a>
            </span>
        </span>
        <span class="label completed-member">( <?=$model->user->activeName?> <span class="completed-time"
                                                                                  data-readable-time="2015-01-30T15:11:37+08:00"><?=$finishTime?></span> )</span>
        <a href="https://tower.im/projects/aa98f7dace494574b9c3c5c56b9e5350" class="label todo-proj"
           data-stack-root="true" data-stack="true" title="_课堂-web - 未名课堂2.0">_课堂-web - 未名课堂2.0</a>
    </div>
</li>