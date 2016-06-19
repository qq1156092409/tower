<?php
use app\models\Operation;
use app\models\Project;
/**
 * @var $trashOperations Operation[]
 * @var $teamID int
 * @var $project Project
 */
$this->title ='回收站';
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax page-behind">
        <a class="link-page-behind" data-stack="" href="<?=$project->getViewUrl()?>"><?=$project->name?></a>
    </div>
    <div class="page page-1 simple-pjax">
        <div class="page-inner" id="page-trash" data-page-name="回收站">

            <div class="title">
                <h3>回收站</h3>
                <p class="desc">项目中被删除的任务、讨论、文件和附件都能在这里找到并恢复。</p>
            </div>
            <?php foreach($trashOperations as $day => $operations){ ?>
                <div class="day" data-date="<?=$day?>">
                    <div class="hd">
                        <span class="m-d"><?=date("m/d",strtotime($day))?></span>
                        <span class="w">周<?=mb_substr( "日一二三四五六",date("w",strtotime($day)),1,"utf-8" )?></span>
                    </div>
                    <ul class="bd">
                        <?php foreach($operations as $operation){ ?>
                            <li class="trash-item">
                                <span class="time"><?=date("H:i",strtotime($operation->create))?></span>
                            <span class="txt">
                                <em class="member">
                                    <a href="/members/f4880b71a92642c293ca7efc1f2256d9" data-stack-root="true"
                                       data-stack="true"><?=$operation->user->activeName?></a>
                                </em>
                                <?=$operation->type==Operation::DISABLE?"删除":"恢复"?>了：
                                <a href="<?=$operation->target->getViewUrl($teamID)?>" data-stack="true" title="<?= $operation->target->name?>"><?=$operation->target->name?></a>
                            </span>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
</div>