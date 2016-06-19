<?php

namespace app\models\form;

use app\models\Test;

class TestForm extends Test {
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
        $test=new Test();
        $test->attributes=$this->attributes;
        if($flag=$test->save()){
            $this->_test=$test;
            //create other
        }
        return $flag;
    }
    public function edit($validate=true){
        if($validate && !$this->validate()) return false;
        $test=$this->getTest();
        $test->load($this->attributes,"");
        return $test->save();
    }
    public function destroy($validate=true){
        if($validate && !$this->validate()) return false;
        $test=$this->getTest();
        if($flag=$test->delete()){
            //delete others
        }
        return $flag;
    }
    public function loadValue(){
        $this->attributes=$this->getTest()->attributes;
    }
    protected $_test=false;

    /**
     * @return Test
     * @throws \yii\base\InvalidConfigException
     */
    public function getTest(){
        if($this->_test===false){
            $this->_test = Test::findOne($this->id);
        }
        return $this->_test;
    }
}