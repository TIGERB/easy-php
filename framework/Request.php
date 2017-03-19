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
    private $_module = '';

    /**
     * 请求控制器
     * @var string
     */
    private $_controller = '';

    /**
     * 请求操作
     * @var string
     */
    private $_action = '';

    /**
     * 请求环境参数
     * @var array
     */
    private $_serverParams = [];

    /**
     * 请求所有参数
     * @var array
     */
    private $_requestParams = [];

    /**
     * 请求GET参数
     * @var array
     */
    private $_getParams = [];

    /**
     * 请求POST参数
     * @var array
     */
    private $_postParams = [];

    /**
     * 构造函数
     *
     * 设置环境、请求参数
     */
    public function __construct()
    {
        $this->_serverParams  = $_SERVER;
        $this->_requestParams = $_REQUEST;
        $this->_getParams     = $_GET;
        $this->_postParams    = $_POST;
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
        $name = '_'.$name;
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
        $name = '_'.$name;
        $this->$name = $value;
    }

    /**
     * 获取GET参数
     *
     * @param  string $value 参数名
     * @return mixed
     */
    public function get($value = '')
    {
        if (isset($this->getParams[$value])) {
            return $this->getParams[$value];
        }
        return '';
    }

    /**
     * 获取POST参数
     *
     * @param  string $value 参数名
     * @return mixed
     */
    public function post($value = '')
    {
        if (isset($this->postParams[$value])) {
            return $this->postParams[$value];
        }
        return '';
    }

    /**
     * 获取REQUEST参数
     *
     * @param  string $value 参数名
     * @return mixed
     */
    public function request($value = '')
    {
        if (isset($this->requestParams[$value])) {
            return $this->requestParams[$value];
        }
        return '';
    }

    /**
     * 获取SERVER参数
     *
     * @param  string $value 参数名
     * @return mixed
     */
    public function getServer($value = '')
    {
        if (isset($this->serverParams[$value])) {
            return $this->serverParams[$value];
        }
        return '';
    }
}
