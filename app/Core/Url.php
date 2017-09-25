<?php
/**
 * Created by PhpStorm.
 * User: Prashanth
 * Date: 26-03-2017
 * Time: 11:45
 */

namespace App\Core;

use App\Core\Session;

/*
 * url Class
 *
 * @author David Carr - dave@simplemvcframework.com
 * @version 2.2
 * @date June 27, 2014
 * @date updated May 18 2015
 */
class Url
{

    /**
     * Redirect to chosen url
     * @param  string  $url      the url to redirect to
     * @param  boolean $fullPath if true use only url in redirect instead of using DIR
     */
    public static function redirect($url = null, $fullPath = false)
    {
        if ($fullPath == false) {
            $url = DIR . $url;
        }

        header('Location: '.$url);
        exit;
    }

    /**
     *
     * created the absolute address to the template folder
     * @param bool $custom
     * @return string url to template folder
     */
    public static function templatePath($custom = false)
    {
        if ($custom == true) {
            return DIR.'app/templates/'.$custom.'/';
        } else {
            return DIR.'app/templates/'.TEMPLATE.'/';
        }
    }

    /**
     * created the relative address to the template folder
     * @param bool $admin
     * @return string url to template folder
     */
    public static function relativeTemplatePath($admin = false)
    {
        if ($admin == false) {
            return "app/templates/".DEFAULT_TEMPLATE."/";
        } else {
            return "app/templates/".ADMIN_TEMPLATE."/";
        }
    }

    /**
     * converts plain text urls into HTML links, second argument will be
     * used as the url label <a href=''>$custom</a>
     *
     * @param  string $text   data containing the text to read
     * @param  string $custom if provided, this is used for the link label
     * @return string         returns the data with links created around urls
     */
    public static function autoLink($text, $custom = null)
    {
        $regex   = '@(http)?(s)?(://)?(([-\w]+\.)+([^\s]+)+[^,.\s])@';

        if ($custom === null) {
            $replace = '<a href="http$2://$4">$1$2$3$4</a>';
        } else {
            $replace = '<a href="http$2://$4">'.$custom.'</a>';
        }

        return preg_replace($regex, $replace, $text);
    }

    /**
     * This function converts and url segment to an safe one, for example:
     * `test name @132` will be converted to `test-name--123`
     * Basicly it works by replacing every character that isn't an letter or an number to an dash sign
     * It will also return all letters in lowercase
     *
     * @param $slug - The url slug to convert
     *
     * @return mixed|string
     */
    public static function generateSafeSlug($slug)
    {
        // transform url
        $slug = preg_replace('/[^a-zA-Z0-9]/', '-', $slug);
        $slug = strtolower(trim($slug, '-'));

        //Removing more than one dashes
        $slug = preg_replace('/\-{2,}/', '-', $slug);

        return $slug;
    }

    /**
     * Go to the previous url.
     */
    public static function previous()
    {
        header('Location: '. $_SERVER['HTTP_REFERER']);
        exit;
    }

    /**
     * get all url parts based on a / separator
     * @return array of segments
     */
    public static function segments()
    {
        return explode('/', $_SERVER['REQUEST_URI']);
    }

    /**
     *
     * get last item in array
     * @param $segments
     * @return mixed
     */
    public static function lastSegment($segments)
    {
        return end($segments);
    }

    /**
     *get first item in array
     * @param $segments
     * @return mixed
     */
    public static function firstSegment($segments)
    {
        return $segments[0];
    }

    /**
     * Generates a href link
     *
     * @param string $link
     * @param null $text
     * @param null $class
     * @return string
     */
    public static function link($link = 'javascript:;', $text = null, $class = null)
    {
        if(!empty($link)){
            return '<a href="'.DIR.$link.'" class="'.$class.'">'.$text.'</a>';
        }else{
            return '<a href="'.DIR.$link.'" class="'.$class.'">'.$link.'</a>';
        }
    }

    /**
     * Generates a link accordingly
     *
     * @param null $segment
     * @return string
     */
    public static function basePath($segment = null){
        $definedPath = DIR;
        $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $url = $protocol.':'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.$_SERVER['SERVER_NAME'].DIRECTORY_SEPARATOR.BASE_FOLDER;
        $basePath = !(empty($definedPath)) ? $definedPath : $url;
        return $basePath . $segment;
    }

    public static function profilePic($username){
        $targetPath = 'app/templates/default/uploads/profile';
        $nameMD5 = md5($username);
        $picPath = $targetPath.DS.$nameMD5;
        if(file_exists($picPath.'.jpg')){
            $path = Url::basePath($picPath.'.jpg');
        }else{
            $path = Url::basePath('app/templates/default/images/default_profile.jpg');
        }
        return $path;
    }

}
