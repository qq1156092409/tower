<?php
namespace app\controllers;
use app\models\Dir;
use app\models\form\DirForm;
use app\models\UserTeam;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\File;
use app\models\multiple\G;

class DirController extends Controller{
    public function actionIndex($id){
        $dir = Dir::findOne($id);
        $dirs=Dir::find()->where([
            "parentID"=>$id,
        ])->orderBy("`update` desc")->all();
        $files=File::find()->where([
            "dirID"=>$id,
            "deleted"=>0,
        ])->orderBy("`update` desc")->all();
        $multiples = array_reverse(G::sortByUpdate(array_merge($dirs, $files)));
        return $this->render("dir",[
            "dir"=>$dir,
            "multiples"=>$multiples,
        ]);
    }
    public function actionCreate(){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret = ["result" => false];
        $model=new DirForm(["scenario"=>DirForm::CREATE]);
        $model->load(\Yii::$app->request->post(),"Dir");
        if($model->create()){
            $ret["result"]=true;
            $ret["page"] = $this->renderPartial("/commons/_dir", ["model" => $model->getDir()]);
        }
        return $ret;
    }
    public function actionEdit($id){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret = ["result" => false,"id"=>$id];
        $model=new DirForm(["scenario"=>DirForm::EDIT]);
        $model->id=$id;
        $model->load(\Yii::$app->request->post(),"Dir");
        if($model->edit()){
            $ret['result']=true;
            $ret["name"] = $model->getDir()->name;
        }
        return $ret;
    }
    public function actionMove($id,$parentID){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret = ["result" => false,"id"=>$id,"parentID"=>$parentID];
        $model=new DirForm([
            "scenario"=>DirForm::MOVE,
            "id"=>$id,
            "parentID"=>$parentID,
        ]);
        if($model->move()){
            $ret["result"] = true;
        }
        return $ret;
    }
    public function actionDestroy($id){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret = ["result" => false,"id"=>$id];
        $model=new DirForm([
            "scenario"=>DirForm::DESTROY,
            "id"=>$id,
        ]);
        if($model->destroy()){
            $ret["result"] = true;
        }
        return $ret;
    }
    public function actionDownload($id){
        $dir = $this->check($id);
        $dir->pack();
        if(file_exists($dir->getFilePath())){
            return \Yii::$app->response->sendFile($dir->getFilePath(), $dir->name . ".zip");
        }else{
            $nullText="504b 0506 0000 0000 0000 0000 0000 0000 0000 0000 0000 ";
            return \Yii::$app->response->sendContentAsFile($nullText, $dir->name . ".zip");
        }
    }

    /**
     * @param $dir Dir|int
     * @return Dir
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    protected function check($dir){
        is_numeric($dir) and $dir = Dir::findOne($dir);
        if(!$dir){
            throw new NotFoundHttpException("你想要的资源已经飞走了");
        }
        /** @var UserTeam $userTeam */
        $userTeam = UserTeam::findOne(["userID"=>\Yii::$app->user->id,"teamID"=>$dir->project->teamID]);
        if(!$userTeam){
            throw new ForbiddenHttpException("你不是我们机组的吧");
        }
        $userTeam->activeTime=date("Y-m-d H:i:s");
        $userTeam->save();
        return $dir;
    }
}