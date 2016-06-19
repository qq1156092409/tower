<?php
use yii\helpers\Url;
use app\models\Project;
/**
 * @var $project Project
 */
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page  page-root simple-pjax page-behind">
        <a class="link-page-behind" data-stack="" href="<?=Url::to(["/project","id"=>$project->id])?>"><?=$project->name?></a>
    </div>

    <div class="page page-1 simple-pjax">
        <div class="page-inner" data-page-name="数据统计" id="page-project-stats">

            <div class="section section-stats">
                <h3>统计</h3>

                <ul class="summary">
                    <li>
                        <span class="name">待处理任务</span>
                        <span class="count">5</span>
                    </li>
                    <li>
                        <span class="name">延误任务</span>
                        <span class="count delay">1</span>
                    </li>
                    <li>
                        <span class="name">总任务数</span>
                        <span class="count">5</span>
                    </li>
                </ul>
            </div>

            <div class="section section-progress" data-url="/projects/c96929b616cd4100a6225ea090264459">
                <h3>
                    进展

                    <span class="tips-helper">
                        <span class="mark">?</span>
                        <span class="tips-pop">
                            任务清单的完成进度（实时统计）<br>
                        </span>
                    </span>
                </h3>

                <table class="progress-table">
                    <tbody>
                    <tr data-url="/projects/c96929b616cd4100a6225ea090264459/lists/f5a1e598cbe64918b700bdef5f3c1c9c/show">
                        <td class="todolist text-overflow">
                            <span class="name">清单3</span>
                        </td>
                        <td class="progress">
                            <div class="bar">
                                <div class="inner-bar" style="width: NaN%"></div>
                            </div>
                            <span class="count">0/0</span>
                        </td>
                    </tr>
                    <tr data-url="/projects/c96929b616cd4100a6225ea090264459/lists/a33fbed9eedc410a9d1ac7ab4276d5fe/show">
                        <td class="todolist text-overflow">
                            <span class="name">清单2</span>
                        </td>
                        <td class="progress">
                            <div class="bar">
                                <div class="inner-bar" style="width: 0%"></div>
                            </div>
                            <span class="count">0/1</span>
                        </td>
                    </tr>
                    <tr data-url="/projects/c96929b616cd4100a6225ea090264459/lists/507edd4262334105a07823c203cc5992/show">
                        <td class="todolist text-overflow">
                            <span class="name">清单1</span>
                        </td>
                        <td class="progress">
                            <div class="bar">
                                <div class="inner-bar" style="width: 0%"></div>
                            </div>
                            <span class="count">0/2</span>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="init init-stats-progress hide">
                    <p class="title">
                        该项目所有任务清单都已完成，<a href="/projects/c96929b616cd4100a6225ea090264459/lists/completed"
                                         data-stack="true">点此查看</a>
                    </p>
                </div>

            </div>

            <div class="section section-contribution">
                <h3>贡献</h3>
                <p class="desc">
                    截至目前，共有 <span class="members count">1</span> 位成员对项目做出了贡献<span class="todos">，共完成 <span class="count"></span> 条任务</span><span class="messages" style="display: inline;">，产生 <span class="count">6</span> 条讨论</span><span class="docs" style="display: inline;">，创建 <span class="count">1</span> 篇文档</span><span class="files" style="display: inline;">，上传 <span class="count">1</span> 个文件</span>。
                </p>

                <table class="contribution-table">
                    <tbody><tr>
                        <td class="member">
                            <img src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37" class="avatar">
                            <span class="name text-overflow">方片周</span>
                        </td>
                        <td class="contribution">
                            <div class="bar">
                                <span class="count">1</span>
                                <div class="inner-bar" data-tooltip="方片周 完成了 1 条任务" data-position="top" style="width: 100%">
                                </div>
                            </div>
                        </td>
                    </tr></tbody>
                </table>

                <div class="init init-stats-contribution hide">
                    <p class="title">hmmm... 项目还没有任何进展，快去干活吧！</p>
                </div>
            </div>

            <script type="text/html" id="tpl-progress-todolist">
                <tr data-url="{{ url }}">
                    <td class="todolist text-overflow">
                        <span class="name">{{ name }}</span>
                    </td>
                    <td class="progress">
                        <div class="bar">
                            <div class="inner-bar" style="width: {{ progressWidth }}%"></div>
                        </div>
                        <span class="count">{{ count }}</span>
                    </td>
                </tr>
            </script>

            <script type="text/html" id="tpl-contribution-member">
                <tr>
                    <td class="member">
                        <img src="{{ avatar }}" class="avatar"/>
                        <span class="name text-overflow">{{ name }}</span>
                    </td>
                    <td class="contribution">
                        <div class="bar">
                            <span class="count">{{ count }}</span>

                            <div class="inner-bar" data-tooltip="{{ name }} 完成了 {{ count }} 条任务" data-position="top"
                                 style="width: {{ contributionWidth }}%">
                            </div>
                        </div>
                    </td>
                </tr>
            </script>

            <input type="hidden" id="stats-data"
                   value="{&quot;members_count&quot;:3,&quot;documents_count&quot;:1,&quot;topics_count&quot;:6,&quot;attachments_count&quot;:1,&quot;progress&quot;:0,&quot;todolist&quot;:{&quot;f5a1e598cbe64918b700bdef5f3c1c9c&quot;:{&quot;name&quot;:&quot;清单3&quot;,&quot;total_todos_count&quot;:0,&quot;completed_todos_count&quot;:0,&quot;progress&quot;:0,&quot;position&quot;:3},&quot;a33fbed9eedc410a9d1ac7ab4276d5fe&quot;:{&quot;name&quot;:&quot;清单2&quot;,&quot;total_todos_count&quot;:1,&quot;completed_todos_count&quot;:0,&quot;progress&quot;:0,&quot;position&quot;:2},&quot;507edd4262334105a07823c203cc5992&quot;:{&quot;name&quot;:&quot;清单1&quot;,&quot;total_todos_count&quot;:2,&quot;completed_todos_count&quot;:0,&quot;progress&quot;:0,&quot;position&quot;:1}},&quot;members&quot;:{}}">
        </div>
    </div>
</div>