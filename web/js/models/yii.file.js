/**
 * @require yii.common.js yii.tmpl.min.js
 */
yii.file=(function($){
    var $body;
    function initObj(){
        $body=$(document.body);
    }
    function watch(){
        //toggle-enable
        $body.on("click",".file-toggle-enable",function(e){
            e.preventDefault();
            var $btn=$(this);
            if(confirm($btn.data("cf"))){
                $.get($btn.attr("href"),function(response){
                    if(response.result){
                        var $file=$("#file-"+response.id);
                        var $scenario = $("#scenario");
                        if($scenario.val()=="file-index"){
                            location.reload();
                            return;
                        }
                        $file.fadeOut(function(){
                            $file.remove();
                        });
                    }else{
                        alert("fail");
                    }
                });
            }
        });
        $body.on("change","#file-upload",function(e){
            var $btn=$(this);
            if(this.files){
                $.each(this.files,function(){
                    var random=parseInt(100000*Math.random());
                    createTempPage(random,this);
                    if(!validateFile(random,this)){
                        return;
                    }
                    fix(true);
                    var formData=new FormData();
                    formData.append("attachment",this);
                    formData.append(yii.getCsrfParam(),yii.getCsrfToken());
                    var xhr = new XMLHttpRequest();
                    xhr.open("post",$btn.data("url"));
                    xhr.onprogress=function(e){
                        //todo 看不到进度条的效果，可能和后台的设置有关
                        if(e.lengthComputable){
                            $("#attachment-"+random).find(".progress-number").css("width",parseInt(100*event.loaded/e.total)+"%");
                        }
                    };
                    xhr.onload=function(e){
                        var response=$.parseJSON(xhr.response);
                        if(response.result){
                            var $file=$(response.page);
                            $("#attachment-"+random).replaceWith($file);
                            yii.common.flash($file);
                        }else{
                            $.each(response.errors,function(k,v){
                                alert(v[0]);
                            });
                        }
                    };
                    xhr.send(formData);
                });
            }
        });
        $body.on("click",".file-upload-boot",function(e){
            $("#file-upload").click();
        });
        function createTempPage(k,file){
            var data={k:k,file:{name:file.name}};
            var extension=yii.common.getExtension(file.name);
            var accept=['bmp','jpg','jpeg','png','gif','mp3','wav','wma','asf','mp4','avi','rmvb','rm','doc','docx','xls','xlsx','ppt','pptx','zip','rar','7z','cab','iso','txt','pdf','swf','flv'];
            var imgExts=["bmp","jpg","jpeg","png","gif"];
            if($.inArray(extension,imgExts)!=-1){
                var reader=new FileReader();
                reader.onload=function(){
                    data.file.preview=this.result;
                    var $page=$("#file-upload-tmpl").tmpl(data);
                    $("#dir-create-form").after($page);
                };
                reader.readAsDataURL(file);
            }else{
                if($.inArray(extension,accept)==-1){
                    extension="others";
                }
                data.file.extension=extension;
                var $page=$("#file-upload-tmpl").tmpl(data);
                $("#dir-create-form").after($page);
            }
        }
        function validateFile(k,file){
            var ret=true;
            var message="";
            if(file.size>53477376){
                message="文件太大";
                ret=false;
            }
            if(ret==false){
                $("#attachment-"+k).append('<div>'+message+'</div>');
            }
            return ret;
        }

        /**
         * @param flag true|false|null
         */
        function fix(flag){
            var $fileList=$(".files-view");
            var $fileInit=$(".init-file");
            if(flag==null){
                flag=$fileList.children(":visible").size()>0;
            }
            if(flag){
                $fileInit.hide();
                $fileList.show();
            }
        }
    }
    function init(){
        initObj();
        watch();
    }
    return {
        init:init,
        initObj:initObj
    }
})(jQuery);