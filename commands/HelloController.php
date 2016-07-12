<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Operation;
use yii\console\Controller;
use yii\db\Connection;
use yii\helpers\FileHelper;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }
    public function actionDjq($a,$b,$c){
        echo "haha\n";
        echo "$a-$b-$c";
        return 0;
    }
    public function actionDjq2(){
        print_r(\Yii::$app->getRequest()->getParams());
        return 0;
    }
    public function actionBatchInsert(){
        /** @var Connection $connection */
        $connection=\Yii::$app->db;
        $datas=[];
        for($i=1;$i<=10000;$i++){
            $datas[]=["name".$i,"description".$i];
        }
        $sql= $connection->queryBuilder->batchInsert("test",["name","description"],$datas);
        $command=$connection->createCommand($sql);
        for($i=1;$i<1000;$i++){
            $command->execute();
        }
        return 0;
    }
}
