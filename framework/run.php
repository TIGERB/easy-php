<?php
/**
 * easy-php
 *
 * a light php framework for study
 *
 * @author: TIERGB <https://github.com/TIGERB>
 */

use Framework\Handles\ErrorHandle;
use Framework\Handles\ExceptionHandle;
use Framework\Handles\RouterHandle;

/**
 * 定义全局常量
 */
define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/..');

require(ROOT_PATH . '/framework/Load.php');
require(ROOT_PATH . '/framework/App.php');

try {
    Load::register();
    $app = new App();
    $app->load(function(){
      return new ErrorHandle();
    });
    $app->load(function(){
      return new ExceptionHandle();
    });
    $app->load(function(){
      return new RouterHandle();
    });
} catch (\Exception $e) {
    header('Content-Type:Application/json; Charset=utf-8');
    die(json_encode([
        'coreError' => [
            'code'    => $e->getCode(),
            'Message' => $e->getMessage(),
        ]
    ]));
}
