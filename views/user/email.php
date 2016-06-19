<?php
use app\models\UserLog;
/**
 * @var $teamID int
 * @var $userLog UserLog
 */
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax">
        <div class="page-inner page-member" id="page-member" data-guid="f4880b71a92642c293ca7efc1f2256d9"
             data-since="2015-04-08 07:38:17 UTC" data-page-name="方片周" data-self="true">
            <?=$this->render("_top",["teamID"=>$teamID,"userLog"=>$userLog,"flag"=>5])?>
            <p class="page-tips moveout inbox-moveout"></p>

            <div class="member-section member-mails">
                <ul class="mails">
                    <div class="init init-mails">
                        <i class="twr twr-envelope-o"></i>
                        <div class="title"><span id="txt-inbox-address">1632799080-895385@mailer.tower.im</span>是你的私人收件箱地址。你可以从邮箱、Evernote、微博客户端、百度网盘等应用，转发内容到这个地址，把重要的内容收集到
                            Tower，或者移动到项目里，跟团队分享和协作。<a href="https://tower.im/help_inbox" target="_blank">查看详细使用帮助</a></div>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</div>