<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2015/8/7
 * Time: 21:27
 */
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax page-behind"><a class="link-page-behind" data-stack=""
                                                           href="/members/27e71406402a4a9388776055bcd4161b/settings/">个人设置</a>
    </div>
    <div class="page page-1 simple-pjax">
        <div class="page-inner" id="page-notification-settings" data-page-name="通知设置">
            <h3>通知设置</h3>

            <form class="form" action="/members/27e71406402a4a9388776055bcd4161b/notification_settings/" method="post"
                  data-remote="true">
                <div class="form-item">
                    <h4>桌面通知</h4>

                    <p class="desc">每当有与你相关的新动态，系统会弹出气泡提醒你<span class="info">（仅对 <a
                                href="https://www.google.com/intl/zh-CN/chrome/browser/" target="_blank">Chrome</a> 、<a
                                href="http://www.mozilla.org/zh-CN/firefox/new/" target="_blank">Firefox</a> 和 <a
                                href="http://www.apple.com/safari/" target="_blank">Safari</a> 浏览器有效）</span></p>

                    <div class="option option-off">
                        <label><input type="radio" id="radio-d18n-off" name="d18n" checked="" value="off">关闭桌面通知</label>
                    </div>
                    <div class="option option-on">
                        <label><input type="radio" id="radio-d18n-on" name="d18n" value="on">开启桌面通知</label>
                    </div>
                </div>

                <div class="form-item">
                    <h4>新动态通知邮件</h4>

                    <p class="desc">每当有与你相关的新动态，系统会给 1632799080@qq.com 发送邮件</p>

                    <div class="option option-off active">
                        <label><input type="radio" name="e16n" checked="" value="off">关闭新动态通知邮件</label>
                    </div>
                    <div class="option option-on ">
                        <label><input type="radio" name="e16n" value="on">开启新动态通知邮件</label>
                        <span class="choose-project ">[ <a href="javascript:;">指定项目</a> ]</span>
                        <span class="select-shortcut hide">
                            [ <a href="javascript:;" class="select-all">全选</a> | <a href="javascript:;"
                                                                                    class="select-none">全不选</a> ]
                        </span>

                        <div class="project-list hide">
                        </div>
                    </div>
                </div>

                <div class="form-item">
                    <h4>延期任务通知邮件</h4>

                    <p class="desc">关闭延期任务通知邮件之后，你将不会收到每日延期任务通知邮件</p>

                    <div class="option option-off">
                        <label><input type="radio" id="delay_todos_notify-off" name="delay_todos_notify" value="0">关闭延期任务通知邮件</label>
                    </div>
                    <div class="option option-on">
                        <label><input type="radio" id="delay_todos_notify-on" name="delay_todos_notify" checked=""
                                      value="1">开启延期任务通知邮件</label>
                    </div>
                </div>

                <div class="form-item">
                    <h4>智能提醒</h4>

                    <p class="desc">当网页版 tower.im 开着的时候，不发送通知邮件以及客户端消息推送。开启后可以避免重复消息的打扰</p>

                    <div class="option option-off">
                        <label><input type="radio" id="ai_notify-off" name="ai_notify" value="0">关闭智能提醒</label>
                    </div>
                    <div class="option option-on">
                        <label><input type="radio" id="ai_notify-on" name="ai_notify" checked="" value="1">网页在线时，不发送邮件通知和客户端推送</label>
                    </div>
                </div>

                <div class="form-buttons">
                    <button class="btn" id="btn-save" data-disable-with="正在保存..." data-success-text="保存成功">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
