<?php
use yii\web\View;
use app\models\Area;
use yii\helpers\Url;
/**
 * @var $this View
 * @var $areas Area[]
 */
?>
<select class="area-get-children" data-url="<?=Url::to(["area/get-children"])?>">
    <?php foreach($areas as $area){ ?>
        <option value="<?=$area->id?>"><?=$area->name?></option>
    <?php } ?>
</select>
