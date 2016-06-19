yii.team=(function($){
    function init(){
        var $body=$(document.body);
        var $popTeamSubgroups=$("#pop-team-subgroups");
        $body.click(function(){
            $("#pop-team-subgroups").hide();
        });
        //create
        $body.on("submit","#form-team-create",function(e){
            e.preventDefault();
            var $form=$(this);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    location.href=response.viewUrl;
                }else{
                    fillErrors($form,response.errors);
                }
            });
        });
        $body.on("click",".btn-team-create",function(){
            $("#pop-team-create").show();
        });
        $body.on("click",".btn-team-create-cancel",function(){
            $("#pop-team-create").hide();
        });
        //edit
        $body.on("submit",".form-team-edit",function(e){
            e.preventDefault();
            var $form=$(this);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    var $team=$("#team-"+response.id);
                    $team.find(".team-name").text(response.name);
                    $form.find(".btn-cancel").click();
                }else{
                    alert("fail");
                }
            });
        });
        $("#btn-team-edit").click(function(){
            $(this).parent().hide().next().show();
        });
        $(".btn-cancel").click(function(){
            $(this).parent().hide().prev().show();
        });
        $("#btn-team-subgroups").click(function(e){
            e.stopPropagation();
            var $btn=$(this);
            $("#pop-team-subgroups").css({
                left:$btn.offset().left-85+"px",
                top:$btn.offset().top+30+"px"
            }).show();
        });
        $popTeamSubgroups.click(function(e){
            e.stopPropagation();
        });
        $popTeamSubgroups.on("click",".groups li",function(e){
            e.preventDefault();
            $(this).addClass("selected").siblings(".selected").removeClass("selected");
            $(".mcw-pop-select-list li").addClass("light");
            $(".mcw-pop-select-list li[data-subgroup-id=" + $(this).data("subgroup-id") + "]").removeClass("light");
        });
        $popTeamSubgroups.on("click",".members li",function(e){
            e.preventDefault();
            location.href=$(this).data("url");
        });
    }
    function fillErrors($form,errors){
        $form.find(".form-field").each(function(){
            var $field=$(this);
            var name=$field.data("attr");
            if(errors[name]){
                $field.addClass("error");
                $field.find("input").addClass("error");
                $field.find("."+name+"-error").removeClass("hide").text(errors[name][0]);
            }else{
                $field.removeClass("error");
                $field.find("input").removeClass("error");
                $field.find("."+name+"-error").addClass("hide");
            }
        });
    }
    return {
        init:init
    }
})(jQuery);