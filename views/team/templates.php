<?php
use app\models\Team;
use app\models\Project;
use yii\helpers\Url;
use yii\web\View;
use app\components\JsManager;
/**
 * @var $this View
 * @var $team Team
 * @var $templates Project[]
 */
JsManager::instance()->registers(["js/yii.dropdown.js"]);
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax page-behind">
        <a class="link-page-behind" data-stack="" href="<?=Url::to(["/team/projects","id"=>$team->id])?>">所有项目</a>
    </div>
    <div class="page page-1 simple-pjax">
        <div class="page-inner" id="page-project_templates-index" data-page-name="项目模板">
            <h3>
                <span class="title">项目模板</span>
                <div class="btn-group">
                    <a href="/teams/93d89386a21248be83711dd878ef33cd/project_templates" class="btn btn-mini"
                       data-loading="true" data-remote="true" rel="nofollow">创建项目模板</a>
                    <button class="btn btn-mini btn-dropdown-toggle">
                        <i class="twr twr-caret-down"></i>
                    </button>
                    <ul class="btn-dropdown-menu icon-menu">
                        <li>
                            <a href="/teams/93d89386a21248be83711dd878ef33cd/project_templates" data-loading="true"
                               data-remote="true" rel="nofollow">标准项目模板</a>
                        </li>
                        <li>
                            <a href="/teams/93d89386a21248be83711dd878ef33cd/project_templates?project_type=1"
                               data-loading="true" data-remote="true" rel="nofollow">敏捷项目模板</a>
                        </li>
                    </ul>
                </div>
            </h3>
            <?php if($templates){ ?>
            <table class="tower-table templates-projects-table">
                <tbody>
                <?php foreach($templates as $template){ ?>
                <tr id="template-<?=$template->id?>" data-id="<?=$template->id?>">
                    <td class="name-and-icon">
                        <a class="project-name" href="/projects/da95a7209f6b44189002081263f3cecc" data-stack="" data-stack-root="">
                        <i class="twr twr-standard-project"></i>
                            <?=$template->name?>
                        </a>
                    </td>
                    <td class="links">
                        <a href="/projects/da95a7209f6b44189002081263f3cecc/create_project_from_template"
                           class="create-project-from-template" data-remote="true"
                           data-cf="Tower 将会根据当前模板的内容和成员设置生成一个全新的项目，确定立刻生成？" data-global-loading="正在生成项目...">从模板生成新项目</a>
                        <a class="link-delete link-template-delete" href="javascript:;"
                           data-remove-project-url="/projects/da95a7209f6b44189002081263f3cecc/destroy">删除模板</a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php }else{ ?>
                <div class="init init-template-projects">还没有项目模板</div>
            <?php }?>
        </div>
    </div>
</div>