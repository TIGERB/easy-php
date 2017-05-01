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

namespace App\Demo\Logics\Gateway;

use Framework\Request;
use App\Demo\Logics\Gateway\Check;
use Framework\Exceptions\CoreHttpException;

/**
 * 网关路由
 */
class CheckRouter extends Check
{
    /**
     * 网关路由规则
     *
     * @param Request $request 请求对象
     */
    public function doCheck(Request $request)
    {
        # do nothing ...
    }
}
