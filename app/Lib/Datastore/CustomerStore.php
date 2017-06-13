<?php
/**
 * Created by PhpStorm.
 * User: lili
 * Date: 17/4/15
 * Time: 17:34
 */

namespace App\Lib\Store;

use App\Lib\Enums\CompanyEnum;
use App\Lib\Enums\CustomerEnum;
use App\Lib\Models\CustomerModel;

class CustomerStore extends BaseStore
{
    public static function getCustomerList($params)
    {
        return CustomerModel::where([
            ['check_status','=', CustomerEnum::CHECK_PASS],
            ['companyId','<>', CompanyEnum::FU_YOU]
        ])->order('id','desc')->limit(30);
    }

    public static function handlerParams($params)
    {
        if (array_key_exists('page',$params)) {

        }
    }
}