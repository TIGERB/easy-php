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
 *
 * Sql Interpreter
 */
trait Interpreter
{
    /**
     * 表名称
     *
     * table name
     *
     * @var string
     */
    private $tableName = '';

    /**
     * 查询条件
     *
     * query where condition
     *
     * @var string
     */
    private $where     = '';

    /**
     * 查询参数
     *
     * query params
     *
     * @var string
     */
    public  $params    = '';

    /**
     * 排序条件
     *
     * sort condition
     *
     * @var string
     */
    private $orderBy   = '';

    /**
     * 查询限制
     *
     * query quantity limit
     *
     * @var string
     */
    private $limit     = '';

    /**
     * 查询偏移量
     *
     * query offset
     *
     * @var string
     */
    private $offset    = '';

    /**
     * 表名称
     *
     * table name
     *
     * @var string
     */
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

        $fieldString = '';
        $valueString = '';
        $i = 0;
        foreach ($data as $k => $v) {
            if ($i === 0) {
                $fieldString .= "`{$k}`";
                $valueString .= ":{$k}";
                $this->params[$k] = $v;
                ++$i;
                continue;
            }
            $fieldString .= "`{$k}`".',';
            $valueString .= ":{$k}";
            $this->params[$k] = $v;
            ++$i;
        }
        unset($k);
        unset($v);

        $this->sql = "INSERT INTO `{$this->tableName}` ({$fieldString}) VALUES ({$valueString})";
    }

    /**
    *  删除数据
    *
    * @return void
    */
    public function del($data=[])
    {
        $this->sql = "DELETE FROM `{$this->tableName}`";
    }

    /**
    * 更新一条数据
    *
    * @param  array $data 数据
    * @return void
    */
    public function updateData($data = [])
    {
        if (empty($data)) {
            throw new CoreHttpException("argument data is null", 400);
        }
        $set = '';
        $dataCopy = $data;
        $pop = array_pop($dataCopy);
        foreach ($data as $k => $v) {
            if ($v === $pop) {
                $set .= "`{$k}` = :$k";
                $this->params[$k] = $v;
                continue;
            }
            $set .= "`{$k}` = :$k,";
            $this->params[$k] = $v;
        }

        $this->sql = "UPDATE `{$this->tableName}` SET {$set}";
    }

    /**
     * 查找一条数据
     *
     * @param  array $data 查询的字段
     * @return mixed
     */
    public function select($data=[])
    {
        $field = '';
        $count = count($data);
        switch ($count) {
            case 0:
                $field = '*';
                break;
            case 1:
                if(! isset($data[0])) {
                    throw new CoreHttpException(
                        "data format invalid",
                        400
                    );
                }
                $field = "`{$data[0]}`";
                break;

            default:
                $last = array_pop($data);
                foreach ($data as $v) {
                    $field .= "{$v},";
                }
                $field .= $last;
                break;
        }
        $this->sql = "SELECT $field FROM `{$this->tableName}`";
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

    /**
     * orderBy
     *
     * @param  string $data sort param, such as id desc
     * @return object
     */
    public function orderBy($sort = '')
    {
        if (! is_string($sort)) {
            throw new CoreHttpException(
                'argu is not string',
                400
            );
        }
        $this->orderBy = " order by {$sort}";
        return $this;
    }

    /**
     * limit
     *
     * @param  integer $start query start point, when just this argument that mean query limit quantity
     * @param  integer $len   query quantity
     * @return object
     */
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

    /**
     * count column
     *
     * @param  string $data 查询的字段
     * @return mixed
     */
    public function countColumn($data = '')
    {
        $data      = empty($data)? '*': $data;
        $field     = $this->packColumn('count',$data);

        $this->sql = "SELECT $field FROM `{$this->tableName}`";
    }

    /**
     * sum column
     *
     * @param  string $data 查询的字段
     * @return mixed
     */
    public function sumColumn($data = '')
    {
        $data      = empty($data)? '*': $data;
        $field     = $this->packColumn('sum',$data);

        $this->sql = "SELECT $field FROM `{$this->tableName}`";
    }

    /**
     * 组装mysql函数字段
     *
     * @param  string $functionName mysql函数名称
     * @param  string $data         参数
     * @return string
     */
    public function packColumn($functionName = '', $data = '')
    {
        $field     = "{$functionName}(`{$data}`)";
        preg_match_all('/(\w+)\sas/', $data, $matchColumn);
        if (isset($matchColumn[1][0]) || (! empty($matchColumn[1][0]))) {
            $matchColumn = $matchColumn[1][0];
            $field = "{$functionName}(`{$matchColumn}`)";
            preg_match_all('/as\s(\w+)/', $data, $match);
            if (isset($match[1][0]) || (! empty($match[1][0]))) {
                $match = $match[1][0];
                $field .= " as `{$match}`";
            }
        }

        return $field;
    }

    /**
     * query
     *
     * @param  string $sql sql statement
     * @return mixed
     */
    public function querySql($sql = '')
    {
        if (empty($sql)) {
            throw new CoreHttpException("sql is empty", 400);
        }
        $this->sql = $sql;
    }

}
