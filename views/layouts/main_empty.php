<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use app\components\JsManager;
/**
 * @var $active int 当前选中
 * @var $this View
 */
$team = Yii::$app->user->identity->lastUserTeam->team;
$teamID=$team->id;
JsManager::instance()->registers(["js/yii.socket.js"]);
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
    <link rel="shortcut icon" href="public/favicon.ico" type="image/x-icon">
    <link rel="icon" href="public/favicon.ico" sizes="32x32">
    <link rel="icon" href="public/favicon.ico" sizes="64x64">
    <link rel="icon" href="public/favicon.ico" sizes="128x128">
    <link rel="apple-touch-icon-precomposed" href="https://tower.im/assets/mobile/icon/icon@512-c8090c0961c63b1549cd19d714c6b69e.png">
    <link rel="search" type="application/opensearchdescription+xml" title="Tower" href="https://tower.im/opensearch.xml">
    <?php $this->head() ?>
</head>
<body class="win">
<?php $this->beginBody(); ?>
<?php echo $content;?>
<div class="hidden">
    <div id="ws-data" data-user="<?=Yii::$app->user->id?>" data-team="<?=$teamID?>"></div>
</div>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage() ?>