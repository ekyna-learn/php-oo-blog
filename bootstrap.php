<?php

define('PROJECT_ROOT', __DIR__);

function class_loader($class) {
    require __DIR__ . '/src/' . $class . '.php';
}

spl_autoload_register('class_loader');

$dsn  = 'mysql:dbname=blog;host=localhost;port=12221';
$user = 'blog';
$pwd  = 'blog';

$connection = new \PDO($dsn, $user, $pwd);
