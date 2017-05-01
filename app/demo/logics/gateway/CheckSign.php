<?php
/********************************************
 *                Easy PHP                  *
 *                                          *
 * A lightweight PHP framework for studying *
 *                                          *
 *                 TIERGB                   *
 *      <https://github.com/TIGERB>         *
 *                                          *
 ********************************************/

namespace App\Demo\Logics\Gateway;

use Framework\Request;
use App\Demo\Logics\Gateway\Check;
use Framework\Exceptions\CoreHttpException;

/**
 * 检验网关签名
 */
class CheckSign extends Check
{
    /**
     * 不参与签名的字段
     *
     * @var array
     */
    private $filiterField = [
        'sign',
        's'
    ];

    /**
     * 校验方法
     *
     * @param Request $request 请求对象
     */
    public function doCheck(Request $request)
    {
        $appKeyMap = $request->env('app_key_map');
        $appKey    = $request->request('app_key');
        $secretKey = $appKeyMap[$appKey];
        $data      = $request->all();
        ksort($data);// 键名首字母升序排序
        $sign      = array();
        foreach ($data as $key => $value) {
            if (! in_array($key, $this->filiterField) && (! empty($value) || $value == 0)) {// 过滤
                $sign[] = rawurldecode($value);// 解码过滤
            }
        }
        array_unshift($sign, $secretKey);
        array_push($sign, $secretKey);
        $string  = implode('', $sign);
        $md5     = md5(sha1($string));
        if ($data['sign'] !== $md5) {// 验证signature
            $info = 'invaild sign';
            // 开发环境输出正确签名信息
            if ($request->env('env')['env'] === 'develop') {
                $info = "invaild sign. info: string->{$string}, sign->{$md5}";
            }
            throw new CoreHttpException($info, 401);
        }
    }
}
