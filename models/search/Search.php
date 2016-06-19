<?php
namespace app\models\search;

use app\models\Relevance;
use app\models\UserTeam;
use app\vendor\sphinx\SphinxClient;

class Search extends Relevance{
    public $keyword;
    public $order;

    public function scenarios(){
        return [
            "search"=>["teamID","keyword","order"],
        ];
    }
    public function preprocess(){
        is_string($this->keyword) and $this->keyword=trim($this->keyword);
    }
    public function beforeValidate(){
        $flag=parent::beforeValidate();
        $this->preprocess();
        return $flag;
    }
    public function rules(){
        return [

            ["teamID","required"],
            [["teamID"],"integer"],
            ["teamID","checkTeamID"],
        ];
    }
    public function checkTeamID($attribute,$params){
        if($this->teamID){
            $userTeam=UserTeam::findOne(["teamID"=>$this->teamID,"userID"=>\Yii::$app->user->id]);
            if(!$userTeam){
                $this->addError($attribute, "你不是我们机组的吧");
            }
        }
    }

    /**
     * 查询 todo
     * @param bool|true $validate
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidParamException
     */
    public function search($validate=true){
        if($validate && !$this->validate()) return false;
        if($this->keyword){
            $sphinx=new SphinxClient();
            $sphinx->SetFilter("teamID",[$this->teamID]);
            $this->_data = $sphinx->Query($this->keyword, "tower");
            $this->_data["matches"] and $this->_relevances=Relevance::findAll(array_keys($this->_data["matches"]));
        }
        return true;
    }
    private $_relevances=[];
    private $_data=[];
    public function getRelevances(){
        return $this->_relevances;
    }
    public function getData(){
        return $this->_data;
    }
}