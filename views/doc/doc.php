<?php
use yii\helpers\Url;
use app\models\multiple\G;
use yii\web\View;
use app\models\Doc;
use app\components\JsManager;
use \yii\widgets\ActiveForm;
/**
 * @var $this View
 * @var $doc Doc
 * @var $teamID int
 */
$this->title=$doc->name;
JsManager::instance()->registers([
    'js/models/yii.doc.js',
    'js/models/yii.collect.js',
    'js/models/yii.comment.js',
    'js/yii.simditor.js',
]);
?>
<div class="container workspace simple-stack simple-stack-transition">
<div class="page  page-root simple-pjax page-behind">
    <a class="link-page-behind" data-stack="" href="<?=Url::to(["/project","id"=>$doc->projectID])?>"><?=$doc->project->name?></a>
</div>

<div class="page page-1 simple-pjax">
<div class="page-inner" data-since="2015-05-08 02:18:45 UTC" data-markdown="1"
     data-creator-guid="f4880b71a92642c293ca7efc1f2256d9" data-project-creator="f4880b71a92642c293ca7efc1f2256d9"
     data-page-name="<?=$doc->name?>" id="page-doc">
    <?php if($doc->deleted){
        $disableOperation=$doc->getLastDisableOperation();
        ?>
        <div class="page-tip resource-deleted">
            这份文档已经于 <span title="<?=$disableOperation->create?>"><?=date("Y年m月d日",strtotime($disableOperation->create))?></span>  删除了
            <span data-visible-to="creator,admin">
                ，你可以选择
                <a id="doc-enable" class="btn-doc-enable" href="<?=Url::to(["/doc/enable","id"=>$doc->id])?>" data-cf="确定要恢复这篇文档吗？">恢复</a>
            </span>
        </div>
    <?php } ?>

<div class="doc-wrap">

    <div class="doc printable" data-created-at="2015-04-29 17:15:48 +0800" data-updated-at="2015-04-29 17:17:14 +0800">
        <h3 class="doc-title">
            <span class="document-rest" title="<?=$doc->name?>"><?=$doc->name?></span>
        </h3>

        <div class="doc-info">
            <p>
                <span class="doc-creator"><?=$doc->user->activeName?></span>
                <span class="doc-update-time" data-readable-time="2015-04-29T17:17:14+08:00"><?=$doc->fuzzyUpdate?></span>保存
            </p>

            <p class="doc-control">
                <a href="/projects/31cfd5556a4543b68cb489a242b1e9e7/docs/6d58f7b6378b4d5487b51d72d814d4ef/revisions"
                   class="link-doc-revisions" data-stack="">查看编辑历史</a>
                    <span class="doc-diff">
                        或 <a href="javascript:;" class="link-doc-diff">对比历史记录</a>
                    </span>
            </p>
        </div>
        <div id="doc-content" class="doc-content editor-style">
            <?=$doc->text?>
        </div>
    </div>

</div>
    <div id="comment-list" class="comments streams">
        <?php foreach($operations as $operation){
            echo $this->render("/commons/_operation",["model"=>$operation,"teamID"=>$teamID]);
        }?>
    </div>
    <div class="detail-star-action">
        <a href="<?=Url::to(["/collect/toggle","model"=>G::DOC,"value"=>$doc->id])?>" class="detail-action detail-action-star btn-collect-toggle" title="关注">关注</a>
    </div>
    <div class="detail-actions">
        <div class="item">
            <a href="javascript:window.print()">打印</a>
        </div>
        <div class="item">
            <span class="detail-action detail-action-edit edit-locked hide" data-tooltip="方片周 正在编辑" data-url="">编辑<i class="twr twr-lock"></i></span>
            <a href="<?=$doc->getEditUrl();?>" class="detail-action detail-action-edit-real ">编辑</a>
        </div>
        <div class="item detail-action-move" data-visible-to="admin,creator">
            <a href="javascript:;" class="detail-action">移动</a>
            <div class="confirm">
                <form class="form form-move" action="/projects/26dc9eb2cbbc48ac98e0c3d876618369/docs/f972adbaf17b487fb4516ff11b4e2fe9/move" method="post" data-remote="true">
                    <p class="title">移动文档到项目</p>
                    <p>
                        <select data-project="26dc9eb2cbbc48ac98e0c3d876618369" class="choose-projects loading"></select>
                        <input type="hidden" name="tpuid">
                    </p>
                    <p>
                        <button type="submit" class="btn btn-mini" disabled="" data-disable-with="正在移动...">移动</button>
                        <button type="button" class="btn btn-x cancel">取消</button>
                    </p>
                </form>
            </div>
        </div>
        <div class="item" data-visible-to="admin,creator">
            <a id="doc-disable" href="<?=Url::to(["/doc/disable","id"=>$doc->id])?>" class="detail-action detail-action-del" data-cf="确定要删除这篇文档吗？">删除</a>
        </div>
    </div>

    <div class="comment comment-form new">
        <a class="avatar-wrap" target="_blank" href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe">
            <img class="avatar" width="50" height="50" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37">
        </a>
        <div class="comment-main">
            <div id="comment-create-sub" class="form-field">
                <div class="fake-textarea" data-droppable="">点击发表评论</div>
            </div>
        </div>
        <?php $form=ActiveForm::begin([
            "id"=>"comment-create-form",
            "action"=>Url::to(["/comment/create"]),
            "options"=>[
                "class"=>"form form-editor comment-create-form hide"
            ]
        ])?>
        <input type="hidden" name="Comment[model]" value="<?=G::DOC?>" />
        <input type="hidden" name="Comment[value]" value="<?=$doc->id?>" />
        <div class="comment-main">
            <div class="form-item">
                <div class="form-field">
                    <div class="fake-textarea" data-droppable="" style="display: none;">点击发表评论</div>
                    <textarea id="editor" name="Comment[text]" autofocus></textarea>
                </div>
            </div>
            <div class="form-item notify hide" style="display: block;">
                <div class="notify-title">
                    <div class="notify-title-title">发送通知给：</div>
                    <div class="notify-title-summary hide" style="display: block;">
                        <span class="receiver"><span data-guid="974ae2692d83457aa0c6068600674b43">
                                邓健强
                            </span></span>
                        <span class="change-notify">
                            [ <a href="javascript:;" class="link-change-notify">更改</a> ]
                        </span>
                    </div>
                    <div class="notify-title-select" style="display: none;">
                        <span unselectable="on" data-subgroup="-1" class="group-select">所有人</span>
                            <span data-subgroup="35628" unselectable="on" class="group-select selected">
                                策划
                            </span>
                            <span data-subgroup="35629" unselectable="on" class="group-select">
                                美术
                            </span>

                    </div>
                </div>

                <div class="form-field" style="display: none;">
                    <ul class="member-list">
                        <li>
                            <label>
                                <input type="checkbox" tabindex="-1" value="974ae2692d83457aa0c6068600674b43" checked="checked" data-subgroup="35628">
                                <span title="邓健强">邓健强</span>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" tabindex="-1" value="2e5c91f6db0e4b9eab25e406940e211d" data-subgroup="35629">
                                <span title="邓健强小小号">邓健强小小号</span>
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="hide form-buttons" style="display: block;">
                <button tabindex="1" type="submit" class="btn btn-primary btn-create-comment" data-disable-with="正在发送...">发表评论</button>
                <button tabindex="2" type="button" id="comment-create-cancel" class="btn btn-x btn-cancel-create-comment">取消</button>
            </div>
        </div>
        <?php $form->end();?>
    </div>
</div>
</div>
</div>