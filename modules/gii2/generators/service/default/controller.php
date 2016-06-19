<?php
/**
 * @var $model \app\modules\gii2\generators\target\Generator
 */
echo '<?php';
?>

namespace app\controllers;

use app\models\form\<?=ucwords($model->target)?>Form;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;

class <?=ucwords($model->target)?>Controller extends Controller{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'roles' => ['@'],],
                ],
            ]
        ];
    }
    public function actionCreate(){
        $model=new <?=ucwords($model->target)?>Form(["scenario"=><?=ucwords($model->target)?>Form::CREATE]);
        if(\Yii::$app->request->isPost){
            $ret=["result"=>false];
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $model->load(\Yii::$app->request->post(), "<?=ucwords($model->target)?>");
            if($model->create()){
                $ret["result"]=true;
            }
            return $ret;
        }
        return $this->render("create",[
            "model"=>$model,
        ]);
    }
    public function actionEdit($id){
        $model=new <?=ucwords($model->target)?>Form([
            "scenario"=><?=ucwords($model->target)?>Form::EDIT,
            "id"=>$id,
        ]);
        if(\Yii::$app->request->isPost){
            $ret=["result"=>false,"id"=>$id];
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $model->load(\Yii::$app->request->post(), "<?=ucwords($model->target)?>");
            if($model->edit()){
                $ret["result"]=true;
            }
            return $ret;
        }
        $model->loadValue();
        return $this->render("edit",[
            "model"=>$model,
        ]);
    }
    public function actionDestroy($id){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new <?=ucwords($model->target)?>Form(["scenario"=><?=ucwords($model->target)?>Form::DESTROY]);
        $model->id = $id;
        if($model->destroy()){
            $ret["result"]=true;
        }
        return $ret;
    }
}