<?php

namespace app\controllers;


use app\models\Calendar;
use app\models\form\CalendarForm;
use app\models\Team;
use app\models\UserTeam;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\AccessControl;
use app\filters\UserTeamFilter;

class CalendarController extends Controller{
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
    public function actionCreate($teamID){
        $model=new CalendarForm(["scenario"=>CalendarForm::CREATE]);
        $model->teamID=$teamID;
        if(\Yii::$app->request->isPost){
            $ret=["result"=>false];
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $model->load(\Yii::$app->request->post(), "Calendar");
            if($model->create()){
                $ret["result"]=true;
                $ret['viewUrl'] = Url::to(["/team/calendars", "id" => $teamID]);
            }
            return $ret;
        }
        $team = Team::findOne($teamID);
        $userTeams=UserTeam::find()->with(["subgroup"])->where(["teamID"=>$teamID])->andWhere("userID !=".\Yii::$app->user->id)->all();
        $subgroups=UserTeam::getSubgroups($userTeams);
        return $this->render("calendarCreate",[
            "teamID"=>$teamID,
            "team"=>$team,
            "userTeams"=>$userTeams,
            "subgroups"=>$subgroups,
        ]);
    }
    public function actionEdit($id){
        $model=new CalendarForm([
            "scenario"=>CalendarForm::EDIT,
            "id"=>$id,
        ]);
        if(\Yii::$app->request->isPost){
            $ret=["result"=>false,"id"=>$id];
            \Yii::$app->response->format=Response::FORMAT_JSON;
            $model->load(\Yii::$app->request->post(), "Calendar");
            $model->load(\Yii::$app->request->post(),"Project");
            if($model->edit()){
                $ret["result"]=true;
                $ret['viewUrl'] = Url::to(["/team/calendars", "id" => $model->getCalendar()->teamID]);
            }
            return $ret;
        }
        $calendar=$model->getCalendar();
        $userTeams=UserTeam::find()->with(["subgroup"])->where(["teamID"=>$calendar->teamID])->andWhere("userID !=".\Yii::$app->user->id)->all();
        $subgroups=UserTeam::getSubgroups($userTeams);
        $model->loadValue();
        $notSelectedSubgroupIDs=$model->getNotSelectedSubgroupIDs();
        return $this->render("calendarEdit",[
            "model"=>$model,
            "calendar"=>$calendar,
            "userTeams"=>$userTeams,
            "subgroups"=>$subgroups,
            "notSelectedSubgroupIDs"=>$notSelectedSubgroupIDs,
        ]);
    }
    public function actionDestroy($id){
        $ret=["result"=>false,"id"=>$id];
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new CalendarForm(["scenario"=>CalendarForm::DESTROY]);
        $model->id = $id;
        if($model->destroy()){
            $ret["result"]=true;
        }
        return $ret;
    }
    public function actionColor($id){
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new CalendarForm(["scenario"=>CalendarForm::COLOR]);
        $model->id = $id;
        $model->load(\Yii::$app->request->post(),"Calendar");
        $ret=["result"=>false,"id"=>$id,"color"=>$model->color,"oldColor"=>$model->getCalendar()->color];
        if($model->color()){
            $ret["result"]=true;
        }
        return $ret;
    }
}