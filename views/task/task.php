<?php
use app\models\multiple\G;
use app\models\User;
use yii\helpers\Url;
use app\models\Task;
use app\models\Collect;
use app\models\Operation;
use yii\web\View;
use yii\widgets\ActiveForm;
use app\assets\SimditorAsset;
use yii\web\YiiAsset;
use app\components\JsManager;
/**
 * @var $this View
 * @var $model Task
 * @var $teamID int
 * @var $operations Operation[]
 * @var $isCollect Collect
 * @var $users User
 */
$this->title=$model->name;
JsManager::instance()->registers([
    "js/yii.simditor.js",
    "js/models/yii.task.js",
    "js/models/yii.comment.js",
]);
?>
<div class="container workspace simple-stack simple-stack-transition">
<div class="page page-root simple-pjax page-behind">
    <a class="link-page-behind" data-stack="" href="<?= $model->project->getViewUrl()?>"><?=$model->project->name?></a>
</div>
<div class="page page-1 simple-pjax">
<div class="page-inner" data-since="2015-01-31 06:51:01 UTC" data-creator-guid="74481dd781b74484827bab529cb0c933"
     data-project-creator="ec6289a803bb41f9b35ea633049008db" data-page-name="<?=$model->name?>" id="page-todo">
<?php if($model->deleted){ ?>
<div class="page-tip resource-deleted">
    这个任务已经于 <span title="<?=$model->lastOperation->create?>"><?=date("Y年m月d日",strtotime($model->lastOperation->create))?></span> 删除了
                <span data-visible-to="creator,admin">
                    ，你可以选择
                    <a class="btn-task-enable" href="<?=Url::to(["task/enable","id"=>$model->id])?>" data-cf="确定要恢复这条任务吗？" data-global-loading="正在恢复" data-refresh="true" data-remote="true">恢复</a>
                </span>
</div>
<?php } ?>
<div class="topic">
    <div class="project-info">
                    <span><a
                            href="https://tower.im/projects/09c3ae86ed0e48fd94cfafa7a449be64/lists/cff3f9a73e4442998fc5e03cb90ef204/show"
                            data-stack-replace="true" data-stack="true"><?=$model->item->name?></a>
                    </span>
    </div>
    <div class="todolist">
        <ul class="todos">
            <?php echo $this->render("/commons/_task",["model"=>$model,"teamID"=>$teamID])?>
            <li class="todo-form edit" style="display:none">
                <form id="form-task-edit" class="form" method="post" data-remote="true" action="<?=Url::to(["task/edit","taskID"=>$model->id])?>">
                    <div class="form-body">
                        <div class="simple-checkbox disabled" style="height: 16px; width: 16px;">
                            <div class="checkbox-container" style="border: 1.6px solid;">
                                <div class="checkbox-tick" style="border-right-width: 2.24px; border-right-style: solid; border-bottom-width: 2.24px; border-bottom-style: solid;">
                                </div>
                            </div>
                            <input type="checkbox" name="todo-done" disabled="" class="checkbox-input" style="display: none;"></div>
                        <textarea name="todo_content" class="todo-content no-border" placeholder="新的任务" data-validate="custom" data-validate-msg="" style="overflow: hidden; word-wrap: break-word; resize: none; height: 32px;"><?=$model->name?></textarea>

                        <div class="todo-toolbar">
                            <a href="javascript:;" class="add-tag" title="点击添加标签">#</a>
                            <a href="javascript:;" class="add-priority" title="点击添加优先级">!</a>
                        </div>

                        <a href="javascript:;" class="todo-label selected">
                            <span class="assignee"> <?= $model->user?$model->user->activeName:"未指派"?> </span>·
                            <span class="due"><?=$model->endTime?date("Y-m-d",strtotime($model->endTime)):"没有截止时间"?></span>
                        </a>
                    </div>

                    <div class="buttons edit-buttons">
                        <button type="submit" class="btn btn-primary btn-update-todo" data-disable-with="正在保存...">保存修改</button>
                        <a href="javascript:;" class="btn-cancel-update-todo">取消</a>
                    </div>

                    <input type="hidden" name="assignee_guid" class="hidden-assignee" value="1ff0fd3d4a404428a1594e9ebdb2360a">
                    <input type="hidden" name="due_at" class="hidden-due-date" value="1430755199000">
                </form>
            </li>
        </ul>
    </div>
</div>

<div class="comments streams" id="comment-list">
    <?php foreach($operations as $operation){
        echo $this->render("/commons/_operation",["model"=>$operation]);
    } ?>
</div>

    <?=$this->render("/commons/_targetActions",["model"=>$model])?>

    <div class="comment comment-form new">
        <a class="avatar-wrap" target="_blank" href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe">
            <img class="avatar" width="50" height="50" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37">
        </a>
        <div class="comment-main">
            <div id="comment-create-sub" class="form-field">
                <div class="fake-textarea" data-droppable="">点击发表评论</div>
            </div>
        </div>
        <?php $form=ActiveForm::begin([
            "id"=>"comment-create-form",
            "action"=>Url::to(["/comment/create"]),
            "options"=>[
                "class"=>"form form-editor comment-create-form hide"
            ]
        ])?>
            <input type="hidden" name="Comment[model]" value="<?=G::TASK?>" />
            <input type="hidden" name="Comment[value]" value="<?=$model->id?>" />
            <div class="comment-main">
                <div class="form-item">
                    <div class="form-field">
                        <div class="fake-textarea" data-droppable="" style="display: none;">点击发表评论</div>
                        <textarea id="editor" name="Comment[text]" autofocus></textarea>
                    </div>
                </div>
                <div class="form-item notify hide" style="display: block;">
                    <div class="notify-title">
                        <div class="notify-title-title">发送通知给：</div>
                        <div class="notify-title-summary hide" style="display: block;">
                        <span class="receiver"><span data-guid="974ae2692d83457aa0c6068600674b43">
                                邓健强
                            </span></span>
                        <span class="change-notify">
                            [ <a href="javascript:;" class="link-change-notify">更改</a> ]
                        </span>
                        </div>
                        <div class="notify-title-select" style="display: none;">
                            <span unselectable="on" data-subgroup="-1" class="group-select">所有人</span>
                            <span data-subgroup="35628" unselectable="on" class="group-select selected">
                                策划
                            </span>
                            <span data-subgroup="35629" unselectable="on" class="group-select">
                                美术
                            </span>

                        </div>
                    </div>

                    <div class="form-field" style="display: none;">
                        <ul class="member-list">
                            <li>
                                <label>
                                    <input type="checkbox" tabindex="-1" value="974ae2692d83457aa0c6068600674b43" checked="checked" data-subgroup="35628">
                                    <span title="邓健强">邓健强</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" tabindex="-1" value="2e5c91f6db0e4b9eab25e406940e211d" data-subgroup="35629">
                                    <span title="邓健强小小号">邓健强小小号</span>
                                </label>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="hide form-buttons" style="display: block;">
                    <button tabindex="1" type="submit" class="btn btn-primary btn-create-comment" data-disable-with="正在发送...">发表评论</button>
                    <button tabindex="2" type="button" id="comment-create-cancel" class="btn btn-x btn-cancel-create-comment">取消</button>
                </div>
            </div>
        <?php $form->end();?>
    </div>
    <!-- page move -->
    <div class="page-move mask hide"></div>
    <div class="page-move page-tip action hide">
        移动完成，这个条目已被移动到 <em class="project-name">测试项目</em> 中，
        <a href="<?=Url::to(["/task","id"=>$model->id])?>">现在就去查看 →</a>
    </div>
    <!-- page move end -->
</div>
</div>
</div>
<?=$this->render("/commons/_taskAssign",["users"=>$users])?>
<!-- pop-comment-operation -->
<?=$this->render("/commons/_popCommentOperation")?>