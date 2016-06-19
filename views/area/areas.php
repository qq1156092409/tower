<?php
use yii\web\View;
use app\models\Area;
use yii\helpers\Url;
use app\components\JsManager;
/**
 * @var $this View
 * @var $areas Area[]
 */
JsManager::instance()->registers(['js/models/yii.area.js']);
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div>
        <?=$this->render("_select",["areas"=>$areas])?>
    </div>
    <input id="area-id" type="hidden" name="areaID">
</div>
<input type="hidden" id="area-get-children-url" value="<?=Url::to(["/area/get-children","parentID"=>"{parentID}"])?>">
