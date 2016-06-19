/**
 * @required yii.common.js
 */
yii.item=(function($){
    var $body;
    function initObj(){
        $body = $(document.body);
    }
    function watch(){
        //item-disable
        $body.on("click",".btn-item-disable",function(e){
            e.preventDefault();
            if(!confirm($(this).data("cf"))) return;
            $.get($(this).attr("href"),function(response){
                if(response.result){
                    $("#item-"+response.id).fadeOut(function(){
                        $(this).remove();
                    });
                }else{
                    alert("fail");
                }
            });
        });
        //item-enable
        $body.on("click",".btn-item-enable",function(e){
            e.preventDefault();
            if(!confirm($(this).data("cf"))) return;
            $.get($(this).attr("href"),function(response){
                if(response.result){
                    location.reload();
                }else{
                    alert("fail");
                }
            });
        });
        //item-toggle-archive
        $body.on("click",".btn-item-toggle-archive",function(e){
            e.preventDefault();
            $.get($(this).attr("href"),function(response){
                if(response.result){
                    $("#item-"+response.id).fadeOut(function(){
                        $(this).remove();
                    });
                }else{
                    $.each(response.errors,function(k,v){
                        alert(v[0]);return false;
                    });
                }
            });
        });
        //edit
        $body.on("click",".item-edit-show",function(e){
            var $btn=$(this);
            var $item=$("#item-"+$btn.data("id"));
            $item.find(".item-edit-sub").hide();
            $item.find(".item-edit-wrap").show().find("input[type=text]:first").focus();
        });
        $body.on("click",".item-edit-cancel",function(e){
            var $btn=$(this);
            var $item=$("#item-"+$btn.data("id"));
            $item.find(".item-edit-sub").show();
            $item.find(".item-edit-wrap").hide();
        });
        $body.on("submit",".item-edit-form",function(e){
            e.preventDefault();
            var $form=$(this);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    var $item=$("#item-"+response.id);
                    $item.find(".attr-name").text(response.name);
                    $item.find(".attr-description").text(response.description);
                    $form.find(".item-edit-cancel").click();
                    yii.common.flash($item.find(".item-edit-sub"));
                }else{
                    alert("fail");
                }
            });
        });
        //create
        $body.on("click","#item-create-show",function(e){
            $("#item-create-wrap").show().find("input[type=text]:first").focus();
        });
        $body.on("click","#item-create-cancel",function(e){
            $("#item-create-wrap").hide();
        });
        $body.on("submit","#item-create-form",function(e){
            e.preventDefault();
            var $form = $("#item-create-form");
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    var $item=$(response.page);
                    $("#item-list").prepend($item);
                    clearForm($form);
                    $form.find("#item-create-cancel").click();
                    $item.find(".task-create-sub").click();
                }else{
                    $.each(response.errors,function(k,v){
                        alert(v[0]);return false;
                    });
                }
            });
        });
    }
    function clearForm($form){
        $form.find(".attr-name").val("");
        $form.find(".attr-description").val("");
    }
    function init(){
        initObj();
        watch();
    }
    return {
        init:init
    };
})(jQuery);
