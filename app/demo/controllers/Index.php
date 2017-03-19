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
    public function __construct()
    {

    }

    public function Hello()
    {
        return 'Hello Easy PHP';
    }

    public function get()
    {
        return App::$app->request->get('username');
    }
}
