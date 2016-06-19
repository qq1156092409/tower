<?php

namespace app\commands;

use app\models\Collect;
use app\models\Comment;
use app\models\Discuss;
use app\models\File;
use app\models\Item;
use app\models\multiple\G;
use app\models\Operation;
use app\models\Relevance;
use app\models\Task;
use yii\console\Controller;
use app\models\Dir;
use app\models\Doc;
use app\models\Event;
use app\models\Project;
use app\models\Team;
use app\models\Topic;
use app\models\UserTeam;
use yii\helpers\ArrayHelper;

class FixController extends Controller{
    /**
     * 删除错误item
     */
    public function actionItem(){
        $items=Item::findAll(["projectID"=>0]);

        $itemIDs=ArrayHelper::getColumn($items, "id");
        if($itemIDs){
            $tasks = Task::findAll(["itemID" => $itemIDs]);
            $taskIDs = ArrayHelper::getColumn($tasks, "id");

            Item::deleteAll(["projectID"=>0]);
            Relevance::deleteAll(["model" => G::ITEM, "value" => $itemIDs]);
            Discuss::deleteAll(["model" => G::ITEM, "value" => $itemIDs]);
            Operation::deleteAll(["model" => G::ITEM, "value" => $itemIDs]);
            Comment::deleteAll(["model" => G::ITEM, "value" => $itemIDs]);
            Collect::deleteAll(["model" => G::ITEM, "value" => $itemIDs]);
            if($taskIDs){
                Task::deleteAll(["id"=>$taskIDs]);
                Relevance::deleteAll(["model" => G::TASK, "value" => $taskIDs]);
                Discuss::deleteAll(["model" => G::TASK, "value" => $taskIDs]);
                Operation::deleteAll(["model" => G::TASK, "value" => $taskIDs]);
                Comment::deleteAll(["model" => G::TASK, "value" => $taskIDs]);
                Collect::deleteAll(["model" => G::TASK, "value" => $taskIDs]);
            }
        }
        echo count($itemIDs);
    }
    public function actionTaskRelevance(){
        $tasks=Task::find()->joinWith(["relevance"])->where(
            "relevance.id is null"
        )->all();
        echo count($tasks);
        foreach($tasks as $task){
            $relevance=new Relevance([
                'model' => G::transfer($task->className()),
                'value' => $task->id,
                'prevModel' => G::PROJECT,
                'prevValue' => $task->projectID,
                'teamID' => $task->project->teamID,
            ]);
            $relevance->save();
        }
    }
    public function actionTeam(){
        $teams = Team::findAll(["creatorID"=>0]);
        foreach($teams as $team){
            $member = UserTeam::findOne(["teamID"=>$team->id,"type"=>UserTeam::SUPER_ADMIN]);
            $team->creatorID=$member->userID;
            echo $team->save()?$team->id:"0";
            echo "<br>";
        }
    }
    public function actionDir(){
        $dirs=Dir::findAll(["link"=>null]);
        foreach($dirs as $dir){
            if($dir->parentID){
                $dir->link=$dir->parent->link.$dir->parentID."-";
            }else{
                $dir->link="-";
            }
            echo $dir->save()?$dir->id:"fail";
            echo "<br>";
        }
    }
    public function actionTopicRelevance(){
        $topics=Topic::find()->joinWith(["relevance"])->where(
            "relevance.id is null"
        )->all();
        echo count($topics);
        foreach($topics as $topic){
            $relevance=new Relevance([
                'model' => G::transfer($topic->className()),
                'value' => $topic->id,
                'prevModel' => G::PROJECT,
                'prevValue' => $topic->projectID,
                'teamID' => $topic->project->teamID,
            ]);
            $relevance->save();
        }
    }
    public function actionProjectRelevance(){
        /** @var Project[] $projects */
        $projects=Project::find()->joinWith(["relevance"])->where(
            "relevance.id is null"
        )->all();
        echo count($projects);
        foreach($projects as $project){
            $relevance=new Relevance([
                'model' => G::transfer($project->className()),
                'value' => $project->id,
                'prevModel' => G::PROJECT,
                'prevValue' => $project->id,
                'teamID' => $project->teamID,
            ]);
            $relevance->save();
        }
    }
    public function actionSubgroupSort(){
        $teams = Team::find()->all();
        foreach($teams as $team){
            foreach($team->subgroups as $k=>$subgroup){
                $subgroup->sort=$k+1;
                $subgroup->save();
            }
        }
    }
    public function actionEventRelevance(){
        $events=Event::find()->joinWith(["relevance"])->where(
            "relevance.id is null"
        )->all();
        echo count($events);
        foreach($events as $event){
            $relevance=new Relevance([
                'model' => G::transfer($event->className()),
                'value' => $event->id,
                'prevModel' => G::CALENDAR,
                'prevValue' => $event->calendarID,
                'teamID' => $event->calendar->teamID,
            ]);
            $relevance->save();
        }
    }
    public function actionDocRelevance(){
        /** @var Doc[] $docs */
        $docs=Doc::find()->joinWith(["relevance"])->where(
            "relevance.id is null"
        )->all();
        echo count($docs);
        foreach($docs as $doc){
            $relevance=new Relevance([
                'model' => G::transfer($doc->className()),
                'value' => $doc->id,
                'prevModel' => G::PROJECT,
                'prevValue' => $doc->projectID,
                'teamID' => $doc->project->teamID,
            ]);
            $relevance->save();
        }
    }
    public function actionCommentCount(){
        $tasks = Task::find()->each();
        $total=$count=0;
        foreach($tasks as $task){
            $total++;
            $task->commentCount=Operation::find()->where(["model"=>G::TASK,"value"=>$task->id])->count();
            $task->save() and $count++;
        }
        echo json_encode(["total"=>$total,"count"=>$count]);
    }
    public function actionFileExtension(){
        /** @var File[] $files */
        $files=File::find()->each();
        foreach($files as $file){
            $file->extension = pathinfo($file->temp, PATHINFO_EXTENSION);
            $file->save();
        }
        echo "success";
    }
    public function actionFileImg(){
        $a='bmp jpg jpeg png gif';//图片
        $b='mp3 wav wma asf';//音频
        $c='mp4 avi rmvb rm';//视频
        $d='doc docx xls xlsx ppt pptx';//office
        $e='zip rar 7z cab iso';//压缩
        $f='txt pdf';//文档
        $g='swf flv';//flash
        $url2='https://tower.im/assets/file_icons/file_extension_{extension}.png';
        $file2='web/public/file_icons/file_extension_{extension}.png';
        $extensions2=[$a,$b,$c,$d,$e,$f,$g];
        $extensions=[];
        foreach($extensions2 as $extension2){
            $extensions=array_merge($extensions,explode(" ",$extension2));
        }
        $extensions = array_unique(array_filter($extensions));
        foreach($extensions as $extension){
            $url=strtr($url2,['{extension}'=>$extension]);
            $file=strtr($file2,['{extension}'=>$extension]);
            if(!file_exists($file)){
                $content=file_get_contents($url);
                if($content!="404"){
                    $handle=fopen($file,"w");
                    fwrite($handle, $content);
                }
            }
        }
    }
    public function actionProjectSort(){
        //update project set sort=id
    }
}