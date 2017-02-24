<?php
/**
 * easy-php
 *
 * a light php framework for study
 *
 * @author: TIERGB <https://github.com/TIGERB>
 */

/**
 * application
 */
class App
{
  /**
   * [$handlesList description]
   * @var [type]
   */
  public static $handlesList = [];

  /**
   * [$handlesList description]
   * @var [type]
   */
  public static $App = '';

  /**
   * [__construct description]
   */
  public function __construct()
  {

  }

  public function load($handle)
  {
    $handle()->register();
  }

}
