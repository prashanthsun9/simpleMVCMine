<?php
namespace App\Core;

use App\Helpers\KLogger;
/*
 * logger class - Custom errors
 *
 * @author David Carr - dave@simplemvcframework.com
 * @version 2.2
 * @date June 27, 2014
 * @date updated May 18 2015
 */
class Logger
{

    /**
     * determines if error should be displayed
     * @var boolean
     */
    private static $printError = false;

    /**
     * clear the errorlog
     * @var boolean
     */
    private static $clear = false;

    /**
     * path to error file
     * @var boolean
     */
    private static $errorFile = 'errorlog.html';

    /**
     * in the event of an error show this message
     */
    public static function customErrorMsg()
    {
        echo "<p>An error occurred, The error has been reported.</p>";
        exit;
    }

    /**
     * saved the exception and calls customer error function
     * @param  exception $e
     */
    public static function exceptionHandler($e)
    {
        self::newMessage($e);
        self::customErrorMsg();
    }

    /**
     * saves error message from exception
     *
     * @param $number error number
     * @param $message the error
     * @param $file file originated from
     * @param $line line number
     * @return int
     */
    public static function errorHandler($number, $message, $file, $line)
    {
        $msg = "$message in $file on line $line";

        if (($number !== E_NOTICE) && ($number < 2048)) {
            self::errorMessage($msg);
            self::customErrorMsg();
        }

        return 0;
    }

    /**
     * new exception
     *
     * @param \Exception $exception
     */
    public static function newMessage(\Exception $exception)
    {

        $message = $exception->getMessage();
        $code = $exception->getCode();
        $file = $exception->getFile();
        $line = $exception->getLine();
        $trace = $exception->getTraceAsString();
        $date = date('M d, Y G:iA');

        $logMessage = "<h3>Exception information:</h3>\n
           <p><strong>Date:</strong> {$date}</p>\n
           <p><strong>Message:</strong> {$message}</p>\n
           <p><strong>Code:</strong> {$code}</p>\n
           <p><strong>File:</strong> {$file}</p>\n
           <p><strong>Line:</strong> {$line}</p>\n
           <h3>Stack trace:</h3>\n
           <pre>{$trace}</pre>\n
           <hr />\n";

        if (is_file(self::$errorFile) === false) {
            file_put_contents(self::$errorFile, '');
        }

        if (self::$clear) {
            $f = fopen(self::$errorFile, "r+");
            if ($f !== false) {
                ftruncate($f, 0);
                fclose($f);
            }

            $content = null;
        } else {
            $content = file_get_contents(self::$errorFile);
        }

        file_put_contents(self::$errorFile, $logMessage . $content);


        if (self::$printError == true) {
            echo $logMessage;
            exit;
        }
    }

    /**
     * custom error
     *
     * @param  string  $error the error
     */
    public static function errorMessage($error)
    {
        $date = date('M d, Y G:iA');
        $logMessage = "<p>Error on $date - $error</p>";

        if (is_file(self::$errorFile) === false) {
            file_put_contents(self::$errorFile, '');
        }

        if (self::$clear) {
            $f = fopen(self::$errorFile, "r+");
            if ($f !== false) {
                ftruncate($f, 0);
                fclose($f);
            }

            $content = null;
        } else {
            $content = file_get_contents(self::$errorFile);
            file_put_contents(self::$errorFile, $logMessage . $content);
        }


        if (self::$printError == true) {
            echo $logMessage;
            exit;
        }
    }

    /**
     * Logs all the errors
     * @param $log
     */
    public static function error($log){
        $error = new KLogger(LOG_FOLDER_NAME, KLogger::ERROR, array (
            'extension' => 'log',
            'prefix' => 'error_',
            'flushFrequency' => 1
        ));
        $error->error($log);
    }

    /**
     * Logs all the infos
     * @param $log
     */
    public static function info($log){
        $info = new KLogger(LOG_FOLDER_NAME, KLogger::INFO, array (
            'extension' => 'log',
            'prefix' => 'info_',
            'flushFrequency' => 1
        ));
        $info->info($log);
    }

    /**
     * Logs all the Notices
     * @param $log
     */
    public static function notice($log){
        $notice = new KLogger(LOG_FOLDER_NAME, KLogger::NOTICE, array (
            'extension' => 'log',
            'prefix' => 'notice_',
            'flushFrequency' => 1
        ));
        $notice->notice($log);
    }

    /**
     * Logs all the Critical
     * @param $log
     */
    public static function critical($log){
        $critical = new KLogger(LOG_FOLDER_NAME, KLogger::CRITICAL, array (
            'extension' => 'log',
            'prefix' => 'critical_',
            'flushFrequency' => 1
        ));
        $critical->critical($log);
    }

    /**
     * Logs all the Alert
     * @param $log
     */
    public static function alert($log){
        $alert = new KLogger(LOG_FOLDER_NAME, KLogger::ALERT, array (
            'extension' => 'log',
            'prefix' => 'alert_',
            'flushFrequency' => 1
        ));
        $alert->alert($log);
    }

    /**
     * Logs all the Debug
     * @param $log
     */
    public static function debug($log){
        $debug = new KLogger(LOG_FOLDER_NAME, KLogger::DEBUG, array (
            'extension' => 'log',
            'prefix' => 'debug_',
            'flushFrequency' => 1
        ));
        $debug->debug($log);
    }

    /**
     * Logs all the Emergency
     * @param $log
     */
    public static function emergency($log){
        $emergency = new KLogger(LOG_FOLDER_NAME, KLogger::EMERGENCY, array (
            'extension' => 'log',
            'prefix' => 'emergency_',
            'flushFrequency' => 1
        ));
        $emergency->emergency($log);
    }

    /**
     * Logs all the Warning
     * @param $log
     */
    public static function warning($log){
        $warning = new KLogger(LOG_FOLDER_NAME, KLogger::WARNING, array (
            'extension' => 'log',
            'prefix' => 'warning_',
            'flushFrequency' => 1
        ));
        $warning->warning($log);
    }

}
