<?php
/**
 * Created by PhpStorm.
 * User: Prashanth
 * Date: 22-03-2017
 * Time: 15:19
 */

namespace App\Core;

use App\Core\Session;

class Api{

    /**
     * @var
     */
    private $url;

    /**
     *
     * Below method will get the url according to the api
     * Request.
     *
     * @param $api
     * @param array $params
     * @return mixed|string
     */
    public function getUrl($api, $params = []){
        $data = file_get_contents ('app/ApiUrl.json');
        $jData = json_decode($data, true);
        if($jData[$api]){
            $dotUrl = str_replace(':', '', $jData[$api]);
            foreach($params as $key => $value){
                $dotUrl = str_replace('{'.$key.'}', !empty($value) ? $value : '', $dotUrl);
            }
            $withOutDotUrl = str_replace('.', DS, $dotUrl);
            if(strpos($withOutDotUrl, '{mallservice}') !== false){
                $url = str_replace('{mallservice}', MALL_SERVICE_API_URL, $withOutDotUrl);
            }else{
                $url = BASE_API_URL.$withOutDotUrl;
            }
        }else{
            $url = '';
        }
        return $url;
    }

    /**
     * Below method will get the a custom url and set it
     * to an api request.
     *
     * @param $url
     * @return bool
     */
    public function setUrl($url){
        if(!empty($url)){
            $this->url = $url;
            return true;
        }else{
            return false;
        }
    }

}