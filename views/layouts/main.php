<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use app\components\JsManager;
use yii\widgets\ActiveForm;
/**
 * @var $active int 当前选中
 * @var $this View
 */
$team = Yii::$app->user->identity->lastUserTeam->team;
$teamID=$team->id;
$userTeams=Yii::$app->user->identity->userTeams;
JsManager::instance()->registers([
    "js/models/yii.layout.js",
    "js/yii.socket.js",
]);
$this->registerCssFile("@web/public/application-404f5efaeb2aead3434d85ff01eddcef.css");
$request=Yii::$app->request;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>">
    <title><?= $this->title?Html::encode($this->title).' - '.Yii::$app->id:Yii::$app->id ?></title>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="baidu-site-verification" content="qLDoHdGnb64RHlkm">
    <meta name="alexaVerifyID" content="SIgQikd9LazsFz9M1vPBaQyC4Gw">
    <meta name="csrf-param" content="<?=$request->csrfParam?>">
    <meta name="csrf-token" content="<?=$request->csrfToken?>">
    <link rel="shortcut icon" href="public/favicon.ico" type="image/x-icon">
    <link rel="icon" href="public/favicon.ico" sizes="32x32">
    <link rel="icon" href="public/favicon.ico" sizes="64x64">
    <link rel="icon" href="public/favicon.ico" sizes="128x128">
    <link rel="apple-touch-icon-precomposed" href="https://tower.im/assets/mobile/icon/icon@512-c8090c0961c63b1549cd19d714c6b69e.png">
    <link rel="search" type="application/opensearchdescription+xml" title="Tower" href="https://tower.im/opensearch.xml">
    <?php $this->head() ?>
</head>
<body class="win">
<?php $this->beginBody() ?>
<div class="wrapper">
    <div class="header">
        <h1 class="logo">
            <a id="btn-teams" href="javascript:;" class="link-team-menu">
                <span class="name"><?=$team->name?></span>
                <i class="twr twr-caret-down"></i>
            </a>
        </h1>
        <ul class="nav">
            <li id="nav-project" class="<?=isset($this->params["active"])&&$this->params["active"]==1?"active":""?>">
                <a href="<?=Url::to(["team/projects","id"=>$teamID])?>" data-stack="" data-stack-root="">项目</a>
            </li>
            <li id="nav-events" class="<?=isset($this->params["active"])&&$this->params["active"]==2?"active":""?>">
                <a href="<?=Url::to(["team/operations","id"=>$teamID])?>" data-stack="" data-stack-root="">动态</a>
            </li>
            <li id="nav-week" class="<?=isset($this->params["active"])&&$this->params["active"]==3?"active":""?>">
                <a href="javascript:void(0)" data-stack="" data-stack-root="">周报</a>
            </li>
            <li id="nav-calendar" class="<?=isset($this->params["active"])&&$this->params["active"]==4?"active":""?>">
                <a href="<?=Url::to(["team/calendars","id"=>$teamID])?>" data-stack="" data-stack-fluid="" data-stack-root="">日历</a>
            </li>
            <li id="nav-members" class="<?=isset($this->params["active"])&&$this->params["active"]==5?"active":""?>">
                <a href="<?=Url::to(["team/members","id"=>$teamID])?>" data-stack="" data-stack-root="">团队</a>
            </li>
            <li id="nav-me" class="<?=isset($this->params["active"])&&$this->params["active"]==6?"active":""?>">
                <a href="<?=Url::to(["user/tasks","teamID"=>$teamID])?>" data-stack="" data-stack-root="">我自己</a>
            </li>
        </ul>
        <div class="command-bar">
            <div class="search-wrap">
                <a id="btn-search" href="javascript:;" class="link-search" title="搜索"><i class="twr twr-search"></i></a>
                <?php
                $form=ActiveForm::begin([
                    "id"=>"form-search",
                    "action"=>Url::to(["team/search","id"=>$teamID]),
                    "method"=>"get",
                    "options"=>[
                        "class"=>"form",
                    ],
                ]);
                ?>
                    <input id="txt-search" type="text" class="keyword no-border" name="keyword" placeholder="搜索" autocomplete="off">
                <?php $form->end()?>
            </div>
            <div class="notification-info">
                <a href="javascript:;" id="btn-notification" class="label " title="新的通知" data-unread-count="0" data-url="/teams/93d89386a21248be83711dd878ef33cd/notifications/unread_counts">
                    <span class="twr twr-bell-o bell"></span>
                    <span class="num">0</span>
                </a>
                <div id="pop-notification" class="noti-pop">
                    <div class="noti-pop-hd">
                        <span class="title">通知</span>
                        <a class="noti-settings" href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe/notification_settings/" title="设置通知发送方式" data-stack="" data-stack-root="">
                            <i class="twr twr-cog"></i>
                        </a>
                        <a id="noti-mark-read" class="mark-as-read" href="javascript:;" title="全部标记为已读">
                            <i class="twr twr-check"></i>
                        </a>
                    </div>
                    <div class="noti-pop-list notification-list">
                    </div>
                    <div class="noti-pop-empty">- 没有新通知 -</div>
                    <div class="noti-pop-action">
                        <a class="noti-all-link" href="/teams/93d89386a21248be83711dd878ef33cd/notifications/" data-stack="" data-stack-root="">查看全部</a>
                    </div>
                </div>
            </div>
            <div class="account-info">
                <div class="member-settings">
                    <a id="btn-user-menu" class="link-member-menu" href="javascript:;" title="邓健强">
                        <img class="avatar" src="public/b77fe6a1d67e4fc1863e3b860ca0815b" alt="邓健强">
                        <span class="twr twr-caret-down"></span>
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
<a href="https://tower.im/help" target="_blank" id="link-feedback">
    <i id="btn-wechat" class="twr twr-weixin"></i>帮助
</a>
<!-- 微信在线客服 -->
<div id="pop-wechat" class="simple-popover wechat-qrcode-popover direction-right-bottom active" style="top: 165px; left: 45px;display:none">
    <div class="simple-popover-content">
        <h5>微信在线客服</h5>
        <p><img alt="Wechat_qrcode" src="public/wechat_qrcode-0f35050697637bcc5bbc1cd5e306ea64.jpg"/></p>
        <p class="desc">扫码获取帮助</p>
    </div>
    <div class="simple-popover-arrow" style="top: 16px;">
        <i class="arrow arrow-shadow-1"></i>
        <i class="arrow arrow-shadow-0"></i>
        <i class="arrow arrow-border"></i>
        <i class="arrow arrow-basic"></i>
    </div>
</div>
<!--项目弹窗-->
<div id="pop-teams" class="simple-popover popover-header-menu scrollable dropdown-list direction-bottom-center" style="display:none">
    <div class="simple-popover-content">
        <ul class="menu">
            <li><a href="<?=Url::to(["/team/setting",'id'=>$teamID])?>" data-stack="" data-stack-root="">团队账户</a></li>
            <li>
                <a href="<?=Url::to(["/team/upgrade",'id'=>$teamID])?>" data-stack="" data-stack-root="">升级到 Pro 版</a>
            </li>
            <p class="title"><span>切换团队</span></p>
            <ul class="menu scroll team-list">
                <?php foreach($userTeams as $userTeam){
                    if($userTeam->teamID == $teamID) continue;
                    ?>
                <li>
                    <a href="<?=Url::to(["team/projects","id"=>$userTeam->teamID])?>"><?=$userTeam->team->name?></a>
                </li>
                <?php } ?>
            </ul>
            <li class="part-line"></li>
            <li class="small"><a href="<?=Url::to(["user/teams"])?>">创建/管理团队</a></li>
        </ul>
    </div>
    <div class="simple-popover-arrow">
        <i class="arrow arrow-shadow-1"></i>
        <i class="arrow arrow-shadow-0"></i>
        <i class="arrow arrow-border"></i>
        <i class="arrow arrow-basic"></i>
    </div>
</div>
<!--个人设置弹窗-->
<div id="pop-user-menu" class="simple-popover popover-header-menu dropdown-list direction-bottom-center" style="display:none;">
    <div class="simple-popover-content">
        <ul class="menu">
            <li>
                <a href="<?=Url::to(["user/setting"])?>" data-stack-root="true" data-stack="true">个人设置</a>
            </li>
            <li><a href="<?=Url::to(["user/notification-setting"])?>" data-stack="true">通知设置</a></li>
            <li class="part-line"></li>
            <li><a href="https://tower.im/roadmap" target="_blank">最新功能</a></li>
            <li><a href="<?=Url::to(["site/logout"])?>" data-method="DELETE" rel="nofollow">退出</a></li>
        </ul>
    </div>
    <div class="simple-popover-arrow">
        <i class="arrow arrow-shadow-1"></i>
        <i class="arrow arrow-shadow-0"></i>
        <i class="arrow arrow-border"></i>
        <i class="arrow arrow-basic"></i>
    </div>
</div>
<div class="hidden">
    <div id="ws-data" data-user="<?=Yii::$app->user->id?>" data-team="<?=$teamID?>"></div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>