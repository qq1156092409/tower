<?php

namespace app\models;

use app\models\multiple\G;
use app\models\multiple\TargetInterface;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property string $name
 * @property string $endTime
 * @property integer $projectID
 * @property integer $itemID
 * @property integer $userID
 * @property integer $creatorID
 * @property integer $box
 * @property integer $status
 * @property integer $deleted
 * @property string $finishTime
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'projectID'], 'required'],
            [['endTime', 'finishTime'], 'safe'],
            [['projectID', 'itemID', 'userID', 'creatorID', 'box', 'status', 'deleted'], 'integer'],
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
            'endTime' => 'End Time',
            'projectID' => 'Project ID',
            'itemID' => 'Item ID',
            'userID' => 'User ID',
            'creatorID' => 'Creator ID',
            'box' => 'Box',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'finishTime' => 'Finish Time',
        ];
    }

    //--attribute
    const ADD = 1;
    const RUNNING = 2;
    const FINISHED = 3;

    private $_commentCount = false; //保存数据

    //--other
    /**
     * 按box划分
     * @param Task[] $tasks
     * @return array
     */
    public static function divideBox(array $tasks){
        $newTasks = [];
        foreach ($tasks as $task) {
            $newTasks[$task->box][] = $task;
        }
        return $newTasks;
    }

    /**
     * 按最后一次操作日期划分
     * @param Task[] $tasks
     * @return Task[]
     */
    public static function divideLastOperationDay(array $tasks){
        $newTasks = [];
        foreach ($tasks as $task) {
            $newTasks[date("Y-m-d", strtotime($task->lastOperation->create))][] = $task;
        }
        return $newTasks;
    }

    /**
     * 按“完成日期-清单”划分
     * @param Task[] $tasks
     * @return array
     */
    public static function divideFinishDayItem(array $tasks){
        $newTasks = [];
        foreach ($tasks as $task) {
            $newTasks[date("Y-m-d", strtotime($task->finishTime))][$task->itemID][] = $task;
        }
        return $newTasks;
    }

    public static function getUnFinishStatus(){
        return [self::ADD, self::RUNNING];
    }

    public static function getProjects(array $tasks){
        $projects = [];
        foreach ($tasks as $task) {
            $projects[$task->item->project->id] = $task->item->project;
        }
        return $projects;
    }

    /**
     * @param null $box
     * @param null $attr
     * @return array
     */
    public static function box($box = null, $attr = null){
        $boxes = [
            1 => ["name" => "new", "chinese" => "新任务", "iconClass" => "twr-inbox", "emptyText" => "当前没有新任务"],
            2 => ["name" => "today", "chinese" => "今天", "iconClass" => "twr-crosshairs", "emptyText" => "今日任务请放入这里"],
            3 => ["name" => "next", "chinese" => "接下来", "iconClass" => "twr-tasks", "emptyText" => "已确定的任务请放入这里"],
            4 => ["name" => "later", "chinese" => "以后", "iconClass" => "twr-archive", "emptyText" => "待考虑的任务请放入这里"],
        ];
        if ($box && $attr) {
            return $boxes[$box][$attr];
        } elseif ($box) {
            return $boxes[$box];
        } else {
            return $boxes;
        }
    }

    //--get
    public function getTeamID(){
        return $this->project->teamID;
    }
    public function getProjectID(){
        return $this->item->projectID;
    }

    public function getCommentCount(){
        if ($this->_commentCount === false) {
            $this->_commentCount = Comment::find()->where([
                "model" => G::TASK,
                "value" => $this->id,
            ])->count();
        }
        return $this->_commentCount;
    }

    public function getViewUrl(){
        return Url::to(["/task", "id" => $this->id]);
    }
    public function getDisableUrl(){
        return Url::to(["/task/disable","id"=>$this->id]);
    }
    public function getLastOperation($type=null){
        $where=[
            "model"=>G::TASK,
            "value"=>$this->id,
        ];
        $type and $where["type"]=$type;
        return Operation::find()->where($where)->orderBy("id desc")->one();
    }

    //--relations
    public function getOperations(){
        return $this->hasMany(Operation::className(), ["value" => "id"])->onCondition("model=" . G::TASK);
    }
    public function getComments(){
        return $this->hasMany(Comment::className(), ["value" => "id"])->onCondition("model =" . G::TASK);
    }
    public function getUser(){
        return $this->hasOne(User::className(), ["id" => "userID"]);
    }
    public function getItem(){
        return $this->hasOne(Item::className(), ["id" => "itemID"]);
    }
    public function getProject(){
        return $this->hasOne(Project::className(), ["id" => "projectID"]);
    }
    public function getRelevance(){
        return $this->hasOne(Relevance::className(),["value"=>"id"])->onCondition("model =" . G::TASK);
    }
    public function getDiscuss(){
        return $this->hasOne(Discuss::className(),["value"=>"id"])->onCondition("model =" . G::TASK);
    }
}
