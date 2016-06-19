yii.user=(function($){
    function cache(){

    }
    function watch(){
        var $body=$(document.body);
        $("#user-login-form").submit(function(e){
            e.preventDefault();
            var $form=$(this);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    location.href=response.jumpUrl;
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
    }
})(jQuery);