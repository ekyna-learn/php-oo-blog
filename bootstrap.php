<?php

define('PROJECT_ROOT', __DIR__);

// Auto-chargement de classes
spl_autoload_register(function ($class) {
    require __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
});

// Connection à la BDD
$dsn  = 'mysql:dbname=php-oo-blog;host=localhost;port=12221';
$user = 'php-oo-blog';
$pwd  = 'php-oo-blog';

$connection = new PDO($dsn, $user, $pwd, [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
]);

setlocale(LC_ALL, 'fr_FR', 'French');
