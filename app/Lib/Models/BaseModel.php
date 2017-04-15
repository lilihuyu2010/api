<?php
/**
 * Created by PhpStorm.
 * User: lili
 * Date: 17/4/15
 * Time: 17:32
 */

namespace App\Lib\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $timestamps = false;
    protected static $redis = null;
    protected static $redisKey = null;
    protected static $key = null;
    protected static $instance = null;

    public function getConnectionStr()
    {
        return $this->connection;
    }

    public static function openQueryLog($connection)
    {
        app('db')->connection($connection)->enableQueryLog();
    }

    public static function getQueryLog($connection)
    {
        $sql = app('db')->connection($connection)->getQueryLog();
        var_dump($sql);
        exit;
    }
}