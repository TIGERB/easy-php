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

use Framework\Helper;

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

    /* 响应结果是否使用框架定义的rest风格 */
    'rest_response' => true,

    /* 默认时区 */
    'default_timezone' => 'Asia/Shanghai',

];
