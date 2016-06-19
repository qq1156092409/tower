<?php

namespace app\models;

use app\models\multiple\G;
use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $model
 * @property integer $value
 * @property string $text
 * @property string $create
 * @property integer $userID
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model', 'value', 'text', 'create','userID'], 'required'],
            [['model', 'value','userID'], 'integer'],
            [['text'], 'string'],
            [['create'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Model',
            'value' => 'Value',
            'text' => 'Text',
            'create' => 'Create',
            'userID'=>'user ID'
        ];
    }

    //--action
//    public static function create($attributes){
//        $comment=new Comment();
//        $comment->load($attributes, "");
//        $comment->create=date("Y-m-d H:i:s");
//        if($flag=$comment->save()){
//            $comment->createOperation();
//            $comment->createDiscuss();
//        }
//        return $flag?$comment:false;
//    }
    public function edit($text){
        $this->text=$text;
        return $this->save();
    }
    public function destroy(){
        if($flag=$this->delete()){
            Operation::deleteAll(["type"=>Operation::COMMENT,"withID"=>$this->id]);
        }
        return $flag;
    }
    private function createOperation(){
        if(!$this->id){
            return false;
        }
        $text = "回复了" . G::getContent($this->model, "chinese");
        return Operation::create([
            'userID' => $this->userID,
            'type' =>Operation::COMMENT,
            'text' => $text,
            'model' => $this->model,
            'value' => $this->value,
            'withID' =>$this->id,
        ]);
    }
    private function createDiscuss(){
        return Discuss::create([
            "model"=>$this->model,
            "value"=>$this->value,
        ]);
    }
    //--get
    public function getActiveText($length=100){
        $text=strip_tags($this->text);
        if($length&&strlen($text)>$length){
            $text=substr($text,0,$length)."...";
        }
        return $text;
    }
    public function countUserComment(){
        return count($this->userComments);
    }
    public function getMyUserComment(){
        return UserComment::findOne(["userID" => Yii::$app->user->id, "commentID" => $this->id]);
    }
    //--relation
    public function getTarget(){
        $class = G::transfer($this->model);
        return $class?$this->hasOne($class, ["id" => "value"]):null;
    }
    public function getUser(){
        return $this->hasOne(User::className(), ["id" => "userID"]);
    }
    public function getOperation(){
        return $this->hasOne(Operation::className(),["withID"=>"id"])->onCondition("type = ".Operation::COMMENT);
    }
    public function getRelevance(){
        return $this->hasOne(Relevance::className(), ["model" => "model", "value" => "value"]);
    }
    public function getDiscuss(){
        return $this->hasOne(Discuss::className(), ["model" => "model", "value" => "value"]);
    }
    public function getUserComments(){
        return $this->hasMany(UserComment::className(), ["commentID" => "id"]);
    }
}
