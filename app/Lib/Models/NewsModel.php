<?php
/**
 * Created by PhpStorm.
 * User: lili
 * Date: 17/6/13
 * Time: 17:57
 */

namespace App\Lib\Models;


class NewsModel extends BaseModel
{
    protected $table = 'news';

    protected $connection = 'brokenswitch';

    protected $dates = array();

    protected $hidden = array();

    protected $primaryKey = 'id';

    protected static $redisConnection = '';

    public static function getAll($where = [], $limit = 30)
    {
        return static::where($where)->limit($limit)->get()->toArray();
    }

    public static function getOne($where = [])
    {
        return static::where($where)->first()->toArray();
    }
}