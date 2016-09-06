<?php
use yii\helpers\Url;
use app\models\Item;
use yii\widgets\ActiveForm;

/**
 * @var $model Item
 * @var $process bool
 */
?>
<div id="item-<?= $model->id ?>" class="todolist item">
    <div class="title item-edit-sub">
        <div class="todolist-actions actions">
            <div class="inr">
                <a href="<?= Url::to(["/item/toggle-archive", "id" => $model->id]) ?>" class="archive btn-item-toggle-archive" title="归档（请确认清单内任务都已完成）">归档</a>
                <a href="javascript:;" class="edit item-edit-show" title="编辑" data-id="<?=$model->id?>">编辑</a>
                <a href="<?= Url::to(["/item/disable", "id" => $model->id]) ?>" data-visible-to="admin,creator" class="del btn-item-disable" data-cf="确定要删除这个任务清单吗？" title="删除任务清单">删除</a>
            </div>
        </div>
        <h4>
    <span class="name-non-linkable">
        <span class="todolist-rest attr-name"><?=$model->name?></span>
    </span>
    <span class="name">
        <a href="<?= $model->getViewUrl() ?>" class="todolist-rest attr-name" data-stack="true"><?=$model->name?></a>
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
        <p class="desc attr-description"><?= $model->description ?></p>
    </div>
    <div class="todolist-form edit item-edit-wrap" style="display: none;">
        <?php $form=ActiveForm::begin([
            "id"=>"item-edit-form-".$model->id,
            "action"=>Url::to(["/item/edit","id"=>$model->id]),
            "options"=>[
                "class"=>"form item-edit-form"
            ]
        ])?>
            <input type="text" class="todolist-name no-border" value="<?= $model->name ?>"
                   name="Item[name]" placeholder="任务清单名称" data-validate="custom" data-validate-msg="">
            <textarea class="todolist-desc no-border" name="Item[description]" placeholder="补充说明（可选）"
                      style="overflow: hidden; word-wrap: break-word; resize: none; height: 18px;"><?= $model->description ?></textarea>

            <p class="form-buttons">
                <button type="submit" class="btn btn-update-todolist btn-primary" data-disable-with="正在保存...">保存
                </button>
                <button type="button" class="btn btn-x item-edit-cancel" data-id="<?=$model->id?>">取消</button>
            </p>
        <?php $form->end()?>
    </div>
    <ul id="task-uncompleted-list-<?=$model->id?>" class="todos todos-uncompleted ui-sortable">
        <?php foreach ($model->commonTasks as $task) {
            echo $this->render("/commons/_task", ["model" => $task,"hasEdit"=>true]);
        } ?>
    </ul>
    <ul class="todo-new-wrap">
        <li id="task-create-wrap-<?=$model->id?>" class="todo-form new" style="display: none">
            <?php $form2=ActiveForm::begin([
                "id"=>"task-create-form-".$model->id,
                "action"=>Url::to(["/task/create"]),
                "options"=>[
                    "class"=>"form task-create-form"
                ]
            ])?>
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
                    <textarea name="Task[name]" class="todo-content no-border attr-name" placeholder="新的任务" data-validate="custom"
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
                    <a href="javascript:;" class="btn-cancel-todo task-create-cancel" data-item="<?=$model->id?>">取消</a>
                </div>
            <?php $form2->end()?>
        </li>
    </ul>
    <a href="javascript:;" class="btn-new-todo task-create-sub" data-item="<?=$model->id?>" id="task-create-sub-<?=$model->id?>">添加新任务</a>
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