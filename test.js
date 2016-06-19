yii.djq=(function($){
    function init(){
        var $body=$(document.body);
        $body.on("submit","#djq-create-form",function(e){
            e.preventDefault();
            var $form=$(this);
            if(isRunning($form)) return;
            start($form);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    //success callback
                    location.href=response.viewUrl;
                    $("#djq-list").append(response.page);
                }else{
                    fillErrors($form, response.errors);
                }
                end($form);
            });
        });
        $body.on("click","#djq-destroy",function(e){
            e.preventDefault();
            var $btn=$(this);
            if(isRunning($btn)) return;
            start($btn);
            $.post($btn.attr("href"),function(response){
                if(response.result){

                }else{
                    $.each(response.errors,function(){
                        alert(this[0]);return false;
                    });
                }
                end($btn);
            });
        });
    }
    function isRunning($form){
        return $form.hasClass("running");
    }
    function start($form){
        return $form.addClass("running");
    }
    function end($form){
        return $form.removeClass("running");
    }
    function fillErrors($form,errors){
        $form.find("error").hide();
        $.each(errors,function(k,v){
            $form.find(k+"-error").text(v[0]).show();
        });
    }
    function watchForm(seletor,successCallback){
        var $body=$(document.body);

    }
    return {
        init:init
    };
})(jQuery);