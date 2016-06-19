<?php

namespace app\extensions\js;
use app\extensions\js\jquery\Jquery;

class JqueryUI extends Jquery{
    //static
    static function widget($obj){}
    //Interactions
    function draggable($obj){}
    function droppable($obj){}
    function sortable($obj){}
    function resizable($obj){}
    function selectable($obj){}
    //Widgets
    function accordion($obj){}//折叠
    function autocomplete($obj){}//输入提示
    function button($obj){}//锚点按钮化
    function datepicker($obj){}//日期输入器
    function dialog($obj){}//弹窗
    function menu($obj){}//菜单
    function progressbar($obj){}//进度条
    function selectmenu($obj){}//定制select标签样式
    function slider($obj){}//滑动器
    function spinner($obj){}//数字输入框 +-按钮效果
    function tabs($obj){}//选项卡
    function tooltip($obj){}//定制title效果
    //Effects 为变换添加渐变效果 : color animation | easing
    function effect($obj){}
    function show($obj){}
    function hide($obj){}
    function toggle($obj){}
    function addClass($obj){}
    function removeClass($obj){}
    function toggleClass($obj){}
    function switchClass($obj){}
    //Utilities
    function position($obj){}
}