<?php
use app\models\Project;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Event;
/**
 * @var $teamID int
 * @var $event Event
 */
$this->title="编辑日程";
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root page-behind simple-pjax">
        <a href="<?=Url::to(["team/calendars","id"=>$teamID])?>" class="link-page-behind" data-stack="" data-stack-fluid="">日历</a>
    </div>
    <div class="page page-1 simple-pjax">
        <div class="page-inner" data-since="2015-05-08 01:09:57 UTC" data-page-name="创建日程" id="page-calendar-event-new">
            <h3>编辑日程</h3>
            <div class="cal-event-form">
                <?php $form=ActiveForm::begin(["action"=>Url::to(["/event/edit","id"=>$event->id]),"options"=>["class"=>"form form-event form-event-edit"]])?>
                    <div class="form-item">
                        <textarea name="Event[name]" class="no-border" rows="1" placeholder="在这里输入日程内容" style="overflow: hidden; word-wrap: break-word; resize: none; height: 19px;"><?=$event->name?></textarea>
                    </div>
                    <div class="form-item">
                        <label>日历</label>
                        <select name="Event[calendarID]" name="event-calendar-id" id="select-cal">
                            <option value="" disabled="disabled">---日历---</option>
                            <?php foreach($commonCalendars as $calendar){ ?>
                                <option value="<?=$calendar->id?>" <?=$event->calendarID==$calendarID?"selected":""?>><?= $calendar->activeName ?></option>
                            <?php } ?>
                            <option value="" disabled="disabled">---项目---</option>
                            <?php foreach($projectCalendars as $calendar){ ?>
                                <option value="<?=$calendar->id?>" <?=$event->calendarID==$calendarID?"selected":""?>><?= $calendar->activeName ?></option>
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
                        <input class="link-start-date event-start" type="date" name="Event[start]" value="<?=date("Y-m-d",strtotime($event->start))?>" style="padding:2px 0" />
                    </div>

                    <div class="form-item event-time all-day">
                        <label>结束</label>
                        <input class="link-end-date event-end" type="date" name="Event[end]" value="<?=date("Y-m-d",strtotime($event->end))?>" style="padding:2px 0" />
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
                        <input type="text" name="Event[address]" id="txt-event-location" class="event-address" value="<?=$event->address?>">
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
                                <select id="select-add-member" style="display: none;"></select>

                                <div class="simple-select"><input type="text" class="select-result" autocomplete="off"
                                                                  placeholder="点击添加成员">
  <span class="link-expand" title="所有选项">
    <i class="icon-caret-down"><span>▾</span></i>
  </span>
  <span class="link-clear" title="清除选择">
    <i class="icon-delete"><span>✕</span></i>
  </span>

                                    <div class="select-list">

                                        <div class="select-item">
                                            <a href="javascript:;" class="label"><img
                                                    src="https://avatar.tower.im/b77fe6a1d67e4fc1863e3b860ca0815b"
                                                    class="avatar"><span>邓健强</span></a>
                                        </div>
                                        <div class="select-item">
                                            <a href="javascript:;" class="label"><img
                                                    src="<?=Url::to("public/default_avatars/winter.jpg")?>"
                                                    class="avatar"><span>邓健强小小号</span></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="group-select">
                                    <span class="all" data-subgroup="-1" unselectable="on"
                                          style="display: block;">所有人</span>
                                    <span data-subgroup="29773" unselectable="on" style="display: block;">美术3</span>
                                    <span data-subgroup="29741" unselectable="on" style="display: block;">策划</span>
                                </div>
                            </div>

                            <ul class="members">

                                <li class="member" data-guid="79a85cca56194bce8d0089acd25af308" data-subgroup="29741"
                                    data-shortcut-key="邓健强 dengjianqiang djq" title="邓健强">

                                    <img src="https://avatar.tower.im/b77fe6a1d67e4fc1863e3b860ca0815b" class="avatar"
                                         alt="邓健强">
                                    <span class="name">邓健强</span>


                                    <span class="role">成员 - 策划</span>

                                    <span class="remove-mask"></span>
                                    <span class="remove-text" unselectable="on">点击移除成员</span>
                                </li>
                                <li class="member" data-guid="1ff0fd3d4a404428a1594e9ebdb2360a" data-subgroup="29773"
                                    data-shortcut-key="邓健强小小号 dengjianqiangxiaoxiaohao djqxxh" title="邓健强小小号">

                                    <img src="<?=Url::to("public/default_avatars/winter.jpg")?>" class="avatar" alt="邓健强小小号">
                                    <span class="name">邓健强小小号</span>
                                    <span class="role">成员 - 美术3</span>
                                    <span class="remove-mask"></span>
                                    <span class="remove-text" unselectable="on">点击移除成员</span>
                                </li>
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
                        <button type="submit" class="btn btn-primary btn-save-event" data-disable-with="正在提交...">保存</button>
                        <a href="javascript:;" onclick="history.back();" class="link-cancel">取消</a>
                    </div>
                <?php $form->end()?>
            </div>
        </div>
    </div>
</div>