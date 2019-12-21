<?php
/**
 * Created by PhpStorm.
 * User: makryun
 * Date: 21/12/2019
 * Time: 18:31
 */

namespace App\Http;


class XmlHelper
{

    public static function parse(string $xml){

        $responseXml = simplexml_load_string($xml);

       return json_decode(json_encode((array)$responseXml), true);
    }
}