yii.jqueryUpload=(function($){
    function init(){
        $("#fileInput").fileupload({
            autoUpload: true,
            filesContainer: '#list-resources',
            dataType: 'json',
            maxChunkSize: 8000000,//8388608
            maxRetries: 5,
        });
    }
    return {
        init:init
    }
})(jQuery);