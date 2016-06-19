<?php
use app\models\User;
use app\models\Team;
use yii\helpers\Url;
use app\models\Operation;
use yii\web\View;
use app\components\JsManager;
/**
 * @var $this View
 * @var $teamID int
 * @var $team Team
 * @var $user User
 * @var $operations Operation[]
 */
$this->title="动态";
$this->params["active"]=2;
JsManager::instance()->registers([
    "js/models/yii.team.js",
    "js/models/yii.operation.js"
]);
?>
<div class="container workspace simple-stack simple-stack-transition">
<div class="page page-root simple-pjax">
<div class="page-inner" id="page-events" data-page-name="动态" data-since="2015-04-08 07:10:45 UTC">
<div class="filters">
    <span class="filters-title">筛选动态</span>
    <div id="btn-team-subgroups" class="mcw-pop-select filter-member">
        <span class="selected-text"><?=$user?$user->activeName:"所有成员"?></span><span class="icon-arrow twr twr-chevron-down"></span>
        <input type="hidden" name="by_member" value="" id="filter-member">
    </div>
</div>
    <?php if($operations){ ?>
    <div class="team-events">
        <?php foreach($operations as $day=>$projectOperations){
            echo $this->render("operations_day",[
                "day"=>$day,
                "projectOperations"=>$projectOperations,
                "teamID"=>$teamID,
            ]);
        } ?>
    </div>
        <?php if($hasMore){ ?>
        <a href="javascript:;" id="btn-load-more" class="btn-operation-more" data-offset="<?=$limit?>" style="display: block;" data-url="<?=Url::to(["","id"=>$teamID,"userID"=>$user->id])?>">加载更多内容</a>
        <?php } ?>
    <?php }else{ ?>
    <div class="init init-events-filter">
        <div class="title"><em>没有找到符合过滤条件的内容</em></div>
        <div class="desc">
            <em><?=$user?$user->activeName:""?></em>
            还没有任何项目的内容
        </div>
    </div>
    <?php } ?>
</div>
</div>
</div>
<!--小组弹窗-->
<div id="pop-team-subgroups" class="simple-popover events-filter-member-popover mcw-pop-select-popover mcw-pop-select-float direction-bottom-center hide" style="top: 125px; left: 345px;">
    <div class="simple-popover-content"><div class="groups-members">
            <div class="groups">
                <h5>小组</h5>
                <ul class="mcw-pop-select-list">
                    <?php foreach($team->subgroups as $subgroup){ ?>
                        <li data-subgroup-id="<?=$subgroup->id?>"><?=$subgroup->name?></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="members">
                <h5>成员</h5>
                <ul class="mcw-pop-select-list">
                    <li data-member-id="-1" class="<?=$user?"":"selected"?>" data-url="<?=Url::to([
                        "team/operations",
                        "id"=>$teamID,
                    ])?>">所有成员</li>
                    <?php foreach($team->userTeams as $userTeam){ ?>
                    <li class="<?=$userTeam->userID==$user->id?"selected":""?>" data-user-id="<?= $userTeam->user->id?>" data-subgroup-id="<?=$userTeam->subgroupID?>" data-url="<?=Url::to([
                        "team/operations",
                        "id"=>$teamID,
                        "userID"=>$userTeam->user->id
                    ])?>"><?= $userTeam->user->activeName?></li>
                    <?php } ?>
                </ul>
            </div>
        </div></div>
    <div class="simple-popover-arrow">
        <i class="arrow arrow-shadow-1"></i>
        <i class="arrow arrow-shadow-0"></i>
        <i class="arrow arrow-border"></i>
        <i class="arrow arrow-basic"></i>
    </div>
</div>