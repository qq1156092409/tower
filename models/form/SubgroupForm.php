<?php

namespace app\models\form;


use app\models\Subgroup;
use app\models\UserTeam;

class SubgroupForm extends Subgroup {
    const CREATE = "create";
    const DESTROY = "destroy";
    const EDIT = "edit";
    const SORT = "sort";

    public $prevID;
    public function scenarios(){
        return [
            self::CREATE=>["teamID","name"],
            self::DESTROY => ["id"],
            self::EDIT => ["id", "name"],
            self::SORT=>["id","prevID"],
        ];
    }
    public function rules(){
        $rules=[
            ["prevID","checkPrevID"]
        ];
        return array_merge($rules, parent::rules());
    }
    public function checkPrevID($attribute){
        if($this->prevID){
            $prev = Subgroup::findOne($this->prevID);
            $subgroup=$this->getSubgroup();
            if($prev->teamID!=$subgroup->teamID){
                $this->addError($attribute, "你不是我们机组的吧");
            }
        }
    }
    public function create($validate=true){
        if($validate && !$this->validate()) return false;
        $subgroup=new Subgroup($this->attributes);
        $maxSort=Subgroup::find()->where([
            "teamID"=>$subgroup->teamID,
        ])->max("sort");
        $subgroup->sort=$maxSort?($maxSort+1):1;
        if($flag=$subgroup->save()){
            $this->_subgroup=$subgroup;
        }
        return $flag;
    }
    public function destroy($validate=true){
        if($validate && !$this->validate()) return false;
        $subgroup=$this->getSubgroup();
        if($flag=$subgroup->delete()){
            UserTeam::updateAll(["subgroupID"=>0],["subgroupID"=>$subgroup->id]);
        }
        return $flag;
    }
    public function edit($validate=true){
        if($validate && !$this->validate()) return false;
        $subgroup=$this->getSubgroup();
        $subgroup->name=$this->name;
        return $subgroup->save();
    }
    public function sort($validate=true){
        if($validate && !$this->validate()) return false;
        $subgroup=$this->getSubgroup();
        $prev=Subgroup::findOne($this->prevID);
        $subgroup->sort=$prev?($prev->sort+1):1;
        if($flag=$subgroup->save()){
            if(Subgroup::find()->where(["teamID"=>$subgroup->teamID,"sort"=>$subgroup->sort])->count()>1){
                $condition="teamID={$subgroup->teamID} and sort >= {$subgroup->sort} and id!={$subgroup->id}";
                Subgroup::updateAllCounters(["sort" => 1], $condition);
            }
        }
        return $flag;
    }
    private $_subgroup=false;

    /**
     * @return Subgroup
     * @throws \yii\base\InvalidConfigException
     */
    public function getSubgroup(){
        if($this->_subgroup===false){
            $this->_subgroup = Subgroup::findOne($this->id);
        }
        return $this->_subgroup;
    }

}