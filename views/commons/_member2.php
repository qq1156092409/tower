<?php
use app\models\UserTeam;
/**
 * 成员子页面
 * @var $model UserTeam
 */
?>
<li id="member2-<?=$model->id?>" class="member">
    <a href="/members/974ae2692d83457aa0c6068600674b43" title="<?=$model->user->name?>" class="member-link admin <?=$model->type==UserTeam::SUPER_ADMIN?"owner":""?>" data-stack="">
        <img src="https://avatar.tower.im/e3c6a3778cd64375b23ee6bfef70473c" class="avatar" alt="<?=$model->user->name?>">
        <span class="name"><?=$model->user->name?></span>
        <span class="role"><?=$model->getTypeName()?><?=$model->subgroup?" - ".$model->subgroup->name:""?></span>
    </a>
</li>
