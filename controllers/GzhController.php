<?php

namespace app\controllers;
use app\models\form\GzhForm;
use yii\web\Controller;

class GzhController extends Controller{
    public $enableCsrfValidation=false;
    public function actionIndex(){
        $model=new GzhForm();
        if(\Yii::$app->request->isPost){
            $model->scenario=GzhForm::ANSWER;
            $model->load(\Yii::$app->request->post(),"");
            if($model->answer()){
                echo $model->getRet();
            }else{
                foreach($model->errors as $k=>$v){
                    echo $v[0];break;
                }
            }
            \Yii::$app->end();
        }
        $model->scenario=GzhForm::VALID;
        $model->load(\Yii::$app->request->getQueryParams(),"");
        if($model->valid()){
            echo $model->getRet();
        }
    }
}