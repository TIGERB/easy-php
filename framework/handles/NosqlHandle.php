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
 * nosql处理机制
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class NosqlHandle implements Handle
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        # code...
    }


    /**
     * 注册配置文件处理机制
     *
     * @param  App    $app 框架实例
     * @return void
     */
    public function register(App $app)
    {
        $config = $app::$container->getSingle('config');
        $config = explode(',', $config->config['nosql']);
        foreach ($config as $v) {
            $className = 'Framework\Nosql\\' . ucfirst($v);
            new $className();
        }
    }
}
