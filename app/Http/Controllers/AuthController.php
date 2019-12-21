<?php
/**
 * Created by PhpStorm.
 * User: makryun
 * Date: 20/12/2019
 * Time: 14:40
 */

namespace App\Http\Controllers;


use App\Http\RequestHelper;
use App\Http\XmlHelper;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    // через 10 минут бездействия связка логина и токена должен исчезнуть из сессии (хранилища)
    const TOKEN_TIMEOUT = 10 * 60;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {

        try{

            $login =  $request->post('login');

            $response =  RequestHelper::sendPost(RequestHelper::URL.'/Auth',
                [ 'login' => $login,
                'password' =>  $request->post('password')
            ]);

            $responseArray = XmlHelper::parse((string)$response->getBody());

            // если авторизация на сторонней системе успешная, генерим новый токен и связываем его с логином,
            // потому что лишь по логину можно получить список счетов
            if(array_key_exists('Response', $responseArray) && $responseArray['Response'] === '1'){

                $token = Str::random(32);

                Cache::put($token, $login, self::TOKEN_TIMEOUT);

                return response()->json(['token' => $token], 200);
            }

            if(array_key_exists('ErrorMessage', $responseArray) && $responseArray['ErrorMessage'] !== ''){

                return response()->json(['error' =>  $responseArray['ErrorMessage']], 500);
            }

            return response()->json(['error' => 'unknown error'], 500);

        }
        catch (ClientException $e){

            $res = $e->getResponse();

            $responseArray =  XmlHelper::parse((string)$res->getBody());

            if(array_key_exists('ErrorCode', $responseArray) && $responseArray['ErrorCode'] === '1'){

                return response()->json(['error' => $responseArray['ErrorMessage']], 500);
            }

            return response()->json(['data' => $e->getMessage()], 500);
        }

    }
}