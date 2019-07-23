<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=БАЗА',
    'username' => 'ЛОГИН',
    'password' => 'ПАРОЛЬ',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600 * 24,
    'schemaCache' => 'cache',
];
