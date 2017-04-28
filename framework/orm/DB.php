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

use Framework\App;
use Framework\Exceptions\CoreHttpException;

/**
 * db使用决策类
 * 
 * 目前策略只支持mysql
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class DB
{
    /**
     * Sql解释器
     */
    use Interpreter;

    /**
     * 数据库类型
     *
     * 目前只支持mysql
     * 
     * @var string
     */
    private $dbtype  = '';

    /**
     * 数据库策略映射
     * 
     * 目前只支持mysql
     *
     * @var array
     */
    private $dbStrategyMap  = [
        'mysql' => 'Framework\Orm\Db\Mysql'
    ];

    /**
     * db instance
     *
     * @var object
     */
    private $dbInstance;

    /**
     * 设置表名
     *
     * @param string $tableName 表名称
     * @return void
     */
    public static function table($tableName = '')
    {
        $db = new self;
        $DB = APP::$container->setSingle('DB', $db);
        $DB->tableName = $tableName;
        $DB->init();
        
        return $DB;
    }

    /**
     * 初始化策略
     *
     * @return void
     */
    public function init()
    {
        $config  = APP::$container->getSingle('config');
        $this->dbtype = $config->config['database']['dbtype'];
        $this->decide();
    }

    /**
     * 策略决策
     *
     * @return void
     */
    public function decide()
    {
        $dbStrategyName   = $this->dbStrategyMap[$this->dbtype];
        $this->dbInstance = APP::$container->setSingle(
            $this->dbtype, 
            function () use ($dbStrategyName) {
                return new $dbStrategyName();
            }
        );
    }

    /**
     * 查找一条数据
     *
     * @return void
     */
    public function findOne()
    {
        $this->select();
        $this->buildSql();
        $functionName = __FUNCTION__;
        return $this->dbInstance->$functionName($this);
    }

    /**
     * 查找所有数据
     *
     * @return void
     */
    public function findAll()
    {
        $this->select();
        $this->buildSql();
        $functionName = __FUNCTION__;
        return $this->dbInstance->$functionName($this);
    }

    /**
     * 构建sql语句
     *
     * @return void
     */
    public function buildSql()
    {
        if (! empty($this->where)) {
            $this->sql .= $this->where;
        }
        if (! empty($this->orderBy)) {
            $this->sql .= $this->orderBy;
        }
        if (! empty($this->limit)) {
            $this->sql .= $this->limit;
        }
    }

    /**
     * 魔法函数__get
     *
     * @param  string $name  属性名称
     * @return mixed
     */
    public function __get($name = '')
    {
        return $this->$name;
    }

    /**
     * 魔法函数__set
     *
     * @param  string $name   属性名称
     * @param  mixed  $value  属性值
     * @return mixed
     */
    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }
}
