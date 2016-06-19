<?php
namespace app\models\form;

use app\models\Calendar;
use app\models\Collect;
use app\models\Comment;
use app\models\Discuss;
use app\models\Event;
use app\models\EventUser;
use app\models\multiple\G;
use app\models\Operation;
use app\models\UserCalendar;
use app\models\UserTeam;
use yii\helpers\ArrayHelper;
use yii\web\UserEvent;

class CalendarForm extends Calendar{
    const CREATE = "create";
    const EDIT = "edit";
    const COLOR = "color";
    const DESTROY = "destroy";

    public $userIDs;//日历对谁可见

    public function rules(){
        $rules=[
            [["name","userIDs"],"required"],
            ["id","exist"],
            ["id","checkID"],
            ["teamID","checkTeamID"],
        ];
        return array_merge(parent::rules(), $rules);
    }
    public function scenarios(){
        return [
            self::CREATE=>["teamID","name","color","userIDs"],
            self::EDIT=>["id","name","color","userIDs"],
            self::COLOR=>["id","color"],
            self::DESTROY=>["id"],
        ];
    }
    public function beforeValidate(){
        $this->filterUserIDs();
        return parent::beforeValidate();
    }
    public function filterUserIDs(){
        if ($this->userIDs) {
            $userTeams=[];
            if($this->scenario==self::CREATE){
                $userTeams = UserTeam::findAll(["teamID" => $this->teamID, "userID" => $this->userIDs]);
            }
            if($this->scenario==self::EDIT){
                $userTeams = UserTeam::findAll(["teamID" => $this->getCalendar()->teamID, "userID" => $this->userIDs]);
            }
            if($userTeams){
                $this->userIDs=ArrayHelper::getColumn($userTeams,"userID");
                return;
            }
        }
        $this->userIDs=array();
    }
    public function checkID($attribute){
        $calendar=$this->getCalendar();
        if (!UserTeam::findOne(["teamID" => $calendar->teamID, "userID" => \Yii::$app->user->id])) {
            $this->addError($attribute, "您不是我们机组的吧");
        }
    }
    public function checkTeamID($attribute){
        if (!UserTeam::findOne(["teamID" => $this->teamID, "userID" => \Yii::$app->user->id])) {
            $this->addError($attribute, "您不是我们机组的吧");
        }
    }
    //--action
    public function create($validate=true){
        if($validate && !$this->validate()) return false;
        $calendar=new Calendar($this->attributes);
        $calendar->projectID=0;
        if($flag=$calendar->save()){
            $this->_calendar=$calendar;
            $this->fixUserCalendars();
        }
        return $flag;
    }
    public function edit($validate=true){
        if($validate && !$this->validate()) return false;
        $calendar=$this->getCalendar();
        $calendar->name=$this->name;
        $calendar->color=$this->color;
        if($flag=$calendar->save()){
            $this->fixUserCalendars();
        }
        return $flag;
    }
    public function color($validate=true){
        if($validate && !$this->validate()) return false;
        $calendar=$this->getCalendar();
        $calendar->color=$this->color;
        if($flag=$calendar->save()){
            //other
        }
        return $flag;
    }
    public function destroy($validate=true){
        if($validate && !$this->validate()) return false;
        $calendar=$this->getCalendar();
        if($flag=$calendar->delete()){
            //other
            UserCalendar::deleteAll(["calendarID" => $calendar->id]);
            if($events=$calendar->events){
                $ids=ArrayHelper::getColumn($events, "id");
                Operation::deleteAll(["model" => G::EVENT, "value" => $ids]);
                Comment::deleteAll(["model" => G::EVENT, "value" => $ids]);
                Collect::deleteAll(["model" => G::EVENT, "value" => $ids]);
                Discuss::deleteAll(["model" => G::EVENT, "value" => $ids]);
                EventUser::deleteAll(["eventID" => $ids]);
                Event::deleteAll(["calendarID" => $calendar->id]);
            }
        }
        return $flag;
    }
    private function fixUserCalendars(){
        $userIDs=$this->userIDs;
        $userIDs[]=\Yii::$app->user->id;
        $calendar=$this->getCalendar();
        $userCalendars=$calendar->userCalendars;
        $oldUserIDs = ArrayHelper::getColumn($userCalendars, "userID");
        $addIDs = array_diff($userIDs, $oldUserIDs);
        $deleteIDs = array_diff($oldUserIDs, $userIDs);
        if($addIDs){
            foreach($addIDs as $userID){
                $userCalendar=new UserCalendar([
                    "userID"=>$userID,
                    "calendarID"=>$calendar->id,
                ]);
                $userCalendar->save();
            }
        }
        $deleteIDs and UserCalendar::deleteAll(["calendarID" => $calendar->id, "userID" => $deleteIDs]);
        return true;
    }
    public function loadValue(){
        $calendar=$this->getCalendar();
        $this->attributes=$calendar->attributes;
        $this->userIDs=array();
        $this->userIDs = ArrayHelper::getColumn($calendar->userCalendars, "userID");
    }
    public function getNotSelectedSubgroupIDs(){
        if(!isset($this->userIDs)){
            $this->loadValue();
        }
        $calendar=$this->getCalendar();
        $userTeams=UserTeam::find()->where([
            "teamID"=>$calendar->teamID,
        ])->andWhere(["not in","userID",$this->userIDs])->andWhere("subgroupID != 0")->all();
        return ArrayHelper::getColumn($userTeams, "subgroupID");
    }

    /**
     * @var Calendar
     */
    private $_calendar=false;
    public function getCalendar(){
        if($this->_calendar===false){
            $this->_calendar = Calendar::findOne($this->id);
        }
        return $this->_calendar;
    }
}