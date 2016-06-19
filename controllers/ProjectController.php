<?php
namespace app\controllers;

use app\models\Dir;
use app\models\Discuss;
use app\models\File;
use app\models\form\ProjectForm;
use app\models\multiple\G;
use app\models\Operation;
use app\models\Project;
use app\models\Task;
use app\models\Team;
use app\models\UserProject;
use app\models\UserTeam;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\models\User;
use yii\web\Response;
use app\models\Event;
use app\models\Doc;
use app\models\Item;

class ProjectController extends Controller{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'roles' => ['@']],
                ],
            ],
        ];
    }
    //--check
    public function actionIndex($id){
        /** @var Project $project */
        $project=Project::find()
            ->with("commonItems.commonTasks.user")
            ->where(["id"=>$id])
            ->one();
        $users=User::find()
            ->innerJoinWith("userTeams")
            ->where(["user_team.teamID"=>$project->teamID])
            ->all();
        $discusses = Discuss::find()->innerJoinWith(["relevance"])->where([
            "relevance.prevModel"=>G::PROJECT,
            "relevance.prevValue" => $id,
            "archive"=>0,
            "deleted" => G::DELETED_NOT,
        ])->orderBy("`order` desc,`update` desc")->limit(5)->all();
        $dirs=Dir::find()
            ->where(["projectID"=>$id, "parentID" =>0,])
            ->orderBy("`update` desc")
            ->limit(10)->all();
        $files=File::find()->where([
            "projectID"=>$id,
            "dirID"=>0,
            "deleted"=>0,
        ])->orderBy("`update` desc")->limit(10)->all();
        $multiples = array_reverse(G::sortByUpdate(array_merge($dirs, $files)));
        $multiples = array_slice($multiples, 0, 10);
        $date=date("Y-m-d 00:00:00");
        $events=Event::find()
            ->innerJoinWith(["calendar"])
            ->where(["calendar.projectID"=>$id])
            ->andWhere("event.start <= '$date' and '$date' <= event.end")
            ->limit(4)->all();
        $docs=Doc::find()
            ->where(["projectID"=>$id])
            ->orderBy("`update` desc")
            ->limit(6)->all();
        $items=$project->getCommonItems()->orderBy("id desc")->all();
        return $this->render("project",[
            "teamID"=>$project->teamID,
            "model"=>$project,
            "users"=>$users,
            "discusses"=>$discusses,
            "multiples"=>$multiples,
            "events"=>$events,
            "docs"=>$docs,
            "items"=>$items,
        ]);
    }
    public function actionItems($id){
        $project=Project::find()->with("commonItems.unFinishTasks.user")->where(["id"=>$id])->one();
        return $this->render("items",[
            "project"=>$project,
            "items"=>array_reverse($project->commonItems),
            "users"=>$project->team->users,
            "teamID"=>$project->teamID,
        ]);
    }
    public function actionArchiveItems($id){
        $project = Project::findOne($id);
        $items=$project->getItems()->where(["deleted"=>0,"archive"=>1])->all();
        return $this->render("archiveItems",[
            "project"=>$project,
            "items"=>$items,
        ]);
    }
    public function actionTrashes($id){
        $project = Project::findOne($id);
        $trashOperations=Operation::find()->innerJoinWith(["relevance"])->with(["user"])->where([
            "relevance.prevModel"=>G::PROJECT,
            "relevance.prevValue"=>$id,
            "type"=>[Operation::ENABLE,Operation::DISABLE]
        ])->orderBy("id desc")->all();
        return $this->render("trashes",[
            "teamID"=>$project->teamID,
            "project"=>$project,
            "trashOperations"=>Operation::divideDay($trashOperations),
        ]);
    }
    public function actionDiscusses($id,$archive=0){
        $project = Project::findOne($id);
        $discusses=Discuss::find()->innerJoinWith(["relevance"])->where([
            "relevance.prevModel"=>G::PROJECT,
            "relevance.prevValue"=>$id,
            "archive"=>$archive,
            "deleted"=>G::DELETED_NOT,
        ])->orderBy("`order` desc,`update` desc")->all();
        return $this->render("discusses",[
            "discusses"=>$discusses,
            "teamID"=>$project->teamID,
            "projectID"=>$id,
            "archive"=>$archive,
            "project"=>$project,
        ]);
    }
    public function actionFiles($id){
        $project = Project::findOne($id);
        $dirs=Dir::find()->where([
            "projectID"=>$id,
            "parentID"=>0,
        ])->orderBy("`update` desc")->all();
        $files=File::find()->where([
            "projectID"=>$id,
            "dirID"=>0,
            "deleted"=>0,
        ])->orderBy("`update` desc")->all();
        $multiples = array_reverse(G::sortByUpdate(array_merge($dirs, $files)));
        return $this->render("files",[
            "project"=>$project,
            "multiples"=>$multiples,
        ]);
    }
    public function actionEvents($id,$month=null){
        $month or $month=date("Y-m");
        $monthStart=$month.'-01 00:00:00';
        $monthEnd=$month.'-31 23:59:59';
        $project = Project::findOne($id);
        $events=Event::find()
            ->innerJoinWith(["calendar"])
            ->where("event.end > '$monthStart' and event.start <'$monthEnd'")
            ->andWhere(["calendar.projectID"=>$id])
            ->all();
        return $this->render("events",[
            "project"=>$project,
            "teamID"=>$project->teamID,
            "events"=>$events,
            "monthStart"=>$monthStart,
        ]);
    }
    public function actionDocs($id){
        $project = Project::findOne($id);
        $docs=Doc::find()
            ->where(["projectID"=>$id,"deleted"=>G::DELETED_NOT])
            ->orderBy("`update` desc")
            ->all();
        return $this->render("docs",[
            "project"=>$project,
            "teamID"=>$project->teamID,
            "docs"=>$docs,
        ]);
    }
    public function actionTasks($id){
        $project = Project::findOne($id);
        $tasks = $project->getCommonTasks()->where(["itemID"=>0])->all();
        $items=$project->getCommonItems()->orderBy("id desc")->all();
        return $this->render("tasks",[
            "project"=>$project,
            "tasks"=>$tasks,
            "items"=>$items,
        ]);
    }
    public function actionDirectTasks($id){
        $project = Project::findOne($id);
        $tasks = Task::find()->where([
            "projectID"=>$id,
            "itemID"=>0,
            "deleted"=>0,
        ])->all();
        $finishedTasks=$unFinishedTasks=[];
        foreach($tasks as $task){
            if($task->status==Task::FINISHED){
                $finishedTasks[]=$task;
            }else{
                $unFinishedTasks[]=$task;
            }
        }
        return $this->render("directTasks",[
            "project"=>$project,
            "tasks"=>$tasks,
            "finishedTasks"=>$finishedTasks,
            "unFinishedTasks"=>$unFinishedTasks,
        ]);
    }
    public function actionFinishedTasks($id,$userID=null){
        $project = Project::findOne($id);
        $where=[
            "task.projectID"=>$id,
            "task.status"=>Task::FINISHED,
            "task.deleted"=>0,
            "item.deleted"=>0,
        ];
        $userID and $where["task.userID"]=$userID;
        $tasks=Task::find()->joinWith(["item"])->where($where)->all();
        $dayItemTasks = Task::divideFinishDayItem($tasks);
        $project->userProjects;//项目成员
        $users=User::find()->innerJoinWith("userProjects")->where([
            "user_project.projectID"=>$id,
        ])->all();
        return $this->render("finishedTasks",[
            "project"=>$project,
            "dayItemTasks"=>$dayItemTasks,
            "users"=>$users,
            "userID"=>$userID,
        ]);
    }
    public function actionStats($id){
        $project = Project::findOne($id);
        return $this->render("stats",[
            "project"=>$project,
        ]);
    }
    public function actionSetting($id){
        $project = Project::findOne($id);
        return $this->render("projectSetting",[
            "project"=>$project,
        ]);
    }
    //--action
    public function actionCreate($teamID){
        $model=new ProjectForm([
            "scenario"=>ProjectForm::CREATE,
            "teamID"=>$teamID,
        ]);
        if(\Yii::$app->request->isPost){
            $ret=["result"=>false];
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $model->load(\Yii::$app->request->post(), "Project");
            if($model->create()){
                $ret["result"]=true;
                $ret['viewUrl']=$model->getProject()->getViewUrl();
            }
            return $ret;
        }
        $team = Team::findOne($teamID);
        $userTeams=UserTeam::find()->with(["subgroup"])->where(["teamID"=>$teamID])->andWhere("userID !=".\Yii::$app->user->id)->all();
        $subgroups=UserTeam::getSubgroups($userTeams);
        return $this->render("projectCreate",[
            "model"=>$model,
            "team"=>$team,
            "userTeams"=>$userTeams,
            "subgroups"=>$subgroups,
        ]);
    }

    /**
     * @param $id
     * @return array
     */
    public function actionIcon($id){
        $model=new ProjectForm([
            "scenario"=>ProjectForm::ICON,
            "id"=>$id,
        ]);
        $model->load(\Yii::$app->request->post(),"Project");
        $project=$model->getProject();
        $ret=["result"=>false,"id"=>$id,"oldIcon"=>$project->icon,"oldIconColor"=>$project->iconColor];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        if($model->icon()){
            $project=$model->getProject();
            $ret['result']=true;
            $ret["icon"]=$project->icon;
            $ret["iconColor"]=$project->iconColor;
        }
        return $ret;
    }
    public function actionQuit($id){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new ProjectForm([
            "scenario"=>ProjectForm::QUIT,
            "id"=>$id,
        ]);
        if ($model->quit()) {
            $ret['result']=true;
            $ret['jump'] = Url::to(["/team/projects", "id" => $model->getProject()->teamID]);
        }else{
            $ret['errors']=$model->errors;
        }
        return $ret;
    }
    public function actionDestroy($id){
        $model=new ProjectForm([
            "scenario"=>ProjectForm::DESTROY,
            "id"=>$id,
        ]);
    }
    public function actionMembers($id){
        if(\Yii::$app->request->isPost){
            $ret=["result"=>false,"id"=>$id];
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $model=new ProjectForm([
                "scenario"=>ProjectForm::MEMBER_MANAGE,
                "id"=>$id,
            ]);
            $model->load(\Yii::$app->request->post(),"Project");
            if($model->manageMember()){
                $project=$model->getProject();
                unset($project->userProjects);
                $ret['result']=true;
                foreach($project->userProjects as $userProject){
                    $ret['page'].=$this->renderPartial("/commons/_member2",["model"=>$userProject->userTeam]);
                }
            }
            return $ret;
        }
        $project = Project::findOne($id);
        $members=UserProject::find()->innerJoinWith(["user","project"])->where([
            "user_project.projectID"=>$id,
        ])->indexBy("userID")->all();
        $userTeams=UserTeam::find()->with(["subgroup"])->where(["teamID"=>$project->teamID])->andWhere("userID !=".\Yii::$app->user->id)->indexBy("userID")->all();
        $subgroups=UserTeam::getSubgroups($userTeams);
        $notSelectedGroupIDs=$this->getNotSelectedGroupIDs($members,$userTeams);
        return $this->render("members",[
            "project"=>$project,
            "members"=>$members,
            "userTeams"=>$userTeams,
            "subgroups"=>$subgroups,
            "notSelectedGroupIDs"=>$notSelectedGroupIDs,
        ]);
    }

    /**
     * 获取未选中小组的id数组
     * @param $members UserProject[]
     * @param $userTeams UserTeam[]
     * @return array
     */
    private function getNotSelectedGroupIDs($members,$userTeams){
        $ret=[];
        foreach($userTeams as $userID=>$userTeam){
            if($userTeam->subgroupID && !$members[$userID]){
                $ret[]=$userTeam->subgroupID;
            }
        }
        return array_unique($ret);
    }
    public function actionToggleSection($id,$sectionID,$page=false){
        $ret=["result"=>false,"id"=>$id,"sectionID"=>$sectionID];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new ProjectForm([
            "scenario"=>ProjectForm::TOGGLE_SECTION,
            "id"=>$id,
            "sectionID"=>$sectionID,
        ]);
        if($flag=$model->toggleSection()){
            $ret["result"]=true;
            $ret['has'] = $model->getProject()->hasSection($sectionID);
            $page and $ret['page'] = $this->getSectionPage($model);
        }
        return $ret;
    }
    public function actionToggleArchive($id){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new ProjectForm([
            "scenario"=>ProjectForm::TOGGLE_ARCHIVE,
            "id"=>$id,
        ]);
        if($flag=$model->toggleArchive()){
            $project=$model->getProject();
            $ret["result"]=true;
            $ret['archive'] = $model->getProject()->archive;
            $ret['teamUrl'] = Url::to(["team/projects", "id" => $project->teamID]);
        }
        return $ret;
    }

    public function actionEdit($id){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new ProjectForm([
            "scenario"=>ProjectForm::EDIT,
            "id"=>$id,
        ]);
        $model->load(\Yii::$app->request->post(),"Project");
        if($flag=$model->edit()){
            $project=$model->getProject();
            $ret["result"]=true;
            $ret['archive'] = $model->getProject()->archive;
            $ret['teamUrl'] = Url::to(["team/projects", "id" => $project->teamID]);
        }
        return $ret;
    }
    private function getSectionPage(ProjectForm $model){
        $sectionPage = "";
        switch($model->sectionID){
            case G::DISCUSS :
                $discusses = Discuss::find()->innerJoinWith(["relevance"])->where([
                    "relevance.prevModel"=>G::PROJECT,
                    "relevance.prevValue" => $model->id,
                    "archive"=>0,
                    "deleted" => G::DELETED_NOT,
                ])->orderBy("`order` desc,`update` desc")->limit(5)->all();
                $sectionPage = $this->renderPartial("_sectionDiscusses",["discusses"=>$discusses,"project"=>$model->getProject()]);break;
            case G::TASK :
                $items=$model->getProject()->getCommonItems()->orderBy("id desc")->all();
                $sectionPage = $this->renderPartial("_sectionTasks",["items"=>$items,"project"=>$model->getProject()]);break;
            case G::FILE :
                $dirs=Dir::find()
                    ->where(["projectID"=>$model->id, "parentID" =>0,])
                    ->orderBy("`update` desc")
                    ->limit(10)->all();
                $files=File::find()
                    ->where(["projectID"=>$model->id, "dirID" => 0,])
                    ->orderBy("`update` desc")
                    ->limit(10)->all();
                $multiples = array_reverse(G::sortByUpdate(array_merge($dirs, $files)));
                $multiples = array_slice($multiples, 0, 10);
                $sectionPage = $this->renderPartial("_sectionFiles",["multiples"=>$multiples,"project"=>$model->getProject()]);break;
            case G::DOC :
                $docs=Doc::find()
                    ->where(["projectID"=>$model->id])
                    ->orderBy("`update` desc")
                    ->limit(6)->all();
                $sectionPage = $this->renderPartial("_sectionDocs",["docs"=>$docs,"project"=>$model->getProject()]);break;
            case G::EVENT :
                $date=date("Y-m-d 00:00:00");
                $events=Event::find()
                    ->innerJoinWith(["calendar"])
                    ->where(["calendar.projectID"=>$model->id])
                    ->andWhere("event.start <= '$date' and '$date' <= event.end")
                    ->limit(4)->all();
                $sectionPage = $this->renderPartial("_sectionEvents",["events"=>$events,"project"=>$model->getProject()]);break;
            default : break;
        }
        return $sectionPage;
    }
    public function actionSort($id,$prevID=null){
        $model=new ProjectForm(["scenario"=>ProjectForm::SORT]);
        $model->id=$id;
        $model->prevID=$prevID;
        $ret=["result"=>false,"id"=>$id,"prevID"=>$prevID];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        if($model->sort()){
            $ret["result"]=true;
            $ret["sort"]=$model->getProject()->sort;
        }
        return $ret;
    }

    /**
     * 栏目顺序
     * @param $id
     * @param $sectionID
     * @param $prevSectionID
     * @return array
     */
    public function actionSectionSort($id,$sectionID,$prevSectionID=null){
        $args=["id"=>$id,"sectionID"=>$sectionID,"prevSectionID"=>$prevSectionID];
        $model=new ProjectForm();
        $model->scenario=ProjectForm::SECTION_SORT;
        $model->load($args,"");
        $ret=array_merge(["result"=>false],$args);
        \Yii::$app->response->format=Response::FORMAT_JSON;
        if($model->sectionSort()){
            $ret["result"]=true;
            $ret["section"]=$model->getProject()->section;
        }
        return $ret;
    }
} 