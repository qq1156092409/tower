<?php

namespace app\controllers;

use app\models\Calendar;
use app\models\Collect;
use app\models\form\EventForm;
use app\models\multiple\G;
use app\models\Team;
use app\models\UserTeam;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\Controller;
use app\models\Event;

class EventController extends Controller{
    public function actionIndex($id){
        $event=Event::findOne($id);
        $this->validate($event);
        $isCollect = Collect::isCollect(\Yii::$app->user->id, G::EVENT, $id);
        return $this->render("event",[
            "event"=>$event,
            "teamID"=>$event->calendar->teamID,
            "operations"=>$event->operations,
            "isCollect"=>$isCollect,
        ]);
    }
    private function validate($event){
        if(!$event){
            throw new NotFoundHttpException("他已经飞走了");
        }
    }
    public function actionCreate($teamID,$calendarID=null){
        $model=new EventForm(["scenario"=>EventForm::CREATE]);
        if(\Yii::$app->request->isPost){
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $ret=['result'=>false];
            $model->load(\Yii::$app->request->post(),"Event");
            $model->load(\Yii::$app->request->post(),"Project");
            if($model->create()){
                $ret["result"]=true;
                $ret['viewUrl']=Url::to(["/event","id"=>$model->getEvent()->id]);
            }
            return $ret;
        }
        $team = Team::findOne($teamID);
        $calendars=Calendar::findAll(["teamID"=>$teamID]);
        $commonCalendars = $projectCalendars = [];
        foreach($calendars as $calendar){
            if($calendar->projectID){
                $projectCalendars[]=$calendar;
            }else{
                $commonCalendars[]=$calendar;
            }
        }
        $calendar = Calendar::findOne($calendarID);
        $userIDs = ArrayHelper::getColumn($calendar->userCalendars, "userID");
        $userTeams=UserTeam::find()->with(["subgroup"])->where(["teamID"=>$team->id,"userID"=>$userIDs])->andWhere("userID !=".\Yii::$app->user->id)->all();
        $subgroups=UserTeam::getSubgroups($userTeams);
        return $this->render("eventCreate",[
            "form"=>$model,
            "projectCalendars"=>$projectCalendars,
            "commonCalendars"=>$commonCalendars,
            "calendarID"=>$calendarID,
            "teamID"=>$teamID,
            "team"=>$team,
            "userTeams"=>$userTeams,
            "subgroups"=>$subgroups,
        ]);
    }
    public function actionEdit($id){
        if(\Yii::$app->request->isPost){
            $model=new EventForm(["scenario"=>EventForm::EDIT,"id"=>$id]);
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $ret=['result'=>false,"id"=>$id];
            $model->load(\Yii::$app->request->post(),"Event");
            $model->load(\Yii::$app->request->post(),"Project");
            if($model->edit()){
                $ret["result"]=true;
                $ret['viewUrl']=Url::to(["/event","id"=>$model->getEvent()->id]);
            }
            return $ret;
        }
        $event = Event::findOne($id);
        $calendars=Calendar::findAll(["teamID"=>$event->calendar->teamID]);
        $commonCalendars = $projectCalendars = [];
        foreach($calendars as $calendar){
            if($calendar->projectID){
                $projectCalendars[]=$calendar;
            }else{
                $commonCalendars[]=$calendar;
            }
        }
        $team = Team::findOne($event->calendar->teamID);
        $userIDs = ArrayHelper::getColumn($event->calendar->userCalendars, "userID");
        $userTeams=UserTeam::find()->with(["subgroup"])->where(["teamID"=>$team->id,"userID"=>$userIDs])->andWhere("userID !=".\Yii::$app->user->id)->all();
        $subgroups=UserTeam::getSubgroups($userTeams);
        return $this->render("eventEdit",[
            "event"=>$event,
            "projectCalendars"=>$projectCalendars,
            "commonCalendars"=>$commonCalendars,
            "userTeams"=>$userTeams,
            "subgroups"=>$subgroups,
        ]);
    }

    public function actionDestroy($id){
        $model=new EventForm([
            "scenario"=>EventForm::DESTROY,
            "id"=>$id,
        ]);
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        if($model->destroy()){
            $ret['result']=true;
            $ret['jumpUrl']=Url::to(["/team/calendars","id"=>$model->getEvent()->calendar->teamID]);
        }
        return $ret;
    }
} 