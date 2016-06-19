<?php
use yii\web\View;
use app\models\Team;
/**
 * @var $this View
 * @var $teamID int
 * @var $team Team
 */
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root page-behind simple-pjax">
        <a href="<?=\yii\helpers\Url::to(["team/members","id"=>$teamID])?>" class="link-page-behind" data-stack="">团队</a>
    </div>
    <div class="page page-1 simple-pjax">
        <div class="page-inner" id="page-invite-new" data-page-name="添加新成员">
            <h3>添加新成员</h3>
            <div class="section">
                <h5 class="title">通过公开链接，快速邀请</h5>
                <p class="desc">将下面的公共邀请链接通过QQ，微信等任何方式发给同事，即可点击申请加入团队。（申请需团队管理员审核并分配访问权限）</p>
                <p class="join-link">
                    <span id="invite-join-link"><?=\yii\helpers\Url::to(["team/apply","code"=>$team->activeCode],"http")?></span>
                    <span id="btn-copy" style="visibility: visible;" class="">复制</span>
                </p>
                <p class="caution">
                    <em>注意：</em>任何看到邀请链接的人，都可以申请加入团队。意外泄漏请
                    <a href="<?=\yii\helpers\Url::to(["team/code-reset","teamID"=>$team->id])?>" class="btn-reset-invite-token" data-cf="此操作将导致当前邀请链接失效，确定要重新生成邀请链接吗？" data-loading="true" data-remote="true" rel="nofollow">重新生成邀请链接</a>
                </p>
            </div>

            <div class="section">
                <h5 class="title">通过邮件邀请，无需审核</h5>
                <p class="desc">你可以预先设置好访问权限，发送邀请给指定的邮箱，对方只需进行个人帐号设置即可直接加入团队，无需等待审批。</p>
                <p class="email-invite">
                    <a href="/teams/16670002c3294dabaebdf1c0fa1c7194/invite" data-stack="">通过邮件邀请新成员 →</a>
                </p>
            </div>

            <div class="section">
                <h5 class="title">通过微信扫码，邀请好友</h5>
                <p class="desc">用微信扫描二维码获取邀请函，转发给微信好友/群，即可邀请他们加入你的团队。</p>
                <div class="wechat-invite">
                    <div class="qrcode-wrap" data-url="/wechat/qrcode?type=8">
                        <img class="qrcode" alt="微信双保险二维码" title="扫描这个二维码获取微信邀请函" src="<?=$team->wechatQr?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
