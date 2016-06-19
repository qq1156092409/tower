<?php
use yii\helpers\Url;
use app\models\Doc;
/**
 * @var $model Doc
 */
?>
<div id="doc-<?=$model->id?>" class="doc-item" data-guid="97555ea1e37f478bb0d410f4b570aca9">
    <a href="<?=$model->getViewUrl()?>" class="document" data-stack="">
        <div class="doc-name">
            <span class="document-rest" title="<?=$model->name?>"><?=$model->name?></span>
        </div>
        <div class="doc-desc editor-style">
            <?=$model->text?>
        </div>
        <div class="truncated"></div>

        <div class="doc-saver doc-info">
            <span><?=$model->user->activeName?></span>
        </div>

        <div class="doc-update-time doc-info">
            <span data-readable-time="2015-04-10T14:21:01+08:00" title="<?=$model->user->activeName?> 在 <?=$model->update?> 保存"><?=$model->fuzzyUpdate?></span>
        </div>
    </a>

    <div class="doc-links">
        <a href="<?=Url::to(["doc/disable","docID"=>$model->id])?>" class="doc-delete"
           data-cf="确定要删除这篇文档吗？"
           data-visible-to="admin,creator">删除</a>
    </div>
</div>