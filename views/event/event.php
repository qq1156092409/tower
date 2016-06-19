<?php
use yii\web\View;
use app\models\Event;
use yii\helpers\Url;
use \app\models\multiple\G;
/**
 * @var $this View
 * @var $teamID int
 * @var $event Event
 */
$this->title=$event->name;
?>
<div class="container workspace simple-stack simple-stack-transition">
<div class="page page-root simple-pjax page-behind">
    <a class="link-page-behind" data-stack="" href="<?=Url::to(["team/calendars","id"=>$teamID])?>">日历</a>
</div>
<div class="page page-1 simple-pjax">
<div class="page-inner" data-since="2015-04-29 07:00:13 UTC" data-page-name="<?=$event->name?>" id="page-calendar-event">
<div class="topic">
    <div class="calendar-info">
        日历：<a href="<?=Url::to(["team/calendars","id"=>$teamID])?>" data-stack="" data-stack-root="" data-parent-name="所有项目"
              data-parent-url="/teams/16670002c3294dabaebdf1c0fa1c7194/projects" class="cal-color-1"><?=$event->calendar->activeName?></a>
    </div>

    <div class="calendar-event" data-schedule="false">
        <img src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37" alt="方片周" class="avatar">

        <p class="event-content">
            <span class="calendar_event-rest" title="<?=$event->name?>"><?=$event->name?></span>
        </p>

        <div class="event-time">
                        <span class="start-time" data-time="2015-03-01T00:00:00+08:00" title="2015年3月1日 星期日">
    3月1日
</span>
<span class="end-time" data-time="2015-05-31T23:59:59+08:00" title="2015年5月31日 星期日">
    - 5月31日
</span>


        </div>
        <ul class="event-info">
            <?php if($event->address){ ?>
            <li>
                <i class="twr twr-map-marker"></i>
                地点：<a class="event-location" target="_blank"
                      href="http://api.map.baidu.com/geocoder?address=<?=$event->address?>&output=html"><?=$event->address?></a>
            </li>
            <?php } ?>
            <?php if($nameStr=$event->inviteUserName){ ?>
            <li>
                <i class="twr twr-user"></i>
                邀请：<span class="event-invite"><?=$nameStr?></span>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>

<div class="comments streams">
    <?php foreach($operations as $operation){
        echo $this->render("/commons/_operation",["model"=>$operation,"teamID"=>$teamID]);
    }?>
</div>
<div class="detail-star-action">
    <a href="<?=Url::to(["collect/toggle","model"=>G::EVENT,"value"=>$event->id])?>"
       class="detail-action detail-action-star btn-collect-toggle <?=$isCollect?" stared":""?>" data-itemid="2596003" data-itemtype="Todo" data-loading="true"
       data-remote="true" rel="nofollow" title="<?=$isCollect?"取消":""?>收藏"><?=$isCollect?"取消":""?>收藏</a>
</div>
<div class="detail-actions">
    <div class="item" data-visible-to="creator,admin">
        <a href="<?=Url::to(["/event/edit","id"=>$event->id])?>" class="detail-action detail-action-edit" data-loading="true" data-method="get" data-remote="true">编辑</a>
    </div>
    <div class="item" data-visible-to="creator,admin">
        <a href="<?=Url::to(["/event/destroy","id"=>$event->id])?>"
           class="detail-action detail-action-del btn-event-destroy" data-cf="确定要删除吗？" data-remote="true"
           data-stack-replace="true" rel="nofollow">删除</a>
    </div>
</div>
<?=$this->render("/commons/_commentCreate",["target"=>$event])?>
</div>
</div>
</div>
<?=$this->render("/commons/_popCommentOperation")?>
<script src="js/models/event.js"></script>