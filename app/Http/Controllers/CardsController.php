<?php
/**
 * Created by PhpStorm.
 * User: makryun
 * Date: 21/12/2019
 * Time: 17:48
 */

namespace App\Http\Controllers;


use App\Http\RequestHelper;
use App\Http\XmlHelper;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

/**
 * Class CardsController
 * @package App\Http\Controllers
 */
class CardsController extends Controller
{

    /**
     * @param string $billId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByBill(string $billId){


        try{

           $response =  RequestHelper::sendGet(getenv('EXTERNAL_API_URL').'/Cards',['id_bill' => $billId]);

            return response()->json(['data' => XmlHelper::parse((string)$response->getBody())], 200);
        }

        catch (ClientException $e){

            return response()->json(['data' => $e->getMessage()], 500);
        }
        catch (RequestException $e){

            return response()->json(['data' => $e->getMessage()], 500);
        }


    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOneById(int $id){

        try{

            $response =  RequestHelper::sendGet(getenv('EXTERNAL_API_URL').'/CardDetail',['id_card' => $id]);

            return response()->json(['data' => XmlHelper::parse((string)$response->getBody())], 200);
        }

        catch (ClientException $e){

            return response()->json(['error' => $e->getMessage()], 500);
        }
        catch (RequestException $e){

            $res = $e->getResponse();

            $responseArray =  XmlHelper::parse((string)$res->getBody());

            if(array_key_exists('ErrorCode', $responseArray) && $responseArray['ErrorCode'] === '1'){

                return response()->json(['error' => $responseArray['ErrorMessage']], 500);
            }

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}