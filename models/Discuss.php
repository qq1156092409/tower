<?php

namespace app\models;

use app\helpers\TimeHelper;
use app\models\multiple\G;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "discuss".
 *
 * @property integer $id
 * @property integer $model
 * @property integer $value
 * @property integer $order
 * @property integer $deleted
 * @property string $update
 * @property integer $archive
 *
 * @property Task|Item|Topic $target
 */
class Discuss extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.discuss';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model', 'value'], 'required'],
            [['model', 'value', 'order', 'deleted', 'archive'], 'integer'],
            [['update'], 'safe']
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
            'order' => 'Order',
            'deleted' => 'Deleted',
            'update' => 'Update',
            'archive' => 'Archive',
        ];
    }

    //--static
    /**
     * @param Discuss[] $discusses
     * @return Discuss[]
     */
    public static function populateCommentCount(array &$discusses){
        $models = array_unique(ArrayHelper::getColumn($discusses,"model"));
        $values = array_unique(ArrayHelper::getColumn($discusses,"value"));
        $query=Comment::find();
        $rows=$query->select(["model","value","count(*) as total"])->asArray()->where(["model"=>$models,"value"=>$values])->groupBy(["model","value"])->indexBy(function($row){
            return $row["model"].'-'.$row["value"];
        })->all();
        foreach($discusses as $discuss){
            $discuss->setCommentCount($rows[$discuss->model."-".$discuss->value]["total"]?:0);
        }
        return $discusses;
    }

    /**
     * 批量填充target值
     * @param Discuss[] $discusses
     * @return \app\models\Discuss[]|array
     */
    public static function populateTarget(array &$discusses){
        $targetArr=[];
        foreach($discusses as $discuss){
            $targetArr[$discuss->model][]=$discuss->value;
        }
        foreach($targetArr as $model=>$values){
            $class=G::transfer($model);
            $targetArr[$model]=$class::find()->where(["id"=>$values])->indexBy("id")->all();
        }
        foreach($discusses as $discuss){
            $discuss->populateRelation("target", $targetArr[$discuss->model][$discuss->value]);
        }
        return $discusses;
    }
    //--cache
    private $_commentCount=false;
    public function getCommentCount(){
        if($this->_commentCount===false){
            $this->_commentCount=Comment::find()->where([
                "model"=>$this->model,
                "value"=>$this->value,
            ])->count();
        }
        return $this->_commentCount;
    }
    public function setCommentCount($count){
        $this->_commentCount=$count;
        return $this;
    }

    //--get
    public static function hasDiscuss($model,$value){
        return self::findOne(["model" => $model, "value" => $value]);
    }
    public function getActiveText(){
        /** @var Comment $comment */
        $comment=Comment::find()->where([
            "model"=>$this->model,
            "value"=>$this->value,
        ])->orderBy("id desc")->one();
        $text=$comment?$comment->text:"";
        if(!$text && $this->model==G::TOPIC){
            $text=$this->target->text;
        }
        return $text;
    }
    public function getActiveUpdate(){
        return TimeHelper::getFuzzyTime($this->update);
    }
    public function getTarget(){
        $class = G::transfer($this->model);
        return $class?$this->hasOne($class, ["id" => "value"]):null;
    }
    //--relation
    public function getRelevance(){
        return $this->hasOne(Relevance::className(), ["model" => "model", "value" => "value"]);
    }
    public function getComments(){
        return $this->hasMany(Comment::className(), ["model" => "model", "value" => "value"]);
    }
}
