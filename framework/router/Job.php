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

use Framework\App;
use Framework\Router\RouterInterface;
use Framework\Router\Router;
use Framework\Exceptions\CoreHttpException;
use ReflectionClass;
use Closure;

/**
 * 任务路由处理机制.
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class Job implements RouterInterface
{
    /**
     * 框架实例.
     *
     * @var App
     */
    private $app;

    /**
     * 配置实例
     *
     * @var
     */
    private $config;

    /**
     * 路由方法.
     *
     * @param App $app 框架实例
     * @param void
     */
    public function route(Router $entrance)
    {
        $entrance->app->notOutput = true;
        
        $app            = $entrance->app;
        $request        = $app::$container->get('request');
        $moduleName     = $request->request('module');
        $jobName        = $request->request('job');
        $actionName     = $request->request('action');

        $entrance->moduleName = $moduleName;
        $entrance->jobName    = $jobName;
        $entrance->actionName = $actionName;

        // 获job类
        $jobName = ucfirst($jobName);
        $appName = ucfirst($entrance->config->config['jobs_folder_name']);
        $this->classPath = "{$appName}\\{$moduleName}\\{$jobName}";
    }
}
