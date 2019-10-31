<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('thrust.index', 'issues');
});

Route::get('bitbucket/oauth', 'BitbucketOauthController@create')->name('bitbucket.oauth.create');
Route::post('bitbucket/oauth', 'BitbucketOauthController@store')->name('bitbucket.oauth.store');

Route::group(['middleware' => ['auth', 'bitbucketOauth']], function() {
    Route::get('me/issues/current', 'MyIssuesController@current')->name('my.issues.current');
    Route::get('me/issues/all', 'MyIssuesController@all')->name('my.issues.all');
    Route::post('issues', 'IssuesController@store')->name('issues.store');
    Route::get('issues/calendar', 'IssuesController@calendar')->name('issues.calendar');
    Route::get('issues/backlog', 'IssuesController@backlog')->name('issues.backlog');
    Route::get('issues/{issue}', 'IssuesController@show')->name('issues.show');
    Route::get('issues/{issue}/resolve', 'IssuesController@resolve')->name('issues.resolve');
    Route::get('issues/{issue}/toggleBacklog', 'IssuesController@toggleBacklog')->name('issues.toggleBacklog');


    Route::post('issues/{issue}/comments', 'CommentsController@store')->name('comments.store');
    Route::put('issues/{issue}/comments', 'CommentsController@update')->name('comments.update');

    Route::get('cycles/{cycle}/complete', 'CyclesController@complete')->name('cycles.complete');

    Route::get('tags', 'TagsController@index')->name('tags.index');

    Route::get('trello', 'TrelloController@index')->name('trello');
    Route::put('trello', 'TrelloController@update')->name('trello.update');

    Route::get('reports', 'ReportsController@index')->name('reports');
});

Route::post('webhook', 'WebhookController@handle');
Route::post('slack', 'SlackController@handle');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
