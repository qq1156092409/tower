<?php
namespace app\models\form;
use app\models\Collect;
use app\models\UserTeam;

class CollectForm extends Collect{
    const TOGGLE = "toggle";
    public function scenarios(){
        return [
            self::TOGGLE=>["model","value"],
        ];
    }
    public function rules(){
        return [
            [["model","value"],"required"],
            ["model","checkTarget"]
        ];
    }
    public function checkTarget($attribute){
        if(!$target=$this->target){
            $this->addError($attribute, "资源不存在");return;
        }
        if (!UserTeam::findOne(["userID" => \Yii::$app->user->id, "teamID" => $target->relevance->teamID])) {
            $this->addError($attribute, "你不是我们机组的吧");return;
        }
    }

    public function toggle($validate=true){
        if($validate && !$this->validate()) return false;
        if($collect=$this->getCollect()){
            return $collect->delete();
        }else{
            return $this->createCollect();
        }
    }
    private function createCollect(){
        $collect=new Collect($this->attributes);
        $collect->userID=\Yii::$app->user->id;
        if($flag=$collect->save()){
            $this->_collect=$collect;
            $this->_has=true;
        }
        return $flag;
    }

    private $_collect=false;
    private $_has=false;

    /**
     * @return Collect
     */
    public function getCollect(){
        if($this->_collect===false){
            $this->_collect = Collect::findOne(["model" => $this->model, "value" => $this->value, "userID" => \Yii::$app->user->id]);
        }
        return $this->_collect;
    }
    public function has(){
        return $this->_has;
    }
}