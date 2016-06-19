<?php

namespace app\controllers;
use app\models\form\IpForm;
use yii\web\Controller;
use yii\web\Response;

class IpController extends Controller{
    public function actionFix($id){
        $model=new IpForm(["scenario"=>IpForm::FIX]);
        $model->id=$id;
        $ret=["result"=>false,"id"=>$id];
        if($model->fix()){
            $ret["result"]=true;
        }else{
            $ret["errors"]=$model->errors;
        }
        \Yii::$app->response->format=Response::FORMAT_JSON;
        return $ret;
    }
}