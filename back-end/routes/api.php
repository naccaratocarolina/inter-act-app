
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
//Route::get('showUser/{id}', 'UserController@showUser');
Route::post('createUser', 'UserController@createUser');
//Route::put('updateUser/{id}', 'UserController@updateUser'); //n ta fucnionando
//Route::delete('destroyUser/{id}', 'UserController@destroyUser'); //n ta fucnionando

//Role Controller
Route::get('indexRole', 'RoleController@indexRole');
Route::get('showRole/{id}', 'RoleController@showRole');
Route::post('createRole', 'RoleController@createRole');
Route::put('updateRole/{id}', 'RoleController@updateRole');
Route::delete('destroyRole/{id}', 'RoleController@destroyRole');

//Passport Controller
Route::post('register', 'API\PassportController@register')->name('register');
Route::post('login', 'API\PassportController@login')->name('login');
Route::group(['middleware' => 'auth:api'], function() {
  Route::get('logout', 'API\PassportController@logout');
  Route::post('getDetails', 'API\PassportController@getDetails');

  //Article Controller
  Route::post('createArticle/{user_id}','ArticleController@createArticle')->middleware('role');
  Route::put('updateArticle/{id}','ArticleController@updateArticle')->middleware('role');
  Route::delete('destroyArticle/{id}','ArticleController@destroyArticle')->middleware('role');
  Route::get('indexAllArticle','ArticleController@indexAllArticle');
  Route::get('showArticle/{id}','ArticleController@showArticle');

  //User Controller
  Route::get('showUser/{id}', 'UserController@showUser')->middleware('role');
  Route::put('updateUser/{id}', 'UserController@updateUser')->middleware('role');
  Route::delete('destroyUser/{id}', 'UserController@destroyUser')->middleware('role');

  //Role Controller
  Route::post('createRole', 'RoleController@createRole')->middleware('moderator');
  Route::put('updateRole/{id}', 'RoleController@updateRole')->middleware('moderator');
  Route::delete('destroyRole/{id}', 'RoleController@destroyRole')->middleware('moderator');
});
