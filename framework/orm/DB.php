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
    protected $dbtype  = '';

    /**
     * 表名称
     *
     * table name
     *
     * @var string
     */
    protected $tableName = '';

    /**
     * 数据库策略映射
     *
     * 目前只支持mysql
     *
     * @var array
     */
    protected $dbStrategyMap  = [
        'mysqldb' => 'Framework\Orm\Db\Mysql'
    ];

    /**
     * db instance
     *
     * @var object
     */
    protected $dbInstance;

    /**
     * 自增id
     *
     * 插入数据成功后的自增id, 0为插入失败
     *
     * @var string
     */
    protected $id = '';

    /**
     * 走主库的查寻语句
     *
     * @var array
     */
    private $master = ['insert', 'update', 'delete'];

    /**
     * 当前查询主从
     *
     * @var string
     */
    private $masterSlave = '';

    /**
     * 数据库配置
     *
     * @var array
     */
    private $dbConfig = [
        'dbhost'   => '',
        'dbname'   => '',
        'username' => '',
        'password' => ''
    ];

    /**
     * 构造函数
     */
    public function __construct()
    {
        // $this->init();
    }

    /**
     * 设置表名
     *
     * @param string $tableName 表名称
     * @return void
     */
    public static function table($tableName = '')
    {
        $db = new self;
        $db->tableName = $tableName;
        $prefix = App::$container->getSingle('config')
                                 ->config['database']['dbprefix'];
        if (! empty($prefix)) {
            $db->tableName = $prefix . '_' . $db->tableName;
        }
        // $db->init();

        return $db;
    }

    /**
     * 初始化策略
     *
     * @param  $masterOrSlave 初始化主库还是从库
     * @return void
     */
    public function init($masterOrSlave = '')
    {
        $config  = APP::$container->getSingle('config');
        $this->dbtype = $config->config['database']['dbtype'];
        if (! empty($masterOrSlave)) {
            $this->masterSlave = $masterOrSlave;
        }
        $this->isMasterOrSlave();
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
        $dbConfig         = $this->dbConfig;
        $this->dbInstance = APP::$container->getSingle(
            "{$this->dbtype}-{$this->masterSlave}",
            function () use ($dbStrategyName, $dbConfig) {
                return new $dbStrategyName(
                    $dbConfig['dbhost'],
                    $dbConfig['dbname'],
                    $dbConfig['username'],
                    $dbConfig['password']
                );
            }
        );
    }

    /**
     * 判断走主库还是从库
     *
     * @return void
     */
    public function isMasterOrSlave()
    {
        if (! empty($this->masterSlave)) {
            $this->initMaster();
            return;
        }
        foreach ($this->master as $v) {
            $res = stripos($this->sql, $v);
            if ($res === 0 || $res) {
                $this->initMaster();
                return;
            }
        }
        $this->initSlave();
    }

    /**
     * 初始化主库
     */
    public function initMaster()
    {
        $config = APP::$container->getSingle('config');
        $dbConfig = $config->config['database'];
        $this->dbConfig['dbhost']   = $dbConfig['dbhost'];
        $this->dbConfig['dbname']   = $dbConfig['dbname'];
        $this->dbConfig['username'] = $dbConfig['username'];
        $this->dbConfig['password'] = $dbConfig['password'];

        $this->masterSlave = 'master';
    }

    /**
     * 初始化从库
     */
    public function initSlave()
    {
        $config = APP::$container->getSingle('config');
        if (! isset($config->config['database']['slave'])) {
            $this->initMaster();
            return;
        }
        $slave                      = $config->config['database']['slave'];
        $randSlave                  = $slave[array_rand($slave)];
        $dbConfig                   = $config->config["database-slave-{$randSlave}"];
        $this->dbConfig['dbhost']   = $dbConfig['dbhost'];
        $this->dbConfig['dbname']   = $dbConfig['dbname'];
        $this->dbConfig['username'] = $dbConfig['username'];
        $this->dbConfig['password'] = $dbConfig['password'];

        $this->masterSlave = "slave-{$randSlave}";
    }

    /**
     * 查找一条数据
     *
     * @param  array $data 查询的字段
     * @return void
     */
    public function findOne($data = [])
    {
        $this->select($data);
        $this->buildSql();
        $functionName = __FUNCTION__;
        return $this->dbInstance->$functionName($this);
    }

    /**
     * 查找所有数据
     *
     * @param  array $data 查询的字段
     * @return void
     */
    public function findAll($data = [])
    {
        $this->select($data);
        $this->buildSql();
        $functionName = __FUNCTION__;
        return $this->dbInstance->$functionName($this);
    }

    /**
     * 查找所有数据
     *
     * @return void
     */
    public function save($data = [])
    {
        $this->insert($data);
        $this->init();
        $functionName = __FUNCTION__;
        return $this->dbInstance->$functionName($this);
    }

    /**
     * 查找所有数据
     *
     * @return void
     */
    public function delete()
    {
        $this->del();
        $this->buildSql();
        $functionName = __FUNCTION__;
        return $this->dbInstance->$functionName($this);
    }

    /**
     * 查找所有数据
     *
     * @param  array $data 数据
     * @return void
     */
    public function update($data = [])
    {
        $this->updateData($data);
        $this->buildSql();
        $functionName = __FUNCTION__;
        return $this->dbInstance->$functionName($this);
    }

    /**
     * count数据
     *
     * @param  string $data 数据
     * @return void
     */
    public function count($data = '')
    {
        $this->countColumn($data);
        $this->buildSql();
        return $this->dbInstance->findAll($this);
    }

    /**
     * sum数据
     *
     * @param  string $data 数据
     * @return void
     */
    public function sum($data = '')
    {
        $this->sumColumn($data);
        $this->buildSql();
        return $this->dbInstance->findAll($this);
    }

    /**
     * sum数据
     *
     * @param  string $data 数据
     * @return void
     */
    public function query($sql = '')
    {
        $this->querySql($sql);
        $this->init();
        return $this->dbInstance->query($this);
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

        $this->init();
    }

    /**
     * stop auto commit transaction and start a transaction
     *
     * @return void
     */
    public static function beginTransaction()
    {
        $instance = APP::$container->getSingle('DB', function () {
                return new DB();
            }
        );
        $instance->init('master');
        $instance->dbInstance->beginTransaction();
    }

    /**
     * commit a transaction
     *
     * @return void
     */
    public static function commit()
    {
        $instance = APP::$container->getSingle('DB', function () {
                return new DB();
            }
        );
        $instance->init('master');
        $instance->dbInstance->commit();
    }

    /**
     * rollback a transaction
     *
     * @return void
     */
    public static function rollBack()
    {
        $instance = APP::$container->setSingle('DB', function () {
                return new DB();
            }
        );
        $instance->init('master');
        $instance->dbInstance->rollBack();
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
