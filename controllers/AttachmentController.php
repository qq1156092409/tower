<?php
namespace app\controllers;

use app\models\form\AttachmentForm;
use yii\base\NotSupportedException;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * 附件控制器
 * Class AttachmentController
 * @package app\controllers
 */
class AttachmentController extends Controller {
    public function actionSingle(){
        $model=new AttachmentForm(["scenario"=>AttachmentForm::SINGLE]);
        $model->file = UploadedFile::getInstanceByName("file");
        $ret=["result"=>false,"name"=>$model->file->name];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        if($model->upload()){
            $ret["result"]=true;
            $ret["path"]=$model->getPath();
        }else{
            $ret["errors"]=$model->errors;
        }
        return $ret;
    }
    public function actionMultiple(){
        throw new NotSupportedException();
    }
    public function actionSimditor(){
        $model=new AttachmentForm(["scenario"=>AttachmentForm::SIMDITOR]);
        $model->file = UploadedFile::getInstanceByName("file");
        $ret=["success"=>false,"name"=>$model->file->name];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        if($model->upload()){
            $ret["success"]=true;
            $ret["file_path"]=$model->getPath();
        }else{
            $ret["errors"]=$model->errors;
            $ret["msg"]=current($model->errors)[0];//取第一个错误
        }
        return $ret;
    }
}