<?php

namespace app\components;
use app\models\User;
use \yii\filters\AccessRule as RawAccessRule;

/**
 * 用户身份过滤
 * 支持@1格式
 * 注意:identity必须实现getType()方法
 * Class AccessRule
 * @package app\components
 */
class AccessRule extends RawAccessRule{
    protected function matchRole($user){
        if(true===parent::matchRole($user)){
            return true;
        }
        /** @var User $identity */
        $identity=$user->identity;
        foreach($this->roles as $role){
            if($role[0] === '@'){
                $type=substr($role,1);
                if (!$user->getIsGuest() && $identity->getType()==$type) {
                    return true;
                }
            }
        }
        return false;
    }
} 