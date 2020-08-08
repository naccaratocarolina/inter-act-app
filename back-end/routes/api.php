<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//User Controller
Route::get('indexUser', 'UserController@indexUser');
Route::get('showUser/{id}', 'UserController@showUser');
Route::post('createUser', 'UserController@createUser');
Route::put('updateUser/{id}', 'UserController@updateUser');
Route::delete('destroyUser/{id}', 'UserController@destroyUser');

//Role Controller
Route::get('indexRole', 'RoleController@indexRole');
Route::get('showRole/{id}', 'RoleController@showRole');
Route::post('createRole', 'RoleController@createRole');
Route::put('updateRole/{id}', 'RoleController@updateRole');
Route::delete('destroyRole/{id}', 'RoleController@destroyRole');
