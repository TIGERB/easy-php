<?php
/***********************************
 *             Easy PHP            *
 *                                 *
 * A light php framework for study *
 *                                 *
 *              TIERGB             *
 *   <https://github.com/TIGERB>   *
 *                                 *
 ***********************************/

use Framework\Handles\ErrorHandle;
use Framework\Handles\ExceptionHandle;
use Framework\Handles\RouterHandle;
use Framework\Exceptions\CoreHttpException;

/**
 * 定义全局常量
 */
define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/..');

require(ROOT_PATH . '/framework/Load.php');
require(ROOT_PATH . '/framework/App.php');

try {
    // 注册自加载
    Load::register();

    // 初始化应用
    $app = new App();

    // 加载错误处理机制
    $app->load(function(){
      return new ErrorHandle();
    });

    // 加载异常处理机制
    $app->load(function(){
      return new ExceptionHandle();
    });

    // 加载路由机制
    $app->load(function(){
      return new RouterHandle();
    });
} catch (CoreHttpException $e) {
    CoreHttpException::reponse($e);
}
