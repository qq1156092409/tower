<?php
use yii\helpers\Url;
use app\models\Task;
use yii\web\View;
use yii\widgets\ActiveForm;
/**
 * @var $this View
 * @var $model Task
 * @var $hasEdit bool
 */
?>
<li id="task-<?=$model->id?>" class="todo running task"
    data-id="<?=$model->id?>"
    data-project="<?=$model->projectID?>"
    data-assign-url="<?=Url::to(["task/assign","id"=>$model->id])?>"
    data-user="<?=$model->userID?$model->userID:-1?>">
    <div class="todo-actions actions">
        <div class="inr">
            <a href="<?=Url::to(["task/run","id"=>$model->id])?>" class="run btn-task-run" title="标记成正在进行中" style="<?=($model->status===Task::RUNNING&&$model->userID===Yii::$app->user->id)?'display: none;':''?>">执行</a>
            <a href="<?=Url::to(["task/pend","id"=>$model->id])?>" class="pause" data-loading="true" data-remote="true" title="暂停" style="<?=($model->status===Task::RUNNING&&$model->userID===Yii::$app->user->id)?'display: inline;':''?>">暂停</a>
            <a href="javascript:;" class="edit task-edit-show" data-id="<?=$model->id?>" title="编辑">编辑</a>
            <a href="<?=Url::to(["task/disable","id"=>$model->id])?>" data-visible-to="creator,admin" class="del btn-task-del btn-task-disable" data-remote="true" data-cf="确定要删除这条任务吗？" title="删除">删除</a>
        </div>
    </div>
    <div class="todo-wrap">
        <div class="simple-checkbox" style="height: 16px; width: 16px;">
            <div class="checkbox-container btn-task-finish" style="border: 1.6px solid;" data-url="<?=Url::to(["/task/finish","id"=>$model->id])?>">
                <div class="checkbox-tick" style="border-right-width: 2.24px; border-right-style: solid; border-bottom-width: 2.24px; border-bottom-style: solid;">
                </div>
            </div>
            <input type="checkbox" name="todo-done" class="checkbox-input" style="display: none;">
        </div>
        <span class="runner <?=$model->status==\app\models\Task::RUNNING?"on":""?>" title="<?=$model->user?$model->user->activeName:""?>正在做这条任务">
            <img alt="<?=$model->user?$model->user->activeName:""?>" class="avatar" src="public/b77fe6a1d67e4fc1863e3b860ca0815b">
        </span>
        <span class="todo-content">
            <span class="raw"><?=$model->name?></span>
            <span class="content-non-linkable">
                <span class="todo-rest" title="<?=$model->name?>"><?=$model->name?></span>
            </span>
            <span class="content-linkable">
                <a href="<?=$viewUrl=$model->getViewUrl()?>" class="todo-rest" data-stack="true" title="<?=$model->name?>"><?=$model->name?></a>
            </span>
        </span>
        <?php if($model->commentCount>0){ ?>
        <span class="label comments-count"> <?=$model->commentCount?>条评论 </span>
        <a class="label comments-count" href="<?= $viewUrl?>" data-stack="">
            <?=$model->commentCount?>条评论
        </a>
        <?php } ?>
        <a class="label todo-assign-due btn-assign <?=$model->userID?"":"no-assign"?>" href="javascript:;" data-id="<?=$model->id?>">
            <span class="assignee" data-guid="c24e8e36ccaf43b787229ff595efc41d"><?=$model->userID?$model->user->activeName:"未指派"?></span>
            <?php if($model->endTime){ ?>
            <span class="due" data-date="<?=$model->endTime?>"><?=date("Y-m-d",strtotime($model->endTime))?></span>
            <?php } ?>
        </a>
        <a href="<?=$viewUrl?>" class="label todo-proj"
           data-stack-root="true" data-stack="true" title="<?=$model->item->project->name?> - <?=$model->item->activeName?>"><?=$model->item->project->name?> - <?=$model->item->activeName?></a>
    </div>
</li>
<?php if($hasEdit){ ?>
<li id="task-edit-wrap-<?=$model->id?>" class="todo-form edit hide">
    <?php $form=ActiveForm::begin([
        "id"=>"task-edit-form-".$model->id,
        "action"=>Url::to(["/task/edit","id"=>$model->id]),
        "options"=>[
            "class"=>"form task-edit-form"
        ]
    ])?>
        <div class="form-body">
            <div class="simple-checkbox disabled" style="height: 18px; width: 18px;">
                <div class="checkbox-container" style="border: 1.8px solid;">
                    <div class="checkbox-tick" style="border-right-width: 2.52px; border-right-style: solid; border-bottom-width: 2.52px; border-bottom-style: solid;">
                    </div>
                </div>
                <input type="checkbox" name="todo-done" disabled="" class="checkbox-input" style="display: none;"></div>
            <textarea name="Task[name]" class="todo-content no-border attr-name" placeholder="修改任务" data-validate="custom" data-validate-msg="" style="overflow: hidden; word-wrap: break-word; resize: none; height: 24px;"><?= $model->name?></textarea>
            <div class="todo-toolbar">
                <a href="javascript:;" class="add-tag" title="点击添加标签">#</a>
                <a href="javascript:;" class="add-priority" title="点击添加优先级">!</a>
            </div>
            <a href="javascript:;" class="todo-label">
                <span class="assignee">未指派</span> ·
                <span class="due">没有截止时间</span>
            </a>
        </div>
        <div class="buttons edit-buttons">
            <button type="submit" class="btn btn-primary btn-update-todo" data-disable-with="正在保存...">保存修改</button>
            <a href="javascript:;" class="btn-cancel-update-todo task-edit-cancel" data-id="<?=$model->id?>">取消</a>
        </div>
    <?php $form->end()?>
</li>
<?php } ?>