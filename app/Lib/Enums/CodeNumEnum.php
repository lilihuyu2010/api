<?php
/**
 * Created by PhpStorm.
 * User: lili
 * Date: 17/4/15
 * Time: 18:06
 */

namespace App\Lib\Enums;


class CodeNumEnum
{
    const ERROR_CODE = 100;
    const SUCCESS_CODE = 200;

    const SYSTEM_COMMAND_CODE = 300;

    /**
     * 时间戳为空
     */
    const ERROR_TIMESTAMP_NULL = 101;

    /**
     * 时间戳错误
     */
    const ERROR_TIMESTAMP_FALSE = 102;
}