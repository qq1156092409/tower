<?php
/**
 * @var $day string
 * @var $teamID int
 * @var $itemTasks array
 */
?>
<div class="day" data-date="2015-01-30T12:01:57+08:00">
    <div class="hd">
        <span class="m-d"><?=date("n/j",strtotime($day))?></span>
        <span class="w">周<?=mb_substr( "日一二三四五六",date("w",strtotime($day)),1,"utf-8" )?></span>
    </div>
    <div class="bd">
        <?php foreach($itemTasks as $itemID=>$tasks){
            $item=$tasks[0]->item;
            ?>
            <h6 class="name">
                <a href="<?=\yii\helpers\Url::to(["project/index","projectID"=>$item->project->id,"teamID"=>$teamID])?>" data-stack="" data-stack-root=""><?=$item->project->name?>：</a>
                <span class="todolist"><a href="<?=\yii\helpers\Url::to(["item/index","itemID"=>$item->id,"teamID"=>$teamID])?>" class="todolist-rest" data-stack="true" title="<?=$item->name?>"><?=$item->name?></a></span>
            </h6>
            <ul class="todolist list">
                <?php foreach($tasks as $task){ ?>
                    <li class="todo completed">
                            <span class="todo-content">
                                <a href="<?=\yii\helpers\Url::to(["task/index","taskID"=>$task->id,"teamID"=>$teamID])?>" class="todo-rest" data-stack="true" title="<?=$task->name?>"><?=$task->name?></a>
                            </span>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</div>