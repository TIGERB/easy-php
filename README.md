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

In addition, unit test, nosql support, api documents and some auxiliary scripts, etc. Finnally, My framework directory as follows:

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
│      ├── LogHandle.php        [log handle class]
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
├── build                       [phar directory build by build script]
tests                           [unit test directory]
├── demo                        [module name]
│      └── DemoTest.php         [test class file]
├── TestCase.php                [phpunit test case class file]
vendor                          [composer vendor directory]
.git-hooks                      [git hooks directory]
├── pre-commit                  [git pre-commit example file]
├── commit-msg                  [git commit-msg example file]
.babelrc                        [babel　config file]
.env                            [the environment variables file]
.gitignore                      [git ignore config file]
build                           [build php code to phar file script]
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

```
// require the application run file
require('../framework/run.php');
```

[[file: public/index.php](https://github.com/TIGERB/easy-php/blob/master/public/index.php)]

##  Autoload Module

Register a autoload function in the __autoload queue by used spl_autoload_register, after that, we can use a class by namespace and keyword 'use'.

[[file: framework/Load.php](https://github.com/TIGERB/easy-php/blob/master/framework/Load.php)]

##  Error&Exception Handle Module

- Catch error:

Register a function by used set_error_handler to handle error, but it can't handle the following error, E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING and the E_STRICT produced by the file which called set_error_handler function. So, we need use register_shutdown_function and error_get_last to handle this finally error which set_error_handler can't handle. When the framework running, we can handle the error by ourself, such as, give a friendly error messge for client.

[[file: framework/hanles/ErrorHandle.php](https://github.com/TIGERB/easy-php/blob/master/framework/handles/ErrorHandle.php)]

- Catch exception:

Register a function by used set_exception_handler to handle the exception which is not be catched, which can give a friendly error messge for client.

[[file: framework/hanles/ExceptionHandle.php](https://github.com/TIGERB/easy-php/blob/master/framework/handles/ExceptionHandle.php)]

##  Config Handle Module

Loading framework-defined and user-defined config files.

[[file: framework/hanles/ConfigHandle.php](https://github.com/TIGERB/easy-php/blob/master/framework/handles/ConfigHandle.php)]

##  Request&Response Module

- Request  Object: contains all the requested information.
- Response Object: contains all the response information.

All output is json in the framework, neithor framework's core error or business logic's output, beacuse I think is friendly.

[[file: framework/Request.php](https://github.com/TIGERB/easy-php/blob/master/framework/Request.php)]

[[file: framework/Response.php](https://github.com/TIGERB/easy-php/blob/master/framework/Response.php)]

##  Route Handle Module

Execute the target controller's function by the router parse the url information.Is composed of four types of:

**tradition router**

```
domain/index.php?module=Demo&contoller=Index&action=test&username=test
```

**pathinfo router**

```
domain/demo/index/modelExample
```

**user-defined router**

```
// config/moduleName/route.php, this 'this' point to RouterHandle instance
$this->get('v1/user/info', function (Framework\App $app) {
    return 'Hello Get Router';
});
```

**micro monolith router**

What's the micro monolith router? There are a lot of teams are moving in the SOA service structure or micro service structure, I think it is difficult for a small team. So the micro monolith was born, what's this? In my opinion, this is a SOA process for a monolith application.For example:

```
app
├── UserService     [user service module]
├── ContentService  [content service module]
├── OrderService    [order service module]
├── CartService     [cart service module]
├── PayService      [pay service module]
├── GoodsService    [goods service module]
└── CustomService   [custom service module]
```

As above, we implemented a easy micro monolith structure.But how these module to communicate with each other? As follows:

```
App::$app->get('demo/index/hello', [
    'user' => 'TIGERB'
]);
```

So we can resolve this problem loose coupling. In the meantime, we can exchange our application to the SOA structure easily, beacuse we only need to change the method get implementing way in the App class, the way contain RPC, REST. etc.

[[file: framework/hanles/RouterHandle.php](https://github.com/TIGERB/easy-php/blob/master/framework/handles/RouterHandle.php)]

##  MVC To MCL

The tradition MVC pattern includes the model,view,controller layer. In general, you always write the business logic in the controller or model layer. But you will feel the code is difficult to read, maintain, expand after a long time. So I add a logic layer in the framework forcefully where you can implement the business logic by yourself. You can not only implement a tool class but also implement your business logic in a new subfolder, what's more, you can implement a gateway based on the pattern of responsibility (I provided a example).

In the end, the structure as follows:

- M: models, the map of database's table where define the curd operation.
- C: controllers, where expose the business resourse
- L: logics,　where implement the business logic flexiblly

**Logics layer**

A gateway example：

I built a gateway in the logics folder, structure as follows：

```
gateway                     [gateway directory in logics]
  ├── Check.php             [interface]
  ├── CheckAppkey.php       [check app key]
  ├── CheckArguments.php    [check require arguments]
  ├── CheckAuthority.php    [check auth]
  ├── CheckFrequent.php     [check call frequent]
  ├── CheckRouter.php       [router]
  ├── CheckSign.php         [check sign]
  └── Entrance.php          [entrance file]
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

Where is the view layer?I abandon it, beacuse I chose the SPA for frontend, detail as follows.

[[file: app/*](https://github.com/TIGERB/easy-php/tree/master/app/demo)]

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
yarn install

DOMAIN=http://yourdomain npm run dev
```

**After build**

After built success, there made dist folder and index.html in the public. This file will be ignore when this branch is not the release branch.

```
public                          [this is a resource directory to expose service resource]
├── dist                        [frontend source file after build]
│    └── ...
├── index.html                  [entrance html file]
```

[[file: frontend/*](https://github.com/TIGERB/easy-php/tree/master/frontend)]

##  ORM

What's the ORM(Object Relation Map)? In my opinion, ORM is a thought that build a relationship of object and the abstract things.The model is the database's table and the model's instance is a operation for the table."Why do you do that, use the sql directly is not good?", my answer:you can do what you like to do, everything is flexable, but it's not be suggested from a perspective of a framework's **reusable, maintainable and extensible**.

On the market for the implemention of the ORM, such as: Active Record in thinkphp and yii, Eloquent in laravel, then we call the ORM here is "ORM" simply. The "ORM" structure in the framework as follows:

```
├── orm                         
│      ├── Interpreter.php      [sql Interpreter]
│      ├── DB.php               [database operate class]
│      ├── Model.php            [base model class]
│      └── db                   
│          └── Mysql.php        [mysql class]
```

**DB example**

```
/**
 * DB operation example
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

**Model example**

```
// controller
/**
 * model example
 *
 * @return mixed
 */
public function modelExample()
{
    try {

        DB::beginTransaction();
        $testTableModel = new TestTable();

        // find one data
        $testTableModel->modelFindOneDemo();
        // find all data
        $testTableModel->modelFindAllDemo();
        // save data
        $testTableModel->modelSaveDemo();
        // delete data
        $testTableModel->modelDeleteDemo();
        // update data
        $testTableModel->modelUpdateDemo([
               'nickname' => 'easy-php'
            ]);
        // count data
        $testTableModel->modelCountDemo();

        DB::commit();
        return 'success';

    } catch (Exception $e) {
        DB::rollBack();
        return 'fail';
    }
}

//TestTable model
/**
 * Model example
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

[[file: framework/orm/*](https://github.com/TIGERB/easy-php/tree/master/framework/orm)]

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
App::$container->setSingle('request', function () {
    // closure function lazy load
    return new Request();
});
// get Request instance
App::$container->getSingle('request');
```

[[file: framework/Container](https://github.com/TIGERB/easy-php/blob/master/framework/Container.php)]

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

[[file: framework/nosql/*](https://github.com/TIGERB/easy-php/tree/master/framework/nosql)]

##  Api Docs

Usually after we write an api, the api documentation is a problem, we use the Api Blueprint protocol to write the api document and mock. At the same time, we can request the api real-timely by used Swagger　(unavailable).

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

[[file: docs/*](https://github.com/TIGERB/easy-php/tree/master/docs)]

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

[[file: tests/*](https://github.com/TIGERB/easy-php/tree/master/tests)]

##  Git Hooks

- The standard of coding:  verify the coding forcefully before commit by used php_codesniffer
- The standard of commit-msg: verify the commit-msg forcefully before commit by used the script commit-msg wrote by [Treri](https://github.com/Treri), which can enhance the git log readability and debugging, log analysis usefully, etc.

[[file: ./git-hooks/*](https://github.com/TIGERB/easy-php/tree/master/.git-hooks)]

## Script

**cli script**

Run the framework with cli mode, detail in the instruction.

**build script**

Build the application in the runtime/build folder, such as:

```
runtime/build/App.20170505085503.phar

<?php
// require the phar file in index.php file
require('runtime/build/App.20170505085503.phar');
```

[[file: ./build](https://github.com/TIGERB/easy-php/tree/master/build)]

# How to use ?

Run：

- composer install
- chmod -R 777 runtime

**Web Server Mode:**

```
step 1: yarn install
step 2: DOMAIN=http://localhost:666 npm run demo
step 3: cd public
step 4: php -S localhost:666

visit web：http://localhost:666/index.html
visit api：http://localhost:666/Demo/Index/hello

demo as follows：
```
<p align="center"><img width="30%" src="demo.gif"><p>

**Cli Mode:**

```
php cli --method=<module.controller.action> --<arguments>=<value> ...

For example, php cli --method=demo.index.get --username=easy-php
```

Get Help:

Use php cli OR php cli --help

# Question&Contribution

If you find some question，please launch a [issue](https://github.com/TIGERB/easy-php/issues) or PR。

How to Contribute？

```
cp ./.git-hooks/* ./git/hooks
```
After that, launch a PR as usual.

project address: [https://github.com/TIGERB/easy-php](https://github.com/TIGERB/easy-php)

# TODO

- The performance test and optimize
- Use the lazy load thought to optimize the framework
- Change Helper's method to the framework's function
- Provide much friendly help for user
- Module's config support module-defined mysql and nosql configuration
- Support master-salve mysql configuration
- ORM provide more apis
- Make different rank for log
- Resolve config problem when publish our project
- implement auto deploy by used phar and git webhook
- ...
