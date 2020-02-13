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

Route::group(["middleware" => 'apiToken', "namespace" => 'Api'], function(){
    Route::get('issues','IssuesController@index');
    Route::get('issues/{repo}/{issue}','IssuesController@show');
    Route::put('issues/{repo}/{issue}','IssuesController@update');
    Route::post('issues/{repo}/{issue}/pr','IssuesController@createPullRequest');
});
