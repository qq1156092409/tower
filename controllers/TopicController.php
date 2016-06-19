<?php

namespace app\controllers;

use app\models\multiple\G;
use app\models\Operation;
use app\models\form\TopicForm;
use yii\web\Controller;
use yii\web\Response;
use app\models\Topic;

class TopicController extends Controller{
    public function actionIndex($id){
        $topic = Topic::findOne($id);
        $operations=$topic->operations;
        return $this->render("topic",[
            "topic"=>$topic,
            "teamID"=>$topic->project->teamID,
            "operations"=>$operations,
        ]);
    }
    public function actionCreate(){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret=["result"=>false];
        $form=new TopicForm(["scenario"=>TopicForm::CREATE]);
        if($form->load(\Yii::$app->request->post(),"Topic") && $form->create()){
            $topic=$form->getTopic();
            $ret["result"]=true;
            $ret["page"]=$this->renderPartial("/commons/_discuss",["model"=>$topic->discuss]);
        }
        return $ret;
    }
    public function actionEnable($id){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret=["result"=>false];
        $form=new TopicForm(["scenario"=>TopicForm::ENABLE]);
        $form->id=$id;
        if($form->validate() && $form->getTopic()->enable(\Yii::$app->user->id)){
            $ret["result"]=true;
        }
        return $ret;
    }

    public function actionDisable($id){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret=["result"=>false];
        $form=new TopicForm(["scenario"=>TopicForm::DISABLE]);
        $form->id=$id;
        if($form->validate() && $form->getTopic()->disable(\Yii::$app->user->id)){
            $ret["result"]=true;
        }
        return $ret;
    }
    public function actionMove($id,$projectID){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret=["result"=>false];
        $form=new TopicForm(["scenario"=>TopicForm::MOVE]);
        $form->id=$id;
        $form->projectID=$projectID;
        if($form->validate() && $form->getTopic()->move($projectID,\Yii::$app->user->id)){
            $ret["result"]=true;
        }
        return $ret;
    }
    public function actionEdit($id){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret=["result"=>false,"id"=>$id];
        $form=new TopicForm(["scenario"=>TopicForm::EDIT]);
        $form->id=$id;
        if($form->load(\Yii::$app->request->post(),"Topic") && $form->validate()){
            $topic=$form->getTopic();
            if($topic->edit($form->name,$form->text,\Yii::$app->user->id)){
                $ret["result"]=true;
                $ret["name"]=$topic->name;
                $ret["text"]=$topic->text;
            }
        }
        return $ret;
    }
} 