yii.layout=(function($){
    var btnTeams="#btn-teams";
    var popTeams="#pop-teams";
    var btnNotification="#btn-notification";
    var popNotification="#pop-notification";
    var btnUserMenu="#btn-user-menu";
    var popUserMenu="#pop-user-menu";
    var btnSearch="#btn-search";
    var inputSearch="#txt-search";
    var btnWechat="#btn-wechat";
    var popWechat="#pop-wechat";
    //对象
    var $body;
    var $btnTeams;
    var $popTeams;
    var $btnNotification;
    var $popNotification;
    var $btnUserMenu;
    var $popUserMenu;
    var $btnSearch;
    var $inputSearch;
    var $wrapSearch;
    var $btnWechat;
    var $popWechat;

    function initObj(){
        $body=$(document.body);
        $btnTeams=$(btnTeams);
        $popTeams=$(popTeams);
        $btnNotification=$(btnNotification);
        $popNotification=$(popNotification);
        $btnUserMenu=$(btnUserMenu);
        $popUserMenu=$(popUserMenu);
        $btnSearch=$(btnSearch);
        $inputSearch=$(inputSearch);
        $btnWechat=$(btnWechat);
        $popWechat=$(popWechat);
        $wrapSearch=$btnSearch.parent();
    }
    /**
     * 注册事件监听
     */
    function watch(){
        $(document).click(function(){
            $popTeams.hide();
            $popNotification.hide();
            $popUserMenu.hide();
            $wrapSearch.removeClass("active");
        });
        var stops=[
            popNotification,
            popTeams,
            popUserMenu,
            btnNotification,
            btnTeams,
            btnUserMenu,
            btnSearch,
            inputSearch,
            "#txt-search"
        ];
        $body.on("click",stops.join(","),function(e){
            e.stopPropagation();
        });
        $btnTeams.click(function(e){
            $popTeams.css({
                top:($(this).offset().top+$(this).height()+5)+"px",
                left:$(this).offset().left-($popTeams.width()-$(this).width())/2+"px"
            });
            $popTeams.show();
        });
        $btnNotification.click(function(e){
            $popNotification.show();
        });
        $btnUserMenu.click(function(e){
            $popUserMenu.css({
                top:($(this).offset().top+$(this).width()+10)+"px",
                left:$(this).offset().left-($btnUserMenu.width()-$(this).width())/2-50+"px"
            });
            $popUserMenu.show();
        });
        $btnSearch.click(function(e){
            $btnSearch.parent().addClass("active");
            $inputSearch.focus();
            e.stopPropagation();
        });
        $inputSearch.blur(function(e){
            $wrapSearch.removeClass("active");
        });
        $btnWechat.mouseenter(function(e){
            $popWechat.css("top",($(this).offset().top-10)+"px");
            $popWechat.show();
        }).mouseleave(function(e){
            $popWechat.hide();
        });
    }
    function init(){
        initObj();
        watch();
    }
    return {
        init:init,
        initObj:initObj
    };
})(jQuery);