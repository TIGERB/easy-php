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
use App\Demo\Logics\Gateway\CheckAccessToken;
use App\Demo\Logics\Gateway\CheckFrequent;
use App\Demo\Logics\Gateway\CheckArguments;
use App\Demo\Logics\Gateway\CheckSign;
use App\Demo\Logics\Gateway\CheckAuthority;
use App\Demo\Logics\Gateway\CheckRouter;

/**
 * 网关入口实体
 *
 * 初始化网关
 *
 * 责任链模式实现的网关
 *
 * @example domain/demo/index/hello?sign=679189bf0730608267cc8dc788cf9322&app_key=315b279901cc47cc21897253b7850d57&timestamp=1493626452&nonce=896662&device_id=7cc21897250d53b7857315b279901cc4
 */
class Entrance
{
    /**
     * 构造函数
     *
     * 初始化网关
     */
    public function __construct()
    {
        // 初始化一个：必传参数校验的check
        $checkArguments   =  new CheckArguments();
        // 初始化一个：令牌校验的check
        $checkAppkey      =  new CheckAppkey();
        // 初始化一个：访问频次校验的check
        $checkFrequent    =  new CheckFrequent();
        // 初始化一个：签名校验的check
        $checkSign        =  new CheckSign();
        // 初始化一个：访问权限校验的check
        $checkAuthority   =  new CheckAuthority();
        // 初始化一个：网关路由规则
        $checkRouter      =  new CheckRouter();

        // 构成对象链
        $checkArguments->setNext($checkAppkey)
                       ->setNext($checkFrequent)
                       ->setNext($checkSign)
                       ->setNext($checkAuthority)
                       ->setNext($checkRouter);

        // 启动网关
        $checkArguments->start(
            APP::$container->get('request')
        );
    }
}
