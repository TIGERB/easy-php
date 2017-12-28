<?php
/*************************************************
 *                  Easy PHP                     *
 *                                               *
 * A Faster Lightweight Full-Stack PHP Framework *
 *                                               *
 *                  TIERGB                       *
 *        <https://github.com/TIGERB>            *
 *                                               *
 *************************************************/

namespace Framework\Router;

use Framework\Router\RouterInterface;
use Framework\Router\Router;
use Framework\Exceptions\CoreHttpException;

/**
 * 自定义路由策略.
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class Userdefined implements RouterInterface
{
	/**
     * 自定义路由规则
     *
     * get请求
     *
     * 查询数据
     *
     * @var array
     */
    private $getMap = [];
	
	/**
	 * 自定义路由规则
	 *
	 * post请求
	 *
	 * 新增数据
	 *
	 * @var array
	 */
	private $postMap = [];

	/**
	 * 自定义路由规则
	 *
	 * put请求
	 *
	 * 更新数据
	 *
	 * @var array
	 */
	private $putMap = [];

	/**
	 * 自定义路由规则
	 *
	 * delete请求
	 *
	 * 删除数据
	 *
	 * @var array
	 */
	private $deleteMap = [];

	/**
     * 自定义get请求路由
     *
     * @param  string $uri      请求uri
     * @param  mixed  $function 匿名函数或者控制器方法标示
     * @return void
     */
    public function get($uri = '', $function = '')
    {
        $this->getMap[$uri] = $function;
    }

    /**
     * 自定义post请求路由
     *
     * @param  string $uri      请求uri
     * @param  mixed  $function 匿名函数或者控制器方法标示
     * @return void
     */
    public function post($uri = '', $function = '')
    {
        $this->postMap[$uri] = $function;
    }

    /**
     * 自定义put请求路由
     *
     * @param  string $uri      请求uri
     * @param  mixed  $function 匿名函数或者控制器方法标示
     * @return void
     */
    public function put($uri = '', $function = '')
    {
        $this->putMap[$uri] = $function;
    }

    /**
     * 自定义delete请求路由
     *
     * @param  string $uri      请求uri
     * @param  mixed  $function 匿名函数或者控制器方法标示
     * @return void
     */
    public function delete($uri = '', $function = '')
    {
        $this->deleteMap[$uri] = $function;
	}
	
    /**
     * 路由方法
     *
     * @param void
     */
    public function route(Router $entrance)
    {
        if ($entrance->routeStrategy === 'job') {
            return;
        }

		$module = $entrance->config->config['module'];
        foreach ($module as $v) {
            // 加载自定义路由配置文件
            $routeFile = "{$entrance->app->rootPath}/config/{$v}/route.php";
            if (file_exists($routeFile)) {
                require($routeFile);
            }
        }
        $uri     = "{$entrance->moduleName}/{$entrance->controllerName}/{$entrance->actionName}";
        $app     = $entrance->app;
        $request = $app::$container->get('request');
        $method  = strtolower($request->method) . 'Map';
        if (! isset($this->$method)) {
            throw new CoreHttpException(
                404,
                'Http Method:'. $request->method
            );
        }
        if (! array_key_exists($uri, $this->$method)) {
            return false;
		}
		
        // 执行自定义路由匿名函数
        $map = $this->$method;
        $entrance->app->responseData = $map[$uri]($app);
        if ($entrance->app->runningMode === 'cli') {
            $entrance->app->notOutput = false;
		}
		return true;
    }
}
