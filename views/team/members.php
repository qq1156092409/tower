<?php
use yii\web\View;
use app\models\Subgroup;
use app\models\UserTeam;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\components\JsManager;
/**
 * @var $this View
 * @var $teamID int
 * @var $subgroups Subgroup[]
 * @var $noGroupUserTeams UserTeam[]
 */
$request=Yii::$app->request;
$this->params["active"]=5;
JsManager::instance()->registers([
    'js/models/yii.subgroup.js',
    'js/models/yii.userTeam.js',
]);

?>
<style>
    .member-empty .init-empty{display:block}
    .init-empty{display: none}
</style>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax">
        <div class="page-inner" id="page-members" data-page-name="团队">

            <div class="group group-default ui-droppable" data-guid="0">
                <ul class="members">
                    <li class="member member-invite">
                        <a href="<?=\yii\helpers\Url::to(["team/member-create","teamID"=>$teamID])?>" class="member-link new" data-stack="">
                            <img alt="邀请新成员" class="avatar" src="public/new-member-68c15bb337983952decc322a4fb11c7b.png">
                            <span class="name">添加新成员</span>
                        </a>
                    </li>
                    <?php if($noGroupUserTeams){ foreach($noGroupUserTeams as $userTeam){
                        echo $this->render("members_member",["model"=>$userTeam]);
                    }} ?>
                </ul>
            </div>
            <div id="subgroup-list" class="grouplists ui-sortable" data-sort-url="<?=Url::to(["/subgroup/sort"])?>">
                <?php if($subgroups){foreach($subgroups as $subgroup){
                    echo $this->render("/commons/_subgroup",["model"=>$subgroup]);
                }} ?>
                <div class="group group-new">
                    <div class="group-hd">
                        <a class="group-new-action btn-subgroup-create" href="javascript:;" title="点击这里创建小组">+ 新建小组</a>
                        <div class="group-form hide">
                            <?php $form=ActiveForm::begin(["action"=>Url::to(["/subgroup/create","teamID"=>$teamID]),"options"=>["class"=>"form form-subgroup-create"]])?>
                                <input name="Subgroup[name]" class="group-name subgroup-name" type="text" placeholder="例如：技术部、客服小组"
                                       data-validate="custom" data-blur-validate="false" data-validate-msg="">
                                <button class="btn btn-primary group-edit-save" type="submit"
                                        data-disabled-with="正在保存...">保存
                                </button>
                                <button type="button" class="btn btn-x cancel btn-cancel btn-subgroup-create-cancel">取消</button>
                            <?php $form->end()?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
