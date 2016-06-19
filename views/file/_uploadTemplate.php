<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/3/21
 * Time: 20:03
 */
?>
<script id="file-upload-tmpl" type="text/html">
    <!--
        {k,file:{name,extension,preview}}
    -->
    <div class="file file-or-dir uploading" id="attachment-${k}" fileid="${k}">
        <div class="file-name">
            <div class="file-thumb">
                <a href="javascript:;">
                    {{if file.preview}}
                    <img alt="${file.name}" src="${file.preview}">
                    {{else}}
                    <img alt="${file.name}" src="public/file_icons/file_extension_${file.extension}.png">
                    {{/if}}
                </a>
            </div>
            <div class="link-name">${file.name}</div>
        </div>
        <div class="progress">
            <div class="progress-bar"><div><span class="progress-number" style="width: 0%;"></span></div></div>
            <span class="percent">0%</span>
            <a href="javascript:;" class="link-cancel" title="取消上传">取消上传</a>
        </div>
    </div>
</script>
