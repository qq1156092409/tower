<?php
namespace app\controllers;

use app\vendor\gateway\Gateway;
use app\models\Collect;
use app\models\multiple\G;
use app\models\Task;
use app\models\UserTeam;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\User;
use app\models\form\TaskForm;

class TaskController extends Controller{
    public function actionIndex($id){
        $task = Task::findOne($id);
        $this->validate($task);
        $collect=Collect::findOne([
            "userID"=>\Yii::$app->user->id,
            "model"=>G::TASK,
            "value"=>$task->id,
        ]);
        $users=User::find()->innerJoinWith("userTeams")->where(["user_team.teamID"=>$task->item->project->teamID])->all();
        return $this->render("task",[
            "teamID"=>$task->item->project->teamID,
            "model"=>$task,
            "operations"=>$task->operations,
            "isCollect"=>$collect,
            "users"=>$users,
        ]);
    }

    /**
     * 查询校验
     * 存在，加入了所属团队
     * @param $task Task
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    private function validate($task){
        if(!$task){
            throw new NotFoundHttpException();
        }
        $userTeam=UserTeam::findOne([
            "userID"=>\Yii::$app->user->id,
            "teamID"=>$task->getTeamID(),
        ]);
        if(!$userTeam){
            throw new ForbiddenHttpException();
        }
        //刷新最近访问的项目记录
        $userTeam->activeTime=date("Y-m-d H:i:s");
        $userTeam->save();
    }

    public function actionCreate(){
        $ret = ["result" => false];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new TaskForm(["scenario" => TaskForm::CREATE]);
        $model->load(\Yii::$app->request->post(), "Task");
        if($model->create()){
            $task=$model->getTask();
            $ret['result']=true;
            $ret['page']=$this->renderPartial("/commons/_task", [
                "model" => $task,
            ]);
            $ret['itemID']=$task->itemID;
        }else{
            $ret["errors"]=$model->errors;
        }
        return $ret;
    }
    /**
     * @param $id
     * @return array {result,id,html,oldTaskID}
     */
    public function actionRun($id){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new TaskForm(["scenario"=>TaskForm::RUN]);
        $model->id=$id;
        if($model->run()){
            $task=$model->getTask();
            $ret["result"]=true;
            $ret["page"] = $this->renderPartial("/commons/_task", ["model" => $task]);
            if($old=$model->getOldRunTask()){
                $ret["oldTaskID"]=$old->id;
            }
        }
        return $ret;
    }
    public function actionPend($id){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new TaskForm(["scenario"=>TaskForm::PAUSE]);
        $model->id=$id;
        if($model->pend()){
            $task=$model->getTask();
            $ret["result"]=true;
            $ret["page"] = $this->renderPartial("/commons/_task", ["model" => $task]);
        }
        return $ret;
    }
    public function actionDisable($id){
        $ret = ["result" => false, "id" => $id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new TaskForm([
            "scenario"=>TaskForm::DISABLE,
            "id"=>$id,
        ]);
        if($model->disable()){
            $ret["result"]=true;
        }
        return $ret;
    }
    public function actionEnable($id){
        $ret = ["result" => false, "id" => $id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new TaskForm([
            "scenario"=>TaskForm::ENABLE,
            "id"=>$id,
        ]);
        if($model->enable()){
            $ret["result"]=true;
        }
        return $ret;
    }
    public function actionAssign($id){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new TaskForm([
            "scenario"=>TaskForm::ASSIGN,
            "id"=>$id,
        ]);
        $model->load(\Yii::$app->request->post(),"Task");
        if($model->assign()){
            $ret["html"] = $this->renderPartial("/commons/_task", [
                "model" => $model->getTask(),
            ]);
        }
        return $ret;
    }
    public function actionEdit($id){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret=["result"=>false,"id"=>$id];
        $model=new TaskForm([
            "scenario"=>TaskForm::EDIT,
            "id"=>$id
        ]);
        $model->load(\Yii::$app->request->post(), "Task");
        if($model->edit()){
            $ret['result']=true;
            $ret["page"] = $this->renderPartial("/commons/_task", [
                "model" => $model->getTask(),
            ]);
        }else{
            $ret["errors"]=$model->errors;
        }
        return $ret;
    }
    public function actionFinish($id){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret=["result"=>false,"id"=>$id,"type"=>"task-finish","random"=>rand(0,99999)];
        $model=new TaskForm([
            "scenario"=>TaskForm::FINISH,
            "id"=>$id
        ]);
        if($model->finish()){
            $task=$model->getTask();
            $ret['result']=true;
            $ret['itemID']=$task->itemID;
            $ret["page"] = $this->renderPartial("/commons/_task", [
                "model" => $task,
            ]);
            Gateway::sendToGroup("tower-".$task->project->teamID,Json::encode($ret));
        }
        return $ret;
    }
    public function actionOpen($id){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $ret=["result"=>false,"id"=>$id,"type"=>"task-open","random"=>rand(0,99999)];
        $model=new TaskForm([
            "scenario"=>TaskForm::OPEN,
            "id"=>$id
        ]);
        if($model->open()){
            $task=$model->getTask();
            $ret['result']=true;
            $ret['itemID']=$task->itemID;
            $ret["page"] = $this->renderPartial("/commons/_task", [
                "model" => $task,
            ]);
            Gateway::sendToGroup("tower-".$task->project->teamID,Json::encode($ret));
        }
        return $ret;
    }
} 