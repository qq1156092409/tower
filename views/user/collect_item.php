<?php
use app\models\Collect;
use app\models\Event;
use yii\helpers\Url;
use app\models\Item;
/**
 * @var $model Collect
 * @var $teamID int
 * @var $target Item
 */
$target=$model->target;
?>
<div id="collect-<?=$model->id?>" class="star-item star-item-todo">
    <a href="<?=Url::to(["collect/toggle","model"=>$model->model,"value"=>$model->value])?>" data-callback="destroy" class="star-action btn-collect-toggle" rel="nofollow" title="取消收藏">星星</a>
    <i class="twr twr-tasks"></i>
    <a href="<?=$target->getViewUrl()?>" class="star-link" data-stack="" title="<?=$target->name?>">
        <span class="title"><?=$target->name?></span>
        <span class="info">项目：<span class="color-1"><?=$target->project->name?></span></span>
        <span class="desc">已完成 <?=$target->countFinishedTask()?>/<?=$target->countEnableTask()?></span>
    </a>
</div>
