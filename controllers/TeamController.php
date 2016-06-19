<?php
namespace app\controllers;

use app\filters\UserTeamFilter;
use app\models\form\TeamForm;
use app\models\Operation;
use app\models\search\Search;
use app\models\Subgroup;
use app\models\Team;
use app\models\UserTeam;
use yii\helpers\Security;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use app\models\Project;
use yii\filters\AccessControl;
use app\models\User;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\Calendar;

class TeamController extends Controller{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'roles' => ['@'],],
                ],
            ],
        ];
    }
    public function actionCreate(){
        $model=new TeamForm(["scenario"=>TeamForm::CREATE]);
        $model->load(\Yii::$app->request->post(),"Team");
        $flag=$model->create();
        //response
        if(\Yii::$app->request->isAjax){
            $ret=["result"=>false];
            \Yii::$app->response->format=Response::FORMAT_JSON;
            if($flag){
                $ret["result"]=true;
                $ret["id"]=$model->getTeam()->id;
                $ret["viewUrl"] = Url::to(["/team/projects", "id" => $model->getTeam()->id]);
            }else{
                $ret["errors"]=$model->errors;
            }
            return $ret;
        }
        return $flag?1:0;
    }
    public function actionEdit($id){
        $model=new TeamForm([
            "scenario"=>TeamForm::EDIT,
            "id"=>$id,
        ]);
        $model->load(\Yii::$app->request->post(),"Team");
        $ret=["result"=>false,"id"=>$id];
        if($model->edit()){
            $ret["result"]=true;
            $ret["name"]=$model->getTeam()->name;
        }
        \Yii::$app->response->format=Response::FORMAT_JSON;
        return $ret;
    }
    public function actionSetting($id){
        $team = Team::findOne($id);
        return $this->render("setting",[
            "team"=>$team,
        ]);
    }
    public function actionUpgrade($id){
        $team = Team::findOne($id);
        return $this->render("upgrade",[
            "team"=>$team,
        ]);
    }
    public function actionProjects($id){
        $this->validate(TeamForm::VIEW);
        $team = Team::findOne($id);
        $projects=Project::find()->innerJoinWith(["userProjects"])->where([
            "project.teamID"=>$id,
            "user_project.userID"=>\Yii::$app->user->id,
            "template"=>0,
            "archive"=>0,
        ])->orderBy("sort desc")->all();
        $this->updateUserTeam($id);
        return $this->render("projects",[
            "team"=>$team,
            "teamID"=>$id,
            "projects"=>$projects,
        ]);
    }
    public function actionArchivedProjects($id){
        $team = Team::findOne($id);
        $projects=Project::find()->innerJoinWith(["userProjects"])->where([
            "project.teamID"=>$id,
            "user_project.userID"=>\Yii::$app->user->id,
            "template"=>0,
            "archive"=>1,
        ])->all();
        $this->updateUserTeam($id);
        return $this->render("archivedProjects",[
            "team"=>$team,
            "projects"=>$projects,
        ]);
    }
    public function actionTemplates($id){
        $team = Team::findOne($id);
        $templates=$team->getProjects()->where(["template"=>1])->all();
        return $this->render("templates",[
            "team"=>$team,
            "templates"=>$templates,
        ]);
    }
    public function actionMembers($id){
        $subgroups = Subgroup::find()->with(["userTeams.user"])->where([
            "teamID" => $id
        ])->orderBy("sort")->all();
        $noGroupUserTeams=UserTeam::find()->innerJoinWith(["user"])->where([
            "teamID"=>$id,
            "subgroupID"=>0,
        ])->all();
        return $this->render("members",[
            "teamID"=>$id,
            "subgroups"=>$subgroups,
            "noGroupUserTeams"=>$noGroupUserTeams
        ]);
    }
    public function actionSubgroupCreate($teamID){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $subgroup=new Subgroup();
        $subgroup->load(\Yii::$app->request->post());
        $subgroup->teamID=$teamID;
        if($subgroup->save()){
            $ret["htm"]=$this->renderPartial("/commons/_subgroup",["model"=>$subgroup]);
            $ret["result"]=true;
        }else{
            $ret["result"]=false;
        }
        return $ret;
    }
    public function actionMemberCreate($teamID){
        $team = Team::findOne($teamID);
        return $this->render("memberCreate",[
            "teamID"=>$teamID,
            "team"=>$team,
        ]);
    }
    public function actionApply($code){

        return $code;//todo
    }
    public function actionCodeReset($teamID){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $team = Team::findOne($teamID);
        if($ret["result"]=$team->resetCode()){
            $ret["code"]=$team->activeCode;
            $ret["applyUrl"]=Url::to(["team/apply","code"=>$team->activeCode],"http");
        }
        return $ret;
    }

    /**
     * todo 修复列举方式
     * @param $id
     * @param null $userID
     * @param int $offset
     * @return string
     */
    public function actionOperations($id,$userID=null,$offset=0){
        $limit=30;
        $team = Team::findOne($id);
        $where=["relevance.teamID"=>$id];
        $userID and $where["userID"]=$userID;
        $operations=Operation::find()->innerJoinWith(["relevance"])->with(["user"])
            ->where($where)->orderBy("id desc")->offset($offset)->limit($limit)->all();
        $user=($userID?User::findOne($userID):null);
        if(\Yii::$app->request->isAjax){
            $ret=["result"=>true,"page"=>"","newOffset"=>$offset+$limit,"hasMore"=>count($operations)==$limit];
            \Yii::$app->response->format=Response::FORMAT_JSON;
            foreach(Operation::divideCreatePrev($operations) as $day=>$projectOperations){
                $ret["page"].=$this->renderPartial("operations_day",[
                    "day"=>$day,
                    "projectOperations"=>$projectOperations,
                    "teamID"=>$id,
                ]);
            }
            return $ret;
        }
        return $this->render("operations",[
            "teamID"=>$id,
            "team"=>$team,
            "limit"=>$limit,
            "hasMore"=>count($operations)==$limit,
            "operations"=>Operation::divideCreatePrev($operations),
            "user"=>$user,
        ]);
    }

    /**
     * todo 攻克事件event的显示
     * @param $id
     * @param null $month
     * @return string
     */
    public function actionCalendars($id,$month=null){
        $month or $month=date("Y-m");
        //团队可见日历
        $calendars=Calendar::find()->innerJoinWith(["userCalendars"])->where([
            "calendar.teamID"=>$id,
            "user_calendar.userID"=>\Yii::$app->user->id,
        ])->all();
        //可见项目日历
        $projectCalendars=Calendar::find()->innerJoinWith(["project.userProjects"])->where([
            "calendar.teamID"=>$id,
            "user_project.userID"=>\Yii::$app->user->id,
        ])->all();
        return $this->render("calendars",[
            "teamID"=>$id,
            "month"=>$month,
            "calendars"=>$calendars,
            "projectCalendars"=>$projectCalendars,
            "weekDays"=>$this->getWeekDays($month),
        ]);
    }
    public function actionSearch($id,$keyword=""){
        $model=new Search(["scenario"=>"search"]);
        $model->teamID=$id;
        $model->keyword=$keyword;
        if($model->search()){
            if(\Yii::$app->request->isAjax){
                $ret=["result"=>true,"page"=>""];
                \Yii::$app->response->format=Response::FORMAT_JSON;
                foreach($model->getDatas() as $data){
                    $ret["page"]=$this->renderPartial("_search",["model"=>$data]);
                }
                return $ret;
            }
            return $this->render("search",[
                "model"=>$model,
            ]);
        }else{
            throw new ForbiddenHttpException("你不是我们机组的吧");
        }
    }

    private function getWeekDays($month=null){
        $firstDay=strtotime($month?$month.'-01':date("Y-m-01"));//这个月的一号,时间戳
        $offset=(date("w",$firstDay)+6)%7;
        $first=strtotime("-$offset days",$firstDay);//月历上的第一天,时间戳
        $dayCount=cal_days_in_month(CAL_GREGORIAN,date("m",$firstDay),date("Y",$firstDay));
        $length=($dayCount+$offset)>35?42:35;
        $days=[];
        for($i=0;$i<$length;$i++){
            $days[]=date("Y-m-d",strtotime("+$i days",$first));
        }
        return array_chunk($days,7);
    }
    private function updateUserTeam($id){
        $userTeam = UserTeam::findOne(["userID" => \Yii::$app->user->id, "teamID" => $id]);
        $userTeam->activeTime=date("Y-m-d H:i:s");
        return $userTeam->save();
    }
    private function validate($scenario){
        $model = new TeamForm(["scenario"=>$scenario]);
        $model->load(\Yii::$app->request->getQueryParams(),"");
        if(!$model->validate()){
            $firstError=current($model->errors);
            throw new BadRequestHttpException($firstError[0]);
        }
        return $model;
    }
}