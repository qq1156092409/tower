<?php
namespace app\controllers;

use app\models\form\Test2Form;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;

class Test2Controller extends Controller{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'roles' => ['@'],],
                ],
            ]
        ];
    }
    public function actionCreate(){
        $model=new Test2Form(["scenario"=>Test2Form::CREATE]);
        if(\Yii::$app->request->isPost){
            $ret=["result"=>false];
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $model->load(\Yii::$app->request->post(), "Test2");
            if($model->create()){
                $ret["result"]=true;
            }
            return $ret;
        }
        return $this->render("create",[
            "model"=>$model,
        ]);
    }
    public function actionEdit($id){
        $model=new Test2Form([
            "scenario"=>Test2Form::EDIT,
            "id"=>$id,
        ]);
        if(\Yii::$app->request->isPost){
            $ret=["result"=>false,"id"=>$id];
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $model->load(\Yii::$app->request->post(), "Test2");
            if($model->edit()){
                $ret["result"]=true;
            }
            return $ret;
        }
        $model->loadValue();
        return $this->render("edit",[
            "model"=>$model,
        ]);
    }
    public function actionDestroy($id){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new Test2Form(["scenario"=>Test2Form::DESTROY]);
        $model->id = $id;
        if($model->destroy()){
            $ret["result"]=true;
        }
        return $ret;
    }
}