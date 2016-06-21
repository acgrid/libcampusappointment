<?php
/**
 * Created by PhpStorm.
 * User: acgrid
 * Date: 2016/6/20
 * Time: 23:42
 */

namespace CampusAppointment\Helper;


class Generator
{
    public static function nextId(array &$items, string $key, int $default = 1)
    {
        return array_reduce($items, function($carry, $item) use ($key){
            return $item->$key > $carry ? $item->$key + 1 : $carry;
        }, $default);
    }

    public static function sortIndexedArray(array &$items, string $key)
    {
        return uasort($items, function($left, $right) use ($key) {
            if($left->$key == $right->$key) return 0;
            return $left->$key > $right->$key ? 1 : -1;
        });
    }
}