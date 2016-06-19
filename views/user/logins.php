<?php
use app\models\UserLog;
use app\models\UserTeam;
use yii\helpers\Url;
use app\components\JsManager;
/**
 * @var $userLogs UserLog[]
 * @var $userTeam UserTeam
 */
JsManager::instance()->registers(["js/yii.time.js"]);
?>
<div class="container workspace simple-stack simple-stack-transition">
<div class="page page-root simple-pjax page-behind">
    <a class="link-page-behind" data-stack="" href="<?=Url::to(["user/tasks","teamID"=>$userTeam->teamID])?>">方片周</a>
</div>
<div class="page page-1 simple-pjax">
<div class="page-inner" data-since="2015-03-31 06:24:52 UTC" data-page-name="方片周 登录记录" id="page-signin-logs">
<p class="page-tip moveout inbox-moveout"></p>


<h3>帐号登录记录</h3>

<p class="description">该功能为你提供有关此帐号最近的登录信息
    ，当前计算机使用的 IP 地址为 <span class="ip"><?=Yii::$app->request->userIP?></span>。
</p>

<table class="signin-logs">
<thead>
<tr>
    <td>登录设备</td>
    <td>地址（IP 地址）</td>
    <td>时间/日期</td>
</tr>
</thead>
<tbody>
<?php foreach($userLogs as $userLog){ ?>
<tr>
    <td>
        <?=$userLog->simpleAgent?>
        <?php if($userLog->simpleAgent!=="android"){ ?>
        <div class="twr twr-info-circle">
            <p class="hide user-agent"><?=$userLog->agent?></p>
        </div>
        <?php } ?>
    </td>
    <td><?=$userLog->addressIp?></td>
    <td class="count-down auto-fuzzy-time" data-time="<?=strtotime($userLog->create)*1000?>"><?=$userLog->fuzzyCreate?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>