<h1 align="center">Easy PHP</h1>

<p align="center"> 从0开始搭建一个属于你自己的PHP框架 <p>

###  框架目录一览

```
app                             [应用目录]
├── demo                        [模块目录]
│   ├── controllers             [控制器目录]
│   ├── Index.php               [默认控制器文件，输出json数据]
│   ├── logics                  [逻辑层，主要写业务逻辑的地方]
│   │   └── HttpException.php   [例如http异常类]
│   └── models                  [数据模型目录]
│       └── Index.php           [默认模式文件，定义一一对应的数据模型]
├── config                      [配置目录]
│    └── demo                   [模块配置目录]
│        ├── common.php         [通用配置]
│        └── database.php       [数据库配置]
doc                             [接口文档目录]
framework                       [Easy PHP核心框架目录]
├── config                      [默认配置文件目录]
│      ├── common.php           [默认通用配置文件]
│      └── database.php         [默认数据库配置文件]
├── exceptions                  [异常目录]
├── handles                     [框架运行时挂载处理机制类目录]
│      ├── Handle.php           [处理机制接口]
│      ├── ErrorHandle.php      [错误处理机制类]
│      ├── ExceptionHandle.php  [未捕获异常处理机制类]
│      ├── ConfigHandle.php     [配置文件处理机制类]
│      └── RouterHandle.php     [路由处理机制类]
├── orm                         [对象关系模型]
│      ├── Interpreter.php      [sql解析器]
│      ├── DB.php               [数据库操作类]
│      └── db                   [数据库类目录]
│          └── Mysql.php        [mysql操作类]
├── nosql                       [nosql类目录]
│    └── Redis.php              [redis类文件]
├── App.php                     [框架类]
├── Container.php               [服务容器]
├── Load.php                    [自加载类]
├── Request.php                 [请求类]
├── Response.php                [响应类]
├── run.php                     [框架应用启用脚本]
public                          [公共资源目录，暴露到万维网]
├── frontend                    [application frontend directory]
│    ├── src                    [frontend resource directory]
│    │   ├── components         [frontend component directory]
│    │   ├── views              [frontend view directory]
│    │   ├── images             [frontend image directory]
│    └── dist                   [frontend build destination]
├── index.php                   [入口文件]
runtime                         [临时目录]
tests                           [单元测试目录]
├── demo                        [模块名称]
│      └── DemoTest.php         [测试演示]
├── TestCase.php                [测试用例]
vendor                          [composer目录]
.git-hooks                      [git钩子目录]
├── pre-commit                  [git pre-commit预commit钩子示例文件]
└── commit-msg                  [git commit-msg示例文件]
.env                            [环境变量文件]
.gitignore                      [git忽略文件配置]
cli                             [框架cli模式运行脚本]
composer.json                   [composer配置文件]
composer.lock                   [composer lock文件]
phpunit.xml                     [phpunit配置文件]
README.md                       [readme文件]

```

###  自加载模块

###  错误和异常模块

###  配置文件模块

###  路由模块

###  输入和输出

###  传统的MVC模式提倡为MVCL模式

###  使用VUE作为视图

###  数据库关系对象模型

###  Nosql的支持

###  接口文档生成和接口模拟

###  单元测试

###  Git钩子配置
