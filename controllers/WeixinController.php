<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/6/22
 * Time: 21:29
 */

namespace app\controllers;


use yii\base\Security;
use yii\web\Controller;

class WeixinController extends Controller{
    public function actionConnect(){
        $url=http_build_query("https://open.weixin.qq.com/connect/qrconnect", [
            "appid"=>"APPID",
            "redirect_uri"=>"REDIRECT_URI",
            "response_type"=>"code",
            "scope"=>"SCOPE",
            "state"=>"STATE",
            "#"=>"wechat_redirect",
        ]);
        $security=new Security();
        \Yii::$app->session->set("weixin-state",$security->generateRandomString());
        $this->redirect($url);
    }
    public function actionLogin($code,$state){

        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code';
    }
}