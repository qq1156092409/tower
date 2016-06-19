<?php
use \app\models\Task;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-7-16
 * Time: 下午10:33
 */
$finishedCount=count($unFinishedTasks);
$totalCount=count($tasks);
?>
<div class="container workspace simple-stack simple-stack-transition">
<div class="page page-root simple-pjax page-behind" style="">
    <a class="link-page-behind" data-stack="" href="<?=$project->viewUrl?>"><?=$project->name?></a>
</div>
<div class="page page-1 simple-pjax" style="">
<div class="page-inner" data-default-todolist="" id="page-todolist">
<div class="todos-all">
    <div class="todolists-wrap">
        <div class="todolists">
            <div class="todolist" data-guid="c7385f1855304877a2612ead3c2e25ce" data-sort="0"
                 data-creator-guid="5ee2cb7e11e84bc2a5f8a627a14b46fe"
                 data-project-guid="c96929b616cd4100a6225ea090264459">

                <div class="title">
                    <div class="todolist-actions actions">
                        <div class="inr">
                            <a href="/projects/c96929b616cd4100a6225ea090264459/lists/c7385f1855304877a2612ead3c2e25ce/toggle_archived"
                               class="archive" data-loading="true" data-method="put" data-remote="true"
                               title="归档（请确认清单内任务都已完成）">归档</a>
                            <a href="/projects/c96929b616cd4100a6225ea090264459/lists/c7385f1855304877a2612ead3c2e25ce/edit"
                               class="edit" data-remote="true" data-loading="true" data-mothod="get" title="编辑">编辑</a>

                        </div>
                    </div>

                    <h4>
    <span class="name-non-linkable">
        <span class="todolist-rest">未归类任务</span>
    </span>
    <span class="name">
        <a href="/projects/c96929b616cd4100a6225ea090264459/lists/c7385f1855304877a2612ead3c2e25ce/show"
           class="todolist-rest" data-stack="true">未归类任务</a>
    </span>


                        <a href="javascript:;" class="fold">
                            <i class="twr twr-angle-up"></i>
                        </a>
                    </h4>

                    <div class="progress">
                        <div class="bar">
                            <div id="bar-schedule" class="inner-bar" style="width:<?=$totalCount?(100*$finishedCount/$totalCount):100?>%"></div>
                        </div>
                        <span class="count"><span id="count-finished"><?=$finishedCount?></span>/<span id="count-total"><?=$totalCount?></span></span>
                    </div>


                </div>


                <ul class="todos todos-uncompleted ui-sortable">
                    <?php foreach($unFinishedTasks as $task){
                        echo $this->render("/commons/_task",["model"=>$task]);
                    } ?>
                </ul>

                <ul class="todo-new-wrap"></ul>
                <a href="javascript:;" class="btn-new-todo"
                   data-url="/projects/c96929b616cd4100a6225ea090264459/lists/c7385f1855304877a2612ead3c2e25ce"
                   data-request-members="c96929b616cd4100a6225ea090264459">添加新任务</a>

                <ul class="todos todos-completed" data-length="0"
                    data-url="/projects/c96929b616cd4100a6225ea090264459/lists/c7385f1855304877a2612ead3c2e25ce/completed">
                    <?php foreach($finishedTasks as $task){
                        echo $this->render("/commons/_task",["model"=>$task]);
                    } ?>
                </ul>

            </div>


        </div>
    </div>

    <div class="comments streams">
    </div>

</div>

<div class="detail-star-action">
    <a href="/projects/c96929b616cd4100a6225ea090264459/lists/c7385f1855304877a2612ead3c2e25ce/star?muid=c7385f1855304877a2612ead3c2e25ce"
       class="detail-action detail-action-star" data-itemid="1027647" data-itemtype="Todolist" data-loading="true"
       data-remote="true" rel="nofollow" title="收藏">收藏</a>
</div>

<div class="detail-actions">
    <div class="item">
        <a href="javascript:;" class="detail-action detail-action-edit">编辑</a>
    </div>
    <div class="item" data-visible-to="member">
        <a href="/projects/c96929b616cd4100a6225ea090264459/lists/c7385f1855304877a2612ead3c2e25ce/toggle_archived"
           class="detail-action detail-action-archive" data-loading="true" data-method="put" data-remote="true"
           title="请确认清单内任务都已完成">归档</a>
    </div>


</div>
<div class="comment comment-form new">
    <form class="form form-editor form-new-comment" method="post" data-remote="true"
          action="/projects/c96929b616cd4100a6225ea090264459/lists/c7385f1855304877a2612ead3c2e25ce/show/comments">

        <a class="avatar-wrap" target="_blank" href="/members/974ae2692d83457aa0c6068600674b43">
            <img class="avatar" width="50" height="50" src="https://avatar.tower.im/b77fe6a1d67e4fc1863e3b860ca0815b">
        </a>

        <div class="comment-main">
            <div class="form-item">
                <div class="form-field">
                    <div class="fake-textarea" data-droppable="">点击发表评论</div>
                    <textarea id="txt-new-comment" tabindex="1" autofocus="" data-validate="custom"
                              data-autosave="new-comment-content" data-mention-group="c96929b616cd4100a6225ea090264459"
                              data-mention-type="project" class="comment-content hide"
                              name="comment_content"></textarea>
                </div>
            </div>

            <div class="form-item notify hide">
                <div class="notify-title">
                    <div class="notify-title-title">发送通知给：</div>
                    <div class="notify-title-summary hide">
                        <span class="receiver"></span>
                        <span class="change-notify">
                            [ <a href="javascript:;" class="link-change-notify">更改</a> ]
                        </span>
                    </div>
                    <div class="notify-title-select">
                        <span unselectable="on" data-subgroup="-1" class="group-select">所有人</span>

                            <span data-subgroup="35629" unselectable="on" class="group-select">
                                美术
                            </span>
                    </div>
                </div>

                <div class="form-field">
                    <ul class="member-list">

                        <li>
                            <label>
                                <input type="checkbox" tabindex="-1" value="2e5c91f6db0e4b9eab25e406940e211d"
                                       data-subgroup="35629">
                                <span title="邓健强小小号">邓健强小小号</span>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" tabindex="-1" value="5ee2cb7e11e84bc2a5f8a627a14b46fe"
                                       data-subgroup="0">
                                <span title="方片周">方片周</span>
                            </label>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="hide form-buttons">
                <button tabindex="1" type="submit" class="btn btn-primary btn-create-comment"
                        data-disable-with="正在发送...">发表评论
                </button>
                <button tabindex="2" type="button" class="btn btn-x btn-cancel-create-comment">取消</button>
            </div>
        </div>
    </form>
</div>

<div class="zoom-meeting">
    <p>
        不想打字？试试<a href="javascript:;" data-url="/teams/93d89386a21248be83711dd878ef33cd/zoom/create"
                  id="link-create-zoom">召开视频会议</a>。
    </p>
</div>

</div>
</div>
</div>