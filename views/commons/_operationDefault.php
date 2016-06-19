<?php
use app\models\Operation;
/**
 * @var $model Operation
 */
?>
<div id="operation-<?=$model->id?>" class="event event-common event-todo-<?=$model->typeName?>">

    <a href="https://tower.im/members/74481dd781b74484827bab529cb0c933" class="from" target="_blank">
        <img alt="陈孝宗" class="avatar" src="public/33fc5b0817a44201b2423e399b52f6c8">
    </a>
    <i class="icon-event"></i>
    <div class="event-main">
        <div class="event-head">
            <a href="https://tower.im/projects/09c3ae86ed0e48fd94cfafa7a449be64/todos/f2c4a626c5b1438b9204546dd207ad6b/#event-3287153"
               data-created-at="2014-06-13T19:55:18+08:00" class="event-created-at"><?=date("y-m-d H:i",strtotime($model->create))?></a>
			<span class="event-actor">
				<a href="https://tower.im/members/74481dd781b74484827bab529cb0c933" class="link-member" target="_blank"><?=$model->user->activeName?></a>
			</span>
			<span class="event-action">
				<?=$model->activeText?>
			</span>
			<span class="event-text">
				<span class="emphasize">
					<a href="https://tower.im/projects/09c3ae86ed0e48fd94cfafa7a449be64/todos/f2c4a626c5b1438b9204546dd207ad6b"
                       class="todo-rest" data-stack="true" title="<?=$model->target->name?>"><?=$model->target->name?></a>
				</span>
			</span>
        </div>
    </div>
</div>