<?php

namespace app\models\form;

use app\models\Item;
use app\models\multiple\G;
use app\models\Operation;
use app\models\Relevance;
use app\models\Task;
use app\models\UserTeam;

class TaskForm extends Task{
    const CREATE = "create";
    const RUN="run";
    const PAUSE="pause";
    const DISABLE = "disable";
    const ENABLE = "enable";
    const ASSIGN = "assign";
    const FINISH = "finish";
    const EDIT = "edit";
    const OPEN = "open";

    public function scenarios(){
        return [
            self::CREATE=>["itemID","name","endTime"],
            self::DISABLE=>["id"],
            self::ENABLE=>["id"],
            self::RUN=>["id"],
            self::PAUSE=>["id"],
            self::FINISH=>["id"],
            self::OPEN=>["id"],
            self::ASSIGN=>["id","userID","endTime"],
            self::EDIT=>["id","name","userID","endTime"],
        ];
    }
    public function rules(){
        $rules=[
            ["id","exist"],
            ["id","checkID"],
            ["itemID","checkItemID"],
            ["endTime","fixEndTime"],
        ];
        return array_merge($rules, parent::rules());
    }
    //--check
    public function checkID($attribute,$params){
        $task = $this->getTask();
        if (!$userTeam = UserTeam::findOne(["teamID" => $task->project->teamID, "userID" => \Yii::$app->user->id])) {
            $this->addError($attribute, "你不是我们机组的吧");return;
        }
    }
    public function checkItemID($attribute,$params){
        $item = Item::findOne($this->itemID);
        if (!$userTeam = UserTeam::findOne(["teamID" => $item->project->teamID, "userID" => \Yii::$app->user->id])) {
            $this->addError($attribute, "你不是我们机组的吧");return;
        }
    }
    public function fixEndTime($attribute,$params){
        if($this->endTime){
            $this->endTime=date("Y-m-d 23:59:59", strtotime($this->endTime));
        }
    }
    //--action
    /**
     * 创建task
     * 创建operation，创建relevance
     * @param bool|true $validate
     * @return bool
     * @throws \yii\base\InvalidParamException
     */
    public function create($validate=true){
        if($validate && !$this->validate()){
            return false;
        }
        $task=new Task($this->attributes);
        $task->projectID=Item::findOne($this->itemID)->projectID;
        $task->creatorID=\Yii::$app->user->id;
        $task->loadDefaultValues();
        if($flag=$task->save()){
            $this->setTask($task);
            $this->createOperation(Operation::ADD);
            $this->createRelevance();
        }
        return $flag;
    }
    private function createRelevance(){
        $task=$this->getTask();
        $relevance=new Relevance([
            'model' => G::transfer($task->className()),
            'value' => $task->id,
            'prevModel' => G::PROJECT,
            'prevValue' => $task->projectID,
            'teamID' => $task->project->teamID,
        ]);
        return $relevance->save()?$relevance:false;
    }

    /**
     * 开始处理任务(指派给自己)
     * 创建operation，暂停之前处理的任务(创建暂停operation)
     * @param bool|true $validate
     * @return bool
     * @throws \yii\base\InvalidParamException
     */
    public function run($validate=true){
        if($validate && !$this->validate()){
            return false;
        }
        $task=$this->getTask();
        $task->status=self::RUNNING;
        $task->userID=\Yii::$app->user->id;
        if($flag=$task->save()){
            $this->createOperation(Operation::RUNNING);
            $this->pendOldTask();
        }
        return $flag;
    }

    /**
     * 暂停任务
     * 创建operation
     * @param bool|true $validate
     * @return bool
     * @throws \yii\base\InvalidParamException
     */
    public function pend($validate=true){
        if($validate && !$this->validate()){
            return false;
        }
        $task=$this->getTask();
        $task->status=self::ADD;
        if($flag=$task->save()){
            $this->createOperation(Operation::PAUSE);
        }
        return $flag;
    }

    /**
     * 不可用
     * 创建operation，同步discuss
     * @param bool|true $validate
     * @return bool
     * @throws \yii\base\InvalidParamException
     */
    public function disable($validate=true){
        if($validate && !$this->validate()){
            return false;
        }
        $task=$this->getTask();
        $task->deleted=1;
        if($flag=$task->save()){
            $this->createOperation(Operation::DISABLE);
            $this->syncDiscuss();
        }
        return $flag;
    }
    public function enable($validate=true){
        if($validate && !$this->validate()) return false;
        $task=$this->getTask();
        $task->deleted=0;
        if($flag=$task->save()){
            $this->createOperation(Operation::ENABLE);
            $this->syncDiscuss();
        }
        return $flag;
    }

    /**
     * 指派 & 修改完成时间(如果用户有变化，设置成默认状态)
     * 创建operation（指派，修改）
     * @param bool|true $validate
     * @return bool
     * @throws \yii\base\InvalidParamException
     */
    public function assign($validate=true){
        if($validate && !$this->validate()) return false;
        $task=$this->getTask();
        $old=clone $task;
        $task->userID=$this->userID;
        if($old->userID!=$task->userID){
            $task->status=self::ADD;
        }
        $task->endTime=$this->endTime;
        if($flag=$task->save()){
            $old->userID!=$task->userID and $this->createOperation(Operation::ASSIGN,$old->userID,$task->userID);
            $old->endTime!=$task->endTime and $this->createOperation(Operation::DUE_CHANGE,$old->endTime,$task->endTime);
        }
        return $flag;
    }
    public function finish($validate=true){
        if($validate && !$this->validate()) return false;
        $task=$this->getTask();
        $task->userID=\Yii::$app->user->id;
        $task->status=self::FINISHED;
        $task->finishTime=date("Y-m-d H:i:s");
        if($flag=$task->save()){
            $this->createOperation(Operation::FINISH);
        }
        return $flag;
    }
    public function open($validate=true){
        if($validate && !$this->validate()) return false;
        $task=$this->getTask();
        $task->status=self::ADD;
        if($flag=$task->save()) {
            $this->createOperation(Operation::REOPEN);
        }
        return $flag;
    }
    public function edit($validate=true){
        if($validate && !$this->validate()) return false;
        $task=$this->getTask();
        $task->name=$this->name;
        $task->userID=$this->userID;
        $task->endTime=$this->endTime;
        if($flag=$task->save()){
            $this->createOperation(Operation::EDIT);
        }
        return $flag;
    }
    private function syncDiscuss(){
        $task=$this->getTask();
        if($discuss=$task->discuss){
            $discuss->deleted=$task->deleted;
            return $discuss->save();
        }
        return false;
    }
    private function findOldRumTask(){
        $task=Task::find()->innerJoin(["project"])->where([
            "task.userID"=>\Yii::$app->user->id,//指派给我
            "task.status" => Task::RUNNING,//正在处理
            "project.teamID"=>$this->getTask()->project->teamID//相同团队
        ])->andWhere("task.id != ".$this->getTask()->id)->one();
        $this->_oldRunTask=$task;
        return $task;
    }
    private function pendOldTask(){
        if($task=$this->getOldRunTask()){
            $model = new TaskForm([
                "id"=>$task->id,
            ]);
            $model->setTask($task);
            return $model->pend(false);
        }
        return false;
    }
    private function createOperation($type,$form=null,$to=null){
        $task=$this->getTask();
        $operation=new Operation([
            'userID' => \Yii::$app->user->id,
            'type' => $type,
            'text' => $this->getOperationText($type,$form,$to),
            'value' => $task->id,
            'create' => date("Y-m-d H:i:s"),
            'model' => G::transfer($task->className()),
        ]);
        return $operation->save()?$operation:false;
    }
    private function getOperationText($type, $from = null, $to = null){
        $textMap = [
            Operation::ADD => "添加了任务",
            Operation::RUNNING => "开始处理这条任务",
            Operation::PAUSE => "暂停处理这条任务",
            Operation::FINISH => "完成了任务",
            Operation::REOPEN => "重新打开了任务",
            Operation::DISABLE => "删除了任务",
            Operation::ENABLE => "恢复了任务",
            Operation::DUE_CHANGE => "将任务完成时间从 " . ($from ? ("{time:" . $from . "}") : "没有截止日期") . " 修改为 " . ($to ? ("{time:" . $to . "}") : "没有截止日期"),
            Operation::RENAME => "将任务 \"" . $from . "\" 修改为 " . $to,
            Operation::COMMENT => "回复了任务",
            Operation::EDIT => "修改了任务",
        ];
        $text = $textMap[$type];
        if (!$text) {
            if ($type == Operation::ASSIGN) {
                if ($from && $to) {
                    $text = "把 " . $from . " 的任务指派给 " . $to;
                } elseif ($from) {
                    $text = "取消了" . $from . "的任务";
                } elseif ($to) {
                    $text = "把任务指派给 " . $to;
                }
            }
        }
        return $text;
    }

    /**
     * @var Task
     */
    private $_task=false;
    public function getTask(){
        if($this->_task===false){
            $this->_task = Task::findOne($this->id);
        }
        return $this->_task;
    }
    public function setTask($task){
        $this->_task=$task;
        return $this;
    }

    /**
     * @var Task
     */
    private $_oldRunTask=false;
    public function getOldRunTask(){
        if($this->_oldRunTask===false){
            $this->findOldRumTask();
        }
        return $this->_oldRunTask;
    }
} 