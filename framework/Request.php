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

/**
 * 请求
 *
 * @author TIERGB <https://github.com/TIGERB>
 */
class Request
{
    /**
     * 请求模块
     * @var string
     */
    private $module = '';

    /**
     * 请求控制器
     * @var string
     */
    private $controller = '';

    /**
     * 请求操作
     * @var string
     */
    private $action = '';

    /**
     * 请求环境参数
     * @var array
     */
    private $serverParams = [];

    /**
     * 请求所有参数
     * @var array
     */
    private $requestParams = [];

    /**
     * 请求GET参数
     * @var array
     */
    private $getParams = [];

    /**
     * 请求POST参数
     * @var array
     */
    private $postParams = [];

    /**
     * http方法名称
     * @var string
     */
    private $method = '';

    /**
     * 服务ip
     * @var string
     */
    private $serverIp = '';

    /**
     * 客户端ip
     * @var string
     */
    private $clientIp = '';

    /**
     * 请求开始时间
     * @var float
     */
    private $beginTime = 0;

    /**
     * 请求结束时间
     * @var float
     */
    private $endTime = 0;

    /**
     * 请求消耗时间
     *
     * 毫秒
     *
     * @var int
     */
    private $consumeTime = 0;

    /**
     * 构造函数
     *
     * 设置环境、请求参数
     *
     * @param App $app 框架实例
     */
    public function __construct(App $app)
    {
        $this->serverParams = $_SERVER;
        $this->method       = isset($_SERVER['REQUEST_METHOD'])? strtolower($_SERVER['REQUEST_METHOD']) : 'get';
        $this->serverIp     = isset($_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR'] : '';
        $this->clientIp     = isset($_SERVER['SERVER_ADDR'])? $_SERVER['SERVER_ADDR'] : '';
        $this->beginTime    = isset($_SERVER['REQUEST_TIME_FLOAT'])? $_SERVER['REQUEST_TIME_FLOAT'] : time(true);
        if ($app->isCli === 'yes') {
            // cli 模式
            $this->requestParams = $_REQUEST['argv'];
            $this->getParams     = $_REQUEST['argv'];
            $this->postParams    = $_REQUEST['argv'];
        } else {
            $this->requestParams = $_REQUEST;
            $this->getParams     = $_GET;
            $this->postParams    = $_POST;
        }
    }

    /**
     * 魔法函数__get.
     *
     * @param string $name 属性名称
     *
     * @return mixed
     */
    public function __get($name = '')
    {
        return $this->$name;
    }

    /**
     * 魔法函数__set.
     *
     * @param string $name  属性名称
     * @param mixed  $value 属性值
     *
     * @return mixed
     */
    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }

    /**
     * 获取GET参数
     *
     * @param  string  $value      参数名
     * @param  string  $default    默认值
     * @param  boolean $checkEmpty 值为空时是否返回默认值，默认true
     * @return mixed
     */
    public function get($value = '', $default = '', $checkEmpty = true)
    {
        if (! isset($this->getParams[$value])) {
            return '';
        }
        if (empty($this->getParams[$value]) && $checkEmpty) {
            return $default;
        }
        return $this->getParams[$value];
    }

    /**
     * 获取POST参数
     *
     * @param  string  $value      参数名
     * @param  string  $default    默认值
     * @param  boolean $checkEmpty 值为空时是否返回默认值，默认true
     * @return mixed
     */
    public function post($value = '', $default = '', $checkEmpty = true)
    {
        if (! isset($this->postParams[$value])) {
            return '';
        }
        if (empty($this->getParams[$value]) && $checkEmpty) {
            return $default;
        }
        return $this->postParams[$value];
    }

    /**
     * 获取REQUEST参数
     *
     * @param  string  $value      参数名
     * @param  string  $default    默认值
     * @param  boolean $checkEmpty 值为空时是否返回默认值，默认true
     * @return mixed
     */
    public function request($value = '', $default = '', $checkEmpty = true)
    {
        if (! isset($this->requestParams[$value])) {
            return '';
        }
        if (empty($this->getParams[$value]) && $checkEmpty) {
            return $default;
        }
        return $this->requestParams[$value];
    }

    /**
     * 获取所有参数
     *
     * @return array
     */
    public function all()
    {
        return $this->requestParams;
    }

    /**
     * 获取SERVER参数
     *
     * @param  string $value 参数名
     * @return mixed
     */
    public function server($value = '')
    {
        if (isset($this->serverParams[$value])) {
            return $this->serverParams[$value];
        }
        return '';
    }
}
