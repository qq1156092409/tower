<?php
namespace app\models\form;
use app\models\Discuss;
use app\models\multiple\G;
use app\models\Operation;
use app\models\Project;
use app\models\Relevance;
use app\models\Topic;
use app\models\UserTeam;

class TopicForm extends Topic{
    const CREATE="create";
    const ENABLE="enable";
    const DISABLE="disable";
    const MOVE="move";
    const EDIT ="edit";

    public function scenarios(){
        $scenarios=[
            self::CREATE=>["name","text","projectID"],
            self::ENABLE=>["id"],
            self::DISABLE=>["id"],
            self::MOVE=>["id","projectID"],
            self::EDIT=>["id","name","text"],
        ];
        return $scenarios;
    }
    public function rules(){
        $rules=[
            [["name","projectID"],"required"],
            ["id","exist"],
            ["id","checkID"],
            ["projectID","checkProjectID"],
        ];
        return array_merge($rules,parent::rules());
    }
    //--check
    public function checkID($attribute, $params){
        $topic=$this->getTopic();
        $userTeam = UserTeam::findOne(["userID" => \Yii::$app->user->id, "teamID" => $topic->project->teamID]);
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

    //--action
    /**
     * 创建主题
     * 创建operation，创建discuss,创建relevance
     * @param bool|true $runValidate
     * @return bool
     * @throws \yii\base\InvalidParamException
     */
    public function create($runValidate=true){
        if($runValidate && !$this->validate()){
            return false;
        }
        $this->userID=\Yii::$app->user->id;
        $topic=new Topic($this->attributes);
        if($flag=$topic->save()){
            $this->setTopic($topic);
            $this->createDiscuss();
            $this->createOperation(Operation::ADD);
            $this->createRelevance();
        }
        return $flag;
    }
    private function createRelevance(){
        $topic=$this->getTopic();
        $relevance=new Relevance([
            'model' => G::TOPIC,
            'value' => $topic->id,
            'prevModel' => G::PROJECT,
            'prevValue' => $topic->projectID,
            'teamID' => $topic->project->teamID,
        ]);
        return $relevance->save();
    }
    private function createOperation($type){
        $topic=$this->getTopic();
        $textMap=[
            Operation::ADD=>"创建了讨论",
            Operation::ENABLE=>"恢复了讨论",
            Operation::DISABLE=>"删除了讨论",
            Operation::EDIT=>"编辑了讨论",
            Operation::MOVE=>"移动了讨论",
        ];
        $operation=new Operation([
            'userID' =>\Yii::$app->user->id,
            'type' => $type,
            'text' =>$textMap[$type],
            'value' => $topic->id,
            'create' => date("Y-m-d H:i:s"),
            'model' =>G::transfer($topic->className()),
        ]);
        return $operation->save()?$operation:false;
    }
    public function createDiscuss(){
        $topic=$this->getTopic();
        $discuss=new Discuss([
            'model' => G::transfer($topic->className()),
            'value' => $topic->id,
            'order' => 0,
            'deleted' => 0,
            'archive' => 0,
        ]);
        return $discuss->save()?$discuss:false;
    }


    private $_topic=false;
    public function getTopic(){
        if($this->_topic===false){
            $this->_topic = Topic::findOne($this->id);
        }
        return $this->_topic;
    }
    public function setTopic(Topic $topic){
        $this->_topic=$topic;
        return $this;
    }
} 