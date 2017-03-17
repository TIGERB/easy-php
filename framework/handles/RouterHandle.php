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
use ReflectionClass;
use Load;

/**
 * 注册加载handle
 */
class RouterHandle implements Handle
{

    public function __construct()
    {
        # code...
    }


    public function register()
    {
        $this->route();
    }

    public function route()
    {
        // 普通路由策略

        // Pathinfo策略
        preg_match_all('/^\/(.*)\?/', $_SERVER['REQUEST_URI'], $uri);
        $uri = $uri[1][0];
        if (empty($uri)) {
            /**
             * 默认模块/控制器/操作逻辑
             */
            throw new CoreHttpException(404);
        }
        $uri = explode('/', $uri);
        switch (count($uri)) {
            case 3:
                $moduleName     = $uri['0'];
                $controllerName = $uri['1'];
                $actionName     = $uri['2'];
                break;

            case 2:
                /**
                 * 默认模块
                 */

                break;
            case 1:
                /**
                 * 默认模块/控制器
                 */

                 break;

            default:
                /**
                 * 默认模块/控制器/操作逻辑
                 */
                break;
        }

        $controllerPath = 'App\\' . $moduleName . '\\Controllers\\' . $controllerName;
        $reflaction     = new ReflectionClass($controllerPath);
        if(!$reflaction->hasMethod($actionName)) {
            throw new CoreHttpException(404, 'Action:' . $actionName);
        }
        $controller = new $controllerPath();
        $controller->$actionName();
    }
}
