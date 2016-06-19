<?php
use app\models\Operation;
use yii\helpers\Url;
use app\models\Team;
use app\models\Project;
use yii\web\View;
use app\components\JsManager;
/**
 * @var $this View
 * @var $team Team
 * @var $projects Project[]
 */
JsManager::instance()->registers([
    "js/models/yii.project.js",
]);
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax page-behind">
        <a class="link-page-behind" data-stack="" href="<?=Url::to(["/team/projects","id"=>$team->id])?>">所有项目</a>
    </div>
    <div class="page page-1 simple-pjax">
        <div class="page-inner" id="page-archived-projects" data-page-name="归档项目">
            <h3>归档项目</h3>
            <table class="tower-table archived-projects-table">
                <thead>
                <tr>
                    <th class="header-name">名称</th>
                    <th class="header-date">归档日期</th>
                    <th class="header-archiver">归档人</th>
                    <th class="header-links" data-visible-to="admin"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($projects as $project){
                    $operation = $project->getLastOperation(Operation::ARCHIVE);
                    ?>
                <tr id="project-<?=$project->id?>">
                    <td class="name-and-icon">
                        <span class="project-icon i<?=$project->icon?> c<?=$project->iconColor?>"><span class="badge"></span></span>
                        <a class="project-name" data-stack="" data-stack-replace="" href="<?=$project->getViewUrl()?>"><?=$project->name?></a>
                    </td>
                    <td class="date"><?=$operation->fuzzyCreate?></td>
                    <td class="person"><?=$operation->user->activeName?></td>
                    <td class="links" data-visible-to="admin">
                        <a class="link-project-unarchive btn-project-toggle-archive" href="<?=Url::to(["/project/toggle-archive","id"=>$project->id])?>"
                           data-page="archived-projects">重新激活</a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<input type="hidden" id="scenario" value="team-archived-projects">
