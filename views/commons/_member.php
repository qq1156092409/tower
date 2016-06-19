<?php
use \app\models\UserTeam;
/**
 * 成员子页面，点击移除
 * @var $model UserTeam;
 * @var $selected bool
 * @var $modelName
 */
?>
<li id="member-<?=$model->id?>" class="member <?=$model->isAdmin()?"admin":""?> <?=$selected?"selected":""?>"
        data-id="<?=$model->id?>"
        data-subgroup="<?=$model->subgroupID?>"
        data-user="<?=$model->userID?>"
        title="<?=$model->user->activeName?>">
    <input class="input-hidden" type="hidden" name="<?=$modelName?>[userIDs][]" value="<?=$model->userID?>" <?=$selected?"":"disabled"?> />
    <img src="https://avatar.tower.im/e3c6a3778cd64375b23ee6bfef70473c" class="avatar" alt="<?= $model->user->activeName?>">
    <span class="name"><?=$model->user->activeName?></span>
    <span class="role"><?=$model->getTypeName()?> - <?=$model->subgroup->name?></span>
    <span class="remove-mask"></span>
    <span class="remove-text" unselectable="on">点击移除成员</span>
</li>
