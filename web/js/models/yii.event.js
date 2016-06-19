yii.event=(function($){
    function init(){
        //create(view)
        $(document).on("submit",".form-event-create",function(e){
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
        //edit(view)
        $(document).on("submit",".form-event-edit",function(e){
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
        //destroy(jump)
        $(document).on("click",".btn-event-destroy",function(e){
            e.preventDefault();
            var $btn=$(this);
            if(!confirm($btn.data("cf"))) return;
            $.get($btn.attr("href"),function(response){
                if(response.result){
                    location.href=response.jumpUrl;
                }else{
                    alert("fail");
                }
            });
        });
    }
    return {
        init:init
    };
})(jQuery);