<?php

namespace app\controllers;

use app\models\form\UserForm;
use app\models\Ip;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\helpers\Security;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\UserLog;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class SiteController extends Controller{
    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->renderPartial("index");
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionLaunchpad(){
        if(Yii::$app->user->identity->lastUserTeam){
            return $this->redirect(["team/projects", "id" => Yii::$app->user->identity->lastUserTeam->teamID]);
        }else{
            return $this->redirect(["team/list"]);
        }
    }
    public function actionLogin(){
        if(!Yii::$app->user->isGuest){
            $this->redirect(["site/launchpad"]);
        }
        $model=new UserForm(["scenario"=>UserForm::LOGIN]);
        if(Yii::$app->request->isPost){
            Yii::$app->response->format=Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post(),"User");
            $ret=["result"=>false,"name"=>$model->name];
            if($model->login()){
                $ret["result"]=true;
                $ret["jumpUrl"] = Yii::$app->user->returnUrl ?: Url::to(["launchpad"]);
            }else{
                $ret["errors"]=$model->errors;
            }
            return $ret;
        }
        return $this->renderPartial("login",[
            "model"=>$model,
        ]);
    }
    public function actionLogout(){
        if(!Yii::$app->user->isGuest){
            Yii::$app->user->logout();
        }
        return $this->goHome();
    }
}
