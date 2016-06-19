<?php
namespace app\models\form;
use app\models\Ip;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class IpForm extends Ip{
    //--static
    const FIX = "fix";
    private static $fixApi="http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip={ip}";
    public static $queryScenarios=[];

    public function scenarios(){
        return [
            self::FIX=>["id"],
        ];
    }
    public function rules(){
        $rules=[
            ["id","required"],
            ["id","integer"],
            ["id","checkExist"],
        ];
        return array_merge(parent::rules(), $rules);
    }
    public function checkExist($attribute,$params){
        if($this->id){
            $ip=$this->getIp();
            if(!$ip){
                $message="请求的资源不存在";
                if(in_array($this->scenario,self::$queryScenarios)){
                    throw new NotFoundHttpException($message);
                }else{
                    $this->addError($attribute, $message);
                }
            }
        }
    }
    public function fix($validate=true){
        if($validate && !$this->validate()) return false;
        $ip=$this->getIp();
        //获取数据
        $url = strtr(self::$fixApi, ["{ip}" => $ip->value]);
        $data=@file_get_contents($url);
        $data = Json::decode($data);
        if($data["ret"]!=1) return false;
        $ip->area=$data["province"]==$data["province"]?"{$data["city"]}市":"{$data["province"]}省{$data["city"]}市";
        return $ip->save();
    }
    private $_ip=false;

    /**
     * @return Ip
     */
    private function getIp(){
        if($this->_ip===false){
            $this->_ip = Ip::findOne($this->id);
        }
        return $this->_ip;
    }
}