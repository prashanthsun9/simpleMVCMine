<?php
/**
 * Created by PhpStorm.
 * User: Prashanth
 * Date: 26-03-2017
 * Time: 11:30
 */

namespace App\Controllers;


use App\Core\Controller;
use App\Requests\MainRequest;

class MainController extends Controller{

    public $mainRequest;

    public function __construct(){
        parent::__construct();
        $this->mainRequest = new MainRequest();
    }

    public function index(){
        echo "your are here";
    }

}