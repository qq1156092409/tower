<?php
use yii\widgets\ActiveForm;
use yii\web\View;
use app\models\search\Search;
use yii\helpers\Url;
use app\components\JsManager;

/**
 * @var $this View
 * @var $model Search
 */
$data=$model->getData();
JsManager::instance()->registers([
    "js/models/yii.search.js",
]);
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax">
        <div class="page-inner" id="page-search-result" data-page-name="1的搜索结果">
            <div class="condition-filters">
                <span class="condition-filter" id="search-prev-show">
                        所有项目、日历和周报
                    <i class="twr twr-caret-down"></i>
                </span>
                <span class="condition-filter" id="search-creator-show">
                        方片周
                    <i class="twr twr-caret-down"></i>
                </span>
                <span class="condition-filter" id="search-model-show">
                        所有内容
                    <i class="twr twr-caret-down"></i>
                </span>
            </div>
            <div class="conditions">
                <form id="search-form" class="form form-condition-search" action="<?=Url::to(["/"])?>" method="get">
                    <input class="attr-r" type="hidden" name="r" value="team/search" />
                    <input class="attr-team" type="hidden" name="id" value="<?=$model->teamID?>" />
                    <input class="attr-prev" type="hidden" name="prev" value="<?=$model->prev?>" />
                    <input class="attr-creator" type="hidden" name="creatorID" value="<?=$model->creatorID?>" />
                    <input class="attr-model" type="hidden" name="model" value="<?=$model->model?>" />
                    <input class="attr-order" type="hidden" name="order" value="<?=$model->order?>" />
                    <div class="condition-keyword">
                        <input type="text" class="keyword-input attr-keyword" name="keyword" value="<?=$model->keyword?>">
                        <button type="submit" class="btn btn-large btn-primary search-btn">搜索</button>
                    </div>
                </form>
            </div>
            <div class="condition-main">
                <span>
                    搜索结果共
                    <span class="result-count">
                        <?=$data["total_found"]?>
                    </span> 条 &nbsp;
                </span>
                <span id="search-order-show" class="condition-sort">
                        按时间排序
                    <i class="twr twr-caret-down"></i>
                </span>
            </div>
            <ul class="results" data-page="1">
                <li data-category="Todo">
                    <div class="side">任务：</div>
                    <div class="main">
                        <p class="result-title">
                            <a href="/projects/c96929b616cd4100a6225ea090264459/todos/456491b37ed44f16a846dbce78147c10"
                               class="todo-rest" data-stack="true"><span class="match">1</span>-6</a>
                        </p>
                        <p>
                            任务清单：
                            <a href="/projects/c96929b616cd4100a6225ea090264459/lists/507edd4262334105a07823c203cc5992/show"
                               class="todolist-rest" data-stack="true">清单<span class="match">1</span></a>
                        </p>
                        <p class="result-ancestor">
                            项目：
                            <a href="/projects/c96929b616cd4100a6225ea090264459" data-stack-root="true"
                               data-stack="true">测试项目-new</a>
                        </p>
                        <span class="result-time" title="2015-09-05 22:33"
                              data-readable-time="2015-09-05T22:33:05+08:00">9月5日</span>
                    </div>
                </li>
                <li data-category="Todo">
                    <div class="side">
                        <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" data-stack="">
                            <img class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37"
                                 width="50" height="50"></a>
                    </div>
                    <div class="main">
                        <p class="result-title">
                            回复：
                            <a href="/projects/c96929b616cd4100a6225ea090264459/todos/12effdd54a0e4348bdf371befbc247b6"
                               class="todo-rest" data-stack="true"><span class="match">1</span>-2-new</a>
                        </p>
                        <p>
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" class="author" data-stack="">方片周</a> -
                <span>
                    <span class="match">1</span>-2
                </span>
                        </p>
                        <p class="result-ancestor">
                            项目：
                            <a href="/projects/c96929b616cd4100a6225ea090264459" data-stack-root="true"
                               data-stack="true">测试项目-new</a>
                        </p>
                        <span class="result-time" title="2015-09-04 17:01"
                              data-readable-time="2015-09-04T17:01:29+08:00">9月4日</span>
                    </div>
                </li>
                <li data-category="Todo">
                    <div class="side">任务：</div>
                    <div class="main">
                        <p class="result-title completed">
                            <a href="/projects/c96929b616cd4100a6225ea090264459/todos/c8cd18875ee9488d87eb28b727ea8a51"
                               class="todo-rest" data-stack="true"><span class="match">1</span>-5</a>
                        </p>
                        <p>
                            任务清单：
                            <a href="/projects/c96929b616cd4100a6225ea090264459/lists/507edd4262334105a07823c203cc5992/show"
                               class="todolist-rest" data-stack="true">清单<span class="match">1</span></a>
                        </p>
                        <p class="result-ancestor">
                            项目：
                            <a href="/projects/c96929b616cd4100a6225ea090264459" data-stack-root="true"
                               data-stack="true">测试项目-new</a>
                        </p>
                        <span class="result-time" title="2015-08-29 17:53"
                              data-readable-time="2015-08-29T17:53:49+08:00">8月29日</span>
                    </div>
                </li>
                <li data-category="Todo">
                    <div class="side">任务：</div>
                    <div class="main">
                        <p class="result-title">
                            <a href="/projects/c96929b616cd4100a6225ea090264459/todos/a7aff8d871f0426ab6f92e294e529e58"
                               class="todo-rest" data-stack="true"><span class="match">1</span>-4</a>
                        </p>
                        <p>
                            任务清单：
                            <a href="/projects/c96929b616cd4100a6225ea090264459/lists/507edd4262334105a07823c203cc5992/show"
                               class="todolist-rest" data-stack="true">清单<span class="match">1</span></a>
                        </p>
                        <p class="result-ancestor">
                            项目：
                            <a href="/projects/c96929b616cd4100a6225ea090264459" data-stack-root="true"
                               data-stack="true">测试项目-new</a>
                        </p>
                        <span class="result-time" title="2015-08-29 17:48"
                              data-readable-time="2015-08-29T17:48:12+08:00">8月29日</span>
                    </div>
                </li>
                <li data-category="Todo">
                    <div class="side">任务：</div>
                    <div class="main">
                        <p class="result-title">
                            <a href="/projects/c96929b616cd4100a6225ea090264459/todos/3705e3bb4fcd4a38955963d1b587faba"
                               class="todo-rest" data-stack="true"><span class="match">1</span>-3</a>
                        </p>
                        <p>
                            任务清单：
                            <a href="/projects/c96929b616cd4100a6225ea090264459/lists/507edd4262334105a07823c203cc5992/show"
                               class="todolist-rest" data-stack="true">清单<span class="match">1</span></a>
                        </p>

                        <p class="result-ancestor">
                            项目：
                            <a href="/projects/c96929b616cd4100a6225ea090264459" data-stack-root="true"
                               data-stack="true">测试项目-new</a>
                        </p>
                        <span class="result-time" title="2015-08-29 17:44"
                              data-readable-time="2015-08-29T17:44:01+08:00">8月29日</span>
                    </div>
                </li>
                <li data-category="Todo">
                    <div class="side">任务：</div>
                    <div class="main">
                        <p class="result-title">
                            <a href="/projects/c96929b616cd4100a6225ea090264459/todos/fad4715161ce4915a4a57c57a2f3e6d4"
                               class="todo-rest" data-stack="true"><span class="match">1</span></a>
                        </p>

                        <p>
                            任务清单：
                            <a href="/projects/c96929b616cd4100a6225ea090264459/lists/c7385f1855304877a2612ead3c2e25ce/show"
                               class="todolist-rest" data-stack="true">未归类任务</a>
                        </p>

                        <p class="result-ancestor">
                            项目：

                            <a href="/projects/c96929b616cd4100a6225ea090264459" data-stack-root="true"
                               data-stack="true">测试项目-new</a>
                        </p>

                        <span class="result-time" title="2015-08-09 18:08"
                              data-readable-time="2015-08-09T18:08:43+08:00">8月9日</span>

                    </div>

                </li>
                <li data-category="Message">


                    <div class="side">
                        <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" data-stack="">
                            <img class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37"
                                 width="50" height="50"></a>
                    </div>
                    <div class="main">
                        <p class="result-title">
                            <a href="/projects/26dc9eb2cbbc48ac98e0c3d876618369/messages/11b9cbcb761e479dab8fd2dc95045080"
                               class="message-rest" data-stack="true"><span class="match">1</span></a>
                        </p>

                        <p>
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" class="author" data-stack="">方片周</a> -
                <span>
                    R.T.
                </span>
                        </p>

                        <p class="result-ancestor">
                            项目：

                            <a href="/projects/26dc9eb2cbbc48ac98e0c3d876618369" data-stack-root="true"
                               data-stack="true">my-tower</a>
                        </p>

                        <span class="result-time" title="2015-08-09 01:16"
                              data-readable-time="2015-08-09T01:16:52+08:00">8月9日</span>

                    </div>

                </li>
                <li data-category="Document">

                    <div class="side">文档：</div>
                    <div class="main">
                        <p class="result-title">
                            <a href="/projects/c96929b616cd4100a6225ea090264459/docs/9dffe7ab27404009b30853fe55f7e0e9"
                               class="document-rest" data-stack="true">文档<span class="match">1</span></a>
                        </p>

                        <p>
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" class="author" data-stack="">方片周</a> -
                <span>
                    内容<span class="match">1</span>
                </span>
                        </p>

                        <p class="result-ancestor">
                            项目：

                            <a href="/projects/c96929b616cd4100a6225ea090264459" data-stack-root="true"
                               data-stack="true">测试项目-new</a>
                        </p>

                        <span class="result-time" title="2015-08-02 10:24"
                              data-readable-time="2015-08-02T10:24:46+08:00">8月2日</span>

                    </div>
                </li>
                <li data-category="Todo">


                    <div class="side">任务：</div>
                    <div class="main">
                        <p class="result-title">
                            <a href="/projects/c96929b616cd4100a6225ea090264459/todos/9034367474174e4c9317e0cd0cc874f5"
                               class="todo-rest" data-stack="true">2-<span class="match">1</span></a>
                        </p>

                        <p>
                            任务清单：
                            <a href="/projects/c96929b616cd4100a6225ea090264459/lists/a33fbed9eedc410a9d1ac7ab4276d5fe/show"
                               class="todolist-rest" data-stack="true">清单2</a>
                        </p>

                        <p class="result-ancestor">
                            项目：

                            <a href="/projects/c96929b616cd4100a6225ea090264459" data-stack-root="true"
                               data-stack="true">测试项目-new</a>
                        </p>

                        <span class="result-time" title="2015-07-16 11:26"
                              data-readable-time="2015-07-16T11:26:19+08:00">7月16日</span>

                    </div>

                </li>
                <li data-category="Todo">


                    <div class="side">任务：</div>
                    <div class="main">
                        <p class="result-title">
                            <a href="/projects/c96929b616cd4100a6225ea090264459/todos/12effdd54a0e4348bdf371befbc247b6"
                               class="todo-rest" data-stack="true"><span class="match">1</span>-2-new</a>
                        </p>

                        <p>
                            任务清单：
                            <a href="/projects/c96929b616cd4100a6225ea090264459/lists/507edd4262334105a07823c203cc5992/show"
                               class="todolist-rest" data-stack="true">清单<span class="match">1</span></a>
                        </p>

                        <p class="result-ancestor">
                            项目：

                            <a href="/projects/c96929b616cd4100a6225ea090264459" data-stack-root="true"
                               data-stack="true">测试项目-new</a>
                        </p>

                        <span class="result-time" title="2015-07-16 11:25"
                              data-readable-time="2015-07-16T11:25:44+08:00">7月16日</span>

                    </div>

                </li>
                <li data-category="Week">


                    <div class="side">
                        <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" data-stack="">
                            <img class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37"
                                 width="50" height="50"></a>
                    </div>
                    <div class="main">
                        <p class="result-title">
                            回复：
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe/weekly_reports?start_at=2015-05-04"
                               data-stack="true">方片周的周报（20<span class="match">1</span>5年第<span class="match">1</span>9周）</a>
                        </p>

                        <p>
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" class="author" data-stack="">方片周</a> -
                <span>
                    <span class="match">1</span>
                </span>
                        </p>


                        <span class="result-time" title="2015-05-13 21:53"
                              data-readable-time="2015-05-13T21:53:03+08:00">5月13日</span>

                    </div>

                </li>
                <li data-category="WeeklyReport">

                    <div class="side">
                        <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" data-stack="">
                            <img class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37"
                                 width="50" height="50"></a>
                    </div>
                    <div class="main">
                        <p class="result-title">
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe/weekly_reports?start_at=2015-05-04"
                               data-stack="true">方片周的周报（20<span class="match">1</span>5年第<span class="match">1</span>9周）</a>
                        </p>

                        <p>
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" class="author" data-stack="">方片周</a> -
                <span>
                    <span class="match">1</span>
                </span>
                        </p>
                    </div>

                </li>
                <li data-category="WeeklyReport">

                    <div class="side">
                        <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" data-stack="">
                            <img class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37"
                                 width="50" height="50"></a>
                    </div>
                    <div class="main">
                        <p class="result-title">
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe/weekly_reports?start_at=2015-05-04"
                               data-stack="true">方片周的周报（20<span class="match">1</span>5年第<span class="match">1</span>9周）</a>
                        </p>

                        <p>
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" class="author" data-stack="">方片周</a> -
                <span>
                    <span class="match">1</span>
                </span>
                        </p>
                    </div>

                </li>
                <li data-category="WeeklyReport">

                    <div class="side">
                        <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" data-stack="">
                            <img class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37"
                                 width="50" height="50"></a>
                    </div>
                    <div class="main">
                        <p class="result-title">
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe/weekly_reports?start_at=2015-05-04"
                               data-stack="true">方片周的周报（20<span class="match">1</span>5年第<span class="match">1</span>9周）</a>
                        </p>

                        <p>
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" class="author" data-stack="">方片周</a> -
                <span>
                    <span class="match">1</span>
                </span>
                        </p>
                    </div>

                </li>
                <li data-category="WeeklyReport">

                    <div class="side">
                        <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" data-stack="">
                            <img class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37"
                                 width="50" height="50"></a>
                    </div>
                    <div class="main">
                        <p class="result-title">
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe/weekly_reports?start_at=2015-05-04"
                               data-stack="true">方片周的周报（20<span class="match">1</span>5年第<span class="match">1</span>9周）</a>
                        </p>

                        <p>
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" class="author" data-stack="">方片周</a> -
                <span>
                    <span class="match">1</span>
                </span>
                        </p>
                    </div>

                </li>
                <li data-category="Document">


                    <div class="side">
                        <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" data-stack="">
                            <img class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37"
                                 width="50" height="50"></a>
                    </div>
                    <div class="main">
                        <p class="result-title">
                            回复：
                            <a href="/projects/c96929b616cd4100a6225ea090264459/docs/c0d7993ad27248e8a0a05b16847e77ce"
                               class="document-rest" data-stack="true">文档<span class="match">1</span></a>
                        </p>

                        <p>
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" class="author" data-stack="">方片周</a> -
                <span>
                    <span class="match">1</span>
                </span>
                        </p>

                        <p class="result-ancestor">
                            项目：

                            <a href="/projects/c96929b616cd4100a6225ea090264459" data-stack-root="true"
                               data-stack="true">测试项目-new</a>
                        </p>

                        <span class="result-time" title="2015-05-08 15:45"
                              data-readable-time="2015-05-08T15:45:35+08:00">5月8日</span>

                    </div>

                </li>
                <li data-category="Document">

                    <div class="side">文档：</div>
                    <div class="main">
                        <p class="result-title">
                            <a href="/projects/c96929b616cd4100a6225ea090264459/docs/c0d7993ad27248e8a0a05b16847e77ce"
                               class="document-rest" data-stack="true">文档<span class="match">1</span></a>
                        </p>

                        <p>
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" class="author" data-stack="">方片周</a> -
                <span>
                    内容
                </span>
                        </p>

                        <p class="result-ancestor">
                            项目：

                            <a href="/projects/c96929b616cd4100a6225ea090264459" data-stack-root="true"
                               data-stack="true">测试项目-new</a>
                        </p>

                        <span class="result-time" title="2015-05-08 15:43"
                              data-readable-time="2015-05-08T15:43:38+08:00">5月8日</span>

                    </div>
                </li>
                <li data-category="Todo">


                    <div class="side">
                        <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" data-stack="">
                            <img class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37"
                                 width="50" height="50"></a>
                    </div>
                    <div class="main">
                        <p class="result-title">
                            回复：
                            <a href="/projects/c96929b616cd4100a6225ea090264459/todos/b41a548e22f7438cb0004017f4ee57ad"
                               class="todo-rest" data-stack="true">任务<span class="match">1</span>-<span
                                    class="match">1</span></a>
                        </p>

                        <p>
                            <a href="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe" class="author" data-stack="">方片周</a> -
                <span>
                    <span class="match">1</span>
                </span>
                        </p>

                        <p class="result-ancestor">
                            项目：

                            <a href="/projects/c96929b616cd4100a6225ea090264459" data-stack-root="true"
                               data-stack="true">测试项目-new</a>
                        </p>

                        <span class="result-time" title="2015-05-08 15:43"
                              data-readable-time="2015-05-08T15:43:10+08:00">5月8日</span>

                    </div>

                </li>
                <li data-category="Todo">


                    <div class="side">任务：</div>
                    <div class="main">
                        <p class="result-title completed">
                            <a href="/projects/c96929b616cd4100a6225ea090264459/todos/b41a548e22f7438cb0004017f4ee57ad"
                               class="todo-rest" data-stack="true">任务<span class="match">1</span>-<span
                                    class="match">1</span></a>
                        </p>

                        <p>
                            任务清单：
                            <a href="/projects/c96929b616cd4100a6225ea090264459/lists/507edd4262334105a07823c203cc5992/show"
                               class="todolist-rest" data-stack="true">清单<span class="match">1</span></a>
                        </p>

                        <p class="result-ancestor">
                            项目：

                            <a href="/projects/c96929b616cd4100a6225ea090264459" data-stack-root="true"
                               data-stack="true">测试项目-new</a>
                        </p>

                        <span class="result-time" title="2015-05-08 15:43"
                              data-readable-time="2015-05-08T15:43:01+08:00">5月8日</span>

                    </div>

                </li>

            </ul>

            <ul class="results" data-page="2">
                <li data-category="Todolist">


                    <div class="side">任务清单：</div>
                    <div class="main">
                        <p class="result-title">
                            <a href="/projects/c96929b616cd4100a6225ea090264459/lists/507edd4262334105a07823c203cc5992/show"
                               class="todolist-rest" data-stack="true">清单<span class="match">1</span></a>
                        </p>

                        <p class="result-ancestor">
                            项目：

                            <a href="/projects/c96929b616cd4100a6225ea090264459" data-stack-root="true"
                               data-stack="true">测试项目-new</a>
                        </p>

                        <span class="result-time" title="2015-05-08 15:42"
                              data-readable-time="2015-05-08T15:42:54+08:00">5月8日</span>

                    </div>
                </li>

            </ul>
            <a href="javascript:;" id="btn-load-more" class="over" style="display: block;">没有更多内容了</a>
        </div>
    </div>
</div>

<div id="search-prev-pop" class="hide simple-popover dropdown-list no-arrow search-popover scrollable target-filter-popover direction-bottom-center" style="top: 109.2px; left: 296.9px;">
    <div class="simple-popover-content">
        <ul class="menu">
            <li>
                <a href="javascript:;" data-value="-1" data-type="project">所有项目、日历和周报
                    <i class="twr twr-check selected"></i>
                </a>
            </li>
        </ul>
        <ul class="menu">
            <p class="title"><span>项目</span></p>
            <ul class="menu scroll">
                <li>
                    <a href="javascript:;" data-value="c96929b616cd4100a6225ea090264459" data-type="project">
                        测试项目-new

                    </a>
                </li>
                <li>
                    <a href="javascript:;" data-value="26dc9eb2cbbc48ac98e0c3d876618369" data-type="project">
                        my-tower
                    </a>
                </li>
            </ul>
        </ul>
    </div>
    <div class="simple-popover-arrow" style="">
        <i class="arrow arrow-shadow-1"></i>
        <i class="arrow arrow-shadow-0"></i>
        <i class="arrow arrow-border"></i>
        <i class="arrow arrow-basic"></i>
    </div>
</div>
<div id="search-creator-pop" class="hide simple-popover dropdown-list no-arrow search-popover scrollable direction-bottom-center" style="top: 109.2px; left: 405.225px;">
    <div class="simple-popover-content">
        <ul class="menu">
            <li>
                <a href="javascript:;" data-value="-1" data-type="member">所有人
                    <i class="twr twr-check selected"></i>
                </a>
            </li>
            <li class="part-line"></li>
        </ul>
        <ul class="menu scroll">
            <li>
                <a href="javascript:;" data-value="5ee2cb7e11e84bc2a5f8a627a14b46fe" data-type="member">
                    方片周

                </a>
            </li>
            <li>
                <a href="javascript:;" data-value="974ae2692d83457aa0c6068600674b43" data-type="member">
                    邓健强

                </a>
            </li>
        </ul>
    </div>
    <div class="simple-popover-arrow" style="">
        <i class="arrow arrow-shadow-1"></i>
        <i class="arrow arrow-shadow-0"></i>
        <i class="arrow arrow-border"></i>
        <i class="arrow arrow-basic"></i>
    </div>
</div>
<div id="search-model-pop" class="hide simple-popover dropdown-list no-arrow search-popover direction-bottom-center" style="top: 109.2px; left: 518.862px;">
    <div class="simple-popover-content">
        <ul class="menu">
            <li>
                <a href="javascript:;" data-value="-1" data-type="category">所有内容
                    <i class="twr twr-check selected"></i>
                </a>
            </li>
        </ul>
        <ul class="menu">
            <li class="part-line"></li>
            <li>
                <a href="javascript:;" data-value="2" data-type="category">
                    任务

                </a>
            </li>
            <li>
                <a href="javascript:;" data-value="7" data-type="category">
                    评论

                </a>
            </li>
            <li>
                <a href="javascript:;" data-value="5" data-type="category">
                    文档

                </a>
            </li>
            <li>
                <a href="javascript:;" data-value="1" data-type="category">
                    任务清单

                </a>
            </li>
        </ul>
    </div>
    <div class="simple-popover-arrow" style="">
        <i class="arrow arrow-shadow-1"></i>
        <i class="arrow arrow-shadow-0"></i>
        <i class="arrow arrow-border"></i>
        <i class="arrow arrow-basic"></i>
    </div>
</div>
<div id="search-order-pop" class="hide simple-popover dropdown-list no-arrow search-popover scrollable direction-bottom-center" style="top: 200.2px; left: 392.388px;">
    <div class="simple-popover-content">
        <ul class="menu">
            <li>
                <a href="javascript:;" data-value="1" data-type="sort">
                    按时间排序
                    <i class="twr twr-check selected"></i>
                </a>
            </li>
            <li>
                <a href="javascript:;" data-value="2" data-type="sort">
                    按相关度排序
                </a>
            </li>
        </ul>
    </div>
    <div class="simple-popover-arrow" style="">
        <i class="arrow arrow-shadow-1"></i>
        <i class="arrow arrow-shadow-0"></i>
        <i class="arrow arrow-border"></i>
        <i class="arrow arrow-basic"></i>
    </div>
</div>