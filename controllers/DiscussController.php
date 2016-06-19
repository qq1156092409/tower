<?php
namespace app\controllers;

use app\vendor\gateway\Gateway;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use app\models\form\DiscussForm;

class DiscussController extends Controller{
    public function actionToggleTop($id){
        $ret=["result"=>false,"id"=>$id,"type"=>"discuss-toggleTop","random"=>rand(0,99999)];
        $model=new DiscussForm([
            "scenario"=>DiscussForm::TOGGLE_TOP,
            "id"=>$id,
        ]);
        \Yii::$app->response->format=Response::FORMAT_JSON;
        if($model->toggleTop()){
            $discuss=$model->getDiscuss();
            $ret["result"]=true;
            $ret["order"]=$discuss->order;
            Gateway::sendToGroup("tower-" . $discuss->relevance->teamID, Json::encode($ret));
        }
        return $ret;
    }
    public function actionToggleArchive($id){
        $ret=["result"=>false,"id"=>$id,"type"=>"discuss-toggleArchive","random"=>rand(0,99999)];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new DiscussForm([
            "scenario"=>DiscussForm::TOGGLE_ARCHIVE,
            "id"=>$id,
        ]);
        if($model->toggleArchive()){
            $discuss=$model->getDiscuss();
            $ret["result"]=true;
            $ret["archive"]=$discuss->archive;
            $ret["substitute"] = $this->renderPartial("/commons/_discussSubstitute", ["model" => $discuss]);
            Gateway::sendToGroup("tower-" . $discuss->relevance->teamID, Json::encode($ret));
        }
        return $ret;
    }
} 