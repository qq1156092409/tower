<?php
use app\models\UserTeam;
/**
 * @var $model UserTeam
 */
?>
<li class="member ui-draggable" data-guid="f4880b71a92642c293ca7efc1f2256d9" data-team-guid="16670002c3294dabaebdf1c0fa1c7194">
    <a href="/members/f4880b71a92642c293ca7efc1f2256d9" title="<?=$model->user->activeName?>" class="member-link owner" data-stack="">
        <img class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37" alt="<?=$model->user->activeName?>">
        <span class="name"><?=$model->user->activeName?></span>
        <span class="role"><?=$model->typeName?></span>
    </a>
</li>