/**
 * @required yii.common.js
 */
yii.discuss=(function($){
    var $popDiscussStatus;
    function initObj(){
        $popDiscussStatus=$("#pop-discuss-status");
    }
    function watch(){
        $(document).click(function(){
            $popDiscussStatus.hide();
        });
        $(document.body).on("click","#btn-discuss-status,#pop-discuss-status",function(e){
            e.stopPropagation();
        });
        $("#btn-discuss-status").click(function(e){
            var $btn=$(this);
            $popDiscussStatus.css({
                left:$btn.offset().left+60+"px",
                top:$btn.offset().top+35+"px"
            }).show();
        });
        //toggle-archive
        $(document).on("click",".btn-discuss-toggle-archive",function(e){
            e.preventDefault();
            var $btn=$(this);
            $.get($btn.attr("href"),function(response){
                if(response.result){
                    toggleArchive(response);
                }else{
                    alert("fail");
                }
            });
        });
        //toggle-top
        $(document).on("click",".btn-discuss-toggle-top",function(e){
            e.preventDefault();
            var $btn=$(this);
            $.get($btn.attr("href"),function(response){
                if(response.result){
                    toggleTop(response);
                }else{
                    alert("fail");
                }
            });
        });
    }
    //--public
    function init(){
        initObj();
        watch();
    }
    function toggleArchive(response){
        var $data=$("#hide-data");
        var $discuss=$("#discuss-" + response.id);
        var $sub = $("#discuss-sub-" + response.id);
        if((response.archive && $data.data("scenario")=="project-discusses-archive-1")|| (!response.archive && $data.data("scenario")!="project-discusses-archive-1")){
            if(yii.socket.ensure($sub,response)){
                $sub.slideUp(function () {
                    $(this).remove();
                });
                $discuss.slideDown(function(){
                    yii.common.flash($(this));
                });
            }
        }else{
            if(yii.socket.ensure($discuss,response)){
                $sub=$(response.substitute);
                $discuss.slideUp();
                $discuss.after($sub);
                $sub.hide();
                $sub.slideDown();
            }
        }
    }
    function toggleTop(response){
        var $discuss=$("#discuss-"+response.id);
        if(yii.socket.ensure($discuss,response)){
            var $btn=$discuss.find(".btn-discuss-toggle-top");
            if(response.order){//top
                $discuss.addClass("sticky");
                $btn.removeClass("stick").addClass("unstick");
                $discuss.parent().prepend($discuss);
            }else{
                $discuss.removeClass("sticky");
                $btn.removeClass("unstick").addClass("stick");
                $discuss.nextAll().each(function(k,v){
                    if(!$(v).hasClass("sticky") && $(v).data("update")<$discuss.data("update")){
                        $(v).before($discuss);
                        $discuss.hasMove=true;
                        return false;
                    }
                });
                if(!$discuss.hasMove){
                    var $last=$(".discuss:last");
                    if($last.next().hasClass("discuss-sub")){
                        $last.next().after($discuss);
                    }else{
                        $last.after($discuss);
                    }
                }
            }
            yii.common.flash($discuss);
        }
    }
    return {
        init:init,
        toggleTop:toggleTop,
        toggleArchive:toggleArchive
    };
})(jQuery);