<?php
use app\models\Project;
use yii\helpers\Url;
/**
 * @var $model Project
 */
?>
<a id="project-<?=$model->id?>" data-id="<?=$model->id?>" class="project c<?=$model->iconColor?> i<?=$model->icon?>" title="<?=$model->name?>"
   href="<?php echo Url::toRoute(["/project","id"=>$model->id])?>"
    data-sort-url="<?=Url::to(["/project/sort","id"=>$model->id])?>">
    <span class="badge"></span>
    <span class="edit-badge btn-project-icon" title="点击修改项目图标和颜色" data-id="<?=$model->id?>"></span>
    <span class="name"><?=$model->name?></span>
    <span class="progress list-item"> 待处理任务 <em>3</em> </span>
</a>