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
     * 配置
     *
     * @var array
     */
    private $config;

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
     * 注册配置文件处理机制
     *
     * @param  App    $app 框架实例
     * @return void
     */
    public function register(App $app)
    {
        $this->app = $app;
        $app::$container->setSingle('config', $this);
        $this->loadEnv($app);
        $this->loadConfig($app);
    }

    /**
     * 加载env文件配置
     *
     * @param  App    $app 框架实例
     * @return void
     */
    public function loadEnv(App $app)
    {
        $env = parse_ini_file($app->rootPath . '/.env', true);
        if ($env === false) {
            throw CoreHttpException('load env fail', 500);
        }
        $request = $app::$container->getSingle('request');
        $request->envParams = $env;
    }

    /**
     * 加载配置文件
     *
     * @param  App    $app 框架实例
     * @return void
     */
    public function loadConfig(App $app)
    {
        /* 加载公共自定义配置 */
        // $commmon  = "{$this->app->rootPath}/config/commmon.php";
        // $database = "{$this->app->rootPath}/config/database.php";
        //
        // /* 加载模块自定义配置 */
        // $module = $app->container->getSingle('config')
        //                          ->config['module'];
        // foreach ($module as $v) {
        //     // 加载自定义路由配置文件
        //     $file = "{$app->rootPath}/{$v}/config.php";
        //     if (file_exists($file)) {
        //         require($file);
        //     }
        // }

        /* 加载默认配置 */
        $defaultConfig   = require($app->rootPath . '/framework/config/config.php');
        $defaultNosql    = require($app->rootPath . '/framework/config/nosql.php');
        $defaultDatabase = require($app->rootPath . '/framework/config/database.php');

        $this->config = array_merge($defaultConfig, $defaultNosql, $defaultDatabase);
    }
}
