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
    public function __construct()
    {
        $this->register();
    }

    /**
     * 应用启动注册.
     *
     * @return mixed
     */
    public function register()
    {
        spl_autoload_register([$this, 'autoload']);
    }

   /**
    * [autoload description].
    *
    * @param  [type] $class [description]
    *
    * @return [type]        [description]
    */
    private function autoload($class)
    {
        if (empty($class)) {
            throw new Exception("Error Processing Request", 1);
        }
        $class_info = explode('\\', $class);
        $class_name = array_pop($class_info);
        foreach ($class_info as &$v) {
            $v = strtolower($v);
        }
        unset($v);
        array_push($class_info, $class_name);
        $class = implode('\\', $class_info);

        require ROOT_PATH.'/'.str_replace('\\', '/', $class).'.php';
    }
 }
