/**
 * @required yii.common.js
 */
yii.test=(function($){
    //--private
    function cache(){

    }
    function watch(){
        var $body=$(document.body);
        $("#test-create-form").submit(function(e){
            e.preventDefault();
            var $form=$(this);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    create(response);
                    $form.find("#test-create-cancel").click();
                    clearForm($form);
                }else{
                    alert("fail");
                }
            });
        });
    }
    function clearForm($form){
        $form.find("input[type=text]").val("");
    }
    //--public
    function init(){
        cache();
        watch();
    }
    function create(response){
        var $parent=$("#parent-wrap-"+response.parentID);
        if($parent.size()>0 && $("#test-"+response.id).size()==0){
            $("#test-list").append(response.page);
        }
    }
    function edit(response){
        var $test=$("#test-"+response.id);
        if($test.data("random")!=response.random){
            $test.data("random",response.random);
            $test.find(".attr-name").text(response.name);
            yii.common.flash($test);
        }
    }
    function destroy(response){
        var $test=$("#test-"+response.id);
        if($test && $test.data("random")!=response.random){
            $test.data("random",response.random);
            $test.fadeOut(function(){
                $(this).remove();
            });
        }
    }
    return {
        init:init,
        create:create,
        edit:edit,
        destroy:destroy
    }
})(jQuery);