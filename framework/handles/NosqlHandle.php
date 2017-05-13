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
 * nosql处理机制
 *
 * nosql handle
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class NosqlHandle implements Handle
{
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
     * 注册nosql处理机制
     *
     * register nosql handle
     *
     * @param  App    $app 框架实例 This framework instance
     * @return void
     */
    public function register(App $app)
    {
        $config = $app::$container->getSingle('config');
        if (empty($config->config['nosql'])) {
            return;
        }
        $config = explode(',', $config->config['nosql']);
        foreach ($config as $v) {
            $className = 'Framework\Nosql\\' . ucfirst($v);
            App::$container->setSingle($v, function () use ($className) {
                // 懒加载　lazy load
                return $className::init();
            });
        }
    }
}
