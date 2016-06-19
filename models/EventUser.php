<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "event_user".
 *
 * @property integer $id
 * @property integer $eventID
 * @property integer $userID
 */
class EventUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.event_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['eventID', 'userID'], 'required'],
            [['eventID', 'userID'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'eventID' => 'Event ID',
            'userID' => 'User ID',
        ];
    }
    //--get
    public function getUserCalendar(){
        return UserCalendar::findOne(["userID"=>$this->userID,"calendarID"=>$this->event->calendarID]);
    }
    public function getUserTeam(){
        return UserTeam::findOne(["userID"=>$this->userID,"teamID"=>$this->event->calendar->teamID]);
    }
    //--relation
    public function getUser(){
        return $this->hasOne(User::className(), ["id" => "userID"]);
    }
    public function getEvent(){
        return $this->hasOne(Event::className(), ["id" => "eventID"]);
    }
}
