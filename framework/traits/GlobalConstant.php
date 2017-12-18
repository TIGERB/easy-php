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

namespace Framework\Traits;

/**
 * global constant manager
*/
trait GlobalConstant
{
    /**
     * register constant
     */
    public function registerGlobalConst()
    {
        define('NOW_TIME', time());
        define('NOW_MICROTIME', microtime(true));
    }
}
 
