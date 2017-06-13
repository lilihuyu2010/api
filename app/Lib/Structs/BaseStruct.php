<?php
/**
 * Created by PhpStorm.
 * User: lili
 * Date: 17/6/13
 * Time: 14:24
 */

namespace App\Lib\Structs;


use App\Lib\Enums\CodeNumEnum;

class BaseStruct
{
    public static function checkTimestamp($timestamp)
    {
        if (! $timestamp) return CodeNumEnum::ERROR_TIMESTAMP_NULL;
        $now = time();
        if ($now < $timestamp || $now - $timestamp > 86400) return CodeNumEnum::ERROR_TIMESTAMP_FALSE;
        return false;
    }
}