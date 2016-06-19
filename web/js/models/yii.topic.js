/**
 * @required yii.common.js
 */
yii.topic=(function($){
    //对象
    var $body=$(document.body);
    var $createShow;
    var $createSub;
    var $createForm;
    var $createCancel;
    var $editShow;
    var $editForm;
    var $editCancel;

    function initObj(){
        $createShow=$("#topic-create-show");
        $createSub=$("#topic-create-sub");
        $createForm=$("#topic-create-form");
        $createCancel=$("#topic-create-cancel");
        $editShow=$("#topic-edit-show");
        $editForm=$("#topic-edit-form");
        $editCancel=$("#topic-edit-cancel");
    }
    function watch(){
        //--create
        $body.on("click","#topic-create-show",function(e){
            $createSub.hide();
            $createForm.show().find("input[type=text]:first").focus();
        });
        $createSub.click(function(){
            $createSub.hide();
            $createForm.show().find("input[type=text]:first").focus();
        });
        $body.on("click","#topic-create-cancel",function(e){
            $createForm.hide();
            $createSub.show();
        });
        $body.on("submit","#topic-create-form",function(e){
            e.preventDefault();
            var $body=$createForm.find(".simditor-body");
            $createForm.find(".topic-text").val($body.html());
            $.post($createForm.attr("action"),$createForm.serialize(),function(response){
                if(response.result){
                    //discuss
                    var $newDiscuss = $(response.page);
                    var $last=$(".sticky:last");
                    if($last.size()>0){
                        $newDiscuss.insertAfter($last);
                    }else{
                        $newDiscuss.prependTo(".messages");
                    }
                    yii.common.flash($newDiscuss);
                    //form
                    $createCancel.click();
                    clearForm($createForm);
                }else{
                    alert("fail");
                }
            });
        });
        //--edit
        $editForm.submit(function(e){
            e.preventDefault();
            $editForm.find(".topic-text").val($editForm.find(".simditor-body").html());
            $.post($editForm.attr("action"),$editForm.serialize(),function(response){
                if(response.result){
                    var $topic=$("#topic-"+response.id);
                    $topic.find(".topic-name").text(response.name).attr("title",response.name);
                    $topic.find(".topic-text").text(response.text);
                    $editCancel.click();
                }else{
                    alert("fail");
                }
            });
        });
        //--disable
        $("#topic-disable").click(function(e){
            e.preventDefault();
            var $btn=$(this);
            if(confirm($btn.data("cf"))){
                $.get($btn.attr("href"),function(response){
                    if(response.result){
                        location.reload();
                    }else{
                        alert("fail");
                    }
                });
            }
        });
    }
    function init(){
        initObj();
        watch();
    }
    function clearForm($form){
        $form.find(".input-text").val("");
        $form.find(".simditor-body").html("");
        if(yii.simditor){
            localStorage.removeItem(yii.simditor.getEditor().autosave.path);
        }
    }
    return {
        init:init,
        initObj:initObj
    };
})(jQuery);