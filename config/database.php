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

return [
    /* 默认配置 */
    'database' => [
        'dbtype'   => env('database')['dbtype'],
        'dbprefix' => env('database')['dbprefix'],
        'dbname'   => env('database')['dbname'],
        'dbhost'   => env('database')['dbhost'],
        'username' => env('database')['username'],
        'password' => env('database')['password']
    ]
];
