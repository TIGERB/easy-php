<?php
/**
 * easy-php
 *
 * a light php framework for study
 *
 * @author: TIERGB <https://github.com/TIGERB>
 */

 /**
  * 注册加载handle
  */
 class Load
 {

   public function __construct()
   {
     # code...
   }

   /**
    * 应用启动注册
    *
    * @return mixed
    */
   public function register()
   {
     spl_autoload_register([$this, 'autoload']);
   }

   /**
    * [autoload description]
    * @param  [type] $class [description]
    * @return [type]        [description]
    */
   private function autoload($class)
   {
    //  var_dump($class);die;
     require ROOT_PATH  . '/' . str_replace('\\', '/', $class) . '.php';
   }
 }
