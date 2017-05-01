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

use Framework\App;
use Framework\Request;
use App\Demo\Logics\Gateway\Check;
use Framework\Exceptions\CoreHttpException;

/**
 * 检验接口访问频率
 */
class CheckFrequent extends Check
{
    /**
     * 限定时间段
     *
     * 单位：seconds
     *
     * @var integer
     */
    private $timeScope = 60;

    /**
     * 限定次数
     *
     * @var integer
     */
    private $times = 60;

    /**
     * 校验方法
     *
     * @param Request $request 请求对象
     */
    public function doCheck(Request $request)
    {
        $key = 'Gateway-client-ip:' . $request->clientIp;
        $redis = App::$container->getSingle('redis');
        $value = $redis->get($key);
        if (! $value) {
            $redis->setex($key, $this->timeScope, 0);
        }
        if ($value >= $this->times) {
            throw new CoreHttpException(
                "too many request per {$this->timeScope} seconds",
                1
            );
        }
        $redis->incr($key);
    }
}
