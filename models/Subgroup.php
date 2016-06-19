<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subgroup".
 *
 * @property integer $id
 * @property string $name
 * @property integer $teamID
 * @property integer $sort
 */
class Subgroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.subgroup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'teamID'], 'required'],
            [['teamID','sort'], 'integer'],
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
            'teamID' => 'Team ID',
            'sort' => 'Sort',
        ];
    }

    //--event
    public function beforeSave($insert){
        $flag = parent::beforeSave($insert);
        if(!isset($this->sort) && $this->teamID){
            $max=Subgroup::find()->where(["teamID"=>$this->teamID])->max("sort");
            if($max){
                $this->sort=$max+1;
            }else{
                $this->sort=1;
            }
        }
        $this->loadDefaultValues();
        return $flag;
    }
    //--relations
    public function getTeam(){
        return $this->hasOne(Team::className(),["id"=>"teamID"]);
    }
    public function getUserTeams(){
        return $this->hasMany(UserTeam::className(),["subgroupID"=>"id"]);
    }
    public function getUsers(){
        return $this->hasMany(User::className(),["id"=>"userID"])->via("UserTeams");
    }
}
