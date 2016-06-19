yii.test=(function($){
    function init(){
        var $body=$(document.body);
        $body.on("click",".button",function(e){
            e.preventDefault();
            var $btn=$(this);
            $.get($btn.attr("href"),function(response){
                if(response.result){
                    //
                }else{
                    $.each(response.errors,function(){
                        alert(this[0]);return false;
                    });
                }
            });
        });
    }
    return {
        init:init
    };
})(jQuery);