<?php
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use app\components\JsManager;
/**
 * @var $this View
 */
JsManager::instance()->registers(["js/models/yii.user.js",]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>登录 - Tower</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="baidu-site-verification" content="qLDoHdGnb64RHlkm">
    <meta name="alexaVerifyID" content="SIgQikd9LazsFz9M1vPBaQyC4Gw">
    <link rel="shortcut icon" href="public/favicon.ico" type="image/x-icon">
    <link rel="icon" href="public/favicon.ico" sizes="32x32">
    <link rel="icon" href="public/favicon.ico" sizes="64x64">
    <link rel="icon" href="public/favicon.ico" sizes="128x128">
    <link rel="apple-touch-icon-precomposed" href="https://tower.im/assets/mobile/icon/icon@512-c8090c0961c63b1549cd19d714c6b69e.png">
    <meta content="authenticity_token" name="csrf-param">
    <meta content="70QA0kMWFE/YdH9mNwJCyMa9GSLLEkz5XU9re+SgKpY=" name="csrf-token">
    <link href="public/application-404f5efaeb2aead3434d85ff01eddcef.css" media="all" rel="stylesheet" type="text/css">
    <script src="<?=Url::to("js/jquery-2.1.1.js")?>"></script>
    <?php $this->head() ?>
</head>
<body class="win">
<?php $this->beginBody() ?>
<div class="wrapper">
    <div class="page" id="page-signin">
        <div class="sign-page">
            <div class="hd">
                <h1 class="logo">
                    <a href="https://tower.im/">tower.im</a>
                </h1>
            </div>
            <div class="bd">
                <?php $form = ActiveForm::begin([
                    "id"=>"user-login-form",
                    "options"=>["class"=>'form form-user-login',],
                ]); ?>
                    <div class="signin-title">
                        <a href="javascript:;" class="link-normal-signin">账户登录</a>
                        <span>或</span>
                        <a href="javascript:;" class="link-wechat-signin"><i class="twr twr-weixin"></i>微信登录</a>
                    </div>
                    <div class="normal-signin sigin-section">
                        <div class="signin-arrow">
                            <i class="arrow arrow-shadow-1"></i>
                            <i class="arrow arrow-shadow-0"></i>
                            <i class="arrow arrow-border"></i>
                            <i class="arrow arrow-basic"></i>
                        </div>

                        <div class="form-item">
                            <div class="form-field">
                                <input type="text" name="User[name]" id="name" placeholder="用户名" autofocus="">
                            </div>
                        </div>

                        <div class="form-item">
                            <div class="form-field">
                                <input type="password" name="User[password]" placeholder="密码"
                                       data-validate="required;length:6" data-validate-msg="请填写你的登录密码">
                            </div>
                            <div class="desc">
                                <p class="left">
                                    <label for="cb-remember"><input type="checkbox" name="remember_me" id="cb-remember"
                                                                    checked=""> 下次自动登录</label>
                                </p>

                                <p class="right">
                                    <span class="forgot-pw"><a href="https://tower.im/users/forgot_password">忘记密码了？</a></span>
                                </p>
                            </div>
                        </div>

                        <div class="form-item form-buttons">
                            <button type="submit" id="btn-signin" class="btn btn-primary btn-submit"
                                    data-disable-with="正在登录..." data-goto="/launchpad/">登录
                            </button>
                            <div class="desc">
                                没有账户？<a href="https://tower.im/users/sign_up">立即注册 →</a>
                            </div>
                        </div>
                    </div>

                    <div class="wechat-signin sigin-section">
                        <div class="signin-arrow">
                            <i class="arrow arrow-shadow-1"></i>
                            <i class="arrow arrow-shadow-0"></i>
                            <i class="arrow arrow-border"></i>
                            <i class="arrow arrow-basic"></i>
                        </div>

                        <div id="wechat-login">
                            <iframe src="./site_login_files/qrconnect.htm" frameborder="0" scrolling="no" width="300px"
                                    height="400px" style="height: 380px;"></iframe>
                        </div>
                    </div>
                <?php $form->end()?>
            </div>
        </div>
        <div class="footer">
            © <a href="http://mycolorway.com/" target="_blank">彩程设计</a>
        </div>

    </div>

</div>

<input type="hidden" id="d18n-enabled" value="false">
<input type="hidden" id="server-time" value="2015-07-04 14:29:48">
<textarea tabindex="-1" style="position: absolute; top: -999px; left: 0px; right: auto; bottom: auto; border: 0px; box-sizing: content-box; word-wrap: break-word; overflow: hidden; height: 0px !important; min-height: 0px !important;"></textarea>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>