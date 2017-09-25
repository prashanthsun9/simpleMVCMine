<?php
/**
 * Created by PhpStorm.
 * User: Prashanth
 * Date: 26-03-2017
 * Time: 11:30
 */

namespace App\Controllers;


use App\Core\Controller;
use App\Core\Url;

class ErrorController extends Controller{

    public function __construct(){
        parent::__construct();
    }

    public static function fourZeroFour(){
        header('HTTP/1.1 404 page not found', true, 404);
        echo json_encode(array('msg' => 'could not find the request that you were looking'));
        exit;
    }

}