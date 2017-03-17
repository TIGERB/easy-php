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

namespace Framework\Handles;

use Framework\Handles\Handle;
use Framework\Exceptions\CoreHttpException;

/**
 * 注册加载handle
 */
class ErrorHandle implements Handle
{

    public function __construct()
    {
        # code...
    }

    /**
     * 注册错误处理机制
     *
     * @return mixed
     */
    public function register()
    {
        set_error_handler([$this, 'errorHandler']);

        register_shutdown_function([$this, 'shutdown']);
    }

    /**
     * 脚本结束
     *
     * @return　mixed
     */
    public function shutdown()
    {
        $error = error_get_last();
        if (empty($error)) {
            return;
        }
        $errorInfo = [
            'type'    => $error['type'],
            'message' => $error['message'],
            'file'    => $error['file'],
            'line'    => $error['line'],
        ];

        CoreHttpException::reponse($errorInfo);
    }

    /**
     * 错误捕获
     *
     * @param  int    $errorNumber  错误码
     * @param  int    $errorMessage 错误信息
     * @param  string $errorFile    错误文件
     * @param  string $errorLine    错误行
     * @param  string $errorContext 错误文本
     * @return mixed               　
     */
    public function errorHandler(
        $errorNumber,
        $errorMessage,
        $errorFile,
        $errorLine,
        $errorContext)
    {
        $errorInfo = [
            'type'    => $errorNumber,
            'message' => $errorMessage,
            'file'    => $errorFile,
            'line'    => $errorLine,
            'context' => $errorContext,
        ];

        CoreHttpException::reponse($errorInfo);
    }

}
