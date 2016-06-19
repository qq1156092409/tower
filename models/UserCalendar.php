<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_calendar".
 *
 * @property integer $id
 * @property integer $userID
 * @property integer $calendarID
 */
class UserCalendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.user_calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'calendarID'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userID' => 'User ID',
            'calendarID' => 'Calendar ID',
        ];
    }

    //--get
    public function getUserTeam(){
        return UserTeam::findOne(["userID" => $this->userID, "teamID" => $this->calendar->teamID]);
    }
    //--relation
    public function getUser(){
        $this->hasOne(User::className(),["id"=>"userID"]);
    }
    public function getCalendar(){
        $this->hasOne(Calendar::className(),["id"=>"calendarID"]);
    }
}
