<?php
/**
 * Created by PhpStorm.
 * User: lili
 * Date: 17/6/9
 * Time: 16:09
 */

namespace App\Http\Controllers\Api\V1\Search;


use App\Http\Controllers\Api\BaseApiController;
use App\Lib\Enums\CodeNumEnum;
use App\Lib\Structs\SearchStruct;
use Dingo\Api\Contract\Http\Request;
use Illuminate\Http\JsonResponse;

class SearchController extends BaseApiController
{
    public function Index(Request $request)
    {
        $input = $request->get('input');
        $timestamp = $request->get('timestamp');

        $result = (new SearchStruct())->search($input, $timestamp);

        return JsonResponse::create(
            $result['data'], $result['code'],[]
        );
    }

}