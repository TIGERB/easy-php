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

/**
 * Index Controller
 *
 * @desc default controller
 * @author TIERGB <https://github.com/TIGERB>
 */
class Index
{
    /**
     * 控制器构造函数
     */
    public function __construct()
    {
        # code...
    }

    /**
     * default action
     */
    public function hello()
    {
        return 'Hello Easy PHP';
    }

    /**
     * demo
     *
     * @return json
     */
    public function get()
    {
        return App::$app->container
                        ->getSingle('request')
                        ->get('username');
    }
}
