<?php

namespace app\extensions\js\jquery;

/**
 * Class Jquery
 * @html http://jquery.cuishifeng.cn/
 */
class Jquery{
    //--static attribute
    static $noop;
    static $support;
    static $fx;//{off,interval}
    static $fn;//{extend(),jquery}

    //--static method
    //核心
    static function __self($var){}
    static function _extend($var){}
    static function onConflict($var){}
    //事件对象
    static function callbacks(){}
    //ajax
    static function ajax($obj){}
    static function get($obj){}
    static function post($obj){}
    static function getJSON($obj){}
    static function getScript($obj){}
    static function ajaxPrefilter($obj){}
    static function ajaxSetup($obj){}
    //工具
    static function trim($string){}
    static function _each($obj,$function){}
    static function inArray($one,$arr){}//return index|-1
    static function toArray(){}
    static function unique(){}
    static function grep($arr,$function){}
    static function makeArray($arr){}//return array 类数组对象生成数组
    static function when(){}
    static function merge($arr1,$arr2){}
    static function _map($arr,$function){}
    static function globalEval($string){}
    static function proxy($function,$context){}
    static function type($var){}
    static function isArray($var){}
    static function isNumeric($var){}
    static function isFunction($var){}
    static function isEmptyObject($var){}
    static function isPlainObject($var){}
    static function isWindow($var){}
    static function now(){}
    static function _error($string){}
    static function parseJSON($string){}
    static function parseHTML($string){}
    static function parseXML($string){}
    static function contains($obj,$obj2){}
    static function param($obj){}


    static function access(){}
    static function camelCase($string){}

    //--attribute
    public $length;
    public $context;
    public $selector;
    public $jquery;//version

    //--method
    function __construct($string){}
    //核心2
    function each($function){}
    function size(){}
    function index(){}
    function data(){}
    function removeData(){}
    function queue(){}
    function dequeue(){}
    function clearQueue(){}
    function extend($obj){}//$.fn.extend
    //ajax与表单
    function load($string){}//加载页面到对象中
    function ajaxStart(){}
    function ajaxComplete(){}
    function ajaxError(){}
    function ajaxSend(){}
    function ajaxStop(){}
    function ajaxSuccess(){}
    function serialize(){}
    function serializeArray(){}
    //属性
    function attr($string,$string=null){}
    function removeAttr($string){}
    function prop($string,$string=null){}
    function removeProp(){}
    function val(){}
    function text(){}
    function html(){}
    function addClass(){}
    function removeClass(){}
    function toggleClass(){}
    function hasClass(){}
    function nodeName(){}
    //事件
    function ready(){}
    function on(){}
    function off(){}
    function bind(){}
    function one(){}
    function trigger(){}
    function triggerHandler(){}
    function unbind(){}
    function delegate(){}
    function undelegate(){}
    function hover(){}
    function blur(){}
    function change(){}
    function click(){}
    function dblclick(){}
    function error(){}
    function focus(){}
    function focusin(){}
    function focusout(){}
    function keydown(){}
    function keypress(){}
    function keyup(){}
    function mousedown(){}
    function mouseenter(){}
    function mouseleave(){}
    function mousemove(){}
    function mouseout(){}
    function mouseover(){}
    function mouseup(){}
    function resize(){}
    function scroll(){}
    function select(){}
    function submit(){}
    function unload(){}
    //效果
    function show(){}
    function hide(){}
    function toggle(){}
    function slideDown(){}
    function slideUp(){}
    function slideToggle(){}
    function fadeDown(){}
    function fadeUp(){}
    function fadeTo(){}
    function fadeToggle(){}
    function animate(){}
    function stop(){}
    function delay(){}
    function finish(){}
    //文档处理
    function append(){}
    function appendTo(){}
    function prepend(){}
    function prependTo(){}
    function after(){}
    function before(){}
    function insertAfter(){}
    function insertBefore(){}
    function wrap(){}
    function unwrap(){}
    function wrapAll(){}
    function wrapInner(){}
    function replaceWith(){}
    function replaceAll(){}
    function _empty(){}
    function remove(){}
    function detach(){}
    function _clone(){}
    //筛选
    function eq(){}
    function first(){}
    function last(){}
    function filter(){}
    function is(){}
    function map(){}
    function has(){}
    function not(){}
    function slice(){}
    function children(){}
    function closest(){}
    function find(){}
    function next(){}
    function nextAll(){}
    function nextUntil(){}
    function offsetParent(){}
    function parent(){}
    function parents(){}
    function parentsUntil(){}
    function prev(){}
    function prevAll(){}
    function prevUntil(){}
    function siblings(){}
    function add(){}
    function andSelf(){}
    function addBack(){}
    function contents(){}
    function end(){}
}
