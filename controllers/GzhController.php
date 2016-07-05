<?php

namespace app\controllers;
use app\models\form\GzhForm;
use app\models\Test2;
use yii\helpers\FileHelper;
use yii\web\Controller;

class GzhController extends Controller{
    public function actionIndex(){
        //监听请求
        $test2=new Test2();
        $test2->name=json_encode(\Yii::$app->request->getQueryParams());
        $test2->save();

        $model=new GzhForm();
        $model->load(\Yii::$app->request->getQueryParams());
        echo $model->echostr;
//        if($model->valid()){
//            echo $model->echostr;
//        }
    }
}