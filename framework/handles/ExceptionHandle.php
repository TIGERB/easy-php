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

namespace Framework\Handles;

use Framework\App;
use Framework\Handles\Handle;
use Framework\Exceptions\CoreHttpException;

/**
 * 未补货异常处理机制
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class ExceptionHandle implements Handle
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        # code...
    }

    /**
     * 注册未捕获异常函数
     *
     * @param  App    $app 框架实例
     * @return void
     */
    public function register(App $app)
    {
        set_exception_handler([$this, 'exceptionHandler']);
    }

    /**
     * 未捕获异常函数
     *
     * @param  object $exception 异常
     * @return void
     */
    public function exceptionHandler($exception)
    {
        throw $exception;
    }

}
