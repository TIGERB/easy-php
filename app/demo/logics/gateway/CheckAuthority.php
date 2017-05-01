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
 * 检验接口服务访问权限
 */
class CheckAuthority extends Check
{
    /**
     * 校验方法
     *
     * @param Request $request 请求对象
     */
    public function doCheck(Request $request)
    {
        # do nothing...
    }
}
