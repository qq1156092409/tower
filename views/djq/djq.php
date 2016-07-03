<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\components\JsManager;
/**
 * @var $this yii\web\View
 */
$this->title = "djq";
$this->params["active"] = 1;
$this->params["teamID"] = 1;
//JsManager::instance()->register("js/yii.simditor.js");
JsManager::instance()->register("js/yii.jqueryUpload.js");
JsManager::instance()->register("js/yii.tab.js");
JsManager::instance()->register("js/yii.djq.js");
$this->registerJsFile("http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js");
?>
<style>
    .tab-section,.tab-section2{display: none}
    .sections .tab-active{display: block}
    .tab-link{width:100px;}
</style>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="tab">
        <ul>
            <li><a href="javascript:void(0)" class="tab-link">1</a></li>
            <li><a href="javascript:void(0)" class="tab-link">2</a></li>
            <li><a href="javascript:void(0)" class="tab-link">3</a></li>
        </ul>
        <div class="sections">
            <div class="tab-section tab-active">section 1</div>
            <div class="tab-section">section 2</div>
            <div class="tab-section">section 3</div>
        </div>
    </div>
    <div class="tab">
        <ul>
            <li><a href="javascript:void(0)" class="tab-link">1</a></li>
            <li><a href="javascript:void(0)" class="tab-link">2</a></li>
            <li><a href="javascript:void(0)" class="tab-link">3</a></li>
        </ul>
        <div class="sections">
            <div class="tab-section tab-active">section 1</div>
            <div class="tab-section">section 2</div>
            <div class="tab-section">section 3</div>
        </div>
    </div>
    <textarea id="editor" placeholder="Balabala"></textarea>
    <input id="fileInput" type="file" name="file" data-url="<?=Url::to("plugins/jqueryFileUpload/server/php/index.php")?>"/>
<!--    <input id="fileInput" type="file" name="file" data-url="--><?//=Url::to(["attachment/single"])?><!--"/>-->
    <div id="list-resources"></div>
    <div id="weixin-login">haha</div>
</div>
<?=$this->render("/commons/_uploadTemplate")?>
<script>
<?php $this->beginBlock("js");?>
var obj = new WxLogin({
    id:"weixin-login",
    appid: "wxbdc5610cc59c1631",
    scope: "snsapi_login",
    redirect_uri: "https%3A%2F%2Fpassport.yhd.com%2Fwechat%2Fcallback.do",
    state: "ef9fd1d4e8e39f5dd3493fc7ec4f2db8",
    style: "",
    href: ""
});
<?php $this->endBlock();$this->registerJs($this->blocks["js"]);?>
</script>
