<?php
/*************************************************
 *                  Easy PHP                     *
 *                                               *
 * A Faster Lightweight Full-Stack PHP Framework *
 *                                               *
 *                  TIERGB                       *
 *        <https://github.com/TIGERB>            *
 *                                               *
 *************************************************/

namespace Framework\Handles;

use Framework\App;
use Framework\Exceptions\CoreHttpException;
use Closure;
use Framework\Router\EasySwooleRouter;

/**
 * 路由处理机制.
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class RouterSwooleHandle implements Handle
{
    /**
     * 注册路由处理机制.
     *
     * @param App $app 框架实例
     * @param void
     */
    public function register(App $app)
    {
        App::$container->setSingle('router', function () {
            return new EasySwooleRouter();
        });
    }
}
