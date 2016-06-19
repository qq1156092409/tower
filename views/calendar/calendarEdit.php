<?php
use app\models\Calendar;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use app\components\JsManager;
/**
 * @var $this View
 * @var $calendar Calendar
 * @var $teamID int
 */
JsManager::instance()->registers('js/models/yii.calendar.js');
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root page-behind simple-pjax">
        <a class="link-page-behind" data-stack="" href="<?=Url::to(["/team/calendars","id"=>$calendar->teamID])?>" data-stack-fluid="">日历</a></div>
    <div class="page page-1 simple-pjax">
        <div class="page-inner" data-since="2015-05-13 08:34:52 UTC" data-page-name="日历设置" id="page-cal-settings">
            <h3>日历设置</h3>
            <?php $form=ActiveForm::begin([
                "id"=>"form-calendar-edit",
                "options"=>[
                    "class"=>"form form-calendar-save"
                ]
            ])?>
                <div class="form-item cal-name-field">
                    <input type="text" name="Calendar[name]" id="txt-cal-name" value="<?=$calendar->name?>" data-validate="required"
                           data-validate-msg="请填写日历名称" placeholder="日历名称">
                </div>
                <div class="form-item cal-color-field">
                    <div class="cal-colors">
                        <?php for($i=1;$i<=18;$i++){ ?>
                            <a class="link-cal-color btn-calendar-color2 cal-color-<?=$i?> <?=$i==$calendar->color?"selected":""?>" data-color="<?=$i?>" href="javascript:;">
                                <span><i class="twr twr-check"></i></span>
                            </a>
                        <?php } ?>
                    </div>
                    <input class="attr-color" type="hidden" name="Calendar[color]" value="<?=$calendar->color?>">
                </div>
                <div class="form-item cal-members-field">
                    <h4>哪些人可以访问日历？</h4>
                    <div class="manage-members">
                        <div class="add-member">
                            <div class="simple-select require-select">
                                <input type="text" class="select-result select-member" autocomplete="off" placeholder="点击添加成员">
                                <span class="link-expand" title="所有选项"> <i class="icon-caret-down"><span>▾</span></i> </span>
                                <span class="link-clear" title="清除选择"> <i class="icon-delete"><span>✕</span></i> </span>
                                <div class="select-list options-member" style="display: none;">
                                    <?php foreach($userTeams as $userTeam){ ?>
                                        <div class="select-item option-member" data-id="<?=$userTeam->id?>" data-subgroup="<?=$userTeam->subgroupID?>">
                                            <a href="javascript:;" class="label">
                                                <img src="https://avatar.tower.im/e3c6a3778cd64375b23ee6bfef70473c" class="avatar">
                                                <span><?=$userTeam->user->activeName?></span>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="group-select">
                                <span id="btn-subgroup-all" class="all btn-subgroup <?=$notSelectedSubgroupIDs?"":"selected"?>" data-id="-1" unselectable="on">所有人</span>
                                <?php foreach($subgroups as $subgroup){ ?>
                                    <span id="btn-subgroup-<?=$subgroup->id?>" class="btn-subgroup <?=in_array($subgroup->id,$notSelectedSubgroupIDs)?"":"selected"?>" data-id="<?=$subgroup->id?>" unselectable="on"><?=$subgroup->name?></span>
                                <?php } ?>
                            </div>
                        </div>

                        <ul class="members">
                            <?php foreach($userTeams as $userTeam){
                                echo $this->render("/commons/_member",[
                                    "model"=>$userTeam,
                                    "selected"=>in_array($userTeam->userID,$model->userIDs),
                                    "modelName"=>"Calendar",
                                ]);
                            } ?>
                        </ul>
                    </div>
                </div>
                <div class="buttons">
                    <button type="submit" id="btn-save-calendar" class="btn btn-primary" data-disable-with="正在保存...">
                        保存
                    </button>
                    <a href="<?=Url::to(["team/calendars","id"=>$calendar->teamID])?>" class="link-cancel">取消</a>
                </div>
            <?php $form->end()?>
        </div>
    </div>
</div>