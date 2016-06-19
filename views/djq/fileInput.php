<?php
use yii\web\View;
use app\assets\FileInputAsset;
/**
 * @var $this View
 */
$this->registerAssetBundle('app\assets\FileInputAsset');
?>
<div class="container workspace simple-stack simple-stack-transition">
    <input id="file" type="file" name="file"/>
</div>
<script>
    <?php $this->beginBlock("js")?>
    $("#file").fileinput({
        uploadUrl: "<?=\yii\helpers\Url::to(["attachment/single"])?>", // server upload action
        uploadAsync: true,
        maxFileCount: 5
    });
    <?php $this->endBlock();$this->registerJs($this->blocks["js"])?>
</script>
