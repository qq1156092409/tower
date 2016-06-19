<?php
use \yii\helpers\ArrayHelper;
use app\models\Project;
use yii\web\View;
use app\models\UserTeam;
use app\models\Subgroup;
use yii\widgets\ActiveForm;
use \app\models\Team;
use yii\helpers\Url;
/**
 * @var $this View
 * @var $team Team
 * @var $userTeams UserTeam[]
 * @var $subgroups Subgroup[]
 */
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax page-behind">
        <a class="link-page-behind" data-stack="" href="<?=Url::to(["/team/projects","id"=>$team->id])?>">所有项目</a>
    </div>
    <div class="page page-1 simple-pjax">
        <div class="page-inner" id="page-new-project" data-page-name="创建新项目">
            <h3>创建新项目</h3>
            <?php $form = ActiveForm::begin(["id"=>"form-project-create","options"=>["class"=>"form form-invite form-project-create"]]) ?>
                <div class="form-item">
                    <div class="form-field">
                        <input type="text" name="Project[name]" id="project-name" placeholder="项目名称" autofocus=""
                               data-validate="required;length:1,255" data-validate-msg="请填写项目名称;项目名称最长255个字符">
                    </div>
                </div>

                <div class="form-item">
                    <div class="form-field">
                        <textarea name="Project[description]" id="project-desc" placeholder="简单描述项目，便于其他人理解（选填）"
                                  data-validate="length:1,1000" data-validate-msg="项目描述最长1000个字符"></textarea>
                    </div>
                </div>

                <div class="form-item allow-visitor-lock">
                    <div class="form-field">
                        <label>
                            <input type="checkbox" name="guest_lockable">
                            允许对访客隐藏敏感内容
                        </label>
                    </div>
                </div>

                <div class="setting-section project-type-section">
                    <h4>选择项目类型</h4>
                    <input class="input-project-type" type="radio" id="project-type-standard" name="Project[type]" value="<?=Project::STANDARD?>" checked="">
                    <label class="project-type" for="project-type-standard">
                        <i class="twr twr-standard-project"></i>
                        <div class="info">
                            <h5>标准项目</h5>
                            <p>更好地组织、细分和管理任务，适用于一般项目管理</p>
                        </div>
                    </label>

                    <input type="radio" id="project-type-agile" name="Project[type]" value="<?=Project::BOARD?>">
                    <label class="project-type" for="project-type-agile">
                        <i class="twr twr-agile-project"></i>

                        <div class="info">
                            <h5>敏捷项目（看板）</h5>
                            <p>擅长处理流程化任务，适用于产品研发、用户支持等场景</p>
                        </div>
                    </label>
                </div>

                <div class="setting-section">
                    <h4>
                        选择项目成员
                    </h4>

                    <p class="desc">
                        管理员可以邀请和移除项目成员，只有被邀请的团队成员才能访问该项目的信息。点击这里查看<a href="https://tower.im/help/faq/8/65/"
                                                                     target="_blank" rel="nofollow">如何设置成员权限</a>。
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
                                        <span id="btn-subgroup-all" class="all" data-subgroup="-1" unselectable="on">所有人</span>
                                        <?php foreach($subgroups as $subgroup){ ?>
                                        <span id="btn-subgroup-<?=$subgroup->id?>" data-subgroup="<?=$subgroup->id?>" unselectable="on"><?=$subgroup->name?></span>
                                        <?php } ?>
                                    </div>
                                </div>

                                <ul class="members">
                                    <?php foreach($userTeams as $userTeam){
                                    echo $this->render("/commons/_member",["model"=>$userTeam]);
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
                    <button type="submit" class="btn btn-primary" id="btn-create-project" data-disable-with="正在创建..."
                            data-success-text="创建成功">创建项目
                    </button>
                    <a href="javascript:void(0)" class="btn btn-x btn-cancel" onclick="history.back()">取消</a>
                </div>
            <?php $form->end()?>

            <div class="templates-wrap">
                <h5 class="title">或者，从模板创建项目</h5>
                <a href="/projects/da95a7209f6b44189002081263f3cecc" class="template-link" data-stack=""
                   data-stack-root="" data-restore-position="">
                    <i class="twr twr twr-file-text-o"></i>
                    项目模板11
                </a>
            </div>
        </div>
    </div>
</div>