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

namespace Framework\Orm\Db;

use Framework\App;
use Framework\Exceptions\CoreHttpException;
use PDO;

/**
 * mysql实体类
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class Mysql
{
    public function __construct()
    {
        $config   = APP::$container->getSingle('config');
        $config   = $config->config;
        $dbConfig = $config['database'];
        $connect  = "{$dbConfig['dbtype']}:dbname={$dbConfig['dbname']};host={$dbConfig['host']};";
        $pdo      = new PDO(
            $connect,
            $dbConfig['username'],
            $dbConfig['password']
        );
    }
}
