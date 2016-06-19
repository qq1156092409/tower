<?php
namespace app\controllers;

use app\models\form\ItemForm;
use yii\web\Controller;
use app\models\Item;
use yii\web\Response;

class ItemController extends Controller{
    public function actionIndex($id){
        $item=Item::findOne($id);
        $tasks=$item->commonTasks;
        return $this->render("item",[
            "item"=>$item,
            "tasks"=>$tasks,
            "teamID"=>$item->project->teamID,
        ]);
    }
    public function actionCreate($projectID){
        $ret = ["result" => false];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new ItemForm(["scenario"=>ItemForm::CREATE]);
        $model->projectID=$projectID;
        $model->load(\Yii::$app->request->post(),"Item");
        if($model->create()){
            $ret['result']=true;
            $ret["page"]=$this->renderPartial("/commons/_item",["model"=>$model->getItem()]);
        }else{
            $ret["errors"]=$model->errors;
        }
        return $ret;
    }
    public function actionDisable($id){
        $ret = ["result" => false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new ItemForm(["scenario"=>ItemForm::DISABLE]);
        $model->id=$id;
        if($model->disable()){
            $ret['result']=true;
        }
        return $ret;
    }
    public function actionEnable($id){
        $ret = ["result" => false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new ItemForm(["scenario"=>ItemForm::ENABLE]);
        $model->id=$id;
        if($model->enable()){
            $ret['result']=true;
        }
        return $ret;
    }
    public function actionEdit($id){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new ItemForm();
        $model->scenario=ItemForm::EDIT;
        $model->id=$id;
        $model->load(\Yii::$app->request->post(),"Item");
        if($model->edit()){
            $item=$model->getItem();
            $ret["result"]=true;
            $ret["name"]=$item->name;
            $ret["description"]=$item->description;
        }
        return $ret;
    }
    public function actionToggleArchive($id){
        $ret=["id"=>$id,"result"=>false];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new ItemForm(["scenario"=>ItemForm::TOGGLE_ARCHIVE]);
        $model->id=$id;
        if($model->toggleArchive()){
            $ret["result"]=true;
            $ret["archive"]=$model->getItem()->archive;
        }else{
            $ret["errors"]=$model->errors;
        }
        return $ret;
    }
    public function actionArchive($id){
        $ret=["id"=>$id,"result"=>false];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new ItemForm(["scenario"=>ItemForm::ARCHIVE]);
        $model->id=$id;
        if($model->archive()){
            $ret["result"]=true;
        }else{
            $ret["errors"]=$model->errors;
        }
        return $ret;
    }
    public function actionUnArchive($id){
        $ret=["id"=>$id,"result"=>false];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new ItemForm(["scenario"=>ItemForm::UN_ARCHIVE]);
        $model->id=$id;
        if($model->unArchive()){
            $ret["result"]=true;
        }else{
            $ret["errors"]=$model->errors;
        }
        return $ret;
    }
} 