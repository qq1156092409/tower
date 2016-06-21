<?php

namespace app\models;

use Yii;
use yii\base\Security;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $nickname
 * @property string $accessToken
 * @property string $authKey
 *
 * @property string $activeName
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base.user';
    }
    public static function getDb(){
        return Yii::$app->baseDb;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'password'], 'required'],
            [['name', 'nickname'], 'string', 'max' => 256],
            [['password', 'accessToken', 'authKey'], 'string', 'max' => 64],
            [['accessToken'], 'unique'],
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
            'password' => 'Password',
            'nickname' => 'Nickname',
            'accessToken' => 'Access Token',
            'authKey' => 'Auth Key',
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * Finds an identity by the given secrete token.
     * @param string $token the secrete token
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(["accessToken"=>$token]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    //--event
    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->authKey = (new Security)->generateRandomKey();
            }
            return true;
        }
        return false;
    }
    //--get
    public function getActiveName(){
        return $this->nickname?:$this->name;
    }
    public function getLastUserTeam(){
        return $this->hasOne(UserTeam::className(),["userID"=>"id"])->orderBy("activeTime DESC");
    }
    public function getUnFinishTasks(){
        return $this->getTasks()->onCondition("status !=".Task::FINISH);
    }
    public function getType(){
        return $this->user2->type;
    }
    //--relations
    public function getUserTeams(){
        return $this->hasMany(UserTeam::className(), ["userID" => "id"])->inverseOf("user");
    }
    public function getTeams(){
        return $this->hasMany(Team::className(),["creatorID"=>"id"]);
    }
    public function getTasks(){
        return $this->hasMany(Task::className(),["userID"=>"id"])->inverseOf("user");
    }
    public function getCreateTasks(){
        return $this->hasMany(Task::className(),["creatorID"=>"id"])->inverseOf("user");
    }
    public function getUserProjects(){
        return $this->hasMany(UserProject::className(), ["userID" => "id"]);
    }
    public function getUserCalendars(){
        return $this->hasMany(UserCalendar::className(), ["userID" => "id"]);
    }
    public function getUserComments(){
        return $this->hasMany(UserComment::className(), ["userID" => "id"]);
    }
    public function getItems(){
        return $this->hasMany(Item::className(),["userID"=>"id"])->inverseOf("user");
    }
    public function getUserInfo(){
        return $this->hasOne(UserInfo::className(),["userID"=>"id"]);
    }
}
