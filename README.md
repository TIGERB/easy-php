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

Why do we need to build a PHP framework by ourself? Maybe the most of people will say "There have so many PHP frameworks be provided, but we still made a wheel?". My point is "Made a wheel is not our purpose, we will get some knowledge when making a wheel which is our really purpose".

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

In addition, unit test, nosql support, api documents and some auxiliary script, etc.The Easy PHP framework directory as follows:

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
├── config                      [config directory]
│    └── demo                   [module config directory]
│        ├── common.php         [common config file]
│        └── database.php       [database config file]
docs                            [api document directory]
├── apib                        [Api Blueprint]
│    └── demo.apib              [api doc example file]
├── swagger                     [swagger]
framework                       [easy-php framework directory]
├── config                      [config directory]
│      ├── common.php           [default common config file]
│      └── database.php         [default database config file]
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
│    ├── Memcahed.php           [Memcahed class file]
│    ├── MongoDB.php            [MongoDB class file]
│    └── Redis.php              [Redis class file]
├── App.php                     [this application class file]
├── Container.php               [Container class file]
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

##  Route Handle Module

Execute the target controller's function by the router parse the url information.

##  MVC To MCL

The tradition MVC pattern includes the model,view,controller layer. In general, you always write the business logic in the controller or model layer. But you will feel the code is diffdcult to read, maintain, expand after a long time. So I add a logic layer in the framework forcefully where you can implement the business logic by yourself. You can not only implement a tool class but also implement your business logic in a new subfolder, what's more, you can implement a gateway based on the pattern of responsibility (I will provide a example).

In the end, the structure as follows:

- M: models, the map of database's table where define the curd operation.
- C: controllers, where expose the business resourse
- L: logics,　where implement the business logic flexiblly

**Logics layer**

A gateway example：

I build a gateway in the logics folder, the gateway entrance class code as follows:

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

##  Service Container

What's the service container?

Service container is default to understand, I think it just a third party class, which can inject the class and instance. we can get the instance in the container very simple.

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
