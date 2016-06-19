<?php
use app\models\Project;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/**
 * @var $teamID int
 */
$this->title="创建日程";
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root page-behind simple-pjax">
        <a href="<?=Url::to(["team/calendars","id"=>$teamID])?>" class="link-page-behind" data-stack="" data-stack-fluid="">日历</a>
    </div>
    <div class="page page-1 simple-pjax">
        <div class="page-inner" data-since="2015-05-08 01:09:57 UTC" data-page-name="创建日程" id="page-calendar-event-new">
            <h3>创建日程</h3>
            <div class="cal-event-form">
                <?php $form=ActiveForm::begin(["action"=>Url::to(["/event/create","teamID"=>$teamID]),"options"=>["class"=>"form form-event form-event-create"]])?>
                    <div class="form-item">
                        <textarea name="Event[name]" class="no-border" rows="1" placeholder="在这里输入日程内容" style="overflow: hidden; word-wrap: break-word; resize: none; height: 19px;"></textarea>
                    </div>
                    <div class="form-item">
                        <label>日历</label>
                        <select name="Event[calendarID]" name="event-calendar-id" id="select-cal">
                            <option value="" disabled="disabled">---日历---</option>
                            <?php foreach($commonCalendars as $calendar){ ?>
                                <option value="<?=$calendar->id?>" <?=$calendar->id==$calendarID?"selected":""?>><?= $calendar->activeName ?></option>
                            <?php } ?>
                            <option value="" disabled="disabled">---项目---</option>
                            <?php foreach($projectCalendars as $calendar){ ?>
                                <option value="<?=$calendar->id?>" <?=$calendar->id==$calendarID?"selected":""?>><?= $calendar->activeName ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="caleventable_type" value="Project">
                    </div>

                    <div class="form-item">
                        <label>类型</label>
                        <label class="all-day-event">
                            <input type="checkbox" class="cb-all-day">
                            全天事件
                        </label>
                    </div>

                    <div class="form-item event-time all-day">
                        <label>开始</label>
                        <input class="link-start-date event-start" type="date" name="Event[start]" value="<?=date("Y-m-d")?>" style="padding:2px 0" />
                    </div>

                    <div class="form-item event-time all-day">
                        <label>结束</label>
                        <input class="link-end-date event-end" type="date" name="Event[end]" value="<?=date("Y-m-d")?>" style="padding:2px 0" />
                    </div>

                    <div class="form-item event-schedule-every">
                        <label>重复</label>
                        <select class="cb-repeat" name="schedule_every" id="select-schedule-every">
                            <option value="0">不重复</option>
                            <option value="4">每日重复</option>
                            <option value="2">每周重复</option>
                            <option value="3">每月重复</option>
                            <option value="1">每年重复</option>
                        </select>
                    </div>

                    <div class="form-item event-schedule-until until-active hide">
                        <label>直到</label>
                        <a href="javascript:;" class="link-until" title="点击修改重复事件的结束日期，最长重复一年" data-date="2015-05-08">
                            2015/05/08
                        </a>
                        <input type="hidden" name="schedule_until" value="2015-05-08 23:59:59">
                    </div>

                    <div class="form-item event-remind">
                        <label>提醒</label>
                        <select id="select-remind" name="remind_time">
                            <option value="">不提醒</option>
                            <option value="2015-05-07T23:00:00+08:00" class="one-hour-ahead">提前一小时</option>
                            <option value="2015-05-07T00:00:00+08:00" class="one-day-ahead">提前一天</option>
                            <option value="2015-05-01T00:00:00+08:00" class="one-week-ahead">提前一周</option>
                        </select>
                    </div>

                    <div class="form-item event-location">
                        <label>地点</label>
                        <input type="text" name="Event[address]" id="txt-event-location" class="event-address" value="">
                    </div>

                    <div class="form-item event-show-creator">
                        <label>
                            <input type="checkbox" name="is_show_creator" checked="">
                            在月视图显示创建者
                        </label>
                    </div>
                    <div class="form-item cal-members-field">
                        <h4>邀请其他人参与</h4>
                        <div class="manage-members">
                            <div class="add-member">
                                <div class="simple-select require-select">
                                    <input type="text" class="select-result" autocomplete="off" placeholder="点击添加成员">
                                        <span class="link-expand" title="所有选项">
                                            <i class="icon-caret-down"><span>▾</span></i>
                                        </span>
                                        <span class="link-clear" title="清除选择">
                                            <i class="icon-delete"><span>✕</span></i>
                                        </span>
                                    <div class="select-list" style="display: none;">
                                        <?php foreach($userTeams as $userTeam){ ?>
                                            <div class="select-item" data-id="<?=$userTeam->id?>" data-subgroup="<?=$userTeam->subgroupID?>">
                                                <a href="javascript:;" class="label">
                                                    <img src="https://avatar.tower.im/e3c6a3778cd64375b23ee6bfef70473c" class="avatar">
                                                    <span><?=$userTeam->user->activeName?></span>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <select id="select-add-member" style="display: none;">
                                    <option value="974ae2692d83457aa0c6068600674b43"
                                            data-guid="974ae2692d83457aa0c6068600674b43"
                                            data-key="邓健强 dengjianqiang djq" data-subgroup="35628"
                                            data-gavatar="https://avatar.tower.im/e3c6a3778cd64375b23ee6bfef70473c">
                                        邓健强
                                    </option>
                                    <option value="2e5c91f6db0e4b9eab25e406940e211d"
                                            data-guid="2e5c91f6db0e4b9eab25e406940e211d"
                                            data-key="邓健强小小号 dengjianqiangxiaoxiaohao djqxxh" data-subgroup="35629"
                                            data-gavatar="<?=Url::to("public/default_avatars/winter.jpg")?>">
                                        邓健强小小号
                                    </option>
                                </select>

                                <div class="group-select">
                                    <span id="btn-subgroup-all" class="all" data-subgroup="-1" unselectable="on">所有人</span>
                                    <?php foreach($subgroups as $subgroup){ ?>
                                        <span id="btn-subgroup-<?=$subgroup->id?>" data-subgroup="<?=$subgroup->id?>" unselectable="on"><?=$subgroup->name?></span>
                                    <?php } ?>
                                </div>
                            </div>

                            <ul class="members">
                                <?php foreach($userTeams as $userTeam){
                                    echo $this->render("/commons/_member",["model"=>$userTeam]);
                                } ?>
                            </ul>
                        </div>
                    </div>

                    <div class="form-item visitor-lock" data-visible-to="member" style="display: none;">
                        <div class="form-field">
                            <label>
                                <input type="checkbox" name="invisible_for_visitor" class="cb-visitor-lock">
                                对访客隐藏这个日程
                            </label>
                        </div>
                    </div>

                    <div class="buttons">
                        <button type="submit" class="btn btn-primary btn-save-event" data-disable-with="正在提交...">添加
                        </button>
                        <a href="javascript:;" onclick="history.back();" class="link-cancel">取消</a>
                    </div>
                <?php $form->end()?>
            </div>
        </div>
    </div>
</div>