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
use Easy\Log;

/**
 * 框架日志处理
 *
 * Framework's log class
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class LogHandle implements Handle
{
    /**
     * log config
     *
     * @var string
     */
    private $logConfig = '';

    /**
     * init the easy log
     *
     * @param  App    $app 框架实例
     * @return void
     */
    public function register(App $app)
    {
        new LogHandle();
    }

    /**
     * 构造函数
     *
     * construct
     */
    public function __construct()
    {
        /**
         * 日志目录检查
         *
         * check log path env config
         */
        $this->logConfig = env('log');
        if (empty($this->logConfig)) {
            throw new CoreHttpException(400, 'log config is not defined');
        }
        if (! isset($this->logConfig['path'])) {
            throw new CoreHttpException(400, 'log path is not defined');
        }
        if (! isset($this->logConfig['name'])) {
            throw new CoreHttpException(400, 'log name is not defined');
        }
        if (! isset($this->logConfig['size'])) {
            throw new CoreHttpException(400, 'log size is not defined');
        }
        $instance = Log::getInstance();
        $instance->logFileName = $this->logConfig['name'];
        $instance->logPath = App::$app->rootPath . $this->logConfig['path'];
        $instance->logFileSize = $this->logConfig['size'];
    }
}
