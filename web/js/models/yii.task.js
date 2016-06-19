yii.task=(function($){
    var $tasks;//所有任务,user-tasks
    var $boxes;
    function initObj(){
        $tasks=$(".task");
        $boxes=$(".box");
    }
    function watch(){
        var $body=$(document.body);
        //create
        $body.on("click",".task-create-sub",function(e){
            var $btn=$(this);
            $("#task-create-wrap-" + $btn.data("item")).show().find(".attr-name").focus();
            $btn.hide();
        });
        $body.on("click",".task-create-show",function(e){
            var $btn=$(this);
            $("#task-create-sub-" + $btn.data("item")).hide();
            $("#item-"+$btn.data("item")).show();
            $("#task-create-wrap-" + $btn.data("item")).show().find(".attr-name").focus();
        });
        $body.on("click",".task-create-cancel",function(e){
            var $btn=$(this);
            $("#task-create-wrap-" + $btn.data("item")).hide();
            $("#task-create-sub-" + $btn.data("item")).show();
        });
        $body.on("submit",".task-create-form",function(e){
            e.preventDefault();
            var $form=$(this);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    var $item=$("#item-"+response.itemID);
                    var $list=$("#task-uncompleted-list-"+response.itemID);
                    var $task=$(response.page);
                    $list.append($task);
                    fixProgress($item.find(".progress"),"create");
                    clearForm($form);
                    $form.find(".attr-name").focus();
                }else{
                    $.each(response.errors,function(k,v){
                        alert(v[0]);return false;
                    });
                }
            });
        });
        //edit
        $body.on("click",".task-edit-show",function(e){
            var $btn=$(this);
            var $task = $("#task-" + $btn.data("id"));
            var $wrap = $("#task-edit-wrap-" + $btn.data("id"));
            $task.hide();
            $wrap.show().find(".attr-name").focus();
        });
        $body.on("click",".task-edit-cancel",function(e){
            var $btn=$(this);
            var $task = $("#task-" + $btn.data("id"));
            var $wrap = $("#task-edit-wrap-" + $btn.data("id"));
            $task.show();
            $wrap.hide();
        });
        $body.on("submit",".task-edit-form",function(e){
            e.preventDefault();
            var $form=$(this);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    var $task = $("#task-" + response.id);
                    $task.replaceWith(response.page);
                    $(".todo_desc").html(response.description);
                    $form.find(".task-edit-cancel").click();
                }else{
                    alert("fail");
                }
            });
        });
        //disable(remove|reload)
        $body.on("click",".btn-task-disable",function(e){
            e.preventDefault();
            var $btn=$(this);
            if(!confirm($btn.data("cf"))) return;
            $.get($(this).attr("href"),function(response){
                if(response.result){
                    //reload
                    if($btn.data("callback")=="reload"){
                        location.reload();
                        return;
                    }
                    //remove
                    var $task=$("#task-"+response.id);
                    $task.fadeOut(function(){
                        $task.remove();
                    });
                }else{
                    alert("fail");
                }
            });
        });
        //enable(reload)
        $body.on("click",".btn-task-enable",function(e){
            e.preventDefault();
            var $btn=$(this);
            $.get($btn.attr("href"),function(response) {
                if(response.result){
                    location.reload();
                }else{
                    alert("fail");
                }
            });
        });
        //run(replace)
        $body.on("click",".btn-task-run",function(e){
            e.preventDefault();
            $.get($(this).attr("href"),function(response){
                if(response.result){
                    //replace
                    $("#task-" + response.id).replaceWith(response.page);
                    if (response.oldTaskID) {
                        var $oldTask = $("#task-" + response.oldTaskID);
                        $oldTask.find(".runner").removeClass("on");
                        $oldTask.find(".run").show();
                        $oldTask.find(".pause").hide();
                    }
                }else{
                    alert("fail");
                }
            });
        });
        //pause(replace)
        $body.on("click",".btn-task-pause",function(e){
            e.preventDefault();
            $.get($(this).attr("href"), function (response) {
                if (response.result) {
                    //replace
                    var $task = $("#task"+response.id);
                    $task.find(".runner").removeClass("on");
                    $task.find(".run").show();
                    $task.find(".pause").hide();
                } else {
                    alert("fail");
                }
            });
        });
        //finish(remove)
        $body.on("click", ".btn-task-finish", function (e) {
            var $btn = $(this);
            $(this).parent().addClass("checked disabled");
            $.get($btn.data("url"), function (response) {
                if (response.result) {
                    finish(response);
                } else {
                    alert("fail");
                }
            });
        });
        //open(remove)
        $body.on("click", ".btn-task-open", function (e) {
            var $that = $(this);
            $(this).parent().removeClass("checked");
            $.get($that.data("url"), function (response) {
                if (response.result) {
                    open(response);
                } else {
                    alert("fail");
                }
            });
        });
        //move(edit|reload)
        $body.on("submit",".form-task-move",function(e){
            e.preventDefault();
            var $form=$(this);
            $.post($form.attr("action"),$form.serialize(),function(response){
                if(response.result){
                    if($form.data("callback")=="reload"){
                        location.reload();return;
                    }
                    $(".page-move").show().find(".project-name").text(response.project.name);
                }else{
                    alert("fail");
                }
            });
        });
        //filter
        $(".task-filter-project").change(function(e){
            var $select=$(this);
            if($select.val()==-1){
                $tasks.show();
            }else{
                $tasks.each(function(k,v){
                    var $task=$(v);
                    if($task.data("project")==$select.val()){
                        $task.show();
                    }else{
                        $task.hide();
                    }
                });
            }
            syncBoxes();
        });
        $("#task-created-more").click(function(e){
            var $that=$(this);
            var $list=$("#task-completed-list");
            $that.hide().next().show();
            $.get($(this).data("url"),{offset:$list.children().size()},function(result){
                $list.append(result.htm);
                if(result.more){
                    $that.show();
                }
                $that.next().hide();
            });
        });
        $(".task-finished-more").click(function(e){
            e.preventDefault();
            var $that=$(this);
            $.get($(this).attr("href"),function(response){
                if(response.htm){
                    $(response.htm).insertBefore($that);
                }
                if(response.moreUrl){
                    $that.attr("href",response.moreUrl);
                }else{
                    $that.attr("href","javascript:void(0)").addClass("over").text("没有更多内容了");
                }
            });
        });
    }

    function init(){
        initObj();
        watch();
    }
    function fixProgress($progress,type){
        if($progress.size()){
            var $count1=$progress.find(".count1");
            var $count2=$progress.find(".count2");
            if(type=="finish"){
                $count1.text(parseInt($count1.text())+1);
            }
            if(type=="open"){
                $count1.text(parseInt($count1.text())-1);
            }
            if(type=="create"){
                $count2.text(parseInt($count2.text())+1);
            }
            $progress.find(".inner-bar").css("width",100*parseInt($count1.text())/parseInt($count2.text())+"%");
        }
    }
    function clearForm($form){
        $form.find(".attr-name").val("");
    }
    function syncBoxes(){
        $boxes.each(function(k,v){
            var $box=$(v);
            if($box.find(".task:visible").size()>0){
                $box.removeClass("empty");
            }else{
                $box.addClass("empty");
            }
        });
    }
    //--public
    function finish(response){
        var $task=$("#task-"+response.id);
        if($task.size() && $task.data("random")!=response.random){
            $task.data("random", response.random);
            var $item=$("#item-"+response.itemID);
            $task.fadeOut(function(){
                $(this).remove();
                var $new=$(response.page);
                $item.find(".todos-completed").prepend($new);
            });
            fixProgress($item.find(".progress"),"finish");
        }
    }
    function open(response){
        var $task=$("#task-"+response.id);
        if($task.size() && $task.data("random")!=response.random){
            $task.data("random",response.random);
            //操作
            var $item=$("#item-"+response.itemID);
            $task.fadeOut(function(){
                $(this).remove();
                $item.find(".todos-uncompleted").append(response.page);
            });
            fixProgress($item.find(".progress"),"open");
        }
    }
    return {
        init:init,
        initObj:initObj,
        finish:finish,
        open:open
    }
})(jQuery);