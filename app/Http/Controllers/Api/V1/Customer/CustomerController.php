<?php

/**
 * Created by PhpStorm.
 * User: lili
 * Date: 17/4/15
 * Time: 16:12
 */
namespace App\Http\Controllers\Api\V1\Customer;

use App\Lib\Enums\CodeNumEnum;
use App\Lib\Enums\ErrorCodeEnum;
use App\Lib\Store\CustomerStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController;
use Mockery\CountValidator\Exception;

class CustomerController extends BaseApiController
{
    public function Index(Request $request)
    {
        try {
            $params['page'] = $request->input('page');
            $params['pageSize'] = $request->input('pageSize');
            $params['customerName'] = $request->input('customerName');
            $params['customerMobile'] = $request->input('customerMobile');
            $params['customerArea'] = $request->input('customerArea');
            $params['companyName'] = $request->input('companyName');
            $params['adminId'] = $request->input('adminId');

            $list = CustomerStore::getCustomerList($params);
            return $this->successRequest($list ? $list : [],CodeNumEnum::SUCCESS_CODE);
        } catch (Exception $e) {
            return $this->exceptionHandle($e);
        }
    }
}