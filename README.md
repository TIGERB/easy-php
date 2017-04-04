<h1 align="center">Easy PHP</h1>

<p align="center"> A lightweight PHP framework for studying<p>

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

###  Autoload Module

###  Error&Exception Handle Module

###  Config Handle Module

###  Route Handle Module

###  MVC To MVCL

###  Using Vue For View

###  ORM

###  Nosql Support

###  Api Doc

###  PHPunit

###  Git Hooks
