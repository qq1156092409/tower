<?php
namespace app\controllers;

use app\models\form\UserTeamForm;
use yii\web\Controller;
use yii\web\Response;

class UserTeamController extends Controller{
    public function actionSubgroup($id,$subgroupID){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new UserTeamForm([
            "scenario"=>UserTeamForm::SUBGROUP,
            "id"=>$id,
            "subgroupID"=>$subgroupID,
        ]);
        if($model->subgroup()){
            $ret["result"]=true;
        }
        return $ret;
    }
} 