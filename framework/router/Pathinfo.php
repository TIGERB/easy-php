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

namespace Framework\Router;

use Framework\Router\RouterInterface;
use Framework\Router\Router;

/**
 * pathinfo路由策略.
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class Pathinfo implements RouterInterface
{
    /**
     * 路由方法
     *
     * @param void
     */
    public function route(Router $entrance)
    {
		/* 匹配出uri */
        if (strpos($entrance->requestUri, '?')) {
            preg_match_all('/^\/(.*)\?/', $entrance->requestUri, $uri);
        } else {
            preg_match_all('/^\/(.*)/', $entrance->requestUri, $uri);
        }

        // 使用默认模块/控制器/操作逻辑
        if (!isset($uri[1][0]) || empty($uri[1][0])) {
            // CLI 模式不输出
            if ($entrance->app->runningMode === 'cli') {
                $entrance->app->notOutput = true;
            }
            return;
        }
        $uri = $uri[1][0];

        /* 自定义路由判断 */

        $uri = explode('/', $uri);
        switch (count($uri)) {
            case 3:
                $entrance->moduleName     = $uri['0'];
                $entrance->controllerName = $uri['1'];
                $entrance->actionName     = $uri['2'];
                break;

            case 2:
                /*
                * 使用默认模块
                */
                $entrance->controllerName = $uri['0'];
                $entrance->actionName     = $uri['1'];
                break;
            case 1:
                /*
                * 使用默认模块/控制器
                */
                $entrance->actionName = $uri['0'];
                break;

            default:
                /*
                * 使用默认模块/控制器/操作逻辑
                */
                break;
        }
    }
}
