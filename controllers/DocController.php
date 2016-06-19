<?php
namespace app\controllers;

use app\models\Doc;
use app\models\form\DocForm;
use yii\web\Controller;
use yii\web\Response;

class DocController extends Controller{
    public function actionIndex($id){
        $doc = Doc::findOne($id);
        return $this->render("doc",[
            "doc"=>$doc,
            "operations"=>$doc->operations,
            "teamID"=>$doc->getTeamID(),
        ]);
    }
    public function actionCreate($projectID){
        if(\Yii::$app->request->isPost){
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $ret=["result"=>false];
            $form=new DocForm(["scenario"=>DocForm::CREATE]);
            $form->load(\Yii::$app->request->post(),"Doc");
            $form->projectID=$projectID;
            if($form->create()){
                $ret["result"]=true;
                $ret["viewUrl"]=$form->getDoc()->getViewUrl();
            }else{
                $ret["errors"]=$form->errors;
            }
            return $ret;
        }
        $this->layout="main_empty";
        return $this->render("docCreate",[
            "projectID"=>$projectID,
        ]);
    }
    public function actionEdit($id){
        if(\Yii::$app->request->isPost){
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $ret=["result"=>false,"id"=>$id];
            $form=new DocForm(["scenario"=>DocForm::EDIT]);
            $form->load(\Yii::$app->request->post(), "Doc");
            $form->id=$id;
            if($form->edit()){
                $ret["result"]=true;
                $ret["viewUrl"]=$form->getDoc()->getViewUrl();
            }
            return $ret;
        }
        $this->layout="main_empty";
        $doc = Doc::findOne($id);
        return $this->render("docEdit",[
            "doc"=>$doc,
        ]);
    }
    public function actionDisable($id){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret=["result"=>false,"id"=>$id];
        $form=new DocForm(["scenario"=>DocForm::DISABLE]);
        $form->id=$id;
        if($form->disable()){
            $ret["result"]=true;
        }
        return $ret;
    }
    public function actionEnable($id){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret=["result"=>false,"id"=>$id];
        $form=new DocForm(["scenario"=>DocForm::ENABLE]);
        $form->id=$id;
        if($form->enable()){
            $ret["result"]=true;
        }
        return $ret;
    }
} 