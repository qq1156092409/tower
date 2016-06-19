<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16-3-14
 * Time: 上午11:24
 */

namespace app\test\di;


class Eye2 implements EyeInterface{
    public function see(){
        echo "i am seeing 2<br>";
    }
} 