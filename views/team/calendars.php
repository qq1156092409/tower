<?php
use yii\widgets\ActiveForm;
use app\models\Calendar;
use yii\helpers\Url;
use yii\web\View;
use app\components\JsManager;
/**
 * @var $this View
 * @var $teamID int
 * @var $calendars Calendar[]
 * @var $projectCalendars Calendar[]
 * @var $calendar2 Calendar
 * @var $calendar Calendar
 * @var $weekDays array
 * @var $month string
 */
$request=Yii::$app->request;
$chinese=['零','一','二','三','四','五','六','七','八','九','十','十一','十二'];
$this->params["active"]=4;
JsManager::instance()->registers([
    "js/models/yii.calendar.js",
]);
?>
<div class="container workspace simple-stack simple-stack-transition simple-stack-fluid">
<div class="page page-root simple-pjax">
<div class="page-inner" id="page-calendar" data-page-name="2015年5月">
<div class="calendar-container">
<div class="calendar-sidebar">
    <div class="sidebar-wrapper">
        <div class="cals">
            <div class="standard-cals">
                <div class="title">
                    <h3>日历</h3>
                    <a href="<?=Url::to(["calendar/create","teamID"=>$teamID])?>" class="link-create-calendar"
                       data-nocache="" data-visible-to="member" data-stack="" data-stack-root="" data-parent-name="日历"
                       data-parent-fluid="">添加日历</a>
                </div>
                <div class="no-cal-tour">请添加你的第一个日历</div>
                <ul class="cal-list">
                    <?php foreach($calendars as $calendar){
                        echo $this->render("/commons/_calendar",["model"=>$calendar,"teamID"=>$teamID]);
                    } ?>
                </ul>
            </div>
            <div class="project-cals" style="display: block;">
                <div class="title">
                    <h3>项目</h3>
                </div>
                <ul class="cal-list">
                    <?php foreach($projectCalendars as $calendar){
                        echo $this->render("/commons/_calendar",["model"=>$calendar,"teamID"=>$teamID]);
                    } ?>
                </ul>
            </div>
        </div>

        <div class="cals-control">
            <ul>
                <li>
                    <a class="show-todos" href="javascript:;">
                        <i class="twr twr-check-circle-o"></i>
                        <span>显示任务</span>
                    </a>
                </li>
                <li>
                    <a href="/teams/93d89386a21248be83711dd878ef33cd/calendars/subscribe" data-stack=""
                       data-stack-root="" data-parent-name="日历"
                       data-parent-url="/teams/93d89386a21248be83711dd878ef33cd/calendars" data-parent-fluid=""><i
                            class="twr twr-calendar"></i> iCalendar 订阅</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="calendar-wrapper">
<div class="calendar-topbar">
    <h3>
        <span class="month"><?=$chinese[(int)substr($month,5,2)]?>月</span>
        <span class="year"><?=substr($month,0,4)?></span>
    </h3>

    <div class="nav-buttons">
        <a class="btn-prev-month" title="上个月" href="<?= Url::to(["","id"=>$teamID,"month"=>date("Y-m",strtotime("-1 month",strtotime($month)))])?>">
            <i class="twr twr-chevron-left"></i>
        </a>
        <a class="btn-next-month" title="下个月" href="<?= Url::to(["","id"=>$teamID,"month"=>date("Y-m",strtotime("+1 month",strtotime($month)))])?>">
            <i class="twr twr-chevron-right"></i>
        </a>
    </div>
    <a href="javascript:;" class="btn btn-mini btn-today">今天</a>

    <div class="cal-loading" style="display: none;"><i class="twr twr-refresh twr-spin"></i></div>
    <a href="javascript:;" class="btn-toggle-sidebar btn-calendar-toggle-sidebar" title="隐藏侧边栏">⇥</a>
</div>
<div id="calendar" data-url="/teams/93d89386a21248be83711dd878ef33cd/calendar_events/" class="simple-calendar">
<div class="weeks"></div>
<div class="week-title">
    <div class="weekdays">
        <div class="weekday">周一</div>
        <div class="weekday">周二</div>
        <div class="weekday">周三</div>
        <div class="weekday">周四</div>
        <div class="weekday">周五</div>
        <div class="weekday">周六</div>
        <div class="weekday">周日</div>
    </div>
</div>
<div class="weeks">
<?php foreach($weekDays as $days){ ?>
<div class="week">
    <div class="days">
        <?php foreach($days as $k=>$day){ ?>
        <div class="day<?=$k==5?" sat":""?><?=$k==6?" sun":""?><?=substr($day,0,7)!=$month?" other-month":""?><?=$day==date("Y-m-d")?" today":""?>" data-date="<?=$day?>">
            <div class="info">
                <span class="desc"></span>
                <span class="num"><?=date("j",strtotime($day))?></span>
            </div>
            <div class="event-spacers"></div>
            <div class="day-events"></div>
            <div class="day-todos"></div>
        </div>
        <?php } ?>
    </div>
    <div class="events"></div>
</div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php foreach(array_merge($calendars,$projectCalendars) as $calendar2){ ?>
<div id="pop-calendar-color-<?php echo $calendar2->id?>" class="pop-calendar-color simple-popover direction-bottom-left" style="top: 183px; left: 1168px;display: none;">
    <div class="simple-popover-content">
        <div class="cal-setting-popover">
            <div class="form-item cal-color-field">
                <?php $form=ActiveForm::begin([
                    "id"=>"form-calendar-color-".$calendar2->id,
                    "action"=>Url::to(["/calendar/color","id"=>$calendar2->id]),
                ])?>
                <input class="attr-color" type="hidden" name="Calendar[color]" value="<?=$calendar2->color?>" />
                <h3>选择日历颜色</h3>
                <div class="cal-colors">
                    <?php for($i=1;$i<=18;$i++){ ?>
                    <a class="btn-calendar-set-color link-cal-color cal-color-<?=$i?> <?=$calendar2->color==$i?"selected":""?>" data-color="<?=$i?>" href="javascript:;">
                        <span><i class="twr twr-check"></i></span>
                    </a>
                    <?php } ?>
                </div>
                <?php $form->end()?>
            </div>
            <?php if(!$calendar2->projectID){ ?>
            <div class="form-item cal-setting-field">
                <p>
                    <a href="<?=Url::to(["/calendar/edit","id"=>$calendar2->id])?>" class="link-edit-cal">修改</a>
                    或者
                    <a href="<?=Url::to(["/calendar/destroy","id"=>$calendar2->id])?>" class="link-delete-calendar btn-calendar-destroy" data-cf="确定要删除这个日历吗？（跟日历相关的事件会被一并删除，请谨慎操作）">删除日历</a>
                </p>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="simple-popover-arrow">
        <i class="arrow arrow-shadow-1"></i>
        <i class="arrow arrow-shadow-0"></i>
        <i class="arrow arrow-border"></i>
        <i class="arrow arrow-basic"></i>
    </div>
</div>
<?php } ?>