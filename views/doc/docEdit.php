<?php
use app\models\Doc;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\components\JsManager;
/**
 * @var $doc Doc
 */
JsManager::instance()->registers([
    "js/models/yii.doc.js",
    "js/yii.simditor.js",
]);
$this->registerCssFile("public/doc-editor.css");
$this->registerCssFile("public/popwindow.css");
?>
<div class="wrapper">
    <div class="container">
        <div class="page">
            <div class="page-inner" id="page-edit-doc" data-heartbeat-path="/projects/26dc9eb2cbbc48ac98e0c3d876618369/docs/f972adbaf17b487fb4516ff11b4e2fe9/heartbeat">
                <div class="doc-wrap">
                    <?php ActiveForm::begin([
                        "id"=>"doc-edit-form",
                        "options"=>[
                            "class"=>"form form-edit-doc",
                            "style"=>"padding-bottom: 0px;",
                        ]
                    ])?>
                        <input type="hidden" name="markdown" id="is-markdown" value="0">
                        <input type="hidden" name="is_html" id="is_html" value="1">
                        <div class="form-item doc-title-wrap">
                            <div class="form-field">
                                <input name="doc_title" class="doc-title" placeholder="文档标题" value="<?=$doc->name?>">
                            </div>
                        </div>
                        <div class="form-item">
                            <div class="form-field">
                                <div class="doc-editor">
                                    <textarea id="editor" name="Doc[text]" data-toolbar="1"><?=$doc->text?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="doc-bottom-bar">
                            <div class="form-item visitor-lock">
                            </div>
                            <div class="form-item save-btns-wrap">
                                <div class="form-field">
                                    <button type="submit" class="btn btn-mini btn-save-version-quit" data-disable-with="保存中..." data-success-text="保存成功">保存并退出</button>
                                    <button type="button" class="btn btn-x btn-cancel-quit" onclick="history.back()">取消</button>
                                </div>
                            </div>
                        </div>
                    <?php ActiveForm::end()?>
                </div>
            </div>
        </div>
    </div>
</div>