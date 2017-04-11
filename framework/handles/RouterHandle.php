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
use Framework\Exceptions\CoreHttpException;
use ReflectionClass;
use Closure;

/**
 * 路由处理机制.
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class RouterHandle implements Handle
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
     * 默认操作.
     *
     * @var string
     */
    private $routeStrategy = '';

    /**
     * 请求uri.
     *
     * @var string
     */
    private $requestUri = '';

    /**
     * 自定义路由规则
     *
     * get请求
     *
     * 查询数据
     *
     * @var array
     */
    private $getMap = [];

    /**
     * 自定义路由规则
     *
     * post请求
     *
     * 新增数据
     *
     * @var array
     */
    private $postMap = [];

    /**
     * 自定义路由规则
     *
     * put请求
     *
     * 更新数据
     *
     * @var array
     */
    private $putMap = [];

    /**
     * 自定义路由规则
     *
     * delete请求
     *
     * 删除数据
     *
     * @var array
     */
    private $deleteMap = [];

    /**
     * 构造函数.
     */
    public function __construct()
    {
        # code...
    }

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
     * 自定义get请求路由
     *
     * @param  string $uri      请求uri
     * @param  mixed  $function 匿名函数或者控制器方法标示
     * @return void
     */
    public function get($uri = '', $function = '')
    {
        $this->getMap[$uri] = $function;
    }

    /**
     * 自定义post请求路由
     *
     * @param  string $uri      请求uri
     * @param  mixed  $function 匿名函数或者控制器方法标示
     * @return void
     */
    public function post($uri = '', $function = '')
    {
        $this->postMap[$uri] = $function;
    }

    /**
     * 自定义put请求路由
     *
     * @param  string $uri      请求uri
     * @param  mixed  $function 匿名函数或者控制器方法标示
     * @return void
     */
    public function put($uri = '', $function = '')
    {
        $this->putMap[$uri] = $function;
    }

    /**
     * 自定义delete请求路由
     *
     * @param  string $uri      请求uri
     * @param  mixed  $function 匿名函数或者控制器方法标示
     * @return void
     */
    public function delete($uri = '', $function = '')
    {
        $this->getMap[$uri] = $function;
    }

    /**
     * 注册路由处理机制.
     *
     * @param App $app 框架实例
     * @param void
     */
    public function register(App $app)
    {
        // request uri
        $this->requestUri     = $app::$container->getSingle('request')->server('REQUEST_URI');
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

        /* 路由策略　*/
        $this->routeStrategy  = 'pathinfo';
        if (strpos($this->requestUri, 'index.php') || $app->isCli === 'true') {
            $this->routeStrategy = 'general';
        }

        // 开启路由
        $this->route();
    }

    /**
     * 路由机制
     *
     * @param void
     */
    public function route()
    {
        // 路由策略
        $strategy = $this->routeStrategy;
        $this->$strategy();

        // 自定义路由判断
        if ($this->userDefined()) {
            return;
        }

        // 获取控制器类
        $controllerName = ucfirst($this->controllerName);
        $controllerPath = "App\\{$this->moduleName}\\Controllers\\{$controllerName}";

        // 判断控制器存不存在
        if (! class_exists($controllerPath)) {
            throw new CoreHttpException(404, 'Controller:'.$controllerName);
        }

        // 反射解析当前控制器类　判断是否有当前操作方法
        $reflaction     = new ReflectionClass($controllerPath);
        if (!$reflaction->hasMethod($this->actionName)) {
            throw new CoreHttpException(404, 'Action:'.$actionName);
        }
        // 实例化当前控制器
        $controller = new $controllerPath();
        // 调用操作
        $actionName = $this->actionName;
        // 获取返回值
        $this->app->responseData = $controller->$actionName();
    }

    /**
     * 普通路由　url路径
     *
     * @param void
     */
    public function general()
    {
        $app            = $this->app;
        $request        = $app::$container->getSingle('request');
        $moduleName     = $request->request('module');
        $controllerName = $request->request('controller');
        $actionName     = $request->request('action');
        if (!empty($moduleName)) {
            $this->moduleName = $moduleName;
        }
        if (!empty($controllerName)) {
            $this->controllerName = $controllerName;
        }
        if (!empty($actionName)) {
            $this->actionName = $actionName;
        }
    }

    /**
     * pathinfo url路径.
     */
    public function pathinfo()
    {
        /* 匹配出uri */
        if (strpos($this->requestUri, '?')) {
            preg_match_all('/^\/(.*)\?/', $this->requestUri, $uri);
        } else {
            preg_match_all('/^\/(.*)/', $this->requestUri, $uri);
        }

        if (!isset($uri[1][0]) || empty($uri[1][0])) {
            /*
            * 使用默认模块/控制器/操作逻辑
            */
            return;
        }
        $uri = $uri[1][0];

        /* 自定义路由判断 */

        $uri = explode('/', $uri);
        switch (count($uri)) {
            case 3:
                $this->moduleName     = $uri['0'];
                $this->controllerName = $uri['1'];
                $this->actionName     = $uri['2'];
                break;

            case 2:
                /*
                * 使用默认模块
                */
                $this->controllerName = $uri['0'];
                $this->actionName     = $uri['1'];
                break;
            case 1:
                /*
                * 使用默认模块/控制器
                */
                $this->actionName = $uri['0'];
                break;

            default:
                /*
                * 使用默认模块/控制器/操作逻辑
                */
                break;
        }
    }

    /**
     * 自定义路由
     *
     * @return void
     */
    private function userDefined()
    {
        $module = $this->config->config['module'];
        foreach ($module as $v) {
            // 加载自定义路由配置文件
            $routeFile = "{$this->app->rootPath}/config/{$v}/route.php";
            if (file_exists($routeFile)) {
                require($routeFile);
            }
        }

        // 路由匹配
        $uri = "{$this->moduleName}/{$this->controllerName}/{$this->actionName}";
        if (! array_key_exists($uri, $this->getMap)) {
            return false;
        }
        $this->app->responseData = $this->getMap[$uri]();
        return true;
    }
}
