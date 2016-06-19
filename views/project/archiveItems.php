<?php
use app\models\Project;
use yii\helpers\Url;
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15-7-16
 * Time: 下午5:07
 */
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page  page-root simple-pjax page-behind">
        <a class="link-page-behind" href="<?=Url::to(["/project","id"=>$project->id])?>">测试项目</a>
    </div>

    <div class="page page-1 simple-pjax">
        <div class="page-inner" data-page-name="已归档任务清单" id="page-completed-todolists">
            <h3>已归档任务清单</h3>
            <ul class="completed-todolists">
                <?php foreach($items as $item){ ?>
                <li class="todolist completed">
                <span class="name">
                <a href="<?=$item->viewUrl?>" class="todolist-rest" data-stack="true"><?=$item->name?></a>
                </span>
                    <span class="todo-count">0个任务</span>
                    <span class="desc"> ( 方片周, <span data-readable-time="2015-07-16 16:58:00 +0800">刚刚</span> ) </span>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>