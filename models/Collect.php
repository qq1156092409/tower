<?php

namespace app\models;

use app\models\multiple\G;
use Yii;

/**
 * This is the model class for table "collect".
 *
 * @property integer $id
 * @property integer $userID
 * @property integer $model
 * @property integer $value
 * @property string $create
 */
class Collect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.collect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'model', 'value'], 'required'],
            [['userID', 'model', 'value'], 'integer'],
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
            'userID' => 'User ID',
            'model' => 'Model',
            'value' => 'Value',
            'create' => 'Create',
        ];
    }

    //--get
    public static function isCollect($userID,$model,$value){
        return self::findOne(["userID" => $userID, "model" => $model, "value" => $value]);
    }
    //--relation
    public function getTarget(){
        $class = G::transfer($this->model);
        return $class?$this->hasOne($class, ["id" => "value"]):null;
    }
    public function getRelevance(){
        return $this->hasOne(Relevance::className(), ["model" => "model", "value" => "value"]);
    }
}
