<?php

interface ArrayListInterface {

    function addToPos($index, $obj);

    function add($obj);

    function addAll($arr);

    function clear();

    function contains($obj);

    function get($index);

    function indexOf($obj);

    function isEmpty();

    function lastIndexOf($obj);

    function removeAt($index);
    
    function remove($obj);
    
    function removeRange($fromIndex, $toIndex);

    function size();

    function sort();

    function toArray();

    function hasNext();

    function reset();

    function next();
}
