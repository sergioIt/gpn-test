<?php
/**
 * Created by PhpStorm.
 * User: makryun
 * Date: 21/12/2019
 * Time: 16:53
 */

namespace App\Http;



class RequestHelper
{

    const URL = 'http://backend-test.gpn-card.com';

    /**
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function sendPost(string $url, array $params){

        $client = new \GuzzleHttp\Client();

      return  $response = $client->post($url, [

            'form_params' => $params
        ]);
    }

    public static function sendGet(string $url, array  $params){

        $client = new \GuzzleHttp\Client();

        return  $response = $client->get($url, [

            'query' => $params
        ]);
    }
}