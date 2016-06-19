<?php
use yii\helpers\Url;
use yii\web\View;
use app\models\Event;
use app\models\Project;
/**
 * @var $this View
 * @var $events Event[]
 * @var $project Project
 * @var $teamID int
 * @var $monthStart string
 */
$this->title="所有的日程";
$chinese=['零','一','二','三','四','五','六','七','八','九','十','十一','十二'];
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax page-behind">
        <a class="link-page-behind" data-stack="" href="<?=Url::to(["project/index","id"=>$project->id])?>"><?=$project->name?></a>
    </div>
    <div class="page page-1 simple-pjax"><div class="page-inner" data-since="2015-04-29 06:39:04 UTC" data-page-name="所有的日程" id="page-project-calendar-events">
            <h3>所有的日程</h3>
            <div class="calendar-events-topbar">
                <a href="<?=Url::to(["/event/create","teamID"=>$project->teamID,"calendarID"=>$project->calendar->id])?>" class="btn btn-mini btn-new-calendar-event" data-stack="true">创建新日程</a>
                <h4 class="date" data-date="<?=date("Y-m-d H:i:s",strtotime($monthStart))?>"><?=date("Y",strtotime($monthStart))?> <?=$chinese[date("n",strtotime($monthStart))]?>月</h4>
                <div class="nav-buttons">
                    <a href="<?=Url::to(["events","id"=>$project->id,"month"=>date("Y-m",strtotime("-1 month",strtotime($monthStart)))])?>" class="left" title="上个月" data-url="/teams/16670002c3294dabaebdf1c0fa1c7194/calendar_events/">
                        <i class="twr twr-chevron-left"></i>
                    </a>
                    <a href="<?=Url::to(["events","id"=>$project->id,"month"=>date("Y-m",strtotime("+1 month",strtotime($monthStart)))])?>" class="right" title="下个月" data-url="/teams/16670002c3294dabaebdf1c0fa1c7194/calendar_events/">
                        <i class="twr twr-chevron-right"></i>
                    </a>
                </div>
            </div>

            <div class="calendar-events">
                <?php
                if($events){
                    foreach($events as $event){
                        echo $this->render("/commons/_event",["model"=>$event,"teamID"=>$teamID]);
                    }
                }else{ ?>
                <div class="init init-calendar-event">
                    <div class="title">还没有日程安排</div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>