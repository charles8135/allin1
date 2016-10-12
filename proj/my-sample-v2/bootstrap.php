<?php

/**
 * 整个Yii工程的全局bootstrap 
 */

ini_set('date.timezone','Asia/Shanghai');

//NOTICE 配置当前env类别，以及是否开启debug
define('ENV', 'dev');
defined('YII_DEBUG') or define('YII_DEBUG', true);

//NOTICE 开发工程前，必须要review是否进行修改
defined('DIR_RUNTIME') or define('DIR_RUNTIME', '/home/liuyue01/var/log-www-sample/runtime');

$cur_dir = __DIR__;
defined('DIR_ROOT') or define('DIR_ROOT', $cur_dir);
defined('DIR_MODULES') or define('DIR_MODULES', DIR_ROOT . '/' . 'modules');
defined('DIR_BIN') or define('DIR_BIN', DIR_ROOT . '/' . 'bin');
defined('DIR_CONFIG') or define('DIR_CONFIG', DIR_ROOT . '/' . 'config');
defined('DIR_DATA') or define('DIR_DATA', DIR_ROOT . '/' . 'data');
defined('DIR_FE') or define('DIR_FE', DIR_ROOT . '/' . 'fe');
defined('DIR_MISC') or define('DIR_MISC', DIR_ROOT . '/' . 'misc');
defined('DIR_VENDOR') or define('DIR_VENDOR', DIR_ROOT . '/' . 'vendor');

//NOTICE 加入一些全局小函数
function mytest($var) {
    echo "//////TEST//////\n";
    var_dump($var);
    exit;
}

//NOTICE 加载autoload 和 yii初始类
require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');
