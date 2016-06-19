<?php
use yii\helpers\Html;
use yii\helpers\Url;
/**
 * @var $teamID int
 * @var $active int 当前选中
 */
$teamID or $teamID=$this->params["teamID"];
$teamID or $teamID=Yii::$app->request->getQueryParam("teamID");
$team = \app\models\Team::findOne($teamID);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?=\Yii::$app->charset ?>">
    <title>basic-tower</title>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="baidu-site-verification" content="qLDoHdGnb64RHlkm">
    <meta name="alexaVerifyID" content="SIgQikd9LazsFz9M1vPBaQyC4Gw">
    <link rel="shortcut icon" href="https://tower.im/favicon.ico" type="image/x-icon">
    <link rel="icon" href="https://tower.im/favicon.ico" sizes="32x32">
    <link rel="icon" href="https://tower.im/favicon.ico" sizes="64x64">
    <link rel="icon" href="https://tower.im/favicon.ico" sizes="128x128">
    <link rel="apple-touch-icon-precomposed" href="https://tower.im/assets/mobile/icon/icon@512-c8090c0961c63b1549cd19d714c6b69e.png">
    <link rel="search" type="application/opensearchdescription+xml" title="Tower" href="https://tower.im/opensearch.xml">
    <link href="public/application-404f5efaeb2aead3434d85ff01eddcef.css" media="all" rel="stylesheet" type="text/css">
    <meta content="authenticity_token" name="csrf-param">
    <meta content="4dfXAA4JPqtdwFJQj7Cz1LvsJXkcXSSB3HRfK66rfro=" name="csrf-token">
    <script src="<?=\yii\helpers\Url::to("js/jquery-2.1.1.js")?>"></script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrapper">
    <div class="header">
        <h1 class="logo">
            <a href="javascript:;" class="link-team-menu">
                <span class="name"><?=$team->name?></span>
                <i class="twr twr-caret-down"></i>
            </a>
        </h1>
        <ul class="nav">
            <li id="nav-project" class="<?=$this->params["active"]==1?"active":""?>">
                <a href="<?=\yii\helpers\Url::to(["team/projects","teamID"=>$teamID])?>" data-stack="" data-stack-root="">项目</a>
            </li>
            <li id="nav-events" class="<?=$this->params["active"]==2?"active":""?>">
                <a href="<?=\yii\helpers\Url::to(["team/operations","teamID"=>$teamID])?>" data-stack="" data-stack-root="">动态</a>
            </li>
            <li id="nav-week" class="<?=$this->params["active"]==3?"active":""?>">
                <a href="javascript:void(0)" data-stack="" data-stack-root="">周报</a>
            </li>
            <li id="nav-calendar" class="<?=$this->params["active"]==4?"active":""?>">
                <a href="javascript:void(0)" data-stack="" data-stack-fluid="" data-stack-root="">日历</a>
            </li>
            <li id="nav-members" class="<?=$this->params["active"]==5?"active":""?>">
                <a href="<?=Url::to(["team/members","teamID"=>$teamID])?>" data-stack="" data-stack-root="">团队</a>
            </li>
            <li id="nav-me" class="<?=$this->params["active"]==6?"active":""?>">
                <a href="<?=\yii\helpers\Url::to(["me/tasks","teamID"=>$teamID])?>" data-stack="" data-stack-root="">我自己</a>
            </li>
        </ul>
        <div class="command-bar">
            <div class="search-wrap">
                <a href="javascript:;" class="link-search" title="搜索"><span class="icon-search"></span></a>
                <form id="form-search" class="form" method="get"
                      action="https://tower.im/teams/67786d3c380f46bbad08c033043d77ab/search">
                    <input id="txt-search" type="text" class="keyword no-border" name="keyword" placeholder="搜索">
                </form>
            </div>
            <div class="notification-info">
                <a class="link" href="/teams/16670002c3294dabaebdf1c0fa1c7194/notifications/" data-stack="" data-stack-root="">通知</a>
                <a href="javascript:;" id="notification-count" class="label " title="新的通知" data-unread-count="0" data-url="/teams/16670002c3294dabaebdf1c0fa1c7194/notifications/unread_counts">
                    <span class="twr twr-bell-o bell"></span>
                    <span class="num">0</span>
                </a>
                <div class="noti-pop">
                    <div class="noti-pop-hd">
                        <span class="title">通知</span>
                        <a class="noti-settings" href="/members/f4880b71a92642c293ca7efc1f2256d9/notification_settings/" title="设置通知发送方式" data-stack="" data-stack-root="">通知设置</a>
                        <a id="noti-mark-read" class="mark-as-read" href="javascript:;" title="全部标记为已读">全部标为已读</a>
                    </div>
                    <div class="noti-pop-list notification-list">

                    </div>
                    <div class="noti-pop-empty">- 没有新通知 -</div>
                    <div class="noti-pop-action">
                        <a class="noti-all-link" href="/teams/16670002c3294dabaebdf1c0fa1c7194/notifications/" data-stack="" data-stack-root="">查看全部</a>
                    </div>
                </div>
            </div>
            <div class="account-info">
                <div class="member-settings">
                    <a class="link-member-menu" href="javascript:;" title="邓健强">
                        <img class="avatar" src="public/b77fe6a1d67e4fc1863e3b860ca0815b" alt="邓健强">
                        <span class="fa fa-caret-down"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?=$content?>
    <div class="footer">
        © <a href="http://mycolorway.com/" target="_blank">彩程设计</a>
    </div>
</div>

<input type="hidden" id="d18n-enabled" value="true">
<input type="hidden" id="server-time" value="2015-01-31 08:35:12">
<input type="hidden" id="team-guid" value="67786d3c380f46bbad08c033043d77ab">
<input type="hidden" id="team-name" value="wmzz">
<input type="hidden" id="team-enable-pusher" value="true">
<input type="hidden" id="user-visit-welcome-project-before" value="true">
<input type="hidden" id="user-email" value="1156092409@qq.com">
<input type="hidden" id="unused-bubbles" value="11">
<input type="hidden" id="member-id" value="200576">
<input type="hidden" id="member-guid" value="c24e8e36ccaf43b787229ff595efc41d">
<input type="hidden" id="member-nickname" value="邓健强">
<input type="hidden" id="member-avatar" value="https://avatar.tower.im/b77fe6a1d67e4fc1863e3b860ca0815b">
<input type="hidden" id="member-timezone" value="Asia/Shanghai">
<input type="hidden" id="conn-guid" value="7960bf3954bf30399fe57da65f3179de">
<input type="hidden" id="beta" value="false">
<a href="https://tower.im/help" target="_blank" id="link-feedback">
    <i class="twr twr-weixin"></i>帮助
</a>
<textarea tabindex="-1" style="position: absolute; top: -999px; left: 0px; right: auto; bottom: auto; border: 0px; box-sizing: content-box; word-wrap: break-word; overflow: hidden; height: 0px !important; min-height: 0px !important;"></textarea>
<!-- 微信在线客服 -->
<div class="simple-popover wechat-qrcode-popover direction-right-bottom active" style="top: 165px; left: 45px;display:none">
    <div class="simple-popover-content">
        <h5>微信在线客服</h5>
        <p><img alt="Wechat_qrcode" src="https://tower.im/assets/wechat_qrcode-0f35050697637bcc5bbc1cd5e306ea64.jpg"/></p>
        <p class="desc">扫码获取帮助</p>
    </div>
    <div class="simple-popover-arrow" style="top: 16px;">
        <i class="arrow arrow-shadow-1"></i>
        <i class="arrow arrow-shadow-0"></i>
        <i class="arrow arrow-border"></i>
        <i class="arrow arrow-basic"></i>
    </div>
</div>
<a id="btn-back-to-top" class="back-to-top" href="javascript:;" title="返回顶部" style="display: none">返回顶部</a>
<script>
    $(function(){
        //搜索框
        $(".link-search").click(function(e){
            if(!$(this).parent().hasClass("active")){
                $(this).parent().addClass("active");
            }
            $("#txt-search").focus();
        });
        $("#txt-search").blur(function(){
            $(".search-wrap").removeClass("active");
        });
        //个人设置
        $(".link-member-menu").click(function(e){
            e.preventDefault();
            e.stopPropagation();
            if($("body>.popover-member-menu").size()<1){
                $(document.body).append($("#tpl-member-menu").html());
            }
        });
        $(document).click(function(e){
            $("body>.popover-member-menu").remove();
            $(".noti-pop").hide();
        });
        //微信帮助
        var $wechatQrcodePopover=$(".wechat-qrcode-popover");
        $(".twr-weixin").mouseenter(function(e){
            $wechatQrcodePopover.show();
            $wechatQrcodePopover.css("top",($(this).offset().top-10)+"px");
        }).mouseleave(function(e){
            $wechatQrcodePopover.hide();
        });
        //2014
        $(".link-wechat-2014").click(function(e){
            $(document.body).append($("#tpl-wechat-2014-dialog").html());
        });
        $(document).on("click",".simple-dialog-remove",function(e){
            $(".simple-dialog").remove();
            $(".simple-dialog-modal").remove();
        });
        //通知
        $("#notification-count").click(function(e){
            e.preventDefault();
            $(".noti-pop").show();
            e.stopPropagation();
        });
        $(".noti-pop").click(function(e){
            e.stopPropagation();
        });
        //btn-back-to-top
        $("#btn-back-to-top").click(function(e){
            $(document.body).animate({scrollTop:0}, 'slow');
        });
        $(window).scroll(function(e){
            if($(window).scrollTop()>2000){
                $("#btn-back-to-top").show();
            }else{
                $("#btn-back-to-top").hide();
            }
        });
    });
</script>

<script type="text/html" id="tpl-wechat-2014-dialog">
    <div class="simple-dialog dialog-new-feature dialog-wechat-2014" style="width: 380px; height: auto; margin-left: -191px; margin-top: -247px;">
        <a class="simple-dialog-remove" href="javascript:;"><i class="fa fa-times"></i></a>
        <div class="simple-dialog-wrapper">
            <div class="simple-dialog-content" style="height: 452px;">
                <div class="main">
                    <img class="title" src="https://tower.im/assets/wechat-2014/2014-title-0d0ac05d3d0e16637151dfa01778addf.png" width="280" height="55">
                    <h1>暗自定下的目标，<br>你都已实现了么？</h1>
                    <div class="qrcode-wrap">
                        <img class="qrcode" alt="微信扫码查看完整报告" title="微信扫码查看完整报告" src="https://webapi.tower.im/webapi/common/ticket?scene_id=117649&amp;scene_type=7&amp;auth_version=1.0&amp;auth_key=tower&amp;auth_timestamp=1422929243&amp;auth_signature=28b9a346e19f99baba5ee750c18a4cd1c48ebe2eb7b0dd378e8627485e8d3821">
                    </div>
                    <p class="qrcode-desc">微信扫码查看完整报告</p>
                </div>
            </div>
        </div>
        <div></div>
    </div>
    <div class="simple-dialog-modal" style="cursor: default;"></div>
</script>
<script type="text/html" id="tpl-wechat-qrcode-popover">
    <div class="simple-popover wechat-qrcode-popover direction-right-bottom active" style="top: 165px; left: 45px;">
        <div class="simple-popover-content">
            <h5>微信在线客服</h5>
            <p><img alt="Wechat_qrcode" src="https://tower.im/assets/wechat_qrcode-0f35050697637bcc5bbc1cd5e306ea64.jpg"/></p>
            <p class="desc">扫码获取帮助</p>
        </div>
    </div>
</script>
<script id="tpl-member-menu" type="text/html">
    <div class="simple-popover popover-member-menu direction-bottom-left" style="top: 73px; left: 1150.5px;">
        <div class="simple-popover-content">
            <ul class="member-menu">
                <li>
                    <a href="/members/f4880b71a92642c293ca7efc1f2256d9/settings" data-stack-root="true" data-stack="true">个人设置</a>
                </li>
                <li class="part-line"></li>
                <li><a href="/teams/16670002c3294dabaebdf1c0fa1c7194/account_settings" data-stack="" data-stack-root="">团队帐号</a></li>
                <li><a href="/teams/16670002c3294dabaebdf1c0fa1c7194/upgrade" data-stack="" data-stack-root="">升级到企业版</a></li>
                <li><a href="/teams/16670002c3294dabaebdf1c0fa1c7194/stats" data-stack="" data-stack-root="">统计</a></li>

                <li class="part-line"></li>
                <li><a href="<?=Url::to(["team/list"])?>"><?=count(\Yii::$app->user->identity->userTeams)>1?"切换团队":"创建团队"?></a></li>
                <li><a href="/users/sign_out" data-method="DELETE" rel="nofollow">退出</a></li>
            </ul>
        </div>
        <div class="simple-popover-arrow">
            <i class="arrow arrow-shadow-1"></i>
            <i class="arrow arrow-shadow-0"></i>
            <i class="arrow arrow-border"></i>
            <i class="arrow arrow-basic"></i>
        </div>
    </div>
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>