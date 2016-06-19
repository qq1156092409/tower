<?php
use app\models\Discuss;
use app\models\Project;
use yii\web\View;
use app\components\JsManager;
/**
 * @var $this View
 * @var $discusses Discuss[]
 * @var $projectID int
 * @var $project Project
 * @var $archive int
 */
$this->title=$archive?"已经结束的讨论":"正在进行的讨论";
JsManager::instance()->registers([
    "js/yii.simditor.js",
    "js/models/yii.topic.js",
    "js/models/yii.discuss.js",
]);
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax page-behind">
        <a class="link-page-behind" data-stack="" href="<?=$project->getViewUrl()?>"><?=$project->name?></a>
    </div>
<div class="page page-1 simple-pjax">
<div class="page-inner <?=$archive?"finished":""?>" data-since="2015-04-16 03:55:11 UTC" data-guest-unlockable=""
     data-project-creator="f4880b71a92642c293ca7efc1f2256d9" data-page-name="正在进行的讨论" id="page-topics">

<h3 id="btn-discuss-status" class="title ">
    <?=$this->title?>
    <span class="twr twr-chevron-down"></span>
</h3>

<div class="editor-wrapper">
    <div id="topic-create-sub" class="editor-placeholder fake-textarea" data-droppable="" style="display: block;">点击发起讨论</div>
    <?=$this->render("/commons/_topicCreate",["projectID"=>$projectID])?>
</div>

<div class="init init-discussion <?=$discusses?"hide":""?>">
    <p class="title">
        <?=$archive?"所有讨论都已结束":"还没有人发起讨论"?>
    </p>
</div>

<div id="discuss-list" class="messages can-stick">
<?php
if($discusses){
    foreach($discusses as $discuss){
        echo $this->render("/commons/_discuss",["model"=>$discuss,"teamID"=>$teamID]);
    }
}
?>
</div>

<a href="javascript:;" id="btn-load-more" class="over">没有更多内容了</a>
</div>
</div>
</div>
<!--选择类型-->
<div id="pop-discuss-status" class="simple-popover topics-select-popover direction-bottom-left" style="top: 252px; left: 411.78125px;display:none">
    <div class="simple-popover-content">
        <ul>
            <li>
                <a href="<?=\yii\helpers\Url::to([
                    "project/discusses",
                    "id"=>$projectID,
                ])?>" class="<?=$archive?"":"active"?>" data-stack="" data-stack-replace="">
                    <i class="twr twr-clock-o"></i> 正在进行
                </a>
            </li>
            <li>
                <a href="<?=\yii\helpers\Url::to([
                    "project/discusses",
                    "id"=>$projectID,
                    "archive"=>1
                ])?>" class="<?=$archive?"active":""?>" data-stack="" data-stack-replace="">
                    <i class="twr twr-inbox"></i> 已经结束
                </a>
            </li>
        </ul>
    </div>
    <div class="simple-popover-arrow">
        <i class="arrow arrow-shadow-1"></i>
        <i class="arrow arrow-shadow-0"></i>
        <i class="arrow arrow-border"></i>
        <i class="arrow arrow-basic"></i>
    </div>
</div>
<div id="hide-data" class="hide" data-scenario="project-discusses-archive-<?=$archive?>"></div>