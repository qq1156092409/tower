<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_comment".
 *
 * @property integer $id
 * @property integer $userID
 * @property integer $commentID
 */
class UserComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.user_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'commentID'], 'integer']
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
            'commentID' => 'Comment ID',
        ];
    }
    //--relation
    public function getUser(){
        return $this->hasOne(User::className(),["id"=>"userID"]);
    }
    public function getComment(){
        return $this->hasOne(Comment::className(),["id"=>"commentID"]);
    }
}
