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
 * 配置文件处理机制
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class ConfigHandle implements Handle
{
    /**
     * 框架实例
     *
     * @var object
     */
    private $app;

    /**
     * 构造函数
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
     * 注册路由处理机制
     *
     * @param  App    $app 框架实例
     * @return void
     */
    public function register(App $app)
    {
        $this->app = $app;
        $app::$container->setSingle('config', $this);
        $this->loadConfig($app);
    }

    /**
     * 加载配置文件
     *
     * @param  App    $app 框架实例
     * @return void
     */
    public function loadConfig(App $app)
    {
        // 加载默认配置
        $config   = require($app->rootPath . '/framework/config/common.php');
        // 加载默认数据库配置
        $database = require($app->rootPath . '/framework/config/database.php');

        $this->config = array_merge($config, $database);
    }
}
