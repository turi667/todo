<?php

return [
    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'dbname' => 'mytodolist',
        'username' => 'root',
        'password' => ''
    ],
    'mail' => [
        'transport' => 'smtp',
        'encrption' => 'tls',
        'port' => 587,
        'host' => 'smtp.mailtrap.io',
        'username' => '',
        'password' => '',
        'from' => 'no-reply@company.com',
        'sender_name' => 'User Confirmation'
    ],
    'recaptcha' => [
        'key' => 'yoursecretkey',
        'secret' => 'yoursecretkey',
    ]
];
