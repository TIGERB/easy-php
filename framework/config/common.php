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
    /* 默认模块 */
    'module' => [
        'demo'
    ],

    /* 路由默认配置 */
    'route'  => [
        // 默认模块
        'default_module'     => 'demo',
        // 默认控制器
        'default_controller' => 'index',
        // 默认操作
        'default_action'     => 'hello',
    ],

    'nosql' => [
        'redis',
        // 'memcache',
        // 'mongodb'
    ],

    /* redis */
    'redis'  => [
        // 默认host
        'host'     => '127.0.0.1',
        // 默认端口
        'port'     => 6379,
        // 密码
        'password' => '',
    ]
];
