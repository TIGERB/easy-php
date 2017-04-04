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

use Framework\Handles\ErrorHandle;
use Framework\Handles\ExceptionHandle;
use Framework\Handles\RouterHandle;
use Framework\Handles\ConfigHandle;
use Framework\Exceptions\CoreHttpException;
use Framework\Request;
use Framework\Response;

// 引入框架文件
require(__DIR__ . '/App.php');

try {
    /**
     * 初始化应用
     */
    $app = new Framework\App(__DIR__ . '/..', function () {
        return require(__DIR__ . '/Load.php');
    });

    /**
     * 挂载handles
     */
    $app->load(function () {
        // 加载错误处理机制
        return new ErrorHandle();
    });

    // $app->load(function () {
    //     //  加载异常处理机制　由于本文件全局catch了异常　所以不存在未捕获异常
    //     //　可省略注册未捕获异常Handle
    //     return new ExceptionHandle();
    // });

    $app->load(function () {
        // 加载预定义配置机制
        return new ConfigHandle();
    });

    $app->load(function () {
        // 加载路由机制
        return new RouterHandle();
    });

    /**
     * 启动应用
     */
    $app->run(function () {
        return new Request();
    });

    /**
     * 响应结果
     * 应用生命周期结束　
     */
    $app->response(function () {
        return new Response();
    });
} catch (CoreHttpException $e) {
    // 捕获异常
    $e->reponse();
}
