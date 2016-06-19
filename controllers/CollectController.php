<?php
namespace app\controllers;

use app\models\Collect;
use app\models\form\CollectForm;
use yii\web\Controller;
use yii\web\Response;

class CollectController extends Controller{
    public function actionToggle($model,$value){
        $formModel=new CollectForm([
            "scenario"=>CollectForm::TOGGLE,
            "model"=>$model,
            "value"=>$value,
        ]);
        $ret=["result"=>false,"model"=>$model,"value"=>$value];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        if($formModel->toggle()){
            $ret["result"]=true;
            $ret['id']=$formModel->getCollect()->id;
            $ret['has']=$formModel->has();
        }else{
            $ret["errors"]=$formModel->errors;
        }
        return $ret;
    }
} 