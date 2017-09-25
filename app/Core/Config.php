<?php
/**
 * Created by PhpStorm.
 * User: Prashanth
 * Date: 22-03-2017
 * Time: 14:50
 */

namespace App\Core;

class Config{

    public function __construct(){
        ob_start();
        define('DS', '/');
        define('BASE_FOLDER', 'proxy');
        define('TEMPLATE', 'default');
        define('ADMIN_TEMPLATE', 'default');
        define('DEFAULT_TEMPLATE', 'default');
        $port = $_SERVER['SERVER_PORT'] != 80 ? ':'.$_SERVER['SERVER_PORT'] : '';
        /* Url Configuration */
        define('DIRECTORY_PATH', dirname(dirname(__FILE__)));
        $protocol = empty($_SERVER['HTTPS']) ? 'http'.':'.DS.DS : 'https'.':'.DS.DS;
        define('BASE_API_URL', '');
        define('DIR', $protocol.$_SERVER['SERVER_NAME'].$port.DS.BASE_FOLDER.DS);
        define('TEMP_FOLDER_NAME', DIRECTORY_PATH.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR);

        define('BASE_URL', $protocol.$_SERVER['SERVER_NAME'].$port.DS);
        define('ADS_FOLDER_NAME', 'ADS');
        define('SIGNAGE_FOLDER_NAME', 'SIGNAGE');
        define('DEALS_FOLDER_NAME', 'DEALS');
        define('CMS_ZONE_LOGO_FOLDER_NAME', 'CMS/LOGOS');
        define('CMS_CAT_LOGO_FOLDER_NAME', 'CMS/CATS');
        define('CMS_SHOP_CARD_FOLDER_NAME', 'CMS/CARDS');
        define('CMS_SHOP_LOGO_FOLDER_NAME', 'CMS/LOGOS');
        define('CMS_MEDIA_FOLDER_NAME', 'CMS/ANNONCES');

        /* Application Core Constants APP_SECRET_KEY */
        define('APP_SECRET_KEY', 'thiswillbeauniquekeyusedbysession');

        /* start sessions */
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

    }

}