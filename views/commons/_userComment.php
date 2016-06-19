<?php
use app\models\UserComment;
/**
 * @var $model UserComment
 */
$user=$model->user;
?>
<a id="user-comment-<?=$model->id?>" class="<?=$model->userID==Yii::$app->user->id?"user-comment-me":""?>" href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" target="_blank" title="<?=$user->activeName?>">
    <img alt="<?=$user->activeName?>" class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37">
</a>
