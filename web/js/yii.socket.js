/**
 * socket
 */
yii.socket=(function($){
    var debug=false;
    var $wsData;
    var ws;
    var clientID;
    function init(){
        $wsData=$("#ws-data");
        ws = new WebSocket("ws://" + document.domain + ":7272");
        ws.onopen = function(){
            var data={type:"init",user:$wsData.data("user"),group:"tower-"+$wsData.data("team")};
            ws.send(JSON.stringify(data));
            if(debug) console.log("send",data);
        };
        ws.onmessage = function(e){
            if(debug) console.log("on-message", e.data);
            var data= $.parseJSON(e.data);
            if(data.type=="ping") {
                var send = {type: "pong"};
                ws.send(JSON.stringify(send));
            }else if(data.type=="connect"){
                clientID=data.clientID;
            }else if(data.type=="init"){

            }else{
                var arr = data.type.split("-");
                if(yii[arr[0]] && $.isFunction(yii[arr[0]][arr[1]])){
                    yii[arr[0]][arr[1]](data);//处理message
                }else{
                    if(debug) console.log("message can not found handler",data.type);//找不到处理方法
                }
            }
        };
        ws.onclose = function () {
            if(debug) console.log("on-close");
            setTimeout(function(){
                init();
            },60000);
        };
        ws.onerror = function () {
            if(debug) console.log("on-error");
        };
    }

    /**
     * 避免重复执行
     * @param $target
     * @param response
     * @returns {boolean}
     */
    function ensure($target,response){
        if($target.size() && $target.data("random")!=response.random){
            $target.data("random", response.random);
            return true;
        }
        return false;
    }
    return {
        init:init,
        ensure:ensure
    };
})(jQuery);