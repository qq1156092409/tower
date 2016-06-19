<?php
use app\models\Task;
use app\models\Item;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var $target Task|Item
 * @var $this View
 */
$request = Yii::$app->request;
?>
<div class="comment comment-form new">
    <form class="form form-editor form-comment-create" method="post" data-remote="true"
          action="<?= \yii\helpers\Url::to(["comment/create"]) ?>">
        <?= \yii\helpers\Html::hiddenInput($request->csrfParam, $request->getCsrfToken()) ?>
        <input type="hidden" name="Comment[model]"
               value="<?= \app\models\multiple\G::transfer($target->className()) ?>"/>
        <input type="hidden" name="Comment[value]" value="<?= $target->id ?>"/>
        <input id="comment-text" type="hidden" name="Comment[text]" value=""/>
        <a class="avatar-wrap" target="_blank" href="/members/f4880b71a92642c293ca7efc1f2256d9">
            <img class="avatar" width="50" height="50" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37">
        </a>

        <div class="comment-main">
            <div class="form-item btn-text-small">
                <div class="form-field">
                    <div class="fake-textarea" data-droppable="" style="display: block;">点击发表评论</div>
                    <textarea id="txt-new-comment" tabindex="1" autofocus="" data-validate="custom"
                              data-autosave="new-comment-content" data-mention-group="31cfd5556a4543b68cb489a242b1e9e7"
                              data-mention-type="project" class="comment-content" name="comment_content"
                              style="display: none;"></textarea>
                </div>
            </div>

            <div class="form-item hide">
            <div class="form-field">
            <div class="fake-textarea" data-droppable="" style="display: none;">点击发表评论</div>
            <div class="simditor" data-droppable="true">
            <div class="simditor-wrapper">
            <div class="simditor-toolbar" style="width: 628px; top: 0px; left: 422.5px;">
                <ul>
                    <li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-emoji"
                           href="javascript:;" title="表情"><span
                                class="simditor-icon simditor-icon-smile-o"></span></a>

                        <div class="toolbar-menu toolbar-menu-emoji">
                            <ul class="emoji-list">
                                <li data-name="smile"><img src="https://s.tower.im/emoji/smile.png"
                                                           width="20" height="20" alt="smile"></li>
                                <li data-name="smiley"><img src="https://s.tower.im/emoji/smiley.png"
                                                            width="20" height="20" alt="smiley"></li>
                                <li data-name="laughing"><img
                                        src="https://s.tower.im/emoji/laughing.png" width="20"
                                        height="20" alt="laughing"></li>
                                <li data-name="blush"><img src="https://s.tower.im/emoji/blush.png"
                                                           width="20" height="20" alt="blush"></li>
                                <li data-name="heart_eyes"><img
                                        src="https://s.tower.im/emoji/heart_eyes.png" width="20"
                                        height="20" alt="heart_eyes"></li>
                                <li data-name="smirk"><img src="https://s.tower.im/emoji/smirk.png"
                                                           width="20" height="20" alt="smirk"></li>
                                <li data-name="flushed"><img src="https://s.tower.im/emoji/flushed.png"
                                                             width="20" height="20" alt="flushed"></li>
                                <li data-name="grin"><img src="https://s.tower.im/emoji/grin.png"
                                                          width="20" height="20" alt="grin"></li>
                                <li data-name="wink"><img src="https://s.tower.im/emoji/wink.png"
                                                          width="20" height="20" alt="wink"></li>
                                <li data-name="kissing_closed_eyes"><img
                                        src="https://s.tower.im/emoji/kissing_closed_eyes.png"
                                        width="20" height="20" alt="kissing_closed_eyes"></li>
                                <li data-name="stuck_out_tongue_winking_eye"><img
                                        src="https://s.tower.im/emoji/stuck_out_tongue_winking_eye.png"
                                        width="20" height="20" alt="stuck_out_tongue_winking_eye"></li>
                                <li data-name="stuck_out_tongue"><img
                                        src="https://s.tower.im/emoji/stuck_out_tongue.png" width="20"
                                        height="20" alt="stuck_out_tongue"></li>
                                <li data-name="sleeping"><img
                                        src="https://s.tower.im/emoji/sleeping.png" width="20"
                                        height="20" alt="sleeping"></li>
                                <li data-name="worried"><img src="https://s.tower.im/emoji/worried.png"
                                                             width="20" height="20" alt="worried"></li>
                                <li data-name="expressionless"><img
                                        src="https://s.tower.im/emoji/expressionless.png" width="20"
                                        height="20" alt="expressionless"></li>
                                <li data-name="sweat_smile"><img
                                        src="https://s.tower.im/emoji/sweat_smile.png" width="20"
                                        height="20" alt="sweat_smile"></li>
                                <li data-name="cold_sweat"><img
                                        src="https://s.tower.im/emoji/cold_sweat.png" width="20"
                                        height="20" alt="cold_sweat"></li>
                                <li data-name="joy"><img src="https://s.tower.im/emoji/joy.png"
                                                         width="20" height="20" alt="joy"></li>
                                <li data-name="sob"><img src="https://s.tower.im/emoji/sob.png"
                                                         width="20" height="20" alt="sob"></li>
                                <li data-name="angry"><img src="https://s.tower.im/emoji/angry.png"
                                                           width="20" height="20" alt="angry"></li>
                                <li data-name="mask"><img src="https://s.tower.im/emoji/mask.png"
                                                          width="20" height="20" alt="mask"></li>
                                <li data-name="scream"><img src="https://s.tower.im/emoji/scream.png"
                                                            width="20" height="20" alt="scream"></li>
                                <li data-name="sunglasses"><img
                                        src="https://s.tower.im/emoji/sunglasses.png" width="20"
                                        height="20" alt="sunglasses"></li>
                                <li data-name="heart"><img src="https://s.tower.im/emoji/heart.png"
                                                           width="20" height="20" alt="heart"></li>
                                <li data-name="broken_heart"><img
                                        src="https://s.tower.im/emoji/broken_heart.png" width="20"
                                        height="20" alt="broken_heart"></li>
                                <li data-name="star"><img src="https://s.tower.im/emoji/star.png"
                                                          width="20" height="20" alt="star"></li>
                                <li data-name="anger"><img src="https://s.tower.im/emoji/anger.png"
                                                           width="20" height="20" alt="anger"></li>
                                <li data-name="exclamation"><img
                                        src="https://s.tower.im/emoji/exclamation.png" width="20"
                                        height="20" alt="exclamation"></li>
                                <li data-name="question"><img
                                        src="https://s.tower.im/emoji/question.png" width="20"
                                        height="20" alt="question"></li>
                                <li data-name="zzz"><img src="https://s.tower.im/emoji/zzz.png"
                                                         width="20" height="20" alt="zzz"></li>
                                <li data-name="thumbsup"><img
                                        src="https://s.tower.im/emoji/thumbsup.png" width="20"
                                        height="20" alt="thumbsup"></li>
                                <li data-name="thumbsdown"><img
                                        src="https://s.tower.im/emoji/thumbsdown.png" width="20"
                                        height="20" alt="thumbsdown"></li>
                                <li data-name="ok_hand"><img src="https://s.tower.im/emoji/ok_hand.png"
                                                             width="20" height="20" alt="ok_hand"></li>
                                <li data-name="punch"><img src="https://s.tower.im/emoji/punch.png"
                                                           width="20" height="20" alt="punch"></li>
                                <li data-name="v"><img src="https://s.tower.im/emoji/v.png" width="20"
                                                       height="20" alt="v"></li>
                                <li data-name="clap"><img src="https://s.tower.im/emoji/clap.png"
                                                          width="20" height="20" alt="clap"></li>
                                <li data-name="muscle"><img src="https://s.tower.im/emoji/muscle.png"
                                                            width="20" height="20" alt="muscle"></li>
                                <li data-name="pray"><img src="https://s.tower.im/emoji/pray.png"
                                                          width="20" height="20" alt="pray"></li>
                                <li data-name="skull"><img src="https://s.tower.im/emoji/skull.png"
                                                           width="20" height="20" alt="skull"></li>
                                <li data-name="trollface"><img
                                        src="https://s.tower.im/emoji/trollface.png" width="20"
                                        height="20" alt="trollface"></li>
                            </ul>
                        </div>
                    </li>
                    <li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-bold"
                           href="javascript:;" title="加粗文字 ( Ctrl + b )"><span
                                class="simditor-icon simditor-icon-bold"></span></a></li>
                    <li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-italic"
                           href="javascript:;" title="斜体文字 ( Ctrl + i )"><span
                                class="simditor-icon simditor-icon-italic"></span></a></li>
                    <li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-underline"
                           href="javascript:;" title="下划线文字 ( Ctrl + u )"><span
                                class="simditor-icon simditor-icon-underline"></span></a></li>
                    <li><a tabindex="-1" unselectable="on"
                           class="toolbar-item toolbar-item-strikethrough" href="javascript:;"
                           title="删除线文字"><span class="simditor-icon simditor-icon-strikethrough"></span></a>
                    </li>
                    <li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-color"
                           href="javascript:;" title="文字颜色"><span
                                class="simditor-icon simditor-icon-tint"></span></a>

                        <div class="toolbar-menu toolbar-menu-color">
                            <ul class="color-list">
                                <li><a href="javascript:;" class="font-color font-color-1"
                                       data-color=""></a></li>
                                <li><a href="javascript:;" class="font-color font-color-2"
                                       data-color=""></a></li>
                                <li><a href="javascript:;" class="font-color font-color-3"
                                       data-color=""></a></li>
                                <li><a href="javascript:;" class="font-color font-color-4"
                                       data-color=""></a></li>
                                <li><a href="javascript:;" class="font-color font-color-5"
                                       data-color=""></a></li>
                                <li><a href="javascript:;" class="font-color font-color-6"
                                       data-color=""></a></li>
                                <li><a href="javascript:;" class="font-color font-color-7"
                                       data-color=""></a></li>
                                <li><a href="javascript:;" class="font-color font-color-default"
                                       data-color=""></a></li>
                            </ul>
                        </div>
                    </li>
                    <li><span class="separator"></span></li>
                    <li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-ol"
                           href="javascript:;" title="有序列表 ( ctrl + / )"><span
                                class="simditor-icon simditor-icon-list-ol"></span></a></li>
                    <li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-ul"
                           href="javascript:;" title="无序列表 ( Ctrl + . )"><span
                                class="simditor-icon simditor-icon-list-ul"></span></a></li>
                    <li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-blockquote"
                           href="javascript:;" title="引用"><span
                                class="simditor-icon simditor-icon-quote-left"></span></a></li>
                    <li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-code"
                           href="javascript:;" title="插入代码"><span
                                class="simditor-icon simditor-icon-code"></span></a></li>
                    <li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-indent"
                           href="javascript:;" title="向右缩进 (Tab)"><span
                                class="simditor-icon simditor-icon-indent"></span></a></li>
                    <li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-outdent"
                           href="javascript:;" title="向左缩进 (Shift + Tab)"><span
                                class="simditor-icon simditor-icon-outdent"></span></a></li>
                    <li><span class="separator"></span></li>
                    <li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-link"
                           href="javascript:;" title="插入链接"><span
                                class="simditor-icon simditor-icon-link"></span></a></li>
                    <li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-image"
                           href="javascript:;" title="插入图片"><span
                                class="simditor-icon simditor-icon-picture-o"></span></a>

                        <div class="toolbar-menu toolbar-menu-image">
                            <ul>
                                <li><a tabindex="-1" unselectable="on"
                                       class="menu-item menu-item-upload-image" href="javascript:;"
                                       title="上传图片"><span>上传图片</span><input type="file" title="上传图片"
                                                                            accept="image/*"></a></li>
                                <li><a tabindex="-1" unselectable="on"
                                       class="menu-item menu-item-external-image" href="javascript:;"
                                       title="外链图片"><span>外链图片</span></a></li>
                            </ul>
                        </div>
                    </li>
                    <li><a tabindex="-1" unselectable="on" class="toolbar-item toolbar-item-attachment"
                           href="javascript:;" title=""><span
                                class="simditor-icon simditor-icon-paperclip"></span><input type="file"
                                                                                            name="upload_file"
                                                                                            tabindex="-1"
                                                                                            multiple="true"></a>
                    </li>
                </ul>
            </div>
            <div class="simditor-placeholder" style="top: 31px;"></div>
            <div class="simditor-body" contenteditable="true" tabindex="1"><p><br></p></div>
            <textarea id="txt-new-comment" tabindex="1" autofocus="" data-validate="custom"
                      data-autosave="new-comment-content"
                      data-mention-group="31cfd5556a4543b68cb489a242b1e9e7" data-mention-type="project"
                      class="comment-content hide" name="comment_content"
                      style="display: none;"></textarea><input type="hidden" name="is_html" value="1">
            </div>
            <div tabindex="-1" contenteditable="true" class="simditor-paste-area"
                 style="width: 1px; height: 1px; overflow: hidden; position: fixed; right: 0px; bottom: 100px;"></div>
            <div class="simditor-popover code-popover">
                <div class="code-settings">
                    <div class="settings-field">
                        <select class="select-lang">
                            <option value="-1">选择程序语言</option>
                            <option value="bash">Bash</option>
                            <option value="c++">C++</option>
                            <option value="cs">C#</option>
                            <option value="css">CSS</option>
                            <option value="erlang">Erlang</option>
                            <option value="less">Less</option>
                            <option value="scss">Sass</option>
                            <option value="diff">Diff</option>
                            <option value="coffeeScript">CoffeeScript</option>
                            <option value="html">Html,XML</option>
                            <option value="json">JSON</option>
                            <option value="java">Java</option>
                            <option value="js">JavaScript</option>
                            <option value="markdown">Markdown</option>
                            <option value="oc">Objective C</option>
                            <option value="php">PHP</option>
                            <option value="perl">Perl</option>
                            <option value="python">Python</option>
                            <option value="ruby">Ruby</option>
                            <option value="sql">SQL</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="simditor-popover link-popover">
                <div class="link-settings">
                    <div class="settings-field">
                        <label>文本</label>
                        <input class="link-text" type="text">
                        <a class="btn-unlink" href="javascript:;" title="移除链接" tabindex="-1"><span
                                class="simditor-icon simditor-icon-unlink"></span></a>
                    </div>
                    <div class="settings-field">
                        <label>地址</label>
                        <input class="link-url" type="text">
                    </div>
                </div>
            </div>
            <div class="simditor-popover image-popover">
                <div class="link-settings">
                    <div class="settings-field">
                        <label>图片地址</label>
                        <input class="image-src" type="text" tabindex="1">
                        <a class="btn-upload" href="javascript:;" title="上传图片" tabindex="-1">
                            <span class="simditor-icon simditor-icon-upload"></span>
                            <input type="file" title="上传图片" accept="image/*"></a>
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
                </div>
            </div>
            <div class="simditor-attachments ui-sortable"></div>
            <div class="simditor-mention-popover" style="display: none;">
                <div class="items"><a class="item" href="javascript:;" data-pinyin="dengjianqiang"
                                      data-abbr="djq" data-name="邓健强">
                        <img src="https://avatar.tower.im/b77fe6a1d67e4fc1863e3b860ca0815b"
                             class="avatar"><span>邓健强</span>
                    </a><a class="item" href="javascript:;" data-pinyin="dengjianqiangxiaoxiaohao"
                           data-abbr="djqxxh" data-name="邓健强小小号">
                        <img src="<?=Url::to("public/default_avatars/winter.jpg")?>" class="avatar"><span>邓健强小小号</span>
                    </a><a></a></div>
            </div>
            </div>
            </div>
            </div>

            <div class="form-item notify hide">
                <div class="notify-title">
                    <div class="notify-title-title">发送通知给：</div>
                    <div class="notify-title-summary">
						<span class="receiver"><span data-guid="79a85cca56194bce8d0089acd25af308">
								邓健强
							</span><span class="sp">, </span><span data-guid="1ff0fd3d4a404428a1594e9ebdb2360a">
								邓健强小小号
							</span></span>
						<span class="change-notify">
							[ <a href="javascript:;" class="link-change-notify">更改</a> ]
						</span>
                    </div>
                </div>


            </div>

            <div class="form-buttons hide">
                <button tabindex="1" type="submit" class="btn btn-primary btn-create-comment"
                        data-disable-with="正在发送...">发表评论
                </button>
                <button tabindex="2" type="button" class="btn btn-x btn-cancel-create-comment">取消</button>
            </div>

        </div>
    </form>
</div>