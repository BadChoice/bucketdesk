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

Route::get('issues','Api\IssuesController@index');
Route::get('issues/{repo}/{issue}','Api\IssuesController@show');
Route::put('issues/{repo}/{issue}','Api\IssuesController@update');
Route::post('issues/{repo}/{issue}/pr','Api\IssuesController@createPullRequest');
