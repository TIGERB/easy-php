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

namespace Framework\Orm;

use Framework\Exceptions\CoreHttpException;

/**
 * Sql解释器
 */
trait Interpreter
{
    private $tableName = '';
    private $where     = '';
    public  $params    = '';
    private $orderBy   = '';
    private $limit     = '';
    private $offset    = '';
    private $sql       = '';

    /**
    *  插入一条数据
    *
    * @param  array $data 数据
    * @return mixed
    */
    public function insert($data=[])
    {
        if (empty($data)) {
            throw new CoreHttpException("argument data is null", 400);
        }
        $count = count($data);
        //拼接字段
        $field = array_keys($data);
        $fieldString = '';
        foreach ($field as $k => $v) {
            if ($k === (int)($count - 1)) {
                $fieldString .= "`{$v}`";
                continue;
            }
            $fieldString .= "`{$v}`".',';
        }
        unset($k);
        unset($v);

        //拼接值
        $value = array_values($data);
        $valueString = '';
        foreach ($value as $k => $v) {
            if ($k === (int)($count - 1)) {
                $valueString .= "'{$v}'";
                continue;
            }
            $valueString .= "'{$v}'".',';
        }
        unset($k);
        unset($v);

        $sql = "INSERT INTO `{$this->_tableName}` ({$fieldString}) VALUES ({$valueString})";
    }

    /**
    *  删除数据
    *
    * @param  array $data 数据
    * @return mixed
    */
    public function delete($data=[])
    {
        if (empty($data)) {
            throw new CoreHttpException("argument data is null", 400);
        }
        // 拼接where语句
        $count = (int)count($data);
        $where = '';
        $dataCopy = $data;
        $pop = array_pop($dataCopy);
        if ($count === 1) {
            $field = array_keys($data)[0];
            $value = array_values($data)[0];
            $where = "`{$field}` = '{$value}'";
        }else{
            foreach ($data as $k => $v) {
                if ($v === $pop) {
                    $where .= "`{$k}` = '{$v}'";
                    continue;
                }
                $where .= "`{$k}` = '{$v}' AND ";
            }
        }

        $sql = "DELETE FROM `{$this->_tableName}` WHERE {$where}";

    }

    /**
    *  更新一条数据
    *
    * @param  array $data 数据
    * @return mixed
    */
    public function update($data=[])
    {
        if (empty($data)) {
            throw new CoreHttpException("argument data is null", 400);
        }
        if (empty($data['id'])) {
            throw new CoreHttpException("argument data['id'] is null", 400);
        }
        $set = '';
        $dataCopy = $data;
        $pop = array_pop($dataCopy);
        foreach ($data as $k => $v) {
            if ($v === $pop) {
                $set .= "`{$k}` = '$v'";
                continue;
            }
            $set .= "`{$k}` = '$v',";
        }

        $sql = "UPDATE `{$this->_tableName}` SET {$set}";
    }

    /**
     *  查找一条数据
     *
     * @return mixed
     */
    public function select($data=[])
    {
        $this->sql = "SELECT * FROM `{$this->tableName}`";
    }

    /**
     * where 条件
     * 
     * @param  array $data 数据
     * @return void
     */
    public function where($data = array())
    {
        if (empty($data)) {
            return;
        }

        $count = count($data);

        /* 单条件 */
        if ($count === 1) {
            $field = array_keys($data)[0];
            $value = array_values($data)[0];
            if (! is_array($value)){
                $this->where  = " WHERE `{$field}` = :{$field}";
                $this->params = $data;
                return $this;
            }
            $this->where = " WHERE `{$field}` {$value[0]} :{$field}";
            $this->params[$field] = $value[1];
            return $this;
        }

        /* 多条件 */
        $tmp  = $data;
        $last = array_pop($tmp);
        foreach ($data as $k => $v) {
            if ($v === $last) {
                if (! is_array($v)){
                    $this->where .= "`{$k}` = :{$k}";
                    $this->params[$k] = $v;
                    continue;
                }
                $this->where .= "`{$k}` {$v[0]} :{$k}";
                $this->params[$k] = $v[1];
                continue;
            }
            if (! is_array($v)){
                $this->where  .= " WHERE `{$k}` = :{$k} AND ";
                $this->params[$k] = $v;
                continue;
            }
            $this->where .= " WHERE `{$k}` {$v[0]} :{$k} AND ";
            $this->params[$k] = $v[1];
            continue;
        }
        return $this;
    }

    public function orderBy($data = '')
    {
        if (! is_string($data)) {
            throw new CoreHttpException(400);
        }
        $this->orderBy = " order by {$data}";
        return $this;
    }

    public function limit($start = 0, $len = 0)
    {
        if (! is_numeric($start) || (! is_numeric($len))) {
            throw new CoreHttpException(400);
        }
        if ($len === 0) {
            $this->limit = " limit {$start}";
            return $this;
        }
        $this->limit = " limit {$start},{$len}";
        return $this;
    }
    
}
