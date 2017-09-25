<?php
namespace App\Core;
use App\Core\Logger;

/**
 * Created by PhpStorm.
 * User: Prashanth
 * Date: 22-03-2017
 * Time: 12:47
 */
class Controller{

    public $session;
    public $log;
    public function __construct(){
        $this->session = new Session();
    }

    public function checkIfExists($stack, $needle, $key){
        $exists = false;
        if(is_array($stack)){
            foreach($stack as $value){
                if($value->{$key} == $needle->{$key}){
                    $exists = true;
                }
            }
            return $exists;
        }else{
            return $exists;
        }
    }

    public function respondWithError($errorCode, $errorMsg){
        header($errorMsg, true, $errorCode);
        echo json_encode(array('msg' => $errorMsg));
        exit;
    }

    public function respond($msg){
        header($msg, true, 200);
        echo json_encode(array('msg' => $msg));
        exit;
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