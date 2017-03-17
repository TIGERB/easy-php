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
