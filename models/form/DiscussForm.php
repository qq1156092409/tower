<?php

namespace app\models\form;
use app\models\Discuss;
use app\models\UserTeam;

class DiscussForm extends Discuss{
    const TOGGLE_TOP = "toggleTop";
    const TOGGLE_ARCHIVE = "toggleArchive";
    public function scenarios(){
        return [
            self::TOGGLE_ARCHIVE=>["id"],
            self::TOGGLE_TOP=>["id"],
        ];
    }
    public function rules(){
        $rules=[
            ["id","required"],
            ["id","exist"],
            ["id","checkID"],
        ];
        return array_merge($rules, parent::rules());
    }
    public function checkID($attribute){
        $discuss=$this->getDiscuss();
        if(!UserTeam::findOne(["userID"=>\Yii::$app->user->id,"teamID"=>$discuss->relevance->teamID])){
            $this->addError($attribute, "你不是我们机组的吧");
        }
    }
    //--action
    public function toggleTop($validate=true){
        if($validate && !$this->validate()) return false;
        $discuss=$this->getDiscuss();
        $discuss->order=$discuss->order?0:time();
        return $discuss->save();
    }
    public function toggleArchive($validate=true){
        if($validate && !$this->validate()) return false;
        $discuss=$this->getDiscuss();
        $discuss->archive=($discuss->archive+1)%2;
        return $discuss->save();
    }
    //--cache
    private $_discuss=false;

    /**
     * @return Discuss
     * @throws \yii\base\InvalidConfigException
     */
    public function getDiscuss(){
        if($this->_discuss===false){
            $this->_discuss = Discuss::findOne($this->id);
        }
        return $this->_discuss;
    }
}