<?php
use app\models\Item;
use yii\web\View;
use yii\helpers\Url;
use app\components\JsManager;
/**
 * @var $this View
 * @var $teamID int
 * @var $item Item
 */
JsManager::instance()->registers([
    "js/models/yii.item.js",
    "js/models/yii.task.js",
    "js/models/yii.comment.js",
]);
?>
<div class="container workspace simple-stack simple-stack-transition">
<div class="page  page-root page-behind simple-pjax" data-url="/projects/31cfd5556a4543b68cb489a242b1e9e7">
    <a href="<?= $item->project->getViewUrl() ?>"
       class="link-page-behind" data-stack=""><?= $item->project->name ?></a>
</div>
<div class="page page-1 simple-pjax">
<div class="page-inner" data-since="2015-02-11 06:16:19 UTC" data-guest-unlockable=""
     data-creator-guid="f4880b71a92642c293ca7efc1f2256d9" data-project-creator="f4880b71a92642c293ca7efc1f2256d9"
     data-page-name="<?= $item->name ?>" id="page-todolist">
<?php if($item->deleted){ ?>
<div class="page-tip resource-deleted">
    这个任务清单已经于 <span title="<?=$item->lastOperation->create?>"><?=date("Y年m月d日",strtotime($item->lastOperation->create))?></span> 删除了
        <span data-visible-to="creator,admin">
            ，你可以选择
            <a class="btn-item-enable" href="<?=Url::to(["item/enable","id"=>$item->id])?>" data-cf="确定要恢复这个任务清单吗？" data-global-loading="正在恢复" data-refresh="true" data-remote="true">恢复</a>
        </span>
</div>
<?php } ?>
<div class="todos-all">
<div class="todolists-wrap">
    <div class="todolists">
        <?=$this->render("/commons/_item",["model"=>$item,"process"=>true])?>
    </div>
</div>
<div class="comments streams">
    <?php foreach($item->operations as $operation){
        echo $this->render("/commons/_operation",["model"=>$operation]);
    }?>
</div>
</div>
    <div class="detail-star-action">
        <a href="/projects/c96929b616cd4100a6225ea090264459/lists/fe4c11843b7343c0986f7bcaab8e1c84/star?muid=fe4c11843b7343c0986f7bcaab8e1c84" class="detail-action detail-action-star" data-itemid="1951098" data-itemtype="Todolist" data-loading="true" data-method="post" data-remote="true" rel="nofollow" title="关注">关注</a>
    </div>
    <div class="detail-actions">
        <div class="item">
            <a href="javascript:;" class="detail-action detail-action-edit">编辑</a>
        </div>

        <div class="item detail-action-copy" data-visible-to="admin">
            <a href="javascript:;" class="detail-action detail-action-todolist">复制</a>
            <div class="confirm">
                <form class="form form-copy" action="/projects/c96929b616cd4100a6225ea090264459/lists/fe4c11843b7343c0986f7bcaab8e1c84/target_project" method="post" data-remote="">
                    <p class="title">复制到项目</p>
                    <p>
                        <select data-project="c96929b616cd4100a6225ea090264459" class="choose-projects loading"></select>
                        <input type="hidden" name="puid">
                    </p>
                    <p>
                        <button type="submit" class="btn btn-mini" disabled="" data-disable-with="正在复制...">复制</button>
                        <button type="button" class="btn btn-x cancel">取消</button>
                    </p>
                </form>
            </div>
        </div>

        <div class="item detail-action-move" data-visible-to="admin">
            <a href="javascript:;" class="detail-action detail-action-todolist">移动</a>
            <div class="confirm">
                <form class="form form-move" action="/projects/c96929b616cd4100a6225ea090264459/lists/fe4c11843b7343c0986f7bcaab8e1c84/move" method="post" data-remote="">
                    <p class="title">移动任务清单到项目</p>
                    <p>
                        <select data-project="c96929b616cd4100a6225ea090264459" class="choose-projects loading"></select>
                        <input type="hidden" name="tpuid">
                    </p>
                    <p>
                        <button type="submit" class="btn btn-mini" disabled="" data-disable-with="正在移动...">移动</button>
                        <button type="button" class="btn btn-x cancel">取消</button>
                    </p>
                </form>
            </div>
        </div>

        <div class="item" data-visible-to="member">
            <a href="/projects/c96929b616cd4100a6225ea090264459/lists/fe4c11843b7343c0986f7bcaab8e1c84/toggle_archived" class="detail-action detail-action-archive" data-loading="true" data-method="put" data-remote="true" title="请确认清单内任务都已完成">归档</a>
        </div>

        <div class="item" data-visible-to="admin, creator">
            <a href="javascript:;" class="detail-action detail-action-del">删除</a>
        </div>
    </div>
    <?=$this->render("/commons/_commentCreate",["target"=>$item])?>
</div>
</div>
</div>