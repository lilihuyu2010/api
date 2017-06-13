<?php
/**
 * Created by PhpStorm.
 * User: lili
 * Date: 17/6/13
 * Time: 14:37
 */

namespace App\Lib\Structs;


class CommandStruct
{
    public static function getCommandResult($command)
    {
        switch ($command) {
            case '@date':
                return date('Y-m-d');
                break;
            case '@time':
                return date('Y-m-d H:i:s');
                break;
            case '@server':
                return phpinfo();
                break;
            default:
                return false;
                break;
        }
    }
}