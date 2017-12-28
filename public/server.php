<?php
/*************************************************
 *                  Easy PHP                     *
 *                                               *
 * A Faster Lightweight Full-Stack PHP Framework *
 *                                               *
 *                  TIERGB                       *
 *        <https://github.com/TIGERB>            *
 *                                               *
 *************************************************/

use Framework\Handles\ErrorHandle;
use Framework\Handles\ExceptionHandle;
use Framework\Handles\RouterHandle;
use Framework\Handles\ConfigHandle;
use Framework\Handles\LogHandle;
use Framework\Handles\NosqlHandle;
use Framework\Handles\UserDefinedHandle;
use Framework\Exceptions\CoreHttpException;
use Framework\Request;
use Framework\Response;

/**
 * 引入框架文件
 *
 * Require framework
 */
$easy = require('../framework/swoole.php');

/**
 * 启动swoole http服务
 *
 * Start the http server
 */
$http = new swoole_http_server('127.0.0.1', 8888);
// set the app running mode
$easy->runningMode = 'swoole';

/**
 * 监听请求
 *  
 * monitor
 */
$http->on('request', function ($request, $response) use ($easy) {	
    try {
        $easy::$container->set('request-swoole', $request);
        $easy::$container->set('response-swoole', $response);
        // init router
        $easy::$container->get('router')->init($easy);
        // response
        $easy->responseSwoole(function () use ($response) {
            return $response;
        });
    } catch (CoreHttpException $e) {
        // exception
        $e->reponseSwoole();
    }
});

/**
 * 启动
 * 
 * start
 */
$http->start();
