<?php

namespace app\extensions\js\jquery;

class Event {
    public $currentTarget;
    public $data;
    public $delegateTarget;
    public $namespace;
    public $pageX;
    public $pageY;
    public $relatedTarget;
    public $result;
    public $target;
    public $timeStamp;
    public $type;
    public $which;

    function isDefaultPrevented(){}
    function isPropagationStopped(){}
    function isImmediatePropagationStopped(){}
    function preventDefault(){}
    function stopPropagation(){}
    function stopImmediatePropagation(){}
}