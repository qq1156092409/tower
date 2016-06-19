<?php
use yii\helpers\Url;
use app\models\Item;
/**
 * @var $model Item
 * @var $process bool
 */
$request = Yii::$app->request;
?>
<div id="item-<?= $model->id ?>" class="todolist item">
    <div class="title">
        <div class="todolist-actions actions">
            <div class="inr">
                <a href="<?= Url::to(["/item/toggle-archive", "id" => $model->id]) ?>"
                   class="archive btn-item-toggle-archive" data-loading="true" data-remote="true"
                   title="归档（请确认清单内任务都已完成）">归档</a>
                <a href="/projects/32b8fcd2b0f4438d8417277049491664/lists/9c1437b87c1a51222fabac50ae77c321/edit"
                   class="edit" data-remote="true" data-loading="true" data-mothod="get" title="编辑">编辑</a>
                <a href="<?= Url::to(["/item/disable", "id" => $model->id]) ?>" data-visible-to="admin,creator"
                   class="del btn-item-disable" data-cf="确定要删除这个任务清单吗？" title="删除任务清单">删除</a>
            </div>
        </div>

        <h4>
    <span class="name-non-linkable">
        <span class="todolist-rest"><?=$model->name?></span>
    </span>
    <span class="name">
        <a href="<?= $model->getViewUrl() ?>"
           class="todolist-rest" data-stack="true"><?=$model->name?></a>
    </span>
            <a href="javascript:;" class="fold">
                <i class="twr twr-angle-up"></i>
            </a>
        </h4>
        <?php if($process){
            $count1=$model->countFinishedTask();
            $count2=$model->countEnableTask();
            ?>
            <div class="progress">
                <div class="bar">
                    <div class="inner-bar" style="width:<?=$count2?(100*$count1/$count2):0?>%"></div>
                </div>
                <span class="count"><span class="count1"><?=$count1?></span>/<span class="count2"><?=$count2?></span></span>
            </div>
        <?php } ?>
        <?php if ($model->description) { ?>
            <p class="desc"><?= $model->description ?></p>
        <?php } ?>
    </div>
    <div class="todolist-form edit" style="display: none;">
        <form id="form-item-edit" class="form" method="post"
              action="<?= Url::to(["item/edit", "itemID" => $model->id]) ?>" data-remote="true">
            <?= \yii\helpers\Html::hiddenInput($request->csrfParam, $request->getCsrfToken()) ?>
            <input id="item-name" type="text" class="todolist-name no-border" value="<?= $model->name ?>"
                   name="Item[name]" placeholder="任务清单名称" data-validate="custom" data-validate-msg="">
            <textarea class="todolist-desc no-border" name="Item[description]" placeholder="补充说明（可选）"
                      style="overflow: hidden; word-wrap: break-word; resize: none; height: 18px;"><?= $model->description ?></textarea>

            <p class="form-buttons">
                <button type="submit" class="btn btn-update-todolist btn-primary" data-disable-with="正在保存...">保存
                </button>
                <button type="button" class="btn btn-x btn-cancel-update-todolist">取消</button>
            </p>
        </form>
    </div>

    <ul class="todos todos-uncompleted ui-sortable">
        <?php foreach ($model->commonTasks as $task) {
            echo $this->render("/commons/_task", ["model" => $task, "teamID" => $teamID]);
        } ?>
    </ul>

    <ul class="todo-new-wrap">
        <li class="todo-form new" style="display: none">
            <form class="form form-create-task" method="post" data-remote="true"
                  action="<?= \yii\helpers\Url::to(["task/create"]) ?>">
                <?= \yii\helpers\Html::hiddenInput($request->csrfParam, $request->getCsrfToken()) ?>
                <input type="hidden" name="Task[itemID]" value="<?= $model->id ?>"/>
                <input type="hidden" name="Task[userID]"/>
                <input type="hidden" name="Task[endTime]"/>

                <div class="form-body">
                    <div class="simple-checkbox disabled" style="height: 16px; width: 16px;">
                        <div class="checkbox-container" style="border: 1.6px solid;">
                            <div class="checkbox-tick"
                                 style="border-right-width: 2.24px; border-right-style: solid; border-bottom-width: 2.24px; border-bottom-style: solid;">
                            </div>
                        </div>
                        <input type="checkbox" name="todo-done" disabled="" class="checkbox-input"
                               style="display: none;"></div>
                    <textarea name="Task[name]" class="todo-content no-border" placeholder="新的任务" data-validate="custom"
                              data-validate-msg="" data-autosave="list-4beca07e8893425d8b08d77ed524f91e-new-todo"
                              style="overflow: hidden; word-wrap: break-word; resize: none; height: 24px;"></textarea>
                    <a href="javascript:;" class="todo-label btn-assign">
                        <span class="assignee">未指派</span> ·
                        <span class="due">没有截止时间</span>
                    </a>
                </div>
                <div class="buttons create-buttons">
                    <button type="submit" class="btn btn-primary btn-create-todo" data-disable-with="正在保存...">添加任务
                    </button>
                    <a href="javascript:;" class="btn-cancel-todo">取消</a>
                </div>
            </form>
        </li>
    </ul>
    <a href="javascript:;" class="btn-new-todo">添加新任务</a>
    <ul class="todos todos-completed">
        <?php
        if($process){
            foreach($model->finishedTasks as $task){
                echo $this->render("/commons/_task",["model"=>$task]);
            }
        }
        ?>
    </ul>
</div>