<?php
use yii\helpers\Url;
use app\models\Project;
use app\models\Discuss;
/**
 * @var $project Project
 * @var $discusses Discuss[]
 */
?>
<div class="section-messages" data-droppable="">
    <h3 class="topics-head">
        <a class="title" href="<?=Url::to(["project/discusses","id"=>$project->id])?>">讨论</a>
        <a href="javascript:;" class="btn btn-mini btn-new-discussion" id="topic-create-show">发起讨论</a>
    </h3>
    <?=$this->render("/commons/_topicCreate",["projectID"=>$project->id])?>

    <div class="messages can-stick">
        <?php if($discusses){foreach($discusses as $discuss){
            echo $this->render("/commons/_discuss",["model"=>$discuss,"teamID"=>$project->teamID]);
        }}?>
        <div class="more">
            <a href="<?=Url::to(["project/discusses","id"=>$project->id])?>" class="link-more-topics">查看全部讨论</a>
        </div>
    </div>
</div>
