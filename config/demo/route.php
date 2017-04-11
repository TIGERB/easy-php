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

/**
 * 自定义路由
 *
 * 支持restful风格
 */

$this->get('v1/user/info', function () {
    return 'Hello Get Router';
});

$this->post('v1/user/info', function () {
    return 'Hello Post Router';
});

$this->put('v1/user/info', function () {
    return 'Hello Put Router';
});

$this->delete('v1/user/info', function () {
    return 'Hello Delete Router';
});
