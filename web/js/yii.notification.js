yii.notification=(function($){
    function init(){
        Notification.requestPermission();
        setTimeout(function(){
            new Notification('你有一封新邮件',{body:"邮件内容简介"});
        },1000);
    }
    return {
        init:init
    };
})(jQuery);