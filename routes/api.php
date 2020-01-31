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

Route::get('games', 'GameController@index');
Route::get('games/{id}', 'GameController@show');
Route::post('games', 'GameController@create');

Route::patch('games/{id}/reveal/{cell}', 'GameController@reveal');
Route::patch('games/{id}/flag/{cell}', 'GameController@flag');