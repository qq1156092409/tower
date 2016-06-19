<?php

namespace app\models;

use app\helpers\TimeHelper;
use app\models\multiple\G;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property string $name
 * @property string $start
 * @property string $end
 * @property string $address
 * @property integer $userID
 * @property integer $calendarID
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'start', 'end', 'userID', 'calendarID'], 'required'],
            [['start', 'end'], 'safe'],
            [['userID', 'calendarID'], 'integer'],
            [['name', 'address'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'start' => 'Start',
            'end' => 'End',
            'address' => 'Address',
            'userID' => 'User ID',
            'calendarID' => 'Calendar ID',
        ];
    }

    //--get
    public function getInviteUserName(){
        $all = [];
        if($this->eventUsers){
            foreach($this->eventUsers as $eventUser){
                $eventUser->user and $all[]=$eventUser->user->activeName;
            }
        }
        return implode(",", $all);
    }
    /**
     * 获取所有用户
     * 自身+邀请的人
     * @return User[]
     */
    public function getAllUsers(){
        $all = [$this->user];
        if($this->eventUsers){
            foreach($this->eventUsers as $eventUser){
                $eventUser->user and $all[]=$eventUser->user;
            }
        }
        return $all;
    }
    public function getViewUrl(){
        return Url::to(["/event", "id" => $this->id]);
    }
    public function getTeamID(){
        return $this->calendar->teamID;
    }
    public function getFuzzyStart(){
        return TimeHelper::getFuzzyTime($this->start);
    }
    public function getFuzzyEnd(){
        return TimeHelper::getFuzzyTime($this->end);
    }
    //--relation
    public function getEventUsers(){
        return $this->hasMany(EventUser::className(), ["eventID" => "id"]);
    }
    public function getUser(){
        return $this->hasOne(User::className(), ["id" => "userID"]);
    }
    public function getOperations(){
        return $this->hasMany(Operation::className(), ["value" => "id"])->onCondition("model=".G::EVENT);
    }
    public function getCalendar(){
        return $this->hasOne(Calendar::className(),["id"=>"calendarID"]);
    }
    public function getRelevance(){
        return $this->hasOne(Relevance::className(),["value"=>"id"])->onCondition("model =" . G::EVENT);
    }
}
