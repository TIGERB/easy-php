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
     * 运行模式
     *
     * fpm/swoole
     * 
     * @var string
     */
    private $mode = 'fmp';

    /**
     * 错误信息
     *
     * @var array
     */
    private $info = [];

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
        $this->info = [
            'code'       => $exception->getCode(),
            'message'    => $exception->getMessage(),
            'file'       => $exception->getFile(),
            'line'       => $exception->getLine(),
            'trace'      => $exception->getTrace(),
            'previous'   => $exception->getPrevious()
        ];

        $this->end();
    }

    /**
     * 脚本结束
     *
     * @return　mixed
     */
    private function end()
    {
        switch ($this->mode) {
            case 'swooole':
                CoreHttpException::reponseErrSwoole($this->info);
            break;

            default:
                CoreHttpException::reponseErr($this->info);
            break;
        }
    }
}
