<?php

namespace app\models\form;

use app\models\Item;
use app\models\multiple\G;
use app\models\Operation;
use app\models\Project;
use app\models\Relevance;
use app\models\Team;
use app\models\UserProject;
use app\models\UserTeam;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\User;

class ProjectForm extends Project{
    //--scenario
    const CREATE = "create";
    const DESTROY = "destroy";
    const EDIT = "edit";
    const ICON = "icon";
    const TOGGLE_SECTION = "toggleSection";
    const TOGGLE_ARCHIVE = "toggleArchive";
    const QUIT = "quit";
    const MEMBER_MANAGE = "memberManage";
    const SORT = "sort";
    const SECTION_SORT = "sectionSort";

    //--attributes
    public $userIDs;//成员ID数组
    public $sectionID;//操作的sectionID
    public $prevID;//前一个的id
    public $prevSectionID;

    //--scenario - attributes
    public function scenarios(){
        return [
            self::CREATE=>["teamID","name","description","type","userIDs"],
            self::DESTROY=>["id"],
            self::EDIT=>["id","name","description"],
            self::ICON=>["id","icon","iconColor"],
            self::TOGGLE_SECTION=>["id","sectionID"],
            self::TOGGLE_ARCHIVE=>["id"],
            self::QUIT=>["id"],
            self::MEMBER_MANAGE=>["id","userIDs"],
            self::SORT=>["id","prevID"],
            self::SECTION_SORT=>["id","sectionID","prevSectionID"],
        ];
    }
    
    //--event
    public function beforeValidate(){
        if($flag=parent::beforeValidate()){
            if($this->scenario==self::CREATE){
                $this->filterUserIDs($this->teamID);
            }
            if($this->scenario==self::MEMBER_MANAGE){
                $this->filterUserIDs($this->getProject()->teamID);
            }
        }
        return $flag;
    }
    /**
     * 过滤用户ID，必须要在团队内
     * @param $teamID int
     */
    public function filterUserIDs($teamID){
        $userTeams=UserTeam::findAll([
            "userID"=>$this->userIDs,
            "teamID"=>$teamID,
        ]);
        $this->userIDs = ArrayHelper::getColumn($userTeams, "userID");
    }
    
    //--validate
    public function rules(){
        $rules=[
            ["id","checkQuit","on"=>self::QUIT],
            ["teamID","checkTeamID"],
            ["sectionID","checkSectionID","on"=>self::TOGGLE_SECTION],
        ];
        return array_merge($rules, parent::rules());
    }
    public function checkSectionID($attribute){
        if (!in_array($this->sectionID, self::getAllSectionIDs())) {
            $this->addError($attribute, "section值不合法");
        }
    }
    /**
     * 必须要已经加入到项目中，如果是管理员退出的话，最后一个管理员不能退出
     * @param $attribute
     */
    public function checkQuit($attribute){
        $userProject=UserProject::findOne(["userID"=>\Yii::$app->user->id,"projectID"=>$this->id]);
        if(!$userProject){
            $this->addError($attribute, "你不是我们机组的吧");return;
        }
        /** @var UserTeam $userTeam */
        $userTeam=$userProject->getUserTeam();
        if ($userTeam->isAdmin()) {
            //当前项目必须要有两个管理员
            $project=$this->getProject();
            $adminCount=UserTeam::find()->where([
                "userID"=>ArrayHelper::getColumn($project->userProjects,"userID"),
                "teamID"=>$project->teamID,
                "type"=>[UserTeam::SUPER_ADMIN,UserTeam::ADMIN],
            ])->count();
            if($adminCount<2){
                $this->addError($attribute, "你是最后一个管理员，不能退出项目");return;
            }
        }
    }
    public function checkTeamID($attribute){
        $team=Team::findOne($this->teamID);
        if(!$team){
            $this->addError($attribute, "团队不存在");return;
        }
        if (!UserTeam::findOne(["teamID" => $this->teamID, "userID" => \Yii::$app->user->id])) {
            $this->addError($attribute, "你不是我们机组的吧");return;
        }
    }
    
    //--action
    /**
     * 创建项目
     * 加入项目，创建直属清单，添加成员,创建relevance,创建operation
     * @param bool|true $validate
     * @return bool
     * @throws \yii\base\InvalidParamException
     */
    public function create($validate=true){
        if($validate && !$this->validate()) return false;
        if($flag=$this->createProject()){
            $project=$this->getProject();
            $this->createDirectItem();//项目直属item（未归类项目存放地方）
            UserProject::create([
                "userID"=>\Yii::$app->user->id,
                "projectID"=>$project->id,
            ]);
            if($this->userIDs){
                foreach($this->userIDs as $userID){
                    UserProject::create([
                        "userID"=>$userID,
                        "projectID"=>$project->id,
                    ]);
                }
            }
            $this->createRelevance();
            $this->createOperation(Operation::ADD);
        }
        return $flag;
    }
    public function icon($validate=true){
        if($validate && !$this->validate()) return false;
        $project=$this->getProject();
        $project->icon=$this->icon;
        $project->iconColor=$this->iconColor;
        return $project->save();
    }
    public function quit($validate=true){
        if($validate && !$this->validate()) return false;
        $userProject=UserProject::findOne(["userID"=>\Yii::$app->user->id,"projectID"=>$this->id]);
        return $userProject->delete();
    }
    public function destroy($validate = true){
        if($validate && !$this->validate()) return false;
        $project=$this->getProject();
        if ($flag = $project->delete()) {
            /**
             * delete others todo
             * calendar
             * item task dir file doc event topic
             * operation comment discuss reference
             */

        }
        return $flag;
    }
    public function toggleSection($validate=true){
        if($validate && !$this->validate()) return false;
        $project=$this->getProject();
        $sections=$project->getSectionIDs();
        if (in_array($this->sectionID, $sections)) {
            foreach($sections as $k=>$sectionID){
                if($this->sectionID==$sectionID){
                    unset($sections[$k]);
                }
            }
        }else{
            $sections[]=$this->sectionID;
        }
        $project->section = implode("-", array_unique($sections));
        return $project->save();
    }
    public function manageMember($validate=true){
        if($validate && !$this->validate()) return false;
        $project=$this->getProject();
        $userIDs = ArrayHelper::getColumn($project->userProjects, "userID");
        $newIDs=$this->userIDs;
        $newIDs[]=\Yii::$app->user->id;
        $adds = array_diff($newIDs, $userIDs);
        $deletes = array_diff($userIDs, $newIDs);
        if($adds){
            foreach($adds as $userID){
                $userProject=new UserProject();
                $userProject->projectID=$this->id;
                $userProject->userID=$userID;
                $userProject->save();
            }
        }
        if($deletes){
            UserProject::deleteAll(["projectID" => $this->id, "userID" => $deletes]);
        }
        return true;
    }
    public function toggleArchive($validate=true){
        if($validate && !$this->validate()) return false;
        $project=$this->getProject();
        $project->archive=($project->archive+1)%2;
        if($flag=$project->save()){
            $this->createOperation($project->archive?Operation::ARCHIVE:Operation::UN_ARCHIVE);
        }
        return $flag;
    }
    public function edit($validate=true){
        if($validate && !$this->validate()) return false;
        $project=$this->getProject();
        $project->name=$this->name;
        $project->description=$this->description;
        return $project->save();
    }

    /**
     * 拖拽排序
     * @param bool $validate
     * @return bool
     */
    public function sort($validate=true){
        if($validate && !$this->validate()) return false;
        $project=$this->getProject();
        $prev = Project::findOne($this->prevID);
        $project->sort=($prev->sort?$prev->sort+1:1);
        if($flag=$project->save()){
            //解决冲突
            $isConflict=Project::find()->where(["teamID"=>$project->teamID,"sort"=>$project->sort])->count()>1;
            if($isConflict){
                $condition="teamID = {$project->teamID} and sort >= {$project->sort} and id != {$this->id}";
                Project::updateAllCounters(["sort" => 1],$condition);
            }
        }
        return $flag;
    }

    /**
     * section排序
     * @param bool $validate
     * @return bool
     */
    public function sectionSort($validate=true){
        if($validate && !$this->validate()) return false;
        $project=$this->getProject();
        $sections = explode("-", $project->section);
        $newSections=$this->prevSectionID?[]:[$this->sectionID];
        foreach($sections as $sectionID){
            $sectionID!=$this->sectionID and $newSections[]=$sectionID;
            if($sectionID==$this->prevSectionID){
                $newSections[]=$this->sectionID;
            }
        }
        $project->section = implode("-", $newSections);
        return $project->save();
    }
    private function createProject(){
        $project=new Project($this->attributes);
        //sort
        $maxSort=Project::find()->where(["teamID"=>$this->teamID])->max("sort");
        $project->sort=$maxSort+1;
        if ($flag = $project->save()) {
            $this->setProject($project);
        }
        return $flag;
    }
    private function createDirectItem(){
        $project=$this->getProject();
        $item=new Item();
        $item->loadDefaultValues();
        $item->projectID=$project->id;
        $item->type=Item::PROJECT_DIRECT;
        return $item->save()?$item:false;
    }
    private function createRelevance(){
        $project=$this->getProject();
        $relevance=new Relevance([
            'model' => G::PROJECT,
            'value' => $project->id,
            'prevModel' => G::PROJECT,
            'prevValue' => $project->id,
            'teamID' => $project->teamID,
        ]);
        return $relevance->save();
    }
    private function createOperation($type){
        $project=$this->getProject();
        $textMap=[
            Operation::ADD=>"创建了项目",
            Operation::ARCHIVE=>"归档了项目",
            Operation::UN_ARCHIVE=>"重新激活了项目",
        ];
        $operation=new Operation([
            'userID' => \Yii::$app->user->id,
            'type' => $type,
            'text' => $textMap[$type],
            'value' => $project->id,
            'model' => G::PROJECT,
        ]);
        return $operation->save();
    }
    
    //--cache
    private $_project=false;

    /**
     * @return Project
     */
    public function getProject(){
        if($this->_project===false){
            $this->_project = Project::findOne($this->id);
        }
        return $this->_project;
    }
    public function setProject($project){
        $this->_project=$project;
    }
} 