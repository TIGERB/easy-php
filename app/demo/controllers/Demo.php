<?php
/**
 * Easy PHP
 *
 * A lightweight PHP framework for studying
 *
 * author: TIERGB <https://github.com/TIGERB>
 */

namespace App\Demo\Controllers;

use Framework\App;
use Framework\Orm\Db\Mysql;

/**
 * Index Controller
 *
 * @desc default controller
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class Demo
{
    /**
     * 控制器构造函数
     */
    public function __construct()
    {
        # code...
    }

    /**
     * api
     */
    public function get()
    {
        $data = [
            'img'     => 'https://raw.githubusercontent.com/TIGERB/easy-php/develop/logo.png',
            'content' => 'A lightweight PHP framework for studying, Why do we need to build a PHP framework by ourself? Maybe the most of people will say "There have so many PHP frameworks be provided, but we still made a wheel?". My point is "Made a wheel is not our purpose, we will get some konwledge when making a wheel which is our really purpose".'
        ];
        $data = array_fill(0, 20, $data);
        return $data;
    }
}
