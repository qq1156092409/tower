<?php

namespace app\models\form;

use app\models\Item;
use app\models\multiple\G;
use app\models\Operation;
use app\models\Relevance;
use app\models\UserTeam;

class ItemForm extends Item{
    const CREATE = "create";
    const EDIT = "edit";
    const ARCHIVE = "archive";
    const UN_ARCHIVE = "unArchive";
    const TOGGLE_ARCHIVE = "toggleArchive";
    const DISABLE = "disable";
    const ENABLE = "enable";
    public function scenarios(){
        return [
            self::CREATE=>["projectID","name","description"],
            self::EDIT=>["id","name","description"],
            self::ARCHIVE=>["id"],
            self::UN_ARCHIVE=>["id"],
            self::TOGGLE_ARCHIVE=>["id"],
            self::DISABLE=>["id"],
            self::ENABLE=>["id"],
        ];
    }
    public function rules(){
        $rules=[
            [["name","projectID"],"required"],
            ["id","exist"],
            ["id","checkID"],
            ["id","checkTask","on"=>[self::ARCHIVE,self::TOGGLE_ARCHIVE,self::ARCHIVE,self::UN_ARCHIVE]],
        ];
        return array_merge(parent::rules(), $rules);
    }
    public function checkID($attribute,$params){
        $item=$this->getItem();
        if (!UserTeam::findOne(["userID" => \Yii::$app->user->id, "teamID" => $item->project->teamID])) {
            $this->addError($attribute, "你不是我们机组吧");
        }
    }
    public function checkTask($attribute,$params){
        $item=$this->getItem();
        if ($item->getCommonTasks()->count()>0) {
            $this->addError($attribute, "请确认清单内任务都已完成，再归档。");
        }
    }
    public function checkProjectID($attribute,$params){
        if (!UserTeam::findOne(["teamID" => $this->project->teamID, "userID" => \Yii::$app->user->id])) {
            $this->addError($attribute, "你不是我们机组的吧");return;
        }
    }
    //--action
    /**
     * 创建item
     * 创建operation
     * @param bool|true $validate
     * @return bool
     * @throws \yii\base\InvalidParamException
     */
    public function create($validate=true){
        if($validate && !$this->validate()) return false;
        if($this->createItem()){
            $this->createOperation(Operation::ADD);
            $this->createRelevance();
            return true;
        }
        return false;
    }
    public function disable($validate=true){
        if($validate && !$this->validate()) return false;
        $item=$this->getItem();
        $item->deleted=1;
        if($flag=$item->save()){
            $this->createOperation(Operation::DISABLE);
            $this->syncDiscuss();
        }
        return $flag;
    }
    public function enable($validate=true){
        if($validate && !$this->validate()) return false;
        $item=$this->getItem();
        $item->deleted=0;
        if($flag=$item->save()){
            $this->createOperation(Operation::ENABLE);
            $this->syncDiscuss();
        }
        return $flag;
    }
    public function edit($validate=true){
        if($validate && !$this->validate()) return false;
        $item=$this->getItem();
        $item->name=$this->name;
        $item->description=$this->description;
        if($flag=$item->save()){
            $this->createOperation(Operation::EDIT);
        }
        return $flag;
    }
    public function toggleArchive($validate=true){
        if($validate && !$this->validate()) return false;
        $item=$this->getItem();
        $item->archive=($item->archive+1)%2;
        if($flag=$item->save()){
            $this->createOperation(Operation::EDIT);
        }
        return $flag;
    }
    public function archive($validate=true){
        if($validate && !$this->validate()) return false;
        $item=$this->getItem();
        return $item->archive?$this->unArchive(false):$this->archive(false);
    }
    public function unArchive($validate=true){
        if($validate && !$this->validate()) return false;
        $item=$this->getItem();
        $item->archive=0;
        if($flag=$item->save()){
            $this->createOperation(Operation::UN_ARCHIVE);
        }
        return $flag;
    }
    private function createItem(){
        $item=new Item($this->attributes);
        $item->userID=\Yii::$app->user->id;
        $item->create=date("Y-m-d H:i:s");
        $item->loadDefaultValues();
        if($flag=$item->save()){
            $this->setItem($item);
        }
        return $flag?$item:false;
    }
    private function createOperation($type){
        $textMap=[
            Operation::ADD=>"创建了清单",
            Operation::DISABLE=>"删除了清单",
            Operation::ENABLE=>"恢复了清单",
            Operation::COMMENT=>"回复了清单",
            Operation::MOVE=>"移动了清单",
            Operation::ARCHIVE=>"归档了清单",
            Operation::UN_ARCHIVE=>"重新激活了清单",
            Operation::EDIT=>"修改了清单",//TODO
        ];
        $item=$this->getItem();
        $operation=new Operation([
            'userID' => \Yii::$app->user->id,
            'type' =>$type,
            'text' =>$textMap[$type],
            'value' =>$item->id,
            'model' =>G::ITEM,
            'create' => date("Y-m-d H:i:s"),
        ]);
        return $operation->save()?$operation:false;
    }
    private function createRelevance(){
        $item=$this->getItem();
        $relevance=new Relevance([
            'model' => G::ITEM,
            'value' =>$item->id,
            'prevModel' => G::PROJECT,
            'prevValue' => $item->projectID,
            'teamID' => $item->project->teamID,
        ]);
        return $relevance->save()?$relevance:false;
    }
    private function syncDiscuss(){
        $item=$this->getItem();
        if($discuss=$item->discuss){
            $discuss->deleted=$item->deleted;
            return $discuss->save();
        }
        return false;
    }
    private $_item=false;

    /**
     * @return Item
     */
    public function getItem(){
        if($this->_item===false){
            $this->_item = Item::findOne($this->id);
        }
        return $this->_item;
    }
    public function setItem(Item $item){
        $this->_item=$item;
        return $this;
    }
} 