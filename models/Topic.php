<?php

namespace app\models;

use app\helpers\TimeHelper;
use app\models\multiple\G;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "topic".
 *
 * @property integer $id
 * @property integer $projectID
 * @property string $name
 * @property string $text
 * @property integer $userID
 * @property string $create
 * @property integer $deleted
 */
class Topic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.topic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectID', 'name', 'userID'], 'required'],
            [['projectID', 'userID', 'deleted'], 'integer'],
            [['text'], 'string'],
            [['create'], 'safe'],
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
            'projectID' => 'Project ID',
            'name' => 'Name',
            'text' => 'Text',
            'userID' => 'User ID',
            'create' => 'Create',
            'deleted' => 'Deleted',
        ];
    }

    //--action
    /**
     * 在创建记录是时加载默认值
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert){
        $flag=parent::beforeSave($insert);
        if($insert){
            $this->loadDefaultValues();
            $this->create=date("Y-m-d H:i:s");
        }
        return $flag;
    }

    public function enable($userID){
        if($this->deleted==G::DELETED_NOT){
            return true;
        }
        $this->deleted=G::DELETED_NOT;
        if($flag=$this->save()){
            $discuss=$this->discuss and $discuss->enable();
            $this->createOperation(Operation::ENABLE,$userID);
        }
        return $flag;
    }
    public function disable($userID){
        if($this->deleted==G::DELETED){
            return true;
        }
        $this->deleted=G::DELETED;
        if($flag=$this->save()){
            $discuss=$this->discuss and $discuss->disable();
            $this->createOperation(Operation::DISABLE,$userID);
        }
        return $flag;
    }
    public function toggleEnable($userID){
        if($this->deleted==G::DELETED){
            return $this->enable($userID);
        }else{
            return $this->disable($userID);
        }
    }
    public function edit($name,$text,$userID){
        $this->name=$name;
        $this->text=$text;
        if($flag=$this->save()){
            $this->createOperation(Operation::EDIT,$userID);
        }
        return $flag;
    }
    public function move($projectID,$userID){
        $this->projectID=$projectID;
        if($flag=$this->save()){
            $this->createOperation(Operation::MOVE,$userID);
        }
        return $flag;
    }
    private function createOperation($type,$userID){
        $textMap=[
            Operation::ADD=>"创建了讨论",
            Operation::ENABLE=>"恢复了讨论",
            Operation::DISABLE=>"删除了讨论",
            Operation::EDIT=>"编辑了讨论",
            Operation::MOVE=>"移动了讨论",
        ];
        return Operation::create([
            'userID' => $userID,
            'type' => $type,
            'text' =>$textMap[$type],
            'value' => $this->id,
            'model' => G::transfer(self::className()),
        ]);
    }
    private function createDiscuss(){
        return Discuss::create([
            'projectID' =>$this->projectID,
            'model' => G::transfer(self::className()),
            'value' => $this->id,
        ]);
    }
    //--get
    public function getFuzzyCreate(){
        return TimeHelper::getFuzzyTime($this->create);
    }
    public function getViewUrl(){
        return Url::to(["/topic","id"=>$this->id]);
    }
    public function getDisableUrl(){
        return Url::to(["/topic/disable","id"=>$this->id]);
    }
    public function getTeamID(){
        return $this->project->teamID;
    }
    public function getLastDisableOperation(){
        return Operation::find()->where(["model"=>G::TOPIC,"value"=>$this->id])->orderBy("id desc")->one();
    }
    //--relation
    public function getProject(){
        return $this->hasOne(Project::className(),["id"=>"projectID"]);
    }
    public function getUser(){
        return $this->hasOne(User::className(), ["id" => "userID"]);
    }
    public function getOperations(){
        return $this->hasMany(Operation::className(),["value"=>"id"])->onCondition("model =".G::TOPIC);
    }
    public function getComments(){
        return $this->hasMany(Comment::className(),["value"=>"id"])->onCondition("model =".G::TOPIC);
    }
    public function getDiscuss(){
        return $this->hasOne(Discuss::className(),["value"=>"id"])->onCondition("model =".G::TOPIC);
    }
    public function getRelevance(){
        return $this->hasOne(Relevance::className(),["value"=>"id"])->onCondition("model =" . G::TOPIC);
    }
}
