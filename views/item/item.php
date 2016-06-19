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
    <?=$this->render("/commons/_targetActions",["model"=>$item])?>
    <?=$this->render("/commons/_commentCreate",["target"=>$item])?>
</div>
</div>
</div>