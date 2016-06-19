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
use app\models\Relevance;
use app\models\UserTeam;
use yii\helpers\ArrayHelper;

class EventForm extends Event{
    const CREATE="create";
    const EDIT="edit";
    const DESTROY="destroy";

    public $userIDs;//邀请其他人一起

    public function scenarios(){
        return [
            self::CREATE=>["calendarID","name","start","end","address",'userIDs'],
            self::EDIT=>["id","name","start","end","address","userIDs"],
            self::DESTROY=>["id"],
        ];
    }
    public function rules(){
        $rules=[
            ["id","exist"],
            ["calendarID","checkCalendarID"],
        ];
        return array_merge(parent::rules(),$rules);
    }
    public function beforeValidate(){
        if($flag=parent::beforeValidate()){
            if($this->scenario==self::CREATE){
                $this->filterUserIDs($this->calendar->teamID);
            }
            if($this->scenario==self::EDIT){
                $this->filterUserIDs($this->getEvent()->calendar->teamID);
            }
            $this->finishTime();
        }
        return $flag;
    }
    private function filterUserIDs($teamID){
        if($this->userIDs){
            $userTeams=UserTeam::findAll(["teamID"=>$teamID,"userID"=>$this->userIDs]);
            $this->userIDs = ArrayHelper::getColumn($userTeams, "userID");
        }else{
            $this->userIDs=[];
        }
    }
    private function finishTime(){
        if($this->start){
            $this->start=date("Y-m-d 00:00:00",strtotime($this->start));
        }
        if($this->end){
            $this->end=date("Y-m-d 23:59:59",strtotime($this->end));
        }
    }
    public function checkCalendarID($attribute){
        $calendar=$this->calendar;
        if(!$calendar){
            $this->addError($attribute, "日历不存在");
            return;
        }
        if(!UserTeam::findOne(["teamID" => $calendar->teamID, "userID" => \Yii::$app->user->id])){
            $this->addError($attribute, "你不是我们机组的吧");
            return;
        }
    }
    //--action
    public function create($validate=true){
        if($validate && !$this->validate()) return false;
        $event=new Event($this->attributes);
        $event->userID=\Yii::$app->user->id;
        if($flag=$event->save()){
            $this->_event=$event;
            $this->createRelevance();
            $this->fixEventUsers();
            $this->createOperation(Operation::ADD);
        }
        return $flag;
    }
    public function edit($validate=true){
        if($validate && !$this->validate()) return false;
        $event=$this->getEvent();
        $event->name=$this->name;
        $event->address=$this->address;
        $event->start=$this->start;
        $event->end=$this->end;
        if($flag=$event->save()){
            $this->fixEventUsers();
        }
        return $flag;
    }
    public function destroy($validate=true){
        if($validate && !$this->validate()) return false;
        $event=$this->getEvent();
        if($flag=$event->delete()){
            Relevance::deleteAll(["model"=>G::EVENT,"value"=>$event->id]);
            EventUser::deleteAll(["eventID" => $event->id]);
            Operation::deleteAll(["model"=>G::EVENT,"value"=>$event->id]);
            Comment::deleteAll(["model"=>G::EVENT,"value"=>$event->id]);
            Discuss::deleteAll(["model"=>G::EVENT,"value"=>$event->id]);
            Collect::deleteAll(["model"=>G::EVENT,"value"=>$event->id]);
        }
        return $flag;
    }
    //--sub action
    private function createRelevance(){
        $event=$this->getEvent();
        $relevance=new Relevance([
            'model' => G::EVENT,
            'value' => $event->id,
            'prevModel' => G::CALENDAR,
            'prevValue' => $event->calendarID,
            'teamID' => $event->calendar->teamID,
        ]);
        return $relevance->save();
    }
    private function fixEventUsers(){
        $event=$this->getEvent();
        $oldIDs=ArrayHelper::getColumn($event->eventUsers,"userID");
        $addIDs = array_diff($this->userIDs, $oldIDs);
        $deleteIDs = array_diff($oldIDs, $this->userIDs);
        if($addIDs){
            foreach($addIDs as $userID){
                $eventUser=new EventUser([
                    "eventID"=>$event->id,
                    "userID"=>$userID,
                ]);
                $eventUser->save();
            }
        }
        if($deleteIDs){
            EventUser::deleteAll(["eventID" => $event->id, "userID" => $deleteIDs]);
        }
        return true;
    }
    private function createOperation($type){
        $event=$this->getEvent();
        $textMap=[
            Operation::ADD=>"创建了日程",
        ];
        $operation=new Operation([
            'userID' => \Yii::$app->user->id,
            'type' => $type,
            'text' => $textMap[$type],
            'value' => $event->id,
            'model' => G::EVENT,
        ]);
        return $operation->save();
    }

    //--get
    public function loadValue(){
        $event=$this->getEvent();
        $this->attributes=$event->attributes;
        $this->userIDs=array();
        $this->userIDs = ArrayHelper::getColumn($event->eventUsers, "userID");
    }
    public function getNotSelectedSubgroupIDs(){
        if(!isset($this->userIDs)){
            $this->loadValue();
        }
        $event=$this->getEvent();
        $userTeams=UserTeam::find()->where([
            "teamID"=>$calendar->teamID,
        ])->andWhere(["not in","userID",$this->userIDs])->andWhere("subgroupID != 0")->all();
        return ArrayHelper::getColumn($userTeams, "subgroupID");
    }
    //--cache
    private $_event=false;

    /**
     * @return Event
     */
    public function getEvent(){
        if($this->_event===false){
            $this->_event = Event::findOne($this->id);
        }
        return $this->_event;
    }
    public function setEvent($event){
        $this->_event=$event;
        return $this;
    }
}