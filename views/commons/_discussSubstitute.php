<?php
use yii\helpers\Url;
use app\models\Discuss;
/**
 * 讨论的替身
 * @var $model Discuss
 */
?>
<p id="discuss-sub-<?=$model->id?>" class="archive-info discuss-sub" data-update="<?=strtotime($model->update)?>">
    <?=$model->archive?"你结束了讨论：":"你重新打开了讨论："?>
    <a href="<?=$model->target->viewUrl?>" class="content" data-stack=""> <?=$model->target->name?> </a>
    <a href="<?=Url::to(["discuss/toggle-archive","id"=>$model->id])?>"
       class="reopen btn-discuss-toggle-archive" data-self="0" data-archive="<?=($model->archive+1)%2?>" title="重新<?=$model->archive?"打开":"结束"?>讨论"> 重新<?=$model->archive?"打开":"结束"?> </a>
</p>