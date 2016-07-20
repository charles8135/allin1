<?php

return [
    'class' => '\yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;port=6600;dbname=www_db',
    'username' => 'www_wr',
    'password' => 'www_wr',

    'slaveConfig' => [
        'username' => 'www_wr',
        'password' => 'www_wr',
    ],

    'slaves' => [
        [
            'dsn' => 'mysql:host=127.0.0.1;port=6600;dbname=www_db',
        ],
    ],
];

