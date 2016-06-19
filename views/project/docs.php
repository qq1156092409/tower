<?php
use app\models\Project;
use app\models\Doc;
use yii\web\View;
use yii\helpers\Url;
use app\components\JsManager;
/**
 * @var $teamID int
 * @var $project Project
 * @var $docs Doc[]
 * @var $this View
 */
$this->title="所有的文档";
JsManager::instance()->registers(["js/yii.dropdown.js"]);
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page  page-root simple-pjax page-behind">
        <a class="link-page-behind" data-stack="" href="<?=Url::to(["/project","id"=>$project->id])?>"><?=$project->name?></a>
    </div>

    <div class="page page-1 simple-pjax">
        <div class="page-inner" data-project-creator="f4880b71a92642c293ca7efc1f2256d9" data-page-name="所有的文档" id="page-docs">
            <h3>
                <span class="title">所有的文档</span>

                <div class="btn-group">
                    <a href="<?=Url::to(["/doc/create","projectID"=>$project->id])?>" class="btn btn-mini btn-new-doc" target="_blank">创建新文档</a>
                    <button class="btn btn-mini btn-dropdown-toggle">
                        <i class="twr twr-caret-down"></i>
                    </button>
                    <ul class="btn-dropdown-menu">
                        <li>
                            <a href="<?=Url::to(["/doc/create","projectID"=>$project->id])?>" class="btn-create-normal-doc" target="_blank">普通文档</a>
                        </li>
                        <li>
                            <a href="/projects/32b8fcd2b0f4438d8417277049491664/docs/new?markdown=1" class="btn-create-md-doc" target="_blank">Markdown 文档</a>
                        </li>
                    </ul>
                </div>
            </h3>

            <div class="docs-view grid-view">
                <div class="switch-view">
                    <a href="javascript:;" class="link-view link-grid-view active">
                        <i class="twr twr-grid-view"></i>
                    </a>
                    <a href="javascript:;" class="link-view link-list-view">
                        <i class="twr twr-list-view"></i>
                    </a>
                </div>

                <div class="doc-headers">
                    <div class="doc-header name-header">
                        <span>名称</span>
                    </div>
                    <div class="doc-header saver-header">
                        <span>修改者</span>
                    </div>
                    <div class="doc-header update-time-header">
                        <span>最后修改时间</span>
                    </div>
                </div>
                <div class="doc-list">
                    <?php foreach($docs as $doc){
                        echo $this->render("/commons/_doc",["model"=>$doc,"teamID"=>$teamID]);
                    }?>
                </div>
            </div>
        </div>
    </div>
</div>