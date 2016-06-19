<?php
use app\models\Collect;
use app\models\Task;
/**
 * @var $model Collect
 * @var $teamID int
 */
if($model->target){
    /** @var Task $target */
    $target=$model->target;
?>
<div id="collect-<?=$model->id?>" class="star-item star-item-todo">
    <a href="<?=\yii\helpers\Url::to(["collect/toggle","model"=>$model->model,"value"=>$model->value])?>" data-callback="destroy" class="star-action btn-collect-toggle" rel="nofollow" title="取消收藏">星星</a>
    <i class="twr twr-check-square-o"></i>
    <a href="<?=$target->getViewUrl($teamID)?>" class="star-link" data-stack="" title="<?=$target->name?>">
        <span class="title">
            <input type="checkbox" disabled="">
            <span class="todo-rest" title="<?=$target->name?>"><?=$target->name?></span>
        </span>
        <span class="info">项目：<span class="color-1"><?=$target->item->project->name?></span></span>
    </a>
</div>
<?php } ?>