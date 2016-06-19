<?php
use app\models\Collect;
use app\models\UserLog;
use \app\models\multiple\G;
use app\components\JsManager;
/**
 * @var $teamID int
 * @var $collects Collect[]
 * @var $userLog UserLog
 */
$this->title=Yii::$app->user->identity->activeName;
$this->params["active"]=6;
JsManager::instance()->registers(["js/models/yii.collect.js",]);
?>
<div class="container workspace simple-stack simple-stack-transition">
<div class="page page-root simple-pjax">
<div class="page-inner page-member" id="page-member-stars" data-guid="f4880b71a92642c293ca7efc1f2256d9"
     data-since="2015-04-01 07:15:19 UTC" data-page-name="方片周" data-self="true">

<?=$this->render("_top",["teamID"=>$teamID,"userLog"=>$userLog,"flag"=>2])?>

<p class="page-tips moveout inbox-moveout"></p>
<div class="member-section member-stars">
<div class="init init-stars-empty <?=$collects?"hide":""?>">
    <div class="title"><i class="twr twr-star"></i><?=Yii::$app->user->identity->activeName?> 没有收藏内容哦</div>
</div>

<div class="star-items">
<?php
if($collects){
    foreach($collects as $collect){
        echo $this->render("collect_".G::getContent($collect->model,"name"),["model"=>$collect,"teamID"=>$teamID]);
    }
}
?>
</div>
</div>
</div>
</div>
</div>
