<?php
use app\models\Project;
use yii\helpers\Url;
use app\models\Item;
use app\models\Task;
use yii\web\View;
use yii\widgets\ActiveForm;
/**
 * @var $this View
 * @var $items Item[] 所有可用的item（包括直属item）
 * @var $project Project
 */
//get directItem
foreach($items as $k=>$item){
    if($item->type==Item::PROJECT_DIRECT){
        $directItem=$item;
        unset($items[$k]);
    }
}
?>
<div class="section section-todos" id="todolists">
<h3>
    <a class="title" href="<?=Url::to(["/project/tasks","id"=>$project->id])?>">任务</a>
    <div class="btn-group">
        <a href="javascript:;" class="btn btn-mini btn-new-todo btn-default-todolist task-create-show" data-item="<?=$directItem->id?>">添加任务</a>
        <button class="btn btn-mini btn-dropdown-toggle">
            <i class="twr twr-caret-down"></i>
        </button>

        <ul class="btn-dropdown-menu icon-menu">
            <li>
                <a href="javascript:;" class="btn-new-todo btn-default-todolist task-create-show" data-item="<?=$directItem->id?>">
                    <i class="twr twr-check-square-o"></i>
                    添加任务
                </a>
            </li>
            <li>
                <a href="javascript:;" class="btn-new-todolist" id="item-create-show">
                    <i class="twr twr-tasks"></i>
                    添加清单
                </a>
            </li>
        </ul>
    </div>
</h3>

<div class="todolist-toolbar ">
    <div class="toolbar-wrap filters-wrap">
        <div class="toolbar-confirm filters-confirm">

            <div class="filters">
                <h5>任务筛选</h5>
                <select id="filter-assignee">
                    <option value="0">所有成员</option>
                    <option disabled="">-----</option><option value="5ee2cb7e11e84bc2a5f8a627a14b46fe">方片周 (我自己)</option>

                    <option value="974ae2692d83457aa0c6068600674b43">邓健强</option>
                    <option value="2e5c91f6db0e4b9eab25e406940e211d">邓健强小小号</option>
                    <option disabled="">-----</option>
                    <option value="-1">未分派</option>
                </select>
                <select id="filter-due">
                    <option value="-1">所有时间</option>
                    <option disabled="">-----</option>
                    <option value="0">今天</option>
                    <option value="1">明天</option>
                    <option value="2">本周</option>
                    <option value="3">下周</option>
                    <option value="5">以后</option>
                    <option disabled="">-----</option>
                    <option value="4">已延误</option>
                    <option value="6">没有截止时间</option>
                </select>
	<span class="filter-desc" style="display: none;">
		<strong>←</strong>筛选结果已用<em> 荧光笔 </em>标记
	</span>
            </div>


        </div>
    </div>

    <a href="javascript:;" class="link-show-confirm link-filter">
        <i class="twr twr-pencil"></i>
    </a>


    <div class="switch-view">
        <a href="javascript:;" class="link-view link-list-view active" data-url="/projects/c96929b616cd4100a6225ea090264459/todos" data-type="list">
            <i class="twr twr-tasks"></i>
        </a>
        <a href="javascript:;" class="link-view link-member-view " data-url="/projects/c96929b616cd4100a6225ea090264459/todos/group_by_members" data-type="member">
            <i class="twr twr-user"></i>
        </a>
    </div>
</div>

<div class="todos-all todos-view list-view">

<div class="todolists-wrap">
<div id="item-<?=$directItem->id?>" class="todolist default-todolist<?=$directItem->commonTasks?"":" hide"?>" data-guid="c7385f1855304877a2612ead3c2e25ce" data-project-guid="c96929b616cd4100a6225ea090264459">
    <ul id="task-uncompleted-list-<?=$directItem->id?>" class="todos todos-uncompleted ui-sortable">
        <?php foreach($directItem->commonTasks as $task){
            echo $this->render("/commons/_task",["model"=>$task]);
        }?>
    </ul>
    <ul class="todo-new-wrap">
        <li id="task-create-wrap-<?=$directItem->id?>" class="todo-form new hide">
            <?php $form=ActiveForm::begin([
                "id"=>"task-create-form-".$directItem->id,
                "action"=>Url::to(["/task/create"]),
                "options"=>[
                    "class"=>"form task-create-form"
                ]
            ])?>
                <input type="hidden" name="Task[itemID]" value="<?=$directItem->id?>" />
                <input type="hidden" name="Task[userID]" />
                <input type="hidden" name="Task[endTime]" />
                <div class="form-body">
                    <div class="simple-checkbox disabled" style="height: 16px; width: 16px;">
                        <div class="checkbox-container" style="border: 1.6px solid;">
                            <div class="checkbox-tick" style="border-right-width: 2.24px; border-right-style: solid; border-bottom-width: 2.24px; border-bottom-style: solid;">
                            </div>
                        </div>
                        <input type="checkbox" name="todo-done" disabled="" class="checkbox-input" style="display: none;"></div>
                    <textarea name="Task[name]" class="todo-content no-border attr-name" placeholder="新的任务" data-validate="custom" data-validate-msg="" data-autosave="list-4beca07e8893425d8b08d77ed524f91e-new-todo" style="overflow: hidden; word-wrap: break-word; resize: none; height: 24px;"></textarea>
                    <a href="javascript:;" class="todo-label btn-assign">
                        <span class="assignee">未指派</span> ·
                        <span class="due">没有截止时间</span>
                    </a>
                </div>
                <div class="buttons create-buttons">
                    <button type="submit" class="btn btn-primary btn-create-todo" data-disable-with="正在保存...">添加任务</button>
                    <a href="javascript:;" class="btn-cancel-todo task-create-cancel" data-item="<?=$directItem->id?>">取消</a>
                </div>
            <?php $form->end()?>
        </li>
    </ul>
    <ul class="todos todos-completed">
    </ul>
</div>
<div id="item-create-wrap" class="todolist-form new hide">
    <?php $form2=ActiveForm::begin([
        "id"=>"item-create-form",
        "action"=>Url::to(["/item/create","projectID"=>$project->id]),
        "options"=>[
            "class"=>"form item-create-form"
        ]
    ])?>
        <input type="text" class="todolist-name no-border attr-name" name="Item[name]" placeholder="输入清单名称" data-validate="custom" data-validate-msg="">
        <textarea class="todolist-desc no-border attr-description" name="Item[description]" placeholder="补充说明（可选）" data-autosave="project-c96929b616cd4100a6225ea090264459-new-todolist-desc"></textarea>
        <div class="visitor-lock" data-visible-to="member">
            <label>
                <input type="checkbox" name="invisible_for_visitor" class="cb-visitor-lock" value="1">
                对访客隐藏这个任务清单
            </label>
        </div>
        <p class="form-buttons">
            <button type="submit" class="btn btn-create-todolist btn-primary" data-disable-with="正在保存...">
                保存，开始添加任务
            </button>
            <button type="button" class="btn btn-x btn-cancel-todolist" id="item-create-cancel">取消</button>
        </p>
    <?php $form2->end()?>
</div>
<div id="item-list" class="todolists ui-sortable">
<?php foreach($items as $item){
    echo $this->render("/commons/_item",["model"=>$item,"process"=>null]);
} ?>
</div>
<div class="todolists-completed">
    <a href="<?=Url::to(["project/archive-items","id"=>$project->id])?>" class="link-project-completed-todolists" data-stack="true">已归档清单</a>
    <a href="<?=Url::to(["project/finished-tasks","id"=>$project->id])?>" class="link-project-completed-todos" data-stack="true">已完成任务</a>
</div>
</div>
</div>
</div>