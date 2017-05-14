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

/**
 * nosql相关配置
 */

return [
    // 需要提供支持的nosql种类
    // 参数示例：redis,memcached,mongoDB
    'nosql'      => env('nosql')['support'],

    // redis
    'redis'      => [
        // 默认host
        'host'     => env('redis')['host'],
        // 默认端口
        'port'     => env('redis')['port'],
        // 密码
        'password' => env('redis')['password'],
    ],

    // memcached
    'memcached'  => [
        // 默认host
        'host'     => env('memcached')['host'],
        // 默认端口
        'port'     => env('memcached')['port'],
        // 密码
        'password' => env('memcached')['password'],
    ],

    // mongoDB
    'mongoDB'    => [
        // 默认host
        'host'     => env('mongoDB')['host'],
        // 默认端口
        'port'     => env('mongoDB')['port'],
        // 数据库名称
        'database' => env('mongoDB')['database'],
        // 用户名
        'username' => env('mongoDB')['username'],
        // 密码
        'password' => env('mongoDB')['password'],
    ]
];
