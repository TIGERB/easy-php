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
use Exception;

/**
 * 注册加载handle
 */
class ExceptionHandle implements Handle
{

    public function __construct()
    {
        # code...
    }


    public function register()
    {
        set_exception_handler([$this, 'exceptionHandler']);
    }

    public function exceptionHandler($exception)
    {
        $exceptionInfo = [
            'number'  => $exception->getCode(),
            'message' => $exception->getMessage(),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine(),
            'trace'   => $exception->getTrace(),
        ];

        throw new Exception(json_encode($errorInfo), 500);
    }

}
