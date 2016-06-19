<?php

namespace app\models;

use app\helpers\TimeHelper;
use app\models\multiple\G;
use Yii;
use yii\helpers\Url;


/**
 * This is the model class for table "operation".
 *
 * @property integer $id
 * @property integer $userID
 * @property integer $type
 * @property string $text
 * @property integer $value
 * @property string $create
 * @property integer $model
 * @property integer $withID
 */
class Operation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.operation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'type', 'text', 'value'], 'required'],
            [['userID', 'type', 'value', 'model', 'withID'], 'integer'],
            [['create'], 'safe'],
            [['text'], 'string', 'max' => 256]
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
            'type' => 'Type',
            'text' => 'Text',
            'value' => 'Value',
            'create' => 'Create',
            'model' => 'Model',
            'withID' => 'With ID',
        ];
    }

    //--attribute
    const ADD=1;        //新增
    const RUNNING=2;    //进行
    const PAUSE=3;      //暂停
    const FINISH=4;     //完成
    const REOPEN=5;     //完成后重新打开
    const DISABLE=6;    //删除
    const ENABLE=7;     //恢复
    const ASSIGN=8;     //指派
    const DUE_CHANGE=9; //修改截止时间
    const RENAME=10;    //重命名
    const COMMENT=11;   //评论
    const MOVE=12;      //移动
    const ARCHIVE=13;   //归档
    const UN_ARCHIVE=14;    //不归档
    const EDIT=15;      //编辑

    public static $types=[
        self::ADD=>["id"=>self::ADD,"name"=>"add","chinese"=>"添加"],
        self::RUNNING=>"running",
        self::PAUSE=>"pause",
        self::FINISH=>"close",
        self::REOPEN=>"open",
        self::DISABLE=>"del",
        self::ENABLE=>"recover",
        self::ASSIGN=>"assign",
        self::DUE_CHANGE=>"due_at_changed",
        self::RENAME=>"content_changed",
        self::MOVE=>"move_to_project",
        self::ARCHIVE=>"archive",
        self::UN_ARCHIVE=>"unarchive",
        self::EDIT=>"edit",
    ];
    //--other
    /**
     * 按日期划分
     * @param Operation[] $operations
     * @return array
     */
    public static function divideDay(array $operations){
        $newOperations=[];
        foreach($operations as $operation){
            $newOperations[date("Y-m-d",strtotime($operation->create))][]=$operation;
        }
        return $newOperations;
    }

    /**
     * 按“create-prev”划分
     * @param Operation[] $operations
     * @return Operation[]
     */
    public static function divideCreatePrev(array $operations){
        $newOperations=[];
        foreach($operations as $operation){
            $relevance=$operation->relevance;
            $newOperations[date("Y-m-d",strtotime($operation->create))][$relevance->prevModel.'-'.$relevance->prevValue][]=$operation;
        }
        return $newOperations;
    }
    public static function parseText($text){
//        $text="abc{time:2015-3-3 10:10:10}def{time:2015-4-4 14:4:4}gh";
        preg_match_all('/{time:[^}]*}/',$text,$matches);
        $replaces=[];
        foreach($matches[0] as $match){
            preg_match("/\d.*\d/",$match,$timeStr);
            $replaces[$match]=date("m月d日",strtotime($timeStr[0]));
        }
        return strtr($text,$replaces);
    }

    //--action
    public static function create($attributes){
        $operation=new Operation();
        $operation->load($attributes,"");
        $operation->create=date("Y-m-d H:i:s");
        return $operation->save()?$operation:false;
    }
    //--get
    public function getActiveText(){
        return self::parseText($this->text);
    }
    public function getFuzzyCreate(){
        return TimeHelper::getFuzzyTime($this->create);
    }
    /**
     * icon样式名称
     * @return string
     */
    public function getTypeName(){
        $typeNames=[
            self::ADD=>"add",
            self::RUNNING=>"running",
            self::PAUSE=>"pause",
            self::FINISH=>"close",
            self::REOPEN=>"open",
            self::DISABLE=>"del",
            self::ENABLE=>"recover",
            self::ASSIGN=>"assign",
            self::DUE_CHANGE=>"due_at_changed",
            self::RENAME=>"content_changed",
            self::MOVE=>"move_to_project",
            self::ARCHIVE=>"archive",
            self::UN_ARCHIVE=>"unarchive",
            self::EDIT=>"edit",
        ];
        return $typeNames[$this->type];
    }
    public function getTarget(){
        $class = G::transfer($this->model);
        return $class?$this->hasOne($class, ["id" => "value"]):null;
    }
    public function getPrev(){
        $class = G::transfer($this->prevModel);
        return $class?$this->hasOne($class, ["id" => "prevValue"]):null;
    }
    public function getWith(){
        if($this->type==self::COMMENT){
            return $this->hasOne(Comment::className(),["id"=>"withID"]);
        }else{
            return null;
        }
    }
    //--relation
    public function getUser(){
        return $this->hasOne(User::className(), ["id" => "userID"]);
    }
    public function getRelevance(){
        return $this->hasOne(Relevance::className(), ["model" => "model", "value" => "value"]);
    }
}
