
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

/*
|--------------------------------------------------------------------------
| Routes that do not need permissions
|--------------------------------------------------------------------------
*/
//Article Controller
Route::get('indexAllArticles','ArticleController@indexAllArticles');

//Passport Controller
Route::post('register', 'API\PassportController@register')->name('register');
Route::post('login', 'API\PassportController@login')->name('login');

//User Controller
Route::get('indexUser', 'UserController@indexUser');
Route::post('createUser', 'UserController@createUser');

/*
|--------------------------------------------------------------------------
| Routes that require a logged in user
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth:api'], function() {
  Route::get('logout', 'API\PassportController@logout');
  Route::post('getDetails', 'API\PassportController@getDetails');

  //Article Controller
  Route::get('indexUserArticles','ArticleController@indexUserArticles')->middleware('role');
  Route::post('createArticle','ArticleController@createArticle')->middleware('role');
  Route::put('updateArticle/{id}','ArticleController@updateArticle')->middleware('role');
  Route::delete('destroyArticle/{id}','ArticleController@destroyArticle')->middleware('role');
  Route::get('showArticle/{id}','ArticleController@showArticle');

  //Comment Controller
  Route::get('indexComment','CommentController@indexComment')->middleware('role');
  Route::get('showComment/{id}','CommentController@showComment')->middleware('role');
  Route::post('createComment','CommentController@createComment')->middleware('role');
  Route::put('updateComment/{id}','CommentController@updateComment')->middleware('role');
  Route::delete('destroyComment/{id}','CommentController@destroyComment')->middleware('role');

  //Role Controller
  Route::get('indexRole', 'RoleController@indexRole')->middleware('moderator');
  Route::get('showRole/{id}', 'RoleController@showRole')->middleware('moderator');
  Route::post('createRole', 'RoleController@createRole');
  Route::put('updateRole/{id}', 'RoleController@updateRole')->middleware('moderator');
  Route::delete('destroyRole/{id}', 'RoleController@destroyRole')->middleware('moderator');

  //User Controller
  Route::get('showUser/{id}', 'UserController@showUser')->middleware('role');
  Route::put('updateUser/{id}', 'UserController@updateUser');
  Route::delete('destroyUser/{id}', 'UserController@destroyUser')->middleware('role');
});
