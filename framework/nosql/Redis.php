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

namespace Framework\Nosql;

use Framework\App;
use Redis as rootRedis;

/**
 * redis操作类
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class Redis
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $config = App::$container->getSingle('config');
        $config = $config->config['redis'];
        $redis = new rootRedis();
        $redis->connect($config['host'], $config['port']);
        App::$container->setSingle('redis', $redis);
    }
}
