yii.time = (function($) {
    var pub = {
        config:[".auto-fuzzy-time"],
        init: function() {
            initAutoFuzzyTime();
        },
        getFuzzyTime:function(time){
            var now=new Date();
            var dayDuration=Math.floor(time/(3600*24*1000))-Math.floor(now.getTime()/(3600*24*1000));//天数相差
            var secondDuration=Math.floor(time/(1000))-Math.floor(now.getTime()/(1000));//秒数相差
            if(dayDuration==-2){
                return "前天";
            }else if(dayDuration==-1){
                return "昨天";
            }else if(dayDuration==0){
                if(secondDuration>0){
                    return "今天";
                }else if(secondDuration>-60){
                    return "刚刚";
                }else if(secondDuration>-3600){
                    return Math.floor(-secondDuration/60)+"分钟前";
                }else{
                    return Math.floor(-secondDuration/3600)+"小时前";
                }
            }else if(dayDuration==1){
                return "明天";
            }else if(dayDuration==2){
                return "后天";
            }else{
                var timeObj=new Date(time);
                if(now.getFullYear()==timeObj.getFullYear()){
                    return (timeObj.getMonth()+1)+"月"+timeObj.getDate()+"日";
                }else{
                    return timeObj.getFullYear()+"年"+(timeObj.getMonth()+1)+"月"+timeObj.getDate()+"日";
                }
            }
        }
    };
    function initAutoFuzzyTime(){
        var config=pub.config;
        var $times=$(config[0]);
        setInterval(function(){
            $times.each(function(){
                var $time=$(this);
                $time.text(pub.getFuzzyTime($time.data("time")));
            });
        },60000);
    }
    return pub;
})(jQuery);