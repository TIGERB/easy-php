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

namespace Framework\Orm\Db;

use Framework\App;
use Framework\Orm\DB;
use Framework\Exceptions\CoreHttpException;
use PDO;

/**
 * mysql实体类
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class Mysql
{
    /**
     * db host
     *
     * @var string
     */
    private $dbhost   = '';

    /**
     * db name
     *
     * @var string
     */
    private $dbname   = '';

    /**
     * db connect info
     *
     * @var string
     */
    private $dns      = '';

    /**
     * db username
     *
     * @var string
     */
    private $username = '';

    /**
     * db password
     *
     * @var string
     */
    private $password = '';

    /**
     * pdo instance
     *
     * @var string
     */
    private $pdo = '';

    /**
     * 预处理实例
     *
     * 代表一条预处理语句，并在该语句被执行后代表一个相关的结果集。
     *
     * @var object
     */
    private $pdoStatement = '';

    /**
     * construct function
     */
    public function __construct()
    {
        $config         = APP::$container->getSingle('config');
        $config         = $config->config;
        $dbConfig       = $config['database'];
        $this->dbhost   = $dbConfig['dbhost'];
        $this->dbname   = $dbConfig['dbname'];
        $this->dsn      = "mysql:dbname={$this->dbname};host={$this->dbhost};";
        $this->username = $dbConfig['username'];
        $this->password = $dbConfig['password'];

        $this->connect();
    }

    /**
     * build connect with mysql by pdo drive
     *
     * @return void
     */
    private function connect()
    {
        $this->pdo = new PDO(
            $this->dsn,
            $this->username,
            $this->password
        );
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

    /**
     * select one data
     *
     * @param  DB     $db DB instance
     * @return array
     */
    public function findOne(DB $db)
    {
        $this->pdoStatement = $this->pdo->prepare($db->sql);
        $this->bindValue($db);
        $this->pdoStatement->execute();
        return $this->pdoStatement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * select all data
     *
     * @param  DB     $db DB instance
     * @return array
     */
    public function findAll(DB $db)
    {
        $this->pdoStatement = $this->pdo->prepare($db->sql);
        $this->bindValue($db);
        $this->pdoStatement->execute();
        return $this->pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * save data
     *
     * @param  DB     $db DB instance
     * @return string
     */
    public function save(DB $db)
    {
        $this->pdoStatement = $this->pdo->prepare($db->sql);
        $this->bindValue($db);
        $this->pdoStatement->execute();
        return $db->id  = $this->pdo->lastInsertId();
    }

    /**
     * delete data
     *
     * @param  DB     $db DB instance
     * @return boolean
     */
    public function delete(DB $db)
    {
        $this->pdoStatement = $this->pdo->prepare($db->sql);
        $this->bindValue($db);
        $this->pdoStatement->execute();
        return $this->pdoStatement->rowCount();
    }

    /**
     * update data
     *
     * @param  DB     $db DB instance
     * @return boolean
     */
    public function update(DB $db)
    {
        $this->pdoStatement = $this->pdo->prepare($db->sql);
        $this->bindValue($db);
        return $this->pdoStatement->execute();
    }

    /**
     * query
     *
     * @param  DB     $db DB instance
     * @return boolean
     */
    public function query(DB $db)
    {
        $res = [];
        foreach ($this->pdo->query($db->sql, PDO::FETCH_ASSOC) as $v) {
            $res[] = $v;
        }
        return $res;
    }

    /**
     * bind value
     *
     * @param  DB     $db DB instance
     * @return void
     */
    public function bindValue(DB $db)
    {
        if (empty($db->params)) {
            return;
        }
        foreach ($db->params as $k => $v) {
            $this->pdoStatement->bindValue(":{$k}", $v);
        }
    }

    /**
     * stop auto commit transaction and start a transaction
     *
     * @return void
     */
    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    /**
     * commit a transaction
     *
     * @return void
     */
    public function commit()
    {
        $this->pdo->commit();
    }

    /**
     * rollback a transaction
     *
     * @return void
     */
    public function rollBack()
    {
        $this->pdo->rollBack();
    }
}
