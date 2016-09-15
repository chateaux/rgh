<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

//Setup the default time zone
date_default_timezone_set('UTC');

// Setup autoloading
require 'init_autoloader.php';

//This change is for APIGILITY
if (!defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', realpath(__DIR__ . '/../'));
}

$appConfig = include APPLICATION_PATH . '/config/application.config.php';
if (file_exists(APPLICATION_PATH . '/config/development.config.php')) {
    $appConfig = Zend\Stdlib\ArrayUtils::merge($appConfig, include APPLICATION_PATH . '/config/development.config.php');
}

// Load console/http specific configurations
if (\Zend\Console\Console::isConsole()) {
    if (file_exists(APPLICATION_PATH . '/config/console.config.php')) {
        $appConfig = Zend\Stdlib\ArrayUtils::merge($appConfig, include APPLICATION_PATH . '/config/console.config.php');
    }
} else {
    if (file_exists(APPLICATION_PATH . '/config/http.config.php')) {
        $appConfig = Zend\Stdlib\ArrayUtils::merge($appConfig, include APPLICATION_PATH . '/config/http.config.php');
    }
}

// Run the application!
Zend\Mvc\Application::init($appConfig)->run();
