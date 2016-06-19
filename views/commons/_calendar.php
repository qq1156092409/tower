<?php
use yii\helpers\Url;
use app\models\Calendar;
/**
 * @var $model Calendar
 */
?>
<li id="calendar-<?=$model->id?>" class="calendar" data-color="<?=$model->color?>"
    data-color-url="<?=Url::to(["/calendar/color","id"=>$model->id])?>"
    data-edit-url="<?=Url::to(["/calendar/edit","id"=>$model->id])?>"
    <?php if($model->projectID==0){ ?>
    data-can-operation="1"
    data-destroy-url="<?=Url::to(["/calendar/destroy","id"=>$model->id])?>"
    <?php } ?>
    >
    <a href="javascript:;" class="link-show-cal link-cal-color cal-color-<?=$model->color?> selected">
        <span><i class="twr twr-check"></i></span>
    </a>
    <a href="javascript:;" class="cal-name" title="<?=$model->activeName?>"><?=$model->activeName?></a>
    <a href="javascript:;" class="link-cal-setting btn-calendar-color" title="设置" data-id="<?=$model->id?>"></a>
</li>