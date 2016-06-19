<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var string $name
 * @var string $message
 * @var Exception $exception
 */
echo $this->render("error".$exception->statusCode,[
    "name"=>$name,
    "message"=>$message,
    "exception"=>$exception,
]);
