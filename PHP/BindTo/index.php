<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-03-27
 * Time: 23:17
 */

$closure = function ($name) {
    return sprintf("Hello %s", $name);
};

echo $closure('josh');


$numbersPlusOne = array_map(function ($number){
    return $number+1;
},[1, 23,3]);

print_r($numbersPlusOne);

function enclosePerson($name)
{
    return function ($doCommand) use ($name) {
        return sprintf('%s %s', $name, $doCommand);
    };
}

$clay = enclosePerson('Clay');
echo $clay('get me sweet tea');
