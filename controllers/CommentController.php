<?php

namespace app\controllers;

use app\models\Comment;
use app\models\form\CommentForm;
use app\models\UserComment;
use yii\web\Controller;
use yii\web\Response;

class CommentController extends Controller{
    /**
     * @return array
     *      {result,page}
     */
    public function actionCreate(){
        $ret=["result"=>false];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new CommentForm(["scenario"=>CommentForm::CREATE]);
        if($model->load(\Yii::$app->request->post(),"Comment") && $model->create()){
            $ret["result"]=true;
            $ret["page"]=$this->renderPartial("/commons/_comment",["model"=>$model->getComment()]);
        }else{
            $ret["errors"]=$model->errors;
        }
        return $ret;
    }

    /**
     * @param $id
     * @return array
     *      {result,id}
     */
    public function actionDestroy($id){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new CommentForm(["scenario"=>CommentForm::DESTROY,"id"=>$id]);
        if($model->destroy()){
            $ret["result"]=true;
        }
        return $ret;
    }

    /**
     * @param $id
     * @return array
     *      post:{result,id,page,text}
     *      get:{page,result}
     */
    public function actionEdit($id){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        if(\Yii::$app->request->isPost){
            $model=new CommentForm(["scenario"=>CommentForm::EDIT,"id"=>$id]);
            if($model->load(\Yii::$app->request->post(),"Comment") && $model->edit()){
                $ret["result"]=true;
                $ret["page"]=$this->renderPartial("/commons/_comment",["model"=>$model->getComment()]);
                $ret['text']=$model->getComment()->text;
            }
            return $ret;
        }
        $comment = Comment::findOne($id);
        $ret['page']=$this->renderPartial("/commons/_commentEdit",["comment"=>$comment]);
        $ret['result']=true;
        return $ret;
    }

    /**
     * @param $id
     * @return array {result,id,has,page,errors}
     */
    public function actionTogglePraise($id){
        $ret=["result"=>false,"id"=>$id,"has"=>false];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new CommentForm(["scenario"=>CommentForm::TOGGLE_PRAISE,"id"=>$id]);
        if($model->togglePraise()){
            $ret["result"]=true;
            if($userComment=UserComment::findOne(["commentID"=>$id,"userID"=>\Yii::$app->user->id])){
                $ret['has']=true;
                $ret['page']=$this->renderPartial("/commons/_userComment",["model"=>$userComment]);
            }
        }
        return $ret;
    }
} 