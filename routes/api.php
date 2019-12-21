<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('auth', 'AuthController@register',[]);
Route::get('bills', 'BillsController@getByToken')->middleware('checkToken');
Route::get('bills/{id}/cards', 'CardsController@getByBill')->middleware('checkToken');
Route::get('card/{id}', 'CardsController@getOneById')->middleware('checkToken');
