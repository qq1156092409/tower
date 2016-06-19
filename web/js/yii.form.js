/**
 * 表单操作
 * 表单提交监听和校验
 */
yii.form=(function($){
    function fillErrors($form,errors){
        $form.find(".form-field").each(function(k,v){
            var $field=$(v);
            var name=$field.data("attr");
            if(errors[name]){
                $field.addClass("error").find("."+name+"-error").text(errors[name][0]);
            }else{
                $field.removeClass("error");
            }
        });
    }
    function watchSubmit(selector,successCallback){
        var $body=$(document.body);
        $body.on("submit",selector,function(e){
            e.preventDefault();
            var $form=$(this);
            if(isSending($form)) return;
            start($form);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    successCallback($form,response);
                }else{
                    fillErrors($form,response.errors);
                }
                end($form);
            });
        });
    }
    function watchButton(selector,successCallback){
        var $body=$(document.body);
        $body.on("click",selector,function(e){
            e.preventDefault();
            var $btn=$(this);
            if($btn.data("cf")){
                if(!confirm($btn.data("cf")))return;
            }
            if(isSending($btn)) return;
            start($btn);
            $.post($btn.attr("href"),function(response){
                if(response.result){
                    successCallback($btn,response);
                }else{
                    $.each(response.errors,function(){
                        alert(this[0]);
                    });
                }
                end($btn);
            });
        });
    }
    function isSending($form){
        return $form.hasClass("sending");
    }
    function start($form){
        $form.addClass("sending");
    }
    function end($form){
        $form.removeClass("sending");
    }
    return {
        isSending:isSending,
        start:start,
        end:end,
        fillErrors:fillErrors,
        watchSubmit:watchSubmit,
        watchButton:watchButton
    };
})(jQuery);