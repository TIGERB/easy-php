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

namespace Framework\Exceptions;

use Exception;

/**
 * 核心http异常
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class CoreHttpException extends Exception
{
    /**
     * 响应异常code
     *
     * @var array
     */
    private $httpCode = [
        // 缺少参数或者必传参数为空
        400 => 'Bad Request',
        // 没有访问权限
        403 => 'Forbidden',
        // 访问的资源不存在
        404 => 'Not Found',
        // 代码错误
        500 => 'Internet Server Error',
        // Remote Service error
        503 => 'Service Unavailable'
    ];

    /**
     * 构造函数
     *
     * @param int $code excption code
     * @param string $extra 错误信息补充
     */
    public function __construct($code = 200, $extra = '')
    {
        $this->code = $code;
        if (empty($extra)) {
            $this->message = $this->httpCode[$code];
            return;
        }
        $this->message = $extra . ' ' . $this->httpCode[$code];
    }

    public function reponse()
    {
        header('Content-Type:Application/json; Charset=utf-8');
        die(json_encode([
            '__coreError' => [
                'code'    => $this->getCode(),
                'message' => $this->getMessage(),
                'infomations'  => [
                    'file'  => $this->getFile(),
                    'line'  => $this->getLine(),
                    'trace' => $this->getTrace(),
                ]
            ]
        ]));
    }

    public static function reponseErr($e)
    {
        header('Content-Type:Application/json; Charset=utf-8');
        die(json_encode([
            '__coreError' => [
                'code'    => 500,
                'message' => $e,
                'infomations'  => [
                    'file'  => $e['file'],
                    'line'  => $e['line'],
                ]
            ]
        ]));
    }
}
