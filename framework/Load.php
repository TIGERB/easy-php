<?php
/**
 * easy-php.
 *
 * a light php framework for study
 *
 * @author: TIERGB <https://github.com/TIGERB>
 */

/**
 * 注册加载handle.
 */
class Load
{
    public static $map = [];

    /**
     * 应用启动注册.
     *
     * @return mixed
     */
    public function register()
    {
        spl_autoload_register(['Load', 'autoload']);
    }

   /**
    * [autoload description].
    *
    * @param  [type] $class [description]
    *
    * @return [type]        [description]
    */
    private static function autoload($class)
    {
        $classOrigin = $class;
        if (empty($class)) {
            throw new Exception("autoload empty Not Found", 404);
        }
        $classInfo = explode('\\', $class);
        $className = array_pop($classInfo);
        foreach ($classInfo as &$v) {
            $v = strtolower($v);
        }
        unset($v);
        array_push($classInfo, $className);
        $class       = implode('\\', $classInfo);
        $classPath   = ROOT_PATH.'/'.str_replace('\\', '/', $class).'.php';
        if (!file_exists($classPath)) {
            throw new Exception("$classPath Not Found", 404);
        }
        self::$map[$classOrigin] = $classPath;
        require $classPath;
    }
 }
