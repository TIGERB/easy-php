<?php
/**
 * Easy PHP
 *
 * A lightweight PHP framework for studying
 *
 * author: TIERGB <https://github.com/TIGERB>
 */

namespace App\Demo\Controllers;

use Framework\App;

/**
 * Index Controller
 *
 * @desc default controller
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class Index
{
    /**
     * 控制器构造函数
     */
    public function __construct()
    {
        # code...
    }

    /**
     * default action
     */
    public function hello()
    {
        return 'Hello Easy PHP';
    }

    /**
     * 演示
     *
     * @param   string $username 用户名
     * @param   string $password 密码
     * @example domain/Demo/Index/get?username=test&password=123456
     * @return  json
     */
    public function get()
    {
        return App::$container->getSingle('request')
                              ->get('username', '666');
    }

    /**
     * 框架内部调用演示
     *
     * 极大的简化了内部模块依赖的问题
     *
     * 可构建微单体建构
     *
     * @example domain/Demo/Index/micro
     * @return  json
     */
    public function micro()
    {
        return App::$app->get('demo/index/hello', [
            'user' => 'TIGERB'
        ]);
    }

    /**
     * 容器内获取实例演示
     *
     * @return void
     */
    public function instance()
    {
        // 请求对象
        App::$container->getSingle('request');
        // 配置对象
        App::$container->getSingle('config');
        // redis对象
        App::$container->getSingle('redis');
        // memcahe对象
        App::$container->getSingle('memcahe');
        // mongodb对象
        App::$container->getSingle('mongodb');
    }
}
