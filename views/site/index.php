<?php
use yii\helpers\Url;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-6-27
 * Time: 下午6:39
 */
$teamID=Yii::$app->user->identity->lastUserTeam->teamID;
?>
<?=Yii::$app->id?><br>
<?php if(Yii::$app->user->isGuest){ ?>
    <a href="<?=Url::to(["site/login"])?>">登录</a>
<?php }else{ ?>
    <a href="<?=Url::to(["team/projects","id"=>$teamID])?>">最后编辑的团队项目</a>
<?php } ?>