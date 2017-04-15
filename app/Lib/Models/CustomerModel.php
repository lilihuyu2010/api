<?php

/**
 * Created by PhpStorm.
 * User: lili
 * Date: 17/4/15
 * Time: 17:05
 */
namespace App\Lib\Models;


class CustomerModel extends BaseModel
{
    protected $table = 'fy_customer';

    protected $connection = 'customer';

    protected $dates = array();

    protected $hidden = array();

    protected $primaryKey = 'id';

    protected static $redisConnection = '';


}