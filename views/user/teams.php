<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use \app\models\Team;
use yii\widgets\ActiveForm;
use app\components\JsManager;
/**
 * @var $this View
 * @var $teams Team[]
 */
JsManager::instance()->registers([
    "js/models/yii.team.js",
    "js/yii.form.js",
]);
$this->registerCssFile("@web/public/application-404f5efaeb2aead3434d85ff01eddcef.css");
$this->beginPage();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>选择团队 - Tower</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="baidu-site-verification" content="qLDoHdGnb64RHlkm">
    <meta name="alexaVerifyID" content="SIgQikd9LazsFz9M1vPBaQyC4Gw">
    <link rel="shortcut icon" href="public/favicon.ico" type="image/x-icon">
    <link rel="icon" href="public/favicon.ico" sizes="32x32">
    <link rel="icon" href="public/favicon.ico" sizes="64x64">
    <link rel="icon" href="public/favicon.ico" sizes="128x128">
    <link rel="apple-touch-icon-precomposed"
          href="https://tower.im/assets/mobile/icon/icon@512-c8090c0961c63b1549cd19d714c6b69e.png">
    <link rel="search" type="application/opensearchdescription+xml" title="Tower"
          href="https://tower.im/opensearch.xml">
    <meta content="authenticity_token" name="csrf-param">
    <meta content="gqAl9Q1X2fW1vrDlQiA5MEmPutv3jCm3E++2zWxjT3w=" name="csrf-token">
    <?php $this->head()?>
</head>
<body style="zoom: 1;">
<?php $this->beginBody()?>
<div class="wrapper">
    <div class="page" id="page-launchpad">
        <div class="topbar">
            <h1 class="logo">
                <a href="<?=Url::to(["site/launchpad"])?>" title="返回">tower.im</a>
            </h1>
            <div class="account-info">
                <span class="welcome">hi, 方片周</span>
                <a href="<?=\yii\helpers\Url::to(["user/logout"])?>" rel="nofollow">退出</a>
            </div>
        </div>
        <ul class="teams">
            <?php foreach($teams as $team){?>
                <li>
                    <a href="<?=Url::to(["team/projects","id"=>$team->id])?>">
                        <span class="name"><?=$team->name?></span>
                        <b class="fly">✈</b>
                    </a>
                </li>
            <?php } ?>
            <li class="new">
                <a href="javascript:;" id="btn-new-team" class="btn-team-create">
                    <span class="name"> <i class="fa fa-plus"></i> 新的团队 </span>
                </a>
            </li>
        </ul>
        <div class="footer">
            © <a href="http://mycolorway.com/" target="_blank">彩程设计</a>
        </div>
    </div>
</div>
<div id="pop-team-create" class="simple-dialog dialog-create-team hide" style="width: 450px; height: auto; margin-left: -226px; margin-top: -91px;">
    <a class="simple-dialog-remove" href="javascript:;"><i class="fa fa-times"></i></a>
    <div class="simple-dialog-wrapper">
        <div class="simple-dialog-content" style="height: 140px;">
            <div class="new-team">
                <?php $form=ActiveForm::begin([
                    "id"=>"form-team-create",
                    "action"=>Url::to(["team/create"]),
                    "options"=>[
                        "class"=>"form"
                    ],
                ])?>
                    <h4 class="simple-dialog-title">新团队名称</h4>
                    <div class="form-item">
                        <div class="form-field" data-attr="name">
                            <input type="text" name="Team[name]" id="txt-team" placeholder="例如：iPhone 6 设计团队" autofocus="" data-validate="required" data-validate-msg="请填写团队或者公司的名称">
                            <p class="name-error error hide">aaa</p>
                        </div>
                    </div>
                    <div class="form-item form-buttons">
                        <button type="submit" id="btn-create-team" class="btn btn-primary btn-large" data-disable-with="正在创建..." data-success-text="创建成功">创建团队</button>
                        <a href="javascript:;" class="btn btn-x btn-team-create-cancel">取消</a>
                    </div>
                <?php $form->end()?>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage() ?>