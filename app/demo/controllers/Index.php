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
use Framework\Orm\DB;

/**
 * Index Controller
 *
 * @desc default controller
 *
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
     * 演示
     *
     * @param   string $username 用户名
     * @param   string $password 密码
     * @example domain/Demo/Index/get?username=test&password=123456
     * @return  json
     */
    public function test()
    {
        $request = App::$container->getSingle('request');
        return [
            'username' =>  $request->get('username', 'default value')
        ];
    }

    /**
     * 框架内部调用演示
     *
     * 极大的简化了内部模块依赖的问题
     *
     * 可构建微单体建构
     *
     * @example domain/Demo/Index/micro
     * @return  json
     */
    public function micro()
    {
        return App::$app->get('demo/index/hello', [
            'user' => 'TIGERB'
        ]);
    }

    /**
     * 容器内获取实例演示
     *
     * @return void
     */
    public function nosqlDemo()
    {
        // 请求对象
        App::$container->getSingle('request');
        // 配置对象
        App::$container->getSingle('config');
        // redis对象
        App::$container->getSingle('redis');
        // memcahe对象
        App::$container->getSingle('memcahed');
        // mongodb对象
        App::$container->getSingle('mongodb');
    }

    /**
     * sql 操作示例
     *
     * find
     *
     * @return void
     */
    public function dbFindDemo()
    {
        $where = [
            'id'   => ['>=', 2],
        ];
        $instance = DB::table('user');
        $res      = $instance->where($where)
                             ->orderBy('id asc')
                             ->findOne();
        $sql      = $instance->sql;

        // return $sql;
        return $res;
    }

    /**
     * sql 操作示例
     *
     * findAll
     *
     * @return void
     */
    public function dbFindAllDemo()
    {
        $where = [
            'id'   => ['>=', 2],
        ];
        $instance = DB::table('user');
        $res      = $instance->where($where)
                             ->orderBy('id asc')
                             ->limit(5)
                             ->findAll(['id','create_at']);
        $sql      = $instance->sql;

        // return $sql;
        return $res;
    }

    /**
     * sql 操作示例
     *
     * Insert
     *
     * @return void
     */
    public function dbSaveDemo()
    {
        $data = [
            'nickname' => 'easy-php',
        ];
        $instance = DB::table('user');
        $res      = $instance->save($data);
        $sql      = $instance->sql;

        // return $sql;
        return $res;
    }

    /**
     * sql 操作示例
     *
     * Delete
     *
     * @return void
     */
    public function dbDeleteDemo()
    {
        $where = [
            'id'   => ['>=', 2],
        ];
        $instance = DB::table('user');
        $res      = $instance->where($where)
                             ->delete();
        $sql      = $instance->sql;

        // return $sql;
        return $res;
    }

    /**
     * sql 操作示例
     *
     * Update
     *
     * @return void
     */
    public function dbUpdateDemo()
    {
        $where = [
            'id'   => ['>=', 2],
        ];
        $instance = DB::table('user');
        $res      = $instance->where($where)
                             ->update([
                                 'nickname' => 'easy'
                             ]);
        $sql      = $instance->sql;

        // return $sql;
        return $res;
    }

    /**
     * sql 操作示例
     *
     * Count
     *
     * @return void
     */
    public function dbCountDemo()
    {
        $where = [
            'id'   => ['>=', 2],
        ];
        $instance = DB::table('user');
        $res      = $instance->where($where)
                             ->count('id as CountId');
        $sql      = $instance->sql;

        // return $sql;
        return $res;
    }

    /**
     * sql 操作示例
     *
     * Sum
     *
     * @return void
     */
    public function dbSumDemo()
    {
        $where = [
            'id'   => ['>=', 1],
        ];
        $instance = DB::table('user');
        $res      = $instance->where($where)
                             ->sum('id as SumId');
        $sql      = $instance->sql;

        return $sql;
        return $res;
    }

    /**
     * sql 操作示例
     *
     * query
     *
     * @return void
     */
    public function dbQueryDemo()
    {
        $instance = DB::table('user');
        $res      = $instance->query('SELECT `id` as `SumId` FROM `user` WHERE `id` >= 1');
        $sql      = $instance->sql;

        // return $sql;
        return $res;
    }
}
