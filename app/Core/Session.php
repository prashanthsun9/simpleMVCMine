<?php
/**
 * Created by PhpStorm.
 * User: Prashanth
 * Date: 22-03-2017
 * Time: 14:51
 */

namespace App\Core;

class Session extends \SessionHandler{

    /**
     * Default Variables used to set keys names and cookies
     * @var
     */
    protected $key, $name, $cookie;

    /**
     * Constructor initializes a session and sets key, name and cookie name
     * @param $key
     * @param string $name
     * @param array $cookie
     */
    public function __construct($key = '', $name = 'PRK_NEAR_BUY', $cookie = []){
        $this->key = (!empty($key)) ? $key : APP_SECRET_KEY;
        $this->name = $name;
        $this->cookie = $cookie;

        $this->cookie += [
            'lifetime' => time() + 3600 * 24 * 2,
            'path'     => ini_get('session.cookie_path'),
            'domain'   => ini_get('session.cookie_domain'),
            'secure'   => isset($_SERVER['HTTPS']),
            'httponly' => true
        ];

        $this->setup();
    }

    /**
     * Setting up a cookie to contain all session information
     */
    private function setup(){
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);

        session_name($this->name);

        session_set_cookie_params(
            $this->cookie['lifetime'],
            $this->cookie['path'],
            $this->cookie['domain'],
            $this->cookie['secure'],
            $this->cookie['httponly']
        );
    }

    /**
     * Starting a Sessions
     * @return bool
     */
    public function start(){
        if (session_id() === '') {
            if (session_start()) {
                return mt_rand(0, 4) === 0 ? $this->refresh() : true; // 1/5
            }
        }

        return false;
    }

    /**
     * Destroying a Session
     * @return bool
     */
    public function forget(){
        if (session_id() === '') {
            return false;
        }

        $_SESSION = [];

        setcookie(
            $this->name,
            '',
            time() + 3600 * 24 * 2,
            $this->cookie['path'],
            $this->cookie['domain'],
            $this->cookie['secure'],
            $this->cookie['httponly']
        );

        return session_destroy();
    }

    /**
     * Regenerating a Session ID
     * To Prevent Session Hijacking
     * @return bool
     */
    public function refresh(){
        return session_regenerate_id(true);
    }

    /**
     * Extends default read method from SessionHandler
     * To restrict access for the session file by using our own
     * Special Keys to encrypt
     *
     * @param string $id
     * @return string
     */
    public function read($id){
        return mcrypt_decrypt(MCRYPT_3DES, $this->key, parent::read($id), MCRYPT_MODE_ECB);
    }

    /**
     * Extends default read method from SessionHandler
     * To restrict access for the session file by using our own
     * Special Keys to encrypt
     *
     * @param string $id
     * @param string $data
     * @return bool
     */
    public function write($id, $data){
        return parent::write($id, mcrypt_encrypt(MCRYPT_3DES, $this->key, $data, MCRYPT_MODE_ECB));
    }

    /**
     * Check if Current Session has
     * no activity from past 30 seconds
     *
     * @param int $ttl
     * @return bool
     */
    public function isExpired($ttl = 30){
        $last = isset($_SESSION['_last_activity'])
            ? $_SESSION['_last_activity']
            : false;

        if ($last !== false && time() - $last > $ttl * 60) {
            return true;
        }

        $_SESSION['_last_activity'] = time();

        return false;
    }

    /**
     * Finger print the Session using
     * Current users ip address and the browser
     *
     * @return bool
     */
    public function isFingerprint(){
        $hash = md5(
            $_SERVER['HTTP_USER_AGENT'] .
            (ip2long($_SERVER['REMOTE_ADDR']) & ip2long('255.255.0.0'))
        );

        if (isset($_SESSION['_fingerprint'])) {
            return $_SESSION['_fingerprint'] === $hash;
        }

        $_SESSION['_fingerprint'] = $hash;

        return true;
    }

    /**
     * Check if Current Session is a valid session
     * calling Expired and Fingerprinting Methods
     *
     * @return bool
     */
    public function isValid(){
        return ! $this->isExpired() && $this->isFingerprint();
    }

    /**
     * Retrieves Session Values
     *
     * @param $name
     * @return null
     */
    public function get($name){
        $parsed = explode('.', $name);

        $result = $_SESSION;

        while ($parsed) {
            $next = array_shift($parsed);

            if (isset($result[$next])) {
                $result = $result[$next];
            } else {
                return null;
            }
        }

        return $result;
    }

    /**
     * Retrieves Session Values
     *
     * @param $name
     * @return null
     */
    public function doExists($name){
        $parsed = explode('.', $name);

        $result = $_SESSION;

        while ($parsed) {
            $next = array_shift($parsed);

            if (isset($result[$next])) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Sets Session Values
     * @param $name
     * @param $value
     */
    public function put($name, $value){
        $parsed = explode('.', $name);

        $session =& $_SESSION;

        while (count($parsed) > 1) {
            $next = array_shift($parsed);

            if ( ! isset($session[$next]) || ! is_array($session[$next])) {
                $session[$next] = [];
            }

            $session =& $session[$next];
        }

        $session[array_shift($parsed)] = $value;
    }

    public function all(){
        return $_SESSION;
    }

}
