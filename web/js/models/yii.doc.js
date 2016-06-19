yii.doc=(function($){
    function init(){
        var $body=$(document.body);
        yii.form.watchSubmit("#doc-create-form",function($form,response){
            localStorage.removeItem(yii.simditor.getEditor().autosave.path);
            location.href=response.viewUrl;
        });
        yii.form.watchSubmit("#doc-edit-form",function($form,response){
            localStorage.removeItem(yii.simditor.getEditor().autosave.path);
            location.href=response.viewUrl;
        });
        yii.form.watchButton("#doc-disable",function($target,response){
            location.reload();
        });
        yii.form.watchButton("#doc-enable",function($target,response){
            location.reload();
        });
    }
    return {
        init:init
    }
})(jQuery);