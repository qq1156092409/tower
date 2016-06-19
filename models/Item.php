<?php

namespace app\models;

use app\models\multiple\G;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "item".
 *
 * @property integer $id
 * @property string $name
 * @property integer $projectID
 * @property string $description
 * @property integer $type
 * @property integer $userID
 * @property integer $archive
 * @property integer $deleted
 * @property string $create
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectID', 'type', 'userID', 'archive', 'deleted'], 'integer'],
            [['create'], 'safe'],
            [['name', 'description'], 'string', 'max' => 256],
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
            'projectID' => 'Project ID',
            'description' => 'Description',
            'type' => 'Type',
            'userID' => 'User ID',
            'archive' => 'Archive',
            'deleted' => 'Deleted',
            'create' => 'Create',
        ];
    }

    //--attribute
    const COMMON=1;//普通类型
    const PROJECT_DIRECT=2;//项目直属（未归类项目保存的item）

    //--cache
    private $_taskCount=false;
    public function getTaskCount(){
        if($this->_taskCount===false){
            $this->_taskCount=Task::find()->where(["itemID"=>$this->id])->count();
        }
        return $this->_taskCount;
    }
    public function setTaskCount($count){
        $this->_taskCount=$count;
        return $this;
    }
    //--static
    /**
     * 批量填充任务数量统计
     * @param Item[] $items
     * @return \app\models\Item[]|array
     */
    public static function populateTaskCount(array &$items){
        $ids = ArrayHelper::getColumn($items,"id");
        $query=Task::find();
        $rows=$query->select(["itemID","count(*) as total"])->asArray()->where(["itemID"=>$ids])->groupBy("itemID")->indexBy("itemID")->all();
        foreach($items as $item){
            $item->setTaskCount($rows[$item->id]["total"]?:0);
        }
        return $items;
    }
    //--get
    public function getCommentCount(){
        return Comment::find()->where([
            "type"=>G::ITEM,
            "value"=>$this->id,
        ])->count();
    }
    public function countFinishedTask(){
        return Task::find()->where([
            "itemID"=>$this->id,
            "deleted"=>0,
            "status"=>Task::FINISHED,
        ])->count();
    }
    public function countEnableTask(){
        return Task::find()->where([
            "itemID"=>$this->id,
            "deleted"=>0,
        ])->count();
    }


    public function getViewUrl(){
        return Url::to(["/item","id"=>$this->id]);
    }
    public function getDisableUrl(){
        return Url::to(["/item/disable", "id" => $this->id]);
    }
    public function getTeamID(){
        return $this->project->teamID;
    }
    public function getActiveName(){
        if($this->type==self::PROJECT_DIRECT){
            return "未归类任务";
        }
        return $this->name;
    }
    public function getCommonTasks(){
        return $this->getTasks()->onCondition("task.status != ".Task::FINISHED." AND task.deleted = 0");//常见任务，未完成，未删除
    }
    public function getFinishedTasks(){
        return $this->getTasks()->onCondition("status = ".Task::FINISHED." AND deleted = 0");//未删除,已完成
    }
    //--relation
    public function getTasks(){
        return $this->hasMany(Task::className(), ["itemID" => "id"])->inverseOf("item");
    }
    public function getOperations(){
        return $this->hasMany(Operation::className(), ["value" => "id"])->onCondition("model=".G::ITEM);
    }
    public function getLastOperation(){
        return $this->hasOne(Operation::className(), ["value" => "id"])->onCondition("model=".G::ITEM)->orderBy("id desc");
    }
    public function getComments(){
        return $this->hasMany(Comment::className(),["value"=>"id"])->onCondition("model =".G::ITEM);
    }
    public function getProject(){
        return $this->hasOne(Project::className(), ["id" => "projectID"]);
    }
    public function getRelevance(){
        return $this->hasOne(Relevance::className(),["value"=>"id"])->onCondition("model =" . G::ITEM);
    }
    public function getDiscuss(){
        return $this->hasOne(Discuss::className(),["value"=>"id"])->onCondition("model =" . G::ITEM);
    }
    public function getUser(){
        return $this->hasOne(User::className(),["id"=>"userID"]);
    }
}
