<?php
use yii\helpers\Url;
use app\models\File;
/**
 * @var $model File
 */
?>
<div id="file-<?=$model->id?>" class="file file-or-dir ui-draggable">
<div class="file-name">
        <div class="file-thumb">
            <a href="<?=$model->isImage()?$model->preview():$model->getViewUrl()?>" data-title="<?=$model->name?>" data-lightbox="<?=$model->id?>">
            <img alt="<?=$model->name?>" src="<?=$model->preview()?>" title="<?=$model->name?>">
            </a>
        </div>
        <div class="link-name">
            <a href="<?=$model->getViewUrl()?>" title="<?=$model->name?> <?=$model->size()?>"><?=$model->name?></a>
        </div>
    </div>

    <div class="file-size" data-size="10">
        <span>10B</span>
    </div>

    <div class="file-update-time">
        <span data-readable-time="2015-04-20T14:29:28+08:00" title="2015年04月20日 14:29">昨天</span>
    </div>

    <div class="file-links">
        <a href="<?=Url::to(["/file/download","id"=>$model->id])?>" class="link-download" target="_blank">下载</a>
        <a href="javascript:;" class="link-move" data-project-guid="31cfd5556a4543b68cb489a242b1e9e7"
           data-name="<?=$model->name?>" data-visible-to="admin,creator"
           data-move-url="/projects/31cfd5556a4543b68cb489a242b1e9e7/uploads/c84a9951b9d743939a38ffb7ed6696e0/move">
            移动
        </a>
        <a href="<?=Url::to(["/file/toggle-enable","id"=>$model->id])?>"
           class="link-delete btn-file-disable file-toggle-enable" data-visible-to="admin,creator"
           data-cf="确定要删除这个文件吗？">删除</a>
    </div>
</div>