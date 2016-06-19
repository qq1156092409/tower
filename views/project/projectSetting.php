<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use \app\models\multiple\G;
use \app\models\Project;
use yii\web\View;
use app\components\JsManager;
/**
 * @var $this View
 * @var $project Project;
 */
JsManager::instance()->registers([
    "js/models/yii.project.js"
]);
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax page-behind">
        <a class="link-page-behind" data-stack="" href="<?=$project->getViewUrl()?>"><?=$project->name?></a>
    </div>
    <div class="page page-1 simple-pjax">
        <div class="page-inner" data-page-name="项目设置" id="page-project-settings">
            <h3>项目设置</h3>
            <?php $form=ActiveForm::begin(["action"=>Url::to(["/project/edit","id"=>$project->id]),"options"=>[
                "class"=>"form form-project-edit",
            ]])?>
                <div class="form-item">
                    <div class="form-field">
                        <input type="text" name="Project[name]" id="project-name" placeholder="项目名称" value="<?=$project->name?>" <?=$project->archive?"disabled":""?>>
                    </div>
                </div>
                <div class="form-item">
                    <div class="form-field">
                        <textarea name="Project[description]" id="project-desc" placeholder="简单描述项目，便于其他人理解（选填）" <?=$project->archive?"disabled":""?>><?=$project->description?></textarea>
                    </div>
                </div>
                <div class="form-item allow-visitor-lock">
                    <div class="form-field">
                        <label>
                            <input type="checkbox" name="guest_lockable" <?=$project->archive?"disabled":""?>>
                            允许对访客隐藏敏感内容
                        </label>
                    </div>
                </div>
                <div class="form-item">
                    <button type="submit" id="btn-save-settings" class="btn btn-primary btn-submit" data-disable-with="正在保存..."
                            data-success-text="保存成功" <?=$project->archive?"disabled":""?>>保存设置
                    </button>
                    <button type="button" class="btn btn-primary success" style="display: none;" disabled>保存成功√</button>
        </div>
            <?php $form->end() ?>
            <?php if(!$project->archive){ ?>
            <div class="setting-section" id="section-custom">
                <h4>调整项目模块</h4>
                <p class="desc">你可以拖动模块调整位置，隐藏的模块可随时恢复。</p>
                <input type="hidden" id="project-sections-order" value="[0, 1, 2, 3, 4]">

                <div class="project-sections ui-sortable"
                     data-url="/projects/c96929b616cd4100a6225ea090264459/order_sections">
                    <ul class="sections" data-sort-url="<?=Url::to(["project/section-sort","id"=>$project->id])?>">
                        <?php foreach($project->getSectionIDs() as $sectionID){ ?>
                            <li id="section-<?=$sectionID?>" class="section" data-section="<?=$sectionID?>">
                                <i class="twr twr-comments-o"></i> <?=G::getContent($sectionID,"chinese")?>
                                <a href="<?=Url::to(["/project/toggle-section","id"=>$project->id,"sectionID"=>$sectionID])?>" class="link-toggle btn-project-toggle-section" data-callback="locate">
                                    <span>隐藏</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php foreach($project->getMissSectionIDs() as $sectionID){ ?>
                            <li id="section-<?=$sectionID?>" class="section disabled" data-section="<?=$sectionID?>">
                                <i class="twr twr-comments-o"></i> <?=G::getContent($sectionID,"chinese")?>
                                <a href="<?=Url::to(["/project/toggle-section","id"=>$project->id,"sectionID"=>$sectionID])?>" class="link-toggle btn-project-toggle-section" data-callback="locate">
                                    <span>显示</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="setting-section" id="section-webhooks">
                <h4>Webhooks</h4>
                <p class="desc">
                    使用 webhooks，你可以在
                    <a href="https://bearychat.com/" title="以团队为中心的沟通工具" target="_blank">BearyChat</a>、<a
                        href="https://pubu.im/" title="化繁为简，轻松整合你团队信息流的沟通服务" target="_blank">瀑布IM</a>
                    等工具上接收项目的最新动态。
                </p>

                <ul class="webhooks-list">
                </ul>

                <a href="/projects/c96929b616cd4100a6225ea090264459/webhooks/new" class="btn btn-mini" data-stack="">添加
                    webhook</a>
            </div>

            <div class="setting-section" id="section-archive">
                <h4>归档项目</h4>
                <p class="desc">项目归档后，所有的内容将变为只读，不能再修改。你只能通过激活操作，将项目重新恢复正常。</p>
                <a href="<?=Url::to(["project/toggle-archive","id"=>$project->id])?>" id="btn-archive-project"
                   class="btn btn-mini btn-project-toggle-archive" data-remote="true" data-cf="确定要归档 测试项目 吗？"
                   data-goto="/teams/93d89386a21248be83711dd878ef33cd/" data-goto-root="" data-loading="">了解，归档这个项目</a>
            </div>
            <?php }else{ ?>
                <div class="setting-section" id="section-archive">
                    <h4>激活项目</h4>
                    <p class="desc">激活项目后，所有的内容将可以正常操作。</p>
                    <a href="<?=Url::to(["project/toggle-archive","id"=>$project->id])?>" class="btn btn-mini btn-project-toggle-archive" data-remote="true" data-cf="确定要重新激活吗？">激活这个项目</a>
                </div>
            <?php } ?>

            <div class="setting-section" id="section-delete">
                <h4>删除项目</h4>
                <p class="desc">项目删除后，所有的内容也将被立刻删除，不能恢复。请谨慎操作</p>
                <button type="button" class="link-delete btn btn-mini" id="btn-del-project">了解风险，删除这个项目</button>
            </div>
        </div>
    </div>
</div>
