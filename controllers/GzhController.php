<?php

namespace app\controllers;
use app\models\form\GzhForm;
use app\models\form\GzhValidForm;
use yii\web\Controller;

class GzhController extends Controller{
    public $enableCsrfValidation=false;
    public function actionIndex($echostr=null){
        if(!$echostr){
            $model=new GzhForm();
            $model->receive();
            echo $model->response();
            \Yii::$app->end();
        }
        $model=new GzhValidForm();
        $model->load(\Yii::$app->request->getQueryParams(),"");
        echo $model->response();
    }
}