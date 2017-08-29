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
use Framework\Router\EasyRouter;

/**
 * 普通路由策略.
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class General implements RouterInterface
{
    /**
     * 路由方法
     *
     * @param void
     */
    public function route(EasyRouter $entrance)
    {
		$app = $entrance->app;
        $request = $app::$container->getSingle('request');
        $moduleName = $request->request('module');
        $controllerName = $request->request('controller');
        $actionName = $request->request('action');
        if (! empty($moduleName)) {
            $entrance->moduleName = $moduleName;
        }
        if (! empty($controllerName)) {
            $entrance->controllerName = $controllerName;
        }
        if (! empty($actionName)) {
            $entrance->actionName = $actionName;
        }

        // CLI 模式不输出
        if (empty($actionName) && $entrance->app->isCli === 'yes') {
            $entrance->app->notOutput = true;
        }
    }
}
