yii.area=(function($){
    function watch(){
        var $body=$(document.body);
        $body.on("change",".area-get-children",function(e){
            var $select=$(this);
            $.get($select.data("url"),{parentID:$select.val()},function(response){
                if(response.result){
                    $select.nextAll().remove();
                    $select.after(response.page);
                }
            });
        });
    }
    function init(){
        watch();
    }
    return {
        init:init
    };
})(jQuery);