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

namespace Framework;

use Framework\App;

/**
 * 框架助手类
 *
 * Framework's helper class
 *
 * 工具类
 *
 * Tool class
 */
class Helper
{
    /**
     * 环境参数缓存
     *
     * @var array
     */
    private static $envCache = [];

    /**
     * 获取环境参数
     *
     * @param  string $paramName 参数名
     * @return mixed
     */
    public static function env($paramName = '')
    {
        if (array_key_exists($paramName, self::$envCache)) {
            return self::$envCache[$paramName];
        }
        self::$envCache[$paramName] = App::$container->getSingle('request')->env($paramName);
        return self::$envCache[$paramName];
    }

    /**
     * 浏览器友善的打印数据
     *
     * @param  array  $data 数据
     * @return mixed
     */
    public static function dump($data = [])
    {
        ob_start();
        var_dump($data);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
        echo ($output);
        return null;
    }

    /**
     * log
     *
     * @param  array  $data     log数据
     * @param  string $fileName log文件名 绝对路径
     * @return void
     */
    public static function log($data = [], $fileName = 'debug')
    {
        $time = date('Y-m-d H:i:s', time());
        error_log(
            "[{$time}]: " . json_encode($data, JSON_UNESCAPED_UNICODE)."\n",
            3,
            $fileName . '.log'
        );
    }
}
