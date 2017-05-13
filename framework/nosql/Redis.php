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
 * Redis class
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class Redis
{
    /**
     * 初始化
     *
     * Init redis
     */
    public static function init()
    {
        $config = App::$container->getSingle('config');
        $config = $config->config['redis'];
        $redis = new rootRedis();
        $redis->connect($config['host'], $config['port']);
        return $redis;
    }
}
