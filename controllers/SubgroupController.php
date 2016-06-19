<?php
namespace app\controllers;

use app\models\form\SubgroupForm;
use yii\web\Controller;
use yii\web\Response;

class SubgroupController extends Controller{
    public function actionCreate($teamID){
        $ret=["result"=>false,"teamID"=>$teamID];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new SubgroupForm([
            "scenario"=>SubgroupForm::CREATE,
            "teamID"=>$teamID,
        ]);
        $model->load(\Yii::$app->request->post(),"Subgroup");
        if($model->create()){
            $subgroup=$model->getSubgroup();
            $ret["result"]=true;
            $ret['page']=$this->renderPartial("/commons/_subgroup",["model"=>$subgroup]);
        }
        return $ret;
    }
    public function actionDestroy($id){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new SubgroupForm([
            "scenario"=>SubgroupForm::DESTROY,
            "id"=>$id,
        ]);
        if($model->destroy()){
            $ret["result"]=true;
        }
        return $ret;
    }
    public function actionEdit($id){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new SubgroupForm([
            "scenario"=>SubgroupForm::EDIT,
            "id"=>$id,
        ]);
        $model->load(\Yii::$app->request->post(),"Subgroup");
        if($model->edit()){
            $subgroup=$model->getSubgroup();
            $ret["result"]=true;
            $ret['name']=$subgroup->name;
        }
        return $ret;
    }
    public function actionSort($id,$prevID=null){
        $ret=["result"=>false,"id"=>$id,"prevID"=>$prevID];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new SubgroupForm([
            "scenario"=>SubgroupForm::SORT,
            "id"=>$id,
            "prevID"=>$prevID,
        ]);
        if($model->sort()){
            $ret["result"]=true;
        }
        return $ret;
    }
}