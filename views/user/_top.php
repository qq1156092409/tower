<?php
use app\models\UserLog;
use yii\helpers\Url;
/**
 * @var $teamID int
 * @var $userLog UserLog
 * @var $flag int
 */
$flag>0 or $flag=1;
?>
<div class="member-info">
    <img class="avatar" alt="邓健强" src="public/b77fe6a1d67e4fc1863e3b860ca0815b">

    <div class="info">
        <h2>邓健强</h2>

        <p><a class="email" href="mailto:1156092409@qq.com" target="_blank">1156092409@qq.com</a></p>

        <p class="member-comment">
            <span class="member-comment-content" data-comment="" title="点击修改成员备注">添加成员备注</span>
            <i class="fa fa-pencil-square-o member-comment-easyedit"></i>
        </p>

        <form class="form hide form-member-comment"
              action="https://tower.im/members/c24e8e36ccaf43b787229ff595efc41d/update_comment" method="post"
              data-remote="" novalidate="">
            <input type="text" name="member_comment[content]" class="no-border" placeholder="添加成员备注"
                   data-validate="length:0,128" data-validate-msg="成员备注最长128个字符">
            <button type="submit" class="btn btn-mini" data-disable-with="正在保存...">保存</button>
            <button type="button" class="btn btn-x btn-cancel">取消</button>
        </form>
    </div>
    <div class="member-control">
    </div>
</div>

<div class="member-nav">
    <ul>
        <li class="<?=$flag==1?"active":""?>">
            <a href="<?=Url::to(["user/tasks","teamID"=>$teamID])?>" data-stack-replace="true"
               data-stack="true">任务</a>
        </li>
        <li class="<?=$flag==2?"active":""?>">
            <a href="<?=Url::to(["user/collects","teamID"=>$teamID])?>" data-stack-replace="true"
               data-stack="true">收藏</a>
        </li>
        <li class="<?=$flag==3?"active":""?>">
            <a href="<?=Url::to(["user/events","teamID"=>$teamID])?>" data-stack-root="true"
               data-stack="true">日程</a>
        </li>
        <li class="<?=$flag==4?"active":""?>">
            <a href="javascript:void(0)">周报</a>
        </li>
        <li class="<?=$flag==5?"active":""?>">
            <a href="<?=Url::to(["user/email","teamID"=>$teamID])?>" data-stack-replace="true"
               data-stack="true">邮件</a>
        </li>
        <li class="member-nav-signin-logs">
            <a href="<?=Url::to(["user/logins"])?>" class="signin-logs"
               title="查看详细">
                上次登录: <span class="count-down auto-fuzzy-time" data-time="<?=strtotime($userLog->create)*1000?>"><?=$userLog->fuzzyCreate?></span>
            </a>
        </li>
    </ul>
</div>