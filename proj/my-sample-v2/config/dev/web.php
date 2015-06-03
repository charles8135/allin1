<?php

$config = [
    'id' => 'liuyue-sample',    
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
            'targets' => [
                [
                    'class' => 'app\components\yii\MyFileTarget',
                    'levels' => ['trace', 'profile', 'info'],
                    'logFile'=> DIR_RUNTIME . '/logs/app.log',
                    //NOTICE Yii 默认会打印['_GET', '_POST', '_FILES', '_COOKIE', '_SESSION',
                    //       '_SERVER']，将logVars配置为空数组，则不进行打印
                    'logVars' => [],
                ],
                [
                    'class' => 'app\components\yii\MyFileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile'=> DIR_RUNTIME . '/logs/app.log.wf',
                    'logVars' => [],
                ],

            ],
        ],

        'view' => [
            'renderers' => [
                'tpl' => [
                    'class' => 'app\components\smarty\ViewRenderer',
                ],
            ],
        ],

        'smarty' => [
            'class' => 'app\components\smarty\SmartyAdapter',
        ],

        'bb' => [
            'class' => 'app\components\env\BlackBoard'
        ],

    ],

    'modules' => [
        'basic' => [
            'class' => 'app\modules\basic\Module',
            'params' => [ ],
        ],
        'monitor' => [
            'class' => 'app\modules\monitor\Module',
        ],
    ],

    //NEXT 感觉模块中的一些配置放在这里也不太合适，后续看看哪里更合适
    'params' => [
        'modules' => [
            'basic' => [
                'smarty' => [
                    'template_dir' => DIR_MODULES . '/basic/views', 
                    'compile_dir' => DIR_RUNTIME . '/templates_c/basic', 
                ],
            ],
        ],
        'filters' => [
            'app\components\filters\ActionTimerFilter',
        ],
    ],

    'on beforeRequest' => function($event) {
        \Yii::$app->bb->initReqInfo();
    },


];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;

