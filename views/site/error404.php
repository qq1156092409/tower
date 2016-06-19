<?php
/**
 * @var yii\web\View $this
 * @var string $name
 * @var string $message
 * @var Exception $exception
 */
$this->title="404 - 你访问的页面不存在";
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax">
        <div class="page-inner" id="page-404" data-page-name="404 - 你访问的页面不存在">
            <div class="content">
                <div class="error-404-gif" alt="404错误"></div>
                <p class="error-title"><b>“</b>喔嚄，我想它已经飞走了...吧？<b>”</b></p>
                <p class="error-desc">错误404: 你访问的页面不存在，<a href="javascript:history.back()">返回上页</a></p>
            </div>
        </div>
    </div>
</div>