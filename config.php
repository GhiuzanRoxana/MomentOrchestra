<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'moment_orchestra');
define('DB_USER', 'postgres');
define('DB_PASS', '1q2w3e');

define('BASE_PATH', __DIR__);
define('PUBLIC_PATH', BASE_PATH . '/Public');
define('BASE_URL', 'http://localhost/Moment_Orchestra/Public/');

spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/Model/' . $class . '.php',
        BASE_PATH . '/Controller/' . $class . '.php',
        BASE_PATH . '/Interfaces/' . $class . '.php',
        BASE_PATH . '/Exceptions/' . $class . '.php',
        BASE_PATH . '/Helpers/' . $class . '.php'
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function isAdmin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function clean($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
