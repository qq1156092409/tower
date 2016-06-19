<?php
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use app\components\JsManager;
/**
 * @var $this View
 */
JsManager::instance()->registers([
    "js/yii.simditor.js",
    "js/models/yii.doc.js",
]);
$this->registerCssFile("public/doc-editor.css");
$this->registerCssFile("public/popwindow.css");
?>
<div class="wrapper">
    <div class="container">
        <div class="page">
            <div class="page-inner" id="page-doc-new">
                <div class="doc-wrap">
                    <?php ActiveForm::begin([
                        "id"=>"doc-create-form",
                        "options"=>[
                            "class"=>"form form-edit-doc",
                            "style"=>"padding-bottom: 0px;",
                        ],
                    ])?>
                        <input type="hidden" name="markdown" id="is-markdown" value="0">
                        <input type="hidden" name="is_html" id="is_html" value="1">
                        <div class="form-item doc-title-wrap">
                            <div class="form-field">
                                <input name="Doc[name]" class="doc-title" placeholder="文档标题" autofocus>
                            </div>
                        </div>
                        <div class="form-item wmd-panel-wrap">
                            <div class="form-field">
                                <div class="doc-editor">
                                    <textarea id="editor" name="Doc[text]" data-toolbar="1"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="doc-bottom-bar">
                            <div class="form-item visitor-lock">
                            </div>
                            <div class="form-item save-btns-wrap">
                                <div class="form-field">
                                    <button type="submit" class="btn btn-mini btn-create-doc" data-disable-with="保存中..." data-success-text="保存成功">发布</button>
                                    <button type="button" class="btn btn-x btn-cancel-quit">取消</button>
                                </div>
                            </div>
                        </div>
                    <?php ActiveForm::end()?>
                </div>
            </div>
        </div>
    </div>
</div>
