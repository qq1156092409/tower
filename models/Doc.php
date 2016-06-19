<?php

namespace app\models;

use app\helpers\TimeHelper;
use app\models\multiple\G;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "doc".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property integer $userID
 * @property integer $projectID
 * @property integer $deleted
 * @property string $update
 * @property string $create
 */
class Doc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.doc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'projectID'], 'required'],
            [['text'], 'string'],
            [['userID', 'projectID', 'deleted'], 'integer'],
            [['update', 'create'], 'safe'],
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
            'text' => 'Text',
            'userID' => 'User ID',
            'projectID' => 'Project ID',
            'deleted' => 'Deleted',
            'update' => 'Update',
            'create' => 'Create',
        ];
    }

    //--get
    public function getViewUrl(){
        return Url::to(["/doc","id"=>$this->id]);
    }
    public function getDisableUrl(){
        return Url::to(["/doc/disable","id"=>$this->id]);
    }
    public function getEditUrl(){
        return Url::to(["/doc/edit","id"=>$this->id]);
    }
    public function getTeamID(){
        return $this->project->teamID;
    }
    public function getFuzzyUpdate(){
        return TimeHelper::getFuzzyTime($this->update);
    }

    /**
     * @return Doc|null
     */
    public function getLastDisableOperation(){
        return Operation::find()->where(["model"=>G::DOC,"value"=>$this->id])->orderBy("id desc")->one();
    }
    //--relation
    public function getProject(){
        return $this->hasOne(Project::className(), ["id" => "projectID"]);
    }
    public function getUser(){
        return $this->hasOne(User::className(), ["id" => "userID"]);
    }
    public function getOperations(){
        return $this->hasMany(Operation::className(), ["value" => "id"])->onCondition("model=".G::DOC);
    }
    public function getRelevance(){
        return $this->hasOne(Relevance::className(),["value"=>"id"])->onCondition("model =" . G::DOC);
    }
}
