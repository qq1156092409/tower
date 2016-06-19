yii.search=(function($){
    function cache(){

    }
    function watch(){
        var $body=$(document.body);
        $(document).click(function(){
            $(".simple-popover:visible").hide();
        });
        var stops=[
            "#search-prev-show",
            "#search-creator-show",
            "#search-model-show",
            "#search-order-show"
        ];
        $body.on("click",stops.join(","),function(e){
            e.stopPropagation();
        });
        $("#search-prev-show").click(function(e){
            var $btn=$(this);
            var $pop=$("#search-prev-pop");
            $(".simple-popover:visible").hide();
            $pop.css({
                left:$btn.offset().left+$btn.width()/2-$pop.width()/2+"px"
            }).show();
        });
        $("#search-creator-show").click(function(e){
            var $btn=$(this);
            var $pop=$("#search-creator-pop");
            $(".simple-popover:visible").hide();
            $pop.css({
                left:$btn.offset().left+$btn.width()/2-$pop.width()/2+"px"
            }).show();
        });
        $("#search-model-show").click(function(e){
            var $btn=$(this);
            var $pop=$("#search-model-pop");
            $(".simple-popover:visible").hide();
            $pop.css({
                left:$btn.offset().left+$btn.width()/2-$pop.width()/2+"px"
            }).show();
        });
        $("#search-order-show").click(function(e){
            var $btn=$(this);
            var $pop=$("#search-order-pop");
            $(".simple-popover:visible").hide();
            $pop.css({
                left:$btn.offset().left+$btn.width()/2-$pop.width()/2+"px"
            }).show();
        });
        $("#search-prev-pop").on("click","li",function(e){
            var $btn=$(this);
            $("#search-form").find(".attr-prev").val($btn.data("type")).submit();
        });
        $("#search-creator-pop").on("click","li",function(e){
            var $btn=$(this);
            $("#search-form").find(".attr-creator").val($btn.data("value")).submit();
        });
        $("#search-model-pop").on("click","li",function(e){
            var $btn=$(this);
            $("#search-form").find(".attr-model").val($btn.data("value")).submit();
        });
        $("#search-order-pop").on("click","li",function(e){
            var $btn=$(this);
            $("#search-form").find(".attr-order").val($btn.data("value")).submit();
        });
        $("#search-more").click(function(e){
            e.preventDefault();
            var $btn=$(this);
            if($btn.data("status")==1) return;//阻止重复点击
            $btn.data("status",1);
            $btn.text("正在加载...");
            $.get($btn.data("url"),{offset:$btn.data("offset")},function(response){
                if(response.result){
                    $("#search-list").append(response.page);
                    if(response.hasMore){
                        $btn.data("offset", response.newOffset);
                    }else{
                        $btn.hide();
                    }
                    $btn.data("status",0);
                    $btn.text("加载更多内容");
                }else{
                    alert("fail");
                }
            });
        });
    }
    function init(){
        cache();
        watch();
    }
    return {
        init:init
    };
})(jQuery);