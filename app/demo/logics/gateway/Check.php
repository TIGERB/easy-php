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

/**
 * 网关检验抽象类
 */
abstract class Check
{
    /**
     * 下一个check实体
     *
     * @var object
     */
    private $nextCheckInstance;

    /**
     * 校验方法
     *
     * @param Request $request 请求对象
     */
    abstract public function doCheck(Request $request);

    /**
     * 设置责任链上的下一个对象
     *
     * @param Check $check
     */
    public function setNext(Check $check)
    {
        $this->nextCheckInstance = $check;
        return $check;
    }

    /**
     * 启动
     *
     * @param Request $request 请求对象
     */
    public function start(Request $request)
    {
        $this->doCheck($request);
        // 调用下一个对象
        if (! empty($this->nextCheckInstance)) {
            $this->nextCheckInstance->start($request);
        }
    }
}
