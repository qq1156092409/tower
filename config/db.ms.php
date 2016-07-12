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
        'charset'=>"utf8",
        'masterConfig'=>[
            "username"=>"root",
            "password"=>"",
            "attributes"=>[
                PDO::ATTR_TIMEOUT=>10
            ],
        ],
        'masters'=>[
            ["dsn"=>"mysql:host=localhost;dbname=tower"]
        ],
        'slaveConfig'=>[
            "username"=>"read",
            "password"=>"read",
            "attributes"=>[
                PDO::ATTR_TIMEOUT=>10
            ],
        ],
        'slaves'=>[
            ["dsn"=>"mysql:host=120.25.240.36;dbname=tower"]
        ]
    ],
];
