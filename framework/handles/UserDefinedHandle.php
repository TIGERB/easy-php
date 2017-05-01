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
 * 用户自定义handle
 *
 * 用户可以自定义框架运行到路由前的操作
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class UserDefinedHandle implements Handle
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        # code...
    }

    /**
     * 注册用户自定义操作
     *
     * @param  App    $app 框架实例
     * @return void
     */
    public function register(App $app)
    {
        // 获取配置
        $config  = $app::$container->getSingle('config');
        foreach ($config->config['module'] as $v) {
            $v = ucwords($v);
            $className = "\App\\{$v}\\Logics\UserDefinedCase";
            new $className($app);
        }
    }
}
