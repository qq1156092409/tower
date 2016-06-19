<?php
use app\models\Discuss;
use yii\helpers\Url;
/**
 * @var $model Discuss
 */
?>
<div id="discuss-<?=$model->id?>" class="discuss message <?=$model->order?"sticky":""?>"
     data-update="<?=strtotime($model->update)?>">
    <div class="message-actions actions" data-visible-to="member">
        <div class="inr">
            <a href="<?=Url::to(["/discuss/toggle-top","id"=>$model->id])?>" class="btn-discuss-toggle-top <?=$model->order?"unstick":"stick"?>" title="<?=$model->order?"取消":""?>置顶">
                <i class="twr twr-arrow-circle-up"></i>
            </a>
            <a href="<?=Url::to(["discuss/toggle-archive","id"=>$model->id])?>"
               class="<?=$model->archive?"un":""?>archive btn-discuss-toggle-archive" title="<?=$model->archive?"重新打开":"结束"?>讨论" data-self="1" data-archive="<?=($model->archive+1)%2?>" data-loading="true">
                <i class="twr <?=$model->archive?"twr-unarchive":"twr-archive-custom"?>"></i>
            </a>
        </div>
    </div>

    <a href="/members/75d0e57f0e25482f983bebbc6e987849" target="_blank" title="tower.im">
        <img alt="tower.im" class="avatar" src="public/default_avatars/path.jpg">
    </a>
    <div class="name">
        <a href="/members/75d0e57f0e25482f983bebbc6e987849" data-stack-root="true" data-stack="true"
           title="tower.im">tower.im</a>
    </div>
    <a data-stack="" href="<?=$viewUrl=$model->target->getViewUrl()?>"
       class="message-link">

        <span class="message-title">
                <span class="message-rest" title="欢迎来到Tower"><?=$model->target->name?></span>
        </span>
        <span class="message-content">
            <?=$model->activeText?:"R.T."?>
        </span>
    </a>
    <span class="time" title="2014-05-21" data-readable-time="2014-05-21T09:22:35+08:00"><?=$model->activeUpdate?></span>
    <div class="comment-info">
        <span class="label-attachment"><i class="twr twr-paperclip"></i></span>
        <?php if($commentCount=$model->commentCount){ ?>
            <a href="<?=$viewUrl?>" class="comments-count" data-stack="true"><?=$commentCount?></a>
        <?php } ?>
    </div>
</div>