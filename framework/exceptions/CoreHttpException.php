<?php
/***********************************
 *             Easy PHP            *
 *                                 *
 * A light php framework for study *
 *                                 *
 *              TIERGB             *
 *   <https://github.com/TIGERB>   *
 *                                 *
 ***********************************/

namespace Framework\Exceptions;

use Exception;

/**
 * 核心http异常
 */
class CoreHttpException extends Exception
{
    /**
     * 响应异常code
     *
     * @var array
     */
    private $_httpCode = [
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
        if (empty($code)) {
            throw new Exception($this->_httpCode[400], 400);
        }
        $this->code = $code;
        if (!isset($this->_httpCode[$code])) {
            throw new Exception($this->_httpCode[404], 404);
        }
        if (empty($extra)) {
            $this->message = $this->_httpCode[$code];
            return;
        }
        $this->message = $extra . ' ' . $this->_httpCode[$code];
    }

    public static function reponse($exception)
    {
        header('Content-Type:Application/json; Charset=utf-8');
        if ($exception instanceof Excption) {
            die(json_encode([
                'coreError' => [
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage(),
                    'infomations'  => [
                        'file'  => $e->getFile(),
                        'line'  => $e->getLine(),
                        'trace' => $e->getTrace(),
                    ]
                ]
            ]));
        }
        die(json_encode([
            'coreError' => [
                'code'    => 500,
                'message' => $exception,
                'infomations'  => [
                    'file'  => $exception['file'],
                    'line'  => $exception['line'],
                ]
            ]
        ]));
    }
}
