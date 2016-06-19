yii.operation=(function($){
    function init(){
        var $body=$(document.body);
        $(".btn-operation-more").click(function(e){
            e.preventDefault();
            var $btn=$(this);
            if($btn.data("status")==1) return;//阻止重复点击
            $btn.data("status",1);
            $btn.text("正在加载...");
            $.get($btn.data("url"),{offset:$btn.data("offset")},function(response){
                if(response.result){
                    append($(".team-events"), $(response.page));
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
        $(window).scroll(function() {
            var $document=$(document),
                $window=$(window);
            if ($document.scrollTop() >= $document.height() - $window.height()) {
                var $more=$(".btn-operation-more");
                if($more.is(":visible")){
                    $more.click();
                }
            }
        });
    }
    function append($parent,$news){
        var $a = $parent.children(":last");
        var $b=$($news[0]);
        if($a.data("date")==$b.data("date")){
            $a.find(".events-day-content").append($b.find(".events-day-content").children());
            $b.hide();
            $parent.append($news);
            $b.remove();
        }else{
            $parent.append($news);
        }
    }
    return {
        init:init
    };
})(jQuery);