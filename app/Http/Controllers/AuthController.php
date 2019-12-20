<?php
/**
 * Created by PhpStorm.
 * User: makryun
 * Date: 20/12/2019
 * Time: 14:40
 */

namespace App\Http\Controllers;


use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    const URL = 'http://backend-test.gpn-card.com';

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {



        try{

            $client = new \GuzzleHttp\Client();

            $response = $client->post(self::URL.'/Auth', [

                'form_params' => [
                    'login' => $request->post('login'),
                    'password' =>  $request->post('password')
                ]
            ]);

            $responseXml = simplexml_load_string((string)$response->getBody());

            $responseArray = json_decode(json_encode((array)$responseXml), true);


            if(array_key_exists('Response', $responseArray) && $responseArray['Response'] === '1'){

                $token = Str::random(32);

                $request->session()->put('token', $token);

                $request->session()->put('login', $request->post('login'));

                return response()->json(['token' => $token], 200);
            }

        }
        catch (ClientException $e){

            return response()->json(['data' => $e->getMessage()], 500);
        }

    }
}