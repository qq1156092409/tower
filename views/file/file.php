<?php
use yii\helpers\Url;
use app\models\File;
use yii\web\View;
use app\components\JsManager;
/**
 * @var $this View
 * @var $file File
 * @var $teamID int
 */
$this->title=$file->name;
JsManager::instance()->registers(["js/models/yii.file.js"]);
?>
<div class="container workspace simple-stack simple-stack-transition">
<div class="page page-root simple-pjax page-behind">
    <a class="link-page-behind" href="<?= Url::to(["/project", "id"=>$file->project->id])?>"><?=$file->project->name?></a>
</div>
<div class="page page-1 simple-pjax">
<div class="page-inner " data-since="2015-04-21 00:48:14 UTC" data-guest-unlockable=""
     data-creator-guid="f4880b71a92642c293ca7efc1f2256d9" data-project-creator="f4880b71a92642c293ca7efc1f2256d9"
     data-page-name="<?=$file->name?>" id="page-file">
    <?php if($file->deleted){ ?>
    <div class="page-tip resource-deleted">
        这个文件已经于 <span title="2015年05月06日16:48:21"><?=date("Y-m-d",strtotime($file->lastOperation->create))?></span> 删除了
                <span data-visible-to="creator,admin">
                    ，你可以选择
                    <a id="btn-file-enable" class="file-toggle-enable" href="<?=Url::to(["file/toggle-enable","id"=>$file->id])?>" data-cf="确定要恢复这个文件吗？">恢复</a>
                </span>
    </div>
    <?php } ?>

<div class="topic">
    <div class="file-crumb">
        <span>路径：</span>

        <a class="link-dir" href="<?=Url::to(["project/files","projectID"=>$file->projectID,"teamID"=>$teamID])?>" data-guid="0" data-stack=""
           data-stack-replace="">文件</a>
        <?php if($file->dirs){foreach($file->dirs as $dir){ ?>
        <span class="separator">&gt;</span>
        <a class="link-dir" href="<?=Url::to(["project/files","projectID"=>$file->projectID,"teamID"=>$teamID,"parentID"=>$dir->id])?>"
           data-guid="4664f3ccf8694d80adc7edd28a3c2c41" data-stack="" data-stack-replace=""><?=$dir->name?></a>
        <?php }} ?>
    </div>

    <div class="file file-inline" data-creator-guid="f4880b71a92642c293ca7efc1f2256d9"
         data-guid="24a671d511494b3ca3279ee7b62b2c1c">
        <div class="file-subject">
            <h3 class="file-title-wrap" title="<?=$file->name?>">
                <span class="file-title"><?=$file->name?></span>
            </h3>

            <div class="file-title-change-form">
                <form class="form"
                      action="/projects/31cfd5556a4543b68cb489a242b1e9e7/uploads/c4257a94bc884ac58807e81221441931"
                      method="post" data-remote="true">
                    <div class="form-item">
                        <div class="form-field">
                            <input type="text" name="title" class="no-border" data-validate="required;length:0,255"
                                   data-validate-msg="文件名不能为空哦;文件名最长255个字符" value="<?=$file->name?>" id="file-title"
                                   placeholder="文件名" autofocus="1">
                        </div>
                    </div>
                    <div class="form-buttons">
                        <button tabindex="1" class="btn btn-mini" id="btn-post" type="submit"
                                data-disable-with="正在保存...">保存
                        </button>
                        <a tabindex="2" href="javascript:;" class="btn btn-x" id="link-cancel-post">取消</a>
                    </div>
                    <div class="form-item visitor-lock" data-visible-to="member">
                        <div class="form-field">
                            <label>
                                <input type="checkbox" name="invisible_for_visitor" class="cb-visitor-lock" value="1">
                                对访客隐藏这个文件
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="file-info">
                <p>
                    <span class="file-creator"><?=$file->user->activeName?></span>
                    <span class="create-time" title="<?=$file->create?>" data-readable-time="2015-04-17T14:14:40+08:00"><?=$file->fuzzyCreate?></span>上传
                    <span class="file-version">版本<?=$file->version?></span>
                    <span class="file-size"><?=$file->size?>B</span>
                </p>

                <p>
                    <a href="javascript:;" class="link-file-newver"
                       data-url="/projects/31cfd5556a4543b68cb489a242b1e9e7/uploads/c4257a94bc884ac58807e81221441931/revisions"
                       data-visible-to="admin,creator" title="为这个文件上传一个新的版本">上传新版本</a>
                    <a href="javascript:;" class="cancel-update-version">取消</a>
                </p>
            </div>
            <div class="file-size">

            </div>
        </div>

        <div class="file-main">
            <div class="file-thumb">
                <a href="https://attachments.tower.im/tower/24a671d511494b3ca3279ee7b62b2c1c?filename=%E4%BD%95%E9%9D%96%E8%B1%AA.avi.zip"
                   target="_blank" title="<?=$file->name?>">
                    <img alt="<?=$file->name?>" src="public/file_icons/file_extension_zip.png" class="file-icon">
                </a>
            </div>
        </div>
    </div>

</div>

<div class="detail-star-action">
    <a href="/projects/c96929b616cd4100a6225ea090264459/uploads/f3661947c20946d39963df01dad1dc4d/star?muid=f3661947c20946d39963df01dad1dc4d" class="detail-action detail-action-star" data-itemid="2064354" data-itemtype="Upload" data-loading="true" data-method="post" data-remote="true" rel="nofollow" title="关注">关注</a>
</div>
<div class="detail-actions">
    <div class="item item-download">
        <a href="https://attachments.tower.im/tower/8f750c95232d477883f030dc30926c35?download=true&amp;filename=tower.sql" class="detail-action detail-action-download">下载</a>
    </div>

    <div class="item">
        <a href="javascript:;" class="detail-action detail-action-edit">编辑</a>
    </div>

    <div class="item detail-action-move" data-visible-to="creator,admin">
        <a href="javascript:;" class="detail-action">移动</a>

        <div class="confirm">
            <form class="form form-move" action="/projects/c96929b616cd4100a6225ea090264459/uploads/f3661947c20946d39963df01dad1dc4d/move" method="post" data-remote="true">
                <p class="title">移动文件到项目</p>
                <p>
                    <select data-project="c96929b616cd4100a6225ea090264459" class="choose-projects loading"></select>
                    <input type="hidden" name="target_project_guid">
                </p>
                <p>
                    <button type="submit" class="btn btn-mini" disabled="" data-disable-with="正在移动...">移动</button>
                    <button type="button" class="btn btn-x cancel">取消</button>
                </p>
            </form>
        </div>
    </div>

    <div class="item" data-visible-to="creator,admin">
        <a href="/projects/c96929b616cd4100a6225ea090264459/uploads/f3661947c20946d39963df01dad1dc4d/destroy" class="detail-action detail-action-del" data-confirm="确定要删除这个文件吗？" data-goto="/projects/c96929b616cd4100a6225ea090264459/attachments" data-method="post" data-remote="true" data-stack-replace="true" rel="nofollow">删除</a>
    </div>
</div>
<div class="comments streams">
    <?php if($file->operations){
        foreach($file->operations as $operation){
            echo $this->render("/commons/_operation",["model"=>$operation]);
    }} ?>

</div>

<?=$this->render("/commons/_commentCreate",["target"=>$file])?>
</div>
</div>
    <input type="hidden" id="scenario" value="file-index" />
</div>