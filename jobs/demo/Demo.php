<?php
/**
 * Easy PHP
 *
 * A Faster Lightweight Full-Stack PHP Framework
 *
 * author: TIERGB <https://github.com/TIGERB>
 */

namespace Jobs\Demo;

/**
 * Demo Jobs
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class Demo
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        # code...
    }

    /**
     * job
     *
     * @example php cli --jobs=demo.demo.test
     */
    public function test()
    {
        echo 'Hello Easy PHP Jobs';
    }
}
