<?php
use app\models\Comment;
use yii\helpers\Url;
/**
 * @var $model Comment
 */
?>
<div id="comment-<?=$model->id?>" class="comment" data-creator-guid="f4880b71a92642c293ca7efc1f2256d9">
    <a class="avatar-wrap" href="/members/f4880b71a92642c293ca7efc1f2256d9/" target="_blank">
        <img class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37" width="50" height="50">
    </a>
    <div class="comment-actions  comment-liked">
        <div class="actions">
            <a href="javascript:;" class="reply">
                <i class="twr twr-reply"></i>
            </a>
            <a href="<?=Url::to(["/comment/toggle-praise","id"=>$model->id])?>" class="btn-comment-toggle-praise like <?=$model->myUserComment?"i-liked":""?>" style="">
                <i class="twr twr-thumbs-o-up"></i> <span class="count"><?=$model->countUserComment()?:""?></span>
            </a>
            <a href="javascript:;" class="more btn-comment-operation" data-visible-to="creator,admin"
               data-destroy-url="<?=Url::to(["/comment/destroy","id"=>$model->id])?>"
               data-edit-url="<?=Url::to(["/comment/edit","id"=>$model->id])?>">
                <i class="twr twr-bars"></i>
            </a>
        </div>
        <div class="popover-liked-list hide" style="top: -62px; right: 14.5px;">
            <div class="simple-popover-content">
                <div class="comment-like-list">
                    <?php foreach($model->userComments as $userComment){
                        echo $this->render("/commons/_userComment",["model"=>$userComment]);
                    } ?>
                </div>
            </div>
            <div class="simple-popover-arrow">
                <i class="arrow arrow-shadow-1"></i>
                <i class="arrow arrow-shadow-0"></i>
                <i class="arrow arrow-border"></i>
                <i class="arrow arrow-basic"></i>
            </div>
        </div>
    </div>
    <div class="comment-main">
        <div class="info">
            <a class="author" href="/members/f4880b71a92642c293ca7efc1f2256d9/" data-stack="" data-stack-root="">方片周</a>
            <a class="create-time" href="#2b6e35dd20924586b664b5772961f496" title="2015-02-11 14:14"
               data-readable-time="2015-02-11T14:14:39+08:00">2月11日</a>
        </div>
        <div class="comment-content editor-style comment-text"><p><?=$model->text?></p></div>
    </div>
</div>