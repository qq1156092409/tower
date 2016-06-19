<?php
use yii\helpers\Url;
use app\models\Project;
use app\models\Event;
/**
 * @var $project Project
 * @var $events Event[]
 */
?>
<div class="section section-calendar-event">
    <h3>
        <a href="<?=Url::to(["/project/events","id"=>$project->id])?>" class="title" data-stack="true">日程</a>
        <a href="<?=Url::to(["event/create","teamID"=>$project->teamID,"calendarID"=>$project->calendar->id])?>" class="btn btn-mini btn-new-calendar-event" data-stack="true">创建新日程</a>
    </h3>

    <div class="calendar-events">
        <?php if($events){
            foreach($events as $event){
                echo $this->render("/commons/_event",["model"=>$event]);
            }
            ?>
        <?php }else{ ?>
            <div class="init init-calendar-event">
                <div class="title">接下来没有日程安排</div>
            </div>
        <?php } ?>

    </div>

    <div class="more">
        <a href="<?=Url::to(["project/events","id"=>$project->id])?>" class="link-more-agenda" data-stack="true">查看全部日程</a>
    </div>
</div>
