<?php

/**
 * 整个Yii工程的全局bootstrap 
 */

//NOTICE 配置当前env类别，以及是否开启debug
define('ENV', 'dev');
defined('YII_DEBUG') or define('YII_DEBUG', true);


$cur_dir = __DIR__;
defined('DIR_ROOT') or define('DIR_ROOT', $cur_dir);
defined('DIR_MODULES') or define('DIR_MODULES', DIR_ROOT . '/' . 'modules');
defined('DIR_BIN') or define('DIR_BIN', DIR_ROOT . '/' . 'bin');
defined('DIR_CONFIG') or define('DIR_CONFIG', DIR_ROOT . '/' . 'config');
defined('DIR_DATA') or define('DIR_DATA', DIR_ROOT . '/' . 'data');
defined('DIR_FE') or define('DIR_FE', DIR_ROOT . '/' . 'fe');
defined('DIR_MISC') or define('DIR_MISC', DIR_ROOT . '/' . 'misc');
defined('DIR_VENDOR') or define('DIR_VENDOR', DIR_ROOT . '/' . 'vendor');
defined('DIR_RUNTIME') or define('DIR_RUNTIME', DIR_ROOT . '/' . 'runtime');

