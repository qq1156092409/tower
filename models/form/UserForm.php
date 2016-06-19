<?php

namespace app\models\form;

use app\models\User;
use yii\helpers\Security;

class UserForm extends User{
    const LOGIN="login";
    public $remember=true;

    public function scenarios(){
        return [
            self::LOGIN=>["name","password","remember"],
        ];
    }
    public function rules(){
        $rules=[
            [["name","password"],"required","on"=>self::LOGIN],
            ["name","exist"],
            ["password","checkPassword"],
        ];
        return array_merge($rules,parent::rules());
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function checkPassword($attribute,$params){
        if($this->password!=""){
            $user=$this->getUser();
            $salt=substr($user->password,32);
            if(md5($this->password.$salt).$salt!==$user->password){
                $this->addError($attribute, "密码错误");
            }
        }
    }

    public function login(){
        if($this->validate()){
            return \Yii::$app->user->login($this->getUser(), $this->remember ? 3600 * 24 * 30:0);
        }
        return false;
    }

    /**
     * @var User
     */
    public $_user=false;
    public function getUser(){
        if($this->_user===false){
            $this->_user = User::findOne(["name" => $this->name]);
        }
        return $this->_user;
    }
} 