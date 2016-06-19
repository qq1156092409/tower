<?php
namespace app\models\multiple;
interface TargetInterface{
    public function getProjectID();
    public function getProject();
    public function getViewUrl();
}