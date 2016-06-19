<?php
use app\models\Calendar;
use app\models\Operation;
use app\models\Project;
use yii\helpers\Url;
use app\models\multiple\G;
/**
 * @var $day string
 * @var $projectOperations Operation[]
 * @var $teamID int
 */
?>
<div class="events-day" data-date="<?=$day?>">
    <h4 class="events-day-title">
        <span class="date"><?=date("n/j",strtotime($day))?></span>
        <span class="day">周<?=mb_substr( "日一二三四五六",date("w",strtotime($day)),1,"utf-8" )?></span>
    </h4>

    <div class="events-day-content">
        <?php foreach($projectOperations as $prev=>$operations){
            list($prevModel,$prevValue)=explode("-",$prev);
            if($prevModel==G::PROJECT){
                /** @var Project $project */
                $project=Project::findOne($prevValue);
                $viewUrl = $project->getViewUrl();
                $name=$project->name;
            }
            if($prevModel==G::CALENDAR){
                $viewUrl = Url::to(["team/calendars", "id" => $teamID]);
                $name="日历";
            }
            ?>
        <div class="events-ancestor" data-ancestor-guid="31cfd5556a4543b68cb489a242b1e9e7">
            <h5 class="events-ancestor-title">
                <a href="<?=$viewUrl?>" title="<?=$name?>"><?=$name?></a>
            </h5>
            <?php foreach($operations as $operation){
                $targetUrl=$operation->target->getViewUrl($teamID);
                ?>
                <div class="event event-common event-todo-assign" id="operation-<?=$operation->id?>"
                 data-ancestor-guid="31cfd5556a4543b68cb489a242b1e9e7" data-ancestor-name="测试项目"
                 data-ancestor-url="/projects/31cfd5556a4543b68cb489a242b1e9e7">

                <a href="/members/f4880b71a92642c293ca7efc1f2256d9" class="from" target="_blank">
                    <img alt="方片周" class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37">
                </a>
                <i class="icon-event"></i>
                <div class="event-main">
                    <div class="event-head">
                        <a href="#event-15694684" data-created-at="2015-04-01T20:12:45+08:00" class="event-created-at"><?=date("H:i",strtotime($operation->create))?></a>
                        <span class="event-actor">
                            <a href="/members/f4880b71a92642c293ca7efc1f2256d9" class="link-member" target="_blank"><?=$operation->user->activeName?></a>
                        </span>
                        <span class="event-action">
                            <?=$operation->activeText?>
                        </span>
                        <span class="event-text">
                            <span class="emphasize">
                                <a href="<?=$targetUrl?>" class="todo-rest" data-stack="true" title="<?=$operation->target->name?>"><?=$operation->target->name?></a>
                            </span>
                        </span>
                    </div>
                    <?php if($operation->withID){
                        $with=$operation->with;
                        $withUrl=$targetUrl."#comment-".$operation->withID;
                        ?>
                    <div class="event-body">
                        <a href="<?=$withUrl?>" class="event-text" data-stack="true" title="<?=$with->getActiveText(false)?>"><?=$with->activeText?></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</div>