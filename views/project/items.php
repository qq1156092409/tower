<?php
use app\models\Project;
use app\models\Item;
use app\models\User;
/**
 * @var $project Project
 * @var $items Item[]
 * @var $users User[]
 */
$this->title ='所有任务';
$this->params["active"]=1;
?>
<div class="container workspace simple-stack simple-stack-transition">
<div class="page page-root simple-pjax page-behind">
    <a class="link-page-behind" data-stack="" href="<?=\yii\helpers\Url::to(["team/projects","teamID"=>$teamID])?>">所有项目</a>
</div>
<div class="page page-1 simple-pjax page-behind">
    <a class="link-page-behind" data-stack="" href="<?=\yii\helpers\Url::to(["project/index","projectID"=>$project->id,"teamID"=>$teamID])?>"><?=$project->name?></a>
</div>
<div class="page page-2 simple-pjax">
<div class="page-inner" data-since="2015-02-03 00:47:30 UTC" data-project-creator="ec6289a803bb41f9b35ea633049008db"
     data-guest-unlockable="" data-page-name="所有任务" id="page-todolists">

<h3>
    <span class="title">任务清单</span>
    <a href="javascript:;" class="btn btn-mini btn-new-todolist"
       data-request-members="09c3ae86ed0e48fd94cfafa7a449be64">添加清单</a>
</h3>

<div class="todos-all list-view">
<div class="filters-wrap">

    <div class="filters">
        <h5>任务筛选</h5>
        <select id="filter-assignee">
            <option value="0">所有成员</option>
            <option disabled="">-----</option>
            <option value="<?=Yii::$app->user->id?>"><?=Yii::$app->user->identity->activeName?> (我自己)</option>
            <?php foreach($users as $user){
                if($user->id==Yii::$app->user->id) continue;
                ?>
                <option value="<?=$user->id?>"><?=$user->activeName?></option>
            <?php } ?>
            <option disabled="">-----</option>
            <option value="-1">未分派</option>
        </select><br>
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
        </select><br>
	<span class="filter-desc" style="display: inline;">
		<strong>←</strong>筛选结果已用<em> 荧光笔 </em>标记
	</span>
    </div>


</div>

<div class="todolists-wrap">
<div class="todolist-form new hide">
    <form class="form" method="post" action="https://tower.im/projects/09c3ae86ed0e48fd94cfafa7a449be64/lists"
          data-remote="true">
        <input type="text" class="todolist-name no-border"
               data-autosave="project-09c3ae86ed0e48fd94cfafa7a449be64-new-todolist" name="todolist_name"
               placeholder="任务清单名称" data-validate="custom" data-validate-msg="">
        <textarea class="todolist-desc no-border" name="todolist_desc" placeholder="补充说明（可选）"
                  data-autosave="project-09c3ae86ed0e48fd94cfafa7a449be64-new-todolist-desc"></textarea>

        <div class="visitor-lock" data-visible-to="member">
            <label>
                <input type="checkbox" name="invisible_for_visitor" class="cb-visitor-lock" value="1">
                对访客隐藏这个任务清单
            </label>
        </div>
        <p class="form-buttons">
            <button type="submit" class="btn btn-create-todolist btn-primary" data-disable-with="正在保存...">保存，开始添加任务
            </button>
            <button type="button" class="btn btn-x btn-cancel-todolist">取消</button>
        </p>
    </form>
</div>


<div class="todolists">
<?php foreach($items as $item){
    echo $this->render("/commons/_item",["model"=>$item,"teamID"=>$teamID]);
} ?>
</div>
</div>

<div class="todolists-completed">
    <a href="https://tower.im/projects/09c3ae86ed0e48fd94cfafa7a449be64/lists/completed"
       class="link-project-completed-todolists" data-stack="true">已完成清单</a>

    <a href="https://tower.im/projects/09c3ae86ed0e48fd94cfafa7a449be64/todos/completed"
       class="link-project-completed-todos" data-stack="true">已完成任务</a>
</div>


</div>
</div>
</div>
</div>