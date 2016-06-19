<?php
use app\models\Collect;
use yii\helpers\Url;
use \app\models\File;
/**
 * @var $model Collect
 * @var $teamID int
 * @var $target File
 */
$target=$model->target;
?>
<div id="collect-<?=$model->id?>" class="star-item star-item-todo">
    <a href="<?=Url::to(["collect/toggle","model"=>$model->model,"value"=>$model->value])?>" data-callback="destroy" class="star-action btn-collect-toggle" rel="nofollow" title="取消收藏">星星</a>
    <i class="twr twr-folder-o"></i>
    <a href="<?=$target->getViewUrl()?>" class="star-link" data-stack="" title="<?=$target->name?>">
        <span class="title"><?=$target->name?></span>
        <span class="info">项目：<span class="color-1"><?=$target->project->name?></span></span>
        <span class="desc ">
            <span class="name"><?=$target->user->activeName?>，</span>
            <span class="date"><?=$target->getFuzzyUpdate()?></span>
        </span>
    </a>
</div>
