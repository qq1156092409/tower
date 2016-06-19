yii.dropdown=(function($){
    function initObj(){

    }
    function watch(){
        var $body=$(document.body);
        $(document).click(function(e){
            $(".dropdown").removeClass("dropdown");
        });
        $body.on("click",".btn-dropdown-toggle",function(e){
            e.stopPropagation();
        });
        $body.on("click",".btn-dropdown-toggle",function(e){
            var $btn=$(this);
            var $list=$btn.next();
            $btn.parent().addClass("dropdown");
            $list.show();
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