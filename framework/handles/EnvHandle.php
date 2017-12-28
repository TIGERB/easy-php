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
 * 加载环境参数处理机制
 *
 * env handle
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class EnvHandle implements Handle
{

    /**
     * 请求参数
     *
     * @var array
     */
    private $envParams = [];

    /**
     * 构造函数
     *
     * construct
     */
    public function __construct()
    {
        # code...
    }


    /**
     * 注册env处理机制
     *
     * register env handle
     *
     * @param  App    $app 框架实例 This framework instance
     * @return void
     */
    public function register(App $app)
    {
        // 加载环境参数
        $this->loadEnv($app);

        App::$container->setSingle('envt', $this);
    }

    /**
     * 获取env参数
     * 
     * get env params
     *
     * @param  string $value 参数名
     * @return mixed
     */
    public function env($value = '')
    {
        if (isset($this->envParams[$value])) {
            return $this->envParams[$value];
        }
        return '';
    }

    /**
     * 加载环境参数
     * 
     * load the env params
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
        $this->envParams = array_merge($_ENV, $env);
    }
}
