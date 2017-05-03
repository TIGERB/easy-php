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
use Memcached as rootMemcached;

/**
 * memcached操作类
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class Memcached
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $config = App::$container->getSingle('config');
        $config = $config->config['memcached'];
        $redis  = new rootMemcached();
        $redis->addServer($config['host'], $config['port']);
        App::$container->setSingle('memcached', $redis);
    }
}
