<?php
namespace app\controllers;

use app\assets\ZeptoAsset;
use app\components\JsManager;
use app\helpers\ImageHelper;
use app\models\Area;
use app\models\Dir;
use app\models\form\DirForm;
use app\models\form\GzhForm;
use app\models\Ip;
use app\models\Task;
use app\models\Test2;
use app\models\User;
use app\vendor\sphinx\SphinxClient;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\ExitException;
use yii\base\NotSupportedException;
use yii\db\Connection;
use yii\db\Query;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Cookie;
use yii\web\Response;
use yii\gii\CodeFile;
use yii\web\Controller;
use Yii;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\JqueryAsset;
use yii\web\NotFoundHttpException;
use app\models\UserInfo;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use app\models\Test;

class DjqController extends Controller{
    public function actionIndex(){
        echo "haha";exit;
        echo "<pre>";
        print_r($_COOKIE);exit;
        $cookies=Yii::$app->request->getCookies();
        print_r($cookies);exit;
//        echo "<pre>";
//        print_r(Yii::$app->user);
        Yii::$app->end();
        return $this->render("djq", [
        ]);
    }
    public function actionRedis(){
        $redis=new \Redis();
        $redis->connect("120.25.240.36",6379);
//        $redis->set("haha", "haha".date("Y-m-d H:i:s"));
        echo $redis->get("haha");
    }
    public function actionTransaction(){
        $transaction=Yii::$app->db->beginTransaction();
        try{
            $test=new Test2();
            $test->id=1;
            $test->name = "djq".rand(1,100);
            $test->setIsNewRecord(false);
            $test->save();

            $test2=new Test2();
            $test2->name = "djq".rand(1,100);
            $test2->save();

            $transaction->commit();
            echo "success";
        }catch(Exception $e){
            $transaction->rollBack();
            echo "fail";
        }
        return $this->render("djq", [
        ]);
    }
    public function actionGuzzle(){
        $client = new Client();
        $res = $client->request('GET', 'http://localhost/phpmyadmin/sql.php?server=1&db=tower&table=area&pos=0&token=2240ea940b3e39ab55807eb09ed7c1f7', [
            'auth' => ['user', 'pass']
        ]);
        echo $res->getStatusCode();
// "200"
        echo $res->getHeader('content-type');
// 'application/json; charset=utf8'
        echo $res->getBody();
// {"type":"User"...'

// Send an asynchronous request.
        $request = new Request('GET', 'http://httpbin.org');
        $promise = $client->sendAsync($request)->then(function ($response) {
            echo 'I completed! ' . $response->getBody();
        });
        $promise->wait();
    }
    public function actionTest(){
        if(Yii::$app->request->isPost){
            Yii::$app->response->format=Response::FORMAT_JSON;
            return $_FILES;
        }
        return $this->render("test");
    }
    /**
     * 下载css内的资源文件
     * 读取-截取-下载-替换
     */
    public function actionCssResource(){
        echo "success";
        Yii::$app->end();
        $css = "@webroot/public/application-404f5efaeb2aead3434d85ff01eddcef.css";
        $css = \Yii::getAlias($css);
        $content = file_get_contents($css);
//        $pattern='/url\(h.*\)/U';//url(h...)
        $pattern2 = '/https[^\)]*/';//http..
        preg_match_all($pattern2, $content, $matches);
//        echo "<pre>";print_r($matches);exit;
        $a = 'https://tower.im/assets';
        $b = Yii::getAlias("@webroot/public/css_resource");
        $c = "css_resource";
        $total = count($matches[0]);
        $count = 0;
        $has = 0;
        foreach ($matches[0] as $k => $match) {
            $fileName = strtr($match, [$a => $b, '?#iefix' => ""]);
            if (file_exists($fileName)) {
                $has++;
                continue;
            }
            file_put_contents($fileName, file_get_contents($match));
            $count++;
        }
        //替换
        file_put_contents($css, strtr($content, [$a => $c, '?#iefix' => ""]));
        print_r(["total" => $total, "count" => $count, "has" => $has]);
    }

    public function actionKfc()
    {
        $cache = Yii::$app->cache;
        if (!$kfc = $cache->get("kfc")) {
            $cache->set("kfc", file_get_contents("http://www.5ikfc.com/kfc/"));
            $kfc = $cache->get("kfc");
        }
        $data = ["kfc" => $kfc];
        return $this->render("djq", [
            "data" => $data,
        ]);
    }

    public function actionSocket()
    {
        $client = stream_socket_client('tcp://127.0.0.1:1236');
        if (!$client) exit("can not connect");
        fwrite($client, '{"type":"say","content":"hello all apache","to_client_id":"all","to_client_name":"all"}' . "\n");
    }

    public function test()
    {
        $args = func_get_args();
        echo "<pre>";
        print_r($args);
    }

    public function actionDraggable()
    {
        return $this->render("draggable");
    }

    public function actionInfo()
    {
        phpinfo();
    }

    public function actionZip()
    {
        $zip = new \ZipArchive();
        if ($zip->open('test2.zip', \ZipArchive::CREATE) === TRUE) { //然后查看是否存在test.zip这个压缩包
            echo $zip->addFile('robots.txt', "haha/robots2.txt") ? 1 : 0;
            $zip->close(); //关闭
            echo 'ok' . date("Y-m-d H:i:s");
        } else {
            echo 'failed';
        }
    }

    /**
     * @param $roleObj Dir
     * @param $resultStr
     */
    public function explodeRole($roleObj, &$resultStr)
    {
        if (0 < count($roleObj->children)) {
            foreach ($roleObj->children as $childRoleObj) {
                if ('' == $resultStr) {
                    $resultStr .= "{$childRoleObj->id}";
                } else {
                    $resultStr .= ", {$childRoleObj->id}";
                }
                $this->explodeRole($childRoleObj, $resultStr);
            }
        }
    }

    public function actionSimditor()
    {
        return $this->render("simditor");
    }

    public function actionDownload()
    {
        $file_name = "test1.mp4";
        if (!file_exists($file_name)) {
            echo "文件不存在";
            exit();
        }
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: " . filesize($file_name));
        header("Content-Disposition: attachment; filename=" . $file_name);
        $fp = fopen($file_name, "r+");
        while (!feof($fp)) {
            $file_data = fread($fp, 1024);
            echo $file_data;
        }
        fclose($fp);
    }

    public function calendar($month = null)
    {
        $firstDay = strtotime($month ? $month . '-01' : date("Y-m-01"));//这个月的一号,时间戳
        $offset = (date("w", $firstDay) + 6) % 7;
        $first = strtotime("-$offset days", $firstDay);//月历上的第一天,时间戳
        $dayCount = cal_days_in_month(CAL_GREGORIAN, date("m", $firstDay), date("Y", $firstDay));
        $length = ($dayCount + $offset) > 35 ? 42 : 35;
        $days = [];
        for ($i = 0; $i < $length; $i++) {
            $days[] = date("Y-m-d", strtotime("+$i days", $first));
        }
        return array_chunk($days, 7);
    }
    public function actionUserInfo(){
        $users=User::find()->all();
        foreach($users as $user){
            if(!$user->userInfo){
                $userInfo=new UserInfo();
                $userInfo->userID=$user->id;
                $userInfo->type=UserInfo::COMMON;
                $userInfo->create=date("Y-m-d H:i:s");
                $userInfo->save();
            }
        }
    }
    public function actionFileInput(){
        return $this->render("fileInput");
    }
    public function actionHaha(){
        echo "haha";
    }
    public function actionSphinx(){
        $sphinx=new SphinxClient();
        $sphinx->SetGroupBy("value",SPH_GROUPBY_ATTR);
        $result=$sphinx->Query("1", "tower");
        echo "<pre>";print_r($result);
    }
}