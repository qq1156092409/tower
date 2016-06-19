<?php

namespace app\models;

use app\models\multiple\G;
use Yii;

/**
 * This is the model class for table "relevance".
 *
 * @property integer $id
 * @property integer $model
 * @property integer $value
 * @property integer $prevModel
 * @property integer $prevValue
 * @property integer $teamID
 * @property integer $creatorID
 */
class Relevance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.relevance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model', 'value'], 'required'],
            [['model', 'value', 'prevModel', 'prevValue', 'teamID', 'creatorID'], 'integer']
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
            'prevModel' => 'Prev Model',
            'prevValue' => 'Prev Value',
            'teamID' => 'Team ID',
            'creatorID' => 'Creator ID',
        ];
    }

    //--action
    public static function create($attributes){
        $relevance=new Relevance();
        $relevance->load($attributes,"");
        if($old=self::findOne(["model"=>$relevance->model,"value"=>$relevance->value])){
            return $old;
        }
        $relevance->fixAttributes();
        return $relevance->save()?$relevance:false;
    }
    /**
     * 根据target补全属性值
     * prevModel , prevValue ,teamID
     */
    private function fixAttributes(){
        if($this->prevModel && $this->prevValue && $this->teamID){
            return $this;
        }
        $prev=$this->getPrevByTarget();
        $this->prevModel = G::transfer($prev->className());
        $this->prevValue=$prev->id;
        $this->teamID=$prev->teamID;
        return $this;
    }
    private function getPrevByTarget(){
        $target=$this->target;
        if($target->className()==Event::className()){
            $prev=$target->calendar;
        }else{
            $prev=$target->project;
        }
        return $prev;
    }
    //--get
    public function getTarget(){
        $class = G::transfer($this->model);
        return $class?$this->hasOne($class, ["id" => "value"]):null;
    }
    public function getPrev(){
        $class = G::transfer($this->prevModel);
        return $class?$this->hasOne($class, ["id" => "prevValue"]):null;
    }
    //--relation
    public function getTeam(){
        return $this->hasOne(Team::className(), ["id" => "teamID"]);
    }
}
