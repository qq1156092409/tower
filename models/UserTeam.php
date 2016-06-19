<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_team".
 *
 * @property integer $id
 * @property integer $userID
 * @property integer $teamID
 * @property integer $type
 * @property string $activeTime
 * @property integer $subgroupID
 */
class UserTeam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.user_team';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'teamID', 'type'], 'required'],
            [['userID', 'teamID', 'type', 'subgroupID'], 'integer'],
            [['activeTime'], 'safe']
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
            'teamID' => 'Team ID',
            'type' => 'Type',
            'activeTime' => 'Active Time',
            'subgroupID' => 'Subgroup ID',
        ];
    }

    //--attribute
    const SUPER_ADMIN=1;//超级管理员
    const ADMIN=2;//管理员
    const MEMBER=3;//成员
    const VISITOR=4;//游客
    public static $types=[
        self::SUPER_ADMIN=>["id"=>self::SUPER_ADMIN,"name"=>"super-admin","chinese"=>"超级管理员"],
        self::ADMIN=>["id"=>self::ADMIN,"name"=>"admin","chinese"=>"管理员"],
        self::MEMBER=>["id"=>self::MEMBER,"name"=>"member","chinese"=>"成员"],
        self::VISITOR=>["id"=>self::VISITOR,"name"=>"visitor","chinese"=>"游客"],
    ];

    //--other
    /**
     * 加入的小组
     * @param UserTeam[] $userTeams
     * @return Subgroup[]
     */
    public static function getSubgroups(array $userTeams){
        $subgroups=[];
        foreach($userTeams as $userTeam){
            $userTeam->subgroup and $subgroups[$userTeam->subgroupID]=$userTeam->subgroup;
        }
        return $subgroups;
    }

    //--action
    public static function upsert($attributes){
        $query=[
            "userID" => $attributes["userID"],
            "teamID" => $attributes["teamID"]
        ];
        $userTeam=self::findOne($query);
        $userTeam or $userTeam=new UserTeam();
        $userTeam->load($attributes,"");
        $userTeam->activeTime=date("Y-m-d H:i:s");
        return $userTeam->save()?$userTeam:false;
    }
    public function move($subgroupID){
        if($this->subgroupID==$subgroupID){
            return true;
        }
        if($subgroupID>0){
            $subgroup = Subgroup::findOne($subgroupID);
            if($subgroup->teamID!==$this->teamID){
                return false;
            }
        }
        $this->subgroupID=$subgroupID;
        return $this->save();
    }
    //--get
    /**
     * 获取身份名称
     * @param string $column
     * @return string
     */
    public function getTypeName($column="chinese"){
        return UserTeam::$types[$this->type][$column];
    }
    public function isAdmin(){
        return in_array($this->type,[self::ADMIN,self::SUPER_ADMIN]);
    }
    //--relation
    public function getUser(){
        return $this->hasOne(User::className(),["id"=>"userID"]);
    }
    public function getTeam(){
        return $this->hasOne(Team::className(), ["id" => "teamID"]);
    }
    public function getSubgroup(){
        return $this->hasOne(Subgroup::className(),["id"=>"subgroupID"]);
    }
}
