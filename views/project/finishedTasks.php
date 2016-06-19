<?php
use yii\helpers\Url;
use app\models\Task;
use app\models\Project;
/**
 * @var $project Project
 * @var $dayItemTasks Task[]
 */
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax page-behind" style="">
        <a class="link-page-behind" data-stack="" href="<?=$project->viewUrl?>"><?=$project->name?></a>
    </div>
    <div class="page page-1 simple-pjax">
        <div class="page-inner" data-page-name="所有已完成任务" id="page-completed-todos">
            <h3>已完成的任务
                <select id="select-member">
                    <option value="<?=Url::to(["","id"=>$project->id])?>"<?=$userID?"":" selected"?>>按人筛选 - 所有人</option>
                    <option disabled="">----</option>
                    <?php foreach($users as $user){ ?>
                    <option value="<?=Url::to(["","id"=>$project->id,"userID"=>$user->id])?>"<?=$userID==$user->id?" selected":""?>><?=$user->activeName?></option>
                    <?php } ?>
                </select>
            </h3>
            <?php foreach($dayItemTasks as $day=>$itemTasks){ ?>
            <div class="day" data-date="2015-07-16T14:23:05+08:00">
                <div class="hd">
                    <span><?=$day?></span>
                </div>
                <div class="bd">
                    <?php foreach($itemTasks as $itemID=>$tasks){
                        $item=current($tasks)->item;
                        ?>
                        <h6 class="name">
                        <span class="todolist">
                            <a href="<?=$item?$item->viewUrl:""?>"
                                class="todolist-rest" data-stack="true"><?=$item?$item->name:"未归类任务"?></a></span>
                    </h6>
                    <ul class="todolist list">

                        <li class="todo completed">
				<span class="todo-content">
					<a href="/projects/c96929b616cd4100a6225ea090264459/todos/b41a548e22f7438cb0004017f4ee57ad"
                       class="todo-rest" data-stack="true">任务1-1</a>
				</span>
                            <small><a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" data-stack="" data-stack-root="">方片周</a>
                            </small>
                        </li>

                    </ul>
                    <?php } ?>
                </div>

            </div>
            <?php } ?>

            <a href="javascript:;" id="btn-load-more" class="over">没有更多内容了</a>
        </div>
    </div>
</div>
