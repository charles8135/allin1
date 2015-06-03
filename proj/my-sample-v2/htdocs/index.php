<?php

require(__DIR__ . '/../bootstrap.php');

$configPath = DIR_CONFIG . '/' . ENV . '/' . 'web.php'; 
$g_config = require($configPath);
$app = new yii\web\Application($g_config);
$app->run();
