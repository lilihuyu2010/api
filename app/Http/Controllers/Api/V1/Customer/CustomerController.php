<?php

/**
 * Created by PhpStorm.
 * User: lili
 * Date: 17/4/15
 * Time: 16:12
 */
namespace App\Http\Controllers\Api\V1\Customer;

use App\Lib\Models\NewsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController;
use GuzzleHttp\Exception\RequestException;
use \Exception;
use GuzzleHttp\Client as HttpClient;
use DB;

class CustomerController extends BaseApiController
{
    private $url = 'http://api.lili.local/v1/customer/send';


    public function Index(Request $request)
    {
        $this->validate($request, [
            'addressBook' => 'required|string',
        ]);

        $contacts = $this->decrypt(base64_decode($request->addressBook));
        var_dump($contacts);
    }

    public function decrypt($addressBook)
    {
        $z = gzdecode(substr($addressBook, 0, strlen($addressBook)-4));
        echo $z;die;
        if (!$z) {
            echo 2;
        }

        $j = json_decode($z, true);
        if (!$j) {
            echo 3;
        }

        return $j;
    }

    public function sendRequest($params)
    {
        $httpClient = new HttpClient();
        try {
            $response = $httpClient->request(
                'POST',
                $this->url,
                $params
            );
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            if (is_null($data) or !is_array($data)) {
                echo 'data为空';
            }

            if ($data['error'] != 200) {
                echo 'code不等于200';
            }

            return json_decode($body, true);
        } catch (Exception $e) {
            // build log info
            $t = [
                'request' => ['params' => $params],
                'exception' => $e->getMessage(),
            ];
            if ($e instanceof RequestException and $e->hasResponse()) {
                $t['response'] = [
                    'code' => $e->getResponse()->getStatusCode(),
                    'body' => $e->getResponse()->getBody()->getContents(),
                ];
            }

            throw $e;
        }
    }

}