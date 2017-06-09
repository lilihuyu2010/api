<?php
/**
 * Created by PhpStorm.
 * User: lili
 * Date: 17/6/9
 * Time: 16:09
 */

namespace App\Http\Controllers\Api\V1\Customer;


use App\Http\Controllers\Api\BaseApiController;
use Dingo\Api\Contract\Http\Request;

class SearchController extends BaseApiController
{
    public function Index(Request $request)
    {
        var_dump($request);
    }
}