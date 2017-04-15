<?php

/**
 * Created by PhpStorm.
 * User: lili
 * Date: 17/4/15
 * Time: 17:36
 */
namespace App\Lib\Enums;

class CustomerEnum
{

    /**
     * 审核状态
     */
    //未审核
    const UN_CHECK = 0;
    //审核通过
    const CHECK_PASS = 1;
    //审核拒绝
    const CHECK_REJECT = -1;
}