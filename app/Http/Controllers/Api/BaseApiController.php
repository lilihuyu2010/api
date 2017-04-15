<?php

namespace App\Http\Controllers\Api;

use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BaseApiController extends BaseController
{

    use Helpers;
    public function __construct(Request $request)
    {
        apiLog()->debug('##################################################');
        apiLog()->debug('request route:' . $request->getRequestUri());
    }

    /**
     * 请求成功响应
     * @param $statusCode
     * @param $msg
     * @param array $data
     * @return mixed
     */
    protected function successRequest($data = [], $code = 1)
    {
        $data['status'] = &$code;
        apiLog()->debug('response log:', $data);
        return $this->response->array($data);

    }

    protected function success($data = [], $msg = '', $status = 1)
    {
        $response = [
            'data' => &$data,
            'msg' => &$msg,
            'status' => &$status
        ];
        return $this->response->array($response);
    }

    /**
     * 控制器异常处理
     * @param $e
     * @return mixed
     */
    protected function exceptionHandle($e)
    {
        if ($e instanceof BadRequestHttpException) {
            apiLog()->info('logic error:' . $e->getFile() . ' ' . $e->getLine() . ' ' . $e->getMessage());
            return $this->errorBadRequest($e->getCode(), $e->getMessage());
        } else {
            apiLog()->error('+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++');
            apiLog()->error('framework error:' . $e->getMessage() . "\n" . $e->getTraceAsString());
            apiLog()->error('+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++');
            return $this->errorBadRequest(ErrorCodeEnum::CODE_5000, 'system error');
        }
    }

    protected function checkData(&$data)
    {
        if (is_array($data) && !empty($data)) {
            foreach ($data as $k => &$v) {

                if (is_array($v)) {
                    $this->checkData($v);
                } elseif ($v === null) {
                    $v = '';
                }

            }
        }
        return $data;
    }

    /**
     * 请求失败响应
     * @param $errorCode
     * @param string $errordesc
     * @param int $status
     * @return mixed
     */
    protected function errorBadRequest($errorCode, $errordesc = '', $httpCode = 1)
    {
        if (is_array($errordesc)) $errordesc = json_encode($errordesc);
        $errorCode = (int)$errorCode;
        $errorCode = $errorCode ? $errorCode : 1;
        $response = [
            'error' => &$errorCode,
            'errordesc' => &$errordesc,
            'status' => 0
        ];

        return $this->response->array($response)->setStatusCode($httpCode);
    }


}