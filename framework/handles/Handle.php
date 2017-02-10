<?php
/**
 * easy-php
 *
 * a light php framework for study
 *
 * @author: TIERGB <https://github.com/TIGERB>
 */

namespace framework\handles;

interface Handle
{
  /**
   * 应用启动注册
   *
   * @param  App    $app 应用
   * @return mixed
   */
  public function register($app);
}
