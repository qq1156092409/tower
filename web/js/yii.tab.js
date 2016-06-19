/**
 * 选项卡
 */
yii.tab=(function($){
    function init(){
        var $body=$(document.body);
        $body.on("click",".tab-link:not(.tab-active)",function(e){
            var $link=$(this);
            var $tab=$link.parents(".tab:first");
            var $links=$tab.find(".tab-link");
            var $sections=$tab.find(".tab-section");
            var index=$links.index($link[0]);
            $links.filter(".tab-active").removeClass("tab-active");
            $link.addClass("tab-active");
            $sections.filter(":visible").hide();
            $sections.eq(index).show();
        });
    }
    return {
        init:init
    };
})(jQuery);