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
use App\Demo\Controllers\Index;

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
        $index = new Index();

        $this->assertEquals(
            'Hello Easy PHP',
            $index->hello()
        );
    }
}
