<?php
use app\models\Collect;
use app\models\Topic;
/**
 * @var $model Collect
 * @var $teamID int
 */
if($model->target){
/** @var Topic $target */
$target=$model->target;
?>
<div id="collect-<?=$model->id?>" class="star-item star-item-message">
    <a href="<?=\yii\helpers\Url::to(["collect/toggle","model"=>$model->model,"value"=>$model->value])?>" data-callback="destroy" class="star-action btn-collect-toggle" title="取消收藏">星星</a>
    <i class="twr twr-comments-o"></i>
    <a href="<?=$target->getViewUrl()?>" class="star-link" data-stack="" title="<?=$target->name?>">
            <span class="title">
                <span class="message-rest" title="<?=$target->name?>"><?=$target->name?></span>
            </span>
        <span class="info">项目：<span class="color-2"><?=$target->project->name?></span></span>
            <span class="desc">
                <span class="name"><?=$target->user->activeName?>，</span>
                <span class="date"><?=$target->getFuzzyCreate()?></span>
            </span>
    </a>
</div>
<?php } ?>