<p align="center"><img width="60%" src="logo.png"><p>

<p align="center">
<a href="http://php.tigerb.cn/"><img src="https://img.shields.io/badge/build-passing-brightgreen.svg" alt="Build Status"></a>
<a href="http://php.tigerb.cn/"><img src="https://img.shields.io/badge/php-5.4%2B-blue.svg" alt="Version"></a>
<a href="https://github.com/TIGERB/easy-php/releases"><img src="https://img.shields.io/badge/version-0.6.6-green.svg" alt="Version"></a>
<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/cocoapods/l/AFNetworking.svg" alt="License"></a>
</p>

<p align="center"> A lightweight PHP framework for studying <p>

<p align="center"> <a href="./README-CN.md">中文版</a>　<p>

# How to build a PHP framework by ourself ?

Why do we need to build a PHP framework by ourself? Maybe the most of people will say "There have so many PHP frameworks be provided, but we still made a wheel?". My point is "Made a wheel is not our purpose, we will get a few of knowledge when making a wheel which is our really purpose".

Then, how to build a PHP framework by ourself? General process as follows:

```
Entry file ----> Register autoload function
           ----> Register error(and exception) function
           ----> Load config file
           ----> Request
           ----> Router
           ----> (Controller <----> Model)
           ----> Response
           ----> Json
           ----> View
```

In addition, unit test, nosql support, api documents and some auxiliary scripts, etc.The Easy PHP framework directory as follows:

#  Project Directory Structure

```
app                             [application backend directory]
├── demo                        [module directory]
│   ├── controllers             [controller directory]
│   │       └── Index.php       [default controller class file]
│   ├── logics                  [logic directory]
│   │   ├── exceptions          [exception directory]
│   │   ├── gateway          　　[a gateway example]
│   │   ├── tools               [tool class directory]
│   │   └── UserDefinedCase.php [register user defined handle before framework loading router]
│   └── models                  [model directory]
│       └── TestTable.php       [model class file]
├── config                      [config folder]
│    ├── demo                   [module config folder]
│    │   ├── config.php         [module-defined config]
│    │   └── route.php          [module-defined router]
│    ├── common.php             [common config]
│    ├── database.php           [database config]
│    └── nosql.php              [nosql config]
docs                            [api document directory]
├── apib                        [Api Blueprint]
│    └── demo.apib              [api doc example file]
├── swagger                     [swagger]
framework                       [easy-php framework directory]
├── exceptions                  [core exception class]
│      ├── CoreHttpException.php[http exception]
├── handles                     [handle class file be used by app run]
│      ├── Handle.php           [handle interface]
│      ├── ErrorHandle.php      [error handle class]
│      ├── ExceptionHandle.php  [exception handle class]
│      ├── ConfigHandle.php     [config handle class]
│      ├── NosqlHandle.php      [nosql handle class]
│      ├── UserDefinedHandle.php[user defined handle class]
│      └── RouterHandle.php     [router handle class]
├── orm                         [datebase object relation map class directory]
│      ├── Interpreter.php      [sql Interpreter class]
│      ├── DB.php               [database operation class]
│      ├── Model.php            [data model]
│      └── db                   [db type directory]
│          └── Mysql.php        [mysql class file]
├── nosql                       [nosql directory]
│    ├── Memcahed.php           [memcahed class file]
│    ├── MongoDB.php            [mongoDB class file]
│    └── Redis.php              [redis class file]
├── App.php                     [this application class file]
├── Container.php               [container class file]
├── Helper.php                  [helper class file]
├── Log.php                     [log class file]
├── Load.php                    [autoload class file]
├── Request.php                 [request object class file]
├── Response.php                [response object class file]
├── run.php                     [run this application script file]
frontend                        [application frontend source code directory]
├── src                         [source folder]
│    ├── components             [vue components]
│    ├── views                  [vue views]
│    ├── images                 [images folder]
│    ├── ...
├── app.js                      [vue root js]
├── app.vue                     [vue root component]
├── index.template.html         [frontend entrance template file]
├── store.js                    [vuex store file]
public                          [this is a resource directory to expose service resource]
├── dist                        [frontend source file after build]
│    └── ...
├── index.html                  [entrance html file]
├── index.php                   [entrance php script file]
runtime                         [temporary file such as log]
├── logs                        [log directory]
tests                           [unit test directory]
├── demo                        [module name]
│      └── DemoTest.php         [test class file]
├── TestCase.php                [phpunit test case class file]
vendor                          [composer vendor directory]
.git-hooks                      [git hooks directory]
├── pre-commit                  [git pre-commit example file]
└── commit-msg                  [git commit-msg example file]
.babelrc                        [babel　config file]
.env                            [the environment variables file]
.gitignore                      [git ignore config file]
cli                             [run this framework with the php cli mode]
LICENSE                         [lincese　file]
logo.png                        [logo picture]
composer.json                   [composer file]
composer.lock                   [composer lock file]
package.json                    [dependence file for frontend]
phpunit.xml                     [phpunit config file]
README-CN.md                    [readme file chinese]
README.md                       [readme file]
webpack.config.js               [webpack config file]
yarn.lock                       [yarn　lock file]

```

# Framework Module Description:

##  Entrance file

Defined a entrance file that provide a uniform file for user visit, which hide the complex logic like the enterprise service bus.

##  Autoload Module

Register a autoload function in the __autoload queue by used spl_autoload_register, after that, we can use a class by namespace and keyword 'use'.

##  Error&Exception Handle Module

- Catch error:

Register a function by used set_error_handler to handle error, but it can't handle the following error, E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING and the E_STRICT produced by the file which called set_error_handler function. So, we need use register_shutdown_function and error_get_last to handle this finally error which set_error_handler can't handle. When the framework running, we can handle the error by ourself, such as, give a friendly error messge for client.

- Catch exception:

Register a function by used set_exception_handler to handle the exception which is not be catched, which can give a friendly error messge for client.

##  Config Handle Module

Loading framework-defined and user-defined config files.

##  Request&Response Module

- Request  Object: contains all the requested information.
- Response Object: contains all the response information.

框架中所有的异常输出和控制器输出都是json格式，因为我认为在前后端完全分离的今天，这是很友善的，目前我们不需要再去考虑别的东西。

##  Route Handle Module

Execute the target controller's function by the router parse the url information.我在这里把路由大致分成了四类：

**传统路由**

```
domain/index.php?module=Demo&contoller=Index&action=test&username=test
```

**pathinfo路由**

```
domain/demo/index/modelExample
```

**用户自定义路由**

```
// 定义在config/moduleName/route.php文件中，这个的this指向RouterHandle实例
$this->get('v1/user/info', function (Framework\App $app) {
    return 'Hello Get Router';
});
```

**微单体路由**

我在这里详细说下这里所谓的微单体路由，面向SOA和微服务架构大行其道的今天，有很多的团队都在向服务化迈进，但是服务化中困难最大和成本最高的地方之一应该就是分布式的事务问题。这导致对于小的团队从单体架构走向服务架构难免困难重重，所以有人提出来了微单体架构，按照我的理解就是在一个单体架构的SOA过程，我们把微服务中的的各个服务还是以模块的方式放在同一个单体中，比如：

```
app
├── UserService     [用户服务模块]
├── ContentService  [内容服务模块]
├── OrderService    [订单服务模块]
├── CartService     [购物车服务模块]
├── PayService      [支付服务模块]
├── GoodsService    [商品服务模块]
└── CustomService   [客服服务模块]
```

如上，我们简单的在一个单体里构建了各个服务模块，但是这些模块怎么通信呢？如下：

```
App::$app->get('demo/index/hello', [
    'user' => 'TIGERB'
]);
```

通过上面的方式我们就可以松耦合的方式进行单体下各个模块的通信和依赖了。与此同时，业务的发展是难以预估的，未来当我们向SOA的架构迁移时，很简单，我们只需要把以往的模块独立成各个项目，然后把App实例get方法的实现转变为RPC或者REST的策略即可，我们可以通过配置文件去调整对应的策略或者把自己的，第三方的实现注册进去即可。

##  MVC To MCL

The tradition MVC pattern includes the model,view,controller layer. In general, you always write the business logic in the controller or model layer. But you will feel the code is difficult to read, maintain, expand after a long time. So I add a logic layer in the framework forcefully where you can implement the business logic by yourself. You can not only implement a tool class but also implement your business logic in a new subfolder, what's more, you can implement a gateway based on the pattern of responsibility (I provided a example).

In the end, the structure as follows:

- M: models, the map of database's table where define the curd operation.
- C: controllers, where expose the business resourse
- L: logics,　where implement the business logic flexiblly

**Logics layer**

A gateway example：

I build a gateway in the logics folder,gateway的结构如下：

```
gateway                     [Logics层目录下gateway逻辑目录]
  ├── Check.php             [接口]
  ├── CheckAppkey.php       [检验app key]
  ├── CheckArguments.php    [校验必传参数]
  ├── CheckAuthority.php    [校验访问权限]
  ├── CheckFrequent.php     [校验访问频率]
  ├── CheckRouter.php       [网关路由]
  ├── CheckSign.php         [校验签名]
  └── Entrance.php          [网关入口文件]
```

The gateway entrance class code as follows:

```
// init：gateway common arguments must be not empty check
$checkArguments   =  new CheckArguments();
// init：app key check
$checkAppkey      =  new CheckAppkey();
// init：call frequent check
$checkFrequent    =  new CheckFrequent();
// init：sign check
$checkSign        =  new CheckSign();
// init：auth check
$checkAuthority   =  new CheckAuthority();
// init：gateway's router
$checkRouter      =  new CheckRouter();

// build object chain
$checkArguments->setNext($checkAppkey)
               ->setNext($checkFrequent)
               ->setNext($checkSign)
               ->setNext($checkAuthority)
               ->setNext($checkRouter);

// start gateway
$checkArguments->start(
    APP::$container->getSingle('request')
);
```

After the gateway be implemented, how to use this in the framework?I provide a user-defined's class, we just register this in the UserDefinedCase class. for example:

```
/**
 * register user-defined behavior
 *
 * @var array
 */
private $map = [
    //　for example, loading user-defined gateway
    'App\Demo\Logics\Gateway\Entrance'
];
```
So, the gateway is running.But what's the UserDefinedCase that can be loading before RouterHandle.

Where is the view layer?I abandon it, beacuse I chose the SPA for frontend, detail as follows:

##  Using Vue For View

**source code folder**

The separate-frontend-and-backend and two-way data binding, modular is so popular.In the meantime, I moved the project [easy-vue](http://vue.tigerb.cn/) that built by myself to the framework as the view layer. The frontend source code folder as follows:

```
frontend                        [application frontend source code directory]
├── src                         [source folder]
│    ├── components             [vue components]
│    ├── views                  [vue views]
│    ├── images                 [images folder]
│    ├── ...
├── app.js                      [vue root js]
├── app.vue                     [vue root component]
├── index.template.html         [frontend entrance template file]
├── store.js                    [vuex store file]
```

**Build Step**

```
npm install

DOMAIN=http://yourdomain npm run test
```

**After build**

After built success, there made dist folder and index.html in the public. This file will be ignore when this branch is not the release branch.

```
public                          [this is a resource directory to expose service resource]
├── dist                        [frontend source file after build]
│    └── ...
├── index.html                  [entrance html file]
```

##  ORM

数据库对象关系映射ORM(Object Relation Map)是什么？按照我目前的理解：顾名思义是建立对象和抽象事物的关联关系，在数据库建模中model实体类其实就是具体的表，对表的操作其实就是对model实例的操作。可能绝大多数的人都要问“为什么要这样做，直接sql语句操作不好吗？搞得这么麻烦！”，我的答案：直接sql语句当然可以，一切都是灵活的，但是从一个项目的**可复用，可维护, 可扩展**出发，采用ORM思想处理数据操作是理所当然的，想想如果若干一段时间你看见代码里大段的难以阅读且无从复用的sql语句，你是什么样的心情。

市面上对于ORM的具体实现有thinkphp系列框架的Active Record,yii系列框架的Active Record,laravel系列框架的Eloquent(据说是最优雅的)，那我们这里言简意赅就叫ORM了。接着为ORM建模，首先是ORM客户端实体DB：通过配置文件初始化不同的db策略，并封装了操作数据库的所有行为，最终我们通过DB实体就可以直接操作数据库了，这里的db策略目前我只实现了mysql(负责建立连接和db的底层操作)。接着我们把DB实体的sql解析功能独立成一个可复用的sql解析器的trait，具体作用：把对象的链式操作解析成具体的sql语句。最后，建立我们的模型基类model,model直接继承DB即可。最后的结构如下：

```
├── orm                         [对象关系模型]
│      ├── Interpreter.php      [sql解析器]
│      ├── DB.php               [数据库操作类]
│      ├── Model.php            [数据模型基类]
│      └── db                   [数据库类目录]
│          └── Mysql.php        [mysql实体类]
```

**DB类使用示例**

```
/**
 * DB操作示例
 *
 * findAll
 *
 * @return void
 */
public function dbFindAllDemo()
{
    $where = [
        'id'   => ['>=', 2],
    ];
    $instance = DB::table('user');
    $res      = $instance->where($where)
                         ->orderBy('id asc')
                         ->limit(5)
                         ->findAll(['id','create_at']);
    $sql      = $instance->sql;

    return $res;
}
```

**Model类使用示例**

```
// controller 代码
/**
 * model example
 *
 * @return mixed
 */
public function modelExample()
{
    $testTableModel = new TestTable();
    return $testTableModel->modelFindDemo();
}

//TestTable model
/**
 * Model操作示例
 *
 * findAll
 *
 * @return void
 */
public function modelFindAllDemo()
{
    $where = [
        'id'   => ['>=', 2],
    ];
    $res = $this->where($where)
                ->orderBy('id asc')
                ->limit(5)
                ->findAll(['id','create_at']);
    $sql = $this->sql;

    return $res;
}
```

##  Service Container

What's the service container?

Service container is difficultly understand, I think it just a third party class, which can inject the class and instance. we can get the instance in the container very simple.

The meaning of the service container?

According to the design patterns: we need make our code "highly cohesive, loosely coupled". As the result of "highly cohesive" is "single principle", As the result of "single principle" is the class rely on each other. General way that handle the dependency as follows:

```
class Demo
{
    public function __construct ()
    {
        // the demo directly dependent on RelyClassName
        $instance = new RelyClassName ();
    }
}
```

The above code is no problem, but is not conform to the design pattern of "The least kown principle", beacuse it has a direct dependence. We bring a third class in the framework, which can new a class or get a instance. So, the third party class is the service container, which like the role of 'middleware' in the architecture of the system.

After implements a service container, I put the Rquest, Config and other instances are injected into service in the singleton container, when we need to use can be obtained from the container, is very convenient.Use the following:

```
// Inject the single instance
App::$container->setSingle('alias', 'object/closure/class name');

// Such as，Inject Request instance
App::$container->setSingle('request', $request);
// get Request instance
App::$container->getSingle('request');
```

##  Nosql Support

Inject the nosql's single instance in service container when the framework loading, you can decide what nosql you need use whit the configuration. At present we support redis/memcahed/mongodb.

Some example:

```
// get redis instance
App::$container->getSingle('redis');
// get memcahed instance
App::$container->getSingle('memcahed');
// get mongodb instance
App::$container->getSingle('mongodb');
```

##  Api Docs

Usually after we write an api, the api documentation is a problem, we use the Api Blueprint protocol to write the api document and mock. At the same time, we can request the api real-timely by used Swagger.

I chose the Api Blueprint's tool snowboard, detail as follows：

**Api doc generate instruction**

```
cd docs/apib

./snowboard html -i demo.apib -o demo.html -s

open the website, http://localhost:8088/
```

**Api mock instruction**

```
cd docs/apib

./snowboard mock -i demo.apib

open the website, http://localhost:8087/demo/index/hello
```

##  PHPunit

Based on the phpunit, I think write unit tests is a good habit.

How to make a test？

Write test file in the folder tests　by referenced the file DemoTest.php, then run:

```
 vendor/bin/phpunit
```

The assertion example:

```
/**
 *　test assertion example
 */
public function testDemo()
{
    $this->assertEquals(
        'Hello Easy PHP',
        // assert the result by run hello function in demo/Index controller
        App::$app->get('demo/index/hello')
    );
}
```

[phpunit assertions manual](https://phpunit.de/manual/current/en/appendixes.assertions.html)

##  Git Hooks

- The standard of coding:  verify the coding forcefully before commit by used php_codesniffer
- The standard of commit-msg: verify the commit-msg forcefully before commit by used the script commit-msg wrote by [Treri](https://github.com/Treri), which can enhance the git log readability and debugging, log analysis usefully, etc.

# How to use ?

composer install

```
Web Server Mode:

step 1: cd public
step 2: php -S localhost:666
step 3: open the website 'http://localhost:666'

For example, http://localhost:666/Demo/Index/hello

--------------------------------------------

Cli Mode:

php cli --method=<module.controller.action> --<arguments>=<value> ...

For example, php cli --method=demo.index.get --username=easy-php

--------------------------------------------

Get Help:

Use php cli OR php cli --help

--------------------------------------------

Frontend compile:

step 1: npm install
step 2: DOMAIN=http://localhost:666 npm run test

open the website http://localhost:666/index.html, the demo as follows
```

<p align="center"><img width="30%" src="demo.gif"><p>

# Question&Contribution

If you find some question，please launch a [issue](https://github.com/TIGERB/easy-php/issues) or PR。

How to Contribute？

```
cp ./.git-hooks/* ./git/hooks
```
After that, launch a PR as usual.

# TODO
