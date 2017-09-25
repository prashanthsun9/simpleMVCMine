<?php
/**
 * Created by PhpStorm.
 * User: Prashanth
 * Date: 26-03-2017
 * Time: 09:24
 */

$router = new AltoRouter();

$router->setBasePath(BASE_FOLDER.'/');

$router->map( 'GET', '/', 'MainController@index' );


// match current request url
$match = $router->match();

$router->dispatch($match);