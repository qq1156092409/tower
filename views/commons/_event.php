<?php
use app\models\Event;
/**
 * @var $model Event
 */
?>
<div id="event-<?=$model->id?>" class="calendar-event event">

    <div class="date">
        <span class="start-time" data-time="2015-04-20T00:00:00+08:00" title="2015年4月20日 星期一"><?=date("n月j日",strtotime($model->start))?></span>
        <?php if(date("Y-m-d",strtotime($model->start))!==date("Y-m-d",strtotime($model->end))){ ?>
        <span class="end-time" data-time="2015-04-30T23:59:59+08:00" title="2015年4月30日 星期四"> - <?=date("n月j日",strtotime($model->end))?> </span>
        <?php } ?>
    </div>

    <div class="event">
        <p class="event-detail">
            <span class="event-content">
                <a href="<?=$model->getViewUrl()?>"
                   class="calendar_event-rest" data-stack="true" title="<?=$model->name?>"><?=$model->name?></a>
            </span>
        </p>
        <div class="calendar">
            <span class="name">日历：<span class="cal-color-1"><?=$model->calendar->activeName?></span></span>
        </div>
        <ul class="member-list">
            <?php foreach($model->allUsers as $user){ ?>
                <li>
                    <a href="/members/f4880b71a92642c293ca7efc1f2256d9" title="<?=$user->activeName?>" data-stack="" data-stack-root="">
                        <img src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37" alt="<?=$user->activeName?>" class="avatar">
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>