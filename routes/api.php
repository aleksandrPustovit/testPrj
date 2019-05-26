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




Route::get("/documents/", "API\DocumentController@index");
Route::get("/documents/{id}", "API\DocumentController@show");
Route::post("/documents/", "API\DocumentController@store");
Route::middleware('auth:api')->put('/documents/{id}', "API\DocumentController@update");
Route::middleware('auth:api')->delete('/documents/{id}', "API\DocumentController@destroy");

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found.'], 404);
});