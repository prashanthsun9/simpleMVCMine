<?php
/**
 * Created by PhpStorm.
 * User: Prashanth
 * Date: 22-03-2017
 * Time: 11:18
 */
ini_set('max_execution_time', 3000000);
ini_set('memory_limit', '10G');
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
} else {
    echo "<h1>Please install via composer.json</h1>";
    echo "<p>Install Composer instructions: <a href='https://getcomposer.org/doc/00-intro.md#globally'>https://getcomposer.org/doc/00-intro.md#globally</a></p>";
    echo "<p>Once composer is installed navigate to the working directory in your terminal/command promt and enter 'composer install'</p>";
    exit;
}

if (!is_readable('app/Core/Config.php')) {
    die('No Config.php found, configure and rename Config.example.php to Config.php in app/Core.');
}

session_start();
new App\Core\Config();

require 'app/routes.php';

