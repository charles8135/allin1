<?php

require(__DIR__ . '/../bootstrap.php');

require(__DIR__ . '/../vendor/framework/autoload.php');
require(__DIR__ . '/../vendor/framework/yiisoft/yii2/Yii.php');

$configPath = DIR_CONFIG . '/' . ENV . '/' . 'web.php'; 

$g_config = require($configPath);

$app = new yii\web\Application($g_config);

$app->run();
