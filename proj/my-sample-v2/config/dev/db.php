<?php

return [
    'class' => '\yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;port=6600;dbname=my_test',
    'username' => 'root',
    'password' => 'shrimp',

    'slaveConfig' => [
        'username' => 'root',
        'password' => 'shrimp',
    ],

    'slaves' => [
        [
            'dsn' => 'mysql:host=127.0.0.1;port=6601;dbname=my_test',
        ],
    ],
];

