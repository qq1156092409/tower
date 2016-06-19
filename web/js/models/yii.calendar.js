yii.calendar=(function($){
    var $body;
    function initObj(){
        $body=$(document.body);
    }
    function watch(){
        //弹窗隐藏
        $(document).click(function(){
            $(".popover-pointTo").removeClass("popover-pointTo");
            $(".simple-popover:visible").hide();
            $(".options-member").hide();
        });
        //阻止冒泡
        $body.on("click",".pop-calendar-color,.btn-calendar-color,.options-member,.select-member",function(e){
            e.stopPropagation();
        });
        //编辑
        $body.on("submit","#form-calendar-edit",function(e){
            e.preventDefault();
            var $form=$(this);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    location.href=response.viewUrl;
                }else{
                    alert("fail");
                }
            });
        });
        //显示弹窗
        $(".btn-calendar-color").click(function(e){
            var $btn=$(this);
            var $popCalendarColor=$("#pop-calendar-color-"+$btn.data("id"));
            $btn.addClass("popover-pointTo");
            $popCalendarColor.show().css({
                top: (($btn.offset().top +30) + "px"),
                left:(($btn.offset().left -180) + "px")
            });
        });
        //修改颜色
        $body.on("click",".btn-calendar-set-color",function(e){
            var $btn=$(this);
            var $form=$btn.parent().parent();
            $form.find(".attr-color").val($btn.data("color"));
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    var $calendar=$("#calendar-"+response.id);
                    $btn.addClass("selected").siblings(".selected").removeClass("selected");
                    $calendar.find(".cal-color-"+response.oldColor).removeClass("cal-color-"+response.oldColor).addClass("cal-color-"+response.color);
                }else{
                    alert("fail");
                }
            });
        });
        //删除
        $body.on("click",".btn-calendar-destroy",function(e){
            e.preventDefault();
            if(confirm($(this).data("cf"))){
                $.get($(this).attr("href"),function(response){
                    if(response.result){
                        $("#calendar-"+response.id).fadeOut(function(){
                            $(this).remove();
                        });
                        $("#pop-calendar-color-"+response.id).fadeOut(function(){
                            $(this).remove();
                        });
                        //todo 移除event
                    }else{
                        alert("fail");
                    }
                });
            }
        });
        //切换sidebar
        $(".btn-calendar-toggle-sidebar").click(function(e){
            $(".calendar-wrapper").toggleClass("expand");
            $(this).toggleClass("sidebar-collapsed");
            if($(this).attr("title")=="隐藏侧边栏"){
                $(this).attr("title","显示侧边栏");
            }else{
                $(this).attr("title","隐藏侧边栏");
            }
        });
        //创建
        $("#form-calendar-create").submit(function(e){
            e.preventDefault();
            var $form=$(this);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    location.href=response.viewUrl;
                }else{
                    alert("fail");
                }
            });
        });
        //选择颜色
        $(document).on("click",".btn-calendar-color2",function(e){
            var $btn=$(this);
            var $form=$(".form-calendar-save");
            $form.find(".attr-color").val($btn.data("color"));
            $btn.addClass("selected").siblings(".selected").removeClass("selected");
        });
        //创建-成员
        $(document.body).on("click",".select-member",function(e){
            $(".options-member").show();
        });
        //添加成员
        $(document.body).on("click",".option-member",function(e){
            var $option=$(this);
            $("#member-"+$option.data("id")).addClass("selected").find(".input-hidden").removeAttr("disabled");
            $(".options-member").hide();
            if($(".member:hidden").size()==0){
                $("#btn-subgroup-all").addClass("selected");//所有成员按钮选中
                $("#btn-subgroup-"+$option.data("subgroup")).addClass("selected");
            }else if($(".member[data-subgroup='"+$option.data("subgroup")+"']:hidden").size()==0){
                $("#btn-subgroup-"+$option.data("subgroup")).addClass("selected");
            }
        });
        //移除成员
        $(document).on("click",".member",function(e){
            var $member=$(this);
            $member.removeClass("selected").find(".input-hidden").attr("disabled","disabled");
            $("#btn-subgroup-all").removeClass("selected");
            $("#btn-subgroup-"+$member.data("subgroup")).removeClass("selected");
        });
        //小组选中切换
        $(document).on("click",".btn-subgroup",function(e){
            var $btn=$(this);
            if($btn.data("id")!=-1){//单组
                var $targetMembers=$(".member[data-subgroup='"+$btn.data("id")+"']");
                if(!$btn.hasClass("selected")){//添加
                    $targetMembers.addClass("selected").find(".input-hidden").removeAttr("disabled");
                    $btn.addClass("selected");
                    if($(".member:hidden").size()==0){
                        $("#btn-subgroup-all").addClass("selected");//所有成员按钮选中
                    }
                }else{//移除
                    $targetMembers.removeClass("selected").find(".input-hidden").attr("disabled","disabled");
                    $btn.removeClass("selected");
                    $("#btn-subgroup-all").removeClass("selected");
                }
            }else{//全部小组
                if(!$btn.hasClass("selected")){//添加
                    $(".member").addClass("selected").find(".input-hidden").removeAttr("disabled");
                    $(".btn-subgroup").addClass("selected");
                }else{//移除
                    $(".member").removeClass("selected").find(".input-hidden").attr("disabled","disabled");
                    $(".btn-subgroup").removeClass("selected");
                }
            }
        });
    }
    function init(){
        initObj();
        watch();
    }
    return {
        init:init,
        initObj:initObj
    };
})(jQuery);