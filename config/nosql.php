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

use Framework\Helper;

return [
    // 需要提供支持的nosql种类
    // 参数示例：redis,memcached,mongoDB
    'nosql'      => Helper::env('nosql')['support'],

    // redis
    'redis'      => [
        // 默认host
        'host'     => Helper::env('redis')['host'],
        // 默认端口
        'port'     => Helper::env('redis')['port'],
        // 密码
        'password' => Helper::env('redis')['password'],
    ],

    // memcached
    'memcached'  => [
        // 默认host
        'host'     => Helper::env('memcached')['host'],
        // 默认端口
        'port'     => Helper::env('memcached')['port'],
        // 密码
        'password' => Helper::env('memcached')['password'],
    ],

    // mongoDB
    'mongoDB'    => [
        // 默认host
        'host'     => Helper::env('mongoDB')['host'],
        // 默认端口
        'port'     => Helper::env('mongoDB')['port'],
        // 数据库名称
        'database' => Helper::env('mongoDB')['database'],
        // 用户名
        'username' => Helper::env('mongoDB')['username'],
        // 密码
        'password' => Helper::env('mongoDB')['password'],
    ]
];
