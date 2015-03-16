<?php

$config = [
    'id' => 'liuyue-sample-console',
    'basePath' => DIR_ROOT,
    'runtimePath' => DIR_RUNTIME,
    'bootstrap' => ['log'],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

    ],
    'modules' => [
        'basic' => [
            'class' => 'app\modules\basic\Module',
            //NOTICE 针对命令行模式，必须要配置下边这个 controllerNamespace
            'controllerNamespace' => 'app\modules\basic\commands',
        ],
    ],

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;

