<?php

$config = [
    'id' => 'liuyue-sample-console',
    'basePath' => DIR_ROOT,
    'runtimePath' => DIR_RUNTIME,

    'bootstrap' => [
        'log',
        'bb',
    ],

    'components' => [

        'db' => require_once(__DIR__ . '/db.php'),

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            //NOTICE 缓存大小
            'flushInterval' => 1,
            'targets' => [
                [
                    'class' => 'app\components\yii\MyFileTarget',
                    'levels' => ['trace', 'profile', 'info'],
                    'logFile'=> DIR_RUNTIME . '/logs/app.log',
                    //NOTICE Yii 默认会打印['_GET', '_POST', '_FILES', '_COOKIE', '_SESSION',
                    //       '_SERVER']，将logVars配置为空数组，则不进行打印
                    'logVars' => [],
                    'exportInterval' => 1,
                ],
                [
                    'class' => 'app\components\yii\MyFileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile'=> DIR_RUNTIME . '/logs/app.log.wf',
                    'logVars' => [],
                    'exportInterval' => 1,
                ],
            ],
        ],

        'bb' => [
            'class' => 'app\components\env\BlackBoard'
        ],

    ],
    'modules' => [
        'basic' => [
            'class' => 'app\modules\basic\CmdModule',
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

