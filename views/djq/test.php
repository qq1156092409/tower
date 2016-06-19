<?php
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\web\YiiAsset;
/**
 * @var $this View
 */
?>
<div class="container workspace simple-stack simple-stack-transition">
    <?php $form=ActiveForm::begin([
        "id"=>"form"
    ])?>
        <input id="file" type="file" name="djq[]"><br>
        <input type="submit" value="提交">
    <?php $form->end()?>
</div>
<template id="template" src="templates/haha.tmpl"></template>
<template id="template2">haha2</template>
<script>
    <?php $this->beginBlock("js");?>
    $("#form").submit(function(e){
        e.preventDefault();
        var $form=$(this);
        var formData=new FormData(this);
        var xhr = new XMLHttpRequest();
        var upload=xhr.upload;

        xhr.open("post",$form.attr("action"));

        xhr.onloadstart=function(e){
            console.log("onloadstart",e);
        };
        xhr.onprogress=function(e){
            console.log("onprogress",e);
        };
        xhr.onload=function(e){
            console.log("onload",e);
        };
        xhr.onloadend=function(e){
            console.log("onloadend",e);
        };
        xhr.onreadystatechange=function(e){
            console.log("onreadystatechange",xhr.readyState,e,xhr);
        };

        xhr.send(formData);
    });
    $("#file").change(function(e){
        console.log(this);
        console.log(e);
        var reader=new FileReader();
        reader.onload=function(){
            $("<img src='"+this.result+"'/>").appendTo("body");
        };
        reader.readAsDataURL(this.files[0]);
    });
    <?php $this->endBlock();$this->registerJs($this->blocks["js"])?>
</script>