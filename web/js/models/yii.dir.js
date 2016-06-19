/**
 * @required yii.common.js
 */
yii.dir=(function($){
    var $body;
    var $createForm;
    var $createCancel;
    var $editForm;
    var $editSub;
    var $editCancel;
    function initObj(){
        $body=$(document.body);
        $createForm=$("#dir-create-form");
        $createCancel=$("#dir-create-cancel");
        $editForm=$("#dir-edit-form");
        $editSub=$("#dir-edit-sub");
        $editCancel=$("#dir-edit-cancel");
    }
    function watch(){
        //destroy
        $body.on("click",".dir-destroy",function(e){
            e.preventDefault();
            var $btn=$(this);
            if(confirm($btn.data("cf"))){
                $.get($btn.attr("href"),function(response){
                    if(response.result){
                        var $dir=$("#dir-" + response.id);
                        $dir.fadeOut(function(){
                            $dir.remove();
                        });
                    }else{
                        alert("fail");
                    }
                });
            }
        });
        //create
        $body.on("click","#dir-create-show",function(e){
            $createForm.show().find("input[type=text]:first").select().focus();
        });
        $body.on("click","#dir-create-cancel",function(e){
            $createForm.hide();
        });
        $body.on("click","#dir-create-submit",function(e){
            $createForm.submit();
        });
        $body.on("submit","#dir-create-form",function(e){
            e.preventDefault();
            $.post($createForm.attr("action"),$createForm.serialize(),function(response){
                if(response.result){
                    var $dir=$(response.page);
                    $createForm.hide().after($dir);
                    yii.common.flash($dir);
                }else{
                    alert("fail");
                }
            });
        });
        //edit
        $editSub.click(function(e){
            $editSub.hide();
            $editForm.parent().show().prev().hide();
            $editForm.find("input[type=text]:first").select();
        });
        $editCancel.click(function(e){
            $editSub.show();
            $editForm.parent().hide().prev().show();
        });
        $editForm.submit(function(e){
            e.preventDefault();
            $.post($editForm.attr("action"),$editForm.serialize(),function(response){
                if(response.result){
                    $editSub.text(response.name);
                    $editCancel.click();
                }else{
                    alert("fail");
                }
            });
        });
    }
    function init(){
        initObj();
        watch();
    }
    return {
        init:init
    };

})(jQuery);