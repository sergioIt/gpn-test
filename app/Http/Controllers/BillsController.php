<?php
/**
 * Created by PhpStorm.
 * User: makryun
 * Date: 21/12/2019
 * Time: 16:08
 */

namespace App\Http\Controllers;


use App\Http\RequestHelper;
use App\Http\XmlHelper;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Class BillsController
 * @package App\Http\Controllers
 */
class BillsController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByToken(Request $request){


        try{

            $token = $request->get('token');

            $login = Cache::get($token);

            $response = RequestHelper::sendGet(RequestHelper::URL.'/Bills', ['login' => $login]);

            $responseArray = XmlHelper::parse((string)$response->getBody());

            return response()->json(['data' => $responseArray['Response']['Bill']], 200);
        }
        catch (ClientException $e){

            return response()->json(['data' => $e->getMessage()], 500);

        }


    }
}