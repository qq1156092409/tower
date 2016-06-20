<?php
namespace app\components;
use yii\db\ActiveRecord;

/**
 * redis�����Ծ��¼
 * ��ȡ����ʱ���ȴ�redis�л�ȡ����������ڣ����mysql�в�ѯ����ӵ�redis��
 * Class RedisActiveRecord
 * @package app\components
 */
abstract class RedisActiveRecord extends ActiveRecord implements IRedisActiveRecord{
    private static $_redis=false;
    private static function getRedis(){
        if(self::$_redis===false){
            $redis=new \Redis();
            $redis->connect('127.0.0.1',6379);
            self::$_redis=$redis;
        }
        return self::$_redis;
    }
    public static function findOne($condition){
        $redis=self::getRedis();
        $key=static::getRedisKey();
        if(is_numeric($condition) && $redis->hExists($key,$condition)){
            return unserialize($redis->hGet($key,$condition));
        }
        $one=parent::findOne($condition);
        $one and $redis->hSet($key, $one->id,serialize($one));
        return $one;
    }
}
interface IRedisActiveRecord{
    public static function getRedisKey();
}