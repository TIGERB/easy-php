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

namespace Framework;

use Framework\Container;
use Closure;

/**
 * Application
 *
 * 框架应用类
 *
 * 整个框架自身就是一个应用
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class App
{
    /**
     * 框架加载流程一系列处理类集合
     *
     * @var array
     */
    private $handlesList = [];

    /**
     * 请求对象
     *
     * @var object
     */
    private $request;

    /**
     * 框架实例根目录
     *
     * @var string
     */
    private $rootPath;

    /**
     * 响应对象
     *
     * @var object
     */
    private $responseData;

    /**
     * cli模式
     *
     * @var string
     */
    private $isCli　= 'false';

    /**
     * 框架实例
     *
     * @var object
     */
    public static $app;

    /**
     * 服务容器
     *
     * @var object
     */
    public static $container;

    /**
     * 构造函数
     *
     * @param  string $rootPath 框架实例根目录
     * @param  string $loader   注入自加载实例
     */
    public function __construct($rootPath, Closure $loader)
    {
        // cli模式
        $this->isCli    = getenv('IS_CLI');
        // 根目录
        $this->rootPath = $rootPath;

        // 注册自加载
        $loader();
        Load::register($this);

        self::$app = $this;
        self::$container = new Container();
    }

    /**
     * 魔法函数__get
     *
     * @param  string $name  属性名称
     * @return mixed
     */
    public function __get($name = '')
    {
        return $this->$name;
    }

    /**
     * 魔法函数__set
     *
     * @param  string $name   属性名称
     * @param  mixed  $value  属性值
     * @return mixed
     */
    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }

    /**
     * 注册框架运行过程中一系列处理类
     *
     * @param  object $handle handle类
     * @return void
     */
    public function load(Closure $handle)
    {
        $this->handlesList[] = $handle;
    }

    /**
     * 运行应用
     *
     * @param  Request $request 请求对象
     * @return void
     */
    public function run(Closure $request)
    {
        self::$container->setSingle('request', $request);
        foreach ($this->handlesList as $handle) {
            $instance = $handle();
            self::$container->setSingle(get_class($instance), $instance);
            $instance->register($this);
        }
    }

    /**
     * 生命周期结束
     *
     * 响应请求
     * @param  Closure $closure 响应类
     * @return json
     */
    public function response(Closure $closure)
    {
        // $closure()->reponse($this->responseData);
        $closure()->restSuccess($this->responseData);
    }
}
