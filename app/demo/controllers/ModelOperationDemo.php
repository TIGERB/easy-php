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
use App\Demo\Models\TestTable;
use Exception;

/**
 * ModelOperationDemo Controller
 *
 * @desc Model opeaation example
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class ModelOperationDemo
{
    /**
     * 控制器构造函数
     */
    public function __construct()
    {
        # code...
    }

    /**
     * model example
     *
     * @return mixed
     */
    public function modelExample()
    {
        try {
            DB::beginTransaction();
            $testTableModel = new TestTable();

            // find one data
            $testTableModel->modelFindOneDemo();
            // find all data
            $testTableModel->modelFindAllDemo();
            // save data
            $testTableModel->modelSaveDemo();
            // delete data
            $testTableModel->modelDeleteDemo();
            // update data
            $testTableModel->modelUpdateDemo([
                   'nickname' => 'easy-php'
                ]);
            // count data
            $testTableModel->modelCountDemo();

            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollBack();
            return 'fail';
        }
    }
}
