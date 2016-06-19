<?php
use app\models\Team;
use yii\helpers\Url;
use yii\web\View;
use app\components\JsManager;
/**
 * @var $team Team
 * @var $this View
 */
$request=Yii::$app->request;
JsManager::instance()->registers([
    "js/models/yii.team.js"
]);
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax">
        <div class="page-inner" id="page-team-settings" data-page-name="方片集团 的团队账户">
            <div class="team-name">
                <h3 id="team-<?=$team->id?>">
                    <span class="name team-name"><?=$team->name?></span>
                    <a id="btn-team-edit" href="javascript:;" class="edit">修改团队名称</a>
                </h3>
                <form class="form form-team-edit" action="<?=Url::to(["/team/edit","id"=>$team->id])?>" method="post">
                    <input type="hidden" name="<?=$request->csrfParam?>" value="<?=$request->csrfToken?>" />
                    <input type="text" class="no-border" name="Team[name]" value="<?=$team->name?>" placeholder="请填写团队名称">
                    <button type="submit" class="btn btn-primary btn-save" data-disable-with="正在保存...">保存</button>
                    <button type="button" class="btn btn-x btn-cancel">取消</button>
                </form>
                <p class="desc">团队创建于 2015年05月08日</p>
            </div>
            <div class="section account-section">
                <div class="account-summary">
                    <table cellspacing="0">
                        <tbody>
                        <tr>
                            <td class="info-field">项目数量：</td>
                            <td class="info-value">
                                <strong>6</strong>
                                <a href="/teams/93d89386a21248be83711dd878ef33cd/projects_info" class="tiny-link"
                                   data-stack="true">查看</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-field">当前方案：</td>
                            <td class="info-value">
                                Tower 免费版
                                <a href="/teams/93d89386a21248be83711dd878ef33cd/upgrade" class="tiny-link"
                                   data-stack="true">Pro 版特权</a>
                            </td>
                        </tr>


                        <tr>
                            <td class="info-field">账户余额：</td>
                            <td class="info-value">
                                <em class="yen-price"><span class="yen">¥</span><span class="price">0</span></em>
                                <a href="/teams/93d89386a21248be83711dd878ef33cd/gift_charge" class="tiny-link"
                                   data-stack="true">使用充值卡</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <p class="payment-actions">
                    <a href="/teams/93d89386a21248be83711dd878ef33cd/upgrade" class="btn btn-primary btn-charge"
                       data-stack-root="true" data-stack="true">升级至 Pro 版</a>

                    <a href="/teams/93d89386a21248be83711dd878ef33cd/pay_history" class="btn-receipt-log"
                       data-stack="true">扣费记录和发票申请</a>
                </p>
            </div>

            <div class="section who-pay">
                <h4>团队账户授权</h4>

                <div class="who-pay">
                    <p class="payer-list">
                        <strong class="info-field">当前授权成员：</strong>
                        <span class="info-value" title="方片周">方片周</span>
                    </p>

                    <p>
                        <a href="/teams/93d89386a21248be83711dd878ef33cd/assistant_owners" class="btn btn-mini"
                           data-stack="true">设置授权成员</a>
                    </p>
                </div>
            </div>


            <div class="section">
                <h4>移交团队账户？</h4>

                <p class="desc">只有超级管理员才可以管理团队账户，你可以把超级管理员身份移交给其他成员，移交之后你将不能再访问团队账户。</p>

                <p>
                </p>

                <form class="form form-trans-account" data-cf="移交后，你将不能再访问团队账户页面，但仍有其它管理权限。你确定要移交么？"
                      action="/members/5ee2cb7e11e84bc2a5f8a627a14b46fe/trans_account" method="post" data-remote="true">
                    <select name="tuid" id="assign-member">
                        <option value="974ae2692d83457aa0c6068600674b43">邓健强</option>
                        <option value="2e5c91f6db0e4b9eab25e406940e211d">邓健强小小号</option>
                    </select>
                    <button type="submit">移交给TA</button>
                </form>
                <p></p>
            </div>
            <div class="section rm-team">
                <h4>删除团队</h4>
                <p class="desc">如果你和你的团队成员，从今往后都不再需要访问该团队的信息，可以删除团队账户。</p>
                <button type="button" class="link-delete btn btn-mini" id="btn-del-team">了解风险，删除当前团队</button>
            </div>
        </div>
    </div>
</div>
