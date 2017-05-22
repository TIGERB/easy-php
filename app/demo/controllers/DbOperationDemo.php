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
 * ModelOperationDemo Controller
 *
 * @desc Model opeaation example
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class DbOperationDemo
{
    /**
     * 控制器构造函数
     */
    public function __construct()
    {
        # code...
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
        $database = $instance->masterSlave;

        return [
            'db'  => $database,
            'sql' => $sql,
            'res' => $res
        ];
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
        $database = $instance->masterSlave;

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

        DB::beginTransaction();

        $user = DB::table('user');
        $test = DB::table('test');

        $userId = $user->save([
            'nickname' => 'easy-php',
        ]);

        $testId = $test->save([
            'name' => 'aa'
        ]);

        if (! $testId) {
            DB::rollBack();
        } else {
            DB::commit();
        }

        return [
            'db'  => $user->masterSlave,
            'sql' => $user->sql,
            'res' => [
                'user_id' => $userId,
                'test_id' => $testId
            ]
        ];
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
