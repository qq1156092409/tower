<?php
use \app\models\form\TopicForm;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
/**
 * @var $this View
 * @var $projectID
 */
?>
<?php $form=ActiveForm::begin([
    "id"=>"topic-create-form",
    "action"=>Url::to(["/topic/create"]),
    "options"=>[
        "class"=>"form form-editor form-new-discussion topic-create-form hide"
    ]
])?>
    <input type="hidden" name="Topic[projectID]" value="<?=$projectID?>" />
    <input class="topic-text" type="hidden" name="Topic[text]" value="" />
    <div class="form-item">
        <div class="form-field">
            <input class="input-text" tabindex="1" type="text" name="Topic[name]" id="txt-title" placeholder="话题" data-validate="length:0,255"
                   data-validate-msg="话题最长255个字符"
                   data-autosave="project-31cfd5556a4543b68cb489a242b1e9e7-new-message-title">
        </div>
    </div>
    <div class="form-item">
        <div class="form-field">
            <textarea id="editor" name="Topic[text]" placeholder="说点什么" autofocus></textarea>
        </div>
    </div>
    <div class="form-item visitor-lock" data-visible-to="member">
        <div class="form-field">
            <label>
                <input type="checkbox" name="invisible_for_visitor" class="cb-visitor-lock" value="1">
                对访客隐藏这个讨论
            </label>
        </div>
    </div>
    <div class="form-item notify">
        <div class="notify-title">
            <div class="notify-title-title">发送通知给：</div>
            <div class="notify-title-select">
                <span data-subgroup="-1" class="group-select" unselectable="on">所有人</span>
                <span data-subgroup="29741" class="group-select" unselectable="on">
                    策划
                </span>
                <span data-subgroup="29773" class="group-select" unselectable="on">
                    美术3
                </span>
            </div>
        </div>
        <div class="form-field">
            <ul class="member-list">
                <li>
                    <label>
                        <input type="checkbox" tabindex="-1" value="79a85cca56194bce8d0089acd25af308"
                               data-subgroup="29741">
                        <span title="邓健强">邓健强</span>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="checkbox" tabindex="-1" value="1ff0fd3d4a404428a1594e9ebdb2360a"
                               data-subgroup="29773">
                        <span title="邓健强小小号">邓健强小小号</span>
                    </label>
                </li>

            </ul>
        </div>
    </div>
    <div class="form-buttons">
        <button tabindex="1" class="btn btn-primary" id="btn-post" type="submit" data-disable-with="正在提交...">发起讨论</button>
        <a tabindex="2" href="javascript:;" class="btn btn-x btn-cancel" id="topic-create-cancel">取消</a>
    </div>
<?php $form->end()?>