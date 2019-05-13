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
Route::post('/files', ['uses'=>'FileController@store']);
Route::put('/updateFile/{id}', ['uses'=>'FileController@updateFile']);
Route::get('/downloadFile/{id}', ['uses'=>'FileController@downloadFile']);
Route::get('/getAllFiles', ['uses'=>'FileController@getAllfiles']);
Route::get('/getFile/{id}', ['uses'=>'FileController@getFile']);