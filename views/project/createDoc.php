<?php
use yii\helpers\Url;
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15-4-30
 * Time: 上午9:22
 */
$request=Yii::$app->request;
?>
<!DOCTYPE html>
<html>
<head>
    <title>创建新文档 - Tower</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="baidu-site-verification" content="qLDoHdGnb64RHlkm">
    <meta name="alexaVerifyID" content="SIgQikd9LazsFz9M1vPBaQyC4Gw">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" sizes="32x32">
    <link rel="icon" href="/favicon.ico" sizes="64x64">
    <link rel="icon" href="/favicon.ico" sizes="128x128">
    <link rel="apple-touch-icon-precomposed" href="/assets/mobile/icon/icon@512-c8090c0961c63b1549cd19d714c6b69e.png">

    <link href="public/popwindow.css" media="all" rel="stylesheet" type="text/css">
    <link href="public/doc-editor.css" media="all" rel="stylesheet" type="text/css">


    <meta content="authenticity_token" name="csrf-param">
    <meta content="Uf0QA6rCVhI9W7A584R25wIRbqxH0atE5xHzj3IMDGs=" name="csrf-token">
</head>
<body class="win" style="zoom: 1;">

<div class="wrapper">

    <div class="container">
        <div class="page">
            <div class="page-inner" id="page-doc-new">
                <div class="doc-wrap">
                    <form id="form-doc-create" class="form form-edit-doc" action=""
                          data-draft-name="/projects/31cfd5556a4543b68cb489a242b1e9e7/docs/new/html"
                          data-target-url="/projects/31cfd5556a4543b68cb489a242b1e9e7" method="post" data-remote="true"
                          style="padding-bottom: 0px;">
                        <input type="hidden" name="<?=$request->csrfParam?>" value="<?=$request->csrfToken?>" />
                        <input id="doc-text" type="hidden" name="Doc[text]" value="" />

                        <input type="hidden" name="markdown" id="is-markdown" value="0">
                        <input type="hidden" name="is_html" id="is_html" value="1">

                        <div class="form-item doc-title-wrap">
                            <div class="form-field">
                                <textarea name="Doc[name]" class="doc-title" placeholder="文档标题"
                                          style="overflow: hidden; word-wrap: break-word; resize: none; height: 30px;"></textarea>
                            </div>
                        </div>
                        <div class="form-item wmd-panel-wrap">
                            <div class="form-field">
                                <div class="doc-editor">
                                    <textarea id="editor"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="doc-bottom-bar">
                            <div class="form-item visitor-lock">
                            </div>
                            <div class="form-item save-btns-wrap">
                                <div class="form-field">
                                    <button type="submit" class="btn btn-mini btn-create-doc" data-disable-with="保存中..."
                                            data-success-text="保存成功">发布
                                    </button>
                                    <button type="button" class="btn btn-x btn-cancel-quit">取消</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>