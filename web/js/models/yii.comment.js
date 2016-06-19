yii.comment=(function($){
    var timer;
    var $createForm;
    function cache(){
        $createForm=$("#comment-create-form");
    }
    function watch(){
        var $body = $(document.body);
        $(document).click(function(){

        });
        var stops=[
            ".comment-operate-form"
        ];
        $body.on("click",stops.join(","),function(e){
            e.stopPropagation();
        });
        //create
        $("#comment-create-sub").click(function(e){
            var $sub=$(this);
            $createForm.show();
            $sub.hide();
            $createForm.find(".simditor-body").focus();
        });
        $("#comment-create-cancel").click(function(e){
            $createForm.hide();
            $("#comment-create-sub").show();
        });
        $createForm.submit(function(e){
            e.preventDefault();
            $.post($createForm.attr("action"),$createForm.serialize(),function(response){
                if(response.result){
                    var $comment=$(response.page);
                    $("#comment-list").append($comment);
                    clearForm($createForm);
                    $("#comment-create-cancel").click();
                }else{
                    alert("fail");
                }
            });
        });

        //todo

        //destroy(remove)
        $body.on("click",".btn-comment-destroy",function(e){
            e.preventDefault();
            var $btn=$(this);
            if(!confirm($btn.data("cf"))) return;
            $.get($btn.attr("href"),function(response){
                if(response.result){
                    var $comment=$("#comment-"+response.id);
                    $comment.fadeOut(function(){
                        $comment.remove();
                    });
                }else{
                    alert("fail");
                }
            });
        });
        //edit(edit)
        $body.on("submit",".form-comment-edit",function(e){
            e.preventDefault();
            var $form=$(this);
            $form.find(".comment-text").val($form.find(".simditor-body").html());
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    var $comment=$("#comment-"+response.id);
                    $comment.find(".comment-text").html(response.text);
                    $form.find(".btn-comment-edit-cancel").click();
                }else{
                    alert("fail");
                }
            });
        });
        //toggle-praise(edit)
        $body.on("click",".btn-comment-toggle-praise",function(e){
            e.preventDefault();
            var $btn=$(this);
            $.get($btn.attr("href"),function(response){
                if(response.result){
                    var $comment=$("#comment-"+response.id);
                    var $count=$btn.find(".count");
                    var $popLike=$comment.find(".popover-liked-list");
                    var $list =$popLike.find(".comment-like-list");
                    if(response.has){
                        fixCount($count, +1);
                        $btn.addClass("i-liked");
                        $comment.find(".comment-like-list").append(response.page);
                        $popLike.show();
                    }else{
                        fixCount($count, -1);
                        $btn.removeClass("i-liked");
                        $comment.find(".user-comment-me").remove();
                        if($list.children().size()==0){
                            $popLike.hide();
                        }
                    }
                }else{
                    alert("fail");
                }
            });
        });
        $body.on("mouseenter",".btn-comment-toggle-praise",function(){
            var $popLike=$(this).parent().next();
            var $list =$popLike.find(".comment-like-list");
            if($list.children().size()){
                $popLike.show();
            }
        });
        $body.on("mouseleave",".btn-comment-toggle-praise",function(){
            $(this).parent().next().hide();
        });
        $body.on("click",".btn-comment-operation",function(e){
            e.preventDefault();e.stopPropagation();
            var $btn=$(this);
//            $popCommentOperation.css({left:($btn.offset().left-15)+"px",top:($btn.offset().top+30)+"px"});
//            $popCommentOperation.find(".btn-comment-destroy").attr("href",$btn.data("destroy-url"));
//            $popCommentOperation.find(".btn-comment-edit").attr("href",$btn.data("edit-url"));
//            $popCommentOperation.show();
        });
        //edit(append)
        $body.on("click",".btn-comment-edit",function(e){
            e.preventDefault();
            var $btn=$(this);
            $.get($btn.attr("href"),function(response){
                if(response.result){
                    var $comment=$("#comment-"+response.id);
                    $comment.after(response.page);
                    $comment.hide();
                }else{
                    alert("fail");
                }
            });
        });
        $body.on("click",".btn-comment-edit-cancel",function(e){
            e.preventDefault();
            var $btn=$(this);
            var $comment=$("#comment-"+$btn.data("id"));
            $comment.show().next(".comment-form").remove();
        });
    }
    function clearForm($form){
        $form.find(".simditor-body").html("");
        if(yii.simditor){
            localStorage.removeItem(yii.simditor.getEditor().autosave.path);
        }
    }
    function fixCount($count,type){
        var count=$count.text();
        if(count){
            count=parseInt(count);
        }else{
            count=0;
        }
        var newCount=count+type;
        if(!newCount) newCount="";
        $count.text(newCount);
    }
    function init(){
        cache();
        watch();
    }
    return {
        init:init
    };
})(jQuery);