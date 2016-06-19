<?php
use app\models\Collect;
use app\models\Event;
use yii\helpers\Url;
/**
 * @var $model Collect
 * @var $teamID int
 * @var $target Event
 */
$target=$model->target;
?>
<div id="collect-<?=$model->id?>" class="star-item star-item-todo">
    <a href="<?=Url::to(["collect/toggle","model"=>$model->model,"value"=>$model->value])?>" data-callback="destroy" class="star-action btn-collect-toggle" rel="nofollow" title="取消收藏">星星</a>
    <i class="twr twr-calendar-o"></i>
    <a href="<?=$target->getViewUrl()?>" class="star-link" data-stack="" title="<?=$target->name?>">
        <span class="title"><?=$target->name?></span>
        <span class="info">项目：<span class="color-1"><?=$target->calendar->activeName?></span></span>
        <span class="desc ">
            <span class="name"><?=$target->user->activeName?>，</span>
            <span class="date"><?=$target->getFuzzyStart()?></span>
            <?php if($target->getFuzzyStart()!=$target->getFuzzyEnd()){ ?>
             - <span class="date"><?=$target->getFuzzyEnd()?></span>
            <?php } ?>
        </span>
    </a>
</div>
