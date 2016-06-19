<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\UserProject;
use app\models\Project;
use app\models\UserTeam;
use \app\models\Subgroup;
/**
 * @var $members UserProject[]
 * @var $project Project
 * @var $userTeams UserTeam[]
 * @var $subgroups Subgroup[]
 * @var $notSelectedGroupIDs int[]
 */
?>
<div class="container workspace simple-stack simple-stack-transition">
<div class="page page-root simple-pjax page-behind">
    <a class="link-page-behind" data-stack="" href="<?=$project->getViewUrl()?>">测试项目</a>
</div>
<div class="page page-1 simple-pjax">
<div class="page-inner" data-project-creator="5ee2cb7e11e84bc2a5f8a627a14b46fe" data-page-name="项目成员"
     id="page-project-members">

<h3>
    <span>项目成员</span>
    <a href="javascript:;" class="link-edit-members" data-visible-to="admin">编辑</a>
</h3>

<a href="<?=Url::to(["/project/quit","id"=>$project->id])?>" class="link-delete btn-project-quit" data-remote="true" data-method="delete"
   data-cf="确定要退出这个项目吗？">退出项目</a>

<div class="project-members">
    <ul>
        <?php foreach($members as $userID=>$member){
            $userTeam=$userID==Yii::$app->user->id?$member->userTeam:$userTeams[$userID];
            echo $this->render("/commons/_member2",["model"=>$userTeam]);
        } ?>
    </ul>
</div>
<?php $form=ActiveForm::begin(["id"=>"form-project-members","options"=>["class"=>"form-project-members form form-invite hide"]])?>
    <div class="setting-section">
        <h4> 选择项目成员 </h4>
        <p class="desc">
            管理员可以邀请和移除项目成员，只有被邀请的团队成员才能访问该项目的信息。点击这里查看
            <a href="https://tower.im/help/faq/8/65/" target="_blank" rel="nofollow">如何设置成员权限</a>。
        </p>
        <div class="manage-members-tabs">
            <div class="tabs-header">
                <a href="javascript:;" class="tab-header active" data-tab="team">团队成员 (<?=count($userTeams)?>)</a>
                <a href="javascript:;" class="tab-header" data-tab="email">邮件邀请</a>
                <a href="javascript:;" class="tab-header" data-tab="wechat">微信邀请</a>
            </div>
            <div class="tab active" data-tab="team" style="display: block;">
                <div class="manage-members">
                    <div class="add-member">
                        <div class="simple-select require-select">
                            <input type="text" class="select-result" autocomplete="off" placeholder="点击添加成员">
                                        <span class="link-expand" title="所有选项">
                                            <i class="icon-caret-down"><span>▾</span></i>
                                        </span>
                                        <span class="link-clear" title="清除选择">
                                            <i class="icon-delete"><span>✕</span></i>
                                        </span>
                            <div class="select-list" style="display: none;">
                                <?php foreach($userTeams as $userTeam){ ?>
                                    <div class="select-item" data-id="<?=$userTeam->id?>" data-subgroup="<?=$userTeam->subgroupID?>">
                                        <a href="javascript:;" class="label">
                                            <img src="https://avatar.tower.im/e3c6a3778cd64375b23ee6bfef70473c" class="avatar">
                                            <span><?=$userTeam->user->activeName?></span>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <select id="select-add-member" style="display: none;">
                            <option value="974ae2692d83457aa0c6068600674b43"
                                    data-guid="974ae2692d83457aa0c6068600674b43"
                                    data-key="邓健强 dengjianqiang djq" data-subgroup="35628"
                                    data-gavatar="https://avatar.tower.im/e3c6a3778cd64375b23ee6bfef70473c">
                                邓健强
                            </option>
                            <option value="2e5c91f6db0e4b9eab25e406940e211d"
                                    data-guid="2e5c91f6db0e4b9eab25e406940e211d"
                                    data-key="邓健强小小号 dengjianqiangxiaoxiaohao djqxxh" data-subgroup="35629"
                                    data-gavatar="<?=Url::to("public/default_avatars/winter.jpg")?>">
                                邓健强小小号
                            </option>
                        </select>

                        <div class="group-select">
                            <span id="btn-subgroup-all" class="all <?=$notSelectedGroupIDs?"":"selected"?>" data-subgroup="-1" unselectable="on">所有人</span>
                            <?php foreach($subgroups as $subgroup){ ?>
                                <span id="btn-subgroup-<?=$subgroup->id?>" class="<?=in_array($subgroup->id,$notSelectedGroupIDs)?"":"selected"?>" data-subgroup="<?=$subgroup->id?>" unselectable="on"><?=$subgroup->name?></span>
                            <?php } ?>
                        </div>
                    </div>

                    <ul class="members">
                        <?php foreach($userTeams as $userID=>$userTeam){
                            echo $this->render("/commons/_member",["model"=>$userTeam,"selected"=>$members[$userID]?true:false]);
                        } ?>
                    </ul>
                </div>
            </div>

            <div class="tab" data-tab="email" style="display: none;">
                <div class="form-item">
                    <div class="form-field">
                        <div class="invite-item">
                            <div class="invite-field">
                                <input type="email" class="invite-email no-border" placeholder="请输入新成员的邮箱">
                                <div class="invite-role-field">
                                    <select class="invite-role" id="choose-role" tabindex="-1">
                                        <option value="0" selected="">成员</option>
                                        <option value="1">管理员</option>
                                        <option value="3">访客</option>
                                    </select>
                                </div>

                                <div class="invite-subgroup-field">
                                    <select class="invite-subgroup" id="choose-subgroup"
                                            tabindex="-1">
                                        <option value="0">小组</option>
                                        <option disabled="">-----</option>
                                        <option value="35628">策划</option>
                                        <option value="35629">美术</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="invite-item">
                            <div class="invite-field">
                                <input type="email" class="invite-email no-border" placeholder="请输入新成员的邮箱">

                                <div class="invite-role-field">
                                    <select class="invite-role" id="choose-role" tabindex="-1">
                                        <option value="0" selected="">成员</option>
                                        <option value="1">管理员</option>
                                        <option value="3">访客</option>
                                    </select>
                                </div>

                                <div class="invite-subgroup-field">
                                    <select class="invite-subgroup" id="choose-subgroup"
                                            tabindex="-1">
                                        <option value="0">小组</option>
                                        <option disabled="">-----</option>
                                        <option value="35628">策划</option>
                                        <option value="35629">美术</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="invite-item">
                            <div class="invite-field">
                                <input type="email" class="invite-email no-border" placeholder="请输入新成员的邮箱">

                                <div class="invite-role-field">
                                    <select class="invite-role" id="choose-role" tabindex="-1">
                                        <option value="0" selected="">成员</option>
                                        <option value="1">管理员</option>
                                        <option value="3">访客</option>
                                    </select>
                                </div>

                                <div class="invite-subgroup-field">
                                    <select class="invite-subgroup" id="choose-subgroup"
                                            tabindex="-1">
                                        <option value="0">小组</option>
                                        <option disabled="">-----</option>
                                        <option value="35628">策划</option>
                                        <option value="35629">美术</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="add-invite-wrap"><a href="javascript:;" id="add-invite-item">再加一个</a></p>
                </div>
            </div>

            <div class="tab" data-tab="wechat" style="display: none;">
                <div class="form-item form-wechat-item">
                    <div class="form-field">
                        <div class="wechat-invite">
                            <div class="qrcode-wrap" data-url="/wechat/qrcode?type=8">
                                <img class="qrcode" alt="微信双保险二维码" title="扫描这个二维码获取微信邀请函" src="<?=Url::to("public/ticket.jpg")?>">
                            </div>
                            <div class="wechat-desc">
                                <h5>扫码邀请</h5>

                                <p>用微信扫描二维码获取邀请函，<br>
                                    转发给微信好友，即可邀请他们加入你的项目。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="form-buttons">
        <button type="submit" id="btn-save-members" class="btn btn-primary" data-disable-with="正在保存..."
                data-success-text="保存成功" data-project-guid="c96929b616cd4100a6225ea090264459">保存项目成员
        </button>
    </div>
<?php $form->end()?>
</div>
</div>
</div>