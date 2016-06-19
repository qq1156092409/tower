<?php
namespace app\controllers;

use app\models\form\TestForm;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;

class TestController extends Controller{
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
        $model=new TestForm(["scenario"=>TestForm::CREATE]);
        if(\Yii::$app->request->isPost){
            $ret=["result"=>false,"type"=>"test-create"];
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $model->load(\Yii::$app->request->post(), "Test");
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
        $model=new TestForm([
            "scenario"=>TestForm::EDIT,
            "id"=>$id,
        ]);
        if(\Yii::$app->request->isPost){
            $ret=["result"=>false,"id"=>$id];
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $model->load(\Yii::$app->request->post(), "Test");
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
        $model = new TestForm(["scenario"=>TestForm::DESTROY]);
        $model->id = $id;
        if($model->destroy()){
            $ret["result"]=true;
        }
        return $ret;
    }
    public function actionToggle($id){

    }
}