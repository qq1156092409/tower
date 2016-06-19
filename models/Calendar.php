<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar".
 *
 * @property integer $id
 * @property string $name
 * @property integer $color
 * @property integer $teamID
 * @property integer $projectID
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['color', 'teamID', 'projectID'], 'integer'],
            [['teamID'], 'required'],
            [['name'], 'string', 'max' => 256]
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
            'color' => 'Color',
            'teamID' => 'Team ID',
            'projectID' => 'Project ID',
        ];
    }

    //--get
    public function getActiveName(){
        return $this->name?$this->name:$this->project->name;
    }
    //--relation
    public function getTeam(){
        return $this->hasOne(Team::className(),["id"=>"teamID"]);
    }
    public function getProject(){
        return $this->hasOne(Project::className(), ["id" => "projectID"]);
    }
    public function getEvents(){
        return $this->hasMany(Event::className(),["calendarID"=>"id"]);
    }
    public function getUserCalendars(){
        return $this->hasMany(UserCalendar::className(),["calendarID"=>"id"]);
    }
}
