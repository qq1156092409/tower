<?php
namespace app\models\form;

use app\models\Project;
use app\models\Team;
use app\models\UserProject;
use app\models\UserTeam;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class TeamForm extends Team{
    const CREATE = "create";
    const EDIT = "edit";
    const VIEW = "view";

    public function scenarios(){
        return [
            self::CREATE=>["name"],
            self::EDIT=>["id","name"],
            self::VIEW=>['id'],
        ];
    }
    public function rules(){
        $rules=[
            [["id","name"],"required"],
            ["id","number"],
            ["id","checkExist"],
            ["id","checkAuth"],
        ];
        return array_merge($rules,parent::rules());
    }
    private static $queryScenarios=[self::VIEW];
    public function checkExist($attribute,$params){
        if(is_numeric($this->id)){
            if(!$this->getTeam()){
                if(in_array($this->scenario,self::$queryScenarios)){
                    throw new NotFoundHttpException();
                }else{
                    $this->addError($attribute, "你访问的资源未找到");
                }
            }
        }
    }
    public function checkAuth($attribute,$params){
        if(is_numeric($this->id)){
            if(!UserTeam::findOne(["userID"=>\Yii::$app->user->id,"teamID"=>$this->id])){
                if(in_array($this->scenario,self::$queryScenarios)){
                    throw new ForbiddenHttpException();
                }else{
                    $this->addError($attribute, "你不是我们机组的吧");
                }
            }
        }
    }

    /**
     * 创建团队
     * 加入团队（超级管理员）,创建示例项目，加入项目
     * @param $validate bool
     * @return bool
     */
    public function create($validate=true){
        if($validate && !$this->validate()) return false;
        if($flag=$this->createTeam()){
            $this->createUserTeam();
            $this->createSampleProject();
        }
        return $flag;
    }
    public function edit($validate=true){
        if($validate && !$this->validate()) return false;
        $team=$this->getTeam();
        $team->name=$this->name;
        return $team->save();
    }

    private function createTeam(){
        $team=new Team($this->attributes);
        $team->creatorID=\Yii::$app->user->id;
        $team->create = date("Y-m-d H:i:s");
        if($flag=$team->save()){
            $this->setTeam($team);
        }
        return $flag;
    }
    private function createUserTeam(){
        $team=$this->getTeam();
        $userTeam=new UserTeam([
            'userID' => \Yii::$app->user->id,
            'teamID' => $team->id,
            'type' =>UserTeam::SUPER_ADMIN,
        ]);
        return $userTeam->save()?$userTeam:false;
    }
    private function createSampleProject(){
        $team=$this->getTeam();
        $model=new ProjectForm([
            "teamID"=>$team->id,
            "name"=>"熟悉Tower",
            "description"=>"工欲善其事，必先利其器",
            "type"=>Project::SAMPLE,
        ]);
        if($flag=$model->create(false)){
            //create other
        }
        return $flag;
    }

    private $_team=false;

    /**
     * @return Team
     */
    public function getTeam(){
        if($this->_team===false){
            $this->_team = Team::findOne($this->id);
        }
        return $this->_team;
    }
    public function setTeam($team){
        $this->_team=$team;
        return $this;
    }
} 