<?php
namespace app\models\form;

use app\models\Test2;

class Test2Form extends Test2 {
    const CREATE = "create";
    const EDIT = "edit";
    const DESTROY = "destroy";
    public function scenarios(){
        //todo finish me
        return [
            "create"=>[],
            "edit"=>[],
            "destroy"=>["id"],
        ];
    }
    public function rules(){
        $rules=[
            ["id","exist"],
        ];
        return array_merge($rules, parent::rules());
    }
    public function create($validate=true){
        if($validate && !$this->validate()) return false;
        $test2=new Test2();
        $test2->attributes=$this->attributes;
        if($flag=$test2->save()){
            $this->_test2=$test2;
            //create other
        }
        return $flag;
    }
    public function edit($validate=true){
        if($validate && !$this->validate()) return false;
        $test2=$this->getTest2();
        $test2->load($this->attributes,"");
        return $test2->save();
    }
    public function destroy($validate=true){
        if($validate && !$this->validate()) return false;
        $test2=$this->getTest2();
        if($flag=$test2->delete()){
            //delete others
        }
        return $flag;
    }
    public function loadValue(){
        $this->attributes=$this->getTest2()->attributes;
    }
    protected $_test2=false;

    /**
     * @return Test2
     * @throws \yii\base\InvalidConfigException
     */
    public function getTest2(){
        if($this->_test2===false){
            $this->_test2 = Test2::findOne($this->id);
        }
        return $this->_test2;
    }
}
