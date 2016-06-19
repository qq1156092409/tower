<?php
use yii\helpers\Html;
use yii\web\User;
/**
 * 指派弹窗
 * @var $users User[]
 */
$request=Yii::$app->request;
?>
<div id="pop-task-assign" class="simple-popover direction-right-bottom" style="top: 236px; left: 533.953125px;display:none;">
<div class="simple-popover-content">
<div class="todo-popover">
<form id="form-task-assign" action="" method="post">
<?= Html::hiddenInput($request->csrfParam, $request->getCsrfToken()) ?>
<input class="input-user-id" type="hidden" name="Task[userID]"/>
<div class="select-assignee">
    <h3>将任务指派给</h3>

    <div class="assignee-wrapper">
        <select id="txt-assignee" style="display: none;"></select>

        <div class="simple-select member-select selected">
            <input type="text" class="select-result" autocomplete="off" placeholder="输入成员姓名（缩写）">
            <span class="link-expand" title="所有选项">
                <i class="fa fa-caret-down"></i>
            </span>
            <span class="link-clear" title="清除选择">
                <i class="fa fa-times"></i>
            </span>

            <div class="select-list" style="display: none;">
                <?php foreach ($users as $user) { ?>
                    <div class="select-item" data-user="<?= $user->id ?>"
                         data-user-name="<?= $user->activeName ?><?= $user->id == \Yii::$app->user->id ? '（我自己）' : "" ?>">
                        <a href="javascript:;" class="label">
                            <img src="https://avatar.tower.im/b77fe6a1d67e4fc1863e3b860ca0815b" class="avatar">
                            <span><?= $user->activeName ?><?= $user->id == \Yii::$app->user->id ? '（我自己）' : "" ?></span>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="select-due-date">
<h3>任务截止时间</h3>

<div class="due-date-wrapper selected">
<input type="date" name="Task[endTime]" class="txt-due-date selected" placeholder="选择截止时间">
<a href="javascript:;" class="link-remove-due-date" title="取消截止时间"><span class="fa fa-times"></span></a>

<div class="due-date-picker">
<div class="cal-wrapper">
<div class="cal-shortcuts">
    <a href="javascript:;" class="link-cal-shortcut today">[今天]</a>
    <a href="javascript:;" class="link-cal-shortcut tomorrow">[明天]</a>
    <a href="javascript:;" class="link-cal-shortcut this-friday" title="本周星期五">[本周]</a>
    <a href="javascript:;" class="link-cal-shortcut next-friday" title="下周星期五">[下周]</a>
</div>
<input type="hidden" class="hidden-due-date" value="2015-03-01">

<div class="simple-datepicker" style="width: 168px;">
<div class="datepicker-header">
    <a href="javascript:;" class="fa fa-chevron-left datepicker-prev"></a>
    <a href="javascript:;" class="datepicker-title">2015 三月</a>
    <a href="javascript:;" class="fa fa-chevron-right datepicker-next"></a>
</div>
<div class="datepicker-yearmonth">
    <div class="datepicker-year-container">
        <ul class="datepicker-year-list">
            <li class="datepicker-year">
                <a href="javascript:;" class="" data-year="2010">
                    2010
                </a>
            </li>
            <li class="datepicker-year">
                <a href="javascript:;" class="" data-year="2011">
                    2011
                </a>
            </li>
            <li class="datepicker-year">
                <a href="javascript:;" class="" data-year="2012">
                    2012
                </a>
            </li>
            <li class="datepicker-year">
                <a href="javascript:;" class="" data-year="2013">
                    2013
                </a>
            </li>
            <li class="datepicker-year">
                <a href="javascript:;" class="" data-year="2014">
                    2014
                </a>
            </li>
            <li class="datepicker-year">
                <a href="javascript:;" class="selected" data-year="2015">
                    2015
                </a>
            </li>
            <li class="datepicker-year">
                <a href="javascript:;" class="" data-year="2016">
                    2016
                </a>
            </li>
            <li class="datepicker-year">
                <a href="javascript:;" class="" data-year="2017">
                    2017
                </a>
            </li>
            <li class="datepicker-year">
                <a href="javascript:;" class="" data-year="2018">
                    2018
                </a>
            </li>
            <li class="datepicker-year">
                <a href="javascript:;" class="" data-year="2019">
                    2019
                </a>
            </li>
            <li class="datepicker-year">
                <a href="javascript:;" class="" data-year="2020">
                    2020
                </a>
            </li>
            <li class="datepicker-year">
                <a href="javascript:;" class="" data-year="2021">
                    2021
                </a>
            </li>
            <li class="datepicker-year">
                <a href="javascript:;" class="" data-year="2022">
                    2022
                </a>
            </li>
            <li class="datepicker-year">
                <a href="javascript:;" class="" data-year="2023">
                    2023
                </a>
            </li>
            <li class="datepicker-year">
                <a href="javascript:;" class="" data-year="2024">
                    2024
                </a>
            </li>
        </ul>
    </div>
    <div class="datepicker-month-container">
        <ul class="datepicker-month-list">
            <li class="datepicker-month">
                <a href="javascript:;" class="" data-month="0">
                    1月
                </a>
            </li>
            <li class="datepicker-month">
                <a href="javascript:;" class="" data-month="1">
                    2月
                </a>
            </li>
            <li class="datepicker-month">
                <a href="javascript:;" class="selected" data-month="2">
                    3月
                </a>
            </li>
            <li class="datepicker-month">
                <a href="javascript:;" class="" data-month="3">
                    4月
                </a>
            </li>
            <li class="datepicker-month">
                <a href="javascript:;" class="" data-month="4">
                    5月
                </a>
            </li>
            <li class="datepicker-month">
                <a href="javascript:;" class="" data-month="5">
                    6月
                </a>
            </li>
            <li class="datepicker-month">
                <a href="javascript:;" class="" data-month="6">
                    7月
                </a>
            </li>
            <li class="datepicker-month">
                <a href="javascript:;" class="" data-month="7">
                    8月
                </a>
            </li>
            <li class="datepicker-month">
                <a href="javascript:;" class="" data-month="8">
                    9月
                </a>
            </li>
            <li class="datepicker-month">
                <a href="javascript:;" class="" data-month="9">
                    10月
                </a>
            </li>
            <li class="datepicker-month">
                <a href="javascript:;" class="" data-month="10">
                    11月
                </a>
            </li>
            <li class="datepicker-month">
                <a href="javascript:;" class="" data-month="11">
                    12月
                </a>
            </li>
        </ul>
    </div>
</div>
<table class="calendar">
<tbody>
<tr class="datepicker-dow">
    <td>一</td>
    <td>二</td>
    <td>三</td>
    <td>四</td>
    <td>五</td>
    <td>六</td>
    <td>日</td>
</tr>
<tr class="days">
    <td class="datepicker-day">
        <a href="javascript:;" class="day others" data-date="2015-02-23">
            23
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day others" data-date="2015-02-24">
            24
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day others" data-date="2015-02-25">
            25
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day others" data-date="2015-02-26">
            26
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day others" data-date="2015-02-27">
            27
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="sat others" data-date="2015-02-28">
            28
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="sun selected" data-date="2015-03-01">
            1
        </a>
    </td>
</tr>
<tr class="days">
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-02">
            2
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day today" data-date="2015-03-03">
            3
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-04">
            4
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-05">
            5
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-06">
            6
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="sat" data-date="2015-03-07">
            7
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="sun" data-date="2015-03-08">
            8
        </a>
    </td>
</tr>
<tr class="days">
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-09">
            9
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-10">
            10
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-11">
            11
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-12">
            12
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-13">
            13
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="sat" data-date="2015-03-14">
            14
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="sun" data-date="2015-03-15">
            15
        </a>
    </td>
</tr>
<tr class="days">
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-16">
            16
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-17">
            17
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-18">
            18
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-19">
            19
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-20">
            20
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="sat" data-date="2015-03-21">
            21
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="sun" data-date="2015-03-22">
            22
        </a>
    </td>
</tr>
<tr class="days">
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-23">
            23
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-24">
            24
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-25">
            25
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-26">
            26
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-27">
            27
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="sat" data-date="2015-03-28">
            28
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="sun" data-date="2015-03-29">
            29
        </a>
    </td>
</tr>
<tr class="days">
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-30">
            30
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day" data-date="2015-03-31">
            31
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day others" data-date="2015-04-01">
            1
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day others" data-date="2015-04-02">
            2
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="day others" data-date="2015-04-03">
            3
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="sat others" data-date="2015-04-04">
            4
        </a>
    </td>
    <td class="datepicker-day">
        <a href="javascript:;" class="sun others" data-date="2015-04-05">
            5
        </a>
    </td>
</tr>
</tbody>
</table>
</div>
</div>
<div class="shortcuts-wrapper">
    <a href="javascript:;" class="link-date-shortcut today" data-shortcut="today|td|jintian|jt|今天">今天，2015-03-03</a>
    <a href="javascript:;" class="link-date-shortcut tomorrow"
       data-shortcut="tomorrow|tm|mingtian|mt|明天">明天，2015-03-04</a>
    <a href="javascript:;" class="link-date-shortcut after-tomorrow" data-shortcut="houtian|ht|dat|后天">后天，2015-03-05</a>
    <a href="javascript:;" class="link-date-shortcut monday" data-shortcut="monday|zhouyi|xingqiyi|zy|xqy|周一|星期一|1">星期一，2015-03-09</a>
    <a href="javascript:;" class="link-date-shortcut tuesday" data-shortcut="tuesday|zhouer|xingqier|ze|xqe|周二|星期二|2">星期二，2015-03-03</a>
    <a href="javascript:;" class="link-date-shortcut wednesday"
       data-shortcut="wednesday|zhousan|xingqisan|zs|xqs|周三|星期三|3">星期三，2015-03-04</a>
    <a href="javascript:;" class="link-date-shortcut thursday" data-shortcut="thursday|zhousi|xingqisi|zs|xqs|周四|星期四|4">星期四，2015-03-05</a>
    <a href="javascript:;" class="link-date-shortcut friday" data-shortcut="friday|zhouwu|xingqiwu|zw|xqw|周五|星期五|5">星期五，2015-03-06</a>
    <a href="javascript:;" class="link-date-shortcut saturday"
       data-shortcut="saturday|zhouliu|xingqiliu|zl|xql|周六|星期日|6">星期六，2015-03-07</a>
    <a href="javascript:;" class="link-date-shortcut sunday" data-shortcut="sunday|zhouri|xingqiri|zr|xqr|周日|星期日|7">星期日，2015-03-08</a>
</div>
</div>
</div>
</div>
<!--<div class="popover-buttons">-->
<!--<button type="button" class='btn btn-submit-popover'>确&nbsp;&nbsp;定</button>-->
<!--</div>-->
</form>
</div>
</div>
<div class="simple-popover-arrow" style="top: 16px;">
    <i class="arrow arrow-shadow-1"></i>
    <i class="arrow arrow-shadow-0"></i>
    <i class="arrow arrow-border"></i>
    <i class="arrow arrow-basic"></i>
</div>
</div>