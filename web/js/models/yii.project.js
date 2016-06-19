/**
 * @required yii.common.js yii.topic.js
 */
yii.project=(function($){
    var $body;
    function initObj(){
        $body=$(document.body);
    }
    function watch(){
        $(document).click(function(){
            $(".simple-popover").hide();
            $(".popover-pointTo").removeClass("popover-pointTo");
            $(".btn-dropdown-menu:visible").hide();
        });
        var stops=[
            ".simple-popover",
            ".btn-project-icon"
        ];
        $(document.body).on("click",stops.join(","),function(e){
            e.stopPropagation();
        });
        $(document.body).on("click",".btn-project-icon",function(e){
            e.preventDefault();
            $(".popover-pointTo").removeClass("popover-pointTo");
            $(".pop-project-icon:visible").hide();
            var $btn=$(this);
            var $pop = $("#pop-project-icon-" + $btn.data("id"));
            $btn.addClass("popover-pointTo");
            $pop.css({
                top:($btn.offset().top+$btn.width()+15)+"px",
                left:$btn.offset().left-($pop.width()-$(this).width())/2+"px"
            });
            $pop.show();
        });
        $(document.body).on("click",".pop-project-icon li",function(e){
            var $btn=$(this);
            var $form=$btn.parent().parent().parent().parent();
            $form.find("."+$btn.parent().data("attr")).val($btn.data("value"));
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    var $project = $("#project-" + response.id);
                    $project.removeClass("i"+response.oldIcon+" c"+response.oldIconColor)
                        .addClass("i"+response.icon+" c"+response.iconColor);
                    $btn.addClass("selected").siblings(".selected").removeClass("selected");
                    if(response.oldIconColor!=response.iconColor){
                        $form.find(".icons").children().removeClass("c"+response.oldIconColor).addClass("c"+response.iconColor);
                    }
                }else{
                    alert("fail");
                }
            });
        });
        $(document).on("submit",".form-project-create",function(e){
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
        //members(replace)
        $(document).on("submit",".form-project-members",function(e){
            e.preventDefault();
            var $form=$(this);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    $(".project-members").children("ul").html(response.page);
                    $(".link-edit-members").click();
                }else{
                    alert("fail");
                }
            });
        });
        //edit(setting)
        $(document).on("submit",".form-project-edit",function(e){
            e.preventDefault();
            var $form=$(this);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    $form.find(".btn-submit").hide().next().show();
                    setTimeout(function () {
                        $form.find(".btn-submit").show().next().hide();
                    }, 2000);
                }else{
                    alert("fail");
                }
            });
        });
        //toggle-section(append|locate)
        $(document).on("click",".btn-project-toggle-section",function(e){
            e.preventDefault();
            var $btn=$(this);
            $.get($btn.attr("href"),function(response){
                if(response.result){
                    if($btn.data("callback")=="locate"){
                        var $section=$("#section-"+response.sectionID);
                        if(response.has){//显示着
                            $btn.text("");
                            $section.removeClass("disabled");
                            var $firstDisabled=$(".section.disabled:first");
                            if($firstDisabled.size()) {
                                $section.insertBefore($firstDisabled);
                            }
                            yii.common.flash($section);
                        }else{//隐藏着
                            $btn.text("");
                            $section.addClass("disabled");
                            $(".sections").append($section);
                            yii.common.flash($section);
                        }
                        return;
                    }
                    if(response.has){
                        var $page=$(response.page).hide();
                        $(".project-sections").append($page);
                        $page.fadeIn();
                        if($btn.siblings(".btn-project-toggle-section").size()==0){
                            $btn.prev().remove();
                        }
                        $btn.remove();
                        yii.topic.initObj();
                    }
                }else{
                    alert("fail");
                }
            });
        });
        //quit(jump)
        $(document).on("click",".btn-project-quit",function(e){
            e.preventDefault();
            if(!confirm($(this).data("cf"))){
                return;
            }
            $.get($(this).attr("href"),function(response){
                if(response.result){
                    location.href=response.jump;
                }else{
                    alert(response.errors.id);
                }
            });
        });
        //toggle-archive(setting|archived-projects)
        $(document).on("click",".btn-project-toggle-archive",function(e){
            e.preventDefault();
            var $btn=$(this);
            if($btn.data("cf") && !confirm($btn.data("cf"))) return;
            $.get($btn.attr("href"),function(response){
                if(response.result){
                    var $scenario=$("#scenario");
                    var $project=$("#project-"+response.id);
                    if($scenario.val()=="team-archived-projects"){
                        if(response.archive==0){
                            $project.fadeOut(function(){
                                $project.remove();
                            });
                        }
                        return;
                    }
                    //setting
                    if(response.archive){
                        location.href=response.teamUrl;
                    }else{
                        location.reload();
                    }
                }else{
                    alert("fail");
                }
            });
        });
        $("#wrap-projects").sortable({
            update:function(e,ui){
                var $project=ui.item;
                var $next=$project.next();
                var data={};
                if($next.size()){
                    data.prevID=$next.data("id");
                }
                $.get($project.data("sort-url"),data,function(response){
                    if(response.result){

                    }else{
                        alert("fail");
                    }
                });
            }
        });
        $(".sections").sortable({
            items:">:not(.disabled)",
            axis:"y",
            update:function(e,ui){
                var $section=ui.item;
                var $prev=$section.prev();
                var data={sectionID:$section.data("section")};
                if($prev.size()){
                    data.prevSectionID=$prev.data("section");
                }
                $.get($section.parent().data("sort-url"),data,function(response){
                    if(response.result){

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
    return {
        init:init
    };
})(jQuery);