<?php
use app\models\Subgroup;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/**
 * @var $model Subgroup
 */
?>
<div id="subgroup-<?=$model->id?>" data-id="<?=$model->id?>" class="subgroup group ui-droppable <?=count($model->userTeams)>0?"":"member-empty"?>" data-guid="77681ce47793475581f4cff8eebc7576">
    <div class="group-hd">
        <h3>
            <span class="group-name subgroup-name"><?=$model->name?></span>
            <a href="javascript:void(0)" class="edit btn-subgroup-edit">编辑</a>
        </h3>
        <div class="group-form hide">
            <?php $form=ActiveForm::begin([
                "action"=>Url::to(["/subgroup/edit","id"=>$model->id]),
                "options"=>[
                    "class"=>"form form-subgroup-edit"
                ]
            ]) ?>
            <input name="Subgroup[name]" class="group-name subgroup-name" type="text" value="<?=$model->name?>" placeholder="例如：技术部、客服小组" data-validate="custom" data-blur-validate="false" data-validate-msg="">
                <button class="btn btn-primary group-edit-save" type="submit" data-disabled-with="正在保存...">保存</button>
                <button type="button" class="btn btn-x cancel btn-subgroup-edit-cancel btn-cancel" data-id="<?=$model->id?>">取消</button>
            <?php $form->end()?>
            <a href="<?=Url::to(["subgroup/destroy","id"=>$model->id])?>" class="btn btn-x del btn-subgroup-destroy" data-cf1="小组删除后组内成员不会受影响，确定删除？">或者，删除这个小组？</a>
        </div>
    </div>
    <div class="group-bd">
        <ul class="members">
            <?php if($model->userTeams){foreach($model->userTeams as $userTeam){
                echo $this->render("/team/members_member",["model"=>$userTeam]);
            }} ?>
        </ul>
        <div class="init init-empty">这个小组现在没有人，拖动成员过来即可加入</div>
    </div>
</div>