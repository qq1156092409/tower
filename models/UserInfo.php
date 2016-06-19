<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_info".
 *
 * @property integer $id
 * @property integer $userID
 * @property integer $type
 * @property string $create
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'type'], 'integer'],
            [['create'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userID' => 'User ID',
            'type' => 'Type',
            'create' => 'Create',
        ];
    }

    //--static
    const COMMON=1;
    const ADMIN=2;
    public static $types=[
        self::COMMON=>"用户",
        self::ADMIN=>"管理员",
    ];
    //--relation
    public function getUser(){
        return $this->hasOne(User::className(),["id"=>"userID"]);
    }
}
