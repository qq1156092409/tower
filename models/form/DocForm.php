<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-6-28
 * Time: 上午11:04
 */

namespace app\models\form;


use app\models\Doc;
use app\models\multiple\G;
use app\models\Operation;
use app\models\Project;
use app\models\Relevance;
use app\models\UserTeam;

class DocForm extends Doc{
    const CREATE="create";
    const EDIT="edit";
    const DISABLE="disable";
    const ENABLE="enable";

    public function beforeValidate(){
        if($flag=parent::beforeValidate()){
            $this->preprocess();
        }
        return $flag;
    }
    public function preprocess(){
        $this->name=="" and $this->name="新建文档";
    }
    public function scenarios(){
        return [
            self::CREATE=>["name","text"],
            self::EDIT=>["id","name","text"],
            self::DISABLE=>["id"],
            self::ENABLE=>["id"],
        ];
    }
    public function rules(){
        $rules=[
            ["id","exist"],
            ["id","checkID"],
            ["projectID","checkProjectID"],
        ];
        return array_merge(parent::rules(), $rules);
    }
    public function checkID($attribute,$params){
        $doc = $this->getDoc();
        $userTeam = UserTeam::findOne(["userID" => \Yii::$app->user->id, "teamID" => $doc->project->teamID]);
        if(!$userTeam){
            $this->addError($attribute,"你不是我们机组的");
        }
    }
    public function checkProjectID($attribute, $params){
        $project = Project::findOne($this->projectID);
        $userTeam = UserTeam::findOne(["userID" => \Yii::$app->user->id, "teamID" => $project->teamID]);
        if(!$userTeam){
            $this->addError($attribute,"你不是我们机组的");
        }
    }

    public function create($validate=true){
        if($validate && !$this->validate()) return false;
        $doc=new Doc;
        $doc->attributes=$this->attributes;
        $doc->userID=\Yii::$app->user->id;
        $doc->update=$doc->create=date("Y-m-d H:i:s");
        $doc->deleted=G::DELETED_NOT;
        if($flag=$doc->save()){
            $this->_doc=$doc;
            $this->createOperation(Operation::ADD);
            $this->createRelevance();
        }
        return $flag;
    }
    public function edit($validate=true){
        if($validate && !$this->validate()) return false;
        $doc=$this->getDoc();
        $doc->name=$this->name;
        $doc->text=$this->text;
        if($flag=$doc->save()){
            $this->createOperation(Operation::EDIT);
        }
        return $flag;
    }
    public function enable($validate=true){
        if($validate && !$this->validate()) return false;
        $doc=$this->getDoc();
        if($doc->deleted==0) return true;
        $doc->deleted=0;
        if($flag=$doc->save()){
            $this->createOperation(Operation::ENABLE);
        }
        return $flag;
    }
    public function disable($validate=true){
        if($validate && !$this->validate()) return false;
        $doc=$this->getDoc();
        if($doc->deleted==1) return true;
        $doc->deleted=1;
        if($flag=$doc->save()){
            $this->createOperation(Operation::DISABLE);
        }
        return $flag;
    }
    private function createOperation($type){
        $doc=$this->getDoc();
        $textMap=[
            Operation::ADD=>"创建了文档",
            Operation::DISABLE=>"删除了文档",
            Operation::ENABLE=>"恢复了文档",
            Operation::EDIT=>"编辑了文档",
        ];
        return Operation::create([
            'userID' => \Yii::$app->user->id,
            'type' => $type,
            'text' => $textMap[$type],
            'value' => $doc->id,
            'model' => G::DOC,
        ]);
    }
    private function createRelevance(){
        $doc=$this->getDoc();
        $relevance=new Relevance();
        $relevance->model=G::DOC;
        $relevance->value=$doc->id;
        $relevance->prevModel=G::PROJECT;
        $relevance->prevValue=$doc->projectID;
        $relevance->teamID=$doc->project->teamID;
        $relevance->creatorID=$doc->userID;
        return $relevance->save();
    }
    private $_doc=false;

    /**
     * @return Doc
     * @throws \yii\base\InvalidConfigException
     */
    public function getDoc(){
        if($this->_doc===false){
            $this->_doc = Doc::findOne($this->id);
        }
        return $this->_doc;
    }
} 