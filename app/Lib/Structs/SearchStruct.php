<?php

/**
 * Created by PhpStorm.
 * User: lili
 * Date: 17/6/13
 * Time: 14:07
 */

namespace App\Lib\Structs;

use App\Lib\Enums\CodeNumEnum;
use App\Lib\Structs\CommandStruct;

class SearchStruct extends BaseStruct
{
    public function search($input, $timestamp = 0)
    {
        $code = CodeNumEnum::SUCCESS_CODE;
        $data = [];
        //检查时间戳格式
        if (! $checkStatus = self::checkTimestamp($timestamp)) {
            $code = $checkStatus;
        }
        //如果是命令
        if (substr($input,0,1) == '!') {
            if (! $commandResult = CommandStruct::getCommandResult($input)) {
                $data = [$commandResult];
                $code = CodeNumEnum::SYSTEM_COMMAND_CODE;
            }
        }

        return ['code' => $code, 'data' => $data];
    }


}