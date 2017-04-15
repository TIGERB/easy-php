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

namespace Tests\Demo;

use Tests\TestCase;
use Framework\App;

/**
 * 单元测试 示例
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class DemoTest extends TestCase
{
    /**
     *　演示测试
     */
    public function testDemo()
    {
        $this->assertEquals(
            'Hello Easy PHP',
            App::$app->get('demo/index/hello')
        );
    }
}
