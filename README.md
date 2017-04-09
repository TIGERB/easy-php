<h1 align="center">Easy PHP</h1>

<p align="center"> A lightweight PHP framework for studying <p>

<p align="center"> <a href="./README-CN.md">中文版</a>　<p>

### How to build a PHP framework by ourself ?

Why do we need to build a PHP framework by ourself? Maybe the most of people will say "There have so many PHP frameworks be provided, but we still made a wheel?". My point is "Made a wheel is not our purpose, we will get some konwledge when making a wheel which is our really purpose".

Then, how to build a PHP framework by ourself? General process as follows:

```
Entry file ----> Register autoload function
           ----> Register error(and exception) function
           ----> Load config file
           ----> Request object
           ----> Router
           ----> (Controller <----> Model)
           ----> Response object
           ----> Json
           ----> View
```

In addition, unit test, nosql support, api documents and some auxiliary script, etc. General framework directory as follows:

###  Project Directory Structure

```
app                             [application backend directory]
├── demo                        [module directory]
│   ├── controllers             [controller directory]
│   ├── Index.php               [default controller class file]
│   ├── logics                  [logic directory]
│   │   └── HttpException.php   [logic class file]
│   └── models                  [model directory]
│       └── Index.php           [model class file]
├── config                      [config directory]
│    └── demo                   [module config directory]
│        ├── common.php         [common config file]
│        └── database.php       [database config file]
doc                             [api document directory]
framework                       [easy-php framework directory]
├── config                      [config directory]
│      ├── common.php           [default common config file]
│      └── database.php         [default database config file]
├── exceptions                  [core exception class]
├── handles                     [handle class file be used by app run]
│      ├── Handle.php           [handle interface]
│      ├── ErrorHandle.php      [error handle class]
│      ├── ExceptionHandle.php  [exception handle class]
│      ├── ConfigHandle.php     [config handle class]
│      └── RouterHandle.php     [router handle class]
├── orm                         [datebase object relation map class directory]
│      ├── Interpreter.php      [sql Interpreter class]
│      ├── DB.php               [database operation class]
│      └── db                   [db type directory]
│          └── Mysql.php        [mysql class file]
├── nosql                       [nosql directory]
│    └── Redis.php              [redis class file]
├── App.php                     [this application class file]
├── Container.php               [Container class file]
├── Load.php                    [autoload class file]
├── Request.php                 [request object class file]
├── Response.php                [response object class file]
├── run.php                     [run this application script file]
public                          [this is a resource directory to expose service resource]
├── frontend                    [application frontend directory]
│    ├── src                    [frontend resource directory]
│    │   ├── components         [frontend component directory]
│    │   ├── views              [frontend view directory]
│    │   ├── images             [frontend image directory]
│    └── dist                   [frontend build destination]
├── index.php                   [entrance php script file]
runtime                         [temporary file such as log]
tests                           [unit test directory]
├── demo                        [module name]
│      └── DemoTest.php         [test class file]
├── TestCase.php                [phpunit test case class file]
vendor                          [composer vendor directory]
.git-hooks                      [git hooks directory]
├── pre-commit                  [git pre-commit example file]
└── commit-msg                  [git commit-msg example file]
.env                            [the environment variables file]
.gitignore                      [git ignore config file]
cli                             [run this framework with the php cli mode]
composer.json                   [composer file]
composer.lock                   [composer lock file]
phpunit.xml                     [phpunit config file]
README.md                       [readme file]

```

# Framework Module Description:

###  Entrance file

Defined a entrance file that provide a uniform file for user visit, which hide the complex logic like the enterprise service bus.

###  Autoload Module

Register a autoload function in the __autoload queue by used spl_autoload_register, after that, we can use a class by namespace and keyword 'use'.

###  Error&Exception Handle Module

- Catch error:

Register a function by used set_error_handler to handle error, but it can't handle the following error, E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING and the E_STRICT produced by the file which called set_error_handler function. So, we need use register_shutdown_function and error_get_last to handle this finally error which set_error_handler can't handle. When the framework running, we can handle the error by ourself, such as, give a friendly error messge for client.

- Catch exception:

Register a function by used set_exception_handler to handle the exception which is not be catched, which can give a friendly error messge for client.

###  Config Handle Module

Loading framework-defined and user-defined config files.

###  Request&Response Module

- Request  Object: contains all the requested information.
- Response Object: contains all the response information.

###  Route Handle Module

Execute the target controller's function by the router parse the url information.

###  MVC To MCL

The tradition MVC pattern includes the model,view,controller layer. In general, you always write the business logic in the controller or model layer. But you will feel the code is diffdcult to read, maintain, expand after a long time. So I add a logic layer in the framework forcefully where you can implement the business logic by yourself. You can not only implement a tool class but also implement your business logic in a new subfolder, what's more, you can implement a gateway based on the pattern of responsibility (I will provide a example).

In the end, the structure as follows:

- M: models, the map of database's table where define the curd operation.
- C: controllers, where expose the business resourse
- L: logics,　where implement the business logic flexiblly

Where is the view layer?I abandon it, beacuse I chose the SPA for frontend, detail as follows:

###  Using Vue For View

###  ORM

###  Nosql Support

###  Api Doc

Usually after we write an api, the api documentation is a problem, we use the Api Blueprint protocol to write the api document and mock. At the same time, we can request the api real-timely by used Swagger.

###  PHPunit

Based on the phpunit, I think write unit tests is a good habit.

###  Git Hooks

- The standard of coding:  verify the coding forcefully before commit by used php_codesniffer
- The standard of commit-msg: verify the commit-msg forcefully before commit by used the script commit-msg wrote by [Treri](https://github.com/Treri), which can enhance the git log readability and debugging, log analysis usefully, etc.

# How to use ?

```
Web Server Mode:

step 1: cd public
step 2: php -S localhost:666
step 3: open the website 'http://localhost:666'

For example, http://localhost:666/?Demo/Index/hello

--------------------------------------------

Cli Mode:

php cli --method=<module.controller.action> --<arguments>=<value> ...

For example, php cli --method=demo.index.get --username=easy-php

--------------------------------------------

Get Help:

Use php cli OR php cli --help
```
