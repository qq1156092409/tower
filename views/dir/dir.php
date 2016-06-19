<?php
use yii\helpers\Url;
use app\models\Dir;
use app\models\File;
use yii\web\View;
use yii\widgets\ActiveForm;
use \app\components\JsManager;
/**
 * @var $this View
 * @var $dir Dir
 * @var $multiples Dir[]|File[]
 */
$this->title=$dir->name."-".$dir->project->name;

JsManager::instance()->registers([
    'js/yii.dropdown.js',
    'js/models/yii.dir.js',
    'js/models/yii.file.js',
]);

?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax page-behind">
        <a class="link-page-behind" data-stack="" href="<?=$dir->project->getViewUrl()?>"><?=$dir->project->name?></a>
    </div>
    <div class="page page-1 simple-pjax page-behind">
        <a class="link-page-behind" data-stack="" href="<?=Url::to(["project/files","id"=>$dir->projectID])?>">所有的文件</a>
    </div>
    <div class="page page-2 simple-pjax">
        <div class="page-inner" data-droppable="" data-creator-guid="5ee2cb7e11e84bc2a5f8a627a14b46fe"
             data-project-creator="5ee2cb7e11e84bc2a5f8a627a14b46fe" data-page-name="设计图 - 测试项目"
             data-dir-guid="e9a931a6efc849d0b0604a19c5d83edc" id="page-folder">
            <div class="dir-title">
                <div class="crumb">
                    <a class="link-dir ui-droppable" href="<?=Url::to(["project/files","id"=>$dir->projectID])?>" data-guid="0" data-stack="" data-stack-replace="">文件</a>
                    <?php foreach($dir->getAncestors() as $parent){ ?>
                        <span class="separator twr twr-angle-right"></span>
                        <a class="link-dir ui-droppable" href="<?=Url::to(["/dir","id"=>$parent->id])?>" data-guid="e9a931a6efc849d0b0604a19c5d83edc" data-stack="" data-stack-replace=""><?=$parent->name?></a>
                    <?php } ?>
                    <span class="separator twr twr-angle-right"></span>
                    <span id="dir-edit-sub" class="current-dir"><?=$dir->name?></span>
                </div>

                <div class="btn-group">
                    <a href="javascript:;" class="btn btn-mini btn-upload-file"
                       data-url="/projects/c96929b616cd4100a6225ea090264459/uploads/"
                       style="position: relative; overflow: hidden; direction: ltr;">上传文件
                        <input id="file-upload" data-url="<?=Url::to(["/file/upload","projectID"=>$dir->projectID,"dirID"=>$dir->id])?>" multiple="multiple" type="file" title="上传文件" name="upload_file" tabindex="-1" style="position: absolute; right: 0px; top: 0px; font-family: Arial; font-size: 118px; margin: 0px; padding: 0px; cursor: pointer; opacity: 0;"></a>
                    <button class="btn btn-mini btn-dropdown-toggle">
                        <i class="twr twr-caret-down"></i>
                    </button>
                    <ul class="btn-dropdown-menu">
                        <li class="btn-local-upload" data-guid="c96929b616cd4100a6225ea090264459">
                            <a href="javascript:;" style="position: relative; overflow: hidden; direction: ltr;" class="file-upload-boot"><i class="twr twr-upload"></i> 上传文件 </a>
                        </li>
                        <li id="dir-create-show" class="btn-create-dir" data-guid="c96929b616cd4100a6225ea090264459"
                            data-dir-guid="e9a931a6efc849d0b0604a19c5d83edc"><a href="javascript:;"><i
                                    class="twr twr-folder-o"></i> 创建文件夹</a></li>
                    </ul>
                </div>
                <div class="rename-dir">
                    <?php $form=ActiveForm::begin([
                        "id"=>"dir-edit-form",
                        "action"=>Url::to(["/dir/edit","id"=>$dir->id]),
                        "options"=>[
                            "class"=>"form"
                        ]
                    ])?>
                        <div class="form-item">
                            <div class="form-field">
                                <input type="text" name="Dir[name]" class="no-border" data-validate="required;length:0,255"
                                       data-validate-msg="文件夹名称不能为空;文件夹名称最长255个字符" value="<?=$dir->name?>" id="txt-dir-name"
                                       placeholder="文件夹名称">
                            </div>
                        </div>
                        <div class="form-buttons">
                            <button tabindex="1" class="btn btn-mini" id="btn-rename-dir" type="submit"
                                    data-disable-with="正在保存...">保存
                            </button>
                            <a tabindex="2" href="javascript:;" class="btn btn-x" id="dir-edit-cancel">取消</a>
                        </div>
                    <?php $form->end()?>
                </div>
            </div>
            <div class="init init-file <?=$multiples?"hide":""?>">
                <div class="title">上传文件，便于整理和查找资料</div>
            </div>
            <div class="gallery-wrap files-view grid-view <?=$multiples?"":"hide"?>">
                <div class="switch-view">
                    <a href="javascript:;" class="link-view link-grid-view active">
                        <i class="twr twr-grid-view"></i>
                    </a>
                    <a href="javascript:;" class="link-view link-list-view">
                        <i class="twr twr-list-view"></i>
                    </a>
                </div>
                <div class="selected-info" style="display: none;">
                    <span class="selected-count">选择了<em>0</em>项</span>
                    <a href="javascript:;" class="link-move-file" data-project-guid="c96929b616cd4100a6225ea090264459"
                       data-move-url="/projects/c96929b616cd4100a6225ea090264459/dirs/move_in">移动</a>
                    <a href="javascript:;" class="link-cancel-select"><i class="twr twr-times"></i></a>
                </div>

                <div class="file-headers">
                    <div class="file-header name-header" data-sortable="">
                        <span>名称</span>
                        <i class="twr twr-sort-desc"></i>
                        <i class="twr twr-sort-asc"></i>
                    </div>
                    <div class="file-header size-header" data-sortable="">
                        <span>大小</span>
                        <i class="twr twr-sort-desc"></i>
                        <i class="twr twr-sort-asc"></i>
                    </div>
                    <div class="file-header update-time-header" data-sortable="">
                        <span>最后修改时间</span>
                        <i class="twr twr-sort-desc"></i>
                        <i class="twr twr-sort-asc"></i>
                    </div>
                </div>
                <div class="file-list gallery-wrap">
                    <?php $form=ActiveForm::begin([
                        "id"=>"dir-create-form",
                        "action"=>Url::to(["/dir/create"]),
                        "options"=>[
                            "class"=>"dir file-or-dir new empty",
                            "style"=>"display:none"
                        ]
                    ])?>
                        <input type="hidden" name="Dir[projectID]" value="<?=$dir->projectID?>" />
                        <input type="hidden" name="Dir[parentID]" value="<?=$dir->id?>" />
                        <div class="dir-name">
                            <div class="dir-icon">
                                <a href="javascript:;"></a>
                            </div>
                            <input name="Dir[name]" type="text" class="txt-dir-name no-border" value="新的文件夹" placeholder="输入文件夹名称">
                        </div>
                        <div class="dir-links">
                            <a href="javascript:;" class="link-submit-dir" id="dir-create-submit">创建</a>
                            <a href="javascript:;" class="link-cancel-dir" id="dir-create-cancel">取消</a>
                        </div>
                    <?php $form->end()?>
                    <?php
                    if($multiples){
                        $classView=[
                            Dir::className()=>"_dir",
                            File::className()=>"_file",
                        ];
                        foreach($multiples as $multiple){
                            echo $this->render("/commons/".$classView[$multiple->className()],["model"=>$multiple]);
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?=$this->render("/file/_uploadTemplate");?>