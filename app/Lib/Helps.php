<?php

if (!function_exists('apiLog')) {
    /**
     * 写日志
     * @return \Laravel\Lumen\Application|mixed|null
     */
    function apiLog()
    {
        static $logDrive = null;
        if (!isset($logDrive)) $logDrive = app('log');
        return $logDrive;
    }
}

if (!function_exists('getHoroscope')) {
    /**
     * 获取星座
     * @param $date
     * @return int|mixed
     */
    function getHoroscope($date)
    {
        if (empty($date)) return 0;
        $constellationArr = [11, 12, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $constellationEdgeDay = [20, 19, 21, 21, 21, 22, 23, 23, 23, 23, 22, 22];
        $time = strtotime($date);
        if (!$time) return 0;
        $month = date('m', $time);
        $day = date('d', $time);
        if ($day < $constellationEdgeDay[$month])
            $month--;
        return $month >= 0 ? $constellationArr[$month] : $constellationArr[11];
    }
}

if (!function_exists('getZodiac')) {
    /**
     * 获取生肖
     * @param $date
     * @return int
     */
    function getZodiac($date)
    {
        if (empty($date)) return 0;
        $date = date('Y', strtotime($date));
//    $data = ['鼠', '牛', '虎', '兔', '龙', '蛇', '马', '羊', '猴', '鸡', '狗', '猪'];
        $index = ($date - 1900) % 12;

        return $index;

    }
}

if (!function_exists('safeGet')) {
    /**
     * 从数组或对象安全的获取数据
     * @param $data
     * @param $key
     * @param null $defaultValue
     * @return mixed|null
     */
    function safeGet(&$data, $key, $defaultValue = null)
    {
        if (is_object($data)) {

            if (isset($data->$key)) return $data->$key;

        } elseif (is_array($data)) {

            if (isset($data[$key])) return $data[$key];

        }

        return $defaultValue;
    }
}

if (!function_exists('getAgeByBirthday')) {
    /**
     * 根据生日获取年龄
     * @param $birthday
     * @return false|string
     */
    function getAgeByBirthday($birthday)
    {
        $birthday = strtotime($birthday);
        if ($birthday == 0) {
            return 20;
        }
        $birthday = date('Y-m-d', $birthday);

        list($year, $month, $day) = explode("-", $birthday);
        $year_diff = date("Y") - $year;
        $month_diff = date("m") - $month;
        $day_diff = date("d") - $day;
        if ($day_diff < 0 || $month_diff < 0)
            $year_diff--;

        //特殊处理
        if ($year_diff < 16) $year_diff = 20;
        return $year_diff;
    }
}

if (!function_exists('tranArrayKeyToUC')) {
    /**
     * 递归转换数组的所有KEY 为指定命名格式,解决Java毫无人性的命名格式随时转换
     * 0全小写 1驼峰 2单词首字符全大写
     * @param $data
     * @return array
     */
    function tranArrayKeyToUC($data, $type = 0)
    {
        $tmp = [];
        $type = (int)$type;

        foreach ($data as $k => &$v) {

            if (is_array($v)) $v = tranArrayKeyToUC($v, $type);

            if (!is_numeric($k)) {
                switch ($type) {
                    case 0:
                        $k = strtolower($k);
                        break;
                    case 1:
                        $k = lcfirst(ucwords($k));
                        break;
                    case 2:
                        $k = ucwords($k);
                        break;
                    default:
                }
            }

            $tmp[$k] = $v;

        }

        return $tmp;
    }
}

if (!function_exists('versionFormat')) {
    /**
     * 格式化版本信息
     * @param $version
     * @return int
     */
    function versionFormat($version)
    {
        if (empty($version)) return 0;
        $verArr = explode('\\.', $version);
        $verStr = '';

        foreach ($verArr as $v) {
            $len = strlen($v);
            if ($len == 1) {
                $verStr .= '0';
                $verStr .= $v;
            } elseif ($len == 2) {
                $verStr .= $v;
            } else {
                // 特殊处理像 [0.9.0831]这样的版本
                $verStr .= substr($v, 0, 2);
            }
        }

        // 处理2.2这类格式的数据
        if (count($verArr)) $verStr .= '00';

        return (int)$verStr;
    }
}

if (!function_exists('loadConfig')) {
    /**
     * 加载配置文件
     * @param $fileName
     * @param $key
     * @return mixed
     */
    function loadConfig($fileName, $key)
    {
        static $loadedConfigList = [];
        if (!isset($loadedConfigList[$fileName])) {
            $loadedConfigList[$fileName] = true;
            app()->configure($fileName);
        }
        return config($fileName . '.' . $key);
    }

}

if (!function_exists('makeRandKey')) {
    /**
     * 生成account表中的randkey
     * @return int
     */
    function makeRandKey()
    {
        return rand(1000, 10000);
    }
}

if (!function_exists('makeAccountPassword')) {
    /**
     * 生成密码
     * @param $password
     * @param $randKey
     * @return string
     */
    function makeAccountPassword($password, $randKey)
    {
        return md5($password . '@' . $randKey);
    }
}

if (!function_exists('getLoginUserId')) {
    /**
     * 全局获取当前用户登录ID
     * @return mixed|null
     */
    function getLoginUserId()
    {
        $key = isset($_REQUEST['key']) ? $_REQUEST['key'] : null;
        if (empty($key)) return null;
        $userId = \App\Lib\Cache\SessionKeyCache::getUserId($key);
        return empty($userId) ? null : $userId;
    }
}

if (!function_exists('makeShortFileUrl')) {
    /**
     * 从照片路径得到小照片路径
     * @param $filePath
     * @return mixed|string
     */
    function makeShortFileUrl($filePath)
    {
        if (strpos($filePath, '_s') !== false) {
            $filePath = str_replace('_s', '', $filePath);
        }
        $index = strrchr($filePath, '.');
        if ($index > 0) {
            return substr($filePath, 0, $index) . '_s' . substr($filePath, $index);
        }
        return $filePath;
    }
}

if (!function_exists('geeTest')) {
    /**
     * 极验验证
     * @param $geetest_challenge
     * @param $geetest_validate
     * @param $geetest_seccode
     * @param $clientIp
     * @return bool
     */
    function geeTest($geetest_challenge, $geetest_validate, $geetest_seccode, $clientIp)
    {
        $geetest_id = loadConfig('application', 'geetest_id');
        $geetest_key = loadConfig('application', 'geetest_key');
        $gtSDK = new GeetestLib($geetest_id, $geetest_key);
        $re = (boolean)$gtSDK->success_validate($geetest_challenge, $geetest_validate, $geetest_seccode, $clientIp);
        if (!$re)
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException('', null, \App\Lib\Enums\ErrorCodeEnum::GEETEST_8201);
        return $re;
    }
}

if (!function_exists('emojiToUtf8')) {
    /**
     * 含emoji表情字符串转为utf8串
     * @param $text
     * @return mixed
     */
    function emojiToUtf8($text)
    {
        if (empty($text)) return '';
        //处理名字的emoji符号
        $tmpStr = json_encode($text); //暴露出unicode
        $tmpStr1 = preg_replace_callback("#(\\\ue[0-9a-f]{3})#i", function ($a) {
            return addslashes($a[1]);
        }, $tmpStr);
        $text = json_decode($tmpStr1);
        return $tmpStr1;
    }

    /**
     * 解析unicode名字
     * @param $data
     * @return string
     */
    function unicodeDecode($data)
    {
        $data = (string)$data;
        $data = str_replace('"', '', $data);
        $jsonStr = '{"str":"' . $data . '"}';
        $tmpArr = json_decode($jsonStr, true);
        if (isset($tmpArr['str'])) return $tmpArr['str'];
        return '';
    }

}

if (!function_exists('makeToken')) {
    /**
     * token生成
     * @param $imei
     * @param $userId
     * @return string
     */
    function makeToken($imei, $userId)
    {
        return sha1($imei . $userId);
    }
}


if (!function_exists('makeSessionKey')) {
    /**
     * 生成sessionKey
     * @return mixed
     */
    function makeSessionKey()
    {
        $sessionKey = \Webpatser\Uuid\Uuid::generate(1, $_SERVER['SERVER_ADDR'])->string;
        return str_replace('-', '', $sessionKey);
    }
}

if (!function_exists('getJavaTime')) {
    /**
     * 获取Java时间戳
     * @param null $unixTime
     * @return null|string
     */
    function getJavaTime($unixTime = null)
    {
        if (isset($unixTime)) {

            if (strlen($unixTime) > 10) {
                // java 时间戳
                return $unixTime;
            } else {
                //php转java
                return (string)$unixTime . '000';
            }

        } else {
            // 获取java时间戳
            return $unixTime = ((string)time()) . '000';
        }
    }

    /**
     * java转php时间戳
     * @param null $unixTime
     * @return bool|null|string
     */
    function getPhpTime($unixTime = null)
    {
        if (isset($unixTime)) {
            if (strlen($unixTime) > 10) {
                return substr($unixTime, 0, 9);
            } else {
                return $unixTime;
            }
        }
        return time();
    }
}

/**
 * 数值转字节
 * @param $val
 * @return string
 */
function numberToBytes($val)
{
    return pack('J', $val);
}

/**
 * 字节转数值
 * @param $redisByte
 * @return array
 */
function bytesToNumber($redisByte)
{
    if (empty($redisByte)) return null;
    $arr = unpack('J', $redisByte);
    if (is_array($arr) && isset($arr[1])) {
        return $arr[1];
    }
    return null;
}

