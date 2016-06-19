<?php

namespace app\controllers;
use app\models\File;
use app\models\form\FileForm;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class FileController extends Controller{
    public function actionIndex($id){
        $file = File::findOne($id);
        return $this->render("file",[
            "file"=>$file,
            "teamID"=>$file->project->teamID,
        ]);
    }
    public function actionDownload($id){
        $file = File::findOne($id);
        $tempName='../files/'.$file->temp;
        $tempName=FileHelper::normalizePath($tempName);
        if(!$file || !file_exists($tempName)){
            throw new NotFoundHttpException;
        }
        return \Yii::$app->response->sendFile($tempName,$file->name);
    }
    public function actionToggleEnable($id){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret=["result"=>false,"id"=>$id];
        $model=new FileForm([
            "scenario"=>FileForm::TOGGLE_ENABLE,
            "id"=>$id,
        ]);
        if($model->toggleEnable()){
            $ret["result"]=true;
            $ret["deleted"]=$model->getFile()->deleted;
        }
        return $ret;
    }
    public function actionUpload($projectID,$dirID){
        $model=new FileForm(["scenario"=>FileForm::UPLOAD]);
        $model->projectID=$projectID;
        $model->dirID=$dirID;
        $ret=["result"=>false,"projectID"=>$projectID,"dirID"=>$dirID];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model->attachment = UploadedFile::getInstanceByName("attachment");
        $model->preprocess();
        if($model->upload()){
            $ret["result"]=true;
            $ret["page"]=$this->renderPartial("/commons/_file",["model"=>$model->getFile()]);
        }else{
            $ret["errors"]=$model->errors;
        }
        return $ret;
    }
} 