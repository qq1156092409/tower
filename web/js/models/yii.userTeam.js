/**
 * @require jquery-ui
 */
yii.userTeam=(function($){
    function init(){
        var $body=$(document.body);
        $("#page-members").sortable({
            items:".ui-draggable"
        });
    }
    return {
        init:init
    };
})(jQuery);