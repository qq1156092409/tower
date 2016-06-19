<?php
use app\models\Event;
use app\models\UserLog;
use yii\helpers\Url;
/**
 * @var $teamID int
 * @var $userLog UserLog
 * @var $events Event[]
 * @var $monthStart string
 */
$chinese=['零','一','二','三','四','五','六','七','八','九','十','十一','十二'];
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax">
        <div class="page-inner page-member" id="page-member-calendar-events"
             data-guid="f4880b71a92642c293ca7efc1f2256d9" data-since="2015-05-08 06:50:58 UTC" data-page-name="方片周"
             data-self="true">
            <?=$this->render("_top",["teamID"=>$teamID,"userLog"=>$userLog,"flag"=>3])?>
            <p class="page-tips moveout inbox-moveout"></p>
            <div class="member-section member-calendar-events">
                <div class="calendar-events-topbar">
                    <a href="<?=Url::to(["/event/create","teamID"=>$teamID])?>" class="btn btn-mini btn-new-calendar-event" data-stack="true">创建新日程</a>
                    <h4 class="date" data-date="<?=date("Y-m-d H:i:s",strtotime($monthStart))?>"><?=date("Y",strtotime($monthStart))?> <?=$chinese[date("n",strtotime($monthStart))]?>月</h4>
                    <div class="nav-buttons">
                        <a href="<?=Url::to(["events","teamID"=>$teamID,"month"=>date("Y-m",strtotime("-1 month",strtotime($monthStart)))])?>" class="left" title="上个月" data-url="/teams/16670002c3294dabaebdf1c0fa1c7194/calendar_events/">
                            <i class="twr twr-chevron-left"></i>
                        </a>
                        <a href="<?=Url::to(["events","teamID"=>$teamID,"month"=>date("Y-m",strtotime("+1 month",strtotime($monthStart)))])?>" class="right" title="下个月" data-url="/teams/16670002c3294dabaebdf1c0fa1c7194/calendar_events/">
                            <i class="twr twr-chevron-right"></i>
                        </a>
                    </div>
                </div>
                <div class="calendar-events">
                    <?php if($events){
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
</div>