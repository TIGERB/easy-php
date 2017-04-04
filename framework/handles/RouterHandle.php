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
     * 构造函数.
     */
    public function __construct()
    {
        // code...
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
     * 注册路由处理机制.
     *
     * @param App $app 框架实例
     */
    public function register(App $app)
    {
        // request uri
        $this->requestUri = $app::$container->getSingle('request')->server('REQUEST_URI');
        // App
        $this->app = $app;
        // 获取配置
        $config = $app::$container->getSingle('config');
        // 设置默认模块
        $this->moduleName = $config->config['route']['default_module'];
        // 设置默认控制器
        $this->controllerName = $config->config['route']['default_controller'];
        // 设置默认操作
        $this->actionName = $config->config['route']['default_action'];

        /* 路由策略　*/
        $this->routeStrategy = 'pathinfo';
        if (strpos($this->requestUri, 'index.php')) {
            $this->routeStrategy = 'general';
        }

        // 开启路由
        $this->route();
    }

    /**
     * 路由极致.
     */
    public function route()
    {
        // 路由策略
        $strategy = $this->routeStrategy;
        $this->$strategy();

        // 获取控制器类
        $controllerName = ucfirst($this->controllerName);
        $controllerPath = "App\\{$this->moduleName}\\Controllers\\{$controllerName}";
        // 反射解析当前控制器类　判断是否有当前操作方法
        $reflaction = new ReflectionClass($controllerPath);
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
     * 普通路由　url路径.
     */
    public function general()
    {
        $app = $this->app;
        $request = $app::$container->getSingle('request');
        $moduleName = $request->request('module');
        $controllerName = $request->request('controller');
        $actionName = $request->request('action');
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
        $uri = explode('/', $uri);
        switch (count($uri)) {
            case 3:
                $this->moduleName = $uri['0'];
                $this->controllerName = $uri['1'];
                $this->actionName = $uri['2'];
                break;

            case 2:
                /*
                * 使用默认模块
                */
                $this->controllerName = $uri['0'];
                $this->actionName = $uri['1'];
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
     * 路由配置文件　路由规则.
     */
    public function config()
    {
        // code...
    }
}
