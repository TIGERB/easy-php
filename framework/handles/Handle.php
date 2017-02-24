<?php
/**
 * easy-php
 *
 * a light php framework for study
 *
 * @author: TIERGB <https://github.com/TIGERB>
 */

namespace Framework\Handles;

Interface Handle
{
  /**
   * 应用启动注册
   *
   * @return mixed
   */
  public function register();
}
