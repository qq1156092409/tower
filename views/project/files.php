<?php
use app\models\File;
use app\models\Dir;
use app\models\Project;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use app\components\JsManager;

/**
 * @var $this View
 * @var $project Project
 * @var $multiples array
 */
$this->title = '所有的文件';
JsManager::instance()->registers([
    "js/yii.dropdown.js",
    "js/models/yii.dir.js",
    "js/models/yii.file.js",
]);
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax page-behind">
        <a class="link-page-behind" data-stack="" href="<?=$project->getViewUrl()?>"><?=$project->name?></a>
    </div>
    <div class="page page-1 simple-pjax">
        <div class="page-inner" data-since="2015-08-20 02:08:12 UTC" data-droppable=""
             data-project-creator="5ee2cb7e11e84bc2a5f8a627a14b46fe" data-page-name="所有的文件" id="page-attachments">
            <h3>
                <a class="title" href="<?=Url::to(["project/files","id"=>$project->id])?>" data-stack="">文件</a>
                <div class="btn-group">
                    <a href="javascript:;" class="btn btn-mini btn-upload-file" data-url="/projects/32b8fcd2b0f4438d8417277049491664/uploads" style="position: relative; overflow: hidden; direction: ltr;">上传文件<input id="file-upload" data-url="<?=Url::to(["/file/upload","projectID"=>$project->id,"dirID"=>0])?>" multiple="multiple" type="file" title="上传文件" name="upload_file" tabindex="-1" style="position: absolute; right: 0px; top: 0px; font-family: Arial; font-size: 118px; margin: 0px; padding: 0px; cursor: pointer; opacity: 0;"></a>
                    <button class="btn btn-mini btn-dropdown-toggle">
                        <i class="twr twr-caret-down"></i>
                    </button>
                    <ul class="btn-dropdown-menu">
                        <li class="btn-local-upload" data-guid="32b8fcd2b0f4438d8417277049491664"><a href="javascript:;" class="file-upload-boot" style="position: relative; overflow: hidden; direction: ltr;"><i class="twr twr-upload"></i> 上传文件</a></li>
                        <li id="dir-create-show" class="btn-create-dir"><a href="javascript:;"><i class="twr twr-folder-o"></i> 创建文件夹</a></li>
                    </ul>
                </div>
            </h3>
            <div class="files-view grid-view">
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
                    <a href="javascript:;" class="link-move-file" data-project-guid="32b8fcd2b0f4438d8417277049491664" data-move-url="/projects/32b8fcd2b0f4438d8417277049491664/dirs/move_in">移动</a>
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
                <div class="file-list">
                    <?php $form=ActiveForm::begin([
                        "id"=>"dir-create-form",
                        "action"=>Url::to(["/dir/create"]),
                        "options"=>[
                            "class"=>"dir file-or-dir new empty",
                            "style"=>"display:none"
                        ]
                    ])?>
                        <input type="hidden" name="Dir[projectID]" value="<?=$project->id?>" />
                        <input type="hidden" name="Dir[parentID]" value="<?=isset($currentDir)?$currentDir->id:0?>" />
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
