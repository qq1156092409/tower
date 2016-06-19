<?php

namespace app\models;

use app\helpers\TimeHelper;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "user_log".
 *
 * @property integer $id
 * @property string $agent
 * @property string $create
 * @property integer $userID
 * @property integer $type
 * @property integer $ipID
 *
 * @property string simpleAgent
 * @property string fuzzyCreate
 */
class UserLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.user_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agent', 'create', 'userID'], 'required'],
            [['create'], 'safe'],
            [['userID', 'type', 'ipID'], 'integer'],
            [['agent'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agent' => 'Agent',
            'create' => 'Create',
            'userID' => 'User ID',
            'type' => 'Type',
            'ipID' => 'Ip ID',
        ];
    }

    //--attribute
    const LOGIN=1;//登录
    //--action
    /**
     * 创建记录，异步fix
     * @param $attributes
     * @return UserLog|bool
     */
    public static function create($attributes){
        $userLog=new UserLog();
        $userLog->load($attributes,"");
        $userLog->create or $userLog->create=date("Y-m-d H:i:s");
        if($flag=$userLog->save()){
            //create other
        }
        return $flag?$userLog:false;
    }
    //--get
    public function getIpDetail(){
        $detail=[];
        $detail["ip"]=$this->ip;
        $ipLookObj = json_decode($this->ipLook);
        $detail["province"]=$ipLookObj->province;
        $detail["city"]=$ipLookObj->city;
        return $detail;
    }
    /**
     * 地址和ip
     * @return string
     */
    public function getAddressIp(){
        $template="{address}({ip})";
        return strtr($template,[
            "{address}"=>$this->ip->area,
            "{ip}"=>$this->ip->value,
        ]);
    }
    /**
     * 获取设备信息
     * todo finish me
     * @refer http://www.jb51.net/article/31178.htm
     */
    public function getSimpleAgent(){
        return $this->id%2==0?"android":"Windows/Windows 7, Chrome";
    }
    public function getFuzzyCreate(){
        return TimeHelper::getFuzzyTime($this->create);
    }
    //--relation
    public function getUser(){
        return $this->hasOne(User::className(), ["id" => "userID"]);
    }
    public function getIp(){
        return $this->hasOne(Ip::className(), ["id" => "ipID"]);
    }
}
