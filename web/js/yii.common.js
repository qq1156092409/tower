/**
 * @required jquery.color.js
 */
yii.common=(function($){
    var pub={
        init:function(){},
        /**
         * 让元素闪一下
         * @param $element
         * @dependent jquery.color.js
         */
        flash:function($element){
            var old=$element.css("background-color");
            $element.css("background-color","rgb(255, 255, 210)")
                .animate({ backgroundColor: old }, 1000);
        },
        /**
         * 清空表单
         * @param $form
         */
        clearForm:function($form){
            $form.find("input[type='text']").val("");
            $form.find("input[type='password']").val("");
            $form.find("textarea").val("");
            $form.find(".simditor-body").html("");
            $form.find(".has-error").removeClass("has-error");
        },
        getExtension:function(file){
            var arr = file.split('.');
            return arr[(arr.length-1)];
        }
    };
    return pub;
})(jQuery);