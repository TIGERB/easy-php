<?php
/**
 * easy-php
 *
 * a light php framework for study
 *
 * @author: TIERGB <https://github.com/TIGERB>
 */

namespace framework\handles;

use framework\handles\Handle;

/**
 * 注册加载handle
 */
class ErrorHandle implements Handle
{

  public function __construct()
  {
    # code...
  }

  /**
   * 应用启动注册
   *
   * @param  App    $app 应用
   * @return mixed
   */
  public function register($app)
  {
    var_dump('aaaaaaaaaaaaa');
  }

}
