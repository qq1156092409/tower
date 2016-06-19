<?php
use app\models\Dir;
use yii\helpers\Url;
/**
 * @var $model Dir
 */
$viewUrl=Url::to(["dir/","id"=>$model->id]);
?>
<div id="dir-<?=$model->id?>" class="dir file-or-dir <?=$model->getIsEmpty()?"empty":""?> ui-draggable ui-droppable" data-guid="70b91703818542c8b75d3a7d7e70d093"
     data-creator-guid="f4880b71a92642c293ca7efc1f2256d9">
    <div class="dir-name">
        <div class="dir-icon">
            <a href="<?=$viewUrl?>" title="wenjian" data-stack="" data-stack-replac=""></a>
        </div>
        <div class="link-name">
            <a href="<?=$viewUrl?>" title="wenjian" data-stack="" data-stack-replace=""> <?= $model->name?> </a>
        </div>
    </div>

    <div class="dir-size" data-size="0">
        <span>--</span>
    </div>
    <div class="dir-update-time">
        <span data-readable-time="2015-04-17T17:56:46+08:00" title="2015年04月17日 17:56">4月17日</span>
    </div>
    <div class="dir-links">
        <a href="<?=Url::to(["dir/download","id"=>$model->id])?>" target="_blank" class="link-download">下载</a>
        <a href="javascript:;" class="link-move" data-project-guid="31cfd5556a4543b68cb489a242b1e9e7"
           data-name="wenjian" data-visible-to="admin,creator" data-dir-guid="70b91703818542c8b75d3a7d7e70d093"
           data-move-url="/projects/31cfd5556a4543b68cb489a242b1e9e7/dirs/70b91703818542c8b75d3a7d7e70d093/move">
            移动
        </a>
        <a href="<?=Url::to(["dir/destroy","id"=>$model->id])?>"
           class="link-delete dir-destroy"
           data-cf="确定要删除这个文件夹吗？">删除</a>
    </div>
</div>