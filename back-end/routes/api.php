
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

Auth::routes();

//User Controller
Route::get('indexUser', 'UserController@indexUser')->middleware('role:moderator,registered-user');
Route::get('showUser/{id}', 'UserController@showUser')->middleware('role:moderator,registered-user');
Route::post('createUser', 'UserController@createUser')->middleware('role:moderator,registered-user');
Route::put('updateUser/{id}', 'UserController@updateUser')->middleware('role:moderator,registered-user');
Route::delete('destroyUser/{id}', 'UserController@destroyUser')->middleware('role:moderator,registered-user');

//Role Controller
Route::get('indexRole', 'RoleController@indexRole')->middleware('can:isModerator');
Route::get('showRole/{id}', 'RoleController@showRole')->middleware('can:isModerator');
Route::post('createRole', 'RoleController@createRole')->middleware('can:isModerator');
Route::put('updateRole/{id}', 'RoleController@updateRole')->middleware('can:isModerator');
Route::delete('destroyRole/{id}', 'RoleController@destroyRole')->middleware('can:isModerator');
/*
//Article Controller
Route::get('indexArticle','ArticleController@indexArticle');
Route::get('showArticle/{id}','ArticleController@showArticle');
Route::post('createArticle','ArticleController@createArticle');
Route::put('updateArticle/{id}','ArticleController@updateArticle');
Route::delete('destroyArticle/{id}','ArticleController@destroyArticle');
*/
//Passport Controller
Route::post('register', 'API\PassportController@register')->name('register');
Route::post('login', 'API\PassportController@login')->name('login');
Route::group(['middleware' => 'auth:api'], function() {
  Route::get('logout', 'API\PassportController@logout');
  Route::post('getDetails', 'API\PassportController@getDetails');

  //Article Controller
  Route::get('indexArticle','ArticleController@indexArticle');
  Route::get('showArticle/{id}','ArticleController@showArticle');
  Route::post('createArticle','ArticleController@createArticle');
  Route::put('updateArticle/{id}','ArticleController@updateArticle');
  Route::delete('destroyArticle/{id}','ArticleController@destroyArticle');
});
