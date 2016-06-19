<?php
use app\models\Project;
use yii\helpers\Url;
use app\models\Item;
use app\models\Task;
use yii\web\View;
use app\components\JsManager;
/**
 * @var $this View
 * @var $tasks Task[]
 * @var $items Item[]
 * @var $project Project
 */
JsManager::instance()->registers([
    "js/yii.dropdown.js",
    "js/models/yii.item.js",
    "js/models/yii.task.js",
]);
?>
<div class="container workspace simple-stack simple-stack-transition">
<div class="page page-root simple-pjax page-behind">
    <a class="link-page-behind" href="<?=Url::to(["/project","id"=>$project->id])?>"><?=$project->name?></a>
</div>
<div class="page page-1 simple-pjax">
<div class="page-inner" data-since="2015-07-16 03:13:51 UTC" data-project-creator="5ee2cb7e11e84bc2a5f8a627a14b46fe"
     data-guest-unlockable="" data-page-name="所有任务" id="page-todolists">
<?=$this->render("_sectionTasks",["tasks"=>$tasks,"items"=>$items,"project"=>$project])?>
</div>
</div>
</div>