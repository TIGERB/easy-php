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

use Framework\Exceptions\CoreHttpException;

/**
 * 注册加载handle
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class Load
{
    public static $map = [];

    /**
     * 应用启动注册.
     *
     * @return mixed
     */
    public static function register()
    {
        // 注册框架加载函数　不使用composer加载机制加载框架　自己实现
        spl_autoload_register(['Load', 'autoload']);

        // 引入composer自加载文件
        require(ROOT_PATH . '/vendor/autoload.php');
    }

   /**
    * 自加载函数
    *
    * @param  string $class 类名
    *
    * @return void
    */
    private static function autoload($class)
    {
        $classOrigin = $class;
        $classInfo   = explode('\\', $class);
        $className   = array_pop($classInfo);
        foreach ($classInfo as &$v) {
            $v = strtolower($v);
        }
        unset($v);
        array_push($classInfo, $className);
        $class       = implode('\\', $classInfo);
        $classPath   = ROOT_PATH.'/'.str_replace('\\', '/', $class).'.php';
        if (!file_exists($classPath)) {
            // 框架级别加载文件不存在　composer加载
            return;
            throw new CoreHttpException(404, "$classPath Not Found");
        }
        self::$map[$classOrigin] = $classPath;
        require $classPath;
    }

 }
