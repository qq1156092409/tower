<?php

return [
    "base"=>[
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=base',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ],
    "tower"=>[
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=tower',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ],
];
