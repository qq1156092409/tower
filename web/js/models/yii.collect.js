yii.collect=(function($){
    function watch(){
        var $body=$(document.body);
        $body.on("click",".btn-collect-toggle",function(e){
            e.preventDefault();
            var $btn = $(this);
            $.get($btn.attr("href"),function(response){
                if(response.result){
                    var $collect=$("#collect-"+response.id);
                    if($btn.data("callback")=="destroy"){
                        if(!response.has){
                            $collect.fadeOut(function(){
                                $collect.remove();
                                if($(".star-items").children().size()==0){
                                    $(".init-stars-empty").show();
                                }else{
                                    $(".init-stars-empty").hide();
                                }
                            });
                        }
                        return;
                    }
                    if(response.has){
                        $btn.addClass("stared").attr("title","取消收藏").text("取消收藏");
                    }else{
                        $btn.removeClass("stared").attr("title","收藏").text("收藏");
                    }
                }else{
                    alert("fail");
                }
            });
        });
    }
    function init(){
        watch();
    }
    return {
        init:init
    };
})(jQuery);