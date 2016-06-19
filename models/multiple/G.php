<?php
namespace app\models\multiple;

use app\models\Calendar;
use app\models\Collect;
use app\models\Comment;
use app\models\Discuss;
use app\models\Doc;
use app\models\Event;
use app\models\File;
use app\models\Item;
use app\models\Operation;
use app\models\Project;
use app\models\Task;
use app\models\Team;
use app\models\Topic;

/**
 * global
 * 全局常量定义
 */
class G {
    //models
    const TASK=1;
    const ITEM=2;
    const PROJECT=3;
    const TOPIC=4;
    const FILE=5;
    const EVENT=6;
    const DOC=7;
    const TEAM=8;
    const CALENDAR=9;
    const DISCUSS=10;

    //model.deleted
    const DELETED_NOT=0;//未删除
    const DELETED=1;//已删除

    const BD_API_KEY='d910a21e809e2c43e51a8e6171e996d7';//百度api-key

    /**
     * 数字与模型名称的转换
     * @param $from int|string
     * @return int|string|null
     */
    public static function transfer($from){
        if(is_numeric($from)){
            return self::getContent($from,"class");
        }else{
            $contents = self::getContent();
            foreach($contents as $content){
                if($content["class"]==$from){
                    return $content["id"];
                }
            }
        }
        return null;
    }

    /**
     * 根据属性排序 asc
     * @param array $models
     * @return array
     */
    public static function sortByUpdate(array $models){
        usort($models,function($a,$b){
            if($a->update==$b->update){
                return 0;
            }else{
                return $a->update>$b->update?1:-1;
            }
        });
        return $models;
    }

    /**
     * todo
     * 更新target的projectID
     * @param $model
     * @param $value
     * @param $projectID
     */
    public static function updateProjectID($model,$value,$projectID){
        Operation::updateAll(["projectID" => $projectID], ["model" => $model, "value" => $value]);
        Collect::updateAll(["projectID" => $projectID], ["model" => $model, "value" => $value]);
        Discuss::updateAll(["projectID" => $projectID], ["model" => $model, "value" => $value]);
    }
    public static function destroy($model,$value){
        Operation::deleteAll(["model"=>$model,"value"=>$value]);
        Comment::deleteAll(["model"=>$model,"value"=>$value]);
        Collect::deleteAll(["model"=>$model,"value"=>$value]);
        Discuss::deleteAll(["model"=>$model,"value"=>$value]);
    }
    public static function getContent($model=null,$attribute=null){
        $contents=[
            self::TASK=>[
                "id" => self::TASK,
                "class" => Task::className(),
                "name" => "task",
                "chinese" => "任务"
            ],
            self::ITEM=>[
                "id" => self::ITEM,
                "class" => Item::className(),
                "name" => "item",
                "chinese" => "清单"
            ],
            self::PROJECT=>[
                "id" => self::PROJECT,
                "class" => Project::className(),
                "name" => "project",
                "chinese" => "项目"
            ],
            self::TOPIC=>[
                "id" => self::TOPIC,
                "class" => Topic::className(),
                "name" => "topic",
                "chinese" => "话题"
            ],
            self::FILE=>[
                "id" => self::FILE,
                "class" => File::className(),
                "name" => "file",
                "chinese" => "文件"
            ],
            self::EVENT=>[
                "id" => self::EVENT,
                "class" => Event::className(),
                "name" => "event",
                "chinese" => "日程"
            ],
            self::DOC=>[
                "id" => self::DOC,
                "class" => Doc::className(),
                "name" => "doc",
                "chinese" => "文档"
            ],
            self::TEAM=>[
                "id" => self::TEAM,
                "class" => Team::className(),
                "name" => "team",
                "chinese" => "团队"
            ],
            self::CALENDAR=>[
                "id" => self::CALENDAR,
                "class" => Calendar::className(),
                "name" => "calendar",
                "chinese" => "日历"
            ],
            self::DISCUSS=>[
                "id" => self::DISCUSS,
                "class" => Discuss::className(),
                "name" => "discuss",
                "chinese" => "讨论"
            ],
        ];
        if($model&&$attribute){
            return $contents[$model][$attribute];
        }elseif($model){
            return $contents[$model];
        }else{
            return $contents;
        }
    }
}