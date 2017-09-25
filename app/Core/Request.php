<?php
namespace App\Core;
use App\Core\Logger;
use Curl\Curl;

/**
 * Created by PhpStorm.
 * User: Prashanth
 * Date: 22-03-2017
 * Time: 12:47
 */
class Request{

    protected $curl;
    protected $api;
    protected $session;
    public function __construct(){
        $this->curl = new Curl();
        $this->api = new Api();
        $this->session = new Session();
    }

    /**
     * Below method is used to log things
     *
     * @param $log
     * @param $type
     */
    public function log($log, $type = 'ERROR'){
        $type = strtoupper($type);
        Logger::$type($log);
    }

}