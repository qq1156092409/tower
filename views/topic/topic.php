<?php
use app\models\Topic;
use app\models\Operation;
use yii\web\View;
use yii\helpers\Url;
use app\components\JsManager;
/**
 * @var $topic Topic
 * @var $operations Operation[]
 * @var $teamID int
 * @var $this View
 */
$this->title=$topic->name;
$request=Yii::$app->request;
JsManager::instance()->registers(["js/models/yii.topic.js",]);
?>
<div class="container workspace simple-stack simple-stack-transition">
<div class="page page-root simple-pjax page-behind">
    <a class="link-page-behind" data-stack="" href="<?=Url::to(["/project","id"=>$topic->projectID])?>"><?=$topic->project->name?></a>
</div>
<div class="page page-1 simple-pjax">
<div class="page-inner" data-since="2015-04-16 00:51:07 UTC" data-guest-unlockable=""
     data-creator-guid="f4880b71a92642c293ca7efc1f2256d9" data-project-creator="f4880b71a92642c293ca7efc1f2256d9"
     data-page-name="<?=$topic->name?>" id="page-message">
    <?php if($topic->deleted){
        $operation=$topic->getLastDisableOperation();
        ?>
    <div class="page-tip resource-deleted">
        这个讨论已经于 <span title="<?=$operation->create?>"><?=date("Y年m月d日",strtotime($operation->create))?></span>  删除了
                <span data-visible-to="creator,admin">
                    ，你可以选择
                    <a class="btn-topic-enable" href="<?=Url::to(["/topic/enable","id"=>$topic->id])?>" data-cf="确定要恢复这条讨论吗？" data-global-loading="正在恢复" data-refresh="true" data-remote="true">恢复</a>
                </span>
    </div>
    <?php } ?>

<div class="topic">
    <div id="topic-<?=$topic->id?>" class="message" data-creator-guid="f4880b71a92642c293ca7efc1f2256d9">
        <div class="message-subject">
            <h3>
                <span class="message-rest topic-name" title="<?=$topic->name?>"><?=$topic->name?></span>
            </h3>
        </div>

        <a href="/members/f4880b71a92642c293ca7efc1f2256d9" class="avatar-wrap" target="_blank" title="<?=$topic->user->activeName?>"><img
                alt="<?=$topic->user->activeName?>" class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37"></a>

        <div class="message-main">
            <div class="info">
                <a href="/members/f4880b71a92642c293ca7efc1f2256d9" class="author" data-stack-root="true"
                   data-stack="true" title="<?=$topic->user->activeName?>"><?=$topic->user->activeName?></a>

                <span class="create-time" title="2015-02-03 17:24"
                      data-readable-time="<?=$topic->create?>"><?=$topic->fuzzyCreate?></span>
            </div>
            <div class="message-content editor-style topic-text"><?=$topic->text?></div>
        </div>
    </div>
    <div class="message-form edit hide">

        <form class="form form-editor form-edit-message form-topic-edit" method="post" data-remote="true" action="<?=Url::to(["/topic/edit","id"=>$topic->id])?>">
            <input type="hidden" name="<?=$request->csrfParam?>" value="<?=$request->csrfToken?>" />
            <input type="hidden" class="topic-text" name="Topic[text]" value="" />


            <div class="form-item">
                <div class="form-field">
                    <input tabindex="1" type="text" name="Topic[name]" data-validate="length:0,255" data-validate-msg="话题最长255个字符" value="<?=$topic->name?>" id="txt-title" placeholder="话题">
                </div>
            </div>
            <div class="form-item">
                <div class="form-field">
                    <div class="simditor" data-droppable="true">
                        <div class="simditor-wrapper"><div class="simditor-toolbar" style="top: 0px; width: 698px; left: 273.5px;"><ul><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-emoji" href="javascript:;" title="表情"><span class="simditor-icon simditor-icon-smile-o"></span></a><div class="toolbar-menu toolbar-menu-emoji"><ul class="emoji-list"><li data-name="smile"><img src="https://s.tower.im/emoji/smile.png" width="20" height="20" alt="smile"></li><li data-name="smiley"><img src="https://s.tower.im/emoji/smiley.png" width="20" height="20" alt="smiley"></li><li data-name="laughing"><img src="https://s.tower.im/emoji/laughing.png" width="20" height="20" alt="laughing"></li><li data-name="blush"><img src="https://s.tower.im/emoji/blush.png" width="20" height="20" alt="blush"></li><li data-name="heart_eyes"><img src="https://s.tower.im/emoji/heart_eyes.png" width="20" height="20" alt="heart_eyes"></li><li data-name="smirk"><img src="https://s.tower.im/emoji/smirk.png" width="20" height="20" alt="smirk"></li><li data-name="flushed"><img src="https://s.tower.im/emoji/flushed.png" width="20" height="20" alt="flushed"></li><li data-name="grin"><img src="https://s.tower.im/emoji/grin.png" width="20" height="20" alt="grin"></li><li data-name="wink"><img src="https://s.tower.im/emoji/wink.png" width="20" height="20" alt="wink"></li><li data-name="kissing_closed_eyes"><img src="https://s.tower.im/emoji/kissing_closed_eyes.png" width="20" height="20" alt="kissing_closed_eyes"></li><li data-name="stuck_out_tongue_winking_eye"><img src="https://s.tower.im/emoji/stuck_out_tongue_winking_eye.png" width="20" height="20" alt="stuck_out_tongue_winking_eye"></li><li data-name="stuck_out_tongue"><img src="https://s.tower.im/emoji/stuck_out_tongue.png" width="20" height="20" alt="stuck_out_tongue"></li><li data-name="sleeping"><img src="https://s.tower.im/emoji/sleeping.png" width="20" height="20" alt="sleeping"></li><li data-name="worried"><img src="https://s.tower.im/emoji/worried.png" width="20" height="20" alt="worried"></li><li data-name="expressionless"><img src="https://s.tower.im/emoji/expressionless.png" width="20" height="20" alt="expressionless"></li><li data-name="sweat_smile"><img src="https://s.tower.im/emoji/sweat_smile.png" width="20" height="20" alt="sweat_smile"></li><li data-name="cold_sweat"><img src="https://s.tower.im/emoji/cold_sweat.png" width="20" height="20" alt="cold_sweat"></li><li data-name="joy"><img src="https://s.tower.im/emoji/joy.png" width="20" height="20" alt="joy"></li><li data-name="sob"><img src="https://s.tower.im/emoji/sob.png" width="20" height="20" alt="sob"></li><li data-name="angry"><img src="https://s.tower.im/emoji/angry.png" width="20" height="20" alt="angry"></li><li data-name="mask"><img src="https://s.tower.im/emoji/mask.png" width="20" height="20" alt="mask"></li><li data-name="scream"><img src="https://s.tower.im/emoji/scream.png" width="20" height="20" alt="scream"></li><li data-name="sunglasses"><img src="https://s.tower.im/emoji/sunglasses.png" width="20" height="20" alt="sunglasses"></li><li data-name="heart"><img src="https://s.tower.im/emoji/heart.png" width="20" height="20" alt="heart"></li><li data-name="broken_heart"><img src="https://s.tower.im/emoji/broken_heart.png" width="20" height="20" alt="broken_heart"></li><li data-name="star"><img src="https://s.tower.im/emoji/star.png" width="20" height="20" alt="star"></li><li data-name="anger"><img src="https://s.tower.im/emoji/anger.png" width="20" height="20" alt="anger"></li><li data-name="exclamation"><img src="https://s.tower.im/emoji/exclamation.png" width="20" height="20" alt="exclamation"></li><li data-name="question"><img src="https://s.tower.im/emoji/question.png" width="20" height="20" alt="question"></li><li data-name="zzz"><img src="https://s.tower.im/emoji/zzz.png" width="20" height="20" alt="zzz"></li><li data-name="thumbsup"><img src="https://s.tower.im/emoji/thumbsup.png" width="20" height="20" alt="thumbsup"></li><li data-name="thumbsdown"><img src="https://s.tower.im/emoji/thumbsdown.png" width="20" height="20" alt="thumbsdown"></li><li data-name="ok_hand"><img src="https://s.tower.im/emoji/ok_hand.png" width="20" height="20" alt="ok_hand"></li><li data-name="punch"><img src="https://s.tower.im/emoji/punch.png" width="20" height="20" alt="punch"></li><li data-name="v"><img src="https://s.tower.im/emoji/v.png" width="20" height="20" alt="v"></li><li data-name="clap"><img src="https://s.tower.im/emoji/clap.png" width="20" height="20" alt="clap"></li><li data-name="muscle"><img src="https://s.tower.im/emoji/muscle.png" width="20" height="20" alt="muscle"></li><li data-name="pray"><img src="https://s.tower.im/emoji/pray.png" width="20" height="20" alt="pray"></li><li data-name="skull"><img src="https://s.tower.im/emoji/skull.png" width="20" height="20" alt="skull"></li><li data-name="trollface"><img src="https://s.tower.im/emoji/trollface.png" width="20" height="20" alt="trollface"></li></ul></div></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-bold" href="javascript:;" title="加粗文字 ( Ctrl + b )"><span class="simditor-icon simditor-icon-bold"></span></a></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-italic" href="javascript:;" title="斜体文字 ( Ctrl + i )"><span class="simditor-icon simditor-icon-italic"></span></a></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-underline" href="javascript:;" title="下划线文字 ( Ctrl + u )"><span class="simditor-icon simditor-icon-underline"></span></a></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-strikethrough" href="javascript:;" title="删除线文字"><span class="simditor-icon simditor-icon-strikethrough"></span></a></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-color" href="javascript:;" title="文字颜色"><span class="simditor-icon simditor-icon-tint"></span></a><div class="toolbar-menu toolbar-menu-color"><ul class="color-list">
                                                <li><a href="javascript:;" class="font-color font-color-1" data-color=""></a></li>
                                                <li><a href="javascript:;" class="font-color font-color-2" data-color=""></a></li>
                                                <li><a href="javascript:;" class="font-color font-color-3" data-color=""></a></li>
                                                <li><a href="javascript:;" class="font-color font-color-4" data-color=""></a></li>
                                                <li><a href="javascript:;" class="font-color font-color-5" data-color=""></a></li>
                                                <li><a href="javascript:;" class="font-color font-color-6" data-color=""></a></li>
                                                <li><a href="javascript:;" class="font-color font-color-7" data-color=""></a></li>
                                                <li><a href="javascript:;" class="font-color font-color-default" data-color=""></a></li>
                                            </ul></div></li><li><span class="separator"></span></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-ol" href="javascript:;" title="有序列表 ( ctrl + / )"><span class="simditor-icon simditor-icon-list-ol"></span></a></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-ul" href="javascript:;" title="无序列表 ( Ctrl + . )"><span class="simditor-icon simditor-icon-list-ul"></span></a></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-blockquote" href="javascript:;" title="引用"><span class="simditor-icon simditor-icon-quote-left"></span></a></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-code" href="javascript:;" title="插入代码"><span class="simditor-icon simditor-icon-code"></span></a></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-indent" href="javascript:;" title="向右缩进 (Tab)"><span class="simditor-icon simditor-icon-indent"></span></a></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-outdent" href="javascript:;" title="向左缩进 (Shift + Tab)"><span class="simditor-icon simditor-icon-outdent"></span></a></li><li><span class="separator"></span></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-link" href="javascript:;" title="插入链接"><span class="simditor-icon simditor-icon-link"></span></a></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-image" href="javascript:;" title="插入图片"><span class="simditor-icon simditor-icon-picture-o"></span></a><div class="toolbar-menu toolbar-menu-image"><ul><li><a tabindex="-1" unselectable="on" class="menu-item menu-item-upload-image" href="javascript:;" title="上传图片"><span>上传图片</span><input type="file" title="上传图片" accept="image/*"></a></li><li><a tabindex="-1" unselectable="on" class="menu-item menu-item-external-image" href="javascript:;" title="外链图片"><span>外链图片</span></a></li></ul></div></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-attachment" href="javascript:;" title=""><span class="simditor-icon simditor-icon-paperclip"></span><input type="file" name="upload_file" tabindex="-1" multiple="true"></a></li><li><span class="separator"></span></li><li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-markdown" href="javascript:;" title=""><span class="simditor-icon simditor-icon-markdown"></span></a></li></ul></div>
                            <div class="simditor-placeholder" style="top: 31px; display: none;">说点什么...</div>
                            <div class="markdown-editor"><textarea placeholder="说点什么..."></textarea></div><div class="simditor-body" contenteditable="true" tabindex="1"><?=$topic->text?></div>
                            <textarea tabindex="1" autofocus="" data-validate="custom" data-mention-group="c96929b616cd4100a6225ea090264459" name="content" id="txt-content" placeholder="说点什么..."><?=$topic->text?></textarea><input type="hidden" name="is_html" value="1"></div>
                        <div tabindex="-1" contenteditable="true" class="simditor-paste-area" style="width: 1px; height: 1px; overflow: hidden; position: fixed; right: 0px; bottom: 100px;"></div><div class="simditor-popover code-popover"><div class="code-settings">
                                <div class="settings-field">
                                    <select class="select-lang">
                                        <option value="-1">选择程序语言</option>
                                        <option value="bash">Bash</option><option value="c++">C++</option><option value="cs">C#</option><option value="css">CSS</option><option value="erlang">Erlang</option><option value="less">Less</option><option value="sass">Sass</option><option value="diff">Diff</option><option value="coffeescript">CoffeeScript</option><option value="html">HTML,XML</option><option value="json">JSON</option><option value="java">Java</option><option value="js">JavaScript</option><option value="markdown">Markdown</option><option value="oc">Objective C</option><option value="php">PHP</option><option value="parl">Perl</option><option value="python">Python</option><option value="ruby">Ruby</option><option value="sql">SQL</option></select>
                                </div>
                            </div></div><div class="simditor-popover link-popover"><div class="link-settings">
                                <div class="settings-field">
                                    <label>文本</label>
                                    <input class="link-text" type="text">
                                    <a class="btn-unlink" href="javascript:;" title="移除链接" tabindex="-1"><span class="simditor-icon simditor-icon-unlink"></span></a>
                                </div>
                                <div class="settings-field">
                                    <label>地址</label>
                                    <input class="link-url" type="text">
                                </div>
                            </div></div><div class="simditor-popover image-popover"><div class="link-settings">
                                <div class="settings-field">
                                    <label>图片地址</label>
                                    <input class="image-src" type="text" tabindex="1">
                                    <a class="btn-upload" href="javascript:;" title="上传图片" tabindex="-1">
                                        <span class="simditor-icon simditor-icon-upload"></span>
                                        <input type="file" title="上传图片" accept="image/*"></a>
                                </div>
                                <div class="settings-field">
                                    <label>图片描述</label>
                                    <input class="image-alt" id="image-alt" type="text" tabindex="1">
                                </div>
                                <div class="settings-field">
                                    <label>图片尺寸</label>
                                    <input class="image-size" id="image-width" type="text" tabindex="2">
                                    <span class="times">×</span>
                                    <input class="image-size" id="image-height" type="text" tabindex="3">
                                    <a class="btn-restore" href="javascript:;" title="还原图片尺寸" tabindex="-1">
                                        <span class="simditor-icon simditor-icon-undo"></span>
                                    </a>
                                </div>
                            </div></div><div class="simditor-attachments ui-sortable">
                        </div><div class="simditor-mention-popover" style="display: none;">
                            <div class="items"><a class="item" href="javascript:;" data-pinyin="dengjianqiang" data-abbr="djq" data-name="邓健强">
                                    <img src="https://avatar.tower.im/b77fe6a1d67e4fc1863e3b860ca0815b" class="avatar"><span>邓健强</span>
                                </a><a class="item" href="javascript:;" data-pinyin="dengjianqiangxiaoxiaohao" data-abbr="djqxxh" data-name="邓健强小小号">
                                    <img src="<?=Url::to("public/default_avatars/winter.jpg")?>" class="avatar"><span>邓健强小小号</span>
                                </a><a></a></div>
                        </div></div>

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
            <div class="form-buttons">
                <button tabindex="1" class="btn btn-primary" id="btn-post" type="submit" data-disable-with="正在保存...">保存</button>
                <a tabindex="2" href="javascript:;" class="btn btn-x btn-cancel" id="link-cancel-post">取消</a>
            </div>
        </form>
    </div>
</div>

<div class="comments streams">
    <?php foreach($operations as $operation){
        echo $this->render("/commons/_operation",["model"=>$operation]);
    }?>
</div>
    <?=$this->render("/commons/_targetActions",["model"=>$topic])?>
    <?=$this->render("/commons/_commentCreate",["target"=>$topic])?>
</div>
</div>
</div>