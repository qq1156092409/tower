<?php
namespace app\models\form;
use app\models\UserTeam;

class UserTeamForm extends UserTeam{
    const SUBGROUP = "subgroup";
    public function scenarios(){
        return [
            self::SUBGROUP=>["id","subgroupID"]
        ];
    }
    public function rules(){
        $rules=[
            ["id", "exist"],
            ["id", "checkID"],
            ["subgroupID","checkSubgroupID"]
        ];
        return array_merge($rules, parent::rules());
    }
    public function checkID($attribute){
        $userTeam=$this->getUserTeam();
        if(!UserTeam::findOne(["teamID"=>$userTeam->teamID,"userID"=>\Yii::$app->user->id])){
            $this->addError($attribute, "你不是我们机组的吧");
        }
    }
    public function checkSubgroupID($attribute){
        if($this->subgroupID==0) return;
        $userTeam=$this->getUserTeam();
        $subgroup=$this->subgroup;
        if($subgroup->teamID!=$userTeam->teamID){
            $this->addError($attribute, "你不是我们机组的吧");
        }
    }
    //--action
    public function subgroup($validate=true){
        if($validate && !$this->validate()) return false;
        $userTeam=$this->getUserTeam();
        $userTeam->subgroupID=$this->subgroupID;
        return $userTeam->save();
    }
    //--cache
    private $_userTeam=false;

    /**
     * @return UserTeam
     * @throws \yii\base\InvalidConfigException
     */
    public function getUserTeam(){
        if($this->_userTeam===false){
            $this->_userTeam = UserTeam::findOne($this->id);
        }
        return $this->_userTeam;
    }
}