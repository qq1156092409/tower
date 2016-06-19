<?php
use \yii\widgets\ActiveForm;
use app\models\Project;
use app\models\Team;
use yii\helpers\Url;
use yii\web\View;
use app\components\JsManager;
/**
 * @var $id int
 * @var Team $team;
 * @var Project[] $projects;
 * @var $this View
 */

$this->title="所有项目";
$this->params["active"]=1;

$array=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
JsManager::instance()->registers([
    'js/models/yii.project.js',
]);
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax">
        <div class="page-inner" id="page-projects" data-page-name="所有项目">
            <div class="tools">
                <div class="switch-view">
                    <a href="javascript:;" class="link-view link-grid-view active" title="网格视图">
                        <i class="twr twr-grid-view"></i>
                    </a>
                    <a href="javascript:;" class="link-view link-list-view" title="列表视图">
                        <i class="twr twr-list-view"></i>
                    </a>
                </div>
                <a id="btn-project-create" class="link-create-project new" href="<?=Url::to(["/project/create","teamID"=>$teamID])?>" data-stack="" data-nocache="">
                    新建项目
                </a>
            </div>
            <div id="wrap-projects" class="projects grid-view ui-sortable">
                <?php foreach ($projects as $project){
                    echo $this->render("/commons/_project",["model"=>$project]);
                } ?>
            </div>
            <div class="projects-footer">
                <a href="<?=Url::to(["/team/templates","id"=>$team->id])?>" data-stack="" data-visible-to="admin">管理项目模板</a>
                <a href="<?=Url::to(["/team/archived-projects","id"=>$team->id])?>" data-stack="" data-visible-to="admin">管理已归档项目</a>
            </div>
            <input type="hidden" id="select-plan-path" value="/teams/67786d3c380f46bbad08c033043d77ab/plans">
        </div>
    </div>
</div>
<!--修改颜色和图标-->
<?php foreach($projects as $project){ ?>
<div id="pop-project-icon-<?php echo $project->id?>" class="simple-popover pop-project-icon direction-bottom-center hide">
    <?php $form=ActiveForm::begin(["id"=>"form-project-icon-".$project->id,"action"=>Url::to(["/project/icon","id"=>$project->id]),"options"=>[
        "class"=>"form-project-icon",
    ]])?>
    <input class="project-icon" type="hidden" name="Project[icon]" value="<?=$project->icon?>" />
    <input class="project-icon-color" type="hidden" name="Project[iconColor]" value="<?=$project->iconColor?>" />
    <div class="simple-popover-content">
        <div class="project-badge badge-settings">
            <ul class="color-sets" data-attr="project-icon-color">
                <?php for($i=1;$i<=8;$i++){ ?>
                    <li data-value="<?=$i?>" class="c<?=$i?> <?=$i==$project->iconColor?"selected":""?>"></li>
                <?php } ?>
            </ul>
            <ul class="icons" data-attr="project-icon">
                <?php for($i=1;$i<=25;$i++){ ?>
                    <li data-value="<?=$i?>" class="i<?=$i?> c<?=$project->iconColor?> <?=$i==$project->icon?"selected":""?>"><?=strtoupper($array[$i-1])?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <?php $form->end()?>
    <div class="simple-popover-arrow">
        <i class="arrow arrow-shadow-1"></i>
        <i class="arrow arrow-shadow-0"></i>
        <i class="arrow arrow-border"></i>
        <i class="arrow arrow-basic"></i>
    </div>
</div>
<?php } ?>