<?php
namespace app\controllers;

use app\models\Area;
use yii\web\Controller;
use yii\web\Response;

class AreaController extends Controller{
    public function actionList(){
        $root=Area::findOne(["parentID"=>0]);
        $areas=$root->getChildren()->orderBy("sort,id")->all();
        return $this->render("areas",["areas"=>$areas]);
    }
    public function actionGetChildren($parentID){
        $ret=["result"=>true,"page"=>"","parentID"=>$parentID];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $areas=Area::find()->where(["parentID"=>$parentID])->orderBy("sort,id")->all();
        if($areas){
            $ret["page"]=$this->renderPartial("_select",["areas"=>$areas]);
        }
        return $ret;
    }
}