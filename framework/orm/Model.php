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
use Framework\Orm\DB;
use Framework\Exceptions\CoreHttpException;

/**
 *
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class Model extends DB
{
    /**
     * 构造函数
     *
     * __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->getTableName();
    }

    /**
     * 获取表名
     *
     * get table name
     *
     * @return void
     */
    public function getTableName()
    {
        $prefix = App::$container->getSingle('config')
                                 ->config['database']['dbprefix'];
        $callClassName = get_called_class();
        $callClassName = explode('\\', $callClassName);
        $callClassName = array_pop($callClassName);
        if (! empty($this->tableName)) {
            if (empty($prefix)) {
                return;
            }
            $this->tableName = $prefix . '_' . $this->tableName;
            return;
        }
        preg_match_all('/([A-Z][a-z]*)/', $callClassName, $match);
        if (! isset($match[1][0]) || empty($match[1][0])) {
            throw new CoreHttpException(401, 'model name invalid');
        }
        $match = $match[1];
        $count = count($match);
        if ($count === 1) {
            $this->tableName = strtolower($match[0]);
            if (empty($prefix)) {
                return;
            }
            $this->tableName = $prefix . '_' . $this->tableName;
            return;
        }
        $last = strtolower(array_pop($match));
        foreach ($match as $v) {
            $this->tableName .= strtolower($v) . '_';
        }
        $this->tableName .= $last;
        if (empty($prefix)) {
            return;
        }
        $this->tableName = $prefix . '_' . $this->tableName;
    }
}
