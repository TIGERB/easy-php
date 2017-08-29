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

namespace Framework\Router;

use Framework\Router\EasyRouter;

/**
 * 路由策略接口.
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
Interface RouterInterface
{
    /**
     * 路由方法
     *
     * @param void
     */
    public function route(EasyRouter $entrance);
}
