<?php

namespace app\models;

use app\helpers\QrHelper;
use Yii;
use yii\helpers\Security;
use yii\helpers\Url;

/**
 * This is the model class for table "team".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $creatorID
 * @property string $create
 *
 * @property string $activeCode
 * @property string $wechatQr       微信申请加入二维码
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.team';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creatorID'], 'integer'],
            [['create'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [['code'], 'string', 'max' => 32],
            [['code'], 'unique']
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
            'code' => 'Code',
            'creatorID' => 'Creator ID',
            'create' => 'Create',
        ];
    }

    //--action
    public function resetCode(){
        $this->code = Security::generateRandomKey();
        return $this->save();
    }
    //--get
    public function getActiveCode(){
        if(!$this->code){
            $this->code = Security::generateRandomKey();
            $this->save();
        }
        return $this->code;
    }
    public function getWechatQr(){
        $message=Url::to(["team/apply","code"=>$this->activeCode,"type"=>"wechat"],"http");//todo replace me
        $fileName="team_apply_".$this->id.'.png';
        return QrHelper::png($message,$fileName);
    }
    public function getTeamID(){
        return $this->id;
    }
    //--relation
    public function getProjects(){
        return $this->hasMany(Project::className(), ["teamID" => "id"]);
    }
    public function getUserTeams(){
        return $this->hasMany(UserTeam::className(), ["teamID" => "id"])->inverseOf("team");
    }
    public function getUsers(){
        return $this->hasMany(User::className(),['id'=>"userID"])->via("userTeams");
    }
    public function getSubgroups(){
        return $this->hasMany(Subgroup::className(), ["teamID" => "id"])->inverseOf("team");
    }
    public function getOperations(){
        return $this->hasMany(Operation::className(), ["teamID" => "id"])->inverseOf("team");
    }
    public function getCreator(){
        return $this->hasOne(User::className(),["id"=>"creatorID"]);
    }
}
