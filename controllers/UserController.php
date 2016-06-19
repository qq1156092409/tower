<?php
namespace app\controllers;

use app\models\Collect;
use app\models\Task;
use app\models\Team;
use app\models\UserLog;
use app\models\UserTeam;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use app\models\User;
use yii\helpers\Url;
use yii\filters\AccessControl;
use app\models\Event;

class UserController extends Controller{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionTasks($teamID){
        $tasks=Task::find()->innerJoinWith("item.project")->where([
            "task.status"=>Task::getUnFinishStatus(),
            "task.userID"=>\Yii::$app->user->id,
            "task.deleted"=>0,
            "project.teamID"=>$teamID
        ])->all();
        $projects = Task::getProjects($tasks);
        $tasks = Task::divideBox($tasks);
        $userLog=UserLog::find()->where([
            "userID"=>\Yii::$app->user->id,
            "type"=>UserLog::LOGIN,
        ])->orderBy("id desc")->one();
        return $this->render("task",[
            "tasks"=>$tasks,
            "projects"=>$projects,
            "teamID"=>$teamID,
            "userLog"=>$userLog,
        ]);
    }
    public function actionCreatedTasks($teamID){
        $unFinishTasks=Task::find()->innerJoinWith(["item.project",'user'])->where([
            "task.creatorID"=>\Yii::$app->user->id,
            "task.status"=>Task::getUnFinishStatus(),
            "project.teamID"=>$teamID
        ])->all();
        $query=Task::find();
        $query->innerJoinWith(["item.project",'user'])->where([
            "task.creatorID"=>\Yii::$app->user->id,
            "task.status"=>Task::FINISHED,
            "project.teamID"=>$teamID
        ])->orderBy("finishTime DESC")->limit(10);
        return $this->render("createdTask",[
            "unFinishTasks"=>$unFinishTasks,
            "finishTasks"=>$query->all(),
            "teamID"=>$teamID,
        ]);
    }
    public function actionMoreFinishTasks($teamID,$offset=0,$limit=10){
        $result=["more"=>0];
        $query=Task::find();
        $query->innerJoinWith(["item.project"])->where([
            "task.creatorID"=>\Yii::$app->user->id,
            "task.status"=>Task::FINISHED,
            "project.teamID"=>$teamID
        ]);
        $tasks=$query->orderBy("finishTime DESC")->offset($offset)->limit($limit)->all();
        foreach($tasks as $task){
            $result['htm'].=$this->renderPartial("/commons/_task",["model"=>$task]);
        }
        if(count($tasks)==$limit){
            if($query->count()>($offset+$limit)){
                $result['more']=1;
            }
        }
        \Yii::$app->response->format=Response::FORMAT_JSON;
        return $result;
    }

    /**
     * todo 任务排序方式错误
     * 暂时先用按日期-清单的方式排
     * load more规则：最少10条，但不切开相同完成日期的任务
     * @param $teamID
     * @param string $endTime
     * @return string
     */
    public function actionFinishedTasks($teamID,$endTime=null){
        $limit=10;
        $query=Task::find()->innerJoinWith(["item.project"])->where([
            "task.userID"=>\Yii::$app->user->id,
            "task.status"=>Task::FINISHED,
            "project.teamID"=>$teamID
        ])->orderBy("finishTime desc");
        if($endTime){
            $endTime=date("Y-m-d 00:00:00",strtotime($endTime));
            $query->andWhere("finishTime < :endTime", [":endTime" => $endTime]);
        }
        /** @var Task $startTask */
        $startTask=$query->offset($limit-1)->one();
        $startTime=null;
        if($startTask){
            $startTime=date("Y-m-d 00:00:00",strtotime($startTask->finishTime));
            $query->andWhere("finishTime >= :startTime", [":startTime" => $startTime]);
        }
        $tasks=$query->offset(null)->all();//一定要清空query遗留的不需要的条件
        $dayTasks=Task::divideFinishDayItem($tasks);
        if(\Yii::$app->request->isAjax){
            $ret=[];
            foreach($dayTasks as $day=>$itemTasks){
                $ret["htm"].=$this->renderPartial("finishedTask_day",["day"=>$day,"itemTasks"=>$itemTasks]);
            }
            $ret["moreUrl"]=$startTime?Url::to(["","teamID"=>$teamID,"endTime"=>$startTime]):false;
            \Yii::$app->response->format=Response::FORMAT_JSON;
            return $ret;
        }
        return $this->render("finishedTask",[
            "teamID"=>$teamID,
            "dayTasks"=>$dayTasks,
            "startTime"=>$startTime,
        ]);
    }
    public function actionCollects($teamID){
        $collects=Collect::find()->innerJoinWith(["relevance"])->where([
            "userID"=>\Yii::$app->user->id,
            "relevance.teamID"=>$teamID,
        ])->orderBy("id desc")->all();
        $userLog=UserLog::find()->where([
            "userID"=>\Yii::$app->user->id,
            "type"=>UserLog::LOGIN,
        ])->orderBy("id desc")->one();
        return $this->render("collects",[
            "teamID"=>$teamID,
            "collects"=>$collects,
            "userLog"=>$userLog,
        ]);
    }
    public function actionEmail($teamID){
        $userLog=UserLog::find()->where([
            "userID"=>\Yii::$app->user->id,
            "type"=>UserLog::LOGIN,
        ])->orderBy("id desc")->one();
        return $this->render("email",[
            "teamID"=>$teamID,
            "userLog"=>$userLog,
        ]);
    }
    public function actionEvents($teamID,$month=null){
        $month or $month=date("Y-m");
        $monthStart=$month.'-01 00:00:00';
        $monthEnd=$month.'-31 23:59:59';
        $userID=\Yii::$app->user->id;
        $events=Event::find()->joinWith(["eventUsers","calendar"])
            ->where(["event.userID"=>$userID])
            ->orWhere(["event_user.userID"=>$userID])
            ->andWhere(["calendar.teamID"=>$teamID])
            ->andWhere("event.end > '$monthStart' and event.start <'$monthEnd'")
            ->all();
        $userLog=UserLog::find()->where([
            "userID"=>\Yii::$app->user->id,
            "type"=>UserLog::LOGIN,
        ])->orderBy("id desc")->one();
        return $this->render("events",[
            "events"=>$events,
            "userLog"=>$userLog,
            "teamID"=>$teamID,
            "monthStart"=>$monthStart,
        ]);
    }
    public function actionLogins(){
        $userLogs=UserLog::find()->where(["userID"=>\Yii::$app->user->id])->orderBy("id desc")->limit(30)->all();
        $userTeam=\Yii::$app->user->identity->lastUserTeam;
        return $this->render("logins",[
            "userLogs"=>$userLogs,
            "userTeam"=>$userTeam,
        ]);
    }
    public function actionTeams(){
        $teams=Team::find()->innerJoinWith(["userTeams"],false)->where([
            "user_team.userID"=>\Yii::$app->user->id
        ])->all();
        return $this->renderPartial("teams",[
            "teams"=>$teams
        ]);
    }
    public function actionSetting(){
        return $this->render("setting");
    }

    public function actionNotificationSetting(){
        return $this->render("notificationSetting");
    }
}