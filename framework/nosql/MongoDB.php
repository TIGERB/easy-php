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
use MongoDB\Client;

/**
 * MongoDB操作类
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class MongoDB
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $config = App::$container->getSingle('config');
        $config = $config->config['mongoDB'];
        $client = new Client(
            "{$config['host']}:{$config['port']}",
            [
                'database' => $config['database'],
                'username' => $config['username'],
                'password' => $config['password']
            ]
        );
        $database = $client->selectDatabase($config['database']);
        App::$container->setSingle('mongoDB', $database);
    }
}
