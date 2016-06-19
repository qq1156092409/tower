<?php
use yii\web\View;
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15-9-6
 * Time: 上午9:11
 * @var $this View;
 */
\app\assets\JqueryUIAsset::register($this);
?>
<div id="djq">
<ul class="sortable">
    <li class="ui-state-default">Item 1</li>
    <li class="ui-state-default">Item 2</li>
    <li class="ui-state-default">Item 3</li>
    <li class="ui-state-default">Item 4</li>
    <li class="ui-state-default">Item 5</li>
</ul>
<ul class="sortable">
    <li class="ui-state-default">Item 1</li>
    <li class="ui-state-default">Item 2</li>
    <li class="ui-state-default">Item 3</li>
    <li class="ui-state-default">Item 4</li>
    <li class="ui-state-default">Item 5</li>
</ul>
</div>
<script>
    <?php $this->beginBlock("js");?>
    $( ".sortable" ).sortable({
        placeholder:'ui-state-highlight'
    });
    <?php $this->endBlock();$this->registerJs($this->blocks["js"])?>
</script>