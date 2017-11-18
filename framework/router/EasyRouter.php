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
use Framework\Exceptions\CoreHttpException;
// use ReflectionClass;
use Closure;

/**
 * 路由入口.
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class EasyRouter
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
     * 请求对象
     *
     * @var
     */
    private $request;

    /**
     * 默认模块.
     *
     * @var string
     */
    private $moduleName = '';

     /**
      * 默认控制器.
      *
      * @var string
      */
    private $controllerName = '';

    /**
     * 默认操作.
     *
     * @var string
     */
    private $actionName = '';

    /**
     * 类文件路径.
     *
     * @var string
     */
    private $classPath = '';

    /**
     * 类文件路径.
     *
     * @var string
     */
    private $executeType = '';

    /**
     * 请求uri.
     *
     * @var string
     */
    private $requestUri = '';

    /**
     * 路由策略.
     *
     * @var string
     */
    private $routeStrategy = '';
    
    /**
     * 路由策略映射
     *
     * @var array
     */
    private $routeStrategyMap = [
        'general'      => 'Framework\Router\General',
        'pathinfo'     => 'Framework\Router\Pathinfo',
        'user-defined' => 'Framework\Router\Userdefined',
        'micromonemer' => 'Framework\Router\Micromonomer',
        'job'          => 'Framework\Router\Job'
    ];

    /**
     * 魔法函数__get.
     *
     * @param string $name 属性名称
     *
     * @return mixed
     */
    public function __get($name = '')
    {
        return $this->$name;
    }

    /**
     * 魔法函数__set.
     *
     * @param string $name  属性名称
     * @param mixed  $value 属性值
     *
     * @return mixed
     */
    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }

    /**
     * 注册路由处理机制.
     *
     * @param App $app 框架实例
     * @param void
     */
    public function init(App $app)
    {
        // 注入当前对象到容器中
        $app::$container->setSingle('router', $this);
        // request uri
        $this->request        = $app::$container->getSingle('request');
        $this->requestUri     = $this->request->server('REQUEST_URI');
        // App
        $this->app            = $app;
        // 获取配置
        $this->config         = $app::$container->getSingle('config');
        // 设置默认模块
        $this->moduleName     = $this->config->config['route']['default_module'];
        // 设置默认控制器
        $this->controllerName = $this->config->config['route']['default_controller'];
        // 设置默认操作
        $this->actionName     = $this->config->config['route']['default_action'];

        // 路由决策
        $this->strategyJudge();

        // 路由策略
        (new $this->routeStrategyMap[$this->routeStrategy])->route($this);

        // 判断是app还是job
        $this->isAppOrJob($this);

        // 自定义路由判断
        if ((new $this->routeStrategyMap['user-defined'])->route($this)) {
            return;
        }

        // 启动路由
        $this->start();
    }

    /**
     * 判断是app还是job
     *
     * @return void
     */
    public function isAppOrJob()
    {
        // 任务类
        if ($this->routeStrategy === 'job') {
            $className         = $this->request->request('job');
            $actionName        = $this->request->request('action');
            $folderName        = ucfirst($this->config->config['jobs_folder_name']);
            $this->classPath   = "{$folderName}\\{$this->moduleName}\\{$className}";
            $this->executeType = 'job';
            return;
        }

        // 获取控制器类
        $controllerName    = ucfirst($this->controllerName);
        $folderName        = ucfirst($this->config->config['application_folder_name']);
        $this->classPath   = "{$folderName}\\{$this->moduleName}\\Controllers\\{$controllerName}";
        $this->executeType = 'controller';
    }

    /**
     * 路由策略决策
     *
     * @param void
     */
    public function strategyJudge()
    {
        // 路由策略
        if (! empty($this->routeSrategy)) {
            return;
        }

        // 任务路由
        if ($this->app->isCli === 'yes' && $this->request->get('router_mode') === 'job') {
            $this->routeStrategy = 'job';
            return;
        }

        // 普通路由
        if (strpos($this->requestUri, 'index.php') || $this->app->isCli === 'yes') {
            $this->routeStrategy = 'general';
            return;
        } else {
            $this->routeStrategy = 'pathinfo';
            return;
        }
    }

    /**
     * 路由机制
     *
     * @param void
     */
    public function start()
    {
        // 判断模块存不存在
        if (! in_array(strtolower($this->moduleName), $this->config->config['module'])) {
            throw new CoreHttpException(404, 'Module:'.$this->moduleName);
        }

        // 判断控制器存不存在
        if (! class_exists($this->classPath)) {
            throw new CoreHttpException(404, "{$this->executeType}:{$this->classPath}");
        }

        // 反射解析当前控制器类　
        // 判断是否有当前操作方法
        // 不使用反射
        // $reflaction     = new ReflectionClass($controllerPath);
        // if (!$reflaction->hasMethod($this->actionName)) {
        //     throw new CoreHttpException(404, 'Action:'.$this->actionName);
        // }

        // 实例化当前控制器
        $controller = new $this->classPath();
        if (! method_exists($controller, $this->actionName)) {
            throw new CoreHttpException(404, 'Action:'.$this->actionName);
        }

        // 调用操作
        $actionName = $this->actionName;
        // 获取返回值
        $this->app->responseData = $controller->$actionName();
    }
}
