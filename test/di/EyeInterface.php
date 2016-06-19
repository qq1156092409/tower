<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16-3-14
 * Time: 上午11:29
 */

namespace app\test\di;


interface EyeInterface {
    public function see();
}
//定义唯一实现类
\Yii::$container->set('app\test\di\EyeInterface',[
    "class"=>'app\test\di\Eye',
]);