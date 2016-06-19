<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_project".
 *
 * @property integer $id
 * @property integer $userID
 * @property integer $projectID
 */
class UserProject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.user_project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'projectID'], 'required'],
            [['userID', 'projectID'], 'integer']
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
            'projectID' => 'Project ID',
        ];
    }

    //--action
    public static function create($attributes){
        $userProject=new UserProject();
        $userProject->load($attributes, "");
        if($old = self::findOne(["userID" => $userProject->userID, "projectID" => $userProject->projectID])){
            return $old;
        }
        if($flag=$userProject->save()){
            //other operations
        }
        return $flag?$userProject:false;
    }
    //--get
    public function getUserTeam(){
        return UserTeam::findOne(["userID" => $this->userID, "teamID" => $this->project->teamID]);
    }
    //--relation
    public function getUser(){
        return $this->hasOne(User::className(), ["id" => "userID"]);
    }
    public function getProject(){
        return $this->hasOne(Project::className(), ["id" => "projectID"]);
    }
}
