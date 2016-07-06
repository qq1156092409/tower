<?php

namespace app\controllers;
use app\models\form\GzhForm;
use yii\web\Controller;

class GzhController extends Controller{
    public $enableCsrfValidation=false;
    public function actionIndex($echostr=null){
        $model=new GzhForm();
        if(!$echostr){
            $model->scenario=GzhForm::ANSWER;
            $model->load($this->getPostData(),"");
            if($model->answer()){
                echo $model->getRet();
            }else{
                foreach($model->errors as $k=>$v){
                    echo $v[0];break;
                }
            }
            \Yii::$app->end();
        }
        $model->scenario=GzhForm::VALID;
        $model->load(\Yii::$app->request->getQueryParams(),"");
        if($model->valid()){
            echo $model->getRet();
        }
    }
    private function getPostData(){
        $data=[];
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        //extract post data
        if (!empty($postStr)){
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $data=[
                "FromUserName"=>$postObj->FromUserName,
                "ToUserName"=>$postObj->ToUserName,
                "Content"=>$postObj->Content,
            ];
        }
        return $data;
    }
}