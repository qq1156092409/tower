<?php

return [
    "base"=>[
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=base',
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8',
    ],
    "tower"=>[
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=tower',
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8',
    ],
];
