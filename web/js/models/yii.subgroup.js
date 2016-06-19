yii.subgroup=(function($){
    function init(){
        //create(append)
        $(document).on("submit",".form-subgroup-create",function(e){
            e.preventDefault();
            var $form=$(this);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    var $newSubgroup=$(response.page);
                    $(".group-new").before($newSubgroup.hide());
                    $newSubgroup.fadeIn();
                    $form.find(".btn-cancel").click();
                    clearForm($form);
                }else{
                    alert("fail");
                }
            });
        });
        //destroy(remove)
        $(document).on("click",".btn-subgroup-destroy",function(e){
            e.preventDefault();
            var $btn=$(this);
            if(!confirm($btn.data("confirm1"))) return;
            $.get($btn.attr("href"),function(response){
                if(response.result){
                    var $subgroup=$("#subgroup-"+response.id);
                    $subgroup.fadeOut(function(){
                        var $members=$subgroup.find(".member");
                        $(".group-default .members").append($members);
                        $subgroup.remove();
                    });
                }else{
                    alert("fail");
                }
            });
        });
        //edit(edit)
        $(document).on("submit",".form-subgroup-edit",function(e){
            e.preventDefault();
            var $form=$(this);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    var $subgroup=$("#subgroup-"+response.id);
                    $subgroup.find(".subgroup-name").text(response.name);
                    $form.find(".btn-cancel").click();
                }else{
                    alert("fail");
                }
            });
        });
        //节点操作
        $(".btn-subgroup-create").click(function(e){
            e.preventDefault();
            var $btn=$(this);
            $btn.hide().next().show().find(".subgroup-name").focus();
        });
        $(".btn-subgroup-create-cancel").click(function(e){
            e.preventDefault();
            $(".btn-subgroup-create").show().next().hide();
        });
        $(document).on("click",".btn-subgroup-edit",function(e){
            e.preventDefault();
            var $btn=$(this);
            $btn.parent().hide().next().show().find(".subgroup-name").focus();
        });
        $(document).on("click",".btn-subgroup-edit-cancel",function(e){
            e.preventDefault();
            var $btn=$(this);
            var $subgroup=$("#subgroup-"+$btn.data("id"));
            $subgroup.find("h3").show().next().hide();
        });
        $("#subgroup-list").sortable({
            "items":".subgroup",
            "axis":"y",
            "update":function(e,ui){
                var $list=$(this);
                var $subgroup=ui.item;
                var $prev=$subgroup.prev();
                var data={ id: $subgroup.data("id") };
                if($prev.size()>0){
                    data.prevID=$prev.data("id");
                }
                $.get($list.data("sort-url"),data,function(response){
                    if(response.result){

                    }else{
                        alert("fail");
                    }
                });
            }
        });
        $(".group-bd").mousedown(function(e){
            e.stopPropagation();
        });
    }
    function clearForm($form){
        $form.find(".subgroup-name").val("");
    }
    return {
        init:init
    };
})(jQuery);